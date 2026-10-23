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
      <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic" id="style-resource-3">
      <link rel="stylesheet" href="assets/css/bootstrap.css" id="style-resource-4">
      <link rel="stylesheet" href="assets/css/neon-core.css" id="style-resource-5">
      <link rel="stylesheet" href="assets/css/neon-theme.css" id="style-resource-6">
      <link rel="stylesheet" href="assets/css/neon-forms.css" id="style-resource-7">
      <link rel="stylesheet" href="assets/css/custom.css" id="style-resource-8">
      <script src="assets/js/jquery-1.11.3.min.js"></script> <!--[if lt IE 9]><script src="https://demo.neontheme.com/assets/js/ie8-responsive-file-warning.js"></script><![endif]-->  <!--[if lt IE 9]> <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script> <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script> <![endif]-->  
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
       
            
            
           
            <h3>Exporting Table Data</h3>
            <br/> <script type="text/javascript">
               jQuery( document ).ready( function( $ ) {
               var $table4 = jQuery( "#table-4" );
               $table4.DataTable( {
               dom: 'Bfrtip',
               buttons: [
               'copyHtml5',
               'excelHtml5',
               'csvHtml5',
               'pdfHtml5'
               ]
               } );


              

               } );
            </script> 
            
            <table class="table table-bordered datatable table" id="table-4">
            </table>

            <table class="table table-bordered datatable table2" id="table-4">
            </table>
            
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
<script type="text/javascript" src="js/jquery.js"></script>

    <script>
    $(document).ready(function(){
        // Load Table Records
        function loadTable(){
        $.ajax({
                url : "load_notificaions",
                type : "POST",
                success : function(data){
                $(".table").html(data);
                }
        });
        }
        loadTable(); // Load Table Records on Page Load


      

        //Approved Notification
        $(document).on("click",".edit-yes", function(){
        if(confirm("Do you really want to Update this record ?")){
            var Id = $(this).data("eid");
            var status = $(this).data("status");
            var element = this;
            $.ajax({
            url: "update_notifications",
            type : "POST",
            data : {id : Id,status:status},
            success : function(data){
                window.location.href = "deduction_on_return.php?id=<?=$_SESSION['id']?>";
            }
            });
        }
        });

         //Approved Notification
         $(document).on("click",".edit-no", function(){
        if(confirm("Do you really want to Update this record ?")){
            var Id = $(this).data("eid");
            var status = $(this).data("status");
            var element = this;
            $.ajax({
            url: "update_notifications",
            type : "POST",
            data : {id : Id,status:status},
            success : function(data){
                loadTable();
            }
            });
        }
        });



          function loadTable(){
        $.ajax({
                url : "pettycash_load_notificaions",
                type : "POST",
                success : function(data){
                $(".table2").html(data);
                }
        });
        }
        loadTable(); // Load Table Records on Page Load


         //Approved Notification
         $(document).on("click",".entry-yes", function(){
        if(confirm("Do you really want to Approved this Petty Cash Entry ?")){
            var Id = $(this).data("eid");
            var status = $(this).data("status");
            var element = this;

            
            $.ajax({
            url: "petty_cash_update_notifications",
            type : "POST",
            data : {id : Id,status:status},
            success : function(data){
                loadTable();
            }
            });
        }
        });

        //Not Approved Notification
        $(document).on("click",".entry-no", function(){
        if(confirm("Do you really want to Approved this Petty Cash Entry ?")){
            var Id = $(this).data("eid");
            var status = $(this).data("status");
            var element = this;

            
            $.ajax({
            url: "petty_cash_update_notifications",
            type : "POST",
            data : {id : Id,status:status},
            success : function(data){
                loadTable();
            }
            });
        }
        });

    });
    </script>
   </body>
</html>