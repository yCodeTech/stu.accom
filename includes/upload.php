<?php
include "functions.php";


/* Dropzone
 * https://www.dropzone.dev/js/

 * Tutorial
 * https://startutorial.com/view/dropzonejs-php-how-to-build-a-file-upload-form 
 */

// Store directory separator (DIRECTORY_SEPARATOR) to a simple variable.
$directorySeparator = DIRECTORY_SEPARATOR;

// Declare a variable for destination folder.
$storeFolder = ".." . $directorySeparator . 'images' . $directorySeparator . 'uploads';

if (!empty($_FILES)) {

	$photos = reArrayFiles($_FILES['uploadPhotos']);
	$uploadedImgs = array();

	foreach($photos as $photo) {
		// If file is sent to the page, store the file object to a temporary variable.
		$tempFile = $photo['tmp_name'];

		// Create the absolute path of the destination folder.
		$targetPath = dirname( __FILE__ ) . $directorySeparator . $storeFolder . $directorySeparator;

		// Create the absolute path of the uploaded file destination.
		$targetFile = $targetPath . $photo['name'];

		// Move uploaded file to destination.
		if ( move_uploaded_file($tempFile, $targetFile) ) {
		
			$uploadedImgs[] = $photo['name'];
		}
	}
	if (count($uploadedImgs) > 0) {
		$response = array();
		$response["imgArray"] = $uploadedImgs;
		echo json_encode($response);
	}
	
}
else {
	echo json_encode("No files uploaded.");
}


?>