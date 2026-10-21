<?php

include('database/db_connection.php');
include('session.php');

$emp_id = $_POST["id"];

$sql = "SELECT * FROM company_info WHERE emp_id = {$emp_id}";
$result = mysqli_query($con, $sql) or die("SQL Query Failed.");
$output = "";
if(mysqli_num_rows($result) > 0 ){

  while($row = mysqli_fetch_assoc($result)){

$output='';


            if($_SESSION['country']=='Romania'){

        

                $output .= "<div class='row'>
                                <div class='col-md-6'>
                                    <div class='form-group'> 
                                        <label for='field-1' class='control-label'>Company Name</label> 
                                        <input type='text' class='form-control' id='company_name' value='{$row["company_name"]}'> 
                                        <input type='text' id='edit-id' hidden value='{$emp_id}'>

                                        <input type='hidden' class='form-control' id='sponsor_id' value='{$row["sponsor_id"]}'> 

                                        <input type='hidden' class='form-control' id='visa_no' value='{$row["visa_no"]}'> 

                                        <input type='hidden' class='form-control' id='e_no' value='{$row["e_no"]}'> 

 


                                    </div>
                                </div>
                                <div class='col-md-6'>
                                    <div class='form-group'> 
                                        <label for='field-2' class='control-label'>Trade</label> 
                                        <input type='text' class='form-control' id='trade' value='{$row["trade"]}' > 
                                    </div>
                                </div>
                                <div class='col-md-6'>
                                    <div class='form-group'> 
                                        <label for='field-3' class='control-label'>Miscellaneous</label> 
                                        <input type='text' class='form-control' id='miscellaneous' value='{$row["miscellaneous"]}'> 
                                    </div>
                                </div>
                                
                            </div>


                
                
                
                    
                

                                <hr>

                                <div class='row'>
                                    
                                    <div class='col-md-12 text-center'>
                                        <div class='form-group'> 
                                        <input type='submit' id='edit-assign-update' class='btn btn-success' value='Update Company Info'>
                                        </div>
                                    </div>
                                </div>
                
                
                ";

            }else{

                $output .= "<div class='row'>
                                <div class='col-md-6'>
                                    <div class='form-group'> 
                                        <label for='field-1' class='control-label'>Company Name</label> 
                                        <input type='text' class='form-control' id='company_name' value='{$row["company_name"]}'> 
                                        <input type='text' id='edit-id' hidden value='{$row["emp_id"]}'>
                                    </div>
                                </div>
                              
                                <div class='col-md-6'>
                                    <div class='form-group'> 
                                        <label for='field-3' class='control-label'>Trade</label> 
                                        <input type='text' class='form-control' id='trade' value='{$row["trade"]}'> 
                                    </div>
                                </div>
                                <div class='col-md-6'>
                                    <div class='form-group'> 
                                        <label for='field-3' class='control-label'>E No</label> 
                                        <input type='text' class='form-control' id='e_no' value='{$row["e_no"]}'> 
                                    </div>
                                </div>
                                <div class='col-md-6'>
                                    <div class='form-group'> 
                                        <label for='field-3' class='control-label'>Visa No</label> 
                                        <input type='text' class='form-control' id='visa_no' value='{$row["visa_no"]}'> 
                                    </div>
                                </div>
                                <div class='col-md-6'>
                                    <div class='form-group'> 
                                        <label for='field-3' class='control-label'>Sponsor Id</label> 
                                        <input type='text' class='form-control' id='sponsor_id' value='{$row["sponsor_id"]}'> 
                                    </div>
                                </div>
                                <div class='col-md-6'>
                                    <div class='form-group'> 
                                        <label for='field-3' class='control-label'>Miscellaneous</label> 
                                        <input type='text' class='form-control' id='miscellaneous' value='{$row["miscellaneous"]}'> 
                                    </div>
                                </div>
                                
                            </div>
                
                
                
                    
                

                                <hr>

                                <div class='row'>
                                    
                                    <div class='col-md-12 text-center'>
                                        <div class='form-group'> 
                                        <input type='submit' id='edit-assign-update' class='btn btn-success' value='Update Company Info'>
                                        </div>
                                    </div>
                                </div>
                
                ";

            }

        }

        mysqli_close($con);
    
        echo $output;
    }else{
        echo "<h2>No Record Found.</h2>";
    }
?>
