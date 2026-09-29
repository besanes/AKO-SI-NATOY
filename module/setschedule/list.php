<?php
/* Dropdown data for the Set Schedule forms.
   $mydb is set up by include/initialize.php, already loaded by template.php.

   Day, Time and Instructor options come from the Sched Day (tblday),
   Sched Time (tbltime) and Instructor (tblinstructor) modules, so
   adding/editing an entry there is what shows up here - no more
   hardcoded lists or free-text instructor names to keep in sync. */
global $mydb;

/* tblclassrooms columns confirmed from the live DB dump:
   CLASSROOMID, NAME, DESCRIPTION - the room name lives in NAME. */
$scheduleRooms = array();
$mydb->setQuery("SELECT CLASSROOMID, NAME FROM `tblclassrooms` ORDER BY NAME ASC");
foreach ($mydb->loadResultList() as $c) { $scheduleRooms[] = $c; }

$scheduleDays = array();
$mydb->setQuery("SELECT DAY_ID, DAY FROM `tblday` ORDER BY DAY_ID ASC");
foreach ($mydb->loadResultList() as $d) { $scheduleDays[] = $d; }

/* Assumes tbltime mirrors tblday: TIME_ID, TIME (e.g. "07:00 AM - 08:00 AM").
   If your tbltime columns are named differently, adjust this query and the
   TIME_ID/TIME references below. */
$scheduleTimes = array();
$mydb->setQuery("SELECT TIME_ID, TIME FROM `tbltime` ORDER BY TIME_ID ASC");
foreach ($mydb->loadResultList() as $t) { $scheduleTimes[] = $t; }

/* Instructors now come from tblinstructor - only show Active ones so
   the dropdown doesn't fill up with instructors who no longer teach.
   tblsetschedule.INSTRUCTORID is a real FK to tblinstructor.INSTRUCTORID. */
$scheduleInstructors = array();
$mydb->setQuery("SELECT INSTRUCTORID, INSTRUCTOR FROM `tblinstructor` WHERE STATUS = 1 ORDER BY INSTRUCTOR ASC");
foreach ($mydb->loadResultList() as $ins) { $scheduleInstructors[] = $ins; }

$scheduleSemesters  = array('1st Semester', '2nd Semester', 'Summer');
$scheduleYearLevels = array('1st Year', '2nd Year', '3rd Year', '4th Year');
?>
 <section class="content">
      <div class="container-fluid">
         <?php check_message(); ?>
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Set Schedule</h3>
              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                <table id="tblsetschedule" class="table table-bordered table-striped" style="width:100%">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Room</th>
                    <th>Day</th>
                    <th>Time</th>
                    <th>AY</th>
                    <th>Semester</th>
                    <th>Year Level</th>
                    <th>Section</th>
                    <th>Code</th>
                    <th>Subject</th>
                    <th>Units</th>
                    <th>Instructor</th>
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
                  <div class="btn-group">

                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#AddNewEntry">Add New</button>

                </div>
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


