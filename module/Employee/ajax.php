<?php
require_once("../../include/initialize.php");
global $mydb;

$act = isset($_POST['act']) ? $_POST['act'] : '';

/* -----------------------------------------------------------------
   Manager dropdown options, used by both the Add and Edit modals.
   ----------------------------------------------------------------- */
if ($act === 'get_managers') {

	$output = array();
	$mydb->setQuery("SELECT EMPLOYEE_ID, FNAME, LNAME FROM `tblemployee` WHERE STATUS = 'Active' ORDER BY LNAME ASC");
	foreach ($mydb->loadResultList() as $row) {
		$output[] = array(
			'EMPLOYEE_ID' => $row->EMPLOYEE_ID,
			'FNAME'       => $row->FNAME,
			'LNAME'       => $row->LNAME,
		);
	}
	echo json_encode($output);
	exit;
}

/* -----------------------------------------------------------------
   Single employee record, for the Edit modal.
   ----------------------------------------------------------------- */
if (isset($_POST['UID'])) {

	$uid = intval($_POST['UID']);
	$output = array();

	$mydb->setQuery("SELECT * FROM `tblemployee` WHERE EMPLOYEE_ID = '".$uid."' LIMIT 1");
	foreach ($mydb->loadResultList() as $row) {
		$output['EMPLOYEE_ID'] = $row->EMPLOYEE_ID;
		$output['FNAME']       = $row->FNAME;
		$output['MNAME']       = $row->MNAME;
		$output['LNAME']       = $row->LNAME;
		$output['SUFFIX']      = $row->SUFFIX;
		$output['EMAIL']       = $row->EMAIL;
		$output['JOB_TITLE']   = $row->JOB_TITLE;
		$output['DEPARTMENT']  = $row->DEPARTMENT;
		$output['MANAGER_ID']  = $row->MANAGER_ID;
		$output['HIRE_DATE']   = $row->HIRE_DATE ? substr($row->HIRE_DATE, 0, 10) : '';
		$output['STATUS']      = $row->STATUS;
	}
	echo json_encode($output);
	exit;
}

/* -----------------------------------------------------------------
   Default: server-side DataTable listing.
   Self-joins tblemployee to itself to resolve MANAGER_ID into the
   "LNAME, FNAME" text shown in the Manager column.
   ----------------------------------------------------------------- */
$columns = array('e.EMPLOYEE_ID', 'e.FNAME', 'e.MNAME', 'e.LNAME', 'e.SUFFIX', 'e.EMAIL',
				  'e.JOB_TITLE', 'e.DEPARTMENT', 'm.LNAME', 'e.HIRE_DATE', 'e.STATUS');

$baseQuery = "FROM `tblemployee` e
			  LEFT JOIN `tblemployee` m ON m.EMPLOYEE_ID = e.MANAGER_ID";

$where = array();

if (isset($_POST['search']['value']) && trim($_POST['search']['value']) != '') {
	$term = $mydb->escape_value(trim($_POST['search']['value']));
	$where[] = "(e.FNAME LIKE '%".$term."%'
				 OR e.LNAME LIKE '%".$term."%'
				 OR e.EMAIL LIKE '%".$term."%'
				 OR e.JOB_TITLE LIKE '%".$term."%'
				 OR e.DEPARTMENT LIKE '%".$term."%')";
}

$statusFilter = isset($_POST['status_filter']) ? trim($_POST['status_filter']) : 'All';
if ($statusFilter === 'Active' || $statusFilter === 'Inactive') {
	$where[] = "e.STATUS = '".$mydb->escape_value($statusFilter)."'";
}

$whereSql = '';
if (!empty($where)) {
	$whereSql = " WHERE ".implode(' AND ', $where);
}

$query = "SELECT e.EMPLOYEE_ID, e.FNAME, e.MNAME, e.LNAME, e.SUFFIX, e.EMAIL,
				  e.JOB_TITLE, e.DEPARTMENT, e.MANAGER_ID, m.FNAME AS M_FNAME, m.LNAME AS M_LNAME,
				  e.HIRE_DATE, e.STATUS
		   ".$baseQuery.$whereSql;

if (isset($_POST['order']) && isset($columns[$_POST['order']['0']['column']])) {
	$orderCol = $columns[$_POST['order']['0']['column']];
	$orderDir = ($_POST['order']['0']['dir'] == 'desc') ? 'DESC' : 'ASC';
	$query .= " ORDER BY ".$orderCol." ".$orderDir." ";
} else {
	$query .= " ORDER BY e.EMPLOYEE_ID DESC ";
}

if (isset($_POST['length']) && $_POST['length'] != -1) {
	$query .= " LIMIT ".intval($_POST['start']).", ".intval($_POST['length'])."";
}

$mydb->setQuery($query);
$cur = $mydb->loadResultList();
$filtered_rows = $mydb->num_rows();

$data = array();
foreach ($cur as $row) {

	$managerName = ($row->M_LNAME) ? $row->M_LNAME.', '.$row->M_FNAME : '-';
	$statusBadge = ($row->STATUS === 'Active')
		? '<span class="badge badge-success">Active</span>'
		: '<span class="badge badge-secondary">Inactive</span>';

	$sub_array = array();
	$sub_array[] = $row->EMPLOYEE_ID;
	$sub_array[] = $row->FNAME;
	$sub_array[] = $row->MNAME;
	$sub_array[] = $row->LNAME;
	$sub_array[] = $row->SUFFIX ? $row->SUFFIX : '-';
	$sub_array[] = $row->EMAIL;
	$sub_array[] = $row->JOB_TITLE;
	$sub_array[] = $row->DEPARTMENT;
	$sub_array[] = $managerName;
	$sub_array[] = $row->HIRE_DATE;
	$sub_array[] = $statusBadge;

	$sub_array[] = '
		<a href="index.php?view=view&id='.$row->EMPLOYEE_ID.'"><button type="button" class="btn btn-info btn-xs" title="View"><span class="fa fa-eye"></span></button></a>
		<button type="button" name="update" UID="'.$row->EMPLOYEE_ID.'" class="btn btn-warning btn-xs editEntry" title="Edit"><span class="fa fa-edit fw-fa"></span></button>
		<a href="controller.php?action=delete&id='.$row->EMPLOYEE_ID.'" onclick="return confirm(\'Delete this employee?\');"><button type="button" class="btn btn-danger btn-xs" title="Delete"><span class="fa fa-trash fw-fa"></span></button></a>
	';

	$data[] = $sub_array;
}

function get_total_all_employees() {
	global $mydb;
	$mydb->setQuery("SELECT EMPLOYEE_ID FROM `tblemployee`");
	return $mydb->num_rows();
}

$output = array(
	'data'            => $data,
	'recordsTotal'    => get_total_all_employees(),
	'recordsFiltered' => $filtered_rows,
);
echo json_encode($output);
?>
