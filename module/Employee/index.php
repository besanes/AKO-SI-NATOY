<?php
require_once("../../include/initialize.php");
// if (!isset($_SESSION['ACCOUNT_ID'])){
//     redirect(web_root."/index.php");
//     }

$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';
$title  = "Employee Module";
$header = $view;

switch ($view) {
	case 'view' :
		$content = 'view.php';
		break;

	default :
		$content = 'list.php';
}
require_once("../../theme/template.php");
?>

<script type="text/javascript">
$(document).ready(function() {

    var statusFilter = 'All';

    var t = $('#tblemployee').DataTable( {
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            url: "<?php echo WEB_ROOT; ?>module/employee/ajax.php",
            type: "POST",
            data: function (d) {
                d.status_filter = statusFilter;
            }
        },
        "columnDefs": [ {
            "searchable": true,
            "orderable": true,
            "targets": 1
        } ],
        "scrollY": "400px",
        "scrollCollapse": true,
        "order": [[ 0, 'asc' ]]
    } );

    /* All / Active / Inactive filter buttons */
    $(document).on('click', '.statusFilterBtn', function () {
        $('.statusFilterBtn').removeClass('active');
        $(this).addClass('active');
        statusFilter = $(this).attr('data-status');
        t.ajax.reload();
    });

    /* Print: just prints the current page - swap for a dedicated
       print-friendly export if a formatted report is needed later. */
    $(document).on('click', '#btnPrintEmployees', function () {
        window.print();
    });
});
</script>

<script type="text/javascript">
/* Populate the Manager dropdown once on load, used by both the Add
   and Edit modals. Whoever is being edited is excluded from their
   own Manager list on the fly (see editEntry handler below). */
function loadManagerOptions(selectEl, excludeId, selectedId) {
    $.ajax({
        url: "<?php echo WEB_ROOT; ?>module/employee/ajax.php",
        method: "POST",
        data: { act: 'get_managers' },
        dataType: "json",
        success: function (data) {
            selectEl.empty().append($('<option>', { value: '', text: '-- None --' }));
            $.each(data, function (i, row) {
                if (excludeId && String(row.EMPLOYEE_ID) === String(excludeId)) { return; }
                var label = row.LNAME + ', ' + row.FNAME;
                var opt = $('<option>', { value: row.EMPLOYEE_ID, text: label });
                if (selectedId && String(row.EMPLOYEE_ID) === String(selectedId)) { opt.prop('selected', true); }
                selectEl.append(opt);
            });
        }
    });
}

$(document).ready(function () {
    loadManagerOptions($('#MANAGER_ID'), null, null);
});

$(document).on('shown.bs.modal', '#AddNewEntry', function () {
    loadManagerOptions($('#MANAGER_ID'), null, null);
});

$(document).on('click', '.editEntry', function () {
    var uid = $(this).attr('UID');
    $.ajax({
        url: "<?php echo WEB_ROOT; ?>module/employee/ajax.php",
        method: "POST",
        data: { UID: uid },
        dataType: "json",
        success: function (data) {
            $('#UID').val(data.EMPLOYEE_ID);
            $('#FNAME1').val(data.FNAME);
            $('#MNAME1').val(data.MNAME);
            $('#LNAME1').val(data.LNAME);
            $('#SUFFIX1').val(data.SUFFIX ? data.SUFFIX : '');
            $('#EMAIL1').val(data.EMAIL);
            $('#JOB_TITLE1').val(data.JOB_TITLE);
            $('#DEPARTMENT1').val(data.DEPARTMENT);
            $('#HIRE_DATE1').val(data.HIRE_DATE ? data.HIRE_DATE : '');
            $('#STATUS1').val(data.STATUS ? data.STATUS : 'Active');

            loadManagerOptions($('#MANAGER_ID1'), data.EMPLOYEE_ID, data.MANAGER_ID);

            $('#editEntry').modal('show');
        },
        error: function () {
            alert('Could not load that employee record.');
        }
    });
});
</script>
