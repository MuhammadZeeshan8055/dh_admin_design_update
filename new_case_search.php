<?php
   include('database/db_connection.php');
   include('session.php');
   session_write_close();

    $search_value = $_POST["search"];

    $country = $_SESSION['country'];
    
    $sql = "
    SELECT 
        n.*, 
        c.company_name, 
        c.trade
    FROM new_case_details n
    LEFT JOIN (
        SELECT c1.emp_id, c1.company_name, c1.trade
        FROM company_info c1
        INNER JOIN (
            SELECT emp_id, MIN(id) AS id FROM company_info GROUP BY emp_id
        ) c2 ON c1.id = c2.id
    ) c ON c.emp_id = n.id
    WHERE 
        (n.name LIKE '%{$search_value}%'
        OR n.pp_no LIKE '%{$search_value}%'
        OR n.tracking_id LIKE '%{$search_value}%'
        OR c.company_name LIKE '%{$search_value}%')
        AND n.country = '$country'
    ";

    $result = mysqli_query($con, $sql) or die("SQL Query Failed.");
$output = "";

if(mysqli_num_rows($result) > 0) {
    $output = '<table class="table table-bordered datatable table-3" id="table-4">
                <tr>
                    <th>S.no</th>
                    <th>Name</th>
                    <th>Father Name</th>
                    <th>PP No</th>
                    <th>PP Expiry</th>
                    <th>Tracking Id</th>
                    <th>New Case Date</th>
                    <th>Care Of</th>
                    <th>Mobile No 1</th>
                    <th>Mobile No 2</th>
                    <th>Missing Documents</th>
                    <th>Country</th>
                    <th>Apply Date</th>
                    <th>First Character Expiry</th>
                    <th>Second Character Expiry</th>
                    <th>Online Submission Date</th>
                    <th>Physical Submission Date</th>
                    <th>Work Permit Receiving Date</th>
                    <th>Appointment Date</th>
                    <th>Visa Issue Date</th>
                    <th>Visa Expiry Date</th>
                    <th>Company Name</th>
                    <th>Trade</th>
                    <th>Entered By</th>
                    <th>Updated By</th>
                    <th>Passport Returned Date</th>
                    <th>Status</th>';
                    
    if($can_update == 'on') {
        $output .= '<th>Edit</th><th>Delete</th>';
    }
    $output .= '</tr>';

    $i = 0;
    while($row = mysqli_fetch_assoc($result)) {
        $i++;
        
        // Handle status and buttons
        $statusBtn = '<button class="btn btn-'.($row['status'] == 'Applied' ? 'success' : 'danger').' btn-sm">'.$row['status'].'</button>';
        $assignCompanyBtn = ($row['status'] == 'Applied' && empty($row['company_name']))
            ? '<button class="btn btn-primary btn-sm mt-4" id="assign_company" data-id="'.$row['id'].'">Assign Company</button>'
            : (($row['status'] == 'Applied') ? '<button class="btn btn-primary btn-sm mt-4" id="show_company" data-id="'.$row['id'].'">Show Company</button>' : '');
        
        $output .= "<tr>
                        <td align='center'>{$i}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['fname']}</td>
                        <td>{$row['pp_no']}</td>
                        <td>{$row['pp_expiry']}</td>
                        <td>{$row['tracking_id']}</td>
                        <td>".formatDate($row['new_case_date'])."</td>
                        <td>{$row['care_of']}</td>
                        <td>{$row['mobile_no_1']}</td>
                        <td>{$row['mobile_no_2']}</td>
                        <td>{$row['missing_documents']}</td>
                        <td>{$row['country']}</td>
                        <td>".formatDate($row['apply_date'])."</td>
                        <td>".formatDate($row['first_character_expiry'])."</td>
                        <td>".formatDate($row['second_character_expiry'])."</td>
                        <td>".formatDate($row['online_submission_date'])."</td>
                        <td>".formatDate($row['physical_submission_date'])."</td>
                        <td>".formatDate($row['work_permit_receiving_date'])."</td>
                        <td>".formatDate($row['appointment_date'])."</td>
                        <td>".formatDate($row['visa_issue_date'])."</td>
                        <td>".formatDate($row['visa_expiry_date'])."</td>
                        <td>{$row['company_name']}</td>
                        <td>{$row['trade']}</td>
                        <td>{$row['entered_by']}</td>
                        <td>{$row['updated_by']}</td>
                        <td>".formatDate($row['passport_returned_date'])."</td>
                        <td>{$statusBtn} <br><br> {$assignCompanyBtn}</td>";
                        
        if($can_update == 'on') {
            $output .= "<td align='center'>
                            <button class='btn btn-default btn-sm btn-icon icon-left edit-btn' data-eid='{$row['id']}'>
                                <i class='entypo-pencil'></i> Edit
                            </button>
                        </td>";
        }
        
        if($can_delete == 'on') {
            $output .= "<td align='center'>
                            <button class='btn btn-danger btn-sm btn-icon icon-left delete-btn' data-id='{$row['id']}'>
                                <i class='entypo-cancel'></i> Delete
                            </button>
                        </td>";
        }
        
        $output .= "</tr>";
    }
    $output .= "</table>";
    mysqli_close($con);
    echo $output;
} else {
    echo "<h2>No Record Found.</h2>";
}
?>