<!-- View -->

<div class="addAccommodation">
	<h1>Add a new Accommodation</h1>
	
	<form action="<?php echo $_SERVER['PHP_SELF'] ?>?action=add-accommodation" method="post" id="addAccom" novalidate enctype="multipart/form-data">
			<!-- Near Univeristy -->
			<!-- Future Development: University Finder API -->
		<div class="row selects">	
			<div class="select-container">
				<div class="row">
					<div class="form-control">
						<label for="nearUni">
							<span class="required">Near which University?</span>
							<div class="overflow-ellipsis">
								<select id="nearUni" name="nearUni">
									<option value="" disabled selected>Please select an option.</option>
									<?php foreach($universities as $uni) {
										// If postback variable equals the type array id,
										// then add a selected attribute.
										$selectedAttr = ($newAccom["nearUni"] === $uni["university_id"]) ? "selected" : "";

										echo "<option value='{$uni["university_id"]}' {$selectedAttr}>{$uni["name"]}</option>";
									} ?>
								</select>
							</div>
						</label>
					</div>
				</div><!-- End .row -->
				<div class="row errors">
					<?php if(isset($errors["nearUni"])) echo errors($errors, "nearUni"); ?>
				</div>
			</div><!-- End .select-container -->

			<!-- Type of Accommodation -->
			<div class="select-container">
				<div class="row">
					<div class="form-control">
						<label for="type">
							<span class="required">Type:</span>
							<div class="overflow-ellipsis">
								<select id="type" name="type">
									<option value="" disabled selected>Please select an option.</option>
									<?php foreach($types as $type) {
										// If postback variable equals the type array id,
										// then add a selected attribute.
										$selectedAttr = ($newAccom["type"] === $type["type_id"]) ? "selected" : "";

										echo "<option value='{$type["type_id"]}' {$selectedAttr}>{$type["name"]}</option>";
									} ?>
								</select>
							</div>
						</label>
					</div>
				</div><!-- End .row -->
				<div class="row errors">
					<?php if(isset($errors["type"])) echo errors($errors, "type"); ?>
				</div>
			</div><!-- End .select-container -->
		</div>

		<!-- Address -->
		<div class="row" id="autoCompleteAddress_container">
			<!-- Auto Complete -->
			<div class="form-control">
				<label for="autoCompleteAddress">
					<span>Address Search</span>
				<input type="text" id="autoCompleteAddress" name="autoCompleteAddress" value="<?php echo $newAccom["autoCompleteAddress"]; ?>" placeholder="Start typing postcode or 1st line of address">
				</label>
				<span>Dev Caveat: Autocomplete Address Lookup no longer works due to API free trial expiration.<!-- <b>API Daily Limit of 20 searches</b> --- <a href="https://api.getaddress.io/v3/usage?api-key=HRXxFmY7XE-_V5cYX2titQ34732" target="_blank">Check here for up to date</a> --></span>
			</div>
		</div>

		<div class="row">
			<!-- Accommodation Name -->
			<div class="form-control">
				<label for="accomName" class="required">Accommodation Name:</label>
				<input type="text" id="accomName" name="accomName" value="<?php echo $newAccom["accomName"]; ?>" placeholder="e.g., building name, 1st line of address, street name">
			</div>
			<!-- Building Name or Number -->
			<div class="form-control">
				<label for="buildingNameOrNum" class="required">Building Name or Number:</label>
				<input type="text" id="buildingNameOrNum" name="buildingNameOrNum" value="<?php echo $newAccom["buildingNameOrNum"]; ?>">
			</div>
			<!-- Flat Number -->
			<div class="form-control">
				<label for="flatNum">Flat Number:</label>
				<input type="text" id="flatNum" name="flatNum" value="<?php echo $newAccom["flatNum"]; ?>">
			</div>
		</div>
		<div class="row errors">
			<?php
			
			if(isset($errors["accomName"])) echo errors($errors, "accomName");
			if(isset($errors["buildingNameOrNum"])) echo errors($errors, "buildingNameOrNum");
			
			?>
		</div>
		<div class="row">
			<!-- Street -->
			<div class="form-control">
				<label for="street" class="required">Street:</label>
				<input type="text" id="street" name="street" value="<?php echo $newAccom["street"]; ?>">
			</div>
			<!-- Local Area -->
			<div class="form-control">
				<label for="localArea">Local Area:</label>
				<input type="text" id="localArea" name="localArea" value="<?php echo $newAccom["localArea"]; ?>">
			</div>
		</div>
		<div class="row errors">
			<?php if(isset($errors["street"])) echo errors($errors, "street"); ?>
		</div>
		<div class="row">
			<!-- City or Town -->
			<div class="form-control">
				<label for="cityOrTown" class="required">City or Town:</label>
				<input type="text" id="cityOrTown" name="cityOrTown" value="<?php echo $newAccom["cityOrTown"]; ?>">
			</div>
			<!-- Postcode -->
			<div class="form-control">
				<label for="postcode" class="required">Postcode:</label>
				<input type="text" id="postcode" name="postcode" value="<?php echo $newAccom["postcode"]; ?>">
			</div>
		</div>
		<div class="row errors">
			<?php
				if(isset($errors["cityOrTown"])) echo errors($errors, "cityOrTown");
				if(isset($errors["postcode"])) echo errors($errors, "postcode");
			?>
		</div>
		<div class="row">
			<!-- County -->
			<div class="form-control">
				<label for="county" class="required">County:</label>
				<input type="text" id="county" name="county" value="<?php echo $newAccom["county"]; ?>">
			</div>
			<!-- Country -->
			<div class="form-control">
				<label for="country">Country:</label>
				<input type="text" id="country" name="country" value="England" readonly>
			</div>
		</div>
		<div class="row errors">
			<?php if(isset($errors["county"])) echo errors($errors, "county"); ?>
		</div>
		
		<div class="row">
			<!-- Rent -->
			<div class="form-control">
				<label for="rent" class="required">Weekly Rent:</label>
				<input type="number" id="rent" name="rent" value="<?php echo $newAccom["rent"]; ?>" step="0.01">
			</div>
		</div>
		<div class="row errors">
			<?php if(isset($errors["rent"])) echo errors($errors, "rent"); ?>
		</div>

		<div class="row">
			<!-- Description -->
			<div class="form-control">
				<label for="description" class="required">Description:</label>
				<textarea id="description" name="description"><?php echo $newAccom["description"]; ?></textarea>
			</div>
		</div>
		<div class="row errors">
			<?php if(isset($errors["description"])) echo errors($errors, "description"); ?>
		</div>
		
		
		<div class="row form-control">
			<fieldset>
				<div class="col">
					<legend class="required">Amenities:</legend>
				</div>
				<div class="col amenities">
					<?php foreach($amenities as $amenity) {
						// Replace the spaces in the name with underscore(_) to use for the input id.
						$inputID = str_replace(' ', '_', $amenity["name"]);

						if(!empty($newAccom["amenities"]) && in_array($amenity["amenity_id"], $newAccom["amenities"]))
							$checkedAttr = "checked";
						else $checkedAttr = "";

						echo "<label for='{$inputID}'>"

							. "<span>{$amenity["name"]}</span>"

							. "<input type='checkbox' id='{$inputID}' name='amenities[]' value='{$amenity["amenity_id"]}' {$checkedAttr}>"

						. "</label>";
					} ?>
				</div>
				<div class="row">
					<!-- Description -->
					<div class="form-control">
						<label for="newAmenity">Add a new Amenity:</label>
						<input type="text" id="newAmenity" name="newAmenity" value="<?php echo $newAccom["newAmenity"]; ?>">
					</div>
					<div class="form-control">
						<button type="button" id="addNewAmenity">Add Amenity</button>
					</div>
				</div>
		
				<div class="row errors" id="addNewAmenityError">
					<?php if(isset($errors["addNewAmenity"])) echo errors($errors, "addNewAmenity"); ?>
				</div>
			</fieldset>
		</div>
		<div class="row errors">
			<?php if(isset($errors["amenities"])) echo errors($errors, "amenities"); ?>
		</div>
		


		<!-- Images -->
		<div class="row uploadImgs">
			<div class="row">
				<div class="form-control">
				<label for="images" class="required">Select images to upload:</label>
					<input type="file" name="images[]" id="imgUpload" multiple="multiple" accept="image/*" required>
					<div class="selectedFiles"></div>


					<!-- <div class="image_upload_dropzone dropzone" id="imageUpload"></div> -->
					
				</div>
			</div>
			<div class="row errors">
				<?php if(isset($errors["imgUpload"])) echo errors($errors, "imgUpload"); ?>
			</div>
		</div>


		<div class="form-control row">
			<input type="hidden" name="imageURLs[]" value="<?php if(isset($newAccom["imageURLs"])) echo $newAccom["imageURLs"]; ?>">
			<input type="submit" name="submitBtn" id="submitBtn" class="btn" value="Add Accommodation">
		</div>
	</form>
</div>