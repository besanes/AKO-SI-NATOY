<?php

$employee = null;
$manager  = null;
$directReports = array();

if (isset($_GET['id']) && $_GET['id'] != '') {

	$id = (int)$_GET['id'];

	$mydb->setQuery("SELECT * FROM `tblemployee` WHERE `EMPLOYEE_ID` = '".$id."' LIMIT 1");
	$employee = $mydb->loadSingleResult();

	if ($employee && $employee->MANAGER_ID) {
		$mydb->setQuery("SELECT EMPLOYEE_ID, FNAME, LNAME, JOB_TITLE FROM `tblemployee` WHERE EMPLOYEE_ID = '".(int)$employee->MANAGER_ID."' LIMIT 1");
		$manager = $mydb->loadSingleResult();
	}

	if ($employee) {
		$mydb->setQuery("SELECT EMPLOYEE_ID, FNAME, LNAME, JOB_TITLE FROM `tblemployee` WHERE MANAGER_ID = '".$id."' ORDER BY LNAME ASC");
		$directReports = $mydb->loadResultList();
	}
}
?>

<section class="content">
  <div class="container-fluid">

  <?php if (!$employee): ?>
    <div class="alert alert-warning">
      No employee was selected. Please go back to the <a href="<?php echo WEB_ROOT; ?>module/employee/">Employee list</a> and click the view button of an employee.
    </div>

  <?php else: ?>

    <div class="row">
      <div class="col-md-3">

        <div class="card card-primary card-outline">
          <div class="card-body box-profile">

            <div class="text-center">
              <img class="profile-user-img img-fluid img-circle"
                   src="<?php echo WEB_ROOT; ?>dist/img/user2-160x160.jpg"
                   alt="Employee photo">
            </div>

            <h3 class="profile-username text-center">
              <?php echo htmlspecialchars($employee->FNAME.' '.$employee->MNAME.' '.$employee->LNAME.' '.$employee->SUFFIX); ?>
            </h3>

            <p class="text-muted text-center"><?php echo htmlspecialchars($employee->JOB_TITLE); ?></p>

            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <b>Department</b> <a class="float-right"><?php echo htmlspecialchars($employee->DEPARTMENT); ?></a>
              </li>
              <li class="list-group-item">
                <b>Hire Date</b> <a class="float-right"><?php echo htmlspecialchars($employee->HIRE_DATE); ?></a>
              </li>
              <li class="list-group-item">
                <b>Status</b>
                <a class="float-right">
                  <?php if ($employee->STATUS === 'Active'): ?>
                    <span class="badge badge-success">Active</span>
                  <?php else: ?>
                    <span class="badge badge-secondary">Inactive</span>
                  <?php endif; ?>
                </a>
              </li>
            </ul>

            <a href="<?php echo WEB_ROOT; ?>module/employee/" class="btn btn-primary btn-block"><b>Back to List</b></a>
          </div>
        </div>

        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Reports To</h3>
          </div>
          <div class="card-body">
            <?php if ($manager): ?>
              <strong><i class="fas fa-user-tie mr-1"></i> Manager</strong>
              <p class="text-muted">
                <a href="<?php echo WEB_ROOT; ?>module/employee/index.php?view=view&id=<?php echo $manager->EMPLOYEE_ID; ?>">
                  <?php echo htmlspecialchars($manager->LNAME.', '.$manager->FNAME); ?>
                </a><br>
                <small><?php echo htmlspecialchars($manager->JOB_TITLE); ?></small>
              </p>
            <?php else: ?>
              <p class="text-muted">No manager assigned.</p>
            <?php endif; ?>
          </div>
        </div>

      </div>
      <!-- /.col -->

      <div class="col-md-9">
        <div class="card">
          <div class="card-header p-2">
            <h3 class="card-title">Employee Info</h3>
          </div>
          <div class="card-body">
            <table class="table table-bordered">
              <tr>
                <th style="width:30%">First Name</th>
                <td><?php echo htmlspecialchars($employee->FNAME); ?></td>
              </tr>
              <tr>
                <th>Middle Name</th>
                <td><?php echo htmlspecialchars($employee->MNAME); ?></td>
              </tr>
              <tr>
                <th>Last Name</th>
                <td><?php echo htmlspecialchars($employee->LNAME); ?></td>
              </tr>
              <tr>
                <th>Suffix</th>
                <td><?php echo $employee->SUFFIX ? htmlspecialchars($employee->SUFFIX) : '-'; ?></td>
              </tr>
              <tr>
                <th>Email</th>
                <td><?php echo htmlspecialchars($employee->EMAIL); ?></td>
              </tr>
              <tr>
                <th>Job Title</th>
                <td><?php echo htmlspecialchars($employee->JOB_TITLE); ?></td>
              </tr>
              <tr>
                <th>Department</th>
                <td><?php echo htmlspecialchars($employee->DEPARTMENT); ?></td>
              </tr>
              <tr>
                <th>Hire Date</th>
                <td><?php echo htmlspecialchars($employee->HIRE_DATE); ?></td>
              </tr>
            </table>

            <h5 class="mt-4">Direct Reports</h5>
            <?php if (empty($directReports)): ?>
              <p class="text-muted">This employee has no direct reports.</p>
            <?php else: ?>
              <table class="table table-bordered table-sm">
                <thead>
                <tr><th>Name</th><th>Job Title</th></tr>
                </thead>
                <tbody>
                <?php foreach ($directReports as $r): ?>
                  <tr>
                    <td>
                      <a href="<?php echo WEB_ROOT; ?>module/employee/index.php?view=view&id=<?php echo $r->EMPLOYEE_ID; ?>">
                        <?php echo htmlspecialchars($r->LNAME.', '.$r->FNAME); ?>
                      </a>
                    </td>
                    <td><?php echo htmlspecialchars($r->JOB_TITLE); ?></td>
                  </tr>
                <?php endforeach; ?>
                </tbody>
              </table>
            <?php endif; ?>

          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

  <?php endif; ?>

  </div>
</section>
