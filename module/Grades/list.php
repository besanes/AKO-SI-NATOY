<?php
/* No dropdown data needed here - filtering is handled client-side by
   the DataTable search box, same as the Student list. */
?>
<section class="content">
  <div class="container-fluid">
    <?php check_message(); ?>
    <div class="row">
      <div class="col-12">

        <div class="card">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-graduation-cap mr-1"></i> Grades</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="tblgrades" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>#</th>
                <th>ID No.</th>
                <th>Student Name</th>
                <th>Course</th>
                <th>Year Level</th>
                <th>AY / Semester</th>
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

<!-- ==================== Grade Sheet modal ==================== -->
<div class="modal fade" id="gradeSheetEntry">
  <div class="modal-dialog modal-lg">
    <form id="gradeSheetForm">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Encode Grades</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <input type="hidden" id="GS_ENROLLMENT_ID" name="ENROLLMENT_ID" value="">

          <p class="mb-1"><strong id="GS_STUDENT_TEXT">-</strong></p>
          <p class="text-muted" id="GS_META_TEXT">-</p>

          <div class="alert alert-warning d-none" id="GS_SUBJECT_ERROR"></div>

          <div class="table-responsive">
            <table class="table table-bordered table-sm">
              <thead>
              <tr>
                <th style="width:15%">Code</th>
                <th>Subject</th>
                <th style="width:10%">Units</th>
                <th style="width:20%">Grade</th>
                <th style="width:20%">Remarks</th>
              </tr>
              </thead>
              <tbody id="GS_ROWS">
              </tbody>
            </table>
          </div>

        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" id="GS_SAVE_BTN" class="btn btn-success">Save Grades</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </form>
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
