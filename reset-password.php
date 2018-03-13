<!DOCTYPE html>
<html>
<head>
	<title>Reset Password</title>
</head>
<?php require './header.php'; ?>
<?php

$is_show_reset_form = "";
if (isset($_GET['status'])) {
	if ($_GET['status'] == "resetpassword") {
		$encrypt = password_hash($_GET['password'], PASSWORD_DEFAULT);
		$username = $_GET['username'];
		require './database/epmtfafn_satta_db.php';
		$db = new Database();
		$db->openDatabase();
		$db->change_password($username, $encrypt);
		$db->closeDatabase();
		$is_show_reset_form = "noshow";
	}
} else {
	// $username = $_GET['username'];
}

?>
<body>
  <div class="row content">
    <div class="col-sm-2" style="background-color:lavender;"></div>
    <div class="col-sm-8">
      <div id="reset-content" class="alert-verify text-center <?php echo $is_show_reset_form;?>">
					<form id="reset-form" method="GET">
						<h4>Credentials</h4><br>
	      		<div class="form-group">
		      		<label id="reset-text-password">New Password</label>
		      		<input type="password" class="form-control" id="reset-password" name="password" required>
	      		</div>
	      		<div class="form-group">
		      		<label id="reset-text-confirmpassword">New Confirm Password</label>
		      		<input type="password" class="form-control" id="reset-confirmpassword" name="confirm-password" required>
	      		</div>
						<br><br>
						<hr>
						<div class="text-center">
							<input type="hidden" name="username" value="<?php echo $_GET['check-username']; ?>">
							<input type="hidden" name="status" value="resetpassword">
							<a id="reset-form-submit" class="btn btn-danger">Change</a>
							<label>or</label>
							<a class="btn btn-light" href="./index.php">Cancel</a>
							<br><br><br><br>
						</div>
					</form>
      </div>
      <div id="reset-alert-content" class="text-center">
      	<br><br>
      	<label>Changed password complete.</label><br>
      	<label>Please return to home page with button below.</label>
      	<br><br>
      	<a class="btn btn-light" href="./index.php">Return to Home Page</a>
      	<br><br>
      </div>
    </div>
    <div class="col-sm-2" style="background-color:lavender;"></div>
  </div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script>
		$(document).ready(function() {
			console.log('READY');
			$(".dropdown-toggle").dropdown();
			actionClick();
		});

		function actionClick() {
			$('#reset-form-submit').click(function(e) {
				password = $('#reset-password').val();
				confirmpassword = $('#reset-confirmpassword').val();

				isWrong = 0;
				href = "";

				if (password.length == 0||password.length > 15)
				{
					$('#reset-text-password').text("*Password");
					if (href == "") {href="#reset-text-password";}
					isWrong = 1;
				} else {
					$('#reset-text-password').text($('#reset-text-password').text().replace("*",""));
				}

				if (confirmpassword.length == 0||confirmpassword.length > 15||confirmpassword!=password)
				{
					$('#reset-text-confirmpassword').text("*Confirm Password");
					if (href == "") {href="#reset-text-confirmpassword";}
					isWrong = 1;
				} else {
					$('#reset-text-confirmpassword').text($('#reset-text-confirmpassword').text().replace("*",""));
				}

				if (isWrong) {
					location.href = href;
					return false;
				}
				document.getElementById('reset-form').submit();
			});
		}

		function resetForm() {
	    $('#register-form, #login-form, #forget-form').find(':input').each(function() {
        switch(this.type) {
            case 'password':
            case 'select-multiple':
            case 'select-one':
            case 'text':
            case 'textarea':
                $(this).val('');
                break;
            case 'checkbox':
            case 'radio':
                this.checked = false;
        }
      });
		}
	</script>
</body>
</html>
