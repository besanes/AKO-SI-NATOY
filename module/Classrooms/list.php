<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h4 class="mb-0">Classrooms</h4>
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addClassroomModal">
      <span class="fa fa-plus fw-fa"></span> Add Classroom
    </button>
  </div>

  <div class="card-body">

    <table id="tblclassroomslist" class="table table-striped table-bordered" style="width:100%">
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Description</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>

  </div>
</div>


<!-- ==================== ADD MODAL ==================== -->
<div class="modal fade" id="addClassroomModal" tabindex="-1">
  <div class="modal-dialog">
    <form action="controller.php?action=add" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Classroom</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">

          <div class="form-group">
            <label>Name</label>
            <input type="text" name="C_NAME" class="form-control" placeholder="e.g. Room 101" maxlength="100" required>
          </div>

          <div class="form-group">
            <label>Description</label>
            <textarea name="C_DESC" class="form-control" rows="3" maxlength="255" placeholder="e.g. Ground floor, near the library"></textarea>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </div>
    </form>
  </div>
</div>


<!-- ==================== EDIT MODAL ==================== -->
<div class="modal fade" id="editClassroomModal" tabindex="-1">
  <div class="modal-dialog">
    <form action="controller.php?action=edit" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Classroom</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">

          <input type="hidden" name="C_ID" id="C_ID">

          <div class="form-group">
            <label>Name</label>
            <input type="text" name="C_NAME" id="C_NAME" class="form-control" maxlength="100" required>
          </div>

          <div class="form-group">
            <label>Description</label>
            <textarea name="C_DESC" id="C_DESC" class="form-control" rows="3" maxlength="255"></textarea>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
      </div>
    </form>
  </div>
</div>