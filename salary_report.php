<?php
    include('database/db_connection.php');
    include('session.php');
    include('attendance_system/database.php');

    $obj = new Database();

    if (isset($_GET['id']) && isset($_GET['type']) && $_GET['type'] === 'waive_off') {
        // $emp_id = $_GET['id'];
        // $where = "
        //     emp_id = '{$emp_id}'
        // ";
        // $obj->select('salary_sheet', '*', null, $where);
        // $rows = $obj->getResult();

        // // pr($rows);
        // $details = $rows[0];

        // $month = $details['month'];
        // pr(value: $month);

        $colName = "
            attendance_summary.*,
            salary_sheet.*,
            attendance_employee_info.id,
            attendance_employee_info.name,
            attendance_employee_info.salary,
            attendance_employee_info.currency
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
        
        $emp_details = $result[0];
        $relief_amount = $emp_details['deducted_salary'];
        $final_salary = $emp_details['salary'];

        $data = [
            "relief_amount" => $relief_amount,
            "final_salary" => $final_salary.' '.$emp_details['currency'],
            "description" => ''

        ];

        $update_where = "emp_id = $emp_id AND month = '$month' AND year = '$year'";
        $update = $obj->update("salary_sheet", $data, $update_where);


    }   
    
    if(isset($_POST['custom_amount_deduction'])){
        $emp_id = $_POST['employee_id'];
        $month = $_POST['month'];
        $currency = $_POST['currency'];
        $year = date('Y');
        $actual_salary = $_POST['actual_salary'];
        $deducted_salary = preg_replace('/[^0-9]/', '', $_POST['deducted_salary']);;
        $actual_dedction_amount = $_POST['actual_dedction_amount'];
        $final_salary = $_POST['final_salary'];
        $description = $_POST['description'];

        $relief_amount = $deducted_salary - $actual_dedction_amount;
        
        $data = [
            "relief_amount" => $relief_amount.' '.$currency,
            "final_salary" => $final_salary.' '.$currency,
            "description" => $description
        ];


        $update_where = "emp_id = $emp_id AND month = '$month' AND year = '$year'";
        $update = $obj->update("salary_sheet", $data, $update_where);
        
    }
    
    
    if(isset($_GET['search_month'])){
        $month = $_GET['search_month'];
    }else{
        $month = date('F', strtotime('first day of last month'));;
    }

    $colName = "attendance_summary.*,salary_sheet.*,attendance_employee_info.id,attendance_employee_info.name,attendance_employee_info.salary,attendance_employee_info.currency";
    $where = "attendance_summary.month='$month' and salary_sheet.month='$month'";
    $join = 'salary_sheet ON salary_sheet.emp_id = attendance_summary.emp_id JOIN attendance_employee_info ON attendance_employee_info.emp_id = attendance_summary.emp_id';
    $limit = 0;
    
    $obj->select('attendance_summary',$colName,$join,$where,null,$limit);
        $result = $obj->getResult();

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
    <!--[if lt IE 9]><script src="https://demo.neontheme.com/assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <!--[if lt IE 9]> <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script> <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script> <![endif]-->
</head>

