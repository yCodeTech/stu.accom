<?php

function connection() {
	// Global variables for DB connection details stored outside the htdocs.
	// Added after Uni.
	include_once __DIR__ . '/../../../.config/stu.accom_config.php';

	try {

		/* Less secure way of establishing a connection.*/
		// Changed after Uni.
		// $conn = new PDO("mysql:host={$host};dbname={$dbname}", $username, $password);
		$conn = new PDO(DB_SOURCE, DB_USER, DB_PASSWORD);
		
		/* echo "<script>console.error('PHP error reporting is on. Please turn off on live sites.');</script>"; */
		$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

		// Sets the global fetch mode for fetch() and fetchAll() to PDO::FETCH_ASSOC
		// Allows the returning array to be the keys as the column names. Otherwise default was named and zero-based keys, meaning duplicated values...
		// From StackOverflow https://stackoverflow.com/a/13843417/2358222
		$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	}
	catch (PDOException $exception) {
		echo "Oh no, there was a problem<br>" . $exception->getMessage();
	}
	return $conn;
}
function closeConnection($conn) {
	$conn = null;
}
?>