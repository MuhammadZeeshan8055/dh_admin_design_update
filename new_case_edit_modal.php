<?php
include('session.php');

if (empty($_SESSION['dh_company_options'])) {
    $company_html = '';
    $company_list = mysqli_query($con, "SELECT company_name FROM company_list");
    if ($company_list) {
        while ($comp_name = mysqli_fetch_assoc($company_list)) {
            $cn = htmlspecialchars($comp_name['company_name'], ENT_QUOTES, 'UTF-8');
            $company_html .= "<option value='{$cn}'>{$cn}</option>";
        }
    }
    $_SESSION['dh_company_options'] = $company_html;
}
if (empty($_SESSION['dh_trade_options'])) {
    $trade_html = '';
    $trade_list = mysqli_query($con, "SELECT trade FROM trade");
    if ($trade_list) {
        while ($trade_name = mysqli_fetch_assoc($trade_list)) {
            $tn = htmlspecialchars($trade_name['trade'], ENT_QUOTES, 'UTF-8');
            $trade_html .= "<option value='{$tn}'>{$tn}</option>";
        }
    }
    $_SESSION['dh_trade_options'] = $trade_html;
}
session_write_close();
?>

<style>
    .passport-returned-date,.passport-returned-date-label {
        display: none;
    }

</style>

<?php
$id = $_POST["id"];

