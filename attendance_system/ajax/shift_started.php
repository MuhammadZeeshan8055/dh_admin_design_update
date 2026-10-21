<?php
include(__DIR__ . '/../../session.php');
include '../database.php';

$obj = new Database();

$current_month = date("F");
$year = date('Y');

// $allowed_ips = [$pak_office, $uae_office, $rom_office];
// if (in_array(getUserIP(), $allowed_ips)) {

$allowed_prefixes  = [$pak_office, $uae_office, $rom_office];

$user_ip = getUserIP(); // Get current user IP
$ip_allowed = false;

foreach ($allowed_prefixes as $prefix) {
    if (strpos($user_ip, $prefix) === 0) {
        $ip_allowed = true;
        break;
    }
}

if ($ip_allowed) {
    if (isset($_POST['Empid'])) {
        $start_time = currentTime(); // Get current time
    
        $data = [
            "emp_id" => $_POST['Empid'],
            "shift_date" => currentDate(),
            "start_time" => $start_time,
            "month" => $current_month,
            "year" => $year
        ];
    
        if ($obj->insert("attendance_record", $data)) {
            echo json_encode(["status" => 1, "start_time" => $start_time]);
        } else {
            echo json_encode(["status" => 0]);
        }
    }
}else{
    echo json_encode(["status" => 2]);
}


?>