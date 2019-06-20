<div class="container">
	<div class="left-col2">			
	</div>
	<div class="right-col2">
		<div class="form-container">
			<div class="form-logo">
<!-- 					<img id="logo" src="images/logo.png" alt="logo">
-->			</div>
				<div class="form-header">
					<h3 id="form-header">Register</h3>
				</div>
			<div class="form-body">
				<h5>Start banking online today!</h5>
				<form class="login-form" method="POST" novalidate="">
					<p>
						<label for="email">Email</label>
						<?php echo display_error($validation_errors, 'email'); ?>
						<input type="email" name="email" novalidate="">
					</p>
					<p>
						<label for="password">Password</label>
						<?php echo display_error($validation_errors, 'password'); ?>
						<input type="password" name="password">
					</p>
					<p>
						<label for="cpassword">Confirm Password</label>
						<?php echo display_error($validation_errors, 'confirm_password'); ?>
						<input type="password" name="confirm_password">
					</p>
					<p>
						<input type="checkbox" name="keep" value="keep">Accept  <a href="#"><em>Terms and Conditions</em></a><span> | Have an account? <a href="index.php">Sign In</a></span>
					</p>
					<input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
					<p><input class="submit-button" type="submit" name="submit" value="Sign Up"></p>
					<p id="sign-up"></p>
				</form>
			</div>
		</div>
	</div>
</div>
	
<?php
	include "includes/footer.php";
?>