$sql = "SELECT * FROM new_case_details WHERE id = {$id}";
$result = mysqli_query($con, $sql) or die("SQL Query Failed.");
$output = "";
if(mysqli_num_rows($result) > 0 ){

  while($row = mysqli_fetch_assoc($result)){
      
    $check_company = mysqli_fetch_assoc(mysqli_query($con, "select * from company_info where emp_id='$row[id]'"));
    if (!is_array($check_company)) {
        $check_company = array(
            'company_name' => '',
            'trade' => '',
            'miscellaneous' => ''
        );
    }
    
    
    $output .= "<div class='row'>
                    <div class='col-md-3'>
                        <div class='form-group'> 
                            <label for='field-1' class='control-label'>Name</label> 
                            <input type='text' class='form-control' id='name' value='{$row["name"]}'> 
                            <input type='text' id='edit-id' hidden value='{$row["id"]}'>
                        </div>
                    </div>
                    <div class='col-md-3'>
                        <div class='form-group'> 
                            <label for='field-2' class='control-label'>Father Name</label> 
                            <input type='text' class='form-control' id='fname' value='{$row["fname"]}'> 
                        </div>
                    </div>
                    <div class='col-md-3'>
                        <div class='form-group'> 
                            <label for='field-3' class='control-label'>PP NO</label> 
                            <input type='text' class='form-control' id='pp_no' value='{$row["pp_no"]}'> 
                        </div>
                    </div>
                    <div class='col-md-3'>
                        <div class='form-group'> 
                            <label for='field-4' class='control-label'>PP Expiry</label> 
                            <input type='date' class='form-control' id='pp_expiry' value='{$row["pp_expiry"]}'> 
                        </div>
                    </div>
                </div>
                
                <div class='row'>
                    
                    <div class='col-md-3'>
                        <div class='form-group'> 
                            <label for='field-5' class='control-label'>Tracking Id</label>
                            <input type='text' class='form-control' id='tracking_id' value='{$row["tracking_id"]}'> 
                        </div>
                    </div>
                    <div class='col-md-3'>
                        <div class='form-group'> 
                            <label for='field-6' class='control-label'>New Case Date</label> 
                            <input type='date' class='form-control' id='new_case_date' value='{$row["new_case_date"]}'> 
                        </div>
                    </div>
                    <div class='col-md-3'>
                        <div class='form-group'> 
                            <label for='field-6' class='control-label'>Date Of Birth</label> 
                            <input type='date' class='form-control' name='date_of_birth' id='date_of_birth' value='{$row["date_of_birth"]}'> 
                        </div>
                    </div>
                    <div class='col-md-3'>
                        <div class='form-group'> 
                            <label for='field-6' class='control-label'>Age</label> 
                            <input type='text' readonly class='form-control' name='client_age' id='client_age' value='{$row["client_age"]}'> 
                        </div>
                    </div>
                </div>
                ";

                    $care_off_list=mysqli_query($con,"select name from care_off_persons");

                    $output.="
                <div class='row'>
                    <div class='col-md-3'>
                        <div class='form-group'> 
                            <label for='field-6' class='control-label'>Care of</label>
                            <select name='' id='care_of' class='form-control'>
                            
                             ";

                                if(!empty($row["care_of"])){
                                    
                                    $output.="
                                        <option value='{$row["care_of"]}'>{$row["care_of"]}</option>
                                    ";
                                    
                                }else{
                                    $output.="
                                        <option>Select Care Off</option>
                                    ";
                                    
                                    
                                }


                                while($care_of_name = mysqli_fetch_assoc($care_off_list)){
                                    
                                    $output.="
                                        <option value='{$care_of_name["name"]}'>{$care_of_name["name"]}</option>
                                        
                                    ";
                                    
                                }  

                            $output.="
                                <option>none</option>
                            </select>
                        </div>
                    </div>
                    <div class='col-md-3'>
                        <div class='form-group'> 
                            <label for='field-6' class='control-label'>Mobile No 1</label> 
                            <input type='text' class='form-control' id='mobile_no_1' value='{$row["mobile_no_1"]}'> 
                        </div>
                    </div>
                    <div class='col-md-3'>
                        <div class='form-group'> 
                            <label for='field-6' class='control-label'>Mobile No 2</label> 
                            <input type='text' class='form-control' id='mobile_no_2' value='{$row["mobile_no_2"]}'> 
                        </div>
                    </div>
                    ";

                    $country_list=mysqli_query($con,"select country_name from country");

                    $output.="
                    <div class='col-md-3'>
                        <div class='form-group'> 
                            <label for='field-6' class='control-label'>Country</label> 
                            <select name='' id='country' class='form-control'>
                             ";

                                if(!empty($row["country"])){
                                    
                                    $output.="
                                        <option value='{$row["country"]}'>{$row["country"]}</option>
                                    ";
                                    
                                }else{
                                    $output.="
                                        <option>Select Company</option>
                                    ";
                                    
                                    
                                }


                                while($country_name = mysqli_fetch_assoc($country_list)){
                                    
                                    $output.="
                                        <option value='{$country_name["country_name"]}'>{$country_name["country_name"]}</option>
                                        
                                    ";
                                    
                                }  

                            $output.="
                                <option>none</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-3'>
                        <div class='form-group'> 
                            <label for='field-6' class='control-label'>Missing Documents</label> 
                            ";

                            if($row['docs_missing']=='Yes'){

                                $output.="

                                    <input type='checkbox' name='missing' value='NO' id='docs_missing'> No Documents Missing ?

                                ";
                            }else{

                                
                                $output.="
                                    <input type='checkbox' name='missing' value='Yes' id='docs_missing'> Any Documents Missing ?
                                ";

                            }
                            $output.="

                            <input type='text' class='form-control' id='missing_documents' value='{$row["missing_documents"]}'> 
                        </div>
                    </div>

                    <div class='col-md-3'>
                        <div class='form-group'> 
                            <label for='field-6' class='control-label'>Passport Returned</label> 
                            ";

                            if($row['passport_returned']=='Yes'){

                                $output.="

                                    <input type='checkbox' name='passport_returned' value='No' id='passport_returned' checked> Have you returned Passport ?

                                ";
                            }else{

                                
                                $output.="
                                    <input type='checkbox' name='passport_returned' value='Yes' id='passport_returned'> Have you returned Passport ?
                                ";

                            }
                            $output.="

                            <input type='text' class='form-control' id='passport_returned_description' value='{$row["passport_returned_description"]}'> 

                            <label for='field-6' class='passport-returned-date-label'>Passport Returned Date</label> 
                            <input type='date' class='passport-returned-date form-control' id='passport_returned_date' value='{$row["passport_returned_date"]}'>
                        </div>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-3'>
                        <div class='form-group'> 
                            <label for='field-6' class='control-label'>Apply Date</label> 
                            <input type='date' class='form-control' id='apply_date' value='{$row["apply_date"]}'> 
                        </div>
                    </div>
                    <div class='col-md-3'>
                        <div class='form-group'> 
                            <label for='field-6' class='control-label'>First Character Issue Date</label> 
                            <input type='date' class='form-control' id='first_character_issue_date' value=''> 
                        </div>
                    </div>
                    <div class='col-md-3'>
                        <div class='form-group'> 
                            <label for='field-6' class='control-label'>First Character Expiry</label> 
                            <input type='date' class='form-control' id='first_character_expiry' value='{$row["first_character_expiry"]}'> 
                        </div>
                    </div>
                    <div class='col-md-3'>
                        <div class='form-group'> 
                            <label for='field-6' class='control-label'>Second Character Issue Date</label> 
                            <input type='date' class='form-control' id='second_character_issue_date' value=''> 
                        </div>
                    </div>
                    <div class='col-md-3'>
                        <div class='form-group'> 
                            <label for='field-6' class='control-label'>Second Character Expiry</label> 
                            <input type='date' class='form-control' id='second_character_expiry' value='{$row["second_character_expiry"]}'> 
                        </div>
                    </div>
                    <div class='col-md-3'>
                        <div class='form-group'> 
                            <label for='field-6' class='control-label'>Online Submission Date</label> 
                            <input type='date' class='form-control' id='online_submission_date' value='{$row["online_submission_date"]}'> 
                        </div>
                    </div>
                    <div class='col-md-3'>
                        <div class='form-group'> 
                            <label for='field-6' class='control-label'>Physical Submission Date</label> 
                            <input type='date' class='form-control' id='physical_submission_date' value='{$row["physical_submission_date"]}'> 
                        </div>
                    </div>
                    <div class='col-md-3'>
                        <div class='form-group'> 
                            <label for='field-6' class='control-label'>Work Permit Receiving Date</label> 
                            <input type='date' class='form-control' id='work_permit_receiving_date' value='{$row["work_permit_receiving_date"]}'> 
                        </div>
                    </div>
                    <div class='col-md-3'>
                        <div class='form-group'> 
                            <label for='field-6' class='control-label'>Appointment Date</label> 
                            <input type='date' class='form-control' id='appointment_date' value='{$row["appointment_date"]}'> 
                        </div>
                    </div>
                    <div class='col-md-3 text-center'>
                        <div class='form-group'> 
                            <label for='field-6' class='control-label'>Status</label> 
                            <select name='' id='status' class='form-control'>

                            ";

                            if($row["country"]=="ROMANIA"){

                                if($row["status"]=='Ready To Apply'){
                                
                                    $output.="
                                    <option value='{$row["status"]}'>{$row["status"]}</option>
                                    <option value='Applied'>Applied</option>
                                    <option value='Returned'>Returned</option>
                                
                                    ";
                                }elseif($row["status"]=='Applied'){
                                    $output.="
                                    <option value='{$row["status"]}'>{$row["status"]}</option>
                                    <option value='Ready To Apply'>Ready To Apply</option>
                                    <option value='Work Permit Issued'>Work Permit Issued</option>
                                    <option value='Returned'>Returned</option>
                                
                                    ";
                                }elseif($row["status"]=='Work Permit Issued'){
                                    $output.="
                                    <option value='{$row["status"]}'>{$row["status"]}</option>                                
                                    <option value='Ready To Apply'>Ready To Apply</option>
                                    <option value='Applied'>Applied</option>
                                    <option value='Appointment Applied'>Appointment Applied</option>
                                    <option value='Returned'>Returned</option>
                                
                                    ";
                                }elseif($row["status"]=='Appointment Applied'){
                                    $output.="
                                    <option value='{$row["status"]}'>{$row["status"]}</option>
                                    <option value='Ready To Apply'>Ready To Apply</option>
                                    <option value='Applied'>Applied</option>
                                    <option value='Visa Issued'>Visa Issued</option>
                                    <option value='Return From Embassy'>Return From Embassy</option>
                                    <option value='Returned'>Returned</option>
                                
                                    ";
                                }elseif($row["status"]=='Visa Issued'){
                                    $output.="
                                    <option value='{$row["status"]}'>{$row["status"]}</option>
                                    <option value='Ready To Apply'>Ready To Apply</option>
                                    <option value='Applied'>Applied</option>
                                    <option value='Appointment Applied'>Appointment Applied</option>
                                    <option value='Fly'>Fly</option>
                                    <option value='Returned'>Returned</option>
                                
                                    ";
                                }
                                else{
                                    $output.="
                                    <option value='{$row["status"]}'>{$row["status"]}</option>
                                    <option value='Ready to Apply'>Ready to Apply</option>
                                    <option value='Applied'>Applied</option>
                                    <option value='Returned'>Returned</option>
                                    <option value='Work Permit Issued'>Work Permit Issued</option>
                                    <option value='Appointment Applied'>Appointment Applied</option>
                                    <option value='Visa Issued'>Visa Issued</option>
                                    <option value='Fly'>Fly</option>
                                    ";
                                }

                            }else{

                                if($row['status']=='Ready to Apply'){
                                    
                                    $output.="
                                    <option value='{$row["status"]}'>{$row["status"]}</option>
                                    <option value='Applied'>Applied</option>
                                    <option value='Returned'>Returned</option>

                                    ";

                                }elseif($row['status']=='Applied'){

                                    $output.="
                                    <option value='{$row["status"]}'>{$row["status"]}</option>
                                    <option value='Ready to Apply'>Ready to Apply</option>
                                    <option value='Work Permit Issued'>Work Permit Issued</option>
                                    <option value='Visa Issued'>Visa Issued</option>
                                    <option value='Returned'>Returned</option>

                                    ";

                                }elseif($row['status']=='Visa Issued'){

                                    $output.="
                                    <option value='{$row["status"]}'>{$row["status"]}</option>
                                    <option value='Ready to Apply'>Ready to Apply</option>
                                    <option value='Visa Issued'>Applied</option>
                                    <option value='Visa Issued'>Fly</option>
                                    <option value='Returned'>Returned</option>

                                    ";

                                } else{
                                    $output.="
                                    <option value='{$row["status"]}'>{$row["status"]}</option>
                                    <option value='Ready to Apply'>Ready to Apply</option>
                                    <option value='Applied'>Applied</option>
                                    <option value='Returned'>Returned</option>
                                    <option value='Work Permit Issued'>Work Permit Issued</option>
                                    <option value='Appointment Applied'>Appointment Applied</option>
                                    <option value='Visa Issued'>Visa Issued</option>
                                    <option value='Fly'>Fly</option>
                                    ";
                                }
                            }

                            $output.="
                            </select>
                        </div>
                    </div>
                    
                    ";
                    
                    if($row['status']=='Visa Issued'){
                        $output.="
                            <div class='col-md-3'>
                                <div class='form-group'> 
                                    <label for='field-6' class='control-label'>Visa Issue Date</label> 
                                    <input type='date' class='form-control' id='visa_issue_date' value='{$row['visa_issue_date']}'> 
                                </div>
                            </div>
                            <div class='col-md-3'>
                                <div class='form-group'> 
                                    <label for='field-6' class='control-label'>Visa Expiry Date</label> 
                                    <input type='date' class='form-control' id='visa_expiry_date' value='{$row['visa_issue_date']}'> 
                                </div>
                            </div>
                        ";
                        
                    }
                    
                    $output.="
                    
                    <div class='col-md-3 text-center'>
                        <div class='form-group'> 
                            <label for='field-6' class='control-label'>Company Name</label> 
                            <select name='' id='company_name' class='form-control'>
                            
                            ";
                            
                            if(!empty($check_company["company_name"])){
                                
                                $output.="
                                    <option value='{$check_company["company_name"]}'>{$check_company["company_name"]}</option>
                                ";
                                
                            }else{
                                 $output.="
                                    <option>Select Company</option>
                                ";
                                
                                
                            }
                            
                            
                            $output .= $_SESSION['dh_company_options'];
                            

                               

                            $output.="
                                <option>none</option>
                            </select>
                        </div>
                    </div>
                    
                    ";
                    //       <div class='col-md-3'>
                    //     <div class='form-group'> 
                    //         <label for='field-6' class='control-label'>Company Name</label> 
                    //         <input type='text' class='form-control' value='{$check_company["company_name"]}' id='company_name' value=''> 
                    //     </div>
                    // </div>
                    
                    $output.="
                    
                    <div class='col-md-3 text-center'>
                        <div class='form-group'> 
                            <label for='field-6' class='control-label'>Trade</label> 
                            <select name='' id='trade' class='form-control'>
                            
                            ";
                            
                            if(!empty($check_company["trade"])){
                                
                                $output.="
                                    <option value='{$check_company['trade']}'>{$check_company['trade']}</option>
                                ";
                                
                            }else{
                                 $output.="
                                    <option>Select Trade</option>
                                ";
                                
                                
                            }
                            
                            
                            $output .= $_SESSION['dh_trade_options'];

                               

                            $output.="
                                <option>none</option>
                            </select>
                        </div>
                    </div>
                    
                    ";
                    
                    //   <div class='col-md-3'>
                    //     <div class='form-group'> 
                    //         <label for='field-6' class='control-label'>Trade</label> 
                    //         <input type='text' class='form-control' value='{$check_company["trade"]}' id='trade' value=''> 
                    //     </div>
                    // </div>
                    
                    $misc_val = htmlspecialchars($check_company["miscellaneous"] ?? '', ENT_QUOTES);
                    $comments_val = htmlspecialchars($row["comments"] ?? '', ENT_QUOTES);
                    $output.="
              
                 
                    <div class='col-md-3'>
                        <div class='form-group'> 
                            <label for='field-6' class='control-label'>Miscellaneous</label> 
                            <input type='text' class='form-control' value='{$misc_val}' id='miscellaneous'> 
                        </div>
                    </div>
                    <div class='col-md-6'>
                        <div class='form-group'> 
                            <label for='field-6' class='control-label'>Comments (Optional)</label> 
                            <textarea class='form-control' id='comments' name='comments' rows='3'>{$comments_val}</textarea>
                        </div>
                    </div>
                </div>

             
                <div class='row'>
                    
                    <div class='col-md-12 text-center'>
                        <div class='form-group'> 
                        <input type='submit' id='edit-submit' class='btn btn-success' value='Update'>
                        </div>
                    </div>
                </div>
                
                

                
                
                ";

  }

    mysqli_close($con);

    echo $output;
}else{
    echo "<h2>No Record Found.</h2>";
}

?>
<script>
    $(document).ready(function() {
        // Show or hide based on initial checkbox state
        if ($('#passport_returned').is(':checked')) {
            $('.passport-returned-date').show();
            $('.passport-returned-date-label').show();
        } else {
            $('.passport-returned-date').hide();
            $('.passport-returned-date-label').hide();
        }
    
        // Toggle visibility when checkbox changes
        $('#passport_returned').on('change', function() {
            if ($(this).is(':checked')) {
                $('.passport-returned-date').slideDown();
                $('.passport-returned-date-label').slideDown();
            } else {
                $('.passport-returned-date').slideUp();
                $('.passport-returned-date-label').slideUp();
            }
        });

        
        document.querySelector('input[name="date_of_birth"]').addEventListener('change', function() {
            let dob = new Date(this.value);
            let today = new Date();
    
            if (!isNaN(dob.getTime())) {
            let age = today.getFullYear() - dob.getFullYear();
            let monthDiff = today.getMonth() - dob.getMonth();
            let dayDiff = today.getDate() - dob.getDate();
    
            // If birthday not reached yet this year → subtract 1
            if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
                    age--;
            }
    
            document.querySelector('input[name="client_age"]').value = `${age} Years Old`;
            }
        });
    });
</script>
