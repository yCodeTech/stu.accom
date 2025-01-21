<?php

session_start();

include "functions.php";
include "db-connection.php";
include "../models/model.php";


if(isset($_GET["action"]) && $_GET["action"] === "addNewAmenity"){

	$newAmenity = $_POST['newAmenity'];

	if (!amenityExists($newAmenity)) {
		$newAmenityReturn = addNewAmenity($newAmenity);

		echo json_encode($newAmenityReturn);
	}
	else {
		$error = array();

		$error["error"] = "This amenity already exists.";
		echo json_encode($error);
	}
}

/* Favourites */
elseif(isset($_GET["action"]) && $_GET["action"] === "fav"){

	$favedID = $_POST['favedAccomID'];
	$userID = getUserID();
	$response = array();

	if (!alreadyFaved($userID,$favedID)) {

			$saved = favAccom($userID, $favedID);
			if ($saved) {
				$favs = getFavs(getUserID());
				$response["text"] = "newFav";
			}
	}
	else {
		deletefav($userID, $favedID);
		$favs = getFavs(getUserID());
		$response["text"] = "deleted";
	}

	
	include "../views/favourites-view.php";
	$ajax = true;

	$response["html"] = favHTML($favs, $ajax);
	echo json_encode($response);
}

/* Favourites */
elseif(isset($_GET["action"]) && $_GET["action"] === "fav" && isset($_GET["deleteFav"])){

	$favedID = $_POST['favedAccomID'];
	$userID = getUserID();

	deletefav($userID, $favedID);
	$response = "deleted";

	echo json_encode($response);
}

?>