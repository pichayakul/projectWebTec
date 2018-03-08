<!DOCTYPE html>
<html>
<head>
	<title>View Profile</title>
	<meta charset="utf-8">
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
					<form method="POST" action="./manageuser.php">
						<h4>Information</h4><br>
						<div class="form-group">
							<label>First Name</label>
							<input type="text" class="form-control" name="first_name" value="<?php echo $first_name; ?>" required>
						</div>
						<div class="form-group">
							<label>Last Name</label>
							<input type="text" class="form-control" name="last_name" value="<?php echo $last_name; ?>" required>
						</div>
						<div class="form-group">
							<label>Nickname</label>
							<input type="text" class="form-control" name="nickname" value="<?php echo $nickname; ?>" required>
						</div>
						<div class="form-group">
							<label>Age</label>
							<input type="text" class="form-control" name="age" value="<?php echo $age;?>" required>
						</div>
						<div class="form-group">
							<label class="mr-5">Gender</label>
							<input type="radio" name="gender" <?php echo $male_checked; ?> required>
							<label class="mr-3">Male</label>
							<input type="radio" name="gender" <?php echo $female_checked; ?> required>
							<label>Female</label>
						</div>
						<br>
						<hr>
						<h4>Contacts</h4><br>
						<div class="form-group">
							<label>Email</label>
							<input type="text" class="form-control" name="email" value="<?php echo $email; ?>" required>
						</div>
						<br>
						<hr>
						<h4>Credentials</h4><br>
						<div class="form-group">
							<label>Password</label>
							<input type="text" class="form-control" name="password" value="<?php echo $password; ?>" required>
						</div>
						<div class="form-group">
							<label class="">Position</label>
							<br>	
							<input type="radio" class="ml-5 mr-2" name="position" <?php echo $admin_checked; ?> required>
							<label>Adminitrator</label><br>
							<input type="radio" class="ml-5 mr-2" name="position" <?php echo $orga_checked; ?> required>
							<label>Organizer</label><br>
							<input type="radio" class="ml-5 mr-2" name="position" <?php echo $atten_checked; ?> required>
							<label>Attendant</label>
						</div>
						<br><br>
						<hr>
						<div class="text-center">
							<input type="hidden" name="status" value="update">
							<button type="submit" class="btn btn-danger" name="submit">Change</button>
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
</body>
</html>
