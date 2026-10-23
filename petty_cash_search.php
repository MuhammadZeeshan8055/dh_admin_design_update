<?php
    
    $conn = mysqli_connect("localhost","root","","petty_cash");
    if (mysqli_connect_errno())
      {
      echo "Failed to connect to MySQL: " . mysqli_connect_error() ." | Seems like you haven't created the DATABASE with an exact name";
      }
    
    include('session.php');


    $date=date('Y-m-d');

    if(isset($_POST['date_select'])){
        list($date1,$date2) = explode('/',$_POST['date']);
        
        $exp_category_dc = mysqli_query($conn, "SELECT expensecategory FROM expenses WHERE (expensedate BETWEEN '$date1' AND '$date2') GROUP BY expensecategory");
        $exp_amt_dc = mysqli_query($conn, "SELECT SUM(expense) FROM expenses WHERE (expensedate BETWEEN '$date1' AND '$date2') GROUP BY expensecategory");
    
        $exp_date_line = mysqli_query($conn, "SELECT expensedate FROM expenses WHERE (expensedate BETWEEN '$date1' AND '$date2') GROUP BY expensedate");
        $exp_amt_line = mysqli_query($conn, "SELECT SUM(expense) FROM expenses WHERE (expensedate BETWEEN '$date1' AND '$date2') GROUP BY expensedate");
        
        $exp_fetched = mysqli_query($conn, "SELECT * FROM expenses WHERE (expensedate BETWEEN '$date1' AND '$date2') order by expensedate");

    }

  if(isset($_POST['date_range'])){
												
        $date1 = $_POST['date1'];
        $date2 = $_POST['date2'];

        $exp_category_dc = mysqli_query($conn, "SELECT expensecategory FROM expenses WHERE (expensedate BETWEEN '$date1' AND '$date2') GROUP BY expensecategory");
        $exp_amt_dc = mysqli_query($conn, "SELECT SUM(expense) FROM expenses WHERE (expensedate BETWEEN '$date1' AND '$date2') GROUP BY expensecategory");
    
        $exp_date_line = mysqli_query($conn, "SELECT expensedate FROM expenses WHERE (expensedate BETWEEN '$date1' AND '$date2') GROUP BY expensedate");
        $exp_amt_line = mysqli_query($conn, "SELECT SUM(expense) FROM expenses WHERE (expensedate BETWEEN '$date1' AND '$date2') GROUP BY expensedate");
        
        $exp_fetched = mysqli_query($conn, "SELECT * FROM expenses WHERE (expensedate BETWEEN '$date1' AND '$date2') order by expensedate");
    }



    $today_date 		= date('Y-m-d').'/'.date('Y-m-d'); 
    $yesterday_date 	= date('Y-m-d', strtotime(date('Y-m-d')." -1 day")).'/'.date('Y-m-d', strtotime(date('Y-m-d')." -1 day"));
    $last7days_date 	= date('Y-m-d', strtotime(date('Y-m-d')." -6 day")).'/'.date('Y-m-d');
    $thismonth_date 	= date('Y-m-d', strtotime(date('Y-m-')."1")).'/'.date('Y-m-t', strtotime(date('Y-m-d')));
    $lastmonth_date 	= date('Y-m-d', strtotime(date('Y-m-')."1 -1 month")).'/'.date('Y-m-t', strtotime(date('Y-m-d')."-1 month"));
    $thisyear_date 		= date('Y-01-01').'/'.date('Y-12-31');
    $lastyear_date 		= date('Y-01-01', strtotime(date('Y-01-01')."-1 year")).'/'.date('Y-12-31', strtotime(date('Y-12-31')."-1 year"));
    $alltime_date 		= '1969-12-31/'.date('Y-12-31');

   					
    if($_POST['date']==$today_date){
      $selectOption = "Today";
   }	
   if($_POST['date']==$yesterday_date){
      $selectOption = "Yesterday";
   }	
   if($_POST['date']==$last7days_date){
      $selectOption = "Last 7 Days";
   }	
   if($_POST['date']==$thismonth_date){
      $selectOption = "This Month";
   }	
   if($_POST['date']==$lastmonth_date){
      $selectOption = "Last Month";
   }	
   if($_POST['date']==$thisyear_date){
      $selectOption = "This Year";
   }	
   if($_POST['date']==$lastyear_date){
      $selectOption = "Last Year";
   }	
   if($_POST['date']==$alltime_date){
      $selectOption = "All Time";
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
                           $total_cash=mysqli_fetch_assoc(mysqli_query($conn,"SELECT sum(cash) as total_cash FROM cash where cashdate between '$date1' and '$date2'"));
                        ?>
                     <div class="icon"><i class="entypo-users"></i></div>
                     <div class="num" data-start="0" data-end="<?=$total_cash['total_cash'];?>" data-postfix data-duration="1500" data-delay="0"><?=number_format($total_cash['total_cash'], 0, '.', ',')?></div>
                     <h3>Total Cash Received</h3>
                     <p>Total Cash Received This Month.</p>
                  </div>
               </div>
               <div class="col-sm-3 col-xs-6">
                  <div class="tile-stats tile-green">
                        <?php 
                           $cash=mysqli_fetch_assoc(mysqli_query($conn,"select sum(cash) as cash from cash where year(cashdate)=year(now())"));
                                                
                           $expenses=mysqli_fetch_assoc(mysqli_query($conn,"select sum(expense) as expense from expenses where year(expensedate)=year(now())"));

                              $remaining_balance=$cash['cash']-$expenses['expense'];
                           
                           // echo 'Rs '.number_format($remaining_balance, 0, '.', ',');
                        ?>
                     <div class="icon"><i class="entypo-chart-bar"></i></div>
                     <div class="num" data-start="0" data-end="<?=$remaining_balance?>" data-postfix data-duration="1500" data-delay="600">0</div>
                     <h3>Current Remaining Balance</h3>
                     <p>Total Cash Remaining Overall.</p>

                  </div>
               </div>
               <div class="clear visible-xs"></div>
               <div class="col-sm-3 col-xs-6">
                  <div class="tile-stats tile-aqua">
                     <?php
                        $monthy_expense=mysqli_fetch_assoc(mysqli_query($conn,"select sum(expense) as monthy_expense from expenses where MONTH(expensedate)=MONTH(now())"));
                             
                        
                     ?>
                     <div class="icon"><i class="entypo-mail"></i></div>
                     <div class="num" data-start="0" data-end="<?=$monthy_expense['monthy_expense']?>" data-postfix data-duration="1500" data-delay="1200">0</div>
                     <h3>This Month Expense</h3>
                     <p>This Month Overall Expense.</p>
                  </div>
               </div>
               <div class="col-sm-3 col-xs-6">
                  <div class="tile-stats tile-blue">
                     <?php

                       $today_expense=mysqli_fetch_assoc(mysqli_query($conn,"select sum(expense) as today_expense from expenses where (expensedate BETWEEN '$date1' AND '$date2')"));
                          
                     ?>
                     <div class="icon"><i class="entypo-rss"></i></div>
                     <div class="num" data-start="0" data-end="<?=$today_expense['today_expense']?>" data-postfix data-duration="1500" data-delay="1800">0</div>
                     <h3>Expense</h3>
                     <p>Expense Calculation</p>
                  </div>
               </div>
            </div>
            <br/> 

            
					<div class="row">
        				<div class="col-12 col-lg-6 col-xl-6 d-flex" >
    					   	<div class="card radius-10 overflow-hidden w-100">
    						  <div class="card-body">
    							<div class="d-flex align-items-center">
    								 <form action="petty_cash_search" method="post">
                    
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
    								 
                     
                                             <form action="petty_cash_search.php" method="post">
                                            
                                              <table class="table-2">
                                                <tr>
                                                    <td> <input type='date' name='date1' class='form-control' value="<?= $_POST['date1']; ?>"   />
    				                                    </td>
                                                     <td>   <input type='date' name='date2' class='form-control' value="<?= $_POST['date2']; ?>"   />
                                
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

               <div class="row">
					<div class="col-12 col-lg-6 col-xl-6 d-flex">
					   <div class="card radius-10 overflow-hidden w-100" style="background:#00c0ef">
						  <div class="card-body">
							<div class="d-flex align-items-center">
								<div>
									<h6 class="mb-0">Monthly Expense</h6>
								</div>
								<div class="font-22 ms-auto text-white"><i class="bx bx-dots-horizontal-rounded"></i>
								</div>
							</div>
												
									<canvas id="myChart" ></canvas>	
									</div>
									<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
					
										</script>
	
						</div>
					</div>
			   
					<div class="col-12 col-lg-6 col-xl-6 d-flex">
					   <div class="card radius-10 overflow-hidden w-100" style="background:#00c0ef;">
						  <div class="card-body">
							<div class="d-flex align-items-center">
								<div>
									<h6 class="mb-0">Monthly Expense</h6>
								</div>
								<div class="font-22 ms-auto text-white"><i class="bx bx-dots-horizontal-rounded"></i>
								</div>
							</div>
							<div>
							    
								<canvas id="myChart2"></canvas>
							</div>
 			
									</div>
									<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
									<script>  // === include 'setup' then 'config' above ===
                                  Chart.defaults.color = "white";
                                //   Chart.defaults.backgroundcolor = "re";
							
							      const ctx = document.getElementById('myChart');
									const ctx2 = document.getElementById('myChart2');

									const myChart = new Chart(ctx, {
									type: 'line',
									data: {
										labels:  [<?php while ($c = mysqli_fetch_array($exp_date_line)) {
														echo '"' . $c['expensedate'] . '",';
													} ?>],
											datasets: [{
											label: 'Expense by Date',
											data: [<?php while ($d = mysqli_fetch_array($exp_amt_line)) {
														echo '"' . $d['SUM(expense)'] . '",';
													} ?>],
											borderColor: [
												'#adb5bd'
											],
											backgroundColor: [
												'#6f42c1',
												'#dc3545',
												'#28a745',
												'#007bff',
												'#ffc107',
												'#20c997',
												'#17a2b8',
												'#fd7e14',
												'#e83e8c',
												'#6610f2'
											],
											fill: false,
											borderWidth: 2
											}]
									},
									});

									const myChart2 = new Chart(ctx2, {
									type: 'bar',
									data: {
										labels: [<?php while ($a = mysqli_fetch_array($exp_category_dc)) {
														echo '"' . $a['expensecategory'] . '",';
													} ?>],
									datasets: [{
											label: 'Expense by Category',
											data: [<?php while ($b = mysqli_fetch_array($exp_amt_dc)) {
														echo '"' . $b['SUM(expense)'] . '",';
													} ?>],
													
										
													backgroundColor: [
																			'rgba(255, 99, 132, 0.2)',
																			'rgba(255, 159, 64, 0.2)',
																			'rgba(255, 205, 86, 0.2)',
																			'rgba(75, 192, 192, 0.2)',
																			'rgba(54, 162, 235, 0.2)',
																			'rgba(153, 102, 255, 0.2)',
																			'rgba(201, 203, 207, 0.2)'
																		],
																		borderColor: [
																			'rgb(255, 99, 132)',
																			'rgb(255, 159, 64)',
																			'rgb(255, 205, 86)',
																			'rgb(75, 192, 192)',
																			'rgb(54, 162, 235)',
																			'rgb(153, 102, 255)',
																			'rgb(201, 203, 207)'
																		],
																		borderWidth: 1
											}]
									},
									});
									</script>						
									<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
									
						</div>
					</div>
				</div><!--End Row-->

            <br/> 
           <div class="row">
               <div class="col-md-12">
               <h3>Petty Cash Data</h3>
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
											<th>Slip</th>
											<th>Expense Category</th>
											<th>Remarks</th>
											<th>Entry By</th>
											<th>Date</th>
											<th>Expense</th>      
                  
                     
                  </tr>
               </thead>
               <tbody>
                                 <?php
												$subtotal=0;

                                    
												$count=1; 
                                    while ($row = mysqli_fetch_array($exp_fetched)) { 

													$total= $row['expense'];

													$subtotal+=$total;

													
											?>
                  <tr>
                                 <td><?php echo $count++?></td>
											<td>
												<div class="d-flex align-items-center">
													
														<a href="http://localhost/dhothar_admin_panel/petty_cash/uploads/<?php echo $row['slip']; ?>" target="_blank" class="btn"><button style="background: none;border: 1px solid;"> <small> see image </small></button></a>
													
													
												</div>
											</td>
											<td>
												<?php echo $row['expensecategory']; ?>
											</td>
												<td>
												<?php echo $row['description']; ?>
											</td>
											<td>
													
												<?php
												
													$sql=mysqli_fetch_assoc(mysqli_query($conn,"select * from users where user_id='$row[user_id]'"));
													
													echo $sql['firstname'] .'&nbsp'. $sql['lastname'] ;
												?>

												<?php

												?>

											</td>
											<td>
												<?php $date= $row['expensedate']; 
													$cls_date = new DateTime($date);
													echo $cls_date->format('d-m-Y');
												?>
											</td>
											<td><?php echo $row['expense']; ?></td>
                     
                  
                  
                  
                     </td>

                     
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
<script src="assets/js/neon-custom.js" id="script-resource-11"></script>  
</body>
</html>