
<?php

include('database/db_connection.php');
include('session.php');



$sql = "select * from payment_handed_over_to where approved='Pending'";
$result = mysqli_query($con, $sql) or die("SQL Query Failed.");
$output = "";
$output2 = "";
if(mysqli_num_rows($result) > 0 ){
$output = '<table class="table table-bordered datatable table-3" id="table-4">
            <tr>
                <th>S.no</th>
                <th>Payment</th>
                <th>Payment Handed Over To</th>
                <th>Given By</th>
                <th>Given Date</th>
                <th>Status</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>';

                $i=0;
            while($row = mysqli_fetch_assoc($result)){
                $i++;
                $output .= "<tr>
                                <td align='center'>{$i}</td>
                                <td>{$row["payment"]} </td>
                                <td>{$row["payment_handed_over_to"]} </td>
                                <td>{$row["given_by"]} </td>
                                <td>{$row["given_date"]} </td>
                                
                                <td>
                            ";
                            
                        if($row['approved']=='Pending'){

                            $applied='<button class="btn btn-primary btn-sm">'.$row['approved'].'</button>';
                            
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
      
