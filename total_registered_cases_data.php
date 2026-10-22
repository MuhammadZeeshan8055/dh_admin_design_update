<?php
/**
 * JSON data for total_registered_cases DataTable (simple + fast).
 * Page shell loads first; rows come in one AJAX call.
 */
include('database/db_connection.php');
include('session.php');

header('Content-Type: application/json; charset=utf-8');

$country_esc = mysqli_real_escape_string($con, $_SESSION['country'] ?? '');
$dateCondition = "";
if (!empty($_GET['date1']) && !empty($_GET['date2'])) {
	$date1 = mysqli_real_escape_string($con, $_GET['date1']);
	$date2 = mysqli_real_escape_string($con, $_GET['date2']);
	$dateCondition = " AND ncd.entry_date BETWEEN '$date1' AND '$date2'";
}

$sql = "SELECT
		ncd.name,
		ncd.fname,
		ncd.pp_no,
		ncd.pp_expiry,
		ncd.tracking_id,
		ncd.new_case_date,
		ncd.date_of_birth,
		ncd.client_age,
		ncd.care_of,
		ncd.mobile_no_1,
		ncd.mobile_no_2,
		ncd.missing_documents,
		ncd.country,
		ncd.apply_date,
		ncd.first_character_expiry,
		ncd.second_character_expiry,
		ncd.online_submission_date,
		ncd.physical_submission_date,
		ncd.work_permit_receiving_date,
		ncd.appointment_date,
		ncd.visa_issue_date,
		ncd.visa_expiry_date,
		ncd.entered_by,
		ncd.updated_by,
		ncd.approved_by,
		ncd.passport_returned_date,
		ncd.status,
		ci.company_name,
		ci.trade,
		ci.miscellaneous
	FROM new_case_details AS ncd
	LEFT JOIN (
		SELECT c1.emp_id, c1.company_name, c1.trade, c1.miscellaneous
		FROM company_info c1
		INNER JOIN (SELECT emp_id, MIN(id) AS id FROM company_info GROUP BY emp_id) c2 ON c1.id = c2.id
	) AS ci ON ncd.id = ci.emp_id
	WHERE ncd.country='$country_esc' $dateCondition";

$res = mysqli_query($con, $sql);
$rows = array();
$i = 0;
$yearLater = strtotime('+1 year');

while ($res && ($row = mysqli_fetch_assoc($res))) {
	$i++;
	$pp = $row['pp_expiry'] ?? '';
	$ppStyle = (!empty($pp) && strtotime($pp) <= $yearLater) ? 'color:red;font-weight:bold;' : '';
	$status = $row['status'] ?? '';
	$btn = ($status === 'Returned') ? 'danger' : 'primary';

	$rows[] = array(
		$i,
		$row['name'] ?? '',
		$row['fname'] ?? '',
		$row['pp_no'] ?? '',
		'<span style="' . $ppStyle . '">' . formatDate($pp) . '</span>',
		$row['tracking_id'] ?? '',
		formatDate($row['new_case_date'] ?? ''),
		formatDate($row['date_of_birth'] ?? ''),
		$row['client_age'] ?? '',
		$row['care_of'] ?? '',
		$row['mobile_no_1'] ?? '',
		$row['mobile_no_2'] ?? '',
		$row['missing_documents'] ?? '',
		$row['country'] ?? '',
		formatDate($row['apply_date'] ?? ''),
		formatDate($row['first_character_expiry'] ?? ''),
		formatDate($row['second_character_expiry'] ?? ''),
		formatDate($row['online_submission_date'] ?? ''),
		formatDate($row['physical_submission_date'] ?? ''),
		formatDate($row['work_permit_receiving_date'] ?? ''),
		formatDate($row['appointment_date'] ?? ''),
		formatDate($row['visa_issue_date'] ?? ''),
		formatDate($row['visa_expiry_date'] ?? ''),
		$row['company_name'] ?? '',
		$row['trade'] ?? '',
		$row['miscellaneous'] ?? '',
		$row['entered_by'] ?? '',
		$row['updated_by'] ?? '',
		$row['approved_by'] ?? '',
		formatDate($row['passport_returned_date'] ?? ''),
		'<button class="btn btn-' . $btn . '">' . htmlspecialchars($status) . '</button>',
	);
}

echo json_encode(array('data' => $rows));
