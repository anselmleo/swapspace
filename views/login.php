<div class="container">
	<div class="left-col">			
	</div>
	<div class="right-col">
		<div class="form-container">
			<div class="form-logo">
<!-- 					<img id="logo" src="images/logo.png" alt="logo">
-->			</div>
				<div class="form-header">
					<h3 id="form-header">Customer Portal</h3>
				</div>
			<div class="form-body">
				<h5>Please sign in to access your dashboard</h5>
					<div class="error-containter">
						<?php  
							if(isset($_GET['msg'])){
								echo '<span class="error">'.$_GET['msg'].'</span>';
							}
						?>
					
					</div>
				<form class="login-form" method="POST" action="index.php" novalidate="">
					<p><label for="email">Email</label>
						<?php echo display_error($validation_errors, 'email'); ?>
					<input type="email" name="email" novalidate=""></p>
					<p><label for="password">Password</label>
						<?php echo display_error($validation_errors, 'password'); ?>
					<input type="password" name="password"></p>
					<p><input type="checkbox" name="keep" value="keep" checked="true">Keep me signed in?</p>
					<input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
					<p><input class="submit-button" type="submit" name="submit" value="Sign In"></p>
					<p id="sign-up">Don't have an account? <a href="register.php">Sign Up</a></p>
				</form>
			</div>
		</div>
	</div>
</div>

<?php
	include "includes/footer.php";
?>