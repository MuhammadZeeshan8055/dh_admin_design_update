<?php
include('database/db_connection.php');
include('session.php');
?>
<!DOCTYPE html>
<html lang="en">
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<!-- /Added by HTTrack -->

<head>
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1" />
   <meta name="description" content="Dhothar International" />
   <meta name="author" content="Laborator.co" />
   <link rel="icon" href="assets/images/favicon.ico">

   <title>Dhothar International </title>
   <link rel="stylesheet" href="assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css" id="style-resource-1">
   <link rel="stylesheet" href="assets/css/font-icons/entypo/css/entypo.css" id="style-resource-2">
   <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic"
      id="style-resource-3">
   <link rel="stylesheet" href="assets/css/bootstrap.css" id="style-resource-4">
   <link rel="stylesheet" href="assets/css/neon-core.css" id="style-resource-5">
   <link rel="stylesheet" href="assets/css/neon-theme.css" id="style-resource-6">
   <link rel="stylesheet" href="assets/css/neon-forms.css" id="style-resource-7">
   <link rel="stylesheet" href="assets/css/custom.css" id="style-resource-8">
   <script src="assets/js/jquery-1.11.3.min.js"></script>
   <!--[if lt IE 9]><script src="https://demo.neontheme.com/assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
   <!--[if lt IE 9]> <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script> <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script> <![endif]-->

   <style>
      .bg-red {
         background-color: #ffdddd;
         animation: background-blink 1s infinite;
         color: white;
      }

      /* Keyframes for blinking effect */
      @keyframes background-blink {
         0% {
            background-color: #ffdddd;
         }

         50% {
            background-color: #ff9999;
         }

         /* darker red */
         100% {
            background-color: #ffdddd;
         }
      }
   </style>

</head>

