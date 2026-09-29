<?php

$enroll  = null;
$grades  = array();
$total   = 0;
$countedUnits = 0;

if (isset($_GET['id']) && $_GET['id'] != '') {

	$enrollmentId = (int)$_GET['id'];

	$mydb->setQuery("SELECT e.*, st.IDNO, st.FNAME, st.MNAME, st.LNAME,
							 c.COURSE_CODE, c.COURSE_NAME, sy.SCHOOL_YEAR
					  FROM `tblenrollment` e
					  LEFT JOIN `tblstudent` st ON st.S_ID = e.S_ID
					  LEFT JOIN `tblcourses` c ON c.COURSE_ID = e.COURSE_ID
					  LEFT JOIN `tblschoolyear` sy ON sy.SY_ID = e.SY_ID
					  WHERE e.ENROLLMENT_ID = '".$enrollmentId."'
					  LIMIT 1");
	$enroll = $mydb->loadSingleResult();

	if ($enroll) {
		$mydb->setQuery("SELECT sub.SUBJECT_CODE, sub.SUBJECT_NAME, sub.UNITS, g.GRADE, g.REMARKS
						  FROM `tblsubjects` sub
						  LEFT JOIN `tblgrades` g
								 ON g.SUBJECT_ID    = sub.SUBJECT_ID
								AND g.S_ID          = '".(int)$enroll->S_ID."'
								AND g.ENROLLMENT_ID = '".$enrollmentId."'
						  WHERE sub.COURSE_ID  = '".(int)$enroll->COURSE_ID."'
							AND sub.YEAR_LEVEL = '".$mydb->escape_value($enroll->YEAR_LEVEL)."'
							AND sub.SEMESTER   = '".$mydb->escape_value($enroll->SEMESTER)."'
						  ORDER BY sub.SUBJECT_CODE ASC");
		$grades = $mydb->loadResultList();

		foreach ($grades as $g) {
			if ($g->GRADE !== null && $g->GRADE !== '') {
				$total        += (float)$g->GRADE * (int)$g->UNITS;
				$countedUnits += (int)$g->UNITS;
			}
		}
	}
}

$gwa = ($countedUnits > 0) ? round($total / $countedUnits, 2) : null;
?>

<section class="content">
  <div class="container-fluid">

  <?php if (!$enroll): ?>
    <div class="alert alert-warning">
      No enrollment record was selected. Please go back to the <a href="<?php echo WEB_ROOT; ?>module/grades/">Grades list</a> and click the view button of a student.
    </div>

  <?php else: ?>

    <div class="row">
      <div class="col-md-3">
        <div class="card card-primary card-outline">
          <div class="card-body box-profile">
            <h3 class="profile-username text-center">
              <?php echo htmlspecialchars($enroll->LNAME.', '.$enroll->FNAME.' '.$enroll->MNAME); ?>
            </h3>
            <p class="text-muted text-center">Student ID: <?php echo htmlspecialchars($enroll->IDNO); ?></p>

            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <b>Course</b> <a class="float-right"><?php echo htmlspecialchars($enroll->COURSE_CODE); ?></a>
              </li>
              <li class="list-group-item">
                <b>Year Level</b> <a class="float-right"><?php echo htmlspecialchars($enroll->YEAR_LEVEL); ?></a>
              </li>
              <li class="list-group-item">
                <b>AY / Semester</b>
                <a class="float-right"><?php echo htmlspecialchars($enroll->SCHOOL_YEAR.' / '.$enroll->SEMESTER); ?></a>
              </li>
              <li class="list-group-item">
                <b>General Average</b>
                <a class="float-right"><?php echo $gwa !== null ? htmlspecialchars($gwa) : '-'; ?></a>
              </li>
            </ul>

            <a href="<?php echo WEB_ROOT; ?>module/grades/" class="btn btn-primary btn-block"><b>Back to List</b></a>
          </div>
        </div>
      </div>
      <!-- /.col -->

      <div class="col-md-9">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Grade Sheet</h3>
          </div>
          <div class="card-body">
            <table class="table table-bordered">
              <thead>
              <tr>
                <th>Code</th>
                <th>Subject</th>
                <th>Units</th>
                <th>Grade</th>
                <th>Remarks</th>
              </tr>
              </thead>
              <tbody>
              <?php if (empty($grades)): ?>
                <tr><td colspan="5" class="text-center text-muted">No subjects are set up for this course / year level / semester.</td></tr>
              <?php else: foreach ($grades as $g): ?>
                <tr>
                  <td><?php echo htmlspecialchars($g->SUBJECT_CODE); ?></td>
                  <td><?php echo htmlspecialchars($g->SUBJECT_NAME); ?></td>
                  <td><?php echo htmlspecialchars($g->UNITS); ?></td>
                  <td><?php echo ($g->GRADE !== null && $g->GRADE !== '') ? htmlspecialchars($g->GRADE) : '-'; ?></td>
                  <td><?php echo $g->REMARKS ? htmlspecialchars($g->REMARKS) : '-'; ?></td>
                </tr>
              <?php endforeach; endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

  <?php endif; ?>

  </div>
</section>
