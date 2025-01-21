<!-- View -->
<div id="loginSignupContainer">
	<?php
	// If logout query string exists in URL, output a logged out message.

	if (isset($_SESSION["loggedout"])) {
		echo "<div class='success loggedout'>{$_SESSION["loggedout"]}</div>";
		// Destroy the user session,
		// ie. log them out.
		session_destroy();
	}
	if (isset($_SESSION["passwordreset"])) {
		echo "<div class='success'>{$_SESSION["passwordreset"]}</div>";
		unset($_SESSION["passwordreset"]);
	}
	?>
	<div class="login_signupBtns">
		<div class="loginBtn">
			<h1>Login</h1>
		</div>
		<div class="signupBtn">
			<h1>Signup</h1>
		</div>
	</div>

	<div class="login">
		<h1>Login</h1>

		<form action="<?php echo $_SERVER['PHP_SELF']; ?>?action=login&loginForm" method="post">
			<div class="row">
				<div class="form-control">
					<label for="loginEmail">
						<span>Email:</span>
						<input type="text" id="email" name="loginEmail" value="<?php echo $loginEmail ?>">
					</label>
				</div>
				<div class="form-control">
					<label for="loginPassword">
						<span>Password:</span>
						<input type="password" id="loginPassword" name="loginPassword" class="password">
						<div class="togglePassword">
							<i class="fa-regular fa-eye"></i>
						</div>
					</label>
				</div>
				
			</div>
			<?php
				// Errors...
				echo '<div class="row errors">';
				
				if(!empty($errors)&& isset($errors["loginEmail"])) {
					echo errors($errors, "loginEmail");
				}

				if(!empty($errors) && isset($errors["loginPassword"])) {
					echo errors($errors, "loginPassword");
				}
				echo '</div>';
			?>

			<div class="form-control">
				<input type="submit" name="login_submit" class="btn" value="Login">
			</div>
		</form>
		<?php
			// Errors...
			if(!empty($errors) && isset($errors["loginFail"])) {
				echo '<div class="row errors">';
				echo errors($errors, "loginFail");
				echo '</div>';
			}
		?>
		<div class="forgotPassword">
			<a href="#">Forgot password?</a>
		
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>?action=login&resetPassword" method="post">
				<h3>Reset Password</h3>
				<div class="row">
					<!-- Email -->
					<div class="form-control">
						<label for="resetPassword_email">
							<span>Email:</span>
							<input type="text" id="resetPassword_email" name="resetPassword_email" value="<?php echo $resetPassword_email ?>">
						</label>
					</div>
					<!-- End Email -->
				</div>
					<!-- Errors -->
					<?php
						if(!empty($errors)&& isset($errors["resetPassword_email"])) {
							echo '<div class="row errors">';
							echo errors($errors, "resetPassword_email");
							echo '</div>';
						}
					?>
					<!-- End Errors -->
				
				<div class="row">
					<!-- Password -->
					<div class="form-control">
						<label for="resetPassword">
							<span>New Password:</span>
							<input type="password" id="resetPassword" name="resetPassword" class="password col">
							<div class="togglePassword">
								<i class="fa-regular fa-eye"></i>
							</div>
						</label>
					</div>
					<!-- End Password -->
					<!-- Confirm Password -->
					<div class="form-control">
						<label for="resetConfirmPassword">
							<span>Confirm New Password:</span>
							<input type="password" id="resetConfirmPassword" name="resetConfirmPassword" value="" class="password col">
							<div class="togglePassword">
								<i class="fa-regular fa-eye"></i>
							</div>
						</label>
					</div>
					<!-- End Confirm Password -->
				</div>
				<!-- Errors -->
				<?php
					if(!empty($errors)) {
						echo '<div class="row errors">';

						if(isset($errors["resetPassword_password"])) {
							echo errors($errors, "resetPassword_password");
						}

						if(isset($errors["resetPassword_confirm_password"])) {
							echo errors($errors, "resetPassword_confirm_password");
						}

						if(isset($errors["resetPassword_password_match"])) {
							echo errors($errors, "resetPassword_password_match");
						}

						echo '</div>';
					}
				?>
				<!-- End Errors -->

				<!-- Submit -->
				<div class="form-control">
					<input type="submit" name="resetPassword_submit" class="btn" value="Reset Password">
				</div>
				<!-- Password Requirements -->
				<div class="row">
					<div class="password-req-checker">
						<h3>Password must have at least:</h3>
						<ul>
							<li class="invalid lowercase">
								<span class="amount">1</span>
								<span class="requirement">Lowercase Letter</span>
							</li>
							<li class="invalid uppercase">
								<span class="amount">1</span>
								<span class="requirement">Uppercase Letter</span>
							</li>
							<li class="invalid numbers">
								<span class="amount">1</span>
								<span class="requirement">Number</span>
							</li>
							<li class="invalid specialchars">
								<span class="amount">1</span>
								<span class="requirement">Special Character</span>
							</li>
							<li class="invalid length">
								<span class="amount">5</span>
								<span class="requirement">Characters</span>
							</li>
						</ul>
					</div> <!-- End password requirements -->
				</div><!-- End row -->
			</form>
			
		</div><!-- End .forgotPassword -->
		
		<div id="dev">
			<p>For dev purposes...</p>
			<p>student@outlook.com &nbsp;&nbsp;&nbsp; Password_1</p>
			<p>landlord@outlook.com &nbsp;&nbsp;&nbsp; Letmein1!</p>
			<!--<p>admin@stu.accom &nbsp;&nbsp;&nbsp; password2</p> -->
		</div>
	</div> <!-- End .login -->
	<div class="signup">
		<h1>Signup</h1>

		<form action="<?php echo $_SERVER['PHP_SELF']; ?>?action=login&signupForm" method="post">
			<div class="row">
				<!-- First Name -->
				<div class="form-control">
					<label for="firstname">
						<span>First Name:</span>
						<input type="text" id="firstname" name="firstname" value="<?php echo $firstname ?>">
					</label>
				</div>
				<!-- End First Name -->
				<!-- Last Name -->
				<div class="form-control">
					<label for="lastname">
						<span>Last Name:</span>
						<input type="text" id="lastname" name="lastname" value="<?php echo $lastname ?>">
					</label>
				</div>
				<!-- End Last Name -->
			</div>
			<!-- Errors -->
			<?php
			if (!empty($errors)) {
				echo '<div class="row errors">';
				
				if(isset($errors["firstname"])) {
					echo errors($errors, "firstname");
				}
				if(isset($errors["lastname"])) {
					echo errors($errors, "lastname");
				}
				echo '</div>';
			}
			?>
			<!-- End Errors -->
			
			<!-- Email -->
			<div class="row">
				<div class="form-control">
					<label for="signupEmail">
						<span>Email:</span>
						<input type="text" id="signupEmail" name="signupEmail" value="<?php echo $signupEmail ?>">
					</label>
				</div>
			</div>
			<!-- End Email -->
			<!-- Errors -->
			<?php
				if(!empty($errors)&& isset($errors["signup_email"])) {
					echo '<div class="row errors">';
					echo errors($errors, "signup_email");
					echo '</div>';
				}
			?>
			<!-- End Errors -->
			
			<div class="row">
				<!-- Password -->
				<div class="form-control">
					<label for="signupPassword">
						<span>Password:</span>
						<input type="password" id="signupPassword" name="signupPassword" value="<?php echo $signupPassword ?>" class="password">
						<div class="togglePassword">
							<i class="fa-regular fa-eye"></i>
						</div>
					</label>
				</div>
				<!-- End Password -->
				<!-- Confirm Password -->
				<div class="form-control">
					<label for="signupConfirmPassword">
						<span>Confirm Password:</span>
						<input type="password" id="signupConfirmPassword" name="signupConfirmPassword" value="<?php echo $signupConfirmPassword ?>" class="password">
						<div class="togglePassword">
							<i class="fa-regular fa-eye"></i>
						</div>
					</label>
				</div>
				<!-- End Confirm Password -->
			</div>
			<!-- Errors -->
			<?php
				if(!empty($errors)) {
					echo '<div class="row errors">';

					if(isset($errors["signup_password"])) {
						echo errors($errors, "signup_password");
					}

					if(isset($errors["signup_confirm_password"])) {
						echo errors($errors, "signup_confirm_password");
					}

					if(isset($errors["signup_password_match"])) {
						echo errors($errors, "signup_password_match");
					}

					echo '</div>';
				}
			?>
			<!-- End Errors -->

			<!-- Submit -->
			<div class="form-control">
				<input type="submit" name="signup_submit" class="btn" value="Signup">
			</div>

			<div class="row">
				<div class="password-req-checker">
					<h3>Password must have at least:</h3>
					<ul>
						<li class="invalid lowercase">
							<span class="amount">1</span>
							<span class="requirement">Lowercase Letter</span>
						</li>
						<li class="invalid uppercase">
							<span class="amount">1</span>
							<span class="requirement">Uppercase Letter</span>
						</li>
						<li class="invalid numbers">
							<span class="amount">1</span>
							<span class="requirement">Number</span>
						</li>
						<li class="invalid specialchars">
							<span class="amount">1</span>
							<span class="requirement">Special Character</span>
						</li>
						<li class="invalid length">
							<span class="amount">5</span>
							<span class="requirement">Characters</span>
						</li>
					</ul>
				</div> <!-- End password requirements -->
			</div><!-- End row -->
		</form>
	</div><!-- End .signup -->
</div><!--  End #loginSignupContainer -->