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

			<li class="parent active"><a data-toggle="collapse" href="#sub-item-1">
				<em class="fa fa-clock-o">&nbsp;</em> Tasks <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="fa fa-plus"></em></span>
				</a>
				<ul class="children collapse" id="sub-item-1">
				<li><a href="pending.php">
						<?php 
						$sql = "SELECT * FROM requests WHERE request_status = 'pending' AND receiver_id = '$user_id'";
						$result = mysqli_query($con, $sql);
						$rows = mysqli_num_rows($result);
						// if($rows < 1){
						// 	$no = "";
						// }else if($rows > 1){
						// 	$no = $rows;
						// }
						?>
						<span class="fa fa-arrow-right">&nbsp;</span> Pending Requests <span class="badge badge-light"><?php echo $rows?></span>
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
					</a></li>					<li><a class="" href="new-request.php">
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
				<li class="active">Requests</li>
				<li class="active">Pending Requests</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Pending Requests</h1>
			</div>
		</div><!--/.row-->

		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default shadow-lg">
					<div class="panel-heading">

						<span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
					<div class="panel-body">
						<table class="table table-hover table-striped" id="requests">
							<thead class="text-center">
								<tr>
									<th class="text-center">Request ID</th>
									<th style="width:25%;" class="text-center">Description</th>
									<th class="text-center">Sender </th>
									<th style="width:25%;" class="text-center">Note </th>
									<th class="text-center">Date Sent</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody">
							</tbody>
						</table>
					</div>
				</div>
				<div class="modal fade" id="downloadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Resolve request</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
					You are about to download this request. Continue?
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
						<button type="button" class="btn btn-primary" id="submit">Download</button>
					</div>
					</div>
				</div>
				</div>
				

				<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Resolve request</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
					You are about to delete this request. Are you sure you want to continue?
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
						<button type="button" class="btn btn-primary" id="confirm">Delete</button>
					</div>
					</div>
				</div>
				</div>
			</div>
		</div>

		
	</div>	<!--/.main-->
	
	<script src="../assets/js/jquery-1.11.1.min.js"></script>
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
				"order": [],
				"ajax": {
					url: "../assets/server/reg.php",
					type: "POST",
					data: {
						action: 'listPendingRequest'
					},
					dataType: "json"
				}
			});
			

			$('#requests').on('click', '.delete', function() {
				var modalConfirm = function(callback){
					$("#confirm").on("click", function(){
						callback(true);
						$("#deleteModal").modal('hide');
					});
				}

				var id = $(this).attr('id');
				var action = 'deleteRequest';
				modalConfirm(function(confirm){
					if(confirm){
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
					}else{
						return false;
					}
				});
			});
			$('#submit').click(function(){
				/* when the submit button in the modal is clicked, submit the form */
				$('#formfield').submit();
				$("#downloadModal").modal('hide');
			});
		})
	</script>

		
</body>
</html>