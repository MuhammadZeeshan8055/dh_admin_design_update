<?php


include('database/db_connection.php');
include('session.php');

$id = $_POST["id"];

 $entered_by = $firstname . ' ' . $lastname;

$sql = "update new_case_details set status_changed_by='$entered_by',status='Request Delete' WHERE id = {$id}";

if(mysqli_query($con, $sql)){
  echo 1;
}else{
  echo 0;
}

?>
