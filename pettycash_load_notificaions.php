
<?php

include('database/db_connection.php');
include('session.php');



$sql = "select * from new_case_details where status like 'Request%'";
$result = mysqli_query($con, $sql) or die("SQL Query Failed.");
$output = "";
$output2 = "";
if(mysqli_num_rows($result) > 0 ){
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
                <th>Missing Documents</th>
                <th>Apply Date</th>
                
                <th>Entered By</th>
                <th>Status</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>';

                $i=0;
            while($row = mysqli_fetch_assoc($result)){
                $i++;
                $output .= "<tr>
                                <td align='center'>{$i}</td>
                                <td>{$row["name"]} </td>
                                <td>{$row["fname"]} </td>
                                <td>{$row["pp_no"]} </td>
                                <td>{$row["pp_expiry"]} </td>
                                <td>{$row["tracking_id"]} </td>
                                <td>{$row["new_case_date"]} </td>
                                <td>{$row["care_of"]} </td>
                                <td>{$row["missing_documents"]} </td>
                                
                                <td>{$row["apply_date"]} </td>
                                <td>{$row["entered_by"]} </td>
                                <td>
                            ";
                            
                        if($row['status']=='Pending'){

                            $applied='<button class="btn btn-primary btn-sm">'.$row['status'].'</button>';
                            
                        }elseif($row['status']=='Visa Issued'){

                            $applied='<button class="btn btn-success btn-sm">'.$row['status'].'</button>';

                        }
                        elseif($row['status']=='Fly'){

                            $applied='<button class="btn btn-success btn-sm">'.$row['status'].'</button>';

                        }
                         elseif($row['status']=='Returned'){

                            $applied='<button class="btn btn-danger btn-sm">'.$row['status'].'</button>';

                        }else{
                            $applied='<button class="btn btn-danger btn-sm">'.$row['status'].'</button>';

                        }

                $output .= "    
                                {$applied}
                                </td>
                                
                                <td align='center'>
                                    <button class='btn btn-success btn-sm btn-icon icon-left edit-yes' data-eid='{$row["id"]}' data-status='Yes'> <i class='entypo-check'></i> Yes</button>

                                </td>
                                <td align='center'>
                                    <button class='btn btn-danger btn-sm btn-icon icon-left edit-no' data-eid='{$row["id"]}' data-status='No'><i class='entypo-cancel'></i> No</button>

                                   
                                </td>
                            </tr>";
            }
    $output .= "</table>";

    mysqli_close($con);

    echo $output;
}else{
    echo "<h2>No Record Found.</h2>";
}



$conn = mysqli_connect("localhost", "dhothari_cms", "dhothari_cms", "dhothari_petty_cash");
if (mysqli_connect_errno())
{
   echo "Failed to connect to MySQL: " . mysqli_connect_error() ." | Seems like you haven't created the DATABASE with an exact name";
}

// $output2 = "Petty Cash Record";

// $petty_cash = "select * from expenses where expense>=5000 and status='Pending'";
// $result2 = mysqli_query($conn, $petty_cash) or die("SQL Query Failed.");
// if(mysqli_num_rows($result2) > 0 ){
// $output2 = '<table class="table table-bordered datatable table-3" id="table-4">
//             <tr style="background:black;">
//                 <th style="color:white !important">S.no</th>
//                 <th style="color:white !important">Expense</th>
//                 <th style="color:white !important">Expense Category</th>
//                 <th style="color:white !important">Slip</th>
//                 <th style="color:white !important">Approved By</th>
//                 <th style="color:white !important">Description</th>
//                 <th style="color:white !important">Yes</th>
//                 <th style="color:white !important">No</th>
                
//             </tr>';

//                 $i=0;
//             while($row2 = mysqli_fetch_assoc($result2)){
//                 $i++;
//                 $output2 .= "<tr>
//                                 <td align='center'>{$i}</td>
//                                 <td>{$row2["expense"]} </td>
//                                 <td>{$row2["expensecategory"]} </td>
//                                 <td>{$row2["slip"]} </td>
//                                 <td>{$row2["approved_by"]} </td>
//                                 <td>{$row2["description"]} </td>
                                
//                                 <td align='center'>
//                                 <button class='btn btn-success btn-sm btn-icon icon-left entry-yes' data-eid='{$row2["expense_id"]}' data-status='Yes'> <i class='entypo-check'></i> Yes</button>

//                                 </td>
//                                 <td align='center'>
//                                     <button class='btn btn-danger btn-sm btn-icon icon-left entry-no' data-eid='{$row2["expense_id"]}' data-status='No'><i class='entypo-cancel'></i> No</button>

                                
//                                 </td>
                       
//                             </tr>";
//             }
//     $output2 .= "</table>";

//     mysqli_close($conn);

//     echo $output2;
// }else{
//     echo "<h2>No Record Found.</h2>";
// }


?>
      
