<?php
	session_start();

	$title = "Register";
	
	include "includes/db.php";
	include "includes/header.php";
	include "includes/validation_rules.php";
	include "includes/validation_errors.php";
//	include "SendGrid/sendgrid-php.php";
	include "includes/functions.php";

	
    

    #to improve on this later.....
	if(array_key_exists('submit', $_POST)) {
		
		check_csrf();

		$rules = $validation_rules['registration'];
		$errors = $validation_errors['registration'];

		list($validation_errors, $clean) = validateFields($conn, $rules, $_POST, $errors);

		if(empty($validation_errors)) 
			registerUser($conn, $clean);
		
	}

	include "views/register.php";
?>