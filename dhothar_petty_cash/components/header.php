<header>
			<div class="topbar d-flex align-items-center">
				<nav class="navbar navbar-expand">
					<div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
					</div>
					<div class="search-bar flex-grow-1">
						<div class="position-relative search-bar-box">
						</div>
					</div>
					<div class="top-menu ms-auto">
						<ul class="navbar-nav align-items-center">
							
							
							<li class="nav-item dropdown dropdown-large">
								
								<div class="dropdown-menu dropdown-menu-end">
									
									<div class="header-notifications-list">
									
										
									</div>
									
								</div>
							</li>
							<li class="nav-item dropdown dropdown-large">
								
								<div class="dropdown-menu dropdown-menu-end">
									
									<div class="header-message-list">
										
									
									</div>
									
								</div>
							</li>
						</ul>
					</div>
					<div class="user-box dropdown">
						<a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							<!-- <img src="assets/images/avatars/avatar-2.png" class="user-img" alt="user avatar"> -->
							<i class="lni lni-user" style="    font-size: 1.8rem;color: white;font-weight: 700;"></i>
							<div class="user-info ps-3">
								<p class="user-name mb-0"><?php echo $username?></p>
								<p class="designattion mb-0"><?php if($userrole==0){echo 'Supervisior';}else{echo 'Admin';} ?></p>
							</div>
						</a>
						<ul class="dropdown-menu dropdown-menu-end">
							<li><a class="dropdown-item" href="user_profile.php"><i class="bx bx-user"></i><span>Profile</span></a>
							</li>
							
							</li>
							<li><a class="dropdown-item" href="logout.php"><i class='bx bx-log-out-circle'></i><span>Logout</span></a>
							</li>
						</ul>
					</div>
				</nav>
			</div>
		</header>