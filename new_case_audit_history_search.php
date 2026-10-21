<?php
include('database/db_connection.php');
include('session.php');

if ($userrole != 'Super Admin') {
    header("location:index");
}

// Get the selected case ID from the form
$selectedCaseId = isset($_GET['case_id']) ? intval($_GET['case_id']) : 0;

 $today_date 		= date('Y-m-d').'/'.date('Y-m-d'); 
$yesterday_date 	= date('Y-m-d', strtotime(date('Y-m-d')." -1 day")).'/'.date('Y-m-d', strtotime(date('Y-m-d')." -1 day"));

$last7days_date 	= date('Y-m-d', strtotime(date('Y-m-d')." -6 day")).'/'.date('Y-m-d');
$thismonth_date 	= date('Y-m-d', strtotime(date('Y-m-')."1")).'/'.date('Y-m-t', strtotime(date('Y-m-d')));
$lastmonth_date 	= date('Y-m-d', strtotime(date('Y-m-')."1 -1 month")).'/'.date('Y-m-t', strtotime(date('Y-m-d')."-1 month"));
$thisyear_date 		= date('Y-01-01').'/'.date('Y-12-31');
$lastyear_date 		= date('Y-01-01', strtotime(date('Y-01-01')."-1 year")).'/'.date('Y-12-31', strtotime(date('Y-12-31')."-1 year"));

if($_POST['date']==$today_date){
	$selectOption = "Today";
}	
if($_POST['date']==$yesterday_date){
	$selectOption = "Yesterday";
}	
if($_POST['date']==$last7days_date){
	$selectOption = "Last 7 Days";
}	
if($_POST['date']==$thismonth_date){
	$selectOption = "This Month";
}	
if($_POST['date']==$lastmonth_date){
	$selectOption = "Last Month";
}	
if($_POST['date']==$thisyear_date){
	$selectOption = "This Year";
}	
if($_POST['date']==$lastyear_date){
	$selectOption = "Last Year";
}	
if($_POST['date']==$alltime_date){
	$selectOption = "All Time";
}

if(isset($_POST['date_select'])){
    list($d1, $d2) = explode('/', $_POST['date']); // e.g., "2026-03-04/2026-03-04"
    $date1 = $d1 . ' 00:00:00';
    $date2 = $d2 . ' 23:59:59';
}

