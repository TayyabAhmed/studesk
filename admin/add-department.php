

<?php
include("common.php");
include("checkadminlogin.php");
$msg = "";
$Name = "";
$Status = 1;
$Remarks = "";

if (isset($_POST["Add-deparment"]) && $_POST["Add-deparment"] == "Add-deparment") {
    foreach ($_POST as $key => $value) {
        $$key = $value;
    }
    //if(Captcha_VERIFICATION == 1) { if(!isset($_POST["Captcha"]) || $_POST["Captcha"]=="" || $_SESSION["code"]!=$_POST["Captcha"]) $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="fa fa-ban"></i> Incorrect Captcha Code</div>'; }
    if ($Name == "" ) {
        $msg = '<div class="alert alert-danger alert-dismissable ">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<i class="fa fa-ban"></i>
	<strong>	Please enter the department code. </strong>
		</div>';
    }
    
     if ($Remarks == "" ) {
        $msg = '<div class="alert alert-danger alert-dismissable ">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<i class="fa fa-ban"></i>
	<strong>	Please enter the department name. </strong>
		</div>';
    }
    else if(checkavailability('departments', 'Name', $Name) > 0)
	{
		$msg = '<div class="alert alert-danger alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<i class="fa fa-ban"></i>
		Department is already added.
		</div>';
	}
        
        
          else if(checkavailability('departments', 'Remarks', $Remarks) > 0)
	{
		$msg = '<div class="alert alert-danger alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<i class="fa fa-ban"></i>
		Department is already added.
		</div>';
	}
        
    else if (!ctype_digit($Status) || ($Status != 0 && $Status != 1)) {
        $msg = '<div class="alert alert-danger alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<i class="fa fa-ban"></i>
		Please select status.
		</div>';
    }
    if ($msg == "") {
        $query = "INSERT INTO departments SET DateAdded=NOW(), DateModified=NOW(),
		Name='" . dbinput($Name) . "',
		Remarks='" . dbinput($Remarks) . "',
		Status=" . (int) $Status;
        mysql_query($query) or die(mysql_error());
        $ID = mysql_insert_id();
        $_SESSION["msg"] = '<div class="alert alert-success alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<i class="fa fa-check"></i>
		Department has been added.
		</div>';
        redirect("add-department");
    }
}



$query = "SELECT ID, Name,Remarks, Status, DateAdded, DateModified FROM departments WHERE ID<>0";
$resource = mysql_query($query) or die(mysql_error());
?>




<?php //for deletion


if(isset($_POST["action"]) && $_POST["action"] == "delete")
{
	if(isset($_POST["chkIDs"]) && is_array($_POST["chkIDs"]))
	{
		foreach($_POST["chkIDs"] as $BID)
		{
			mysql_query("DELETE FROM departments WHERE ID IN (" . $BID . ")") or die(mysql_error());
		}
		$_SESSION["msg"]='<div class="alert alert-success alert-dismissable">
		<i class="fa fa-check"></i>
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<b>All selected department deleted.</b>
		</div>';
		redirect("add-department");
	}
	else
	{
		$msg='<div class="alert alert-danger alert-dismissable">
		<i class="fa fa-ban"></i>
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<b>Please select any department to delete.</b>
		</div>';
	}
}


?>






<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title> <?php echo SITE_TITLE; ?> </title>
        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="fonts/css/font-awesome.min.css" rel="stylesheet">
        <link href="css/animate.min.css" rel="stylesheet">
        <!-- Custom styling plus plugins -->
        <link href="css/custom.css" rel="stylesheet">
        <link href="css/icheck/flat/green.css" rel="stylesheet">
        <script src="js/jquery.min.js"></script>




        <link href="js/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
        <link href="js/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="js/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="js/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="js/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css" />




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
<?php include("side-nav.php"); ?>
               
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



         <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel" >
                        <div class="x_title">
                            <h2>Manage Departments</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>

                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br>

                            <!--- content of panel -->
                           
