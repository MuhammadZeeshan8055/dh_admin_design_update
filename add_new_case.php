<?php
   include('database/db_connection.php');
   include('session.php');
   include('attendance_system/database.php');

   $obj = new Database();

   $colName = "*";
   $join = null;
   $limit = 0;
   $where = null;

   $obj->select('care_off_persons', $colName, $join, $where, null, $limit);
   $care_of = $obj->getResult();

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

    <title>Dhothar International </title>
    <link rel="stylesheet" href="assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css"
        id="style-resource-1">
    <link rel="stylesheet" href="assets/css/font-icons/entypo/css/entypo.css" id="style-resource-2">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic"
        id="style-resource-3">
    <link rel="stylesheet" href="assets/css/bootstrap.css" id="style-resource-4">
    <link rel="stylesheet" href="assets/css/neon-core.css" id="style-resource-5">
    <link rel="stylesheet" href="assets/css/neon-theme.css" id="style-resource-6">
    <link rel="stylesheet" href="assets/css/neon-forms.css" id="style-resource-7">
    <link rel="stylesheet" href="assets/css/custom.css" id="style-resource-8">
    <script src="assets/js/jquery-1.11.3.min.js"></script>
    <!--[if lt IE 9]><script src="https://demo.neontheme.com/assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <!--[if lt IE 9]> <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script> <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script> <![endif]-->

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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
               <li> <a href="add_new_case.html">Add New Case</a> </li>
               <li class="active"> <strong>Add New Case</strong> </li>
            </ol>
            <h2>Add New Case</h2>
            <br/> 
            
            <div class="row">
               <div class="col-md-12">
                  <div class="panel panel-primary" data-collapsed="0">
                     <div class="panel-heading">
                        <div class="panel-title">
                           Entry Form
                        </div>
                     </div>
                     <div class="panel-body">
                        <div class="row">
                           <form action="save_form" method="post">
                              
                              <div class="col-md-6"> 
                                 <label class="col-sm-3 control-label">Name <span style="color:red">*</span></label>
                                 <input type="text" name="name" required class="form-control" placeholder="Enter Name"> 
                              </div>
                              <div class="col-md-6"> 
                                 <label class="col-sm-3 control-label">Father Name <span style="color:red">*</span></label>
                                 <input type="text" name="fname" required class="form-control" placeholder="Enter Father Name"> 
                              </div>
                              <div class="clear"></div>
                              <br/> 
                              <div class="col-md-6"> 
                                 <label class="col-sm-3 control-label">PP NO <span style="color:red">*</span></label>
                                 <input type="text" name="pp_no" required class="form-control" placeholder="Enter PP NO"> 
                              </div>
                              
                              <div class="col-md-6"> 
                                 <label class="col-sm-3 control-label">PP Expiry <span style="color:red">*</span></label>
                                 <input type="date" name="pp_expiry" required class="form-control" placeholder="Enter PP Expiry"> 
                              </div>

                              <div class="clear"></div>
                              <br/>

                              <div class="col-md-6"> 
                                 <label class="col-sm-3 control-label">Tracking Id <span style="color:red">*</span></label>
                                 <input type="text" name="tracking_id" pattern="\d{4}" title="Please enter exactly 4 digits" required class="form-control" placeholder="Enter Name Tracking ID"> 
                              </div>
                              <div class="col-md-6"> 
                                 <label class="col-sm-3 control-label">New Case Date <span style="color:red">*</span> </label>
                                 <input type="date" name="new_case_date" required class="form-control" placeholder="Enter New Case Date"> 
                              </div>

                              <div class="clear"></div>
                              <br/>
                              
                              <div class="col-md-6"> 
                                 <label class="col-sm-3 control-label">Date Of Birth <span style="color:red">*</span></label>
                                 <input type="date" name="date_of_birth" required class="form-control" placeholder="Enter Date Of Birth"> 
                              </div>
                              
                              <div class="col-md-6"> 
                                 <label class="col-sm-3 control-label">Age </label>
                                 <input type="text" name="client_age" class="form-control" placeholder="New Case Age" readonly>  
                              </div>

                              <div class="clear"></div>
                              <br/>

                              <div class="clear"></div>
                              <br/>

                              <div class="col-md-6"> 
                                 <label for="care_of">Care Of <span style="color:red">*</span></label>
                                 <!-- <input type="text" name="care_of" required class="form-control" placeholder="Enter Reference">  -->
                                 <select name="care_of" id="care_of" class="js-example-basic-single form-select border fs-3"
                                    aria-label="Default select example">

                                    <option value="">Search Care of</option>

                                    <?php 
                                    $selectedCareOf = $_GET['search_care_of'] ?? '';
                                    if (!empty($care_of)) {
                                          foreach ($care_of as $row) {
                                             $selected = ($selectedCareOf === $row['name']) ? 'selected' : '';
                                             ?>
                                                                  <option value="<?= htmlspecialchars($row['name']); ?>" <?= $selected ?>>
                                                                     <?= htmlspecialchars($row['name']); ?>
                                                                  </option>
                                                                  <?php 
                                          }
                                    } 
                                    ?>
                                 </select>
                              </div>
                              
                              <div class="clear"></div>
                              <br/>
                              
                               <div class="col-md-6"> 
                                 <label class="col-sm-3 control-label">Trade </label>
                                 <input type="text" name="trade"  class="form-control" placeholder="Enter Trade"> 
                              </div>
                              
                              <div class="clear"></div>
                              <br/>

                              <div class="col-md-6"> 
                                 <label class="col-sm-3 control-label">Mobile No 1 <span style="color:red">*</span></label>
                                 <input type="text" name="mobile_no_1" required pattern="^\d{4}\d{3}\d{4}$" class="form-control" placeholder="Enter Mobile No 1 E.g:03001234567"> 
                              </div>


                              <div class="col-md-6"> 
                                 <label class="col-sm-3 control-label">Mobile No 2 </label>
                                 <input type="text" name="mobile_no_2" class="form-control" pattern="^\d{4}\d{3}\d{4}$" placeholder="Enter Mobile No 2 E.g:03001234567"> 
                              </div>
                              
                              <div class="clear"></div>
                              <br/>

                              <!-- <div class="col-md-6"> 
                                 <label class="col-sm-6 control-label">Missing Documents</label>
                                 <input type="text" name="missing_documents" required class="form-control" placeholder="Enter Missing Documents"> 
                              </div> -->
                              
                              <div class="col-md-6"> 
                                 <label class="col-sm-5 control-label">First Character Issue Date<span style="color:red">*</span> </label>
                                 <input type="date" name="first_character_issue_date" id="first_character_issue_date" required class="form-control" > 
                              </div>
                              
                              <div class='col-md-6'>
                                <div class='form-group'> 
                                    <label for='field-6' class='control-label'>First Character Expiry</label> 
                                    <input type='date' name="first_character_expiry" class='form-control' id='first_character_expiry'> 
                                </div>
                            </div>
                            
                            <div class="clear"></div>
                              <br/>
                              <br/>
                            
                              <!-- missing_documents field -->
                              <div class="col-md-6">
                                 <label class="col-sm-6 control-label">
                                    <input type="checkbox" name="missing" value="Documents Missing" id="showInput"> Any Documents Missing ?
                                 </label>
                                 <div class="clear"></div>
                                 <br/>
                                 <div id="inputContainer" class="hidden">
                                    <label class="col-sm-6 control-label">Missing Documents</label>
                                    <input type="text" name="missing_documents" id="inputField" class="form-control">
                                 </div>
                              </div>

                              <div class="col-md-6"> 
                                 <label for="country">Country</label>
                                 <select name="country" class="form-control" id="country">
                                    
                                    <?php
                                       $country=mysqli_query($con,"select country_name from country");
                                       while($c_name=mysqli_fetch_assoc($country)){
                                    ?>

                                       <option value="<?=$c_name['country_name']?>"><?=$c_name['country_name']?></option>

                                    <?php
                                       }
                                    ?>
                                    
                                 </select> 
                              </div>

                              <div class="clear"></div>
                              <br/>

                              <div class="col-md-12 text-center"> 
                                 <button type="submit" name="new_case_entry" class="btn btn-success">Submit Details</button>
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
      <link rel="stylesheet" href="assets/js/datatables/datatables.css" id="style-resource-1">
        <link rel="stylesheet" href="assets/js/select2/select2-bootstrap.css" id="style-resource-2">
        <link rel="stylesheet" href="assets/js/select2/select2.css" id="style-resource-3">
        <script src="assets/js/gsap/TweenMax.min.js" id="script-resource-1"></script>
        <script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js" id="script-resource-2"></script>
        <script src="assets/js/bootstrap.js" id="script-resource-3"></script>
        <script src="assets/js/joinable.js" id="script-resource-4"></script>
        <script src="assets/js/resizeable.js" id="script-resource-5"></script>
        <script src="assets/js/neon-api.js" id="script-resource-6"></script>
        <script src="assets/js/cookies.min.js" id="script-resource-7"></script>
        <script src="assets/js/datatables/datatables.js" id="script-resource-8"></script>
        <script src="assets/js/select2/select2.min.js" id="script-resource-9"></script>
