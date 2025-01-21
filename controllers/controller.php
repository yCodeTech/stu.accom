<?php
/* Controller */

include "includes/functions.php";

/* Login/Signup */
function login_signup() {
	/* Initialise variables for the postback forms */

	/* Login */
	$loginEmail = "";
	$errors = [];

	/* Forgot Password Reset */
	$resetPassword_email = "";
	$resetPassword = "";
	$resetConfirmPassword = "";

	/* Signup */
	$signupEmail = "";
	$signupPassword = "";
	$signupConfirmPassword = "";
	$firstname = "";
	$lastname = "";
	
	/* Login */
	if(isset($_POST['login_submit'])){

		$loginEmail = $_POST['loginEmail'];
		$loginPassword = $_POST['loginPassword'];
		
		// If email field is empty, throw error.
		if (empty($loginEmail)) {
			$errors["loginEmail"] = "Please enter your email address.";
		}
		// If email fails validation (not a proper email address), throw error.
		elseif (!filter_var($loginEmail, FILTER_VALIDATE_EMAIL)) {
			$errors["loginEmail"] = "Email address is not valid.\r\nEmail needs to be in the form of name@domain.extension, \r\ne.g. me@example.com";
		}

		// If password field is empty, throw error.
		if(empty($loginPassword)) {
			$errors["loginPassword"] = "Please enter your password.";
		}
		// Otherwise continue with password validation...
		if(empty($errors)) {
			// Use the function in the model to validate the password via the database.
			// If password fails validation, throw error.
			if (!validatePassword($loginEmail, $loginPassword)) {
				$errors["loginFail"] = "Wrong login details, please try again.";
			}
			// Otherwise the validation was successful, so we login...
			else {
				// Set login session
				$_SESSION["user"] = $loginEmail;
				
				// Update the datetime for the last logged in column for the user.
				updateLastLoggedIn(getUserID());

				// Logged in.

				// Redirect to the main page.
				if (isStudent())
					header("Location: {$_SERVER['PHP_SELF']}?action=home");
				else header("Location: {$_SERVER['PHP_SELF']}?action=profile");
			}
		}
	} // If isset login_submit

	/* Password Reset */
	if(isset($_POST['resetPassword_submit'])){
		$resetPassword_email = $_POST['resetPassword_email'];
		$resetPassword = $_POST['resetPassword'];
		$resetConfirmPassword = $_POST['resetConfirmPassword'];

		$errors = emailValidation("resetPassword", $resetPassword_email, $errors);
		$errors = passwordValidation("resetPassword", $resetPassword, $resetConfirmPassword, $errors);

		if (!emailExists($resetPassword_email)) {
			$errors["resetPassword_email"] = "This email address is not in our system. Please use a different email, or signup for an account.";
		}

		// Otherwise reset the password...
		if(empty($errors)) {
			$resetPassword = password_hash($resetPassword, PASSWORD_DEFAULT);

			resetPassword($resetPassword_email, $resetPassword);

			$_SESSION["passwordreset"] = "Your password has been changed. Please login.";

			header("Location: {$_SERVER['PHP_SELF']}?action=login&loginForm");
			// Somehow allows the login-view to unset the session
			// https://stackoverflow.com/a/7235153/2358222
			exit(0);
		}
	}

	/* Signup */
	if(isset($_POST['signup_submit'])){
		// trim() removes white space from start and end of strings
		// Prevents users from getting around the min characters by using spaces.
		
		$firstname = trim($_POST['firstname']);
		$lastname = trim($_POST['lastname']);
		$signupEmail = trim($_POST['signupEmail']);
		$signupPassword = $_POST['signupPassword'];
		$signupConfirmPassword = $_POST['signupConfirmPassword'];
		
		// If firstname field is empty, throw error.
		if (empty($firstname)) {
			$errors["firstname"] = "Please enter your First Name.";
		}
		// If firstname field is less than 3 characters, throw error.
		elseif (strlen($firstname) < 3) {
			$errors["firstname"] = "Your First Name must be at least 3 characters long.";
		}

		// If lastname field is empty, throw error.
		if (empty($lastname)) {
			$errors["lastname"] = "Please enter your lastname.";
		}
		// If lastname field is less than 3 characters, throw error.
		elseif (strlen($lastname) < 3) {
			$errors["lastname"] = "Your Last Name must be at least 3 characters long.";
		}

		$errors = emailValidation("signup", $signupEmail, $errors);
		$errors = passwordValidation("signup", $signupPassword, $signupConfirmPassword, $errors);
		
		// Otherwise create user and log them in...
		if(empty($errors)) {
			// Hash (encrypt) the password with a php internal salt.
			$signupPassword = password_hash($signupPassword, PASSWORD_DEFAULT);

			// Add to the database to create user.
			createUser($firstname, $lastname, $signupEmail, $signupPassword);

			// Set login session
			$_SESSION["user"] = $signupEmail;

			// Logged in.

			// Redirect to profile.
			header("Location: {$_SERVER['PHP_SELF']}?action=profile");
		}
	} // If isset signup_submit

	include "views/login-view.php";
}

