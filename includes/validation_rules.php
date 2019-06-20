<?php

	$validation_rules = [
		'registration' => [
			'email' => 'empty|is_valid_email|not_exists:customer#email',
			'password' => 'empty|confirm_password' 
		],

		'login' => [
			'email' => 'empty|is_valid_email',
			'password' => 'empty'
		],
		'completeprofile' => [
			'fname' => 'empty|not_numeric',
			'lname' => 'empty|not_numeric'
		],

		'addpin' => [
			'pin' => 'empty|min:4|max:4|equals:cpin|numeric'
		],

		'add-beneficiaries' =>  [
			'beneficiaries' => 'empty|numeric|exists:account#account_no'
		],

		'transfer' => [
			'amount' => 'empty|numeric',
			'pin' => 'empty|min:4|max:4|numeric'		
		]
	];