<?php

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Create Your Account</title>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="generator" content="Mobirise v4.12.3, mobirise.com">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
	<link rel="shortcut icon" href="" type="image/x-icon">
	<meta name="description" content="">
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="assets/vendor/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="assets/css/util.css">
    <link rel="stylesheet" type="text/css" href="assets/css/main.css">
    <script src="assets/vendor/jquery/jquery-3.2.1.min.js"></script>

	<!-- <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet"> -->
	<style>
		.input100 {
			padding: 0 30px 0 20px;
		}
		.login-form-title{
			padding-bottom: 20px;
        }
        .btn:hover{
            color: white;
        }

	</style>

</head>

<body>
	<div class="container-login100">
		<div class="wrap-login100">
			<div class="login100-pic  m-t-100">
				<img src="assets/images/covenant-university-logo-iscn-international-sustainable-campus-network-member.png" alt="IMG">
			</div>
			<form class="login100-form validate-form" autocomplete="off" id="regform" method="POST">
				<span class="login100-form-title">
					Create your Account
                </span>
                <div class="alert alert-success alert-dismissible" id="success" style="display:none;"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a></div>
                <div class="alert alert-danger alert-dismissible" id="error" style="display:none;"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a></div>

                <div class="wrap-input100">
					<input class="input100" type="text" name="uName" id="name" required placeholder="Full Name">
				</div>
				<div class="wrap-input100"  data-validate="Valid email is required">
					<input class="input100" type="email" name="eMail" id="email" required placeholder="Email">
				</div>
				<div class="wrap-input100" data-validate="ID is required">
					<input class="input100" type="text" name="userID" id="id"  required placeholder="Staff/Student ID">

				</div>
				<div class=" wrap-input100">
					
					<select id="role" class="form-control" required name="role" >
						<option value="">Choose your role...</option>
						<option value="pg_coord">PG Coordinator</option>
						<option value="hod">Head Of Department</option>
						<option value="col_sps_coord">College SPS Coordinator</option>
						<option value="student">Student</option>
						<option value="dean_col">Dean of College</option>
						<option value="sps_senate">SPS Senate Officer</option>
						<option value="sub_dean_sps">Sub-Dean SPS</option>
						<option value="dean_sps">Dean SPS</option>
						<option value="examiner">Examiner</option>
						<option value="supervisor">Supervisor</option>
					</select>
				</div>

				
				<div class="container-login100-form-btn">
					<button class="login100-form-btn btn " type="submit" id="reg">
						Continue
					</button>
				</div>
				<span id="status" style="font-size: 14px;"></span>

				<div class="text-center txt2 p-t-25">
					Already have an account?
					<a class="txt2" href="index.php">
						Login!
						<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
					</a>
				</div>
			</form>
		</div>
		<footer class="col-md-6 mx-auto container text-center align-items-center">
			© Copyright 2020 Covenant University - All Rights Reserved
		</footer>
	</div>
    <script>
        $(document).ready(function (){
            $('#regform').submit(function(e){
                e.preventDefault();
                var selected = $('#role option:selected');
                
                var name = $('#name').val();
                var email = $('#email').val();
                var id = $('#id').val();
                var role = selected.val();
                                
                $('#reg').html("processing").attr("disabled",true); //changes the button text to PROCESSING...
                $.ajax({
                    type: 'POST',
                    url: 'assets/server/reg.php?action=r',
                    data: {
                        type: 1,
                        name: name,
                        email: email,
                        id: id,
                        role: role
                    }
                })
                .done(function(response){
                    console.log(response);
                    $('#reg').html("Continue").attr('disabled',false);
                    if (response == 204 ){
                        $('#error').html('You already have an account!').show().delay(2000).fadeOut();
                    }else if(response == 404 ) {
                        $('#error').html('An error occured. Try later!').show().delay(2000).fadeOut();;
                    }else if(response == 500 ) {
                        $('#success').html('Sucessful!.Check your email for activation link.').show().delay(2000).fadeOut(); 
                    }else if(response == 406 ) {
                        $('#error').html('Error occured. Please check connection and try again.').show().delay(2000).fadeOut();
                    }else if(response == 999 ) {
                        $('#error').html('An error occured. Try later!').show().delay(2000).fadeOut();;
                    }
                })

                .fail(function() {
                    // just in case posting your form failed
                    $('#reg').html("continue").attr('disabled',false);
                    $('#error').html('Error occured. Please check connection and try again.').show().delay(2000).fadeOut(); 
                });

                $(this).each(function(){
                    this.reset();   //Here form fields will be cleared.
                });                
                return false;
            });
        });
        
    </script>


	<script src="assets/vendor/bootstrap/js/popper.js"></script>
	<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/vendor/tilt/tilt.jquery.min.js"></script>
	<script src="assets/js/main.js"></script>

</body>

