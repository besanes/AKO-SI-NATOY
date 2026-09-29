<?php


$student = null;
$enroll  = null;

if (isset($_GET['id']) && $_GET['id'] != '') {
    $mydb->setQuery("SELECT * FROM `tblstudent` WHERE `S_ID`='".(int)$_GET['id']."' LIMIT 1");
    $student = $mydb->loadSingleResult();

    // Latest enrollment record for this student (course / section / school year), if any
    $mydb->setQuery("SELECT e.*, c.COURSE_CODE, c.COURSE_NAME, s.SECTION_NAME, sy.SCHOOL_YEAR
                      FROM `tblenrollment` e
                      LEFT JOIN `tblcourses` c ON c.COURSE_ID = e.COURSE_ID
                      LEFT JOIN `tblsections` s ON s.SECTION_ID = e.SECTION_ID
                      LEFT JOIN `tblschoolyear` sy ON sy.SY_ID = e.SY_ID
                      WHERE e.S_ID='".(int)$_GET['id']."'
                      ORDER BY e.ENROLLMENT_ID DESC LIMIT 1");
    $enroll = $mydb->loadSingleResult();
}
?>

<section class="content">
  <div class="container-fluid">

  <?php if (!$student): ?>
    <div class="alert alert-warning">
      No student was selected. Please go back to the <a href="<?php echo WEB_ROOT; ?>module/student/">student list</a> and click the view button of a student.
    </div>

  <?php else: ?>

    <div class="row">
      <div class="col-md-3">

        <!-- Profile Image / Basic Info -->
        <div class="card card-primary card-outline">
          <div class="card-body box-profile">

            <div class="text-center">
              <img class="profile-user-img img-fluid img-circle"
                   src="<?php echo WEB_ROOT; ?>module/student/image/1.png"
                   alt="Student photo">
            </div>

            <h3 class="profile-username text-center">
              <?php echo htmlspecialchars($student->FNAME.' '.$student->MNAME.' '.$student->LNAME); ?>
            </h3>

            <p class="text-muted text-center">
              Student ID: <?php echo htmlspecialchars($student->IDNO); ?>
            </p>

            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <b>Gender</b> <a class="float-right"><?php echo htmlspecialchars($student->SEX); ?></a>
              </li>
              <li class="list-group-item">
                <b>Birthday</b> <a class="float-right"><?php echo htmlspecialchars($student->BDAY); ?></a>
              </li>
              <li class="list-group-item">
                <b>Status</b> <a class="float-right"><?php echo htmlspecialchars($student->STATUS); ?></a>
              </li>
            </ul>

            <a href="<?php echo WEB_ROOT; ?>module/student/" class="btn btn-primary btn-block"><b>Back to List</b></a>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <!-- Enrollment summary -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Current Enrollment</h3>
          </div>
          <div class="card-body">
            <?php if ($enroll): ?>
              <strong><i class="fas fa-book mr-1"></i> Course</strong>
              <p class="text-muted">
                <?php echo htmlspecialchars($enroll->COURSE_CODE.' - '.$enroll->COURSE_NAME); ?>
              </p>
              <hr>
              <strong><i class="fas fa-users mr-1"></i> Section</strong>
              <p class="text-muted"><?php echo htmlspecialchars($enroll->SECTION_NAME); ?></p>
              <hr>
              <strong><i class="fas fa-calendar mr-1"></i> School Year</strong>
              <p class="text-muted"><?php echo htmlspecialchars($enroll->SCHOOL_YEAR); ?></p>
              <hr>
              <strong><i class="fas fa-info-circle mr-1"></i> Enrollment Status</strong>
              <p class="text-muted"><?php echo htmlspecialchars($enroll->STATUS); ?></p>
            <?php else: ?>
              <p class="text-muted">This student is not yet enrolled in any course/section.</p>
            <?php endif; ?>
          </div>
        </div>

      </div>
      <!-- /.col -->
      <div class="col-md-9">
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#profile" data-toggle="tab">Profile Info</a></li>
              <li class="nav-item"><a class="nav-link" href="#contact" data-toggle="tab">Contact Info</a></li>
            </ul>
          </div><!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content">

              <div class="active tab-pane" id="profile">
                <table class="table table-bordered">
                  <tr>
                    <th style="width:30%">Student ID Number</th>
                    <td><?php echo htmlspecialchars($student->IDNO); ?></td>
                  </tr>
                  <tr>
                    <th>Full Name</th>
                    <td><?php echo htmlspecialchars($student->FNAME.' '.$student->MNAME.' '.$student->LNAME); ?></td>
                  </tr>
                  <tr>
                    <th>Gender</th>
                    <td><?php echo htmlspecialchars($student->SEX); ?></td>
                  </tr>
                  <tr>
                    <th>Birthday</th>
                    <td><?php echo htmlspecialchars($student->BDAY); ?></td>
                  </tr>
                  <tr>
                    <th>Birth Place</th>
                    <td><?php echo isset($student->BPLACE) ? htmlspecialchars($student->BPLACE) : ''; ?></td>
                  </tr>
                  <tr>
                    <th>Age</th>
                    <td><?php echo isset($student->AGE) ? htmlspecialchars($student->AGE) : ''; ?></td>
                  </tr>
                  <tr>
                    <th>Nationality</th>
                    <td><?php echo isset($student->NATIONALITY) ? htmlspecialchars($student->NATIONALITY) : ''; ?></td>
                  </tr>
                  <tr>
                    <th>Religion</th>
                    <td><?php echo isset($student->RELIGION) ? htmlspecialchars($student->RELIGION) : ''; ?></td>
                  </tr>
                  <tr>
                    <th>Status</th>
                    <td><?php echo htmlspecialchars($student->STATUS); ?></td>
                  </tr>
                </table>
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="contact">
                <table class="table table-bordered">
                  <tr>
                    <th style="width:30%">Contact Number</th>
                    <td><?php echo isset($student->CONTACT_NO) ? htmlspecialchars($student->CONTACT_NO) : ''; ?></td>
                  </tr>
                  <tr>
                    <th>Email</th>
                    <td><?php echo isset($student->EMAIL) ? htmlspecialchars($student->EMAIL) : ''; ?></td>
                  </tr>
                  <tr>
                    <th>Home Address</th>
                    <td><?php echo isset($student->HOME_ADD) ? htmlspecialchars($student->HOME_ADD) : ''; ?></td>
                  </tr>
                </table>
              </div>
              <!-- /.tab-pane -->

            </div>
            <!-- /.tab-content -->
          </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

  <?php endif; ?>

  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
