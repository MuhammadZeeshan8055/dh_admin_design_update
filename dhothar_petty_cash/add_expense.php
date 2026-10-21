<?php
include("session.php");
$update = false;
$del = false;
$msg='';
$expenseamount = "";
$expensedate = date("Y-m-d");
$expensecategory = "Food";
if (isset($_POST['add'])) {
    $expenseamount = $_POST['expenseamount'];
    $expensedate = $_POST['expensedate'];
    $expensecategory = $_POST['expensecategory'];
	$description=$_POST['desc'];

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
        // $query = "UPDATE users SET profile_path = '$name' WHERE user_id='$userid'";
        // mysqli_query($con, $query);


		if($expenseamount>=5000){
			$status='Pending';
		}else{
			$status='Yes';
		}


		$expenses = "INSERT INTO expenses (user_id, expense,expensedate,expensecategory,slip,description,status) VALUES ('$userid', '$expenseamount','$expensedate','$expensecategory','$name','$description','$status')";
		$result = mysqli_query($con, $expenses) or die("Something Went Wrong!");
		

        // Upload file
        move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $name);

        // header("Refresh: 0");
        if($result==true){
             $msg="Data Inserted Successfully";
            header('location:add_expense?page=add_expense');
           
        }else{
            $msg="Data Not Inserted";
            // header('location:add_expense?page=add_expense');
        }
		//
// 		header('location:add_expense?page=add_expense');
    }


    // $expenses = "INSERT INTO expenses (user_id, expense,expensedate,expensecategory) VALUES ('$userid', '$expenseamount','$expensedate','$expensecategory')";
    // $result = mysqli_query($con, $expenses) or die("Something Went Wrong!");
    // header('location: add_expense.php');
}

if (isset($_POST['update'])) {
    $id = $_GET['edit'];
    $expenseamount = $_POST['expenseamount'];
    $expensedate = $_POST['expensedate'];
    $expensecategory = $_POST['expensecategory'];
    $description = $_POST['desc'];


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
        // $query = "UPDATE users SET profile_path = '$name' WHERE user_id='$userid'";
        // mysqli_query($con, $query);


		$sql = "UPDATE expenses SET expense='$expenseamount', expensedate='$expensedate', expensecategory='$expensecategory',slip='$name',description='$description' WHERE user_id='$userid' AND expense_id='$id'";
		if (mysqli_query($con, $sql)) {
			echo "Records were updated successfully.";
		} else {
			echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
		}
        // Upload file
        move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $name);

        // header("Refresh: 0");

		//
		header('location:add_expense?page=add_expense');

    }

    // $sql = "UPDATE expenses SET expense='$expenseamount', expensedate='$expensedate', expensecategory='$expensecategory' WHERE user_id='$userid' AND expense_id='$id'";
    // if (mysqli_query($con, $sql)) {
    //     echo "Records were updated successfully.";
    // } else {
    //     echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
    // }
    // header('location: manage_expense?page=manage_expense');
}



if (isset($_POST['delete'])) {
    $id = $_GET['delete'];
    $image = $_GET['img'];

	

    $expenseamount = $_POST['expenseamount'];
    $expensedate = $_POST['expensedate'];
    $expensecategory = $_POST['expensecategory'];
    $expensecategory = $_POST['expensecategory'];
    $slip = $_POST['slip'];
    $description = $_POST['desc'];

	unlink('uploads/'.$image);
	

    $sql = "DELETE FROM expenses WHERE user_id='$userid' AND expense_id='$id'";
    if (mysqli_query($con, $sql)) {
        echo "Records were updated successfully.";
    } else {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
    }
    header('location: manage_expense?page=manage_expense');
}

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $record = mysqli_query($con, "SELECT * FROM expenses WHERE user_id='$userid' AND expense_id=$id");
    if (mysqli_num_rows($record) == 1) {
        $n = mysqli_fetch_array($record);
        $expenseamount = $n['expense'];
        $expensedate = $n['expensedate'];
        $expensecategory = $n['expensecategory'];
        $description = $n['description'];
       
    } else {
        echo ("WARNING: AUTHORIZATION ERROR: Trying to Access Unauthorized data");
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $del = true;
    $record = mysqli_query($con, "SELECT * FROM expenses WHERE user_id='$userid' AND expense_id=$id");

    if (mysqli_num_rows($record) == 1) {
        $n = mysqli_fetch_array($record);
        $expenseamount = $n['expense'];
        $expensedate = $n['expensedate'];
        $expensecategory = $n['expensecategory'];
        $slip = $n['slip'];
        $description = $n['description'];
	
    } else {
        echo ("WARNING: AUTHORIZATION ERROR: Trying to Access Unauthorized data");
    }
}
?>
<!doctype html>
<html lang="en">


