<?php
	session_start();
	

	include "includes/db.php";
	include "includes/functions.php";
	include "includes/header2.php";
	include "includes/validation_errors.php";
	include "includes/validation_rules.php";


	checkLogin();

	if(array_key_exists('submit', $_POST)) {

		check_csrf();

		$rules = $validation_rules['completeprofile'];
		$errors = $validation_errors['completeprofile'];
		
		list($validation_errors, $clean) = validateFields($conn, $rules, $_POST, $errors);

		if(empty($validation_errors)) {
			updateProfile($conn, $clean, $_SESSION['user_id']);
		}

	}

 

		include "views/completeprofile.php";
		include "includes/footer2.php"; 

	?>