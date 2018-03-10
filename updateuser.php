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
	<div class="row content">
		<div class="col-sm-1" style="background-color:lavender;"></div>
		<div class="col-sm-10">
			<div class="row">
				<div class="col-sm-12 text-center">
					<br>
					<h2><?php echo $str_title;?></h2>
					<hr>
					<br>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-3"></div>
				<div class="col-sm-6 profile">
					<form id="updateuser-form" method="POST" action="./manageuser.php">
						<h4>Information</h4><br>
						<div class="form-group">
							<label id="updateuser-text-firstname">First Name</label>
							<input type="text" class="form-control" id="updateuser-firstname" name="first_name" value="<?php echo $first_name; ?>" required>
						</div>
						<div class="form-group">
							<label id="updateuser-text-lastname">Last Name</label>
							<input type="text" class="form-control" id="updateuser-lastname" name="last_name" value="<?php echo $last_name; ?>" required>
						</div>
						<div class="form-group">
							<label id="updateuser-text-nickname">Nickname</label>
							<input type="text" class="form-control" id="updateuser-nickname" name="nickname" value="<?php echo $nickname; ?>" required>
						</div>
						<div class="form-group">
							<label id="updateuser-text-age">Age</label>
							<input type="text" class="form-control" id="updateuser-age" name="age" value="<?php echo $age;?>" required>
						</div>
						<div class="form-group">
							<label class="mr-5">Gender</label>
							<input type="radio" class="updateuser-gender" name="gender" <?php echo $male_checked; ?> value="m" required>
							<label class="mr-3">Male</label>
							<input type="radio" class="updateuser-gender" name="gender" <?php echo $female_checked; ?> value="w" required>
							<label>Female</label>
						</div>
						<br>
						<hr>
						<h4>Contacts</h4><br>
						<div class="form-group">
							<label id="updateuser-text-email">Email</label>
							<input type="hidden" id="updateuser-has-email" name="has-email" value="false">
							<input type="text" class="form-control" id="updateuser-email" name="email" value="<?php echo $email; ?>" required>
							<label id="updateuser-alert-email" class="noshow">---Email is already used.---</label>   
						</div>
						<br>
						<hr>
						<h4>Credentials</h4><br>
						<div class="form-group">
							<input type="hidden" name="oldpassword" value="<?php echo $password; ?>">
							<label id="updateuser-text-password">Password</label>
							<input type="text" class="form-control" id="updateuser-password" name="password" required>
							<label>---Blank, if you don't want to change it.---</label>  
						</div>
						<div class="form-group">
							<label id="updateuser-text-confirmpassword">Confirm Password</label>
							<input type="text" class="form-control" id="updateuser-confirmpassword" name="password" required>
							<label>---Blank, if you don't want to change it.---</label>  
						</div>
						<div class="form-group">
							<label>Position</label>
							<br>	
							<input type="radio" class="ml-5 mr-2" name="position" <?php echo $admin_checked; ?> value="admin" required>
							<label>Adminitrator</label><br>
							<input type="radio" class="ml-5 mr-2" name="position" <?php echo $orga_checked; ?> value="organizer" required>
							<label>Organizer</label><br>
							<input type="radio" class="ml-5 mr-2" name="position" <?php echo $atten_checked; ?> value="attendant" required>
							<label>Attendant</label>
						</div>
						<br><br>
						<hr>
						<div class="text-center">
							<input type="hidden" name="username" value="<?php echo $username; ?>">
							<input type="hidden" name="status" value="update">
							<a class="btn btn-danger" id="updateuser-form-submit" name="updateuser-form-submit">Change</a>
							<label>or</label>
							<a href="./manageuser.php" class="btn btn-info">Cancel</a>
						</div>
					</form>
				</div>
				<div class="col-sm-3"></div>
			</div>
		</div>
		<div class="col-sm-1" style="background-color:lavender;"></div>
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