<?php echo $msg;
if (isset($_SESSION["msg"])) {
    echo $_SESSION["msg"];
    $_SESSION["msg"] = "";
} ?>
                                <form id="add-department"  data-parsley-validate  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" data-toggle="validator">


                                    <div class="row">
                                    

                                        <div class ="col-lg-8">
                                             <label>Name * :</label>
                                             

                                            <input name="Remarks" type="text" class="form-control" id="Remarks" placeholder="Enter Department Name i.e. Computer Enginering"  required="required" value="<?php echo $Remarks; ?>" >


                                            
                                            <div class="help-block with-errors"></div>
                                        </div>



                                        <div class ="col-lg-4">

                                            <label>Status:</label><br>

                                            Active:
                                            <input type="radio" class="flat" name="Status" id="active" value=1  <?php echo $Status == 1 ? 'checked=""' : ''; ?> > In-Active:
                                            <input type="radio" class="flat" name="Status" id="inactive" value=0 <?php echo $Status == 0 ? 'checked=""' : ''; ?>>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                        </div>
                                    
                                    <div class="row" >
                                   
                                        <div class="col-lg-4 ">
                                            <label>Code*:</label>
                                            
                                             <input name="Name" type="text" class="form-control " id="Name" placeholder="Enter Department Code i.e. CE" value="<?php echo $Name; ?>" >
                                               <div class="help-block with-errors"></div>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                    
                                    <div class="row">
                                       

                                        <div class= "col-lg-12">
                                             <input type="hidden" name="action" value="Add-deparment"/>
                                            <input type="submit" class="btn btn-success pull-right" name="Add-deparment" value="Add-deparment" />
                                        </div>
                                        

                                    </div>

                                </form>
                            </div>
                            <!---------->

                        </div>
                    </div>
                 </div>
                 
                 
               
                  

                    <!------table-->
                    <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Departments</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><button  type="button" class="btn btn-danger btn-sm" id ="delete" onclick="return deleteChecked()" value = "delete">
                                                    <span class="glyphicon glyphicon-trash"></span> &nbsp;Delete Dept.(s)
                                                </button></li>
                                    
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                    

                                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                
                                <form id="delel" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                    
                                    
                                     <?php  $count=0;?>

                                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                    <thead>
                                       
                                            <th> </th>
                                            <th>Serial no.</th>
                                            
                                            <th>Name</th>
                                            <th>Code</th>
                                            <th>Status</th>
                                            <th>Date Added</th>
                                            <th>Date Modified</th>
                                            <th> Edit</th>

                                                                           </thead>
                                    <tbody>
                                    <?php
	while($row = mysql_fetch_array($resource))
	{
	?>
                                       
                                    
                                        <tr>		<td class="hidden-print"><input type="checkbox" class="chkIDs" name="chkIDs[]" value="<?php echo dboutput($row["ID"]); ?>" ></td>
								<td><?php echo $count++; ?></td>
								<td><?php echo dboutput($row["Remarks"]); ?></td>
                                                                <td><?php echo dboutput($row["Name"]); ?></td>
								<td><?php echo getStatus(dboutput($row["Status"])); ?></td>
								<td><?php echo date('d M Y h:iA', strtotime(dboutput($row["DateAdded"]))); ?></td>
								<td><?php echo date('d M Y h:iA', strtotime(dboutput($row["DateModified"]))); ?></td>
								
								
								
                                                            
                                                                
								<td align ="center">
                                                <button type="button" class="btn btn-default btn-sm">
                                                    <span class="glyphicon glyphicon-edit"></span> 
                                                </button>
                                                                    
                                                                      <button type="button" class="btn btn-default" data-toggle="modal" data-target=".bs-example-modal-sm"> <span class="glyphicon glyphicon-eye-open"></span> </button>


                                            </td> </tr>
                                        
                                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        <?php
	}
	?>
                                        
                                        
                                        
                                        
                                        
                                         <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-sm">
                    <div class="modal-content">

                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel2">Department</h4>
                      </div>
                      <div class="modal-body">
                        
                          <li> Name : <?php echo dboutput($row["Remarks"]); ?></li>
                          <li> Staus : <?php echo dboutput($row["Status"]); ?></li>
                          <li> Code : <?php echo dboutput($row["Name"]); ?></li>
                          <li> DateAdded : <?php echo dboutput($row["DateAdded"]); ?></li>
                           <li> DateModified : <?php echo dboutput($row["DateModified"]); ?></li>
                        
                        
                        
                        
                        
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                       
                      </div>

                    </div>
                  </div>
                </div>
                       

                                       

                                    </tbody>
                                </table>
                                     <input type="hidden" name="action" value="delete"/>
                                    </form>

                            </div>
                        </div>   <!-----------table end----->

                    </div>
                        
                        </div>

                    
           

               
                <!------- NOTIHY-->
                <!-- footer content -->
                <footer>
                    <div class="copyright-info">
                        <p class="pull-right">All rights reserved  <a href="https://www.ssuet.edu.pk">Sir Syed University of Engineering and Technology</a>
                        </p>
                    </div>
                    <div class="clearfix"></div>
                </footer>
                <!-- /footer content -->
