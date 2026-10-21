<?php
$country = $_SESSION['country'];


$payment_no_entered_cases = mysqli_fetch_assoc(mysqli_query(
   $con,
   "SELECT count(ncd.id) as payment_no_entered_cases FROM new_case_details AS ncd LEFT JOIN payments AS p ON ncd.id = p.emp_id WHERE ncd.status NOT IN ('Returned', 'Fly', 'Return from Embassy') AND (ncd.missing_documents IS NULL OR ncd.missing_documents = '') AND p.emp_id IS NULL and ncd.country='$_SESSION[country]'"
));

$second_payment_no_entered_cases = mysqli_fetch_assoc(mysqli_query(
   $con,
   "SELECT count(ncd.id) as second_payment_no_entered_cases FROM new_case_details AS ncd LEFT JOIN payments AS p ON ncd.id = p.emp_id WHERE ncd.status NOT IN ('Applied', 'Ready To Apply', 'Returned','Return From Embassy','Appointment Applied','Fly') AND (ncd.missing_documents IS NULL OR ncd.missing_documents = '') AND (p.second_payment IS NULL OR p.second_payment = '') and ncd.country='$_SESSION[country]'"
));

$final_payment_no_entered_cases = mysqli_fetch_assoc(mysqli_query(
   $con,
   "SELECT count(ncd.id) as final_payment_no_entered_cases FROM new_case_details AS ncd LEFT JOIN payments AS p ON ncd.id = p.emp_id WHERE ncd.status IN ('Visa Issued') AND (ncd.missing_documents IS NULL OR ncd.missing_documents = '') AND (p.final_payment IS NULL OR p.final_payment = '') and ncd.country='$_SESSION[country]'"
));

?>

