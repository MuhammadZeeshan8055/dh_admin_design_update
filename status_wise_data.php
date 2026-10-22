<?php
    include('database/db_connection.php');
    include('session.php');
    
    
    if(isset($_GET['status'])){
       $status=$_GET['status'];
    } else {
       $status = '';
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

    // Shared dropdown options — rendered into modal <select>s (no JS list build)
    $company_options_html = "<option value=\"\">Select Company</option>";
    $co_q = mysqli_query($con, "SELECT company_name FROM company_list ORDER BY company_name");
    if ($co_q) {
       while ($co = mysqli_fetch_assoc($co_q)) {
          if ($co['company_name'] !== '') {
             $cn = htmlspecialchars($co['company_name'], ENT_QUOTES, 'UTF-8');
             $company_options_html .= "<option value=\"{$cn}\">{$cn}</option>";
          }
       }
    }
    $trade_options_html = "<option value=\"\">Select trade</option>";
    $tr_q = mysqli_query($con, "SELECT trade FROM trade ORDER BY trade");
    if ($tr_q) {
       while ($tr = mysqli_fetch_assoc($tr_q)) {
          if ($tr['trade'] !== '') {
             $tn = htmlspecialchars($tr['trade'], ENT_QUOTES, 'UTF-8');
             $trade_options_html .= "<option value=\"{$tn}\">{$tn}</option>";
          }
       }
    }

    $isRomania = (($_SESSION['country'] ?? '') === 'Romania');
    $ajaxQs = 'status=' . urlencode($status);
    if (!empty($_GET['date1']) && !empty($_GET['date2'])) {
       $ajaxQs .= '&date1=' . urlencode($_GET['date1']) . '&date2=' . urlencode($_GET['date2']);
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
      <style>
         #table-4_wrapper .dataTables_processing {
            top: 110px !important;
            margin-top: 0 !important;
            z-index: 2;
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            padding: 10px 18px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
         }
         #table-4.dh-table-pending {
            visibility: hidden;
         }
         /* Above header/sidebar (z-index ~1250) */
         .modal-backdrop { z-index: 2490 !important; }
         .modal { z-index: 2500 !important; }
         #dhCompanyShowModal .modal-content,
         #dhCompanyAssignModal .modal-content,
         #dhFlightModal .modal-content {
            overflow: visible !important;
         }
      </style>
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
            <p class="text-muted" id="dh-table-loading">Loading records…</p>
            <table class="table table-bordered datatable table-3" id="table-4">
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
                     <th class="no-export">Assign Company</th>
                     <?php
                        if($status == 'Visa Issued'){
                           echo '<th>Flight Details</th>';
                        }
                     ?>
                     <th>Status</th>
                     
                     <?php if ($can_update === 'on'): ?>
                     <th class="no-export">Action</th>
                     <?php endif; ?>
                  </tr>
               </thead>
               <tbody></tbody>
            </table>

            <!-- Shared company / flight modals (one each — filled on open) -->
            <div class="modal fade" id="dhCompanyShowModal" tabindex="-1" role="dialog" aria-hidden="true">
               <div class="modal-dialog" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h2 class="modal-title">Assign Company</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     </div>
                     <div class="modal-body">
<?php if ($isRomania): ?>
                        <form method="post">
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Company Name</label>
                                    <input type="hidden" name="employee_id" id="dh-show-emp-id" class="form-control">
                                    <select name="company_name" id="dh-show-company" class="form-control"><?= $company_options_html ?></select>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Trade</label>
                                    <select name="trade" id="dh-show-trade" class="form-control"><?= $trade_options_html ?></select>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Miscellaneous</label>
                                    <input type="text" name="miscellaneous" id="dh-show-misc" class="form-control">
                                 </div>
                              </div>
                           </div>
                           <button type="submit" name="update_assign_company" class="btn btn-primary">Update</button>
                        </form>
<?php else: ?>
                        <form method="post">
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Company Name</label>
                                    <input type="hidden" name="employee_id" id="dh-show-emp-id" class="form-control">
                                    <select name="company_name" id="dh-show-company" class="form-control"><?= $company_options_html ?></select>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Trade</label>
                                    <input type="text" name="trade" id="dh-show-trade" class="form-control">
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>E No</label>
                                    <input type="text" name="e_no" id="dh-show-eno" class="form-control">
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Visa No</label>
                                    <input type="text" name="visa_no" id="dh-show-visa" class="form-control">
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Sponsor ID</label>
                                    <input type="text" name="sponsor_id" id="dh-show-sponsor" class="form-control">
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Miscellaneous</label>
                                    <input type="text" name="miscellaneous" id="dh-show-misc" class="form-control">
                                 </div>
                              </div>
                           </div>
                           <button type="submit" name="update_assign_company" class="btn btn-primary">Update</button>
                        </form>
<?php endif; ?>
                     </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                     </div>
                  </div>
               </div>
            </div>

            <div class="modal fade" id="dhCompanyAssignModal" tabindex="-1" role="dialog" aria-hidden="true">
               <div class="modal-dialog" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title">Assign Company</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     </div>
                     <div class="modal-body">
                        <form method="post">
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Company Name</label>
                                    <input type="hidden" name="employee_id" id="dh-assign-emp-id" class="form-control">
                                    <select name="company_name" id="dh-assign-company" class="form-control"><?= $company_options_html ?></select>
                                 </div>
                              </div>
<?php if ($isRomania): ?>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Trade</label>
                                    <select name="trade" id="dh-assign-trade" class="form-control"><?= $trade_options_html ?></select>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Miscellaneous</label>
                                    <input type="text" name="miscellaneous" id="dh-assign-misc" class="form-control">
                                 </div>
                              </div>
