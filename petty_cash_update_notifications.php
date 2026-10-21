<?php

    include('session.php');

    $conn = mysqli_connect("localhost","root","","petty_cash");
    if (mysqli_connect_errno())
    {
    echo "Failed to connect to MySQL: " . mysqli_connect_error() ." | Seems like you haven't created the DATABASE with an exact name";
    }

    $id=$_POST['id'];
    $status=$_POST['status'];

    $approved_by=$firstname . '' . $lastname;

    $update=mysqli_query($conn,"Update expenses set status='$status',approved_by='$approved_by' where expense_id='$id'");

    if($update==true){
        echo "Data Updated Successfully";

        header("location:notifications.php");
    }else{
        echo "Data Not Updated";

    }

?>