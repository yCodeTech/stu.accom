<?php
/* Model */

/* Login */
function validatePassword($email, $password) {
	$conn = connection();
	$prepare = $conn-> prepare("SELECT * FROM user_login WHERE email = :email");
	$prepare-> bindValue(':email', $email);
	$prepare-> execute();

	if($row = $prepare-> fetch()){
		if (password_verify($password, $row['password'])) {

			// Set role session.
			$_SESSION["userRole"] = $row['role'];
			$_SESSION["userID"] = $row['user_id'];
			// Added after uni.
			$_SESSION["userEmail"] = $row['email'];
			
			return true;
		}
	}
	closeConnection($conn);
}

/* updateLastLoggedIn
 * Update the user's last logged in date and time.
 */
function updateLastLoggedIn($userID) {
	$conn = connection();
	$query = "UPDATE `user_login` SET `last_signed_in`= NOW() WHERE user_id = :id";
	$prepare = $conn-> prepare($query);
	$prepare-> bindValue(':id', $userID);
	
	$prepare-> execute();
	closeConnection($conn);
}
/* emailExists
 * Checks to see if the email is already
 * in the database when signing up.
 */
function emailExists($signupEmail) {
	$conn = connection();
	$prepare = $conn-> prepare("SELECT * FROM user_login WHERE email = :email");
	$prepare-> bindValue(':email', $signupEmail);
	$prepare-> execute();

	if($prepare-> fetch()){
		return true;
	}
	closeConnection($conn);
}
function createUser($firstname, $lastname, $email, $password) {
	$conn = connection();

	$query = "INSERT INTO user_login (user_id, email, password, role, date_registered, last_signed_in)
				VALUES (NULL, :email, :password, 'student', NOW(), NOW())";
	$prepare = $conn-> prepare($query);
	$prepare-> bindValue(':email', $email);
	$prepare-> bindValue(':password', $password);
	$prepare-> execute();

	// Insert the amenities for the new Accommodation.

	// Get the ID of the new Accommodation (last inserted row ID).
	$userID = $conn-> lastInsertId();

		$query = "INSERT INTO student_details (student_id, title, first_name, last_name)
			VALUES (:student_id, '', :firstname, :lastname)";
		$prepare = $conn-> prepare($query);
		$prepare-> bindValue(':student_id', $userID);
		$prepare-> bindValue(':firstname', $firstname);
		$prepare-> bindValue(':lastname', $lastname);
		$prepare-> execute();

		// Set role and ID sessions.
		$_SESSION["userRole"] = 'student';
		$_SESSION["userID"] = $userID;

	closeConnection($conn);
}
function resetPassword($email, $password) {
	$conn = connection();
	$query = "UPDATE `user_login` SET `password`= :password WHERE email = :email";
	$prepare = $conn-> prepare($query);
	$prepare-> bindValue(':password', $password);
	$prepare-> bindValue(':email', $email);
	
	$prepare-> execute();
	closeConnection($conn);
}
function delete_account($userID) {
	$conn = connection();

	// Delete data in any table referencing the user_login table with the user id.
	// Uses DELETE CASCADE
	// https://www.javatpoint.com/mysql-on-delete-cascade#:~:text=ON%20DELETE%20CASCADE%20clause%20in,related%20to%20the%20foreign%20key
	$query = "DELETE FROM user_login WHERE user_id = :student_id";
	$prepare = $conn-> prepare($query);
	$prepare-> bindValue(':student_id', $userID);
	$prepare-> execute();

	closeConnection($conn);
}
function getLandlordAccoms($id) {
	$conn = connection();

	$query = "SELECT accommodation_id, accommodation_name FROM `accommodations` WHERE landlord_id = :id";

	$prepare = $conn-> prepare($query);
	$prepare-> bindValue(':id', $id);
	$prepare-> execute();

	$accomsDetails = $prepare-> fetchAll();

	closeConnection($conn);

	if ($accomsDetails) return $accomsDetails;
	else return false;

}
function getUserDetails($userID, $userRole) {
	$conn = connection();
	/* Using LEFT JOIN ensures the query still returns the columns 
	 * in the joining tables even if there's no data.
	 * https://stackoverflow.com/a/4076157/2358222
	 */
	$query = "SELECT * FROM `user_login`
				LEFT JOIN `{$userRole}_details` ON user_login.user_id = {$userRole}_details.{$userRole}_id ";
	// If user is student...
	if ($userRole === "student") {
		// Join the nationality tables on the query.
		$query .= "LEFT JOIN `student_nationalities` ON student_details.student_id = student_nationalities.student_id
		LEFT JOIN `nationalities` ON student_nationalities.nationality_id = nationalities.nationality_id
		WHERE user_login.user_id = :id";
	}
	else {
		$query .= "WHERE user_login.user_id = :id";
	}

	$prepare = $conn-> prepare($query);
	$prepare-> bindValue(':id', $userID);
	$prepare-> execute();

	$userDetails = $prepare-> fetch();

	closeConnection($conn);

	if ($userDetails) return $userDetails;
	else return false;
}

