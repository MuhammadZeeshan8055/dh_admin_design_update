<script>
(function () {
  try {
    var t = localStorage.getItem('dhothar-theme');
    if (t !== 'light' && t !== 'dark') {
      t = (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) ? 'dark' : 'light';
    }
    document.documentElement.setAttribute('data-theme', t);
  } catch (e) {
    document.documentElement.setAttribute('data-theme', 'light');
  }
})();
</script>
<!-- Sidebar interactions must load with the sidebar, including pages without the shared header. -->
<script src="assets/js/dhothar-theme.js" defer></script>
<?php
if (!isset($_SESSION['country'])) {
   $_SESSION['country'] = 'Romania';
}

// Use the executing script name so query strings and optional .php URLs do not
// break the persistent active state of sidebar items.
$fileName = pathinfo($_SERVER['SCRIPT_NAME'], PATHINFO_FILENAME);

include('database/db_connection.php');

$date = date('Y-m-d');

// Same counts as before — cached ~60s so navigating pages is faster
$returned = dh_cached_row(
   'sidebar_returned_cases',
   "select count(id) as returned_cases from new_case_details where status='Returned' and country='Romania'"
);
$leave_requests = dh_cached_row(
   'sidebar_leave_requests',
   "select count(id) as employee_leaves from employee_leaves where status='Applied'"
);
$account_history = dh_cached_row(
   'sidebar_account_history',
   "select count(id) as pending_account_history from audit_log where table_name='payments' and viewed = 0 AND changed_at LIKE '$date%'"
);
$new_case_details_history = dh_cached_row(
   'sidebar_case_history',
   "select count(id) as pending_new_case_details_history from audit_log where table_name='new_case_details' and viewed = 0 AND changed_at LIKE '$date%'"
);

// Safe defaults if a query fails
if (!is_array($returned)) { $returned = array('returned_cases' => 0); }
if (!is_array($leave_requests)) { $leave_requests = array('employee_leaves' => 0); }
if (!is_array($account_history)) { $account_history = array('pending_account_history' => 0); }
if (!is_array($new_case_details_history)) { $new_case_details_history = array('pending_new_case_details_history' => 0); }

// Helper function to check if menu item is active
function isActive($current, $pages)
{
   $pages = is_array($pages) ? $pages : [$pages];
   return in_array($current, $pages) ? 'active' : '';
}

// Helper function to check if parent menu is active
function isParentActive($current, $pages)
{
   $pages = is_array($pages) ? $pages : [$pages];
   return in_array($current, $pages) ? 'active opened active has-sub root-level' : 'has-sub root-level';
}

// Define page groups
$attendancePages = ['attendance_dashboard', 'attendance_report', 'salary_report', 'leaves', 'leave_requests', 'settings', 'add_leave', 'attendance_marking_issue', 'salary_slip'];
$newCasesPages = ['add_new_case', 'new_cases_details', 'export_new_case_data', 'track_case'];
$protectorPages = ['print_fsa', 'protector', 'print_insurance', 'fsa_print_info'];
$accountsPages = ['clients_list', 'accounts', 'account_analysis_search', 'account_analysis', 'account_tracker', 'miscellaneous_payment', 'refund_analysis'];
?>

