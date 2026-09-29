<?php
// HIPANAO SOLUTIONS - Sched Day module data endpoints
//
// TABLE: tblday
//   DAY_ID  INT PK AUTO_INCREMENT
//   DAY     VARCHAR(20)   e.g. "Monday"

require_once("../../include/initialize.php");
global $mydb;

$act = isset($_POST['act']) ? $_POST['act'] : '';

/* -----------------------------------------------------------------
   One day row, for the Edit modal.
   ----------------------------------------------------------------- */
if ($act === 'row') {

    $id = intval($_POST['DAY_ID']);
    $output = array();

    $mydb->setQuery("SELECT * FROM `tblday` WHERE DAY_ID = '".$id."' LIMIT 1");

    foreach ($mydb->loadResultList() as $r) {
        $output['DAY_ID'] = $r->DAY_ID;
        $output['DAY']    = $r->DAY;
    }

    echo json_encode($output);
    exit;
}

/* -----------------------------------------------------------------
   DataTables list
   ----------------------------------------------------------------- */
$base  = "FROM `tblday` d ";
$where = " WHERE 1=1 ";

if (isset($_POST["search"]["value"]) && $_POST["search"]["value"] != '') {
    $s = $mydb->escape_value($_POST["search"]["value"]);
    $where .= " AND d.DAY LIKE '%".$s."%' ";
}

$orderCols = array(
    0 => 'd.DAY_ID',
    1 => 'd.DAY'
);

$orderBy = " ORDER BY d.DAY_ID ASC ";
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

$select = "SELECT d.DAY_ID, d.DAY ";

$mydb->setQuery($select.$base.$where.$orderBy.$limit);
$rows = $mydb->loadResultList();

$mydb->setQuery("SELECT d.DAY_ID ".$base.$where);
$filtered = $mydb->num_rows();

$mydb->setQuery("SELECT DAY_ID FROM `tblday`");
$total = $mydb->num_rows();

$data = array();
$i = isset($_POST['start']) ? intval($_POST['start']) + 1 : 1;

foreach ($rows as $r) {

    $actions = '
        <button type="button" DID="'.$r->DAY_ID.'" class="btn btn-warning btn-xs editDay" title="Edit">
            <span class="fa fa-edit fw-fa"></span>
        </button>
        <a href="controller.php?action=delete&id='.$r->DAY_ID.'" onclick="return confirm(\'Delete this day?\');">
            <button type="button" class="btn btn-danger btn-xs" title="Delete"><span class="fa fa-trash fw-fa"></span></button>
        </a>';

    $data[] = array(
        $i,
        htmlspecialchars($r->DAY),
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