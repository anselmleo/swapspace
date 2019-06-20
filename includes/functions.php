<?php
	
	function display_error($err, $key){
		if(isset($err)) {
			if(!empty($err) && array_key_exists($key, $err)){
				return '<span class="error">'.$err[$key].'</span><br/>';
			}
		}
	}


	function doesEmailExist($dbconn, $email){
		$result = false;
		$query = "SELECT email 
				  FROM customer
				  WHERE email = '$email'";
		$res = mysqli_query($dbconn, $query) or die(msqli_error($dbconn));

		if(mysqli_num_rows($res)>0) {
			$result = true;
		}

		return $result;

	}

	function doesItemExist($dbconn, $tableName, $column, $val){
		$result = false;
		$query = "SELECT * 
				  FROM {$tableName}
				  WHERE {$column} = '" . $val . "'";

		$res = mysqli_query($dbconn, $query) or die(msqli_error($dbconn));

		if(mysqli_num_rows($res)>0) {
			$result = true;
		}

		return $result;

	}

	function user_login($dbconn, $email, $password) {

		$result = "";
			
		$query = "SELECT * 
				  FROM customer 
				  WHERE email='$email'";

		$res = mysqli_query($dbconn, $query) or die(msqli_error($dbconn));
		#var_dump(mysqli_num_rows($res)); exit();
		
		if(mysqli_num_rows($res) != 1) {
			loginErrorHandler("Either username or password is incorrect!");
			exit();
		}


		$dataset = mysqli_fetch_array($res);


		if(!password_verify($password, $dataset['hash'])) {
			loginErrorHandler("Either username or password is incorrect!");
			exit();
		}
		 	
		//$result[] = true;
		$result = $dataset;

		return $result;
	}

	function startUserSession($user_data) {

		$_SESSION['user_id'] = $user_data['id'];
		$_SESSION['check_profile']= $user_data['check_profile'];
		$_SESSION['fname'] = $user_data['first_name'];
		$_SESSION['lname'] = $user_data['last_name'];
	}

	function redirect($location, $payload) {

		header("Location: {$location}{$payload}");

	}

	function loginErrorHandler($errmsg) {

		$payload = "?msg={$errmsg}";

		redirect("index.php", $payload);

	}


	function validateFields($dbconn, $rules, $post, $err){

		$validation_errors = [];
		$_trimmed = array_map('trim', $post);

		foreach ($rules as $key => $ruleset) {
			//$field = $_trimmed[$key];
			$validate_rules = explode('|', $ruleset);
			$is_error_msg = validate($dbconn, $key, $_trimmed, $validate_rules, $err);

			if($is_error_msg)
				$validation_errors[$key] = $is_error_msg;
		}

		return [$validation_errors, $_trimmed];
	}

	function validate($dbconn, $key, $formdata, $validationrules, $err){
		$_isError = false;
		$_errMsg = "";

		$field = $formdata[$key];

		foreach ($validationrules as $rule) {

			$rule = explode(':', $rule);

			switch ($rule[0]) {
				case 'empty':
					if(empty($field)){
						$_errMsg = $err[$key]['empty'];
						$_isError = true;
					}
					break;
				
				case 'is_valid_email':
					if(!filter_var($field, FILTER_VALIDATE_EMAIL)) {
						$_errMsg = $err[$key]['is_valid_email'];
						$_isError = true;
					}
					break;

				// case 'email_exists':
				// 	if(doesEmailExist($dbconn, $field)) {
				// 		$_errMsg = $err[$key]['email_exists'];
				// 		$_isError = true;
				// 	}
				// 	break;

				case 'exists':
					$table = explode('#', $rule[1]);
					$tableName = $table[0];
					$column = $table[1];
					if(!doesItemExist($dbconn, $tableName, $column, $field)) {
						$_errMsg = $err[$key]['exists'];
						$_isError = true;
					}
					break;

				case 'not_exists':
					$table = explode('#', $rule[1]);
					$tableName = $table[0];
					$column = $table[1];
					if(doesItemExist($dbconn, $tableName, $column, $field)) {
						$_errMsg = $err[$key]['exists'];
						$_isError = true;
					}
					break;

				case 'confirm_password':
					if($field != $formdata['confirm_password']) {
						$_errMsg = $err[$key]['confirm_password'];
						$_isError = true;
					}
					break;

				case 'not_numeric':
					if(is_numeric($field)) {
						$_errMsg = $err[$key]['not_numeric'];
						$_isError = true;
					}
					break;

				case 'min':
					if(strlen($field) < $rule[1]) {
						$_errMsg = $err[$key]['min'];
						$_isError = true;
					}
					break;

				case 'max':
					if(strlen($field)<$rule[1]) {
						$_errMsg = $err[$key]['max'];
						$_isError = true;
					}
					break;

				case 'numeric':
					if(!is_numeric($field)) {
						$_errMsg = $err[$key]['numeric'];
						$_isError = true;
					}
					break;

				case 'equals':
					if($field!=$formdata[$rule[1]]) {
						$_errMsg = $err[$key]['equals'];
						$_isError = true;
					}
					break;

				default:
					# code...
					break;
			}

			if($_isError) break;
		}
		
		return $_errMsg;
	}

	function registerUser($dbconn, $data) {
		extract($data);
		$hash = password_hash($password, PASSWORD_BCRYPT);

		$query = "INSERT INTO customer (email, hash)
				 VALUES ('$email', '$hash')";

		$result = mysqli_query($dbconn, $query) or die(mysqli_error($dbconn));

		if(mysqli_affected_rows($dbconn)==1) {

			// $email = new \SendGrid\Mail\Mail();
			// $email->setFrom("test@example.com", "Example User");
			// $email->setSubject("Sending with SendGrid is Fun");
			// $email->addTo("anselmleo@gmail.com", "Example User");

			// $email->addContent(
			//     "text/html", "<strong>and easy to do anywhere, even with PHP</strong>"
			// );

			// $sendgrid = new \SendGrid('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');
			// try {
			//     $response = $sendgrid->send($email);
			//     print $response->statusCode() . "\n";
			//     print_r($response->headers());
			//     print $response->body() . "\n";
			// } catch (Exception $e) {
			//     echo 'Caught exception: ',  $e->getMessage(), "\n";
			// }

			$user_data = user_login($dbconn, $email, $password);

			startUserSession($user_data);

			insertNewAccount($dbconn, $_SESSION['user_id']);

			$_isProfileFilled = hasUserFilledProfile($user_data);

			if(!$_isProfileFilled)
				redirect("dashboard.php", "");
		}
		
	}

	function insertNewAccount($dbconn, $user_id) {
		$newAccNumber = 1019002019 + 1000000000 + $user_id;
		$newBalance = rand(100000,900000);
		$newCustomerId = $user_id;
		$query = "INSERT INTO account 
				  (id,customer_id,account_no,pin,balance)
				  VALUES(NULL,$newCustomerId,$newAccNumber,NULL,$newBalance)";
		
		$result2 = mysqli_query($dbconn, $query) or die(mysqli_error($dbconn));

		if(!mysqli_affected_rows($dbconn)==1) {
			redirect("dashboard.php", "Error adding account info.");
			exit();
		}				
	}

	function hasUserFilledProfile($user_data) {

		$result = false;

		if($user_data['check_profile']==0) {
			$result = true;
			redirect('completeprofile.php', '');
		}

		return $result;
	}


	function checkLogin() {
		if(!isset($_SESSION['user_id'])){
			header('Location: index.php');
		}
	}

	function csrf_token() {
		
		if(empty($_SESSION['token'])) {
			$_SESSION['token'] = bin2hex(md5(rand()));
		}

		if(empty($_SESSION['token_expires'])) {
			$_SESSION['token_expires'] = time() + 3600;
		}

		$token = $_SESSION['token'];

		return $token;
					
	}

	function check_csrf() {
		if(!hash_equals($_SESSION['token'], $_POST['csrf_token'])) {
			redirect("csrf.php","");
			exit();
		}

		if(time() > $_SESSION['token_expires']) {
			unset($_SESSION['token_expires']);
			redirect("index.php", '');
		}
	}

	function updateProfile($dbconn, $data, $uid) {

		extract($data);
		$query = "UPDATE customer
		   		 SET first_name='$fname', last_name='$lname', check_profile=1 
		   		 WHERE id=$uid LIMIT 1";

		$result = mysqli_query($dbconn, $query) or die(mysqli_error($dbconn));
		
		if(mysqli_affected_rows($dbconn) == 1) {
			
			$_SESSION['fname'] = $fname;
			$_SESSION['lname'] = $lname;

			redirect("dashboard.php", "");
			exit();
		}
	}

	function logout() {

		unset($_SESSION);
		unset($_SESSION['token_expires']);
		session_destroy();
	}

	function createPin($dbconn, $pin, $user_id) {

		$query = "UPDATE account 
				  SET pin=$pin 
				  WHERE customer_id=$user_id";

		$result = mysqli_query($dbconn, $query) or die(mysqli_error($dbconn));

		if(mysqli_affected_rows($dbconn)==1) {
			redirect('add-pin.php','?msg=<span class="success">Pin created successfully!</span>');

		} else {
			redirect('add-pin.php','?msg=<span class="error">Error creating pin, please try again!</span>');
		}

	}

	function addBeneficiary($dbconn, $acc_no, $user_id) {

		$query = "SELECT customer_id 
		          FROM account
		          WHERE account_no=$acc_no LIMIT 1";

		$result = mysqli_query($dbconn, $query) or die(mysqli_error($dbconn));

		list($beneficiary_id) = mysqli_fetch_array($result);
		
		updateBeneficiary($dbconn, $beneficiary_id, $user_id);

	}

	function updateBeneficiary($dbconn, $ben_id, $user_id) {

		$query = "INSERT INTO beneficiary
				  VALUES (NULL,$user_id,$ben_id)";

		$result = mysqli_query($dbconn, $query) or die(mysqli_error($dbconn));

		if(mysqli_affected_rows($dbconn))
			redirect('add-beneficiaries.php', '?msg=<span class="success">Beneficiary added!</span>');
	}

	#METHOD 1 FOR SELECTING BENEFICIARY LIST
	function selectBeneficiaryList1($dbconn, $user_id) {
		$query = "SELECT b.beneficiary_id, 
		a.account_no, c.first_name, c.last_name 
		FROM account a INNER JOIN beneficiary b 
		ON a.customer_id=b.beneficiary_id 
		INNER JOIN customer c 
		ON b.beneficiary_id=c.id
		WHERE b.customer_id=$user_id";

		$result = mysqli_query($dbconn, $query) or die(mysqli_error($dbconn));

		$data = "";

		#keep fetching while there is still a record
		while($res = mysqli_fetch_array($result)) {

			$data .= '<option value="' . $res['beneficiary_id'] . '">' 
					 . $res['first_name']. ' ' . $res['last_name'] 
					 . '-' . $res['account_no'] . '</option>';
				
		}
		echo $data;
		exit();
		return $data;
	}

	#METHOD 2
	function selectBeneficiaryList($dbconn, $user_id, $templateHandler) {

		$query = "SELECT b.beneficiary_id, 
		a.account_no, c.first_name, c.last_name 
		FROM account a INNER JOIN beneficiary b 
		ON a.customer_id=b.beneficiary_id 
		INNER JOIN customer c 
		ON b.beneficiary_id=c.id
		WHERE b.customer_id=$user_id";

		$result = mysqli_query($dbconn, $query) or die(mysqli_error($dbconn));

		if(mysqli_num_rows($result) > 0) {
			render($result, $templateHandler);

		}
	}


	function render($data, $func) {
		$func($data);
	}

	$generateBeneficiaryList = function($resultSet) {
		$data = "";

		#keep fetching while there is still a record
		while($res = mysqli_fetch_array($resultSet)) {

			$data .= '<option value="' . $res['account_no'] . '">' 
					 . $res['first_name']. ' ' . $res['last_name'] 
					 . '-' . $res['account_no'] . '</option>';
				
		}
		echo $data;
	};

	$generateBeneficiaryListAsTable = function($resultSet) {
		$data = "";

		#keep fetching while there is still a record
		while($res = mysqli_fetch_array($resultSet)) {

			
			$data .= '<tr>
						<td>' . $res['first_name'] . '</td>
						<td>' . $res['last_name'] . '</td>
						<td>' . $res['account_no'] . '</td>
						<td><a href="deleteben.php?cid=' . $res['beneficiary_id'] . '">Delete</a>
					 </tr>';
				
		}
		echo $data;
	};

	function isValidPin($dbconn, $user_id, $pin) {
		$result = false;

		$query = "UPDATE account SET balance=$balance
				 WHERE customer_id=$user_id";
				 

		$res = mysqli_query($dbconn, $query) or die(mysqli_error($dbconn));
	
		if(mysqli_affected_rows($dbconn)==1) {

			$query = "UPDATE account SET balance=balance+$amount
					  WHERE account_no=$account_no";
			
			$res = mysqli_query($dbconn, $query) or die(mysqli_error($dbconn));

			if(mysqli_affected_rows($dbconn)==1) {

			redirect('transfer.php', '?msg=Transaction completed successfull!');
			exit();
			}

		}

	}

	function includeFiles(){
		ob_start();
		include "includes/db.php";
		include "includes/header.php";
		include "includes/validation_rules.php";
		include "includes/validation_errors.php";
	}

	function deleteBeneficiary($dbconn, $cid, $uid) {
		$query = "DELETE FROM beneficiary 
				 WHERE beneficiary_id=$cid AND customer_id=$uid LIMIT 1";

		$result = mysqli_query($dbconn, $query) or die(mysqli_error($dbconn));

		if(mysqli_affected_rows($dbconn)==1) {
			redirect("view-beneficiaries.php", "?msg=Beneficiary deleted successfully!");
			exit();
		}
	}
