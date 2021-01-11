<?php



?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Sign In</title>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="generator" content="Mobirise v4.12.3, mobirise.com">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
	<link rel="shortcut icon" href="" type="image/x-icon">
	<meta name="description" content="">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
		integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/vendor/animate/animate.css">
	<link rel="stylesheet" href="assets/css/util.css">
	<link rel="stylesheet" href="assets/css/main.css">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
	<script src="assets/vendor/jquery/jquery-3.2.1.min.js"></script>


</head>

<body>
	<div class="container-login100">
		<div class="wrap-login100">
			<div class="login100-pic m-t-60">
				<img src="assets/images/covenant-university-logo-iscn-international-sustainable-campus-network-member.png" alt="IMG">
			</div>
			<form class="login100-form validate-form" autocomplete="off" id="logform" method="POST">
				<span class="login100-form-title">
					Login to your Account
				</span>
				<div class="alert alert-danger alert-dismissible" id="error" style="display:none;"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a></div>
				<div class="wrap-input100 validate-input">
					<input class="input100" type="text" name="userid" id="userid" placeholder="Email or ID">
				</div>
				<div class="wrap-input100 validate-input" data-validate="Enter your password">
					<input class="input100" type="password" name="password" id="user_pass" placeholder="Password">
				</div>
				<div class="container-login100-form-btn">
					<button class="login100-form-btn" type="submit" id="reg">
						Continue
					</button>
				</div>
				<div class="text-center txt2 p-t-25">
					Don't have an account?
					<a class="txt2" href="register.php">
						Register!
						<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
					</a>
				</div>
			</form>
			<script>
				$(document).ready(function () {
					$('#logform').submit(function(e){
                e.preventDefault();
                
                var id = $('#userid').val();
                var pass = $('#user_pass').val();
                                
                $('#reg').html("processing").attr('disabled',true); //changes the button text to PROCESSING...
                $.ajax({
                    type: 'POST',
                    url: 'assets/server/reg.php?action=l',
                    data: {
                        type: 1,
                        id: id,
                        pass: pass,
                    }
                })
                .done(function(response){
                    console.log(response);
                    $('#reg').html("Continue").attr('disabled',false);
                    if (response == 500 ){
                        $("body").fadeOut(1000,function(){
							window.location.replace("studentView/index.php");
						});
                    }else if(response == 600 ) {
                        $("body").fadeOut(1000,function(){
							window.location.replace("staffView/index.php");
						});
                    }else if(response == 404 ) {
                        $('#error').html('Incorrect Id or password!').show().delay(2000).fadeOut(); 
                    }else {
                        $('#error').html('Error occured. Please check connection and try again.').show().delay(2000).fadeOut();
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

		</div>
		<footer class="col-md-6 mx-auto container text-center align-items-center">
			© Copyright 2020 Covenant University - All Rights Reserved
		</footer>
	</div>


	<script src="assets/vendor/bootstrap/js/popper.js"></script>
	<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/vendor/tilt/tilt.jquery.min.js"></script>
	<script>
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
	<script src="assets/js/main.js"></script>

</body>

</html>

