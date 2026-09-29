<?php

// Sched Time module entry point

// Load the system initialization file and database connection.
require_once("../../include/initialize.php");

// Check if the user is logged in.
if (!isset($_SESSION['UID'])) {

  // Redirect the user to the login page if not logged in.
  redirect(WEB_ROOT."login.php");
}

// Set the page title.
$title = "Sched Time Module";

// Set list.php as the main content of the time module.
$content = 'list.php';

// Load the main website template.
require_once("../../theme/template.php");
?>

<script type="text/javascript">
$(document).ready(function () {

  // Create the time DataTable.
  var table = $('#tbltimelist').DataTable({
    processing: true,
    serverSide: true,
    order: [],

    // Get time data from ajax.php.
    ajax: {
      url: "<?php echo WEB_ROOT; ?>module/schedtime/ajax.php",
      type: "POST"
    }
  });


  /* -----------------------------------------------------------
     EDIT
     ----------------------------------------------------------- */

  // Open the edit modal when the Edit button is clicked.
  $(document).on('click', '.editTime', function () {

    // Get the time ID from the clicked button.
    var tid = $(this).attr("TID");

    // Request the time record from the server.
    $.ajax({
      url: "<?php echo WEB_ROOT; ?>module/schedtime/ajax.php",
      method: "POST",

      // Send the request to get one time record.
      data: {
        act: 'row',
        TIME_ID: tid
      },

      // Expect JSON data from the server.
      dataType: "json",

      // Run when the record is received.
      success: function (data) {

        // Fill the edit form with the time information.
        $('#T_ID').val(data.TIME_ID);
        $('#T_TIME').val(data.TIME);

        // Show the edit modal.
        $('#editTimeModal').modal('show');
      },

      // Show an error if the record cannot be loaded.
      error: function () {
        alert('Could not load the time record.');
      }
    });
  });

});
</script>