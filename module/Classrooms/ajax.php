<?php
// HIPANAO SOLUTIONS - Classrooms module data endpoints
//
// TABLE: tblclassrooms
//   CLASSROOMID  INT PK AUTO_INCREMENT
//   NAME         VARCHAR(100)   e.g. "Room 101"
//   DESCRIPTION  VARCHAR(255)   e.g. "Ground floor, near the library"

require_once("../../include/initialize.php");
global $mydb;

$act = isset($_POST['act']) ? $_POST['act'] : '';

/* -----------------------------------------------------------------
   One classroom row, for the Edit modal.
   ----------------------------------------------------------------- */
if ($act === 'row') {

    $id = intval($_POST['CLASSROOMID']);
    $output = array();

    $mydb->setQuery("SELECT * FROM `tblclassrooms` WHERE CLASSROOMID = '".$id."' LIMIT 1");

    foreach ($mydb->loadResultList() as $r) {
        $output['CLASSROOMID'] = $r->CLASSROOMID;
        $output['NAME']        = $r->NAME;
        $output['DESCRIPTION'] = ($r->DESCRIPTION === null) ? '' : $r->DESCRIPTION;
    }

    echo json_encode($output);
    exit;
}

/* -----------------------------------------------------------------
   DataTables list
   ----------------------------------------------------------------- */
$base  = "FROM `tblclassrooms` c ";
$where = " WHERE 1=1 ";

if (isset($_POST["search"]["value"]) && $_POST["search"]["value"] != '') {
    $s = $mydb->escape_value($_POST["search"]["value"]);
    $where .= " AND (c.NAME LIKE '%".$s."%' OR c.DESCRIPTION LIKE '%".$s."%') ";
}

$orderCols = array(
    0 => 'c.CLASSROOMID',
    1 => 'c.NAME',
    2 => 'c.DESCRIPTION'
);

$orderBy = " ORDER BY c.CLASSROOMID ASC ";
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

$select = "SELECT c.CLASSROOMID, c.NAME, c.DESCRIPTION ";

$mydb->setQuery($select.$base.$where.$orderBy.$limit);
$rows = $mydb->loadResultList();

$mydb->setQuery("SELECT c.CLASSROOMID ".$base.$where);
$filtered = $mydb->num_rows();

$mydb->setQuery("SELECT CLASSROOMID FROM `tblclassrooms`");
$total = $mydb->num_rows();

$data = array();
$i = isset($_POST['start']) ? intval($_POST['start']) + 1 : 1;

foreach ($rows as $r) {

    $actions = '
        <button type="button" CID="'.$r->CLASSROOMID.'" class="btn btn-warning btn-xs editClassroom" title="Edit">
            <span class="fa fa-edit fw-fa"></span>
        </button>
        <a href="controller.php?action=delete&id='.$r->CLASSROOMID.'" onclick="return confirm(\'Delete this classroom?\');">
            <button type="button" class="btn btn-danger btn-xs" title="Delete"><span class="fa fa-trash fw-fa"></span></button>
        </a>';

    $data[] = array(
        $i,
        htmlspecialchars($r->NAME),
        htmlspecialchars($r->DESCRIPTION == null ? '' : $r->DESCRIPTION),
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