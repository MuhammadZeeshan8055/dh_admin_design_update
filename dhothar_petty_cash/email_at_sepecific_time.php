<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<?php
  $con = mysqli_connect("localhost","turkishj_daily","YpQz)o%wwo7H","turkishj_daily_expense");
  include('smtp/PHPMailerAutoload.php');
  
  

    // $query_date = date('Y-m-d');
    
    // First day of the month.
    // $first_date= date('Y-m-01', strtotime($query_date)).'<br>';
    
    // Last day of the month.
    // $last_date= date('Y-m-t', strtotime($query_date));
    
    // echo $last_date;
    //  echo $query_date;
    
    
      	
      	
    
//   if($query_date==$query_date){
      
      
       $lastmonth_date 	= date('Y-m-d', strtotime(date('Y-m-')."1 -1 month")).'/'.date('Y-m-t', strtotime(date('Y-m-d')."-1 month"));
      
        list($date1,$date2) = explode('/',$lastmonth_date);
        
         $lastmonth_date 	= date('Y-m-d', strtotime(date('Y-m-')."1 -1 month")).'/'.date('Y-m-t', strtotime(date('Y-m-d')."-1 month"));
      
        list($date1,$date2) = explode('/',$lastmonth_date);
      
        // Date Format: Y/m/d
        $paymentDate = $date1;
        $month = date('F', strtotime($paymentDate));
      
        $food = mysqli_fetch_assoc(mysqli_query($con, "SELECT sum(expense) as sum FROM expenses where expensecategory='food' and (expensedate BETWEEN '$date1' AND '$date2')  and YEAR(expensedate)=YEAR(now())"));
        $builty = mysqli_fetch_assoc(mysqli_query($con, "SELECT sum(expense) as sum FROM expenses where expensecategory='Builty & Cargo' and (expensedate BETWEEN '$date1' AND '$date2') and YEAR(expensedate)=YEAR(now())"));
      	$Other = mysqli_fetch_assoc(mysqli_query($con, "SELECT sum(expense) as sum FROM expenses where expensecategory='Others' and (expensedate BETWEEN '$date1' AND '$date2') and YEAR(expensedate)=YEAR(now())"));
      
      	
    //   	echo $Rent['sum'];
      	
      	$food=$food['sum'];
      	$builty=$builty['sum'];
      	$Other=$Other['sum'];
      
       	$monthly=mysqli_fetch_assoc(mysqli_query($con,"select SUM(expense) as monthly from expenses where (expensedate BETWEEN '$date1' AND '$date2') and YEAR(expensedate)=YEAR(now())"));
										   
										  
// 		echo 'Rs '.number_format($monthly['monthly'], 0, '.', ',');
      
        $this_month=$monthly['monthly'];
      
      	$cash=mysqli_fetch_assoc(mysqli_query($con,"select sum(cash) as cash from cash where (cashdate BETWEEN '$date1' AND '$date2') and YEAR(cashdate)=YEAR(now())"));

