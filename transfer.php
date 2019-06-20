<?php
	session_start();
	$title = "Transfer";

	include "includes/header2.php";
	include "includes/db.php";
	include "includes/functions.php";
	include "includes/validation_errors.php";
	include "includes/validation_rules.php";

	
	if(array_key_exists('submit', $_POST)) {

		check_csrf();

		$rules = $validation_rules['transfer'];
		$errors = $validation_errors['transfer'];

		list($validation_errors, $clean) = validateFields($conn, $rules, $_POST, $errors);

		if(empty($validation_errors))
			executeTransfer($conn, $clean['beneficiaries'], $_SESSION['user_id'], $clean['amount'], $clean['pin']);

	}

	
	include "views/transfer.php";
	include "includes/footer.php";