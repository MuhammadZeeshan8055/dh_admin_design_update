<?php
include('session.php');
include('attendance_system/database.php');

header('Content-Type: application/json');

try {
    $obj = new Database();
    $action = $_POST['action'] ?? $_GET['action'] ?? '';

    if ($action === 'fetch') {
        $date = $_POST['date'] ?? date('Y-m-d');
        $where = "DATE(created_at) = '" . addslashes($date) . "'";

        $obj->select('daily_visitors', '*', null, $where, 'id DESC', null);
        $result = $obj->getResult();

        // REVERT_POINT: today_visitor_count_start
        $today = date('Y-m-d');
        $today_count = (int) $obj->count('daily_visitors', '*', "DATE(created_at) = '$today'");
        $today_done_count = (int) $obj->count('daily_visitors', '*', "DATE(created_at) = '$today' AND status = 1");
        $today_pending_count = $today_count - $today_done_count;
        // REVERT_POINT: today_visitor_count_end

        echo json_encode([
            'status' => 1,
            'data' => $result ?: [],
            // REVERT_POINT: today_visitor_count_start
            'today_count' => $today_count,
            'today_done_count' => $today_done_count,
            'today_pending_count' => $today_pending_count
            // REVERT_POINT: today_visitor_count_end
        ]);
        exit;
    }

    if ($action === 'lookup') {
        $contact_no = trim($_POST['contact_no'] ?? '');

        if ($contact_no === '') {
            echo json_encode([
                'status' => 1,
                'found' => 0,
                'data' => []
            ]);
            exit;
        }

        $contact_no = addslashes($contact_no);
        $where = "contact_no = '$contact_no'";

        $obj->select('daily_visitors', '*', null, $where, 'created_at DESC', null);
        $result = $obj->getResult();

        echo json_encode([
            'status' => 1,
            'found' => !empty($result) ? 1 : 0,
            'count' => !empty($result) ? count($result) : 0,
            'data' => $result ?: []
        ]);
        exit;
    }

    if ($action === 'create') {
        $name = trim($_POST['name'] ?? '');
        $contact_no = trim($_POST['contact_no'] ?? '');
        $purpose_of_visit = trim($_POST['purpose_of_visit'] ?? '');
        $visitor = trim($_POST['visitor'] ?? '');
        $visit_done = isset($_POST['visit_done']) && $_POST['visit_done'] == '1' ? 1 : 0;

        if ($name === '' || $contact_no === '' || $purpose_of_visit === '' || $visitor === '') {
            echo json_encode([
                'status' => 0,
                'message' => 'Please fill all required fields.'
            ]);
            exit;
        }

        $data = [
            'name' => addslashes(strtoupper($name)),
            'contact_no' => addslashes($contact_no),
            'purpose_of_visit' => addslashes(strtoupper($purpose_of_visit)),
            'visitor' => addslashes(strtoupper($visitor)),
            'status' => $visit_done,
        ];

        $inserted = $obj->insert('daily_visitors', $data);

        if ($inserted) {
            echo json_encode([
                'status' => 1,
                'message' => 'Visitor added successfully.',
                'id' => $obj->lastInsertedId()
            ]);
        } else {
            echo json_encode([
                'status' => 0,
                'message' => 'Failed to add visitor.'
            ]);
        }
        exit;
    }
    
    if ($action === 'update') {
        $id = (int) ($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $contact_no = trim($_POST['contact_no'] ?? '');
        $purpose_of_visit = trim($_POST['purpose_of_visit'] ?? '');
        $visitor = trim($_POST['visitor'] ?? '');
    
        if ($id <= 0) {
            echo json_encode([
                'status' => 0,
                'message' => 'Invalid visitor id.'
            ]);
            exit;
        }
    
        if ($name === '' || $contact_no === '' || $purpose_of_visit === '' || $visitor === '') {
            echo json_encode([
                'status' => 0,
                'message' => 'Please fill all required fields.'
            ]);
            exit;
        }
    
        $data = [
            'name' => addslashes(strtoupper($name)),
            'contact_no' => addslashes($contact_no),
            'purpose_of_visit' => addslashes(strtoupper($purpose_of_visit)),
            'visitor' => addslashes(strtoupper($visitor)),
        ];
    
        $updated = $obj->update('daily_visitors', $data, 'id = ' . $id);
    
        if ($updated) {
            echo json_encode([
                'status' => 1,
                'message' => 'Visitor updated successfully.'
            ]);
        } else {
            echo json_encode([
                'status' => 0,
                'message' => 'Failed to update visitor.'
            ]);
        }
        exit;
    }

    if ($action === 'toggle_visit_done') {
        $id = (int) ($_POST['id'] ?? 0);
        $visit_done = isset($_POST['visit_done']) && $_POST['visit_done'] == '1' ? 1 : 0;

        if ($id <= 0) {
            echo json_encode([
                'status' => 0,
                'message' => 'Invalid visitor id.'
            ]);
            exit;
        }

        $updated = $obj->update('daily_visitors', ['status' => $visit_done], 'id = ' . $id);

        if ($updated) {
            // REVERT_POINT: today_visitor_count_start
            $today = date('Y-m-d');
            $today_count = (int) $obj->count('daily_visitors', '*', "DATE(created_at) = '$today'");
            $today_done_count = (int) $obj->count('daily_visitors', '*', "DATE(created_at) = '$today' AND status = 1");
            $today_pending_count = $today_count - $today_done_count;
            // REVERT_POINT: today_visitor_count_end

            echo json_encode([
                'status' => 1,
                'message' => 'Visit status updated.',
                'visit_done' => $visit_done,
                // REVERT_POINT: today_visitor_count_start
                'today_count' => $today_count,
                'today_done_count' => $today_done_count,
                'today_pending_count' => $today_pending_count
                // REVERT_POINT: today_visitor_count_end
            ]);
        } else {
            echo json_encode([
                'status' => 0,
                'message' => 'Failed to update visit status.'
            ]);
        }
        exit;
    }

    echo json_encode([
        'status' => 0,
        'message' => 'Invalid action.'
    ]);
} catch (Throwable $e) {
    echo json_encode([
        'status' => 0,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
