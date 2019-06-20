<?php

	session_start();
	#page title
	$title = "Add Pin";
	include "includes/db.php";
	include "includes/functions.php";
	include "includes/header2.php";
	include "includes/validation_rules.php";
	include "includes/validation_errors.php";

	checkLogin();
	
	if(array_key_exists('submit', $_POST)) {

		check_csrf();

		$rules = $validation_rules['addpin'];
		$errors = $validation_errors['addpin'];

		list($validation_errors, $clean) = validateFields($conn, $rules, $_POST, $errors);

		if(empty($validation_errors)) {

			createPin($conn, $clean['pin'], $_SESSION['user_id']);

		}
	}

	include "views/add-pin.php";
	include "includes/footer.php";

?>
