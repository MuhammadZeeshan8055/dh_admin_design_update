<?php
/**
 * JSON rows for status_wise_data DataTable.
 * Same filters/JOINs as before — page shell loads first; rows via AJAX.
 */
include('database/db_connection.php');
include('session.php');

header('Content-Type: application/json; charset=utf-8');

$status = isset($_GET['status']) ? trim($_GET['status']) : '';
$country = mysqli_real_escape_string($con, $_SESSION['country'] ?? '');
$status_esc = mysqli_real_escape_string($con, $status);
$canUpdate = (($can_update ?? '') === 'on');
$showFlight = ($status === 'Visa Issued');

$dateCondition = '';
if (!empty($_GET['date1']) && !empty($_GET['date2'])) {
	$date1 = mysqli_real_escape_string($con, $_GET['date1']);
	$date2 = mysqli_real_escape_string($con, $_GET['date2']);
	$dateCondition = " AND ncd.status_updated_at BETWEEN '$date1' AND '$date2'";
}

switch ($status) {
	case 'Yes':
		$where = "ncd.docs_missing = '$status_esc' AND ncd.country = '$country' AND ncd.status NOT IN ('Returned', 'Fly')";
		break;
	case 'passport_returned':
		$where = "ncd.passport_returned = 'Yes' AND ncd.country = '$country' AND ncd.status NOT IN ('Returned', 'Fly') OR ncd.status IS NULL";
		break;
	case 'Total Registered Cases':
		$where = "ncd.country = '$country'";
		break;
	case 'Ready To Apply':
	case 'Applied':
		$where = "ncd.status = '$status_esc' AND ncd.docs_missing != 'Yes' AND ncd.country = '$country'";
		break;
	case 'Returned':
		$where = "(ncd.status = '$status_esc' OR ncd.status='Request Returned') AND ncd.country = '$country'";
		break;
	case 'Work Permit Issued':
		// Same as dashboard card count: Work Permit Issued + Appointment Applied
		$where = "ncd.status IN ('Work Permit Issued', 'Appointment Applied') AND ncd.country = '$country'";
		break;
	case 'Appointment Applied':
		$where = "ncd.status = 'Appointment Applied' AND ncd.country = '$country'";
		break;
	case 'passport_expiry_under_year':
		$where = "ncd.pp_expiry BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 YEAR) AND ncd.country = '$country' AND ncd.status NOT IN ('Returned', 'Fly')";
		break;
	case 'character_expiry':
		$where = "(
			(ncd.second_character_expiry IS NOT NULL AND ncd.second_character_expiry != '' AND ncd.second_character_expiry >= DATE_SUB(ncd.second_character_expiry, INTERVAL 180 DAY) AND ncd.second_character_expiry < NOW())
			OR
			((ncd.second_character_expiry IS NULL OR ncd.second_character_expiry = '') AND ncd.first_character_expiry IS NOT NULL AND ncd.first_character_expiry != '' AND ncd.first_character_expiry >= DATE_SUB(ncd.first_character_expiry, INTERVAL 180 DAY) AND ncd.first_character_expiry < NOW())
		) AND ncd.country = '$country' AND ncd.status NOT IN ('Returned', 'Fly')";
		break;
	case 'passport_expired':
		$where = "ncd.pp_expiry < CURDATE() AND ncd.country = '$country' AND ncd.status NOT IN ('Returned', 'Fly')";
		break;
	default:
		$where = "ncd.status = '$status_esc' AND (ncd.docs_missing = 'No' OR ncd.docs_missing = '') AND ncd.country = '$country'";
		break;
}

