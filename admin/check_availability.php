<?php
include("common.php");
include("checkadminlogin.php");
if(isset($_POST["Username"]) && $_POST["Username"] != "")
{
	$result = mysql_query("SELECT ID FROM users WHERE Username='" . dbinput($_POST["Username"]) . "'") or die(mysql_error());
	$user_count = mysql_num_rows($result);
	if($user_count > 0) echo "unavailable";
	else echo "available";
}
else
	echo "unavailable";
	
?>