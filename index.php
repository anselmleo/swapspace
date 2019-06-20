 <?php
	session_start();
	#page title
	$title = "swapspace bank";
	include "includes/functions.php";
	include "includes/db.php";
	include "includes/header.php";
	include "includes/validation_rules.php";
	include "includes/validation_errors.php";

	 //includeFiles();

	 //print_r($validation_rules['email']);
	 //exit();
		
	if (array_key_exists('submit', $_POST)) {

		check_csrf();

		$rules = $validation_rules['login'];
		$errors = $validation_errors['login'];

		list($validation_errors, $clean) = validateFields($conn, $rules, $_POST, $errors);

		if(empty($validation_errors)) {

			$user_data = user_login($conn, $clean['email'], $clean['password']);
			
			startUserSession($user_data);
			
			$_isProfileFilled = hasUserFilledProfile($user_data);

			if(!$_isProfileFilled)
				redirect("dashboard.php", "");
		}
	}
	
	include "views/login.php";
	
?>

