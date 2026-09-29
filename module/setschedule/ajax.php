<?php
// Set Schedule module data endpoint.
//
// ob_start() runs before anything else so any stray output - a
// warning, a notice, or a die("...") message from the DB wrapper -
// gets captured instead of printed directly.
ob_start();

$responseSent = false;

function sendJson($payload) {
    global $responseSent;
    $responseSent = true;

    // Clear EVERY buffer level currently open - our own explicit one
    // above, plus any implicit buffer PHP's own config may already
    // have started - so nothing leftover can get treated as an error
    // by the shutdown safety net below.
    while (ob_get_level() > 0) {
        ob_end_clean();
    }

    if (!headers_sent()) {
        header('Content-Type: application/json');
    }
    echo json_encode($payload);
    exit;
}

/* -----------------------------------------------------------------
   SAFETY NET: only runs if sendJson() was never reached - e.g. the
   script died early (the DB wrapper calling die("Query failed: ..."))
   or hit an uncatchable fatal error. In that case whatever text
   leaked into the output buffer gets wrapped into valid JSON instead
   of being sent to the browser as raw text.
   ----------------------------------------------------------------- */
register_shutdown_function(function () use (&$responseSent) {
    if ($responseSent) {
        return;
    }
    $leftover = '';
    while (ob_get_level() > 0) {
        $leftover .= ob_get_clean();
    }
    if (trim($leftover) !== '') {
        if (!headers_sent()) {
            header('Content-Type: application/json');
        }
        echo json_encode(array(
            'data'            => array(),
            'recordsTotal'    => 0,
            'recordsFiltered' => 0,
            'error'           => trim(strip_tags($leftover))
        ));
    }
});

require_once("../../include/initialize.php");
global $mydb;

error_reporting(0);
ini_set('display_errors', '0');

