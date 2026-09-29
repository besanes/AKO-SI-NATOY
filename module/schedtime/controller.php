<?php
//  Sched Time controller
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
   ADD a new time
   --------------------------------------------------------------------- */
function doAdd() {

	global $mydb;

	$TIME = isset($_POST['T_TIME']) ? trim($_POST['T_TIME']) : '';

	if ($TIME == '') {
		message("Please enter a time.", "error");
		redirect('index.php');
		return;
	}

	// Keep time entries unique so the same slot can't be listed twice.
	$mydb->setQuery("SELECT TIME_ID FROM `tbltime` WHERE TIME = '".$mydb->escape_value($TIME)."' LIMIT 1");
	if ($mydb->num_rows() >= 1) {
		message("That time already exists.", "error");
		redirect('index.php');
		return;
	}

	$sql = "INSERT INTO `tbltime` (`TIME`) VALUES ('".$mydb->escape_value($TIME)."')";

	if ($mydb->InsertThis($sql)) {
		message("Time added.", "success");
	} else {
		message("The time could not be added.", "error");
	}
	redirect('index.php');
}


/* ---------------------------------------------------------------------
   EDIT an existing time
   --------------------------------------------------------------------- */
function doEdit() {

	global $mydb;

	$ID   = isset($_POST['T_ID'])   ? intval($_POST['T_ID'])   : 0;
	$TIME = isset($_POST['T_TIME']) ? trim($_POST['T_TIME'])   : '';

	if ($ID <= 0 || $TIME == '') {
		message("Please complete all the required fields.", "error");
		redirect('index.php');
		return;
	}

	$mydb->setQuery("SELECT TIME_ID FROM `tbltime` WHERE TIME_ID = '".$ID."' LIMIT 1");
	if ($mydb->num_rows() < 1) {
		message("That time no longer exists.", "error");
		redirect('index.php');
		return;
	}

	// Keep time entries unique, excluding the record being edited.
	$mydb->setQuery("SELECT TIME_ID FROM `tbltime` 
		WHERE TIME = '".$mydb->escape_value($TIME)."' 
		  AND TIME_ID <> '".$ID."' 
		LIMIT 1");
	if ($mydb->num_rows() >= 1) {
		message("Another record already uses that time.", "error");
		redirect('index.php');
		return;
	}

	$sql = "UPDATE `tbltime` SET `TIME` = '".$mydb->escape_value($TIME)."' WHERE `TIME_ID` = '".$ID."'";

	if ($mydb->InsertThis($sql)) {
		message("Time updated.", "success");
	} else {
		message("The time could not be updated.", "error");
	}
	redirect('index.php');
}


/* ---------------------------------------------------------------------
   DELETE a time
   --------------------------------------------------------------------- */
function doDelete() {

	global $mydb;

	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

	if ($id <= 0) {
		message("No time selected.", "error");
		redirect('index.php');
		return;
	}

	if ($mydb->InsertThis("DELETE FROM `tbltime` WHERE `TIME_ID` = '".$id."'")) {
		message("Time deleted.", "info");
	} else {
		message("The time could not be deleted.", "error");
	}
	redirect('index.php');
}
?>