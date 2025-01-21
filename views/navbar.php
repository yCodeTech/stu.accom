<?php $URLaction = $_GET["action"]; ?>

<!--navbar start-->
<div id='logo'>
	<a <?php echo "href='{$_SERVER['PHP_SELF']}?action=home'" ?>>
		<img src="images/Logo.png" alt="Stu.Accom Logo">
	</a>
</div>
<ul id="navbar">
	<li>
		<a <?php echo "href='{$_SERVER['PHP_SELF']}?action=home'"; ?> 
			class='<?php echo isActive($URLaction, "home"); ?>'>Home
		</a>
	</li>
	<li>
		<a <?php echo "href='{$_SERVER['PHP_SELF']}?action=about'"; ?> 
			class='<?php echo isActive($URLaction, "about"); ?>'>About Us
		</a>
	</li>
	<li>
		<a <?php echo "href='{$_SERVER['PHP_SELF']}?action=contact'"; ?> 
			class='<?php echo isActive($URLaction, "contact"); ?>'>Contact
		</a>
	</li>
	
	<?php
		// If logged in...
		if (isLoggedIn()) {
			// Display the user dropdown and logout button.
			
			// Split the user email at the point of @ and return the first part as the username.
			$username = preg_split("/[@]+/", $_SESSION["user"])[0];

			// User and Logout dropdown.
			$userDropdown = "<li id='user-dropdown'>
								<a class='user' href='#'>
									<i class='fas fa-user'></i>
									<span>{$username} <i class='fas fa-caret-down'></i></span>
								</a>
								<ul class='dropdown'>
									<li>
										<a href='{$_SERVER['PHP_SELF']}?action=profile' 
											class='". isActive($URLaction, "profile") ."'>User Profile
										</a>
									</li>
									<li>
										<a href='{$_SERVER['PHP_SELF']}?action=view-applications' 
											class='". isActive($URLaction, "view-applications") ."'>View Applications
										</a>
									</li>";


			// If user is Landlord or Admin, display the add accommodation button.
			if (isLandlord() || isAdmin()) {
				// Add Hotel button.
				$userDropdown .=	"<li>
										<a href='{$_SERVER['PHP_SELF']}?action=add-accommodation' 
											class='". isActive($URLaction, "add-accommodation") ."'>Add New Accommodation
										</a>
									</li>";
			}
			$userDropdown .=		"<li>
										<a href='{$_SERVER['PHP_SELF']}?action=logout' class='logout'>Logout</a>
									</li>
								</ul><!-- End ul.dropdown -->
							</li>";

			echo $userDropdown;
		}
		// Otherwise we're logged out, so display the login button.
		else {
	?>
			<li>
				<a <?php echo "href='{$_SERVER['PHP_SELF']}?action=login'"; ?> 
					class='<?php echo isActive($URLaction, "login"); ?>'>Login/Signup
				</a>
			</li>
<?php	} ?>
	
</ul>
<!--nav bar end-->
