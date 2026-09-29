<?php

// Sched Day module entry point

// Load the system initialization file and database connection.
require_once("../../include/initialize.php");

// Check if the user is logged in.
if (!isset($_SESSION['UID'])) {

  // Redirect the user to the login page if not logged in.
  redirect(WEB_ROOT."login.php");
}

// Set the page title.
$title = "Sched Day Module";

// Set list.php as the main content of the day module.
$content = 'list.php';

// Load the main website template.
require_once("../../theme/template.php");
?>

<script type="text/javascript">
$(document).ready(function () {

  // Create the day DataTable.
  var table = $('#tbldaylist').DataTable({
    processing: true,
    serverSide: true,
    order: [],

    // Get day data from ajax.php.
    ajax: {
      url: "<?php echo WEB_ROOT; ?>module/scheduleday/ajax.php",
      type: "POST"
    }
  });


  /* -----------------------------------------------------------
     EDIT
     ----------------------------------------------------------- */

  // Open the edit modal when the Edit button is clicked.
  $(document).on('click', '.editDay', function () {

    // Get the day ID from the clicked button.
    var did = $(this).attr("DID");

    // Request the day record from the server.
    $.ajax({
      url: "<?php echo WEB_ROOT; ?>module/scheduleday/ajax.php",
      method: "POST",

      // Send the request to get one day record.
      data: {
        act: 'row',
        DAY_ID: did
      },

      // Expect JSON data from the server.
      dataType: "json",

      // Run when the record is received.
      success: function (data) {

        // Fill the edit form with the day information.
        $('#D_ID').val(data.DAY_ID);
        $('#D_DAY').val(data.DAY);

        // Show the edit modal.
        $('#editDayModal').modal('show');
      },

      // Show an error if the record cannot be loaded.
      error: function () {
        alert('Could not load the day record.');
      }
    });
  });

});
</script>