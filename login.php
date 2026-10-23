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

      $sql = "SELECT start_time FROM attendance_record WHERE shift_date = '$current_date' AND start_time != '' && emp_id='$user_id' LIMIT 1";
      $result = mysqli_query($con, $sql);
      $check_attendance = mysqli_fetch_assoc($result);

      if (!empty($check_attendance) && !empty($check_attendance['start_time'])) {
         header("Location: index.php");
         exit;
      } else {
         header("Location: attendance_dashboard.php");
         exit;
      }

    }
    else {
      $errormsg = "Please enter correct email and password.";
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1" />
   <meta name="description" content="Dhothar International" />
   <link rel="icon" href="assets/images/favicon.ico">
   <title>Dhothar International | Login</title>
   <link rel="stylesheet" href="assets/css/custom.css">
   <script src="assets/js/dhothar-theme.js"></script>
</head>
<body class="login-page">
   <div class="dh-login">
      <div class="dh-login-bg" aria-hidden="true">
         <span class="dh-login-orb dh-login-orb-a"></span>
         <span class="dh-login-orb dh-login-orb-b"></span>
         <span class="dh-login-orb dh-login-orb-c"></span>
         <span class="dh-login-grid"></span>
      </div>

      <button type="button" id="dh-theme-toggle" class="dh-theme-toggle dh-login-theme" title="Toggle light / dark" aria-label="Toggle theme">
         <svg class="dh-icon-sun" viewBox="0 0 24 24" aria-hidden="true">
            <circle cx="12" cy="12" r="4"></circle>
            <path d="M12 2v2M12 20v2M4.93 4.93l1.42 1.42M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.42-1.42M17.66 6.34l1.41-1.41"></path>
         </svg>
         <svg class="dh-icon-moon" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M20.2 15.1A8.7 8.7 0 0 1 8.9 3.8 9 9 0 1 0 20.2 15.1Z"></path>
         </svg>
      </button>

      <div class="dh-login-shell">
         <aside class="dh-login-hero">
            <div class="dh-login-hero-inner">
               <img src="dhothar_logo.png" alt="Dhothar International" class="dh-login-logo">
               <p class="dh-login-copy">Sign in to manage cases, attendance, and daily operations.</p>
            </div>
         </aside>

         <section class="dh-login-sheet">
            <h2 class="dh-login-sheet-title">Welcome back</h2>
            <p class="dh-login-sheet-sub">Enter your details to continue</p>

            <?php if ($errormsg !== ''): ?>
               <div class="dh-login-error"><?= htmlspecialchars($errormsg) ?></div>
            <?php endif; ?>

            <form method="post" class="dh-login-form" autocomplete="off">
               <label class="dh-login-label" for="username">Email</label>
               <input type="text" class="dh-login-input" name="email" id="username" placeholder="name@example.com" required>

               <label class="dh-login-label" for="password">Password</label>
               <input type="password" class="dh-login-input" name="password" id="password" placeholder="Your password" required>

               <button type="submit" name="login" class="dh-login-btn">Log In</button>
            </form>
         </section>
      </div>
   </div>
</body>
</html>
