<?php
include('database/db_connection.php');
include('session.php');

if (isset($_POST['record_id']) && isset($_POST['table_name'])) {
    $record_id = mysqli_real_escape_string($con, $_POST['record_id']);
    $table_name = mysqli_real_escape_string($con, $_POST['table_name']);

    $query = "
        UPDATE audit_log 
        SET viewed = 1 
        WHERE record_id = '$record_id' 
        AND table_name = '$table_name'
    ";

    if (mysqli_query($con, $query)) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "invalid";
}
?>
