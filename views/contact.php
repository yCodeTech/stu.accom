<!-- View -->

<!------ Contact Page --------
---------- By Ryan ----------
----- Edited by Stuart ------->

<!-- Contact Us -->
<div class="contact">
	<h1>Contact Us</h1>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>?action=contact" method="post">
		<div class="row">
			<div class="form-control">
				<label for="firstname">
					<span class="required">First name:</span>
					<input type="text" id="firstname" name="firstname" required>
				</label>
			</div>
			<div class="form-control">
				<label for="lastname">
					<span class="required">Last name:</span>
					<input type="text" id="lastname" name="lastname" required>
				</label>
			</div>
		</div>

		<div class="row">
			<div class="form-control">
				<label for="email">
					<span class="required">Email:</span>
					<input type="email" id="email" name="email" required>
				</label>
			</div>
			<div class="form-control">
				<label for="phone">
					<span>Phone Number:</span>
					<input type="tel" id="phone" name="phone">
				</label>
			</div>
		</div>

		<div class="row">
			<div class="form-control">
				<label for="msg">
					<span class="required">Message:</span>
					<textarea id="msg" name="msg" required></textarea>
				</label>
			</div>
		</div>
		<div class="form-control">
			<input type="submit" value="Submit">
		</div>
	</form>
</div>
	<!-- End Contact Us -->