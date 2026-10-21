<?php
    include('database/db_connection.php');
    include('session.php');
    include('attendance_system/database.php');

    $obj = new Database();
    
    $msg = "";
$editable = false;

$employee_id = "";
$from_date = "";
$to_date = "";
$total = "";
$half_leave = "";
$short_leave = "";
$leave_time = "";
$description = "";
$status = "";

if (isset($_POST['add_leave'])) {

    $leave_type = $_POST['leave_type'] ?? '';
    $short_leave = $_POST['short_leave'] ?? '';
    $total_days = $_POST['total'] ?? '';

    if($leave_type == 'half_leave'){
        $leave_time = 4;
    }elseif($leave_type == 'short_leave'){
        $leave_time = 2;
    }else{
        $leave_time = $total_days * $total_working_hours;
    }

    $data = [
        "emp_id" => $_POST['employee_id'],
        "from_date" => $_POST['from_date'],
        "to_date" => $_POST['to_date'],
        "total" => $total_days,
        "leave_type" => $leave_type,
        "leave_time" => $leave_time,
        "description" => $_POST['description'],
    ];

    $message = $obj->insert("employee_leaves", $data)
        ? "Leave Record Inserted Successfully."
        : "Leave is Not Inserted Successfully.";

    $msg = $message;
}

if (isset($_GET['id'])) {

    $id = $_GET['id'];
    $editable = true;

    $colName = "*"; // Select all columns
    $join = null; // No join required
    $limit = 0;
    $where = "id = $id"; // Adjust your condition accordingly


    $obj->select('attendance_employee_info', $colName, $join, $where, null, $limit);
    $result = $obj->getResult();

    $employee = $result[0];

    $employee_id = $employee['employee_id'];
    $from_date = $employee['from_date'];
    $to_date = $employee['to_date'];
    $total = $employee['total'];
    $half_leave = $employee['half_leave'];
    $short_leave = $employee['short_leave'];
    $leave_time = $employee['leave_time'];
    $description = $employee['description'];
    $status = $employee['status'];

}

if (isset($_POST['update_leave_info'])) {
    $id = $_POST['employee_id'];
    $data = [
        "employee_id" => $_POST['employee_id'],
        "from_date" => $_POST['from_date'],
        "to_date" => $_POST['to_date'],
        "total" => $_POST['total'],
        "half_leave" => $_POST['half_leave'],
        "short_leave" => $_POST['short_leave'],
        "leave_time" => $_POST['leave_time'],
        "description" => $_POST['description'],
        "status" => $_POST['status']
    ];

    $message = $obj->update('attendance_employee_info', $data, 'id=' . $id)
        ? "Leave Data Updated Successfully."
        : "Leave Data is Not Updated Successfully.";

    echo "<h2>$message</h2>";
}

$colName = "*";
$join = null;
$limit = 0;

$obj->select('company', $colName, $join, null, null, $limit);
$company_names = $obj->getResult();

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
                <li class="active"> <strong>Add Leave</strong> </li>
            </ol>
            <hr />
            <div class="col-12">

                <a href="leaves" class="btn btn-success">Leaves</a>

            </div>
            <hr />
            <p class="text-success text-center text-bold"><strong><?= $msg ?></strong></p>
            <div class="col-12">
                <form class="" method="post" action="add_leave">
                    <div class="form-group mb-0">
                        <input type="hidden" class="form-control" name="employee_id" required value="<?= $empid ?>"
                            id="inputText11" />
                        <?php
                                                    if ($editable) {
                                                        ?>
                        <input type="hidden" class="form-control" name="employee_id" required value="<?= $empid ?>"
                            id="inputText11" />
                        <?php
                                                    }
                                                    ?>
                    </div>
                    <div class="form-group mb-0">
                        <label for="from_date" class="col-3 text-end col-form-label">From Date
                            <span style="color:red">*</span></label>
                        <input type="date" class="form-control" name="from_date" id="from_date"
                            value="<?= $from_date ?>" required />
                    </div>
                    <div class="form-group mb-0">
                        <label for="to_date" class="col-3 text-end col-form-label">To Date <span
                                style="color:red">*</span></label>
                        <input type="date" class="form-control" name="to_date" id="to_date" value="<?= $to_date ?>"
                            required />
                    </div>
                    <div class="form-group mb-0">
                        <label for="total" class="col-3 text-end col-form-label">Total Days
                            <span style="color:red">*</span></label>
                        <input type="text" class="form-control" name="total" id="total" value="<?= $total ?>" required
                            readonly />
                    </div>
                    <script>
                    function calculateDays() {
                        const fromDate = new Date(document.getElementById('from_date').value);
                        const toDate = new Date(document.getElementById('to_date').value);
                        const totalField = document.getElementById('total');

                        if (!isNaN(fromDate) && !isNaN(toDate)) {
                            // Calculate difference in time
                            const timeDiff = toDate - fromDate;
                            const dayDiff = Math.floor(timeDiff / (1000 * 60 * 60 * 24));

                            // Add 1 to include the start day
                            totalField.value = (dayDiff >= 0) ? (dayDiff + 1) : 0;
                        } else {
                            totalField.value = '';
                        }
                    }

                    // Attach event listeners
                    document.getElementById('from_date').addEventListener('change', calculateDays);
                    document.getElementById('to_date').addEventListener('change', calculateDays);

                    // Optional: run on page load
                    window.addEventListener('load', calculateDays);
                    </script>
                    <div class="form-group mb-0">
                        <label class="col-3 text-end col-form-label">Half Day</label>
                        <input type="radio" name="leave_type" value="half_leave" />
                    </div>
                    <div class="form-group mb-0">
                        <label class="col-3 text-end col-form-label">Short Day</label>
                        <input type="radio" name="leave_type" value="short_leave" />
                    </div>
                    <div class="form-group mb-0">
                        <label for="description" class="col-3 text-end col-form-label">
                            Description <span style="color:red">*</span>
                        </label>
                        <textarea class="form-control" name="description" id="description" required
                            placeholder="Enter Description Here"><?= $description ?></textarea>
                    </div>
                    <div class="form-group mb-0 text-end">
                        <button type="submit" name="<?= ($editable) ? 'update_leave_info' : 'add_leave'; ?>"
                            class="btn btn-primary">
                            <?= ($editable) ? 'Update' : 'Save'; ?>
                        </button>
                    </div>
                </form>
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


</body>

</html>