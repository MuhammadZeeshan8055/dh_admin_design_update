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
      
      <title>Dhothar International</title>
      <link rel="stylesheet" href="assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css" id="style-resource-1">
      <link rel="stylesheet" href="assets/css/font-icons/entypo/css/entypo.css" id="style-resource-2">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic" id="style-resource-3">
      <link rel="stylesheet" href="assets/css/bootstrap.css" id="style-resource-4">
      <link rel="stylesheet" href="assets/css/neon-core.css" id="style-resource-5">
      <link rel="stylesheet" href="assets/css/neon-theme.css" id="style-resource-6">
      <link rel="stylesheet" href="assets/css/neon-forms.css" id="style-resource-7">
      <link rel="stylesheet" href="assets/css/custom.css" id="style-resource-8">
      <script src="assets/js/jquery-1.11.3.min.js"></script> 
      <style>
         body{
         font-family: arial;
         background: #b2bec3;
         padding:0;
         margin: 0;
         }
         #main{
         width: 800px;
         margin: 0 auto;
         background: white;
         font-size: 19px;
         }
         #header{
         background: #f7d794;
         }
         h1{
         float: left;
         margin: 15px;
         }
         #search-bar{
         padding: 10px 20px 0;
         float: right;
         }
         #search-bar label{
         font-size: 16px;
         font-weight: bold;
         display: block;
         }
         #search-bar input{
         width: 250px;
         height: 25px;
         font-size: 18px;
         letter-spacing: 0.8px;
         padding: 3px 10px;
         border-radius: 4px;
         border: 1px solid #000;
         }
         #search-bar input:focus{
         outline: 0;
         }
         #table-form{
         background: #55efc4;
         padding: 20px 10px;
         }
         #table-form input[type="text"]{
         width: 180px;
         height: 25px;
         font-size: 18px;
         padding: 3px 10px;
         border-radius: 4px;
         border: 1px solid green;
         }
         #save-button{
         background:#2c3e50;
         color: #fff;
         border:0;
         padding: 8px 30px;
         margin-left: 7px;
         border-radius: 3px;
         cursor: pointer;
         }
         #table-data{
         padding: 15px;
         height: 500px;
         vertical-align: top;
         }
         #table-data th{
         background: #74b9ff;
         }
         #table-data tr:nth-child(odd){
         background: #ecf0f1;
         }
         #success-message{
         background: #DEF1D8;
         color: green;
         padding: 10px;
         margin: 10px;
         display: none;
         position: absolute;
         right: 15px;
         top: 15px;
         }
         #error-message{
         background: #EFDCDD;
         color: red;
         padding: 10px;
         margin: 10px;
         display: none;
         position:absolute;
         right: 15px;
         top: 15px;
         }
         .delete-btn{
         background:#e74c3c;
         color: #fff;
         border:0;
         padding: 4px 10px;
         border-radius: 3px;
         cursor: pointer;
         }
         .edit-btn{
         background: #27ae60;
         color: white;
         border: 0;
         padding: 4px 10px;
         border-radius: 3px;
         cursor: pointer;
         }
         #modal{
         background: rgba(11, 20, 30, 0.72);
         position: fixed;
         left: 0;
         top:0;
         width: 100%;
         height: 100%;
         z-index: 2500;
         display: none;
         overflow-y: auto;
         padding: 14px 0 20px;
         }
         #modal-form.dh-edit-modal {
            background: var(--dh-surface-solid, #fff);
            color: var(--dh-text, #1a2b3c);
            width: calc(100% - 32px);
            max-width: 1580px;
            max-height: calc(100vh - 36px);
            position: relative;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            padding: 0 16px 16px;
            border-radius: 10px;
            border: 1px solid var(--dh-border, rgba(0, 175, 235, .18));
            overflow-x: hidden;
            overflow-y: auto;
            box-shadow: 0 16px 40px rgba(7, 31, 47, 0.38);
         }
         #modal-form h2{
            margin: 0 -16px 12px;
            padding: 14px 48px 14px 16px;
            border-bottom: 0;
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            letter-spacing: 0.01em;
            background: linear-gradient(110deg, #254260 0%, #176e91 54%, #267d98 100%);
         }
         #modal-form input[type = "text"]{
            width: 100%;
         }
         .dh-edit-modal table {
            display: block;
            width: 100%;
         }
         .dh-edit-modal table > tbody,
         .dh-edit-modal table > tbody > tr,
         .dh-edit-modal table > tbody > tr > td {
            display: block;
            width: 100%;
         }
         .dh-edit-modal .row {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 10px 14px;
            align-items: start;
            margin-left: 0 !important;
            margin-right: 0 !important;
            margin-bottom: 8px !important;
         }
         .dh-edit-modal .row:before,
         .dh-edit-modal .row:after {
            display: none !important;
         }
         .dh-edit-modal .row > [class*="col-md-"] {
            float: none;
            width: auto;
            min-width: 0;
            padding-left: 0 !important;
            padding-right: 0 !important;
         }
         .dh-edit-modal .row > .col-md-12 {
            grid-column: 1 / -1;
         }
         .dh-edit-modal .row > .col-md-6 {
            grid-column: span 2;
         }
         .dh-edit-modal .form-group {
            margin-bottom: 4px !important;
         }
         .dh-edit-modal label,
         .dh-edit-modal .control-label {
            display: block;
            margin-bottom: 4px;
            font-size: 12px;
            font-weight: 600;
            line-height: 1.25;
            color: var(--dh-text-muted, #5a6f82);
         }
         .dh-edit-modal .form-control,
         .dh-edit-modal textarea {
            border-radius: 6px !important;
            border: 1px solid var(--dh-border, rgba(0, 175, 235, .22)) !important;
            background: #f7fafc !important;
            box-shadow: none !important;
            min-height: 34px;
            height: 34px;
            padding: 5px 9px !important;
            font-size: 13px;
            line-height: 1.3;
         }
         .dh-edit-modal select.form-control {
            height: 34px;
            padding-top: 3px !important;
            padding-bottom: 3px !important;
         }
         .dh-edit-modal .form-control:focus,
         .dh-edit-modal textarea:focus {
            border-color: #00afeb !important;
            box-shadow: 0 0 0 2px rgba(0, 175, 235, .14) !important;
            outline: 0;
         }
         .dh-edit-modal textarea {
            display: block;
            width: 100%;
            min-height: 64px;
            height: auto;
            resize: vertical;
         }
         .dh-edit-modal br {
            display: none;
         }
         .dh-edit-modal input[type="checkbox"] {
            margin: 2px 6px 6px 0;
            vertical-align: middle;
         }
         .dh-edit-modal #edit-submit {
            min-width: 130px;
            margin-top: 10px;
            padding: 8px 20px;
            border: 0;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            color: #fff;
            background: linear-gradient(135deg, #2f9e6b, #247a54);
            box-shadow: 0 4px 12px rgba(47, 158, 107, 0.22);
            cursor: pointer;
         }
         .dh-edit-modal #edit-submit:hover {
            filter: brightness(1.05);
         }
         #edit-form-body {
            padding: 0;
         }
         #dh-toast {
            display: none;
            position: fixed;
            top: 22px;
            right: 22px;
            z-index: 4000;
            min-width: 260px;
            max-width: 360px;
            padding: 14px 18px;
            border-radius: 12px;
            background: #1f6b4a;
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.22);
         }
         [data-theme="dark"] .dh-edit-modal {
            color: #e8f1f8 !important;
            background: #162434 !important;
            border-color: rgba(86, 201, 246, .22) !important;
            box-shadow: 0 24px 70px rgba(0, 0, 0, .55);
         }
         [data-theme="dark"] .dh-edit-modal label,
         [data-theme="dark"] .dh-edit-modal .control-label {
            color: #c8d8e5 !important;
         }
         [data-theme="dark"] .dh-edit-modal .form-control,
         [data-theme="dark"] .dh-edit-modal textarea {
            color: #e8f1f8 !important;
            background: #101d2a !important;
            border-color: rgba(86, 201, 246, .22) !important;
         }
         [data-theme="dark"] .dh-edit-modal .form-control:focus,
         [data-theme="dark"] .dh-edit-modal textarea:focus {
            border-color: #00afeb !important;
            box-shadow: 0 0 0 3px rgba(0, 175, 235, .14) !important;
            outline: 0;
         }
         [data-theme="dark"] .dh-edit-modal input[readonly] {
            color: #aebfcd !important;
            background: #1b2a38 !important;
         }
         @media (max-width: 1100px) {
            .dh-edit-modal .row {
               grid-template-columns: repeat(2, minmax(0, 1fr));
            }
         }
         @media (max-width: 640px) {
            #modal {
               padding: 6px 0 10px;
            }
            #modal-form.dh-edit-modal {
               width: calc(100% - 12px);
               max-height: calc(100vh - 12px);
               padding: 0 8px 10px;
            }
            #modal-form h2 {
               margin: 0 -8px 8px;
               padding: 10px 40px 10px 10px;
            }
            .dh-edit-modal .row {
               grid-template-columns: 1fr;
               gap: 4px;
            }
         }
         #close-btn{
            background: rgba(255, 255, 255, 0.14);
            color: #fff;
            width: 28px;
            height: 28px;
            line-height: 28px;
            text-align: center;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.22);
            position: absolute;
            top: 8px;
            right: 10px;
            cursor: pointer;
            z-index: 2;
         }
         #close-btn2,
         #close-btn3{
         background: rgba(255, 255, 255, 0.14);
         color: #fff;
         width: 32px;
         height: 32px;
         line-height: 32px;
         text-align: center;
         border-radius: 50%;
         border: 1px solid rgba(255, 255, 255, 0.22);
         position: absolute;
         top: 12px;
         right: 14px;
         cursor: pointer;
         z-index: 2;
         }
         .modal2-form,
         .modal3-form {
            overflow: hidden !important;
            border-radius: 14px !important;
            padding: 0 15px 20px !important;
            box-shadow: 0 18px 48px rgba(7, 31, 47, 0.35) !important;
         }
         .modal2-form h2,
         .modal3-form h2 {
            margin: 0 -15px 18px !important;
            padding: 16px 52px 16px 20px !important;
            border-bottom: 0 !important;
            color: rgba(247, 251, 253, 0.96) !important;
            font-size: 18px !important;
            font-weight: 600 !important;
            background:
               radial-gradient(circle at 92% 14%, rgba(216, 186, 111, .14), transparent 245px),
               linear-gradient(110deg, #254260 0%, #176e91 54%, #267d98 100%) !important;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .10);
         }
         .page-container {
            width: auto;
            display: table;
            height: 100%;
            table-layout: fixed;
         }
         .page-container .sidebar-menu .sidebar-menu-inner {
            position: relative;
            width: 230px;
         }


         #modal2{
         background: rgba(11, 20, 30, 0.72);
         position: fixed;
         left: 0;
         top:0;
         width: 100%;
         height: 100%;
         z-index: 2500;
         display: none;
         }
         #modal2-form {
            background: #fff;
            width: 90%;
            position: relative;
            top: 3%;
            left: calc(50% - 44%);
            padding: 15px;
            border-radius: 4px;
         }
         #modal2-form h2{
         margin: 0 0 15px;
         padding-bottom: 10px;
         border-bottom: 1px solid #000;
         }
         #modal2-form input[type = "text"]{
         width: 100%;
         }


         #modal3{
         background: rgba(11, 20, 30, 0.72);
         position: fixed;
         left: 0;
         top:0;
         width: 100%;
         height: 100%;
         z-index: 2500;
         display: none;
         }
         #modal3-form {
            background: #fff;
            width: 90%;
            position: relative;
            top: 3%;
            left: calc(50% - 44%);
            padding: 15px;
            border-radius: 4px;
         }
         #modal3-form h2{
         margin: 0 0 15px;
         padding-bottom: 10px;
         border-bottom: 1px solid #000;
         }
         #modal3-form input[type = "text"]{
         width: 100%;
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
            <hr/>
            <ol class="breadcrumb bc-3">
               <li> <a href="../../dashboard/main/index.html"><i class="fa-home"></i>Home</a> </li>
               <li> <a href="../main/index.html">Tables</a> </li>
               <li class="active"> <strong>Data Tables</strong> </li>
            </ol>
       
            
            
           
            <h3>New Case Details</h3>
            <p class="text-muted" id="dh-table-loading">Loading records…</p>

            <div id="error-message"></div>
            <div id="success-message"></div>
            <div id="dh-toast"></div>

            <table class="table table-bordered datatable table-3" id="table-4" style="width:100%">
               <thead>
                  <tr>
                     <th>S.no</th>
                     <th>Name</th>
                     <th>Father Name</th>
                     <th>PP No</th>
                     <th>PP Expiry</th>
                     <th>Tracking Id</th>
                     <th>New Case Date</th>
                     <th>Date Of Birth</th>
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
                     <th>Visa Expiry Date</th>
                     <th>Company Name</th>
                     <th>Trade</th>
                     <th>Entered By</th>
                     <th>Updated By</th>
                     <th>Passport Returned Date</th>
                     <th>Status</th>
                     <?php if (($can_update ?? '') === 'on'): ?>
                     <th>Edit</th>
                     <?php endif; ?>
                     <?php if (($can_delete ?? '') === 'on'): ?>
                     <th>Delete</th>
                     <?php endif; ?>
                  </tr>
               </thead>
               <tbody></tbody>
            </table>
            
            <br/>  
            <?php
               include('components/footer.php');
            ?>
         </div>
        
        

      </div>

         <div id="modal">
            <div id="modal-form" class="dh-edit-modal" role="dialog" aria-modal="true" aria-labelledby="dh-edit-modal-title">
               <h2 id="dh-edit-modal-title">Edit New Case Details Form</h2>
               <div id="edit-form-body">Loading...</div>
               <div id="close-btn">X</div>
            </div>
         </div>


         <div id="modal2">
            <div id="modal-form" class="modal2-form" style="background: #fff;
                                                            width: 40%;
                                                            position: relative;
                                                            top: 12%;
                                                            left: calc(50% - 23%);
                                                            padding: 15px;
                                                            border-radius: 4px;">

               <h2>Assign Company</h2>
               <table cellpadding="10px" width="100%">
               </table>
               <div id="close-btn2">X</div>
            </div>
         </div>

         <div id="modal3">
            <div id="modal-form" class="modal3-form" style="background: #fff;
                                                            width: 40%;
                                                            position: relative;
                                                            top: 12%;
                                                            left: calc(50% - 23%);
                                                            padding: 15px;
                                                            border-radius: 4px;">

               <h2>Show Company</h2>
               <table cellpadding="10px" width="100%">
               </table>
               <div id="close-btn3">X</div>
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
      <style>
         #table-4_wrapper .dataTables_processing {
            top: 80px !important;
            margin-top: 0 !important;
            z-index: 2;
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            padding: 10px 18px;
         }
      </style>
