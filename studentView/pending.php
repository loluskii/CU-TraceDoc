<?php

include("../assets/server/session.php");

?>


<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pending Requets</title>
	<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="../assets/css/font-awesome.min.css" rel="stylesheet">
	<link href="../assets/css/datepicker3.css" rel="stylesheet">
	<link href="../assets/css/styles.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap.min.css">
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
			<li><a href="index.php"><em class="fa fa-dashboard">&nbsp;</em> Dashboard</a></li>
			<li class="parent "><a data-toggle="collapse" href="#sub-item-1">
					<em class="fa fa-navicon">&nbsp;</em> New Request <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="fa fa-plus"></em></span>
				</a>
				<ul class="children collapse" id="sub-item-1">
					<li class="active"><a href="form.php">
							<span class="fa fa-arrow-right">&nbsp;</span> Fill New Form
						</a></li>
					<li><a class="" href="request.php">
							<span class="fa fa-arrow-right">&nbsp;</span> Create New Request
						</a></li>
				</ul>
			</li>
			<li class="active"><a href="pending.php"><em class="fa fa-clock-o">&nbsp;</em> Pending Requests</a></li>
			<li><a href="resolved.php"><em class="fa fa-check">&nbsp;</em> Resolved Requests</a></li>


			<li><a href="settings.php"><em class="fa fa-cog">&nbsp;</em> Settings</a></li>

			<li><a href="pending.php?logout"><em class="fa fa-power-off">&nbsp;</em> Logout</a></li>
		</ul>
	</div>
	<!--/.sidebar-->

	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
						<em class="fa fa-home"></em>
					</a></li>
				<li class="active">Pending Requests</li>
			</ol>
		</div>
		<!--/.row-->

		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Pending Requests</h1>
			</div>
		</div>
		<!--/.row-->

		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">

						<span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
					<div class="panel-body">
						<table class="table table-hover table-striped" id="requests">
							<thead class="text-center">
								<tr>
									<th class="text-center">Request ID</th>
									<th style="width: 25%" class="text-center">Description</th>
									<th class="text-center">Sent to </th>

									<th class="text-center">Date Sent</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody class="text-center">
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>


	<script src="../assets/js/bootstrap.min.js"></script>
	<script src="../assets/js/bootstrap-datepicker.js"></script>
	<script src="../assets/js/custom.js"></script>
	<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
	<script>
		$(document).ready(function() {
			var requests = $('#requests').DataTable({
				// scrollY:'60vh',
				scrollCollapse: true,
				"iDisplayLength": 10,
				"bProcessing": true,
				"serverSide": true,
				"bPaginate": true,
				"order": [],
				"ajax": {
					url: "../assets/server/reg.php",
					type: "POST",
					data: {
						action: 'listSubmittedRequests'
					},
					dataType: "json"
				}
			});
			$('#requests').on('click', '.delete', function() {
				var id = $(this).attr('id');
				var action = 'deleteRecord';
				if (confirm('Are you sure you want to delete this request?')) {
					$.ajax({
						url: '../assets/server/reg.php',
						method: 'POST',
						data: {
							id: id,
							action: action
						},
						success: function(data) {
							requests.ajax.reload();
						}
					})
				} else {
					return false;
				}
			});

		})
	</script>

</body>

</html>