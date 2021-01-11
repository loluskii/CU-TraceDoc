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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>
	<link href="../assets/css/styles.css" rel="stylesheet">
	
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
				<em class="fa fa-navicon">&nbsp;</em> New Request <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="fa fa-plus"></em></span>
				</a>
				<ul class="children collapse" id="sub-item-1">
					<li><a href="form.php">
						<span class="fa fa-arrow-right">&nbsp;</span> Fill New Form
					</a></li>
					<li><a class="" href="request.php">
						<span class="fa fa-arrow-right">&nbsp;</span> Create New Request
					</a></li>
				</ul>
			</li>

			<li><a href="pending.php"><em class="fa fa-clock-o">&nbsp;</em> Pending Requests</a></li>
			<li><a href="resolved.php"><em class="fa fa-check">&nbsp;</em> Resolved Requests</a></li>

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
				<li class="active">Dashboard</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Dashboard</h1>
			</div>
		</div><!--/.row-->
		
		<div class="panel panel-container">
			<div class="row">
				<div class="col-xs-6 col-md-6 col-lg-6 no-padding">
					<div class="panel panel-teal panel-widget border-right">
						<div class="row no-padding"><em class="fa fa-xl fa-clock-o color-orange"></em>
							<?php
							$sql = "SELECT * FROM requests WHERE request_status = 'pending' and sender_id = '$user_id'";
							$result = mysqli_query($con,$sql) or die(mysqli_error($con));
							$count = mysqli_num_rows($result);
							
							?>
							<div class="large"><?php echo $count ?></div>
							<div class="text-muted">Pending</div>
						</div>
					</div>
				</div>
				<div class="col-xs-6 col-md-6 col-lg-6 no-padding">
					<div class="panel panel-blue panel-widget border-right">
						<div class="row no-padding"><em class="fa fa-xl fa-check color-blue"></em>
							<?php
							$sqls = "SELECT * FROM requests WHERE request_status = 'resolved'";
							$res = mysqli_query($con,$sqls) or die(mysqli_error($con));
							$cnt = mysqli_num_rows($res);
							
							?>
							<div class="large"><?php echo $cnt ?></div>
							<div class="text-muted">Resolved</div>
						</div>
					</div>
				</div>
			</div><!--/.row-->
		</div>
		
		<div class="row">
			<div class="col-md-6">
				<iframe src="weather.php" width="663px" height="390px" style="border:none;"></iframe>
				<!-- <div class="panel panel-default">
					<div class="panel-heading">
						To-do List
						<ul class="pull-right panel-settings panel-button-tab-right">
							<li class="dropdown"><a class="pull-right dropdown-toggle" data-toggle="dropdown" href="#">
								<em class="fa fa-cogs"></em>
							</a>
								<ul class="dropdown-menu dropdown-menu-right">
									<li>
										<ul class="dropdown-settings">
											<li><a href="#">
												<em class="fa fa-cog"></em> Settings 1
											</a></li>
											<li class="divider"></li>
											<li><a href="#">
												<em class="fa fa-cog"></em> Settings 2
											</a></li>
											<li class="divider"></li>
											<li><a href="#">
												<em class="fa fa-cog"></em> Settings 3
											</a></li>
										</ul>
									</li>
								</ul>
							</li>
						</ul>
						<span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
					<div class="panel-body">
						<ul class="todo-list">
							<li class="todo-list-item">
								<div class="checkbox">
									<input type="checkbox" id="checkbox-1" />
									<label for="checkbox-1">Make coffee</label>
								</div>
								<div class="pull-right action-buttons"><a href="#" class="trash">
									<em class="fa fa-trash"></em>
								</a></div>
							</li>
							<li class="todo-list-item">
								<div class="checkbox">
									<input type="checkbox" id="checkbox-2" />
									<label for="checkbox-2">Check emails</label>
								</div>
								<div class="pull-right action-buttons"><a href="#" class="trash">
									<em class="fa fa-trash"></em>
								</a></div>
							</li>
							<li class="todo-list-item">
								<div class="checkbox">
									<input type="checkbox" id="checkbox-3" />
									<label for="checkbox-3">Reply to Jane</label>
								</div>
								<div class="pull-right action-buttons"><a href="#" class="trash">
									<em class="fa fa-trash"></em>
								</a></div>
							</li>
							<li class="todo-list-item">
								<div class="checkbox">
									<input type="checkbox" id="checkbox-4" />
									<label for="checkbox-4">Make more coffee</label>
								</div>
								<div class="pull-right action-buttons"><a href="#" class="trash">
									<em class="fa fa-trash"></em>
								</a></div>
							</li>
							<li class="todo-list-item">
								<div class="checkbox">
									<input type="checkbox" id="checkbox-5" />
									<label for="checkbox-5">Work on the new design</label>
								</div>
								<div class="pull-right action-buttons"><a href="#" class="trash">
									<em class="fa fa-trash"></em>
								</a></div>
							</li>
							<li class="todo-list-item">
								<div class="checkbox">
									<input type="checkbox" id="checkbox-6" />
									<label for="checkbox-6">Get feedback on design</label>
								</div>
								<div class="pull-right action-buttons"><a href="#" class="trash">
									<em class="fa fa-trash"></em>
								</a></div>
							</li>
						</ul>
					</div>
					<div class="panel-footer">
						<div class="input-group">
							<input id="btn-input" type="text" class="form-control input-md" placeholder="Add new task" /><span class="input-group-btn">
								<button class="btn btn-primary btn-md" id="btn-todo">Add</button>
						</span></div>
					</div>
				</div> -->
			</div><!--/.col-->
			
			
			<div class="col-md-6">
				<div class="panel panel-default" style="border-radius: 25px; margin: 30px 30px;">
					
					<div class="panel-body">
						<div id="calendar"></div>
					</div>
				</div>

			</div><!--/.col-->
		</div><!--/.row-->
		<div class="row">
			<div class="container">
				<div class="col-md-12 col-sm-12">
				<div class="panel panel-default articles">
					<div class="panel-heading">
						Latest News
						<ul class="pull-right panel-settings panel-button-tab-right">
							<li class="dropdown"><a class="pull-right dropdown-toggle" data-toggle="dropdown" href="#">
								<em class="fa fa-cogs"></em>
							</a>
								<ul class="dropdown-menu dropdown-menu-right">
									<li>
										<ul class="dropdown-settings">
											<li><a href="#">
												<em class="fa fa-cog"></em> Settings 1
											</a></li>
											<li class="divider"></li>
											<li><a href="#">
												<em class="fa fa-cog"></em> Settings 2
											</a></li>
											<li class="divider"></li>
											<li><a href="#">
												<em class="fa fa-cog"></em> Settings 3
											</a></li>
										</ul>
									</li>
								</ul>
							</li>
						</ul>
						<span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
					<div class="panel-body articles-container">
						<div class="article border-bottom">
							<div class="col-xs-12">
								<div class="row">
									<div class="col-xs-2 col-md-2 date">
										<div class="large">30</div>
										<div class="text-muted">Jun</div>
									</div>
									<div class="col-xs-10 col-md-10">
										<h4><a href="#">Covenant Rises 50 Places to 101-150 in THE Young University Rankings</a></h4>
										<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer at sodales nisl. Donec malesuada orci ornare risus finibus feugiat.</p>
									</div>
								</div>
							</div>
							<div class="clear"></div>
						</div><!--End .article-->
						
						<div class="article border-bottom">
							<div class="col-xs-12">
								<div class="row">
									<div class="col-xs-2 col-md-2 date">
										<div class="large">28</div>
										<div class="text-muted">Jun</div>
									</div>
									<div class="col-xs-10 col-md-10">
										<h4><a href="#">2020 INWED: APWEN Educates Women in Covenant Host Community</a></h4>
										<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer at sodales nisl. Donec malesuada orci ornare risus finibus feugiat.</p>
									</div>
								</div>
							</div>
							<div class="clear"></div>
						</div><!--End .article-->
						
						<div class="article">
							<div class="col-xs-12">
								<div class="row">
									<div class="col-xs-2 col-md-2 date">
										<div class="large">24</div>
										<div class="text-muted">Jun</div>
									</div>
									<div class="col-xs-10 col-md-10">
										<h4><a href="#">Covenant Rises to 2nd Position by Volume of Scholarly Output Since 2015 in Nigeria</a></h4>
										<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer at sodales nisl. Donec malesuada orci ornare risus finibus feugiat.</p>
									</div>
								</div>
							</div>
							<div class="clear"></div>
						</div><!--End .article-->
					</div>
				</div><!--End .articles-->

				</div>
			</div>
		</div>
	</div>	<!--/.main-->
	
	<script src="../assets/js/jquery-1.11.1.min.js"></script>
	<script src="../assets/js/bootstrap.min.js"></script>
	<script src="../assets/js/bootstrap-datepicker.js"></script>
	<script src="../assets/js/custom.js"></script>
		
</body>
</html>