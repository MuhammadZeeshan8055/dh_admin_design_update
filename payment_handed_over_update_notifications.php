<?php

    include('database/db_connection.php');
    include('session.php');

    $id=$_POST['id'];
    $status=$_POST['status'];

    $approved_by=$firstname . '' . $lastname;

    $update=mysqli_query($con,"Update payment_handed_over_to set approved='$status',approved_by='$approved_by' where id='$id'");

    if($update==true){
        echo "Data Updated Successfully";

        header("location:payment_handed_over_to_notifications.php");
    }else{
        echo "Data Not Updated";

    }

?>