<!-- Mirrored from codervent.com/dashtreme/demo/vertical/table-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 16 Jun 2022 11:31:27 GMT -->
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
	<link href="assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
	<!-- loader-->
	<link href="assets/css/pace.min.css" rel="stylesheet" />
	<script src="assets/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/bootstrap-extended.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
	<link href="assets/css/app.css" rel="stylesheet">
	<link href="assets/css/icons.css" rel="stylesheet">
	<link href="assets/css/my_style.css" rel="stylesheet">
	
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
				
				<!--end breadcrumb-->
				<div class="row">
					<div class="col-xl-7 mx-auto">
						
						
						<div class="card border-top border-0 border-4 border-white">
							<div class="card-body p-5">
								<div class="card-title d-flex align-items-center">
									<div><i class="lni lni-circle-plus me-1 font-22 text-white"></i>
									</div>
									<h5 class="mb-0 text-white">
											<?php
												if(!empty($slip)){
											
												echo 'Delete Expense';

											
												}else{
													echo 'Add Expense';

												}
											?>
									</h5>
								</div>
								<hr>
								<form class="row g-3" action="" method="POST" enctype='multipart/form-data'>
								
									<div class="col-12">
										<label for="inputPhoneNo" class="form-label">
											
											<?php
												if(!empty($slip)){
											
												echo 'Amount';

											
												}else{
													echo 'Enter Amount';

												}
											?>
										</label>
										<div class="input-group"> <span class="input-group-text">PKR</span>
										
											<?php
												if(!empty($slip)){
											?>

												<input type="number" value="<?php echo $expenseamount; ?>" name="expenseamount" required class="form-control border-start-0" id="inputPhoneNo" placeholder="Enter Amount" disabled/>
													

											<?php
												}else{
											?>
											
												<input type="number" value="<?php echo $expenseamount; ?>" name="expenseamount" required class="form-control border-start-0" id="inputPhoneNo" placeholder="Enter Amount" />
												
											
											<?php
												}
											?>
										
											<!-- <input type="number" value="<?php echo $expenseamount; ?>" name="expenseamount" required class="form-control border-start-0" id="inputPhoneNo" placeholder="Enter Amount" /> -->
										
										</div>
									</div>
									<div class="col-12">
										<label for="inputPhoneNo" class="form-label">Date</label>
										<div class="input-group"> <span class="input-group-text"><i class='lni lni-calendar' ></i></span>
											
												
											<?php
												if(!empty($slip)){
											?>

												<input type="Date" class="form-control border-start-0" value="<?php echo $expensedate; ?>" name="expensedate" id="inputPhoneNo" disabled/>
													

											<?php
												}else{
											?>
											
												<input type="Date" class="form-control border-start-0" value="<?php echo $expensedate; ?>" name="expensedate" id="inputPhoneNo" />
												
											
											<?php
												}
											?>
											<!-- <input type="Date" class="form-control border-start-0" value="<?php echo $expensedate; ?>" name="expensedate" id="inputPhoneNo" /> -->
										</div>
									</div>

									<div class="col-12">

											<?php
												if(!empty($slip)){
													
											?>

													
												<div class="form-check">
													<input class="form-check-input" type="radio" name="expensecategory" id="expensecategory3" value="<?= $expensecategory ?>" <?php echo $expensecategory ? 'checked' : '' ?>>
													<label class="form-check-label" for="expensecategory3">
														<?= $expensecategory ?>
													</label>
												</div>

												<?php
													}else{
												?>
												
												<div class="form-check">
												<input class="form-check-input" type="radio" name="expensecategory" id="expensecategory3" value="Food" <?php echo ($expensecategory == 'Food') ? 'checked' : '' ?>>
												<label class="form-check-label" for="expensecategory3">
													Food
												</label>
												</div>
												
												<div class="form-check">
												<input class="form-check-input" type="radio" name="expensecategory" id="expensecategory3" value="Builty & Cargo" <?php echo ($expensecategory == 'Builty & Cargo') ? 'checked' : '' ?>>
													<label class="form-check-label" for="expensecategory3">
														Builty & Cargo
													</label>
												</div>
											    <div class="form-check">
													<input class="form-check-input" type="radio" name="expensecategory" id="expensecategory5" value="Roti" <?php echo ($expensecategory == 'Roti') ? 'checked' : '' ?>>
													<label class="form-check-label" for="expensecategory5">
														Roti
													</label>
												</div>
												<div class="form-check">
													<input class="form-check-input" type="radio" name="expensecategory" id="expensecategory5" value="Tea & Milk" <?php echo ($expensecategory == 'Milk') ? 'checked' : '' ?>>
													<label class="form-check-label" for="expensecategory5">
														Tea & Milk
													</label>
												</div>
												<div class="form-check">
													<input class="form-check-input" type="radio" name="expensecategory" id="expensecategory5" value="Guest" <?php echo ($expensecategory == 'Guest') ? 'checked' : '' ?>>
													<label class="form-check-label" for="expensecategory5">
														Guest
													</label>
												</div>
												<div class="form-check">
													<input class="form-check-input" type="radio" name="expensecategory" id="expensecategory5" value="Bike Repairing" <?php echo ($expensecategory == 'Milk') ? 'checked' : '' ?>>
													<label class="form-check-label" for="expensecategory5">
														Bike Repairing
													</label>
												</div>
												<div class="form-check">
													<input class="form-check-input" type="radio" name="expensecategory" id="expensecategory5" value="Petrol" <?php echo ($expensecategory == 'Petrol') ? 'checked' : '' ?>>
													<label class="form-check-label" for="expensecategory5">
														Petrol
													</label>
												</div>
												<div class="form-check">
													<input class="form-check-input" type="radio" name="expensecategory" id="expensecategory5" value="Gas" <?php echo ($expensecategory == 'Gas') ? 'checked' : '' ?>>
													<label class="form-check-label" for="expensecategory5">
														Gas
													</label>
												</div>
												
												<div class="form-check">
													<input class="form-check-input" type="radio" name="expensecategory" id="expensecategory5" value="Kitchen Accessories" <?php echo ($expensecategory == 'Kitchen Accessories') ? 'checked' : '' ?>>
													<label class="form-check-label" for="expensecategory5">
														Kitchen Accessories
													</label>
												</div>
												
												<div class="form-check">
													<input class="form-check-input" type="radio" name="expensecategory" id="expensecategory5" value="Packing Matariel" <?php echo ($expensecategory == 'Packing Matariel') ? 'checked' : '' ?>>
													<label class="form-check-label" for="expensecategory5">
														Packing Matariel
													</label>
												</div>
												<div class="form-check">
													<input class="form-check-input" type="radio" name="expensecategory" id="expensecategory5" value="Others" <?php echo ($expensecategory == 'Others') ? 'checked' : '' ?>>
													<label class="form-check-label" for="expensecategory5">
														Others
													</label>
												</div>
											<?php
												}
											?>
									
                                        
									</div>
									

									<div class="col-12">
										<label for="inputPhoneNo" class="form-label">Slip</label>
										<div class="input-group"> 

											<?php
												if(!empty($slip)){
											?>

												<input type="text" name='slip' value="<?php echo $slip; ?>" class="form-control border-start-0" id="inputPhoneNo" placeholder="Enter Amount" disabled/>

												<img src="uploads/<?php echo $slip; ?>" height='68px' width='88px' alt="">

											<?php
												}else{
											?>
											
											
											<input type="file" name='file' required class="form-control border-start-0" id="inputPhoneNo" placeholder="Enter Amount" />
										
											<?php
												}
											?>
										</div>
									</div>


									<div class="col-12">
										<label for="inputPhoneNo" class="form-label">Remarks</label>
										<div class="input-group">										
												
											<?php
												if(!empty($slip)){
											?>

												<textarea name="desc" id="" cols="30" rows="5" placeholder="Enter Description"><?php echo $description; ?></textarea>	

											<?php
												}else{
											?>
											
												<textarea name="desc" id="" cols="30" rows="5" placeholder="Enter Description" required><?php if(!empty($description)){echo $description;}?></textarea>	


											
											<?php
												}
											?>
											<!-- <input type="Date" class="form-control border-start-0" value="<?php echo $expensedate; ?>" name="expensedate" id="inputPhoneNo" /> -->
										</div>
									</div>
									
									<div class="col-12 mt-4">
									<?php if ($update == true) : ?>
										<button  type="submit" name="update" class="btn btn-light px-5">Update</button>
                                        <!-- <button class="btn btn-lg btn-block btn-warning" style="border-radius: 0%;" type="submit" name="update">Update</button> -->
                                    <?php elseif ($del == true) : ?>
										<button type="submit" name="delete" class="btn btn-light px-5">Delete</button>

                                        <!-- <button class="btn btn-lg btn-block btn-danger" style="border-radius: 0%;" type="submit" name="delete">Delete</button> -->
                                    <?php else : ?>
										<button type="submit" name="add" class="btn btn-light px-5">Add Expense</button>
										<?=$msg;?>

                                        <!-- <button type="submit" name="add" class="btn btn-lg btn-block btn-success" style="border-radius: 0%;">Add Expense</button> -->
                                    <?php endif ?>
										
									</div>
								</form>
							</div>
						</div>
					
					</div>
				</div>
				<!--end row-->
				
				<!--end row-->
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
	<script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
	<script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
	
	
	<!-- <script>
		$(document).ready(function() {
			$('#example').DataTable(
			  
			  );
			$("div.dataTables_filter input").focus();
		  } );
	</script> -->
	
	
	<script>
	  
	  $(document).ready(function() {
	  $('#example').DataTable()
	});
	  
	</script>
	
	
	<script>
		$(document).ready(function() {
			var table = $('#example2').DataTable( {
				lengthChange: false,
				buttons: [ 'copy', 'excel', 'pdf', 'print']
			} );
		 
			table.buttons().container()
				.appendTo( '#example2_wrapper .col-md-6:eq(0)' );
		} );
	</script>
	<!--app JS-->
	<script src="assets/js/app.js"></script>
</body>


<!-- Mirrored from codervent.com/dashtreme/demo/vertical/table-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 16 Jun 2022 11:31:28 GMT -->
</html>