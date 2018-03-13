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
<?php
	$str_title = "Not found profile.";
	if (isset($_POST['status'])) {
		if (!strcmp($_POST['status'], "update")) {
			$username = $_POST['username'];
			$str_title = $username."'s Profile";
			require './database/epmtfafn_satta_db.php';
			$db = new Database();
			$db->openDatabase();
			$info = $db->infoUsername($username);
			$first_name = $info['first_name'];
			$last_name = $info['last_name'];
			$nickname = $info['nickname'];
			$age = $info['age'];
			$gender = $info['gender'];
			if ($gender == "m") {
				$male_checked = "checked";
				$female_checked = "";
			} else {
				$male_checked = "";
				$female_checked = "checked";
			}
			$position = $info['position'];
			if ($position == "admin") {
				$admin_checked = "checked";
				$orga_checked = "";
				$atten_checked = "";
			} else if ($position == "organizer") {
				$admin_checked = "";
				$orga_checked = "checked";
				$atten_checked = "";
			} else {
				$admin_checked = "";
				$orga_checked = "";
				$atten_checked = "checked";
			}
			$email = $info['email'];
			$password = $info['password'];
			$db->closeDatabase();
		}
	}
?>
<body>
	<div class="container" style="background-color:white;">
	<h1><?php echo $str_title ?></h1>
 <hr style="height:5px;  background-color:#FF6666	;">
