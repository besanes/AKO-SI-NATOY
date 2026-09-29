<?php
//  Department controller
require_once("../../include/initialize.php");
global $mydb;

$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : '';

switch ($action) {
	case 'add' :
		doAdd();
		break;

	case 'edit' :
		doEdit();
		break;

	case 'delete' :
		doDelete();
		break;
}


/* ---------------------------------------------------------------------
   Checks whether another department already uses this name (case
   insensitive), optionally excluding a specific DEPARTMENTID so an
   edit can keep its own name.
   --------------------------------------------------------------------- */
function nameAlreadyUsed($name, $excludeId = 0) {
	global $mydb;

	$sql = "SELECT DEPARTMENTID FROM `tbldepartments` WHERE LOWER(NAME) = LOWER('".$mydb->escape_value($name)."')";
	if ($excludeId > 0) {
		$sql .= " AND DEPARTMENTID <> '".$excludeId."'";
	}
	$mydb->setQuery($sql);
	return ($mydb->num_rows() >= 1);
}


/* ---------------------------------------------------------------------
   ADD a new department
   --------------------------------------------------------------------- */
function doAdd() {

	global $mydb;

	$NAME        = isset($_POST['D_NAME'])        ? trim($_POST['D_NAME'])        : '';
	$DESCRIPTION = isset($_POST['D_DESCRIPTION'])  ? trim($_POST['D_DESCRIPTION']) : '';

	if ($NAME == '') {
		message("Please enter the department name.", "error");
		redirect('index.php');
		return;
	}

	if (nameAlreadyUsed($NAME)) {
		message("A department with that name already exists.", "error");
		redirect('index.php');
		return;
	}

	$sql = "INSERT INTO `tbldepartments` (`NAME`, `DESCRIPTION`) VALUES 
		('".$mydb->escape_value($NAME)."', '".$mydb->escape_value($DESCRIPTION)."')";

	if ($mydb->InsertThis($sql)) {
		message("Department added.", "success");
	} else {
		message("The department could not be added.", "error");
	}
	redirect('index.php');
}


/* ---------------------------------------------------------------------
   EDIT an existing department
   --------------------------------------------------------------------- */
function doEdit() {

	global $mydb;

	$ID          = isset($_POST['D_ID'])          ? intval($_POST['D_ID'])        : 0;
	$NAME        = isset($_POST['D_NAME'])        ? trim($_POST['D_NAME'])        : '';
	$DESCRIPTION = isset($_POST['D_DESCRIPTION']) ? trim($_POST['D_DESCRIPTION']) : '';

	if ($ID <= 0 || $NAME == '') {
		message("Please complete all the required fields.", "error");
		redirect('index.php');
		return;
	}

	$mydb->setQuery("SELECT DEPARTMENTID FROM `tbldepartments` WHERE DEPARTMENTID = '".$ID."' LIMIT 1");
	if ($mydb->num_rows() < 1) {
		message("That department no longer exists.", "error");
		redirect('index.php');
		return;
	}

	if (nameAlreadyUsed($NAME, $ID)) {
		message("Another department already uses that name.", "error");
		redirect('index.php');
		return;
	}

	$sql = "UPDATE `tbldepartments` SET 
			`NAME`        = '".$mydb->escape_value($NAME)."', 
			`DESCRIPTION` = '".$mydb->escape_value($DESCRIPTION)."' 
		WHERE `DEPARTMENTID` = '".$ID."'";

	if ($mydb->InsertThis($sql)) {
		message("Department updated.", "success");
	} else {
		message("The department could not be updated.", "error");
	}
	redirect('index.php');
}


/* ---------------------------------------------------------------------
   DELETE a department
   ("Blocked if still in use" was removed - tblcourses has no
   DEPARTMENTID column in the actual database, so there is no
   department-course link to check against.)
   --------------------------------------------------------------------- */
function doDelete() {

	global $mydb;

	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

	if ($id <= 0) {
		message("No department selected.", "error");
		redirect('index.php');
		return;
	}

	$mydb->setQuery("SELECT DEPARTMENTID FROM `tbldepartments` WHERE DEPARTMENTID = '".$id."' LIMIT 1");
	if ($mydb->num_rows() < 1) {
		message("That department no longer exists.", "error");
		redirect('index.php');
		return;
	}

	if ($mydb->InsertThis("DELETE FROM `tbldepartments` WHERE `DEPARTMENTID` = '".$id."'")) {
		message("Department deleted.", "info");
	} else {
		message("The department could not be deleted.", "error");
	}
	redirect('index.php');
}
?>