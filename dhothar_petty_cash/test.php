<?php

    
  include("session.php");
  
  $lastmonth_date 	= date('Y-m-d', strtotime(date('Y-m-')."1 -1 month")).'/'.date('Y-m-t', strtotime(date('Y-m-d')."-1 month"));
  
   list($date1,$date2) = explode('/',$lastmonth_date);
		    
  
  $sql=mysqli_fetch_assoc(mysqli_query($con,"select sum(expense) as sum from expenses"));
  
   $sql2=mysqli_fetch_assoc(mysqli_query($con,"select sum(cash) as cash from cash "));
  
  echo $sql['sum'].'<br>';
  
  echo $sql2['cash'].'<br>';
  
  $remaining=$sql2['cash']-$sql['sum'];
  
  echo $remaining;
 

?>