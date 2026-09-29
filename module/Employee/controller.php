<?php
require_once("../../include/initialize.php");
global $mydb;

if (!isset($_SESSION['ACCOUNT_ID'])) {
	// redirect(WEB_ROOT."admin/index.php");
}

$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : '';

switch ($action) {
	case 'add' :
		doInsert();
		break;

	case 'edit' :
		doEdit();
		break;

	case 'delete' :
		doDelete();
		break;
}

function doInsert() {
	global $mydb;

	$FNAME       = isset($_POST['FNAME'])       ? trim($_POST['FNAME'])       : '';
	$MNAME       = isset($_POST['MNAME'])       ? trim($_POST['MNAME'])       : '';
	$LNAME       = isset($_POST['LNAME'])       ? trim($_POST['LNAME'])       : '';
	$SUFFIX      = isset($_POST['SUFFIX'])      ? trim($_POST['SUFFIX'])      : '';
	$EMAIL       = isset($_POST['EMAIL'])       ? trim($_POST['EMAIL'])       : '';
	$JOB_TITLE   = isset($_POST['JOB_TITLE'])   ? trim($_POST['JOB_TITLE'])   : '';
	$DEPARTMENT  = isset($_POST['DEPARTMENT'])  ? trim($_POST['DEPARTMENT'])  : '';
	$MANAGER_ID  = isset($_POST['MANAGER_ID'])  ? intval($_POST['MANAGER_ID']): 0;
	$HIRE_DATE   = isset($_POST['HIRE_DATE'])   ? trim($_POST['HIRE_DATE'])   : '';
	$STATUS      = isset($_POST['STATUS'])      ? trim($_POST['STATUS'])      : 'Active';

	if ($FNAME == '' || $LNAME == '') {
		message("First name and last name are required.", "error");
		redirect('index.php');
		return;
	}

	$managerSql = ($MANAGER_ID > 0) ? "'".$MANAGER_ID."'" : "NULL";
	$hireSql    = ($HIRE_DATE != '') ? "'".$mydb->escape_value($HIRE_DATE)."'" : "NULL";

	$sql = "INSERT INTO `tblemployee`
			(`FNAME`, `MNAME`, `LNAME`, `SUFFIX`, `EMAIL`, `JOB_TITLE`, `DEPARTMENT`, `MANAGER_ID`, `HIRE_DATE`, `STATUS`)
			VALUES
			('".$mydb->escape_value($FNAME)."', '".$mydb->escape_value($MNAME)."', '".$mydb->escape_value($LNAME)."',
			 '".$mydb->escape_value($SUFFIX)."', '".$mydb->escape_value($EMAIL)."', '".$mydb->escape_value($JOB_TITLE)."',
			 '".$mydb->escape_value($DEPARTMENT)."', ".$managerSql.", ".$hireSql.", '".$mydb->escape_value($STATUS)."')";

	$istrue = $mydb->InsertThis($sql);

	if ($istrue) {
		message("New employee [".$FNAME." ".$LNAME."] has been added successfully!", "success");
	} else {
		message("The employee could not be saved.", "error");
	}
	redirect('index.php');
}

function doEdit() {
	global $mydb;

	$UID = isset($_POST['UID']) ? intval($_POST['UID']) : 0;

	if ($UID <= 0) {
		message("No employee was selected to update.", "error");
		redirect('index.php');
		return;
	}

	$FNAME       = isset($_POST['FNAME1'])       ? trim($_POST['FNAME1'])       : '';
	$MNAME       = isset($_POST['MNAME1'])       ? trim($_POST['MNAME1'])       : '';
	$LNAME       = isset($_POST['LNAME1'])       ? trim($_POST['LNAME1'])       : '';
	$SUFFIX      = isset($_POST['SUFFIX1'])      ? trim($_POST['SUFFIX1'])      : '';
	$EMAIL       = isset($_POST['EMAIL1'])       ? trim($_POST['EMAIL1'])       : '';
	$JOB_TITLE   = isset($_POST['JOB_TITLE1'])   ? trim($_POST['JOB_TITLE1'])   : '';
	$DEPARTMENT  = isset($_POST['DEPARTMENT1'])  ? trim($_POST['DEPARTMENT1'])  : '';
	$MANAGER_ID  = isset($_POST['MANAGER_ID1'])  ? intval($_POST['MANAGER_ID1']): 0;
	$HIRE_DATE   = isset($_POST['HIRE_DATE1'])   ? trim($_POST['HIRE_DATE1'])   : '';
	$STATUS      = isset($_POST['STATUS1'])      ? trim($_POST['STATUS1'])      : 'Active';

	if ($FNAME == '' || $LNAME == '') {
		message("First name and last name are required.", "error");
		redirect('index.php');
		return;
	}

	/* An employee can never be their own manager. */
	if ($MANAGER_ID === $UID) {
		$MANAGER_ID = 0;
	}

	$managerSql = ($MANAGER_ID > 0) ? "'".$MANAGER_ID."'" : "NULL";
	$hireSql    = ($HIRE_DATE != '') ? "'".$mydb->escape_value($HIRE_DATE)."'" : "NULL";

	$sql = "UPDATE `tblemployee` SET
				`FNAME` = '".$mydb->escape_value($FNAME)."',
				`MNAME` = '".$mydb->escape_value($MNAME)."',
				`LNAME` = '".$mydb->escape_value($LNAME)."',
				`SUFFIX` = '".$mydb->escape_value($SUFFIX)."',
				`EMAIL` = '".$mydb->escape_value($EMAIL)."',
				`JOB_TITLE` = '".$mydb->escape_value($JOB_TITLE)."',
				`DEPARTMENT` = '".$mydb->escape_value($DEPARTMENT)."',
				`MANAGER_ID` = ".$managerSql.",
				`HIRE_DATE` = ".$hireSql.",
				`STATUS` = '".$mydb->escape_value($STATUS)."'
			WHERE `EMPLOYEE_ID` = '".$UID."'";

	$istrue = $mydb->InsertThis($sql);

	if ($istrue) {
		message("Employee details have been updated successfully!", "success");
	} else {
		message("The employee could not be updated.", "error");
	}
	redirect('index.php');
}

function doDelete() {
	global $mydb;

	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

	if ($id <= 0) {
		message("No employee was selected to delete.", "error");
		redirect('index.php');
		return;
	}

	/* Anyone who listed this employee as their manager is bumped back
	   to no manager, so the delete never leaves a dangling MANAGER_ID. */
	$mydb->InsertThis("UPDATE `tblemployee` SET `MANAGER_ID` = NULL WHERE `MANAGER_ID` = '".$id."'");

	$istrue = $mydb->InsertThis("DELETE FROM `tblemployee` WHERE `EMPLOYEE_ID` = '".$id."'");

	if ($istrue) {
		message("Employee has been deleted.", "success");
	} else {
		message("The employee could not be deleted.", "error");
	}
	redirect('index.php');
}
?>
