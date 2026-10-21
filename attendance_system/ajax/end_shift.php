<?php
include(__DIR__ . '/../../session.php');
include '../database.php';
$obj = new Database();

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
        $empid = $_POST['Empid'];
        $current_date = currentDate();

        // Fetch existing shift details
        $colName = "emp_id, shift_date, start_time";
        $where = "attendance_record.emp_id = $empid AND attendance_record.shift_date = '$current_date'";

        $obj->select('attendance_record', $colName, "", $where, null, 1);
        $result = $obj->getResult();

        if (!empty($result)) {
            $attendance_record = $result[0];
            $start_time = $attendance_record['start_time'];

            // Get current time as end time
            $end_time = currentTime();

            // Convert times to timestamps
            $start_timestamp = strtotime($start_time);
            $end_timestamp = strtotime($end_time);

            // Calculate worked hours in seconds
            $worked_seconds = $end_timestamp - $start_timestamp;

            // Convert seconds to hours, minutes, and seconds
            $worked_hours = floor($worked_seconds / 3600); // Full hours
            $worked_minutes = floor(($worked_seconds % 3600) / 60); // Remaining minutes
            $worked_seconds = $worked_seconds % 60; // Remaining seconds

            // Format as "9 H, 07 m, 50 s"
            $worked_time = sprintf("%d H, %02d m, %02d s", $worked_hours, $worked_minutes, $worked_seconds);

            // Determine overtime status
            $overtime = ($worked_hours >= $total_working_hours) ? "Yes" : "No";

            // Update the database with end time, worked hours, and overtime status
            $data = [
                "end_time" => $end_time,
                "worked_hours" => $worked_time,
                "overtime" => $overtime
            ];

            $update_where = "emp_id = $empid AND shift_date = '$current_date'";
            $update = $obj->update("attendance_record", $data, $update_where);

            if ($update) {
                echo json_encode([
                    "status" => 1,
                    "message" => "Shift ended successfully.",
                    "end_time" => $end_time,
                    "worked_hours" => $worked_time,
                    "overtime" => $overtime
                ]);
            } else {
                echo json_encode(["status" => 0, "message" => "Failed to update shift details."]);
            }
        } else {
            echo json_encode(["status" => 0, "message" => "No shift found for today."]);
        }
    }
}else{
    echo json_encode(["status" => 2]);
}

?>
