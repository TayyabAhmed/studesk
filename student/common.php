<?php session_start();
	$self  = $_SERVER['PHP_SELF'];

	include("dbconnection.php"); 
	
	$Theme= 0;
	$path= explode("/", $_SERVER["PHP_SELF"]);

	$settingResultSet=mysql_query("SELECT * FROM configurations ") or die(mysql_error());
	$settingRecordSet=mysql_fetch_assoc($settingResultSet);
	define("FULL_NAME", dboutput($settingRecordSet["FullName"]));
	define("COMPANY_NAME", dboutput($settingRecordSet["CompanyName"]));
	define("SITE_TITLE", dboutput($settingRecordSet["SiteTitle"]));
	define("DOMAIN", dboutput($settingRecordSet["Domain"]));
	define("ADDRESS", dboutput($settingRecordSet["Address"]));
	define("EMAIL", dboutput($settingRecordSet["Email"]));
	define("PHONE", dboutput($settingRecordSet["Phone"]));
	define("FAX_NUMBER", dboutput($settingRecordSet["FaxNumber"]));
	define("MOBILE", dboutput($settingRecordSet["Mobile"]));
	define("LOGO", dboutput($settingRecordSet["Logo"]));
	define("SMS_USERNAME", dboutput($settingRecordSet["SMSUsername"]));
	define("SMS_PASSWORD", dboutput($settingRecordSet["SMSPassword"]));
	define("Captcha_VERIFICATION", dboutput($settingRecordSet["CaptchaVerification"]));
	
	define("NOREPLY_EMAIL_ADDRESS", "no-reply@".DOMAIN);
	define("ENCRYPRTION_KEY", pack('H*', "5cb04b7e105a0cd8554763a51caf08bc55abee29fdebae5ebd417e2fdb2a40f2"));
	
	define("SITE_URL", "http://".DOMAIN);
	define("SITE_URL_SSL", "https://".DOMAIN);
	
	define("TITLE", SITE_TITLE." Administration");
	define("COPYRIGHT", "Copyright &copy; ".date("Y")." <a href=\"".SITE_URL."\" target=\"_blank\">".SITE_TITLE."</a>, All rights reserved.");
	
	define("MANDATORY", "<span class=\"mandatory noPrint\">*</span>");
	define("THUMB_WIDTH", 72); //In Pixel
	define("THUMB_HEIGHT", 72); //In Pixel
	define("INDENT", "&nbsp;&nbsp;&nbsp;");
	define("MAX_IMAGE_SIZE", 5120); //In KB
	
	define("DIR_USER_IMAGES", "../assets/images/user_images/");
	define("DIR_LOGO_IMAGE", "../assets/images/logo/");
	
