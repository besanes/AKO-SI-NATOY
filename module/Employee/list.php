<section class="content">
  <div class="container-fluid">
    <?php check_message(); ?>
    <div class="row">
      <div class="col-12">

        <div class="card">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-users mr-1"></i> Employees</h3>

            <div class="card-tools">
              <div class="btn-group mr-2">
                <button type="button" class="btn btn-sm btn-secondary statusFilterBtn active" data-status="All">All</button>
                <button type="button" class="btn btn-sm btn-success statusFilterBtn" data-status="Active">Active</button>
                <button type="button" class="btn btn-sm btn-secondary statusFilterBtn" data-status="Inactive">Inactive</button>
              </div>
              <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#AddNewEntry">
                <i class="fas fa-plus"></i> Add Employee
              </button>
              <button type="button" id="btnPrintEmployees" class="btn btn-sm btn-default">
                <i class="fas fa-print"></i> Print
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="tblemployee" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>Suffix</th>
                <th>Email</th>
                <th>Job Title</th>
                <th>Department</th>
                <th>Manager</th>
                <th>Hire Date</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
              </thead>
              <tbody>
              </tbody>
              <tfoot>
              </tfoot>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</section>
<!-- /.content -->

<!-- ==================== Add Employee modal ==================== -->
<div class="modal fade" id="AddNewEntry">
  <div class="modal-dialog">
    <form action="controller.php?action=add" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add New Employee</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="form-group">
            <label>First Name</label>
            <input type="text" name="FNAME" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Middle Name</label>
            <input type="text" name="MNAME" class="form-control">
          </div>
          <div class="form-group">
            <label>Last Name</label>
            <input type="text" name="LNAME" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Suffix</label>
            <select name="SUFFIX" class="form-control">
              <option value="">-- none --</option>
              <option value="Jr.">Jr.</option>
              <option value="Sr.">Sr.</option>
              <option value="II">II</option>
              <option value="III">III</option>
            </select>
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" name="EMAIL" class="form-control">
          </div>
          <div class="form-group">
            <label>Job Title</label>
            <input type="text" name="JOB_TITLE" class="form-control">
          </div>
          <div class="form-group">
            <label>Department</label>
            <input type="text" name="DEPARTMENT" class="form-control">
          </div>
          <div class="form-group">
            <label>Manager</label>
            <select id="MANAGER_ID" name="MANAGER_ID" class="form-control">
              <option value="">-- None --</option>
            </select>
          </div>
          <div class="form-group">
            <label>Hire Date</label>
            <input type="date" name="HIRE_DATE" class="form-control">
          </div>
          <div class="form-group">
            <label>Status</label>
            <select name="STATUS" class="form-control">
              <option value="Active">Active</option>
              <option value="Inactive">Inactive</option>
            </select>
          </div>

        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save Employee</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </form>
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- ==================== Edit Employee modal ==================== -->
<div class="modal fade" id="editEntry">
  <div class="modal-dialog">
    <form action="controller.php?action=edit" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Employee</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <input type="hidden" id="UID" name="UID">

          <div class="form-group">
            <label>First Name</label>
            <input type="text" id="FNAME1" name="FNAME1" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Middle Name</label>
            <input type="text" id="MNAME1" name="MNAME1" class="form-control">
          </div>
          <div class="form-group">
            <label>Last Name</label>
            <input type="text" id="LNAME1" name="LNAME1" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Suffix</label>
            <select id="SUFFIX1" name="SUFFIX1" class="form-control">
              <option value="">-- none --</option>
              <option value="Jr.">Jr.</option>
              <option value="Sr.">Sr.</option>
              <option value="II">II</option>
              <option value="III">III</option>
            </select>
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" id="EMAIL1" name="EMAIL1" class="form-control">
          </div>
          <div class="form-group">
            <label>Job Title</label>
            <input type="text" id="JOB_TITLE1" name="JOB_TITLE1" class="form-control">
          </div>
          <div class="form-group">
            <label>Department</label>
            <input type="text" id="DEPARTMENT1" name="DEPARTMENT1" class="form-control">
          </div>
          <div class="form-group">
            <label>Manager</label>
            <select id="MANAGER_ID1" name="MANAGER_ID1" class="form-control">
              <option value="">-- None --</option>
            </select>
          </div>
          <div class="form-group">
            <label>Hire Date</label>
            <input type="date" id="HIRE_DATE1" name="HIRE_DATE1" class="form-control">
          </div>
          <div class="form-group">
            <label>Status</label>
            <select id="STATUS1" name="STATUS1" class="form-control">
              <option value="Active">Active</option>
              <option value="Inactive">Inactive</option>
            </select>
          </div>

        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update Employee</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </form>
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
