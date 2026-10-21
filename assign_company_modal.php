<?php

include('database/db_connection.php');
include('session.php');

$emp_id = $_POST["id"];
$output='';


            if($_SESSION['country']=='Romania'){

        

                $output .= "<div class='row'>
                                <div class='col-md-6'>
                                    <div class='form-group'> 
                                        <label for='field-1' class='control-label'>Company Name</label> 
                                        <input type='text' class='form-control' id='company_name'> 
                                        <input type='text' id='edit-id' hidden value='{$emp_id}'>

                                        <input type='hidden' class='form-control' id='sponsor_id' value=' '> 

                                        <input type='hidden' class='form-control' id='visa_no' value=' '> 

                                        <input type='hidden' class='form-control' id='e_no' value=' '> 

 


                                    </div>
                                </div>
                                <div class='col-md-6'>
                                    <div class='form-group'> 
                                        <label for='field-2' class='control-label'>Trade</label> 
                                        <input type='text' class='form-control' id='trade' value='{$emp_id}'> 
                                    </div>
                                </div>
                                <div class='col-md-6'>
                                    <div class='form-group'> 
                                        <label for='field-3' class='control-label'>Miscellaneous</label> 
                                        <input type='text' class='form-control' id='miscellaneous'> 
                                    </div>
                                </div>
                                
                            </div>


                
                
                
                    
                

                                <hr>

                                <div class='row'>
                                    
                                    <div class='col-md-12 text-center'>
                                        <div class='form-group'> 
                                        <input type='submit' id='edit-assign' class='btn btn-success' value='Assign Company'>
                                        </div>
                                    </div>
                                </div>
                
                
                ";

            }else{

                $output .= "<div class='row'>
                                <div class='col-md-6'>
                                    <div class='form-group'> 
                                        <label for='field-1' class='control-label'>Company Name</label> 
                                        <input type='text' class='form-control' id='company_name' value=' '> 
                                        <input type='text' id='edit-id' hidden >
                                    </div>
                                </div>
                                
                                <div class='col-md-6'>
                                    <div class='form-group'> 
                                        <label for='field-3' class='control-label'>Trade</label> 
                                        <input type='text' class='form-control' id='trade' value=' '> 
                                    </div>
                                </div>
                                <div class='col-md-6'>
                                    <div class='form-group'> 
                                        <label for='field-3' class='control-label'>E No</label> 
                                        <input type='text' class='form-control' id='e_no' value=' '> 
                                    </div>
                                </div>
                                <div class='col-md-6'>
                                    <div class='form-group'> 
                                        <label for='field-3' class='control-label'>Visa No</label> 
                                        <input type='text' class='form-control' id='visa_no' value=' '> 
                                    </div>
                                </div>
                                <div class='col-md-6'>
                                    <div class='form-group'> 
                                        <label for='field-3' class='control-label'>Sponsor Id</label> 
                                        <input type='text' class='form-control' id='sponsor_id' value=' '> 
                                    </div>
                                </div>
                                <div class='col-md-6'>
                                    <div class='form-group'> 
                                        <label for='field-3' class='control-label'>Miscellaneous</label> 
                                        <input type='text' class='form-control' id='miscellaneous' value=' '> 
                                    </div>
                                </div>
                                
                            </div>
                
                
                
                    
                

                                <hr>

                                <div class='row'>
                                    
                                    <div class='col-md-12 text-center'>
                                        <div class='form-group'> 
                                        <input type='submit' id='edit-assign' class='btn btn-success' value='Assign Company'>
                                        </div>
                                    </div>
                                </div>
                
                ";

            }


    mysqli_close($con);

    echo $output;


?>
