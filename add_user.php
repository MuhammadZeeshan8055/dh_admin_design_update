<?php
include('database/db_connection.php');
include('session.php');


if (isset($_POST['add_new_user'])) {

   $firstname = $_POST['firstname'];
   $lastname = $_POST['lastname'];
   $email = $_POST['email'];
   $password = md5($_POST['password']);
   $can_view = $_POST['can_view'];
   $can_add = $_POST['can_add'];
   $can_update = $_POST['can_update'];
   $can_delete = $_POST['can_delete'];
   $manage_petty_cash = $_POST['manage_petty_cash'];
   $manage_accounts = $_POST['manage_accounts'];

   $profile = 'default_profile.png';

   $date = date('Y-m-d');

   $insert = mysqli_query($con, "insert into users(firstname,lastname,email,profile,password,register_date,only_view,can_add,can_update,can_delete,manage_petty_cash,manage_accounts) 
        values ('$firstname','$lastname','$email','$profile','$password','$date','$can_view','$can_add','$can_update','$can_delete','$manage_petty_cash','$manage_accounts')");

   if ($insert == true) {
      header("location:users");
   } else {
      echo 'Data Not Entered ';
   }
}


if (isset($_GET['id']) && isset($_GET['type'])) {

   $userid = $_GET['id'];
   $type = $_GET['type'];

   if ($type == 'Update') {


      $check = mysqli_query($con, "select * from users where user_id='$userid'");

      if (mysqli_num_rows($check) > 0) {

         $record = "Records Present";

         $user = mysqli_fetch_assoc(mysqli_query($con, "select * from users where user_id='$userid'"));
         $user_info = mysqli_fetch_assoc(mysqli_query($con, "select * from attendance_employee_info where emp_id='$userid'"));

      }


   }

}

if (isset($_POST['update_user'])) {

   $id = $_GET['id'];
   $firstname = $_POST['firstname'];
   $lastname = $_POST['lastname'];
   $email = $_POST['email'];
   $password = trim($_POST['password']);
   $can_view_edit = $_POST['can_view'];
   $can_add_edit = $_POST['can_add'];
   $can_update_edit = $_POST['can_update'];
   $can_delete_edit = $_POST['can_delete'];
   $manage_petty_cash_edit = $_POST['manage_petty_cash'];
   $manage_accounts_edit = $_POST['manage_accounts'];

   $profile = 'default_profile.png';


   $updateSql = "UPDATE users SET 
      firstname='$firstname',
      lastname='$lastname',
      email='$email',
      profile='$profile',
      only_view='$can_view_edit',
      can_add='$can_add_edit',
      can_update='$can_update_edit',
      can_delete='$can_delete_edit',
      manage_petty_cash='$manage_petty_cash_edit',
      manage_accounts='$manage_accounts_edit'
   ";

   if ($password !== '') {
      $hashedPassword = md5($password);
      $updateSql .= ", password='$hashedPassword'";
   }

   $updateSql .= " WHERE user_id='$id'";
   $update_user = mysqli_query($con, $updateSql);

   // ======================================
   // insert data in attendance_employee_info

   $attendance_company_name = $_POST['attendance_company_name'];
   $designation = $_POST['designation'];
   $date_of_joining = $_POST['date_of_joining'];
   $salary = $_POST['salary'];
   $currency = $_POST['currency'];
   $cnic_or_passport = $_POST['cnic_or_passport'];
   $permanent_address = $_POST['permanent_address'];
   $country = $_POST['country'];
   $phone_1 = $_POST['phone_1'];
   $phone_2 = $_POST['phone_2'];
   $bank_name = $_POST['bank_name'];
   $account_title = $_POST['account_title'];
   $iban = $_POST['iban'];


   // Get emp_id from users table (same as $id from GET)
   $emp_id = $id;

   // Check if record exists in attendance_employee_info
   $check_query = mysqli_query($con, "SELECT id FROM attendance_employee_info WHERE emp_id = '$emp_id'");

   if (mysqli_num_rows($check_query) > 0) {
      // Record exists â†’ Update
      $update = mysqli_query($con, "UPDATE attendance_employee_info SET
                  name = '$firstname $lastname',
                  company = '$attendance_company_name',
                  designation = '$designation',
                  date_of_joining = '$date_of_joining',
                  salary = '$salary',
                  currency = '$currency',
                  cnic_passport = '$cnic_or_passport',
                  permanent_address = '$permanent_address',
                  country = '$country',
                  phone_1 = '$phone_1',
                  phone_2 = '$phone_2',
                  bank_name = '$bank_name',
                  account_title = '$account_title',
                  iban = '$iban'
                  WHERE emp_id = '$emp_id'
               ");
   } else {
      // No record â†’ Insert
      $insert = mysqli_query($con, "INSERT INTO attendance_employee_info (
                  emp_id, name, company, designation, date_of_joining, salary, currency,
                  cnic_passport, permanent_address, country, phone_1, phone_2,
                  bank_name, account_title, iban
               ) VALUES (
                  '$emp_id', '$firstname $lastname', '$attendance_company_name', '$designation', '$date_of_joining',
                  '$salary', '$currency', '$cnic_or_passport', '$permanent_address', '$country',
                  '$phone_1', '$phone_2', '$bank_name', '$account_title', '$iban'
               )");
   }


   if ($update_user == true) {
      header("location:users");
   } else {
      echo 'Data Not Entered ';
   }
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

   <title>Dhothar International | Forms</title>
   <link rel="stylesheet" href="assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css" id="style-resource-1">
   <link rel="stylesheet" href="assets/css/font-icons/entypo/css/entypo.css" id="style-resource-2">
   <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic"
      id="style-resource-3">
   <link rel="stylesheet" href="assets/css/bootstrap.css" id="style-resource-4">
   <link rel="stylesheet" href="assets/css/neon-core.css" id="style-resource-5">
   <link rel="stylesheet" href="assets/css/neon-theme.css" id="style-resource-6">
   <link rel="stylesheet" href="assets/css/neon-forms.css" id="style-resource-7">
   <link rel="stylesheet" href="assets/css/custom.css" id="style-resource-8">
   <script src="assets/js/jquery-1.11.3.min.js"></script>
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
            <li class="active"> <strong>Add New User</strong> </li>
         </ol>
         <h2>
            <?php
            if ($record == 'Records Present') {
               ?>

               Update User


               <?php
            } else {
               ?>

               Add New User

               <?php
            }
            ?>
         </h2>
         <br />

         <div class="row">
            <div class="col-md-12">
               <div class="panel panel-primary" data-collapsed="0">
                  <div class="panel-heading">
                     <div class="panel-title">
                        Add New User
                     </div>
                  </div>
                  <div class="panel-body">
                     <div class="row">

                        <?php
                        if ($record == 'Records Present') {
                           ?>

                           <form action="" method="post">

                              <div class="col-md-6">
                                 <label class="col-sm-3 control-label">First Name <span style="color:red">*</span></label>
                                 <input type="hidden" name="id" required value="<?= $user['user_id'] ?>"
                                    class="form-control" placeholder="Enter Name">
                                 <input type="text" name="firstname" required value="<?= $user['firstname'] ?>"
                                    class="form-control" placeholder="Enter Name">
                              </div>
                              <div class="col-md-6">
                                 <label class="col-sm-3 control-label">Last Name <span style="color:red">*</span></label>
                                 <input type="text" name="lastname" required value="<?= $user['lastname'] ?>"
                                    class="form-control" placeholder="Enter Father Name">
                              </div>

                              <div class="clear"></div>
                              <br />

                              <div class="col-md-6">
                                 <label class="col-sm-3 control-label">Email <span style="color:red">*</span></label>
                                 <input type="text" name="email" required value="<?= $user['email'] ?>"
                                    class="form-control" placeholder="Enter Father Name">
                              </div>

                              <div class="clear"></div>
                              <br />

                              <div class="col-md-6">
                                 <label>Password</label>
                                 <input type="password" name="password" class="form-control"
                                    placeholder="Leave blank to keep current password" autocomplete="new-password">
                              </div>



                              <div class="clear"></div>
                              <br />

                              <hr>

                              <div class="col-md-6">
                                 <label class="col-sm-6 control-label">Can View </label>

                                 <?php
                                 if ($user['only_view'] == 'on') {
                                    ?>

                                    <input type="checkbox" value="<?= $user['only_view'] ?>" name="can_view" checked>

                                    <?php
                                 } else {
                                    ?>

                                    <input type="checkbox" name="can_view">

                                    <?php
                                 }
                                 ?>


                              </div>

                              <div class="clear"></div>
                              <br />

                              <hr>

                              <div class="col-md-6">
                                 <label class="col-sm-6 control-label">Can Add </label>

                                 <?php
                                 if (!empty($user['can_add'] == 'on')) {
                                    ?>

                                    <input type="checkbox" name="can_add" value="<?= $user['can_add'] ?>" checked>

                                    <?php

                                 } else {
                                    ?>

                                    <input type="checkbox" name="can_add">

                                    <?php
                                 }
                                 ?>

                              </div>

                              <div class="clear"></div>
                              <br />

                              <hr>

                              <div class="col-md-6">
                                 <label class="col-sm-6 control-label">Can Update </label>

                                 <?php
                                 if (!empty($user['can_update'] == 'on')) {
                                    ?>

                                    <input type="checkbox" name="can_update" value="<?= $user['can_update'] ?>" checked>

                                    <?php

                                 } else {
                                    ?>

                                    <input type="checkbox" name="can_update">

                                    <?php
                                 }
                                 ?>

                              </div>

                              <div class="clear"></div>
                              <br />

                              <hr>

                              <div class="col-md-6">
                                 <label class="col-sm-6 control-label">Can Delete </label>

                                 <?php
                                 if (!empty($user['can_delete'] == 'on')) {
                                    ?>

                                    <input type="checkbox" name="can_delete" value="<?= $user['can_delete'] ?>" checked>

                                    <?php

                                 } else {
                                    ?>

                                    <input type="checkbox" name="can_delete">

                                    <?php
                                 }
                                 ?>

                              </div>

                              <div class="clear"></div>
                              <br />

                              <hr>

                              <div class="col-md-6">
                                 <label class="col-sm-6 control-label">Manage Petty Cash </label>

                                 <?php
                                 if (!empty($user['manage_petty_cash'] == 'on')) {
                                    ?>


                                    <input type="checkbox" name="manage_petty_cash" value="<?= $user['manage_petty_cash'] ?>"
                                       checked>

                                    <?php

                                 } else {
                                    ?>

                                    <input type="checkbox" name="manage_petty_cash">

                                    <?php
                                 }
                                 ?>

                              </div>

                              <div class="clear"></div>
                              <br />

                              <hr>

                              <div class="col-md-6">
                                 <label class="col-sm-6 control-label">Manage Accounts </label>

                                 <?php
                                 if (!empty($user['manage_accounts'] == 'on')) {
                                    ?>


                                    <input type="checkbox" name="manage_accounts" value="<?= $user['manage_accounts'] ?>"
                                       checked>

                                    <?php

                                 } else {
                                    ?>

                                    <input type="checkbox" name="manage_accounts">

                                    <?php
                                 }
                                 ?>


                              </div>


                              <div class="clear"></div>
                              <br />
                              <hr>

                              <div class="col-md-6">
                                 <label class="col-sm-3 control-label">Company</label>
                                 <select name="attendance_company_name" class="form-control">
                                    <?php
                                    $attendance_company = mysqli_query($con, "SELECT * FROM attendance_company");
                                    $selected_company_id = $user_info['company'] ?? '';

                                    while ($company = mysqli_fetch_assoc($attendance_company)) {
                                       $selected = ($company['id'] == $selected_company_id) ? 'selected' : '';
                                       echo '<option value="' . $company['id'] . '" ' . $selected . '>' . $company['company_name'] . '</option>';
                                    }
                                    ?>
                                 </select>
                              </div>

                              <div class="clear"></div>
                              <br />

                              <hr>

                              <div class="col-md-6">
                                 <label class="col-sm-3 control-label">Designation</label>
                                 <input type="text" name="designation" value="<?= $user_info['designation'] ?? '' ?>"
                                    class="form-control" placeholder="Enter Designation">
                              </div>

                              <div class="clear"></div>
                              <br />

                              <hr>

                              <div class="col-md-6">
                                 <label class="col-sm-3 control-label">Date Of Joining </label>
                                 <input type="date" name="date_of_joining"
                                    value="<?= $user_info['date_of_joining'] ?? '' ?>" class="form-control"
                                    placeholder="Enter Date of joining">
                              </div>

                              <div class="clear"></div>
                              <br />
                              <hr>

                              <div class="col-md-6">
                                 <label class="col-sm-3 control-label">Salary</label>
                                 <input type="text" name="salary" value="<?= $user_info['salary'] ?? '' ?>"
                                    class="form-control" placeholder="Enter Salary">
                              </div>

                              <div class="clear"></div>
                              <br />
                              <hr>

                              <div class="col-md-6">
                                 <label class="col-sm-3 control-label">Currency</label>
                                 <input type="text" name="currency" value="<?= $user_info['currency'] ?? '' ?>"
                                    class="form-control" placeholder="Enter Currency">
                              </div>

                              <div class="clear"></div>
                              <br />
                              <hr>

                              <div class="col-md-6">
                                 <label class="col-sm-3 control-label">CNIC Or Passport</label>
                                 <input type="text" name="cnic_or_passport"
                                    value="<?= $user_info['cnic_passport'] ?? '' ?>" class="form-control"
                                    placeholder="Enter Cnic Or Passport">
                              </div>

                              <div class="clear"></div>
                              <br />
                              <hr>

                              <div class="col-md-6">
                                 <label class="col-sm-3 control-label">Permanent Address</label>
                                 <input type="text" name="permanent_address"
                                    value="<?= $user_info['permanent_address'] ?? '' ?>" class="form-control"
                                    placeholder="Enter Permanent Address">
                              </div>

                              <div class="clear"></div>
                              <br />
                              <hr>

                              <div class="col-md-6">
                                 <label class="col-sm-3 control-label">Country</label>
                                 <input type="text" name="country" value="<?= $user_info['country'] ?? '' ?>"
                                    class="form-control" placeholder="Enter Country Name">
                              </div>

                              <div class="clear"></div>
                              <br />
                              <hr>

                              <div class="col-md-6">
                                 <label class="col-sm-3 control-label">Phone 1 </label>
                                 <input type="text" name="phone_1" value="<?= $user_info['phone_1'] ?? '' ?>"
                                    class="form-control" placeholder="Enter Phone 1">
                              </div>

                              <div class="clear"></div>
                              <br />
                              <hr>

                              <div class="col-md-6">
                                 <label class="col-sm-3 control-label">Phone 2</label>
                                 <input type="text" name="phone_2" value="<?= $user_info['phone_2'] ?? '' ?>"
                                    class="form-control" placeholder="Enter Phone 2">
                              </div>

                              <div class="clear"></div>
                              <br />
                              <hr>

                              <div class="col-md-6">
                                 <label class="col-sm-3 control-label">Bank Name</label>
                                 <input type="text" name="bank_name" value="<?= $user_info['bank_name'] ?? '' ?>"
                                    class="form-control" placeholder="Enter Bank Name">
                              </div>
                              <div class="clear"></div>
                              <br />
                              <hr>

                              <div class="col-md-6">
                                 <label class="col-sm-3 control-label">Account Title </label>
                                 <input type="text" name="account_title" value="<?= $user_info['account_title'] ?? '' ?>"
                                    class="form-control" placeholder="Enter Account title">
                              </div>
                              <div class="clear"></div>
                              <br />
                              <hr>

                              <div class="col-md-6">
                                 <label class="col-sm-3 control-label">IBAN</label>
                                 <input type="text" name="iban" value="<?= $user_info['iban'] ?? '' ?>"
                                    class="form-control" placeholder="Enter IBAN number">
                              </div>

                              <div class="clear"></div>
                              <br />

                              <hr>

                              <div class="col-md-12 text-center">
                                 <button type="submit" name="update_user" class="btn btn-success">Update</button>
                              </div>
                           </form>

                           <?php
                        } else {
                           ?>


                           <form action="" method="post">

                              <div class="col-md-6">
                                 <label class="col-sm-3 control-label">First Name <span style="color:red">*</span></label>
                                 <input type="text" name="firstname" required class="form-control"
                                    placeholder="Enter Name">
                              </div>
                              <div class="col-md-6">
                                 <label class="col-sm-3 control-label">Last Name <span style="color:red">*</span></label>
                                 <input type="text" name="lastname" required class="form-control"
                                    placeholder="Enter Father Name">
                              </div>

                              <div class="clear"></div>
                              <br />

                              <div class="col-md-6">
                                 <label class="col-sm-3 control-label">Email <span style="color:red">*</span></label>
                                 <input type="text" name="email" required class="form-control"
                                    placeholder="Enter Father Name">
                              </div>

                              <div class="clear"></div>
                              <br />

                              <div class="col-md-6">
                                 <label class="col-sm-3 control-label">Password <span style="color:red">*</span></label>
                                 <input type="password" name="password" required class="form-control"
                                    placeholder="Enter Password">
                              </div>

                              <div class="clear"></div>
                              <br />

                              <hr>

                              <div class="col-md-6">
                                 <label class="col-sm-6 control-label">Can View </label>
                                 <input type="checkbox" name="can_view">
                              </div>

                              <div class="clear"></div>
                              <br />

                              <hr>

                              <div class="col-md-6">
                                 <label class="col-sm-6 control-label">Can Add </label>
                                 <input type="checkbox" name="can_add">
                              </div>

                              <div class="clear"></div>
                              <br />

                              <hr>

                              <div class="col-md-6">
                                 <label class="col-sm-6 control-label">Can Update </label>
                                 <input type="checkbox" name="can_update">
                              </div>

                              <div class="clear"></div>
                              <br />

                              <hr>

                              <div class="col-md-6">
                                 <label class="col-sm-6 control-label">Can Delete </label>
                                 <input type="checkbox" name="can_delete">
                              </div>

                              <div class="clear"></div>
                              <br />

                              <hr>

                              <div class="col-md-6">
                                 <label class="col-sm-6 control-label">Manage Petty Cash </label>
                                 <input type="checkbox" name="manage_petty_cash">
                              </div>

                              <div class="clear"></div>
                              <br />

                              <hr>

                              <div class="col-md-6">
                                 <label class="col-sm-6 control-label">Manage Accounts </label>
                                 <input type="checkbox" name="manage_accounts">
                              </div>


                              <div class="clear"></div>
                              <br />

                              <div class="col-md-12 text-center">
                                 <button type="submit" name="add_new_user" class="btn btn-success">Add User</button>
                              </div>
                           </form>
                           <?php
                        }
                        ?>

                     </div>
                  </div>
               </div>
            </div>
         </div>
         <?php
         include('components/footer.php');
         ?>
      </div>



   </div>
   <script src="assets/js/gsap/TweenMax.min.js" id="script-resource-1"></script>
   <script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js" id="script-resource-2"></script>
   <script src="assets/js/bootstrap.js" id="script-resource-3"></script>
   <script src="assets/js/joinable.js" id="script-resource-4"></script>
   <script src="assets/js/resizeable.js" id="script-resource-5"></script>
   <script src="assets/js/neon-api.js" id="script-resource-6"></script>
   <script src="assets/js/cookies.min.js" id="script-resource-7"></script>
   <script src="assets/js/bootstrap-switch.min.js" id="script-resource-8"></script>
<script src="assets/js/neon-custom.js" id="script-resource-10"></script>
</body>

</html>

<script>
   document.getElementById('showInput').addEventListener('change', function () {
      var inputContainer = document.getElementById('inputContainer');
      inputContainer.classList.toggle('hidden', !this.checked);
   });
</script>