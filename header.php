<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<!-- <link href="./css/bootstrap.min.css" rel="stylesheet"> -->
	<link href="./css/theme.css" rel="stylesheet" >
</head>
<body>
<?php

	$is_show_login = "";
	$is_show_profile = "noshow";

	session_save_path('./session/');
	session_start();
	// session_destroy();

	if (isset($_SESSION['username'])) {
		$is_show_login = "noshow";
		$is_show_profile = "";
	}
	if (isset($_POST['login-username'])) {
		$_SESSION['username'] = $_POST['login-username'];
		require './database/add_info_to_session.php';
		$is_show_login = "noshow";
		$is_show_profile = "";
		echo "into login-username";
	}

	if (isset($_POST['status'])) {
		if ($_POST['status'] == "logout") {
			session_destroy();
			$is_show_login = "";
			$is_show_profile = "noshow";
		}
	} 

	if (isset($_POST['status'])) {
		if ($_POST['status'] == "viewprofile") {
			if ($_POST['submit'] == "Save") {
				require './database/epmtfafn_satta_db.php';
				$db = new Database();
				$db->openDatabase();
				$image_path = $_SESSION['image'];
				if (isset($_POST['image']) && $_POST['image'] != "") {
					$image_path = $_POST['image'];
				}
				$db->update_account($_SESSION['username'],$_SESSION['password'],$_POST['nickname'],$_SESSION['position'],
						$_POST['first_name'],$_POST['last_name'],$_POST['email'],$image_path);
				$db->closeDatabase();
				require './database/add_info_to_session.php';
			}
		}
	}

	print_r($_SESSION);
	echo "<br>";
