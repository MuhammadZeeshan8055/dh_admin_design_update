<?php
   include('database/db_connection.php');
   include('session.php');

   $_SESSION['country']='Romania';

   if(isset($_GET['country'])){
      
      $country=$_GET['country'];

      $_SESSION['country']=$_GET['country'];
   
      
   }
   
   
    if(isset($_POST['date_select'])){
        list($date1,$date2) = explode('/',$_POST['date']);
      
    }

    if(isset($_POST['date_range'])){
												
        $date1 = $_POST['date1'];
        $date2 = $_POST['date2'];
    }
    

   if($_SESSION['country']=='Romania'){
      $exp_category_dc = mysqli_query($con, "SELECT status FROM new_case_details WHERE entry_date between '$date1' and '$date2' and country='$_SESSION[country]' GROUP BY status");
      $exp_amt_dc = mysqli_query($con, "SELECT count(id) FROM new_case_details WHERE entry_date between '$date1' and '$date2' and country='$_SESSION[country]' GROUP BY status");
   
      $exp_date_line = mysqli_query($con, "SELECT entry_date FROM new_case_details WHERE entry_date between '$date1' and '$date2' and country='$_SESSION[country]' GROUP BY entry_date");
      $exp_amt_line = mysqli_query($con, "SELECT count(id) FROM new_case_details WHERE entry_date between '$date1' and '$date2' and country='$_SESSION[country]' GROUP BY entry_date");
   
   }else{
      $exp_category_dc = mysqli_query($con, "SELECT status FROM new_case_details WHERE entry_date between '$date1' and '$date2' and country='$_SESSION[country]' GROUP BY status");
      $exp_amt_dc = mysqli_query($con, "SELECT count(id) FROM new_case_details WHERE entry_date between '$date1' and '$date2' and country='$_SESSION[country]' GROUP BY status");
   
      $exp_date_line = mysqli_query($con, "SELECT entry_date FROM new_case_details WHERE entry_date between '$date1' and '$date2' and country='$_SESSION[country]' GROUP BY entry_date");
      $exp_amt_line = mysqli_query($con, "SELECT count(id) FROM new_case_details WHERE entry_date between '$date1' and '$date2' and country='$_SESSION[country]' GROUP BY entry_date");
   
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
      <title>Dhothar International | Dashboard</title>
      <link rel="stylesheet" href="assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css" id="style-resource-1">
      <link rel="stylesheet" href="assets/css/font-icons/entypo/css/entypo.css" id="style-resource-2">
      <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic" id="style-resource-3">
      <link rel="stylesheet" href="assets/css/bootstrap.css" id="style-resource-4">
      <link rel="stylesheet" href="assets/css/neon-core.css" id="style-resource-5">
      <link rel="stylesheet" href="assets/css/neon-theme.css" id="style-resource-6">
      <link rel="stylesheet" href="assets/css/neon-forms.css" id="style-resource-7">
      <link rel="stylesheet" href="assets/css/custom.css" id="style-resource-8">
      <style>
            .card.radius-10.overflow-hidden.w-100 {
               padding: 10px 10px 10px 10px;
               box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
            }
            .tile-stats.tile-red{
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
      <script src="assets/js/jquery-1.11.3.min.js"></script> 
   </head>
   <body class="">
      <div class="page-container">
         <div class="sidebar-menu">
            <?php include('components/sidebar.php'); ?>
         </div>
         <div class="main-content">

           <?php include('components/header.php'); ?>

            <hr/>

            <?php
               if($country=='' || $country=='Romania'){
            ?>

               <div class="row">
                  <div class="col-sm-4 col-xs-6">
                      <a href="total_registered_cases?date1=<?=$date1?>&date2=<?=$date2?>"> 
                        <div class="tile-stats tile-green">
                           <div class="icon"><i class="entypo-users"></i></div>

                           <?php 
                              $count_total_records=mysqli_fetch_assoc(mysqli_query($con,"select count(id) as total_records from new_case_details where entry_date between '$date1' and '$date2' and country='$_SESSION[country]'"));
                           ?>

                           <div class="num" data-start="0" data-end="<?=$count_total_records['total_records'];?>" data-postfix data-duration="1500" data-delay="0">0</div>
                           <h3>Total Registered Cases</h3>
                           
                        </div>
                      </a> 
                  </div>
                  <div class="col-sm-4 col-xs-6">
                     <a href="status_wise_data?status=Ready To Apply&date1=<?=$date1?>&date2=<?=$date2?>">

                        <div class="tile-stats tile-aqua">
                           <div class="icon"><i class="entypo-chart-bar"></i></div>
                           <?php 
                              $ready_to_apply=mysqli_fetch_assoc(mysqli_query($con,"select status,count(id) as ready_to_apply from new_case_details where status='Ready To Apply' and docs_missing!='Yes' and country='$_SESSION[country]' and status_updated_at between '$date1' and '$date2'"));
                           ?>
                           <div class="num" data-start="0" data-end="<?=$ready_to_apply['ready_to_apply'];?>" data-postfix data-duration="1500" data-delay="600">0</div>
                           <h3>Ready To Apply</h3>
                           
                        </div>

                     </a>
                  </div>
                  <div class="clear visible-xs"></div>
                  <div class="col-sm-4 col-xs-6">
                     <a href="status_wise_data?status=Applied&date1=<?=$date1?>&date2=<?=$date2?>">

                        <div class="tile-stats tile-blue">
                           <div class="icon"><i class="entypo-mail"></i></div>
                           <?php 
                              $applied=mysqli_fetch_assoc(mysqli_query($con,"select status,count(id) as applied from new_case_details where status='Applied' and country='$_SESSION[country]' 
                                          AND docs_missing != 'Yes' and status_updated_at between '$date1' and '$date2'"));
                           ?>
                           <div class="num" data-start="0" data-end="<?=$applied['applied'];?>" data-postfix data-duration="1500" data-delay="1200">0</div>
                           <h3>Applied</h3>
                           
                        </div>

                     </a>
                  </div>
               
                  <div class="col-sm-4 col-xs-6">
                     <div class="tile-stats tile-green" onclick="window.location='status_wise_data?status=<?= urlencode('Work Permit Issued') ?>&date1=<?=$date1?>&date2=<?=$date2?>'" style="cursor:pointer">
                        <?php 
                              $work_permit_issued = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(id) AS work_permit_issued FROM new_case_details WHERE status IN ('Work Permit Issued', 'Appointment Applied') AND country='$_SESSION[country]' AND status_updated_at BETWEEN '$date1' AND '$date2'"));
                              $waiting_for_appointments = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(id) AS waiting_for_appointments FROM new_case_details WHERE status='Work Permit Issued' AND (appointment_date IS NULL OR appointment_date = '') AND country='$_SESSION[country]' AND status NOT IN ('Returned', 'Fly') AND status_updated_at BETWEEN '$date1' AND '$date2'"));
                        ?>
                        <div class="icon"><i class="entypo-rss"></i></div>
                        <div class="num" data-start="0" data-end="<?=$work_permit_issued['work_permit_issued'];?>" data-postfix data-duration="1500" data-delay="1800">0</div>
                        <h3>Work Permit Issued
                              <span onclick="event.stopPropagation(); window.location='waiting_for_appointments?status=<?= urlencode('Work Permit Issued') ?>&date1=<?=$date1?>&date2=<?=$date2?>';" style="font-size:1.1rem; display:block; margin-top:5px; cursor:pointer;">
                                 Waiting For Appointment (<?=$waiting_for_appointments['waiting_for_appointments'];?>)
                              </span>
                        </h3>
                     </div>
                  </div>
                  <div class="col-sm-4 col-xs-6">
                     <a href="status_wise_data?status=Appointment Applied&date1=<?=$date1?>&date2=<?=$date2?>">

                        <div class="tile-stats tile-aqua">
                           <?php 
                              $appointment_applied=mysqli_fetch_assoc(mysqli_query($con,"select status,count(id) as appointment_applied from new_case_details where status='Appointment Applied' and country='$_SESSION[country]' and status_updated_at between '$date1' and '$date2'"));
                           ?>
                           <div class="icon"><i class="entypo-rss"></i></div>
                           <div class="num" data-start="0" data-end="<?=$appointment_applied['appointment_applied'];?>" data-postfix data-duration="1500" data-delay="1800">0</div>
                           <h3>Appointment Applied</h3>
                           
                        </div>

                     </a>
                  </div>
                  <div class="col-sm-4 col-xs-6">
                     <a href="status_wise_data?status=Visa Issued&date1=<?=$date1?>&date2=<?=$date2?>">

                        <div class="tile-stats tile-blue">
                           <?php 
                              $sql = "select status,count(id) as visa_issued from new_case_details where status='Visa Issued' and country='$_SESSION[country]' and status_updated_at between '$date1' and '$date2'";
                            //   echo $sql;
                              $visa_issued=mysqli_fetch_assoc(mysqli_query($con,$sql));
                           ?>
                           <div class="icon"><i class="entypo-rss"></i></div>
                           <div class="num" data-start="0" data-end="<?=$visa_issued['visa_issued'];?>" data-postfix data-duration="1500" data-delay="1800">0</div>
                           <h3>Visa Issued</h3>
                           
                        </div>

                     </a>
                  </div>
                  <div class="col-sm-4 col-xs-6">
                     <a href="status_wise_data?status=Return From Embassy&date1=<?=$date1?>&date2=<?=$date2?>">
                     
                        <div class="tile-stats tile-red">
                           <?php 
                              $rejected_from_embassy=mysqli_fetch_assoc(mysqli_query($con,"select status,count(id) as rejected_from_embassy from new_case_details where status='Return From Embassy' and country='$_SESSION[country]' and status_updated_at between '$date1' and '$date2'"));
                           ?>
                           <div class="icon"><i class="entypo-rss"></i></div>
                           <div class="num" data-start="0" data-end="<?=$rejected_from_embassy['rejected_from_embassy'];?>" data-postfix data-duration="500" data-delay="1800">0</div>
                           <h3>Return From Embassy</h3>
                           
                        </div>

                     </a>
                  </div>
                  <div class="col-sm-4 col-xs-6">
                     <a href="status_wise_data?status=Fly&date1=<?=$date1?>&date2=<?=$date2?>">

                        <div class="tile-stats tile-green">
                           <?php 
                              $fly=mysqli_fetch_assoc(mysqli_query($con,"select status,count(id) as fly from new_case_details where status='Fly' and status_updated_at between '$date1' and '$date2'"));
                           ?>
                           <div class="icon"><i class="entypo-rss"></i></div>
                           <div class="num" data-start="0" data-end="<?=$fly['fly'];?>" data-postfix data-duration="1500" data-delay="1800">0</div>
                           <h3>Departed</h3>
                           
                        </div>

                     </a>
                  </div>
                  <div class="col-sm-4 col-xs-6">
                     <a href="status_wise_data?status=Returned&date1=<?=$date1?>&date2=<?=$date2?>">
                     
                        <div class="tile-stats tile-red">
                           <?php 
                              $returned=mysqli_fetch_assoc(mysqli_query($con,"select status,count(id) as returned from new_case_details where (status='Returned' or status='Request Returned') and country='$_SESSION[country]' and status_updated_at between '$date1' and '$date2'"));
                           ?>
                           <div class="icon"><i class="entypo-rss"></i></div>
                           <div class="num" data-start="0" data-end="<?=$returned['returned'];?>" data-postfix data-duration="1500" data-delay="1800">0</div>
                           <h3>Returned</h3>
                           
                        </div>

                     </a>
                  </div>

                  <div class="col-sm-4 col-xs-6">
                     <a href="status_wise_data?status=Yes">
                     
                        <div class="tile-stats tile-red">
                           <?php 
                              $missing_documents=mysqli_fetch_assoc(mysqli_query($con,"select status,count(id) as missing_documents from new_case_details where docs_missing='Yes' and country='$_SESSION[country]'  AND status NOT IN ('Returned', 'Fly') and status_updated_at between '$date1' and '$date2'"));
                           ?>
                           <div class="icon"><i class="entypo-rss"></i></div>
                           <div class="num" data-start="0" data-end="<?=$missing_documents['missing_documents'];?>" data-postfix data-duration="1500" data-delay="1800">0</div>
                           <h3>Missing Documents</h3>
                           
                        </div>

                     </a>
                  </div>
                  
                  <div class="col-sm-4 col-xs-6">
                     <a href="status_wise_data?status=passport_expiry_under_year">
                     
                        <div class="tile-stats tile-red">
                           <?php 
                              $passport_expiry_under_year=mysqli_fetch_assoc(mysqli_query($con,"SELECT status,count(id) as passport_expiry_under_year FROM new_case_details 
                                WHERE pp_expiry BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 YEAR)
                                 and country='$_SESSION[country]' AND status NOT IN ('Returned', 'Fly')"));
                           ?>
                           <div class="icon"><i class="entypo-rss"></i></div>
                           <div class="num" data-start="0" data-end="<?=$passport_expiry_under_year['passport_expiry_under_year'];?>" data-postfix data-duration="1500" data-delay="1800">0</div>
                           <h3>PP EXPIRY UNDER 1 YEAR</h3>
                           
                        </div>

                     </a>
                  </div>
                  
                  <div class="col-sm-4 col-xs-6">
                     <a href="status_wise_data?status=passport_expired">
                     
                        <div class="tile-stats tile-red">
                           <?php 
                              $passport_expired=mysqli_fetch_assoc(mysqli_query($con,"SELECT count(id) as passport_expired FROM new_case_details WHERE pp_expiry < CURDATE() and country='$_SESSION[country]' AND status NOT IN ('Returned', 'Fly')"));
                           ?>
                           <div class="icon"><i class="entypo-rss"></i></div>
                           <div class="num" data-start="0" data-end="<?=$passport_expired['passport_expired'];?>" data-postfix data-duration="1500" data-delay="1800">0</div>
                           <h3>EXPIRED PASSPORTS</h3>
                           
                        </div>

                     </a>
                  </div>
                  
                  <div class="col-sm-4 col-xs-6">
                     <a href="status_wise_data?status=character_expiry">
                     
                        <div class="tile-stats tile-red">
                           <?php 
                                //   $character_expiry=mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(id) AS first_character_expiry_count FROM new_case_details WHERE first_character_expiry >= DATE_SUB(CURDATE(), INTERVAL 180 DAY) AND first_character_expiry < CURDATE() AND country='$_SESSION[country]' AND status NOT IN ('Returned', 'Fly')"));
                                  
                                  $character_expiry=mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(id) AS expiry_count
                                        FROM new_case_details
                                        WHERE 
                                            (
                                                (
                                                    second_character_expiry IS NOT NULL 
                                                    AND second_character_expiry != ''
                                                    AND second_character_expiry >= DATE_SUB(second_character_expiry, INTERVAL 180 DAY) 
                                                    AND second_character_expiry < NOW()
                                                )
                                                OR 
                                                (
                                                    (second_character_expiry IS NULL OR second_character_expiry = '') 
                                                    AND first_character_expiry IS NOT NULL 
                                                    AND first_character_expiry != ''
                                                    AND first_character_expiry >= DATE_SUB(first_character_expiry, INTERVAL 180 DAY) 
                                                    AND first_character_expiry < NOW()
                                                )
                                            )
                                            AND country = '$_SESSION[country]'
                                            AND status NOT IN ('Returned', 'Fly');

                                        "));
                           ?>
                           <div class="icon"><i class="entypo-rss"></i></div>
                           <div class="num" data-start="0" data-end="<?=$character_expiry['expiry_count'];?>" data-postfix data-duration="1500" data-delay="1800">0</div>
                           <h3>Character Expiry</h3>
                           
                        </div>

                     </a>
                  </div>
                  <div class="col-sm-4 col-xs-6">
                     <a href="status_wise_data?status=passport_returned">

                        <div class="tile-stats tile-aqua">
                           <div class="icon"><i class="entypo-chart-bar"></i></div>
                           <?php 
                              $temporary_return_passports=mysqli_fetch_assoc(mysqli_query($con,"select status,count(id) as temporary_return_passports from new_case_details where passport_returned = 'Yes' AND status NOT IN ('Returned', 'Fly') OR status IS NULL and country='$_SESSION[country]' and status_updated_at between '$date1' and '$date2'"));
                              // pr("select status,count(id) as temporary_return_passports from new_case_details where passport_returned = 'Yes' AND status NOT IN ('Returned', 'Fly') and country='$_SESSION[country]'");
                           ?>
                           <div class="num" data-start="0" data-end="<?=$temporary_return_passports['temporary_return_passports'];?>" data-postfix data-duration="500" data-delay="600">0</div>
                           <h3>Temporary Passport Returns</h3>
                           
                        </div>

                     </a>
                  </div>

               </div>

               <hr>
                 <br>
                <br>
                
                	<div class="row">
        				<div class="col-12 col-lg-6 col-xl-6 d-flex" >
    					   	<div class="card radius-10 overflow-hidden w-100">
    						  <div class="card-body">
    							<div class="d-flex align-items-center">
    								 <form action="index_search" method="post">
                    
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
    								 
                     
                                             <form action="index_search" method="post">
                                            
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
                
                <hr>
                
                
               <div class="row">
                  <div class="col-12 col-lg-6 col-xl-6 d-flex">
                     <div class="card radius-10 overflow-hidden w-100" style="background:#00c0ef">
                     <div class="card-body">
                        <div class="d-flex align-items-center">
                           <div>
                              <h6 class="mb-0">Date Wise Entry Graph</h6>
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
                              <h6 class="mb-0">Status Wise Data</h6>
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
                                             echo '"' . $c['entry_date'] . '",';
                                          } ?>],
                                    datasets: [{
                                    label: 'Entry by Date',
                                    data: [<?php while ($d = mysqli_fetch_array($exp_amt_line)) {
                                             echo '"' . $d['count(id)'] . '",';
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
                                             echo '"' . $a['status'] . '",';
                                          } ?>],
                              datasets: [{
                                    label: 'Status by Category',
                                    data: [<?php while ($b = mysqli_fetch_array($exp_amt_dc)) {
                                             echo '"' . $b['count(id)'] . '",';
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

            <?php
               }else{
            ?>

               <div class="row">
                  
                  <div class="col-sm-4 col-xs-6">
                     <div class="tile-stats tile-green">
                        <div class="icon"><i class="entypo-users"></i></div>

                        <?php 
                           $count_total_records=mysqli_fetch_assoc(mysqli_query($con,"select count(id) as total_records from new_case_details where country='$_SESSION[country]' and entry_date between '$date1' and '$date2'"));
                        ?>

                        <div class="num" data-start="0" data-end="<?=$count_total_records['total_records'];?>" data-postfix data-duration="1500" data-delay="0">0</div>
                        <h3>Registered Cases</h3>
                     </div>
                  </div>
                  <a href="status_wise_data?status=Ready To Apply">
                     <div class="col-sm-4 col-xs-6">
                        <div class="tile-stats tile-aqua">
                           <div class="icon"><i class="entypo-chart-bar"></i></div>
                           <?php 
                              $ready_to_apply=mysqli_fetch_assoc(mysqli_query($con,"select status,count(id) as ready_to_apply from new_case_details where status='Ready To Apply' and country='$_SESSION[country]' and entry_date between '$date1' and '$date2'"));
                           ?>
                           <div class="num" data-start="0" data-end="<?=$ready_to_apply['ready_to_apply'];?>" data-postfix data-duration="1500" data-delay="600">0</div>
                           <h3>Ready To Apply</h3>
                           
                        </div>
                     </div>
                  </a>
                  <div class="clear visible-xs"></div>
                  <a href="status_wise_data?status=Applied">
                     <div class="col-sm-4 col-xs-6">
                        <div class="tile-stats tile-blue">
                           <div class="icon"><i class="entypo-mail"></i></div>
                           <?php 
                              $applied=mysqli_fetch_assoc(mysqli_query($con,"select status,count(id) as applied from new_case_details where status='Applied' and country='$_SESSION[country]' and entry_date between '$date1' and '$date2'"));
                           ?>
                           <div class="num" data-start="0" data-end="<?=$applied['applied'];?>" data-postfix data-duration="1500" data-delay="1200">0</div>
                           <h3>Applied</h3>
                           
                        </div>
                     </div>
                  </a>
                  
                  <a href="status_wise_data?status=Visa Issued">
                     <div class="col-sm-4 col-xs-6">
                        <div class="tile-stats tile-blue">
                           <?php 
                              $visa_issued=mysqli_fetch_assoc(mysqli_query($con,"select status,count(id) as visa_issued from new_case_details where status='Visa Issued' and country='$_SESSION[country]' and entry_date between '$date1' and '$date2'"));
                           ?>
                           <div class="icon"><i class="entypo-rss"></i></div>
                           <div class="num" data-start="0" data-end="<?=$visa_issued['visa_issued'];?>" data-postfix data-duration="1500" data-delay="1800">0</div>
                           <h3>Visa Issued</h3>
                           
                        </div>
                     </div>
                  </a>

                  <a href="status_wise_data?status=Fly">
                     <div class="col-sm-4 col-xs-6">
                        <div class="tile-stats tile-green">
                           <?php 
                              $fly=mysqli_fetch_assoc(mysqli_query($con,"select status,count(id) as fly from new_case_details where status='Fly' and country='$_SESSION[country]' and entry_date between '$date1' and '$date2'"));
                           ?>
                           <div class="icon"><i class="entypo-rss"></i></div>
                           <div class="num" data-start="0" data-end="<?=$fly['fly'];?>" data-postfix data-duration="1500" data-delay="1800">0</div>
                           <h3>Fly</h3>
                           
                        </div>
                     </div>
                  </a>

                  <a href="status_wise_data?status=Returned">
                     <div class="col-sm-4 col-xs-6">
                        <div class="tile-stats tile-red">
                           <?php 
                              $returned=mysqli_fetch_assoc(mysqli_query($con,"select status,count(id) as returned from new_case_details where status='Returned' and country='$_SESSION[country]' and entry_date between '$date1' and '$date2'"));
                           ?>
                           <div class="icon"><i class="entypo-rss"></i></div>
                           <div class="num" data-start="0" data-end="<?=$returned['returned'];?>" data-postfix data-duration="1500" data-delay="1800">0</div>
                           <h3>Returned</h3>
                           
                        </div>
                     </div>
                  </a>
               </div>

               <hr>


               <div class="row">
                  <div class="col-12 col-lg-6 col-xl-6 d-flex">
                     <div class="card radius-10 overflow-hidden w-100" style="background:#00c0ef">
                     <div class="card-body">
                        <div class="d-flex align-items-center">
                           <div>
                              <h6 class="mb-0">Date Wise Entry Graph</h6>
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
                              <h6 class="mb-0">Status Wise Data</h6>
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
                                             echo '"' . $c['entry_date'] . '",';
                                          } ?>],
                                    datasets: [{
                                    label: 'Expense by Date',
                                    data: [<?php while ($d = mysqli_fetch_array($exp_amt_line)) {
                                             echo '"' . $d['count(id)'] . '",';
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
                                             echo '"' . $a['status'] . '",';
                                          } ?>],
                              datasets: [{
                                    label: 'Expense by Category',
                                    data: [<?php while ($b = mysqli_fetch_array($exp_amt_dc)) {
                                             echo '"' . $b['count(id)'] . '",';
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

            <?php
               }
            ?> 

            
            <br/> 
           
            <div class="row">
               <div class="col-md-12">
                  <h3>Clients Data</h3>
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
                                 <th>Name</th>
                                 <th>Father Name</th>
                                 <th>PP No</th>
                                 <th>PP Expiry</th>
                                 <th>Tracking Id</th>
                                 <th>Care of</th>
                                 <th>Status</th>
										
                  
                     
                  </tr>
               </thead>
               <tbody>
                                 <?php
												$subtotal=0;

                                    $exp_fetched = mysqli_query($con, "SELECT name,fname,pp_no,pp_expiry,tracking_id,care_of,status FROM new_case_details where country='$_SESSION[country]' and entry_date between '$date1' and '$date2'");
		
												$count=1; 
                                    while ($row = mysqli_fetch_array($exp_fetched)) { 

																									
											?>
                              <tr>
                                    <td><?php echo $count++?></td>
                                    <td><?=$row['name']?></td>
                                    <td><?=$row['fname']?></td>
                                    <td><?=$row['pp_no']?></td>
                                    <td><?=$row['pp_expiry']?></td>
                                    <td><?=$row['tracking_id']?></td>
                                    <td><?=$row['care_of']?></td>
                                    <td>
                                       <?php
                                          if($row['status']=='Returned' || $row['status']=='Request Returned'){
                                          
                                             echo   $applied='<button class="btn btn-danger btn-sm">'.$row['status'].'</button>'.'<br>';
                                             
                                          }else{
                                             echo   $applied='<button class="btn btn-success btn-sm">'.$row['status'].'</button>'.'<br>';

                                          }
                                       ?>
                                    </td>

                                 
                              </tr>
                  <?php
                     }
                  ?>
               </tbody>
               
            </table>
               </div>
           </div>
          
           
          
            <?php
               include('components/footer.php');
            ?>
         </div>
        
        
        
      </div>
     
      <script src="assets/js/datatables/datatables.js" id="script-resource-8"></script> 

      <link rel="stylesheet" href="assets/js/datatables/datatables.css" id="style-resource-1">
      <link rel="stylesheet" href="assets/js/jvectormap/jquery-jvectormap-1.2.2.css" id="style-resource-1">
      <link rel="stylesheet" href="assets/js/rickshaw/rickshaw.min.css" id="style-resource-2">
      <script src="assets/js/gsap/TweenMax.min.js" id="script-resource-1"></script> 
      <script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js" id="script-resource-2"></script> 
      <script src="assets/js/bootstrap.js" id="script-resource-3"></script> <script src="assets/js/joinable.js" id="script-resource-4"></script> 
      <script src="assets/js/resizeable.js" id="script-resource-5"></script> 
      <script src="assets/js/neon-api.js" id="script-resource-6"></script> 
      <script src="assets/js/cookies.min.js" id="script-resource-7"></script> 
      <script src="assets/js/jvectormap/jquery-jvectormap-1.2.2.min.js" id="script-resource-8"></script> 
      <script src="assets/js/jvectormap/jquery-jvectormap-europe-merc-en.js" id="script-resource-9"></script> 
      <script src="assets/js/jquery.sparkline.min.js" id="script-resource-10"></script> 
      <script src="assets/js/rickshaw/vendor/d3.v3.js" id="script-resource-11"></script> 
      <script src="assets/js/rickshaw/rickshaw.min.js" id="script-resource-12"></script> 
      <script src="assets/js/raphael-min.js" id="script-resource-13"></script> 
      <script src="assets/js/morris.min.js" id="script-resource-14"></script> 
      <script src="assets/js/toastr.js" id="script-resource-15"></script> 
      <script src="assets/js/neon-chat.js" id="script-resource-16"></script>  
      <script src="assets/js/neon-custom.js" id="script-resource-17"></script>  
      <script src="assets/js/neon-demo.js" id="script-resource-18"></script> 
      <script src="assets/js/neon-skins.js" id="script-resource-19"></script> 
     
   </body>
</html>

