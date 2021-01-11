<?php

include ("../assets/server/session.php");

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>TraceDoc - Dashboard</title>
	<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="../assets/css/font-awesome.min.css" rel="stylesheet">
	<link href="../assets/css/datepicker3.css" rel="stylesheet">
	<link href="../assets/css/styles.css" rel="stylesheet">
	
	<!--Custom Font-->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap.min.css">
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
	<script src="../assets/vendor/jquery/jquery-3.2.1.min.js"></script>
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
	<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
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
			<li class="active"><a href="index.php"><em class="fa fa-dashboard">&nbsp;</em> Dashboard</a></li>

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
					</a></li>
					
					<li><a class="" href="upload.php">
						<span class="fa fa-arrow-right">&nbsp;</span> Upload Resolved Requests
					</a></li>
					<!-- <li><a class="" href="request.php">
						<span class="fa fa-arrow-right">&nbsp;</span> View Resolved Requests
					</a></li> -->
				</ul>
			</li>

			<li class="parent "><a data-toggle="collapse" href="#sub-item-2">
				<em class="fa fa-navicon">&nbsp;</em> New Request <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="fa fa-plus"></em></span>
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
	</div><!--/.sidebar-->
		
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
				<li>New Request</li>
				<li class="active">Forms</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Forms</h1>
			</div>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						Create a new form
						<span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
					<div class="panel-body">
						<form class="form-horizontal" action="../assets/server/reg.php?action=d" method="post">
							<fieldset>
								<!-- Name input-->
								<div class="form-group">
									<label class="col-md-3 control-label" for="name">Form Name</label>
									<div class="col-md-9">
										<select id="selectForm" class="form-control" name="form_name" style="height: 40px">
											<option value="">Select form name</option>
										</select>
										<script>
											$(document).ready(function (){
												$('#selectForm').select2({
													ajax: {
													url: "../assets/server/reg.php?a=loadform",
													type: "post",
													dataType:'json',
													delay:250,
													data: function(params){
														return {
															searchTerm: params.term 
														};
													},
													processResults: function(response){
														return{
															results : response
														};
													},
													cache: true
													}
												})
											})

										</script>                      
										
									</div>
								</div>
								<div class="form-group">
								  <label class="col-md-3 control-label" for="">Initiator/Form Key</label>
								  <div class="col-md-9">
								  	<input type="text" class="form-control"  name="" id="desc" placeholder="" disabled>
								  </div>
								</div>
								<div class="form-group">
									<div class="col-md-12 widget-right">
										<button type="submit" class="btn btn-primary btn-md pull-right" id="submit">Submit</button>
									</div>
								</div>
							</fieldset>
						</form>					
					</div>
				</div>
			</div><!--/.col-->
			
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						Upload a new form
						<span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
					<div class="panel-body">
						<form class="form-horizontal" id="new" action="" method="post">
							<fieldset>
							<div class="alert alert-success alert-dismissible" id="success" style="display:none;"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a></div>
                			<div class="alert alert-danger alert-dismissible" id="error" style="display:none;"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a></div>
								<!-- Name input-->
								<div class="form-group">
									<label class="col-md-3 control-label" for="name">Form Name</label>
									<div class="col-md-9">
										<input id="form_name" name="new_form" type="file" placeholder="Form Name" class="form-control">
									</div>
								</div>
								<!-- Form actions -->
								<div class="form-group">
									<div class="col-md-12 widget-right">
										<button id="upload" type="submit" class="btn btn-primary btn-md pull-right">Submit</button>
									</div>
								</div>
							</fieldset>
						</form>
						<script>
							$(document).ready(function(){
								$('#new').submit(function(e){
									//show sth is loading..
									e.preventDefault();
									var fd = new FormData();
									var files = $('#form_name')[0].files[0];
									fd.append('new_form',files);									

									$('#upload').html("WAIT").attr('disabled',true); //changes the button text to PROCESSING...
									$.ajax({
										type: 'POST',
										url: '../assets/server/reg.php?action=u',
										data: fd,
										contentType: false,
            							processData: false,
									})
									.done(function(response){
										console.log(response);
										$('#upload').html("Submit").attr('disabled',false);
										if (response == 400 ){
						                    $('#success').html('Form uploaded successfully').show().delay(2000).fadeOut(); 
										}else if(response == 404) {
						                    $('#error').html('Error uploading form. Please try later').show().delay(2000).fadeOut(); 
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
								});
							});
                  		</script>

					</div>
				</div>
			</div><!--/.col-->
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						List of Uploaded Forms
						<span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
					<div class="panel-body">
						<table class="table table-hover table-striped" id="uploaded_forms">
							<thead>
								<tr>
									<th class="text-center">Form Name</th>
									<th class="text-center">Description</th>
									<th class="text-center">Date Uploaded</th>
								</tr>
							</thead>
							<tbody  class="text-center">
								<tr>
									<td></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div><!--/.col-->

		</div><!--/.row-->

		
	</div>	<!--/.main-->
	
	<script src="../assets/js/bootstrap.min.js"></script>
	<script src="../assets/js/bootstrap-datepicker.js"></script>
	<script src="../assets/js/custom.js"></script>
	<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>


	<!-- <script>
		$('#submit').on('click', function(){
			window.alert("Your document is being downloaded.");
		})
	</script> -->
    <script type="text/javascript" language="javascript" >
		$(document).ready(function() {
			var table =$('#uploaded_forms').DataTable({
				"bProcessing": true,
				"sAjaxSource": "../assets/server/table.php",
				"iDisplayLength": 10,
				"aoColumns": [
						
						{ mData: 'Form_Name' } ,
						{ mData: 'Form_Key' },
						{ mData: 'Date_Uploaded' },
					]
			})
			// table.ajax.reload();
			$("#selectForm").change(function(){
					var form = $(this).val();
					//console.log(form);
           	   	    if(form){
						$.ajax({
           	   	     	type:"POST",
           	   	     	url:'../assets/server/reg.php',
           	   	     	data:'formtype='+form,
						success:function(html){
							$('#desc').val(html);
						}	   
           	   	     });
					}else{
						$('#desc').html("");
					}
           	   });
		});
		
	</script>
	
		
</body>
</html>