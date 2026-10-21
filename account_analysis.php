<?php
    
    include('database/db_connection.php');

    include('session.php');


    
    $date=date('Y-m-d');


$today_date 		= date('Y-m-d').'/'.date('Y-m-d'); 
$yesterday_date 	= date('Y-m-d', strtotime(date('Y-m-d')." -1 day")).'/'.date('Y-m-d', strtotime(date('Y-m-d')." -1 day"));

 list($date1,$date2) = explode('/',$yesterday_date);
		    

$last7days_date 	= date('Y-m-d', strtotime(date('Y-m-d')." -6 day")).'/'.date('Y-m-d');
$thismonth_date 	= date('Y-m-d', strtotime(date('Y-m-')."1")).'/'.date('Y-m-t', strtotime(date('Y-m-d')));
$lastmonth_date 	= date('Y-m-d', strtotime(date('Y-m-')."1 -1 month")).'/'.date('Y-m-t', strtotime(date('Y-m-d')."-1 month"));
$thisyear_date 		= date('Y-01-01').'/'.date('Y-12-31');
$lastyear_date 		= date('Y-01-01', strtotime(date('Y-01-01')."-1 year")).'/'.date('Y-12-31', strtotime(date('Y-12-31')."-1 year"));
$alltime_date 		= '1969-12-31/'.date('Y-12-31');

