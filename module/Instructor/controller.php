<?php
//  Instructor controller
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
   Checks whether another instructor already uses this name (case
   insensitive), optionally excluding a specific INSTRUCTORID so an
   edit can keep its own name.
   --------------------------------------------------------------------- */
function nameAlreadyUsed($name, $excludeId = 0) {
	global $mydb;

	$sql = "SELECT INSTRUCTORID FROM `tblinstructor` WHERE LOWER(INSTRUCTOR) = LOWER('".$mydb->escape_value($name)."')";
	if ($excludeId > 0) {
		$sql .= " AND INSTRUCTORID <> '".$excludeId."'";
	}
	$mydb->setQuery($sql);
	return ($mydb->num_rows() >= 1);
}


/* ---------------------------------------------------------------------
   ADD a new instructor
   --------------------------------------------------------------------- */
function doAdd() {

	global $mydb;

	$INSTRUCTOR = isset($_POST['I_NAME'])   ? trim($_POST['I_NAME'])       : '';
	$STATUS     = isset($_POST['I_STATUS']) ? intval($_POST['I_STATUS'])   : 1;

	if ($INSTRUCTOR == '') {
		message("Please enter the instructor name.", "error");
		redirect('index.php');
		return;
	}

	if (nameAlreadyUsed($INSTRUCTOR)) {
		message("An instructor with that name already exists.", "error");
		redirect('index.php');
		return;
	}

	$sql = "INSERT INTO `tblinstructor` (`INSTRUCTOR`, `STATUS`) VALUES 
		('".$mydb->escape_value($INSTRUCTOR)."', '".$STATUS."')";

	if ($mydb->InsertThis($sql)) {
		message("Instructor added.", "success");
	} else {
		message("The instructor could not be added.", "error");
	}
	redirect('index.php');
}


/* ---------------------------------------------------------------------
   EDIT an existing instructor
   --------------------------------------------------------------------- */
function doEdit() {

	global $mydb;

	$ID         = isset($_POST['I_ID'])     ? intval($_POST['I_ID'])       : 0;
	$INSTRUCTOR = isset($_POST['I_NAME'])   ? trim($_POST['I_NAME'])       : '';
	$STATUS     = isset($_POST['I_STATUS']) ? intval($_POST['I_STATUS'])   : 1;

	if ($ID <= 0 || $INSTRUCTOR == '') {
		message("Please complete all the required fields.", "error");
		redirect('index.php');
		return;
	}

	$mydb->setQuery("SELECT INSTRUCTORID FROM `tblinstructor` WHERE INSTRUCTORID = '".$ID."' LIMIT 1");
	if ($mydb->num_rows() < 1) {
		message("That instructor no longer exists.", "error");
		redirect('index.php');
		return;
	}

	if (nameAlreadyUsed($INSTRUCTOR, $ID)) {
		message("Another instructor already uses that name.", "error");
		redirect('index.php');
		return;
	}

	$sql = "UPDATE `tblinstructor` SET 
			`INSTRUCTOR` = '".$mydb->escape_value($INSTRUCTOR)."', 
			`STATUS`     = '".$STATUS."' 
		WHERE `INSTRUCTORID` = '".$ID."'";

	if ($mydb->InsertThis($sql)) {
		message("Instructor updated.", "success");
	} else {
		message("The instructor could not be updated.", "error");
	}
	redirect('index.php');
}


/* ---------------------------------------------------------------------
   DELETE an instructor
   (No other table references INSTRUCTORID in the actual database, so
   there is no linked-record check to run before deleting.)
   --------------------------------------------------------------------- */
function doDelete() {

	global $mydb;

	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

	if ($id <= 0) {
		message("No instructor selected.", "error");
		redirect('index.php');
		return;
	}

	$mydb->setQuery("SELECT INSTRUCTORID FROM `tblinstructor` WHERE INSTRUCTORID = '".$id."' LIMIT 1");
	if ($mydb->num_rows() < 1) {
		message("That instructor no longer exists.", "error");
		redirect('index.php');
		return;
	}

	if ($mydb->InsertThis("DELETE FROM `tblinstructor` WHERE `INSTRUCTORID` = '".$id."'")) {
		message("Instructor deleted.", "info");
	} else {
		message("The instructor could not be deleted.", "error");
	}
	redirect('index.php');
}
?>
