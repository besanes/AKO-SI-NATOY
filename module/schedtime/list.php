<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h4 class="mb-0">Times</h4>
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addTimeModal">
      <span class="fa fa-plus fw-fa"></span> Add Time
    </button>
  </div>

  <div class="card-body">

    <table id="tbltimelist" class="table table-striped table-bordered" style="width:100%">
      <thead>
        <tr>
          <th>#</th>
          <th>Time</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>

  </div>
</div>


<!-- ==================== ADD MODAL ==================== -->
<div class="modal fade" id="addTimeModal" tabindex="-1">
  <div class="modal-dialog">
    <form action="controller.php?action=add" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Time</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">

          <div class="form-group">
            <label>Time</label>
            <input type="text" name="T_TIME" class="form-control" placeholder="e.g. 7:00 AM - 8:00 AM" maxlength="50" required>
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
<div class="modal fade" id="editTimeModal" tabindex="-1">
  <div class="modal-dialog">
    <form action="controller.php?action=edit" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Time</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">

          <input type="hidden" name="T_ID" id="T_ID">

          <div class="form-group">
            <label>Time</label>
            <input type="text" name="T_TIME" id="T_TIME" class="form-control" maxlength="50" required>
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