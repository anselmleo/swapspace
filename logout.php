<?php
	session_start();
	include 'includes/functions.php';
	logout();
	redirect('index.php','');