<?php
include __DIR__ . '/../database/db_connection.php';

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$file_ext_name = 'xlsx';
$fileName = "Dhothar_PP_Expiry_2_months_before";

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A1', 'Name');
$sheet->setCellValue('B1', 'Father Name');
$sheet->setCellValue('C1', 'Passport No');
$sheet->setCellValue('D1', 'Passport Expiry');
$sheet->setCellValue('E1', 'Tracking Id');
$sheet->setCellValue('F1', 'Mobile No');
$sheet->setCellValue('G1', 'Country');
$sheet->setCellValue('H1', 'First character expiry');
$sheet->setCellValue('I1', 'Second character expiry');
$sheet->setCellValue('J1', 'Status');

$rowCount = 2;

$new_cases = "SELECT * FROM new_case_details WHERE physical_submission_date != '' AND physical_submission_date > DATE(NOW()) AND ( ( second_character_expiry IS NOT NULL AND second_character_expiry != '' AND DATE(second_character_expiry) = DATE_ADD(CURDATE(), INTERVAL 60 DAY) ) OR ( (second_character_expiry IS NULL OR second_character_expiry = '') AND first_character_expiry IS NOT NULL AND first_character_expiry != '' AND DATE(first_character_expiry) = DATE_ADD(CURDATE(), INTERVAL 60 DAY) ) ) AND status NOT IN ('Returned', 'Fly')";
$query_run = mysqli_query($con, $new_cases);

if (mysqli_num_rows($query_run) > 0) {
    
    while($row = mysqli_fetch_assoc($query_run)){
        $sheet->setCellValue('A'.$rowCount, $row['name']);
        $sheet->setCellValue('B'.$rowCount, $row['fname']);
        $sheet->setCellValue('C'.$rowCount, $row['pp_no']);
        $sheet->setCellValue('D'.$rowCount, $row['pp_expiry']);
        $sheet->setCellValue('E'.$rowCount, $row['tracking_id']);
        $sheet->setCellValue('F'.$rowCount, $row['mobile_no_1']);
        $sheet->setCellValue('G'.$rowCount, $row['country']);
        $sheet->setCellValue('H'.$rowCount, $row['first_character_expiry']);
        $sheet->setCellValue('I'.$rowCount, $row['second_character_expiry']);
        $sheet->setCellValue('J'.$rowCount, $row['status']);
        
        $rowCount++;
    }
    
    // Save the Excel file
    $writer = new Xlsx($spreadsheet);
    $final_filename = $fileName.'.xlsx';
    $writer->save('pcc_expiry_email_before_2_months/' .$final_filename);
    
    // Send email only when records are found
    require 'PHPMailer/PHPMailerAutoload.php';
    require 'credential.php';

    $mail = new PHPMailer;

    // $mail->SMTPDebug = 4;                               // Enable verbose debug output

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = EMAIL;                              // SMTP username
    $mail->Password = PASS;                               // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    $mail->setFrom(EMAIL, 'Dhothar International');

    // Add all recipients
    $recipients = [
        'muhammadzeeshan8055@gmail.com',
        'anees@dhotharinternational.com',
        'info@dhotharinternational.com',
        'dhotharinternational@gmail.com'
    ];

    foreach ($recipients as $email) {
        $mail->addAddress(trim($email)); // Added trim() to remove any whitespace
    }

    $mail->addReplyTo(EMAIL);

    // Attach the Excel file
    $mail->addAttachment('pcc_expiry_email_before_2_months/' .$final_filename);

    $mail->isHTML(true);                                  // Set email format to HTML

    $recordCount = mysqli_num_rows($query_run);
    $mail->Subject = "Reminder: {$recordCount} Cases PCC Expiry in 60 Days";
    $mail->Body = "<h1>PCC Expiring Within 60 Days</h1><p>Found {$recordCount} cases with PCC expiring within the next 60 days.<br>Please review the attached Excel file and take necessary action if needed.</p>";
    $mail->AltBody = "Found {$recordCount} cases with PCC expiring within the next 60 days. Please check the attached Excel file.";

    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer'       => false,
            'verify_peer_name'  => false,
            'allow_self_signed' => true
        ]
    ];

    if (!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo "Message has been sent - {$recordCount} records found and processed.";
    }
    
} else {
    // No records found - don't send email
    echo "No matching records found. Email not sent.";
}
?>
?>