<div class="sidebar-menu-inner">
   <header class="logo-env">
      <div class="logo">
         <a href="index">
            <img src="dhothar_logo.png" width="120" alt />
         </a>
      </div>
      <!-- Desktop sidebar collapse is temporarily disabled until the collapsed layout is refined.
      <div class="sidebar-collapse">
         <a href="#" class="sidebar-collapse-icon">
            <i class="entypo-menu"></i>
         </a>
      </div>
      -->
      <div class="sidebar-mobile-menu visible-xs">
         <a href="#" class="with-animation">
            <i class="entypo-menu"></i>
         </a>
      </div>
   </header>

   <ul id="main-menu" class="main-menu">
      <!-- Dashboard -->
      <li class="<?= isActive($fileName, ['index', '/']) ? 'active opened active' : 'opened' ?>">
         <a href="index?country=<?= $_SESSION['country'] ?>">
            <i class="entypo-chart-pie"></i>
            <span class="title">Dashboard</span>
         </a>
      </li>

      <!-- Attendance Menu -->
      <li class="<?= isParentActive($fileName, $attendancePages) ?>">
         <a href="attendance_dashboard">
            <i class="entypo-calendar"></i>
            <span class="title">Attendance</span>
         </a>
         <ul class="">
            <li class="<?= isActive($fileName, 'attendance_dashboard') ?>">
               <a href="attendance_dashboard">
                  <span class="title">Mark Attendance</span>
               </a>
            </li>

            <?php if ($userrole == 'Super Admin'): ?>
               <li class="<?= isActive($fileName, 'attendance_report') ?>">
                  <a href="attendance_report">
                     <span class="title">Attendance Report</span>
                  </a>
               </li>

               <li class="<?= isActive($fileName, 'salary_report') ?>">
                  <a href="salary_report">
                     <span class="title">Salary Report</span>
                  </a>
               </li>

               <li class="<?= isActive($fileName, 'salary_slip') ?>">
                  <a href="salary_slip">
                     <span class="title">Salary Slip</span>
                  </a>
               </li>
            <?php endif; ?>

            <li class="<?= isActive($fileName, ['leaves', 'add_leave']) ?>">
               <a href="leaves">
                  <span class="title">Leave</span>
               </a>
            </li>

            <?php if ($userrole == 'Super Admin'): ?>
               <li class="<?= isActive($fileName, 'leave_requests') ?>">
                  <a href="leave_requests">
                     <span class="title">Leave Requests
                        <?= !empty($leave_requests['employee_leaves']) ? '(' . $leave_requests['employee_leaves'] . ')' : '' ?>
                     </span>
                  </a>
               </li>

               <li class="<?= isActive($fileName, 'attendance_marking_issue') ?>">
                  <a href="attendance_marking_issue">
                     <span class="title">Public Holiday/Other</span>
                  </a>
               </li>

               <li class="<?= isActive($fileName, 'settings') ?>">
                  <a href="settings">
                     <span class="title">Settings</span>
                  </a>
               </li>
            <?php endif; ?>
         </ul>
      </li>

      <!-- Daily Visitors -->
      <li class="<?= isActive($fileName, 'daily_visitors') ? 'active opened active' : 'visible' ?>">
         <a href="daily_visitors">
            <i class="entypo-users"></i>
            <span class="title">Daily Visitors</span>
         </a>
      </li>
      
      <!-- New Cases Menu -->
      <li class="<?= isParentActive($fileName, $newCasesPages) ?>">
         <a href="#">
            <i class="entypo-folder"></i>
            <span class="title">New Cases</span>
         </a>
         <ul class="">
            <?php if ($can_add == 'on'): ?>
               <li class="<?= isActive($fileName, 'add_new_case') ?>">
                  <a href="add_new_case">
                     <span class="title">Add New Case</span>
                  </a>
               </li>
            <?php endif; ?>

            <li class="<?= isActive($fileName, 'new_cases_details') ?>">
               <a href="new_cases_details">
                  <span class="title">Manage New Cases Details</span>
               </a>
            </li>

            <li class="<?= isActive($fileName, 'export_new_case_data') ?>">
               <a href="export_new_case_data">
                  <span class="title">Export New Cases Details</span>
               </a>
            </li>

            <li class="<?= isActive($fileName, 'track_case') ?>">
               <a href="track_case">
                  <span class="title">Track Case</span>
               </a>
            </li>

            <li class="title">
               <a href="import_cases/index">
                  <span class="title">Import Cases</span>
               </a>
            </li>
         </ul>
      </li>

      <!-- New Case Audit History -->
      <?php if ($userrole == 'Super Admin'): ?>

      <li class="<?= isActive($fileName, 'new_case_audit_history') ?>">
         <a href="new_case_audit_history">
            <i class="entypo-back-in-time"></i>
            <span class="title">New Case Audit History
               <?= !empty($new_case_details_history['pending_new_case_details_history']) ? '(' . $new_case_details_history['pending_new_case_details_history'] . ')' : '' ?>
            </span>
         </a>
      </li>

      <?php endif; ?>

      <!-- Country -->
      <li class="<?= isActive($fileName, 'country') ? 'active opened active' : 'visible' ?>">
         <a href="country">
            <i class="entypo-globe"></i>
            <span class="title">Country</span>
         </a>
      </li>
      
      <!-- Care Off List -->
      <li class="<?= isActive($fileName, 'care_off') ? 'active opened active' : 'visible' ?>">
         <a href="care_off">
            <i class="entypo-list"></i>
            <span class="title">Care Off List</span>
         </a>
      </li>

      <!-- Company List -->
      <li class="<?= isActive($fileName, 'company_list') ? 'active opened active' : 'visible' ?>">
         <a href="company_list">
            <i class="entypo-briefcase"></i>
            <span class="title">Company List</span>
         </a>
      </li>

      <!-- Trade -->
      <li class="<?= isActive($fileName, 'trade') ? 'active opened active' : 'visible' ?>">
         <a href="trade">
            <i class="entypo-flow-tree"></i>
            <span class="title">Trade</span>
         </a>
      </li>

      <!-- New Jobs -->
      <li class="<?= isActive($fileName, 'new_jobs') ? 'active opened active' : 'visible' ?>">
         <a href="new_jobs">
            <i class="entypo-suitcase"></i>
            <span class="title">New Jobs</span>
         </a>
      </li>

      <!-- Ledger -->
      <li class="<?= isActive($fileName, 'ledger') ? 'active opened active' : 'visible' ?>">
         <a href="ledger">
            <i class="entypo-book-open"></i>
            <span class="title">Ledger</span>
         </a>
      </li>

      <!-- Protector Menu -->
      <li class="<?= isParentActive($fileName, $protectorPages) ?>">
         <a href="protector">
            <i class="entypo-lock"></i>
            <span class="title">Protector</span>
         </a>
         <ul class="">
            <li class="<?= isActive($fileName, 'protector') ?>">
               <a href="protector">
                  <span class="title">Protector</span>
               </a>
            </li>

            <li class="<?= isActive($fileName, 'print_fsa') ?>">
               <a href="print_fsa">
                  <span class="title">Print Fsa</span>
               </a>
            </li>

            <li class="<?= isActive($fileName, 'print_insurance') ?>">
               <a href="print_insurance">
                  <span class="title">Print Insurance</span>
               </a>
            </li>
         </ul>
      </li>

      <!-- Petty Cash -->
      <?php if ($manage_petty_cash == 'on'): ?>
         <li class="<?= isActive($fileName, 'petty_cash') ? 'active opened active' : 'opened' ?>">
            <a href="petty_cash">
               <i class="entypo-credit-card"></i>
               <span class="title">Petty Cash</span>
            </a>
         </li>
      <?php endif; ?>

      <!-- Notifications -->
      <?php if ($userrole == 'Super Admin'): ?>
         <li class="<?= isActive($fileName, 'notifications') ? 'active opened active' : 'opened' ?>">
            <a href="notifications">
               <i class="entypo-bell"></i>
               <span class="title">Notifications</span>
               <?php if ($fileName == 'notifications'):
                  $check = mysqli_fetch_assoc(mysqli_query($con, "select count(expense_id) as entries_check from expenses where expense>=5000 and status='Pending'"));
                  ?>
                  <span class="badge badge-secondary"><?= $check['entries_check'] ?></span>
               <?php endif; ?>
            </a>
         </li>
      <?php endif; ?>

      <?php if ($userrole == 'Super Admin'): ?>

         <li class="<?= isActive($fileName, 'account_history') ?>">
            <a href="account_history">
               <i class="entypo-clipboard"></i>
               <span class="title">Account Audit History
                  <?= !empty($account_history['pending_account_history']) ? '(' . $account_history['pending_account_history'] . ')' : '' ?>
               </span>
            </a>
         </li>

      <?php endif; ?>

      <!-- Accounts Menu -->
      <?php if ($manage_accounts == 'on'): ?>
         <li class="<?= isParentActive($fileName, $accountsPages) ?>">
            <a href="accounts">
               <i class="entypo-database"></i>
               <span class="title">Accounts</span>
            </a>
            <ul class="">
               <li class="<?= isActive($fileName, ['account_analysis', 'account_analysis_search']) ?>">
                  <a href="account_analysis">
                     <span class="title">Account Analysis</span>
                  </a>
               </li>

               <li class="<?= isActive($fileName, 'refund_analysis') ?>">
                  <a href="refund_analysis">
                     <span class="title">Refund List (<?= $returned['returned_cases'] ?>)</span>
                  </a>
               </li>

               <li class="<?= isActive($fileName, 'clients_list') ?>">
                  <a href="clients_list">
                     <span class="title">Clients List</span>
                  </a>
               </li>

               <li class="<?= isActive($fileName, 'accounts') ?>">
                  <a href="accounts">
                     <span class="title">Accounts</span>
                  </a>
               </li>

               <li class="<?= isActive($fileName, 'account_tracker') ?>">
                  <a href="account_tracker">
                     <span class="title">Account Track</span>
                  </a>
               </li>

               <li class="<?= isActive($fileName, 'miscellaneous_payment') ?>">
                  <a href="miscellaneous_payment">
                     <span class="title">Miscellaneous Payment</span>
                  </a>
               </li>
            </ul>
         </li>
      <?php endif; ?>

      <br><br><br><br>

      <!-- Users -->
      <?php if ($userrole == 'Super Admin'): ?>
         <li class="<?= isActive($fileName, 'users') ? 'active opened active' : 'opened' ?>">
            <a href="users">
               <i class="entypo-users"></i>
               <span class="title">Users</span>
            </a>
         </li>
      <?php endif; ?>
   </ul>
</div>
