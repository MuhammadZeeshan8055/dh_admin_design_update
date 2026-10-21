
<?php

include('database/db_connection.php');



$sql = "select * from new_case_details where status like 'Request Delete'";
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






?>
      
