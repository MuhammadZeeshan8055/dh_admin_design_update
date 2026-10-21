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
         padding: 24px 0 40px;
         }
         #modal-form {
            background: #fff;
            width: 90%;
            position: relative;
            top: 0;
            left: calc(50% - 45%);
            padding: 0 15px 20px;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 18px 48px rgba(7, 31, 47, 0.35);
         }
         #modal-form h2{
         margin: 0 -15px 18px;
         padding: 16px 52px 16px 20px;
         border-bottom: 0;
         color: rgba(247, 251, 253, 0.96);
         font-size: 18px;
         font-weight: 600;
         letter-spacing: 0.01em;
         background:
            radial-gradient(circle at 92% 14%, rgba(216, 186, 111, .14), transparent 245px),
            linear-gradient(110deg, #254260 0%, #176e91 54%, #267d98 100%);
         box-shadow: inset 0 1px 0 rgba(255, 255, 255, .10);
         }
         #modal-form input[type = "text"]{
         width: 100%;
         }
         #close-btn{
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
            <br/> 

            <div id="error-message"></div>
            <div id="success-message"></div>
            <div id="search-bar">
               <label>Search :</label>
               <input type="search" id="search" class="form-control mb-4" autocomplete="off">
            </div>
            <br>
            <table class="table table-bordered datatable table" id="table-4">
            </table>
            
            <br/>  
            <?php
               include('components/footer.php');
            ?>
         </div>
        
        

      </div>

         <div id="modal">
            <div id="modal-form">
               <h2>Edit New Case Details Form</h2>
               <table cellpadding="10px" width="100%">
               </table>
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
      <script src="assets/js/gsap/TweenMax.min.js" id="script-resource-1"></> 
      <script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js" id="script-resource-2"></script> 
      <script src="assets/js/bootstrap.js" id="script-resource-3"></script> 
      <script src="assets/js/joinable.js" id="script-resource-4"></script> 
      <script src="assets/js/resizeable.js" id="script-resource-5"></script> 
      <script src="assets/js/neon-api.js" id="script-resource-6"></script> 
      <script src="assets/js/cookies.min.js" id="script-resource-7"></script> 
      <script src="assets/js/datatables/datatables.js" id="script-resource-8"></script> 
      <script src="assets/js/select2/select2.min.js" id="script-resource-9"></script> 
      <script src="assets/js/neon-chat.js" id="script-resource-10"></script>  
      <script src="assets/js/neon-custom.js" id="script-resource-11"></script>  
      <script src="assets/js/neon-demo.js" id="script-resource-12"></script> 
      <script src="assets/js/neon-skins.js" id="script-resource-13"></script> 
       
   <script type="text/javascript" src="js/jquery.js"></script>

   </body>
   
 <style>
     .loader {
        text-align: center;
        padding: 20px;
        font-size: 18px;
    }
    
    .loader::after {
        content: "";
        display: inline-block;
        width: 30px;
        height: 30px;
        border: 4px solid #3498db;
        border-top-color: transparent;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }
    
    @keyframes spin {
        100% { transform: rotate(360deg); }
    }

 </style>

