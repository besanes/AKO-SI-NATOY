<?php
// HIPANAO SOLUTIONS - Department list + Add + Edit
global $mydb;

$mydb->setQuery("SELECT DEPARTMENTID FROM `tbldepartments`");
$cntAll = $mydb->num_rows();
?>
<section class="content">
  <div class="container-fluid">
    <?php check_message(); ?>

    <div class="row">
      <div class="col-12">

        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Department Records (<?php echo $cntAll; ?>)</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addDepartmentModal">
                <i class="fa fa-plus"></i> Add Department
              </button>
            </div>
          </div>

          <div class="card-body">
            <table id="tbldepartmentlist" class="table table-bordered table-striped" style="width:100%">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Description</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>


<!-- =================================================================
     ADD a new department
     ================================================================= -->
<div class="modal fade" id="addDepartmentModal">
  <div class="modal-dialog">
    <form action="controller.php?action=add" method="POST">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h4 class="modal-title"><i class="fa fa-plus"></i> &nbsp;Add Department</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" style="color:#fff;">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="form-group">
            <label for="ADD_D_NAME" class="col-form-label col-form-label-sm">Department Name</label>
            <input type="text" class="form-control form-control-sm" name="D_NAME" id="ADD_D_NAME" required maxlength="100">
          </div>

          <div class="form-group">
            <label for="ADD_D_DESCRIPTION" class="col-form-label col-form-label-sm">Description</label>
            <textarea class="form-control form-control-sm" name="D_DESCRIPTION" id="ADD_D_DESCRIPTION" rows="3" maxlength="255"></textarea>
          </div>

        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Department</button>
        </div>
      </div>
    </form>
  </div>
</div>


<!-- =================================================================
     EDIT an existing department
     ================================================================= -->
<div class="modal fade" id="editDepartmentModal">
  <div class="modal-dialog">
    <form action="controller.php?action=edit" method="POST">
      <div class="modal-content">
        <div class="modal-header bg-warning">
          <h4 class="modal-title"><i class="fa fa-edit"></i> &nbsp;Edit Department</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <input type="hidden" name="D_ID" id="EDIT_D_ID" value="">

          <div class="form-group">
            <label for="EDIT_D_NAME" class="col-form-label col-form-label-sm">Department Name</label>
            <input type="text" class="form-control form-control-sm" name="D_NAME" id="EDIT_D_NAME" required maxlength="100">
          </div>

          <div class="form-group">
            <label for="EDIT_D_DESCRIPTION" class="col-form-label col-form-label-sm">Description</label>
            <textarea class="form-control form-control-sm" name="D_DESCRIPTION" id="EDIT_D_DESCRIPTION" rows="3" maxlength="255"></textarea>
          </div>

        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-warning"><i class="fa fa-save"></i> Save changes</button>
        </div>
      </div>
    </form>
  </div>
</div>