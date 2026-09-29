<?php
// HIPANAO SOLUTIONS - Instructor module data endpoints
//
// ob_start() is the very first thing that runs, before initialize.php
// is even loaded, so any stray output from an included file never
// corrupts the JSON response below.
ob_start();

require_once("../../include/initialize.php");
global $mydb;

error_reporting(0);
ini_set('display_errors', '0');

$act = isset($_POST['act']) ? $_POST['act'] : '';

function sendJson($payload) {
    if (ob_get_level() > 0) {
        ob_end_clean();
    }
    header('Content-Type: application/json');
    echo json_encode($payload);
    exit;
}

try {

    /* -----------------------------------------------------------------
       One instructor row, for the Edit modal.
       ----------------------------------------------------------------- */
    if ($act === 'row') {

        $id = intval($_POST['INSTRUCTORID']);
        $output = array();

        $mydb->setQuery("SELECT * FROM `tblinstructor` WHERE `INSTRUCTORID` = '".$id."' LIMIT 1");

        foreach ($mydb->loadResultList() as $r) {
            $output['INSTRUCTORID'] = $r->INSTRUCTORID;
            $output['INSTRUCTOR']   = $r->INSTRUCTOR;
            $output['STATUS']       = $r->STATUS;
        }

        sendJson($output);
    }

    /* -----------------------------------------------------------------
       DataTables list
       NOTE: no other table references INSTRUCTORID in the actual
       database, so this query only ever touches tblinstructor and
       there is nothing to join against.
       ----------------------------------------------------------------- */
    $base  = "FROM `tblinstructor` i ";

    $where = " WHERE 1=1 ";

    if (isset($_POST["search"]["value"]) && $_POST["search"]["value"] != '') {
        $s = $mydb->escape_value($_POST["search"]["value"]);
        $where .= " AND (i.`INSTRUCTOR` LIKE '%".$s."%') ";
    }

    $orderCols = array(
        0 => 'i.`INSTRUCTORID`',
        1 => 'i.`INSTRUCTOR`',
        2 => 'i.`STATUS`'
    );

    $orderBy = " ORDER BY i.`INSTRUCTORID` ASC ";
    if (isset($_POST['order'][0]['column'])) {
        $ci  = intval($_POST['order'][0]['column']);
        $dir = (isset($_POST['order'][0]['dir']) && strtolower($_POST['order'][0]['dir']) == 'asc') ? 'ASC' : 'DESC';
        if (isset($orderCols[$ci])) {
            $orderBy = " ORDER BY ".$orderCols[$ci]." ".$dir." ";
        }
    }

    $limit = "";
    if (isset($_POST['length']) && $_POST['length'] != -1) {
        $limit = " LIMIT ".intval($_POST['start']).", ".intval($_POST['length'])." ";
    }

    $select = "SELECT i.`INSTRUCTORID`, i.`INSTRUCTOR`, i.`STATUS` ";

    $mydb->setQuery($select.$base.$where.$orderBy.$limit);
    $rows = $mydb->loadResultList();

    $mydb->setQuery("SELECT i.`INSTRUCTORID` ".$base.$where);
    $filtered = $mydb->num_rows();

    $mydb->setQuery("SELECT `INSTRUCTORID` FROM `tblinstructor`");
    $total = $mydb->num_rows();

    $data = array();
    $i = isset($_POST['start']) ? intval($_POST['start']) + 1 : 1;

    foreach ($rows as $r) {

        $statusBadge = ($r->STATUS == 1)
            ? '<span class="badge badge-success">Active</span>'
            : '<span class="badge badge-secondary">Inactive</span>';

        $actions = '
            <button type="button" IID="'.$r->INSTRUCTORID.'" class="btn btn-warning btn-xs editInstructor" title="Edit">
                <span class="fa fa-edit fw-fa"></span>
            </button>
            <a href="controller.php?action=delete&id='.$r->INSTRUCTORID.'" onclick="return confirm(\'Delete this instructor?\');">
                <button type="button" class="btn btn-danger btn-xs" title="Delete"><span class="fa fa-trash fw-fa"></span></button>
            </a>';

        $data[] = array(
            $i,
            htmlspecialchars($r->INSTRUCTOR),
            $statusBadge,
            $actions
        );
        $i++;
    }

    sendJson(array(
        'data'            => $data,
        'recordsTotal'    => $total,
        'recordsFiltered' => $filtered
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
