<?php

include("../assets/server/session.php");

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TraceDoc - Dashboard</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/font-awesome.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <link href="../assets/css/styles.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap.min.css">

    <!--Custom Font-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <style>
        .panel-heading .panel-default {
            border-bottom: 1px solid transparent;
        }

        .shadow-sm {
            box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important
        }

        .shadow {
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important
        }

        .shadow-lg {
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, .175) !important
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-custom navbar-fixed-top" role="navigation" >
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse"><span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span></button>
                <a class="navbar-brand" href="#"><span>Trace</span>Doc <img src="../assets/images/covenant-university-logo-iscn-international-sustainable-campus-network-member_burned.png" alt="" srcset="" style="display: inline-block;"></a>
            </div>
        </div><!-- /.container-fluid -->
    </nav>
    <div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
        <div class="profile-sidebar">
            <div class="profile-userpic">
                <img src="http://placehold.it/50/30a5ff/fff" class="img-responsive" alt="">
            </div>
            <div class="profile-usertitle">
                <div class="profile-usertitle-name" style="text-transform: uppercase; font-size:medium"><?php echo $user_name; ?></div>
                <div class="profile-usertitle-status"><span class="indicator label-success"></span><?php echo $user_type ?></div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="divider"></div>
        <ul class="nav menu">
            <li><a href="index.php"><em class="fa fa-dashboard">&nbsp;</em> Dashboard</a></li>

            <li class="parent "><a data-toggle="collapse" href="#sub-item-1">
                    <em class="fa fa-clock-o">&nbsp;</em> Tasks <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="fa fa-plus"></em></span>
                </a>
                <ul class="children collapse" id="sub-item-1">
                <li><a href="pending.php">
						<?php 
						$sql = "SELECT * FROM requests WHERE request_status = 'pending' AND receiver_id = '$user_id'";
						$result = mysqli_query($con, $sql);
						$rows = mysqli_num_rows($result);
						if($rows < 1){
							$no = "";
						}else if($rows > 1){
							$no = $rows;
						}
						?>
						<span class="fa fa-arrow-right">&nbsp;</span> Pending Requests
					</a></li>                    <li><a class="" href="upload.php">
                            <span class="fa fa-arrow-right">&nbsp;</span> Upload Resolved Requests
                        </a></li>
                    <!-- <li><a class="" href="request.php">
						<span class="fa fa-arrow-right">&nbsp;</span> View Resolved Requests
					</a></li> -->
                </ul>
            </li>

            <li class="parent active"><a data-toggle="collapse" href="#sub-item-2">
                    <em class="fa fa-navicon">&nbsp;</em> New Request <span data-toggle="collapse" href="#sub-item-2" class="icon pull-right"><em class="fa fa-plus"></em></span>
                </a>
                <ul class="children collapse" id="sub-item-2">
                    <li><a href="req_form.php">
                            <span class="fa fa-arrow-right">&nbsp;</span> Request or Upload Form
                        </a></li>
                    <li><a class="" href="new-request.php">
                            <span class="fa fa-arrow-right">&nbsp;</span> Create New Requests
                        </a></li>
                    <!-- <li><a class="" href="request.php">
						<span class="fa fa-arrow-right">&nbsp;</span> View Resolved Requests
					</a></li> -->
                </ul>
            </li>

            <li><a href="settings.php"><em class="fa fa-cog">&nbsp;</em> Settings</a></li>


            <li><a href="index.php?logout"><em class="fa fa-power-off">&nbsp;</em> Logout</a></li>
        </ul>
    </div>
    <!--/.sidebar-->

    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="#">
                        <em class="fa fa-home"></em>
                    </a></li>
                <li>New Request</li>
                <li class="active">Create New Requests</li>
            </ol>
        </div>
        <!--/.row-->

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Requests</h1>
            </div>
        </div>
        <!--/.row-->

        <div class="row">
            <div class="col-md-12 container">
                <div class="panel panel-default container shadow-lg" style="border-radius: 25px;">
                    <div class="panel-heading">
                        Create a new Request
                        <span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
                    <div class="panel-body">
                        <form id="new_request" class="form-horizontal" action="" method="post">
                            <fieldset>
                                <!-- Name input-->
                                <div class="alert alert-success alert-dismissible" id="success" style="display:none;"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a></div>
                                <div class="alert alert-danger alert-dismissible" id="error" style="display:none;"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a></div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="name">Form Name</label>
                                    <div class="col-md-9">
                                        <?php
                                        $sql = "SELECT * FROM uploaded_forms WHERE uploader_id = '$user_id'";
                                        $query = mysqli_query($con, $sql);
                                        while ($results[] = mysqli_fetch_object($query));
                                        array_pop($results);
                                        ?>
                                        <select id="my-select" class="form-control" name="form_name">
                                            <option value="">Select form name</option>
                                            <?php foreach ($results as $option) : ?>
                                                <option value="<?php echo $option->form_code; ?>"><?php echo $option->form_description; ?></option>
                                            <?php endforeach; ?>

                                        </select>
                                    </div>
                                </div>

                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="email">Role of Receiver</label>
                                    <div class="col-md-9">
                                        <select class="form-control" id="role">
                                            <option value="">Choose the reciever's role</option>
                                            <option value="PG Coordinator">PG Coordinator</option>
                                            <option value="HOD">Head Of Department</option>
                                            <option value="College SPS Coordinator">College SPS Coordinator</option>
                                            <option value="Student">Student</option>
                                            <option value="Dean of College">Dean of College</option>
                                            <option value="SPS Senate">SPS Senate Officer</option>
                                            <option value="Sub-Dean SPS">Sub-Dean SPS</option>
                                            <option value="Dean SPS">Dean SPS</option>
                                            <option value="Examiner">Examiner</option>
                                            <option value="Supervisor">Supervisor</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="email">Receiver's Name</label>
                                    <div class="col-md-9">
                                        <select class="form-control" id="role_name">

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="my-textarea">Additional note</label>
                                    <div class="col-md-9">
                                        <textarea id="note" class="form-control" name="name" rows="3"></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-11 widget-right">
                                        <button id="submit_req" type="submit" class="btn  btn-primary text-white btn-md pull-right">Send Request</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>


            </div>
            <!--/.col-->




        </div>
        <br><br>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default shadow-lg ">
                    <div class="panel-heading">
                        List of Submitted Requests
                        <span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
                    <div class="panel-body">
                        <table class="table table-hover table-striped" id="requests">
                            <thead>
                                <tr>
                                    <th class="text-center">Form Name</th>
                                    <th class="text-center">Sent to </th>
                                    <th class="text-center">Form Status</th>
                                    <th class="text-center">Date Sent</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">

                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
            <!--/.col-->

        </div>
        <!--/.row-->


    </div>
    <!--/.main-->

    <script src="../assets/js/jquery-1.11.1.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/bootstrap-datepicker.js"></script>
    <script src="../assets/js/custom.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
  	<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

    <script type="text/javascript">
           $(document).ready(function(){
				var table =$('#requests').DataTable({
					"bProcessing": true,
					"sAjaxSource": "../assets/server/requests_table.php",
					"iDisplayLength": 10,
					"aoColumns": [
							{ mData: 'Form_Name' } ,
							{ mData: 'sent_to' },
							{ mData: 'status' },
							{ mData: 'Date_Uploaded' },
						]
				})

			   $('#new_request').submit(function(e){
				   e.preventDefault();
				   var select1 = $('#my-select option:selected');
				   var select2 = $('#role option:selected');
				   var select3 = $('#role_name option:selected');

				   var form_name = select1.val();
				   var receiver_role = select2.val();
				   var receiver_id = select3.val();
				   var note = $('#note').val();

				   $('#reg').html("processing").attr("disabled",true); //changes the button text to PROCESSING...
					$.ajax({
						type: 'POST',
						url: '../assets/server/reg.php?action=staffnewreq',
						data: {
							type: 1,
							form_name: form_name,
							receiver_role: receiver_role,
							receiver_id: receiver_id,
							note: note
						}
					})
					.done(function(response){
						console.log(response);
						$('#upload').html("Submit").attr('disabled',false);
						table.ajax.reload();
						if (response == 400 ){
							$('#success').html('Request sent! ').show().delay(2000).fadeOut(); 
						}else if(response == 404) {
							$('#error').html('Error sending request. Please try later').show().delay(2000).fadeOut(); 
						} 
					})
					.fail(function() {
						$('#upload').html("continue").attr('disabled',false);
						$('#error').html('Error occured. Please check connection and try again.').show().delay(2000).fadeOut(); 
					});
					$(this).each(function(){
						this.reset();   //Here form fields will be cleared.
					});
					
					return false;
				   
			   })
           	   $("#role").change(function(){
					var roleType = $(this).val();
           	   	    if(roleType){
						$.ajax({
           	   	     	type:"POST",
           	   	     	url:'../assets/server/reg.php',
           	   	     	data:'roleType='+roleType,
						success:function(html){
							$('#role_name').html(html);
						}	   
           	   	     });
					}else{
						$('#role_name').html("<option>Choose the reciever's name</option>");
					}
           	   });
				  

			   	  
	       });
      </script>
											


</body>

</html>