<body class="page-body">
    <div class="page-container">
        <div class="sidebar-menu">
            <?php include('components/sidebar.php'); ?>
        </div>
        <div class="main-content">
            <?php include('components/header.php'); ?>
            <div class="col-6">
                <label for="">Search Salary Record</label>
                <hr>
                <form action="">
                    <div class="form-group">
                        <div class="d-flex align-items-center justify-content-between gap-6">
                            <select name="search_month" onchange="this.form.submit()" class="form-select border fs-3"
                                aria-label="Default select example">
                                <?php
                                                if(isset($_GET['search_month'])){
                                                    ?>

                                <option value="<?=$_GET['search_month']?>"><?=$_GET['search_month']?></option>

                                <?php
                                                }else{
                                                    ?>
                                <option value="">Search Month</option>

                                <?php
                                                }
                                            ?>
                                <option value="January">January</option>
                                <option value="February">February</option>
                                <option value="March">March</option>
                                <option value="April">April</option>
                                <option value="May">May</option>
                                <option value="June">June</option>
                                <option value="July">July</option>
                                <option value="August">August</option>
                                <option value="September">September</option>
                                <option value="October">October</option>
                                <option value="November">November</option>
                                <option value="December">December</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <hr />
            <div class="col-12">
                <div class="company-list">
                    <form method="POST" action="generate_salary_slip" id="companyForm">
                        <label for="">Generate Salary</label>
                        <hr>
                        <div class="form-group">
                            <div class="d-flex align-items-center justify-content-between gap-6">
                                <select name="month" class="form-select border fs-3"
                                    aria-label="Default select example">
                                    <option value="January">January</option>
                                    <option value="February">February</option>
                                    <option value="March">March</option>
                                    <option value="April">April</option>
                                    <option value="May">May</option>
                                    <option value="June">June</option>
                                    <option value="July">July</option>
                                    <option value="August">August</option>
                                    <option value="September">September</option>
                                    <option value="October">October</option>
                                    <option value="November">November</option>
                                    <option value="December">December</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <input type="submit" name="generate_salary_slip" class="btn btn-primary"
                                value="Generate Salary Details">
                        </div>
                    </form>
                </div>


            </div>
            <hr />
            <div class="col-12">
                <div class="card-body pt-8">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="attendance_record">
                            <tr>
                                <thead>
                                    <th>Name</th>
                                    <th>Salary</th>
                                    <th>Wording Days</th>
                                    <th>Shortfall in Days</th>
                                    <th>Expected Working Hours</th>
                                    <th>Actual Working Hours</th>
                                    <th>Shortfall Mins</th>
                                    <th>Hourly Rate</th>
                                    <th>Minute Rate</th>
                                    <th>Approved Leave Amount</th>
                                    <th>Calculated Salary</th>
                                    <th>Deducted Salary</th>
                                    <th>Relief Amount</th>
                                    <th>Final Salary</th>
                                    <th>Description</th>
                                    <th>Month</th>
                                    <th>Year</th>
                                    <th></th>
                                    <th></th>
                                </thead>
                            </tr>
                            <tbody>
                                <?php if (!empty($result)): ?>
                                <?php foreach($result as $row): ?>
                                <tr>
                                    <td><?= $row['name'] ?></td>
                                    <td><?= $row['salary'] ?></td>
                                    <td><?= $row['working_days'] ?></td>
                                    <td><?= intval($row['shortfall_in_days']) ?></td>
                                    <td><?= $row['expected_hours'] ?></td>
                                    <td><?= $row['actual_hours'] ?></td>
                                    <td><?= $row['shortfall_mins'] ?></td>
                                    <td><?= $row['hourly_rate'] ?></td>
                                    <td><?= $row['minute_rate'] ?></td>
                                    <td><?=$row['approved_leave_amount']?></td>
                                    <td><?= $row['calculated_salary'] ?></td>
                                    <td style="color:red"><?= $row['deducted_salary'] ?></td>
                                    <td style="color:green"><?= $row['relief_amount'] ?></td>
                                    <td style="color:green"><?= $row['final_salary'] ?></td>
                                    <td><?= $row['description'] ?></td>
                                    <td><?= $row['month'] ?></td>
                                    <td><?= $row['year'] ?></td>
                                    <td>
                                        <a href="salary_report?id=<?= $row['emp_id'] ?>&type=waive_off&month=<?= $row['month'] ?>" onclick="return confirm('Are you sure you want to waive off this salary?');" class="btn btn-success">Waive off</a>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#refund_modal<?= $row['emp_id'] ?>">
                                            Custom Amount
                                        </button>
                                    </td>
                                </tr>

                                <!-- Custom Deduction Modal -->
                                <div class="modal fade" id="refund_modal<?=$row['emp_id']?>" tabindex="-1" role="dialog" aria-labelledby="showModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                        <h2 class="modal-title" id="showModalLabel">Custom Deduction</h2>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        
                
                                            <div class="modal-body">
                
                                                    <form action="" method="post">
                                                    <div class="row">
                                                            <div class="col-md-12">
                                                                <h3><?=$row['name']?></h3>
                                                                <br>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="">Actual Salary</label>

                                                                    <input type="hidden" name="employee_id" value="<?=$row['emp_id'];?>" id="" class="form-control">
                                                                    <input type="hidden" name="month" value="<?=$row['month'];?>" id="" class="form-control">
                                                                    <input type="hidden" name="currency" value="<?=$row['currency'];?>" id="" class="form-control">

                                                                    <input type="number" name="actual_salary" value="<?=$row['salary'];?>" id="actual_salary_<?=$row['emp_id']?>" class="form-control" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="">Deduction Amount</label>
                                                                    <input type="text" name="deducted_salary" value="<?=$row['deducted_salary'];?>" id="deduction_amount_<?=$row['emp_id']?>" class="form-control" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="">Actual Deduction Amount</label>
                                                                    <input type="number" name="actual_dedction_amount" value="" id="actual_deduction_amount_<?=$row['emp_id']?>" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="">Final Salary</label>
                                                                    <input type="text" name="final_salary" value="" id="final_salary_<?=$row['emp_id']?>" class="form-control" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <label for="desc">Description</label>
                                                                <div class="form-group">
                                                                <textarea id="desc" rows="8" name="description" cols="60"></textarea>
                                                                </div>
                                                            </div>
                                                    </div>
                
                                                    <button type="submit" name="custom_amount_deduction" class="btn btn-primary">Add</button>
                
                                                    </form>
                
                                            </div>
                                    
                                        <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                        </div>
                                    </div>
                                </div>

                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="13" style="text-align: center;">No records found</td>
                                </tr>
                                <?php endif; ?>

                            </tbody>
                        </table>
                    </div>
                </div>
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
<script>
            document.addEventListener("DOMContentLoaded", function () {
                <?php foreach($result as $row): ?>
                    (function(empId) {
                        let actualSalaryEl = document.getElementById("actual_salary_" + empId);
                        let deductionEl = document.getElementById("actual_deduction_amount_" + empId);
                        let finalSalaryEl = document.getElementById("final_salary_" + empId);

                        if (deductionEl) {
                            deductionEl.addEventListener("input", function () {
                                let actualSalary = parseFloat(actualSalaryEl.value) || 0;
                                let deduction = parseFloat(this.value) || 0;

                                // Calculate final salary
                                let finalSalary = actualSalary - deduction;

                                // Show in final salary field
                                finalSalaryEl.value = finalSalary >= 0 ? finalSalary : 0;
                            });
                        }
                    })(<?= $row['emp_id'] ?>);
                <?php endforeach; ?>
            });
        </script>


</body>

</html>