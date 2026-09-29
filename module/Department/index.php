<?php

// Department module entry point

// Load the system initialization file and database connection.
require_once("../../include/initialize.php");

// Check if the user is logged in.
if (!isset($_SESSION['UID'])) {

  // Redirect the user to the login page if not logged in.
  redirect(WEB_ROOT."login.php");
}

// Set the page title.
$title = "Department Module";

// Set list.php as the main content of the department module.
$content = 'list.php';

// Load the main website template.
require_once("../../theme/template.php");
?>

<script type="text/javascript">
$(document).ready(function () {

  // Create the department DataTable.
  var table = $('#tbldepartmentlist').DataTable({
    processing: true,
    serverSide: true,
    order: [],

    // Get department data from ajax.php (relative path - ajax.php
    // lives in this same folder, so this works regardless of what
    // the module folder is actually named/capitalized on the server).
    ajax: {
      url: "ajax.php",
      type: "POST"
    }
  });


  /* -----------------------------------------------------------
     ADD
     Reset the Add form every time the modal is opened, so leftover
     text from a previous add doesn't carry over.
     ----------------------------------------------------------- */
  $('#addDepartmentModal').on('show.bs.modal', function () {
    $('#ADD_D_NAME').val('');
    $('#ADD_D_DESCRIPTION').val('');
  });


  /* -----------------------------------------------------------
     EDIT
     ----------------------------------------------------------- */

  // Open the edit department modal when the Edit button is clicked.
  $(document).on('click', '.editDepartment', function () {

    // Get the department ID from the clicked button.
    var did = $(this).attr("DID");

    // Request the department record from the server.
    $.ajax({
      url: "ajax.php",
      method: "POST",

      // Send the request to get one department record.
      data: {
        act: 'row',
        DEPARTMENTID: did
      },

      // Expect JSON data from the server.
      dataType: "json",

      // Run when the department data is received.
      success: function (data) {

        // Fill the edit form with the department information.
        $('#EDIT_D_ID').val(data.DEPARTMENTID);
        $('#EDIT_D_NAME').val(data.NAME);
        $('#EDIT_D_DESCRIPTION').val(data.DESCRIPTION);

        // Show the edit department modal.
        $('#editDepartmentModal').modal('show');
      },

      // Show an error if the department record cannot be loaded.
      error: function () {
        alert('Could not load the department record.');
      }
    });
  });

});
</script>