<div class="row dh-app-header">
   <div class="col-md-8 col-sm-8 clearfix">
      <ul class="user-info pull-left pull-none-xsm">
         <li class="profile-info dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">

               <?php
               if ($firstname == "Mam") {


                  ?>

                  <img src="assets/images/f_user.jpg" alt class="img-circle" width="44" />

                  <?php

               } else {
                  ?>

                  <img src="assets/images/user.jpg" alt class="img-circle" width="44" />


                  <?php
               }
               ?>

               <?php echo $firstname . '    ' . $lastname; ?>
            </a>
            <!--<ul class="dropdown-menu">-->
            <!--   <li class="caret"></li>-->
            <!--   <li> -->
            <!--      <a href="#"> <i class="entypo-user"></i>-->
            <!--      Edit Profile-->
            <!--      </a> -->
            <!--   </li>-->
            <!--   <li> <a href="#"> <i class="entypo-mail"></i>-->
            <!--      Inbox-->
            <!--      </a> -->
            <!--   </li>-->
            <!--   <li> <a href="#"> <i class="entypo-calendar"></i>-->
            <!--      Calendar-->
            <!--      </a> -->
            <!--   </li>-->
            <!--   <li> <a href="#"> <i class="entypo-clipboard"></i>-->
            <!--      Tasks-->
            <!--      </a> -->
            <!--   </li>-->
            <!--</ul>-->
         </li>
      </ul>
      <?php
      if ($userrole == 'Super Admin') {
         ?>
         <ul class="user-info pull-left pull-right-xs pull-none-xsm">
            <li class="notifications dropdown">
               <?php
               $check_request = mysqli_fetch_assoc(mysqli_query($con, "select count(id) as requests from new_case_details where status LIKE  'Request Returned'"));
               ?>
               <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                  <i class="entypo-mail"></i> <span class="badge badge-info"><?= $check_request['requests']; ?></span> </a>
               <ul class="dropdown-menu">
                  <li class="top">
                     <?php
                     $check_request = mysqli_fetch_assoc(mysqli_query($con, "select count(id) as requests from new_case_details where status LIKE  'Request Returned'"));
                     ?>
                     <p class="small">
                        You have <strong><?= $check_request['requests']; ?></strong> new notifications.
                     </p>
                  </li>
                  <li>
                     <ul class="dropdown-menu-list scroller" id='requests'>

                        <li class="unread notification-success">
                           <a href="#">

                              <?php
                              $check_request = mysqli_query($con, "select status_changed_by,name,status from new_case_details where status LIKE 'Request Returned'");
                              while ($check = mysqli_fetch_assoc($check_request)) {
                                 ?>

                                 <span class="line">
                                    <strong><b><?= $check['status_changed_by']; ?></b> Request to change
                                       <?= $check['name']; ?>
                                       status to
                                       <?php
                                       if ($check['status'] == 'Request Returned') {

                                          echo 'Returned';
                                       }
                                       ?>
                                    </strong>
                                 </span>
                                 <?php
                              }
                              ?>
                              <!-- <span class="line small">
                                       30 seconds ago
                                       </span>  -->
                           </a>
                        </li>

                     </ul>
                  </li>
                  <li class="external"> <a href="notifications">View all notifications</a> </li>
               </ul>
            </li>


         </ul>

         <ul class="user-info pull-left pull-right-xs pull-none-xsm">
            <li class="notifications dropdown">
               <?php
               $check_request = mysqli_fetch_assoc(mysqli_query($con, "select count(id) as requests from new_case_details where status LIKE  'Request Delete'"));
               ?>
               <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                  <i class="entypo-mail"></i> <span class="badge badge-info"><?= $check_request['requests']; ?></span> </a>
               <ul class="dropdown-menu">
                  <li class="top">
                     <?php
                     $check_request = mysqli_fetch_assoc(mysqli_query($con, "select count(id) as requests from new_case_details where status LIKE  'Request Delete'"));
                     ?>
                     <p class="small">
                        You have <strong><?= $check_request['requests']; ?></strong> new notifications.
                     </p>
                  </li>
                  <li>
                     <ul class="dropdown-menu-list scroller" id='requests'>

                        <li class="unread notification-success">
                           <a href="#">

                              <?php
                              $check_request = mysqli_query($con, "select status_changed_by,name,status from new_case_details where status LIKE 'Request Delete'");
                              while ($check = mysqli_fetch_assoc($check_request)) {
                                 ?>

                                 <span class="line">
                                    <strong><b><?= $check['status_changed_by']; ?></b> Request to Delete Record Of
                                       <?= $check['name']; ?>

                                    </strong>
                                 </span>
                                 <?php
                              }
                              ?>
                              <!-- <span class="line small">
                                       30 seconds ago
                                       </span>  -->
                           </a>
                        </li>

                     </ul>
                  </li>
                  <li class="external"> <a href="delete_notifications">View all notifications</a> </li>
               </ul>
            </li>


         </ul>

         <ul class="user-info pull-left pull-right-xs pull-none-xsm">
            <li class="notifications dropdown">
               <?php
               $check_request = mysqli_fetch_assoc(mysqli_query($con, "SELECT count(id) as appointment_not_applied
                                            FROM new_case_details
                                            WHERE 
                                                (appointment_date IS NULL OR appointment_date = '')
                                                AND work_permit_receiving_date IS NOT NULL 
                                                AND work_permit_receiving_date != ''
                                                AND work_permit_receiving_date <= CURDATE() - INTERVAL 30 DAY AND country = '$country' AND status NOT IN ('Returned','Return From Embassy','Fly')
                                            "));
               ?>
               <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                  <i class="entypo-mail"></i> <span
                     class="badge badge-info"><?= $check_request['appointment_not_applied']; ?></span> </a>
               <ul class="dropdown-menu">
                  <li class="top">
                     <?php
                     $check_request = mysqli_fetch_assoc(mysqli_query($con, "SELECT count(id) as appointment_not_applied
                                            FROM new_case_details
                                            WHERE 
                                                (appointment_date IS NULL OR appointment_date = '')
                                                AND work_permit_receiving_date IS NOT NULL 
                                                AND work_permit_receiving_date != ''
                                                AND work_permit_receiving_date <= CURDATE() - INTERVAL 30 DAY AND country = '$country' AND status NOT IN ('Returned','Return From Embassy','Fly')"));
                     ?>
                     <p class="small">
                        You have <strong><?= $check_request['appointment_not_applied']; ?></strong> new notifications.
                     </p>
                  </li>
                  <li>
                     <ul class="dropdown-menu-list scroller" id='requests'>

                        <li class="unread notification-success">
                           <span>
                              Appointments have not yet been scheduled for these cases, all of which have exceeded 30 days
                              since the work permit receiving date.
                           </span>
                           <a href="#">

                           </a>
                        </li>

                     </ul>
                  </li>
                  <li class="external"> <a href="pending_appointments">View all cases</a> </li>
               </ul>
            </li>


         </ul>

         <ul class="user-info pull-left pull-right-xs pull-none-xsm">
            <li class="notifications dropdown">
               <?php
               $check_payment_hand_over = mysqli_fetch_assoc(mysqli_query($con, "select count(id) as pending from payment_handed_over_to where approved='Pending'"));
               ?>
               <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                  <i class="entypo-bag"></i> <span
                     class="badge badge-info"><?= $check_payment_hand_over['pending']; ?></span> </a>
               <ul class="dropdown-menu">
                  <li class="top">
                     <?php
                     $check_payment_hand_over = mysqli_fetch_assoc(mysqli_query($con, "select count(id) as pending from payment_handed_over_to where approved='Pending'"));
                     ?>
                     <p class="small">
                        You have <strong><?= $check_payment_hand_over['pending']; ?></strong> new notifications.
                     </p>
                  </li>
                  <li>
                     <ul class="dropdown-menu-list scroller" id='requests'>

                        <li class="unread notification-success">
                           <a href="#">

                              <?php
                              $check_payment_hand_over = mysqli_query($con, "select * from payment_handed_over_to where approved='Pending'");
                              while ($check = mysqli_fetch_assoc($check_payment_hand_over)) {

                                 $cash_given_date = $check['given_date'];// Example date in Y-m-d format
                           
                                 $cash_given_Date = date("d-m-Y", strtotime($cash_given_date));


                                 ?>

                                 <span class="line">
                                    <strong><b><?= $check['given_by']; ?></b> given <?= $check['payment']; ?>/euro to
                                       <?= $check['payment_handed_over_to']; ?> on <?= $cash_given_Date; ?>


                                    </strong>
                                 </span>
                                 <?php
                              }
                              ?>
                              <!-- <span class="line small">
                                       30 seconds ago
                                       </span>  -->
                           </a>
                        </li>

                     </ul>
                  </li>
                  <li class="external"> <a href="payment_handed_over_to_notifications">View all notifications</a> </li>
               </ul>
            </li>


         </ul>
         <?php
      }
      ?>

      <style>
         .color-red {
            color: #ffdddd;
            animation: color-blink 1s infinite;
            color: white;
         }

         /* Keyframes for blinking effect */
         @keyframes color-blink {
            0% {
               color: #ffdddd;
            }

            50% {
               color: #ff9999;
            }

            /* darker red */
            100% {
               color: #ffdddd;
            }
         }

         .bg-red {
            background-color: #ffdddd;
            animation: background-blink 1s infinite;
            background-color: white;
         }

         /* Keyframes for blinking effect */
         @keyframes background-blink {
            0% {
               background-color: #ffdddd;
            }

            50% {
               background-color: #ff9999;
            }

            /* darker red */
            100% {
               background-color: #ffdddd;
            }
         }
      </style>

      <?php if ($manage_accounts == 'on'): ?>
         <ul class="user-info pull-left pull-right-xs pull-none-xsm">
            <li class="notifications dropdown">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                  <i class="entypo-bag color-red"></i> <span
                     class="badge badge-info bg-red"><?= $payment_no_entered_cases['payment_no_entered_cases'] ?></span>
               </a>
               <ul class="dropdown-menu">
                  <li class="top">
                     <p class="small">
                        You have <strong><?= $payment_no_entered_cases['payment_no_entered_cases'] ?></strong> new
                        notifications.
                     </p>
                  </li>
                  <li>
                     <ul class="dropdown-menu-list scroller" id='requests'>

                        <?php

                        $country = mysqli_real_escape_string($con, $_SESSION['country']);

                        $payment_check = mysqli_query($con, "
                           SELECT ncd.id, ncd.name, ncd.care_of, ncd.status FROM new_case_details AS ncd LEFT JOIN payments AS p ON ncd.id = p.emp_id WHERE ncd.status NOT IN ('Returned', 'Fly', 'Return from Embassy') AND (ncd.missing_documents IS NULL OR ncd.missing_documents = '')
                           AND p.emp_id IS NULL
                           AND ncd.country = '$country'
                        ");

                        while ($payment_not_enter = mysqli_fetch_assoc($payment_check)) {
                           ?>
                           <li class="unread notification-success"
                              style="display:flex;align-items:center;justify-content:space-between;margin: 0 10px 0 10px">
                              <?= $payment_not_enter['name']; ?> c/o <?= $payment_not_enter['care_of']; ?>
                              <a href="add_payment.php?id=<?= $payment_not_enter['id']; ?>" target="_blank"
                                 class="btn btn-success" style="color:white">
                                 ADD
                              </a>
                           </li>
                           <?php
                        }

                        ?>



                     </ul>
                  </li>
               </ul>
            </li>


         </ul>
         <ul class="user-info pull-left pull-right-xs pull-none-xsm">
            <li class="notifications dropdown">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                  <i class="entypo-bag color-red"></i> <span
                     class="badge badge-info bg-red"><?= $second_payment_no_entered_cases['second_payment_no_entered_cases'] ?></span>
               </a>
               <ul class="dropdown-menu">
                  <li class="top">
                     <p class="small">
                        You have <strong><?= $second_payment_no_entered_cases['second_payment_no_entered_cases'] ?></strong> new
                        notifications.
                     </p>
                  </li>
                  <li>
                     <ul class="dropdown-menu-list scroller" id='requests'>

                        <?php

                        $country = mysqli_real_escape_string($con, $_SESSION['country']);

                        $second_payment_check = mysqli_query($con, "
                           SELECT ncd.id, ncd.name, ncd.care_of, ncd.status FROM new_case_details AS ncd LEFT JOIN payments AS p ON ncd.id = p.emp_id WHERE ncd.status NOT IN ('Applied', 'Ready To Apply', 'Returned','Return From Embassy','Appointment Applied','Fly') AND (ncd.missing_documents IS NULL OR ncd.missing_documents = '') AND (p.second_payment IS NULL OR p.second_payment = '') and ncd.country = '$country'
                        ");

                        while ($second_payment_not_enter = mysqli_fetch_assoc($second_payment_check)) {
                           ?>
                           <li class="unread notification-success"
                              style="display:flex;align-items:center;justify-content:space-between;margin: 0 10px 0 10px">
                              <?= $second_payment_not_enter['name']; ?> c/o <?= $second_payment_not_enter['care_of']; ?>
                              <a href="add_payment.php?id=<?= $second_payment_not_enter['id']; ?>" target="_blank"
                                 class="btn btn-success" style="color:white">
                                 ADD
                              </a>
                           </li>
                           <?php
                        }

                        ?>



                     </ul>
                  </li>
               </ul>
            </li>


         </ul>
         <ul class="user-info pull-left pull-right-xs pull-none-xsm">
            <li class="notifications dropdown">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                  <i class="entypo-bag color-red"></i> <span
                     class="badge badge-info bg-red"><?= $final_payment_no_entered_cases['final_payment_no_entered_cases'] ?></span>
               </a>
               <ul class="dropdown-menu">
                  <li class="top">
                     <p class="small">
                        You have <strong><?= $final_payment_no_entered_cases['final_payment_no_entered_cases'] ?></strong> new
                        notifications.
                     </p>
                  </li>
                  <li>
                     <ul class="dropdown-menu-list scroller" id='requests'>

                        <?php

                        $country = mysqli_real_escape_string($con, $_SESSION['country']);

                        $final_payment_check = mysqli_query($con, "
                           SELECT ncd.id, ncd.name, ncd.care_of, ncd.status FROM new_case_details AS ncd LEFT JOIN payments AS p ON ncd.id = p.emp_id WHERE ncd.status IN ('Visa Issued') AND (ncd.missing_documents IS NULL OR ncd.missing_documents = '') AND (p.final_payment IS NULL OR p.final_payment = '') and ncd.country = '$country'
                        ");

                        while ($final_payment_not_enter = mysqli_fetch_assoc($final_payment_check)) {
                           ?>
                           <li class="unread notification-success"
                              style="display:flex;align-items:center;justify-content:space-between;margin: 0 10px 0 10px">
                              <?= $final_payment_not_enter['name']; ?> c/o <?= $final_payment_not_enter['care_of']; ?>
                              <a href="add_payment.php?id=<?= $final_payment_not_enter['id']; ?>" target="_blank"
                                 class="btn btn-success" style="color:white">
                                 ADD
                              </a>
                           </li>
                           <?php
                        }

                        ?>



                     </ul>
                  </li>
               </ul>
            </li>


         </ul>
      <?php endif; ?>

   </div>
   <div class="col-md-4 col-sm-4 clearfix hidden-xs">
      <ul class="list-inline links-list pull-right">
         <li>
            <button type="button" id="dh-theme-toggle" class="dh-theme-toggle" title="Toggle light / dark" aria-label="Toggle theme">
               <svg class="dh-icon-sun" viewBox="0 0 24 24" aria-hidden="true">
                  <circle cx="12" cy="12" r="4"></circle>
                  <path d="M12 2v2M12 20v2M4.93 4.93l1.42 1.42M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.42-1.42M17.66 6.34l1.41-1.41"></path>
               </svg>
               <svg class="dh-icon-moon" viewBox="0 0 24 24" aria-hidden="true">
                  <path d="M20.2 15.1A8.7 8.7 0 0 1 8.9 3.8 9 9 0 1 0 20.2 15.1Z"></path>
               </svg>
            </button>
         </li>
         <li class="dropdown language-selector">
            Country: &nbsp;
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-close-others="true">
               <?php

               $country_list = mysqli_query($con, "select * from country where country_name='$country'");

               while ($check_countries = mysqli_fetch_assoc($country_list)) {

                  echo '<img src="assets/images/flags/' . $check_countries['flag_img'] . '" width="16" height="16" />';

               }
               ?>

            </a>
            <ul class="dropdown-menu pull-right">

               <?php

               $country_list = mysqli_query($con, "select * from country");

               while ($check_countries = mysqli_fetch_assoc($country_list)) {
                  $countryName = $check_countries['country_name'];
                  ?>
                  <li class="<?= $countryName === $country ? 'active' : '' ?>">
                     <a href="index?country=<?= urlencode($countryName) ?>">
                        <img src="assets/images/flags/<?= htmlspecialchars($check_countries['flag_img'], ENT_QUOTES, 'UTF-8') ?>"
                           width="16" height="16" alt="" />
                        <span><?= htmlspecialchars($countryName, ENT_QUOTES, 'UTF-8') ?></span>
                     </a>
                  </li>

                  <?php
               }
               ?>
               <!--<li class="active"> <a href="index?country=Romania"> <img src="assets/images/flags/romania.jpg" width="16" height="16" /> <span>Romania</span> </a> </li>-->
               <!--<li> <a href="index?country=Saudi Arabia"> <img src="assets/images/flags/saudi.jpg" width="16" height="16" /> <span>Saudi Arabia</span> </a> </li>-->
               <!--<li> <a href="index?country=UAE"> <img src="assets/images/flags/uae.jpg" width="16" height="16" /> <span>UAE</span> </a> </li>-->
               <!--<li> <a href="index?country=Qatar"> <img src="assets/images/flags/qatar.jpg" width="16" height="16" /> <span>Qatar</span> </a> </li>-->
               <!--<li> <a href="index?country=Oman"> <img src="assets/images/flags/oman.jpg" width="16" height="16" /> <span>Oman</span> </a> </li>-->
               <!--<li> <a href="index?country=Bahrain"> <img src="assets/images/flags/bahrain.jpg" width="16" height="16" /> <span>Bahrain</span> </a> </li>-->
               <!--<li> <a href="index?country=Miscellaneous"> <img src="assets/images/flags/" width="16" height="16" /> <span>Miscellaneous</span> </a> </li>-->
               <!--<li> <a href="index?country=Albaniya"> <img src="assets/images/flags/albania.jpg" width="16" height="16" /> <span>Albaniya</span> </a> </li>-->
            </ul>
         </li>


         <li class="sep"></li>
         <li> <a href="logout">
               Log Out <i class="entypo-logout right"></i> </a>
         </li>
      </ul>
   </div>
</div>

<style>
   button#dismiss-btn {
      background: none;
      border: none;
   }
</style>

<?php if ($manage_accounts == 'on'): ?>
   <div id="payment-alert" style="position: relative; width: 60%;">
        <div class="marquee">
          <span>
            <?= $payment_no_entered_cases['payment_no_entered_cases'] ?> cases are pending their first payment |
            <?= $second_payment_no_entered_cases['second_payment_no_entered_cases'] ?> cases are pending their Second payment |
            <?= $final_payment_no_entered_cases['final_payment_no_entered_cases'] ?> cases are pending their Final payment. Kindly review and enter the payment accordingly.
          </span>
        </div>
        
        <style>
            .marquee {
              width: 100%;
              overflow: hidden;
              background: #fff;
              color: red;
              font-size: 16px;
              white-space: nowrap;
              box-sizing: border-box;
              padding: 5px 0;
            }
            
            .marquee span {
              display: inline-block;
              padding-left: 100%;
              animation: marquee 15s linear infinite;
            }
            
            .marquee:hover span {
              animation-play-state: paused; /* stops on hover */
            }
            
            @keyframes marquee {
              0% { transform: translateX(0); }
              100% { transform: translateX(-100%); }
            }
        </style>
        <button id="dismiss-btn" style="position: absolute; right: 0; top: 0;">✖</button>
   </div>

   <script>
      // Helper functions for cookies
      function setCookie(name, value, hours) {
         const d = new Date();
         d.setTime(d.getTime() + (hours * 60 * 60 * 1000));
         document.cookie = name + "=" + value + ";expires=" + d.toUTCString() + ";path=/";
      }

      function getCookie(name) {
         const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
         return match ? match[2] : null;
      }

      const alertDiv = document.getElementById('payment-alert');
      const dismissBtn = document.getElementById('dismiss-btn');

      // Hide alert if cookie exists
      if (getCookie('dismiss_payment_alert')) {
         alertDiv.style.display = 'none';
      }

      // On click, set cookie for 4 hours and hide
      dismissBtn.addEventListener('click', () => {
         setCookie('dismiss_payment_alert', '1', 4); // 4 hours
         alertDiv.style.display = 'none';
      });
   </script>
<?php endif; ?>
