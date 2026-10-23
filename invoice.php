<?php
    include('database/db_connection.php');
    include('session.php');
        
        
    if(isset($_GET['id'])){
       $id=$_GET['id'];
       
       $payment_details=mysqli_fetch_assoc(mysqli_query($con,"select * from payments where emp_id='$id'"));
       $client_details=mysqli_fetch_assoc(mysqli_query($con,"select * from new_case_details where id='$id'"));
       
       $sub_total = (float)$payment_details['first_payment'] 
           + (float)$payment_details['second_payment'] 
           + (float)$payment_details['final_payment'];
       
       $remaining_amount=$payment_details['agreed_amount']-$sub_total;
    }
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
      
      <title>Dhothar | Invoice</title>
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
            <div class="sidebar-menu-inner">
              
                <?php include('components/sidebar.php'); ?>
            </div>
         </div>
         <div class="main-content">
           
            <br class="hidden-print" /> 
            <div class="invoice">
               <div class="row">
                  <div class="col-sm-6 invoice-left"> <a href="#"> <img src="dhothar_logo.png" width="185" alt /> </a> </div>
                  <div class="col-sm-6 invoice-right">
                     <h3>INVOICE</h3>
                        <span>
                         <?php 
                            $date = date('Y-m-d');// Example date in Y-m-d format
                  
                            echo 'Dated: '.$date = date("d-m-Y", strtotime($date));
                         ?>
                        </span> 
                  </div>
               </div>
               <hr class="margin" />
               <div class="row">
                  <div class="col-sm-3 invoice-left">
                     <h4>Client</h4>
                        <?=$client_details['name'];?>
                     <br/>
                     S/o
                     <?=$client_details['fname'];?>
                     <br/>
                     Care of
                     
                     <?=$client_details['care_of'];?>
                  </div>
                 <div class="col-sm-3 invoice-left">
                    
                  </div>
                  <div class="col-md-6 invoice-right">
                     <!--<h4>Payment Details:</h4>-->
                     <!--<strong>V.A.T Reg #:</strong> 542554(DEMO)78-->
                     <!--<br/> <strong>Account Name:</strong> FoodMaster Ltd-->
                     <!--<br/> <strong>SWIFT code:</strong> 45454DEMO545DEMO-->
                  </div>
               </div>
               <div class="margin"></div>
               <table class="table table-bordered">
                  <thead>
                     <tr>
                        <th class="text-center">#</th>
                        <th width="60%">Payments</th>
                        <th>Date</th>
                        <th>Price</th>
                     </tr>
                     
                  </thead>
                  <tbody>
                      
                      <?php
                         if(!empty($payment_details['first_payment_date'])){
                      ?>
                     <tr>
                        <td class="text-center">1</td>
                        <td>First Payment</td>
                        <td>
                            <?php 
                                $first_payment = $payment_details['first_payment_date'];// Example date in Y-m-d format
                      
                                echo $first_payment_Date = date("d-m-Y", strtotime($first_payment));
                             ?>
                        </td>
                        <td class="text-right"><?=$payment_details['first_payment'],'/Euro';?></td>
                     </tr>
                     
                     <?php
                         }
                        if(!empty($payment_details['second_payment_date'])){
                    ?>
                     
                     <tr>
                        <td class="text-center">2</td>
                        <td>Second Payment</td>
                        <td>
                            <?php 
                                $second_payment = $payment_details['second_payment_date'];// Example date in Y-m-d format
                      
                                echo $second_payment_Date = date("d-m-Y", strtotime($second_payment));
                             ?>
                        </td>
                        <td class="text-right"><?=$payment_details['second_payment'],'/Euro';?></td>
                     </tr>
                    
                    <?php
                        }
                        
                     ?>
                     
                     <?php
                        
                        if(!empty($payment_details['final_payment'])){
                    ?>
                     
                     <tr>
                        <td class="text-center">3</td>
                        <td>Final Payment</td>
                        <td>
                            <?php 
                                $final_payment = $payment_details['final_payment_date'];// Example date in Y-m-d format
                      
                                echo $final_payment_Date = date("d-m-Y", strtotime($final_payment));
                             ?>
                        </td>
                        <td class="text-right"><?=$payment_details['final_payment'],'/Euro';?></td>
                     </tr>
                    
                    <?php
                        }
                        
                     ?>
                    
                    
                  </tbody>
               </table>
               <div class="margin"></div>
               <div class="row">
                  <div class="col-sm-6">
                     <div class="invoice-left">
                        5th Road City Plaza 
                        <br/>
                        Near New Al Jannat Mall
                        <br/>
                        P: 03425083003
                        <br/>
                        Dhothar International
                        <br/>
                        <a href="#">dhotharinternational@gmail.com</a>
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="invoice-right">
                        <ul class="list-unstyled">
                           <li>
                              Sub - Total amount:
                              <strong><?=$sub_total.'/euro'?></strong> 
                           </li>
                           <li>
                              Agreed Amount:
                              <strong><?=$payment_details['agreed_amount'].'/euro'?></strong> 
                           </li>
                          
                           <li>
                              Remaining Amount: 
                              <strong><?=$remaining_amount?></strong> 
                           </li>
                        </ul>
                        <br/> <a href="javascript:window.print();" class="btn btn-primary btn-icon icon-left hidden-print">
                        Print Invoice
                        <i class="entypo-doc-text"></i> </a>
                        &nbsp;
                       
                     </div>
                  </div>
               </div>
            </div>
            <?php
                include('components/footer.php');
            ?>
         </div>
         
      </div>
      
      <script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
      <script src="assets/js/gsap/TweenMax.min.js" id="script-resource-1"></script> 
      <script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js" id="script-resource-2"></script> 
      <script src="assets/js/bootstrap.js" id="script-resource-3"></script> 
      <script src="assets/js/joinable.js" id="script-resource-4"></script> 
      <script src="assets/js/resizeable.js" id="script-resource-5"></script> 
      <script src="assets/js/neon-api.js" id="script-resource-6"></script> 
      <script src="assets/js/cookies.min.js" id="script-resource-7"></script> 
<script src="assets/js/neon-custom.js" id="script-resource-9"></script>  
</body>
</html>