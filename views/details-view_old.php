<?php

/* View */

// If newhotel parameter exists in the url query string...
if (isset($_GET["newaccom"])) {
	// A new hotel has been added...

	// Call the goBackLink function with the parameter [$newAccom] as true and get the href.
	$gobackLinkHref = goBackLink(true);

	// And echo a confirmation.
	echo "<div class='row'><h2>The new accommodation {$accomDetails["accom"]["name"]} has been added. Here are the details:</h2></div>";
}
// Otherwise, call the goBackLink function and get the href of the referring page for the list search.
else $gobackLinkHref = goBackLink();
?>

<div class="row goBack">
	<a href="<?php echo $gobackLinkHref; ?>" class="btn"><i class="fas fa-reply"></i>Go back to the list</a>
</div>
<div id="details_container">

	<?php
	if ($accomDetails) {
		$accom = $accomDetails["accom"];
		echo "<pre>";
			print_r($accom);
		echo "</pre>";
		

		$amenities = $accomDetails["amenities"];

		echo "<h1 class='name'>{$accom['name']}";
		echo "<span class='price'>£{$accom['weekly_rent']} <sup>per week</sup></span>";
		echo "</h1>";

		echo "<div class='row'>";

			echo "<div class='col'>";
			echo "<p>Type: {$accom['type']}</p>";
			echo "</div>"; // End .col

			echo "<div class='col'>";

			// Construct an array with all the address elements.
			$addressArray = array($accom['building_name_or_number'], $accom['flat_number'],
				$accom['street'], $accom['local_area'], $accom['city_town'],
				$accom['postcode'], $accom['county']);

			$address = arrayToString($addressArray);

			echo "<p>Address: {$address}</p>";
			echo "</div>"; // End .col

		echo "</div>"; // End .row
	
		echo "<div class='row' id='amenities'>";
		echo "<span>Amenities:</span>";
		echo "<ul class='row'>";
		foreach ($amenities as $amenity) {
			echo "<li>{$amenity['amenityName']}</li>";
		}
		echo "</ul>";
		echo "</div>";

		if(array_key_exists("images", $accomDetails)) {
			$images = $accomDetails["images"];
			foreach ($images as $image) {
				echo "<img src='{$image["imgURL"]}' alt='{$image["imgURL"]}'>";
			}
		}
	}	
	?>
	<?php
		// Errors...
		if(!empty($errors)) {
			echo '<div class="row errors">';
			echo errors($errors, "details");
			echo '</div>';
		}
	?>
</div> <!-- End .details_container -->