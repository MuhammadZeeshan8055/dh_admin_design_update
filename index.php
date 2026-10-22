<?php
   include('database/db_connection.php');
   include('session.php');

   $_SESSION['country']='Romania';

   if(isset($_GET['country'])){
      
      $country=$_GET['country'];

      $_SESSION['country']=$_GET['country'];
   
      
   }

   if($_SESSION['country']=='Romania'){
      $exp_category_dc = mysqli_query($con, "SELECT status FROM new_case_details WHERE MONTH(entry_date)=MONTH(now()) and country='$_SESSION[country]' GROUP BY status");
      $exp_amt_dc = mysqli_query($con, "SELECT count(id) FROM new_case_details WHERE MONTH(entry_date)=MONTH(now()) and country='$_SESSION[country]' GROUP BY status");
   
      $exp_date_line = mysqli_query($con, "SELECT entry_date FROM new_case_details WHERE MONTH(entry_date)=MONTH(now()) and country='$_SESSION[country]' GROUP BY entry_date");
      $exp_amt_line = mysqli_query($con, "SELECT count(id) FROM new_case_details WHERE MONTH(entry_date)=MONTH(now()) and country='$_SESSION[country]' GROUP BY entry_date");
   
   }else{
      $exp_category_dc = mysqli_query($con, "SELECT status FROM new_case_details WHERE MONTH(entry_date)=MONTH(now()) and country='$_SESSION[country]' GROUP BY status");
      $exp_amt_dc = mysqli_query($con, "SELECT count(id) FROM new_case_details WHERE MONTH(entry_date)=MONTH(now()) and country='$_SESSION[country]' GROUP BY status");
   
      $exp_date_line = mysqli_query($con, "SELECT entry_date FROM new_case_details WHERE MONTH(entry_date)=MONTH(now()) and country='$_SESSION[country]' GROUP BY entry_date");
      $exp_amt_line = mysqli_query($con, "SELECT count(id) FROM new_case_details WHERE MONTH(entry_date)=MONTH(now()) and country='$_SESSION[country]' GROUP BY entry_date");
   
   }
   
   
   $today_date 		= date('Y-m-d').'/'.date('Y-m-d'); 
$yesterday_date 	= date('Y-m-d', strtotime(date('Y-m-d')." -1 day")).'/'.date('Y-m-d', strtotime(date('Y-m-d')." -1 day"));

