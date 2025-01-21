<!-- View -->
<div id="listContainer">

	<h1>Results</h1>
	<form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>?action=list" class="searchbar">
		<!-- A hidden input to send the action for the URL query string parameters. -->
		<input id="action" name="action" type="hidden" value="list">

		<input type="text" placeholder="Search by University" id="search" name="search" value="<?php echo $search ?>">
		<button type="submit" name="submit"><i class="fa fa-search"></i></button>
	</form>

	<div class="row outputMsg <?php if ($errors) echo "errors"; ?>">
		<?php
			echo "<p>". newLine($outputMsg) ."</p>";
			if ($errors) echo errors($errors, "list");
		?>
	</div>
	<?php
		if (isset($accoms)) {
			echo "<ul id='accomList' class='row'>";

			if (isset($favs)) {
				$favesArray = array();
				foreach($favs as $fav) {
					foreach($fav as $favDetails) {
						foreach($favDetails as $val) {
							if (array_key_exists("accommodation_id", $val)) {
								
								$favesArray["favID"][] = $val["accommodation_id"];
							}
						}
					}
				}
			}

			foreach ($accoms as $accom) {
				if (isset($favesArray)){
					foreach($favesArray as $key) {
						foreach($key as $id) {
							if ($accom["accommodation_id"] === $id) {
								$accom["faved"] = true;
							}
						}
					}
				}
				if (isset($accom["faved"])) {
					$favedClass = "faved";
					$favedStarClass = "fa-solid";
				}
				else {
					$favedClass = "";
					$favedStarClass = "";
				}

				echo "<li>";
						if (isLoggedIn() && isStudent()) {
							echo "<span class='fav' data-accom-id='{$accom["accommodation_id"]}'><i class='fa-regular fa-star {$favedStarClass}'></i></span>";
						}
						echo "<a href='{$_SERVER['PHP_SELF']}?action=details&id={$accom["accommodation_id"]}' class='{$favedClass}'>
						
							<span class='name'><b>{$accom["accommodation_name"]}</b></span>
							
							<span class='rent'>£{$accom["weekly_rent"]} p/w</span>
						</a>
					</li>";
			}
			echo "</ul>";
		}
	?>
</div>