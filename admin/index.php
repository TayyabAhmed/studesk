<?php
include("common.php");
if(isset($_SESSION["Status"]) && ctype_digit($_SESSION["Status"]))
	redirect("dashboard.php");
else
	redirect("../login.php");
?>