function sw_status_action_html($rowStatus, $id) {
	$id = (int) $id;
	$opts = array();
	switch ($rowStatus) {
		case 'Ready To Apply':
			$opts = array('Ready To Apply', 'Applied', 'Returned');
			break;
		case 'Applied':
			$opts = array('Applied', 'Work Permit Issued', 'Ready To Apply', 'Returned');
			break;
		case 'Work Permit Issued':
			$opts = array('Work Permit Issued', 'Appointment Applied', 'Applied', 'Returned');
			break;
		case 'Appointment Applied':
			$opts = array('Appointment Applied', 'Visa Issued', 'Return From Embassy', 'Applied', 'Returned');
			break;
		case 'Return From Embassy':
			$opts = array('Return From Embassy', 'Ready To Apply', 'Applied', 'Work Permit Issued', 'Appointment Applied', 'Returned');
			break;
		case 'Visa Issued':
			$opts = array('Visa Issued', 'Fly', 'Work Permit Issued', 'Returned');
			break;
		case 'Fly':
			$opts = array('Fly', 'Visa Issued', 'Returned');
			break;
		default:
			return '';
	}
	$html = "<form method=\"post\" style=\"margin:0;padding:0;text-align:center;width:100px\">";
	$html .= "<input type=\"hidden\" name=\"getid\" value=\"{$id}\" />";
	$html .= "<select name=\"status\" class=\"form-control\" onchange=\"this.form.submit()\">";
	foreach ($opts as $o) {
		$sel = ($o === $rowStatus) ? ' selected' : '';
		$html .= '<option value="' . htmlspecialchars($o, ENT_QUOTES, 'UTF-8') . '"' . $sel . '>' . htmlspecialchars($o, ENT_QUOTES, 'UTF-8') . '</option>';
	}
	$html .= '</select></form>';
	return $html;
}

$flightSelect = $showFlight
	? ", fd.date_of_dep, fd.airport_name, fd.airline, fd.from_to"
	: ", NULL AS date_of_dep, NULL AS airport_name, NULL AS airline, NULL AS from_to";
$flightJoin = $showFlight
	? "LEFT JOIN (
		SELECT f1.emp_id, f1.date_of_dep, f1.airport_name, f1.airline, f1.from_to
		FROM flight_details f1
		INNER JOIN (SELECT emp_id, MIN(id) AS id FROM flight_details GROUP BY emp_id) f2 ON f1.id = f2.id
	) AS fd ON ncd.id = fd.emp_id"
	: "";

$query = "SELECT
		ncd.id, ncd.name, ncd.fname, ncd.pp_no, ncd.pp_expiry, ncd.tracking_id,
		ncd.new_case_date, ncd.date_of_birth, ncd.client_age, ncd.care_of,
		ncd.mobile_no_1, ncd.mobile_no_2, ncd.missing_documents,
		ncd.passport_returned_description, ncd.passport_returned_date, ncd.country,
		ncd.apply_date, ncd.first_character_expiry, ncd.second_character_expiry,
		ncd.online_submission_date, ncd.physical_submission_date,
		ncd.work_permit_receiving_date, ncd.appointment_date,
		ncd.entered_by, ncd.approved_by, ncd.updated_by, ncd.status,
		p.first_payment,
		ci.company_name, ci.trade, ci.miscellaneous, ci.e_no, ci.visa_no, ci.sponsor_id
		$flightSelect
	FROM new_case_details AS ncd
	LEFT JOIN (
		SELECT emp_id, MAX(first_payment) AS first_payment
		FROM payments
		WHERE first_payment > 0
		GROUP BY emp_id
	) AS p ON ncd.id = p.emp_id
	LEFT JOIN (
		SELECT c1.emp_id, c1.company_name, c1.trade, c1.miscellaneous, c1.e_no, c1.visa_no, c1.sponsor_id
		FROM company_info c1
		INNER JOIN (SELECT emp_id, MIN(id) AS id FROM company_info GROUP BY emp_id) c2 ON c1.id = c2.id
	) AS ci ON ncd.id = ci.emp_id
	$flightJoin
	WHERE $where $dateCondition";

$rows = array();
$i = 0;
$yearLater = strtotime('+1 year');

try {
	$res = mysqli_query($con, $query);
} catch (Throwable $e) {
	echo json_encode(array('data' => array(), 'error' => 'Query failed'));
	exit;
}
if (!$res) {
	echo json_encode(array('data' => array(), 'error' => 'Query failed'));
	exit;
}

