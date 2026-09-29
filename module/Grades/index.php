<?php
require_once("../../include/initialize.php");
// if (!isset($_SESSION['ACCOUNT_ID'])){
//     redirect(web_root."/index.php");
//     }

$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';
$title  = "Grades Module";
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
    var t = $('#tblgrades').DataTable( {
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            url: "<?php echo WEB_ROOT; ?>module/grades/ajax.php",
            type: "POST"
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
});
</script>

<script type="text/javascript">
/* ---------------------------------------------------------------
   "Grade" button: loads the subjects for that enrollment (based on
   its COURSE_ID / YEAR_LEVEL / SEMESTER) together with any grade
   already encoded in tblgrades, and renders one editable row per
   subject inside the Grade Sheet modal.
   --------------------------------------------------------------- */
$(document).on('click', '.gradeEntry', function () {
    var enrollmentId = $(this).attr('data-enrollment');

    $('#GS_ENROLLMENT_ID').val(enrollmentId);
    $('#GS_ROWS').empty();
    $('#GS_STUDENT_TEXT').text('Loading...');
    $('#GS_SUBJECT_ERROR').addClass('d-none');

    $.ajax({
        url: "<?php echo WEB_ROOT; ?>module/grades/ajax.php",
        method: "POST",
        data: { act: 'get_subjects', ENROLLMENT_ID: enrollmentId },
        dataType: "json",
        success: function (data) {

            $('#GS_STUDENT_TEXT').text(
                (data.IDNO ? data.IDNO : '-') + ' \u2014 ' + (data.FULLNAME ? data.FULLNAME : '-')
            );
            $('#GS_META_TEXT').text(
                (data.COURSE_CODE ? data.COURSE_CODE : '-') + ' / ' +
                (data.YEAR_LEVEL ? data.YEAR_LEVEL : '-') + ' / ' +
                (data.SEMESTER ? data.SEMESTER : '-') + ' / ' +
                (data.SCHOOL_YEAR ? data.SCHOOL_YEAR : '-')
            );

            if (!data.subjects || data.subjects.length === 0) {
                $('#GS_SUBJECT_ERROR').removeClass('d-none')
                    .text('No subjects are set up yet for this course / year level / semester.');
                $('#gradeSheetEntry').modal('show');
                return;
            }

            $.each(data.subjects, function (i, row) {
                var tr = $('<tr>');
                tr.append($('<td>').text(row.SUBJECT_CODE));
                tr.append($('<td>').text(row.SUBJECT_NAME));
                tr.append($('<td>').text(row.UNITS));

                var gradeInput = $('<input>', {
                    type: 'number', step: '0.01', min: '1', max: '5',
                    class: 'form-control form-control-sm gs-grade',
                    name: 'GRADE[]', value: row.GRADE ? row.GRADE : ''
                });
                tr.append($('<td>').append(gradeInput));

                var remarksSelect = $('<select>', { class: 'form-control form-control-sm gs-remarks', name: 'REMARKS[]' });
                ['', 'Passed', 'Failed', 'INC', 'Dropped'].forEach(function (opt) {
                    var o = $('<option>', { value: opt, text: opt === '' ? '-- select --' : opt });
                    if (row.REMARKS === opt) { o.prop('selected', true); }
                    remarksSelect.append(o);
                });
                tr.append($('<td>').append(remarksSelect));

                tr.append($('<input>', { type: 'hidden', name: 'SUBJECT_ID[]', value: row.SUBJECT_ID }));

                $('#GS_ROWS').append(tr);
            });

            $('#gradeSheetEntry').modal('show');
        },
        error: function () {
            alert('Could not load the subjects for this enrollment.');
        }
    });
});

/* Auto-fill remarks from the grade when the clerk types a number:
   1.00 - 3.00 => Passed, 5.00 => Failed. The clerk can still override it. */
$(document).on('input', '.gs-grade', function () {
    var val = parseFloat($(this).val());
    var select = $(this).closest('tr').find('.gs-remarks');
    if (isNaN(val) || select.val() !== '') { return; }
    if (val >= 1 && val <= 3) { select.val('Passed'); }
    else if (val === 5) { select.val('Failed'); }
});

$(document).on('submit', '#gradeSheetForm', function (e) {
    e.preventDefault();
    var btn = $('#GS_SAVE_BTN').prop('disabled', true).text('Saving...');

    $.ajax({
        url: "<?php echo WEB_ROOT; ?>module/grades/ajax.php",
        method: "POST",
        data: $(this).serialize() + '&act=save_grades',
        dataType: "json",
        success: function (resp) {
            btn.prop('disabled', false).text('Save Grades');
            if (resp.success) {
                $('#gradeSheetEntry').modal('hide');
                $('#tblgrades').DataTable().ajax.reload(null, false);
            } else {
                alert(resp.message ? resp.message : 'The grades could not be saved.');
            }
        },
        error: function () {
            btn.prop('disabled', false).text('Save Grades');
            alert('The grades could not be saved.');
        }
    });
});
</script>
