<?php
	if(!isset($_SESSION['User']) || $_SESSION["User"] == true)
		redirect("login");
		$self = $_SERVER['PHP_SELF'];
?>