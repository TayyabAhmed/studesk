<?php 
include ("common.php");
include("checkadminlogin.php");


$msg = "";
$Username = "";
$Password = "";
$Name = "";
$Email = "";
$Mobile = "";
$RoleID = 1;
$Admin = 0;
$Status = 1;
$Remarks = "";
$Image = "";





if(isset($_POST["Submit"]) && $_POST["Submit"] == "Submit")
{
	foreach($_POST as $key => $value)
	{
		$$key=$value;
	}
	if(Captcha_VERIFICATION == 1) { if(!isset($_POST["Captcha"]) || $_POST["Captcha"]=="" || $_SESSION["code"]!=$_POST["Captcha"]) $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="fa fa-ban"></i> Incorrect Captcha Code</div>'; }
	if($Username == "")
	{
		$msg = '<div class="alert alert-danger alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<i class="fa fa-ban"></i>
		Please enter the officer username.
		</div>';
	}
	else if(checkavailability('users', 'Username', $Username) > 0)
	{
		$msg = '<div class="alert alert-danger alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<i class="fa fa-ban"></i>
		Username not available, please choose another username.
		</div>';
	}
	else if($Password == "")
	{
		$msg = '<div class="alert alert-danger alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<i class="fa fa-ban"></i>
		Please enter a password.
		</div>';
	}
	else if($Name == "")
	{
		$msg = '<div class="alert alert-danger alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<i class="fa fa-ban"></i>
		Please enter the officer name.
		</div>';
	}
	else if(isset($_FILES["Image"]) && $_FILES["Image"]['name'] != "")
	{
		$filenamearray=explode(".", $_FILES["Image"]['name']);
		$ext=End($filenamearray);
	
		if(!in_array($ext, $_IMAGE_ALLOWED_TYPES))
		{
			$msg='<div class="alert alert-danger alert-dismissable">
			<i class="fa fa-ban"></i>
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<b>Only '.implode(", ", $_IMAGE_ALLOWED_TYPES) . ' Images can be uploaded. </b>
			</div>';
		}			
		else if($_FILES["Image"]['size'] > (MAX_IMAGE_SIZE*1024))
		{
			$msg='<div class="alert alert-danger alert-dismissable">
			<i class="fa fa-ban"></i>
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<b>Image size must be ' . MAX_IMAGE_SIZE . ' KB or less.</b>
			</div>';
		}
	}
	if($msg == "")
	{
		$query = "INSERT INTO users SET DateAdded=NOW(), DateModified=NOW(),
		Admin=1,
		RoleID=".(int)$RoleID.",
		Username='".dbinput($Username)."',
		Password='".encrypt($Password)."',
		Name='".dbinput($Name)."',
		Email='".dbinput($Email)."',
		Mobile='".dbinput($Mobile)."',
		Remarks='".dbinput($Remarks)."',
		Status=".(int)$Status;
		mysql_query($query) or die(mysql_error());
		$ID = mysql_insert_id();
		$_SESSION["msg"] = '<div class="alert alert-success alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<i class="fa fa-check"></i>
		Admin has been added.
		</div>';

		if(isset($_FILES["Image"]) && $_FILES["Image"]['name'] != "")
		{
			if(is_file(DIR_USER_IMAGES . $Image))
				unlink(DIR_USER_IMAGES . $Image);
		
			ini_set('memory_limit', '-1');
			
			$tempName = $_FILES["Image"]['tmp_name'];
			$realName = "user".$ID.'.'.$ext;
			$StoreImage = $realName; 
			$target = DIR_USER_IMAGES . $realName;

			$moved=move_uploaded_file($tempName, $target);
		
			if($moved)
			{			
			
				$query2="UPDATE users SET Image='" . dbinput($realName) . "' WHERE ID=".$ID;
				mysql_query($query2) or die(mysql_error());
			}
			else
			{
				$msg='<div class="alert alert-warning alert-dismissable">
					<i class="fa fa-ban"></i>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<b>Admin added but image could not be uploaded.</b>
					</div>';
			}
		}
		redirect("add-admin");
	}
}







$query = "SELECT ID, IssuedBy,IssuedTo,Subject,Status, Body, DateAdded, DateModified FROM notifications WHERE ID<>0";
$resource = mysql_query($query) or die(mysql_error());
?>
 

<?php //for deletion


if(isset($_POST["action"]) && $_POST["action"] == "delete")
{
	if(isset($_POST["chkIDs"]) && is_array($_POST["chkIDs"]))
	{
		foreach($_POST["chkIDs"] as $BID)
		{
			mysql_query("DELETE FROM notifications WHERE ID IN (" . $BID . ")") or die(mysql_error());
		}
		$_SESSION["msg"]='<div class="alert alert-success alert-dismissable">
		<i class="fa fa-check"></i>
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<b>All selected notification deleted.</b>
		</div>';
		redirect("add-notification");
	}
	else
	{
		$msg='<div class="alert alert-danger alert-dismissable">
		<i class="fa fa-ban"></i>
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<b>Please select any notification to delete.</b>
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
        <title>StuDesk|SSUET </title>
        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="fonts/css/font-awesome.min.css" rel="stylesheet">
        <link href="css/animate.min.css" rel="stylesheet">
        <!-- Custom styling plus plugins -->
        <link href="css/custom.css" rel="stylesheet">
        <link href="css/icheck/flat/green.css" rel="stylesheet">
        <script src="js/jquery.min.js"></script>


        <!-- editor -->
        <link href="http://netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">
        <link href="css/editor/external/google-code-prettify/prettify.css" rel="stylesheet">
        <link href="css/editor/index.css" rel="stylesheet">



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
                        <!---------->
                        
                        <!--------------starting of float--->
                        
                        
                        
                        
                        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Add  Admin</h4>
                      </div>
                      <div class="modal-body">
                          
                          
                          
                           <form class="form-horizontal form-label-left" novalidate>
                        
                          <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6"  name="name" placeholder="both name(s) e.g Jon Doe" required="required" type="text">
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="email" id="email" name="email" required="required" class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Username"> Username <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                          
                          <input type="text" id="Username" name="Username" placeholder="Enter a unique username" class="form-control" value="<?php echo $Username; ?>" required="" onkeyup="checkAvailability()"><span id="user-availability-status"></span>
						  <p><i class="fa fa-spinner fa-spin" style="display:none" id="loaderIcon"></i></p>
                          
                          
                    <?php   // <input type="text" id="email2" name="Username"  required="required" class="form-control col-md-7 col-xs-12">  ?>
                      </div>
                    </div>
                    
                               
                               <?php /*
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="website">Website URL <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="url" id="website" name="website" required="required" placeholder="www.website.com" class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">Occupation <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="occupation" type="text" name="occupation" data-validate-length-range="5,20" class="optional form-control col-md-7 col-xs-12">
                      </div>  
                    </div>*/?>
                    <div class="item form-group">
                      <label for="password" class="control-label col-md-3">Password</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="password" type="password" name="password" data-validate-length="6,8" class="form-control col-md-7 col-xs-12" required="required">
                      </div>
                    </div>
                    <div class="item form-group">
                      <label for="password2" class="control-label col-md-3 col-sm-3 col-xs-12">Repeat Password</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="password2" type="password" name="password2" data-validate-linked="password" class="form-control col-md-7 col-xs-12" required="required">
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telephone">Telephone <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="tel" id="telephone" name="phone" required="required" data-validate-length-range="8,20" class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>
                    
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-8  pull-right">
                        
                        <button id="send" type="submit" class="btn btn-success">Submit</button>
                      </div>
                    </div>

                          
                           </form>>
                          
                          
                          
                        
                           
                        
                        
                         
                        
                      </div>
                     

                    </div>
                  </div>
                </div>
                           
                        <!--------------end of float--->
            
                        
                        <?php $count=0;?>
         <!------table-->
              <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Notifications </h2>
                            <ul class="nav navbar-right panel_toolbox">
                                
                                 <li><button  type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".bs-example-modal-lg">
                                                    <span class="glyphicon glyphicon-plus-sign"></span> Add Notification
                                                </button></li>
                                                 <li><button  type="button" class="btn btn-danger btn-sm" id ="delete" onclick="return deleteChecked()" value = "delete">
                                                    <span class="glyphicon glyphicon-trash"></span> &nbsp;Delete Notification(s)
                                                </button></li>
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>

                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                             <?php echo $msg;
if (isset($_SESSION["msg"])) {
    echo $_SESSION["msg"];
    $_SESSION["msg"] = "";
} ?>
                             <form id="delel" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Id</th>
                                        <th>Issued By</th>
                                        <th>Issued To</th>
                                        <th>Status </th>
                                        <th>Body </th>
                                        <th>Date Added </th>
                                         <th>Date Modified </th>
                                        <th> Actions</th>

                                    </tr>
                                </thead>
                                
                               
                                <tbody>
                                    
                                    <?php
	while($row = mysql_fetch_array($resource))
	{
	?>
                                    
                                      
                                     <tr>		<td class="hidden-print"><input type="checkbox" class="chkIDs" name="chkIDs[]" value="<?php echo dboutput($row["ID"]); ?>" ></td>
								<td><?php echo $count++; ?></td>
								<td><?php echo dboutput($row["IssuedBy"]); ?></td>
                                                                <td><?php echo dboutput($row["IssuedTo"]); ?></td>
								<td><?php echo getStatus(dboutput($row["Status"])); ?></td>
                                                                 <td><?php echo dboutput($row["Body"]); ?></td>
                                                                <td><?php echo date('d M Y h:iA', strtotime(dboutput($row["DateAdded"]))); ?></td>
								<td><?php echo date('d M Y h:iA', strtotime(dboutput($row["DateModified"]))); ?></td>
								
								
								
                                                            
                                                                
								<td align ="center">
                                                <button type="button" class="btn btn-default btn-sm">
                                                    <span class="glyphicon glyphicon-edit"></span> 
                                                </button>


                                            </td> </tr>
                                     <?php
	}
	?>
                                  
  

                                </tbody>
                            </table>
                                   <input type="hidden" name="action" value="delete"/>
                                 
                                 </form>

                        </div>
                    </div>   <!-----------table end----->

                </div>


            </div>        <!--notif-->
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
    <!-- textarea resize -->
    <script src="js/textarea/autosize.min.js"></script>


    <script>
        autosize($('.resizable_textarea'));
    </script>
    <script>
        var handleDataTableButtons = function () {
            "use strict";
            0 !== $("#datatable-buttons").length && $("#datatable-buttons").DataTable({
                dom: "Bfrtip",
                buttons: [{
                        extend: "copy",
                        className: "btn-sm"
                    }, {
                        extend: "csv",
                        className: "btn-sm"
                    }, {
                        extend: "excel",
                        className: "btn-sm"
                    }, {
                        extend: "pdf",
                        className: "btn-sm"
                    }, {
                        extend: "print",
                        className: "btn-sm"
                    }],
                responsive: !0
            })
        },
                TableManageButtons = function () {
                    "use strict";
                    return {
                        init: function () {
                            handleDataTableButtons()
                        }
                    }
                }();
    </script>
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


    <!-- editor -->
    <script>
        $(document).ready(function () {
			$("#add-notification").submit(function() {
				$("#Body2").val($("#editor").html());
				$(this).submit();
			});
            $('.xcxc').click(function () {
                $('#descr').val($('#editor').html());
            });
        });

        $(function () {
            function initToolbarBootstrapBindings() {
                var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier',
                    'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
                    'Times New Roman', 'Verdana'
                ],
                        fontTarget = $('[title=Font]').siblings('.dropdown-menu');
                $.each(fonts, function (idx, fontName) {
                    fontTarget.append($('<li><a data-edit="fontName ' + fontName + '" style="font-family:\'' + fontName + '\'">' + fontName + '</a></li>'));
                });
                $('a[title]').tooltip({
                    container: 'body'
                });
                $('.dropdown-menu input').click(function () {
                    return false;
                })
                        .change(function () {
                            $(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');
                        })
                        .keydown('esc', function () {
                            this.value = '';
                            $(this).change();
                        });

                $('[data-role=magic-overlay]').each(function () {
                    var overlay = $(this),
                            target = $(overlay.data('target'));
                    overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
                });
                if ("onwebkitspeechchange" in document.createElement("input")) {
                    var editorOffset = $('#editor').offset();
                    $('#voiceBtn').css('position', 'absolute').offset({
                        top: editorOffset.top,
                        left: editorOffset.left + $('#editor').innerWidth() - 35
                    });
                } else {
                    $('#voiceBtn').hide();
                }
            }
            ;

            function showErrorAlert(reason, detail) {
                var msg = '';
                if (reason === 'unsupported-file-type') {
                    msg = "Unsupported format " + detail;
                } else {
                    console.log("error uploading file", reason, detail);
                }
                $('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>' +
                        '<strong>File upload error</strong> ' + msg + ' </div>').prependTo('#alerts');
            }
            ;
            initToolbarBootstrapBindings();
            $('#editor').wysiwyg({
                fileUploadError: showErrorAlert
            });
            window.prettyPrint && prettyPrint();
        });
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
			alert("Please select any Section(s) to delete");
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
    
    
    
    <!-- pace -->
  <script src="js/pace/pace.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      // Smart Wizard
      $('#wizard').smartWizard();

      function onFinishCallback() {
        $('#wizard').smartWizard('showMessage', 'Finish Clicked');
        //alert('Finish Clicked');
      }
    });

    $(document).ready(function() {
      // Smart Wizard
      $('#wizard_verticle').smartWizard({
        transitionEffect: 'slide'
      });

    });
  </script>

    
    <!-- form validation -->
  <script src="js/validator/validator.js"></script>
  <script>
    // initialize the validator function
    validator.message['date'] = 'not a real date';

    // validate a field on "blur" event, a 'select' on 'change' event & a '.reuired' classed multifield on 'keyup':
    $('form')
      .on('blur', 'input[required], input.optional, select.required', validator.checkField)
      .on('change', 'select.required', validator.checkField)
      .on('keypress', 'input[required][pattern]', validator.keypress);

    $('.multi.required')
      .on('keyup blur', 'input', function() {
        validator.checkField.apply($(this).siblings().last()[0]);
      });

    // bind the validation to the form submit event
    //$('#send').click('submit');//.prop('disabled', true);

    $('form').submit(function(e) {
      e.preventDefault();
      var submit = true;
      // evaluate the form using generic validaing
      if (!validator.checkAll($(this))) {
        submit = false;
      }

      if (submit)
        this.submit();
      return false;
    });

    /* FOR DEMO ONLY */
    $('#vfields').change(function() {
      $('form').toggleClass('mode2');
    }).prop('checked', false);

    $('#alerts').change(function() {
      validator.defaults.alerts = (this.checked) ? false : true;
      if (this.checked)
        $('form .alert').remove();
    }).prop('checked', false);
  </script>

</html>