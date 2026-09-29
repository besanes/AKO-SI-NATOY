<?php
// HIPANAO SOLUTIONS - Instructor list + Add + Edit
global $mydb;

$mydb->setQuery("SELECT INSTRUCTORID FROM `tblinstructor`");
$cntAll = $mydb->num_rows();
?>
<section class="content">
  <div class="container-fluid">
    <?php check_message(); ?>

    <div class="row">
      <div class="col-12">

        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Instructor Records (<?php echo $cntAll; ?>)</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addInstructorModal">
                <i class="fa fa-plus"></i> Add Instructor
              </button>
            </div>
          </div>

          <div class="card-body">
            <table id="tblinstructorlist" class="table table-bordered table-striped" style="width:100%">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Instructor Name</th>
                  <th>Status</th>
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
     ADD a new instructor
     ================================================================= -->
<div class="modal fade" id="addInstructorModal">
  <div class="modal-dialog">
    <form action="controller.php?action=add" method="POST">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h4 class="modal-title"><i class="fa fa-plus"></i> &nbsp;Add Instructor</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" style="color:#fff;">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="form-group">
            <label for="ADD_I_NAME" class="col-form-label col-form-label-sm">Instructor Name</label>
            <input type="text" class="form-control form-control-sm" name="I_NAME" id="ADD_I_NAME" required maxlength="100">
          </div>

          <div class="form-group">
            <label for="ADD_I_STATUS" class="col-form-label col-form-label-sm">Status</label>
            <select class="form-control form-control-sm" name="I_STATUS" id="ADD_I_STATUS">
              <option value="1">Active</option>
              <option value="0">Inactive</option>
            </select>
          </div>

        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Instructor</button>
        </div>
      </div>
    </form>
  </div>
</div>


<!-- =================================================================
     EDIT an existing instructor
     ================================================================= -->
<div class="modal fade" id="editInstructorModal">
  <div class="modal-dialog">
    <form action="controller.php?action=edit" method="POST">
      <div class="modal-content">
        <div class="modal-header bg-warning">
          <h4 class="modal-title"><i class="fa fa-edit"></i> &nbsp;Edit Instructor</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <input type="hidden" name="I_ID" id="EDIT_I_ID" value="">

          <div class="form-group">
            <label for="EDIT_I_NAME" class="col-form-label col-form-label-sm">Instructor Name</label>
            <input type="text" class="form-control form-control-sm" name="I_NAME" id="EDIT_I_NAME" required maxlength="100">
          </div>

          <div class="form-group">
            <label for="EDIT_I_STATUS" class="col-form-label col-form-label-sm">Status</label>
            <select class="form-control form-control-sm" name="I_STATUS" id="EDIT_I_STATUS">
              <option value="1">Active</option>
              <option value="0">Inactive</option>
            </select>
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
