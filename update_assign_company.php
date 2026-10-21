<?php


include('database/db_connection.php');
include('session.php');


$emp_ID = $_POST["id"];
$company_name = $_POST["company_name"];
$trade = $_POST["trade"];
$e_no = $_POST["e_no"];
$visa_no = $_POST["visa_no"];
$sponsor_id= $_POST["sponsor_id"];
$miscellaneous=$_POST["miscellaneous"];


$update_assign_company=mysqli_query($con,"update company_info set company_name='$company_name',trade='$trade',
e_no='$e_no',visa_no='$visa_no',sponsor_id='$sponsor_id',miscellaneous='$miscellaneous' where emp_id='$emp_ID'
");

if($update_assign_company==true){
  echo 1;
}else{
  echo 0;
}

?>
