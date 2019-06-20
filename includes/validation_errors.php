<?php

	$validation_errors = [
		'registration' => [
			'email' => [
				'empty' => 'Please enter email!',
				'is_valid_email'=> 'Please enter a valid email address!',
				'exists' => 'Email already exists'
			],

			'password' => [
				'empty' => 'Please enter password!',
				'confirm_password' => 'The passwords do not match'
			]
		],

		'login' => [
			'email' => [ 
				'empty' => 'Please enter email!',
				'is_valid_email' => 'The email address is not valid!'
			],
			'password' => ['empty' => 'Please enter password!']

		],

		'completeprofile' => [
			'fname' => [
				'empty' => 'Please enter first name',
				'not_numeric' => 'Invalid characters, numbers not allowed for this field'
			],
			'lname' => [
				'empty' => 'Please enter first name',				
				'not_numeric' => 'Invalid characters, numbers not allowed for this field'
			]
		],

		'addpin' => [
			'pin' => [
				'empty' => 'Please enter pin',
				'min' => 'Please enter up to four digits',
				'max' => 'Please enter a maximum of four digits',
				'equals' => 'PIN does match',
				'numeric' => 'Invalid characters, only digits allowed'
			]
		],

		'add-beneficiaries' => [
			'beneficiaries' => [
				'empty' => 'Please enter beneficiary account number',
				'numeric' => 'Please enter numeric characters only',
				'exists' => 'Account number does not exist'
			]
		],

		'transfer' => [
			'amount' => ['numeric' => 'Invalid characters, only digits allowed',
			'empty' => 'Please enter amount'
		],
			'pin' => [
				'empty' => 'Please enter pin',
				'min' => 'Please enter up to four digits',
				'max'=> 'Please enter a maximum of four digits',
				'equals' => 'PIN does match',
				'numeric' => 'Invalid characters, only digits allowed'
			]
		]

	];