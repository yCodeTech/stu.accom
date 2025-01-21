<!-- User Profile View -->

<?php 


if ($userDetails) {
	foreach($userDetails as $key => $detail) {
		echo $key . ": " . $detail . "<br><br>";
	}
}
/* email, title, first_name, last_name, gender, dob, 
telephone_number, mobile_number, parent_guardian_name,
parent_guardian_phonenumber, parent_guardian_address, nationality */


// Errors... "Record not found."
if(!empty($errors)) {
	echo '<div class="row errors">';
	echo errors($errors, "details");
	echo '</div>';
}

?>
<?php 
// If User is a student show the delete account button.
if($_SESSION["userRole"] === "student") { ?>

<div class="deleteAccount">
	<a href="#">Delete Account</a>
</div>

<?php } // End if userRole ?>