/* Logout */
function logout($accountDeletedMsg = false) {
	// Unset all session keys...
	session_unset();

	// If accountDeletedMsg is false, logout message.
	if ($accountDeletedMsg === false) $msg = "You've been logged out.";
	// Otherwise, account deleted message.
	else $msg = $accountDeletedMsg;

	// Set a loggedout session so we can print a logged out message.
	$_SESSION["loggedout"] = $msg;
	
	// Go to login.
	header("Location: {$_SERVER['PHP_SELF']}?action=login");
}

/* Delete Account */
function deleteAccount($userID) {
	// Delete all user details in the database.
	delete_account($userID);
	// Send a message back to the user.
	$accountDeletedMsg = "Your account has been deleted.";
	// Logout with the message.
	logout($accountDeletedMsg);
}

/* User Profile */
function viewProfile() {
	$errors = [];
	$userID = getUserID();
	$userRole = $_SESSION["userRole"];
	// Get user details from the database.
	$userDetails = getUserDetails($userID, $userRole);
	
	if (isLandlord()) {
		$accomsDetails = getLandlordAccoms($userID);
	
		if (!$accomsDetails) {
			$errors["landlordAccomDetails"] = "No Records Found";
		}
	}
	if (!$userDetails) {
		$errors["details"] = "No Records Found";
	}
	
	include "views/user-profile.php";
}

/* Browseable List */
function viewList() {
	$search = "";
	$outputMsg = "";
	$errors = [];

	// If submit
	if (isset($_GET['submit'])) {

		// If search not empty
		if (!empty($_GET['search'])) {
			$search = $_GET['search'];

			if (isLoggedIn() && isStudent()) {
				$favs = getFavs(getUserID());
			}

			// Run the search function in the Model
			$accoms = search($search);

			// Error
			if (!$accoms) {
				$errors["list"] = "No matching Accommodations were found.";
			}
		}
		// Otherwise, search is empty...
		else {
			// No search term?
			$errors["list"] = "Please enter a University to search for accommodations.";
		}
	}
	else {
		$errors["list"] = "Please enter a University to search for accommodations.";
	}
	
	include "views/browseable-list-view.php";
}

/* Accommodation Details */
function details() {
	$accomID = $_GET['id'];
	// Get details from the model
	$accomDetails = getDetails($accomID);
	$errors = [];
	
	if (!$accomDetails) {
		$errors["details"] = "No Records Found";
	}
	
	include "views/details-view.php";

	// If Accommodation details is not false, then return the accommodation name
	// so that we can use it for the page title; otherwise return null.
	return ($accomDetails != false) ? $accomDetails["accom"]["name"] : null;
}


