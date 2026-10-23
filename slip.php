<?php
include('database/db_connection.php');
include('session.php');
include('attendance_system/database.php');

$obj = new Database();

$colName = "
            attendance_summary.*,
            salary_sheet.*,
            attendance_employee_info.id,
            attendance_employee_info.name,
            attendance_employee_info.salary,
            attendance_employee_info.currency,
            attendance_employee_info.designation
        ";

$emp_id = $_GET['id']; // make sure to sanitize this
$month = $_GET['month'];
$year = date('Y');

$where = "
            attendance_summary.month = '$month'
            AND salary_sheet.month = '$month'
            AND attendance_summary.emp_id = '$emp_id'
        ";

$join = "
            salary_sheet ON salary_sheet.emp_id = attendance_summary.emp_id
            JOIN attendance_employee_info ON attendance_employee_info.emp_id = attendance_summary.emp_id
        ";

$limit = 0;

$obj->select('attendance_summary', $colName, $join, $where, null, $limit);
$result = $obj->getResult();

$employee_details = $result[0];

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
    <meta name="description" content="Neon Admin Panel" />
    <meta name="author" content="Laborator.co" />
    <link rel="icon" href="assets/images/favicon.ico">

    <title>Dhothar | Invoice</title>
    <link rel="stylesheet" href="assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css"
        id="style-resource-1">
    <link rel="stylesheet" href="assets/css/font-icons/entypo/css/entypo.css" id="style-resource-2">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic"
        id="style-resource-3">
    <link rel="stylesheet" href="assets/css/bootstrap.css" id="style-resource-4">
    <link rel="stylesheet" href="assets/css/neon-core.css" id="style-resource-5">
    <link rel="stylesheet" href="assets/css/neon-theme.css" id="style-resource-6">
    <link rel="stylesheet" href="assets/css/neon-forms.css" id="style-resource-7">
    <link rel="stylesheet" href="assets/css/custom.css" id="style-resource-8">
    <script src="assets/js/jquery-1.11.3.min.js"></script>
</head>

