<?php
include("common.php");
include("checkadminlogin.php");
$msg = "";
$Name = "";
$Status = 1;
$Remarks = "";
$DeptID="";
$BatchID= "";

if (isset($_POST["Add-course"]) && $_POST["Add-course"] == "Add-course") {
    foreach ($_POST as $key => $value) {
        $$key = $value;
    }
    //if(Captcha_VERIFICATION == 1) { if(!isset($_POST["Captcha"]) || $_POST["Captcha"]=="" || $_SESSION["code"]!=$_POST["Captcha"]) $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="fa fa-ban"></i> Incorrect Captcha Code</div>'; }
    if ($Name == "" ) {
        $msg = '<div class="alert alert-danger alert-dismissable ">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<i class="fa fa-ban"></i>
	<strong>	Please enter the Section Name. </strong>
		</div>';
    }
    
    
    else if(checkavailability('courses', 'Name', $Name) > 0)
	{
		$msg = '<div class="alert alert-danger alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<i class="fa fa-ban"></i>
		Course is already added.
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
        $query = "INSERT INTO courses SET DateAdded=NOW(), DateModified=NOW(),
		Name='" . dbinput($Name) . "',
		Remarks='" . dbinput($Remarks) . "',
               
               
              
                Status=" . (int) $Status;
        mysql_query($query) or die(mysql_error());
        $ID = mysql_insert_id();
        $_SESSION["msg"] = '<div class="alert alert-success alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<i class="fa fa-check"></i>
		Course has been added.
		</div>';
        redirect("add-course");
    }
}



$query = "SELECT ID, Name,Remarks, Status, DateAdded, DateModified FROM courses WHERE ID<>0";
$resource = mysql_query($query) or die(mysql_error());
?>




<?php //for deletion


if(isset($_POST["action"]) && $_POST["action"] == "delete")
{
	if(isset($_POST["chkIDs"]) && is_array($_POST["chkIDs"]))
	{
		foreach($_POST["chkIDs"] as $BID)
		{
			mysql_query("DELETE FROM courses WHERE ID IN (" . $BID . ")") or die(mysql_error());
		}
		$_SESSION["msg"]='<div class="alert alert-success alert-dismissable">
		<i class="fa fa-check"></i>
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<b>All selected course(s) deleted.</b>
		</div>';
		redirect("add-course");
	}
	else
	{
		$msg='<div class="alert alert-danger alert-dismissable">
		<i class="fa fa-ban"></i>
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<b>Please select any course to delete.</b>
		</div>';
	}
}


?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>



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
       
        <script src="js/jquery.min.js"></script>





  <!-- Custom styling plus plugins -->
 
 
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


        <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
   
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
                            <h2>Manage Courses</h2>
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
                            
                            <?php echo $msg;
if (isset($_SESSION["msg"])) {
    echo $_SESSION["msg"];
    $_SESSION["msg"] = "";
} ?>

                            <!--- content of panel -->
                            <form  id="add-batch" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" data-toggle="validator">


                                    <div class="row">
                                    

                                        <div class ="col-lg-4">
                                             <label>Name*:</label>
                                            <input name="Name" type="text" class="form-control" id="Name" placeholder=" i.e. Neural Networks" value="<?php echo $Name; ?>" >
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
                                   
                                        <div class="col-lg-8 ">
                                            <label>Remarks:</label>
                                            
                                             <input name="Name" type="text" class="form-control " id="Name" placeholder="" value="<?php echo $Name; ?>" >
                                               <div class="help-block with-errors"></div>
                                            
                                        </div>
                                        
                                    </div>

                                      
                                        
                                    
                                    
                                    <div class="row">
                                       

                                        <div class= "col-lg-12">
                                             <input type="hidden" name="action" value="Add-course"/>
                                            <input type="submit" class="btn btn-success pull-right" name="Add-course" value="Add-course" />
                                        </div>
                                        

                                    </div>
                                
                                </form>
                        </div>
                        <!---------->

                    </div>
                </div>
            </div>



                <!------table-->

