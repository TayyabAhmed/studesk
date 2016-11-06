<?php
	session_start();
	$_SESSION["UserName"]=false;
	$_SESSION["Client"]=false;
	session_destroy();
	foreach(array_keys($_SESSION) as $k) unset($_SESSION[$k]);
	header("Location: ../");

	// session_start();
	// $_SESSION["Client"]=false;
	// session_destroy();
	// header("Location: index.php");
?>