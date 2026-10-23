<?php
    include('database/db_connection.php');
    include('session.php');
    include('attendance_system/database.php');

    $obj = new Database();
    // Get employee ID from URL parameter
    $emp_id = $_GET['id'];
  
  // Determine month (default to current month if not specified)
  if(isset($_GET['month'])){
      $month_name = $_GET['month'];
  } else {
      $month_name = date('F');
  }
  
  // Convert month name to number
  $month_num = date('n', strtotime($month_name));
  $year = date('Y');
  
  // Compute how many days to loop
  $firstOfMonth = "$year-$month_num-01";
  $totalInMonth = date('t', strtotime($firstOfMonth));
  $isCurrent = ($year == date('Y') && $month_num == date('n'));
  $lastDayToShow = $isCurrent ? date('j') : $totalInMonth;
  
  // Fetch employee name
  $employee_colName = "name";
  $employee_where = "emp_id = $emp_id";
  $obj->select('attendance_employee_info', $employee_colName, null, $employee_where, null, 0);
  $employee_result = $obj->getResult();
  $employee_name = $employee_result[0]['name'];
  
  // Fetch all records for this employee and month
  $where = "
      emp_id = '{$emp_id}'
      AND YEAR(shift_date) = {$year}
      AND MONTH(shift_date) = {$month_num}
  ";
  $obj->select('attendance_record', '*', null, $where);
  $rows = $obj->getResult();
  
  // Index rows by normalized date string
  $byDate = [];
  foreach ($rows as $r) {
      $key = date('Y-m-d', strtotime($r['shift_date']));
      $byDate[$key] = $r;
  }
  
  // Prepare totals logic
  $hoursPerDay = $total_working_hours;
  $workingDays = getWorkingDaysInMonth($year, $month_num);
  $totalHoursNeeded = getWorkingHoursInMonth($year, $month_num, $hoursPerDay);
  $totalWorked = calculateEmployeeWorkedHours($emp_id, $month_name, $obj);

  
  $approved_leave_time = getApprovedLeaveTime($emp_id, $month_name, $year, $obj);
  $at_least = $totalHoursNeeded - ($approved_leave_time['hours'] ?? 0);
  

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
    <link rel="stylesheet" href="assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css"
        id="style-resource-1">
    <link rel="stylesheet" href="assets/css/font-icons/entypo/css/entypo.css" id="style-resource-2">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic"
        id="style-resource-3">
    <link rel="stylesheet" href="assets/css/bootstrap.css" id="style-resource-4">
    <link rel="stylesheet" href="assets/css/neon-core.css" id="style-resource-5">
    <link rel="stylesheet" href="assets/css/neon-theme.css" id="style-resource-6">
    <link rel="stylesheet" href="assets/css/neon-forms.css" id="style-resource-7">
    <link rel="stylesheet" href="assets/css/custom.css" id="style-resource-8">
    <script src="assets/js/jquery-1.11.3.min.js"></script>
    <!--[if lt IE 9]><script src="https://demo.neontheme.com/assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <!--[if lt IE 9]> <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script> <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script> <![endif]-->
</head>

