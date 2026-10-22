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
               <li class="active"> <strong>Search</strong> </li>
            </ol>
       
            
            
           
            <h3>
                <?php
                    
                     $name=trim($_POST['name']);
                     $fname=trim($_POST['fname']);
                     $pp_no=trim($_POST['pp_no']);
                     $tracking_id=trim($_POST['tracking_id']);
                     $care_of=trim($_POST['care_of']);
                     
                     $receiving_dates = trim($_POST['receiving_dates']);
                     $daterange = trim($_POST['daterange']);
        
                     list($range_date1, $range_date2) = array_map('trim', explode('-', $daterange));
        
                     $startDate = DateTime::createFromFormat('m/d/Y', $range_date1)->format('Y-m-d');
                     $endDate = DateTime::createFromFormat('m/d/Y', $range_date2)->format('Y-m-d');
                     
                    if(!empty($_POST['name'])){
                        echo 'Showing Data With Name of <b>'.$name.'</b>';
                     
                     }elseif(!empty($_POST['name'])){
                         echo 'Showing Data With Father Name of <b>'.$fname.'</b>';
                     
                     }elseif(!empty($_POST['name'])){
                          echo 'Showing Data With Reference Passport No <b>'.$pp_no.'</b>';
                     
                     }elseif(!empty($_POST['name'])){
                         echo 'Showing Data With Reference Passport No <b>'.$pp_no.'</b>';
                     
                     }elseif(!empty($care_of)){
                          echo 'Showing Data With Reference Care Of <b>'.$care_of.'</b>';
                     
                     }
                
                ?>
            </h3>
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
                     <th>Tracking Id</th>
                     <th>PP NO</th>
                     <th>Mobile No 1</th>
                     
                     <th>Care Of</th>
                     <th>Company Name</th>
                     <th>Trade</th>
                     <th>Status</th>
                     
                  </tr>
               </thead>
               <tbody>
                  <?php
                        $i=0;
                    
                     
                        $fields = "nc.name, nc.fname, nc.tracking_id, nc.pp_no, nc.mobile_no_1, nc.care_of, nc.trade, nc.status, company_info.company_name,company_info.trade";
                        $where  = "";
                        
                        if (!empty($name)) {
                            $where = "nc.name LIKE '$name%'";
                        } elseif (!empty($fname)) {
                            $where = "nc.fname LIKE '$fname%'";
                        } elseif (!empty($pp_no)) {
                            $where = "nc.pp_no LIKE '$pp_no%'";
                        } elseif (!empty($tracking_id)) {
                            $where = "nc.tracking_id LIKE '$tracking_id%'";
                        } elseif (!empty($care_of)) {
                            $where = "nc.care_of LIKE '$care_of%'";
                        } elseif ($receiving_dates !== '') {
                            $where = "nc.$receiving_dates BETWEEN '$startDate' AND '$endDate' AND nc.country = 'Romania'";
                        }
                        
                        $sql  = "SELECT $fields FROM new_case_details as nc left join company_info on nc.id = company_info.emp_id WHERE $where";
                        $data = mysqli_query($con, $sql);
                        
                        while ($row = mysqli_fetch_assoc($data)) {
                        $i++;
                        
                        $payments=mysqli_fetch_assoc(mysqli_query($con,"select * from payments where emp_id='$row[id]'"));
                  ?>
                  <tr>
                     <td><?=$i;?></td>
                     <td><?=$row['name'];?></td>
                     <td><?=$row['fname'];?></td>
                     <td><?=$row['tracking_id'];?></td>
                     <td><?=$row['pp_no'];?></td>
                     <td><?=$row['mobile_no_1'];?></td>
                     <td><?=$row['care_of'];?></td>
                     <td><?=$row['company_name'];?></td>
                     <td><?=$row['trade'];?></td>
                     <td><?=$row['status'];?></td>
                     
                    
                     
                  </tr>
                  <?php
                     }
                  ?>
                  
                
               </tbody>
               
            </table>
            <br/>  
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