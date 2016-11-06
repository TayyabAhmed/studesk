<?php
include("common.php");
include("checkadminlogin.php");
?>

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
     
      <div class="page-title">
      <div class="title_left">
    
      </div>
      <!--   <div class="title_right">
         <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
           <div class="input-group">
             <input type="text" class="form-control" placeholder="Search for...">
             <span class="input-group-btn">
                       <button class="btn btn-default" type="button">Go!</button>
                   </span>
         
           </div>
         </div>
         </div> -->
      </div>
      <div class="clearfix"></div>
      <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
      <div class="x_title">
      <h2>Plain Page</h2>
      <!-- <ul class="nav navbar-right panel_toolbox">
         <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
         </li>
         <li class="dropdown">
           <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
           <ul class="dropdown-menu" role="menu">
             <li><a href="#">Settings 1</a>
             </li>
             <li><a href="#">Settings 2</a>
             </li>
           </ul>
         </li>
         <li><a class="close-link"><i class="fa fa-close"></i></a>
         </li>
         </ul>   !-->
      <div class="clearfix"></div>
      </div>
      <div class="row top_tiles">
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats">
          
          <a href="add-batch"></a>
      <div class="icon"><i class="fa fa-flag-checkered"></i>
      </div>
      <div class="count"> <?php echo mysql_num_rows(mysql_query("SELECT ID FROM batches")); ?> </div>
       <a href="add-batch">
      <h3>Batches</h3>
       </a>
      </div>
      </div>
      <!---second box stats-->
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats">
          
          
      <div class="icon"><i class="fa fa-bank"></i>
      </div>
      <div class="count"> <?php echo mysql_num_rows(mysql_query("SELECT ID FROM departments")); ?></div>
       <a href="add-department">
      <h3>Departments  </h3>
     </a>
      </div>
      </div>
      <!---second box stats-->
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats">
      <div class="icon"><i class="fa fa-users"></i>
      </div>
      <div class="count">179</div>
      <h3>New Sign ups</h3>
      <p>Lorem ipsum psdea itgum rixt.</p>
      </div>
      </div>
      <!---second box stats-->
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats">
      <div class="icon"><i class="fa fa-graduation-cap"></i>
      </div>
      <div class="count">179</div>
      <h3>New Sign ups</h3>
      <p>Lorem ipsum psdea itgum rixt.</p>
      </div>
      </div>
	  
      </div>
          
          </div>
          
           </div>
          
          </div>
     
         <!--row ends-->
         
         
         
         <div class="clearfix"></div>

          <div class="row">


            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Line graph<small>Sessions</small></h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Settings 1</a>
                        </li>
                        <li><a href="#">Settings 2</a>
                        </li>
                      </ul>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <canvas id="lineChart"></canvas>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Bar graph <small>Sessions</small></h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Settings 1</a>
                        </li>
                        <li><a href="#">Settings 2</a>
                        </li>
                      </ul>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <canvas id="mybarChart"></canvas>
                </div>
              </div>
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
     
      <!-- /page content -->
      
      
      <div id="custom_notifications" class="custom-notifications dsp_none">
      <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
      </ul>
      <div class="clearfix"></div>
      <div id="notif-group" class="tabbed_notifications"></div>
      </div>
      
      
      
      
       <script src="js/bootstrap.min.js"></script>
  <script src="js/moment/moment.min.js"></script>
  <script src="js/chartjs/chart.min.js"></script>
  <script src="js/progressbar/bootstrap-progressbar.min.js"></script>
  <script src="js/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="js/icheck/icheck.min.js"></script>
  <script src="js/custom.js"></script>
  <script src="js/pace/pace.min.js"></script>

  <script>
    Chart.defaults.global.legend = {
      enabled: false
    };

    // Line chart
    var ctx = document.getElementById("lineChart");
    var lineChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: ["2013", "February", "March", "April", "May", "June", "July"],
        datasets: [{
          label: "My First dataset",
          backgroundColor: "rgba(38, 185, 154, 0.31)",
          borderColor: "rgba(38, 185, 154, 0.7)",
          pointBorderColor: "rgba(38, 185, 154, 0.7)",
          pointBackgroundColor: "rgba(38, 185, 154, 0.7)",
          pointHoverBackgroundColor: "#fff",
          pointHoverBorderColor: "rgba(220,220,220,1)",
          pointBorderWidth: 1,
          data: [31, 74, 6, 39, 20, 85, 7]
        }, {
          label: "My Second dataset",
          backgroundColor: "rgba(3, 88, 106, 0.3)",
          borderColor: "rgba(3, 88, 106, 0.70)",
          pointBorderColor: "rgba(3, 88, 106, 0.70)",
          pointBackgroundColor: "rgba(3, 88, 106, 0.70)",
          pointHoverBackgroundColor: "#fff",
          pointHoverBorderColor: "rgba(151,187,205,1)",
          pointBorderWidth: 1,
          data: [82, 23, 66, 9, 99, 4, 2]
        }]
      },
    });

    // Bar chart
    var ctx = document.getElementById("mybarChart");
    var mybarChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ["January", "February", "March", "April", "May", "June", "July"],
        datasets: [{
          label: '# of Votes',
          backgroundColor: "#26B99A",
          data: [51, 30, 40, 28, 92, 50, 45]
        }, {
          label: '# of Votes',
          backgroundColor: "#03586A",
          data: [41, 56, 25, 48, 72, 34, 12]
        }]
      },

      options: {
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        }
      }
    });

    // Doughnut chart
    var ctx = document.getElementById("canvasDoughnut");
    var data = {
      labels: [
        "Dark Grey",
        "Purple Color",
        "Gray Color",
        "Green Color",
        "Blue Color"
      ],
      datasets: [{
        data: [120, 50, 140, 180, 100],
        backgroundColor: [
          "#455C73",
          "#9B59B6",
          "#BDC3C7",
          "#26B99A",
          "#3498DB"
        ],
        hoverBackgroundColor: [
          "#34495E",
          "#B370CF",
          "#CFD4D8",
          "#36CAAB",
          "#49A9EA"
        ]

      }]
    };

    var canvasDoughnut = new Chart(ctx, {
      type: 'doughnut',
      tooltipFillColor: "rgba(51, 51, 51, 0.55)",
      data: data
    });

    // Radar chart
    var ctx = document.getElementById("canvasRadar");
    var data = {
      labels: ["Eating", "Drinking", "Sleeping", "Designing", "Coding", "Cycling", "Running"],
      datasets: [{
        label: "My First dataset",
        backgroundColor: "rgba(3, 88, 106, 0.2)",
        borderColor: "rgba(3, 88, 106, 0.80)",
        pointBorderColor: "rgba(3, 88, 106, 0.80)",
        pointBackgroundColor: "rgba(3, 88, 106, 0.80)",
        pointHoverBackgroundColor: "#fff",
        pointHoverBorderColor: "rgba(220,220,220,1)",
        data: [65, 59, 90, 81, 56, 55, 40]
      }, {
        label: "My Second dataset",
        backgroundColor: "rgba(38, 185, 154, 0.2)",
        borderColor: "rgba(38, 185, 154, 0.85)",
        pointColor: "rgba(38, 185, 154, 0.85)",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(151,187,205,1)",
        data: [28, 48, 40, 19, 96, 27, 100]
      }]
    };

    var canvasRadar = new Chart(ctx, {
      type: 'radar',
      data: data,
    });

    // Pie chart
    var ctx = document.getElementById("pieChart");
    var data = {
      datasets: [{
        data: [120, 50, 140, 180, 100],
        backgroundColor: [
          "#455C73",
          "#9B59B6",
          "#BDC3C7",
          "#26B99A",
          "#3498DB"
        ],
        label: 'My dataset' // for legend
      }],
      labels: [
        "Dark Gray",
        "Purple",
        "Gray",
        "Green",
        "Blue"
      ]
    };

    var pieChart = new Chart(ctx, {
      data: data,
      type: 'pie',
      otpions: {
        legend: false
      }
    });

    // PolarArea chart
    var ctx = document.getElementById("polarArea");
    var data = {
      datasets: [{
        data: [120, 50, 140, 180, 100],
        backgroundColor: [
          "#455C73",
          "#9B59B6",
          "#BDC3C7",
          "#26B99A",
          "#3498DB"
        ],
        label: 'My dataset' // for legend
      }],
      labels: [
        "Dark Gray",
        "Purple",
        "Gray",
        "Green",
        "Blue"
      ]
    };

    var polarArea = new Chart(ctx, {
      data: data,
      type: 'polarArea',
      options: {
        scale: {
          ticks: {
            beginAtZero: true
          }
        }
      }
    });
  </script>
      
      
      
   </body>
</html>