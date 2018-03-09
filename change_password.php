<!DOCTYPE html>
<html>
<head>
	<title>Change Password</title>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
</head>
<? require 'header.php'; ?>
<body>
	<div class="row content">
		<div class="col-sm-1" style="background-color:lavender;"></div>
		<div class="col-sm-10">
			<div class="row">
				<div class="col-sm-12 text-center">
					<br>
					<h2>Change Password</h2>
					<hr>
					<br>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-3"></div>
				<div class="col-sm-6 profile">
					<form method="POST" action="index.php">
						<h4>Credentials</h4><br>
						<div class="form-group">
							<label>New Password</label>
							<input type="text" class="form-control" value="">
							<span>leave it blank if you don't want to change it.</span>
						</div>
						<div class="form-group">
							<label>New Password Confirmation</label>
							<input type="text" class="form-control" value="">
						</div>
						<div class="form-group">
							<label>Current Password</label>
							<input type="text" class="form-control" value="">
							<span>leave it blank if you don't want to change it.</span>
						</div>
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