<?php else: ?>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Trade</label>
                                    <input type="text" name="trade" id="dh-assign-trade" class="form-control">
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>E No</label>
                                    <input type="text" name="e_no" id="dh-assign-eno" class="form-control">
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Visa No</label>
                                    <input type="text" name="visa_no" id="dh-assign-visa" class="form-control">
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Sponsor ID</label>
                                    <input type="text" name="sponsor_id" id="dh-assign-sponsor" class="form-control">
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Miscellaneous</label>
                                    <input type="text" name="miscellaneous" id="dh-assign-misc" class="form-control">
                                 </div>
                              </div>
<?php endif; ?>
                           </div>
                           <button type="submit" name="assign_company" class="btn btn-primary">Save</button>
                        </form>
                     </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                     </div>
                  </div>
               </div>
            </div>

            <div class="modal fade" id="dhFlightModal" tabindex="-1" role="dialog" aria-hidden="true">
               <div class="modal-dialog" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h2 class="modal-title">Flight Details</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     </div>
                     <div class="modal-body">
                        <form method="post">
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Date of Departure<?= $isRomania ? ' *' : '' ?></label>
                                    <input type="hidden" name="employee_id" id="dh-flight-emp-id" class="form-control">
                                    <input type="date" name="date_of_dep" id="dh-flight-dep" class="form-control"<?= $isRomania ? ' required' : '' ?>>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Airport Name</label>
                                    <input type="text" name="airport_name" id="dh-flight-airport" class="form-control" placeholder="Enter Airport Name">
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Airline</label>
                                    <input type="text" name="airline" id="dh-flight-airline" class="form-control" placeholder="Enter Airline Name">
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Route</label>
                                    <input type="text" name="route" id="dh-flight-route" class="form-control" placeholder="Enter Route Details">
                                 </div>
                              </div>
                           </div>
                           <button type="submit" name="update_flight_detail" class="btn btn-primary">Update</button>
                        </form>
                     </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                     </div>
                  </div>
               </div>
            </div>

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

      <script type="text/javascript">
      jQuery(function ($) {
         var $table4 = $("#table-4");
         if ($.fn.DataTable && $table4.length && !$.fn.DataTable.isDataTable($table4)) {
            $table4.DataTable({
               ajax: {
                  url: 'status_wise_data_data.php?<?= $ajaxQs ?>',
                  dataSrc: 'data'
               },
               deferRender: true,
               pageLength: 25,
               order: [],
               processing: true,
               dom: 'Bfrtip',
               buttons: [
                  { extend: 'copyHtml5', exportOptions: { columns: ':not(.no-export)' } },
                  { extend: 'excelHtml5', exportOptions: { columns: ':not(.no-export)' } },
                  { extend: 'csvHtml5', exportOptions: { columns: ':not(.no-export)' } },
                  { extend: 'pdfHtml5', exportOptions: { columns: ':not(.no-export)' } }
               ],
               initComplete: function () {
                  $('#dh-table-loading').hide();
                  $table4.removeClass('dh-table-pending');

                  this.api().columns().every(function () {
                     var column = this;
                     var $header = $(column.header());

                     if ($header.hasClass('no-export') || $header.find('input.dh-col-search').length) {
                        return;
                     }

                     var title = $header.text().replace(/\s+/g, ' ').trim();
                     var $input = $('<input type="text" class="form-control form-control-sm dh-col-search" />')
                        .attr('placeholder', 'Search ' + title)
                        .css({ marginTop: '5px', width: '100%', minWidth: '70px' });

                     $input.appendTo($header)
                        .on('click mousedown', function (e) {
                           e.stopPropagation();
                        })
                        .on('keyup', function () {
                           var val = this.value;
                           if (column.search() !== val) {
                              column.search(val).draw();
                           }
                        });
                  });
               }
            });
         } else {
            $('#dh-table-loading').hide();
            $table4.removeClass('dh-table-pending');
         }

         // Move modals to body so they show above the header
         $('#dhCompanyShowModal, #dhCompanyAssignModal, #dhFlightModal').appendTo('body');

         // When Show/Assign Company is clicked, put button values into the modal fields
         $(document).on('click', '.dh-open-company', function () {
            var btn = $(this);
            var isShow = (btn.attr('data-target') || '').indexOf('Show') !== -1;
            var p = isShow ? 'show' : 'assign';

            $('#dh-' + p + '-emp-id').val(btn.attr('data-id') || '');
            $('#dh-' + p + '-company').val(btn.attr('data-company') || '');
            $('#dh-' + p + '-trade').val(btn.attr('data-trade') || '');
            $('#dh-' + p + '-misc').val(btn.attr('data-misc') || '');
            $('#dh-' + p + '-eno').val(btn.attr('data-eno') || '');
            $('#dh-' + p + '-visa').val(btn.attr('data-visa') || '');
            $('#dh-' + p + '-sponsor').val(btn.attr('data-sponsor') || '');
         });

         // When Flight button is clicked, put values into the flight modal
         $(document).on('click', '.dh-open-flight', function () {
            var btn = $(this);
            $('#dh-flight-emp-id').val(btn.attr('data-id') || '');
            $('#dh-flight-dep').val(btn.attr('data-dep') || '');
            $('#dh-flight-airport').val(btn.attr('data-airport') || '');
            $('#dh-flight-airline').val(btn.attr('data-airline') || '');
            $('#dh-flight-route').val(btn.attr('data-route') || '');
         });
      });
      </script>
       
   </body>
</html>