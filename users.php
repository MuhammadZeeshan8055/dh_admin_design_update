<?php
    include('database/db_connection.php');
    include('session.php');
    
    if(isset($_GET['id']) && isset($_GET['type'])){
        
        $id=$_GET['id'];
        $type=$_GET['type'];
        
        if($type=='Delete'){
               $delete=mysqli_query($con,"DELETE FROM users where user_id='$id'");
            
            if($delete==true){
                header("location:users.php");
            }else{
                echo "<script>alert('Error: Cant Delete Records')</script>";
            }
        
        }else{
             echo "<script>alert('Error: Invalid Value')</script>";
        }
     
       
    }
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
               <li class="active"> <strong>Users</strong> </li>
            </ol>
       
            
           
            <div class="row">
                <div class="col-md-12">
                    <a href="add_user" class="btn btn-success">Add User</a>
                </div>
            </div> 
           
            <h3>Users List</h3>
            <br/> <script type="text/javascript">
               jQuery( document ).ready( function( $ ) {
               var $table4 = jQuery( "#table-4" );
               $table4.DataTable( {
               dom: 'Bfrtip',
               buttons: [
               'copyHtml5',
               'excelHtml5',
               'csvHtml5',
               'pdfHtml5'
               ]
               } );


              

               } );
            </script> 
            <table class="table table-bordered datatable table-3" id="table-4">
               <thead>
                  <tr>
                     <th>S.no</th>
                     <th>First Name</th>
                     <th>Last Name</th>
                     <th>Email</th>
                     <th>Register Date</th>
                     <th>Can View</th>
                     <th>Can Add</th>
                     <th>Can Update</th>
                     <th>Can Delete</th>
                     <th>Manage Petty Cash</th>
                     <th>Manage Accounts</th>
                     <th>Edit</th>
                     <th>Edit</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                     $i=0;
                     $data=mysqli_query($con,"select * from users");
                     while($row=mysqli_fetch_assoc($data)){
                        $i++;
                  ?>
                  <tr>
                     <td><?=$i;?></td>
                     <td><?=$row['firstname'];?></td>
                     <td><?=$row['lastname'];?></td>
                     <td><?=$row['email'];?></td>
                     <td><?=$row['register_date'];?></td>
                     <td><?=$row['only_view'];?></td>
                     <td><?=$row['can_add'];?></td>
                     <td><?=$row['can_update'];?></td>
                     <td><?=$row['can_delete'];?></td>
                     <td><?=$row['manage_petty_cash'];?></td>
                     <td><?=$row['manage_accounts'];?></td>
                     <td>
                        <a href="add_user?id=<?=$row['user_id']?>&type=Update" class='btn btn-default btn-sm btn-icon icon-left edit-btn'> <i class='entypo-pencil'></i> Edit</a>
        
                     </td>
                     <td>
                         <a href="users?id=<?=$row['user_id']?>&type=Delete" class='btn btn-danger btn-sm btn-icon icon-left delete-btn'><i class='entypo-cancel'></i> Delete</a>
                                               
                     </td>
                  </tr>
                  <?php
                     }
                  ?>
               </tbody>
               
            </table>
            <br/>  
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
</body>
</html>