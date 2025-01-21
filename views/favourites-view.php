<?php
function favHTML($favs, $ajax = false) {
	$favHTML = "";

	if($favs) {
		/* echo "<pre>";
		var_dump($favs);
		echo "</pre>"; */

		$favHTML .= "<ul class='col'>";

		foreach($favs as $fav) {
			foreach($fav as $favDetails) {
				foreach($favDetails as $val) {

					if (isset($val["accommodation_id"])) {
						$id = $val["accommodation_id"];

						$favHTML .= "<li data-id='$id' class='row'>";

							$favHTML .= "<span class='remove_fav'><i class='fa-solid fa-circle-minus'></i></span>";
							
							$favHTML .= "<div><a href='index.php?action=details&id={$id}' class='row'>";

								$favHTML .="<span class='name'><b>{$val["accommodation_name"]}</b></span>";

								$favHTML .= "<span class='rent'>£{$val["weekly_rent"]} p/w</span>";
						
					}
					
					if (isset($val["imgURL"])) {
						
						$img = $val["imgURL"];

						//$alt = $img

						$favHTML .= "<img src='images/uploads/{$img}' alt='{$img} photo' class='favedImg'>";
					}
					

				
				} // End foreach favDetails -> val
			} // End foreach fav -> favDetails
			$favHTML .= "</a></div>";
			$favHTML .= "</li>";
		} // End foreach favs -> fav
		
		$favHTML .= "</ul>";

	} // End if favs
	if (!$ajax){
		echo $favHTML;
	}
	// Ajax, return to ajax processing for a json encode.
	else {
		return $favHTML;
	}
}
?>