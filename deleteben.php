<?php
	session_start();
	include "includes/db.php";
	include "includes/functions.php";

	if(isset($_GET['cid'])) {
		$cid = $_GET['cid'];

		deleteBeneficiary($conn, $cid, $_SESSION['user_id']);
	}