<body class="page-body">
   <div class="page-container">
      <div class="sidebar-menu">
         <?php include('components/sidebar.php'); ?>
      </div>
      <div class="main-content">
         <?php include('components/header.php'); ?>
         <hr />
         <ol class="breadcrumb bc-3">
            <li> <a href="../../dashboard/main/index.html"><i class="fa-home"></i>Home</a> </li>
            <li> <a href="../main/index.html">Tables</a> </li>
            <li class="active"> <strong>Data Tables</strong> </li>
         </ol>




         <h3>Exporting Table Data</h3>
         <br />
         <script type="text/javascript">
            jQuery(document).ready(function ($) {
               var $table4 = jQuery("#table-4");
               $table4.DataTable({
                  dom: 'Bfrtip',
                  buttons: [
                     'copyHtml5',
                     'excelHtml5',
                     'csvHtml5',
                     'pdfHtml5'
                  ]
               });




            });
         </script>
         <table class="table table-bordered datatable table-3" id="table-4">
            <thead>
               <tr>
                  <th>S.no</th>
                  <th>Name</th>
                  <th>Father Name</th>
                  <th>PP No</th>
                  <th>Tracking Id</th>
                  <th>Care Off</th>
                  <th>Mobile No 1</th>
                  <th>Mobile No 2</th>
                  <th>Country</th>
                  <th>Status</th>
                  <th>Agreed Amount</th>
                  <th>First Payment Amount</th>
                  <th>First Payment Date</th>
                  <th>Second Payment Amount</th>
                  <th>Second Payment Date</th>
                  <th>Final Payment Amount</th>
                  <th>Final Payment Date</th>

               </tr>
            </thead>
            <tbody>
               <?php
               $i = 0;

               $name = trim($_POST['name']);
               $fname = trim($_POST['fname']);
               $pp_no = trim($_POST['pp_no']);
               $tracking_id = trim($_POST['tracking_id']);
               $care_of = trim($_POST['care_of']);
               $status = trim($_POST['status']);
               $receiving_dates = trim($_POST['receiving_dates']);
               $daterange = trim($_POST['daterange']);

               list($range_date1, $range_date2) = array_map('trim', explode('-', $daterange));

               $startDate = DateTime::createFromFormat('m/d/Y', $range_date1)->format('Y-m-d');
               $endDate = DateTime::createFromFormat('m/d/Y', $range_date2)->format('Y-m-d');

               // Start base query
               $sql = "SELECT nc.name, nc.fname, nc.pp_no, nc.tracking_id, nc.care_of, nc.mobile_no_1,
                              nc.mobile_no_2, nc.country, nc.status, 
                              p.agreed_amount, p.first_payment, p.first_payment_date,
                              p.second_payment, p.second_payment_date,
                              p.final_payment, p.final_payment_date
                     FROM new_case_details AS nc
                     JOIN payments AS p ON nc.id = p.emp_id
                     WHERE nc.country = '{$_SESSION['country']}'";

               // Add filters dynamically
               if ($name !== '') {
                  $sql .= " AND nc.name LIKE '%" . mysqli_real_escape_string($con, $name) . "%'";
               }
               if ($fname !== '') {
                  $sql .= " AND nc.fname LIKE '%" . mysqli_real_escape_string($con, $fname) . "%'";
               }
               if ($pp_no !== '') {
                  $sql .= " AND nc.pp_no LIKE '%" . mysqli_real_escape_string($con, $pp_no) . "%'";
               }
               if ($tracking_id !== '') {
                  $sql .= " AND nc.tracking_id LIKE '%" . mysqli_real_escape_string($con, $tracking_id) . "%'";
               }
               if ($care_of !== '') {
                  $sql .= " AND nc.care_of LIKE '%" . mysqli_real_escape_string($con, $care_of) . "%'";
               }
               if ($status !== '' && $status != 'Select Status') {
                  $sql .= " AND nc.status LIKE '%" . mysqli_real_escape_string($con, $status) . "%'";
               }

               if ($receiving_dates !== '') {
                  $sql .= " AND nc.$receiving_dates BETWEEN '" . mysqli_real_escape_string($con, $startDate) . "'
                            AND '" . mysqli_real_escape_string($con, $endDate) . "'";
               }

               // Execute query
               $payment = mysqli_query($con, $sql);

               while ($row = mysqli_fetch_assoc($payment)) {
                  $i++;

                  ?>
                  <tr>
                     <td><?= $i; ?></td>
                     <td><?= $row['name']; ?></td>
                     <td><?= $row['fname']; ?></td>
                     <td><?= $row['pp_no']; ?></td>
                     <td><?= $row['tracking_id']; ?></td>
                     <td><?= $row['care_of']; ?></td>
                     <td><?= $row['mobile_no_1']; ?></td>
                     <td><?= $row['mobile_no_2']; ?></td>
                     <td><?= $row['country']; ?></td>
                     <td><?= $row['status']; ?></td>
                     <td><?= $row['agreed_amount']; ?></td>
                     <td class="<?= empty($row['first_payment']) ? 'bg-red' : '' ?>">
                        <?= !empty($row['first_payment']) ? $row['first_payment'] : 'First Payment Pending Kindly Update' ?>
                     </td>
                     <td><?= $row['first_payment_date']; ?></td>
                     <td class="<?=
                        (empty($row['second_payment']) &&
                           $row['status'] !== 'Applied' &&
                           $row['status'] !== 'Ready To Apply')
                        ? 'bg-red'
                        : ''
                        ?>">
                        <?php
                        if (
                           empty($row['second_payment']) &&
                           $row['status'] !== 'Applied' &&
                           $row['status'] !== 'Ready To Apply'
                        ) {
                           echo 'Second Payment Pending Kindly Update';
                        }
                        ?>
                     </td>

                     <td><?= $row['second_payment_date']; ?></td>

                     <td class="<?=
                        (empty($row['final_payment']) &&
                           $row['status'] == 'Visa Issued')
                        ? 'bg-red'
                        : ''
                        ?>">
                        <?php
                        if (
                           empty($row['final_payment']) &&
                           $row['status'] == 'Visa Issued'
                        ) {
                           echo 'Final Payment Pending Kindly Update';
                        }
                        ?>
                     </td>
                     <td><?= $row['final_payment_date']; ?></td>
                  </tr>
                  <?php
               }
               ?>
            </tbody>

         </table>
         <br />
         <?php
         include('components/footer.php');
         ?>
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
</body>

</html>