<div class ="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Courses</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                
                                 <li><button  type="button" class="btn btn-danger btn-sm" id ="delete" onclick="return deleteChecked()" value = "delete">
                                                    <span class="glyphicon glyphicon-trash"></span> &nbsp;Delete Course(s)
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
                                        <tr>
                                            <th> </th>
                                            <th>Serial no.</th>
                                            <th>Name</th>
                                            <th>Remarks</th>
                                            <th>Status</th>
                                            <th>Date Added</th>
                                            <th>Date Modified</th>
                                            <th> Edit</th> </tr>
                                    </thead>
                                <tbody>
                                        <?php
	while($row = mysql_fetch_array($resource))
	{
	?>
                                    <tr>		<td class="hidden-print"><input type="checkbox" class="chkIDs" name="chkIDs[]" value="<?php echo dboutput($row["ID"]); ?>" ></td>
								<td><?php echo $count++; ?></td>
								<td><?php echo dboutput($row["Name"]); ?></td>
                                                                <td><?php echo dboutput($row["Remarks"]); ?></td>
								<td><?php echo getStatus(dboutput($row["Status"])); ?></td>
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
        </div>

        <div id="custom_notifications" class="custom-notifications dsp_none">
            <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
            </ul>
            <div class="clearfix"></div>
            <div id="notif-group" class="tabbed_notifications"></div>
        </div>
        <script src="js/bootstrap.min.js"></script>
        <!-- bootstrap progress js -->
       
        <script src="js/nicescroll/jquery.nicescroll.min.js"></script>
        <!-- icheck -->
      
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
    
    
     <link href="js/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
        <link href="js/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="js/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="js/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="js/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css" />

    
     <link rel="stylesheet" href="css/switchery/switchery.min.css" />
     <script src="js/switchery/switchery.min.js"></script>
      <script src="js/icheck/icheck.min.js"></script>
      <script src="js/select/select2.full.js"></script>
       <link href="css/icheck/flat/green.css" rel="stylesheet">

    <!-- pace -->
    <script src="js/pace/pace.min.js"></script>
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
    
      

  <!-- bootstrap progress js -->
  <script src="js/progressbar/bootstrap-progressbar.min.js"></script>
 
  <!-- icheck -->
  <script src="js/icheck/icheck.min.js"></script>
  <!-- tags -->
  <script src="js/tags/jquery.tagsinput.min.js"></script>
  <!-- switchery -->
  <script src="js/switchery/switchery.min.js"></script>
  <!-- daterangepicker -->
  <script type="text/javascript" src="js/moment/moment.min.js"></script>
  <script type="text/javascript" src="js/datepicker/daterangepicker.js"></script>
  <!-- richtext editor -->
  <script src="js/editor/bootstrap-wysiwyg.js"></script>
  <script src="js/editor/external/jquery.hotkeys.js"></script>
  <script src="js/editor/external/google-code-prettify/prettify.js"></script>
  <!-- select2 -->
  <script src="js/select/select2.full.js"></script>
  <!-- form validation -->
  <script type="text/javascript" src="js/parsley/parsley.min.js"></script>
  <!-- textarea resize -->
  <script src="js/textarea/autosize.min.js"></script>
  <script>
    autosize($('.resizable_textarea'));
  </script>
  <!-- Autocomplete -->
  <script type="text/javascript" src="js/autocomplete/countries.js"></script>
  <script src="js/autocomplete/jquery.autocomplete.js"></script>
  <!-- pace -->
  <script src="js/pace/pace.min.js"></script>
  <script type="text/javascript">
    $(function() {
      'use strict';
      var countriesArray = $.map(countries, function(value, key) {
        return {
          value: value,
          data: key
        };
      });
      // Initialize autocomplete with custom appendTo:
      $('#autocomplete-custom-append').autocomplete({
        lookup: countriesArray,
        appendTo: '#autocomplete-container'
      });
    });
  </script>
 


  <!-- select2 -->
  <script>
    $(document).ready(function() {
      $(".select2_single").select2({
        placeholder: "Select a state",
        allowClear: true
      });
      $(".select2_group").select2({});
      $(".select2_multiple").select2({
        maximumSelectionLength: 4,
        placeholder: "With Max Selection limit 4",
        allowClear: true
      });
    });
  </script>
  <!-- /select2 -->
  
   <script>
    function onAddTag(tag) {
      alert("Added a tag: " + tag);
    }

    function onRemoveTag(tag) {
      alert("Removed a tag: " + tag);
    }

    function onChangeTag(input, tag) {
      alert("Changed a tag: " + tag);
    }

    $(function() {
      $('#tags_1').tagsInput({
        width: 'auto'
      });
    });
  </script>
  <!-- /input tags -->
  <!-- form validation -->
  <script type="text/javascript">
    $(document).ready(function() {
      $.listen('parsley:field:validate', function() {
        validateFront();
      });
      $('#demo-form .btn').on('click', function() {
        $('#demo-form').parsley().validate();
        validateFront();
      });
      var validateFront = function() {
        if (true === $('#demo-form').parsley().isValid()) {
          $('.bs-callout-info').removeClass('hidden');
          $('.bs-callout-warning').addClass('hidden');
        } else {
          $('.bs-callout-info').addClass('hidden');
          $('.bs-callout-warning').removeClass('hidden');
        }
      };
    });

    $(document).ready(function() {
      $.listen('parsley:field:validate', function() {
        validateFront();
      });
      $('#demo-form2 .btn').on('click', function() {
        $('#demo-form2').parsley().validate();
        validateFront();
      });
      var validateFront = function() {
        if (true === $('#demo-form2').parsley().isValid()) {
          $('.bs-callout-info').removeClass('hidden');
          $('.bs-callout-warning').addClass('hidden');
        } else {
          $('.bs-callout-info').addClass('hidden');
          $('.bs-callout-warning').removeClass('hidden');
        }
      };
    });
    try {
      hljs.initHighlightingOnLoad();
    } catch (err) {}
  </script>
  <!-- /form validation -->
  <!-- editor -->
  <script>
    $(document).ready(function() {
      $('.xcxc').click(function() {
        $('#descr').val($('#editor').html());
      });
    });

    $(function() {
      function initToolbarBootstrapBindings() {
        var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier',
            'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
            'Times New Roman', 'Verdana'
          ],
          fontTarget = $('[title=Font]').siblings('.dropdown-menu');
        $.each(fonts, function(idx, fontName) {
          fontTarget.append($('<li><a data-edit="fontName ' + fontName + '" style="font-family:\'' + fontName + '\'">' + fontName + '</a></li>'));
        });
        $('a[title]').tooltip({
          container: 'body'
        });
        $('.dropdown-menu input').click(function() {
            return false;
          })
          .change(function() {
            $(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');
          })
          .keydown('esc', function() {
            this.value = '';
            $(this).change();
          });

        $('[data-role=magic-overlay]').each(function() {
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
      };

      function showErrorAlert(reason, detail) {
        var msg = '';
        if (reason === 'unsupported-file-type') {
          msg = "Unsupported format " + detail;
        } else {
          console.log("error uploading file", reason, detail);
        }
        $('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>' +
          '<strong>File upload error</strong> ' + msg + ' </div>').prependTo('#alerts');
      };
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
			alert("Please select any Batch(s) to delete");
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