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
  <title>Dhothar International</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <style>
    img{
      float: left;
      /* margin-left: 10%; */
    }
    .form-title{
      float: right !important;
      /* margin-right: 28%; */
    }
    .group-pensions {
          text-align: center;
          font-size: 1.5rem;
      }
      .header-border-div{
        border: 1px solid black;

      }
      .inline-content {
            display: flex;
        }
        .inline-content p {
              padding: 0% 8%;
          }
      .mid-content-body{
        border: 1px solid black;

      }
      span {
          font-size: 1rem;
      }
      p {
          font-size: 1rem;
      }
      .sub-title-of-signature {
        float: right;
        border-top: 1px solid black;
        margin-right: 12%;
        }
  </style>

</head>
<body>
  <div class="container">
    <div class="row">
      
      <div class="col-12">
        <h6 class="form-title mb-2">Form "G"</h6>
        
      </div>
      
      <div class="col-12 mt-2 text-center">
        <img src="state_life.jpg" class="" height="90px" alt="">
         <h2>STATE LIFE INSURANCE CORPORATION OF PAKISTAN</h2>
        <h5 class="ml-5">State Life Building No. 9, 7th floor, Dr. Ziauddin Ahmed Road, Karachi.</h5>
       </div>
       
       <div class="col-12">
        <p class="group-pensions">GROUP & PENSIONS DIVISION</p>
       </div>
       
       <div class="col-12">
        <div class="header-border-div">
          <p class="text-center">For Office Use Only</p>
         <div class="inline-content">
          <p>Certificate No.</p>
          <p>Date:</p>
          <p>Registration No.</p>
          <p>Date:</p>
         </div>
        </div>
       </div>
       
       <div class="col-12 ml-5 ">
        <p class="mt-1 ">Please Tick</p>
        <input class="" type="checkbox" name="" value="" id="">
        <span> Application For Insurance of Pakistan Emigrants Proceeding abroad for employement. </span>
        <br>
        <input class="" type="checkbox" name="" id="">
        <span> Application for Insurance Pakistani Emigrants Registered abroad by Pakistani Mission.</span>
        <br>
        <input class="" type="checkbox" name="" id="">
        <span> Application for Renewal of INsurance of Pakistani Emigrants working abroad.</span>

       </div>
       
       <div class="col-12 mt-3">
        <div class="mid-content-body pl-2">
          <span>Name of the Applicant &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <b> <?=$personal_info['name']?> </b></span>
        </div>
        <div class="mid-content-body pl-2">
          <span>Father's/Husband's Name &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <b><?=$personal_info['employee_father_name']?> </b></span>
        </div>
        <div class="mid-content-body pl-2">
          <span>Date & Place of Birth &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <b> 
          <?php 
              $orgDate = $personal_info['date_of_birth'];  
                $newDate = date("d-m-Y", strtotime($orgDate));  
                echo $newDate;  
          ?> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <?=$personal_info['place_of_birth']?> </b></span>
        </div>
        <div class="mid-content-body">
          
          <div class="inline-content pl-2">
            <span class="mt-1 mb-1">N.I.C No.</span>
            <span class="mt-1 mb-1" style="margin-left: 15%;border:2px solid black;padding: 5px;"><?php echo substr($personal_info['employee_cnic'],0,1) ?></span>
            <span class="mt-1 mb-1" style="margin-left: 1px;border:2px solid black;padding: 5px;"><?php echo substr($personal_info['employee_cnic'],1,1) ?></span>
            <span class="mt-1 mb-1" style="margin-left: 1px;border:2px solid black;padding: 5px;"><?php echo substr($personal_info['employee_cnic'],2,1) ?></span>
            <span class="mt-1 mb-1" style="margin-left: 1px;border:2px solid black;padding: 5px;"><?php echo substr($personal_info['employee_cnic'],3,1) ?></span>
            <span class="mt-1 mb-1" style="margin-left: 1px;border:2px solid black;padding: 5px;"><?php echo substr($personal_info['employee_cnic'],4,1) ?></span>
            <span class="mt-1 mb-1" style="margin-left: 1px;border:2px solid black;padding: 5px;">-</span>
            <span class="mt-1 mb-1" style="margin-left: 1px;border:2px solid black;padding: 5px;"><?php echo substr($personal_info['employee_cnic'],6,1) ?></span>
            <span class="mt-1 mb-1" style="margin-left: 1px;border:2px solid black;padding: 5px;"><?php echo substr($personal_info['employee_cnic'],7,1) ?></span>
            <span class="mt-1 mb-1" style="margin-left: 1px;border:2px solid black;padding: 5px;"><?php echo substr($personal_info['employee_cnic'],8,1) ?></span>
            <span class="mt-1 mb-1" style="margin-left: 1px;border:2px solid black;padding: 5px;"><?php echo substr($personal_info['employee_cnic'],9,1) ?></span>
            <span class="mt-1 mb-1" style="margin-left: 1px;border:2px solid black;padding: 5px;"><?php echo substr($personal_info['employee_cnic'],10,1) ?></span>
            <span class="mt-1 mb-1" style="margin-left: 1px;border:2px solid black;padding: 5px;"><?php echo substr($personal_info['employee_cnic'],11,1) ?></span>
            <span class="mt-1 mb-1" style="margin-left: 1px;border:2px solid black;padding: 5px;"><?php echo substr($personal_info['employee_cnic'],12,1) ?></span>
            <span class="mt-1 mb-1" style="margin-left: 1px;border:2px solid black;padding: 5px;">-</span>
            <span class="mt-1 mb-1" style="margin-left: 1px;border:2px solid black;padding: 5px;"><?php echo substr($personal_info['employee_cnic'],-1) ?></span>
            
          </div>
          
        </div>

        <div class="mid-content-body">
          <div class="inline-content mb-1 mt-1 pl-2">
            <span>Passport No</span>
                <span style="margin-left: 12%;"> <u><b><?=$personal_info['passport_no']?></b></u> </span>
            <span style="margin-left: 12%;"> Date Issue </span>
            <span style="margin-left: 3%;"> <u><b>
            <?php 
              $orgDate = $personal_info['date_of_issue'];  
                $newDate = date("d-m-Y", strtotime($orgDate));  
                echo $newDate;  
          ?>
          </b></u> </span>
          </div>

          <div class="inline-content mb-1 mt-1 pl-2">
            <span>Place Of Issue</span>
            <span style="margin-left: 11%;"> <u><b><?=$personal_info['place_of_issue']?></b></u> </span>
            <span style="margin-left: 12%;"> Occupation </span>
            <span style="margin-left: 3%;"> <u><b><?=$contract_conditions['job_title']?></b></u> </span>
          </div>

         
        </div>

        <div class="mid-content-body pl-2">
          <div class="inline-content mb-1 mt-1 pl-2">
            <span>Postal Address in Pakistan for dispatch of Insurance Certificate</span>
            <span style="margin-left: 2%;"> <u><b><?=$personal_info['address']?></b></u> </span>
           
          </div>
        </div>
        <div class="mid-content-body pl-2">
          <div class="inline-content mb-1 mt-1 pl-2">
            <span>Address Abroad</span>
            <span style="margin-left: 2%;"> <u><b><?=$employer_info['city']?>, <?=$employer_info['country']?></b></u> </span>
           
          </div>
        </div>

        <div class="mid-content-body pl-2">
          <div class="inline-content mb-1 mt-1 pl-2">
            <span>Name & Address of employee abroad</span>
            <span style="margin-left: 2%;"> <u><b><?=$employer_info['employer_name']?>, <?=$employer_info['address']?></b></u> </span>
           
          </div>
        </div>

        <div class="mid-content-body pl-2">
          <span>Particulars of the Person to whom Insured Amount is payable in the event of death of the insured Person</span>
            
          <div class="inline-content mb-1 mt-1 pl-2">
            <span>Name</span>
            <span style="margin-left: 2%;"> <u><b><?=$next_of_kin['next_of_kin_name']?></b></u> </span>
            <span style="margin-left:10%">Age</span>
            <span style="margin-left: 2%;"> <u><b><?=$next_of_kin['age']?></b></u> </span>
            <span style="margin-left:10%">Relation with Emigrant</span>
            <span style="margin-left: 2%;"> <u><b><?=$next_of_kin['relation']?></b></u> </span>
           
          </div>
          <div class="inline-content pl-2">
            <span class="mt-1 mb-1">N.I.C No.</span>
            <span class="mt-1 mb-1" style="margin-left: 3%;border:2px solid black;padding: 5px;"><?php echo substr($next_of_kin['cnic'],0,1) ?></span>
              <span class="mt-1 mb-1" style="margin-left: 1px;border:2px solid black;padding: 5px;"><?php echo substr($next_of_kin['cnic'],1,1) ?></span>
            <span class="mt-1 mb-1" style="margin-left: 1px;border:2px solid black;padding: 5px;"><?php echo substr($next_of_kin['cnic'],2,1) ?></span>
            <span class="mt-1 mb-1" style="margin-left: 1px;border:2px solid black;padding: 5px;"><?php echo substr($next_of_kin['cnic'],3,1) ?></span>
            <span class="mt-1 mb-1" style="margin-left: 1px;border:2px solid black;padding: 5px;"><?php echo substr($next_of_kin['cnic'],4,1) ?></span>
            <span class="mt-1 mb-1" style="margin-left: 1px;border:2px solid black;padding: 5px;">-</span>
            <span class="mt-1 mb-1" style="margin-left: 1px;border:2px solid black;padding: 5px;"><?php echo substr($next_of_kin['cnic'],6,1) ?></span>
            <span class="mt-1 mb-1" style="margin-left: 1px;border:2px solid black;padding: 5px;"><?php echo substr($next_of_kin['cnic'],7,1) ?></span>
            <span class="mt-1 mb-1" style="margin-left: 1px;border:2px solid black;padding: 5px;"><?php echo substr($next_of_kin['cnic'],8,1) ?></span>
            <span class="mt-1 mb-1" style="margin-left: 1px;border:2px solid black;padding: 5px;"><?php echo substr($next_of_kin['cnic'],9,1) ?></span>
            <span class="mt-1 mb-1" style="margin-left: 1px;border:2px solid black;padding: 5px;"><?php echo substr($next_of_kin['cnic'],10,1) ?></span>
            <span class="mt-1 mb-1" style="margin-left: 1px;border:2px solid black;padding: 5px;"><?php echo substr($next_of_kin['cnic'],11,1) ?></span>
            <span class="mt-1 mb-1" style="margin-left: 1px;border:2px solid black;padding: 5px;"><?php echo substr($next_of_kin['cnic'],12,1) ?></span>
            <span class="mt-1 mb-1" style="margin-left: 1px;border:2px solid black;padding: 5px;">-</span>
            <span class="mt-1 mb-1" style="margin-left: 1px;border:2px solid black;padding: 5px;"><?php echo substr($next_of_kin['cnic'],-1) ?></span>
            
            <span style="margin-left:5% ;">Address</span>
            <span style="margin-left: 2%;"> <u><b>As Above</b></u> </span>

          </div>
          
        </div>

        <div class="mid-content-body pl-2">
          <div class="inline-content mb-1 mt-1 pl-2">
            <span>Amount of Insurance</span>
            <span style="margin-left: 2%;"> <u><b>Rs 1000,000/-Rupess Ten Hundred Thousand Only</b></u> </span>

          </div>
        </div>

        <div class="mid-content-body pl-2">
          <div class="inline-content mb-1 mt-1 pl-2">
            <span>Period Of Insurance</span>
            <span style="margin-left: 2%;"> <u><b>Five Years</b></u> </span>

          </div>
        </div>

        <div class="mid-content-body pl-2">
          <div class="inline-content mb-1 mt-1 pl-2">
            <span>Date of Commencement/Renewal of Insurance</span>
            <span style="margin-left: 2%;"> <u><b></b></u> </span>

          </div>
        </div>

        <div class="mid-content-body pl-2">
          <div class="inline-content mb-1 mt-1 pl-2">
            <span>Amount of Premium Paid</span>
            <span style="margin-left: 2%;"> <u><b>Rs 2500/-(Two thousand and fice hundred Only)</b></u> </span>

          </div>
        </div>

        <div class="mid-content-body pl-2">
          <div class="inline-content mb-1 mt-1 pl-2">
            <span>Details of Previous Insurance Certificate</span>
            <span style="margin-left: 2%;"> <u><b></b></u> </span>
            <span style="margin-left: 15%;">Reg No.</span>
            <span style="margin-left: 2%;"> <u><b></b></u> </span>
            <span style="margin-left: 16%;">Date:</span>
            <span style="margin-left: 2%;"> <u><b></b></u> </span>

          </div>
        </div>

        <span class="mt-1 mb-1">I hereby declare that the particulars given above in the Applicatoin Form are true & correct. In case of any misstatement STATE LIFE/BUREAU shall have the right to cancel certificate issued on the basis of this Form "G" and take any legal action which it may deem fit. I understand that in case of issuance of two or more Insurance Certificates to me the claim will be payable on only one Insurance Certificate.</span>
        <br>
        <br>
        <span class="mt-1 mb-1"> Note: In case of registeration abroad the coverage will commence from the date of issuance of Isurance Certificate by State life Insurance Corporation. </span>
        <br>
        <br>
       
        <div class="inline-content mb-1 mt-1 pl-2">
          <span>Signed On</span>
          <span style="border-bottom: 1px solid black; width: 15%;"> <u><b></b></u> </span>
          <span>this day</span>
          <span style="border-bottom: 1px solid black; width: 15%;"> <u><b></b></u> </span>
          <span>of</span>
          <span style="border-bottom: 1px solid black; width: 15%;"> <u><b></b></u> </span>
          <span>at</span>
          <span style="border-bottom: 1px solid black; width: 15%;"> <u><b></b></u> </span>
          <span>in Presence of witness</span>
         
        </div>

        <br>
        <br>
        <br>
        


        <div class="signature">

          <div class="sub-title-of-signature">
            Signature/L.T.I. <br>
            Of the Emigrant with Date
          </div>

        </div>

        <br>
        <br>
        

        <div class="inline-content mb-1 mt-1 pl-2">
          <span>Witness Name:</span>
          <span style="border-bottom: 1px solid black; width: 30%;"> <u><b></b></u> </span>
          <span>Sign</span>
          <span style="border-bottom: 1px solid black; width: 15%;"> <u><b></b></u> </span>
          <span>N.I.C No.</span>
          <span style="border-bottom: 1px solid black; width: 30%;"> <u><b></b></u> </span>
          
        </div>
        <br>
        <span>Attested by</span>
        <br>
        <span class="ml-5 pl-5">CWA/Seal and Signature</span>

       </div>


    </div>
  </div>
</body>
</html>