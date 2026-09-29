<?php
//  Classrooms controller
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
   ADD a new classroom
   --------------------------------------------------------------------- */
function doAdd() {

	global $mydb;

	$NAME = isset($_POST['C_NAME']) ? trim($_POST['C_NAME']) : '';
	$DESC = isset($_POST['C_DESC']) ? trim($_POST['C_DESC']) : '';

	if ($NAME == '') {
		message("Please enter a classroom name.", "error");
		redirect('index.php');
		return;
	}

	// Keep classroom names unique so the same room can't be listed twice.
	$mydb->setQuery("SELECT CLASSROOMID FROM `tblclassrooms` WHERE NAME = '".$mydb->escape_value($NAME)."' LIMIT 1");
	if ($mydb->num_rows() >= 1) {
		message("That classroom already exists.", "error");
		redirect('index.php');
		return;
	}

	$descSql = ($DESC == '') ? "NULL" : "'".$mydb->escape_value($DESC)."'";

	$sql = "INSERT INTO `tblclassrooms` (`NAME`, `DESCRIPTION`) VALUES ('".$mydb->escape_value($NAME)."', ".$descSql.")";

	if ($mydb->InsertThis($sql)) {
		message("Classroom added.", "success");
	} else {
		message("The classroom could not be added.", "error");
	}
	redirect('index.php');
}


/* ---------------------------------------------------------------------
   EDIT an existing classroom
   --------------------------------------------------------------------- */
function doEdit() {

	global $mydb;

	$ID   = isset($_POST['C_ID'])   ? intval($_POST['C_ID'])   : 0;
	$NAME = isset($_POST['C_NAME']) ? trim($_POST['C_NAME'])   : '';
	$DESC = isset($_POST['C_DESC']) ? trim($_POST['C_DESC'])   : '';

	if ($ID <= 0 || $NAME == '') {
		message("Please complete all the required fields.", "error");
		redirect('index.php');
		return;
	}

	$mydb->setQuery("SELECT CLASSROOMID FROM `tblclassrooms` WHERE CLASSROOMID = '".$ID."' LIMIT 1");
	if ($mydb->num_rows() < 1) {
		message("That classroom no longer exists.", "error");
		redirect('index.php');
		return;
	}

	// Keep classroom names unique, excluding the record being edited.
	$mydb->setQuery("SELECT CLASSROOMID FROM `tblclassrooms` 
		WHERE NAME = '".$mydb->escape_value($NAME)."' 
		  AND CLASSROOMID <> '".$ID."' 
		LIMIT 1");
	if ($mydb->num_rows() >= 1) {
		message("Another classroom already uses that name.", "error");
		redirect('index.php');
		return;
	}

	$descSql = ($DESC == '') ? "NULL" : "'".$mydb->escape_value($DESC)."'";

	$sql = "UPDATE `tblclassrooms` SET 
			`NAME`        = '".$mydb->escape_value($NAME)."', 
			`DESCRIPTION` = ".$descSql." 
		WHERE `CLASSROOMID` = '".$ID."'";

	if ($mydb->InsertThis($sql)) {
		message("Classroom updated.", "success");
	} else {
		message("The classroom could not be updated.", "error");
	}
	redirect('index.php');
}


/* ---------------------------------------------------------------------
   DELETE a classroom
   --------------------------------------------------------------------- */
function doDelete() {

	global $mydb;

	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

	if ($id <= 0) {
		message("No classroom selected.", "error");
		redirect('index.php');
		return;
	}

	if ($mydb->InsertThis("DELETE FROM `tblclassrooms` WHERE `CLASSROOMID` = '".$id."'")) {
		message("Classroom deleted.", "info");
	} else {
		message("The classroom could not be deleted.", "error");
	}
	redirect('index.php');
}
?>