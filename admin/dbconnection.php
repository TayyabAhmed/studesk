<?php
	 define("DB_HOST", "localhost");
	 define("DB_NAME", "studesk");
	 define("DB_USERNAME", "root");
	 define("DB_PASSWORD", "");

	 // define("DB_HOST", "localhost");
	 //define("DB_NAME", "ssuetdes_osms");
	//define("DB_USERNAME", "ssuetdes_osms");
	//define("DB_PASSWORD", "ssuet+2012");

	global $dbh;
	$dbh=mysql_connect (DB_HOST, DB_USERNAME, DB_PASSWORD) or die ('Could not connect to the database because: ' . mysql_error());
	mysql_select_db(DB_NAME);
?>