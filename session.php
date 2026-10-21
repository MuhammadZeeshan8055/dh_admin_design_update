<?php
    session_start();
    if(!isset($_SESSION["login"])){
        header("Location: login.php");
        exit();
    }

    include("database/db_connection.php");

    $sess_email = $_SESSION["login"];
    $sql = "SELECT * FROM users WHERE email = '$sess_email'";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $userid=$row["user_id"];
        $firstname = $row["firstname"];
        $lastname = $row["lastname"];
        $username =$row["firstname"]." ".$row["lastname"];
        $useremail=$row["email"];
        $only_view=$row["only_view"];
        $can_add=$row["can_add"];
        $can_update=$row["can_update"];
        $can_delete=$row["can_delete"];
        $manage_petty_cash=$row["manage_petty_cash"];
        $manage_accounts=$row["manage_accounts"];
            
        $userrole=$row["role"];
        $userprofile="uploads/".$row["profile"];
    }
    } else {
        $userid="GHX1Y2";
        $username ="Jhon Doe";
        $useremail="mailid@domain.com";
        $userprofile="Uploads/default_profile.png";
    }
    
    //function helper
    
    function formatDate($date) {
        return !empty($date) ? date("d F Y", strtotime($date)) : '';
    }

    function todayDate() {
        return date("Y-m-d");
    }


    // attendance part 
    $sess_email = $_SESSION["login"];
    $sql = "SELECT attendance_employee_info.*, attendance_company.* 
        FROM attendance_employee_info 
        LEFT JOIN attendance_company ON attendance_employee_info.company = attendance_company.id 
        WHERE attendance_employee_info.emp_id = '$userid'";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $empid=$row["emp_id"];
        $curr_emp_name = $row["name"];
        $curr_emp_email=$sess_email;
        $curr_emp_company=$row["company_name"];
        $curr_emp_designation=$row["designation"];
        $curr_emp_date_of_joining=$row["date_of_joining"];
        $curr_emp_salary=$row["salary"];
        $curr_emp_currency=$row["currency"];
        $curr_emp_cnic_passport=$row["cnic_passport"];
        $curr_emp_permanent_address=$row["permanent_address"];
        $curr_emp_country=$row["country"];
        $curr_emp_phone_1=$row["phone_1"];
        $curr_emp_phone_2=$row["phone_2"];
        $curr_emp_bank_name=$row["bank_name"];
        $curr_emp_account_title=$row["account_title"];
        $curr_emp_iban=$row["iban"];
    }
    } else {
        $empid="GHX1Y2";
        $username ="Jhon Doe";
        $emp_email="mailid@domain.com";
    }

    $sql2 = "SELECT * FROM attendance_settings";
    $result2 = $con->query($sql2);

    $settings_data = [];

    if ($result2->num_rows > 0) {
        while ($row2 = $result2->fetch_assoc()) {
            $settings_data[$row2["meta_key"]] = $row2["meta_value"];
        }
    }

    $total_working_hours = $settings_data["total_working_hours"] ?? null;
    $break_timing = $settings_data["break_timing"] ?? null;
    $break_time = $settings_data["break_time"] ?? null;
    $pak_office = $settings_data["pak_ip_address"] ?? null;
    $uae_office = $settings_data["uae_ip_address"] ?? null;
    $rom_office = $settings_data["rom_ip_address"] ?? null;
    $official_working_hours = $settings_data["official_working_hours"] ?? null;

     // Function Helper 
     function currentDate(){
        return date('Y-m-d');
    }
    function currentTime() {
        date_default_timezone_set('Asia/Karachi'); // Set timezone to Pakistan
        return date('h:i A');
    }

    function getUserIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }

    // Function to get working days in a month (excluding Sundays)
    function getWorkingDaysInMonth($year, $month) {
        $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $working_days = 0;
        for ($day = 1; $day <= $days_in_month; $day++) {
            $weekday = date('w', strtotime("$year-$month-$day"));
            if ($weekday != 0) { // 0 = Sunday
                $working_days++;
            }
        }
        return $working_days;
    }

    // Function to get working hours in a month
    function getWorkingHoursInMonth($year, $month, $hours_per_day) {
        $working_days = getWorkingDaysInMonth($year, $month);
        return $working_days * $hours_per_day;
    }
    
    function calculateEmployeeWorkedHours($emp_id, $month_name, $db) {
        $where = "emp_id = '$emp_id' AND month = '$month_name'";
        
        $db->select('attendance_record', '*', null, $where, null, null);
        $records = $db->getResult();
    
        $total_seconds = 0;
    
        foreach ($records as $row) {
            $worked_hours = $row['worked_hours'];
    
            // Parse "1 H, 30 m, 15 s"
            preg_match('/(\d+)\s*H/', $worked_hours, $h);
            preg_match('/(\d+)\s*m/', $worked_hours, $m);
            preg_match('/(\d+)\s*s/', $worked_hours, $s);
    
            $hours = isset($h[1]) ? (int)$h[1] : 0;
            $minutes = isset($m[1]) ? (int)$m[1] : 0;
            $seconds = isset($s[1]) ? (int)$s[1] : 0;
    
            $total_seconds += $hours * 3600 + $minutes * 60 + $seconds;
        }
    
        // Format total time
        $total_hours = floor($total_seconds / 3600);
        $total_minutes = floor(($total_seconds % 3600) / 60);
        $total_secs = $total_seconds % 60;
    
        return sprintf('%d H, %02d m, %02d s', $total_hours, $total_minutes, $total_secs);
    }
    
    // function getApprovedLeaveTime($employee_id, $month, $year, $obj) {
    //     $month_number = date('m', strtotime("1 $month"));
        
    //     // Get all approved leaves that overlap with the target month
    //     $where = "emp_id = '$employee_id' 
    //             AND status = 'Approved' 
    //             AND (
    //                 (MONTH(from_date) = '$month_number' AND YEAR(from_date) = '$year') 
    //                 OR 
    //                 (MONTH(to_date) = '$month_number' AND YEAR(to_date) = '$year')
    //                 OR
    //                 (from_date <= '$year-$month_number-01' AND to_date >= LAST_DAY('$year-$month_number-01'))
    //             )";
        
    //     $obj->select("employee_leaves", "*", null, $where);
    //     $leaveData = $obj->getResult();
        
    //     $total_minutes = 0;
        
    //     foreach ($leaveData as $leave) {
    //         $from_date = new DateTime($leave['from_date']);
    //         $to_date = new DateTime($leave['to_date']);
            
    //         // Calculate total days in the entire leave period
    //         $total_leave_period = new DatePeriod(
    //             $from_date,
    //             new DateInterval('P1D'),
    //             $to_date->modify('+1 day')
    //         );
            
    //         $total_leave_days = 0;
    //         foreach ($total_leave_period as $date) {
    //             $total_leave_days++;
    //         }
            
    //         // Reset $to_date since modify() changed it
    //         $to_date = new DateTime($leave['to_date']);
            
    //         // Create the first and last day of the target month
    //         $month_start = new DateTime("$year-$month_number-01");
    //         $month_end = new DateTime($month_start->format('Y-m-t'));
            
    //         // Find the overlap period
    //         $overlap_start = max($from_date, $month_start);
    //         $overlap_end = min($to_date, $month_end);
            
    //         // Calculate days in the overlap period
    //         if ($overlap_start <= $overlap_end) {
    //             $overlap_period = new DatePeriod(
    //                 $overlap_start,
    //                 new DateInterval('P1D'),
    //                 $overlap_end->modify('+1 day')
    //             );
                
    //             $days_in_month = 0;
    //             foreach ($overlap_period as $date) {
    //                 $days_in_month++;
    //             }
                
    //             // Calculate hours per day (total leave hours / total leave days)
    //             $total_leave_hours = (int)$leave['leave_time'];
    //             $hours_per_day = $total_leave_hours / $total_leave_days;
                
    //             // Calculate minutes for this leave period in the target month
    //             $minutes_for_this_leave = $days_in_month * $hours_per_day * 60;
                
    //             $total_minutes += $minutes_for_this_leave;
    //         }
    //     }

    //     // Convert to hours and minutes
    //     $total_hours = floor($total_minutes / 60);
    //     $remaining_minutes = $total_minutes % 60;

    //     return [
    //         'minutes' => $total_minutes,
    //         'hours' => $total_hours,
    //         'remaining_minutes' => $remaining_minutes
    //     ];
    // }
    
    function getApprovedLeaveTime($employee_id, $month, $year, $obj) {
        $month_number = date('m', strtotime("1 $month"));
        
        // Get all approved leaves that overlap with the target month
        $where = "emp_id = '$employee_id' 
                AND status = 'Approved' 
                AND (
                    (MONTH(from_date) = '$month_number' AND YEAR(from_date) = '$year') 
                    OR 
                    (MONTH(to_date) = '$month_number' AND YEAR(to_date) = '$year')
                    OR
                    (from_date <= '$year-$month_number-01' AND to_date >= LAST_DAY('$year-$month_number-01'))
                )";
        
        $obj->select("employee_leaves", "*", null, $where);
        $leaveData = $obj->getResult();
        
        $total_minutes = 0;
        
        foreach ($leaveData as $leave) {
            $from_date = new DateTime($leave['from_date']);
            $to_date = new DateTime($leave['to_date']);
            
            // Calculate total days in the entire leave period
            $total_leave_period = new DatePeriod(
                $from_date,
                new DateInterval('P1D'),
                $to_date->modify('+1 day')
            );
            
            $total_leave_days = 0;
            foreach ($total_leave_period as $date) {
                $total_leave_days++;
            }
            
            // Reset $to_date since modify() changed it
            $to_date = new DateTime($leave['to_date']);
            
            // Create the first and last day of the target month
            $month_start = new DateTime("$year-$month_number-01");
            $month_end = new DateTime($month_start->format('Y-m-t'));
            
            // Find the overlap period
            $overlap_start = max($from_date, $month_start);
            $overlap_end = min($to_date, $month_end);
            
            // Calculate days in the overlap period
            if ($overlap_start <= $overlap_end) {
                $overlap_period = new DatePeriod(
                    $overlap_start,
                    new DateInterval('P1D'),
                    $overlap_end->modify('+1 day')
                );
                
                $days_in_month = 0;
                foreach ($overlap_period as $date) {
                    $days_in_month++;
                }
                
                // Calculate hours per day (total leave hours / total leave days)
                $total_leave_hours = (int)$leave['leave_time'];
                $hours_per_day = $total_leave_hours / $total_leave_days;
                
                // Calculate minutes for this leave period in the target month
                $minutes_for_this_leave = $days_in_month * $hours_per_day * 60;
                
                $total_minutes += $minutes_for_this_leave;
            }
        }
        
        // Add office closures for the target month
        $closure_where = "MONTH(closure_date) = '$month_number' AND YEAR(closure_date) = '$year'";
        $obj->select("office_closures", "*", null, $closure_where);
        $closureData = $obj->getResult();
        
        foreach ($closureData as $closure) {
            // Each closure day = 8 hours = 480 minutes
            $total_minutes += 8 * 60;
        }
    
        // Convert to hours and minutes
        $total_hours = floor($total_minutes / 60);
        $remaining_minutes = $total_minutes % 60;
    
        return [
            'minutes' => $total_minutes,
            'hours' => $total_hours,
            'remaining_minutes' => $remaining_minutes
        ];
    }

    function pr($value) {
        echo '<pre>';
        print_r($value);
        echo '</pre>';
        die(); // Stop further execution
    }
?>