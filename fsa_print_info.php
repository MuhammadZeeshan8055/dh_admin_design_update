<?php
   include('database/db_connection.php');
   include('session.php');

   $employee_id=$_GET['id'];

    $employee=mysqli_fetch_assoc(mysqli_query($con,"Select * from new_case_details where id='$employee_id' "));

?>
<!DOCTYPE html> 
<html lang="en">
   <!-- Added by HTTrack -->
   <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
   <!-- /Added by HTTrack -->
   <head>
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1" />
      <meta name="description" content="Dhothar International" />
      <meta name="author" content="Laborator.co" />
      <link rel="icon" href="assets/images/favicon.ico">
       
      <title>Dhothar International | Forms</title>
      <link rel="stylesheet" href="assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css" id="style-resource-1">
      <link rel="stylesheet" href="assets/css/font-icons/entypo/css/entypo.css" id="style-resource-2">
      <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic" id="style-resource-3">
      <link rel="stylesheet" href="assets/css/bootstrap.css" id="style-resource-4">
      <link rel="stylesheet" href="assets/css/neon-core.css" id="style-resource-5">
      <link rel="stylesheet" href="assets/css/neon-theme.css" id="style-resource-6">
      <link rel="stylesheet" href="assets/css/neon-forms.css" id="style-resource-7">
      <link rel="stylesheet" href="assets/css/custom.css" id="style-resource-8">
      <script src="assets/js/jquery-1.11.3.min.js"></script> 
   </head>
   <body class="page-body">
      <div class="page-container">
        <div class="sidebar-menu">
            <?php include('components/sidebar.php'); ?>
         </div>
         <div class="main-content">

            <?php include('components/header.php'); ?>
            <hr/>
            <ol class="breadcrumb bc-3">
               <li> <a href="../../dashboard/main/index.html"><i class="fa-home"></i>Home</a> </li>
               <li> <a href="add_new_case.html">Fsa Info</a> </li>
               <li class="active"> <strong>Fsa Info</strong> </li>
            </ol>
            <h2>Fsa Info</h2>
            <br/> 
            
            <div class="row">
               <div class="col-md-12">
                  <div class="panel panel-primary" data-collapsed="0">
                     <div class="panel-heading">
                        <div class="panel-title">
                            Particulars of Employer:
                        </div>
                     </div>
                     <div class="panel-body">
                        <div class="row">
                           <form action="save_form" method="post">
                              <div class="col-md-12"> 
                                 <input type="hidden" name="employee_id" value="<?=$employee['id']?>" id="">
                                 <label class="col-sm-6 control-label">Employer Name <span style="color:red">*</span></label>
                                 <input type="text" name="employer_name"  class="form-control" placeholder="Employer Name"> 
                              </div>
                              <div class="clear"></div>
                              <br/>
                              <div class="col-md-6"> 
                                 <label class="col-sm-3 control-label">Address <span style="color:red">*</span></label>
                                 <input type="text" name="employer_address"  class="form-control" placeholder="Enter Address"> 
                              </div>
                              <div class="clear"></div>
                              <br/> 
                              <div class="col-md-6"> 
                                 <label class="col-sm-3 control-label">City <span style="color:red">*</span></label>
                                 <input type="text" name="employer_city"  class="form-control" placeholder="Enter City"> 
                              </div>
                              
                              <div class="col-md-6"> 
                                 <label class="col-sm-3 control-label">Country <span style="color:red">*</span></label>
                                 <input type="text" name="employer_country"  class="form-control" placeholder="Enter Country"> 
                              </div>

                              <div class="clear"></div>
                              <br/>

                              <div class="col-md-6"> 
                                 <label class="col-sm-3 control-label">Telephone <span style="color:red">*</span></label>
                                 <input type="text" name="employer_telephone" pattern="\d{4}" title="Please enter exactly 4 digits"  class="form-control" placeholder="Enter Name Telephone"> 
                              </div>
                              <div class="col-md-6"> 
                                 <label class="col-sm-3 control-label">Fax <span style="color:red">*</span> </label>
                                 <input type="text" name="employer_fax_no"  class="form-control" placeholder="Enter Fax"> 
                              </div>

                              <div class="clear"></div>
                              <br/>

                              <div class="col-md-6"> 
                                 <label class="col-sm-3 control-label">Email <span style="color:red">*</span></label>
                                 <input type="text" name="employer_email"  class="form-control" placeholder="Enter Email"> 
                              </div>
                              
                              <div class="clear"></div>
                              <br/>
                              <div class="clear"></div>
                              <br/>
                              
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        Particulars of Emigrant (Employee):
                                    </div>
                                </div>

                              <div class="col-md-12"> 
                                 <label class="col-sm-3 control-label">Name <span style="color:red">*</span></label>
                                 <input type="text" name="employee_name" value="<?=$employee['name']?>"  class="form-control" placeholder="Enter Name"> 
                              </div>

                              <div class="clear"></div>
                              <br/>

                              <div class="col-md-12"> 
                                 <label class="col-sm-3 control-label">Cnic <span style="color:red">*</span></label>
                                 <input type="text" name="employee_cnic"  class="form-control" placeholder="Enter Cnic"> 
                              </div>
                              
                              <div class="clear"></div>
                              <br/>

                              <div class="col-md-12"> 
                                 <label class="col-sm-6 control-label">Father Name <span style="color:red">*</span></label>
                                 <input type="text" name="employee_father_name" value="<?=$employee['fname']?>"  class="form-control" placeholder="Enter Father Name"> 
                              </div>
                              
                              <div class="clear"></div>
                              <br/>

                              <div class="col-md-12"> 
                                 <label class="col-sm-6 control-label">Mother Name <span style="color:red">*</span></label>
                                 <input type="text" name="employee_mother_name"  class="form-control" placeholder="Enter Mother Name"> 
                              </div>


                              <div class="clear"></div>
                              <br/>

                              <div class="col-md-12"> 
                                 <label class="col-sm-6 control-label">Father Cnic <span style="color:red">*</span></label>
                                 <input type="text" name="employee_father_cnic"  class="form-control" placeholder="Enter Father Cnic"> 
                              </div>

                              <div class="clear"></div>
                              <br/>

                              <div class="col-md-12"> 
                                 <label class="col-sm-6 control-label">Address <span style="color:red">*</span></label>
                                 <input type="text" name="employee_address"  class="form-control" placeholder="Enter Address"> 
                              </div>

                              <div class="clear"></div>
                              <br/>

                              <div class="col-md-6"> 
                                 <label class="col-sm-6 control-label">Passport No <span style="color:red">*</span></label>
                                 <input type="text" name="employee_passport_no" value="<?=$employee['pp_no']?>"  class="form-control" placeholder="Enter Passport No"> 
                              </div>

                             

                              <div class="col-md-6"> 
                                 <label class="col-sm-6 control-label">Date Of Issue <span style="color:red">*</span></label>
                                 <input type="date" name="employee_passport_issue_date"  class="form-control" placeholder="Enter Date Of Issue"> 
                              </div>

                              <div class="clear"></div>
                              <br/>

                              <div class="col-md-6"> 
                                 <label class="col-sm-6 control-label">Date Of Expiry <span style="color:red">*</span></label>
                                 <input type="date" name="employee_passport_expiry_date" value="<?=$employee['pp_expiry']?>"  class="form-control" placeholder="Enter Date Of Expiry"> 
                              </div>


                              <div class="col-md-6"> 
                                 <label class="col-sm-6 control-label">Place Of Issue <span style="color:red">*</span></label>
                                 <input type="text" name="employee_passport_issue_place"  class="form-control" placeholder="Enter Place Of Issue"> 
                              </div>

                              <div class="clear"></div>
                              <br/>

                              <div class="col-md-6"> 
                                 <label class="col-sm-6 control-label">Date Of Birth <span style="color:red">*</span></label>
                                 <input type="date" name="employee_date_of_birth"  class="form-control" placeholder="Enter Date Of Birth"> 
                              </div>


                              <div class="col-md-6"> 
                                 <label class="col-sm-6 control-label">Place Of Birth <span style="color:red">*</span></label>
                                 <input type="text" name="employee_place_of_birth"  class="form-control" placeholder="Enter Place Of Birth"> 
                              </div>


                              <div class="clear"></div>
                              <br/>

                              <div class="col-md-6"> 
                                 <label class="col-sm-6 control-label">District Of Domicile <span style="color:red">*</span></label>
                                 <input type="text" name="employee_domicile"  class="form-control" placeholder="Enter District Of Domicile"> 
                              </div>


                              <div class="col-md-6"> 
                                 <label class="col-sm-6 control-label">Province <span style="color:red">*</span></label>
                                 <input type="text" name="employee_province"  class="form-control" placeholder="Enter Province"> 
                              </div>

                              <div class="clear"></div>
                              <br/>

                              <div class="col-md-6"> 
                                 <label class="col-sm-6 control-label">Martial Status <span style="color:red">*</span></label>
                                 <select name="employee_martial_status" id="" class="form-control">
                                    <option value="Select Martial Status">Select Martial Status</option>
                                    <option value="Married">Married</option>
                                    <option value="Unmarried">Unmarried</option>
                                 </select>
                              </div>


                              <div class="col-md-6"> 
                                <label class="col-sm-6 control-label">Gender <span style="color:red">*</span></label>
                                 <select name="employee_gender" id="" class="form-control">
                                    <option value="Select Gender">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                 </select> 
                              </div>

                              <div class="clear"></div>
                              <br/>

                              <div class="col-md-6"> 
                                <label class="col-sm-6 control-label">Education/Qualification <span style="color:red">*</span></label>
                                 <select name="employee_education" id="" class="form-control">
                                    <option value="Select Education/Qualification">Select Education/Qualification</option>
                                    <option value="Under Matric">Under Matric</option>
                                    <option value="MATRIC">MATRIC</option>
                                    <option value="FA">FA</option>
                                    <option value="BA">BA</option>
                                    <option value="BACHELOR">BACHELOR</option>
                                    <option value="MASTER">MASTER</option>
                                    <option value="PHD">PHD</option>
                                 </select>  
                              </div>
                              
                              
                              <div class="clear"></div>
                              <br/>
                              <div class="clear"></div>
                              <br/>

                                <div class="panel-heading">
                                    <div class="panel-title">
                                        Particulars of Next Kin:
                                    </div>
                                </div>


                              <div class="col-md-12"> 
                                 <label class="col-sm-6 control-label">Next Of Kin <span style="color:red">*</span></label>
                                 <input type="text" name="employee_next_kin"  class="form-control" placeholder="Enter Next Of Kin"> 
                              </div>

                              <div class="clear"></div>
                              <br/>

                              <div class="col-md-12"> 
                                 <label class="col-sm-6 control-label">Next Of Kin Age <span style="color:red">*</span></label>
                                 <input type="text" name="employee_next_kin_age"  class="form-control" placeholder="Enter Next Of Kin Age"> 
                              </div>

                              <div class="clear"></div>
                              <br/>

                              <div class="col-md-12"> 
                                 <label class="col-sm-6 control-label">Next Of Kin Cnic <span style="color:red">*</span></label>
                                 <input type="text" name="employee_next_kin_cnic"  class="form-control" placeholder="Enter Next Of Kin Cnic"> 
                              </div>

                              <div class="clear"></div>
                              <br/>

                              <div class="col-md-12"> 
                                 <label class="col-sm-6 control-label">Next Of Kin relation <span style="color:red">*</span></label>
                                 <input type="text" name="employee_next_kin_relation"  class="form-control" placeholder="Enter Next Of Kin relation"> 
                              </div>

                              <div class="clear"></div>
                              <br/>

                              <div class="col-md-12"> 
                                 <label class="col-sm-6 control-label">Next Of Kin Address <span style="color:red">*</span></label>
                                 <input type="text" name="employee_next_kin_address"  class="form-control" placeholder="Enter Next Of Kin Address"> 
                              </div>

                              <div class="clear"></div>
                              <br/>
                              <div class="clear"></div>
                              <br/>

                              <div class="col-md-6"> 
                                 <label class="col-sm-6 control-label">Job Title <span style="color:red">*</span></label>
                                 <input type="text" name="job_title"  class="form-control" placeholder="Enter Job Title"> 
                              </div>

                              <div class="col-md-6"> 
                                 <label class="col-sm-6 control-label">Monthly Salary <span style="color:red">*</span></label>
                                 <input type="text" name="monthly_salary"  class="form-control" placeholder="Enter Monthly Salary"> 
                              </div>


                              <div class="clear"></div>
                              <br/>

                              <div class="col-md-6"> 
                                 <label class="col-sm-6 control-label">Rate <span style="color:red">*</span></label>
                                 <input type="text" name="rate"  class="form-control" placeholder="Enter Rate"> 
                              </div>

                              <div class="col-md-6"> 
                                 <label class="col-sm-6 control-label">Period Of Contract <span style="color:red">*</span></label>
                                 <input type="text" name="period_of_contract"  class="form-control" placeholder="Enter Period Of Contract"> 
                              </div>


                              <div class="clear"></div>
                              <br/>

                              <div class="col-md-12"> 
                                 <label class="col-sm-6 control-label">Free Accommodation <span style="color:red">*</span></label>
                                 <input type="text" name="free_acco"  class="form-control" placeholder="Enter Free Accommodation"> 
                              </div>

                              <div class="clear"></div>
                              <br/>

                              <div class="col-md-12"> 
                                 <label class="col-sm-6 control-label">Free Food <span style="color:red">*</span></label>
                                 <input type="text" name="free_food"  class="form-control" placeholder="Enter Free Food"> 
                              </div>

                              <div class="clear"></div>
                              <br/>

                              <div class="col-md-12"> 
                                 <label class="col-sm-6 control-label">Experience <span style="color:red">*</span></label>
                                 <input type="text" name="experience"  class="form-control" placeholder="Enter Experience"> 
                              </div>


                              <div class="col-md-12 text-center"> 
                                 <button type="submit" name="add_fsa_info" class="btn btn-success">Submit Details</button>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <?php
               include('components/footer.php');
            ?>
         </div>
      
         
      
      </div>
      <script src="assets/js/gsap/TweenMax.min.js" id="script-resource-1"></script> 
      <script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js" id="script-resource-2"></script> 
      <script src="assets/js/bootstrap.js" id="script-resource-3"></script> 
      <script src="assets/js/joinable.js" id="script-resource-4"></script> 
      <script src="assets/js/resizeable.js" id="script-resource-5"></script> 
      <script src="assets/js/neon-api.js" id="script-resource-6"></script> 
      <script src="assets/js/cookies.min.js" id="script-resource-7"></script> 
      <script src="assets/js/bootstrap-switch.min.js" id="script-resource-8"></script> 
<script src="assets/js/neon-custom.js" id="script-resource-10"></script>  
</body>
</html>