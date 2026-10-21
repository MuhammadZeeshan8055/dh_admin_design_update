<?php
    include('database/db_connection.php');
    include('session.php');
    include('attendance_system/database.php');

    $obj = new Database();
        
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
                <div class="card-body pt-8">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="attendance_record">
                            <tr>
                                <thead>
                                    <th>Name</th>
                                    <th>Salary Slip</th>
                                </thead>
                            </tr>
                            <tbody>
                                <?php if (!empty($result)): ?>
                                <?php foreach($result as $row): ?>
                                <tr>
                                    <td><?= $row['name'] ?></td>
                                    <td>
                                        <a href="slip?id=<?= $row['emp_id'] ?>&month=<?= $month ?>" target="_blank" class="btn btn-primary">Salary Slip</a>
                                    </td>
                                    
                                </tr>

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
        <script src="assets/js/neon-chat.js" id="script-resource-10"></script>
        <script src="assets/js/neon-custom.js" id="script-resource-11"></script>
        <script src="assets/js/neon-demo.js" id="script-resource-12"></script>


</body>

</html>