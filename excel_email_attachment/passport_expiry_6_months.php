<?php
include __DIR__ . '/../database/db_connection.php';

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


    $file_ext_name = 'xlsx';
    $fileName = "Dhothar_PP_Expiry";

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Name');
        $sheet->setCellValue('B1', 'Father Name');
        $sheet->setCellValue('C1', 'Passport No');
        $sheet->setCellValue('D1', 'Passport Expiry');
        $sheet->setCellValue('E1', 'Tracking Id');
        $sheet->setCellValue('F1', 'Mobile No');
        $sheet->setCellValue('G1', 'Country');
        $sheet->setCellValue('H1', 'Status');
        
        $rowCount = 2;
        
            $student = "SELECT * FROM new_case_details WHERE pp_expiry BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 6 MONTH) AND status NOT IN ('Returned', 'Fly')";
            $query_run = mysqli_query($con, $student);
    
           while($row=mysqli_fetch_assoc($query_run)){
               
               
                $sheet->setCellValue('A'.$rowCount, $row['name']);
                $sheet->setCellValue('B'.$rowCount, $row['fname']);
                $sheet->setCellValue('C'.$rowCount, $row['pp_no']);
                $sheet->setCellValue('D'.$rowCount, $row['pp_expiry']);
                $sheet->setCellValue('E'.$rowCount, $row['tracking_id']);
                $sheet->setCellValue('F'.$rowCount, $row['mobile_no_1']);
                $sheet->setCellValue('G'.$rowCount, $row['country']);
                $sheet->setCellValue('H'.$rowCount, $row['status']);
                
                $rowCount++;
            }
            
        
        $writer = new Xlsx($spreadsheet);
            $final_filename = $fileName.'.xlsx';
         
        $writer->save('Passport_expiry_6_months/' .$final_filename);
    
        
        require 'PHPMailer/PHPMailerAutoload.php';
        require 'credential.php';

        $mail = new PHPMailer;

        // $mail->SMTPDebug = 4;                               // Enable verbose debug output

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = EMAIL;                              // SMTP username
        $mail->Password = PASS;                               // SMTP password
        $mail->SMTPSecure = 'tls';                             // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        $mail->setFrom(EMAIL, 'Dhothar International');

        // Add all recipients
        $recipients = [
            'muhammadzeeshan8055@gmail.com',
            'anees@dhotharinternational.com ',
            'info@dhotharinternational.com',
            'dhotharinternational@gmail.com'
        ];

        foreach ($recipients as $email) {
            $mail->addAddress($email);
        }
        
        // $mail->addAddress('muhammadzeeshan8055@gmail.com');                   // Add a recipient

        $mail->addReplyTo(EMAIL);

        // Attach the static Excel file
        $mail->addAttachment('Passport_expiry_6_months/' .$final_filename); // Assuming the file is in the same folder

        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = 'Reminder: Casses Passport Expiry in 6 Months';
        $mail->Body    = '<h1>Passport Expiry Below 6 Months</h1><p>The following Casses have passports expiring within the next 6 months.<br>Please review and take necessary action if needed.</p>';
        $mail->AltBody = 'Testing Message';

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
            echo 'Message has been sent';
        }

?>