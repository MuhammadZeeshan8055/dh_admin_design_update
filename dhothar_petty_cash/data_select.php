<?php
error_reporting(0);
	$con = mysqli_connect("localhost","root","","petty_cash");
	if (mysqli_connect_errno())
	{
	echo "Failed to connect to MySQL: " . mysqli_connect_error() ." | Seems like you haven't created the DATABASE with an exact name";
	}
  
       if($_POST['date_select']){
		    list($date1,$date2) = explode('/',$_POST['date']);
		    
            	if($userrole==1){
                  
                	$exp_category_dc = mysqli_query($con, "SELECT expensecategory FROM expenses where (expensedate BETWEEN '$date1' AND '$date2') GROUP BY expensecategory");
                	$exp_amt_dc = mysqli_query($con, "SELECT SUM(expense) FROM expenses where (expensedate BETWEEN '$date1' AND '$date2') GROUP BY expensecategory");
                
                	$exp_date_line = mysqli_query($con, "SELECT expensedate FROM expenses where (expensedate BETWEEN '$date1' AND '$date2') GROUP BY expensedate");
                	$exp_amt_line = mysqli_query($con, "SELECT SUM(expense) FROM expenses where (expensedate BETWEEN '$date1' AND '$date2') GROUP BY expensedate");
                	
                	$exp_fetched = mysqli_query($con, "SELECT * FROM expenses where (expensedate BETWEEN '$date1' AND '$date2') order by expensedate");
                	
                		$food=mysqli_fetch_assoc(mysqli_query($con,"select SUM(expense) as food from expenses where expensecategory='food' and (expensedate BETWEEN '$date1' AND '$date2')"));
	                                           
										 	$total=mysqli_fetch_assoc(mysqli_query($con,"select SUM(expense) as total from expenses where (expensedate BETWEEN '$date1' AND '$date2')"));
	                                          
                            $x = $food['food']; 
                            $total = $total['total']; 
                            $calculate = ($x*100)/$total;
                            
                           
                            $food_percentage = (int)$calculate; 
                            
                            	$builty=mysqli_fetch_assoc(mysqli_query($con,"select SUM(expense) as builty from expenses where expensecategory='Builty & Cargo' and (expensedate BETWEEN '$date1' AND '$date2')"));
	                                           
							               
                            $b_c = $builty['builty']; 
                            $b_c_cal = ($b_c*100)/$total;
                            
                           
                            $builty_per = (int)$b_c_cal; 
                            
                            
                            	$other=mysqli_fetch_assoc(mysqli_query($con,"select SUM(expense) as other from expenses where expensecategory='others' and (expensedate BETWEEN '$date1' AND '$date2')"));
	                                           
										     
                            $oth = $other['other']; 
                           
                            $other_calculate = ($oth*100)/$total;
                            
                           
                            $other_percentage = (int)$other_calculate; 
                  
            
              }
              else{
            
                	$exp_category_dc = mysqli_query($con, "SELECT expensecategory FROM expenses WHERE (expensedate BETWEEN '$date1' AND '$date2') GROUP BY expensecategory");
                	$exp_amt_dc = mysqli_query($con, "SELECT SUM(expense) FROM expenses WHERE (expensedate BETWEEN '$date1' AND '$date2') GROUP BY expensecategory");
                
                	$exp_date_line = mysqli_query($con, "SELECT expensedate FROM expenses WHERE (expensedate BETWEEN '$date1' AND '$date2') GROUP BY expensedate");
                	$exp_amt_line = mysqli_query($con, "SELECT SUM(expense) FROM expenses WHERE (expensedate BETWEEN '$date1' AND '$date2') GROUP BY expensedate");
                	
                	$exp_fetched = mysqli_query($con, "SELECT * FROM expenses WHERE (expensedate BETWEEN '$date1' AND '$date2') order by expensedate");
            
              
                      	$food=mysqli_fetch_assoc(mysqli_query($con,"select SUM(expense) as food from expenses where expensecategory='food' and (expensedate BETWEEN '$date1' AND '$date2')"));
	                                           
										 	$total=mysqli_fetch_assoc(mysqli_query($con,"select SUM(expense) as total from expenses where (expensedate BETWEEN '$date1' AND '$date2')"));
	                                          
                            $x = $food['food']; 
                            $total = $total['total']; 
                            $calculate = ($x*100)/$total;
                            
                           
                            $food_percentage = (int)$calculate; 
                            
                            	$builty=mysqli_fetch_assoc(mysqli_query($con,"select SUM(expense) as builty from expenses where expensecategory='Builty & Cargo' and (expensedate BETWEEN '$date1' AND '$date2')"));
	                                           
							               
                            $b_c = $builty['builty']; 
                            $b_c_cal = ($b_c*100)/$total;
                            
                           
                            $builty_per = (int)$b_c_cal; 
                            
                            
                            	$other=mysqli_fetch_assoc(mysqli_query($con,"select SUM(expense) as other from expenses where expensecategory='others' and (expensedate BETWEEN '$date1' AND '$date2')"));
	                                           
										     
                            $oth = $other['other']; 
                           
                            $other_calculate = ($oth*100)/$total;
                            
                           
                            $other_percentage = (int)$other_calculate; 
                  
              }
  
		    
        }
        
        
        if($_POST['date_range']){
												
			$date1 = $_POST['date1'];
			$date2 = $_POST['date2'];
									
		 
            	if($userrole==1){
                  
                	$exp_category_dc = mysqli_query($con, "SELECT expensecategory FROM expenses where (expensedate BETWEEN '$date1' AND '$date2') GROUP BY expensecategory");
                	$exp_amt_dc = mysqli_query($con, "SELECT SUM(expense) FROM expenses where (expensedate BETWEEN '$date1' AND '$date2') GROUP BY expensecategory");
                
                	$exp_date_line = mysqli_query($con, "SELECT expensedate FROM expenses where (expensedate BETWEEN '$date1' AND '$date2') GROUP BY expensedate");
                	$exp_amt_line = mysqli_query($con, "SELECT SUM(expense) FROM expenses where (expensedate BETWEEN '$date1' AND '$date2') GROUP BY expensedate");
                	
                	$exp_fetched = mysqli_query($con, "SELECT * FROM expenses where (expensedate BETWEEN '$date1' AND '$date2') order by expensedate");
            
              }
              else{
            
                	$exp_category_dc = mysqli_query($con, "SELECT expensecategory FROM expenses WHERE (expensedate BETWEEN '$date1' AND '$date2') GROUP BY expensecategory");
                	$exp_amt_dc = mysqli_query($con, "SELECT SUM(expense) FROM expenses WHERE (expensedate BETWEEN '$date1' AND '$date2') GROUP BY expensecategory");
                
                	$exp_date_line = mysqli_query($con, "SELECT expensedate FROM expenses WHERE (expensedate BETWEEN '$date1' AND '$date2') GROUP BY expensedate");
                	$exp_amt_line = mysqli_query($con, "SELECT SUM(expense) FROM expenses WHERE (expensedate BETWEEN '$date1' AND '$date2') GROUP BY expensedate");
                	
                	$exp_fetched = mysqli_query($con, "SELECT * FROM expenses WHERE (expensedate BETWEEN '$date1' AND '$date2') order by expensedate");
            
              }
		}


  