<script src="assets/js/neon-custom.js" id="script-resource-11"></script>
<script>
            // In your Javascript (external .js resource or <script> tag)
            $(document).ready(function() {
                $('.js-example-basic-single').select2();
            });
        </script>
     
   </body>
</html>

   <script>
        document.getElementById('showInput').addEventListener('change', function() {
            var inputContainer = document.getElementById('inputContainer');
            inputContainer.classList.toggle('hidden', !this.checked);
        });
        
         // Auto-fill expiry date when character_issue_date is selected
        $(document).on("change", "#first_character_issue_date", function() {
            var issueDate = new Date($(this).val());
            if (!isNaN(issueDate.getTime())) {
                // Add 180 days to the issue date
                var expiryDate = new Date(issueDate);
                expiryDate.setDate(expiryDate.getDate() + 180);
    
                // Format the date as YYYY-MM-DD
                var formattedExpiryDate = expiryDate.toISOString().split('T')[0];
    
                // Set the expiry date to the first_character_expiry and second_character_expiry fields
                $("#first_character_expiry").val(formattedExpiryDate);
            }
        });
        
        document.querySelector('input[name="date_of_birth"]').addEventListener('change', function() {
             let dob = new Date(this.value);
             let today = new Date();
    
             if (!isNaN(dob.getTime())) {
                let age = today.getFullYear() - dob.getFullYear();
                let monthDiff = today.getMonth() - dob.getMonth();
                let dayDiff = today.getDate() - dob.getDate();
    
                // If birthday not reached yet this year â†’ subtract 1
                if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
                      age--;
                }
    
                document.querySelector('input[name="client_age"]').value = `${age} Years Old`;
             }
        });
        
        
   </script>