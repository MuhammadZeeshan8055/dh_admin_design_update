<?php
   include('database/db_connection.php');
   include('session.php');
   

   $get_id=$_GET['id'];

   $detail=mysqli_fetch_assoc(mysqli_query($con,"select * from new_case_details where id='$get_id'"));


   $payment_detail=mysqli_query($con,"select * from payments where emp_id='$get_id'");

   if(mysqli_num_rows ($payment_detail) > 0){
    
        $payment_detail=mysqli_fetch_assoc(mysqli_query($con,"select * from payments where emp_id='$get_id'"));
        

       $record= 'Record Present';
    
   }else{

        $payment_detail=mysqli_fetch_assoc(mysqli_query($con,"select * from payments where emp_id='$get_id'"));
        $record='';

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
                            <?php
                                if($record=='Record Present'){
                            ?>
                                Update Payment info 
                            <?php
                                }else{
                            ?>
                               Add Payment info 

                            <?php
                                }
                            ?> 
                    </strong> 
                </li>
            </ol>

            <h2>
                
                            <?php
                                if($record=='Record Present'){
                            ?>
                                Update Payment info of
                            <?php
                                }else{
                            ?>
                               Add Payment info of

                            <?php
                                }
                            ?>
               
                <b><u><?=$detail['name']?></b></u> S/o <b><u><?=$detail['fname']?></u></b> Care of <b><u><?=$detail['care_of']?></u></b>
            </h2>
            <br/> 
            
            <div class="row">
               <div class="col-md-12">
                  <div class="panel panel-primary" data-collapsed="0">
                     <div class="panel-heading">
                        <div class="panel-title">
                            <?php
                                if($record=='Record Present'){
                            ?>
                                Update Payment Form
                            <?php
                                }else{
                            ?>
                                Payment Form

                            <?php
                                }
                            ?>
                        </div>
                     </div>
                     <div class="panel-body">
                        <div class="row">
                            <?php
                                if($record=='Record Present'){
                            ?>
                                <form action="save_form" method="post">
                                    
                                    
                                    <div class="col-md-12">
                                         <label class="col-sm-6 control-label">Select Currency:</label>
                                         <select name="currency" class="form-control" required>
                                             <option value="<?=$payment_detail['currency'];?>"><?=$payment_detail['currency'];?></option>
                                             <option value="PKR">Currency PKR</option>
                                                <option value="EURO">Currency EURO</option>
                                          </select>
                                          
                                         
                                    </div>
                                    
                                    <div class="clear"></div>
                                    <br/> 
                              
                                    <div class="col-md-12"> 
                                        <label class="col-sm-3 control-label">Agreed Amount <span style="color:red">*</span></label>
                                        <input type="hidden" name="emp_id" value='<?=$get_id?>' required class="form-control"> 
                                        <input type="text" name="agreed_amount" value="<?=$payment_detail['agreed_amount'];?>" required class="form-control" placeholder="Enter Agreed Amount In Euro"> 
                                    </div>
                                    
                                    <div class="clear"></div>
                                    <br/> 

                                    <div class="col-md-12">
                                          <label class="col-sm-6 control-label">Choose Status</label>
                                          
                                            <select name="payment_status" class="form-control" required>
                                              <option value="<?=$payment_detail['payment_status'];?>"><?=$payment_detail['payment_status'];?></option>
                                              <option value="Payment Clear">Payment Clear</option>
                                              <option value="Payment Pending">Payment Pending</option>
                                              
                                            </select>
                                              
                                             
                                    </div>
                                    
                                    <div class="clear"></div>
                                    <br/> 
                                    
                                    
                                    <div class="col-md-6"> 
                                        <label class="col-sm-3 control-label">First Payment </label>
                                        <input type="text" name="first_payment" value="<?=$payment_detail['first_payment'];?>" class="form-control" placeholder="Enter First Payment Amount in Euro"> 
                                    </div>
                                    
                                    <div class="col-md-6"> 
                                        <label class="col-sm-6 control-label">First Payment Date </label>
                                        <input type="date" name="first_payment_date" value="<?=$payment_detail['first_payment_date'];?>"  class="form-control" placeholder="Enter First Payment Date"> 
                                    </div>

                                    <div class="clear"></div>
                                    <br/> 
                                    
                                    <div class="col-md-6"> 
                                        <label>
                                            <?php
                                                if($payment_detail['first_payment_method']=='cheque'){
                                            ?>
                                                
                                                    <input type="radio" name="first_payment_method" value="cheque" onclick="showField('chequeField')" checked> Checque 
                                            <?php
                                                    echo 'Number: '.$payment_detail['first_receive_by'];
                                                }else{
                                            ?>
                                                    
                                                    <input type="radio" name="first_payment_method" value="cheque" onclick="showField('chequeField')"> Checque
                                            
                                            <?php
                                                     
                                                }
                                            ?>
                                            
                                        </label>
                                        <label>
                                            <?php
                                                if($payment_detail['first_payment_method']=='cash'){
                                            ?>
                                                
                                                    <input type="radio" name="first_payment_method" value="cash" onclick="showField('onlineField')" checked> Cash 
                                            <?php
                                                     echo 'Received By: '.$payment_detail['first_receive_by'];
                                                }else{
                                            ?>
                                                    
                                                    <input type="radio" name="first_payment_method" value="cash" onclick="showField('onlineField')"> Cash
                                            
                                            <?php
                                                }
                                            ?>
                                            
                                        </label>
                                        <label>
                                             <?php
                                                if($payment_detail['first_payment_method']=='bank'){
                                            ?>
                                                
                                                     <input type="radio" name="first_payment_method" value="bank" onclick="showField('bankField')" checked> Bank 
                                            <?php
                                                     echo 'Transfer To: '.$payment_detail['first_receive_by'];
                                                }else{
                                            ?>
                                                    
                                                     <input type="radio" name="first_payment_method" value="bank" onclick="showField('bankField')"> Bank
                                            
                                            <?php
                                                }
                                            ?>
                                           
                                        </label>
                                        
                                    </div>
                                  
                                      <div class="clear"></div>
                                      <br/>
                                      
                                      <div class="col-md-6"> 
                                      
                                            <?php
                                                if($payment_detail['first_payment_method']=='cheque'){
                                            ?>
                                            
                                                <div id="chequeField" class="hidden">
                                                    <label class="col-sm-6 control-label">Checque Number:
                                                        <input type="text" name="first_checque_number" class="form-control">
                                                    </label>
                                                </div>
                                                
                                            <?php
                                                }else{
                                            ?>
                                            
                                                 <div id="chequeField" class="hidden">
                                                    <label class="col-sm-6 control-label">Checque Number:
                                                        <input type="text" name="first_checque_number" class="form-control">
                                                    </label>
                                                </div>
                                            
                                            <?php
                                                }
                                            ?>
                                            
                                             <?php
                                                if($payment_detail['first_payment_method']=='bank'){
                                            ?>
                                            
                                                <div id="bankField" class="hidden">
                                                    <label class="col-sm-6 control-label">Select Bank:
                                                        <select name="first_bank_name" class="form-control">
                                                            <option value="">Select Bank</option>
                                                            <option value="Zunair Javed HBL BANK">Zunair Javed HBL BANK</option>
                                                            <option value="Dhothar International Allied Bank">Dhothar International Allied Bank</option>
                                                            <option value="Zunair Javed Meezan Bank">Zunair Javed Meezan Bank</option>
                                                        </select>
                                                    </label>
                                                </div>
                                                
                                            <?php
                                                }else{
                                            ?>
                                            
                                                <div id="bankField" class="hidden">
                                                    <label class="col-sm-6 control-label">Select Bank:
                                                        <select name="first_bank_name" class="form-control">
                                                            <option value="">Select Bank</option>
                                                            <option value="Zunair Javed HBL BANK">Zunair Javed HBL BANK</option>
                                                            <option value="Dhothar International Allied Bank">Dhothar International Allied Bank</option>
                                                            <option value="Zunair Javed Meezan Bank">Zunair Javed Meezan Bank</option>
                                                        </select>
                                                    </label>
                                                </div>
                                            
                                            <?php
                                                }
                                            ?>
                                            
                                            
                                             <?php
                                                if($payment_detail['first_payment_method']=='cash'){
                                            ?>
                                            
                                                <div id="onlineField" class="hidden">
                                                    <label class="col-sm-6 control-label">Cash Received By:
                                                        
                                                            <input type="text" name="first_cash_received_by" class="form-control">
                                                        
                                                    </label>
                                                </div>
                                                
                                            <?php
                                                }else{
                                            ?>
                                            
                                                  <div id="onlineField" class="hidden">
                                                    <label class="col-sm-6 control-label">Cash Received By:
                                                        
                                                            <input type="text" name="first_cash_received_by" class="form-control">
                                                        
                                                    </label>
                                                </div>
                                            
                                            <?php
                                                }
                                            ?>
                                            
                                    
                                            
                                            
                                           
                                      </div>
                                      
                                      
                                      <div class="col-md-6"> 
                                         <label class="col-sm-6 control-label">First Payment Description </label>
                                         <input type="text" name="first_payment_description" value="<?=$payment_detail['first_payment_description'];?>"  class="form-control" placeholder="Enter Description"> 
                                      </div>
                                      
                                      
                                      
                                      <div class="clear"></div>
                                    <br/> 
                                    
                                    <hr>
                                    
                                    <div class="col-md-6"> 
                                        <label class="col-sm-3 control-label">Second Payment </label>
                                        <input type="text" name="second_payment" value="<?=$payment_detail['second_payment'];?>" class="form-control" placeholder="Enter Second Payment Amount in Euro"> 
                                    </div>

                                    

                                    <div class="col-md-6"> 
                                        <label class="col-sm-6 control-label">Second Payment Date </label>
                                        <input type="date" name="second_payment_date" value="<?=$payment_detail['second_payment_date'];?>" title="Please enter exactly 4 digits"  class="form-control" placeholder="Enter Second Payment Date"> 
                                    </div>
                                    
                                    <div class="clear"></div>
                                    <br/> 
                                    
                                    <div class="col-md-6"> 
                                        <label>
                                            <?php
                                                if($payment_detail['second_payment_method']=='cheque'){
                                            ?>
                                                
                                                    <input type="radio" name="second_payment_method" value="cheque" onclick="showField2('chequeField2')" checked> Checque 
                                            <?php
                                                    echo 'Number: '.$payment_detail['second_receive_by'];
                                                }else{
                                            ?>
                                                    
                                                    <input type="radio" name="second_payment_method" value="cheque" onclick="showField2('chequeField2')"> Checque 
                                            
                                            <?php
                                                }
                                            ?>
                                            
                                        </label>
                                        <label>
                                            <?php
                                                if($payment_detail['second_payment_method']=='cash'){
                                            ?>
                                                
                                                    <input type="radio" name="second_payment_method" value="cash" onclick="showField2('onlineField2')" checked> Cash 
                                            <?php
                                                    echo 'Received By: '.$payment_detail['second_receive_by'];
                                                }else{
                                            ?>
                                                    
                                                    <input type="radio" name="second_payment_method" value="cash" onclick="showField2('onlineField2')"> Cash
                                            
                                            <?php
                                                }
                                            ?>
                                            
                                        </label>
                                        <label>
                                             <?php
                                                if($payment_detail['second_payment_method']=='bank'){
                                            ?>
                                                
                                                     <input type="radio" name="second_payment_method" value="bank" onclick="showField2('bankField2')" checked> Bank 
                                            <?php
                                                    echo 'Transfer To: '.$payment_detail['second_receive_by'];
                                                }else{
                                            ?>
                                                    
                                                     <input type="radio" name="second_payment_method" value="bank" onclick="showField2('bankField2')"> Bank
                                            
                                            <?php
                                                }
                                            ?>
                                           
                                        </label>
                                        
                                    </div>
                                    
                                    
                                  

                                    <div class="clear"></div>
                                    <br/> 
                                    
                                    <div class="col-md-6"> 
                                      
                                            <?php
                                                if($payment_detail['second_payment_method']=='cheque'){
                                            ?>
                                            
                                                <div id="chequeField2" class="hidden">
                                                    <label class="col-sm-6 control-label">Checque Number:
                                                        <input type="text" name="second_checque_number" class="form-control">
                                                    </label>
                                                </div>
                                                
                                            <?php
                                                }else{
                                            ?>
                                            
                                                 <div id="chequeField2" class="hidden">
                                                    <label class="col-sm-6 control-label">Checque Number:
                                                        <input type="text" name="second_checque_number" class="form-control">
                                                    </label>
                                                </div>
                                            
                                            <?php
                                                }
                                            ?>
                                            
                                             <?php
                                                if($payment_detail['second_payment_method']=='bank'){
                                            ?>
                                            
                                                <div id="bankField2" class="hidden">
                                                    <label class="col-sm-6 control-label">Select Bank:
                                                        <select name="second_bank_name" class="form-control">
                                                            <option value="">Select Bank</option>
                                                             <option value="Zunair Javed HBL BANK">Zunair Javed HBL BANK</option>
                                                            <option value="Dhothar International Allied Bank">Dhothar International Allied Bank</option>
                                                            <option value="Zunair Javed Meezan Bank">Zunair Javed Meezan Bank</option>
                                                        </select>
                                                    </label>
                                                </div>
                                                
                                            <?php
                                                }else{
                                            ?>
                                            
                                                 <div id="bankField2" class="hidden">
                                                    <label class="col-sm-6 control-label">Select Bank:
                                                        <select name="second_bank_name" class="form-control">
                                                             <option value="">Select Bank</option>
                                                            
                                                             <option value="Zunair Javed HBL BANK">Zunair Javed HBL BANK</option>
                                                            <option value="Dhothar International Allied Bank">Dhothar International Allied Bank</option>
                                                            <option value="Zunair Javed Meezan Bank">Zunair Javed Meezan Bank</option>
                                                        </select>
                                                    </label>
                                                </div>
                                            
                                            <?php
                                                }
                                            ?>
                                            
                                            
                                             <?php
                                                if($payment_detail['second_payment_method']=='cash'){
                                            ?>
                                            
                                                <div id="onlineField2" class="hidden">
                                                    <label class="col-sm-6 control-label">Cash Received By:
                                                        
                                                            <input type="text" name="second_cash_received_by" class="form-control">
                                                        
                                                    </label>
                                                </div>
                                                
                                            <?php
                                                }else{
                                            ?>
                                            
                                                  <div id="onlineField2" class="hidden">
                                                    <label class="col-sm-6 control-label">Cash Received By:
                                                        
                                                            <input type="text" name="second_cash_received_by" class="form-control">
                                                        
                                                    </label>
                                                </div>
                                            
                                            <?php
                                                }
                                            ?>
                                            
                                    
                                            
                                            
                                           
                                      </div>


                                    <div class="col-md-6"> 
                                         <label class="col-sm-6 control-label">Second Payment Description </label>
                                         <input type="text" name="second_payment_description" value="<?=$payment_detail['second_payment_description'];?>"  class="form-control" placeholder="Enter Description"> 
                                    </div>

                                    <div class="clear"></div>
                                    <br/>
                                    <div class="col-md-6"> 
                                        <label class="col-sm-3 control-label">Final Payment </label>
                                        <input type="text" name="final_payment" value="<?=$payment_detail['final_payment'];?>"  class="form-control" placeholder="Enter Final Payment Amount in Euro"> 
                                    </div>

                                    

                                    <div class="col-md-6"> 
                                        <label class="col-sm-6 control-label">Final Payment Date </label>
                                        <input type="date" name="final_payment_date" value="<?=$payment_detail['final_payment_date'];?>" title="Please enter exactly 4 digits"  class="form-control" placeholder="Enter Final Payment Date"> 
                                    </div>

                                    <div class="clear"></div>
                                    <br/> 
                                    
                                    <div class="col-md-6"> 
                                        <label>
                                            <?php
                                                if($payment_detail['final_payment_method']=='cheque'){
                                            ?>
                                                
                                                    <input type="radio" name="final_payment_method" value="cheque" onclick="showField3('chequeField3')" checked> Checque 
                                            <?php
                                                    echo 'Number: '.$payment_detail['final_receive_by'];
                                                }else{
                                            ?>
                                                    
                                                    <input type="radio" name="final_payment_method" value="cheque" onclick="showField3('chequeField3')"> Checque
                                            
                                            <?php
                                                }
                                            ?>
                                            
                                        </label>
                                        <label>
                                            <?php
                                                if($payment_detail['final_payment_method']=='cash'){
                                            ?>
                                                
                                                    <input type="radio" name="final_payment_method" value="cash" onclick="showField3('onlineField3')" checked> Cash 
                                            <?php 
                                                    echo 'Received By: '.$payment_detail['final_receive_by'];
                                                }else{
                                            ?>
                                                    
                                                    <input type="radio" name="final_payment_method" value="cash" onclick="showField3('onlineField3')"> Cash
                                            
                                            <?php
                                                }
                                            ?>
                                            
                                        </label>
                                        <label>
                                             <?php
                                                if($payment_detail['final_payment_method']=='bank'){
                                            ?>
                                                
                                                     <input type="radio" name="final_payment_method" value="bank" onclick="showField3('bankField3')" checked> Bank 
                                            <?php   
                                                    echo 'Transfer To: '.$payment_detail['final_receive_by'];
                                                }else{
                                            ?>
                                                    
                                                     <input type="radio" name="final_payment_method" value="bank" onclick="showField3('bankField3')"> Bank
                                            
                                            <?php
                                                }
                                            ?>
                                           
                                        </label>
                                        
                                    </div>
                                    
                                    
                                  

                                    <div class="clear"></div>
                                    <br/> 
                                    
                                    <div class="col-md-6"> 
                                      
                                            <?php
                                                if($payment_detail['final_payment_method']=='cheque'){
                                            ?>
                                            
                                                <div id="chequeField3" class="hidden">
                                                    <label class="col-sm-6 control-label">Checque Number:
                                                        <input type="text" name="final_checque_number" class="form-control">
                                                    </label>
                                                </div>
                                                
                                            <?php
                                                }else{
                                            ?>
                                            
                                                 <div id="chequeField3" class="hidden">
                                                    <label class="col-sm-6 control-label">Checque Number:
                                                        <input type="text" name="final_checque_number" class="form-control">
                                                    </label>
                                                </div>
                                            
                                            <?php
                                                }
                                            ?>
                                            
                                             <?php
                                                if($payment_detail['final_payment_method']=='bank'){
                                            ?>
                                            
                                                <div id="bankField3" class="hidden">
                                                    <label class="col-sm-6 control-label">Select Bank:
                                                        <select name="second_bank_name" class="form-control">
                                                            <option value="">Select Bank</option>
                                                             <option value="Zunair Javed HBL BANK">Zunair Javed HBL BANK</option>
                                                            <option value="Dhothar International Allied Bank">Dhothar International Allied Bank</option>
                                                            <option value="Zunair Javed Meezan Bank">Zunair Javed Meezan Bank</option>
                                                        </select>
                                                    </label>
                                                </div>
                                                
                                            <?php
                                                }else{
                                            ?>
                                            
                                                 <div id="bankField3" class="hidden">
                                                    <label class="col-sm-6 control-label">Select Bank:
                                                        <select name="final_bank_name" class="form-control">
                                                             <option value="">Select Bank</option>
                                                            
                                                             <option value="Zunair Javed HBL BANK">Zunair Javed HBL BANK</option>
                                                            <option value="Dhothar International Allied Bank">Dhothar International Allied Bank</option>
                                        <option value="Zunair Javed Meezan Bank">Zunair Javed Meezan Bank</option>
                                                        </select>
                                                    </label>
                                                </div>
                                            
                                            <?php
                                                }
                                            ?>
                                            
                                            
                                             <?php
                                                if($payment_detail['final_payment_method']=='cash'){
                                            ?>
                                            
                                                <div id="onlineField3" class="hidden">
                                                    <label class="col-sm-6 control-label">Cash Received By:
                                                        
                                                            <input type="text" name="final_cash_received_by" class="form-control">
                                                        
                                                    </label>
                                                </div>
                                                
                                            <?php
                                                }else{
                                            ?>
                                            
                                                  <div id="onlineField3" class="hidden">
                                                    <label class="col-sm-6 control-label">Cash Received By:
                                                        
                                                            <input type="text" name="final_cash_received_by" class="form-control">
                                                        
                                                    </label>
                                                </div>
                                            
                                            <?php
                                                }
                                            ?>
                                            
                                    
                                            
                                            
                                           
                                      </div>
                                    
                                    
                                     <div class="col-md-6"> 
                                         <label class="col-sm-6 control-label">Final Payment Description </label>
                                         <input type="text" name="final_payment_description" value="<?=$payment_detail['final_payment_description'];?>" class="form-control" placeholder="Enter Description"> 
                                    </div>
                                    
                                    
                                    <div class="clear"></div>
                                    <br/>

                                    <div class="col-md-12 text-center"> 
                                        <button type="submit" name="update_payment_detail" class="btn btn-success">Update Payment Detail</button>
                                    </div>
                                </form>
                            <?php
                                }else{
                            ?>

                            <form action="save_form" method="post">
                                
                            
                              <div class="col-md-12">
                                 <label class="col-sm-6 control-label">Select Currency:</label>
                                 <select name="currency" class="form-control" required>
                                     <option value="Select Currency">Select Currency</option>
                                      <option value="PKR">Currency PKR</option>
                                      <option value="EURO">Currency EURO</option>
                                  </select>
                                  
                                 
                              </div>
                              
                               <div class="clear"></div>
                              <br/> 
                              
                              <div class="col-md-12"> 
                                 <label class="col-sm-3 control-label">Agreed Amount <span style="color:red">*</span></label>
                                 <input type="hidden" name="emp_id" value='<?=$get_id?>' required class="form-control" placeholder="Enter Agreed Amount In Euro"> 
                                 <input type="text" name="agreed_amount" required class="form-control" placeholder="Enter Agreed Amount In Euro"> 
                              </div>
                              
                              <div class="clear"></div>
                              <br/> 
                              
                              <div class="col-md-12">
                                      <label class="col-sm-6 control-label">Choose Status</label>
                                      
                                        <select name="payment_status" class="form-control" required>
                                          
                                          <option value="Payment Pending">Payment Pending</option>
                                          <option value="Payment Clear">Payment Clear</option>
                                          
                                        </select>
                                          
                                         
                              </div>


                              <div class="clear"></div>
                              <br/> 
                              
                              
                              <div class="col-md-6"> 
                                 <label class="col-sm-3 control-label">First Payment</label>
                                 <input type="text" name="first_payment" value="0" class="form-control" placeholder="Enter First Payment Amount in Euro"> 
                              </div>
                              
                              <div class="col-md-6"> 
                                 <label class="col-sm-6 control-label">First Payment Date </label>
                                 <input type="date" name="first_payment_date"  class="form-control" placeholder="Enter First Payment Date"> 
                              </div>

                              <div class="clear"></div>
                              <br/> 
                              
                              <div class="col-md-6"> 
                                    <label>
                                        <input type="radio" name="first_payment_method" value="cheque" onclick="showField('chequeField')"> Checque
                                    </label>
                                    <label>
                                        <input type="radio" name="first_payment_method" value="cash" onclick="showField('onlineField')"> Cash
                                    </label>
                                    <label>
                                        <input type="radio" name="first_payment_method" value="bank" onclick="showField('bankField')"> Bank
                                    </label>
                                    
                              </div>
                              
                              <div class="clear"></div>
                              <br/>
                              
                              <div class="col-md-6">
                                    <div id="chequeField" class="hidden">
                                        <label class="col-sm-6 control-label">Checque Number:
                                            <input type="text" name="first_checque_number" class="form-control">
                                        </label>
                                    </div>
                            
                                    <div id="bankField" class="hidden">
                                        <label class="col-sm-6 control-label">Select Bank:
                                            <select name="first_bank_name" class="form-control">
                                                <option value="Zunair Javed HBL BANK">Zunair Javed HBL BANK</option>
                                                <option value="Dhothar International Allied Bank">Dhothar International Allied Bank</option>
                                                <option value="Zunair Javed Meezan Bank">Zunair Javed Meezan Bank</option>
                                            </select>
                                        </label>
                                    </div>
                                    
                                    <div id="onlineField" class="hidden">
                                        <label class="col-sm-6 control-label">Cash Received By:
                                            
                                                <input type="text" name="first_cash_received_by" class="form-control">
                                            
                                        </label>
                                    </div>
                              </div>
                              
                               <div class="col-md-6"> 
                                 <label class="col-sm-6 control-label">First Payment Description </label>
                                 <input type="text" name="first_payment_description"  class="form-control" placeholder="Enter Description"> 
                              </div>
                              
                              <div class="clear"></div>
                              <br/>
                              
                              <hr>
                              
                              <!--<div class="col-md-6"> -->
                              <!--   <label class="col-sm-3 control-label">Second Payment <span style="color:red">*</span></label>-->
                              <!--   <input type="text" name="second_payment"  class="form-control" placeholder="Enter Second Payment Amount in Euro"> -->
                              <!--</div>-->

                             

                              <!--<div class="col-md-6"> -->
                              <!--   <label class="col-sm-6 control-label">Second Payment Date <span style="color:red">*</span></label>-->
                              <!--   <input type="date" name="second_payment_date" title="Please enter exactly 4 digits"  class="form-control" placeholder="Enter Second Payment Date"> -->
                              <!--</div>-->

                              <!--<div class="clear"></div>-->
                              <!--<br/> -->

                              <!--<div class="col-md-6"> -->
                              <!--   <label class="col-sm-3 control-label">Final Payment <span style="color:red">*</span></label>-->
                              <!--   <input type="text" name="final_payment"  class="form-control" placeholder="Enter Final Payment In Euro"> -->
                              <!--</div>-->

                             

                              <!--<div class="col-md-6"> -->
                              <!--   <label class="col-sm-6 control-label">Final Payment Date <span style="color:red">*</span></label>-->
                              <!--   <input type="date" name="final_payment_date" title="Please enter exactly 4 digits"  class="form-control" placeholder="Enter Final Payment Date"> -->
                              <!--</div>-->

                             
                              <!--<div class="clear"></div>-->
                              <!--<br/>-->

                              <div class="col-md-12 text-center"> 
                                 <button type="submit" name="add_payment_details" class="btn btn-success">Submit Payment Details</button>
                              </div>
                            </form>

                            <?php
                                }
                            ?>
                           
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
            
            function showField2(fieldId) {
                // Hide all fields
                document.getElementById('chequeField2').classList.add('hidden');
                document.getElementById('bankField2').classList.add('hidden');
                document.getElementById('onlineField2').classList.add('hidden');
    
                // Show the selected field
                document.getElementById(fieldId).classList.remove('hidden');
            }
            function showField3(fieldId) {
                // Hide all fields
                document.getElementById('chequeField3').classList.add('hidden');
                document.getElementById('bankField3').classList.add('hidden');
                document.getElementById('onlineField3').classList.add('hidden');
    
                // Show the selected field
                document.getElementById(fieldId).classList.remove('hidden');
            }
        </script>
     
   </body>
</html>