/* Add New Accommodation */
function addAccom() {
	// For use in the form (to add all the types/amenities).
	// (Dev note: vscode displays these variables as unused, they are used but in the view file.)

	$universities = getAccommodationAttr("universities");
	$types = getAccommodationAttr("accommodation_types");
	$amenities = getAccommodationAttr("accommodation_amenities");

	$errors = [];
	$newAccom = [];
	$amenitiesArray = [];

	// Initialise the variables for the postback form to work.
	$newAccom["nearUni"] = "";
	$newAccom["type"] = "";

	$newAccom["autoCompleteAddress"] = "";
	$newAccom["accomName"] = "";
	$newAccom["buildingNameOrNum"] = "";
	$newAccom["flatNum"] = "";
	$newAccom["street"] = "";
	$newAccom["localArea"] = "";
	$newAccom["cityOrTown"] = "";
	$newAccom["postcode"] = "";
	$newAccom["county"] = "";
	$newAccom["country"] = "";

	$newAccom["rent"] = "";
	$newAccom["description"] = "";
	$newAccom["amenities"] = "";
	$newAccom["newAmenity"] = "";

	if(isset($_POST['submitBtn'])) {
		/* POST the form elements values */
		if(isset($_POST['nearUni'])) {
			$nearUni = $_POST['nearUni'];
			$newAccom["nearUni"] = $nearUni;
		}
		if(isset($_POST['type'])) {
			$type = $_POST['type'];
			$newAccom["type"] = $type;
		}

		$autoCompleteAddress = trim($_POST['autoCompleteAddress']);
		$newAccom["autoCompleteAddress"] = $autoCompleteAddress;

		$accomName = trim($_POST['accomName']);
		$newAccom["accomName"] = $accomName;

		$buildingNameOrNum = trim($_POST['buildingNameOrNum']);
		$newAccom["buildingNameOrNum"] = $buildingNameOrNum;

		$flatNum = trim($_POST['flatNum']);
		$newAccom["flatNum"] = $flatNum;

		$street = trim($_POST['street']);
		$newAccom["street"] = $street;

		$localArea = trim($_POST['localArea']);
		$newAccom["localArea"] = $localArea;

		$cityOrTown = trim($_POST['cityOrTown']);
		$newAccom["cityOrTown"] = $cityOrTown;

		$postcode = trim($_POST['postcode']);
		$newAccom["postcode"] = $postcode;

		$county = trim($_POST['county']);
		$newAccom["county"] = $county;

		$country = trim($_POST['country']);
		$newAccom["country"] = $country;

		$rent = $_POST['rent'];
		$newAccom["rent"] = $rent;

		$description = $_POST['description'];
		$newAccom["description"] = $description;
		
		if(isset($_POST['amenities'])) {
			$amenitiesArray = $_POST['amenities'];
			$newAccom["amenities"] = $amenitiesArray;
		}


		/* Validation */

		/* Near University */
		if (!isset($nearUni)) {
			$errors["nearUni"] = "Please select a University.";
		}
		/* Type */
		if (!isset($type)) {
			$errors["type"] = "Please select an accommodation type.";
		}

		/* Address */

		/* Accommodation Name */
		if (empty($accomName)) {
			$errors["accomName"] = "Please enter the accommodation name";
		}

		/* Building Name or Number */
		if (empty($buildingNameOrNum)) {
			$errors["buildingNameOrNum"] = "Please enter the building name or number.";
		}

		/* Street */
		if (empty($street)) {
			$errors["street"] = "Please enter the street";
		}

		/* City or Town */
		if (empty($cityOrTown)) {
			$errors["cityOrTown"] = "Please enter the city or town";
		}

		/* Postcode */
		if (empty($postcode)) {
			$errors["postcode"] = "Please enter the postcode";
		}

		/* County */
		if (empty($county)) {
			$errors["county"] = "Please enter the county";
		}
		
		/* Rent */
		if (empty($rent)) {
			$errors["rent"] = "Please enter the weekly rent.";
		}
		/* Regex pattern from
		 * https://stackoverflow.com/a/19251654/2358222
		 */
		else if (!preg_match("/^\d+(\.\d{2})?$/", $rent)) {
			$errors["rent"] = "Please enter a whole number or demical number only.";
		}
		
		/* Description */
		if (empty($description)) {
			$errors["description"] = "Please enter a description.";
		}
		/* Amenities */
		if (!isset($_POST['amenities'])) {
			$errors["amenities"] = "Please select the Accommodation amenities.";
		}
		/* Images */
		if (empty($_FILES['images']['tmp_name']) || !is_uploaded_file($_FILES['images']['tmp_name'][0])) {
			$errors["imgUpload"] = "No images were uploaded. Please add some images.";
		}

		$files = $_FILES['images'];

		$file_count = count($files['name']);
		
		/* Success */

		// If errors array is empty (no errors).
		if(empty($errors)) {
			$landlordID = getUserID();

			// Call the insert Accommodation function from the model
			// and insert into the database.
			// And get back the ID.
			$accomID = insertAccom($newAccom, $landlordID);


			/* Image Upload */

			for($i = 0; $i < $file_count; $i++) {
				$directorySeparator = DIRECTORY_SEPARATOR;
				// Declare a variable for destination folder.
				$storeFolder = ".." . $directorySeparator . 'images' . $directorySeparator . 'uploads';

				// If file is sent to the page, store the file object to a temporary variable.
				$tempFile = $files['tmp_name'][$i];

				// Create the absolute path of the destination folder.
				$targetPath = dirname( __FILE__ ) . $directorySeparator . $storeFolder . $directorySeparator;

				// Create the absolute path of the uploaded file destination.
				$targetFile = $targetPath . $files['name'][$i];

				// Move uploaded file to destination.
				if ( move_uploaded_file($tempFile, $targetFile) ) {

					insertImage($accomID, $files['name'][$i]);
					// Go to the details page using the ID.
					header("Location: {$_SERVER['PHP_SELF']}?action=details&newaccom=true&id={$accomID}");
				}
			}
		}
	} // End if isset submit

	include "views/add-accommodation-view.php";
}

/* Contact */
function viewContactUs() {
	include "views/contact.php";
}



?>