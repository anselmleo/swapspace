<?php
	session_start();
	$title = "Add Beneficiaries";

	include "includes/db.php";
	include "includes/header2.php";
	include "includes/functions.php";
	include "includes/validation_errors.php";
	include "includes/validation_rules.php";

	if(array_key_exists('submit', $_POST)) {

		check_csrf();

		$rules = $validation_rules['add-beneficiaries'];
		$errors = $validation_errors['add-beneficiaries'];

		list($validation_errors, $clean) = validateFields($conn, $rules, $_POST, $errors);

		if(empty($validation_errors))
			addBeneficiary($conn, $clean['beneficiaries'], $_SESSION['user_id']);

	}

	include "views/add-beneficiaries.php";
	include "includes/footer.php";