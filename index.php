<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Start output buffering
// (prevents all html output from reaching the page and instead stores it internally).
ob_start();

include "includes/db-connection.php";
include "models/model.php";
include "controllers/controller.php";

if (isLoggedIn() && $_SESSION["userRole"] === "student") {
	$favs = getFavs(getUserID());
}

include 'views/header.php';

// Declare a new variable to work with later.
$pageTitle = null;

if(isset($_GET["action"])){
	$action = $_GET['action'];
}
else {
	$action = "home";
	header("Location: {$_SERVER['PHP_SELF']}?action=home");
}

/* Under Development Pages */
if (isset($_GET["under-development"])) {
	$_SESSION["devPageTitle"] = $action;
	include "views/under-development-view.php";
}

/* Home */
elseif ($action === "home") {
	include "views/home.php";
}

/* About */
elseif ($action === "about") {
	include "views/about.php";
}

/* Login */
else if ($action === "login") {
	if(!isLoggedIn()) {
		login_signup();
		$pageTitle = "Login/Signup";
	}
	else {
		// Redirect to the login page.
		header("Location: {$_SERVER['PHP_SELF']}?action=home");
	}
}
/* Logout */
elseif ($action === "logout") {
	logout();
}


/* Browseable List */
elseif ($action === "list") {
	viewList();
	$pageTitle = "Browse Accommodations";
}


/* Accommodation Details */
// If action is details AND the id is set in the URL parameters...
elseif ($action === "details" && isset($_GET['id'])) {
	$accomName = details();
	$pageTitle = "{$accomName}";
}



/* User Profile */
elseif (isLoggedIn() && $action === "profile") {
	viewProfile();
	$pageTitle = "User Profile";
}

/* Delete Account */
elseif ($action === "deleteAccount") {
	deleteAccount($_SESSION["userID"]);
}

/* Add New Acccommodation */
elseif ($action === "add-accommodation") {
	// Restrict access to this page to only Admin or Landlord.
	if (!isAdmin() && !isLandlord()) {
		// The user doesn't have Admin privileges to access this page.
		// Send a 403 forbidden HTTP response to the server and show the 403 view.
		http_response_code(403);
		include "views/403-view.php";
	}
	else {
		addAccom();
		$pageTitle = "Add a new Accommodation";
	}
}

/* Contact */
elseif ($action === "contact") {
	viewContactUs();
	$pageTitle = "Contact";
}

/* View Applications */
elseif ($action === "view-applications") {
	$dev = "under-development";
	header("Location: {$_SERVER['PHP_SELF']}?action={$action}&{$dev}");
	$pageTitle = "View Applications";
}

/* Page not found?? */
else {
	// Send a 404 forbidden HTTP response to the server and show the 404 view.
	http_response_code(404);
	include "views/404-view.php";
}

// If action NOT login AND user ISN'T logged in...
if(($action === "profile" || $action === "view-applications" || $action === "add-accommodation") && !isLoggedIn()) {
	// Redirect to the login page.
	header("Location: {$_SERVER['PHP_SELF']}?action=login");
}

include 'views/footer.php';

/* pageBuffer function
 *
 * ob_start() atop this file stops any HTML/output reaching the page
 * and stores the output internally.
 * This is then used to be able to change the title of the page 
 * before sending everything to the page.
 *
 * Based on an answer from StackOverflow: https://stackoverflow.com/a/32337830/2358222
 */
function pageBuffer($pageTitle) {
	// Get the contents of the internal buffer and store it as a variable to be.
	$buffer = ob_get_contents();
	// Erase and disable the internal output buffer.
	ob_end_clean();

	// If page title is set, get the title and add the site/company name on to it,
	// otherwise just set the title as the site/company name.
	$pageTitle = (isset($pageTitle)) ? $pageTitle . " | Stu.Accom" : "Stu.Accom";
	// In the buffer, find and replace the <title> tag with the new page title.
	$buffer = str_replace("<title></title>", "<title>{$pageTitle}</title>", $buffer);
	
	// Return the buffer output to the function.
	return $buffer;
}
// Echo out the whole page including new page title.
echo pageBuffer($pageTitle);
?>