<div class="row">
		<!-- left column -->
		<div class="col-md-3">
			<div class="text-center">
				<img src="https://cdn0.iconfinder.com/data/icons/user-pictures/100/matureman1-256.png" class="avatar img-circle" alt="avatar">
				<h6>Change Photo</h6>

				<input type="file" class="form-control">
			</div>
		</div>

		<!-- edit form column -->
		<div class="col-md-9 personal-info" >

			<h3>Personal info</h3>

			<form id="updateuser-form" class="form-horizontal" role="form" action="./manageuser.php" method="POST">
				<div class="form-group">
					<label id="updateuser-text-firstname"class="col-lg-3 control-label">First name:</label>
					<div class="col-lg-8">
						<input class="form-control" type="text" id="updateuser-firstname" name="first_name" value="<?php echo $first_name; ?>" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" id="updateuser-text-lastname">Last name:</label>
					<div class="col-lg-8">
						<input class="form-control" type="text" id="updateuser-lastname" name="last_name" value="<?php echo $last_name; ?>" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" id="updateuser-text-nickname">Nickname:</label>
					<div class="col-lg-8">
						<input class="form-control" type="text" id="updateuser-nickname" name="nickname" value="<?php echo $nickname; ?>" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" id="updateuser-text-age" >Age: </label>
					<div class="col-lg-8">
					<input type="text" class="form-control" id="updateuser-age" name="age" value="<?php echo $age;?>" required>
					</div>

				</div>

				<div class="form-group">
					<label class="col-lg-3 control-label" >Gender: </label>
					<div class="col-lg-8">
							<input type="radio" class="updateuser-gender" name="gender" <?php echo $male_checked; ?> value="m" required>
							<label class="mr-3">Male</label>
							<input type="radio" class="updateuser-gender" name="gender" <?php echo $female_checked; ?> value="w" required>
							<label>Female</label>

					</div>

				</div>

				<div class="form-group">
					<label class="col-lg-3 control-label" id="updateuser-text-email">Email:</label>
					<div class="col-lg-8">
						 <input type="hidden" id="updateuser-has-email" name="has-email" value="false">
						<input class="form-control" type="text" id="updateuser-email" name="email" value="<?php echo $email; ?>" required>
						<label id="updateuser-alert-email" class="noshow">---Email is already used.---</label>
					</div>
				</div>
				<div class="form-group">
					<input type="hidden" name="oldpassword" value="<?php echo $password; ?>">
					<label class="col-lg-3 control-label"id="updateuser-text-password">Password:</label>

					<div class="col-lg-8">
						<input type="password" class="form-control" id="updateuser-password" name="password" required>
						<label  >---Blank, if you don't want to change it.---</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label" id="updateuser-text-confirmpassword">Confirm Password:</label>
					<div class="col-md-8">
						<input type="password" class="form-control" id="updateuser-confirmpassword" name="password" required>
						<label  >---Blank, if you don't want to change it.---</label>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label">Position:</label>
					<div class="col-md-8">
						  <input type="radio" class="ml-5 mr-2" name="position" <?php echo $admin_checked; ?> value="admin" required>
							<label >Adminitrator</label><br>
							<input type="radio" class="ml-5 mr-2" name="position" <?php echo $orga_checked; ?> value="organizer" required>
							<label>Organizer</label><br>
							<input type="radio" class="ml-5 mr-2" name="position" <?php echo $atten_checked; ?> value="attendant" required>
							<label>Attendant</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label"></label>
					<div class="col-md-8">
						<input type="hidden" name="username" value="<?php echo $username; ?>">
						<input type="hidden" name="status" value="update">
    				<a class="btn btn-primary" id="updateuser-form-submit"  name="updateuser-form-submit">Save Change</a>
    				<a class="btn btn-danger"  href="./manageuser.php">Cancel</a>
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
			$('#updateuser-form-submit').click(function(e) {
				password = $('#updateuser-password').val();
				confirmpassword = $('#updateuser-confirmpassword').val();
				nickname = $('#updateuser-nickname').val();
				firstname = $('#updateuser-firstname').val();
				lastname = $('#updateuser-lastname').val();
				age = $('#updateuser-age').val();
				email = $('#updateuser-email').val();
				hasEmail = $('#updateuser-has-email').val();

				isWrong = 0;
				href = "";

				if (password.length > 15)
				{
					$('#updateuser-text-password').text("*Password");
					if (href == "") {href="#updateuser-text-password";}
					isWrong = 1;
				} else {
					$('#updateuser-text-password').text($('#updateuser-text-password').text().replace("*",""));
				}

				if (confirmpassword.length > 15||confirmpassword!=password)
				{
					$('#updateuser-text-confirmpassword').text("*Confirm Password");
					if (href == "") {href="#updateuser-text-confirmpassword";}
					isWrong = 1;
				} else {
					$('#updateuser-text-confirmpassword').text($('#updateuser-text-confirmpassword').text().replace("*",""));
				}

				if (nickname.length == 0||nickname.length > 30)
				{
					$('#updateuser-text-nickname').text("*Nickname");
					if (href == "") {href="#updateuser-text-nickname";}
					isWrong = 1;
				} else {
					$('#updateuser-text-nickname').text($('#updateuser-text-nickname').text().replace("*",""));
				}

				if (firstname.length == 0||firstname.length > 30)
				{
					$('#updateuser-text-firstname').text("*First name");
					if (href == "") {href="#updateuser-text-firstname";}
					isWrong = 1;
				} else {
					$('#updateuser-text-firstname').text($('#updateuser-text-firstname').text().replace("*",""));
				}

				if (lastname.length == 0||lastname.length > 30)
				{
					$('#updateuser-text-lastname').text("*Last name");
					if (href == "") {href="#updateuser-text-lastname";}
					isWrong = 1;
				} else {
					$('#updateuser-text-lastname').text($('#updateuser-text-lastname').text().replace("*",""));
				}

				if (email.length == 0||hasEmail == "true")
				{
					$('#updateuser-text-email').text("*Email");
					if (href == "") {href="#updateuser-text-email";}
					isWrong = 1;
				} else {
					hasAdd = false;
					for (var i = 0; i < email.length; i++) {
						c = email.charAt(i);
						if (c == '@') {hasAdd = true;}
					}
					if (hasAdd == false) {
						$('#updateuser-text-email').text("*Email");
						if (href == "") {href="#updateuser-text-email";}
						isWrong = 1;
					} else {
						$('#updateuser-text-email').text($('#updateuser-text-email').text().replace("*",""));
					}
				}

				if (isWrong) {
					location.href = href;
					return false;
				}
				document.getElementById('updateuser-form').submit();

			});

			$('#updateuser-email').keyup(function() {
				email = $('#updateuser-email').val();
        $.ajax({
	        url: "./database/check-email.php", //the page containing php script
	        dataType: "json",
	        method: "POST",
	       	data: {email: email},
	        success: function(response) {
	        	status = response['status'];
	        	if (status == "YES") { // YES is no have username
	        		$('#updateuser-has-email').val("false");
	        		$('#updateuser-alert-email').css('display', 'none');
	        	} else {
	        		$('#updateuser-has-email').val("true");
	        		$('#updateuser-alert-emai').css('display', 'block');
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
