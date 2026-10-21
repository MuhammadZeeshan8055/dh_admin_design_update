<?php

    include('database/db_connection.php');
    include('session.php');

    $id=$_POST['id'];
    $status=$_POST['status'];
    
    
    $_SESSION['id']=$id;
    
    if($status=='No'){
        $update_status='Ready To Apply';
        
          $approved_by=$firstname . ' ' . $lastname;

        $update=mysqli_query($con,"Update new_case_details set approved_by='$approved_by',status='$update_status' where id='$id'");
    
        if($update==true){
            echo "Data Updated Successfully";
    
            header("location:notifications.php");
        }else{
            echo "Data Not Updated";
    
        }
    }else{
        
       
        $delete_record=mysqli_query($con,"delete from new_case_details where id='$id'");
        $delete_payment_record=mysqli_query($con,"delete from payments where emp_id='$id'");
        
        if($delete_record==true){
            echo "Data Updated Successfully";
    
            header("location:index.php");
        }else{
            echo "Data Not Updated";
    
        }
    }

  

?>