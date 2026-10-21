<?php
  include('session.php');
  include('database/db_connection.php');

    $emp_id=$_GET['emp_id'];
   
    $personal_info=mysqli_fetch_assoc(mysqli_query($con,"select * from employee_personal_info where emp_id='$emp_id'"));
    $employer_info=mysqli_fetch_assoc(mysqli_query($con,"select * from employer_info where emp_id='$personal_info[emp_id]'"));
    $next_of_kin=mysqli_fetch_assoc(mysqli_query($con,"select * from next_of_kin where emp_id='$personal_info[emp_id]'"));
    $contract_conditions=mysqli_fetch_assoc(mysqli_query($con,"select * from contract_conditions where emp_id='$personal_info[emp_id]'"));

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dhotar International</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
<style>
     input[type="text"] {
        border: 2px solid !important;
    }
    .inline {
        border: 2px solid !important;
        display: inline;
        padding:2px 2px 2px 2px;
        margin-left:4%;
        margin-top: -2%;
        font-family: auto;
        font-size: 1rem;
    }
    textarea {
        margin-left: 4% !important;
        border: 2px solid black;
        margin-top: -2%;
        overflow:hidden;
    }
</style>
</head>
<body>
    
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="container-fluid mt-5 ml-5">
        <div class="row mt-5">
            
            <div class="col-12 mt-5">
                <h4 class="mt-5 ml-3"> <u> FOREIGN SERVICE CONTRACT </u></h4>
                <h5 class="ml-3">This agreement has been executed between emigrant (employee) and the O.E.P on behalf of the <br>
                    employer as power of attorney / Sak Wakala dated
                </h5>
                <br>
                <h4 class="ml-3"><u>Part-I</u></h4>
                <h5>A PARTICULARS OF THE OVERSEAS EMPLOYEMENT PROMOTER (O.E.P)</h5>
                <h5>1 Title of O.E.P <input type="text" name="" value="DHOTHAR INTERNATIONAL RECRUITMENT AGENCY" style="width:50%" id="" readonly> </h5>
                
                <h5>2 License No &nbsp <input type="text" name="" value="4513/RWP/2020" style="width:15%" id="" readonly> </h5>
                <h5>B PARTICULARS OF EMPLOYER</h5>
                <h5>3 Name of the employer <input type="text" name="" value="<?=$employer_info['employer_name']?>" style="width:72%" id="" readonly> </h5>
                <h5>4 Address <input type="text" name="" value="<?=$employer_info['address']?>" style="margin-left:45px;width:50%" id="" readonly> </h5>
                <h5>5 City <input type="text" name="" value="<?=$employer_info['city']?>" style="margin-left:82px;width:50%" id="" readonly> &nbsp&nbsp 6 Country <input type="text" name="" value="<?=$employer_info['country']?>" id=""> </h5>
                <h5>7 Telephone <input type="text" name="" value="<?=$employer_info['telephone']?>" style="margin-left:24px;width:50%" id="" readonly> &nbsp&nbsp 8 Fax No &nbsp&nbsp<input type="text" name="" value="<?=$employer_info['fax_no']?>" id=""> </h5>
                <h5>9 Email <input type="text" name="" value="<?=$employer_info['email']?>" style="margin-left:67px;width:50%" id="" readonly> </h5>
                
                <br>
                <h5>C PARTICULARS OF EMIGRANTS (EMPLOYEE)</h5>
                <h5>10 Name <input type="text" name="" value="<?=$personal_info['name']?>" style="margin-left:85px;width:80%" id="" readonly> </h5>
                <h5>11 CNIC No <input type="text" name="" value="<?=$personal_info['employee_cnic']?>" style="margin-left:63px;width:50%" id="" readonly> </h5>
                <h5>12 Father's Name  <input type="text" name="" value="<?=$personal_info['employee_father_name']?>" style="margin-left:10px;width:50%" id="" readonly> </h5>
                <h5>13 CNIC No  <input type="text" name="" value="<?=$personal_info['father_cnic']?>" style="margin-left:60px;width:50%" id="" readonly> </h5>
                <h5>14 Address In <br> &nbsp&nbsp&nbsp&nbsp Pakistan  <textarea rows="2" cols="80" style="margin-left:4%"><?=$personal_info['address']?></textarea> </h5>
                <?php
                     $date_of_issue = $personal_info['date_of_issue'];// Example date in Y-m-d format
                  
                      $date_of_issue_Date = date("d-m-Y", strtotime($date_of_issue));
                      
                      $date_of_birth = $personal_info['date_of_birth'];// Example date in Y-m-d format
                  
                      $date_of_birth_Date = date("d-m-Y", strtotime($date_of_birth));
                      
                ?>
                <h5>15 Passport No <input type="text" name="" value="<?=$personal_info['passport_no']?>" style="margin-left:20px;width:20%" id="" readonly>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp 16 Date Of Issue <input type="text" name="" value="<?=$date_of_issue_Date?>" id=""> </h5>
                <h5>17 Place Of Issue <input type="text" name="" value="<?=$personal_info['place_of_issue']?>" style="margin-left:20px;width:20%" id="" readonly>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp 18 Date Of Birth <input type="text" name="" value="<?=$date_of_birth_Date?>" id=""> </h5>
                <h5>19 District Domicile <input type="text" name="" value="<?=$personal_info['district_domicile']?>" style="margin-left:20px;width:20%" id="" readonly>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp 20 Province &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type="text" name="" value="<?=$personal_info['province']?>" id=""> </h5>
                <h5>21 Marital Status <input type="text" name="" value="<?=$personal_info['martial_status']?>" style="margin-left:20px;width:20%" id="" readonly>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp 22 Gender &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type="text" name="" value="<?=$personal_info['gender']?>" id=""> </h5>
                <h5>23 Education/Qualification <input type="text" name="" value="<?=$personal_info['education']?>" style="margin-left:5px;width:20%" id="" readonly> </h5>

                <br>

                <h5>D PARTICULARS OF NEXT KIN</h5>
                <h5>24 Next Of Kin  <input type="text" name="" value="<?=$next_of_kin['next_of_kin_name']?>" style="margin-left:30px;width:50%" id="" readonly> </h5>
                <h5>25 CNIC No  <input type="text" name="" value="<?=$next_of_kin['cnic']?>" style="margin-left:55px;width:50%" id="" readonly> </h5>
                <h5>26 Address <input type="text" name="" value="<?=$next_of_kin['address']?>" style="margin-left:60px;width:80%" id="" readonly> </h5>
                

                
            </div>
        </div>
    </div>

</body>
</html>