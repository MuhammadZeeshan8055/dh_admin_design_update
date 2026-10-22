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
                     <th>PP NO</th>
                     <th>PP Expiry</th>
                     <th>Tracking Id</th>
                     <th>Care Of</th>
                     <th>Agreed Amount</th>
                     <th>First Payment</th>
                     <th>First Payment Date</th>
                     <th>First Payment Description</th>
                     <th>Second Payment</th>
                     <th>Second Payment Date</th>
                     <th>Second Payment Description</th>
                     <th>Final Payment </th>
                     <th>Final Payment Date</th>
                     <th>Final Payment Description</th>
                     <th>Remaining Amount</th>
                     
                     
                     
                  </tr>
               </thead>
               <tbody>
                  <?php
                     $i=0;

                     $payment=mysqli_query($con,"select * from payments");

                     while($payments=mysqli_fetch_assoc($payment)){
                        $i++;
                     
                     $row=mysqli_fetch_assoc(mysqli_query($con,"select * from new_case_details where id='$payments[emp_id]' and country='$_SESSION[country]'"));

                  ?>
                  <tr>
                     <td><?=$i;?></td>
                     <td><?=$row['name'];?></td>
                     <td><?=$row['fname'];?></td>
                     <td><?=$row['pp_no'];?></td>
                     <td><?=$row['pp_expiry'];?></td>
                     <td><?=$row['tracking_id'];?></td>
                     <td><?=$row['care_of'];?></td>
                     <td><?=$payments['agreed_amount'];?>/euro</td>
                     <td class="<?= empty($payments['first_payment']) ? 'bg-red' : '' ?>">
                        <?= !empty($payments['first_payment']) ? $payments['first_payment'] : 'First Payment Pending Kindly Update' ?>
                     </td>
                     <td><?= $payments['first_payment_date']; ?></td>
                     <td><?= $payments['first_payment_description']; ?></td>
                     <td class="<?=
                        (empty($payments['second_payment']) &&
                           $row['status'] !== 'Applied' &&
                           $row['status'] !== 'Ready To Apply' &&
                           $row['status'] !== 'Returned')
                        ? 'bg-red'
                        : ''
                        ?>">
                        <?php
                        if (
                           empty($payments['second_payment']) &&
                           $row['status'] !== 'Applied' &&
                           $row['status'] !== 'Ready To Apply' &&
                           $row['status'] !== 'Returned'
                        ) {
                           echo 'Second Payment Pending Kindly Update';
                        }
                        ?>
                     </td>

                     <td><?= $payments['second_payment_date']; ?> </td>
                     <td><?= $payments['second_payment_description']; ?></td>
                     <td class="<?=
                        (empty($payments['final_payment']) &&
                           $row['status'] == 'Visa Issued')
                        ? 'bg-red'
                        : ''
                        ?>">
                        <?php
                        if (
                           empty($payments['final_payment']) &&
                           $row['status'] == 'Visa Issued'
                        ) {
                           echo 'Final Payment Pending Kindly Update';
                        }
                        ?>
                     </td>
                     <td><?= $payments['final_payment_date']; ?></td>
                     <td><?= $payments['final_payment_description']; ?></td>

                     

                           <?php
                              $remaining_amount=0;

                              if(!empty($payments['first_payment'])){

                                 $first_payment=$payments['first_payment'];

                              }else{
                                 $first_payment=0;

                              }

                              if(!empty($payments['second_payment'])){

                                 $second_payment=$payments['second_payment'];

                              }else{
                                 $second_payment=0;

                              }
                              
                              
                              if(!empty($payments['final_payment'])){

                                 $final_payment=$payments['final_payment'];
                                 
                              }else{

                                 $final_payment=0;

                              }


                              $remaining_amount=$payments['agreed_amount']-$first_payment-$second_payment-$final_payment;
                           
                              if($remaining_amount > '200'){
                              
                                 echo '<td style="color:white;background:red !important">';
                              }else{
                                 echo '<td style="background:green !important">';

                              }
                           ?>

                           

                     
                        <?php
                           $remaining_amount=0;

                           if(!empty($payments['first_payment'])){

                              $first_payment=$payments['first_payment'];

                           }else{
                              $first_payment=0;

                           }

                           if(!empty($payments['second_payment'])){

                              $second_payment=$payments['second_payment'];

                           }else{
                              $second_payment=0;

                           }
                           
                           
                           if(!empty($payments['final_payment'])){

                              $final_payment=$payments['final_payment'];
                              
                           }else{

                              $final_payment=0;

                           }


                           $remaining_amount=$payments['agreed_amount']-$first_payment-$second_payment-$final_payment;
                           echo $remaining_amount.'/euro';
                        ?>
                     </td>
                    

                     
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