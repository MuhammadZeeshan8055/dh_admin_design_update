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
      <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic" id="style-resource-3">
      <link rel="stylesheet" href="assets/css/bootstrap.css" id="style-resource-4">
      <link rel="stylesheet" href="assets/css/neon-core.css" id="style-resource-5">
      <link rel="stylesheet" href="assets/css/neon-theme.css" id="style-resource-6">
      <link rel="stylesheet" href="assets/css/neon-forms.css" id="style-resource-7">
      <link rel="stylesheet" href="assets/css/custom.css" id="style-resource-8">
      <script src="assets/js/jquery-1.11.3.min.js"></script> 
      <style>
        .hidden {
            display: none;
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
               
                <li class="active"> 
                    <strong>
                           Add Miscellaneous Payment
                    </strong> 
                </li>
            </ol>

            <h2>
                
                            Add Miscellaneous Payment
               
               
            </h2>
            <br/> 
            
            <div class="row">
               <div class="col-md-12">
                  <div class="panel panel-primary" data-collapsed="0">
                     <div class="panel-heading">
                        <div class="panel-title">
                           Add Miscellaneous Payment
                        </div>
                     </div>
                     <div class="panel-body">
                        <div class="row">
                          

                            <form action="save_form" method="post">
                              
                              <div class="col-md-12"> 
                                 <label class="col-sm-3 control-label">Payment Purpose <span style="color:red">*</span></label>
                                 <input type="text" name="payment_purpose" required class="form-control" placeholder="Purpose Of Payment"> 
                              </div>
                              
                               <div class="clear"></div>
                              <br/>
                              
                              <div class="col-md-6"> 
                                 <label class="col-sm-6 control-label">Payment Given By <span style="color:red">*</span></label>
                                 <input type="text" name="payment_given_by" required class="form-control" placeholder="Enter Given By"> 
                              </div>
                              
                              <div class="clear"></div>
                              <br/> 

                              <div class="col-md-6"> 
                                 <label class="col-sm-3 control-label">Amount <span style="color:red">*</span></label>
                                 <input type="text" name="amount" required class="form-control" placeholder="Enter Amount in Euro"> 
                              </div>
                              
                              <div class="col-md-6"> 
                                 <label class="col-sm-6 control-label">Payment Date <span style="color:red">*</span></label>
                                 <input type="date" name="payment_date"  class="form-control" placeholder="Enter First Payment Date"> 
                              </div>
                              
                               <div class="clear"></div>
                              <br/> 
                              
                              <div class="col-md-6"> 
                                 <label class="col-sm-6 control-label">Care Of <span style="color:red">*</span></label>
                                 <input type="text" name="care_of"  class="form-control" placeholder="Enter First Payment Date"> 
                              </div>

                              <div class="clear"></div>
                              <br/> 
                              
                              <div class="col-md-6"> 
                                    <label>
                                        <input type="radio" name="miscellaneous_payment_method" value="cheque" onclick="showField('chequeField')"> Checque
                                    </label>
                                    <label>
                                        <input type="radio" name="miscellaneous_payment_method" value="cash" onclick="showField('onlineField')"> Cash
                                    </label>
                                    <label>
                                        <input type="radio" name="miscellaneous_payment_method" value="bank" onclick="showField('bankField')"> Bank
                                    </label>
                                    
                              </div>
                              
                              <div class="clear"></div>
                              <br/>
                              
                              <div class="col-md-12"> 
                                    <div id="chequeField" class="hidden">
                                        <label class="col-sm-6 control-label">Checque Number:
                                            <input type="text" name="checque_number" class="form-control">
                                        </label>
                                    </div>
                            
                                    <div id="bankField" class="hidden">
                                        <label class="col-sm-6 control-label">Select Bank:
                                            <select name="bank_name" class="form-control">
                                                <option value="">Select Bank Account</option>
                                                <option value="Zunair Javed HBL BANK">Zunair Javed HBL BANK</option>
                                                <option value="bank3">Bank 3</option>
                                            </select>
                                        </label>
                                    </div>
                                    
                                    <div id="onlineField" class="hidden">
                                        <label class="col-sm-6 control-label">Cash Received By:
                                            
                                                <input type="text" name="cash_received_by" class="form-control">
                                            
                                        </label>
                                    </div>
                              </div>
                              
                              

                              <div class="col-md-12 text-center"> 
                                 <button type="submit" name="add_miscellaneous_payment" class="btn btn-success">Submit Payment Details</button>
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
<script src="assets/js/neon-custom.js" id="script-resource-10"></script>  
<script>
             function showField(fieldId) {
                // Hide all fields
                document.getElementById('chequeField').classList.add('hidden');
                document.getElementById('bankField').classList.add('hidden');
                document.getElementById('onlineField').classList.add('hidden');
    
                // Show the selected field
                document.getElementById(fieldId).classList.remove('hidden');
            }
            
           
        </script>
     
   </body>
</html>