/* Browseable List */

// Select all Accommodations where name relates to a search term function
function search($search) {
	$conn = connection();

	$query = "SELECT * FROM accommodations
		INNER JOIN universities ON accommodations.university_id = universities.university_id
		WHERE universities.name LIKE :search";
	$prepare = $conn-> prepare($query);
	$prepare-> bindValue(':search', '%'. $search .'%');
	$prepare-> execute();


	$accoms = $prepare-> fetchAll();

	


	closeConnection($conn);
	return $accoms;
	
}

/* Details */
function getDetails($accomID, $getFaved = false) {
	$conn = connection();

	/* Accommodation */
	$query = "SELECT *, accommodations.accommodation_name AS name, accommodation_types.name AS type FROM accommodations
				INNER JOIN accommodation_types ON accommodations.type_id = accommodation_types.type_id
				WHERE accommodations.accommodation_id = :id";

	$prepare = $conn-> prepare($query);
	$prepare-> bindValue(':id', $accomID);
	$prepare-> execute();

	if ($getFaved === false) {
		$accom = $prepare-> fetch();
	}
	else {
		$accom = $prepare-> fetchAll();
	}

	/* Amenities */
	$query = "SELECT accommodation_amenities.name as amenityName FROM accommodations
				INNER JOIN amenity_accommodation ON accommodations.accommodation_id = amenity_accommodation.accommodation_id
				INNER JOIN accommodation_amenities ON amenity_accommodation.amenity_id = accommodation_amenities.amenity_id
				WHERE accommodations.accommodation_id = :id";
	$prepare = $conn-> prepare($query);
	$prepare-> bindValue(':id', $accomID);
	$prepare-> execute();

	$amenities = $prepare-> fetchAll();

	/* Images */
	$query = "SELECT accommodation_images.image_url as imgURL FROM accommodations
				INNER JOIN accommodation_images ON accommodations.accommodation_id = accommodation_images.accommodation_id
				WHERE accommodations.accommodation_id = :id";
	if ($getFaved === true) {
		$query .= " LIMIT 1;";
	}

	$prepare = $conn-> prepare($query);
	$prepare-> bindValue(':id', $accomID);
	$prepare-> execute();

	$images = $prepare-> fetchAll();

	closeConnection($conn);

	$accomDetails = ["accom" => $accom, "amenities" => $amenities];
	
	if ($images) $accomDetails["images"] = $images;
	
	if ($accom && $amenities) return $accomDetails;
	else return false;
}

/* Add Accommodation */

// Get Accommodation attributes (types, amenities)
// Using one function to avoid 2 near-identical code...
function getAccommodationAttr($tableName) {
	$conn = connection();

	$query = "SELECT * FROM {$tableName}";
	$result = $conn-> query($query);

	closeConnection($conn);
	return $result->fetchAll();
}

/* Insert Accommodation function */
function insertAccom($newAccom, $landlord_id) {
	$conn = connection();

	$uni_id = $newAccom["nearUni"];
	$type_id = $newAccom["type"];

	$accomName = $newAccom["accomName"];
	$building_nameORnum = $newAccom["buildingNameOrNum"];
	$flat_num = $newAccom["flatNum"];
	$street = $newAccom["street"];
	$local_area = $newAccom["localArea"];
	$city_town = $newAccom["cityOrTown"];
	$postcode = $newAccom["postcode"];
	$county = $newAccom["county"];
	$country = $newAccom["country"];

	$rent = $newAccom["rent"];
	$description = $newAccom["description"];
	$amenities = $newAccom["amenities"];


	$query = "INSERT INTO accommodations (accommodation_id, university_id, type_id, landlord_id, accommodation_name, building_name_or_number, flat_number, street, local_area, city_town, postcode, county, country, description, weekly_rent)
				VALUES (NULL, :uni_id, :type_id, :landlord_id, :accomName, :building_nameORnum, :flat_num, :street, :local_area, :city_town, :postcode, :county, :country, :description, :rent)";
	$prepare = $conn-> prepare($query);
	$prepare-> bindValue(':uni_id', $uni_id);
	$prepare-> bindValue(':type_id', $type_id);
	$prepare-> bindValue(':landlord_id', $landlord_id);
	
	$prepare-> bindValue(':accomName', $accomName);
	$prepare-> bindValue(':building_nameORnum', $building_nameORnum);
	$prepare-> bindValue(':flat_num', $flat_num);
	$prepare-> bindValue(':street', $street);
	$prepare-> bindValue(':local_area', $local_area);
	$prepare-> bindValue(':city_town', $city_town);
	$prepare-> bindValue(':postcode', $postcode);
	$prepare-> bindValue(':county', $county);
	$prepare-> bindValue(':country', $country);
	
	$prepare-> bindValue(':description', $description);
	$prepare-> bindValue(':rent', $rent);
	
	$prepare-> execute();

	/* Insert the amenities for the new Accommodation. */

	// Get the ID of the new Accommodation (last inserted row ID).
	$accomID = $conn-> lastInsertId();

	// Loop through the amenities array and insert each amenity ID into the database
	// along with the new Accommodation ID.
	foreach($amenities as $amenityID) {
		$query = "INSERT INTO amenity_accommodation (amenity_id, accommodation_id)
			VALUES (:amenity_id, :accom_id)";
		$prepare = $conn-> prepare($query);
		$prepare-> bindValue(':amenity_id', $amenityID);
		$prepare-> bindValue(':accom_id', $accomID);
		$prepare-> execute();
	}
	closeConnection($conn);
	
	return $accomID;
}

