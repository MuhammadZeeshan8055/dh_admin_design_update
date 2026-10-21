<?php


include('database/db_connection.php');
include('session.php');
include('attendance_system/database.php');
$db = new Database();

$current_date=date('Y-m-d');

$id = $_POST["id"];
$status = $_POST["status"];

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

$name = $_POST["name"];
$fname = $_POST["fname"];
$pp_no = $_POST["pp_no"];
$pp_expiry = $_POST["pp_expiry"];
$tracking_id= $_POST["tracking_id"];
$new_case_date=$_POST["new_case_date"];
$date_of_birth=$_POST["date_of_birth"];
$client_age=$_POST["client_age"];
$care_of=$_POST["care_of"];
$mobile_no_1=$_POST["mobile_no_1"];
$mobile_no_2=$_POST["mobile_no_2"];
$missing_documents = $_POST["missing_documents"];
$passport_returned_description = $_POST["passport_returned_description"];

if(!empty($missing_documents)){
    $docs_missing = $_POST["docs_missing"];

}
if(!empty($passport_returned_description)){
    $passport_returned = $_POST["passport_returned"];

}

$country = $_POST["country"];
$first_character_expiry = $_POST["first_character_expiry"];
$second_character_expiry = $_POST["second_character_expiry"];
$online_submission_date = $_POST["online_submission_date"];
$physical_submission_date = $_POST["physical_submission_date"];
$work_permit_receiving_date = $_POST["work_permit_receiving_date"];
$appointment_date = $_POST["appointment_date"];
$apply_date = $_POST["apply_date"];
$visa_issue_date = $_POST["visa_issue_date"];
$visa_expiry_date = $_POST["visa_expiry_date"];

$comments = $_POST["comments"];

$status_changed_by = $username;

$updated_by = $username;

if($status=='Returned'){
    $passport_returned_date=todayDate();
}elseif(!empty($passport_returned_description)){
    $passport_returned_date=$_POST["passport_returned_date"];
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

$sql = "UPDATE new_case_details SET name = '{$name}',fname = '{$fname}',pp_no = '{$pp_no}',pp_expiry = '{$pp_expiry}',tracking_id = '{$tracking_id}',new_case_date = '{$new_case_date}',date_of_birth = '{$date_of_birth}',client_age = '{$client_age}',care_of = '{$care_of}',mobile_no_1='$mobile_no_1',mobile_no_2='$mobile_no_2',missing_documents = '{$missing_documents}',docs_missing = '{$docs_missing}',passport_returned = '{$passport_returned}',passport_returned_description = '{$passport_returned_description}',country = '{$country}',apply_date = '{$apply_date}',first_character_expiry='{$first_character_expiry}',second_character_expiry='{$second_character_expiry}',online_submission_date='{$online_submission_date}',physical_submission_date='{$physical_submission_date}',work_permit_receiving_date='{$work_permit_receiving_date}',appointment_date='{$appointment_date}',status_changed_by='$status_changed_by',status='{$status}',passport_returned_date='{$passport_returned_date}',visa_issue_date='{$visa_issue_date}',visa_expiry_date='{$visa_expiry_date}',comments='{comments}',updated_by='{$updated_by}',updated_on='{$current_date}',status_updated_at='{$status_updated_at}' WHERE id = {$id}";


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
$company_name = $_POST["company_name"];
$trade = $_POST["trade"];
$miscellaneous = $_POST["miscellaneous"];

$check_company=mysqli_query($con,"select * from company_info where emp_id={$id}");

if(mysqli_num_rows($check_company) > 0){
    
    
    $company="UPDATE company_info SET company_name='{$company_name}',trade='{$trade}',miscellaneous='{$miscellaneous}' WHERE emp_id = {$id}";
    mysqli_query($con, $company);
    
}else{
    $company=mysqli_query($con,"insert into company_info (emp_id,company_name,trade,miscellaneous) values ('{$id}','{$company_name}','{$trade}','{$miscellaneous}')");
}



if(mysqli_query($con, $sql)){
    
     // ✅ Log changes only after successful update
    $db->logChanges('new_case_details', $id, $oldData, $newData, $userid);


  echo 1;
}else{
  echo 0;
}

?>
