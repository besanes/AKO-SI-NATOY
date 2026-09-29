<?php
// HIPANAO SOLUTIONS - Sched Time module data endpoints
//
// TABLE: tbltime
//   TIME_ID  INT PK AUTO_INCREMENT
//   TIME     VARCHAR(50)   e.g. "7:00 AM - 8:00 AM"

require_once("../../include/initialize.php");
global $mydb;

$act = isset($_POST['act']) ? $_POST['act'] : '';

/* -----------------------------------------------------------------
   One time row, for the Edit modal.
   ----------------------------------------------------------------- */
if ($act === 'row') {

    $id = intval($_POST['TIME_ID']);
    $output = array();

    $mydb->setQuery("SELECT * FROM `tbltime` WHERE TIME_ID = '".$id."' LIMIT 1");

    foreach ($mydb->loadResultList() as $r) {
        $output['TIME_ID'] = $r->TIME_ID;
        $output['TIME']    = $r->TIME;
    }

    echo json_encode($output);
    exit;
}

/* -----------------------------------------------------------------
   DataTables list
   ----------------------------------------------------------------- */
$base  = "FROM `tbltime` t ";
$where = " WHERE 1=1 ";

if (isset($_POST["search"]["value"]) && $_POST["search"]["value"] != '') {
    $s = $mydb->escape_value($_POST["search"]["value"]);
    $where .= " AND t.TIME LIKE '%".$s."%' ";
}

$orderCols = array(
    0 => 't.TIME_ID',
    1 => 't.TIME'
);

$orderBy = " ORDER BY t.TIME_ID ASC ";
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

$select = "SELECT t.TIME_ID, t.TIME ";

$mydb->setQuery($select.$base.$where.$orderBy.$limit);
$rows = $mydb->loadResultList();

$mydb->setQuery("SELECT t.TIME_ID ".$base.$where);
$filtered = $mydb->num_rows();

$mydb->setQuery("SELECT TIME_ID FROM `tbltime`");
$total = $mydb->num_rows();

$data = array();
$i = isset($_POST['start']) ? intval($_POST['start']) + 1 : 1;

foreach ($rows as $r) {

    $actions = '
        <button type="button" TID="'.$r->TIME_ID.'" class="btn btn-warning btn-xs editTime" title="Edit">
            <span class="fa fa-edit fw-fa"></span>
        </button>
        <a href="controller.php?action=delete&id='.$r->TIME_ID.'" onclick="return confirm(\'Delete this time?\');">
            <button type="button" class="btn btn-danger btn-xs" title="Delete"><span class="fa fa-trash fw-fa"></span></button>
        </a>';

    $data[] = array(
        $i,
        htmlspecialchars($r->TIME),
        $actions
    );
    $i++;
}

echo json_encode(array(
    'data'            => $data,
    'recordsTotal'    => $total,
    'recordsFiltered' => $filtered
));
?>