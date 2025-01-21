<!-- View -->

<!------ Home Page --------
---------- By Jameel ----------
----- Edited by Stuart ------->

<div id="homeContainer">
	<!--form and headings-->

	<div id='accomHead'>
		<div class="headingContainer">
			<h1>Accomodation Starts Here</h1>
			<h3>We make locating and booking accommodation easy</h3>
		
			<form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>?action=list" class="searchbar">
				<!-- A hidden input to send the action for the URL query string parameters. -->
				<input id="action" name="action" type="hidden" value="list">

				<input type="text" placeholder="Search by University" id="search" name="search">
				<button type="submit" name="submit"><i class="fa fa-search"></i></button>
			</form>
		</div>
	</div>

	<div id='help'>
		<h1>Let us help you...</h1>

		<ul class="row">
			<li class="row"><i class="fa fa-check-circle"></i>Up-to-date information on accommodations provided, along with landlord portals for them to update their listings</li>
			<li class="row"><i class="fa fa-building"></i>All facilities are listed in each accommodation, allowing you to see exactly what each place has to offer</li>
			<li class="row"><i class="fa-regular fa-pen-to-square"></i>The ability to view and sign contracts on the site directly, without having to redirect to different sites</li>
		</ul>
			<div class="row images">
				<div class="column">
					<img src="images/home/Accom1.png" alt="Accomodation 1">
				</div>
				<div class="column">
					<img src="images/home/Accom2.png" alt="Accomodation 2">
				</div>
				<div class="column">
					<img src="images/home/Accom3.png" alt="Accomodation 3">
				</div>
			</div>
	</div>
</div>

