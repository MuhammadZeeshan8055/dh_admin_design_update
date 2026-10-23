<?php


include('database/db_connection.php');
include('session.php');
include('attendance_system/database.php');
$db = new Database();
session_write_close();

function dh_in($con, $key) {
    if (!isset($_POST[$key])) {
        return '';
    }
    return mysqli_real_escape_string($con, $_POST[$key]);
}

$current_date=date('Y-m-d');

$id = dh_in($con, 'id');
$status = dh_in($con, 'status');

if ($status == 'Applied') {

    $payment_check = mysqli_query(
        $con,
        "SELECT first_payment
         FROM payments
         WHERE first_payment > 0
         AND emp_id = '$id'"
    );

    if (mysqli_num_rows($payment_check) == 0) {
        echo "PAYMENT_NOT_FOUND";
        exit;
    }
}

if ($status == 'Fly') {

    $payment_check = mysqli_query(
        $con,
        "SELECT first_payment, second_payment, final_payment 
                FROM payments 
                WHERE first_payment > 0 
                  AND second_payment > 0 
                  AND final_payment > 0 
                  AND emp_id = '$id'"
    );

    if (mysqli_num_rows($payment_check) == 0) {
        echo "FULL_PAYMENT_RECORD_NOT_FOUND";
        exit;
    }
}

$name = dh_in($con, 'name');
$fname = dh_in($con, 'fname');
$pp_no = dh_in($con, 'pp_no');
$pp_expiry = dh_in($con, 'pp_expiry');
$tracking_id = dh_in($con, 'tracking_id');
$new_case_date = dh_in($con, 'new_case_date');
$date_of_birth = dh_in($con, 'date_of_birth');
$client_age = dh_in($con, 'client_age');
$care_of = dh_in($con, 'care_of');
$mobile_no_1 = dh_in($con, 'mobile_no_1');
$mobile_no_2 = dh_in($con, 'mobile_no_2');
$missing_documents = dh_in($con, 'missing_documents');
$passport_returned_description = dh_in($con, 'passport_returned_description');
$docs_missing = '';
$passport_returned = '';

if(!empty($missing_documents)){
    $docs_missing = dh_in($con, 'docs_missing');
}
if(!empty($passport_returned_description)){
    $passport_returned = dh_in($con, 'passport_returned');
}

$country = dh_in($con, 'country');
$first_character_expiry = dh_in($con, 'first_character_expiry');
$second_character_expiry = dh_in($con, 'second_character_expiry');
$online_submission_date = dh_in($con, 'online_submission_date');
$physical_submission_date = dh_in($con, 'physical_submission_date');
$work_permit_receiving_date = dh_in($con, 'work_permit_receiving_date');
$appointment_date = dh_in($con, 'appointment_date');
$apply_date = dh_in($con, 'apply_date');
$visa_issue_date = dh_in($con, 'visa_issue_date');
$visa_expiry_date = dh_in($con, 'visa_expiry_date');

$comments = dh_in($con, 'comments');

$status_changed_by = $username;

$updated_by = $username;

if($status=='Returned'){
    $passport_returned_date=todayDate();
}elseif(!empty($passport_returned_description)){
    $passport_returned_date = dh_in($con, 'passport_returned_date');
}else{
    $passport_returned_date='';
}

$check_old_status=mysqli_fetch_assoc(mysqli_query($con,"select status,status_updated_at from new_case_details where id='{$id}'"));



if($status==$check_old_status['status']){
    $status_updated_at = $check_old_status['status_updated_at'];
}else{
     $status_updated_at=todayDate();
}

# ✅ Get old data before updating
$oldData = $db->getOldData('new_case_details', 'id', $id);

$sql = "UPDATE new_case_details SET name = '{$name}',fname = '{$fname}',pp_no = '{$pp_no}',pp_expiry = '{$pp_expiry}',tracking_id = '{$tracking_id}',new_case_date = '{$new_case_date}',date_of_birth = '{$date_of_birth}',client_age = '{$client_age}',care_of = '{$care_of}',mobile_no_1='$mobile_no_1',mobile_no_2='$mobile_no_2',missing_documents = '{$missing_documents}',docs_missing = '{$docs_missing}',passport_returned = '{$passport_returned}',passport_returned_description = '{$passport_returned_description}',country = '{$country}',apply_date = '{$apply_date}',first_character_expiry='{$first_character_expiry}',second_character_expiry='{$second_character_expiry}',online_submission_date='{$online_submission_date}',physical_submission_date='{$physical_submission_date}',work_permit_receiving_date='{$work_permit_receiving_date}',appointment_date='{$appointment_date}',status_changed_by='$status_changed_by',status='{$status}',passport_returned_date='{$passport_returned_date}',visa_issue_date='{$visa_issue_date}',visa_expiry_date='{$visa_expiry_date}',comments='{$comments}',updated_by='{$updated_by}',updated_on='{$current_date}',status_updated_at='{$status_updated_at}' WHERE id = {$id}";


# ✅ Prepare new data array for logging
$newData = [
    'name' => $name,
    'fname' => $fname,
    'pp_no' => $pp_no,
    'pp_expiry' => $pp_expiry,
    'tracking_id' => $tracking_id,
    'new_case_date' => $new_case_date,
    'date_of_birth' => $date_of_birth,
    'client_age' => $client_age,
    'care_of' => $care_of,
    'mobile_no_1' => $mobile_no_1,
    'mobile_no_2' => $mobile_no_2,
    'missing_documents' => $missing_documents,
    'docs_missing' => $docs_missing ?? '',
    'passport_returned' => $passport_returned ?? '',
    'passport_returned_description' => $passport_returned_description,
    'country' => $country,
    'apply_date' => $apply_date,
    'first_character_expiry' => $first_character_expiry,
    'second_character_expiry' => $second_character_expiry,
    'online_submission_date' => $online_submission_date,
    'physical_submission_date' => $physical_submission_date,
    'work_permit_receiving_date' => $work_permit_receiving_date,
    'appointment_date' => $appointment_date,
    'status_changed_by' => $status_changed_by,
    'status' => $status,
    'passport_returned_date' => $passport_returned_date,
    'visa_issue_date' => $visa_issue_date,
    'visa_expiry_date' => $visa_expiry_date,
    'comments' => $comments,
    'updated_by' => $updated_by,
    'updated_on' => $current_date,
    'status_updated_at' => $status_updated_at
];



//company data
$company_name = dh_in($con, 'company_name');
$trade = dh_in($con, 'trade');
$miscellaneous = dh_in($con, 'miscellaneous');

$check_company=mysqli_query($con,"select * from company_info where emp_id={$id}");

if(mysqli_num_rows($check_company) > 0){
    
    
    $company="UPDATE company_info SET company_name='{$company_name}',trade='{$trade}',miscellaneous='{$miscellaneous}' WHERE emp_id = {$id}";
    mysqli_query($con, $company);
    
}else{
    $company=mysqli_query($con,"insert into company_info (emp_id,company_name,trade,miscellaneous) values ('{$id}','{$company_name}','{$trade}','{$miscellaneous}')");
}



if(mysqli_query($con, $sql)){
    echo '1';
    if (function_exists('ob_flush')) { @ob_flush(); }
    flush();
    $db->logChanges('new_case_details', $id, $oldData, $newData, $userid);
    exit;
}else{
    echo '0';
    exit;
}

?>
