<?php
require_once("../../include/initialize.php");
global $mydb;

if (!isset($_SESSION['ACCOUNT_ID'])) {
	// redirect(web_root."admin/index.php");
}

$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : '';

switch ($action) {
	case 'add':
		doInsert();
		break;

	case 'edit':
		doEdit();
		break;

	case 'delete':
		doDelete();
		break;

	case 'toggle':
		doToggle();
		break;
}

/* ---------------------------------------------------------------------
   Confirms an INSTRUCTORID actually exists in tblinstructor before we
   save it as a foreign key. Returns true for an empty/0 id too, since
   the instructor field is optional (schedule can be "unassigned").
   --------------------------------------------------------------------- */
function instructorIdIsValid($id) {
	global $mydb;
	if ($id <= 0) {
		return true;
	}
	$mydb->setQuery("SELECT INSTRUCTORID FROM `tblinstructor` WHERE INSTRUCTORID = '".$id."' LIMIT 1");
	return ($mydb->num_rows() >= 1);
}

function doInsert() {
	global $mydb;

	$ROOM                = isset($_POST['ROOM'])                ? trim($_POST['ROOM'])                : '';
	$DAY                 = isset($_POST['DAY'])                 ? trim($_POST['DAY'])                 : '';
	$TIME                = isset($_POST['TIME'])                ? trim($_POST['TIME'])                : '';
	$AY                  = isset($_POST['AY'])                  ? trim($_POST['AY'])                  : '';
	$SEMESTER            = isset($_POST['SEMESTER'])             ? trim($_POST['SEMESTER'])            : '';
	$YEAR_LEVEL          = isset($_POST['YEAR_LEVEL'])           ? trim($_POST['YEAR_LEVEL'])           : '';
	$SECTION             = isset($_POST['SECTION'])              ? trim($_POST['SECTION'])              : '';
	$CODE                = isset($_POST['CODE'])                 ? trim($_POST['CODE'])                 : '';
	$SUBJECT_DESCRIPTION = isset($_POST['SUBJECT_DESCRIPTION'])  ? trim($_POST['SUBJECT_DESCRIPTION'])  : '';
	$UNITS               = isset($_POST['UNITS'])                ? floatval($_POST['UNITS'])            : 0;
	$INSTRUCTORID        = isset($_POST['INSTRUCTORID'])         ? intval($_POST['INSTRUCTORID'])       : 0;
	$STATUS              = isset($_POST['STATUS']) && $_POST['STATUS'] == '1' ? 1 : 1; // default enabled on create

	if ($ROOM == '' || $DAY == '' || $TIME == '' || $AY == '' || $SEMESTER == ''
		|| $YEAR_LEVEL == '' || $SECTION == '' || $CODE == '' || $SUBJECT_DESCRIPTION == '') {
		message("Please complete all required schedule fields.", "error");
		redirect('index.php');
		return;
	}

	if (!instructorIdIsValid($INSTRUCTORID)) {
		message("Please choose a valid instructor.", "error");
		redirect('index.php');
		return;
	}

	/* Avoid double-booking the same room, day, time, AY & semester. */
	$mydb->setQuery("SELECT SCHEDULEID FROM `tblsetschedule`
		WHERE ROOM = '".$mydb->escape_value($ROOM)."'
		  AND DAY = '".$mydb->escape_value($DAY)."'
		  AND TIME = '".$mydb->escape_value($TIME)."'
		  AND AY = '".$mydb->escape_value($AY)."'
		  AND SEMESTER = '".$mydb->escape_value($SEMESTER)."'
		LIMIT 1");
	if ($mydb->num_rows() >= 1) {
		message("That room is already scheduled for the same day, time, school year and semester.", "error");
		redirect('index.php');
		return;
	}

	$instructorSql = ($INSTRUCTORID > 0) ? "'".$INSTRUCTORID."'" : "NULL";

	$sql = "INSERT INTO `tblsetschedule`
		(`ROOM`, `DAY`, `TIME`, `AY`, `SEMESTER`, `YEAR_LEVEL`, `SECTION`, `CODE`, `SUBJECT_DESCRIPTION`, `UNITS`, `INSTRUCTORID`, `STATUS`)
		VALUES (
			'".$mydb->escape_value($ROOM)."',
			'".$mydb->escape_value($DAY)."',
			'".$mydb->escape_value($TIME)."',
			'".$mydb->escape_value($AY)."',
			'".$mydb->escape_value($SEMESTER)."',
			'".$mydb->escape_value($YEAR_LEVEL)."',
			'".$mydb->escape_value($SECTION)."',
			'".$mydb->escape_value($CODE)."',
			'".$mydb->escape_value($SUBJECT_DESCRIPTION)."',
			".$UNITS.",
			".$instructorSql.",
			".$STATUS."
		)";

	$istrue = $mydb->InsertThis($sql);

	if ($istrue) {
		message("New schedule has been created successfully!", "success");
		redirect('index.php');
	} else {
		message("The schedule could not be saved.", "error");
		redirect('index.php');
	}
}

function doEdit() {
	global $mydb;

	$UID = isset($_POST['UID']) ? intval($_POST['UID']) : 0;

	$ROOM                = isset($_POST['ROOM1'])                ? trim($_POST['ROOM1'])                : '';
	$DAY                 = isset($_POST['DAY1'])                 ? trim($_POST['DAY1'])                 : '';
	$TIME                = isset($_POST['TIME1'])                ? trim($_POST['TIME1'])                : '';
	$AY                  = isset($_POST['AY1'])                  ? trim($_POST['AY1'])                  : '';
	$SEMESTER            = isset($_POST['SEMESTER1'])             ? trim($_POST['SEMESTER1'])            : '';
	$YEAR_LEVEL          = isset($_POST['YEAR_LEVEL1'])           ? trim($_POST['YEAR_LEVEL1'])           : '';
	$SECTION             = isset($_POST['SECTION1'])              ? trim($_POST['SECTION1'])              : '';
	$CODE                = isset($_POST['CODE1'])                 ? trim($_POST['CODE1'])                 : '';
	$SUBJECT_DESCRIPTION = isset($_POST['SUBJECT_DESCRIPTION1'])  ? trim($_POST['SUBJECT_DESCRIPTION1'])  : '';
	$UNITS               = isset($_POST['UNITS1'])                ? floatval($_POST['UNITS1'])            : 0;
	$INSTRUCTORID        = isset($_POST['INSTRUCTORID1'])         ? intval($_POST['INSTRUCTORID1'])       : 0;
	$STATUS              = (isset($_POST['STATUS1']) && $_POST['STATUS1'] == '1') ? 1 : 0;

	if ($UID <= 0 || $ROOM == '' || $DAY == '' || $TIME == '' || $AY == '' || $SEMESTER == ''
		|| $YEAR_LEVEL == '' || $SECTION == '' || $CODE == '' || $SUBJECT_DESCRIPTION == '') {
		message("Please complete all required schedule fields.", "error");
		redirect('index.php');
		return;
	}

	if (!instructorIdIsValid($INSTRUCTORID)) {
		message("Please choose a valid instructor.", "error");
		redirect('index.php');
		return;
	}

	$instructorSql = ($INSTRUCTORID > 0) ? "'".$INSTRUCTORID."'" : "NULL";

	$sql = "UPDATE `tblsetschedule` SET
		`ROOM` = '".$mydb->escape_value($ROOM)."',
		`DAY` = '".$mydb->escape_value($DAY)."',
		`TIME` = '".$mydb->escape_value($TIME)."',
		`AY` = '".$mydb->escape_value($AY)."',
		`SEMESTER` = '".$mydb->escape_value($SEMESTER)."',
		`YEAR_LEVEL` = '".$mydb->escape_value($YEAR_LEVEL)."',
		`SECTION` = '".$mydb->escape_value($SECTION)."',
		`CODE` = '".$mydb->escape_value($CODE)."',
		`SUBJECT_DESCRIPTION` = '".$mydb->escape_value($SUBJECT_DESCRIPTION)."',
		`UNITS` = ".$UNITS.",
		`INSTRUCTORID` = ".$instructorSql.",
		`STATUS` = ".$STATUS."
		WHERE `SCHEDULEID` = '".$UID."'";

	$istrue = $mydb->InsertThis($sql);

	if ($istrue) {
		message("Schedule has been updated successfully!", "success");
		redirect('index.php');
	} else {
		message("The schedule could not be updated.", "error");
		redirect('index.php');
	}
}

function doDelete() {
	global $mydb;
	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

	if ($id > 0) {
		$mydb->InsertThis("DELETE FROM `tblsetschedule` WHERE `SCHEDULEID` = '".$id."'");
		message("Schedule has been deleted!", "info");
	}
	redirect('index.php');
}

function doToggle() {
	global $mydb;
	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

	if ($id > 0) {
		$mydb->setQuery("SELECT STATUS FROM `tblsetschedule` WHERE SCHEDULEID = '".$id."' LIMIT 1");
		$row = $mydb->loadResultList();
		$newStatus = 1;
		foreach ($row as $r) {
			$newStatus = ($r->STATUS == 1) ? 0 : 1;
		}
		$mydb->InsertThis("UPDATE `tblsetschedule` SET `STATUS` = '".$newStatus."' WHERE `SCHEDULEID` = '".$id."'");
		message("Schedule status updated!", "success");
	}
	redirect('index.php');
}
?>
