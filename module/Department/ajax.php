<?php
// HIPANAO SOLUTIONS - Department module data endpoints
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
       One department row, for the Edit modal.
       ----------------------------------------------------------------- */
    if ($act === 'row') {

        $id = intval($_POST['DEPARTMENTID']);
        $output = array();

        $mydb->setQuery("SELECT * FROM `tbldepartments` WHERE `DEPARTMENTID` = '".$id."' LIMIT 1");

        foreach ($mydb->loadResultList() as $r) {
            $output['DEPARTMENTID'] = $r->DEPARTMENTID;
            $output['NAME']         = $r->NAME;
            $output['DESCRIPTION']  = ($r->DESCRIPTION === null) ? '' : $r->DESCRIPTION;
        }

        sendJson($output);
    }

    /* -----------------------------------------------------------------
       DataTables list
       NOTE: tblcourses has no DEPARTMENTID column in the actual
       database, so departments and courses aren't linked - this
       query only ever touches tbldepartments.
       ----------------------------------------------------------------- */
    $base  = "FROM `tbldepartments` d ";

    $where = " WHERE 1=1 ";

    if (isset($_POST["search"]["value"]) && $_POST["search"]["value"] != '') {
        $s = $mydb->escape_value($_POST["search"]["value"]);
        $where .= " AND (d.`NAME` LIKE '%".$s."%' 
                     OR d.`DESCRIPTION` LIKE '%".$s."%') ";
    }

    $orderCols = array(
        0 => 'd.`DEPARTMENTID`',
        1 => 'd.`NAME`',
        2 => 'd.`DESCRIPTION`'
    );

    $orderBy = " ORDER BY d.`DEPARTMENTID` ASC ";
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

    $select = "SELECT d.`DEPARTMENTID`, d.`NAME`, d.`DESCRIPTION` ";

    $mydb->setQuery($select.$base.$where.$orderBy.$limit);
    $rows = $mydb->loadResultList();

    $mydb->setQuery("SELECT d.`DEPARTMENTID` ".$base.$where);
    $filtered = $mydb->num_rows();

    $mydb->setQuery("SELECT `DEPARTMENTID` FROM `tbldepartments`");
    $total = $mydb->num_rows();

    $data = array();
    $i = isset($_POST['start']) ? intval($_POST['start']) + 1 : 1;

    foreach ($rows as $r) {

        $actions = '
            <button type="button" DID="'.$r->DEPARTMENTID.'" class="btn btn-warning btn-xs editDepartment" title="Edit">
                <span class="fa fa-edit fw-fa"></span>
            </button>
            <a href="controller.php?action=delete&id='.$r->DEPARTMENTID.'" onclick="return confirm(\'Delete this department?\');">
                <button type="button" class="btn btn-danger btn-xs" title="Delete"><span class="fa fa-trash fw-fa"></span></button>
            </a>';

        $data[] = array(
            $i,
            htmlspecialchars($r->NAME),
            htmlspecialchars($r->DESCRIPTION),
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