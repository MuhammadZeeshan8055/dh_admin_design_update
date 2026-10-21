<?php

    include('database/db_connection.php');
    include('session.php');

    $id=$_POST['id'];
    $status=$_POST['status'];
    
    
    $_SESSION['id']=$id;
    
    if($status=='No'){
        $update_status='Ready To Apply';
    }else{
        
        $update_status='Returned';
    }

    $approved_by=$firstname . ' ' . $lastname;

    $update=mysqli_query($con,"Update new_case_details set status='$update_status',approved_by='$approved_by' where id='$id'");

    if($update==true){
        echo "Data Updated Successfully";

        header("location:notifications.php");
    }else{
        echo "Data Not Updated";

    }

?>