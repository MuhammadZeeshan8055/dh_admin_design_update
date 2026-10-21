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


$assign_company=mysqli_query($con,"insert into company_info (emp_id,company_name,trade,e_no,visa_no,sponsor_id,miscellaneous) 
         VALUES 
         ('$emp_ID','$company_name','$trade','$e_no','$visa_no','$sponsor_id','$miscellaneous')");

if($assign_company==true){
  echo 1;
}else{
  echo 0;
}

?>
