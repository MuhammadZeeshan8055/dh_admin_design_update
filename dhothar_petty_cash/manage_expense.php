<?php
include("session.php");
$exp_fetched = mysqli_query($con, "SELECT * FROM expenses WHERE user_id = '$userid' and month(expensedate)=month(now()) order by expense_id desc");
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
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Tables</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Data Table</li>
							</ol>
						</nav>
					</div>
					
				</div>
				<!--end breadcrumb-->
				
				<h6 class="mb-0 text-uppercase">DataTable Import</h6>
				<hr/>
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="example2" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>#</th>
										<th>Date</th>
										<th>Expense Category</th>
										
										<th>Amount</th>
										<th>Slip</th>
										<th>Remarks</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>

									<?php
										$subtotal=0;


										$count=1; while ($row = mysqli_fetch_array($exp_fetched)) { 

											 $total= $row['expense'];

                                            $subtotal+=$total;
        
											
									?>


										<tr>
											<td><?php echo $count;?></td>
											<td>	
												<?php $date= $row['expensedate']; 
													$cls_date = new DateTime($date);
													echo $cls_date->format('d-m-Y');
												?>
											</td>
											<td><?php echo $row['expensecategory']; ?></td>
											<td><?php echo $row['expense']; ?></td>
											<td>
												<!--<img src="uploads/<?php echo $row['slip']; ?>" height='68px' width='88px' alt="">-->
												<a href="http://estyler.pk/petty_cash/uploads/<?php echo $row['slip']; ?>" target="_blank" class="btn"><button style="background: none;color: white;border: 1px solid;"> <small> see image </small></button></a>
													
											</td>
											<td><?php echo $row['description']; ?></td>
											<td>
												<a href="add_expense.php?edit=<?php echo $row['expense_id']; ?>"> <i class="lni lni-pencil-alt" style="font-size: 1.6rem;color: #09de09;"></i> </a>

												<a href="add_expense.php?delete=<?php echo $row['expense_id']; ?> & img=<?php echo $row['slip']; ?>"><i class="lni lni-cross-circle" style="font-size: 1.6rem;color:red"></i></a>
											</td>
										</tr>
									
									<?php $count++; } ?>

									

									
									
								</tbody>

								
								<tr>
										<td></td>
										<td></td>
										<td></td>
										<td>Total: <?php echo $subtotal; ?></td>
										<td></td>
										<td></td>
										<td></td>
										

									</tr>
								
								
							</table>

							

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