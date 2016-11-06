<?php
	if(!isset($_SESSION['Admin']) || $_SESSION["Admin"] == true)
		redirect("../");
                  
		$self = $_SERVER['PHP_SELF'];
?>