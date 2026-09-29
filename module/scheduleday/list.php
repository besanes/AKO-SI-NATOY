<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h4 class="mb-0">Days</h4>
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addDayModal">
      <span class="fa fa-plus fw-fa"></span> Add Day
    </button>
  </div>

  <div class="card-body">

    <table id="tbldaylist" class="table table-striped table-bordered" style="width:100%">
      <thead>
        <tr>
          <th>#</th>
          <th>Day</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>

  </div>
</div>


<!-- ==================== ADD MODAL ==================== -->
<div class="modal fade" id="addDayModal" tabindex="-1">
  <div class="modal-dialog">
    <form action="controller.php?action=add" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Day</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">

          <div class="form-group">
            <label>Day</label>
            <input type="text" name="D_DAY" class="form-control" placeholder="e.g. Monday" maxlength="20" required>
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
<div class="modal fade" id="editDayModal" tabindex="-1">
  <div class="modal-dialog">
    <form action="controller.php?action=edit" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Day</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">

          <input type="hidden" name="D_ID" id="D_ID">

          <div class="form-group">
            <label>Day</label>
            <input type="text" name="D_DAY" id="D_DAY" class="form-control" maxlength="20" required>
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