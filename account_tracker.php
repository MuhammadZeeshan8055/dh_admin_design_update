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

   <title>Dhothar International | Forms</title>
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

   <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
   <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
   <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
   <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

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
            <li class="active"> <strong>Account Tracker</strong> </li>
         </ol>
         <h2>Account Tracker By Search</h2>
         <br />

         <div class="row">
            <div class="col-md-12">
               <div class="panel panel-primary" data-collapsed="0">
                  <div class="panel-heading">
                     <div class="panel-title">
                        Search Fields
                     </div>
                  </div>
                  <div class="panel-body">
                     <div class="row">
                        <form id="searchForm" action="account_tracker_search" method="post">

                           <div class="col-md-6">
                              <label class="col-sm-3 control-label">Name </label>
                              <input type="text" name="name" class="form-control" placeholder="Enter Name">
                           </div>
                           <div class="col-md-6">
                              <label class="col-sm-3 control-label">Father Name </label>
                              <input type="text" name="fname" class="form-control" placeholder="Enter Father Name">
                           </div>
                           <div class="clear"></div>
                           <br />
                           <div class="col-md-6">
                              <label class="col-sm-3 control-label">PP NO </label>
                              <input type="text" name="pp_no" class="form-control" placeholder="Enter PP NO">
                           </div>

                           <div class="col-md-6">
                              <label class="col-sm-3 control-label">PP Expiry </label>
                              <input type="date" name="pp_expiry" class="form-control" placeholder="Enter PP Expiry">
                           </div>

                           <div class="clear"></div>
                           <br />

                           <div class="col-md-6">
                              <label class="col-sm-3 control-label">Tracking Id </label>
                              <input type="text" name="tracking_id" pattern="\d{4}"
                                 title="Please enter exactly 4 digits" class="form-control"
                                 placeholder="Enter Name Tracking ID">
                           </div>

                           <div class="clear"></div>
                           <br />

                           <div class="col-md-6">
                              <label class="col-sm-3 control-label">Care Of </label>
                              <input type="text" name="care_of" class="form-control" placeholder="Enter Reference">
                           </div>

                           <div class="col-md-6">
                              <label class="col-sm-3 control-label">Status</label>
                              <select name="status" id="" class="form-control">
                                 <option>Select Status</option>
                                 <option value='Work Permit Issued'>Work Permit Issued</option>
                                 <option value='Appointment Applied'>Appointment Applied</option>
                                 <option value='Visa Issued'>Visa Issued</option>
                                 <option value='Fly'>Fly</option>
                                 <option value='Returned'>Returned</option>
                              </select>
                           </div>

                           <div class="clear"></div>
                           <br />

                           <div class="col-md-6">
                              <label class="col-sm-3 control-label">Receiving Dates</label>
                              <select name="receiving_dates" id="received_dates" class="form-control">
                                 <option>Select Status</option>
                                 <option value='work_permit_receiving_date'>Work Permit Receiving Date</option>
                                 <option value='appointment_date'>Appointment Applied Date</option>
                                 <option value='apply_date'>Apply Date</option>
                              </select>
                           </div>

                           <div class="col-md-6" id="daterange">
                              <label class="col-sm-3 control-label">Date Range </label>
                              <input type="text" name="daterange" class="form-control" />
                           </div>
                           <style>
                              #daterange {
                                 display: none
                              }
                           </style>
                           <div class="clear"></div>
                           <br />

                           <div class="col-md-12 text-center">
                              <button type="submit" name="new_case_entry" class="btn btn-success">Search</button>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <?php
         include('components/footer.php');
         ?>
      </div>



   </div>
   <script src="assets/js/gsap/TweenMax.min.js" id="script-resource-1"></script>
   <script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js" id="script-resource-2"></script>
   <script src="assets/js/bootstrap.js" id="script-resource-3"></script>
   <script src="assets/js/joinable.js" id="script-resource-4"></script>
   <script src="assets/js/resizeable.js" id="script-resource-5"></script>
   <script src="assets/js/neon-api.js" id="script-resource-6"></script>
   <script src="assets/js/cookies.min.js" id="script-resource-7"></script>
   <script src="assets/js/bootstrap-switch.min.js" id="script-resource-8"></script>
   <script src="assets/js/neon-chat.js" id="script-resource-9"></script>
   <script src="assets/js/neon-custom.js" id="script-resource-10"></script>
   <script src="assets/js/neon-demo.js" id="script-resource-11"></script>
   <script src="assets/js/neon-skins.js" id="script-resource-12"></script>

</body>

</html>

<script>

   const form = document.querySelector('#searchForm'); // select by id

   form.addEventListener('submit', function (e) {
      const fields = [
         'name',
         'fname',
         'pp_no',
         'pp_expiry',
         'tracking_id',
         'care_of',
         'status',
         'receiving_dates'
      ];

      // Check if at least one field has a value
      let hasValue = false;
      for (let i = 0; i < fields.length; i++) {
         const el = document.getElementsByName(fields[i])[0];

         if (el) {
            // For select, ignore default option
            if ((el.tagName === 'SELECT' && el.value !== '' && el.value !== 'Select Status') ||
               (el.tagName !== 'SELECT' && el.value.trim() !== '')) {
               hasValue = true;
               break;
            }
         }
      }

      if (!hasValue) {
         e.preventDefault(); // stop form submission
         alert('Please fill at least one field to search!');
      }
   });


   const received_dates = document.querySelector('#received_dates');
   const daterange = document.querySelector('#daterange');

   received_dates.addEventListener('change', () => {
      daterange.style.display = 'block';
   });

</script>

<script>
   $(function () {
      const startOfMonth = moment().startOf('month');
      const endOfMonth = moment().endOf('month');

      $('input[name="daterange"]').daterangepicker({
         startDate: startOfMonth,
         endDate: endOfMonth,
         opens: 'left',
         drops: 'up'
      }, function (start, end) {
         console.log(
            "Selected range: " +
            start.format('YYYY-MM-DD') +
            " to " +
            end.format('YYYY-MM-DD')
         );
      });
   });


</script>