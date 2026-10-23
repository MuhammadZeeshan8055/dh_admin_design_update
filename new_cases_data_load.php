<?php
/**
 * JSON rows for New Case Details DataTable.
 * Same filters as before — page shell loads first.
 */
include('database/db_connection.php');
include('session.php');

$country = $_SESSION['country'] ?? '';
$canUpdate = (($can_update ?? '') === 'on');
$canDelete = (($can_delete ?? '') === 'on');
session_write_close();

header('Content-Type: application/json; charset=utf-8');

$country_esc = mysqli_real_escape_string($con, $country);

$sql = "SELECT
		n.id, n.name, n.fname, n.pp_no, n.pp_expiry, n.tracking_id,
		n.new_case_date, n.date_of_birth, n.client_age, n.care_of,
		n.mobile_no_1, n.mobile_no_2, n.missing_documents, n.country,
		n.apply_date, n.first_character_expiry, n.second_character_expiry,
		n.online_submission_date, n.physical_submission_date,
		n.work_permit_receiving_date, n.appointment_date,
		n.visa_issue_date, n.visa_expiry_date,
		n.entered_by, n.updated_by, n.passport_returned_date, n.status,
		c.company_name, c.trade
	FROM new_case_details n
	LEFT JOIN (
		SELECT c1.emp_id, c1.company_name, c1.trade
		FROM company_info c1
		INNER JOIN (
			SELECT emp_id, MIN(id) AS id FROM company_info GROUP BY emp_id
		) c2 ON c1.id = c2.id
	) c ON c.emp_id = n.id
	WHERE n.country='$country_esc'";

$res = mysqli_query($con, $sql);
$rows = array();
$i = 0;

while ($res && ($row = mysqli_fetch_assoc($res))) {
	$i++;
	$id = (int) $row['id'];
	$status = $row['status'] ?? '';
	$company = $row['company_name'] ?? '';

	$statusClass = ($status === 'Applied') ? 'success' : 'danger';
	$statusHtml = '<button class="btn btn-' . $statusClass . ' btn-sm">' . htmlspecialchars($status) . '</button>';

	if ($status === 'Applied' && $company === '') {
		$statusHtml .= '<br><br><button type="button" class="btn btn-primary btn-sm assign_company" data-id="' . $id . '">Assign Company</button>';
	} elseif ($status === 'Applied') {
		$statusHtml .= '<br><br><button type="button" class="btn btn-primary btn-sm show_company" data-id="' . $id . '">Show Company</button>';
	}

	$cells = array(
		$i,
		$row['name'] ?? '',
		$row['fname'] ?? '',
		$row['pp_no'] ?? '',
		$row['pp_expiry'] ?? '',
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
		$company,
		$row['trade'] ?? '',
		$row['entered_by'] ?? '',
		$row['updated_by'] ?? '',
		formatDate($row['passport_returned_date'] ?? ''),
		$statusHtml,
	);

	if ($canUpdate) {
		$cells[] = '<button type="button" class="btn btn-default btn-sm btn-icon icon-left edit-btn" data-eid="' . $id . '"><i class="entypo-pencil"></i> Edit</button>';
	}
	if ($canDelete) {
		$cells[] = '<button type="button" class="btn btn-danger btn-sm btn-icon icon-left delete-btn" data-id="' . $id . '"><i class="entypo-cancel"></i> Delete</button>';
	}

	$rows[] = $cells;
}

$json = json_encode(array('data' => $rows));
echo ($json === false) ? '{"data":[]}' : $json;
