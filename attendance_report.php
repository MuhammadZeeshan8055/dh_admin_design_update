<?php
    include('database/db_connection.php');
    include('session.php');
    include('attendance_system/database.php');

    $obj = new Database();
    $company = "";
    if (isset($_GET['company'])) {
        $company = trim($_GET['company']); // Optional: trim spaces
    }
    $company = !empty($company) ? $company : '';

    
    $colName = "attendance_employee_info.id,attendance_employee_info.emp_id,attendance_employee_info.name,attendance_employee_info.company,attendance_employee_info.salary,attendance_employee_info.currency,attendance_company.company_name";
    $where = !empty($company) ? "attendance_company.company_name = '$company'" : "1";
    $join = 'attendance_company ON attendance_company.id = attendance_employee_info.company';
    $limit = 0;
    
    $obj->select('attendance_employee_info',$colName,$join,$where,null,$limit);
        $result = $obj->getResult();

    $companyName = "*";
    
    $obj->select('company',$companyName,null,null,null,0);
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
            <div class="col-12">
                <div class="card-body pt-8">
                    <div class="table-responsive">
                        <table class="table table-bordered"
                            id="attendance_record">
                            <tr>
                                <thead>
                                    <th>S.no</th>
                                    <th>Name</th>
                                    <th>Company</th>
                                    <th>Salary</th>
                                    <th>Actions</th>
                                </thead>
                            </tr>
                            <tbody>
                                <?php
                                                $i=0;
                                                if(!empty($result)){
                                                    foreach ($result as 
                                                    list("emp_id"=>$id,"name"=>$name,
                                                    "company"=>$company,"salary"=>$salary,"currency"=>$currency,'company_name'=>$company)) {
                                                        $i++;
                                                ?>
                                <tr>
                                    <td><?=$i?></td>
                                    <td><?=$name?></td>
                                    <td><?=$company?></td>
                                    <td><?=$salary.' '.$currency?></td>
                                    <td>
                                        <a href="view_attendance?id=<?= $id ?>" class="btn btn-success">View
                                            Attendance</a>
                                    </td>
                                </tr>
                                <?php
                                                    }
                                                }else{
                                                    ?>
                                <tr>
                                    <td class="text-center" colspan="6">No Attendance Record Found for this
                                        Company</td>
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
        <script src="assets/js/neon-chat.js" id="script-resource-10"></script>
        <script src="assets/js/neon-custom.js" id="script-resource-11"></script>
        <script src="assets/js/neon-demo.js" id="script-resource-12"></script>


</body>

</html>