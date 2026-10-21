<?php
require('config.php');
session_start();
$errormsg = "";
if (isset($_POST['email'])) {

  $email = stripslashes($_REQUEST['email']);
  $email = mysqli_real_escape_string($con, $email);
  $password = stripslashes($_REQUEST['password']);
  $password = mysqli_real_escape_string($con, $password);
  $query = "SELECT * FROM `users` WHERE email='$email'and password='" . md5($password) . "'";
  $result = mysqli_query($con, $query) or die(mysqli_error($con));
  $rows = mysqli_num_rows($result);
  if ($rows == 1) {
    $_SESSION['petty_cash'] = $email;
    header("Location: index.php");
  } else {
    $errormsg  = "<p style='    align-items: center;
	text-align: center;
	padding: 10px 10px 10px 10px;
	background: #992a2a;
	margin-top: 5%;''>Plz Enter Correct Details</p>";
  }
} else {
}
?>
<!doctype html>
<html lang="en">

	
<!-- Mirrored from codervent.com/dashtreme/demo/vertical/authentication-signin.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 16 Jun 2022 11:31:28 GMT -->
<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!--favicon-->
		<link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" />
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
		<div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
			<div class="container-fluid">
				<div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
					<div class="col mx-auto">
						<div class="mb-4 text-center">
							<!-- <img src="assets/images/logo-img.png" width="180" alt="" /> -->
						</div>
						<div class="card">
							<div class="card-body">
								<div class="border p-4 rounded">
									<div class="text-center">
										<h3 class="">Sign in</h3>
										<!-- <p>Don't have an account yet? <a href="authentication-signup.html">Sign up here</a> -->
										</p>
									</div>
									
									
									<div class="form-body">
										<form class="row g-3" action="" method="POST" autocomplete="off">
											<div class="col-12">
												<label for="inputEmailAddress" class="form-label">Email Address</label>
												<input type="email" name="email" class="form-control" id="inputEmailAddress" placeholder="Email Address">
											</div>
											<div class="col-12">
												<label for="inputChoosePassword" class="form-label">Enter Password</label>
												<div class="input-group" id="show_hide_password">
													<input type="password" name="password" class="form-control border-end-0" id="inputChoosePassword" value="12345678" placeholder="Enter Password"> <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-check form-switch">
													<input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
													<label class="form-check-label" for="flexSwitchCheckChecked">Remember Me</label>
												</div>
											</div>
											<!-- <div class="col-md-6 text-end">	<a href="authentication-forgot-password.html">Forgot Password ?</a> -->
											</div>
											<div class="col-12">
												<div class="d-grid">
													<button type="submit" class="btn btn-light"><i class="bx bxs-lock-open"></i>Sign in</button>
														<p>
																	<?php echo $errormsg ?>
														</p>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--end row-->
			</div>
		</div>
	</div>
	<!--end wrapper-->
	


	<!--plugins-->
	<script src="assets/js/jquery.min.js"></script>
	<!--Password show & hide js -->
	<script>
		$(document).ready(function () {
			$("#show_hide_password a").on('click', function (event) {
				event.preventDefault();
				if ($('#show_hide_password input').attr("type") == "text") {
					$('#show_hide_password input').attr('type', 'password');
					$('#show_hide_password i').addClass("bx-hide");
					$('#show_hide_password i').removeClass("bx-show");
				} else if ($('#show_hide_password input').attr("type") == "password") {
					$('#show_hide_password input').attr('type', 'text');
					$('#show_hide_password i').removeClass("bx-hide");
					$('#show_hide_password i').addClass("bx-show");
				}
			});
		});
	</script>

	<script>
	$(".switcher-btn").on("click", function() {
	$(".switcher-wrapper").toggleClass("switcher-toggled")
	}), $(".close-switcher").on("click", function() {
		$(".switcher-wrapper").removeClass("switcher-toggled")
	}),


	$('#theme1').click(theme1);
	$('#theme2').click(theme2);
	$('#theme3').click(theme3);
	$('#theme4').click(theme4);
	$('#theme5').click(theme5);
	$('#theme6').click(theme6);
	$('#theme7').click(theme7);
	$('#theme8').click(theme8);
	$('#theme9').click(theme9);
	$('#theme10').click(theme10);
	$('#theme11').click(theme11);
	$('#theme12').click(theme12);
	$('#theme13').click(theme13);
	$('#theme14').click(theme14);
	$('#theme15').click(theme15);


	function theme1() {
	  $('body').attr('class', 'bg-theme bg-theme1');
	}

	function theme2() {
	  $('body').attr('class', 'bg-theme bg-theme2');
	}

	function theme3() {
	  $('body').attr('class', 'bg-theme bg-theme3');
	}

	function theme4() {
	  $('body').attr('class', 'bg-theme bg-theme4');
	}

	function theme5() {
	  $('body').attr('class', 'bg-theme bg-theme5');
	}

	function theme6() {
	  $('body').attr('class', 'bg-theme bg-theme6');
	}

	function theme7() {
	  $('body').attr('class', 'bg-theme bg-theme7');
	}

	function theme8() {
	  $('body').attr('class', 'bg-theme bg-theme8');
	}

	function theme9() {
	  $('body').attr('class', 'bg-theme bg-theme9');
	}

	function theme10() {
	  $('body').attr('class', 'bg-theme bg-theme10');
	}

	function theme11() {
	  $('body').attr('class', 'bg-theme bg-theme11');
	}

	function theme12() {
	  $('body').attr('class', 'bg-theme bg-theme12');
	}

	function theme13() {
	  $('body').attr('class', 'bg-theme bg-theme13');
	}

	function theme14() {
	  $('body').attr('class', 'bg-theme bg-theme14');
	}

	function theme15() {
	  $('body').attr('class', 'bg-theme bg-theme15');
	}
	</script>
</body>


<!-- Mirrored from codervent.com/dashtreme/demo/vertical/authentication-signin.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 16 Jun 2022 11:31:29 GMT -->
</html>