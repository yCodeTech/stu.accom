</section>
	<footer>
		<div class="row">
			<div class="logo">
				<a <?php echo "href='{$_SERVER['PHP_SELF']}?action=home'"; ?>><img src= "images/Logo.png" alt ="Stu.Accom Logo"></a>
			</div>
			<div class="navlinks">
				<div class="col">
					<a <?php echo "href='{$_SERVER['PHP_SELF']}?action=home'"; ?> 
						class='<?php echo isActive($URLaction, "home"); ?>'>Home
					</a>
					<a <?php echo "href='{$_SERVER['PHP_SELF']}?action=about'"; ?> 
						class='<?php echo isActive($URLaction, "about"); ?>'>About Us
					</a>
					<a <?php echo "href='{$_SERVER['PHP_SELF']}?action=contact'"; ?> 
						class='<?php echo isActive($URLaction, "contact"); ?>'>Contact
					</a>
				</div>

				<div class="col">
				<a <?php echo "href='{$_SERVER['PHP_SELF']}?action=profile'"; ?> 
						class='<?php echo isActive($URLaction, "profile"); ?>'>User Profile
					</a>
					<a <?php echo "href='{$_SERVER['PHP_SELF']}?action=view-applications'"; ?> 
						class='<?php echo isActive($URLaction, "view-applications"); ?>'>View Applications
					</a>

					<a <?php echo "href='{$_SERVER['PHP_SELF']}?action=add-accommodation'"; ?> 
						class='<?php echo isActive($URLaction, "add-accommodation"); ?>'>Add New Accommodation
					</a>
				</div>
			</div>

			<div class="legal">
				<span>Terms and Conditions</span>
				
				<span>Privacy Policy</span>
				
				<span>&copy Stu.Accom | All rights reserved.</span>
			</div>
		</div>
		<div class="attribution">Designed by Team 26: The Certified Intellectuals (Apurv, Jameel, Mahir, Niloy, Ryan, Stuart) - a second year team project at University of Huddersfield.</div>
	</footer>

	<script src="https://rawgit.com/tcsehv/jquery-password-requirement-checker/master/dist/js/jquery.password-requirements-checker.min.js"></script>
	<script src="js/script.js"></script>
</body>
</html>