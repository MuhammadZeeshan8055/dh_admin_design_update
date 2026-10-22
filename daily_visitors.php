<?php
include('database/db_connection.php');
include('session.php');
include('attendance_system/database.php');
?>
<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Dhothar International" />
    <meta name="author" content="Laborator.co" />
    <link rel="icon" href="assets/images/favicon.ico">

    <title>Daily Visitors - Dhothar International</title>
    <link rel="stylesheet" href="assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css" id="style-resource-1">
    <link rel="stylesheet" href="assets/css/font-icons/entypo/css/entypo.css" id="style-resource-2">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic" id="style-resource-3">
    <link rel="stylesheet" href="assets/css/bootstrap.css" id="style-resource-4">
    <link rel="stylesheet" href="assets/css/neon-core.css" id="style-resource-5">
    <link rel="stylesheet" href="assets/css/neon-theme.css" id="style-resource-6">
    <link rel="stylesheet" href="assets/css/neon-forms.css" id="style-resource-7">
    <link rel="stylesheet" href="assets/css/custom.css" id="style-resource-8">
    <script src="assets/js/jquery-1.11.3.min.js"></script>
    <style>
        .visitor-form-row {
            display: flex;
            flex-wrap: nowrap;
            align-items: flex-end;
            gap: 10px;
            margin-bottom: 10px;
        }
        .visitor-form-row .form-field {
            flex: 1;
            min-width: 0;
        }
        .visitor-form-row .form-field label {
            display: block;
            margin-bottom: 4px;
            font-weight: 600;
            font-size: 12px;
            white-space: nowrap;
        }
        .visitor-form-row .form-field-btn {
            flex: 0 0 auto;
        }
        .prev-visit-box {
            display: none;
            margin: 10px 0 15px;
            border: 1px solid #f0ad4e;
            background: #fcf8e3;
            border-radius: 4px;
            padding: 12px 15px;
        }
        .prev-visit-box .prev-title {
            font-weight: 700;
            color: #8a6d3b;
            margin-bottom: 8px;
        }
        .prev-visit-box table {
            margin-bottom: 0;
            background: #fff;
        }
        .prev-visit-box .table > thead > tr > th,
        .prev-visit-box .table > tbody > tr > td {
            padding: 6px 8px;
            font-size: 12px;
        }
        /* REVERT_POINT: today_visitor_count_start */
        .page-title-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 5px;
        }
        .page-title-row h3 {
            margin: 0;
        }
        .today-stats {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .today-visitor-count {
            display: inline-block;
            padding: 8px 14px;
            background: #303641;
            color: #fff;
            border-radius: 4px;
            font-size: 14px;
            white-space: nowrap;
        }
        .today-visitor-count.done {
            background: #00a651;
        }
        .today-visitor-count.pending {
            background: #f0ad4e;
            color: #333;
        }
        .today-visitor-count strong {
            font-size: 18px;
            margin-left: 4px;
        }
        /* REVERT_POINT: today_visitor_count_end */
    </style>
</head>

<body class="page-body">
    <div class="page-container">
        <div class="sidebar-menu">
            <?php include('components/sidebar.php'); ?>
        </div>
        <div class="main-content">
            <ol class="breadcrumb bc-3">
                <li><a href="index"><i class="fa-home"></i>Home</a></li>
                <li class="active"><strong>Daily Visitors</strong></li>
            </ol>

            <!-- REVERT_POINT: today_visitor_count_start -->
            <div class="page-title-row">
                <h3>Daily Visitors</h3>
                <div class="today-stats">
                    <div class="today-visitor-count">
                        Today: <strong id="today_visitor_count">0</strong>
                    </div>
                    <div class="today-visitor-count done">
                        Meeting Done: <strong id="today_done_count">0</strong>
                    </div>
                    <div class="today-visitor-count pending">
                        In Meeting: <strong id="today_pending_count">0</strong>
                    </div>
                </div>
            </div>
            <!-- REVERT_POINT: today_visitor_count_end -->
            <hr />

            <div id="visitor_msg" class="text-center" style="display:none; margin-bottom:15px;"></div>

            <!--<form id="daily_visitor_form">-->
            <!--    <div class="visitor-form-row">-->
            <!--        <div class="form-field">-->
            <!--            <label for="name">Name <span style="color:red">*</span></label>-->
            <!--            <input type="text" name="name" id="name" class="form-control input-sm" required placeholder="Full name">-->
            <!--        </div>-->
            <!--        <div class="form-field">-->
            <!--            <label for="contact_no">Contact No <span style="color:red">*</span></label>-->
            <!--            <input type="text" name="contact_no" id="contact_no" class="form-control input-sm" required placeholder="Phone number">-->
            <!--        </div>-->
            <!--        <div class="form-field">-->
            <!--            <label for="purpose_of_visit">Purpose <span style="color:red">*</span></label>-->
            <!--            <input type="text" name="purpose_of_visit" id="purpose_of_visit" class="form-control input-sm" required placeholder="Purpose of visit">-->
            <!--        </div>-->
            <!--        <div class="form-field">-->
            <!--            <label for="visitor">Meeting With <span style="color:red">*</span></label>-->
            <!--            <input type="text" name="visitor" id="visitor" class="form-control input-sm" required placeholder="Meeting with">-->
            <!--        </div>-->
            <!--        <div class="form-field-btn">-->
            <!--            <button type="submit" class="btn btn-primary btn-sm" id="save_visitor_btn">Save</button>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</form>-->
            
            <form id="daily_visitor_form">
                <input type="hidden" name="id" id="visitor_id" value="">
                <div class="visitor-form-row">
                    <div class="form-field">
                        <label for="name">Name <span style="color:red">*</span></label>
                        <input type="text" name="name" id="name" class="form-control input-sm" required placeholder="Full name">
                    </div>
                    <div class="form-field">
                        <label for="contact_no">Contact No <span style="color:red">*</span></label>
                        <input type="text" name="contact_no" id="contact_no" class="form-control input-sm" required placeholder="Phone number">
                    </div>
                    <div class="form-field">
                        <label for="purpose_of_visit">Purpose <span style="color:red">*</span></label>
                        <input type="text" name="purpose_of_visit" id="purpose_of_visit" class="form-control input-sm" required placeholder="Purpose of visit">
                    </div>
                    <div class="form-field">
                        <label for="visitor">Meeting With <span style="color:red">*</span></label>
                        <input type="text" name="visitor" id="visitor" class="form-control input-sm" required placeholder="Meeting with">
                    </div>
                    <div class="form-field-btn">
                        <button type="submit" class="btn btn-primary btn-sm" id="save_visitor_btn">Save</button>
                        <button type="button" class="btn btn-default btn-sm" id="cancel_edit_btn" style="display:none;">Cancel</button>
                    </div>
                </div>
            </form>

            <div id="prev_visit_box" class="prev-visit-box">
                <div class="prev-title" id="prev_visit_title">Previous visits found</div>
                <div class="table-responsive">
                    <table class="table table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Purpose</th>
                                <th>Visitor</th>
                                <th>Visit Done</th>
                                <th>Date / Time</th>
                            </tr>
                        </thead>
                        <tbody id="prev_visit_tbody"></tbody>
                    </table>
                </div>
            </div>
            <div class="row" style="margin-bottom:15px;">
                <div class="col-md-3">
                    <label for="filter_date">Date</label>
                    <input type="date" id="filter_date" class="form-control" value="<?= date('Y-m-d') ?>">
                </div>
            </div>

            <table class="table table-bordered datatable table-3" id="table-4">
                <thead>
                    <tr>
                        <th>S.no</th>
                        <th>Name</th>
                        <th>Contact No</th>
                        <th>Purpose of Visit</th>
                        <th>Meeting With</th>
                        <th>Visit Done</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="daily_visitors_tbody">
                </tbody>
            </table>

            <?php include('components/footer.php'); ?>
        </div>
    </div>

    <link rel="stylesheet" href="assets/js/datatables/datatables.css" id="style-resource-1">
    <link rel="stylesheet" href="assets/js/select2/select2-bootstrap.css" id="style-resource-2">
    <link rel="stylesheet" href="assets/js/select2/select2.css" id="style-resource-3">
    <script src="assets/js/gsap/TweenMax.min.js" id="script-resource-1"></script>
    <script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js" id="script-resource-2"></script>
    <script src="assets/js/bootstrap.js" id="script-resource-3"></script>
    <script src="assets/js/joinable.js" id="script-resource-4"></script>
    <script src="assets/js/resizeable.js" id="script-resource-5"></script>
    <script src="assets/js/neon-api.js" id="script-resource-6"></script>
    <script src="assets/js/cookies.min.js" id="script-resource-7"></script>
    <script src="assets/js/datatables/datatables.js" id="script-resource-8"></script>
    <script src="assets/js/select2/select2.min.js" id="script-resource-9"></script>
    <script src="assets/js/neon-custom.js" id="script-resource-11"></script>

    <script>
        var lookupTimer = null;
        var visitorsTable = null;
        var isEditMode = false;
        
        function showMsg(message, success) {
            var $msg = $('#visitor_msg');
            $msg.removeClass('text-success text-danger')
                .addClass(success ? 'text-success' : 'text-danger')
                .html('<strong>' + message + '</strong>')
                .show();
            setTimeout(function() {
                $msg.fadeOut();
            }, 3000);
        }
        
        function formatDisplayDate(datetime) {
            if (!datetime) return '';
            var d = new Date(datetime.replace(/-/g, '/'));
            if (isNaN(d.getTime())) return datetime;
            var months = ['January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'];
            return d.getDate() + ' ' + months[d.getMonth()] + ' ' + d.getFullYear();
        }
        
        function formatDisplayTime(datetime) {
            if (!datetime) return '';
            var parts = datetime.split(' ');
            if (parts.length < 2) return '';
            var t = parts[1].split(':');
            var h = parseInt(t[0], 10);
            var m = t[1];
            var ampm = h >= 12 ? 'PM' : 'AM';
            h = h % 12;
            h = h ? h : 12;
            return (h < 10 ? '0' + h : h) + ':' + m + ' ' + ampm;
        }
        
        function destroyVisitorsTable() {
            if ($.fn.DataTable.isDataTable('#table-4')) {
                $('#table-4').DataTable().clear().destroy();
            }
        }
        
        function initVisitorsTable() {
            visitorsTable = jQuery('#table-4').DataTable({
                dom: 'Bfrtip',
                buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5'],
                order: [],
                language: { emptyTable: 'No visitors found for this date.' }
            });
        }
        
        function hidePrevVisits() {
            $('#prev_visit_box').hide();
            $('#prev_visit_tbody').empty();
        }
        
        function showPrevVisits(data, count) {
            var rows = '';
            $.each(data, function(i, row) {
                var done = (row.status == 1 || row.status == '1') ? 'Yes' : 'No';
                rows += '<tr>' +
                    '<td>' + (i + 1) + '</td>' +
                    '<td>' + (row.name || '') + '</td>' +
                    '<td>' + (row.purpose_of_visit || '') + '</td>' +
                    '<td>' + (row.visitor || '') + '</td>' +
                    '<td>' + done + '</td>' +
                    '<td>' + formatDisplayDate(row.created_at) + ' ' + formatDisplayTime(row.created_at) + '</td>' +
                    '</tr>';
            });
        
            $('#prev_visit_title').text('Returning visitor — ' + count + ' previous visit(s) found');
            $('#prev_visit_tbody').html(rows);
            $('#prev_visit_box').show();
        
            if (!isEditMode && !$('#name').val() && data[0] && data[0].name) {
                $('#name').val(data[0].name);
            }
        }
        
        function lookupPrevVisits() {
            var contact = $.trim($('#contact_no').val());
            if (contact.length < 5) {
                hidePrevVisits();
                return;
            }
        
            $.ajax({
                url: 'daily_visitors_ajax',
                type: 'POST',
                dataType: 'json',
                data: { action: 'lookup', contact_no: contact },
                success: function(res) {
                    if (res.status == 1 && res.found == 1 && res.data.length > 0) {
                        showPrevVisits(res.data, res.count);
                    } else {
                        hidePrevVisits();
                    }
                },
                error: function() {
                    hidePrevVisits();
                }
            });
        }
        
        function resetVisitorForm() {
            isEditMode = false;
            $('#visitor_id').val('');
            $('#daily_visitor_form')[0].reset();
            $('#save_visitor_btn').text('Save');
            $('#cancel_edit_btn').hide();
            hidePrevVisits();
        }
        
        function enterEditMode(row) {
            isEditMode = true;
            $('#visitor_id').val(row.id);
            $('#name').val(row.name || '');
            $('#contact_no').val(row.contact_no || '');
            $('#purpose_of_visit').val(row.purpose_of_visit || '');
            $('#visitor').val(row.visitor || '');
            $('#save_visitor_btn').text('Update');
            $('#cancel_edit_btn').show();
            hidePrevVisits();
            $('html, body').animate({ scrollTop: $('#daily_visitor_form').offset().top - 80 }, 300);
            $('#name').focus();
        }
        
        function loadVisitors() {
            var date = $('#filter_date').val();

            // Remember page + search before refresh (so they stay the same)
            var currentPage = 0;
            var currentSearch = '';
            if ($.fn.DataTable.isDataTable('#table-4')) {
                var oldTable = $('#table-4').DataTable();
                currentPage = oldTable.page();
                currentSearch = oldTable.search();
            }

            $.ajax({
                url: 'daily_visitors_ajax',
                type: 'POST',
                dataType: 'json',
                data: { action: 'fetch', date: date },
                success: function(res) {
                    destroyVisitorsTable();
        
                    if (typeof res.today_count !== 'undefined') {
                        $('#today_visitor_count').text(res.today_count);
                        $('#today_done_count').text(res.today_done_count || 0);
                        $('#today_pending_count').text(res.today_pending_count || 0);
                    }
        
                    var rows = '';
                    if (res.status == 1 && res.data && res.data.length > 0) {
                        $.each(res.data, function(i, row) {
                            var checked = (row.status == 1 || row.status == '1') ? 'checked' : '';
                            var payload = encodeURIComponent(JSON.stringify({
                                id: row.id,
                                name: row.name || '',
                                contact_no: row.contact_no || '',
                                purpose_of_visit: row.purpose_of_visit || '',
                                visitor: row.visitor || ''
                            }));
                            rows += '<tr>' +
                                '<td>' + (i + 1) + '</td>' +
                                '<td>' + (row.name || '') + '</td>' +
                                '<td>' + (row.contact_no || '') + '</td>' +
                                '<td>' + (row.purpose_of_visit || '') + '</td>' +
                                '<td>' + (row.visitor || '') + '</td>' +
                                '<td class="text-center">' +
                                '<input type="checkbox" class="visit-done-toggle" data-id="' + row.id + '" ' + checked + '>' +
                                '</td>' +
                                '<td>' + formatDisplayDate(row.created_at) + '</td>' +
                                '<td>' + formatDisplayTime(row.created_at) + '</td>' +
                                '<td class="text-center">' +
                                '<button type="button" class="btn btn-info btn-xs edit-visitor-btn" data-row="' + payload + '">Edit</button>' +
                                '</td>' +
                                '</tr>';
                        });
                    }
                    $('#daily_visitors_tbody').html(rows);
                    initVisitorsTable();

                    // Restore search first, then page
                    if (visitorsTable) {
                        if (currentSearch) {
                            visitorsTable.search(currentSearch).draw(false);
                        }
                        var totalPages = visitorsTable.page.info().pages;
                        if (currentPage >= totalPages) {
                            currentPage = totalPages > 0 ? totalPages - 1 : 0;
                        }
                        if (currentPage > 0) {
                            visitorsTable.page(currentPage).draw(false);
                        }
                    }
                },
                error: function() {
                    destroyVisitorsTable();
                    $('#daily_visitors_tbody').html('');
                    initVisitorsTable();
                    showMsg('Failed to load records.', false);
                }
            });
        }
        
        $(document).ready(function() {
            loadVisitors();
        
            $('#filter_date').on('change', function() {
                loadVisitors();
            });
        
            $('#contact_no').on('keyup blur', function() {
                clearTimeout(lookupTimer);
                lookupTimer = setTimeout(lookupPrevVisits, 400);
            });
        
            $('#cancel_edit_btn').on('click', function() {
                resetVisitorForm();
            });
        
            $(document).on('click', '.edit-visitor-btn', function() {
                var row = JSON.parse(decodeURIComponent($(this).attr('data-row')));
                enterEditMode(row);
            });
        
            $('#daily_visitor_form').on('submit', function(e) {
                e.preventDefault();
        
                var $btn = $('#save_visitor_btn');
                var editing = isEditMode && $('#visitor_id').val();
                $btn.prop('disabled', true).text(editing ? 'Updating...' : 'Saving...');
        
                var payload = {
                    action: editing ? 'update' : 'create',
                    name: $('#name').val(),
                    contact_no: $('#contact_no').val(),
                    purpose_of_visit: $('#purpose_of_visit').val(),
                    visitor: $('#visitor').val(),
                    visit_done: 0
                };
        
                if (editing) {
                    payload.id = $('#visitor_id').val();
                }
        
                $.ajax({
                    url: 'daily_visitors_ajax',
                    type: 'POST',
                    dataType: 'json',
                    data: payload,
                    success: function(res) {
                        showMsg(res.message, res.status == 1);
                        if (res.status == 1) {
                            resetVisitorForm();
                            loadVisitors();
                        }
                    },
                    error: function() {
                        showMsg('Something went wrong.', false);
                    },
                    complete: function() {
                        $btn.prop('disabled', false).text(isEditMode ? 'Update' : 'Save');
                    }
                });
            });
        
            $(document).on('change', '.visit-done-toggle', function() {
                var $cb = $(this);
                var id = $cb.data('id');
                var visit_done = $cb.is(':checked') ? 1 : 0;
        
                $.ajax({
                    url: 'daily_visitors_ajax',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'toggle_visit_done',
                        id: id,
                        visit_done: visit_done
                    },
                    success: function(res) {
                        if (res.status != 1) {
                            $cb.prop('checked', !visit_done);
                            showMsg(res.message || 'Update failed.', false);
                        } else if (typeof res.today_count !== 'undefined') {
                            $('#today_visitor_count').text(res.today_count);
                            $('#today_done_count').text(res.today_done_count || 0);
                            $('#today_pending_count').text(res.today_pending_count || 0);
                        }
                    },
                    error: function() {
                        $cb.prop('checked', !visit_done);
                        showMsg('Failed to update visit status.', false);
                    }
                });
            });
        });
        
        setInterval(function () {
            loadVisitors();
        }, 5000);
        </script>
</body>

</html>