<script>
   $(document).ready(function(){
        // Load Table Records
        function loadTable() {
            $(".table").html('<div class="loader">Loading Data...</div>'); // Show loader before AJAX call
        
            $.ajax({
                url: "new_cases_data_load",
                type: "POST",
                success: function (data) {
                    $(".table").html(data); // Replace loader with table data
                },
                error: function () {
                    $(".table").html("<p>Error loading data.</p>"); // Handle errors
                }
            });
        }
        
        // Load Table Records on Page Load
        loadTable();



        //Delete Records
        $(document).on("click",".delete-btn", function(){
        if(confirm("Do you really want to delete this record ?")){
            var Id = $(this).data("id");
            var element = this;
            
            $.ajax({
            url: "request_delete_new_case_details",
            type : "POST",
            data : {id : Id},
            success : function(data){
                if(data == 1){
                    $(element).closest("tr").fadeOut();
                    loadTable(); // Load Table Records on Page Load
                }else{
                    $("#error-message").html("Can't Delete Record.").slideDown();
                    $("#success-message").slideUp();
                }
            }
            });
        }
        });


        //show company assign modal box
         
         $(document).on("click","#show_company", function(){
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




         //Assign Show Modal Box
         $(document).on("click","#assign_company", function(){
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
                  if(data == 1){
                     $("#modal3").hide();
                     loadTable();
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
                  if(data == 1){
                     $("#modal2").hide();
                     loadTable();
                  }
               }
            })
         });



          //Show Modal Box
         $(document).on("click",".edit-btn", function(){
            $("#modal").show();
            var Id = $(this).data("eid");

            $.ajax({
            url: "new_case_edit_modal",
            type: "POST",
            data: {id: Id },
            success: function(data) {
               $("#modal-form table").html(data);
            }
            })
         });


         //Hide Modal Box
         $("#close-btn").on("click",function(){
            $("#modal").hide();
         });

         //Hide Modal Box
         $("#close-btn2").on("click",function(){
            $("#modal2").hide();
         });

         //Hide Modal Box
         $("#close-btn3").on("click",function(){
            $("#modal3").hide();
         });

         //Save Update Form
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
            var visa_issue_date = $("#visa_issue_date").val();
            var visa_expiry_date = $("#visa_expiry_date").val();
            var company_name = $("#company_name").val();
            var trade = $("#trade").val();
            var miscellaneous = $("#miscellaneous").val();
            
            if (status === "Applied") {
               if (!company_name || company_name.trim() === "Select Company") {
                  alert("Company not assigned. Please assign a company to proceed.");
                  return false;
               }
            }
            
            //comments
            var comments = $("#comments").val();
            
            // alert(passport_returned_date);

            $.ajax({
               url: "new_case_update_details",
               type : "POST",
               data : {id: id, name: name, fname: fname, pp_no: pp_no, pp_expiry: pp_expiry,tracking_id: tracking_id,new_case_date:new_case_date,date_of_birth:date_of_birth,client_age:client_age,care_of:care_of,mobile_no_1:mobile_no_1,mobile_no_2:mobile_no_2,
                        missing_documents:missing_documents,docs_missing:docs_missing,passport_returned:passport_returned,passport_returned_description:passport_returned_description,passport_returned_date:passport_returned_date,country:country,first_character_expiry:first_character_expiry,second_character_expiry:second_character_expiry,online_submission_date:online_submission_date,physical_submission_date:physical_submission_date,work_permit_receiving_date:work_permit_receiving_date,appointment_date:appointment_date,apply_date:apply_date,status:status,visa_issue_date:visa_issue_date,visa_expiry_date:visa_expiry_date,company_name:company_name,trade:trade,miscellaneous:miscellaneous,comments:comments},
               success: function(data) {
                  if (data == 1) {
                     $("#modal").hide();
                     loadTable();
                  }
                  else if (data == "PAYMENT_NOT_FOUND") {
                     alert("Advance payment is required before applying this status. Please add the payment to proceed.");
                  }
                  else if(data == "FULL_PAYMENT_RECORD_NOT_FOUND"){
                     alert("Full payment record is required before applying this status. Please add the payment to proceed.");
                  }
               }
            })
         });


         // Live Search
         $("#search").on("keyup",function(){
            var search_term = $(this).val();

              
            $.ajax({
               url: "new_case_search",
               type: "POST",
               data : {search:search_term },
               success: function(data) {
               $(".table").html(data);
               }
            });
         });
         // Auto-fill expiry date when character_issue_date is selected
        $(document).on("change", "#first_character_issue_date", function() {
            var issueDate = new Date($(this).val());
            if (!isNaN(issueDate.getTime())) {
                // Add 180 days to the issue date
                var expiryDate = new Date(issueDate);
                expiryDate.setDate(expiryDate.getDate() + 180);
    
                // Format the date as YYYY-MM-DD
                var formattedExpiryDate = expiryDate.toISOString().split('T')[0];
    
                // Set the expiry date to the first_character_expiry and second_character_expiry fields
                $("#first_character_expiry").val(formattedExpiryDate);
            }
        });
        $(document).on("change", "#second_character_issue_date", function() {
            var issueDate = new Date($(this).val());
            if (!isNaN(issueDate.getTime())) {
                // Add 180 days to the issue date
                var expiryDate = new Date(issueDate);
                expiryDate.setDate(expiryDate.getDate() + 180);
    
                // Format the date as YYYY-MM-DD
                var formattedExpiryDate = expiryDate.toISOString().split('T')[0];
    
                // Set the expiry date to the first_character_expiry and second_character_expiry fields
                $("#second_character_expiry").val(formattedExpiryDate);
            }
        });

   });
</script>


</html>