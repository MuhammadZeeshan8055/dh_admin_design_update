<?php
    
    include('database/db_connection.php');
    include('session.php');

    if(isset($_POST['enter_refund_info'])){
       
        $emp_ID=$_POST['employee_id'];
        $date_of_ref=$_POST['date_of_ref'];
        $refund_amount=$_POST['refund_amount'];
        $payment_method=$_POST['payment_method'];
        $account_name=$_POST['account_name'];
        $paid_by=$_POST['paid_by'];
        $description=$_POST['description'];
        
        $flight_details=mysqli_query($con,"insert into refund_payments (emp_id,date_of_ref,refund_amount,payment_method,account_name,paid_by,description) 
         VALUES 
         ('$emp_ID','$date_of_ref','$refund_amount','$payment_method','$account_name','$paid_by','$description')");
         
        if($flight_details==true){
            echo '<script>alert("Refunds Details Entered Successfully");</script>'; // Display your message
            echo '<script>
                     setTimeout(function() {
                        window.location.href = "refund_analysis";
                     }, 2000); // Redirect after 2 seconds
                  </script>';
             
        }else{
            echo '<script>alert("Refunds Details Not Entered");</script>';
   
        }
    }
    
    if (isset($_GET['id']) && $_GET['type'] == 'delete') {
        
        $id=$_GET['id'];
        
        $del=mysqli_query($con,"Delete from refund_payments where id='$id'");
        
        if($del==true){
            echo '<script>alert("Refunds Details Deleted Successfully");</script>'; // Display your message
            echo '<script>
                     setTimeout(function() {
                        window.location.href = "refund_analysis";
                     }, 2000); // Redirect after 2 seconds
                  </script>';
             
        }else{
            echo '<script>alert("Refunds Details Not Deleted");</script>';
       echo 'Error: ' . mysqli_error($con);
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
               <li> <a href="../main/index.html">Accounts</a> </li>
               <li class="active"> <strong>Refund List</strong> </li>
            </ol>
       
            
            
           
            <h3>Refund List</h3>
            <br/> <script type="text/javascript">
               jQuery( document ).ready( function( $ ) {
               var $table4 = jQuery( "#table-4" );
               $table4.DataTable( {
               dom: 'Bfrtip',
               buttons: [
               'copyHtml5',
               'excelHtml5',
               'csvHtml5',
               'pdfHtml5'
               ]
               } );


              

               } );
            </script> 
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
                        <th>Care Of</th>
                        <th>Mobile No 1</th>
                        <th>Mobile No 2</th>
                        <th>Country</th>
                        <th>Passport Returned Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $data = mysqli_query($con, "SELECT
                                ncd.id AS id,
                                ncd.name AS name,
                                ncd.fname AS fname,
                                ncd.pp_no AS pp_no,
                                ncd.pp_expiry AS pp_expiry,
                                ncd.tracking_id AS tracking_id,
                                ncd.new_case_date AS new_case_date,
                                ncd.care_of AS care_of,
                                ncd.mobile_no_1 AS mobile_no_1,
                                ncd.mobile_no_2 AS mobile_no_2,
                                ncd.country AS country,
                                ncd.status AS status,
                                ncd.passport_returned_date AS passport_returned_date
                            FROM new_case_details AS ncd
                            WHERE status = 'Returned' AND country = '{$_SESSION['country']}'");
                        
                        while ($row = mysqli_fetch_assoc($data)) {
                            $i++;
                        
                            // Check if a refund entry exists for this emp_id
                            $emp_id = $row['id'];
                            $refund_check = mysqli_query($con, "SELECT 1 FROM refund_payments WHERE emp_id = $emp_id LIMIT 1");
                            $is_refunded = mysqli_num_rows($refund_check) > 0;
                        ?>
                        <tr>
                            <td><?= $i; ?></td>
                            <td><?= htmlspecialchars($row['name']); ?></td>
                            <td><?= htmlspecialchars($row['fname']); ?></td>
                            <td><?= htmlspecialchars($row['pp_no']); ?></td>
                            <td><?= formatDate($row['pp_expiry']); ?></td>
                            <td><?= htmlspecialchars($row['tracking_id']); ?></td>
                            <td><?= formatDate($row['new_case_date']); ?></td>
                            <td><?= htmlspecialchars($row['care_of']); ?></td>
                            <td><?= htmlspecialchars($row['mobile_no_1']); ?></td>
                            <td><?= htmlspecialchars($row['mobile_no_2']); ?></td>
                            <td><?= htmlspecialchars($row['country']); ?></td>
                            <td><?= formatDate($row['passport_returned_date']); ?></td>
                            <td>
                                <button class="btn btn-<?= $row['status'] == 'Returned' ? 'danger' : 'primary'; ?>">
                                    <?= htmlspecialchars($row['status']); ?>
                                </button>
                            </td>
                            <td>
                                <?php if ($is_refunded): ?>
                                    <button class="btn btn-success">Refunded</button>
                                <?php else: ?>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#refund_modal<?= $row['id'] ?>">
                                        Refund
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    
                    <!-- Payment Refund Modal -->
                    <div class="modal fade" id="refund_modal<?=$row['id']?>" tabindex="-1" role="dialog" aria-labelledby="showModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                               <div class="modal-header">
                               <h2 class="modal-title" id="showModalLabel">Payment Refund</h2>
                               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                               </button>
                               </div>
                              
    
                                  <div class="modal-body">
    
                                        <form action="" method="post">
                                           <div class="row">
                                                <div class="col-md-12">
                                                    <h3><?=$row['name']?> C/O <?=$row['care_of']?></h3>
                                                    <br>
                                                 </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                       <label for="">Date</label>
                                                       <input type="hidden" name="employee_id" value="<?=$row['id'];?>" id="" class="form-control">
    
                                                       <input type="date" name="date_of_ref" value="" id="" class="form-control">
                                                       
                                                    </div>
                                                 </div>
                                                 <div class="col-md-6">
                                                    <div class="form-group">
                                                       <label for="">Refund Amount</label>
                                                       <input type="number" name="refund_amount" value="" placeholder="Enter Refund Amount" id="" class="form-control">
                                                    </div>
                                                 </div>
                                                 <div class="col-md-6">
                                                    <div class="form-group">
                                                       <label for="">Payment Method</label>
                                                       <input type="text" name="payment_method" value="" placeholder="Enter Payment Method" id="" class="form-control">
                                                    </div>
                                                 </div>
                                                 <div class="col-md-6">
                                                    <div class="form-group">
                                                       <label for="">Account Name</label>
                                                       <input type="text" name="account_name" value="" placeholder="Enter Account Method" id="" class="form-control">
                                                    </div>
                                                 </div>
                                                 <div class="col-md-6">
                                                    <div class="form-group">
                                                       <label for="">Paid By</label>
                                                       <input type="text" name="paid_by" value="" placeholder="Enter Paid By" id="" class="form-control">
                                                    </div>
                                                 </div>
                                                 <div class="col-md-12">
                                                    <label for="desc">Description</label>
                                                    <div class="form-group">
                                                       <textarea id="desc" rows="8" name="description" cols="60"></textarea>
                                                    </div>
                                                 </div>
                                           </div>
    
                                           <button type="submit" name="enter_refund_info" class="btn btn-primary">Add</button>
    
                                        </form>
    
                                  </div>
                         
                               <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                               </div>
                            </div>
                        </div>
                    </div>
                    
                    <?php } ?>
                </tbody>
            </table>
            <br/>  
            
            <h3>Clear List</h3>
            <br/> <script type="text/javascript">
               jQuery( document ).ready( function( $ ) {
               var $table4 = jQuery( "#table-5" );
               $table4.DataTable( {
               dom: 'Bfrtip',
               buttons: [
               'copyHtml5',
               'excelHtml5',
               'csvHtml5',
               'pdfHtml5'
               ]
               } );


              

               } );
            </script> 
              <table class="table table-bordered datatable table-3" id="table-5">
                <thead>
                    <tr>
                        <th>S.no</th>
                        <th>Name</th>
                        <th>Care Of</th>
                        <th>Passport No</th>
                        <th>Tracking ID</th>
                        <th>Date Of Refund</th>
                        <th>Refunded Amount</th>
                        <th>Payment Method</th>
                        <th>Account Name</th>
                        <th>Paid By</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    $refund_list = mysqli_query($con, "SELECT refund_payments.*,new_case_details.name,new_case_details.care_of,new_case_details.pp_no,new_case_details.tracking_id FROM `refund_payments` left join new_case_details on new_case_details.id=refund_payments.emp_id");
                    while ($refund = mysqli_fetch_assoc($refund_list)) {
                        $i++;
                    ?>
                    <tr>
                        <td><?= $i; ?></td>
                        <td><?= htmlspecialchars($refund['name']); ?></td>
                        <td><?= htmlspecialchars($refund['care_of']); ?></td>
                        <td><?= htmlspecialchars($refund['pp_no']); ?></td>
                        <td><?= htmlspecialchars($refund['tracking_id']); ?></td>
                        <td><?= htmlspecialchars($refund['date_of_ref']); ?></td>
                        <td><?= htmlspecialchars($refund['refund_amount']); ?></td>
                        <td><?= htmlspecialchars($refund['payment_method']); ?></td>
                        <td><?= htmlspecialchars($refund['account_name']); ?></td>
                        <td><?= htmlspecialchars($refund['paid_by']); ?></td>
                        <td><?= htmlspecialchars($refund['description']); ?></td>
                        <td>
                            <a href="refund_analysis?id=<?= $refund['id'] ?>&type=delete" class="btn btn-danger">Delete</a>
                        </td>
                        
                    </tr>
                    
                    
                    
                    <?php } ?>
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