while ($row = mysqli_fetch_assoc($res)) {
	$i++;
	$id = (int) $row['id'];
	$hasPayment = !empty($row['first_payment']);
	$companyName = $row['company_name'] ?? '';
	$trade = $row['trade'] ?? '';
	$misc = $row['miscellaneous'] ?? '';
	$hasCompany = ($companyName !== '' && $companyName !== 'Select Company');
	$pp = $row['pp_expiry'] ?? '';
	$ppStyle = (!empty($pp) && strtotime($pp) <= $yearLater) ? 'color:red;font-weight:bold;' : '';
	$rowStatus = $row['status'] ?? '';
	$statusBtn = ($rowStatus === 'Returned') ? 'danger' : 'primary';

	$companyBtn = $hasCompany
		? '<button type="button" class="btn btn-success dh-open-company" data-toggle="modal" data-target="#dhCompanyShowModal"'
			. ' data-id="' . $id . '"'
			. ' data-company="' . htmlspecialchars($companyName, ENT_QUOTES, 'UTF-8') . '"'
			. ' data-trade="' . htmlspecialchars($trade, ENT_QUOTES, 'UTF-8') . '"'
			. ' data-misc="' . htmlspecialchars($misc, ENT_QUOTES, 'UTF-8') . '"'
			. ' data-eno="' . htmlspecialchars($row['e_no'] ?? '', ENT_QUOTES, 'UTF-8') . '"'
			. ' data-visa="' . htmlspecialchars($row['visa_no'] ?? '', ENT_QUOTES, 'UTF-8') . '"'
			. ' data-sponsor="' . htmlspecialchars($row['sponsor_id'] ?? '', ENT_QUOTES, 'UTF-8') . '">Show Company</button>'
		: '<button type="button" class="btn btn-success dh-open-company" data-toggle="modal" data-target="#dhCompanyAssignModal"'
			. ' data-id="' . $id . '"'
			. ' data-company="" data-trade="" data-misc="" data-eno="" data-visa="" data-sponsor="">Assign Company</button>';

	$flightBtn = '';
	if ($showFlight) {
		$hasFlight = !empty($row['date_of_dep']);
		$label = $hasFlight ? 'Show Flight Details' : 'Enter Flight Details';
		$flightBtn = '<button type="button" class="btn btn-primary dh-open-flight" data-toggle="modal" data-target="#dhFlightModal"'
			. ' data-id="' . $id . '"'
			. ' data-dep="' . htmlspecialchars($row['date_of_dep'] ?? '', ENT_QUOTES, 'UTF-8') . '"'
			. ' data-airport="' . htmlspecialchars($row['airport_name'] ?? '', ENT_QUOTES, 'UTF-8') . '"'
			. ' data-airline="' . htmlspecialchars($row['airline'] ?? '', ENT_QUOTES, 'UTF-8') . '"'
			. ' data-route="' . htmlspecialchars($row['from_to'] ?? '', ENT_QUOTES, 'UTF-8') . '">' . $label . '</button>';
	}

	$displayCompany = $hasCompany ? $companyName : '';

	$cells = array(
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
		$row['passport_returned_description'] ?? '',
		$row['passport_returned_date'] ?? '',
		$row['country'] ?? '',
		formatDate($row['apply_date'] ?? ''),
		formatDate($row['first_character_expiry'] ?? ''),
		formatDate($row['second_character_expiry'] ?? ''),
		formatDate($row['online_submission_date'] ?? ''),
		formatDate($row['physical_submission_date'] ?? ''),
		formatDate($row['work_permit_receiving_date'] ?? ''),
		formatDate($row['appointment_date'] ?? ''),
		$row['entered_by'] ?? '',
		$row['approved_by'] ?? '',
		$row['updated_by'] ?? '',
		$displayCompany,
		$trade,
		$misc,
		$companyBtn,
	);

	if ($showFlight) {
		$cells[] = $flightBtn;
	}

	$cells[] = '<button class="btn btn-' . $statusBtn . '">' . htmlspecialchars($rowStatus) . '</button>';

	if ($canUpdate) {
		$cells[] = sw_status_action_html($rowStatus, $id);
	}

	$rowOut = array();
	foreach ($cells as $idx => $val) {
		$rowOut[(string) $idx] = $val;
	}
	if (!$hasPayment) {
		$rowOut['DT_RowAttr'] = array('style' => 'color:red');
	}

	$rows[] = $rowOut;
}

$json = json_encode(array('data' => $rows), JSON_INVALID_UTF8_SUBSTITUTE);
if ($json === false) {
	$json = '{"data":[]}';
}
echo $json;