</div>
                <!-- /page content -->
          

            
                 
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

    <!-- Datatables -->
         <!-- <script src="js/datatables/js/jquery.dataTables.js"></script>
   <script src="js/datatables/tools/js/dataTables.tableTools.js"></script> -->

    <!-- Datatables-->
    <script src="js/datatables/jquery.dataTables.min.js"></script>
    <script src="js/datatables/dataTables.bootstrap.js"></script>
    <script src="js/datatables/dataTables.buttons.min.js"></script>
    <script src="js/datatables/buttons.bootstrap.min.js"></script>
    <script src="js/datatables/jszip.min.js"></script>
    <script src="js/datatables/pdfmake.min.js"></script>
    <script src="js/datatables/vfs_fonts.js"></script>
    <script src="js/datatables/buttons.html5.min.js"></script>
    <script src="js/datatables/buttons.print.min.js"></script>
    <script src="js/datatables/dataTables.fixedHeader.min.js"></script>
    <script src="js/datatables/dataTables.keyTable.min.js"></script>
    <script src="js/datatables/dataTables.responsive.min.js"></script>
    <script src="js/datatables/responsive.bootstrap.min.js"></script>
    <script src="js/datatables/dataTables.scroller.min.js"></script>


    <!-- pace -->
    <script src="js/pace/pace.min.js"></script>
   
    <script type="text/javascript">
        $(document).ready(function () {
            $('#datatable').dataTable();
            $('#datatable-keytable').DataTable({
                keys: true
            });
            $('#datatable-responsive').DataTable();
            $('#datatable-scroller').DataTable({
                ajax: "js/datatables/json/scroller-demo.json",
                deferRender: true,
                scrollY: 380,
                scrollCollapse: true,
                scroller: true
            });
            var table = $('#datatable-fixed-header').DataTable({
                fixedHeader: true
            });
        });
        TableManageButtons.init();
    </script>
    
    <script>
	$(function () {
		$('#supported').text('Supported/allowed: ' + !!screenfull.enabled);

		if (!screenfull.enabled) {
			return false;
		}

		

		$('#toggle').click(function () {
			screenfull.toggle($('#container')[0]);
		});
		

		
	});
	function deleteChecked(ele) {
		if($(".chkIDs").is(":checked"))
		{
			if(confirm("Are you sure you want to delete."))
			{
				$("#action").val("delete");
				$("#delel").submit();
			}
		}
		else
		{
			alert("Please select any department(s) to delete");
		}
	 }

	 function checkAll(ele) {
		 var checkboxes = document.getElementsByTagName('input');
		 if (ele.checked) {
			 for (var i = 0; i < checkboxes.length; i++) {
				 if (checkboxes[i].type == 'checkbox') {
					 checkboxes[i].checked = true;
				 }
			 }
		 } else {
			 for (var i = 0; i < checkboxes.length; i++) {
				 console.log(i)
				 if (checkboxes[i].type == 'checkbox') {
					 checkboxes[i].checked = false;
				 }
			 }
		 }
	 }
	</script>
        
        
    


</html>