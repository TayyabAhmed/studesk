<?php 
include ("common.php");
include("checkadminlogin.php");

$msg = "";
$IssuedBy="";
$IssuedTo="";
$Subject="";
$Body="";
$Status="1";





if(isset($_POST["add-notification"])&& $_POST["add-notification"]== "add-notification")
 
{
     foreach ($_POST as $key => $value) {
        $$key = $value;
    }
    
    
 // dd($_POST);
    
    
    $Body=$Body2;
    
     if ( $IssuedBy== "" ) {
        $msg = '<div class="alert alert-danger alert-dismissable ">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<i class="fa fa-ban"></i>
	<strong>	Please enter the Issuer Name. </strong>
		</div>';
    }
    
   else  if ( $Subject== "" ) {
        $msg = '<div class="alert alert-danger alert-dismissable ">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<i class="fa fa-ban"></i>
	<strong>	Please enter the Issuer Name. </strong>
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
        $query = "INSERT INTO notifications SET DateAdded=NOW(), DateModified=NOW(),
		IssuedBy='" . dbinput($IssuedBy) . "',
		IssuedTo='" . dbinput($IssuedTo) . "',
                Body='" .dbinput(htmlentities($Body) ) . "',
                Subject='" . dbinput($Subject) . "',
		Status=" . (int) $Status;
        mysql_query($query) or die(mysql_error());
        $ID = mysql_insert_id();
        $_SESSION["msg"] = '<div class="alert alert-success alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<i class="fa fa-check"></i>
		Notification has been added.
		</div>';
        redirect("add-notification");
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
                        <h4 class="modal-title" id="myModalLabel">Add  Notifications</h4>
                      </div>
                      <div class="modal-body">
                        
                        
                           
                        
                        
                         <form id="add-notification" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" data-toggle="validator">


                                <div class="row">



                                    <div class ="col-lg-4">
                                        <label>Issued By*:</label>

                                        <input name="IssuedBy" type="text" class="form-control " id="IssuedBy" placeholder="Admin,Registrar etc" required="" value="<?php echo $IssuedBy; ?>">



                                    </div>
                                    <div class ="col-lg-4">
                                        <label>Issued To:</label>
 <input name="IssuedTo" type="text" class="form-control " id="IssuedTo" placeholder="Teachers,Students etc  etc" required="" value="<?php echo $IssuedTo; ?>">
                                          </div>
                                    
                                    
                                    
                              <div class="col-lg-4">
                                     <label>Status:</label><br>

                                            Active:
                                            <input type="radio" class="flat" name="Status" id="active" value=1  <?php echo $Status == 1 ? 'checked=""' : ''; ?> > In-Active:
                                            <input type="radio" class="flat" name="Status" id="inactive" value=0 <?php echo $Status == 0 ? 'checked=""' : ''; ?>>
                                            <div class="help-block with-errors"></div>
                                        </div>

                                </div>
                               <br>

                                <div class ="row">
                                      <div class ="col-lg-4">
                                        <label>Subject *:</label>
                                        <input name="Subject" type="text" class="form-control " id="issued_to" placeholder="i.e Sir Syed Day" value="<?php echo $Subject; ?>" required="">
                                    </div>


                                    <div class="col-lg-8 col-sm-8 col-xs-8">
                                        <label>Body*:</label>

                                        <div class="clearfix"></div>
                                  <div id="alerts"></div>
                                        <div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#editor">
                                            <div class="btn-group">
                                                <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font"><i class="fa icon-font"></i><b class="caret"></b></a>
                                                <ul class="dropdown-menu">
                                                </ul>
                                            </div>
                                            <div class="btn-group">
                                                <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="icon-text-height"></i>&nbsp;<b class="caret"></b></a>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a data-edit="fontSize 5">
                                                            <p style="font-size:17px">Huge</p>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a data-edit="fontSize 3">
                                                            <p style="font-size:14px">Normal</p>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a data-edit="fontSize 1">
                                                            <p style="font-size:11px">Small</p>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="btn-group">
                                                <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="icon-bold"></i></a>
                                                <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="icon-italic"></i></a>
                                                <a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="icon-strikethrough"></i></a>
                                                <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="icon-underline"></i></a>
                                            </div>
                                            <div class="btn-group">
                                                <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="icon-list-ul"></i></a>
                                                <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="icon-list-ol"></i></a>
                                                <a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="icon-indent-left"></i></a>
                                                <a class="btn" data-edit="indent" title="Indent (Tab)"><i class="icon-indent-right"></i></a>
                                            </div>
                                            <div class="btn-group">
                                                <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="icon-align-left"></i></a>
                                                <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="icon-align-center"></i></a>
                                                <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="icon-align-right"></i></a>
                                                <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="icon-align-justify"></i></a>
                                            </div>
                                            <div class="btn-group">
                                                <a class="btn dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="icon-link"></i></a>
                                                <div class="dropdown-menu input-append">
                                                    <input class="span2" placeholder="URL" type="text" data-edit="createLink" />
                                                    <button class="btn" type="button">Add</button>
                                                </div>
                                                <a class="btn" data-edit="unlink" title="Remove Hyperlink"><i class="icon-cut"></i></a>

                                            </div>

                                         
                                            <div class="btn-group">
                                                <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="icon-undo"></i></a>
                                                <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="icon-repeat"></i></a>
                                            </div>
                                        </div>

                                        <div id="editor"  > 
                                            
                                            <?php echo $Body ;?>
                                          
                                        </div>
                                  
                                  <textarea name="Body" id="Body" style=" display:none;"></textarea>
                                       
                                        <br />

                                    </div>

                                </div>

                                <div class="row">

                                    <div class= "col-lg-12">
                                         <input type="hidden" name="Body2" id="Body2" value=""/>
                                         <input type="hidden" name="action" value="add-notification"/>
                                        <input type="submit" class="btn btn-success pull-right" name="add-notification" value="add-notification" />
                                    </div>

                                </div>

                            </form>
                        
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
    
    
    
    <!-- richtext editor -->
    <script src="js/editor/bootstrap-wysiwyg.js"></script>
    <script src="js/editor/external/jquery.hotkeys.js"></script>
    <script src="js/editor/external/google-code-prettify/prettify.js"></script>
    <!-- /editor -->


</html>