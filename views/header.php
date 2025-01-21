<!DOCTYPE HTML>
<html>
<head>
<title></title>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0'>

<!-- CSS -->

<!-- Add Font Awesome icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css" integrity="sha512-10/jx2EXwxxWqCLX/hHth/vu2KY3jCF70dCQB8TSgNjbCVAC/8vai53GfMDrO2Emgwccf2pJqxct9ehpzG+MTw==" crossorigin="anonymous" referrerpolicy="no-referrer">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css">
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"/>


<link rel="stylesheet" href="css/styles.css">


<!-- JavaScripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>

<!-- Address.io no longer works due to trial expiration -->
<!-- <script src="https://cdn.getaddress.io/scripts/getaddress-autocomplete-native-1.0.1.min.js"></script> -->


<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bigslide.js/0.9.4/bigSlide.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

</head>
<body class="wrap push">
	<header>
		<?php include "navbar.php"; ?>
	</header>
	<?php if (isLoggedIn() && $_SESSION["userRole"] === "student") { ?>
		<div class="favContainer">
			<div class="favouritesBtn push"><i class="fa-solid fa-star"></i></div>
			<div id="favourites" class="panel">
				<div class="favHeader row">
					<h3>Favourites</h3>
					<div class="closeBtn"><i class="fa-solid fa-circle-xmark close"></i></div>
				</div>
				<div class="favContent">
					<?php
						include "favourites-view.php";
						favHTML($favs);
					?>
				</div>
			</div>
		</div>
	<?php } ?>
	<section class="content">