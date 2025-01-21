<!-- View -->


<!------ User Profile Page --------
---------- By Ryan ----------
----- Edited by Stuart ------->
<div id="profileContainer">
	<?php


	if ($userDetails) {

		if (isset($userDetails["title"])) {
			$title = $userDetails["title"];
		} else {
			$title = "";
		}

		if (isset($userDetails["first_name"])) {
			$fname = $userDetails["first_name"];
		} else {
			$fname = "";
		}

		if (isset($userDetails["last_name"])) {
			$lname = $userDetails["last_name"];
		} else {
			$lname = "";
		}

		if (isset($userDetails["dob"])) {
			$dob = $userDetails["dob"];
		} else {
			$dob = "";
		}

		if (isset($userDetails["mobile_number"])) {
			$mobile = $userDetails["mobile_number"];
		} else {
			$mobile = "";
		}

		if (isset($userDetails["telephone_number"])) {
			$telnum = $userDetails["telephone_number"];
		} else {
			$telnum= "";
		}

		if (isset($userDetails["email"])) {
			$email = $userDetails["email"];
		} else {
			$email = "";
		}

		if (isLandlord()) {
			/* if (isset($accomDetails)) {
				if (isset($accomDetails["accommodation_id"])) 
					$accomID = $accomDetails["accommodation_id"];
				if (isset($accomDetails["accommodation_name"]))
					$accomName = $accomDetails["accommodation_name"];
			} */
			
		}

	?>
		<div class="row">
			<div class="col">
				<h1 style="margin-bottom: 0px;">Your Account Details</h1>
				<form style="text-align: center;">
					<p style="display: inline;">Title: </p>
					<input type="text" id="title" value="<?php echo $title;?>" style="width: 250px;" disabled/><br><br>

					<p style="display: inline;">First Name: </p>
					<input type="text" id="fname" value="<?php echo $fname;?>" style="width: 250px;" disabled/><br><br>

					<p style="display: inline; margin-right: 10px;">Last Name: </p>
					<input type="text" id="lname" value="<?php echo $lname;?>" style="width: 250px;" disabled/><br><br>

					<p style="display: inline; margin-right: 10px;">Date of Birth: </p>
					<input type="text" id="dob" value="<?php echo $dob;?>" style="width: 250px;" disabled/><br><br>

					<p style="display: inline; margin-right: 10px;">Mobile Number: </p>
					<input type="text" id="mobile" value="<?php echo $mobile;?>" style="width: 250px;" disabled/><br><br>

					<p style="display: inline; margin-right: 10px;">Telephone Number: </p>
					<input type="text" id="tel" value="<?php echo $telnum;?>" style="width: 250px;" disabled/><br><br>

					<p style="display: inline; margin-right: 10px;">Email Address: </p>
					<input type="text" id="email" value="<?php echo $email;?>" style="width: 250px;" disabled/><br>
				</form>
				<?php 
					// Errors... "Record not found."
					if(!empty($errors)) {
						echo '<div class="row errors">';
						echo errors($errors, "details");
						echo '</div>';
					}	
				?>
			</div>
			<?php if (isLandlord()) { ?>
				<div class="col">
					<div class="landlordsAccommodation">
						<h1>Your Accommodations</h1>
						<div>
							<?php if ($accomsDetails) {
								echo "<ul id='accomList' class='row'>";

								foreach ($accomsDetails as $accom) {
									echo "<li>
											<a href='{$_SERVER['PHP_SELF']}?action=details&id={$accom["accommodation_id"]}' class='listItem btn'>{$accom["accommodation_name"]}</a>
										</li>";
								}
								echo "</ul>";
							} ?>
						</div>
					</div>
					<?php
						// Errors... "Record not found."
						if(!empty($errors)) {
							echo '<div class="row errors">';
							echo errors($errors, "landlordAccomDetails");
							echo '</div>';
						}	
					?>
				</div>
			<?php } ?>
		</div>

	<?php }
	/* email, title, first_name, last_name, gender, dob, 
	telephone_number, mobile_number, parent_guardian_name,
	parent_guardian_phonenumber, parent_guardian_address, nationality */




	?>
	<?php 
	// If User is a student show the delete account button.
	if(isStudent()) { ?>

	<div class="deleteAccount" style="text-align: center;">
		<button><a href="#" style="text-decoration: none;">Delete Account</a></button>
	</div>

	<?php } // End if userRole ?>
</div>