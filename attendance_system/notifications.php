<?php

include('../session.php'); // make sure this has NO output

$current_date = currentDate();

$sql = "SELECT * FROM attendance_record WHERE emp_id = '$userid' and shift_date='$current_date' and (end_time = '' OR end_time IS NULL)  and start_time != '' ORDER BY id DESC LIMIT 1";
$result = $con->query($sql);

if ($row = $result->fetch_assoc()) {
    echo json_encode(['status' => 'new','message' => 'Make sure to end your shift before leaving.']);
} else {
    echo json_encode(['status' => 'none']);
}

// header('Content-Type: application/json');
// echo json_encode([
//     'status' => 'new',
//     'message' => 'Mark Your End Time'
// ]);
?>