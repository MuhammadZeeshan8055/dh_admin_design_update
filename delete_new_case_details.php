<?php


include('database/db_connection.php');
include('session.php');

$id = $_POST["id"];


$sql = "DELETE FROM new_case_details WHERE id = {$id}";

if(mysqli_query($con, $sql)){
  echo 1;
}else{
  echo 0;
}

?>
