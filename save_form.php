<?php

include('database/db_connection.php');
include('session.php');
include('attendance_system/database.php');

    $db = new Database();

    if (isset($_POST['new_case_entry'])) {
        
       
        $name = mysqli_real_escape_string($con, strtoupper($_POST['name']));
        $fname = mysqli_real_escape_string($con, strtoupper($_POST['fname']));
        $pp_no = mysqli_real_escape_string($con, strtoupper($_POST['pp_no']));
        $pp_expiry = mysqli_real_escape_string($con, strtoupper($_POST['pp_expiry']));
        $tracking_id = mysqli_real_escape_string($con, strtoupper($_POST['tracking_id']));
        $new_case_date = mysqli_real_escape_string($con, strtoupper($_POST['new_case_date']));
        $date_of_birth = mysqli_real_escape_string($con, strtoupper($_POST['date_of_birth']));
        $client_age = mysqli_real_escape_string($con, strtoupper($_POST['client_age']));
        $care_of = mysqli_real_escape_string($con, strtoupper($_POST['care_of']));
        $trade = mysqli_real_escape_string($con, strtoupper($_POST['trade']));
        $mobile_no_1 = mysqli_real_escape_string($con, strtoupper($_POST['mobile_no_1']));
        $mobile_no_2 = mysqli_real_escape_string($con, strtoupper($_POST['mobile_no_2']));
        $missing_documents = mysqli_real_escape_string($con, strtoupper($_POST['missing_documents']));
        $country = mysqli_real_escape_string($con, strtoupper($_POST['country']));
        $first_character_expiry = mysqli_real_escape_string($con, strtoupper($_POST['first_character_expiry']));
        
        if(!empty($_POST['missing'])){
            $docs_missing = "YES";

        }else{

            $docs_missing = "NO";

        }
        
        $status = 'Ready To Apply';
        $entry_date = date('Y-m-d');

        $entered_by = $firstname . ' ' . $lastname;

        // Check if user details already exist
        $check_sql = "SELECT name, fname, pp_no FROM new_case_details WHERE name='$name' AND fname='$fname' AND pp_no='$pp_no'";
        
        $check_result = mysqli_query($con, $check_sql);

        if (mysqli_num_rows($check_result) > 0) {
            // If user details exist, show a message and stop the script
            echo '<script type="text/javascript">';
            echo 'alert("User Details Already Exists");';
            echo 'window.location.href = "add_new_case.php";';
            echo '</script>';
        } else {
            // If user details do not exist, proceed with the insert
            $sql = mysqli_query($con, "INSERT INTO new_case_details (name, fname, pp_no, pp_expiry, tracking_id, new_case_date, date_of_birth, client_age, care_of,trade, mobile_no_1,mobile_no_2, missing_documents,country,first_character_expiry, entered_by,entry_date,docs_missing, status)
            VALUES ('$name', '$fname', '$pp_no', '$pp_expiry', '$tracking_id', '$new_case_date', '$date_of_birth', '$client_age', '$care_of','$trade', '$mobile_no_1','$mobile_no_2', '$missing_documents','$country','$first_character_expiry', '$entered_by','$entry_date','$docs_missing', '$status')");


            if ($sql == true) {
                // Use JavaScript for alert and then redirection
                
                 $check_sql = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM new_case_details WHERE name='$name' AND fname='$fname' AND pp_no='$pp_no'"));
                    
                    $record_id=$check_sql['id'];
                
                echo '<script type="text/javascript">';
                echo 'alert("Data Submitted Successfully");';
                if ($manage_accounts === 'on') {
                    echo 'window.location.href = "add_payment.php?id=' . $record_id . '";';
                } else {
                    echo 'window.location.href = "add_new_case.php";';
                }
                echo '</script>';
            } else {
                echo 'Data Not Submitted';
            }

        }
    }

    if(isset($_POST['add_fsa_info'])){
        
                //employer info
                $emp_id=$_POST['employee_id'];
                $employer_name=strtoupper($_POST['employer_name']);
                $employer_address=strtoupper($_POST['employer_address']);
                $employer_city=strtoupper($_POST['employer_city']);
                $employer_country=strtoupper($_POST['employer_country']);
                $employer_telephone=strtoupper($_POST['employer_telephone']);
                $employer_fax_no=strtoupper($_POST['employer_fax_no']);
                $employer_email=strtoupper($_POST['employer_email']);


                $employer_info=mysqli_query($con,"insert into employer_info 
                
                (emp_id,employer_name,address,city,country,telephone,fax_no,email) 

                values 

                ('$emp_id','$employer_name','$employer_address','$employer_city','$employer_country','$employer_telephone','$employer_fax_no','$employer_email') 

                ");


                //employee personal info

                $employee_name=strtoupper($_POST['employee_name']);
                $employee_cnic=strtoupper($_POST['employee_cnic']);
                $employee_father_name=strtoupper($_POST['employee_father_name']);
                $employee_mother_name=strtoupper($_POST['employee_mother_name']);
                $employee_father_cnic=strtoupper($_POST['employee_father_cnic']);
                $employee_address=strtoupper($_POST['employee_address']);
                $employee_passport_no=strtoupper($_POST['employee_passport_no']);
                $employee_passport_issue_date=strtoupper($_POST['employee_passport_issue_date']);
                $employee_passport_expiry_date=strtoupper($_POST['employee_passport_expiry_date']);
                $employee_passport_issue_place=strtoupper($_POST['employee_passport_issue_place']);
                $employee_date_of_birth=strtoupper($_POST['employee_date_of_birth']);
                $employee_place_of_birth=strtoupper($_POST['employee_place_of_birth']);
                $employee_domicile=strtoupper($_POST['employee_domicile']);
                $employee_province=strtoupper($_POST['employee_province']);
                $employee_martial_status=strtoupper($_POST['employee_martial_status']);
                $employee_gender=strtoupper($_POST['employee_gender']);
                $employee_education=strtoupper($_POST['employee_education']);
                $experience=strtoupper($_POST['experience']);


                $employer_personal_info=mysqli_query($con,"insert into employee_personal_info 
                
                (emp_id,name,employee_cnic,employee_father_name,mother_name,father_cnic,address,passport_no,date_of_issue,date_of_expiry,place_of_issue,date_of_birth,place_of_birth,district_domicile,province,martial_status,gender,education,experience) 

                values 

                ('$emp_id','$employee_name','$employee_cnic','$employee_father_name','$employee_mother_name','$employee_father_cnic','$employee_address','$employee_passport_no','$employee_passport_issue_date','$employee_passport_expiry_date','$employee_passport_issue_place',
                '$employee_date_of_birth','$employee_place_of_birth','$employee_domicile','$employee_province','$employee_martial_status','$employee_gender','$employee_education','$experience') 

                ");


                //next of kin

                $employee_next_kin=strtoupper($_POST['employee_next_kin']);
                $employee_next_kin_age=strtoupper($_POST['employee_next_kin_age']);
                $employee_next_kin_cnic=strtoupper($_POST['employee_next_kin_cnic']);
                $employee_next_kin_relation=strtoupper($_POST['employee_next_kin_relation']);
                $employee_next_kin_address=strtoupper($_POST['employee_next_kin_address']);
            

                $kin_info=mysqli_query($con,"insert into next_of_kin 
                
                (emp_id,next_of_kin_name,age,cnic,relation,address) 

                values 

                ('$emp_id','$employee_next_kin','$employee_next_kin_age','$employee_next_kin_cnic','$employee_next_kin_relation','$employee_next_kin_address') 

                ");



                $job_title=strtoupper($_POST['job_title']);
                $monthly_salary=strtoupper($_POST['monthly_salary']);
                $rate=strtoupper($_POST['rate']);
                $period_of_contract=strtoupper($_POST['period_of_contract']);
                $free_acco=strtoupper($_POST['free_acco']);
                $free_food=strtoupper($_POST['free_food']);

                $contract=mysqli_query($con,"insert into contract_conditions 
                
                (emp_id,job_title,monthly_salary,rate,period_of_contract,free_acco,free_food) 

                values 

                ('$emp_id','$job_title','$monthly_salary','$rate','$period_of_contract','$free_acco','$free_food') 

                ");

                if($employer_personal_info==true){
                    header("location:print_fsa.php");
                }else{
                    echo "Error : Info Not Save";
                }
    }
    if(isset($_POST['Update'])){
        $emp_id=$_POST['emp_id'];

    
        //employer info

        $employer_name=strtoupper($_POST['employer_name']);
        $employer_address=strtoupper($_POST['employer_address']);
        $employer_city=strtoupper($_POST['employer_city']);
        $employer_country=strtoupper($_POST['employer_country']);
        $employer_telephone=strtoupper($_POST['employer_telephone']);
        $employer_fax_no=strtoupper($_POST['employer_fax_no']);
        $employer_email=strtoupper($_POST['employer_email']);

        
        $employer_info=mysqli_query($con,

        "
        Update employer_info set emp_id='$emp_id',employer_name='$employer_name',address='$employer_address',
        
        city='$employer_city',country='$employer_country',telephone='$employer_telephone',fax_no='$employer_fax_no',email='$employer_email' where emp_id='$emp_id'
        
        
        "  

        );

        
        //employee personal info

        $employee_name=strtoupper($_POST['employee_name']);
        $employee_cnic=strtoupper($_POST['employee_cnic']);
        $employee_father_name=strtoupper($_POST['employee_father_name']);
        $employee_mother_name=strtoupper($_POST['employee_mother_name']);
        $employee_father_cnic=strtoupper($_POST['employee_father_cnic']);
        $employee_address=strtoupper($_POST['employee_address']);
        $employee_passport_no=strtoupper($_POST['employee_passport_no']);
        $employee_passport_issue_date=strtoupper($_POST['employee_passport_issue_date']);
        $employee_passport_expiry_date=strtoupper($_POST['employee_passport_expiry_date']);
        $employee_passport_issue_place=strtoupper($_POST['employee_passport_issue_place']);
        $employee_date_of_birth=strtoupper($_POST['employee_date_of_birth']);
        $employee_place_of_birth=strtoupper($_POST['employee_place_of_birth']);
        $employee_domicile=strtoupper($_POST['employee_domicile']);
        $employee_province=strtoupper($_POST['employee_province']);
        $employee_martial_status=strtoupper($_POST['employee_martial_status']);
        $employee_gender=strtoupper($_POST['employee_gender']);
        $employee_education=strtoupper($_POST['employee_education']);
        $experience=strtoupper($_POST['experience']);


    $employer_personal_info=mysqli_query($con,"
        
        Update employee_personal_info set emp_id='$emp_id',name='$employee_name',employee_cnic='$employee_cnic',employee_father_name='$employee_father_name',mother_name='$employee_mother_name',father_cnic='$employee_father_cnic',
        address='$employee_address',passport_no='$employee_passport_no',date_of_issue='$employee_passport_issue_date',date_of_expiry='$employee_passport_expiry_date',place_of_issue='$employee_passport_issue_place',
        date_of_birth='$employee_date_of_birth',place_of_birth='$employee_place_of_birth',district_domicile='$employee_domicile',province='$employee_province',
        martial_status='$employee_martial_status',gender='$employee_gender',education='$employee_education',experience='$experience' where emp_id='$emp_id'

        ");

    
        //next of kin

        $employee_next_kin=strtoupper($_POST['employee_next_kin']);
        $employee_next_kin_age=strtoupper($_POST['employee_next_kin_age']);
        $employee_next_kin_cnic=strtoupper($_POST['employee_next_kin_cnic']);
        $employee_next_kin_relation=strtoupper($_POST['employee_next_kin_relation']);
        $employee_next_kin_address=strtoupper($_POST['employee_next_kin_address']);
    
        $kin_info=mysqli_query($con,"

        Update next_of_kin set emp_id='$emp_id',next_of_kin_name='$employee_next_kin',age='$employee_next_kin_age',cnic='$employee_next_kin_cnic',relation='$employee_next_kin_relation',address='$employee_next_kin_address' where emp_id='$emp_id'

        ");

    
        $job_title=strtoupper($_POST['job_title']);
        $monthly_salary=strtoupper($_POST['monthly_salary']);
        $rate=strtoupper($_POST['rate']);
        $period_of_contract=strtoupper($_POST['period_of_contract']);
        $free_acco=strtoupper($_POST['free_acco']);
        $free_food=strtoupper($_POST['free_food']);


        $contract=mysqli_query($con,"
        
        Update contract_conditions set emp_id='$emp_id',job_title='$job_title',monthly_salary='$monthly_salary',

        rate='$rate',period_of_contract='$period_of_contract',free_acco='$free_acco',free_food='$free_food' where emp_id='$emp_id'

        ");


        if($employer_personal_info==true){
            header("location:print_fsa.php");
            
        }
    }
    

    if(isset($_POST['add_payment_details'])){

         $emp_ID=$_POST['emp_id'];

         $currency=$_POST['currency'];
         $agreed_amount=$_POST['agreed_amount'];
        
        if(!empty($_POST['first_payment'])){
        
            $first_payment=$_POST['first_payment'];
            
        }else{
            $first_payment = null;
        }
        
         $first_payment_date=$_POST['first_payment_date'];
        
         $first_payment_method=$_POST['first_payment_method'];
        
        if($_POST['first_checque_number']){
            
              $first_receive_by=$_POST['first_checque_number'];
        
        }elseif($_POST['first_bank_name']){
            
             $first_receive_by=$_POST['first_bank_name'];
            
        }else{
            
             $first_receive_by=$_POST['first_cash_received_by'];
        }
        
        
         $first_payment_description=$_POST['first_payment_description'];
       
       
       $payment_status=$_POST['payment_status'];

      
        
       $payment=mysqli_query($con,"insert into payments (emp_id,currency,agreed_amount,first_payment,first_payment_date,first_payment_method,first_payment_description,first_receive_by,payment_status) 
       values ('$emp_ID','$currency','$agreed_amount','$first_payment','$first_payment_date','$first_payment_method','$first_payment_description','$first_receive_by','$payment_status')
        ");


        if($payment==true){
            echo '<script>alert("Payment Info Saved Successfully");</script>'; // Display your message
            echo '<script>
                     setTimeout(function() {
                        window.location.href = "clients_list.php";
                     }, 1000); // Redirect after 1 seconds
                  </script>';
             
         }else{
            echo '<script>alert("Error : Payment Info Not Saved");</script>';
   
         }


        
    }

    if (isset($_POST['update_payment_detail'])) {

        $emp_ID = $_POST['emp_id'];
        $user_id = $userid; // logged-in user
        
        // Fetch old data
        // $oldData = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM payments WHERE emp_id='$emp_ID'"));
    
        // ✅ Fetch old record before update
        $oldData = $db->getOldData('payments', 'emp_id', $emp_ID);

        // Prepare all updated values
        $agreed_amount = $_POST['agreed_amount'];
        $first_payment = $_POST['first_payment'];
        $first_payment_date = $_POST['first_payment_date'];
        $second_payment = $_POST['second_payment'];
        $second_payment_date = $_POST['second_payment_date'];
        $final_payment = $_POST['final_payment'];
        $final_payment_date = $_POST['final_payment_date'];
        $payment_status = $_POST['payment_status'];
    
        $check_payments = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM payments WHERE emp_id='$emp_ID'"));
    
        // --- First Payment Receiver ---
        $first_payment_method = $_POST['first_payment_method'];
        if (!empty($_POST['first_checque_number'])) {
            $first_receive_by = $_POST['first_checque_number'];
        } elseif (!empty($_POST['first_bank_name'])) {
            $first_receive_by = $_POST['first_bank_name'];
        } elseif (!empty($_POST['first_cash_received_by'])) {
            $first_receive_by = $_POST['first_cash_received_by'];
        } else {
            $first_receive_by = $check_payments['first_receive_by'];
        }
    
        // --- Second Payment Receiver ---
        $second_payment_method = $_POST['second_payment_method'];
        if (!empty($_POST['second_checque_number'])) {
            $second_receive_by = $_POST['second_checque_number'];
        } elseif (!empty($_POST['second_bank_name'])) {
            $second_receive_by = $_POST['second_bank_name'];
        } elseif (!empty($_POST['second_cash_received_by'])) {
            $second_receive_by = $_POST['second_cash_received_by'];
        } else {
            $second_receive_by = $check_payments['second_receive_by'];
        }
    
        // --- Final Payment Receiver ---
        $final_payment_method = $_POST['final_payment_method'];
        if (!empty($_POST['final_checque_number'])) {
            $final_receive_by = $_POST['final_checque_number'];
        } elseif (!empty($_POST['final_bank_name'])) {
            $final_receive_by = $_POST['final_bank_name'];
        } elseif (!empty($_POST['final_cash_received_by'])) {
            $final_receive_by = $_POST['final_cash_received_by'];
        } else {
            $final_receive_by = $check_payments['final_receive_by'];
        }
    
        // Descriptions
        $first_payment_description = $_POST['first_payment_description'];
        $second_payment_description = $_POST['second_payment_description'];
        $final_payment_description = $_POST['final_payment_description'];
    
        // Prepare new data array for logging
        $newData = [
            'agreed_amount' => $agreed_amount,
            'first_payment' => $first_payment,
            'first_payment_date' => $first_payment_date,
            'first_payment_method' => $first_payment_method,
            'first_receive_by' => $first_receive_by,
            'first_payment_description' => $first_payment_description,
            'second_payment' => $second_payment,
            'second_payment_date' => $second_payment_date,
            'second_payment_method' => $second_payment_method,
            'second_receive_by' => $second_receive_by,
            'second_payment_description' => $second_payment_description,
            'final_payment' => $final_payment,
            'final_payment_date' => $final_payment_date,
            'final_payment_method' => $final_payment_method,
            'final_receive_by' => $final_receive_by,
            'final_payment_description' => $final_payment_description,
            'payment_status' => $payment_status
        ];


    
        // Update query
        $update_payment_details = mysqli_query($con, "
            UPDATE payments SET 
                agreed_amount='$agreed_amount',
                first_payment='$first_payment',
                first_payment_date='$first_payment_date',
                first_payment_method='$first_payment_method',
                first_receive_by='$first_receive_by',
                first_payment_description='$first_payment_description',
                second_payment='$second_payment',
                second_payment_date='$second_payment_date',
                second_payment_method='$second_payment_method',
                second_receive_by='$second_receive_by',
                second_payment_description='$second_payment_description',
                final_payment='$final_payment',
                final_payment_date='$final_payment_date',
                final_payment_method='$final_payment_method',
                final_receive_by='$final_receive_by',
                final_payment_description='$final_payment_description',
                payment_status='$payment_status'
            WHERE emp_id='$emp_ID'
        ");
    
        if ($update_payment_details) {
            // Log changed fields to audit_log
            $db->logChanges('payments', $emp_ID, $oldData, $newData, $user_id);
    
            echo '<script>alert("Payment Info Updated Successfully");</script>';
            echo '<script>
                    setTimeout(function() {
                        window.location.href = "clients_list.php";
                    }, 1000);
                  </script>';
        } else {
            echo '<script>alert("Error: Payment Info Not Updated");</script>';
        }
    }

    if(isset($_POST['payment_handed_over_to'])){
        
        $today_cash=$_POST['today_cash_received'];
        $handed_over_to=$_POST['handed_over_to'];

        $given_by = $firstname . ' ' . $lastname;

        $given_date=date('Y-m-d');



        $handed_over_to=mysqli_query($con,"insert into payment_handed_over_to(payment,payment_handed_over_to,given_by,given_date) 
        values 
        ('$today_cash','$handed_over_to','$given_by','$given_date')");

        if($handed_over_to==true){
            echo '<script>alert("Payment Info Added Successfully");</script>'; // Display your message
            echo '<script>
                     setTimeout(function() {
                        window.location.href = "account_analysis.php";
                     }, 1000); // Redirect after 1 seconds
                  </script>';
        }else{

            echo '<script>alert("Error : Payment Info Not Added");</script>';
        }
        

    }
    
    if(isset($_POST['add_miscellaneous_payment'])){
        $payment_purpose=$_POST['payment_purpose'];
        $payment_given_by=$_POST['payment_given_by'];
        $amount=$_POST['amount'];
        $payment_date=$_POST['payment_date'];
        $care_of=$_POST['care_of'];
        $miscellaneous_payment_method=$_POST['miscellaneous_payment_method'];
        $checque_number=$_POST['checque_number'];
        $bank_name=$_POST['bank_name'];
        $cash_received_by=$_POST['cash_received_by'];
        
         $miscellaneous_payment_method=mysqli_query($con,"insert into miscellaneous_payment(payment_purpose,payment_given_by,amount,payment_date,care_of,miscellaneous_payment_method,checque_number,bank_name,cash_received_by) 
        values 
        ('$payment_purpose','$payment_given_by','$amount','$payment_date','$care_of','$miscellaneous_payment_method','$checque_number','$bank_name','$cash_received_by')");

        if($miscellaneous_payment_method==true){
            echo '<script>alert("Miscellaneous Payment Info Added Successfully");</script>'; // Display your message
            echo '<script>
                     setTimeout(function() {
                        window.location.href = "account_analysis.php";
                     }, 1000); // Redirect after 1 seconds
                  </script>';
        }else{

            echo '<script>alert("Error : Payment Info Not Added");</script>';
        }
    }
    
    if(isset($_POST['deduction_payment_detail'])){
        $emp_ID=$_POST['emp_id'];

        $agreed_amount=$_POST['agreed_amount'];
        $first_payment=$_POST['first_payment'];
        $first_payment_date=$_POST['first_payment_date'];
        $second_payment=$_POST['second_payment'];
        $second_payment_date=$_POST['second_payment_date'];
        $refund_remarks=$_POST['refund_remarks'];
        
        $check_payments=mysqli_fetch_assoc(mysqli_query($con,"select * from payments where emp_id='$emp_ID'"));

        $first_payment_method=$_POST['first_payment_method'];
        
        if(!empty($_POST['first_checque_number'])){
            
            $first_receive_by=$_POST['first_checque_number'];
        
        }elseif(!empty($_POST['first_bank_name'])){
            
             $first_receive_by=$_POST['first_bank_name'];
            
        }elseif(!empty($_POST['first_cash_received_by'])){
            
            $first_receive_by=$_POST['first_cash_received_by'];
        }else{
             $first_receive_by=$check_payments['first_receive_by'];
        }
        
        
         $second_payment_method=$_POST['second_payment_method'];
        
        if($_POST['second_checque_number']){
            
             $second_receive_by=$_POST['second_checque_number'];
        
        }elseif($_POST['second_bank_name']){
            
           $second_receive_by=$_POST['second_bank_name'];
            
        }elseif($_POST['second_cash_received_by']){

             $second_receive_by=$_POST['second_cash_received_by'];
            
        }else{
             $second_receive_by=$check_payments['second_receive_by'];
        }
        
        
        
        $update_payment_details=mysqli_query($con,"update payments 
        set 
        agreed_amount='$agreed_amount',first_payment='$first_payment',first_payment_date='$first_payment_date',first_payment_method='$first_payment_method',first_receive_by='$first_receive_by',second_payment='$second_payment',second_payment_date='$second_payment_date',
        second_payment_method='$second_payment_method',second_receive_by='$second_receive_by',refund_on_return='$refund_remarks' where emp_id='$emp_ID'");

        if($update_payment_details==true){
            echo '<script>alert("Payment Info Updated Successfully");</script>'; // Display your message
            echo '<script>
                     setTimeout(function() {
                        window.location.href = "clients_list.php";
                     }, 1000); // Redirect after 1 seconds
                  </script>';
             
         }else{
            echo '<script>alert("Error : Payment Info Not Updated");</script>';
   
         }

        
    }

?>
