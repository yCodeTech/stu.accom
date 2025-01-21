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
	<a href="<?php echo $gobackLinkHref; ?>"><i class="fas fa-reply" style="text-align: left;" ></i>Go back to the list</a>
</div>
<div id="details_container">

	<?php
	if ($accomDetails) {
		$accom = $accomDetails["accom"];

		$desc = $accom["description"];
		$images = $accomDetails["images"];
		$amenities = $accomDetails["amenities"];

		echo "<h1 class='name' style='margin-top: 0px;'>{$accom['name']}";
		echo "<span class='price'>£{$accom['weekly_rent']} <sup>per week</sup></span>";
		echo "</h1>";

		echo "<div class='col'>";
		echo "<p style='margin-top: -15px; text-align:center'><b>{$accom['type']}</b></p>";
		echo "</div>"; // End .col

			echo "<div class='col' style='text-align:center'>";

			// Construct an array with all the address elements.
			$addressArray = array($accom['building_name_or_number'], $accom['flat_number'],
				$accom['street'], $accom['local_area'], $accom['city_town'],
				$accom['postcode'], $accom['county']);

			$address = arrayToString($addressArray);

			echo "<p style='padding: 10px;
			margin: 10px;
			background: #cbcbfd;
			border-radius: 30px;'>{$address}</p>";

        

		echo "</div>"; // End .row
        echo "<div class='descf' style='line-height: 1.5;'> 
                <p>";  echo $desc; "</p>

                </div>";

		echo "<div class='row' id='amenities'>";
		echo "<span><b>Amenities</b></span>";
		echo "<ul class='row'>";
		foreach ($amenities as $amenity) {
			echo "<li>{$amenity['amenityName']}</li>";
		}
		echo "</ul>";
		echo "</div>";

		$lightboxId = str_replace(" ", "_", $accom['name']);

		echo "<div class='gallery'>";

		foreach ($images as $image) {
			foreach ($image as $imgURL) {
				echo "<div><img src='images/uploads/{$imgURL}' alt='{$accom['name']} Photo'></div>";
			}
		}
		echo "</div>";


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
