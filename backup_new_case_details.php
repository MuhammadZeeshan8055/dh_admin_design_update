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
      <meta name="description" content="Neon Admin Panel" />
      <meta name="author" content="Laborator.co" />
      <link rel="icon" href="assets/images/favicon.ico">
      
      <title>Neon | Data Tables</title>
      <link rel="stylesheet" href="assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css" id="style-resource-1">
      <link rel="stylesheet" href="assets/css/font-icons/entypo/css/entypo.css" id="style-resource-2">
      <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic" id="style-resource-3">
      <link rel="stylesheet" href="assets/css/bootstrap.css" id="style-resource-4">
      <link rel="stylesheet" href="assets/css/neon-core.css" id="style-resource-5">
      <link rel="stylesheet" href="assets/css/neon-theme.css" id="style-resource-6">
      <link rel="stylesheet" href="assets/css/neon-forms.css" id="style-resource-7">
      <link rel="stylesheet" href="assets/css/custom.css" id="style-resource-8">
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
            <table class="table table-bordered datatable table-3" id="table-4">
               <thead>
                  <tr>
                    <th>S.no</th>
                    <th>Name</th>
                    <th>Father Name</th>
                    <th>PP No</th>
                    <th>PP Expiry</th>
                    <th>Tracking Id</th>
                    <th>New Case Date</th>
                    <th>Missing Documents</th>
                    <th>Apply Date</th>
                    <th>Entered By</th>
                    <th>Status</th>
                    <th>Action</th>
                     
                  </tr>
               </thead>
               <tbody>

                <?php
                    $i=0;
                    $new_cases=mysqli_query($con,"select name,fname,pp_no,pp_expiry,tracking_id,new_case_id,missing_documents,apply_date,status,entered_by from new_case_details");
                    while($row=mysqli_fetch_assoc($new_cases)){
                    $i++;
                ?>  
                    <tr>
                        <td><?=$i++?></td>
                        <td><?=$row['name'];?></td>
                        <td><?=$row['fname'];?></td>
                        <td><?=$row['pp_no'];?></td>
                        <td><?=$row['pp_expiry'];?></td>
                        <td><?=$row['tracking_id'];?></td>
                        <td><?=$row['new_case_id'];?></td>
                        <td><?=$row['missing_documents'];?></td>
                        <td><?=$row['apply_date'];?></td>
                        <td><?=$row['entered_by'];?></td>
                        <td>
                            <?php
                              if($row['entered_by']=="Applied"){
                            ?>

                                <button class="btn btn-success">Applied</button>

                            <?php
                              }else{
                            ?>
                                <button class="btn btn-success">Applied</button>

                            <?php
                              }
                            ?>
                        </td>
                        <td>
                            <a href="#" class="btn btn-default btn-sm btn-icon icon-left"> <i class="entypo-pencil"></i>
                                Edit    
                            </a>
                            <a href="#" class="btn btn-danger btn-sm btn-icon icon-left"> <i class="entypo-cancel"></i>
                                Delete
                            </a>
                        </td>
                    </tr>
                <?php
                    }
                ?>
               </tbody>
               
            </table>
            <br/>  
            <footer class="main">
               <div class="pull-right"> <a href="https://themeforest.net/item/neon-bootstrap-admin-theme/6434477?ref=Laborator" target="_blank"><strong>Purchase this theme for $25</strong></a> </div>
               &copy; 2024 <strong>Neon</strong> Admin Theme by <a href="https://laborator.co/" target="_blank">Laborator</a> 
            </footer>
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
      <script src="assets/js/neon-chat.js" id="script-resource-10"></script>  
      <script src="assets/js/neon-custom.js" id="script-resource-11"></script>  
      <script src="assets/js/neon-demo.js" id="script-resource-12"></script> 
      <script src="assets/js/neon-skins.js" id="script-resource-13"></script> 
       
   </body>
</html>