try {

    /* -----------------------------------------------------------------
       Single record fetch, used by the Edit modal.
       Triggered when the JS sends UID (the SCHEDULEID) with no other act.
       ----------------------------------------------------------------- */
    if (isset($_POST['UID'])) {

        $output = array();
        $sid = intval($_POST["UID"]);

        $mydb->setQuery("SELECT * FROM `tblsetschedule` WHERE SCHEDULEID = '".$sid."' LIMIT 1");
        $result = $mydb->loadResultList();

        foreach ($result as $row) {
            $output["UID"]                  = $row->SCHEDULEID;
            $output["ROOM"]                 = $row->ROOM;
            $output["DAY"]                  = $row->DAY;
            $output["TIME"]                 = $row->TIME;
            $output["AY"]                   = $row->AY;
            $output["SEMESTER"]             = $row->SEMESTER;
            $output["YEAR_LEVEL"]           = isset($row->YEAR_LEVEL) ? $row->YEAR_LEVEL : '';
            $output["SECTION"]              = isset($row->SECTION) ? $row->SECTION : '';
            $output["CODE"]                 = isset($row->CODE) ? $row->CODE : '';
            $output["SUBJECT_DESCRIPTION"]  = isset($row->SUBJECT_DESCRIPTION) ? $row->SUBJECT_DESCRIPTION : '';
            $output["UNITS"]                = isset($row->UNITS) ? $row->UNITS : '';
            $output["INSTRUCTORID"]         = isset($row->INSTRUCTORID) && $row->INSTRUCTORID !== null ? $row->INSTRUCTORID : '';
            $output["STATUS"]               = $row->STATUS;
        }

        sendJson($output);
    }

    /* -----------------------------------------------------------------
       DataTable server-side feed for the Set Schedule list.
       Instructor is a real FK (INSTRUCTORID), so we LEFT JOIN
       tblinstructor to display the instructor's name. LEFT JOIN (not
       INNER) so schedules with no instructor assigned still show up.
       ----------------------------------------------------------------- */
    $query = "SELECT s.`SCHEDULEID`, s.`ROOM`, s.`DAY`, s.`TIME`, s.`AY`, s.`SEMESTER`,
                     s.`YEAR_LEVEL`, s.`SECTION`, s.`CODE`, s.`SUBJECT_DESCRIPTION`, s.`UNITS`,
                     i.`INSTRUCTOR` AS INSTRUCTOR_NAME, s.`STATUS`
              FROM `tblsetschedule` s
              LEFT JOIN `tblinstructor` i ON s.`INSTRUCTORID` = i.`INSTRUCTORID`
              WHERE 1=1 ";

    if (isset($_POST["search"]["value"]) && $_POST["search"]["value"] != '') {
        $search = $mydb->escape_value($_POST["search"]["value"]);
        $query .= " AND (s.`ROOM` LIKE '%".$search."%'
                    OR s.`DAY` LIKE '%".$search."%'
                    OR s.`SECTION` LIKE '%".$search."%'
                    OR s.`CODE` LIKE '%".$search."%'
                    OR s.`SUBJECT_DESCRIPTION` LIKE '%".$search."%'
                    OR i.`INSTRUCTOR` LIKE '%".$search."%') ";
    }

    if (isset($_POST['order'][0]['column'])) {
        $col = intval($_POST['order'][0]['column']);
        $dir = (isset($_POST['order'][0]['dir']) && strtolower($_POST['order'][0]['dir']) == 'asc') ? 'ASC' : 'DESC';
        $query .= ' ORDER BY '.$col.' '.$dir.' ';
    } else {
        $query .= ' ORDER BY s.`SCHEDULEID` DESC ';
    }

    if (isset($_POST['length']) && $_POST['length'] != -1) {
        $query .= " LIMIT " . intval($_POST['start']) . ", " . intval($_POST['length']) . "";
    }

    $mydb->setQuery($query);
    $cur = $mydb->loadResultList();
    $data = array();
    $filtered_rows = $mydb->num_rows();
    $i = isset($_POST['start']) ? intval($_POST['start']) + 1 : 1;

    foreach ($cur as $result) {
        $sub_array = array();

        $sub_array[] = $i;
        $sub_array[] = $result->ROOM;
        $sub_array[] = $result->DAY;
        $sub_array[] = $result->TIME;
        $sub_array[] = $result->AY;
        $sub_array[] = $result->SEMESTER;
        $sub_array[] = htmlspecialchars($result->YEAR_LEVEL);
        $sub_array[] = htmlspecialchars($result->SECTION);
        $sub_array[] = htmlspecialchars($result->CODE);
        $sub_array[] = htmlspecialchars($result->SUBJECT_DESCRIPTION);
        $sub_array[] = $result->UNITS;
        $sub_array[] = $result->INSTRUCTOR_NAME
            ? htmlspecialchars($result->INSTRUCTOR_NAME)
            : '<span class="text-muted">Unassigned</span>';
        $sub_array[] = ($result->STATUS == 1)
            ? '<span class="badge badge-success">Enabled</span>'
            : '<span class="badge badge-secondary">Disabled</span>';

        $sub_array[] = '

        <button type="button" name="update" UID="'.$result->SCHEDULEID.'" class="btn btn-warning btn-xs editEntry" title="Edit"><span class="fa fa-edit fw-fa"></span></button>

        <a href="controller.php?action=toggle&id='.$result->SCHEDULEID.'"><button type="button" class="btn btn-'.($result->STATUS == 1 ? 'secondary' : 'success').' btn-xs" title="'.($result->STATUS == 1 ? 'Disable' : 'Enable').'"><span class="fa fa-power-off fw-fa"></span></button></a>

        <a href="controller.php?action=delete&id='.$result->SCHEDULEID.'"><button type="button" class="btn btn-danger btn-xs" title="Delete" onclick="return confirm(\'Delete this schedule?\');"><span class="fa fa-trash fw-fa"></span> Del</button></a>

        ';
        $data[] = $sub_array;
        $i = $i + 1;
    }

    $mydb->setQuery("SELECT `SCHEDULEID` FROM `tblsetschedule`");
    $total = $mydb->num_rows();

    sendJson(array(
        'data'            => $data,
        'recordsTotal'    => $total,
        'recordsFiltered' => $filtered_rows
    ));

} catch (Throwable $e) {

    sendJson(array(
        'data'            => array(),
        'recordsTotal'    => 0,
        'recordsFiltered' => 0,
        'error'           => $e->getMessage()
    ));
}
?>
