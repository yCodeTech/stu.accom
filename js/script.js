// @ts-nocheck -- for preventing typescript from validating the code.

/* Prevents the any buttons that don't go anywhere (such as user dropdown) from adding hash to the url. */
$('#user-dropdown .user, .deleteAccount a, .forgotPassword a, .login_signupBtns a').on("click", function (e) {
	e.preventDefault();
});

$(".loginBtn").on("click", function () {

	const login = $("#loginSignupContainer .login");
	const signup = $("#loginSignupContainer .signup");

	if (signup.is(":visible")) {
		signup.slideUp(500);
		login.delay(800).slideDown(500);
	}
	else login.slideToggle(500);
});

$(".signupBtn").on("click", function () {

	const login = $("#loginSignupContainer .login");
	const signup = $("#loginSignupContainer .signup");

	if (login.is(":visible")) {
		login.slideUp(500);
		signup.delay(800).slideDown(500);
	}
	else signup.slideToggle(500);
});

$('.deleteAccount a').on("click", function () {
	/* jQuery Confirm plugin
	 * http://craftpip.github.io/jquery-confirm/v3.3.2/
	 */
	$.confirm({
		title: 'Delete your account?',
		content: "Are you sure? It can not be undone.",
		type: 'red',
		icon: 'fa fa-warning',
		animation: 'zoom',
		animateFromElement: false,
		theme: "material",
		buttons: {
			confirm: {
				btnClass: 'btn-red',
				action: function () {
					// Delete account

					// Redirect to the action deleteAccount

					const path = window.location.pathname;
					const url = `${path}?action=deleteAccount`;
					window.location.href = url;
				},
			},
			cancel: {}
		}
	});
});
$(".forgotPassword a").on("click", function () {
	$(this).parent().find("form").slideToggle(500);
});

$(document).ready(function () {
	/* Password Requirement visual list jQuery Plugin
	 * https://github.com/tcsehv/jquery-password-requirement-checker
	 */
	$("#signupPassword, #resetPassword").passwordRequirements({
		minLength: 5,
		classes: {
			"dirty": ""
		}
	});

	/* Show/hide password button
	 * https://www.csestack.org/hide-show-password-eye-icon-html-javascript/
	 */
	$('.togglePassword').on("click", function () {
		const form = $(this).parents("form");
		const passwordField = form.find(".password");


		passwordField.each(function (i, element) {
			const type = $(element).prop("type") === "password" ? "text" : "password";
			$(element).attr("type", type);

		});
		form.find(".fa-eye").toggleClass("fa-eye-slash");
	});
});

/* Read a page's GET URL querystrings and return them as an associative array.
 * https://stackoverflow.com/a/4656873/2358222 
 */
function getUrlQuerystrings() {
	var vars = [], hash;
	var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
	for (var i = 0; i < hashes.length; i++) {
		hash = hashes[i].split('=');
		vars.push(hash[0]);
		vars[hash[0]] = hash[1];
	}
	return vars;
}
// If resetPassword exists in the getUrlQuerystrings returning array...
if (getUrlQuerystrings().indexOf("resetPassword") > 0) {
	// Show the reset password form automatically.
	$("#loginSignupContainer .login").show();
	$(".forgotPassword form").show();
}
// If loginForm exists in the getUrlQuerystrings returning array...
if (getUrlQuerystrings().indexOf("loginForm") > 0) {
	// Show the login form automatically.
	$("#loginSignupContainer .login").show();
}
// If signupForm exists in the getUrlQuerystrings returning array...
if (getUrlQuerystrings().indexOf("signupForm") > 0) {
	// Show the login form automatically.
	$("#loginSignupContainer .signup").show();
}


/* Add Accommodation */

// Add a class to the readonly input containers
$('input[readonly]').parents('.form-control').addClass('readonly');

/* Changed after assignment hand in...
 * NO LONGER WORKS.
 * 
 * Add Accommodation Address Lookup
 * API documentation:
 * https://documentation.getaddress.io/
 */
/* getAddress.autocomplete(
	'autoCompleteAddress',
	'tmJDxMgV1Ued8jAkje3TBQ34732',
	{
		output_fields: {
			building_number: 'buildingNameOrNum',
			building_name: 'buildingNameOrNum',
			sub_building_number: 'flatNum',
			sub_building_name: 'flatNum',
			thoroughfare: 'street',
			locality: 'localArea',
			town_or_city: 'cityOrTown',
			postcode: 'postcode',
			county: 'county',
			id_prefix: 'autoCompleteAddress',
			suggestion_count: 20
		}
	}
);
$(document)
	.on("getaddress-autocomplete-suggestions-failed getaddress-autocomplete-address-selected-failed", function(e){
		console.log(e.status);
		console.log(e.message);
				
		const msg = e.status + "<br>" + e.message;
		const error = `<div class="row"><div class="errors">${msg}</div></div>`;
		$('#autoCompleteAddress_container').after(error);
	});
*/

/* Prevent Add Accommodation form from submitting by pressing enter
	* https://stackoverflow.com/a/895231/2358222
	*/
$('form#addAccom input').keydown(function (event) {
	if (event.keyCode == 13) {
		event.preventDefault();
		return false;
	}
});

/* Add New Amenity to the database */

