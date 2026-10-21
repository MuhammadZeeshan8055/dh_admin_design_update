<?php
    include('database/db_connection.php');
    include('session.php');
    
    $dateCondition = "";
    if (isset($_GET['date1'], $_GET['date2'])) {
        $date1 = $_GET['date1'];
        $date2 = $_GET['date2'];
        $dateCondition = " AND status_updated_at BETWEEN '$date1' AND '$date2'";
    }

    $status = mysqli_real_escape_string($con, $_GET['status'] ?? 'Work Permit Issued');
    
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
      <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic" id="style-resource-3">
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
       
            
            
           
            <h3>Waiting for Appointment Table Data</h3>
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
                        <th>Country</th>
                        <th>Apply Date</th>
                        <th>First Character Expiry</th>
                        <th>Second Character Expiry</th>
                        <th>Online Submission Date</th>
                        <th>Physical Submission Date</th>
                        <th>Work Permit Receiving Date</th>
                        <th>Appointment Date</th>
                        <th>Visa Issue Date</th>
                        <th>Visa Expiry</th>
                        <th>Company Name</th>
                        <th>Trade</th>
                        <th>Miscellaneous</th>
                        <th>Entered By</th>
                        <th>Updated By</th>
                        <th>Approved By</th>
                        <th>Passport Returned Date</th>
                        <th>Status</th>
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
                            ncd.date_of_birth AS date_of_birth,
                            ncd.client_age AS client_age,
                            ncd.care_of AS care_of,
                            ncd.mobile_no_1 AS mobile_no_1,
                            ncd.mobile_no_2 AS mobile_no_2,
                            ncd.missing_documents AS missing_documents,
                            ncd.country AS country,
                            ncd.apply_date AS apply_date,
                            ncd.first_character_expiry AS first_character_expiry,
                            ncd.second_character_expiry AS second_character_expiry,
                            ncd.online_submission_date AS online_submission_date,
                            ncd.physical_submission_date AS physical_submission_date,
                            ncd.work_permit_receiving_date AS work_permit_receiving_date,
                            ncd.appointment_date AS appointment_date,
                            ncd.entered_by AS entered_by,
                            ncd.updated_by AS updated_by,
                            ncd.approved_by AS approved_by,
                            ncd.status AS status,
                            ncd.docs_missing AS docs_missing,
                            ci.emp_id AS emp_id,
                            ci.company_name AS company_name,
                            ci.trade AS trade,
                            ci.miscellaneous AS miscellaneous,
                            fd.date_of_dep AS date_of_dep,
                            fd.airport_name AS airport_name,
                            fd.airline AS airline,
                            fd.from_to AS from_to FROM new_case_details AS ncd
                                LEFT JOIN company_info AS ci ON ncd.id = ci.emp_id
                                LEFT JOIN flight_details AS fd ON ncd.id = fd.emp_id WHERE status='$status' and (appointment_date Is NULL OR appointment_date = '') AND status NOT IN ('Returned', 'Fly') and country='$_SESSION[country]' $dateCondition");


                    while ($row = mysqli_fetch_assoc($data)) {
                        $i++;
                    ?>
                    <tr>
                        <td><?= $i; ?></td>
                        <td><?= htmlspecialchars($row['name']); ?></td>
                        <td><?= htmlspecialchars($row['fname']); ?></td>
                        <td><?= htmlspecialchars($row['pp_no']); ?></td>
                        <td><?= formatDate($row['pp_expiry']); ?></td>
                        <td><?= htmlspecialchars($row['tracking_id']); ?></td>
                        <td><?= formatDate($row['new_case_date']); ?></td>
                        <td><?= formatDate($row['date_of_birth']); ?></td>
                        <td><?= htmlspecialchars($row['client_age']); ?></td>
                        <td><?= htmlspecialchars($row['care_of']); ?></td>
                        <td><?= htmlspecialchars($row['mobile_no_1']); ?></td>
                        <td><?= htmlspecialchars($row['mobile_no_2']); ?></td>
                        <td><?= htmlspecialchars($row['missing_documents']); ?></td>
                        <td><?= htmlspecialchars($row['country']); ?></td>
                        <td><?= formatDate($row['apply_date']); ?></td>
                        <td><?= formatDate($row['first_character_expiry']); ?></td>
                        <td><?= formatDate($row['second_character_expiry']); ?></td>
                        <td><?= formatDate($row['online_submission_date']); ?></td>
                        <td><?= formatDate($row['physical_submission_date']); ?></td>
                        <td><?= formatDate($row['work_permit_receiving_date']); ?></td>
                        <td><?= formatDate($row['appointment_date']); ?></td>
                        <td><?= formatDate($row['visa_issue_date']); ?></td>
                        <td><?= formatDate($row['visa_expiry_date']); ?></td>
                        <td><?= htmlspecialchars($row['company_name']); ?></td>
                        <td><?= htmlspecialchars($row['trade']); ?></td>
                        <td><?= htmlspecialchars($row['Miscellaneous']); ?></td>
                        <td><?= htmlspecialchars($row['entered_by']); ?></td>
                        <td><?= htmlspecialchars($row['updated_by']); ?></td>
                        <td><?= htmlspecialchars($row['approved_by']); ?></td>
                        <td><?= formatDate($row['passport_returned_date']); ?></td>
                        <td>
                            <button class="btn btn-<?= $row['status'] == 'Returned' ? 'danger' : 'primary'; ?>"><?= htmlspecialchars($row['status']); ?></button>
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
      <script src="assets/js/neon-chat.js" id="script-resource-10"></script>  
      <script src="assets/js/neon-custom.js" id="script-resource-11"></script>  
      <script src="assets/js/neon-demo.js" id="script-resource-12"></script> 
      <script src="assets/js/neon-skins.js" id="script-resource-13"></script> 
       
   </body>
</html>