<script>
   $(document).ready(function(){
        var casesTable = null;

        function showToast(message) {
            $("#dh-toast").text(message).stop(true, true).fadeIn(200);
            setTimeout(function () {
                $("#dh-toast").fadeOut(400);
            }, 2500);
        }

        // Fast DataTable load (JSON)
        if ($.fn.DataTable) {
            casesTable = $("#table-4").DataTable({
                ajax: {
                    url: "new_cases_data_load.php",
                    dataSrc: "data",
                    cache: false
                },
                deferRender: true,
                pageLength: 25,
                order: [],
                processing: true,
                initComplete: function () {
                    $("#dh-table-loading").hide();
                }
            });
        }

        function reloadTable() {
            if (casesTable) {
                casesTable.ajax.reload(null, false);
            }
        }

        //Delete Records
        $(document).on("click",".delete-btn", function(){
        if(confirm("Do you really want to delete this record ?")){
            var Id = $(this).data("id");
            
            $.ajax({
            url: "request_delete_new_case_details",
            type : "POST",
            data : {id : Id},
            success : function(data){
                if($.trim(data) == 1){
                    reloadTable();
                    showToast("Record deleted");
                }else{
                    $("#error-message").html("Can't Delete Record.").slideDown();
                    $("#success-message").slideUp();
                }
            }
            });
        }
        });

        // Show company modal
         $(document).on("click",".show_company", function(){
            $("#modal3").show();
            var Id = $(this).data("id");

            $.ajax({
               url: "show_company_modal",
               type: "POST",
               data: {id: Id },
               success: function(data) {
                  $(".modal3-form table").html(data);
               }
            })
         });

         // Assign company modal
         $(document).on("click",".assign_company", function(){
            $("#modal2").show();
            var Id = $(this).data("id");

            $.ajax({
               url: "assign_company_modal",
               type: "POST",
               data: {id: Id },
               success: function(data) {
                  $(".modal2-form table").html(data);
               }
            })
         });

         $(document).on("click","#edit-assign-update", function(){
            var id = $("#edit-id").val();
            var company_name = $("#company_name").val();
            var trade = $("#trade").val();
            var e_no = $("#e_no").val();
            var visa_no = $("#visa_no").val();
            var sponsor_id = $("#sponsor_id").val();
            var miscellaneous = $("#miscellaneous").val();

            $.ajax({
               url: "update_assign_company",
               type : "POST",
               data : {id: id, company_name: company_name, trade: trade,e_no: e_no,visa_no: visa_no,sponsor_id: sponsor_id, miscellaneous: miscellaneous},
               success: function(data) {
                  if($.trim(data) == 1){
                     $("#modal3").hide();
                     reloadTable();
                     showToast("Info updated successfully");
                  }
               }
            })
         });

         $(document).on("click","#edit-assign", function(){
            var id = $("#edit-id").val();
            var company_name = $("#company_name").val();
            var trade = $("#trade").val();
            var e_no = $("#e_no").val();
            var visa_no = $("#visa_no").val();
            var sponsor_id = $("#sponsor_id").val();
            var miscellaneous = $("#miscellaneous").val();

            $.ajax({
               url: "assign_company",
               type : "POST",
               data : {id: id, company_name: company_name, trade: trade,e_no: e_no,visa_no: visa_no,sponsor_id: sponsor_id, miscellaneous: miscellaneous},
               success: function(data) {
                  if($.trim(data) == 1){
                     $("#modal2").hide();
                     reloadTable();
                     showToast("Info updated successfully");
                  }
               }
            })
         });

          // Show Edit Modal
         $(document).on("click",".edit-btn", function(){
            $("#modal").show();
            $("#edit-form-body").html("Loading...");
            var Id = $(this).data("eid");

            $.ajax({
            url: "new_case_edit_modal",
            type: "POST",
            data: {id: Id },
            success: function(data) {
               $("#edit-form-body").html(data);
            },
            error: function() {
               $("#edit-form-body").html("Could not load this case.");
            }
            })
         });

         $("#close-btn").on("click",function(){
            $("#modal").hide();
         });

         $("#close-btn2").on("click",function(){
            $("#modal2").hide();
         });

         $("#close-btn3").on("click",function(){
            $("#modal3").hide();
         });

         // Save Update Form (same fields / same URL as before)
         $(document).on("click","#edit-submit", function(){
            var id = $("#edit-id").val();
            var name = $("#name").val();
            var fname = $("#fname").val();
            var pp_no = $("#pp_no").val();
            var pp_expiry = $("#pp_expiry").val();
            var tracking_id = $("#tracking_id").val();
            var new_case_date = $("#new_case_date").val();
            var date_of_birth = $("#date_of_birth").val();
            var client_age = $("#client_age").val();
            var care_of = $("#care_of").val();
            var mobile_no_1 = $("#mobile_no_1").val();
            var mobile_no_2 = $("#mobile_no_2").val();
            var missing_documents = $("#missing_documents").val();
            var docs_missing = $("#docs_missing").val();
            var passport_returned_description = $("#passport_returned_description").val();
            var passport_returned = $("#passport_returned").val();
            var passport_returned_date = $("#passport_returned_date").val();
            var country = $("#country").val();
            var first_character_expiry = $("#first_character_expiry").val();
            var second_character_expiry = $("#second_character_expiry").val();
            var online_submission_date = $("#online_submission_date").val();
            var physical_submission_date = $("#physical_submission_date").val();
            var work_permit_receiving_date = $("#work_permit_receiving_date").val();
            var appointment_date = $("#appointment_date").val();
            var apply_date = $("#apply_date").val();
            var status = $("#status").val();
            var visa_issue_date = $("#visa_issue_date").val() || "";
            var visa_expiry_date = $("#visa_expiry_date").val() || "";
            var company_name = $("#company_name").val();
            var trade = $("#trade").val();
            var miscellaneous = $("#miscellaneous").val();
            var comments = $("#comments").val();
            
            if (status === "Applied") {
               if (!company_name || company_name.trim() === "Select Company") {
                  alert("Company not assigned. Please assign a company to proceed.");
                  return false;
               }
            }

            $.ajax({
               url: "new_case_update_details",
               type : "POST",
               data : {id: id, name: name, fname: fname, pp_no: pp_no, pp_expiry: pp_expiry,tracking_id: tracking_id,new_case_date:new_case_date,date_of_birth:date_of_birth,client_age:client_age,care_of:care_of,mobile_no_1:mobile_no_1,mobile_no_2:mobile_no_2,
                        missing_documents:missing_documents,docs_missing:docs_missing,passport_returned:passport_returned,passport_returned_description:passport_returned_description,passport_returned_date:passport_returned_date,country:country,first_character_expiry:first_character_expiry,second_character_expiry:second_character_expiry,online_submission_date:online_submission_date,physical_submission_date:physical_submission_date,work_permit_receiving_date:work_permit_receiving_date,appointment_date:appointment_date,apply_date:apply_date,status:status,visa_issue_date:visa_issue_date,visa_expiry_date:visa_expiry_date,company_name:company_name,trade:trade,miscellaneous:miscellaneous,comments:comments},
               success: function(data) {
                  data = $.trim(data);
                  if (data == "1") {
                     $("#modal").hide();
                     showToast("Info updated successfully");
                     reloadTable();
                  }
                  else if (data == "PAYMENT_NOT_FOUND") {
                     alert("Advance payment is required before applying this status. Please add the payment to proceed.");
                  }
                  else if(data == "FULL_PAYMENT_RECORD_NOT_FOUND"){
                     alert("Full payment record is required before applying this status. Please add the payment to proceed.");
                  }
                  else {
                     alert("Update failed. Please try again.");
                  }
               }
            })
         });

        $(document).on("change", "#first_character_issue_date", function() {
            var issueDate = new Date($(this).val());
            if (!isNaN(issueDate.getTime())) {
                var expiryDate = new Date(issueDate);
                expiryDate.setDate(expiryDate.getDate() + 180);
                $("#first_character_expiry").val(expiryDate.toISOString().split('T')[0]);
            }
        });
        $(document).on("change", "#second_character_issue_date", function() {
            var issueDate = new Date($(this).val());
            if (!isNaN(issueDate.getTime())) {
                var expiryDate = new Date(issueDate);
                expiryDate.setDate(expiryDate.getDate() + 180);
                $("#second_character_expiry").val(expiryDate.toISOString().split('T')[0]);
            }
        });

   });
</script>
</body>
</html>
