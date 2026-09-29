<?php

// Classrooms module entry point

// Load the system initialization file and database connection.
require_once("../../include/initialize.php");

// Check if the user is logged in.
if (!isset($_SESSION['UID'])) {

  // Redirect the user to the login page if not logged in.
  redirect(WEB_ROOT."login.php");
}

// Set the page title.
$title = "Classrooms Module";

// Set list.php as the main content of the classrooms module.
$content = 'list.php';

// Load the main website template.
require_once("../../theme/template.php");
?>

<script type="text/javascript">
$(document).ready(function () {

  // Create the classrooms DataTable.
  var table = $('#tblclassroomslist').DataTable({
    processing: true,
    serverSide: true,
    order: [],

    // Get classroom data from ajax.php.
    ajax: {
      url: "<?php echo WEB_ROOT; ?>module/Classrooms/ajax.php",
      type: "POST"
    }
  });


  /* -----------------------------------------------------------
     EDIT
     ----------------------------------------------------------- */

  // Open the edit modal when the Edit button is clicked.
  $(document).on('click', '.editClassroom', function () {

    // Get the classroom ID from the clicked button.
    var cid = $(this).attr("CID");

    // Request the classroom record from the server.
    $.ajax({
      url: "<?php echo WEB_ROOT; ?>module/Classrooms/ajax.php",
      method: "POST",

      // Send the request to get one classroom record.
      data: {
        act: 'row',
        CLASSROOMID: cid
      },

      // Expect JSON data from the server.
      dataType: "json",

      // Run when the record is received.
      success: function (data) {

        // Fill the edit form with the classroom information.
        $('#C_ID').val(data.CLASSROOMID);
        $('#C_NAME').val(data.NAME);
        $('#C_DESC').val(data.DESCRIPTION);

        // Show the edit modal.
        $('#editClassroomModal').modal('show');
      },

      // Show an error if the record cannot be loaded.
      error: function () {
        alert('Could not load the classroom record.');
      }
    });
  });

});
</script>