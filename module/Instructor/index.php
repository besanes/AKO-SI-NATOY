<?php

// Instructor module entry point

// Load the system initialization file and database connection.
require_once("../../include/initialize.php");

// Check if the user is logged in.
if (!isset($_SESSION['UID'])) {

  // Redirect the user to the login page if not logged in.
  redirect(WEB_ROOT."login.php");
}

// Set the page title.
$title = "Instructor Module";

// Set list.php as the main content of the instructor module.
$content = 'list.php';

// Load the main website template.
require_once("../../theme/template.php");
?>

<script type="text/javascript">
$(document).ready(function () {

  // Create the instructor DataTable.
  var table = $('#tblinstructorlist').DataTable({
    processing: true,
    serverSide: true,
    order: [],

    // Get instructor data from ajax.php (relative path - ajax.php
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
  $('#addInstructorModal').on('show.bs.modal', function () {
    $('#ADD_I_NAME').val('');
    $('#ADD_I_STATUS').val('1');
  });


  /* -----------------------------------------------------------
     EDIT
     ----------------------------------------------------------- */

  // Open the edit instructor modal when the Edit button is clicked.
  $(document).on('click', '.editInstructor', function () {

    // Get the instructor ID from the clicked button.
    var iid = $(this).attr("IID");

    // Request the instructor record from the server.
    $.ajax({
      url: "ajax.php",
      method: "POST",

      // Send the request to get one instructor record.
      data: {
        act: 'row',
        INSTRUCTORID: iid
      },

      // Expect JSON data from the server.
      dataType: "json",

      // Run when the instructor data is received.
      success: function (data) {

        // Fill the edit form with the instructor information.
        $('#EDIT_I_ID').val(data.INSTRUCTORID);
        $('#EDIT_I_NAME').val(data.INSTRUCTOR);
        $('#EDIT_I_STATUS').val(String(data.STATUS));

        // Show the edit instructor modal.
        $('#editInstructorModal').modal('show');
      },

      // Show an error if the instructor record cannot be loaded.
      error: function () {
        alert('Could not load the instructor record.');
      }
    });
  });

});
</script>
