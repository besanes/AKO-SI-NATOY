<?php
require_once ("../../include/initialize.php");
	  if (!isset($_SESSION['ACCOUNT_ID'])){
     // redirect(web_root."admin/index.php");
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

	case 'register' :
	doRegister();
	break;
	 
	}
    
	function doInsert(){
  //``IDNO`, `FNAME`, `LNAME`, `MNAME`, `SEX`, `BDAY`
 
		
	 
		$student = new Student();

		$IDNO   = $_POST['IDNO'];
		$FNAME	= $_POST['FNAME'];
		$LNAME 	= $_POST['LNAME'];
		$MNAME 		= $_POST['MNAME'];
		$SEX 		= $_POST['SEX'];
		$BDAY  = $_POST['BDAY'];
		$BPLACE = isset($_POST['BPLACE']) ? $_POST['BPLACE'] : '';
		$AGE = isset($_POST['AGE']) ? $_POST['AGE'] : '';
		$NATIONALITY = isset($_POST['NATIONALITY']) ? $_POST['NATIONALITY'] : '';
		$RELIGION = isset($_POST['RELIGION']) ? $_POST['RELIGION'] : '';
		$CONTACT_NO = isset($_POST['CONTACT_NO']) ? $_POST['CONTACT_NO'] : '';
		$HOME_ADD = isset($_POST['HOME_ADD']) ? $_POST['HOME_ADD'] : '';
		$EMAIL = isset($_POST['EMAIL']) ? $_POST['EMAIL'] : '';

		$photo = '';
		if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
			$uploadDir = "image/";
			if (!is_dir($uploadDir)) { mkdir($uploadDir, 0777, true); }
			$filename = time() . '_' . basename($_FILES['photo']['name']);
			move_uploaded_file($_FILES['photo']['tmp_name'], $uploadDir . $filename);
			$photo = $uploadDir . $filename;
		}
		

		$res = $student->find_all_student($IDNO);
		
		
			if ($res >=1) {
				message("Student IDNO already exist!", "error");
				redirect('index.php');
			}else{
				
				$student->IDNO = $IDNO;
				$student->FNAME = $FNAME;
				$student->LNAME = $LNAME;
				$student->MNAME 	= $MNAME;
				$student->SEX 	= $SEX;
				$student->BDAY 	= $BDAY;
				$student->BPLACE = $BPLACE;
				$student->AGE = $AGE;
				$student->NATIONALITY = $NATIONALITY;
				$student->RELIGION = $RELIGION;
				$student->CONTACT_NO = $CONTACT_NO;
				$student->HOME_ADD = $HOME_ADD;
				$student->EMAIL = $EMAIL;
				if ($photo != '') {
					$student->photo = $photo;
				}
				
				 
				 $istrue = $student->create(); 
				 
				 		if ($istrue == true) {
					 		message("New Student [". $IDNO ."] has been created successfully!", "success");
					 		redirect('index.php');
					 	}else{
					 		message("No user has been created successfully!", "error");
					 		redirect('index.php');
					 	}
			}	 

	}
	function doEdit(){

			$student = new Student();

			$UID   = $_POST['UID'];

			//`IDNO`, `FNAME`, `LNAME`, `MNAME`, `SEX`, `BDAY``

			$IDNO   = $_POST['IDNO1'];
			$FNAME	= $_POST['FNAME1'];
			$MNAME	= $_POST['MNAME1'];
			$LNAME	= $_POST['LNAME1'];
			$SEX	= isset($_POST['SEX1'])  ? $_POST['SEX1']  : '';
			$BDAY	= isset($_POST['BDAY1']) ? $_POST['BDAY1'] : '';
			$BPLACE = isset($_POST['BPLACE1']) ? $_POST['BPLACE1'] : '';
			$AGE = isset($_POST['AGE1']) ? $_POST['AGE1'] : '';
			$NATIONALITY = isset($_POST['NATIONALITY1']) ? $_POST['NATIONALITY1'] : '';
			$RELIGION = isset($_POST['RELIGION1']) ? $_POST['RELIGION1'] : '';
			$CONTACT_NO = isset($_POST['CONTACT_NO1']) ? $_POST['CONTACT_NO1'] : '';
			$HOME_ADD = isset($_POST['HOME_ADD1']) ? $_POST['HOME_ADD1'] : '';
			$EMAIL = isset($_POST['EMAIL1']) ? $_POST['EMAIL1'] : '';
					
					
				$student->IDNO = $IDNO;
				$student->FNAME = $FNAME;
				$student->MNAME = $MNAME;
				$student->LNAME = $LNAME;
				$student->BPLACE = $BPLACE;
				$student->AGE = $AGE;
				$student->NATIONALITY = $NATIONALITY;
				$student->RELIGION = $RELIGION;
				$student->CONTACT_NO = $CONTACT_NO;
				$student->HOME_ADD = $HOME_ADD;
				$student->EMAIL = $EMAIL;

				if (isset($_FILES['photo1']) && $_FILES['photo1']['error'] == 0) {
					$uploadDir = "image/";
					if (!is_dir($uploadDir)) { mkdir($uploadDir, 0777, true); }
					$filename = time() . '_' . basename($_FILES['photo1']['name']);
					move_uploaded_file($_FILES['photo1']['tmp_name'], $uploadDir . $filename);
					$student->photo = $uploadDir . $filename;
				}

				/* Only overwrite gender when a real choice was made, so a blank
				   dropdown never wipes an existing value. */
				if ($SEX == 'Male' || $SEX == 'Female') {
					$student->SEX = $SEX;
				}

				/* Same guard for the date: an empty date input must not turn a
				   stored BDAY into 0000-00-00. */
				if ($BDAY != '') {
					$student->BDAY = $BDAY;
				}
				
				 
				 $istrue = $student->update($UID); 
				 if ($istrue == true){
				 	
				 	message("Details has been Updated successfully!", "success");
				 	redirect('index.php');
				 	
				 }else{
				 	message("No user account has been updated successfully!", "error");
				 	redirect('index.php');
				 }
		
	
	}


	/* -------------------------------------------------------------------
	   STAGE 1 of the enrollment flow: RESERVE

	   Creates the tblenrollment row with STATUS = Reserved. SECTION_ID and
	   DATE_ENROLLED are deliberately left NULL - they get filled in during
	   Stage 2 (Sectioning) on the Enrollment screen.

	   Ends by sending the user to Enrollment so the new reservation is
	   right in front of them, ready to be sectioned.
	   ------------------------------------------------------------------- */
	function doRegister(){

		global $mydb;

		$S_ID       = isset($_POST['R_SID'])           ? intval($_POST['R_SID'])          : 0;
		$SY_ID      = isset($_POST['R_SY'])            ? intval($_POST['R_SY'])           : 0;
		$COURSE_ID  = isset($_POST['R_COURSE'])        ? intval($_POST['R_COURSE'])       : 0;
		$YEAR_LEVEL = isset($_POST['R_YEARLEVEL'])     ? trim($_POST['R_YEARLEVEL'])      : '';
		$SEMESTER   = isset($_POST['R_SEMESTER'])      ? trim($_POST['R_SEMESTER'])       : '';
		$CATEGORY   = isset($_POST['R_CATEGORY'])      ? trim($_POST['R_CATEGORY'])       : 'New';
		$CURRICULUM = isset($_POST['R_CURRICULUM'])    ? trim($_POST['R_CURRICULUM'])     : '';
		$RESERVED   = isset($_POST['R_DATE_RESERVED']) ? trim($_POST['R_DATE_RESERVED'])  : '';

		$enrollmentPage = WEB_ROOT.'module/enrollment/index.php';

		if ($S_ID <= 0 || $SY_ID <= 0 || $COURSE_ID <= 0 || $YEAR_LEVEL == '' || $SEMESTER == '') {
			message("Please complete all the reservation fields.", "error");
			redirect('index.php');
			return;
		}

		if ($RESERVED == '') { $RESERVED = date('Y-m-d'); }

		/* One reservation per student per school year per semester. The
		   database also enforces this with a unique key, but catching it
		   here gives a readable message instead of a PDO error. */
		$mydb->setQuery("SELECT ENROLLMENT_ID FROM `tblenrollment` 
			WHERE S_ID     = '".$S_ID."' 
			  AND SY_ID    = '".$SY_ID."' 
			  AND SEMESTER = '".$mydb->escape_value($SEMESTER)."' 
			LIMIT 1");
		if ($mydb->num_rows() >= 1) {
			message("This student already has a record for that academic year and semester.", "error");
			redirect('index.php');
			return;
		}

		$encodedBy = isset($_SESSION['UID']) ? intval($_SESSION['UID']) : 0;
		$encodedSql = ($encodedBy > 0) ? "'".$encodedBy."'" : "NULL";

		$curriculumSql = ($CURRICULUM == '') ? "NULL" : "'".$mydb->escape_value($CURRICULUM)."'";

		$sql = "INSERT INTO `tblenrollment` 
			(`S_ID`, `COURSE_ID`, `SECTION_ID`, `SY_ID`, `YEAR_LEVEL`, `SEMESTER`, 
			 `CATEGORY`, `CURRICULUM_YR`, `DATE_RESERVED`, `DATE_ENROLLED`, `STATUS`, `ENCODED_BY`) 
			VALUES ('".$S_ID."', '".$COURSE_ID."', NULL, '".$SY_ID."', 
			'".$mydb->escape_value($YEAR_LEVEL)."', '".$mydb->escape_value($SEMESTER)."', 
			'".$mydb->escape_value($CATEGORY)."', ".$curriculumSql.", 
			'".$mydb->escape_value($RESERVED)."', NULL, 'Reserved', ".$encodedSql.")";

		$istrue = $mydb->InsertThis($sql);

		if ($istrue) {

			/* Keep the student record in step with the course they reserved
			   for, so the Student list shows the right program. */
			$mydb->InsertThis("UPDATE `tblstudent` SET `COURSE_ID` = '".$COURSE_ID."' WHERE `S_ID` = '".$S_ID."'");

			message("Slot reserved. Use Sectioning to complete the enrollment.", "success");
			redirect($enrollmentPage);
		} else {
			message("The reservation could not be saved.", "error");
			redirect('index.php');
		}
	}


	


	function doDelete(){
		
				$id = 	$_GET['id'];

				$student = New Student();
	 		 	$student->delete($id);
			 
			message("Student already Deleted!","info");
			redirect('index.php');
		
	}

	
?>