if (isset($_POST['date'])) {
    if ($_POST['date'] == $today_date) {
        $selectOption = "Today";
    } elseif ($_POST['date'] == $yesterday_date) {
        $selectOption = "Yesterday";
    } elseif ($_POST['date'] == $last7days_date) {
        $selectOption = "Last 7 Days";
    } elseif ($_POST['date'] == $thismonth_date) {
        $selectOption = "This Month";
    } elseif ($_POST['date'] == $lastmonth_date) {
        $selectOption = "Last Month";
    } elseif ($_POST['date'] == $thisyear_date) {
        $selectOption = "This Year";
    } elseif ($_POST['date'] == $lastyear_date) {
        $selectOption = "Last Year";
    } elseif ($_POST['date'] == $alltime_date) {
        $selectOption = "All Time";
    }
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
            .card.radius-10.overflow-hidden.w-100 {
               padding: 10px 10px 10px 10px;
               box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
            }
            .tile-stats.tile-red {
               box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
            }
            .tile-stats.tile-aqua {
               box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
            }
            .tile-stats.tile-blue {
               box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
            }
             .tile-stats.tile-green {
               box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
            }
            .table-1{
               width: 100%;
            }
            .table-2{
               width: 100%;
            }

         </style>
         
   </head>
   <body class="page-body page-fade" >
      <div class="page-container">
         <div class="sidebar-menu">
            <?php include('components/sidebar.php'); ?>
         </div>
         <div class="main-content">
            <?php include('components/header.php'); ?>

            <hr/>
            
            <div class="row">
               <div class="col-sm-3 col-xs-6">
                  <div class="tile-stats tile-red">
                        <?php 
                           $first_payment=mysqli_fetch_assoc(mysqli_query($con,"SELECT sum(first_payment) as first_payment FROM payments where month(first_payment_date)=month(now())"));
                           $second_payment=mysqli_fetch_assoc(mysqli_query($con,"SELECT sum(second_payment) as second_payment FROM payments where month(second_payment_date)=month(now())"));
                           $final_payment=mysqli_fetch_assoc(mysqli_query($con,"SELECT sum(final_payment) as final_payment FROM payments where month(final_payment_date)=month(now())"));
                           $miscellaneous_payment=mysqli_fetch_assoc(mysqli_query($con,"SELECT sum(amount) as miscellaneous_payment FROM miscellaneous_payment where month(payment_date)=month(now())"));
                                                
                           $total_cash=$first_payment['first_payment']+$second_payment['second_payment']+$final_payment['final_payment']+$miscellaneous_payment['miscellaneous_payment'];
                        ?>
                     <div class="icon"><i class="entypo-users"></i></div>
                     <div class="num" data-start="0" data-end="<?=$total_cash;?>" data-postfix data-duration="1500" data-delay="0"><?=number_format($total_cash, 0, '.', ',')?></div>
                     <h3>Total Cash Received</h3>
                     <p>Total Cash Received This Month.</p>
                  </div>
               </div>
              
               <div class="clear visible-xs"></div>
               <div class="col-sm-3 col-xs-6">
                  <div class="tile-stats tile-aqua">
                    <?php
                         $first_payment=mysqli_fetch_assoc(mysqli_query($con,"SELECT sum(first_payment) as first_payment FROM payments where month(first_payment_date)=month(now())"));
                         $second_payment=mysqli_fetch_assoc(mysqli_query($con,"SELECT sum(second_payment) as second_payment FROM payments where month(second_payment_date)=month(now())"));
                         $final_payment=mysqli_fetch_assoc(mysqli_query($con,"SELECT sum(final_payment) as final_payment FROM payments where month(final_payment_date)=month(now())"));

                         $monthly_cash=$first_payment['first_payment']+$second_payment['second_payment']+$final_payment['final_payment'];
                     ?>
                     <div class="icon"><i class="entypo-mail"></i></div>
                     <div class="num" data-start="0" data-end="<?=$monthly_cash;?>" data-postfix data-duration="1500" data-delay="1200">0</div>
                     <h3>This Month Cash Received</h3>
                     <p>This Month Overall Cash Received.</p>
                  </div>
               </div>
               <div class="col-sm-3 col-xs-6">
                  <div class="tile-stats tile-green">
                  <?php
                         $first_payment=mysqli_fetch_assoc(mysqli_query($con,"SELECT sum(first_payment) as first_payment FROM payments where first_payment_date between '$date1' and '$date2'"));
                         $second_payment=mysqli_fetch_assoc(mysqli_query($con,"SELECT sum(second_payment) as second_payment FROM payments where second_payment_date between '$date1' and '$date2'"));
                         $final_payment=mysqli_fetch_assoc(mysqli_query($con,"SELECT sum(final_payment) as final_payment FROM payments where final_payment_date between '$date1' and '$date2'"));

                         $today_cash=$first_payment['first_payment']+$second_payment['second_payment']+$final_payment['final_payment'];
                     ?>
                     <div class="icon"><i class="entypo-mail"></i></div>
                     <div class="num" data-start="0" data-end="<?=$today_cash;?>" data-postfix data-duration="1500" data-delay="1200">0</div>
                     <h3>Yesterday Cash Received</h3>
                     <p>Yesterday Cash Received Calculation.</p>
                  </div>
               </div>
               <div class="col-sm-3 col-xs-6">
                  <div class="tile-stats tile-green">
                  <?php
                         $miscellaneous_payment=mysqli_fetch_assoc(mysqli_query($con,"SELECT sum(amount) as miscellaneous_payment FROM miscellaneous_payment where payment_date='$date'"));
                        
                         $total_miscellaneous_payment=$miscellaneous_payment['miscellaneous_payment'];
                     ?>
                     <div class="icon"><i class="entypo-mail"></i></div>
                     <div class="num" data-start="0" data-end="<?=$total_miscellaneous_payment;?>" data-postfix data-duration="1500" data-delay="1200">0</div>
                     <h3>Miscellaneous Cash Received</h3>
                     <p>Miscellaneous Cash Received Calculation.</p>
                  </div>
               </div>
               <div class="col-sm-3 col-xs-6">
                  <div class="tile-stats tile-blue">
                  <?php
                         $first_payment=mysqli_fetch_assoc(mysqli_query($con,"SELECT sum(first_payment) as first_payment FROM payments where first_payment_date='$date'"));
                         $second_payment=mysqli_fetch_assoc(mysqli_query($con,"SELECT sum(second_payment) as second_payment FROM payments where second_payment_date='$date'"));
                         $final_payment=mysqli_fetch_assoc(mysqli_query($con,"SELECT sum(final_payment) as final_payment FROM payments where final_payment_date='$date'"));

                         $today_cash=$first_payment['first_payment']+$second_payment['second_payment']+$final_payment['final_payment'];
                     ?>
                     <div class="icon"><i class="entypo-mail"></i></div>
                     <div class="num" data-start="0" data-end="<?=$today_cash;?>" data-postfix data-duration="1500" data-delay="1200">0</div>
                     <h3>Today Cash Received</h3>
                     <p>Today Cash Calculation.</p>
                  </div>
               </div>
            </div>
            <br/> 

            
					<div class="row">
        				<div class="col-12 col-lg-6 col-xl-6 d-flex" >
    					   	<div class="card radius-10 overflow-hidden w-100">
    						  <div class="card-body">
    							<div class="d-flex align-items-center">
    								 <form action="account_analysis_search" method="post">
                    
                                          <table class="table-1">
                                                <tr>
                                                    <td><select class='form-control' name="date"  required >
                                            				<?php if($_POST['date']){?>
                                            					<option value="<?= $_POST['date']; ?>"><?= $selectOption; ?></option>
                                            				<?php }else{ ?>
                                            					<option value=''>Select</option>
                                            				<?php } ?>
                                            					<option value="<?= $today_date; ?>">Today</option>
                                            					<option value="<?= $yesterday_date; ?>">Yesterday</option>
                                            					<option value="<?= $last7days_date; ?>">Last 7 Days</option>
                                            					<option value="<?= $thismonth_date; ?>">This Month</option>
                                            					<option value="<?= $lastmonth_date; ?>">Last Month</option>
                                            					<option value="<?= $thisyear_date; ?>">This Year</option>
                                            					<option value="<?= $lastyear_date; ?>">Last Year</option>
                                            					<option value="<?= $alltime_date; ?>">All Time</option>
                                            				</select>
    				                                    </td>
                                                     <td>   <input type="submit" name="date_select" value="search" id="" class="form-control">
                                
                                                      </td>
                                                </tr>
                                          </table>
                    
                                 
                                    </form>
                        
                            	</div>
                              </div>
    						</div>
    					</div>
    					
    					<div class="col-12 col-lg-6 col-xl-6 d-flex">
    					   <div class="card radius-10 overflow-hidden w-100" >
    						  <div class="card-body">
    							<div class="d-flex align-items-center">
    								 
                     
                                             <form action="account_analysis_search" method="post">
                                            
                                              <table class="table-2">
                                                <tr>
                                                    <td> <input type='date' name='date1' class='form-control' value="<?= $_POST['date1'] ?? ''; ?>"   />
    				                                    </td>
                                                     <td>   <input type='date' name='date2' class='form-control' value="<?= $_POST['date2'] ?? ''; ?>"   />
                                
                                                      </td>
                                                      <td>
                                                          <input type="submit" name="date_range" value="search" id="" class="form-control">
                                    
                                                      </td>
                                                </tr>
                                          </table>
                                          
                                         
                                           
                                              <!--<input type='date' name='date1' class='form-control' value="<?= $_POST['date1']; ?>"   />-->
                                              <!--  	<input type='date' name='date2' class='form-control' value="<?= $_POST['date2']; ?>"   />-->
                                              <!--  <input type="submit" name="date_range" value="search" id="" class="form-control">-->
                                    
                                            
                                            
                                            
                                            </form>
                            	</div>
                              </div>
    						</div>
    					</div>
					
					</div>

               <br>
               <br>

              
            <br/> 

            <hr>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-header">
                                <h3>Today Cash Handed Over to</h3>
                            </div>
                            <br>
                            <div class="card-body">
                                <form action="save_form" method="post">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Today Cash Received In Euro</label>
                                            <input type="text" name="today_cash_received" required value="<?=$today_cash?>" id="" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Today Cash Handed Over To</label>
                                            <input type="text" name="handed_over_to" id="" required class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for=""></label>
                                            <br>
                                            <input type="submit" name="payment_handed_over_to" id="" class="btn btn-primary">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr>
            <br>
             <div class="row">
               <div class="col-md-12">
                  <h3>Miscellaneous Payments</h3>
                  <br/> 
                  <script type="text/javascript">
                  jQuery( document ).ready( function( $ ) {
                  var $table5 = jQuery( "#table-5" );
                  $table5.DataTable( {
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
               <table class="table table-bordered datatable table-3" id="table-5">
               <thead>
                  <tr>
                                <th>Sno</th>
							    <th>Payment Purpose</th>
							    <th>Payment Given By</th>
							    <th>Amount</th>
							    <th>Payment Date</th>
							    <th>Care Of</th>
								<th>Miscellaneous Payment Method</th>
								<th>Checque Number</th>
								<th>Bank Name</th>
								<th>Cash Received By</th>
								
                     
                  </tr>
               </thead>
               <tbody>
                                            <?php
												$subtotal=0;

                                                $miscellaneous_payment = mysqli_query($con, "SELECT * FROM miscellaneous_payment");
                    
                                                            $count=1; 
                                                while ($row2 = mysqli_fetch_array($miscellaneous_payment)) { 
                                                    
                                                   

													
											?>
                        <tr>
                                <td><?php echo $count++?></td>
								<td><?=$row2['payment_purpose'];?></td>
                                <td><?=$row2['payment_given_by'];?></td>
                                <td><?=$row2['amount'];?></td>
                                <td><?=$row2['payment_date'];?></td>
                                <td><?=$row2['care_of'];?></td>
                                <td><?=$row2['miscellaneous_payment_method'];?></td>
                                <td><?=$row2['checque_number'];?></td>
                                <td><?=$row2['bank_name'];?></td>
                                <td><?=$row2['cash_received_by'];?></td>
                                
                                
                        </tr>
                  <?php
                     }
                  ?>
               </tbody>
               
            </table>
               </div>
           </div>
           
            <br/> 
            
           <div class="row">
               <div class="col-md-12">
                  <h3>Cash Data</h3>
                  <br/> 
                  <script type="text/javascript">
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
                                <th>Sno</th>
							    <th>Client</th>
							    <th>Father Name</th>
							    <th>Passport No</th>
							    <th>Tracking Id</th>
							    <th>Care Of</th>
							    <th>Agreed Amount</th>
								<th>First Payment</th>
								<th>First Payment Date</th>
								<th>First Payment Description</th>
								<th>Second Payment</th>
								<th>Second Payment Date</th>
								<th>Second Payment Description</th>
								<th>Final Payment</th>
								<th>Final Payment Date</th>
								<th>Final Payment Description</th>
								<th>Remaining</th>      
                                <th>Refund Remarks</th>
							
                     
                  </tr>
               </thead>
               <tbody>
                                            <?php
												$subtotal=0;

                                                $exp_fetched = mysqli_query($con, "SELECT * FROM payments");
                    
                                                            $count=1; 
                                                while ($row = mysqli_fetch_array($exp_fetched)) { 
                                                    
                                                    $client=mysqli_fetch_assoc(mysqli_query($con,"select name,fname,care_of,tracking_id,pp_no from new_case_details where id='$row[emp_id]'"));
													// $total= $row['sum'];

													// $subtotal+=$total;

													
											?>
                        <tr>
                                <td><?php echo $count++?></td>
								<td><?=$client['name'];?></td>
                                <td><?=$client['fname'];?></td>
                                <td><?=$client['pp_no'];?></td>
                                <td><?=$client['tracking_id'];?></td>
                                <td><?=$client['care_of'];?></td>
                                <td><?=$row['agreed_amount'];?></td>
                                <td><?=$row['first_payment'];?></td>
                                <td><?=$row['first_payment_date'];?></td>
                                <td><?=$row['first_payment_description'];?></td>
                                <td><?=$row['second_payment'];?></td>
                                <td><?=$row['second_payment_date'];?></td>
                                <td><?=$row['second_payment_description'];?></td>
                                <td><?=$row['final_payment'];?></td>
                                <td><?=$row['final_payment_date'];?></td>
                                <td><?=$row['final_payment_description'];?></td>
                                <?php
                                  $remaining_amount=0;
    
                                  if(!empty($row['first_payment'])){
    
                                    $first_payment = (float) preg_replace('/[^0-9.]/', '', $row['first_payment']);
    
                                  }else{
                                     $first_payment=0;
    
                                  }
    
                                  if(!empty($row['second_payment'])){
    
                                    $second_payment = (float) preg_replace('/[^0-9.]/', '', $row['second_payment']);
    
                                  }else{
                                     $second_payment=0;
    
                                  }
                                  
                                  
                                  if(!empty($row['final_payment'])){
    
                                    $final_payment = (float) preg_replace('/[^0-9.]/', '', $row['final_payment']);
                                     
                                  }else{
    
                                     $final_payment=0;
    
                                  }
                                
                                
                                $agreed_amount = (float) preg_replace('/[^0-9.]/', '', $row['agreed_amount']);
                                
                                $remaining_amount=$agreed_amount-$first_payment-$second_payment-$final_payment;
                               
                              if($remaining_amount > '200'){
                              
                                 echo '<td style="color:white;background:red !important">';
                              }else{
                                 echo '<td style="background:green !important">';

                              }
                           ?>

                           

                     
                                        <?php
                                            $remaining_amount=0;

                                            if(!empty($row['first_payment'])){

                                                $first_payment=$row['first_payment'];

                                            }else{
                                                $first_payment=0;

                                            }

                                            if(!empty($row['second_payment'])){

                                                $second_payment=$row['second_payment'];

                                            }else{
                                                $second_payment=0;

                                            }
                                            
                                            
                                            if(!empty($row['final_payment'])){

                                                $final_payment=$row['final_payment'];
                                                
                                            }else{

                                                $final_payment=0;

                                            }


                                            $remaining_amount=$row['agreed_amount']-$first_payment-$second_payment-$final_payment;
                                            
                                            if($remaining_amount==0){
                                                echo "<span style='color:white !important'>Payment Cleared</span>";

                                            }else{
                                                echo '<span style="color:white !important">'.$remaining_amount.'</span>/euro';

                                            }

                                        ?>
                                </td>
                                
                                <td><?=$row['refund_on_return'];?></td>
                  
                  
                  
                    

                     
                        </tr>
                  <?php
                     }
                  ?>
               </tbody>
               
            </table>
               </div>
           </div>
            <?php include('components/footer.php');?>
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