<body class="page-body">
    <div class="page-container">
        <div class="sidebar-menu">
            <div class="sidebar-menu-inner">

                <?php include('components/sidebar.php'); ?>
            </div>
        </div>
        <div class="main-content">

            <br class="hidden-print" />
            <div class="invoice">
                <div class="row">
                    <div class="col-sm-6 invoice-left"> <a href="#"> <img src="dhothar_logo.png" width="185" alt /> </a>
                    </div>
                    <div class="col-sm-6 invoice-right">
                        <h3>INVOICE</h3>
                        <span>
                            <?php
                            $date = date('Y-m-d');// Example date in Y-m-d format
                            
                            echo 'Dated: ' . $date = date("d-m-Y", strtotime($date));
                            ?>
                        </span>
                    </div>
                </div>
                <hr class="margin" />
                <div class="row">
                    <div class="col-sm-3 invoice-left">
                        <h4>Employee</h4>
                        <?= $employee_details['name'] ?>
                        <br>
                        <?= $employee_details['designation'] ?>
                    </div>
                    <div class="col-sm-3 invoice-left">

                    </div>
                    <div class="col-md-6 invoice-right">
                        <!--<h4>Payment Details:</h4>-->
                        <!--<strong>V.A.T Reg #:</strong> 542554(DEMO)78-->
                        <!--<br/> <strong>Account Name:</strong> FoodMaster Ltd-->
                        <!--<br/> <strong>SWIFT code:</strong> 45454DEMO545DEMO-->
                    </div>
                </div>
                <div class="margin"></div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th width="60%">Payments</th>
                            <th>Date</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <tr>
                            <td class="text-center"><?= $i++ ?></td>
                            <td>Actual Salary</td>
                            <td><?= $employee_details['month'] . ' ' . $employee_details['year'] ?></td>
                            <td><?= $employee_details['salary'] . ' ' . $employee_details['currency'] ?></td>
                        </tr>

                        <?php if ((float) $employee_details['deducted_salary'] > 0): ?>
                        <tr>
                            <td class="text-center"><?= $i++ ?></td>
                            <td>Deducted Salary</td>
                            <td><?= $employee_details['month'] . ' ' . $employee_details['year'] ?></td>
                            <td><?= $employee_details['deducted_salary'] ?></td>
                        </tr>
                        <?php endif; ?>

                        <?php if ((float) $employee_details['approved_leave_amount'] > 0): ?>
                        <tr>
                            <td class="text-center"><?= $i++ ?></td>
                            <td>Approved Leave Relief</td>
                            <td><?= $employee_details['month'] . ' ' . $employee_details['year'] ?></td>
                            <td><?= $employee_details['approved_leave_amount'] ?></td>
                        </tr>
                        <?php endif; ?>

                        <?php if ((float) $employee_details['relief_amount'] > 0): ?>
                        <tr>
                            <td class="text-center"><?= $i++ ?></td>
                            <td>Relief / Waive Off</td>
                            <td><?= $employee_details['month'] . ' ' . $employee_details['year'] ?></td>
                            <td><?= $employee_details['relief_amount'] ?></td>
                        </tr>
                        <?php endif; ?>

                        <tr>
                            <td class="text-center"><?= $i++ ?></td>
                            <td><strong>Final Salary</strong></td>
                            <td><?= $employee_details['month'] . ' ' . $employee_details['year'] ?></td>
                            <td><strong><?= !empty($employee_details['final_salary']) ? $employee_details['final_salary'] : $employee_details['calculated_salary']; ?>
                                </strong></td>
                        </tr>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-md-6">
                        
                    </div>
                    <div class="col-md-6">
                        <div class="col-sm-6">
                          <style>
                            .stamp {
                              width: 200px;
                              height: 100px;
                              border: 6px solid #007BFF;
                              display: flex;
                              justify-content: center;
                              align-items: center;
                              margin: 40px auto;
                              transform: rotate(-25deg);
                              color: #007BFF;
                              font-weight: bold;
                              font-family: Arial, sans-serif;
                              font-size: 28px;
                        
                              /* Zigzag border effect */
                              clip-path: polygon(
                                5% 0%, 10% 10%, 15% 0%, 20% 10%, 25% 0%, 30% 10%, 35% 0%, 
                                40% 10%, 45% 0%, 50% 10%, 55% 0%, 60% 10%, 65% 0%, 70% 10%, 
                                75% 0%, 80% 10%, 85% 0%, 90% 10%, 95% 0%, 100% 10%,
                                100% 90%, 95% 100%, 90% 90%, 85% 100%, 80% 90%, 75% 100%, 
                                70% 90%, 65% 100%, 60% 90%, 55% 100%, 50% 90%, 45% 100%, 
                                40% 90%, 35% 60%, 30% 90%, 25% 100%, 20% 90%, 15% 100%, 
                                10% 90%, 5% 100%, 0% 90%, 0% 10%
                              );
                            }
                          </style>
                        
                          <div class="stamp">
                            PAID
                          </div>
                        </div>

                    </div>
                </div>
                <div class="margin"></div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="invoice-left">
                            5th Road City Plaza
                            <br />
                            Near New Al Jannat Mall
                            <br />
                            P: 03425083003
                            <br />
                            Dhothar International
                            <br />
                            <a href="#">dhotharinternational@gmail.com</a>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="invoice-right">
                            <a href="javascript:window.print();"
                                class="btn btn-primary btn-icon icon-left hidden-print">
                                Print Invoice
                                <i class="entypo-doc-text"></i> </a>
                            &nbsp;

                        </div>
                    </div>
                </div>
            </div>
            <?php
            include('components/footer.php');
            ?>
        </div>

    </div>

    <script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="assets/js/gsap/TweenMax.min.js" id="script-resource-1"></script>
    <script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js" id="script-resource-2"></script>
    <script src="assets/js/bootstrap.js" id="script-resource-3"></script>
    <script src="assets/js/joinable.js" id="script-resource-4"></script>
    <script src="assets/js/resizeable.js" id="script-resource-5"></script>
    <script src="assets/js/neon-api.js" id="script-resource-6"></script>
    <script src="assets/js/cookies.min.js" id="script-resource-7"></script>
<script src="assets/js/neon-custom.js" id="script-resource-9"></script>
</body>

</html>