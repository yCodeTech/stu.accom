<?php
/* isLoggedIn function
 * Checks if user is logged in.
*/
function isLoggedIn() {
	if(isset($_SESSION["user"])) return true;
	else return false;
}
/* isAdmin function
 * Checks if user is an Admin.
*/
function isAdmin() {
	if($_SESSION["userRole"] === "admin") return true;
	else return false;
}
/* isLandlord function
 * Checks if user is an Landlord.
*/
function isLandlord() {
	if($_SESSION["userRole"] === "landlord") return true;
	else return false;
}
/* isStudent function
 * Checks if user is an Landlord.
*/
function isStudent() {
	if($_SESSION["userRole"] === "student") return true;
	else return false;
}
/* getUserID function
 * Gets the User ID
*/
function getUserID() {
	if(isset($_SESSION["userID"])) return $_SESSION["userID"];
}

/* isActive function
 * For the navbar links.
 * Determines whether the nav link should be active
 * according to the action in the URL.
 */
function isActive($URLaction, $actionName) {
	if ($URLaction === $actionName) return "selected";
}

function emailValidation($formType, $email, $errors) {
	// If email field is empty, throw error.
	if (empty($email)) {
		$errors["{$formType}_email"] = "Please enter your email address.";
	}
	// If email fails validation (not a proper email address), throw error.
	elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$errors["{$formType}_email"] = "Email address is not valid.\r\nEmail needs to be in the form of name@domain.extension, \r\ne.g. me@example.com";
	}
	// If email already exists in the database, throw error.
	elseif($formType === "signup" && emailExists($email)) {
		$errors["{$formType}_email"] = "This Email is already in our system. Please login instead. Or try using a different Email address.";
	}
	
	return $errors;
}

function passwordValidation($formType, $password, $confirmPassword, $errors) {
	// If password field is empty, throw error.
	if(empty($password) || empty($confirmPassword)) {
		$errors["{$formType}_password"] = "Please enter your Password.";
	}
	/* Passwords must have at least:
	* 1 uppercase letter,
	* 1 lowercase letter,
	* 1 special character,
	* and 1 number.
	* And must be 5 or more characters
	*
	* Regex based on an answer on Stack overflow
	* https://stackoverflow.com/a/5142164/2358222
	* 
	* If password doesn't match, throw error.
	*/
	elseif(!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$&*_-])(?=.*[0-9]).{5,}$/", $password)) {
		$errors["{$formType}_password"] = "Your Password isn't strong enough.\r\n\r\nPlease make sure it fulfills the requirements stated below. ";
	}
	// If confirm password field is empty, throw error.
	elseif($confirmPassword != $password) {
		$errors["{$formType}_password_match"] = "Passwords do not match.\r\n\r\nPlease make sure they are identical.";
	}

	return $errors;
}





/* goBackLink function
 * For the Accommodation details go back button.
 * Determines how to set the href of the button.
 */
function goBackLink($isNewAccommodation = false) {
	// If newAccommodation is true (a new Accommodation has been added)
	// OR the server http referer ISN'T set (by the browser),
	// then set the href to the list.
	if($isNewAccommodation === true || !isset($_SERVER['HTTP_REFERER']))
		return "{$_SERVER['PHP_SELF']}?action=list";
	
	// Otherwise, set the href to the referring page
	// (ie. previous page, specifically for the list search).
	else return $_SERVER['HTTP_REFERER'];
}

/* Errors function */
function errors($errors, $errorName) {
	if (!empty($errors)) {
		
		return $errors[$errorName] = "<div class='error'><p>". newLine($errors[$errorName]) ."</p></div>";
	}
}

/* newLine function
 * Converts the php newline \r\n in the string into html line break (<br>).
 */
function newLine($string) {
	return nl2br($string);
}
/* arrayToString function
 * Joins array elements together to form a string using a separator.
 */
function arrayToString($array) {
	return implode(" ", $array);
}

/* Function to rewrite the POST $_FILES array to a more
 * cleaner array enabling for a better way to loop through the files.
 * https://www.php.net/manual/en/features.file-upload.multiple.php#53240
 */
function reArrayFiles($file_post) {

	$file_ary = array();
	$file_count = count($file_post['name']);
	$file_keys = array_keys($file_post);

	for ($i=0; $i<$file_count; $i++) {
		foreach ($file_keys as $key) {
			$file_ary[$i][$key] = $file_post[$key][$i];
		}
	}

	return $file_ary;
}
?>