<?php

include ("../assets/server/session.php");

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>TraceDoc - Settings</title>
	<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="../assets/css/font-awesome.min.css" rel="stylesheet">
	<link href="../assets/css/datepicker3.css" rel="stylesheet">
	<link href="../assets/css/styles.css" rel="stylesheet">
	<!--Custom Font-->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
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

	<!--[if lt IE 9]>
	<![endif]-->
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
				<em class="fa fa-navicon">&nbsp;</em> New Request <span data-toggle="collapse" href="#sub-item-2" class="icon pull-right"><em class="fa fa-plus"></em></span>
				</a>
				<ul class="children collapse" id="sub-item-2">
					<li><a href="req_form.php">
						<span class="fa fa-arrow-right">&nbsp;</span> Request or Upload Form
					</a></li>
					<li><a href="new-request.php">
						<span class="fa fa-arrow-right">&nbsp;</span> Create New Requests
					</a></li>
					<!-- <li><a class="" href="request.php">
						<span class="fa fa-arrow-right">&nbsp;</span> View Resolved Requests
					</a></li> -->
				</ul>
			</li>

			<li class="active"><a href="settings.php"><em class="fa fa-cog">&nbsp;</em> Settings</a></li>


			<li><a href="index.php?logout"><em class="fa fa-power-off">&nbsp;</em> Logout</a></li>
		</ul>
	</div><!--/.sidebar-->
		
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active">Account Settings</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Settings</h1>
			</div>
		</div><!--/.row-->
		
		
		<div class="row">
			<div class="col-md-6">
			<div class="panel panel-default shadow" style="border-radius: 25px;">
					<div class="panel-heading">
						Update Your Profile
						<span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
					<div class="panel-body">
						<?php
							$sql = "SELECT * FROM accounts WHERE user_id = '$user_id'";
							$result = mysqli_query($con,$sql) or die(mysqli_error($con));
							$row = mysqli_fetch_assoc($result);
							
						?>
						<form class="form-horizontal" id="update_profile" method="post" autocomplete="off">
							<div class="alert alert-success alert-dismissible" id="success" style="display:none;"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a></div>
							<div class="alert alert-danger alert-dismissible" id="error" style="display:none;"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a></div>

							<fieldset>
								<!-- Name input-->
								<div class="form-group">
									<label class="col-md-3 control-label" for="name">Name</label>
									<div class="col-md-9">
										<input id="name" disabled type="text" value=<?php echo $row['user_name']?> class="form-control">
									</div>
								</div>
							
								<!-- Email input-->
								<div class="form-group">
									<label class="col-md-3 control-label" for="email">Your E-mail</label>
									<div class="col-md-9">
										<input  disabled type="text" value=<?php echo $row['user_email']?> class="form-control">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-3 control-label" for="email">Your ID</label>
									<div class="col-md-9">
										<input disabled type="text" value=<?php echo $row['user_id']?>  class="form-control">
									</div>
								</div>
								
								
								<div class="form-group">
									<label class="col-md-3 control-label" for="email">Department</label>
									<div class="col-md-9">
										<input id="dept" type="text" placeholder="Department" class="form-control">
									</div>
								</div>
								<!-- Form actions -->
								<div class="form-group">
									<div class="col-md-12 widget-right">
										<button id="sub" type="submit" class="btn btn-primary btn-md pull-right">Submit</button>
									</div>
								</div>
							</fieldset>
						</form>
						<script>
							$('#update_profile').submit(function(e){ 
								e.preventDefault();
								var dept = $('#dept').val();
											
								$('#sub').html("WAIT").attr("disabled",true); //changes the button text to PROCESSING...
								$.ajax({
									type: 'POST',
									url: '../assets/server/reg.php?action=update',
									data: {
										dept: dept,
									}
								})
								.done(function(response){
									console.log(response);
									$('#sub').html("Submit").attr('disabled',false);
									if (response == 400 ) {
										$('#success').html('Profile Updated!').show().delay(2000).fadeOut(); 
									}else if(response == 404 ) {
										$('#error').html('Error occured. Please try again later.').show().delay(2000).fadeOut();
									}
								})

								.fail(function() {
									// just in case posting your form failed
									$('#sub').html("Submit").attr('disabled',false);
									$('#error').html('Error occured. Please check connection and try again.').show().delay(2000).fadeOut(); 
								});

								$(this).each(function(){
									this.reset();   //Here form fields will be cleared.
								});                
								return false;
							});


						</script>

					</div>
				</div>

			</div><!--/.col-->
			
			
			<div class="col-md-6">
				<div class="panel panel-default shadow" style="border-radius: 25px;">
					<div class="panel-heading">
						Reset Your Password
						<span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
					<div class="panel-body">
						<form class="form-horizontal" id="update_pass" method="post" autocomplete="off">
							<div class="alert alert-success alert-dismissible" id="success1" style="display:none;"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a></div>
							<div class="alert alert-danger alert-dismissible" id="error1" style="display:none;"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a></div>

							<fieldset>
								<!-- Name input-->
								<div class="form-group">
									<label class="col-md-3 control-label" for="name">Old Password</label>
									<div class="col-md-9">
										<input id="old" name="name" type="password"  class="form-control">
									</div>
								</div>
							
								<!-- Email input-->
								<div class="form-group">
									<label class="col-md-3 control-label" for="email">New Password</label>
									<div class="col-md-9">
										<input id="pass1" name="pass1" type="password" class="form-control">
									</div>
								</div>
								
								<!-- Message body -->
								<div class="form-group">
									<label class="col-md-3 control-label" for="message">Re-type Password</label>
									<div class="col-md-9">
										<input id="pass2" name="pass2" type="password" placeholder="" class="form-control">
									</div>
								</div>
								
								<!-- Form actions -->
								<div class="form-group">
									<div class="col-md-12 widget-right">
										<button type="submit" class="btn btn-primary btn-md pull-right" id="update">Submit</button>
									</div>
								</div>
							</fieldset>
						</form>
						<script>
							$('#update_pass').submit(function(e){ 
								e.preventDefault();
								var pass = $('#old').val();
								var new_pass1 = $('#pass1').val();
								var new_pass2 = $('#pass2').val();	
											
								$('#update').html("WAIT").attr("disabled",true); //changes the button text to PROCESSING...
								$.ajax({
									type: 'POST',
									url: '../assets/server/reg.php?action=reset',
									data: {
										pass: pass,
										new_pass1: new_pass1,
										new_pass2: new_pass2,
									}
								})
								.done(function(response){
									console.log(response);
									$('#update').html("Submit").attr('disabled',false);
									if (response == 600 ){
										$('#error1').html('Old password is incorrect').show().delay(2000).fadeOut();
									}else if(response == 500 ) {
										$('#error1').html('Passwords do not match').show().delay(2000).fadeOut();;
									}else if(response == 400 ) {
										$('#success1').html('Password update successfully').show().delay(2000).fadeOut(); 
									}else if(response == 404 ) {
										$('#error1').html('Error occured. Please try again later.').show().delay(2000).fadeOut();
									}
								})

								.fail(function() {
									// just in case posting your form failed
									$('#update').html("Submit").attr('disabled',false);
									$('#error1').html('Error occured. Please check connection and try again.').show().delay(2000).fadeOut(); 
								});

								$(this).each(function(){
									this.reset();   //Here form fields will be cleared.
								});                
								return false;
							});


						</script>
					</div>
				</div>

			</div><!--/.col-->
			
		</div><!--/.row-->
	</div>	<!--/.main-->
	
	<script src="../assets/js/bootstrap.min.js"></script>
	<script src="../assets/js/bootstrap-datepicker.js"></script>
	<script src="../assets/js/custom.js"></script>
	
</body>
</html>
