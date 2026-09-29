<?php
require_once("../../include/initialize.php");
// if (!isset($_SESSION['ACCOUNT_ID'])){
  //    redirect(web_root."/index.php");
//     }

$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';
$title  = "Set Schedule Module";
$header = $view;
switch ($view) {
	case 'list':
		$content = 'list.php';
		break;

	default:
		$content = 'list.php';
}
require_once ("../../theme/template.php");
?>

<script type="text/javascript">
        $(document).ready(function() {
            var t = $('#tblsetschedule').DataTable( {
            "processing":true,
            "serverSide":true,
            "order":[],
            "ajax":{
              url:"<?php echo WEB_ROOT; ?>module/setschedule/ajax.php",
              type:"POST"
            },
                "columnDefs": [ {
                    "searchable": true,
                    "orderable": true,
                    "targets": 1
                } ],
                //vertical scroll
                 "scrollY":        "400px",
                "scrollCollapse": true,
                "scrollX": true,
                //ordering start at column 2
               "order": [[ 2, 'asc' ]]
            } );

            // TEMPORARY DEBUG HOOK: if ajax.php's safety net caught an
            // error and returned it in the "error" field, show it in
            // an alert so it's easy to read without opening DevTools.
            // Safe to remove once everything is confirmed working.
            t.on('xhr.dt', function (e, settings, json) {
                if (json && json.error) {
                    alert('Set Schedule data error:\n\n' + json.error);
                }
            });

                t.on( 'order.dt search.dt', function () {
                t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();

        });
    </script>

<script type="text/javascript">
  $(document).on('click', '.editEntry', function(){
    var uid = $(this).attr("UID");
    $.ajax({
      url:"<?php echo WEB_ROOT; ?>module/setschedule/ajax.php",
      method:"POST",
      data:{UID:uid},
      dataType:"json",
      success:function(data)
      {
       $('#UID').val(data.UID);
       $('#ROOM1').val(data.ROOM);
       $('#DAY1').val(data.DAY);
       $('#TIME1').val(data.TIME);
       $('#AY1').val(data.AY);
       $('#SEMESTER1').val(data.SEMESTER);
       $('#YEAR_LEVEL1').val(data.YEAR_LEVEL);
       $('#SECTION1').val(data.SECTION);
       $('#CODE1').val(data.CODE);
       $('#SUBJECT_DESCRIPTION1').val(data.SUBJECT_DESCRIPTION);
       $('#UNITS1').val(data.UNITS);
       $('#INSTRUCTORID1').val(data.INSTRUCTORID ? data.INSTRUCTORID : '');
       $('#STATUS1').prop('checked', data.STATUS == 1);

       $('#editEntry').modal('show');
      },
      error:function()
      {
        alert('Could not load the schedule record.');
      }
    })
  });
</script>
