<?php
    include("session.php");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      foreach ($_POST as $meta_key => $meta_value) {
          $meta_key = $con->real_escape_string($meta_key);
          $meta_value = $con->real_escape_string($meta_value);
  
          // Check if the meta_key exists
          $result = $con->query("SELECT * FROM attendance_settings WHERE meta_key = '$meta_key'");
  
          if ($result->num_rows > 0) {
              // Update existing record
              $con->query("UPDATE attendance_settings SET meta_value = '$meta_value' WHERE meta_key = '$meta_key'");
          } else {
              // Insert new record
              $con->query("INSERT INTO attendance_settings (meta_key, meta_value) VALUES ('$meta_key', '$meta_value')");
          }
      }
  
       // Redirect back to settings page
       header('Location: settings.php');
       exit;
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
                <li class="active"> <strong>Settings</strong> </li>
            </ol>
            
            <hr />
            <div class="col-12">
                <form class="" method="post" action="settings">
                    <div class="form-group mb-0">
                        <label for="inputText11" class="col-3 text-end  col-form-label">Pakistan Office IP
                            Address</label>
                        <input type="text" class="form-control" name="pak_ip_address" value="<?=$pak_office?>"
                            id="inputText11" placeholder="Enter Pakistan Ip Address Here" />
                    </div>
                    <div class="form-group mb-0">
                        <label for="inputText11" class="col-3 text-end  col-form-label">UAE Office IP Address</label>
                        <input type="text" class="form-control" name="uae_ip_address" value="<?=$uae_office?>"
                            id="inputText11" placeholder="Enter UAE Ip Address Here" />
                    </div>
                    <div class="form-group mb-0">
                        <label for="inputText11" class="col-3 text-end  col-form-label">Romania Office IP
                            Address</label>
                        <input type="text" class="form-control" name="rom_ip_address" value="<?=$rom_office?>"
                            id="inputText11" placeholder="Enter ROMANIA Ip Address Here" />
                    </div>

                    <div class="form-group mb-0">
                        <label for="inputText12" class="col-3 text-end  col-form-label">Total Working Hours</label>
                        <input type="text" class="form-control" name="total_working_hours"
                            value="<?=$total_working_hours?>" id="inputText12" placeholder="Project Name Here" />
                    </div>
                    <div class="form-group mb-0">
                        <label for="inputDate1" class="col-3 text-end  col-form-label">Break Time</label>
                        <input type="text" class="form-control" name="break_time" value="<?=$break_time?>"
                            id="inputDate1" placeholder="Date Here" />
                    </div>
                    <div class="form-group mb-0">
                        <label for="inputDate1" class="col-3 text-end  col-form-label">Break Timings</label>
                        </label>
                        <input type="text" class="form-control" name="break_timing" value="<?=$break_timing?>"
                            id="inputDate1" placeholder="Date Here" />
                    </div>
                    <div class="form-group mb-0">
                        <label for="inputTime1" class="col-3 text-end  col-form-label">Official Working Hours</label>
                        <input type="text" class="form-control" name="official_working_hours"
                            value="<?=$official_working_hours?>" id="inputTime1" placeholder="Start Time Here" />
                    </div>
                    <div class="form-group mb-0 text-end">
                        <button type="submit" class="btn btn-primary">
                            Save
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
<script src="assets/js/neon-custom.js" id="script-resource-11"></script>
</body>

</html>