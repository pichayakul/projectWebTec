<!DOCTYPE html>
<html>
<head>
	<title>View Profile</title>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
</head>
<?php require 'header.php'; ?>
<body >
	<div class="container" style="background-color:white;">
	<h1>Profile</h1>
	<hr style="height:5px;  background-color:#FF6666	;">
<div class="row">
		<!-- left column -->
		<div class="col-md-3">
			<div class="text-center">
				<img src="<?php echo $_SESSION['image'];?>" class="avatar img-circle" alt="avatar" style="width: 80%;">
				<h6>Change Photo</h6>

				<input type="file" name="imageUp" class="form-control">
			</div>
		</div>
		<!-- edit form column -->
		<div class="col-md-9 personal-info" >

			<h3>Personal info</h3>

			<form id="profile-form" class="form-horizontal" role="form" action="./index.php" method="POST">
				<div class="form-group">
					<label id="profile-text-firstname"class="col-lg-3 control-label">First name:</label>
					<div class="col-lg-8">
						<input class="form-control" type="text" id="profile-firstname" name="first_name" value="<?php echo $_SESSION['first_name']; ?>" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" id="profile-text-lastname">Last name:</label>
					<div class="col-lg-8">
						<input class="form-control" type="text" id="profile-lastname" name="last_name" value="<?php echo $_SESSION['last_name']; ?>" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" id="profile-text-nickname">Nickname:</label>
					<div class="col-lg-8">
						<input class="form-control" type="text" id="profile-nickname" name="nickname" value="<?php echo $_SESSION['nickname']; ?>" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" >Gender: </label>
					<div class="col-lg-8">
						<label class="control-label"><?php switch ($_SESSION['gender']){case 'm':echo "Male";break; case 'w':echo "Female";break;} ?></label>

					</div>

				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" >Age: </label>
					<div class="col-lg-8">
						<label class="control-label" style="float:left;"><?php echo $_SESSION['age']; ?></label>
					</div>

				</div>

				<div class="form-group">
					<label class="col-lg-3 control-label" id="profile-text-email">Email:</label>
					 <input type="hidden" id="profile-has-email" name="has-email" value="false">
					<div class="col-lg-8">
						<input class="form-control" type="text" id="profile-email" name="email" value="<?php echo $_SESSION['email']; ?>" required>
						<label id="profile-alert-email" class="noshow">---Email is already used.---</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label"id="profile-text-password">New Password:</label>
					<div class="col-lg-8">
						<input type="password" class="form-control" id="profile-password" name="password" required>
						<label id="profile-alert-email" >---Blank, if you don't want to change it.---</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label" id="profile-text-confirmpassword">Confirm Password</label>
					<div class="col-md-8">
						<input type="password" class="form-control" id="profile-confirmpassword" name="confirm-password" required>
						<label id="profile-alert-email" >---Blank, if you don't want to change it.---</label>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label"></label>
					<div class="col-md-8">
						<input type="hidden" name="status" value="viewprofile">
    				<a id="profile-form-submit" class="btn btn-primary">Save Change</a>
    				<a class="btn btn-danger" id="profile-form-submit" href="./index.php">Cancel</a>
					</div>
				</div>
			</form>
		</div>
</div>
</div>





	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script>
		$(document).ready(function() {
			actionForm();
		});

		function actionForm() {
			$('#profile-form-submit').click(function(e) {
				password = $('#profile-password').val();
				confirmpassword = $('#profile-confirmpassword').val();
				nickname = $('#profile-nickname').val();
				firstname = $('#profile-firstname').val();
				lastname = $('#profile-lastname').val();
				email = $('#profile-email').val();
				hasEmail = $('#profile-has-email').val();

				isWrong = 0;
				href = "";

				if (password.length > 15)
				{
					$('#profile-text-password').text("*Password");
					if (href == "") {href="#profile-text-password";}
					isWrong = 1;
				} else {
					$('#profile-text-password').text($('#profile-text-password').text().replace("*",""));
				}

				if (confirmpassword.length > 15||confirmpassword!=password)
				{
					$('#profile-text-confirmpassword').text("*Confirm Password");
					if (href == "") {href="#profile-text-confirmpassword";}
					isWrong = 1;
				} else {
					$('#profile-text-confirmpassword').text($('#profile-text-confirmpassword').text().replace("*",""));
				}

				if (nickname.length == 0||nickname.length > 30)
				{
					$('#profile-text-nickname').text("*Nickname");
					if (href == "") {href="#profile-text-nickname";}
					isWrong = 1;
				} else {
					$('#profile-text-nickname').text($('#profile-text-nickname').text().replace("*",""));
				}

				if (firstname.length == 0||firstname.length > 30)
				{
					$('#profile-text-firstname').text("*First name");
					if (href == "") {href="#profile-text-firstname";}
					isWrong = 1;
				} else {
					$('#profile-text-firstname').text($('#profile-text-firstname').text().replace("*",""));
				}

				if (lastname.length == 0||lastname.length > 30)
				{
					$('#profile-text-lastname').text("*Last name");
					if (href == "") {href="#profile-text-lastname";}
					isWrong = 1;
				} else {
					$('#profile-text-lastname').text($('#profile-text-lastname').text().replace("*",""));
				}

				if (email.length == 0||hasEmail == "true")
				{
					$('#profile-text-email').text("*Email");
					if (href == "") {href="#profile-text-email";}
					isWrong = 1;
				} else {
					hasAdd = false;
					for (var i = 0; i < email.length; i++) {
						c = email.charAt(i);
						if (c == '@') {hasAdd = true;}
					}
					if (hasAdd == false) {
						$('#profile-text-email').text("*Email");
						if (href == "") {href="#profile-text-email";}
						isWrong = 1;
					} else {
						$('#profile-text-email').text($('#profile-text-email').text().replace("*",""));
					}
				}

				if (isWrong) {
					location.href = href;
					return false;
				}
				document.getElementById('profile-form').submit();
			});

			$('#profile-email').keyup(function() {
				email = $('#profile-email').val();
        $.ajax({
	        url: "./database/check-email.php", //the page containing php script
	        dataType: "json",
	        method: "POST",
	       	data: {email: email},
	        success: function(response) {
	        	status = response['status'];
	        	if (status == "YES") { // YES is no have username
	        		$('#profile-has-email').val("false");
	        		$('#profile-alert-email').css('display', 'none');
	        	} else {
	        		$('#profile-has-email').val("true");
	        		$('#profile-alert-email').css('display', 'block');
	        	}
		      },
		      error: function (xhr, ajaxOptions, thrownError) {
            console.log(thrownError);
        	}
	     	});
			});
		}
	</script>
</body>
</html>