<body class="page-body">
    <div class="page-container">
        <div class="sidebar-menu">
            <?php include('components/sidebar.php'); ?>
        </div>
        <div class="main-content">
            <?php include('components/header.php'); ?>
            <hr />
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="GET">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($emp_id) ?>">

                                <select name="month" class="form-control" id="monthSelect" onchange="this.form.submit()">
                                    <option selected value="<?= $month_name ?>"><?= $month_name ?>
                                    </option>
                                    <option value="January">January</option>
                                    <option value="February">February</option>
                                    <option value="March">March</option>
                                    <option value="April">April</option>
                                    <option value="May">May</option>
                                    <option value="June">June</option>
                                    <option value="July">July</option>
                                    <option value="August">August</option>
                                    <option value="September">September</option>
                                    <option value="October">October</option>
                                    <option value="November">November</option>
                                    <option value="December">December</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <h3><?=$employee_name?> Attendance Record (<?=$month_name?>)</h3>
                </div>
            </div>

            <!-- Row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card-body pt-8">
                        <div class="table-responsive">
                            <table class="table table-bordered"
                                id="attendance_record">
                                <tr>
                                    <thead>
                                        <th>S.no</th>
                                        <th>Shift Date</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Worked Hours</th>
                                        <th>Overtime</th>
                                    </thead>
                                </tr>
                                <tbody>
                                    <?php
                                        $countDays = 0;
                                        $countLeaves = 0;
                                        $total_seconds = 0;
                                        $approvedLeaveDates = [];

                                        // Updated WHERE clause to handle cross-month leaves
                                        $where = "emp_id = '$emp_id' 
                                                  AND status = 'Approved' 
                                                  AND (
                                                      (MONTH(from_date) = '$month_num' AND YEAR(from_date) = '$year') 
                                                      OR 
                                                      (MONTH(to_date) = '$month_num' AND YEAR(to_date) = '$year')
                                                      OR
                                                      (from_date <= '$year-$month_num-01' AND to_date >= LAST_DAY('$year-$month_num-01'))
                                                  )";
                                        
                                        $obj->select("employee_leaves", "*", null, $where);
                                        $leaveRows = $obj->getResult();
                                        
                                        foreach ($leaveRows as $leave) {
                                            $start = strtotime($leave['from_date']);
                                            $end   = strtotime($leave['to_date'] ?? $leave['from_date']);
                                            
                                            // Create target month boundaries
                                            $month_start = strtotime("$year-$month_num-01");
                                            $month_end = strtotime("last day of $year-$month_num");
                                            
                                            // Loop through each day in the leave range
                                            for ($date = $start; $date <= $end; $date = strtotime("+1 day", $date)) {
                                                $current_date = date('Y-m-d', $date);
                                                
                                                // Only include dates that fall within the target month
                                                if ($date >= $month_start && $date <= $month_end) {
                                                    $approvedLeaveDates[] = $current_date;
                                                }
                                            }
                                        }
                                        
                                        // Remove duplicates if any
                                        $approvedLeaveDates = array_unique($approvedLeaveDates);

                                        $whereClosure = "closure_date BETWEEN '$year-$month_num-01' AND LAST_DAY('$year-$month_num-01')";
                                        $obj->select("office_closures", "*", null, $whereClosure);
                                        $closureRows = $obj->getResult();

                                        $closureDates = [];
                                        foreach ($closureRows as $c) {
                                            $closureDates[$c['closure_date']] = $c['description']; // keep description as well
                                        }

                                        // Loop through each day
                                        $i = 0;
                                        for ($d = 1; $d <= $lastDayToShow; $d++) {
                                            // normalize to YYYY-MM-DD
                                            $current = date('Y-m-d', strtotime("$year-$month_num-$d"));
                                            $weekday = date('w', strtotime($current)); // 0 = Sunday

                                            // Sunday holiday
                                            if ($weekday === '0') {
                                                $i++;
                                                echo '<tr style="background:#f9f9f9;">
                                                        <td>' . $i . '</td>
                                                        <td>'. formatDate($current) .'</td>
                                                        <td colspan="4" class="text-center">Holiday</td>
                                                      </tr>';
                                                continue;
                                            }

                                            // If we have a record for this date
                                            if (isset($byDate[$current])) {
                                                extract($byDate[$current]);
                                                $i++;
                                                
                                                                                                
                                                // Check against official hours for styling
                                                $parts = explode(' ', $worked_hours);
                                                $hrs = (int)$parts[0]; // Assumes first part is hours
                                                $rowStyle = ($hrs < $official_working_hours) ? 'class="red-text"' : 'class="green-text"';
                                                $countDays ++;
                                                echo "<tr {$rowStyle}>
                                                        <td>{$i}</td>
                                                        <td>" . formatDate($shift_date) . "</td>
                                                        <td>{$start_time}</td>
                                                        <td>{$end_time}</td>
                                                        <td>{$worked_hours}</td>
                                                        <td>{$overtime}</td>
                                                      </tr>";
                                            } else {
                                                    // No record: Check if it's approved leave
                                                    if (in_array($current, $approvedLeaveDates)) {
                                                        $i++;
                                                        echo "<tr>
                                                                <td>{$i}</td>
                                                                <td class='text-success'>". formatDate($current) ."</td>
                                                                <td class='text-success text-center' colspan='4'>Paid Leave</td>
                                                            </tr>";
                                                    } elseif (array_key_exists($current, $closureDates)) {
                                                        // âœ… Office closure / holiday
                                                        $i++;
                                                        $desc = $closureDates[$current]; // description from DB
                                                        echo "<tr>
                                                                <td>{$i}</td>
                                                                <td class='text-success'>". formatDate($current) ."</td>
                                                                <td class='text-success text-center' colspan='4'>{$desc}</td>
                                                              </tr>";
                                                    
                                                    }  else {
                                                    // No record: empty row
                                                    $countLeaves++;
                                                    $i++;

                                                    echo "<tr class=\"red-text\">
                                                            <td>{$i}</td>
                                                            <td>" . formatDate($current) . "</td>
                                                            <td>--</td>
                                                            <td>--</td>
                                                            <td>--</td>
                                                            <td>--</td>
                                                        </tr>";
                                                }
                                            }
                                        }

                                        ?>

                                    <tr>
                                        <td colspan="4" class="text-end"><strong>Total Worked Hours:</strong></td>
                                        <td colspan="2"><strong><?=$totalWorked?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Total Leaves <span class="text-danger"> ( <?=$countLeaves?> ) </span> Days.
                                        </td>
                                        <td colspan="2" class="text-end">
                                            <?=$employee_name?> has Worked ( <?=$countDays?> ) Days.
                                        </td>
                                        <td colspan="3">
                                            <?=$employee_name?> has Worked <br> ( <?=$totalWorked?> ) <br> Hours,
                                            Minutes.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-end">
                                            <?=$employee_name?> need to have at-least
                                        </td>
                                        <td colspan="3">
                                            ( <?=$at_least?> ) <br> Working Hours.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            Official Working Days :
                                        </td>
                                        <td><?=$workingDays?></td>
                                        <td colspan="3">
                                            Official Working Hours <br> : <?=$totalHoursNeeded?> H
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Row -->
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