$("#addNewAmenity").on("click", function () {
	// Remove any related errors.
	$('#addNewAmenityError .error').remove();

	const $this = $(this);
	const $input = $this.parents(".row").find("input#newAmenity");

	// Get the input value
	const val = $input.val();

	// If value is NOT empty...
	if (val != "") {
		// URL of the ajax processing script.
		const url = "includes/ajax-processing.php?action=addNewAmenity";

		// AJAX
		$.ajax({
			type: "POST",
			url: `${url}`,
			data: { newAmenity: `${val}` },
			dataType: 'json',
			encode: true,
			success: function (data) {
				// If the response data does NOT have errors.
				if (data.hasOwnProperty("error") === false) {
					// Get the amenity name.
					var name = data["amenityName"];

					// Replace any spaces with underscores
					var htmlID = name.replace(" ", "_");

					// Get the amenity ID
					const amenityID = data["amenityID"];

					// Construct the checkbox HTML
					const html = `<label for="${htmlID}"><span>${name}</span><input type="checkbox" id="${htmlID}" name="amenities[]" value="${amenityID}" checked></label>`;

					$input.val("");

					// Add the checkbox
					$('.amenities').append(html);
				}
				// Errors
				else {
					// Get the error
					const error = data["error"];

					// Add the error to the error container.
					$('#addNewAmenityError').append(`<div class='error'><p>${error}</p></div>`);
				}

			} // End Success
		});
	}
});


/* Favourites Sliding/pushing panel
 * http://ascott1.github.io/bigSlide.js
 */
$('.favouritesBtn').bigSlide({
	menu: "#favourites",
	menuWidth: "300px",
	side: "right",
	afterOpen: function () {
		$(this.menu).addClass("open");
	},
	afterClose: function () {
		$(this.menu).removeClass("open");
	}
});
$(".content, #favourites .close").on("click", function () {
	const $favbtn = $(".favouritesBtn");
	if ($favbtn.is(".active")) {
		$favbtn.trigger("click");
	}
});

/* Favourite a listing */

$("#accomList .fav").on("click", function () {

	const $this = $(this);
	const $starReg = $this.find(".fa-star");

	$starReg.toggleClass("fa-solid");

	// Get the input value
	const accomID = $this.data("accom-id");

	// URL of the ajax processing script.
	const url = "includes/ajax-processing.php?action=fav";

	// AJAX
	$.ajax({
		type: "POST",
		url: `${url}`,
		data: { favedAccomID: `${accomID}` },
		dataType: 'json',
		encode: true,
		success: function (data) {

			console.log(data);

			$('.favouritesBtn').click();

			let $favContent = $('#favourites .favContent');

			$favContent.html(data["html"]);

		} // End Success
	})
		.fail(function (jqXHR, textStatus, responseText) {
			console.log(jqXHR, textStatus, responseText, jqXHR["responseText"]);
		});
});
/* Delete Favourite */
$("#favourites").on("click", ".remove_fav", function () {
	const $parent = $(this).parent()
	const favID = $parent.data("id");

	// URL of the ajax processing script.
	const url = "includes/ajax-processing.php?action=fav&deleteFav";

	$.ajax({
		type: "POST",
		url: `${url}`,
		data: { favedAccomID: `${favID}` },
		dataType: 'json',
		encode: true,
		success: function (data) {

			console.log(data);

			$parent.hide(500).remove();

			const listpagefaved = $(`#listContainer #accomList [data-accom-id="${favID}"]`);

			console.log(listpagefaved);

			if (listpagefaved.length > 0) listpagefaved.find(".fa-star").removeClass("fa-solid");
		} // End Success
	})
		.fail(function (jqXHR, textStatus, responseText) {
			console.log(jqXHR, textStatus, responseText, jqXHR["responseText"]);
		});

});

/* Upload Images */

$('#imgUpload').on("change", function () {
	let files = this.files;
	$('.selectedFiles').empty();

	files.forEach(element => {
		$('.selectedFiles').append(`<p>${element["name"]}</p>`);
	});
	console.log(files);
});




$('.gallery').slick({
	dots: true
});






/* via Dropzone.js
* https://www.dropzone.dev/js/
* Docs: https://docs.dropzone.dev/
*/

/* const url = "includes/upload.php";
Dropzone.options.imageUpload = {
	url: `${url}`,
	uploadMultiple: true,
	addRemoveLinks: true,
	parallelUploads: 100,
	paramName: "uploadPhotos",
	clickable: ".image_upload_dropzone",
	previewsContainer: ".image_upload_dropzone",
	hiddenInputContainer: ".image_upload_dropzone",

	// The setting up of the dropzone
	init: function() {
		
		// Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
		// of the sending event because uploadMultiple is set to true.
		this.on("sendingmultiple", function() {
			if ($('.success').length > 0) $('.success').remove();

			// Gets triggered when the form is actually being sent.
			// Hide the success button or the complete form.
		});
		this.on("successmultiple", function(files, response) {
			// Gets triggered when the files have successfully been sent.
			// Redirect user or notify of success.
			$(this.element).after("<div class='success'>Images have been uploaded. Please proceed to submit the accommodation.</div>");

			var imageURLs = JSON.parse(response);

			console.log(imageURLs);

			console.log(files, response);

			const input = $("input[name='imageURLs[]']").val(JSON.stringify(imageURLs));
		});
		this.on("errormultiple", function(files, response) {
			// Gets triggered when there was an error sending the files.
			// Maybe show form again, and notify user of error
			
			console.log(files, response);
		});
	}
}; */
