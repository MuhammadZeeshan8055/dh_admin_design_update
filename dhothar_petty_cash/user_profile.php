<?php
include("session.php");
$exp_fetched = mysqli_query($con, "SELECT * FROM expenses WHERE user_id = '$userid'");

if (isset($_POST['save'])) {
    $fname = mysqli_real_escape_string($con,$_POST['first_name']);
    $lname = mysqli_real_escape_string($con,$_POST['last_name']);
    // $email = mysqli_real_escape_string($con,$_POST['email']);

    $sql = "UPDATE users SET firstname = '$fname', lastname='$lname' WHERE user_id='$userid'";
    if (mysqli_query($con, $sql)) {
        echo "Records were updated successfully.";
    } else {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
    }
    header('location: user_profile?page=user_profile');
}

if (isset($_POST['but_upload'])) {

    $name = $_FILES['file']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);

    // Select file type
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Valid file extensions
    $extensions_arr = array("jpg", "jpeg", "png", "gif");

    // Check extension
    if (in_array($imageFileType, $extensions_arr)) {

        // Insert record
        $query = "UPDATE users SET profile_path = '$name' WHERE user_id='$userid'";
        mysqli_query($con, $query);

        // Upload file
        move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $name);

        header("Refresh: 0");
    }
}

?>
<!doctype html>
<html lang="en">


<!-- Mirrored from codervent.com/dashtreme/demo/vertical/user-profile.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 16 Jun 2022 11:31:30 GMT -->
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" />
	<!--plugins-->
	<link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
	<link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
	<link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
	<!-- loader-->
	<link href="assets/css/pace.min.css" rel="stylesheet" />
	<script src="assets/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/bootstrap-extended.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
	<link href="assets/css/app.css" rel="stylesheet">
	<link href="assets/css/icons.css" rel="stylesheet">
	
	<title>Dhothar - Petty Cash</title>
</head>

<body class="bg-theme bg-theme1">
	<!--wrapper-->
	<div class="wrapper">
		<!--sidebar wrapper -->
		<?php include('components/sidebar.php'); ?>
		<!--end sidebar wrapper -->
		<!--start header -->
			<?php include('components/header.php'); ?>
		<!--end header -->
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">User Profile</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">User Profilep</li>
							</ol>
						</nav>
					</div>
					
				</div>
				<!--end breadcrumb-->
				<div class="container">
					<div class="main-body">
						<div class="row">
							<div class="col-lg-4">
								<div class="card">
									<div class="card-body">
										<div class="d-flex flex-column align-items-center text-center">
											<img src="<?php echo $userprofile; ?>" alt="Admin" class="rounded-circle p-1 bg-primary" width="110">
											<div class="mt-3">
												<h5><?php echo $firstname; ?> <?php echo $lastname; ?></h5>
												<!-- <p class="mb-1">Full Stack Developer</p>
												<p class="font-size-sm">Bay Area, San Francisco, CA</p>
												<button class="btn btn-light">Follow</button>
												<button class="btn btn-light">Message</button> -->
											</div>
											
										</div>
										<hr class="my-4" />
										
									</div>
								</div>
							</div>
							<div class="col-lg-8">
								<div class="card">
									<div class="card-body">
										<form method="post" action="" enctype='multipart/form-data'>
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Change Picture</h6>
											</div>
											<div class="col-sm-9">
												<input type="file" name='file' class="form-control"/>
												<button class="btn btn-secondary" type="submit" name='but_upload' id="profilepicinput">Upload Picture</button>

										</div>
										</form>
										</div>
										<form class="form" action="" method="post" autocomplete="off">
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">First Name</h6>
											</div>
											<div class="col-sm-9">
												<input type="text" class="form-control" name="first_name" value="<?php echo $firstname; ?>"/>
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Last Name</h6>
											</div>
											<div class="col-sm-9">
												<input type="text" class="form-control" name="last_name" id="last_name" value="<?php echo $lastname; ?>" />
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Email</h6>
											</div>
											<div class="col-sm-9">
												<input type="text" class="form-control"  name="email" id="email" value="<?php echo $useremail; ?>" disabled/>
											</div>
										</div>
										<!-- <div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Phone</h6>
											</div>
											<div class="col-sm-9">
												<input type="text" class="form-control" value="(239) 816-9029" />
											</div>
										</div> -->
										
										<div class="row">
											<div class="col-sm-3"></div>
											<div class="col-sm-9">
												<input name="save" type="submit" class="btn btn-light px-4" value="Save Changes" />
											</div>
										</div>
										</form>
									</div>
								</div>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--end page wrapper -->
		<!--start overlay-->
		<div class="overlay toggle-icon"></div>
		<!--end overlay-->
		<!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
		<!--End Back To Top Button-->
		
	</div>
	<!--end wrapper-->
	<!--start switcher-->
	<div class="switcher-wrapper">
		<div class="switcher-btn"> <i class='bx bx-cog bx-spin'></i>
		</div>
		<div class="switcher-body">
			<div class="d-flex align-items-center">
				<h5 class="mb-0 text-uppercase">Theme Customizer</h5>
				<button type="button" class="btn-close ms-auto close-switcher" aria-label="Close"></button>
			</div>
			<hr/>
			<p class="mb-0">Gaussian Texture</p>
			  <hr>
			  
			  <ul class="switcher">
				<li id="theme1"></li>
				<li id="theme2"></li>
				<li id="theme3"></li>
				<li id="theme4"></li>
				<li id="theme5"></li>
				<li id="theme6"></li>
			  </ul>
               <hr>
			  <p class="mb-0">Gradient Background</p>
			  <hr>
			  
			  <ul class="switcher">
				<li id="theme7"></li>
				<li id="theme8"></li>
				<li id="theme9"></li>
				<li id="theme10"></li>
				<li id="theme11"></li>
				<li id="theme12"></li>
				<li id="theme13"></li>
				<li id="theme14"></li>
				<li id="theme15"></li>
			  </ul>
		</div>
	</div>
	<!--end switcher-->
	<!-- Bootstrap JS -->
	<script src="assets/js/bootstrap.bundle.min.js"></script>
	<!--plugins-->
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
	<!--app JS-->
	<script src="assets/js/app.js"></script>
</body>


<!-- Mirrored from codervent.com/dashtreme/demo/vertical/user-profile.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 16 Jun 2022 11:31:30 GMT -->
</html>