<?php
//  Sched Day controller
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
   ADD a new day
   --------------------------------------------------------------------- */
function doAdd() {

	global $mydb;

	$DAY = isset($_POST['D_DAY']) ? trim($_POST['D_DAY']) : '';

	if ($DAY == '') {
		message("Please enter a day.", "error");
		redirect('index.php');
		return;
	}

	// Keep day names unique so the same day can't be listed twice.
	$mydb->setQuery("SELECT DAY_ID FROM `tblday` WHERE DAY = '".$mydb->escape_value($DAY)."' LIMIT 1");
	if ($mydb->num_rows() >= 1) {
		message("That day already exists.", "error");
		redirect('index.php');
		return;
	}

	$sql = "INSERT INTO `tblday` (`DAY`) VALUES ('".$mydb->escape_value($DAY)."')";

	if ($mydb->InsertThis($sql)) {
		message("Day added.", "success");
	} else {
		message("The day could not be added.", "error");
	}
	redirect('index.php');
}


/* ---------------------------------------------------------------------
   EDIT an existing day
   --------------------------------------------------------------------- */
function doEdit() {

	global $mydb;

	$ID  = isset($_POST['D_ID'])  ? intval($_POST['D_ID'])  : 0;
	$DAY = isset($_POST['D_DAY']) ? trim($_POST['D_DAY'])   : '';

	if ($ID <= 0 || $DAY == '') {
		message("Please complete all the required fields.", "error");
		redirect('index.php');
		return;
	}

	$mydb->setQuery("SELECT DAY_ID FROM `tblday` WHERE DAY_ID = '".$ID."' LIMIT 1");
	if ($mydb->num_rows() < 1) {
		message("That day no longer exists.", "error");
		redirect('index.php');
		return;
	}

	// Keep day names unique, excluding the record being edited.
	$mydb->setQuery("SELECT DAY_ID FROM `tblday` 
		WHERE DAY = '".$mydb->escape_value($DAY)."' 
		  AND DAY_ID <> '".$ID."' 
		LIMIT 1");
	if ($mydb->num_rows() >= 1) {
		message("Another record already uses that day.", "error");
		redirect('index.php');
		return;
	}

	$sql = "UPDATE `tblday` SET `DAY` = '".$mydb->escape_value($DAY)."' WHERE `DAY_ID` = '".$ID."'";

	if ($mydb->InsertThis($sql)) {
		message("Day updated.", "success");
	} else {
		message("The day could not be updated.", "error");
	}
	redirect('index.php');
}


/* ---------------------------------------------------------------------
   DELETE a day
   --------------------------------------------------------------------- */
function doDelete() {

	global $mydb;

	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

	if ($id <= 0) {
		message("No day selected.", "error");
		redirect('index.php');
		return;
	}

	if ($mydb->InsertThis("DELETE FROM `tblday` WHERE `DAY_ID` = '".$id."'")) {
		message("Day deleted.", "info");
	} else {
		message("The day could not be deleted.", "error");
	}
	redirect('index.php');
}
?>