//	date_default_timezone_set("Asia/Karachi");
	date_default_timezone_set('Etc/GMT+5');
	
	$_AD = array("<i class=\"fa fa-fw fa-times-circle\"></i>", "<i class=\"fa fa-fw fa-check-circle\"></i>");
	
	$_IMAGE_ALLOWED_TYPES = array("jpg","JPG","jpeg","JPEG","PNG","png","GIF","gif");
	$Gender_Array = array("Select Gender","Male","Female");
	$Days_Array = array("Monday","Tuesday","Wednesday","Thursday","Friday");
	$Periods_Array = array("1" => "1st" , "2" => "2nd" , "3" => "3rd" , "4" => "4th","5" => "5th" , "6" => "6th", "7" => "7th" , "8" => "8th");
	$Months_Array = array("January","February","March","April","May","June","July","August","September","October","November","December");
	$OfficeType = array("0" => "Select Office Type" , "1" => "FWC" , "2" => "RHS-A" , "3" => "MSUs");

	function redirect($url)
	{
		header("Location: " . $url);
		exit();
	}
	
	function backup_tables($host,$user,$pass,$name,$tables)
	{
		$return='';	
		$link = mysql_connect($host,$user,$pass);
		mysql_select_db($name,$link);
		
		//get all of the tables
		if($tables == '*')
		{
			$tables = array();
			$result = mysql_query('SHOW TABLES');
			while($row = mysql_fetch_row($result))
			{
				$tables[] = $row[0];
			}
		}
		else
		{
			$tables = is_array($tables) ? $tables : explode(',',$tables);
		}
		
		//cycle through
		foreach($tables as $table)
		{
			$result = mysql_query('SELECT * FROM '.$table);
			$num_fields = mysql_num_fields($result);
			
			$return.= 'DROP TABLE IF EXISTS '.$table.';';
			$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
			$return.= "\n\n".$row2[1].";\n\n";
			
			for ($i = 0; $i < $num_fields; $i++) 
			{
				while($row = mysql_fetch_row($result))
				{
					$return.= 'INSERT INTO '.$table.' VALUES(';
					for($j=0; $j<$num_fields; $j++) 
					{
						$row[$j] = addslashes($row[$j]);
						$row[$j] = ereg_replace("\n","\\n",$row[$j]);
						if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
						if ($j<($num_fields-1)) { $return.= ','; }
					}
					$return.= ");\n";
				}
			}
			$return.="\n\n\n";
		}
	
	//save file
	//	$handle = fopen('db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql','w+');
	//	fwrite($handle,$return);
	//	fclose($handle);

	//	header('Pragma: anytextexeptno-cache', true);
	//	header("Pragma: public");
	//	header("Expires: 0");
	//	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	//	header("Cache-Control: private", false);
		header("Content-Type: text/plain");
		header("Content-Disposition: attachment; filename=\"dbbackup_".date('DMY').(date('G')+3).date('ia').".sql\"");
		echo $return; exit();
	
	}
	
	function validEmailAddress($email_address)
	{
		if(strpos($email_address, " ") > 0)
			return false;
		else

		//return preg_match("^(([\w-]+\.)+[\w-]+|([a-zA-Z]{1}|[\w-]{2,}))@((([0-1]?[0-9]{1,2}|25[0-5]|2[0-4][0-9])\.([0-1]?[0-9]{1,2}|25[0-5]|2[0-4][0-9])\.([0-1]?[0-9]{1,2}|25[0-5]|2[0-4][0-9])\.([0-1]?[0-9]{1,2}|25[0-5]|2[0-4][0-9])){1}|([a-zA-Z]+[\w-]+\.)+[a-zA-Z]{2,4})$^", $email_address);
		
		return filter_var($email_address, FILTER_VALIDATE_EMAIL);
	}
	
	function dbinput($string, $allow_html = false)
	{
		global $dbh;
		
		if($allow_html == false)
			$string = strip_tags($string);
		
		if (function_exists('mysql_real_escape_string'))
			return mysql_real_escape_string($string, $dbh);
		else if (function_exists('mysql_escape_string'))
			return mysql_escape_string($string);
		
		return addslashes($string);
	}
	
	function dboutput($string)
	{
		return stripslashes($string);
	}
	
	function not_null($value)
	{
		if (is_array($value))
		{
			if (sizeof($value) > 0)
				return true;
			else
				return false;
		}
		else
		{
			if ((is_string($value) || is_int($value)) && ($value != '') && ($value != 'NULL') && (strlen(trim($value)) > 0))
				return true;
			else
				return false;
		}
	}

	function generate_password()
	{
		$pass = "";
		$salt = "ABCDEFGHIJKLMNOPQRSTUVWXWZ0123456789abchefghjkmnpqrstuvwxyz";
		srand((double)microtime()*1000000);
		$i = 0;		
		while ($i <= 7) {
			$num = rand() % 33;
			$tmp = substr($salt, $num, 1);
			$pass = $pass . $tmp;
			$i++;
		}
		
		return $pass;
	}
	
	function encrypt($plaintext)
	{
		return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, ENCRYPRTION_KEY, $plaintext, MCRYPT_MODE_ECB));
		// $key_size =  strlen(ENCRYPRTION_KEY);
		// $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
		// $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		// $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, ENCRYPRTION_KEY,
									 // $plaintext, MCRYPT_MODE_CBC, $iv);
		// $ciphertext = $iv . $ciphertext;
		// $ciphertext_base64 = base64_encode($ciphertext);
		// return  $ciphertext_base64;

	}
	
	function decrypt($encrypted)
	{
		// $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
		// $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		// $ciphertext_dec = base64_decode($encrypted);
		// $iv_dec = substr($ciphertext_dec, 0, $iv_size);
		// $ciphertext_dec = substr($ciphertext_dec, $iv_size);
		// $plaintext_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, ENCRYPRTION_KEY,
										// $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);
		// return $plaintext_dec;
		return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, ENCRYPRTION_KEY, base64_decode($encrypted), MCRYPT_MODE_ECB));
	}
	
	function getToken($length)
	{
		$pass = "";
		$salt = "ABCDEFGHIJKLMNOPQRSTUVWXWZ0123456789abchefghjkmnpqrstuvwxyz";
		srand((double)microtime()*1000000);
		$i = 0;		
		while ($i <= 7) {
			$num = rand() % 33;
			$tmp = substr($salt, $num, 1);
			$pass = $pass . $tmp;
			$i++;
		}
		
		return substr($pass, 0, $length);
	}

	function getStatus($Status)
	{
		if($Status == "1")
			return '<i class="fa fa-check-circle"></i>';
		else if($Status == "0")
			return '<i class="fa fa-times-circle"></i>';
	}

	function getBatch($ID)
	{
		$q = mysql_query("SELECT Name from batches WHERE ID=".(int)$ID);
		if(mysql_num_rows($q) > 0)
			return mysql_result($q, 0, 0);
		else
			return '';
	}

	function getUsername($ID)
	{
		$q = mysql_query("SELECT Username from users WHERE ID=".(int)$ID);
		if(mysql_num_rows($q) > 0)
			return mysql_result($q, 0, 0);
		else
			return '';
	}

	function getDepartment($ID)
	{
		$q = mysql_query("SELECT Name from departments WHERE ID=".(int)$ID);
		if(mysql_num_rows($q) > 0)
			return mysql_result($q, 0, 0);
		else
			return '';
	}

	function getSection($ID)
	{
		$q = mysql_query("SELECT Name from sections WHERE ID=".(int)$ID);
		if(mysql_num_rows($q) > 0)
			return mysql_result($q, 0, 0);
		else
			return '';
	}

	function getCourse($ID)
	{
		$q = mysql_query("SELECT Name from courses WHERE ID=".(int)$ID);
		if(mysql_num_rows($q) > 0)
			return mysql_result($q, 0, 0);
		else
			return '';
	}

	function getRoleName($RoleID)
	{
		if($RoleID == "1")
			return 'Admin';
		else if($RoleID == "2")
			return 'Faculty';
		else if($RoleID == "3")
			return 'Student';
	}

	function send_mail($From, $To, $Subject, $Body, $IsHTML = true, $Attachments=array())
	{
		$headers = "from: ".EMAIL."\r\n";
		$headers .= "Content-type: text/html\r\n";
		return mail($To, $Subject, $Body, $headers);
		
	}
	
	function checkactive($url)
	{
		if(($_SERVER['PHP_SELF'] == dirname($_SERVER['PHP_SELF'])."/".$url))
			return " active ";
		else
			return "";
	}
	
	function getDistrict($ID)
	{
		$q = mysql_query("select Name FROM districts WHERE ID=".$ID);
		if(mysql_num_rows($q) > 0)
			return mysql_result($q, 0, 0);
		else
			return "";
	}
	
	function getDesignation($ID)
	{
		$q = mysql_query("select Name FROM designations WHERE ID=".$ID);
		if(mysql_num_rows($q) > 0)
			return mysql_result($q, 0, 0);
		else
			return "";
	}

	function getOfficeDistrict($ID)
	{
		$q = mysql_query("select ID, Name FROM districts WHERE ID=".$ID);
		if(mysql_num_rows($q) > 0)
			return mysql_result($q, 0, 0);
		else
			return "";
	}
	
	function getDistrictByOfficeID($ID)
	{
		$q = mysql_query("select DistrictID FROM offices WHERE ID=".$ID);
		if(mysql_num_rows($q) > 0)
			return mysql_result($q, 0, 0);
		else
			return "";
	}
	
	function getOfficeType($ID)
	{
		$q = mysql_query("select Type FROM offices WHERE ID=".$ID);
		if(mysql_num_rows($q) > 0)
			return mysql_result($q, 0, 0);
		else
			return "";
	}
	
	function checkavailability($table, $column, $name)
	{
		return mysql_num_rows(mysql_query("SELECT * FROM ". $table." WHERE ".$column."='".$name."'"));
	}

	function checkusernameavailability($table, $column, $name, $ID)
	{
		return mysql_num_rows(mysql_query("SELECT * FROM ". $table." WHERE ".$column."='".$name."' AND ID<>'".$ID."'"));
	}

	function getStars($num)
	{
		$ret = "";
		for($i=0; $i<$num; $i++)
			$ret .= '<i class="fa fa-star"></i>';
		return $ret;
	}
?>
