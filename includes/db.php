<?php 

	# prepare database constants...
	define("DB_HOST", "localhost");
	define("DB_USER", "root");
	define("DB_PASS", "");
	define("DB_NAME", "banking");

	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS) or die(mysqli_error());

	mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn));