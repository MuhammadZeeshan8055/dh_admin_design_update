<?php
    include('database/db_connection.php');
    include('session.php');

    $dateQs = '';
    if (!empty($_GET['date1']) && !empty($_GET['date2'])) {
        $dateQs = '&date1=' . urlencode($_GET['date1']) . '&date2=' . urlencode($_GET['date2']);
    }
?>
<!DOCTYPE html>
<html lang="en">
   <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
   <head>
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1" />
      <meta name="description" content="Dhothar International" />
      <link rel="icon" href="assets/images/favicon.ico">
      <title>Dhothar International | Total Registered Cases</title>
      <link rel="stylesheet" href="assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
      <link rel="stylesheet" href="assets/css/font-icons/entypo/css/entypo.css">
      <link rel="stylesheet" href="assets/css/bootstrap.css">
      <link rel="stylesheet" href="assets/css/neon-core.css">
      <link rel="stylesheet" href="assets/css/custom.css">
      <style>
         /* Keep "Processing..." below thead (column search makes header tall) */
         #table-4_wrapper .dataTables_processing {
            top: 110px !important;
            margin-top: 0 !important;
            z-index: 2;
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            padding: 10px 18px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
         }
      </style>
      <script src="assets/js/jquery-1.11.3.min.js"></script>
   </head>
   <body class="page-body">
      <div class="page-container">
         <div class="sidebar-menu">
            <?php include('components/sidebar.php'); ?>
         </div>
         <div class="main-content">
            <?php include('components/header.php'); ?>
            <hr/>
            <ol class="breadcrumb bc-3">
               <li> <a href="index"><i class="fa-home"></i>Home</a> </li>
               <li class="active"> <strong>Total Registered Cases</strong> </li>
            </ol>

            <h3>Total Registered Cases</h3>
            <p class="text-muted" id="dh-table-loading">Loading records…</p>

            <table class="table table-bordered datatable table-3" id="table-4" style="width:100%">
                <thead>
                    <tr>
                        <th>S.no</th>
                        <th>Name</th>
                        <th>Father Name</th>
                        <th>PP NO</th>
                        <th>PP Expiry</th>
                        <th>Tracking Id</th>
                        <th>New Case Date</th>
                        <th>Date of Birth</th>
                        <th>Age</th>
                        <th>Care Of</th>
                        <th>Mobile No 1</th>
                        <th>Mobile No 2</th>
                        <th>Missing Documents</th>
                        <th>Country</th>
                        <th>Apply Date</th>
                        <th>First Character Expiry</th>
                        <th>Second Character Expiry</th>
                        <th>Online Submission Date</th>
                        <th>Physical Submission Date</th>
                        <th>Work Permit Receiving Date</th>
                        <th>Appointment Date</th>
                        <th>Visa Issue Date</th>
                        <th>Visa Expiry</th>
                        <th>Company Name</th>
                        <th>Trade</th>
                        <th>Miscellaneous</th>
                        <th>Entered By</th>
                        <th>Updated By</th>
                        <th>Approved By</th>
                        <th>Passport Returned Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>

            <?php include('components/footer.php'); ?>
         </div>
      </div>

      <link rel="stylesheet" href="assets/js/datatables/datatables.css">
      <script src="assets/js/gsap/TweenMax.min.js"></script>
      <script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
      <script src="assets/js/bootstrap.js"></script>
      <script src="assets/js/joinable.js"></script>
      <script src="assets/js/resizeable.js"></script>
      <script src="assets/js/neon-api.js"></script>
      <script src="assets/js/cookies.min.js"></script>
      <script src="assets/js/datatables/datatables.js"></script>
      <script src="assets/js/neon-custom.js"></script>

      <script type="text/javascript">
      jQuery(function ($) {
         var $table = $('#table-4');
         if (!$.fn.DataTable || !$table.length) return;

         var table = $table.DataTable({
            ajax: {
               url: 'total_registered_cases_data.php?1=1<?= $dateQs ?>',
               dataSrc: 'data'
            },
            deferRender: true,
            pageLength: 25,
            order: [],
            processing: true,
            dom: 'Bfrtip',
            buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5'],
            initComplete: function () {
               $('#dh-table-loading').hide();

               // In-cell search (same as before)
               this.api().columns().every(function () {
                  var column = this;
                  var $header = $(column.header());
                  if ($header.find('input.dh-col-search').length) return;

                  var title = $header.text().replace(/\s+/g, ' ').trim();
                  $('<input type="text" class="form-control form-control-sm dh-col-search" />')
                     .attr('placeholder', 'Search ' + title)
                     .css({ marginTop: '5px', width: '100%', minWidth: '70px' })
                     .appendTo($header)
                     .on('click mousedown', function (e) { e.stopPropagation(); })
                     .on('keyup', function () {
                        var val = this.value;
                        if (column.search() !== val) {
                           column.search(val).draw();
                        }
                     });
               });
            }
         });
      });
      </script>
   </body>
</html>