$last7days_date 	= date('Y-m-d', strtotime(date('Y-m-d')." -6 day")).'/'.date('Y-m-d');
$thismonth_date 	= date('Y-m-d', strtotime(date('Y-m-')."1")).'/'.date('Y-m-t', strtotime(date('Y-m-d')));
$lastmonth_date 	= date('Y-m-d', strtotime(date('Y-m-')."1 -1 month")).'/'.date('Y-m-t', strtotime(date('Y-m-d')."-1 month"));
$thisyear_date 		= date('Y-01-01').'/'.date('Y-12-31');
$lastyear_date 		= date('Y-01-01', strtotime(date('Y-01-01')."-1 year")).'/'.date('Y-12-31', strtotime(date('Y-12-31')."-1 year"));
$alltime_date 		= '1969-12-31/'.date('Y-12-31');
  
  
	
 
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
      <link rel="stylesheet" href="assets/css/bootstrap.css" id="style-resource-4">
      <!-- neon-core kept for sidebar layout/scripts compatibility; visual theme is dhothar-theme via custom.css -->
      <link rel="stylesheet" href="assets/css/neon-core.css" id="style-resource-5">
      <link rel="stylesheet" href="assets/css/custom.css" id="style-resource-8">
      <?php include('components/theme_head.php'); ?>
      <script src="assets/js/jquery-1.11.3.min.js"></script> 
   </head>
   <body class="dh-dashboard">
      <div class="page-container">
         <div class="sidebar-menu">
            <?php include('components/sidebar.php'); ?>
         </div>
         <div class="main-content">

           <?php include('components/header.php'); ?>

            <div class="dh-dash-welcome dh-animate">
               <div>
                  <span class="dh-brand">Dhothar</span>
                  <h1>Welcome back<?php echo !empty($firstname) ? ', ' . htmlspecialchars($firstname) : ''; ?>!</h1>
                  <p>Here’s what’s happening with your cases today — <?php echo htmlspecialchars($_SESSION['country']); ?>.</p>
               </div>
            </div>

            <?php
               if($country=='' || $country=='Romania'){
            ?>

               <div class="row dh-stat-grid dh-animate dh-animate-delay-1">
                  <div class="col-sm-4 col-xs-6">
                      <a href="total_registered_cases"> 
                        <div class="tile-stats tile-green">
                           <div class="icon"><i class="entypo-users"></i></div>

                           <?php 
                            //   $count_total_records=mysqli_fetch_assoc(mysqli_query($con,"select count(id) as total_records from new_case_details where country='$_SESSION[country]'"));
                              
                            //   $count_total_active=mysqli_fetch_assoc(mysqli_query($con,"select count(id) as total_active_records from new_case_details where country='$_SESSION[country]' and status !='Returned'"));
                              
                              $query = mysqli_query($con, "
                                    SELECT 
                                        COUNT(id) AS total_records, 
                                        SUM(CASE WHEN status != 'Returned' THEN 1 ELSE 0 END) AS total_active_records 
                                    FROM new_case_details 
                                    WHERE country = '{$_SESSION['country']}'
                                ");
                                
                                $count_data = mysqli_fetch_assoc($query);
                                $total_records = $count_data['total_records'];
                                $total_active_records = $count_data['total_active_records'];

                              
                           ?>

                           <div class="num" data-start="0" data-end="<?=$total_records;?>" data-postfix data-duration="500" data-delay="0">0</div>
                           <h3>Total Registered Cases <span style="font-size:1.1rem;float:right;margin-top:3px">Active Cases (<?=$total_active_records;?>)</span></h3>
                           
                        </div>
                      </a> 
                  </div>
                  <div class="col-sm-4 col-xs-6">
                     <a href="status_wise_data?status=Ready To Apply">

                        <div class="tile-stats tile-aqua">
                           <div class="icon"><i class="entypo-chart-bar"></i></div>
                           <?php 
                              $ready_to_apply=mysqli_fetch_assoc(mysqli_query($con,"select status,count(id) as ready_to_apply from new_case_details where status='Ready To Apply' and docs_missing!='Yes' and country='$_SESSION[country]'"));
                           ?>
                           <div class="num" data-start="0" data-end="<?=$ready_to_apply['ready_to_apply'];?>" data-postfix data-duration="500" data-delay="600">0</div>
                           <h3>Ready To Apply</h3>
                           
                        </div>

                     </a>
                  </div>
                  <div class="col-sm-4 col-xs-6">
                     <a href="status_wise_data?status=Applied">

                        <div class="tile-stats tile-blue">
                           <div class="icon"><i class="entypo-mail"></i></div>
                           <?php 
                              $applied=mysqli_fetch_assoc(mysqli_query($con,"select status,count(id) as applied from new_case_details where status='Applied' and country='$_SESSION[country]'"));
                           ?>
                           <div class="num" data-start="0" data-end="<?=$applied['applied'];?>" data-postfix data-duration="500" data-delay="1200">0</div>
                           <h3>Applied</h3>
                           
                        </div>

                     </a>
                  </div>
               
                  <div class="col-sm-4 col-xs-6">
                  <div class="tile-stats tile-green" onclick="window.location='status_wise_data?status=<?= urlencode('Work Permit Issued') ?>'" style="cursor:pointer">
                     <?php
                     $work_permit_issued = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(id) AS work_permit_issued FROM new_case_details WHERE status IN ('Work Permit Issued', 'Appointment Applied') AND country='$_SESSION[country]'"));
                     $waiting_for_appointments = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(id) AS waiting_for_appointments FROM new_case_details WHERE status='Work Permit Issued' AND (appointment_date IS NULL OR appointment_date = '') AND country='$_SESSION[country]' AND status NOT IN ('Returned', 'Fly')"));
                     ?>
                     <div class="icon"><i class="entypo-rss"></i></div>
                     <div class="num" data-start="0" data-end="<?= $work_permit_issued['work_permit_issued']; ?>" data-postfix data-duration="500" data-delay="1800">0</div>
                     <h3>Work Permit Issued
                        <span onclick="event.stopPropagation(); window.location='waiting_for_appointments?status=<?= urlencode('Work Permit Issued') ?>';" style="font-size:1.1rem; display:block; margin-top:5px; cursor:pointer;">
                           Waiting For Appointment (<?= $waiting_for_appointments['waiting_for_appointments']; ?>)
                        </span>
                     </h3>
                  </div>
               </div>
               <div class="col-sm-4 col-xs-6">
                     <div class="tile-stats tile-aqua" onclick="window.location='status_wise_data?status=<?= urlencode('Appointment Applied') ?>'" style="cursor:pointer">
                        <?php
                        $appointment_applied = mysqli_fetch_assoc(mysqli_query($con, "select count(id) as appointment_applied from new_case_details where status='Appointment Applied' and country='$_SESSION[country]'"));
                        $waiting_for_appointments = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(id) AS waiting_for_appointments FROM new_case_details WHERE status='Appointment Applied' AND (appointment_date IS NULL OR appointment_date = '') AND country='$_SESSION[country]' AND status NOT IN ('Returned', 'Fly')"));
                        ?>
                        <div class="icon"><i class="entypo-rss"></i></div>
                        <div class="num" data-start="0" data-end="<?= $appointment_applied['appointment_applied']; ?>" data-postfix data-duration="500" data-delay="1800">0</div>
                        <h3>Appointment Applied
                           <span onclick="event.stopPropagation(); window.location='waiting_for_appointments?status=<?= urlencode('Appointment Applied') ?>';" style="font-size:1.1rem; display:block; margin-top:5px; cursor:pointer;">
                              Waiting For Appointment (<?= $waiting_for_appointments['waiting_for_appointments']; ?>)
                           </span>
                        </h3>
                     </div>
               </div>
                  <div class="col-sm-4 col-xs-6">
                     <a href="status_wise_data?status=Visa Issued">

                        <div class="tile-stats tile-blue">
                           <?php 
                              $visa_issued=mysqli_fetch_assoc(mysqli_query($con,"select status,count(id) as visa_issued from new_case_details where status='Visa Issued' and country='$_SESSION[country]'"));
                           ?>
                           <div class="icon"><i class="entypo-rss"></i></div>
                           <div class="num" data-start="0" data-end="<?=$visa_issued['visa_issued'];?>" data-postfix data-duration="500" data-delay="1800">0</div>
                           <h3>Visa Issued</h3>
                           
                        </div>

                     </a>
                  </div>
                  <div class="col-sm-4 col-xs-6">
                     <a href="status_wise_data?status=Return From Embassy">
                     
                        <div class="tile-stats tile-red">
                           <?php 
                              $rejected_from_embassy=mysqli_fetch_assoc(mysqli_query($con,"select status,count(id) as rejected_from_embassy from new_case_details where status='Return From Embassy' and country='$_SESSION[country]'"));
                           ?>
                           <div class="icon"><i class="entypo-rss"></i></div>
                           <div class="num" data-start="0" data-end="<?=$rejected_from_embassy['rejected_from_embassy'];?>" data-postfix data-duration="500" data-delay="1800">0</div>
                           <h3>Return From Embassy</h3>
                           
                        </div>

                     </a>
                  </div>
                  <div class="col-sm-4 col-xs-6">
                     <a href="status_wise_data?status=Fly">

                        <div class="tile-stats tile-green">
                           <?php 
                              $fly=mysqli_fetch_assoc(mysqli_query($con,"select status,count(id) as fly from new_case_details where status='Fly' and country='$_SESSION[country]'"));
                           ?>
                           <div class="icon"><i class="entypo-rss"></i></div>
                           <div class="num" data-start="0" data-end="<?=$fly['fly'];?>" data-postfix data-duration="500" data-delay="1800">0</div>
                           <h3>Departed</h3>
                           
                        </div>

                     </a>
                  </div>
                  <div class="col-sm-4 col-xs-6">
                     <a href="status_wise_data?status=Returned">
                     
                        <div class="tile-stats tile-red">
                           <?php 
                              $returned=mysqli_fetch_assoc(mysqli_query($con,"select status,count(id) as returned from new_case_details where status='Returned' or status='Request Returned' and country='$_SESSION[country]'"));
                           ?>
                           <div class="icon"><i class="entypo-rss"></i></div>
                           <div class="num" data-start="0" data-end="<?=$returned['returned'];?>" data-postfix data-duration="500" data-delay="1800">0</div>
                           <h3>Returned</h3>
                           
                        </div>

                     </a>
                  </div>

                  <div class="col-sm-4 col-xs-6">
                     <a href="status_wise_data?status=Yes">
                     
                        <div class="tile-stats tile-red">
                           <?php 
                              $missing_documents=mysqli_fetch_assoc(mysqli_query($con,"select status,count(id) as missing_documents from new_case_details where docs_missing='Yes' and country='$_SESSION[country]' AND status NOT IN ('Returned', 'Fly')"));
                           ?>
                           <div class="icon"><i class="entypo-rss"></i></div>
                           <div class="num" data-start="0" data-end="<?=$missing_documents['missing_documents'];?>" data-postfix data-duration="500" data-delay="1800">0</div>
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
                           <div class="num" data-start="0" data-end="<?=$passport_expiry_under_year['passport_expiry_under_year'];?>" data-postfix data-duration="500" data-delay="1800">0</div>
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
                           <div class="num" data-start="0" data-end="<?=$passport_expired['passport_expired'];?>" data-postfix data-duration="500" data-delay="1800">0</div>
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
                           <div class="num" data-start="0" data-end="<?=$character_expiry['expiry_count'];?>" data-postfix data-duration="500" data-delay="1800">0</div>
                           <h3>Character Expiry</h3>
                           
                        </div>

                     </a>
                  </div>
                  <div class="col-sm-4 col-xs-6">
                     <a href="status_wise_data?status=passport_returned">

                        <div class="tile-stats tile-aqua">
                           <div class="icon"><i class="entypo-chart-bar"></i></div>
                           <?php 
                              $temporary_return_passports=mysqli_fetch_assoc(mysqli_query($con,"select status,count(id) as temporary_return_passports from new_case_details where passport_returned = 'Yes' AND status NOT IN ('Returned', 'Fly') OR status IS NULL and country='$_SESSION[country]'"));
                              // pr("select status,count(id) as temporary_return_passports from new_case_details where passport_returned = 'Yes' AND status NOT IN ('Returned', 'Fly') and country='$_SESSION[country]'");
                           ?>
                           <div class="num" data-start="0" data-end="<?=$temporary_return_passports['temporary_return_passports'];?>" data-postfix data-duration="500" data-delay="600">0</div>
                           <h3>Temporary Passport Returns</h3>
                           
                        </div>

                     </a>
                  </div>

               </div>

               <div class="row dh-animate dh-animate-delay-2">
        				<div class="col-12 col-lg-6 col-xl-6 d-flex" >
    					   	<div class="card radius-10 overflow-hidden w-100 dh-panel">
    						  <div class="card-body">
                                 <h6 class="dh-panel-title">Quick date filter</h6>
    								 <form action="index_search" method="post">
                                          <table class="table-1">
                                                <tr>
                                                    <td><select class='form-control' name="date"  required >
                                            				<?php if(!empty($_POST['date'])){?>
                                            					<option value="<?= htmlspecialchars($_POST['date']); ?>"><?= htmlspecialchars($selectOption ?? $_POST['date']); ?></option>
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
                                                     <td>   <input type="submit" name="date_select" value="Search" class="form-control">
                                                      </td>
                                                </tr>
                                          </table>
                                    </form>
                              </div>
    						</div>
    					</div>
    					
    					<div class="col-12 col-lg-6 col-xl-6 d-flex">
    					   <div class="card radius-10 overflow-hidden w-100 dh-panel" >
    						  <div class="card-body">
                                 <h6 class="dh-panel-title">Custom date range</h6>
                                             <form action="index_search" method="post">
                                              <table class="table-2">
                                                <tr>
                                                    <td> <input type='date' name='date1' class='form-control' value="<?= !empty($_POST['date1']) ? htmlspecialchars($_POST['date1']) : '' ?>"   />
    				                                    </td>
                                                     <td>   <input type='date' name='date2' class='form-control' value="<?= !empty($_POST['date2']) ? htmlspecialchars($_POST['date2']) : '' ?>"   />
                                                      </td>
                                                      <td>
                                                          <input type="submit" name="date_range" value="Search" class="form-control">
                                                      </td>
                                                </tr>
                                          </table>
                                            </form>
                              </div>
    						</div>
    					</div>
					</div>

               <div class="row dh-animate dh-animate-delay-3" style="margin-top:8px">
                  <div class="col-12 col-lg-6 col-xl-6 d-flex">
                     <div class="card radius-10 overflow-hidden w-100 dh-panel">
                     <div class="card-body">
                              <h6 class="dh-panel-title">Date Wise Entry Graph</h6>
                              <div class="dh-chart-wrap">
                                 <canvas id="myChart"></canvas>
                              </div>
                              </div>
                     </div>
                  </div>
               
                  <div class="col-12 col-lg-6 col-xl-6 d-flex">
                     <div class="card radius-10 overflow-hidden w-100 dh-panel">
                     <div class="card-body">
                              <h6 class="dh-panel-title">Status Wise Data</h6>
                              <div class="dh-chart-wrap">
                                 <canvas id="myChart2"></canvas>
                              </div>
                              </div>
                     </div>
                  </div>
				   </div><!--End Row-->
               <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
               <script>
               (function () {
                  var isDark = document.documentElement.getAttribute('data-theme') === 'dark';
                  var textColor = isDark ? '#a8bdd0' : '#5a6f82';
                  Chart.defaults.color = textColor;
                  var ctx = document.getElementById('myChart');
                  var ctx2 = document.getElementById('myChart2');
                  if (!ctx || !ctx2) return;

                  new Chart(ctx, {
                     type: 'line',
                     data: {
                        labels: [<?php
                           mysqli_data_seek($exp_date_line, 0);
                           while ($c = mysqli_fetch_array($exp_date_line)) {
                              echo '"' . $c['entry_date'] . '",';
                           }
                        ?>],
                        datasets: [{
                           label: 'Entry by Date',
                           data: [<?php
                              mysqli_data_seek($exp_amt_line, 0);
                              while ($d = mysqli_fetch_array($exp_amt_line)) {
                                 echo '"' . $d['count(id)'] . '",';
                              }
                           ?>],
                           borderColor: '#00afeb',
                           backgroundColor: 'rgba(86, 201, 246, 0.25)',
                           pointBackgroundColor: '#d8ba6f',
                           pointBorderColor: '#00afeb',
                           fill: true,
                           tension: 0.35,
                           borderWidth: 2
                        }]
                     },
                     options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: { legend: { display: true } },
                        scales: {
                           x: { grid: { color: 'rgba(0,175,235,0.08)' } },
                           y: { grid: { color: 'rgba(0,175,235,0.08)' }, beginAtZero: true }
                        }
                     }
                  });

                  new Chart(ctx2, {
                     type: 'bar',
                     data: {
                        labels: [<?php
                           mysqli_data_seek($exp_category_dc, 0);
                           while ($a = mysqli_fetch_array($exp_category_dc)) {
                              echo '"' . addslashes($a['status']) . '",';
                           }
                        ?>],
                        datasets: [{
                           label: 'Status by Category',
                           data: [<?php
                              mysqli_data_seek($exp_amt_dc, 0);
                              while ($b = mysqli_fetch_array($exp_amt_dc)) {
                                 echo '"' . $b['count(id)'] . '",';
                              }
                           ?>],
                           backgroundColor: [
                              'rgba(0, 175, 235, 0.55)',
                              'rgba(216, 186, 111, 0.65)',
                              'rgba(86, 201, 246, 0.55)',
                              'rgba(229, 216, 171, 0.7)',
                              'rgba(0, 175, 235, 0.4)',
                              'rgba(216, 186, 111, 0.45)',
                              'rgba(86, 201, 246, 0.4)'
                           ],
                           borderColor: ['#00afeb', '#d8ba6f', '#56c9f6', '#e5d8ab', '#00afeb', '#d8ba6f', '#56c9f6'],
                           borderWidth: 1,
                           borderRadius: 6
                        }]
                     },
                     options: {
                        responsive: true,
                        plugins: { legend: { display: false } },
                        scales: {
                           x: { grid: { display: false } },
                           y: { grid: { color: 'rgba(0,175,235,0.08)' }, beginAtZero: true }
                        }
                     }
                  });
               })();
               </script>

            <?php
               }else{
            ?>

               <div class="row dh-stat-grid dh-animate dh-animate-delay-1">
                  <div class="col-sm-4 col-xs-6">
                      <a href="status_wise_data?status=Total Registered Cases"> 
                        <div class="tile-stats tile-green">
                           <div class="icon"><i class="entypo-users"></i></div>

                           <?php 
                              $query = mysqli_query($con, "
                                    SELECT 
                                        COUNT(id) AS total_records, 
                                        SUM(CASE WHEN status != 'Returned' THEN 1 ELSE 0 END) AS total_active_records 
                                    FROM new_case_details 
                                    WHERE country = '{$_SESSION['country']}'
                                ");
                                
                                $count_data = mysqli_fetch_assoc($query);
                                $total_records = $count_data['total_records'];
                                $total_active_records = $count_data['total_active_records'];
                           ?>

                           <div class="num" data-start="0" data-end="<?=$total_records;?>" data-postfix data-duration="500" data-delay="0">0</div>
                           <h3>Total Registered Cases <span style="font-size:1.1rem;float:right;margin-top:3px">Active Cases (<?=$total_active_records;?>)</span></h3>
                           
                        </div>
                      </a> 
                  </div>
                  <div class="col-sm-4 col-xs-6">
                     <a href="status_wise_data?status=Ready To Apply">

                        <div class="tile-stats tile-aqua">
                           <div class="icon"><i class="entypo-chart-bar"></i></div>
                           <?php 
                              $ready_to_apply=mysqli_fetch_assoc(mysqli_query($con,"select status,count(id) as ready_to_apply from new_case_details where status='Ready To Apply' and docs_missing!='Yes' and country='$_SESSION[country]'"));
                           ?>
                           <div class="num" data-start="0" data-end="<?=$ready_to_apply['ready_to_apply'];?>" data-postfix data-duration="500" data-delay="600">0</div>
                           <h3>Ready To Apply</h3>
                           
                        </div>

                     </a>
                  </div>
                  <div class="col-sm-4 col-xs-6">
                     <a href="status_wise_data?status=Applied">

                        <div class="tile-stats tile-blue">
                           <div class="icon"><i class="entypo-mail"></i></div>
                           <?php 
                              $applied=mysqli_fetch_assoc(mysqli_query($con,"select status,count(id) as applied from new_case_details where status='Applied' and country='$_SESSION[country]'"));
                           ?>
                           <div class="num" data-start="0" data-end="<?=$applied['applied'];?>" data-postfix data-duration="500" data-delay="1200">0</div>
                           <h3>Applied</h3>
                           
                        </div>

                     </a>
                  </div>
               
                  <div class="col-sm-4 col-xs-6">
                     <a href="status_wise_data?status=Work Permit Issued">

                        <div class="tile-stats tile-green">
                           <?php 
                              $work_permit_issued=mysqli_fetch_assoc(mysqli_query($con,"select status,count(id) as work_permit_issued from new_case_details where status='Work Permit Issued' and country='$_SESSION[country]'"));
                           ?>
                           <div class="icon"><i class="entypo-rss"></i></div>
                           <div class="num" data-start="0" data-end="<?=$work_permit_issued['work_permit_issued'];?>" data-postfix data-duration="500" data-delay="1800">0</div>
                           <h3>Work Permit Issued</h3>
                           
                        </div>

                     </a>
                  </div>
                  <div class="col-sm-4 col-xs-6">
                     <a href="status_wise_data?status=Appointment Applied">

                        <div class="tile-stats tile-aqua">
                           <?php 
                              $appointment_applied=mysqli_fetch_assoc(mysqli_query($con,"select status,count(id) as appointment_applied from new_case_details where status='Appointment Applied' and country='$_SESSION[country]'"));
                           ?>
                           <div class="icon"><i class="entypo-rss"></i></div>
                           <div class="num" data-start="0" data-end="<?=$appointment_applied['appointment_applied'];?>" data-postfix data-duration="500" data-delay="1800">0</div>
                           <h3>Appointment Applied</h3>
                           
                        </div>

                     </a>
                  </div>
                  <div class="col-sm-4 col-xs-6">
                     <a href="status_wise_data?status=Visa Issued">

                        <div class="tile-stats tile-blue">
                           <?php 
                              $visa_issued=mysqli_fetch_assoc(mysqli_query($con,"select status,count(id) as visa_issued from new_case_details where status='Visa Issued' and country='$_SESSION[country]'"));
                           ?>
                           <div class="icon"><i class="entypo-rss"></i></div>
                           <div class="num" data-start="0" data-end="<?=$visa_issued['visa_issued'];?>" data-postfix data-duration="500" data-delay="1800">0</div>
                           <h3>Visa Issued</h3>
                           
                        </div>

                     </a>
                  </div>
                  <div class="col-sm-4 col-xs-6">
                     <a href="status_wise_data?status=Fly">

                        <div class="tile-stats tile-green">
                           <?php 
                              $fly=mysqli_fetch_assoc(mysqli_query($con,"select status,count(id) as fly from new_case_details where status='Fly' and country='$_SESSION[country]'"));
                           ?>
                           <div class="icon"><i class="entypo-rss"></i></div>
                           <div class="num" data-start="0" data-end="<?=$fly['fly'];?>" data-postfix data-duration="500" data-delay="1800">0</div>
                           <h3>Departed</h3>
                           
                        </div>

                     </a>
                  </div>
                  <div class="col-sm-4 col-xs-6">
                     <a href="status_wise_data?status=Returned">
                     
                        <div class="tile-stats tile-red">
                           <?php 
                              $returned=mysqli_fetch_assoc(mysqli_query($con,"select status,count(id) as returned from new_case_details where (status='Returned' or status='Request Returned') and country='$_SESSION[country]'"));
                           ?>
                           <div class="icon"><i class="entypo-rss"></i></div>
                           <div class="num" data-start="0" data-end="<?=$returned['returned'];?>" data-postfix data-duration="500" data-delay="1800">0</div>
                           <h3>Returned</h3>
                           
                        </div>

                     </a>
                  </div>

                  <div class="col-sm-4 col-xs-6">
                     <a href="status_wise_data?status=Yes">
                     
                        <div class="tile-stats tile-red">
                           <?php 
                              $missing_documents=mysqli_fetch_assoc(mysqli_query($con,"select status,count(id) as missing_documents from new_case_details where docs_missing='Yes' and country='$_SESSION[country]' AND status NOT IN ('Returned', 'Fly')"));
                           ?>
                           <div class="icon"><i class="entypo-rss"></i></div>
                           <div class="num" data-start="0" data-end="<?=$missing_documents['missing_documents'];?>" data-postfix data-duration="500" data-delay="1800">0</div>
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
                           <div class="num" data-start="0" data-end="<?=$passport_expiry_under_year['passport_expiry_under_year'];?>" data-postfix data-duration="500" data-delay="1800">0</div>
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
                           <div class="num" data-start="0" data-end="<?=$passport_expired['passport_expired'];?>" data-postfix data-duration="500" data-delay="1800">0</div>
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
                           <div class="num" data-start="0" data-end="<?=$character_expiry['expiry_count'];?>" data-postfix data-duration="500" data-delay="1800">0</div>
                           <h3>Character Expiry</h3>
                           
                        </div>

                     </a>
                  </div>

               </div>

               <div class="row dh-animate dh-animate-delay-3" style="margin-top:8px">
                  <div class="col-12 col-lg-6 col-xl-6 d-flex">
                     <div class="card radius-10 overflow-hidden w-100 dh-panel">
                     <div class="card-body">
                              <h6 class="dh-panel-title">Date Wise Entry Graph</h6>
                              <div class="dh-chart-wrap">
                                 <canvas id="myChart"></canvas>
                              </div>
                              </div>
                     </div>
                  </div>
               
                  <div class="col-12 col-lg-6 col-xl-6 d-flex">
                     <div class="card radius-10 overflow-hidden w-100 dh-panel">
                     <div class="card-body">
                              <h6 class="dh-panel-title">Status Wise Data</h6>
                              <div class="dh-chart-wrap">
                                 <canvas id="myChart2"></canvas>
                              </div>
                              </div>
                     </div>
                  </div>
				   </div><!--End Row-->
               <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
               <script>
               (function () {
                  var isDark = document.documentElement.getAttribute('data-theme') === 'dark';
                  Chart.defaults.color = isDark ? '#a8bdd0' : '#5a6f82';
                  var ctx = document.getElementById('myChart');
                  var ctx2 = document.getElementById('myChart2');
                  if (!ctx || !ctx2) return;

                  new Chart(ctx, {
                     type: 'line',
                     data: {
                        labels: [<?php
                           mysqli_data_seek($exp_date_line, 0);
                           while ($c = mysqli_fetch_array($exp_date_line)) {
                              echo '"' . $c['entry_date'] . '",';
                           }
                        ?>],
                        datasets: [{
                           label: 'Entry by Date',
                           data: [<?php
                              mysqli_data_seek($exp_amt_line, 0);
                              while ($d = mysqli_fetch_array($exp_amt_line)) {
                                 echo '"' . $d['count(id)'] . '",';
                              }
                           ?>],
                           borderColor: '#00afeb',
                           backgroundColor: 'rgba(86, 201, 246, 0.25)',
                           pointBackgroundColor: '#d8ba6f',
                           fill: true,
                           tension: 0.35,
                           borderWidth: 2
                        }]
                     },
                     options: {
                        responsive: true,
                        scales: {
                           x: { grid: { color: 'rgba(0,175,235,0.08)' } },
                           y: { grid: { color: 'rgba(0,175,235,0.08)' }, beginAtZero: true }
                        }
                     }
                  });

                  new Chart(ctx2, {
                     type: 'bar',
                     data: {
                        labels: [<?php
                           mysqli_data_seek($exp_category_dc, 0);
                           while ($a = mysqli_fetch_array($exp_category_dc)) {
                              echo '"' . addslashes($a['status']) . '",';
                           }
                        ?>],
                        datasets: [{
                           label: 'Status by Category',
                           data: [<?php
                              mysqli_data_seek($exp_amt_dc, 0);
                              while ($b = mysqli_fetch_array($exp_amt_dc)) {
                                 echo '"' . $b['count(id)'] . '",';
                              }
                           ?>],
                           backgroundColor: [
                              'rgba(0, 175, 235, 0.55)',
                              'rgba(216, 186, 111, 0.65)',
                              'rgba(86, 201, 246, 0.55)',
                              'rgba(229, 216, 171, 0.7)',
                              'rgba(0, 175, 235, 0.4)',
                              'rgba(216, 186, 111, 0.45)',
                              'rgba(86, 201, 246, 0.4)'
                           ],
                           borderColor: ['#00afeb', '#d8ba6f', '#56c9f6', '#e5d8ab', '#00afeb', '#d8ba6f', '#56c9f6'],
                           borderWidth: 1,
                           borderRadius: 6
                        }]
                     },
                     options: {
                        responsive: true,
                        plugins: { legend: { display: false } },
                        scales: {
                           x: { grid: { display: false } },
                           y: { grid: { color: 'rgba(0,175,235,0.08)' }, beginAtZero: true }
                        }
                     }
                  });
               })();
               </script>

            <?php
               }
            ?> 

            <?php
               include('components/footer.php');
            ?>
         </div>
      </div>

      <!-- Essential scripts only: DataTables + sidebar (neon-custom) + Bootstrap -->
      <link rel="stylesheet" href="assets/js/datatables/datatables.css">
      <script src="assets/js/datatables/datatables.js"></script>
      <script src="assets/js/gsap/TweenMax.min.js"></script>
      <script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
      <script src="assets/js/bootstrap.js"></script>
      <script src="assets/js/joinable.js"></script>
      <script src="assets/js/resizeable.js"></script>
      <script src="assets/js/neon-api.js"></script>
      <script src="assets/js/cookies.min.js"></script>
      <script src="assets/js/neon-custom.js"></script>
     
   </body>
</html>

