<?php
include('database/db_connection.php');
include('session.php');
include('attendance_system/database.php');

$obj = new Database();

$colName = "*";
$join = null;
$limit = 0;
$where = null;

$obj->select('care_off_persons', $colName, $join, $where, null, $limit);
$care_of = $obj->getResult();

$result = [];

if (isset($_GET['search_care_of'])) {
    $search_care_of = $_GET['search_care_of'];
    $colName = "new_case_details.id, new_case_details.name, new_case_details.pp_no, 
    new_case_details.care_of, new_case_details.status,
    p.currency, p.agreed_amount, 
    p.first_payment, p.first_payment_date,p.first_payment_method, p.first_payment_description,
    p.second_payment, p.second_payment_date,p.second_payment_method, p.second_payment_description,
    p.final_payment, p.final_payment_date,p.final_payment_method, p.final_payment_description,
    p.payment_status";

    $join = "LEFT JOIN payments p ON new_case_details.id = p.emp_id";
    $limit = 0;
    $where = " new_case_details.care_of = '$search_care_of'";

    $obj->select('new_case_details', $colName, $join, $where, null, $limit);
    $result = $obj->getResult();

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

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        .page-body .select2-container {
            display: block;
            width: 30%;
        }
    </style>

</head>

<body class="page-body">
    <div class="page-container">
        <div class="sidebar-menu">
            <?php include('components/sidebar.php'); ?>
        </div>
        <div class="main-content">
            <?php include('components/header.php'); ?>
            <div class="col-6">
                <label for="">Search Care of Record</label>
                <hr>
                <form action="">
                    <div class="form-group">
                        <div class="d-flex align-items-center justify-content-between gap-6">
                            <select name="search_care_of" onchange="this.form.submit()" class="js-example-basic-single form-select border fs-3"
                                aria-label="Default select example">

                                <option value="">Search Care of</option>

                                <?php 
                                $selectedCareOf = $_GET['search_care_of'] ?? '';
                                if (!empty($care_of)) {
                                    foreach ($care_of as $row) {
                                        $selected = ($selectedCareOf === $row['name']) ? 'selected' : '';
                                        ?>
                                                            <option value="<?= htmlspecialchars($row['name']); ?>" <?= $selected ?>>
                                                                <?= htmlspecialchars($row['name']); ?>
                                                            </option>
                                                            <?php 
                                    }
                                } 
                                ?>
                            </select>

                        </div>
                    </div>

                </form>
            </div>
            <hr />
            <div class="col-12">
                <div class="card-body pt-8">
                    <div class="table-responsive">


                        <h3>Exporting Table Data</h3>
                        <br />
                        <script type="text/javascript">
                        jQuery(document).ready(function($) {
                            var $table4 = jQuery("#table-4");
                            $table4.DataTable({
                                dom: 'Bfrtip',
                                buttons: [
                                    'copyHtml5',
                                    'excelHtml5',
                                    'csvHtml5',
                                    'pdfHtml5'
                                ]
                            });




                        });
                        </script>
                        <table class="table table-bordered table-3" id="table-4">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>PP No</th>
                                    <th>Care Of</th>
                                    <th>Status</th>
                                    <th>Payment History</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($result)) {
                                    foreach ($result as $record) { ?>
                                <tr>
                                    <td><?= $record['name']; ?></td>
                                    <td><?= $record['pp_no']; ?></td>
                                    <td><?= $record['care_of']; ?></td>
                                    <td><?= $record['status']; ?></td>
                                    <td>
                                        <table class="table table-sm table-bordered mb-0">
                                            <tr>
                                                <th>Agreed</th>
                                                <td><?= $record['agreed_amount']; ?> <?= $record['currency']; ?></td>
                                            </tr>
                                            <tr>
                                                <th style="<?= empty($record['first_payment']) ? 'color:red;' : '' ?>">
                                                    1st</th>
                                                <td>
                                                    <?= $record['first_payment']; ?>
                                                    <?= !empty($record['first_payment_date']) ? "(Date: {$record['first_payment_date']})" : '' ?>
                                                    <?= !empty($record['first_payment_method']) ? "({$record['first_payment_method']})" : '' ?>
                                                    <?= !empty($record['first_payment_description']) ? "({$record['first_payment_description']})" : '' ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="<?= empty($record['second_payment']) ? 'color:red;' : '' ?>">
                                                    2nd</th>
                                                <td>
                                                    <?= $record['second_payment']; ?>
                                                    <?= !empty($record['second_payment_date']) ? "(Date: {$record['second_payment_date']})" : '' ?>
                                                    <?= !empty($record['second_payment_method']) ? "({$record['second_payment_method']})" : '' ?>
                                                    <?= !empty($record['second_payment_description']) ? "({$record['second_payment_description']})" : '' ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="<?= empty($record['final_payment']) ? 'color:red;' : '' ?>">
                                                    Final</th>
                                                <td>
                                                    <?= $record['final_payment']; ?>
                                                    <?= !empty($record['final_payment_date']) ? "(Date: {$record['final_payment_date']})" : '' ?>
                                                    <?= !empty($record['final_payment_method']) ? "({$record['final_payment_method']})" : '' ?>
                                                    <?= !empty($record['final_payment_description']) ? "({$record['final_payment_description']})" : '' ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <td><?= $record['payment_status']; ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <?php }
                                }  ?>
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

        <script>
            // In your Javascript (external .js resource or <script> tag)
            $(document).ready(function() {
                $('.js-example-basic-single').select2();
            });
        </script>


</body>

</html>