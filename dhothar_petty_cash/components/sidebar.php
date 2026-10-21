
<?php

    if(!empty($_GET['page'])){
        $subAct = $_GET['page'];
    }


?>

		<!--sidebar wrapper -->
		<div class="sidebar-wrapper" data-simplebar="true">
			<div class="sidebar-header">
				<div>
					<img src="assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
				</div>
				<div>
					<h4 class="logo-text">Petty Cash</h4>
				</div>
				<div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
				</div>
			</div>
			<!--navigation-->
			<ul class="metismenu" id="menu">


				<?php
					if($userrole==1){
				?>
				
						<li class="<?php if($subAct == "" ){ echo 'mm-active'; }?>">
							<a href="index.php">
								<div class="parent-icon"><i class='bx bx-home-circle'></i>
								</div>
								<div class="menu-title ">Dashboard</div>
							</a>
							
						</li>
				<?php
					}else{
				?>

            	<li class="<?php if($subAct == "" ){ echo 'mm-active'; }?>">
					<a href="index.php">
						<div class="parent-icon"><i class='bx bx-home-circle'></i>
						</div>
						<div class="menu-title ">Dashboard</div>
					</a>
					
				</li>
				
		
				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"><i class="lni lni-grid-alt"></i>
						</div>
						<div class="menu-title">Cash</div>
					</a>
					<ul>
						<li class="<?php if($subAct == "add_cash" ){ echo 'mm-active'; }?>"> <a href="add_cash.php?page=add_cash"><i class="bx bx-right-arrow-alt"></i>Add Cash</a>
						</li>
						<li class="<?php if($subAct == "manage_cash" ){ echo 'mm-active'; }?>"> <a href="manage_cash.php?page=manage_cash"><i class="bx bx-right-arrow-alt"></i>Manage Cash</a>
						</li>
									
					</ul>
					
				</li>
			
				
    <!--            <li class="<?php if($subAct == "add_expense" ){ echo 'mm-active'; }?>">-->
    <!--                <a href="add_expense.php?page=add_expense">-->
				<!--		<div class="parent-icon"><i class="lni lni-circle-plus"></i>-->
				<!--		</div>-->
				<!--		<div class="menu-title">Add Expense</div>-->
				<!--	</a>-->
		
				<!--</li>-->
				<!--<li class="<?php if($subAct == "manage_expense" ){ echo 'mm-active'; }?>">-->
    <!--                <a href="manage_expense.php?page=manage_expense">-->
				<!--		<div class="parent-icon"><i class="lni lni-calculator"></i>-->
				<!--		</div>-->
				<!--		<div class="menu-title">Manage Expense</div>-->
				<!--	</a>-->
		
				<!--</li>-->
				
				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"><i class="lni lni-grid-alt"></i>
						</div>
						<div class="menu-title">Expense</div>
					</a>
					<ul>
						<li class="<?php if($subAct == "add_expense" ){ echo 'mm-active'; }?>"> <a href="add_expense.php?page=add_expense"><i class="bx bx-right-arrow-alt"></i>Add Expense</a>
						</li>
						<li class="<?php if($subAct == "manage_expense" ){ echo 'mm-active'; }?>"> <a href="manage_expense.php?page=manage_expense"><i class="bx bx-right-arrow-alt"></i>Manage Expense</a>
						</li>
									
					</ul>
					
				</li>
			
				
				<!-- <li class="<?php if($subAct == "user_profile" ){ echo 'mm-active'; }?>">
                    <a href="user_profile.php?page=user_profile">
						<div class="parent-icon"><i class="bx bx-user-circle"></i>
						</div>
						<div class="menu-title">Profile</div>
					</a>
		
				</li> -->
				<li class="<?php if($subAct == "logout" ){ echo 'mm-active'; }?>">
                    <a href="logout.php?page=logout">
						<div class="parent-icon"><i class="bx bx-log-out-circle"></i>
						</div>
						<div class="menu-title">Logout</div>
					</a>
		
				</li>
            
              	<?php

				}


				?>
				
			
			</ul>
			<!--end navigation-->
		</div>
		<!--end sidebar wrapper -->