// If user selected a custom range
if(isset($_POST['date_range'])){	
    $date1 = $_POST['date1'] . ' 00:00:00';
    $date2 = $_POST['date2'] . ' 23:59:59';
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

    <title>Dhothar International | New Case Audit History</title>
    <link rel="stylesheet" href="assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css"
        id="style-resource-1">
    <link rel="stylesheet" href="assets/css/font-icons/entypo/css/entypo.css" id="style-resource-2">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic"
        id="style-resource-3">
    <link rel="stylesheet" href="assets/css/bootstrap.css" id="style-resource-4">
    <link rel="stylesheet" href="assets/css/neon-core.css" id="style-resource-5">
    <link rel="stylesheet" href="assets/css/neon-theme.css" id="style-resource-6">
    <link rel="stylesheet" href="assets/css/neon-forms.css" id="style-resource-7">
    <link rel="stylesheet" href="assets/css/custom.css" id="style-resource-8">
    <script src="assets/js/jquery-1.11.3.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        .hidden {
            display: none;
        }

        .section-title {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 25px;
            color: #2d3436;
            border-left: 5px solid #007bff;
            padding-left: 10px;
        }

        /* Main container */
        .audit-table-container {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        /* Grouped client block */
        .client-block {
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        /* Client title bar */
        .client-header {
            background: linear-gradient(135deg, #007bff, #00b4ff);
            color: #fff;
            padding: 10px 16px;
            font-size: 15px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Table design */
        .audit-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .audit-table thead {
            background: #f8f9fa;
        }

        .audit-table th,
        .audit-table td {
            padding: 8px 12px;
            border-bottom: 1px solid #eee;
            text-align: left;
            vertical-align: middle;
        }

        .audit-table th {
            font-weight: 600;
            color: #444;
        }

        .audit-table tbody tr:hover {
            background: #f1f9ff;
        }

        /* Change visualization */
        .value-change {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .old-value {
            color: #dc3545;
            font-weight: 500;
        }

        .new-value {
            color: #28a745;
            font-weight: 500;
        }

        .change-arrow {
            color: #6c757d;
            font-size: 13px;
            transition: transform 0.2s ease;
        }

        .value-change:hover .change-arrow {
            transform: translateX(4px);
        }

        /* Subtle alternating row background */
        .audit-table tbody tr:nth-child(even) {
            background-color: #fafafa;
        }

        /* Responsive design */
        @media (max-width: 768px) {

            .audit-table th,
            .audit-table td {
                font-size: 13px;
                padding: 6px 8px;
            }

            .client-header {
                font-size: 14px;
            }
        }

        .mark-read-btn {
            margin-left: auto;
            background: #ffffff22;
            color: #fff;
            border: 1px solid #fff;
            border-radius: 6px;
            padding: 4px 10px;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .mark-read-btn:hover {
            background: #fff;
            color: #007bff;
        }

        .mark-read-btn:disabled {
            background: #d1e7dd;
            color: #198754;
            border-color: #198754;
            cursor: not-allowed;
        }

        .page-body .select2-container {
            display: block;
            width: 100%;
            max-width: 600px;
        }

        .search-form-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
        }

        .clear-search-btn {
            background: #6c757d;
            color: #fff;
            border: none;
            padding: 8px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            margin-left: 10px;
            transition: all 0.3s ease;
        }

        .clear-search-btn:hover {
            background: #5a6268;
        }

        .no-records {
            text-align: center;
            padding: 40px;
            color: #6c757d;
            font-size: 16px;
        }

        .search-controls {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }
    </style>
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
                <li> <a href="../main/index.html">New Case Audit History</a> </li>
                <li class="active"> <strong>New Case Audit History</strong> </li>
            </ol>
            
            <hr>
                 <br>
                <br>
                    
                	<div class="row">
        				<div class="col-12 col-lg-6 col-xl-6 d-flex" >
    					   	<div class="card radius-10 overflow-hidden w-100">
    						  <div class="card-body">
    							<div class="d-flex align-items-center">
    							    <h6>Search Working For Time Period</h6>
    								 <form action="new_case_audit_history_search" method="post">
                    
                                          <table class="table-1">
                                                <tr>
                                                    <td><select class='form-control' name="date"  required >
                                            				<?php if($_POST['date']){?>
                                            					<option value="<?= $_POST['date']; ?>"><?= $selectOption; ?></option>
                                            				<?php }else{ ?>
                                            					<option value=''>Select</option>
                                            				<?php } ?>
                                            					<option value="<?= $today_date; ?>">Today</option>
                                            					<option value="<?= $yesterday_date; ?>">Yesterday</option>
                                            					<option value="<?= $last7days_date; ?>">Last 7 Days</option>
                                            					<option value="<?= $thismonth_date; ?>">This Month</option>
                                            					<option value="<?= $lastmonth_date; ?>">Last Month</option>
                                            					<option value="<?= $thisyear_date; ?>">This Year</option>
                                            					<option value="<?= $lastyear_date; ?>">Last Year</option>
                                            					<option value="<?= $alltime_date; ?>">All Time</option>
                                            				</select>
    				                                    </td>
                                                     <td>   <input type="submit" name="date_select" value="search" id="" class="form-control">
                                
                                                      </td>
                                                </tr>
                                          </table>
                    
                                 
                                    </form>
                        
                            	</div>
                              </div>
    						</div>
    					</div>
    					
    					<div class="col-12 col-lg-6 col-xl-6 d-flex">
    					   <div class="card radius-10 overflow-hidden w-100" >
    						  <div class="card-body">
    							<div class="d-flex align-items-center">
    								 
                                            <h6>Search Working For Time Period</h6>
                                             <form action="new_case_audit_history_search" method="post">
                                            
                                              <table class="table-2">
                                                <tr>
                                                    <td> <input type='date' name='date1' class='form-control' value="<?= $_POST['date1'] ?? ''; ?>"   />
    				                                    </td>
                                                     <td>   <input type='date' name='date2' class='form-control' value="<?= $_POST['date2'] ?? ''; ?>"   />
                                
                                                      </td>
                                                      <td>
                                                          <input type="submit" name="date_range" value="search" id="" class="form-control">
                                    
                                                      </td>
                                                </tr>
                                          </table>
                                          
                                         
                                           
                                              <!--<input type='date' name='date1' class='form-control' value="<?= $_POST['date1']; ?>"   />-->
                                              <!--  	<input type='date' name='date2' class='form-control' value="<?= $_POST['date2']; ?>"   />-->
                                              <!--  <input type="submit" name="date_range" value="search" id="" class="form-control">-->
                                    
                                            
                                            
                                            
                                            </form>
                            	</div>
                              </div>
    						</div>
    					</div>
					
					</div>
                
                <hr>

            <!-- Search Form -->
            <div class="search-form-container">
                <form action="" method="GET">
                    <div class="search-controls">
                        <select name="case_id" id="caseSelect" class="js-example-basic-single form-select border"
                            aria-label="Search cases">
                            <option value="">All Cases (Show All)</option>
                            <?php
                            // Fetch cases from the database
                            $casesQuery = mysqli_query($con, "SELECT id, name, fname, care_of FROM new_case_details ORDER BY name ASC");
                            while ($case = mysqli_fetch_assoc($casesQuery)) {
                                $selected = ($selectedCaseId == $case['id']) ? 'selected' : '';
                                echo '<option value="' . htmlspecialchars($case['id']) . '" ' . $selected . '>'
                                    . htmlspecialchars($case['name'])
                                    . ' | Father: ' . htmlspecialchars($case['fname'])
                                    . ' | C/O: ' . htmlspecialchars($case['care_of'])
                                    . '</option>';
                            }
                            ?>
                        </select>
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="entypo-search"></i> Search
                        </button>

                        <?php if ($selectedCaseId > 0): ?>
                            <a href="?" class="clear-search-btn">
                                <i class="entypo-cancel"></i> Clear Search
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <h3 class="section-title">
                <?php 
                if ($selectedCaseId > 0) {
                    echo "Filtered Audit History";
                } else {
                    echo "New Case Audit History by Client";
                }
                ?>
            </h3>

            <div class="audit-table-container">
                <?php
                // Build the query based on whether a case is selected
                
                $date = date('Y-m-d');
                
                $querySQL = "
                    SELECT 
                        al.*, 
                        nc.id AS case_id, 
                        nc.name AS client_name, 
                        nc.care_of, 
                        u.user_id, 
                        u.firstname, 
                        u.lastname 
                    FROM audit_log AS al 
                    JOIN new_case_details AS nc ON al.record_id = nc.id 
                    JOIN users AS u ON u.user_id = al.user_id 
                    WHERE al.table_name = 'new_case_details' 
                    AND al.viewed = 0 AND al.changed_at between '$date1' and '$date2'
                ";

                // Add filter if a case is selected
                if ($selectedCaseId > 0) {
                    $querySQL .= " AND al.record_id = " . intval($selectedCaseId);
                }

                $querySQL .= " ORDER BY al.record_id, al.changed_at DESC";

                $query = mysqli_query($con, $querySQL);

                // Group data by record_id
                $groupedData = [];
                while ($row = mysqli_fetch_assoc($query)) {
                    $groupedData[$row['record_id']][] = $row;
                }

                // Check if there are any records
                if (empty($groupedData)) {
                    echo '<div class="no-records">';
                    if ($selectedCaseId > 0) {
                        echo '<i class="entypo-info-circled" style="font-size: 48px; display: block; margin-bottom: 15px;"></i>';
                        echo '<strong>No unread audit records found for the selected case.</strong>';
                    } else {
                        echo '<i class="entypo-info-circled" style="font-size: 48px; display: block; margin-bottom: 15px;"></i>';
                        echo '<strong>No unread audit records available.</strong>';
                    }
                    echo '</div>';
                } else {
                    // Display grouped data
                    foreach ($groupedData as $record_id => $entries):
                        $clientName = $entries[0]['client_name'];
                        $careOf = $entries[0]['care_of'];
                        ?>
                        <div class="client-block">
                            <div class="client-header">
                                <i class="entypo-user"></i>
                                <strong><?= htmlspecialchars($clientName); ?></strong>
                                <?php if ($careOf): ?>
                                    <span style="font-weight:400; margin-left:8px; color:#e3f2fd;">(C/O
                                        <?= htmlspecialchars($careOf); ?>)</span>
                                <?php endif; ?>

                                <!-- Mark as Read button -->
                                <button class="mark-read-btn" data-id="<?= $record_id; ?>" data-table="new_case_details">
                                    <i class="entypo-check"></i> <span>Mark as Read</span>
                                </button>
                            </div>

                            <table class="audit-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Updated By</th>
                                        <th>Field</th>
                                        <th>Value Change From <i class="entypo-right-bold"></i> To</th>
                                        <th>Changed At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0;
                                    foreach ($entries as $row):

                                        $prettyFieldName = ucwords(str_replace('_', ' ', $row['field_name']));
                                       
                                        $skipFields = [
                                            'Status Changed By',
                                            'Updated By',
                                            'Updated On',
                                            'Status Updated At'
                                        ];

                                        if (in_array($prettyFieldName, $skipFields)) {
                                            continue; // Skip this row
                                        }

                                        $i++; ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td><?= htmlspecialchars($row['firstname'] . ' ' . $row['lastname']); ?></td>
                                            <td>
                                                <?php
                                                echo htmlspecialchars($prettyFieldName);
                                                ?>
                                            </td>

                                            <td>
                                                <div class="value-change">
                                                    <span class="old-value">
                                                        <?= $row['old_value'] ? htmlspecialchars($row['old_value']) : '<em>New Entry</em>'; ?>
                                                    </span>
                                                    <i class="entypo-right-bold"></i>
                                                    <span class="new-value">
                                                        <?= $row['new_value'] ? htmlspecialchars($row['new_value']) : '<em>—</em>'; ?>
                                                    </span>
                                                </div>
                                            </td>
                                            <td><?= date('d M Y, h:i A', strtotime($row['changed_at'])); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endforeach;
                }
                ?>
            </div>

            <?php include('components/footer.php'); ?>
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
    <script src="assets/js/neon-chat.js" id="script-resource-9"></script>
    <script src="assets/js/neon-custom.js" id="script-resource-10"></script>
    <script src="assets/js/neon-demo.js" id="script-resource-11"></script>
    <link rel="stylesheet" href="assets/js/select2/select2-bootstrap.css" id="style-resource-2">
    <link rel="stylesheet" href="assets/js/select2/select2.css" id="style-resource-3">
    <script src="assets/js/select2/select2.min.js" id="script-resource-9"></script>

    <script>
        $(document).ready(function () {
            // Initialize Select2
            $('.js-example-basic-single').select2({
                placeholder: "Search for a case...",
                allowClear: true
            });
        });

        // Mark as Read functionality
        document.addEventListener("DOMContentLoaded", () => {
            const buttons = document.querySelectorAll(".mark-read-btn");

            buttons.forEach(btn => {
                btn.addEventListener("click", async () => {
                    const recordId = btn.dataset.id;
                    const tableName = btn.dataset.table;

                    try {
                        const response = await fetch("update_viewed", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/x-www-form-urlencoded"
                            },
                            body: `record_id=${encodeURIComponent(recordId)}&table_name=${encodeURIComponent(tableName)}`
                        });

                        const text = await response.text();

                        if (text.trim() === "success") {
                            btn.innerHTML = '<i class="entypo-check"></i> Viewed';
                            btn.disabled = true;
                            btn.closest(".client-block").style.opacity = "0.7";
                        } else {
                            alert("Failed to update. Try again.");
                        }
                    } catch (error) {
                        console.error("Error:", error);
                        alert("Error connecting to server.");
                    }
                });
            });
        });
    </script>
</body>
</html>