/* amenityExists
 * Checks to see if the new Amenity is already
 * in the database.
 */
function amenityExists($newAmenity) {
	$conn = connection();
	$prepare = $conn-> prepare("SELECT * FROM accommodation_amenities WHERE name = :name");
	$prepare-> bindValue(':name', $newAmenity);
	$prepare-> execute();

	if($prepare-> fetch()){
		return true;
	}
	closeConnection($conn);
}

/* Add New Amenity */
function addNewAmenity($newAmenity){

	$data = array();

	$conn = connection();

	$query = "INSERT INTO accommodation_amenities (amenity_id, name)
	VALUES (NULL, :name)";

	$prepare = $conn-> prepare($query);
	$prepare-> bindValue(':name', $newAmenity);

	$prepare-> execute();

	$amenityID = $conn-> lastInsertId();

	closeConnection($conn);
	
	$data["amenityID"] = $amenityID;
	$data["amenityName"] = $newAmenity;

	return $data;
}
function insertImage($accomID, $filename) {
	$conn = connection();

	$query = "INSERT INTO accommodation_images (id, accommodation_id, image_url)
		VALUES (null, :accom_id, :image_url)";
	$prepare = $conn-> prepare($query);
	$prepare-> bindValue(':accom_id', $accomID);
	$prepare-> bindValue(':image_url', $filename);
	$prepare-> execute();

	closeConnection($conn);
}

/* alreadyFaved
 * Checks to see if the accommodation is already favourited
 * and stored in the database.
 */
function alreadyFaved($userID, $favedID) {
	$conn = connection();
	$prepare = $conn-> prepare("SELECT * FROM favourites WHERE student_id = :id AND accommodation_id = :favID");
	$prepare-> bindValue(':id', $userID);
	$prepare-> bindValue(':favID', $favedID);
	$prepare-> execute();

	if($prepare-> fetch()){
		return true;
	}
	closeConnection($conn);
}

/* Favourite an accommodation */
function favAccom($userID, $favedID){

	$conn = connection();

	$query = "INSERT INTO favourites (student_id, accommodation_id)
	VALUES (:id, :accomID)";

	$prepare = $conn-> prepare($query);
	$prepare-> bindValue(':id', $userID);
	$prepare-> bindValue(':accomID', $favedID);

	$prepare-> execute();
	
	return true;
}
/* Unfavourites an accommodation */
function deletefav($userID, $favedID) {
	$conn = connection();

	$query = "DELETE FROM favourites WHERE student_id = :id AND accommodation_id = :favedID";
	$prepare = $conn-> prepare($query);
	$prepare-> bindValue(':id', $userID);
	$prepare-> bindValue(':favedID', $favedID);
	$prepare-> execute();

	closeConnection($conn);
}
function getFavs($userID) {
	$conn = connection();

	$query = "SELECT * FROM favourites WHERE student_id = :id";

	$prepare = $conn-> prepare($query);
	$prepare-> bindValue(':id', $userID);

	$prepare-> execute();

	$favsArray = array();

	if($favs = $prepare-> fetchAll()){
		foreach($favs as $fav) {
				$favsArray[$fav["accommodation_id"]] = getDetails($fav["accommodation_id"], true);

				
		}
	}
	
	closeConnection($conn);
	return $favsArray;
}

?>