<div class="container">
		<div class="nav">
			<div>
				<img id="nav-logo" src="images/swapspace-logo2.png" alt="Logo">
			</div>
			
			<span id="logout-button"><a href="logout.php">Logout</a></span>
		</div>
		<div class="main">
			<p> 
				Hello 
				<?php
					if(!empty($_SESSION['fname'])) {

					echo $_SESSION['fname'] . " " . $_SESSION['lname'] . ",";

					} else {

						echo "Customer,";

					}
				?>
			</p>
			<br><br><br>
		</div>
			<div class=inner-main-profile>
				<form method="POST">
					<h3>Please complete your profile to continue</h3><br>
					<?php 
						if(!empty($_GET['msg'])) {
							echo '<span class="error">'.$_GET['msg'].'</span>';
						}
					?>
					<label for="fname">First Name:
						<?php echo display_error($validation_errors, 'fname'); ?>
					</label><br>
					<input type="text" name="fname"><br><br>

					<label for="lname">Last Name:
						<?php echo display_error($validation_errors, 'lname'); ?>
					</label><br>
					<input type="text" name="lname"><br><br>
					<input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
					<input class="submit-button" type="submit" name="submit" value="Submit">
				</form>
			</div>
		</div>