<!-----ADD NEW SCHEDULE---->
<div class="modal fade" id="AddNewEntry">
        <div class="modal-dialog">
        <form action="controller.php?action=add" method="POST">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Set Schedule</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <div class="row">

                <div class="col-sm-12">
                  <div class="form-group">
                   <label for="ROOM" class="col-form-label col-form-label-sm">Room</label>
                    <select class="form-control form-control-sm" name="ROOM" id="ROOM" required>
                      <option value="">Select Room</option>
                      <?php foreach ($scheduleRooms as $c) { ?>
                      <option value="<?php echo htmlspecialchars($c->NAME); ?>"><?php echo htmlspecialchars($c->NAME); ?></option>
                      <?php } ?>
                    </select>
                    <small class="form-text text-muted">Manage the list under Classrooms.</small>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                   <label for="DAY" class="col-form-label col-form-label-sm">Day</label>
                    <select class="form-control form-control-sm" name="DAY" id="DAY" required>
                      <option value="">Select Day</option>
                      <?php foreach ($scheduleDays as $d) { ?>
                      <option value="<?php echo htmlspecialchars($d->DAY); ?>"><?php echo htmlspecialchars($d->DAY); ?></option>
                      <?php } ?>
                    </select>
                    <small class="form-text text-muted">Manage the list under Sched Day.</small>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                   <label for="TIME" class="col-form-label col-form-label-sm">Time</label>
                    <select class="form-control form-control-sm" name="TIME" id="TIME" required>
                      <option value="">Select Time</option>
                      <?php foreach ($scheduleTimes as $t) { ?>
                      <option value="<?php echo htmlspecialchars($t->TIME); ?>"><?php echo htmlspecialchars($t->TIME); ?></option>
                      <?php } ?>
                    </select>
                    <small class="form-text text-muted">Manage the list under Sched Time.</small>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                   <label for="AY" class="col-form-label col-form-label-sm">AY</label>
                    <input type="text" class="form-control form-control-sm" name="AY"
                    id="AY" placeholder="e.g. 2026" required>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                   <label for="SEMESTER" class="col-form-label col-form-label-sm">Semester</label>
                    <select class="form-control form-control-sm" name="SEMESTER" id="SEMESTER" required>
                      <option value="">Select Semester</option>
                      <?php foreach ($scheduleSemesters as $s) { ?>
                      <option value="<?php echo $s; ?>"><?php echo $s; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                   <label for="YEAR_LEVEL" class="col-form-label col-form-label-sm">Year Level</label>
                    <select class="form-control form-control-sm" name="YEAR_LEVEL" id="YEAR_LEVEL" required>
                      <option value="">Select Year Level</option>
                      <?php foreach ($scheduleYearLevels as $yl) { ?>
                      <option value="<?php echo $yl; ?>"><?php echo $yl; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                   <label for="SECTION" class="col-form-label col-form-label-sm">Section</label>
                    <input type="text" class="form-control form-control-sm" name="SECTION"
                    id="SECTION" placeholder="e.g. BSIT-1A" maxlength="20" required>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                   <label for="CODE" class="col-form-label col-form-label-sm">Subject Code</label>
                    <input type="text" class="form-control form-control-sm" name="CODE"
                    id="CODE" placeholder="e.g. IT101" maxlength="30" required>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                   <label for="UNITS" class="col-form-label col-form-label-sm">Units</label>
                    <input type="number" step="0.5" min="0" class="form-control form-control-sm" name="UNITS"
                    id="UNITS" placeholder="e.g. 3" required>
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="form-group">
                   <label for="SUBJECT_DESCRIPTION" class="col-form-label col-form-label-sm">Subject Description</label>
                    <input type="text" class="form-control form-control-sm" name="SUBJECT_DESCRIPTION"
                    id="SUBJECT_DESCRIPTION" placeholder="e.g. Introduction to Programming" maxlength="255" required>
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="form-group">
                   <label for="INSTRUCTORID" class="col-form-label col-form-label-sm">Instructor</label>
                    <select class="form-control form-control-sm" name="INSTRUCTORID" id="INSTRUCTORID">
                      <option value="">Select Instructor</option>
                      <?php foreach ($scheduleInstructors as $ins) { ?>
                      <option value="<?php echo $ins->INSTRUCTORID; ?>"><?php echo htmlspecialchars($ins->INSTRUCTOR); ?></option>
                      <?php } ?>
                    </select>
                    <small class="form-text text-muted">Manage the list under Instructor.</small>
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="form-check ml-2">
                    <input type="checkbox" class="form-check-input" name="STATUS" id="STATUS" value="1" checked>
                    <label class="form-check-label" for="STATUS">Enable this schedule</label>
                  </div>
                </div>

              </div>

            </div>
            <div class="modal-footer justify-content-between">
             <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                 <button type="submit" class="btn btn-primary" name="save"><i class="fa fa-save"></i> Save</button>

            </div>
          </div>
          </form>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
<!-----END of Add Form---->


<!-----EDIT SCHEDULE---->
<div class="modal fade" id="editEntry">
        <div class="modal-dialog">
        <form action="controller.php?action=edit" method="POST">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Schedule</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <input type="hidden" name="UID" id="UID" value="">

              <div class="row">

                <div class="col-sm-12">
                  <div class="form-group">
                   <label for="ROOM1" class="col-form-label col-form-label-sm">Room</label>
                    <select class="form-control form-control-sm" name="ROOM1" id="ROOM1" required>
                      <option value="">Select Room</option>
                      <?php foreach ($scheduleRooms as $c) { ?>
                      <option value="<?php echo htmlspecialchars($c->NAME); ?>"><?php echo htmlspecialchars($c->NAME); ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                   <label for="DAY1" class="col-form-label col-form-label-sm">Day</label>
                    <select class="form-control form-control-sm" name="DAY1" id="DAY1" required>
                      <option value="">Select Day</option>
                      <?php foreach ($scheduleDays as $d) { ?>
                      <option value="<?php echo htmlspecialchars($d->DAY); ?>"><?php echo htmlspecialchars($d->DAY); ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                   <label for="TIME1" class="col-form-label col-form-label-sm">Time</label>
                    <select class="form-control form-control-sm" name="TIME1" id="TIME1" required>
                      <option value="">Select Time</option>
                      <?php foreach ($scheduleTimes as $t) { ?>
                      <option value="<?php echo htmlspecialchars($t->TIME); ?>"><?php echo htmlspecialchars($t->TIME); ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                   <label for="AY1" class="col-form-label col-form-label-sm">AY</label>
                    <input type="text" class="form-control form-control-sm" name="AY1"
                    id="AY1" placeholder="e.g. 2026" required>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                   <label for="SEMESTER1" class="col-form-label col-form-label-sm">Semester</label>
                    <select class="form-control form-control-sm" name="SEMESTER1" id="SEMESTER1" required>
                      <option value="">Select Semester</option>
                      <?php foreach ($scheduleSemesters as $s) { ?>
                      <option value="<?php echo $s; ?>"><?php echo $s; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                   <label for="YEAR_LEVEL1" class="col-form-label col-form-label-sm">Year Level</label>
                    <select class="form-control form-control-sm" name="YEAR_LEVEL1" id="YEAR_LEVEL1" required>
                      <option value="">Select Year Level</option>
                      <?php foreach ($scheduleYearLevels as $yl) { ?>
                      <option value="<?php echo $yl; ?>"><?php echo $yl; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                   <label for="SECTION1" class="col-form-label col-form-label-sm">Section</label>
                    <input type="text" class="form-control form-control-sm" name="SECTION1"
                    id="SECTION1" placeholder="e.g. BSIT-1A" maxlength="20" required>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                   <label for="CODE1" class="col-form-label col-form-label-sm">Subject Code</label>
                    <input type="text" class="form-control form-control-sm" name="CODE1"
                    id="CODE1" placeholder="e.g. IT101" maxlength="30" required>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                   <label for="UNITS1" class="col-form-label col-form-label-sm">Units</label>
                    <input type="number" step="0.5" min="0" class="form-control form-control-sm" name="UNITS1"
                    id="UNITS1" placeholder="e.g. 3" required>
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="form-group">
                   <label for="SUBJECT_DESCRIPTION1" class="col-form-label col-form-label-sm">Subject Description</label>
                    <input type="text" class="form-control form-control-sm" name="SUBJECT_DESCRIPTION1"
                    id="SUBJECT_DESCRIPTION1" placeholder="e.g. Introduction to Programming" maxlength="255" required>
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="form-group">
                   <label for="INSTRUCTORID1" class="col-form-label col-form-label-sm">Instructor</label>
                    <select class="form-control form-control-sm" name="INSTRUCTORID1" id="INSTRUCTORID1">
                      <option value="">Select Instructor</option>
                      <?php foreach ($scheduleInstructors as $ins) { ?>
                      <option value="<?php echo $ins->INSTRUCTORID; ?>"><?php echo htmlspecialchars($ins->INSTRUCTOR); ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="form-check ml-2">
                    <input type="checkbox" class="form-check-input" name="STATUS1" id="STATUS1" value="1">
                    <label class="form-check-label" for="STATUS1">Enable this schedule</label>
                  </div>
                </div>

              </div>

            </div>
            <div class="modal-footer justify-content-between">
             <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                 <button type="submit" class="btn btn-primary" name="edit"><i class="fa fa-save"></i> Save changes</button>

            </div>
          </div>
          </form>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
<!-----END of Edit Form---->
