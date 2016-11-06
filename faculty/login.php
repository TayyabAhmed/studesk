<?php
include("common.php");
if(isset($_SESSION["Admin"]) && $_SESSION["Admin"] == true)
	redirect("index.php");

$msg = "";
$Username = "";
$Password = "";
$remember_me = 0;

if(isset($_COOKIE["SSUET_Remember_Username"]))
	$Username = $_COOKIE["SSUET_Remember_Username"];
if(isset($_COOKIE["SSUET_Remember_Password"]))
	$Password = $_COOKIE["SSUET_Remember_Password"];

if(isset($_POST["Login"]) && $_POST["Login"] == "Login")
{
	foreach($_POST as $key => $value)
	{
		$$key=$value;
	}
	
	if($Username == "")
	{
		$msg = '<div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="fa fa-ban"></i>
					Please Enter Your Username.
				</div>';
	}

	else if($Password == "")
	{
		$msg = '<div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="fa fa-ban"></i>
					Please Enter Your Password.
				</div>';
	}

	else if($msg=='')
	{	
		$query="SELECT ID, Password, Admin FROM users WHERE Username='".dbinput($Username)."'";
		$result = mysql_query ($query) or die("Query error: ". mysql_error()); 
		$num = mysql_num_rows($result);
		if($num==0)
		{
			$_SESSION["Admin"]=false;
			$_SESSION["User"]=false;
			$msg = '<div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="fa fa-ban"></i>
					Incorrect Username.
				</div>';
		}
		else
		{
			$row = mysql_fetch_array($result);
			if(dboutput($row["Password"]) == encrypt($Password))
			{
				if($row["Admin"] == 1)
				{
					$_SESSION["Admin"]=true;
					$_SESSION["User"]=true;
				}
				else
				{
					$_SESSION["Admin"]=false;
					$_SESSION["User"]=true;
				}
				$ssql = "SELECT * FROM users WHERE ID = ".$row["ID"]."";
				$datap = mysql_query($ssql);
				$rows = mysql_fetch_assoc($datap);
				foreach($rows as $key => $value)
				{
					if(!isset($_SESSION[$key]))
						$_SESSION[$key] = "";
					$_SESSION[$key]=$value;
				}
				if($remember_me == 1)
				{
					setcookie("SSUET_Remember_Username", $Username, time() + (86400 * 30), "/"); // 86400 = 1day
					setcookie("SSUET_Remember_Password", $Password, time() + (86400 * 30), "/"); // 86400 = 1day
					setcookie("SSUET_Remember_remember_me", $remember_me, time() + (86400 * 30), "/"); // 86400 = 1day
				}
				else
				{
					setcookie("SSUET_Remember_Username", "", time() - 3600, "/"); // 86400 = 1day
					setcookie("SSUET_Remember_Password", "", time() - 3600, "/"); // 86400 = 1day
					setcookie("SSUET_Remember_remember_me", "", time() - 3600, "/"); // 86400 = 1day
				}
				mysql_query("UPDATE users SET LastLogin=NOW() WHERE ID=".(int)$row["ID"]) or die(mysql_error());
				redirect("dashboard.php");
			}
			else
			{
				$_SESSION["Admin"]=false;
				$_SESSION["User"]=false;
				$msg = '<div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="fa fa-ban"></i>
					Incorrect Password.
				</div>';
			}
		}
	}
}
?>




 <script>
                                    $(document).ready(function() {
    var interval = setInterval(function() {
        var momentNow = moment();
        $('#date-part').html(momentNow.format('YYYY MMMM DD') + ' '
                            + momentNow.format('dddd')
                             .substring(0,3).toUpperCase());
        $('#time-part').html(momentNow.format('A hh:mm:ss'));
    }, 100);
    
    $('#stop-interval').on('click', function() {
        clearInterval(interval);
    });
});                                 
                                    
                                    
                                    
                                    
                                    
                                    </script>
                                    
                                    
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>StuDesk|SSUET </title>

        <!-- Bootstrap core CSS -->

        <link href="css/bootstrap.min.css" rel="stylesheet">

        <link href="fonts/css/font-awesome.min.css" rel="stylesheet">
        <link href="css/animate.min.css" rel="stylesheet">

        <!-- Custom styling plus plugins -->
        <link href="css/custom.css" rel="stylesheet">
        <link href="css/icheck/flat/green.css" rel="stylesheet">


        <!-- Custom styling plus plugins -->
        <link href="css/custom.css" rel="stylesheet">
        <link href="css/icheck/flat/green.css" rel="stylesheet">
        <!-- editor -->
        <link href="http://netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">
        <link href="css/editor/external/google-code-prettify/prettify.css" rel="stylesheet">
        <link href="css/editor/index.css" rel="stylesheet">
        <!-- select2 -->
        <link href="css/select/select2.min.css" rel="stylesheet">
        <!-- switchery -->
        <link rel="stylesheet" href="css/switchery/switchery.min.css" />

        <script src="js/jquery.min.js"></script>


    </head>
      <div class='time-frame'>  <!-------date time here--------------------------->
    <div id='date-part'></div>
    <div id='time-part'></div>
</div>  

    <body style="background:#F7F7F7;">

        
        
        <div class="">
            <a class="hiddenanchor" id="toregister"></a>
            <a class="hiddenanchor" id="tologin"></a>

            <div id="wrapper">
                <div id="login" class="animate form">
                    <section class="login_content">
                         <img src="images/logo.png" class="img-rounded" alt="SSUET logo" width="150" height="150">
                        <form id="LoginForm" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
                           
                            <h1>&nbsp;&nbsp;<i class="fa fa-institution" style="font-size: 26px;"></i> Studesk | SSUET&nbsp;&nbsp; </h1>


                            <div class= "row">

                                <div class ="col-lg-12 col-xs-12  ">
                                   
                                   

                                    <input name="Username" type="text" class="form-control has-feedback-left"  placeholder="Useranme" required="">
                                    <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                                </div>

                                <div class ="col-lg-12 col-xs-12">

                                    <input name="Password" type="password" class="form-control has-feedback-left"   placeholder="Password"  required="">


                                    <span class="fa fa-lock form-control-feedback left" aria-hidden="true"></span>
                                    
                                    <a class="news-letter " href="#">
						 <label class="checkbox1"><input id="remember_me" name="remember_me" value="1" type="checkbox" value="Remember Me" <?php echo (isset($_COOKIE["SSUET_Remember_remember_me"]) && $_COOKIE["SSUET_Remember_remember_me"] == 1 ? 'checked="checked"' : ''); ?>><i> </i>Remember Me</label>
					   </a>
                                    <br>
                                    
                                     <a href ="forgetpass" >Forget Password ? No worries :) click here</a>
                                </div>
                                
                               
                                
                 

                                     <div class ="col-lg-12 col-xs-12">
                                         <br>
                                       <input class ="btn btn-success" type="submit" name="Login" value="Login">

                                </div>
                                
                                

                            </div>

                            <div class="clearfix"></div>
                            
                            <div>
                                <br>
                                

                                <p>©2016 All Rights Reserved.<br>Sir Syed University of Engineering and Technology Karachi.<br>  </p>                          </div>
                            </div>
                        </form>
                        <!-- form -->
                    </section>

                    <!-- content -->
                </div>
                
            </div>
        
    </body>
    
    <!--scrolling js-->
	<script src="js/jquery.nicescroll.js"></script>
	<script src="js/scripts.js"></script>
	<!--//scrolling js-->

</html>
