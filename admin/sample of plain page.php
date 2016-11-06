

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
      <script src="js/jquery.min.js"></script>
      <!--[if lt IE 9]>
      <script src="../assets/js/ie8-responsive-file-warning.js"></script>
      <![endif]-->
      <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
   </head>
   <body class="nav-md layout boxed">
      <div class="container body">
      <div class="main_container">
      <!------side menu started-->
	  <?php include("side-nav.php");?>
            <!-- /sidebar menu -->
            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
            <a href ='plain_page.html' data-toggle="tooltip" data-placement="top" title="Settings">
            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
            <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Lock">
            <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a  href= 'logout.php' data-toggle="tooltip" data-placement="top" title="Logout">
            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
            </div>
            <!-- /menu footer buttons -->
         </div>
      </div>
      <!-- side menu clodes-->       
     <?php include("top-nav.php"); ?>
      <!-- /top navigation -->
      <!-- page content -->
      <div class="right_col" role="main">
      <div class="">
      
     
      <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel" style="height:600px;">
      <div class="x_title">
      <h2>Plain Page</h2>
	   <div class="clearfix"></div>
	  
	 
      
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	 
	  </div>
	  </div>
	  
      <!--notif-->
      <!------- NOTIHY-->
      <!-- footer content -->
      <footer>
      <div class="copyright-info">
      <p class="pull-right">All rights reserved  <a href="https://colorlib.com">Sir Syed University of Engineering and Technology</a>
      </p>
      </div>
      <div class="clearfix"></div>
      </footer>
      <!-- /footer content -->
      </div>
      <!-- /page content -->
      </div>
      </div>
      <div id="custom_notifications" class="custom-notifications dsp_none">
      <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
      </ul>
      <div class="clearfix"></div>
      <div id="notif-group" class="tabbed_notifications"></div>
      </div>
      <script src="js/bootstrap.min.js"></script>
      <!-- bootstrap progress js -->
      <script src="js/progressbar/bootstrap-progressbar.min.js"></script>
      <script src="js/nicescroll/jquery.nicescroll.min.js"></script>
      <!-- icheck -->
      <script src="js/icheck/icheck.min.js"></script>
      <script src="js/custom.js"></script>
      <!-- pace -->
      <script src="js/pace/pace.min.js"></script>
   </body>
</html>