// 		echo 'Rs '.number_format($cash['cash'], 0, '.', ',');
		
		$this_cash_received=$cash['cash'];
		
			$cash=mysqli_fetch_assoc(mysqli_query($con,"select sum(cash) as cash from cash where (cashdate BETWEEN '$date1' AND '$date2') and YEAR(cashdate)=YEAR(now())"));

			    $cash_in_hand=$cash['cash'];
	 
				$expenses=mysqli_fetch_assoc(mysqli_query($con,"select sum(expense) as expense from expenses where (expensedate BETWEEN '$date1' AND '$date2') and YEAR(expensedate)=YEAR(now())"));
	 
				$expense=$expenses['expense'];
											   
				$remaining_balance=$cash_in_hand-$expense;
	 
				// echo 'Rs '.number_format($remaining_balance, 0, '.', ',');
				
			
      
    $html='
    
        <h3 style="">Petty Cash Expense Summary</h3>
    
        <table style=" width: 65%; text-align: center;BORDER-RIGHT: #CCCCCC 1px solid; PADDING-RIGHT: 0px; BORDER-TOP: #CCCCCC 1px solid; PADDING-LEFT: 0px; PADDING-BOTTOM: 0px; BORDER-LEFT: #CCCCCC 1px solid; PADDING-TOP: 0px; BORDER-BOTTOM: #CCCCCC 1px solid"
        height=238 width=100 cellSpacing="0" cellPadding="15">
            <tr>
            <thead>
            <tr>
                
                <th style="border:1px solid black">Category</th>
                <th style="border:1px solid black">Expense</th>
            </tr>
            <thead>
            <tbody>
            <tr>
                <td style="border:1px solid black"><b>Food</b></td>
                <td style="border:1px solid black">'.$food.'</td>
            </tr>
             <tr>
                <td style="border:1px solid black"><b>Builty and Cargo</b></td>
                <td style="border:1px solid black">'.$builty.'</td>
            </tr>
            <tr>
                <td style="border:1px solid black"><b>Other</b></td>
                <td style="border:1px solid black">'.$Other.'</td>
            </tr>
            
            
             <tr>
                <td style="border:1px solid black;">
                   <h3>
                       '.$month.' Expense:
                       <br>
                       '.$month.' Cash Received:
                       <br>
                       '.$month.' Remaining Balance:
                   </h3>
                </td>
                <td style="border:1px solid black;"> 
                    '.'Rs '.number_format($monthly['monthly'], 0, '.', ',').' 
                    <br>
                    '.'Rs '.number_format($cash['cash'], 0, '.', ',').' 
                    <br>
                    '.'Rs '.number_format($remaining_balance, 0, '.', ',').' 
                    
                 
                    
                </td>
                
            </tr>
            
        </tbody>
       </table>
    
 
    
    ';
    
                        $date=date('Y-m-d');
     
                        $remaining_amount=mysqli_query($con,"update remaining_balance set amount='$remaining_balance',date='$date' where id='1'");
                       
                    
  
    //  <h3>
    
    //     This Month Expense: '.'Rs '.number_format($monthly['monthly'], 0, '.', ',').' 
    //     <br>
    //     This Month Cash Received: '.'Rs '.number_format($cash['cash'], 0, '.', ',').' 
    //     <br>
    //     Remaining Balance: '.'Rs '.number_format($remaining_balance, 0, '.', ',').' 
    
    // </h3>
    
  
            //   function smtp_mailer($to,$subject, $msg){
            // 	$mail = new PHPMailer(); 
            // // 	$mail->SMTPDebug  = 3;
            // 	$mail->IsSMTP(); 
            // 	$mail->SMTPAuth = true; 
            // 	$mail->SMTPSecure = 'tls'; 
            // 	$mail->Host = "mail.estyler.pk";
            // 	$mail->Port = 25; 
            // 	$mail->IsHTML(true);
            // 	$mail->CharSet = 'UTF-8';
            // 	$mail->Username = "info@estyler.pk";
            // 	$mail->Password = "3RybY}A[EI6r";
            // 	$mail->SetFrom("info@estyler.pk");
            // 	$mail->Subject = $subject;
            // 	$mail->Body =$msg;
            // 	$mail->AddAddress($to);
            // 	$mail->SMTPOptions=array('ssl'=>array(
            // 		'verify_peer'=>false,
            // 		'verify_peer_name'=>false,
            // 		'allow_self_signed'=>false
            // 	));
            // 	if(!$mail->Send()){
            // 		echo $mail->ErrorInfo;
            // 	}else{
            // 		return 'Sent';
            // 	}
            // }

// }

  
    // if($query_date==$query_date){
    
    //   smtp_mailer('rajaarif666@gmail.com','Monthly Report of Office Expense',$html);
    //     smtp_mailer('xabi.mlk@gmail.com','Monthly Report of Office Expense',$html);
    //      smtp_mailer('zunair3003@gmail.com','Monthly Report of Office Expense',$html);
       
        //  smtp_mailer('muhammadzeeshan8055@gmail.com','Monthly Report of Office Expense',$html);
        
   
    // }

?>