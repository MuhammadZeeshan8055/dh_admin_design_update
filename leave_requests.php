<?php
    include('database/db_connection.php');
    include('session.php');
    include('attendance_system/database.php');

    $obj = new Database();
    
    $msg="";
    $colName = "employee_leaves.*,attendance_employee_info.name";
    $join = "attendance_employee_info on employee_leaves.emp_id=attendance_employee_info.emp_id";
    $where = "employee_leaves.status = 'Applied'";

    $limit = 0;

    $obj->select('employee_leaves', $colName, $join, $where, null, $limit);
    $result = $obj->getResult();

    if(isset($_POST['update_leave_status'])) {
        $employee_id   = $_POST['employee_id'];
        $from_date     = $_POST['from_date'];
        $to_date       = $_POST['to_date'];
        $leave_type    = isset($_POST['leave_type']) ? $_POST['leave_type'] : null;
        $update_status = $_POST['update_leave_status'];
        
        $approved_by = $username;
        
        
        $data = [
            "status" => $update_status,
            "approved_by" => $approved_by
        ];


        // Build base condition
        $where = "emp_id = '$employee_id' AND from_date = '$from_date' AND to_date = '$to_date'";

        // Append leave_type condition only if it is not empty
        if (!empty($leave_type)) {
            $where .= " AND leave_type = '$leave_type'";
        }

        $message = $obj->update('employee_leaves', $data, $where)
            ? "Leave Status Updated Successfully."
            : "Leave Status is Not Updated Successfully.";

        $msg=$message;
        
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
            <hr />
            <ol class="breadcrumb bc-3">
                <li> <a href="../../dashboard/main/index.html"><i class="fa-home"></i>Home</a> </li>
                <li> <a href="../main/index.html">Tables</a> </li>
                <li class="active"> <strong>Leave Requests</strong> </li>
            </ol>
            <hr />
            <?php if (!empty($msg)): ?>
                <div id="delete-msg">
                    <p class="text-success text-center"><strong><?= $msg ?></strong></p>
                </div>
                <script>
                    // Hide the message after 3 seconds and then redirect
                    setTimeout(function () {
                        document.getElementById('delete-msg').style.display = 'none';
                        window.location.href = 'leave_requests.php'; // <-- redirect URL here
                    }, 2000);
                </script>
            <?php endif; ?>

            <hr />
            <div class="col-12">
                <div class="card-body pt-8">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="attendance_record">
                            <tr>
                                <thead>
                                    <th>S.no</th>
                                    <th>Name</th>
                                    <th>From Date</th>
                                    <th>To Date</th>
                                    <th>Total</th>
                                    <th>Leave Type</th>
                                    <th>Leave Time</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                </thead>
                            </tr>
                            <tbody>
                                <?php
                                            $i = 0;
                                            if (!empty($result)) {
                                                foreach ($result as $record) {
                                                    $i++;
                                                    ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $record['name']; ?></td>
                                    <td><?= $record['from_date']; ?></td>
                                    <td><?= $record['to_date']; ?></td>
                                    <td><?= $record['total']; ?></td>
                                    <td><?= $record['leave_type']; ?></td>
                                    <td><?= $record['leave_time']; ?></td>
                                    <td><?= $record['description']; ?></td>
                                    <td>
                                        <form action="" method="post">
                                            <input type="hidden" name="employee_id" value="<?= $record['emp_id']; ?>">
                                            <input type="hidden" name="from_date" value="<?= $record['from_date']; ?>">
                                            <input type="hidden" name="to_date" value="<?= $record['to_date']; ?>">
                                            <input type="hidden" name="leave_type"
                                                value="<?= $record['leave_type']; ?>">
                                            <select name="update_leave_status" class="form-control"
                                                onchange="this.form.submit()">
                                                <option value="<?= $record['status']; ?>"><?= $record['status']; ?>
                                                </option>
                                                <option value="Approved">Approved</option>
                                                <option value="Declined">Declined</option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>

                                <?php
                                                }
                                            } else {
                                                ?>
                                <tr>
                                    <td colspan="9" class="text-center">No Record Found</td>
                                </tr>
                                <?php
                                            }
                                            ?>

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
</body>

</html>