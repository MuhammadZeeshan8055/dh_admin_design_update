<?php
    include('database/db_connection.php');
    include('session.php');
    
    
    if(isset($_GET['status'])){
       $status=$_GET['status'];
    }
    
    if(isset($_POST['status'])){

         $id = $_POST['getid'];
         $status_update = $_POST['status'];

        if($status_update=='Applied'){
            $payment_check=mysqli_query($con,"select first_payment from payments where first_payment > 0 and emp_id='$id'");
            
            $check_company_assigned = mysqli_query($con, "SELECT * FROM company_info WHERE emp_id='$id' AND company_name != 'Select Company' AND company_name != '' ");
    
            $check_old_status=mysqli_fetch_assoc(mysqli_query($con,"select status, status_updated_at from new_case_details where id='{$id}'"));
            
            $status_changed_by = $firstname . ' ' . $lastname;
            
            if($status_update==$check_old_status['status']){
                $status_updated_at = $check_old_status['status_updated_at'];
            }else{
                 $status_updated_at=todayDate();
            }
            
        if (mysqli_num_rows($payment_check) > 0 && mysqli_num_rows($check_company_assigned) > 0) {
    
            // Both payment and company are valid
            $update_status = mysqli_query($con, "UPDATE new_case_details 
                SET status = '$status_update', 
                    status_changed_by = '$status_changed_by', 
                    status_updated_at = '$status_updated_at' 
                WHERE id = '$id'");
        
            if ($update_status === true) {
                header("Location: status_wise_data.php?status=$status");
                exit;
            } else {
                echo '<script>alert("Status Not Updated");</script>';
            }
        
        } else {
            // One or both conditions failed
            if (mysqli_num_rows($payment_check) == 0) {
                echo '<script>alert("Advance payment is required before applying this status. Please add the payment to proceed.");</script>';
            }
        
            if (mysqli_num_rows($check_company_assigned) == 0) {
                echo '<script>alert("Company not assigned. Please assign a company to proceed.");</script>';
            }
        
            // Redirect after showing alerts
            echo '<script>
                setTimeout(function() {
                    window.location.href = "status_wise_data.php?status=' . $status . '";
                }, 2000);
            </script>';
        }

      }elseif($status_update=='Fly'){
          $payment_check = mysqli_query($con, "
                SELECT first_payment, second_payment, final_payment 
                FROM payments 
                WHERE first_payment > 0 
                  AND second_payment > 0 
                  AND final_payment > 0 
                  AND emp_id = '$id'
            ");
            
            $check_old_status=mysqli_fetch_assoc(mysqli_query($con,"select status, status_updated_at from new_case_details where id='{$id}'"));
            
            $status_changed_by = $firstname . ' ' . $lastname;
            
            if($status_update==$check_old_status['status']){
                $status_updated_at = $check_old_status['status_updated_at'];
            }else{
                 $status_updated_at=todayDate();
            }
            
        if (mysqli_num_rows($payment_check) > 0) {
    
            // Both payment and company are valid
            $update_status = mysqli_query($con, "UPDATE new_case_details 
                SET status = '$status_update', 
                    status_changed_by = '$status_changed_by', 
                    status_updated_at = '$status_updated_at' 
                WHERE id = '$id'");
        
            if ($update_status === true) {
                header("Location: status_wise_data.php?status=$status");
                exit;
            } else {
                echo '<script>alert("Status Not Updated");</script>';
            }
        
        } else {
            // One or both conditions failed
            if (mysqli_num_rows($payment_check) == 0) {
                echo '<script>alert("Clients payment is required before applying this status. Please add the payment to proceed.");</script>';
            }
        
            // Redirect after showing alerts
            echo '<script>
                setTimeout(function() {
                    window.location.href = "status_wise_data.php?status=' . $status . '";
                }, 2000);
            </script>';
        }
      }elseif($status_update=='Returned'){
          
            $date = todayDate(); // Calls the function and gets the current date
            
            $check_old_status=mysqli_fetch_assoc(mysqli_query($con,"select status, status_updated_at from new_case_details where id='{$id}'"));
                
            $status_update = $_POST['status'];
            
            $status_changed_by = $firstname . ' ' . $lastname;
                
                if($status_update==$check_old_status['status']){
                    $status_updated_at = $check_old_status['status_updated_at'];
                }else{
                     $status_updated_at=todayDate();
                }

            $update_status = mysqli_query($con, 
                "UPDATE new_case_details 
                 SET status = '$status_update', passport_returned_date = '$date',status_changed_by='$status_changed_by',status_updated_at='$status_updated_at' 
                 WHERE id = '$id'"
            );

             if($update_status==true){
                header("location:status_wise_data.php?status=$status");
             }else{
                echo '<script>alert("Status Not Updated");</script>';
             }  
      }elseif($status_update=='Work Permit Issued'){
          
            $check_work_permit_issue_date=mysqli_query($con,"SELECT work_permit_receiving_date 
                FROM new_case_details 
                WHERE id = '$id' 
                  AND work_permit_receiving_date != '' 
                  AND work_permit_receiving_date IS NOT NULL;
            ");

    
            $check_old_status=mysqli_fetch_assoc(mysqli_query($con,"select status, status_updated_at from new_case_details where id='{$id}'"));
            
            $status_changed_by = $firstname . ' ' . $lastname;
            
            if($status_update==$check_old_status['status']){
                $status_updated_at = $check_old_status['status_updated_at'];
            }else{
                 $status_updated_at=todayDate();
            }
            
            if (mysqli_num_rows($check_work_permit_issue_date) > 0 ) {
        
                // if the work permit receiving date mentioned
                $update_status = mysqli_query($con, "UPDATE new_case_details 
                    SET status = '$status_update', 
                        status_changed_by = '$status_changed_by', 
                        status_updated_at = '$status_updated_at' 
                    WHERE id = '$id'");
            
                if ($update_status === true) {
                    header("Location: status_wise_data.php?status=$status");
                    exit;
                } else {
                    echo '<script>alert("Status Not Updated");</script>';
                }
        
        } else {
           
            echo '<script>alert("Work Permit Receiving date not mentioned. Enter a work permit receiving date to proceed.");</script>';
        
            // Redirect after showing alerts
            echo '<script>
                setTimeout(function() {
                    window.location.href = "status_wise_data.php?status=' . $status . '";
                }, 2000);
            </script>';
        }
      }else{
          
         
            $status_update = $_POST['status'];
          
            $check_old_status=mysqli_fetch_assoc(mysqli_query($con,"select status, status_updated_at from new_case_details where id='{$id}'"));
            
            $status_changed_by = $firstname . ' ' . $lastname;
            
            if($status_update==$check_old_status['status']){
                $status_updated_at = $check_old_status['status_updated_at'];
            }else{
                 $status_updated_at=todayDate();
            }
            
             $update_status=mysqli_query($con,"update new_case_details set status='$status_update',status_changed_by='$status_changed_by',status_updated_at='$status_updated_at' where id='$id'");
    
             if($update_status==true){
                header("location:status_wise_data.php?status=$status");
             }else{
                echo '<script>alert("Status Not Updated");</script>';
             }
      }

        

    }

    if(isset($_POST['assign_company'])){

      $emp_ID=$_POST['employee_id'];

      if(!empty($_POST['company_name'])){
         $company_name=$_POST['company_name'];

         if(!empty($_POST['trade'])){

            $trade=$_POST['trade'];
         }else{
   
            $trade='';
   
         }
   
         if(!empty($_POST['e_no'])){
            
            $e_no=$_POST['e_no'];
         }else{
   
            $e_no='';
   
         }
   
         if(!empty($_POST['visa_no'])){
            
            $visa_no=$_POST['visa_no'];
   
         }else{
   
            $visa_no='';
   
   
         }
   
         if(!empty($_POST['sponsor_id'])){
            
            $sponsor_id=$_POST['sponsor_id'];
   
         }else{
   
            $sponsor_id='';
   
   
         }
   
         if(!empty($_POST['miscellaneous'])){
            
            $miscellaneous=$_POST['miscellaneous'];
   
         }else{
   
            $miscellaneous='';
   
   
         }
   
         $assign_company=mysqli_query($con,"insert into company_info (emp_id,company_name,trade,e_no,visa_no,sponsor_id,miscellaneous) 
         VALUES 
         ('$emp_ID','$company_name','$trade','$e_no','$visa_no','$sponsor_id','$miscellaneous')");
   
         if($assign_company==true){
            echo '<script>alert("Company Assigned Successfully");</script>'; // Display your message
            echo '<script>
                     setTimeout(function() {
                        window.location.href = "status_wise_data.php?status=' . $status . '";
                     }, 2000); // Redirect after 2 seconds
                  </script>';
             
         }else{
            echo '<script>alert("Company Not Assigned");</script>';
   
         }

      }else{
         echo '<script>alert("Company Name Should not be empty");</script>'; // Display your message
         echo '<script>
                  setTimeout(function() {
                     window.location.href = "status_wise_data.php?status=' . $status . '";
                  }, 2000); // Redirect after 2 seconds
               </script>';
            
      }

     
   }


   if(isset($_POST['update_assign_company'])){
      $emp_ID=$_POST['employee_id'];

      $company_name=$_POST['company_name'];

      if(!empty($_POST['trade'])){

         $trade=$_POST['trade'];
      }else{

         $trade='';

      }

      if(!empty($_POST['e_no'])){
         
         $e_no=$_POST['e_no'];
      }else{

         $e_no='';

      }

      if(!empty($_POST['visa_no'])){
         
         $visa_no=$_POST['visa_no'];

      }else{

         $visa_no='';


      }

      if(!empty($_POST['sponsor_id'])){
         
         $sponsor_id=$_POST['sponsor_id'];

      }else{

         $sponsor_id='';


      }

      if(!empty($_POST['miscellaneous'])){
         
         $miscellaneous=$_POST['miscellaneous'];

      }else{

         $miscellaneous='';


      }

      $update_assign_company=mysqli_query($con,"update company_info set company_name='$company_name',trade='$trade',
      e_no='$e_no',visa_no='$visa_no',sponsor_id='$sponsor_id',miscellaneous='$miscellaneous' where emp_id='$emp_ID'
      ");

      if($update_assign_company==true){
         echo '<script>alert("Company Info Updated Successfully");</script>'; // Display your message
         echo '<script>
                  setTimeout(function() {
                     window.location.href = "status_wise_data.php?status=' . $status . '";
                  }, 2000); // Redirect after 2 seconds
               </script>';
          
      }else{
         echo '<script>alert("Company info Not Updated");</script>';

      }

   }
   
   if(isset($_POST['update_flight_detail'])){
       
        $emp_ID=$_POST['employee_id'];
        $date_departure=$_POST['date_of_dep'];
        $airport_name=$_POST['airport_name'];
        $airline=$_POST['airline'];
        $route=$_POST['route'];
        
        $flight_details=mysqli_query($con,"insert into flight_details (emp_id,date_of_dep,airport_name,airline,from_to) 
         VALUES 
         ('$emp_ID','$date_departure','$airport_name','$airline','$route')");
         
        if($flight_details==true){
            echo '<script>alert("Flight Details Entered Successfully");</script>'; // Display your message
            echo '<script>
                     setTimeout(function() {
                        window.location.href = "status_wise_data.php?status=' . $status . '";
                     }, 2000); // Redirect after 2 seconds
                  </script>';
             
        }else{
            echo '<script>alert("Flight Details Not Entered");</script>';
   
        }
   }
    
?>
<!DOCTYPE html> 
<html lang="en">
   <!-- Added by HTTrack -->
   <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
   <!-- /Added by HTTrack -->
   <head>
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1" />
      <meta name="description" content="Dhothar International" />
      <meta name="author" content="Laborator.co" />
      <link rel="icon" href="assets/images/favicon.ico">
      
      <title>Dhothar International </title>
      <link rel="stylesheet" href="assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css" id="style-resource-1">
      <link rel="stylesheet" href="assets/css/font-icons/entypo/css/entypo.css" id="style-resource-2">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic" id="style-resource-3">
      <link rel="stylesheet" href="assets/css/bootstrap.css" id="style-resource-4">
      <link rel="stylesheet" href="assets/css/neon-core.css" id="style-resource-5">
      <link rel="stylesheet" href="assets/css/neon-theme.css" id="style-resource-6">
      <link rel="stylesheet" href="assets/css/neon-forms.css" id="style-resource-7">
      <link rel="stylesheet" href="assets/css/custom.css" id="style-resource-8">
      <script src="assets/js/jquery-1.11.3.min.js"></script> <!--[if lt IE 9]><script src="https://demo.neontheme.com/assets/js/ie8-responsive-file-warning.js"></script><![endif]-->  <!--[if lt IE 9]> <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script> <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script> <![endif]-->  
   </head>
   <body class="page-body">
      <div class="page-container">
         <div class="sidebar-menu">
            <?php include('components/sidebar.php'); ?>
         </div>
         <div class="main-content">
            <?php include('components/header.php'); ?>
            <hr/>
            <ol class="breadcrumb bc-3">
               <li> <a href="../../dashboard/main/index.html"><i class="fa-home"></i>Home</a> </li>
               <li> <a href="../main/index.html">Tables</a> </li>
               <li class="active"> <strong>Data Tables</strong> </li>
            </ol>
       
            
            
           
            <h3>Exporting Table Data</h3>
            <br/> <script type="text/javascript">
               jQuery(document).ready(function($) {
                    var $table4 = jQuery("#table-4");
                    
                    // Initialize DataTable with enhanced search features
                    var table = $table4.DataTable({
                        dom: 'Bfrtip',
                        buttons: [
                            'copyHtml5',
                            'excelHtml5', 
                            'csvHtml5',
                            'pdfHtml5'
                        ],
                        // Enable individual column searching
                        initComplete: function() {
                            // Add search inputs to each column header
                            this.api().columns().every(function() {
                                var column = this;
                                var title = column.header().textContent;
                                
                                // Create search input for each column
                                var input = document.createElement('input');
                                input.placeholder = 'Search ' + title;
                                input.className = 'form-control form-control-sm';
                                input.style.marginTop = '5px';
                                
                                $(input).appendTo($(column.header()))
                                    .on('keyup change clear', function() {
                                        if (column.search() !== this.value) {
                                            column.search(this.value).draw();
                                        }
                                    });
                            });
                        }
                    });
                    
                    // Alternative: Add a dedicated Company Name search
                    $('#company-search').on('keyup', function() {
                        // Search in the Company Name column (index 21 based on your table structure)
                        table.column(21).search(this.value).draw();
                    });
                    
                });
            </script> 
            <table class="table table-bordered datatable table-3" id="table-4">
                <!-- Add this BEFORE your <table> tag -->
                <div class="row mb-3">
                    <!--<div class="col-md-6">-->
                    <!--    <label for="company-search">Search by Company Name:</label>-->
                    <!--    <input type="text" id="company-search" class="form-control" placeholder="Enter company name...">-->
                    <!--</div>-->
                </div>
               <thead>
                  <tr>
                     <th>S.no</th>
                     <th>Name</th>
                     <th>Father Name</th>
                     <th>PP NO</th>
                     <th>PP Expiry</th>
                     <th>Tracking Id</th>
                     <th>New Case Date</th>
                     <th>Date of Birth</th>
                     <th>Age</th>
                     <th>Care Of</th>
                     <th>Mobile No 1</th>
                     <th>Mobile No 2</th>
                     <th>Missing Documents</th>
                     <th>Passport Return Description</th>
                     <th>Passport Return Date</th>
                     <th>Country</th>
                     <th>Apply Date</th>
                     <th>First Character Expiry</th>
                     <th>Second Character Expiry</th>
                     <th>Online Submission Date</th>
                     <th>Physical Submission Date</th>
                     <th>Work Permit Receiving Date</th>
                     <th>Appointment Date</th>
                     <th>Entered By</th>
                     <th>Approved By</th>
                     <th>Updated By</th>
                     <th>Company Name</th>
                     <th>Trade</th>
                     <th>Miscellaneous</th>
                     <th>Assign Company</th>
                     <?php
                        if($status == 'Visa Issued'){
                           echo '<th>Flight Details</th>';
                        }
                     ?>
                     <th>Status</th>
                     
                     <?php if ($can_update === 'on'): ?>
                     <th>Action</th>
                     <?php endif; ?>
                  </tr>
               </thead>
               <tbody>
                  <?php
                     $i=0;
                     
                        $country = $_SESSION['country']; // Store session variable to avoid repeated access
                        $query = ""; // Initialize query variable
                        
                        $dateCondition = "";
                        if (isset($_GET['date1'], $_GET['date2'])) {
                            $date1 = $_GET['date1'];
                            $date2 = $_GET['date2'];
                            $dateCondition = " AND status_updated_at BETWEEN '$date1' AND '$date2'";
                        }
                        
                        switch ($status) {
                            case "Yes":
                                $query = "SELECT * FROM new_case_details 
                                          WHERE docs_missing = '$status' 
                                          AND country = '$country' 
                                          AND status NOT IN ('Returned', 'Fly')"
                                          . $dateCondition;
                                break;
                            case "passport_returned":
                                 $query = "SELECT * FROM new_case_details 
                                           WHERE passport_returned = 'Yes' 
                                           AND country = '$country' 
                                           AND status NOT IN ('Returned', 'Fly') OR status IS NULL"
                                           . $dateCondition;
                                 break;
                        
                            case "Total Registered Cases":
                                $query = "SELECT * FROM new_case_details 
                                          WHERE country = '$country'" . $dateCondition;
                                break;
                        
                            case "Ready To Apply":
                                $query = "SELECT * FROM new_case_details 
                                          WHERE status = '$status' 
                                          AND docs_missing != 'Yes' 
                                          AND country = '$country'"
                                          . $dateCondition;
                                break;
                            
                            case "Applied":
                                $query = "SELECT * FROM new_case_details 
                                          WHERE status = '$status' 
                                          AND docs_missing != 'Yes' 
                                          AND country = '$country'"
                                          . $dateCondition;
                                break;
                                
                            case "Returned":
                                $query = "SELECT * FROM new_case_details 
                                          WHERE (status = '$status' or status='Request Returned')
                                          AND country = '$country'"
                                          . $dateCondition;
                                break;
                                
                            case "Work Permit Issued":
                                $query = "SELECT * FROM new_case_details 
                                          WHERE status IN ('Work Permit Issued', 'Appointment Applied') 
                                          AND country = '$country'"
                                          . $dateCondition;
                                break;
                                
                            case "Ready To Apply":
                                $query = "SELECT * FROM new_case_details 
                                          WHERE status = '$status' 
                                          AND docs_missing != 'Yes' 
                                          AND country = '$country'"
                                          . $dateCondition;
                                break;
                        
                            case "passport_expiry_under_year":
                                $query = "SELECT * FROM new_case_details 
                                          WHERE pp_expiry BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 YEAR)
                                          AND country = '$country' 
                                          AND status NOT IN ('Returned', 'Fly')"
                                          . $dateCondition;
                                break;
                        
                            case "character_expiry":
                                $query = "SELECT *
                                          FROM new_case_details
                                          WHERE 
                                            (
                                                (
                                                    second_character_expiry IS NOT NULL 
                                                    AND second_character_expiry != ''
                                                    AND second_character_expiry >= DATE_SUB(second_character_expiry, INTERVAL 180 DAY) 
                                                    AND second_character_expiry < NOW()
                                                )
                                                OR 
                                                (
                                                    (second_character_expiry IS NULL OR second_character_expiry = '') 
                                                    AND first_character_expiry IS NOT NULL 
                                                    AND first_character_expiry != ''
                                                    AND first_character_expiry >= DATE_SUB(first_character_expiry, INTERVAL 180 DAY) 
                                                    AND first_character_expiry < NOW()
                                                )
                                            )
                                            AND country = '$_SESSION[country]'
                                            AND status NOT IN ('Returned', 'Fly')"
                                          . $dateCondition;
                                break;
                        
                            case "passport_expired":
                                $query = "SELECT * FROM new_case_details 
                                          WHERE pp_expiry < CURDATE() 
                                          AND country = '$country' 
                                          AND status NOT IN ('Returned', 'Fly')"
                                          . $dateCondition;
                                break;
                        
                            default:
                                $query = "SELECT * FROM new_case_details 
                                          WHERE status = '$status' 
                                          AND (docs_missing = 'No' OR docs_missing = '')
                                          AND country = '$country'"
                                          . $dateCondition;
                                break;
                        }

                        
                        // Execute query
                        if (!empty($query)) {
                            $data = mysqli_query($con, $query);
                        }


                     while($row=mysqli_fetch_assoc($data)){
                        $i++;

                        $check_payment=mysqli_fetch_assoc(mysqli_query($con,"select * from payments where emp_id='$row[id]' and first_payment > 0 "));
                        
                        $check_company=mysqli_fetch_assoc(mysqli_query($con,"select * from company_info where emp_id='$row[id]'"));
                        
                        $flight_details=mysqli_fetch_assoc(mysqli_query($con,"select * from flight_details where emp_id='$row[id]'"));
                        
                        // $flight_details=mysqli_fetch_assoc(mysqli_query($con,"select * from flight_details where emp_id='$row[id]'"));
                  ?>
                  <tr style="color: <?= $check_payment ? 'inherit' : 'red'; ?>">
                     <td><?=$i;?></td>
                     <td><?=$row['name'];?></td>
                     <td><?=$row['fname'];?></td>
                     <td><?=$row['pp_no'];?></td>
                     <td><?=formatDate($row['pp_expiry']);?></td>
                     <td><?=$row['tracking_id'];?></td>
                     <td>
                        <?=formatDate($row['new_case_date']);?>
                     </td>
                     <td>
                        <?=formatDate($row['date_of_birth']);?>
                     </td>
                     <td>
                        <?=$row['client_age'];?>
                     </td>
                     <td><?=$row['care_of'];?></td>
                     <td><?=$row['mobile_no_1'];?></td>
                     <td><?=$row['mobile_no_2'];?></td>
                     <td><?=$row['missing_documents'];?></td>
                     <td><?=$row['passport_returned_description'];?></td>
                     <td><?=$row['passport_returned_date'];?></td>
                     <td><?=$row['country'];?></td>
                     <td>
                        <?=formatDate($row['apply_date']);?>
                     </td>
                     <td>
                        <?=formatDate($row['first_character_expiry']);?>
                     </td>
                        
                     <td>
                        <?=formatDate($row['second_character_expiry']);?>
                     </td>
                        
                     <td>
                        <?=formatDate($row['online_submission_date']);?>
                     </td>
                     <td>
                        <?=formatDate($row['physical_submission_date']);?>
                    </td>
                     
                     <td>
                        <?=formatDate($row['work_permit_receiving_date']);?>
                     </td>
                     <td>
                        <?=formatDate($row['appointment_date']);?>
                     </td>
                     <td><?=$row['entered_by'];?></td>
                     <td><?=$row['approved_by'];?></td>
                     <td><?=$row['updated_by'];?></td>
                     <td><?= (isset($check_company['company_name']) && $check_company['company_name'] !== 'Select Company') ? $check_company['company_name'] : ''; ?></td>

                     <td><?=$check_company['trade'] ?? '';?></td>
                     <td><?=$check_company['miscellaneous'] ?? '';?></td>
                     
                        <?php
                              if(!empty($check_company['company_name'])){
                        ?>

                             <td>                    
                                 <button type="button" class="btn btn-success" data-toggle="modal" data-target="#showModal<?=$row['id']?>">
                                    Show Company 
                                 </button>
                                 
                              </td>
                        <?php
                              }else{
                        ?>

                              <td>                    
                                 <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal<?=$row['id']?>">
                                    Assign Company 
                                 </button>
                              </td>
                        <?php
                              }
                        ?>
                        
                        <?php
                           if($status == 'Visa Issued'){
                              if(!empty($flight_details['date_of_dep'])){

                        ?>

                             <td>                    
                                 <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#flight_details<?=$row['id']?>">
                                    Show Flight Details 
                                 </button>
                                 
                              </td>
                        <?php
                              }else{
                        ?>

                              <td>                    
                                 <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#flight_details<?=$row['id']?>">
                                    Enter Flight Details 
                                 </button>
                              </td>
                        <?php
                              }

                           }
                        ?>
                     
                     
                     <td>
                         
                         
                        
                      <!-- Modal -->
                      <div class="modal fade" id="showModal<?=$row['id']?>" tabindex="-1" role="dialog" aria-labelledby="showModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                           <div class="modal-header">
                           <h2 class="modal-title" id="showModalLabel">Assign Company</h2>
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                           </button>
                           </div>
                          

                              <div class="modal-body">

                                 <?php
                                    if($_SESSION['country']=='Romania'){
                                 ?>
                                    <form action="" method="post">
                                       <div class="row">
                                          <form action="" method="post">
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label for="">Company Name</label>
                                                   <input type="hidden" name="employee_id" value="<?=$row['id'];?>" id="" class="form-control">

                                                   <!--<input type="text" name="company_name" value="<?=$check_company['company_name'];?>" id="" class="form-control">-->
                                                   <select name='company_name' id='company_name' class='form-control'>
                                                    
                                                    <?php
                                                        
                                                        if(!empty($check_company['company_name'])){
                                                        
                                                        ?>
                                                    
                                                            <option value="<?=$check_company['company_name'];?>"><?=$check_company['company_name'];?></option>
                                                    
                                                        <?php
                                                        }else{
                                                        ?>
                                                        
                                                            <option>Select Company</option>
                                                        
                                                        <?php
                                                        }
                                                    ?>
                                                   
                                                   <?php
                                                    $dynamic_company_list=mysqli_query($con,"select * from company_list");
                                                    
                                                    while($company_list=mysqli_fetch_assoc($dynamic_company_list)){
                                                        ?>
                                                        
                                                            <option value='<?=$company_list["company_name"]?>'><?=$company_list["company_name"]?></option>
                                                            
                                                        <?php
                                                    }
                                                    
                                                   ?>
                                                   </select>
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label for="">Trade</label>
                                                   <!--<input type="text" name="trade" value="<?=$check_company['trade'];?>" id="" class="form-control">-->
                                                   
                                                    <select name='trade' id='trade' class='form-control'>
                                                    
                                                    <?php
                                                        
                                                        if(!empty($check_company['trade'])){
                                                        
                                                        ?>
                                                    
                                                            <option value="<?=$check_company['trade'];?>"><?=$check_company['trade'];?></option>
                                                    
                                                        <?php
                                                        }else{
                                                        ?>
                                                        
                                                            <option>Select Company</option>
                                                        
                                                        <?php
                                                        }
                                                    ?>
                                                   
                                                   <?php
                                                    $dynamic_trade_list=mysqli_query($con,"select * from trade");
                                                    
                                                    while($trade_list=mysqli_fetch_assoc($dynamic_trade_list)){
                                                        ?>
                                                        
                                                            <option value='<?=$trade_list["trade"]?>'><?=$trade_list["trade"]?></option>
                                                            
                                                        <?php
                                                    }
                                                    
                                                   ?>
                                                   </select>
                                                   
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label for="">Miscellaneous</label>
                                                   
                                                   <input type="text" name="miscellaneous" value="<?=$check_company['miscellaneous'];?>" id="" class="form-control">
                                                </div>
                                             </div>

                                          
                                       </div>

                                       <button type="submit" name="update_assign_company" class="btn btn-primary">Update</button>

                                    </form>



                                 <?php
                                    }else{
                                 ?>

                                    <div class="row">
                                       <form action="" method="post">
                                          <div class="col-md-6">
                                             <div class="form-group">
                                                <label for="">Company Name</label>
                                                <input type="text" name="employee_id" value="<?=$row['id'];?>" id="" class="form-control">

                                                <!--<input type="text" name="company_name" value="<?=$check_company['company_name'];?>" id="" class="form-control">-->
                                                <select name='company_name' id='company_name' class='form-control'>
                                                    <?php
                                                        
                                                        if(!empty($check_company['company_name'])){
                                                        
                                                        ?>
                                                    
                                                            <option value="<?=$check_company['company_name'];?>"><?=$check_company['company_name'];?></option>
                                                    
                                                        <?php
                                                        }else{
                                                        ?>
                                                        
                                                            <option>Select Company</option>
                                                        
                                                        <?php
                                                        }
                                                    ?>
                                                   <?php
                                                    $dynamic_company_list=mysqli_query($con,"select * from company_list");
                                                    
                                                    while($company_list=mysqli_fetch_assoc($dynamic_company_list)){
                                                        ?>
                                                        
                                                            <option value='<?=$company_list["company_name"]?>'><?=$company_list["company_name"]?></option>
                                                            
                                                        <?php
                                                    }
                                                    
                                                   ?>
                                                </select>
                                             </div>
                                          </div>
                                          <div class="col-md-6">
                                             <div class="form-group">
                                                <label for="">Trade</label>
                                                <input type="text" name="trade" value="<?=$check_company['trade'];?>" id="" class="form-control">
                                             </div>
                                          </div>
                                          <div class="col-md-6">
                                             <div class="form-group">
                                                <label for="">E No</label>
                                                <input type="text" name="e_no" value="<?=$row['e_no'];?>" id="" class="form-control">
                                             </div>
                                          </div>
                                          <div class="col-md-6">
                                             <div class="form-group">
                                                <label for="">Visa No</label>
                                                <input type="text" name="visa_no" value="<?=$row['visa_no'];?>" id="" class="form-control">
                                             </div>
                                          </div>

                                          <div class="col-md-6">
                                             <div class="form-group">
                                                <label for="">Sponsor ID</label>
                                                <input type="text" name="sponsor_id" value="<?=$row['sponsor_id'];?>" id="" class="form-control">
                                             </div>
                                          </div>
                                          
                                          <div class="col-md-6">
                                             <div class="form-group">
                                                <label for="">Miscellaneous</label>
                                                
                                                <input type="text" name="miscellaneous" value="<?=$check_company['miscellaneous'];?>" id="" class="form-control">
                                             </div>
                                          </div>

                                          <button type="submit" name="assign_company" class="btn btn-primary">Save</button>

                                       </form>
                                    </div>

                                 <?php
                                    }
                                 ?>
                                 
                              </div>
                     
                           <div class="modal-footer">
                           <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                           
                           </div>
                        </div>
                     </div>
                     </div>
                     
                     
                     <!-- Flight Detail Modal -->
                      <div class="modal fade" id="flight_details<?=$row['id']?>" tabindex="-1" role="dialog" aria-labelledby="showModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                           <div class="modal-header">
                           <h2 class="modal-title" id="showModalLabel">Flight Details</h2>
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                           </button>
                           </div>
                          

                              <div class="modal-body">

                                 <?php
                                    if($_SESSION['country']=='Romania'){
                                 ?>
                                    <form action="" method="post">
                                       <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                   <label for="">Date of Departure *</label>
                                                   <input type="hidden" name="employee_id" value="<?=$row['id'];?>" id="" class="form-control">

                                                   <input type="date" name="date_of_dep" value="<?=$flight_details['date_of_dep']?>" id="" class="form-control" required>
                                                   
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label for="">Airport Name</label>
                                                   <input type="text" name="airport_name" value="<?=$flight_details['airport_name']?>" placeholder="Enter Airport Name" id="" class="form-control">
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label for="">Airline</label>
                                                   
                                                   <input type="text" name="airline" value="<?=$flight_details['airline']?>" placeholder="Enter Airline Name" id="" class="form-control">
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label for="">Route</label>
                                                   <input type="text" name="route" value="<?=$flight_details['from_to']?>" placeholder="Enter Route Details" id="" class="form-control">
                                                </div>
                                             </div>

                                          
                                       </div>

                                       <button type="submit" name="update_flight_detail" class="btn btn-primary">Update</button>

                                    </form>



                                 <?php
                                    }else{
                                 ?>

                                       <div class="row">
                                          <form action="" method="post">
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label for="">Date of Departure</label>
                                                   <input type="hidden" name="employee_id" value="<?=$row['id'];?>" id="" class="form-control">

                                                   <input type="date" name="date_of_dep" value="" id="" class="form-control">
                                                   
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label for="">Airport Name</label>
                                                   <input type="text" name="airport_name" value="" placeholder="Enter Airport Name" id="" class="form-control">
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label for="">Airline</label>
                                                   
                                                   <input type="text" name="airline" value="" placeholder="Enter Airline Name" id="" class="form-control">
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label for="">Route</label>
                                                   <input type="text" name="route" value="" placeholder="Enter Route Details" id="" class="form-control">
                                                </div>
                                             </div>

                                          
                                       </div>

                                       <button type="submit" name="update_flight_detail" class="btn btn-primary">Update</button>

                                    </form>
                                    </div>

                                 <?php
                                    }
                                 ?>
                                 
                              </div>
                     
                           <div class="modal-footer">
                           <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                           
                           </div>
                        </div>
                     </div>
                     </div>

                     <!-- Modal -->
                     <div class="modal fade" id="exampleModal<?=$row['id']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                     <div class="modal-dialog" role="document">
                        <div class="modal-content">
                           <div class="modal-header">
                           <h5 class="modal-title" id="exampleModalLabel">Assign Company</h5>
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                           </button>
                           </div>
                           <?php
                              if($_SESSION['country']=='Romania'){
                           ?>

                              <div class="modal-body">
                                 <form action="" method="post">
                                    <div class="row">
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <label for="">Company Name</label>
                                             <input type="hidden" name="employee_id" value="<?=$row['id'];?>" id="" class="form-control">

                                             <!--<input type="text" name="company_name" id="" class="form-control">-->
                                                <select name='company_name' id='company_name' class='form-control'>
                                                    <?php
                                                        
                                                        if(!empty($check_company['company_name'])){
                                                        
                                                        ?>
                                                    
                                                            <option value="<?=$check_company['company_name'];?>"><?=$check_company['company_name'];?></option>
                                                    
                                                        <?php
                                                        }else{
                                                        ?>
                                                        
                                                            <option>Select Company</option>
                                                        
                                                        <?php
                                                        }
                                                    ?>
                                                   <?php
                                                    $dynamic_company_list=mysqli_query($con,"select * from company_list");
                                                    
                                                    while($company_list=mysqli_fetch_assoc($dynamic_company_list)){
                                                        ?>
                                                        
                                                            <option value='<?=$company_list["company_name"]?>'><?=$company_list["company_name"]?></option>
                                                            
                                                        <?php
                                                    }
                                                    
                                                   ?>
                                                </select>
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <label for="">Trade</label>
                                             <!--<input type="text" name="trade" id="" class="form-control">-->
                                             
                                             <select name='trade' id='trade' class='form-control'>
                                                    <?php
                                                        
                                                        if(!empty($check_company['trade'])){
                                                        
                                                        ?>
                                                    
                                                            <option value="<?=$check_company['trade'];?>"><?=$check_company['trade'];?></option>
                                                    
                                                        <?php
                                                        }else{
                                                        ?>
                                                        
                                                            <option>Select trade</option>
                                                        
                                                        <?php
                                                        }
                                                    ?>
                                                   <?php
                                                    $dynamic_trade_list=mysqli_query($con,"select * from trade");
                                                    
                                                    while($trade_list=mysqli_fetch_assoc($dynamic_trade_list)){
                                                        ?>
                                                        
                                                            <option value='<?=$trade_list["trade"]?>'><?=$trade_list["trade"]?></option>
                                                            
                                                        <?php
                                                    }
                                                    
                                                   ?>
                                                </select>
                                             
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <label for="">Miscellaneous</label>
                                             <input type="text" name="miscellaneous" id="" class="form-control">
                                          </div>
                                       </div>
                                    </div>
                                    <button type="submit" name="assign_company" class="btn btn-primary">Save</button>
                                 
                                 </div>
                              </form>
                           <?php
                              }else{
                           ?>
                              <div class="modal-body">
                                 <form action="" method="post">
                                    <div class="row">
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <label for="">Company Name</label>
                                             <input type="hidden" name="employee_id" value="<?=$row['id'];?>" id="" class="form-control">

                                             <!--<input type="text" name="company_name" id="" class="form-control">-->
                                                <select name='company_name' id='company_name' class='form-control'>
                                                    <?php
                                                        
                                                        if(!empty($check_company['company_name'])){
                                                        
                                                        ?>
                                                    
                                                            <option value="<?=$check_company['company_name'];?>"><?=$check_company['company_name'];?></option>
                                                    
                                                        <?php
                                                        }else{
                                                        ?>
                                                        
                                                            <option>Select Company</option>
                                                        
                                                        <?php
                                                        }
                                                    ?>
                                                   <?php
                                                    $dynamic_company_list=mysqli_query($con,"select * from company_list");
                                                    
                                                    while($company_list=mysqli_fetch_assoc($dynamic_company_list)){
                                                        ?>
                                                        
                                                            <option value='<?=$company_list["company_name"]?>'><?=$company_list["company_name"]?></option>
                                                            
                                                        <?php
                                                    }
                                                    
                                                   ?>
                                                </select>
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <label for="">Trade</label>
                                             <input type="text" name="trade" id="" class="form-control">
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <label for="">E No</label>
                                             <input type="text" name="e_no" id="" class="form-control">
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <label for="">Visa No</label>
                                             <input type="text" name="visa_no" id="" class="form-control">
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <label for="">Sponsor ID</label>
                                             <input type="text" name="sponsor_id" id="" class="form-control">
                                          </div>
                                       </div>
                                        <div class="col-md-6">
                                          <div class="form-group">
                                             <label for="">Miscellaneous</label>
                                             <input type="text" name="miscellaneous" id="" class="form-control">
                                          </div>
                                       </div>
                                    </div>
                                 
                                    <button type="submit" name="assign_company" class="btn btn-primary">Save</button>
                                
                                 </div>
                              </form>
                           <?php
                              }
                           ?> 
                           <div class="modal-footer">
                           <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                           
                           </div>
                        </div>
                     </div>
                     </div>
                  
                     <?php

                        if($row['status']=='Returned'){
                     ?>

                           <button class='btn btn-danger'><?=$row['status']?></button>

                     <?php
                        }else{
                     ?>
                           <button class='btn btn-primary'><?=$row['status']?></button>

                     <?php
                        }
                        
                     ?>
                  
                  
                  
                     </td>
                    
                    <?php if ($can_update === 'on'): ?>
                     <td>

                           <?php

                              if($row['status']=='Ready To Apply'){

                           ?>
                                    <form method="post" style='margin:0px; padding:0px; text-align:center;width:100px'>
													<input type="hidden" name='getid' value='<?= $row['id']; ?>' />
											
													<select name="status" class='form-control'  onchange="this.form.submit()" >
														<option value="Ready To Apply">Ready To Apply</option>
														<option value="Applied">Applied</option>
                                         <option value="Returned">Returned</option>
													</select>	
												</form>
                           <?php
                              }
                           

                              elseif($row['status']=='Applied'){

                              ?>
                                    <form method="post" style='margin:0px; padding:0px; text-align:center;width:100px'>
                                       <input type="hidden" name='getid' value='<?= $row['id']; ?>' />
                                 
                                       <select name="status" class='form-control'  onchange="this.form.submit()" >
                                          <option value="Applied">Applied</option>
														<option value="Work Permit Issued">Work Permit Issued</option>
                                          <option value="Ready To Apply">Ready To Apply</option>
                                          <option value="Returned">Returned</option>
                                       </select>	
                                    </form>
                              <?php
                              }
                             

                              elseif($row['status']=='Work Permit Issued'){

                              ?>
                                    <form method="post" style='margin:0px; padding:0px; text-align:center;width:100px'>
                                       <input type="hidden" name='getid' value='<?= $row['id']; ?>' />
                                 
                                       <select name="status" class='form-control'  onchange="this.form.submit()" >
                                          <option value="Work Permit Issued">Work Permit Issued</option>
                                          <option value="Appointment Applied">Appointment Applied</option>
                                          <option value="Applied">Applied</option>
                                          <option value="Returned">Returned</option>
                                       </select>	
                                    </form>
                              <?php
                              }
                              elseif($row['status']=='Appointment Applied'){

                                 ?>
                                       <form method="post" style='margin:0px; padding:0px; text-align:center;width:100px'>
                                          <input type="hidden" name='getid' value='<?= $row['id']; ?>' />
                                    
                                          <select name="status" class='form-control'  onchange="this.form.submit()" >
                                             <option value="Appointment Applied">Appointment Applied</option>
                                             <option value="Visa Issued">Visa Issued</option>
                                             <option value="Return From Embassy">Return From Embassy</option>
                                             <option value="Applied">Applied</option>
                                             <option value="Returned">Returned</option>
                                          </select>	
                                       </form>
                                 <?php
                                 }
                                 elseif($row['status']=='Return From Embassy'){
                                     ?>
                                    
                                     <form method="post" style='margin:0px; padding:0px; text-align:center;width:100px'>
                                          <input type="hidden" name='getid' value='<?= $row['id']; ?>' />
                                    
                                          <select name="status" class='form-control'  onchange="this.form.submit()" >
                                              <option value="Return From Embassy">Return From Embassy</option>
                                             <option value="Ready To Apply">Ready To Apply</option>
                                             <option value="Applied">Applied</option>
                                             <option value="Work Permit Issued">Work Permit Issued</option>
                                             <option value="Appointment Applied">Appointment Applied</option>
                                             <option value="Returned">Returned</option>
                                          </select>	
                                       </form>
                                     
                                     
                                    <?php
                                     
                                 }
                              elseif($row['status']=='Visa Issued'){

                                 ?>
                                       <form method="post" style='margin:0px; padding:0px; text-align:center;width:100px'>
                                          <input type="hidden" name='getid' value='<?= $row['id']; ?>' />
                                    
                                          <select name="status" class='form-control'  onchange="this.form.submit()" >
                                             <option value="Visa Issued">Visa Issued</option>
                                             <option value="Fly">Fly</option>
                                             <option value="Work Permit Issued">Work Permit Issued</option>
                                             <option value="Returned">Returned</option>
                                          </select>	
                                       </form>
                              <?php
                                 }
                                 elseif($row['status']=='Fly'){

                                    ?>
                                          <form method="post" style='margin:0px; padding:0px; text-align:center;width:100px'>
                                             <input type="hidden" name='getid' value='<?= $row['id']; ?>' />
                                       
                                             <select name="status" class='form-control'  onchange="this.form.submit()" >
                                                <option value="Fly">Fly</option>
                                                <option value="Visa Issued">Visa Issued</option>
                                                <option value="Returned">Returned</option>
                                             </select>	
                                          </form>
                                 <?php
                                    }
                                 ?>
                     </td>
                    <?php endif; ?>

                     
                  </tr>
                  <?php
                     }
                  ?>
               </tbody>
               
            </table>
            <br/>  
            <?php
               include('components/footer.php');
            ?>
         </div>
        
      </div>
      <link rel="stylesheet" href="assets/js/datatables/datatables.css" id="style-resource-1">
      <link rel="stylesheet" href="assets/js/select2/select2-bootstrap.css" id="style-resource-2">
      <link rel="stylesheet" href="assets/js/select2/select2.css" id="style-resource-3">
      <script src="assets/js/gsap/TweenMax.min.js" id="script-resource-1"></script> 
      <script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js" id="script-resource-2"></script> 
      <script src="assets/js/bootstrap.js" id="script-resource-3"></script> 
      <script src="assets/js/joinable.js" id="script-resource-4"></script> 
      <script src="assets/js/resizeable.js" id="script-resource-5"></script> 
      <script src="assets/js/neon-api.js" id="script-resource-6"></script> 
      <script src="assets/js/cookies.min.js" id="script-resource-7"></script> 
      <script src="assets/js/datatables/datatables.js" id="script-resource-8"></script> 
      <script src="assets/js/select2/select2.min.js" id="script-resource-9"></script> 
<script src="assets/js/neon-custom.js" id="script-resource-11"></script>  
</body>
</html>