<!DOCTYPE html>
<html>
<head>
	<title>View Profile</title>
	<meta charset="utf-8">
</head>
<?php require 'header.php'; ?>
<body>
	<div class="row content">
		<div class="col-sm-1" style="background-color:lavender;"></div>
		<div class="col-sm-10">
			<div class="row">
				<div class="col-sm-12 text-center">
					<br>
					<h2>Profile</h2>
					<hr>
					<br>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-3"></div>
				<div class="col-sm-6 profile">
					<form method="POST" action="index.php">
						<h4>Information</h4><br>
						<div class="form-group">
							<label>First Name</label>
							<input type="text" class="form-control" name="first_name" value="<?php echo $_SESSION['first_name']; ?>" required>
						</div>
						<div class="form-group">
							<label>Last Name</label>
							<input type="text" class="form-control" name="last_name" value="<?php echo $_SESSION['last_name']; ?>" required>
						</div>
						<div class="form-group">
							<label>Nickname</label>
							<input type="text" class="form-control" name="nickname" value="<?php echo $_SESSION['nickname']; ?>" required>
						</div>
						<label>Gender <?php switch ($_SESSION['gender']){case 'm':echo "Male";break; case 'w':echo "Female";break;} ?></label>
						<br>
						<label>Age <?php echo $_SESSION['age']; ?></label>
						<hr>
						<h4>Contacts</h4><br>
						<div class="form-group">
							<label>Email</label>
							<input type="text" class="form-control" name="email" value="<?php echo $_SESSION['email']; ?>" required>
						</div>
						<br>
						<hr>
						<h4>Credentials</h4><br>
						<button class="btn btn-secondary">Change password</button>
						<br><br>
						<hr>
						<div class="text-center">
							<input type="hidden" name="status" value="viewprofile">
							<input type="submit" class="btn btn-danger" name="submit" value="Save">
							<label>or</label>
							<input type="submit" class="btn btn-light" name="submit" value="Cancel">
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
