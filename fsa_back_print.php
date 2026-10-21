<?php
    include('session.php');
    include('database/db_connection.php');

    $emp_id=$_GET['emp_id'];
   
    $contract_conditions=mysqli_fetch_assoc(mysqli_query($con,"select * from contract_conditions where emp_id='$emp_id'"));

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
.line {
    border-left: 2px solid black;
    height: 100px;
    float: right;
    margin-top: -6%;
    /* margin-right: 32%; */
}
.stump{
    height: 200px;
}
.vertical_line{
    border-bottom: 2px solid black;
}
input[type="text"] {
        border: 2px solid !important;
    }
    p.inline {
    width: 42% !important;
    border: 1px solid;
    margin-left: 34%;
}
</style>
</head>
<body>

    <div class="container-fluid mt-5 ml-5">
        <div class="row mt-5">
            <div class="col-12 mt-5">
                <h4 class="mt-5 ml-3"> <u> PART-II </u></h4>
                <h5 class="ml-3"> <U> TERMS AND CONDITIONS OF THE CONTRACT</U>
                </h5>
                <h5>27 Job Title <input type="text" name="" value="<?=$contract_conditions['job_title']?>" style="margin-left:8%;width:20%" id="" readonly> &nbsp&nbsp 28 Monthly Salary <input type="text" name="" style="width:30%" value="<?=$contract_conditions['monthly_salary']?>" id=""> </h5>
                <h5>29 Rate <input type="text" name="" value="<?=$contract_conditions['rate']?>" style="margin-left:11%;width:20%" id="" readonly> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp 30 Period of Contract <input type="text" name="" value="<?=$contract_conditions['period_of_contract']?>" id=""> </h5>
                <h5>31 Free Accomadation <input type="text" name="" value="<?=$contract_conditions['free_acco']?>" style="margin-left:2%;width:20%" id="" readonly>  </h5>
                <h5>31 Free Food <input type="text" name="" value="<?=$contract_conditions['free_food']?>" style="margin-left:7%;width:20%" id="" readonly>  </h5>
                <h5>33 Probation period, working hours, overtime (working days and holidays)
                    <br>
                    &nbsp&nbsp&nbsp&nbsp medical, passage, repatriation, of dead body, leave Anention, other fringe 
                    <br>
                    &nbsp&nbsp&nbsp&nbsp benefits, social security and service benefits etc.
                    <br>
                    34 Cancellation of Contract
                    <p class="line mr-5"> 
                        &nbsp&nbsp
                        As per local labour laws
                        <br>
                        <br>
                        <br>
                        &nbsp&nbsp
                        As per local labour laws

                    </p>

                </h5>
                
            </div>
            <div class="col-6">
                <h4 class="mt-5 ml-3"> <u> PART-III </u></h4>
                <h5 class="ml-3">Certified that the above named emigrant has been engaged for employement abroad as per details 
                    given above and he has been made to understand about the terms and conditions of service
                </h5>
            </div>
            <div class="col-6 mt-5">
                <h5 class="ml-3 mt-5">
                    I agree for the employement on the terms and conditions mentioned above which have been explained 
                    to me and I have fully understood
                </h5>
            </div>

        </div>


        
        <div class="vertical_line"></div>


    </div>

    <div class="container-fluid ml-5">
        <div class="row">
            <div class="col-6">
                <div class="stump_portion">
                    <div class="stump">

                    </div>

                    <div class="vertical_line" style="width:96%"></div>

                    <h5>Signature and Seal of O.E.P on behalf of Employer</h5>

                </div>
                
            </div>
            <div class="col-6">
                <div class="thumb_portion">
                    <div class="stump">
                        
                    </div>
            
                    <div class="vertical_line" style="width:86%"></div>

                    <h5>Signature and Thumb impression of Emigrant</h5>

                </div>
            </div>
        </div>
        
        <div class="vertical_line"></div>


    </div>

    <div class="container-fluid ml-5">
        <div class="row">
            <div class="col-12">
            <h5>Certified that both parties mentioned above have agreed with the contents of the contract which has been registered vide number as below</h5>
                   
            </div>
            <div class="col-6">
                <div class="stump_portion">
                    <div class="stump">

                    </div>

                    <h5>Registration No <p class="inline"></p> </h5>
                    <h5>Date <p class="inline"></p></h5>

                   
                </div>
                
            </div>
            <div class="col-6">
                <div class="thumb_portion">
                    <div class="stump">
                        
                    </div>
            
                    <div class="vertical_line" style="width:80%"></div>

                    <h5>Signature and Seal of Protector Emigrants</h5>

                </div>
            </div>
        </div>
        
        <div class="vertical_line"></div>


        <div class="row">
            <div class="col-12">
                <h5>Note: All columns which are applicable must be filled-in properly</h5>
            </div>
        </div>

    </div>




</body>
</html>