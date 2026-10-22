<?php

   session_start();
   include('database/db_connection.php');

   $errormsg = "";
   
   function currentDate(){
      return date('Y-m-d');
   }
   $current_date = currentDate();
   

   if (isset($_POST['login'])) {

    $email = stripslashes($_REQUEST['email']);
    $email = mysqli_real_escape_string($con, $email);
    $password = stripslashes($_REQUEST['password']);
    $password = mysqli_real_escape_string($con, $password);
    $query = "SELECT * FROM `users` WHERE email='$email'and (password='" . md5($password) . "') ";
    $result = mysqli_query($con, $query) or die(mysqli_error($con));
    $rows = mysqli_num_rows($result);
    if ($rows == 1) {
        
       $user = mysqli_fetch_assoc($result);
       $user_id = $user['user_id'];

       $_SESSION['login'] = $email;

      // Prepare query
      $sql = "SELECT start_time FROM attendance_record WHERE shift_date = '$current_date' AND start_time != '' && emp_id='$user_id' LIMIT 1";
      $result = mysqli_query($con, $sql);
      $check_attendance = mysqli_fetch_assoc($result);

      // Redirect based on attendance
      if (!empty($check_attendance) && !empty($check_attendance['start_time'])) {
         header("Location: index.php");
         exit;
      } else {
         header("Location: attendance_dashboard.php");
         exit;
      }
      
    }
    else {
      $errormsg  = "<p style='    align-items: center;
      text-align: center;
      padding: 10px 10px 10px 10px;
      background: #992a2a;
      margin-top: 5%;''>Plz Enter Correct Details</p>";
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
      
     
      <title>Dhothar International | Login</title>
      <link rel="stylesheet" href="assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css" id="style-resource-1">
      <link rel="stylesheet" href="assets/css/font-icons/entypo/css/entypo.css" id="style-resource-2">
      <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic" id="style-resource-3">
      <link rel="stylesheet" href="assets/css/bootstrap.css" id="style-resource-4">
      <link rel="stylesheet" href="assets/css/neon-core.css" id="style-resource-5">
      <link rel="stylesheet" href="assets/css/neon-theme.css" id="style-resource-6">
      <link rel="stylesheet" href="assets/css/neon-forms.css" id="style-resource-7">
      <link rel="stylesheet" href="assets/css/custom.css" id="style-resource-8">
      <script src="assets/js/jquery-1.11.3.min.js"></script> 
    </head>
   <body class="page-body login-page login-form-fall" data-url="https://demo.neontheme.com">
      
      <div class="login-container">
         <div class="login-header login-caret">
            <div class="login-content">
                <a href="#" class="logo"> 
                     <img src="dhothar_logo.png" width="100%" alt />  
                    <!--<h2 style="color:white">Dhothar International</h2>-->
                </a> 
              
            </div>
         </div>
        
         <div class="login-form">
            <div class="login-content">
               
               <form method="post" role="form" >
                  <div class="form-group">
                     <div class="input-group">
                        <div class="input-group-addon"> <i class="entypo-user"></i> </div>
                        <input type="text" class="form-control" name="email" id="username" placeholder="email" autocomplete="off" /> 
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="input-group">
                        <div class="input-group-addon"> <i class="entypo-key"></i> </div>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" autocomplete="off" /> 
                     </div>
                  </div>
                  <div class="form-group"> 
                    <button type="submit" name="login" class="btn btn-primary btn-block btn-login"> 
                        <i class="entypo-login"></i>
                     Log In
                     </button> 
                  </div>
                  <p>
																	<?php echo $errormsg ?>
														</p>
               </form>
            </div>
         </div>
      </div>
      <script src="assets/js/gsap/TweenMax.min.js" id="script-resource-1"></script> 
      <script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js" id="script-resource-2"></script> 
      <script src="assets/js/bootstrap.js" id="script-resource-3"></script> 
      <script src="assets/js/joinable.js" id="script-resource-4"></script> 
      <script src="assets/js/resizeable.js" id="script-resource-5"></script> 
      <script src="assets/js/neon-api.js" id="script-resource-6"></script> 
      <script src="assets/js/cookies.min.js" id="script-resource-7"></script> 
      <script src="assets/js/jquery.validate.min.js" id="script-resource-8"></script> 
      <script src="assets/js/neon-login.js" id="script-resource-9"></script>  
      <script src="assets/js/neon-custom.js" id="script-resource-10"></script>  
</body>
</html>