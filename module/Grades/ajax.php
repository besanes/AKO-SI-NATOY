<?php
require_once("../../include/initialize.php");
global $mydb;

$act = isset($_POST['act']) ? $_POST['act'] : '';

/* -----------------------------------------------------------------
   Loads the subject list for one enrollment (its COURSE_ID,
   YEAR_LEVEL and SEMESTER decide which tblsubjects rows apply),
   together with any grade already saved in tblgrades for that
   S_ID + SUBJECT_ID + ENROLLMENT_ID.
   ----------------------------------------------------------------- */
if ($act === 'get_subjects') {

	$enrollmentId = intval($_POST['ENROLLMENT_ID']);
	$output = array('subjects' => array());

	$mydb->setQuery("SELECT e.ENROLLMENT_ID, e.S_ID, e.COURSE_ID, e.YEAR_LEVEL, e.SEMESTER, e.SY_ID,
							 st.IDNO, st.FNAME, st.MNAME, st.LNAME,
							 c.COURSE_CODE, c.COURSE_NAME, sy.SCHOOL_YEAR
					  FROM `tblenrollment` e
					  LEFT JOIN `tblstudent` st ON st.S_ID = e.S_ID
					  LEFT JOIN `tblcourses` c ON c.COURSE_ID = e.COURSE_ID
					  LEFT JOIN `tblschoolyear` sy ON sy.SY_ID = e.SY_ID
					  WHERE e.ENROLLMENT_ID = '".$enrollmentId."'
					  LIMIT 1");
	$enroll = $mydb->loadSingleResult();

	if (!$enroll) {
		echo json_encode($output);
		exit;
	}

	$output['S_ID']        = $enroll->S_ID;
	$output['IDNO']        = $enroll->IDNO;
	$output['FULLNAME']    = trim($enroll->LNAME.', '.$enroll->FNAME.' '.$enroll->MNAME);
	$output['COURSE_CODE'] = $enroll->COURSE_CODE;
	$output['YEAR_LEVEL']  = $enroll->YEAR_LEVEL;
	$output['SEMESTER']    = $enroll->SEMESTER;
	$output['SCHOOL_YEAR'] = $enroll->SCHOOL_YEAR;

	$mydb->setQuery("SELECT sub.SUBJECT_ID, sub.SUBJECT_CODE, sub.SUBJECT_NAME, sub.UNITS,
							 g.GRADE, g.REMARKS
					  FROM `tblsubjects` sub
					  LEFT JOIN `tblgrades` g
							 ON g.SUBJECT_ID    = sub.SUBJECT_ID
							AND g.S_ID          = '".intval($enroll->S_ID)."'
							AND g.ENROLLMENT_ID = '".$enrollmentId."'
					  WHERE sub.COURSE_ID  = '".intval($enroll->COURSE_ID)."'
						AND sub.YEAR_LEVEL = '".$mydb->escape_value($enroll->YEAR_LEVEL)."'
						AND sub.SEMESTER   = '".$mydb->escape_value($enroll->SEMESTER)."'
					  ORDER BY sub.SUBJECT_CODE ASC");

	foreach ($mydb->loadResultList() as $row) {
		$output['subjects'][] = array(
			'SUBJECT_ID'   => $row->SUBJECT_ID,
			'SUBJECT_CODE' => $row->SUBJECT_CODE,
			'SUBJECT_NAME' => $row->SUBJECT_NAME,
			'UNITS'        => $row->UNITS,
			'GRADE'        => $row->GRADE,
			'REMARKS'      => $row->REMARKS,
		);
	}

	echo json_encode($output);
	exit;
}

/* -----------------------------------------------------------------
   Saves every row of the Grade Sheet modal. One tblgrades row per
   subject: updates it if it already exists for this student +
   enrollment + subject, otherwise inserts a new one.
   ----------------------------------------------------------------- */
if ($act === 'save_grades') {

	$enrollmentId = intval($_POST['ENROLLMENT_ID']);
	$subjectIds   = isset($_POST['SUBJECT_ID']) ? $_POST['SUBJECT_ID'] : array();
	$grades       = isset($_POST['GRADE'])      ? $_POST['GRADE']      : array();
	$remarksArr   = isset($_POST['REMARKS'])    ? $_POST['REMARKS']    : array();

	if ($enrollmentId <= 0 || empty($subjectIds)) {
		echo json_encode(array('success' => false, 'message' => 'Nothing to save.'));
		exit;
	}

	$mydb->setQuery("SELECT S_ID, SY_ID, SEMESTER FROM `tblenrollment` WHERE ENROLLMENT_ID = '".$enrollmentId."' LIMIT 1");
	$enroll = $mydb->loadSingleResult();

	if (!$enroll) {
		echo json_encode(array('success' => false, 'message' => 'That enrollment record no longer exists.'));
		exit;
	}

	$sId      = intval($enroll->S_ID);
	$syId     = intval($enroll->SY_ID);
	$semester = $enroll->SEMESTER;

	$saved = 0;
	foreach ($subjectIds as $i => $rawSubjectId) {

		$subjectId = intval($rawSubjectId);
		if ($subjectId <= 0) { continue; }

		$gradeVal = isset($grades[$i]) ? trim($grades[$i]) : '';
		$remarks  = isset($remarksArr[$i]) ? trim($remarksArr[$i]) : '';

		/* Skip a row the clerk left completely blank. */
		if ($gradeVal === '' && $remarks === '') { continue; }

		$gradeSql   = ($gradeVal === '') ? "NULL" : "'".$mydb->escape_value($gradeVal)."'";
		$remarksSql = ($remarks  === '') ? "NULL" : "'".$mydb->escape_value($remarks)."'";

		$mydb->setQuery("SELECT GRADE_ID FROM `tblgrades`
						  WHERE S_ID = '".$sId."'
							AND SUBJECT_ID = '".$subjectId."'
							AND ENROLLMENT_ID = '".$enrollmentId."'
						  LIMIT 1");
		$existing = $mydb->loadSingleResult();

		if ($existing) {
			$mydb->InsertThis("UPDATE `tblgrades`
								SET GRADE = ".$gradeSql.", REMARKS = ".$remarksSql.", DATE_ENCODED = CURDATE()
								WHERE GRADE_ID = '".intval($existing->GRADE_ID)."'");
		} else {
			$mydb->InsertThis("INSERT INTO `tblgrades`
								(`S_ID`, `SUBJECT_ID`, `ENROLLMENT_ID`, `SY_ID`, `SEMESTER`, `GRADE`, `REMARKS`, `DATE_ENCODED`)
								VALUES
								('".$sId."', '".$subjectId."', '".$enrollmentId."', '".$syId."',
								 '".$mydb->escape_value($semester)."', ".$gradeSql.", ".$remarksSql.", CURDATE())");
		}
		$saved++;
	}

	echo json_encode(array('success' => true, 'saved' => $saved));
	exit;
}

/* -----------------------------------------------------------------
   Default: server-side DataTable listing for the Grades screen.
   One row per enrollment - IDNO, name, course, year level and the
   AY / Semester, with Grade + View buttons.
   ----------------------------------------------------------------- */
$columns = array('e.ENROLLMENT_ID', 'st.IDNO', 'st.LNAME', 'c.COURSE_CODE', 'e.YEAR_LEVEL', 'sy.SCHOOL_YEAR');

$baseQuery = "FROM `tblenrollment` e
			  LEFT JOIN `tblstudent` st ON st.S_ID = e.S_ID
			  LEFT JOIN `tblcourses` c ON c.COURSE_ID = e.COURSE_ID
			  LEFT JOIN `tblschoolyear` sy ON sy.SY_ID = e.SY_ID";

$where = '';
if (isset($_POST['search']['value']) && trim($_POST['search']['value']) != '') {
	$term  = $mydb->escape_value(trim($_POST['search']['value']));
	$where = " WHERE (st.LNAME LIKE '%".$term."%'
					 OR st.FNAME LIKE '%".$term."%'
					 OR st.IDNO LIKE '%".$term."%'
					 OR c.COURSE_CODE LIKE '%".$term."%')";
}

$query = "SELECT e.ENROLLMENT_ID, st.S_ID, st.IDNO, st.FNAME, st.MNAME, st.LNAME,
				  c.COURSE_CODE, e.YEAR_LEVEL, e.SEMESTER, sy.SCHOOL_YEAR
		   ".$baseQuery.$where;

if (isset($_POST['order']) && isset($columns[$_POST['order']['0']['column']])) {
	$orderCol = $columns[$_POST['order']['0']['column']];
	$orderDir = ($_POST['order']['0']['dir'] == 'desc') ? 'DESC' : 'ASC';
	$query .= " ORDER BY ".$orderCol." ".$orderDir." ";
} else {
	$query .= " ORDER BY e.ENROLLMENT_ID DESC ";
}

if (isset($_POST['length']) && $_POST['length'] != -1) {
	$query .= " LIMIT ".intval($_POST['start']).", ".intval($_POST['length'])."";
}

$mydb->setQuery($query);
$cur = $mydb->loadResultList();
$filtered_rows = $mydb->num_rows();

$data = array();
$i = 1;
foreach ($cur as $row) {

	$fullname = trim($row->LNAME.', '.$row->FNAME.' '.$row->MNAME);
	$ayShort  = trim($row->SCHOOL_YEAR.' / '.$row->SEMESTER);

	$sub_array = array();
	$sub_array[] = $i;
	$sub_array[] = $row->IDNO;
	$sub_array[] = $fullname;
	$sub_array[] = $row->COURSE_CODE;
	$sub_array[] = $row->YEAR_LEVEL;
	$sub_array[] = $ayShort;

	$sub_array[] = '
		<button type="button" data-enrollment="'.$row->ENROLLMENT_ID.'" class="btn btn-primary btn-xs gradeEntry" title="Encode Grades"><span class="fa fa-graduation-cap fw-fa"></span> Grade</button>
		<a href="index.php?view=view&id='.$row->ENROLLMENT_ID.'"><button type="button" class="btn btn-info btn-xs" title="View"><span class="fa fa-eye"></span> View</button></a>
	';

	$data[] = $sub_array;
	$i++;
}

function get_total_all_grade_records() {
	global $mydb;
	$mydb->setQuery("SELECT e.ENROLLMENT_ID
					  FROM `tblenrollment` e
					  LEFT JOIN `tblstudent` st ON st.S_ID = e.S_ID
					  LEFT JOIN `tblcourses` c ON c.COURSE_ID = e.COURSE_ID");
	return $mydb->num_rows();
}

$output = array(
	'data'            => $data,
	'recordsTotal'    => get_total_all_grade_records(),
	'recordsFiltered' => $filtered_rows,
);
echo json_encode($output);
?>