?>
	<div class="row" style="background-color: yellow;">
		<div class="col-sm-3">
			<form id="name-website-form" method="POST" action="./index.php">
				<h3 id="name-website" onclick="document.getElementById('name-website-form').submit();">The Garden</h3>
			</form>
		</div>
		<div class="col-sm-6"></div>
		<div class="col-sm-3">
			<button type="button" id="btn-login" class="btn btn-info btn-lg login <?php echo $is_show_login;?>" data-toggle="modal" data-target="#myModal">Sign in / Sign up</button>
			
			<div class="dropdown">
				<button type="button" id="btn-profile" class="btn btn-primary dropdown-toggle login <?php echo $is_show_profile;?>" data-toggle="dropdown"><?php echo $_SESSION['first_name']." ".$_SESSION['last_name']; ?><span class="caret"></span></button>
			  <div class="dropdown-menu">
			    <a class="dropdown-item" href="./viewprofile.php">View profile</a>
			    <a class="dropdown-item" href="./viewevent.php">View event</a>
			    <a class="dropdown-item <?php if($_SESSION['position']!="admin"){ echo "noshow";} ?>" href="./management.php" >Management</a>
			    <div class="dropdown-divider"></div>
			    <!-- <form id="logout-form" method="POST" action="index.php"> -->
			    	<!-- <input type="hidden" name="status" value="logout"> -->
			    <a class="dropdown-item" id="btn-logout">Log out</a>
			    <!-- </form> -->
			  </div>			
			</div>
		</div>
	</div>
	
	<div id="myModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
					<h4 class="text-center" id="login-header">Sign in</h4>
	        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">x</span></button>
	        
	        <!-- <h4 class="modal-title">Modal Header</h4> -->
	      </div>
	      <div class="modal-body text-center clearfix ml-4 mr-4" id="login-content">
	      	<br>
	      	<form id="login-form" method="post" action="">

	      		<div class="form-group">
	      			<label class="float-left">Username</label>
	      			<input type="text" id="login-username" class="form-control" name="login-username" placeholder="Username">
	      		</div>
	      		<div class="form-group">
	      			<label class="float-left">Password</label>
	      			<input type="password" id="login-password" class="form-control" name="login-password" placeholder="Password">
	      		</div>

	      		<input type="hidden" id="login-status" name="login-status" value="0">
	      		<label id="alert-login" class="noshow">username or password are wrong.</label>
	      		<br>

	      		<a class="btn btn-success" name="submit-login" id="login-form-submit" value="Log in">Log in</a>
	      		<label>or</label>
	      		<a class="btn btn-success" onclick="location.reload();">Cancel</a>
	      	</form>
	      	<br>
	      	<a href="#">Forget Password</a>
	      	<hr>
	      	<p class="text-center">
	      		<a href="#" id="btn-register">Sign up</a>
	      	</p>
	      </div>
	      <div class="modal-body ml-3 mr-3" id="register-content" style="display: none;">
	      	<form id="register-form" method="POST" action="./verify.php" enctype="multipart/form-data">
	      		<div class="form-group">
		      		<label id="text-username">Username</label>
		      		<input type="hidden" id="register-has-username" name="has-username" value="false">
		      		<input type="text" class="form-control" id="register-username" name="username" required>
		      		<label id="alert-username" class="noshow">---Username is already used.---</label>    			
	      		</div>
	      		<div class="form-group">
		      		<label id="text-password">Password</label>
		      		<input type="password" class="form-control" id="register-password" name="password" required>   			
	      		</div>
	      		<div class="form-group">
		      		<label id="text-confirmpassword">Confirm Password</label>
		      		<input type="password" class="form-control" id="register-confirmpassword" name="confirm-password" required>   			
	      		</div>
	      		<div class="form-group">
		      		<label id="text-nickname">Nickname</label>
		      		<input type="text" class="form-control" id="register-nickname" name="nickname" required>      			
	      		</div>
	      		<div class="form-group">
		      		<label id="text-firstname">First name</label>
		      		<input type="text" class="form-control" id="register-firstname" name="firstname" required>      			
	      		</div>
	      		<div class="form-group">
		      		<label id="text-lastname">Last name</label>
		      		<input type="text" class="form-control" id="register-lastname" name="lastname" required>	      			
	      		</div>
	      		<div class="form-group">
		      		<label id="text-email">Email</label>
		      		<input type="hidden" id="register-has-email" name="has-email" value="false">
		      		<input type="text" class="form-control" id="register-email" name="email" required>
		      		<label id="alert-email" class="noshow">---Email is already used.---</label>       	      			
	      		</div>
   					<div class="form-group">
		      		<label id="text-dob">Date of birth</label>
		      		<input type="date" class="form-control" id="register-dob" name="dob" required><br>   						
   					</div>
	      		<div class="form-group">
	      			<label id="text-gender">Gender</label><br>
		      		<input type="radio" class="register-gender" name="gender" value="m" required><label> Male</label>
		      		<input type="radio" class="register-gender" name="gender" value="w"><label> Female</label>			
	      		</div>
	      		<div class="form-group">
	      			<label id="text-avatar">Avatar</label>
		      		<input type="file" id="register-file" class="form-control" name="file" accept="image/*" required data-type='image'> 			
	      		</div>
	      		<div class="form-group">
	      			<label id="text-position">Position</label>
		      		<input type="radio" class="register-position" name="position" value="organizer" required><label> Organizer</label>
		      		<input type="radio" class="register-position" name="position" value="attendant"><label> Attendant</label>			
	      		</div>
	      		<br><br>
	      		<a class="btn btn-primary" id="register-form-submit" name="register-form-submit">Register</a>
	      		<label>or</label>
	      		<a class="btn btn-secondary" onclick="location.reload();">Cancel</a>
	      	</form>
	      </div>
	    </div>

	  </div>
	</div>
	<div id="myModal-verify" class="modal fade" role="dialog">
	  <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
					<h4 class="text-center" id="login-header">Verify</h4>
	        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">x</span></button>
	        
	        <!-- <h4 class="modal-title">Modal Header</h4> -->
	      </div>
	      <div class="modal-body text-center" id="login-content">
	      	<label>Please, check email.</label>
	      </div>
	    </div>

	  </div>
	</div>
	<script src="./js/jquery-3.3.1.min.js"></script>
	<!-- <script src="./js/popper.min.js"></script> -->
	<!-- <script src="./js/bootstrap.min.js"></script> -->
	<!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script>
		$(document).ready(function() {
			console.log('READY');
			$(".dropdown-toggle").dropdown();
			actionClick();
		});

		function actionClick() {
			$('#btn-login').click(function() {
				$('#login-content').css('display', 'block');
				$('#register-content').css('display', 'none');
				$('#submitted-content').css('display', 'none');
				$('#login-header').text('Sign in');
		    $('#register-form, #login-form').find(':input').each(function() {
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
        $('#alert-login').css('display', 'none');
			});
			$('#btn-register').click(function() {
				$('#login-content').css('display', 'none');
				$('#register-content').css('display', 'block');
				$('#login-header').text('Sign up');
			});
			$('#login-form-submit').click(function(e) {
				username = $('#login-username').val();
				password = $('#login-password').val();
				console.log('submit login form');
        $.ajax({
	        url: "./database/check-login.php", //the page containing php script
	        dataType: "json",
	        method: "POST",
	       	data: {username: username, password: password},
	        success: function(response) {
	        	output = response['output'];
	        	if (output == 0) {
	        		$('#alert-login').css('display', 'block');
	        	} else {
	        		$('#myModal').hide();
	        		$('#login-form').submit();
	        	}
		      }
	     	});
			});	     	
			$('#btn-logout').click(function(e) {
        $.ajax({
	        url: "./database/check-logout.php", //the page containing php script
	        dataType: "json",
	        method: "POST",
	       	data: {status: "delete"},
	        success: function(response) {
	        	output = response['status'];
	        	if (output == "Deleted") {
	        		$('#btn-login').css('display', 'block');
	        		$('#btn-profile').css('display', 'none');
	        		location.href="./index.php";
	        	}
		      }
	     	});
			});

			$('#register-form-submit').click(function(e) {
				username = $('#register-username').val();
				hasUsername = $('#register-has-username').val();
				password = $('#register-password').val();
				confirmpassword = $('#register-confirmpassword').val();
				nickname = $('#register-nickname').val();
				firstname = $('#register-firstname').val();
				lastname = $('#register-lastname').val();
				email = $('#register-email').val();
				hasEmail = $('#register-has-email').val();
				dob = $('#register-dob').val();
				gender = $('.register-gender:checked').val();
				file = $('#register-file').val();
				position = $('.register-position:checked').val();

				isWrong = 0;
				href = "";
				if (username.length == 0||username.length > 15||hasUsername == "true")
				{
					$('#text-username').text("*Username");
					if (href == "") {href="#text-username";}
					isWrong = 1;
				} else {
					$('#text-username').text($('#text-username').text().replace("*",""));
				}

				if (password.length == 0||password.length > 15)
				{
					$('#text-password').text("*Password");
					if (href == "") {href="#text-password";}
					isWrong = 1;
				} else {
					$('#text-password').text($('#text-password').text().replace("*",""));
				}

				if (confirmpassword.length == 0||confirmpassword.length > 15||confirmpassword!=password)
				{
					$('#text-confirmpassword').text("*Confirm Password");
					if (href == "") {href="#text-confirmpassword";}
					isWrong = 1;
				} else {
					$('#text-confirmpassword').text($('#text-confirmpassword').text().replace("*",""));
				}

				if (nickname.length == 0||nickname.length > 30)
				{
					$('#text-nickname').text("*Nickname");
					if (href == "") {href="#text-nickname";}
					isWrong = 1;
				} else {
					$('#text-nickname').text($('#text-nickname').text().replace("*",""));
				}

				if (firstname.length == 0||firstname.length > 30)
				{
					$('#text-firstname').text("*First name");
					if (href == "") {href="#text-firstname";}
					isWrong = 1;
				} else {
					$('#text-firstname').text($('#text-firstname').text().replace("*",""));
				}

				if (lastname.length == 0||lastname.length > 30)
				{
					$('#text-lastname').text("*Last name");
					if (href == "") {href="#text-lastname";}
					isWrong = 1;
				} else {
					$('#text-lastname').text($('#text-lastname').text().replace("*",""));
				}

				if (email.length == 0||hasEmail == "true")
				{
					$('#text-email').text("*Email");
					if (href == "") {href="#text-email";}
					isWrong = 1;
				} else {
					hasAdd = false;
					for (var i = 0; i < email.length; i++) {
						c = email.charAt(i);
						if (c == '@') {hasAdd = true;}
					}
					if (hasAdd == false) {
						$('#text-email').text("*Email");
						if (href == "") {href="#text-email";}
						isWrong = 1;				
					} else {
						$('#text-email').text($('#text-email').text().replace("*",""));
					}
				}

				if (dob.length == 0)
				{
					$('#text-dob').text("*Date of birth");
					if (href == "") {href="#text-dob";}
					isWrong = 1;
				} else {
					$('#text-dob').text($('#text-dob').text().replace("*",""));
				}

				if (gender == undefined)
				{
					$('#text-gender').text("*Gender");
					if (href == "") {href="#text-gender";}
					isWrong = 1;
				} else {
					$('#text-gender').text($('#text-gender').text().replace("*",""));
				}

				if (file.length == 0)
				{
					$('#text-avatar').text("*Avatar");
					if (href == "") {href="#text-avatar";}
					isWrong = 1;
				} else {
					$('#text-avatar').text($('#text-avatar').text().replace("*",""));
				}

				if (position == undefined)
				{
					$('#text-position').text("*Position");
					if (href == "") {href="#text-position";}
					isWrong = 1;
				} else {
					$('#text-position').text($('#text-position').text().replace("*",""));
				}

				if (isWrong) {
					location.href = href;
					return false;
				}
				console.log("through condition.");
				document.getElementById('register-form').submit();
			});

			$('#register-username').keyup(function() {
				username = $('#register-username').val();
        $.ajax({
	        url: "./database/check-username.php", //the page containing php script
	        dataType: "json",
	        method: "POST",
	       	data: {username: username},
	        success: function(response) {
	        	status = response['status'];
	        	if (status == "YES") { // YES is no have username
	        		$('#register-has-username').val("false");
	        		$('#alert-username').css('display', 'none');
	        	} else {
	        		$('#register-has-username').val("true");
	        		$('#alert-username').css('display', 'block');
	        	}
		      },
		      error: function (xhr, ajaxOptions, thrownError) {
            console.log(thrownError);
        	}
	     	});
			});

			$('#register-email').keyup(function() {
				email = $('#register-email').val();
        $.ajax({
	        url: "./database/check-email.php", //the page containing php script
	        dataType: "json",
	        method: "POST",
	       	data: {email: email},
	        success: function(response) {
	        	status = response['status'];
	        	if (status == "YES") { // YES is no have username
	        		$('#register-has-email').val("false");
	        		$('#alert-email').css('display', 'none');
	        	} else {
	        		$('#register-has-email').val("true");
	        		$('#alert-email').css('display', 'block');
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