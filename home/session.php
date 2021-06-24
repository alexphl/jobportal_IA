<?php 
	session_start(); include 'functions.php';

	// Perform session validity checks
	$mysqli = new mysqli("127.0.0.1", "anon", "123", "SIT");
	$pass = mysqli_query($mysqli,"SELECT pword, shash FROM USERS WHERE email='{$_SESSION["email"]}' limit 1");
	$result = mysqli_fetch_array($pass); 

	// Logout if...
	// ... password changed during session
	if ($_SESSION["password"] != $result['pword']) {logout();}

	// ... session token changed
	if ($_SESSION["shash"] != $result['shash']) {logout();}

	// ... no login found
	if (is_null($_SESSION["email"])) {logout();}
?>