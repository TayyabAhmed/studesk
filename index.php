<?php
include("admin/common.php");
if(isset($_SESSION["RoleID"]) && $_SESSION["RoleID"] == 1)
	redirect("admin/dashboard.php");
else if(isset($_SESSION["RoleID"]) && $_SESSION["RoleID"] == 2 && $_SESSION["Admin"] == 1)
	redirect("admin/dashboard.php");
else if(isset($_SESSION["RoleID"]) && $_SESSION["RoleID"] == 2 && $_SESSION["Admin"] == 0)
	redirect("faculty/dashboard.php");
else if(isset($_SESSION["RoleID"]) && $_SESSION["RoleID"] == 3)
	redirect("student/dashboard.php");
else
	redirect("login.php");
?>