?>
						
<?php 

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
<!doctype html>
<html lang="en">


<!-- Mirrored from codervent.com/dashtreme/demo/vertical/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 16 Jun 2022 11:27:11 GMT -->
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" />
	<!--plugins-->
	<link href="assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet"/>
	<link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
	<link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
	<link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
	<!-- loader-->
	<link href="assets/css/pace.min.css" rel="stylesheet" />
	<script src="assets/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/bootstrap-extended.css" rel="stylesheet">
	<link href="assets/css/bootstrap-extended.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
	<link href="assets/css/app.css" rel="stylesheet">
	<link href="assets/css/icons.css" rel="stylesheet">
	
	<style>

	    table.table-1 {
	        
            width: 	262%;
        }@media (max-width: 600px){
        input.form-control {
            width: 100px;
        }
         table.table-1 {
	        
            width: 163%;
        }
        }
	</style>
	
	<title>Dhothar - Petty Cash</title>
</head>

<body class="bg-theme bg-theme1">
	<!--wrapper-->
	<div class="wrapper">
		<!--sidebar wrapper -->
		<?php include('components/sidebar.php'); ?>
		<!--end sidebar wrapper -->
		<!--start header -->
			<?php include('components/header.php'); ?>
		<!--end header -->
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">

				<div class="card radius-10">
					<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 row-group g-0">
						<div class="col">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<h5 class="mb-0">
										
										<?php
                                           

										  if($userrole==1){
											$date=date('Y-m-d');
										   $monthly=mysqli_query($con,"select SUM(expense) as monthly from expenses where expensedate BETWEEN '$date1' AND '$date2' ");
										   
											while($monthly_sale = mysqli_fetch_assoc($monthly)){
													echo 'Rs '.number_format($monthly_sale['monthly'], 0, '.', ',');
											}
										  }else{
										
											$date=date('Y-m-d');
										   $monthly=mysqli_query($con,"select SUM(expense) as monthly from expenses where (expensedate BETWEEN '$date1' AND '$date2')");
										   
										   while($monthly_sale = mysqli_fetch_assoc($monthly)){
												echo 'Rs '.number_format($monthly_sale['monthly'], 0, '.', ',');
										   }
										  }

										//    $date=date('Y-m-d');
										//    $monthly=mysqli_query($con,"select SUM(expense) as monthly from expenses where expensedate='$date'");
										   
										//    while($monthly_sale = mysqli_fetch_assoc($monthly)){
										// 		echo 'Rs '.number_format($monthly_sale['monthly'], 0, '.', ',');
										//    }
										   
									   	?>
									</h5>
									<div class="ms-auto">
										<span style="font-size:1.3rem">PKR</span>
									</div>
								</div>
								<div class="progress my-3" style="height:3px;">
									<div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
								<div class="d-flex align-items-center text-white">
									<p class="mb-0"><?php if($selectOption!==''){echo $selectOption; }?> Expense</p>
									<!-- <p class="mb-0 ms-auto">+4.2%<span><i class='bx bx-up-arrow-alt'></i></span></p> -->
								</div>
							</div>
						</div>
						<div class="col">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<h5 class="mb-0">
										<?php
                                           
										   if($userrole==1){
											$monthly=mysqli_query($con,"select SUM(expense) as monthly from expenses where MONTH(expensedate)=MONTH(now())");
										   
										   while($monthly_sale = mysqli_fetch_assoc($monthly)){
												echo 'Rs '.number_format($monthly_sale['monthly'], 0, '.', ',');
										   }
										  }else{
										
											$monthly=mysqli_query($con,"select SUM(expense) as monthly from expenses where MONTH(expensedate)=MONTH(now())");
										   
										   while($monthly_sale = mysqli_fetch_assoc($monthly)){
												echo 'Rs '.number_format($monthly_sale['monthly'], 0, '.', ',');
										   }
										  }
										//    $monthly=mysqli_query($con,"select SUM(expense) as monthly from expenses where MONTH(expensedate)=MONTH(now()) and YEAR(expensedate)=YEAR(now())");
										   
										//    while($monthly_sale = mysqli_fetch_assoc($monthly)){
										// 		echo 'Rs '.number_format($monthly_sale['monthly'], 0, '.', ',');
										//    }
										   
									   	?>
									</h5>
									<div class="ms-auto">
                                        <span style="font-size:1.3rem">PKR</span>
									</div>
								</div>
								<div class="progress my-3" style="height:3px;">
									<div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
								<div class="d-flex align-items-center text-white">
									<p class="mb-0">This Month Expense</p>
									<!-- <p class="mb-0 ms-auto">+1.2%<span><i class='bx bx-up-arrow-alt'></i></span></p> -->
								</div>
							</div>
						</div>
						<div class="col">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<h5 class="mb-0">
										<?php
                                           
										   if($userrole==1){
											$cash=mysqli_fetch_assoc(mysqli_query($con,"select sum(cash) as cash from cash where (cashdate BETWEEN '$date1' AND '$date2') and YEAR(cashdate)=YEAR(now())"));

										  	echo 'Rs '.number_format($cash['cash'], 0, '.', ',');
										   
										  }else{
										
											$cash=mysqli_fetch_assoc(mysqli_query($con,"select sum(cash) as cash from cash where (cashdate BETWEEN '$date1' AND '$date2') and YEAR(cashdate)=YEAR(now())"));

										  	echo 'Rs '.number_format($cash['cash'], 0, '.', ',');
										   
										  }
										//    $cash=mysqli_fetch_assoc(mysqli_query($con,"select sum(cash) as cash from cash where MONTH(cashdate)=MONTH(now()) and YEAR(cashdate)=YEAR(now())"));

										//   	echo 'Rs '.number_format($cash['cash'], 0, '.', ',');
										   
									   	?>
									</h5>
									<div class="ms-auto">
										<span style="font-size:1.3rem">PKR</span>
									</div>
								</div>
								<div class="progress my-3" style="height:3px;">
									<div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
								<div class="d-flex align-items-center text-white">
									<p class="mb-0"><?=$selectOption?> Cash Received</p>
									<!-- <p class="mb-0 ms-auto">+5.2%<span><i class='bx bx-up-arrow-alt'></i></span></p> -->
								</div>
							</div>
						</div>
						<div class="col">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<h5 class="mb-0">
										<?php

											if($userrole==1){
											      $remaining_amount=mysqli_fetch_assoc(mysqli_query($con,"select sum(amount) as remaining_cash from remaining_balance"));
                                                $p_month_amount=$remaining_amount['remaining_cash'];
                                                
                                                
												$cash=mysqli_fetch_assoc(mysqli_query($con,"select sum(cash) as cash from cash where MONTH(cashdate)=MONTH(now()) and YEAR(cashdate)=YEAR(now())"));

												$cash_in_hand=$cash['cash']+$p_month_amount;
	 
												$expenses=mysqli_fetch_assoc(mysqli_query($con,"select sum(expense) as expense from expenses where MONTH(expensedate)=MONTH(now()) and YEAR(expensedate)=YEAR(now())"));
	 
												 $expense=$expenses['expense'];
											   
												$remaining_balance=$cash_in_hand-$expense;
	 
											   echo 'Rs '.number_format($remaining_balance, 0, '.', ',');
											
											}else{

                                                $remaining_amount=mysqli_fetch_assoc(mysqli_query($con,"select sum(amount) as remaining_cash from remaining_balance where user_id='$userid'"));
                                                $p_month_amount=$remaining_amount['remaining_cash'];
                                                
                                                // echo $p_month_amount;
											
												$cash=mysqli_fetch_assoc(mysqli_query($con,"select sum(cash) as cash from cash where MONTH(cashdate)=MONTH(now()) and YEAR(cashdate)=YEAR(now())"));

												$cash_in_hand=$cash['cash']+$p_month_amount;
	 
												$expenses=mysqli_fetch_assoc(mysqli_query($con,"select sum(expense) as expense from expenses where MONTH(expensedate)=MONTH(now()) and YEAR(expensedate)=YEAR(now())"));
	 
												 $expense=$expenses['expense'];
											   
												$remaining_balance=$cash_in_hand-$expense;
	 
											   echo 'Rs '.number_format($remaining_balance, 0, '.', ',');
											
											}

                                        //    $cash=mysqli_fetch_assoc(mysqli_query($con,"select sum(cash) as cash from cash where MONTH(cashdate)=MONTH(now()) and YEAR(cashdate)=YEAR(now())"));

										//    $cash_in_hand=$cash['cash'];

										//    $expenses=mysqli_fetch_assoc(mysqli_query($con,"select sum(expense) as expense from expenses where MONTH(expensedate)=MONTH(now()) and YEAR(expensedate)=YEAR(now())"));

										//     $expense=$expenses['expense'];
										  
										//    $remaining_balance=$cash_in_hand-$expense;

										//   echo 'Rs '.number_format($remaining_balance, 0, '.', ',');
										   
									   	?>
									</h5>
									<div class="ms-auto">
										<span style="font-size:1.3rem">PKR</span>
									</div>
								</div>
								<div class="progress my-3" style="height:3px;">
									<div class="progress-bar" role="progressbar" style="width: 55%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
								<div class="d-flex align-items-center text-white">
									<p class="mb-0">Current Remaining Balance</p>
									<!-- <p class="mb-0 ms-auto">+2.2%<span><i class='bx bx-up-arrow-alt'></i></span></p> -->
								</div>
							</div>
						</div>
						
					</div><!--end row-->
				</div>
				
					<div class="row">
        				<div class="col-12 col-lg-6 col-xl-6 d-flex">
    					   <div class="card radius-10 overflow-hidden w-100">
    						  <div class="card-body">
    							<div class="d-flex align-items-center">
    								 <form action="data_select" method="post">
                    
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
    					   <div class="card radius-10 overflow-hidden w-100">
    						  <div class="card-body">
    							<div class="d-flex align-items-center">
    								 
                     
                                             <form action="data_select" method="post">
                                            
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

				<div class="row">
				<div class="col-12 col-lg-6 col-xl-6 d-flex">
					   <div class="card radius-10 overflow-hidden w-100">
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
					   <div class="card radius-10 overflow-hidden w-100">
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
<span class="percent" style="text-align: center;">Builty & Cargo : <?= $builty_per.'%';?> &nbsp;&nbsp;&nbsp; Food : <?= $food_percentage.'%';?> &nbsp;&nbsp; Other : <?= $other_percentage.'%';?></span>

						</div>
					</div>
				   </div><!--End Row-->



					
					 
					  <div class="card radius-10">
						<div class="card-body">
							<div class="d-flex align-items-center">
								<div>
									<h5 class="mb-0">Orders Summary</h5>
								</div>
								<div class="font-22 ms-auto"><i class="bx bx-dots-horizontal-rounded"></i>
								</div>
							</div>
							<hr>
							<div class="table-responsive">
								<table class="table align-middle mb-0">
									<thead class="table-light">
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

		
												$count=1; while ($row = mysqli_fetch_array($exp_fetched)) { 

													$total= $row['expense'];

													$subtotal+=$total;

													
											?>
										
										<tr>
											<td><?php echo $count++?></td>
											<td>
												<div class="d-flex align-items-center">
													<a href="http://estyler.pk/petty_cash/uploads/<?php echo $row['slip']; ?>" target="_blank" class="btn"><button style="background: none;color: white;border: 1px solid;"> <small> see image </small></button></a>
											
													
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
												
													$sql=mysqli_fetch_assoc(mysqli_query($con,"select * from users where user_id='$row[user_id]'"));
													
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
											<!-- <td>
												<div class="badge rounded-pill bg-light w-100">Completed</div>
											</td>
											<td>
												<div class="d-flex order-actions">	<a href="javascript:;" class=""><i class="bx bx-cog"></i></a>
													<a href="javascript:;" class="ms-4"><i class="bx bx-down-arrow-alt"></i></a>
												</div>
											</td> -->
										</tr>


										<?php } ?>

									</tbody>
								</table>
							</div>
						</div>
					</div>

			</div>
		</div>
		<!--end page wrapper -->
		<!--start overlay-->
		<div class="overlay toggle-icon"></div>
		<!--end overlay-->
		<!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
		<!--End Back To Top Button-->
		
	</div>
	<!--end wrapper-->
	
	<!-- Bootstrap JS -->
	<script src="assets/js/bootstrap.bundle.min.js"></script>
	<!--plugins-->
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
	<script src="assets/plugins/chartjs/js/Chart.min.js"></script>
	<script src="assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js"></script>
	<script src="assets/plugins/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
	<script src="assets/plugins/sparkline-charts/jquery.sparkline.min.js"></script>
	<script src="assets/plugins/jquery-knob/excanvas.js"></script>
	<script src="assets/plugins/jquery-knob/jquery.knob.js"></script>
	  <script>
		  $(function() {
			  $(".knob").knob();
		  });
	  </script>
	  <script src="assets/js/index.js"></script>
	<!--app JS-->
	<script src="assets/js/app.js"></script>
</body>


<!-- Mirrored from codervent.com/dashtreme/demo/vertical/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 16 Jun 2022 11:27:46 GMT -->
</html>