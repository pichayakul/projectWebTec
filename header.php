<head>
	<meta charset="utf-8">
	<!-- <link href="./css/bootstrap.min.css" rel="stylesheet"> -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link href="./css/theme.css" rel="stylesheet" >
	<link href="https://fonts.googleapis.com/css?family=Libre+Baskerville|Mitr|Nanum+Gothic|Noto+Serif|Ubuntu" rel="stylesheet">
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
			$db = new Database();
			$db->openDatabase();
			$image_path = $_SESSION['image'];
			if (isset($_POST['image']) && $_POST['image'] != "") {
				$image_path = $_POST['image'];
			}
			if ($_POST['password'] == "") {
				$encrypt = $_SESSION['password'];
			} else {
				$encrypt = password_hash($_POST['password'], PASSWORD_DEFAULT);
			}
			$db->update_account($_SESSION['username'],$encrypt,$_POST['nickname'],$_SESSION['position'],
					$_POST['first_name'],$_POST['last_name'],$_POST['email'],$image_path);
			$db->closeDatabase();
			require './database/add_info_to_session.php';
		}
	}

	// print_r($_SESSION);
	// echo "<br>";
?>
	<div class="navbar navbar-default" style="background-color: white; box-shadow:0 0 10px;">
		<div class="container-fluid">
		<div class="col-sm-2 navbar-header">
			<form id="name-website-form" method="POST" action="./home.php" style="">
				<a  id="name-website"  href="index.php" onclick="document.getElementById('name-website-form').submit(); " class="navbar-brand" style="font-size:24px;">The Garden</a>
			</form>
		</div>


			<form action="./viewAll.php" class="navbar-form navbar-left" method="post" style="margin-left:-65px;" >
				<div class="input-group">
					<input type="hidden" value="search" name="type">
					<input type="text" class="form-control" placeholder="Search Events / Seminars " name="search">
					<div class="input-group-btn">
						<button class="btn btn-default"  type="submit"><i class="glyphicon glyphicon-search"></i></button>
					</div>
				</div>
			</form>



		<!-- <div class="col-sm-2"> -->
			<ul class="nav navbar-nav navbar-right" >

			<a type="button" id="btn-login" class="btn btn-link  <?php echo $is_show_login; ?>" data-toggle="modal" data-target="#login-myModal" style="font-size:18px; margin-top:5px; text-decoration: none;"><span class="glyphicon glyphicon-log-in"></span><label style="margin-left:15px;">Sign in/Sign up</label></a>
			<div class="dropdown">
				<button type="button" id="btn-profile" class="btn  btn-md dropdown-toggle  <?php echo $is_show_profile;?>" data-toggle="dropdown" style="margin-top:8px;" ><span class="glyphicon glyphicon-th-list"></span><lebel style="margin-left:15px;"><?php echo $_SESSION['first_name']." ".$_SESSION['last_name']; ?></label><span class="caret"></span></button>
			  <ul class="dropdown-menu">
			    <li><a href="./viewprofile.php">View profile</a></li>
			    <li><a href="./viewevent.php">View event</a></li>
			    <li class="<?php if($_SESSION['position']!="admin"){ echo "noshow";} ?>"><a href="./management.php">Management</a></li>
			    <li><div class="dropdown-divider"></div></li>
			    <!-- <form id="logout-form" method="POST" action="index.php"> -->
			    	<!-- <input type="hidden" name="status" value="logout"> -->
			    <li><a class="" id="btn-logout">Log out</a></li>
			    <!-- </form> -->
			  </ul>
			</div>
		</ul>
	</div>
		<!-- </div> -->
	</div>

	<div id="login-myModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content" style="width: 70%;">
	      <div class="modal-header">
					<button type="button" class="close btn-lg" data-dismiss="modal"><span aria-hidden="true">X</span></button>
					<center><image src = "./picture/SATTAGA.jpg" alt ="satta-logo"  style="width:40%"></center>


	        <!-- <h4 class="modal-title">Modal Header</h4> -->
	      </div>
	      <div class="modal-body " id="login-content">
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
	      		<input type="hidden" id="check-enter-login" name="check-enter-login" value="false">
	      		<input type="hidden" id="login-status" name="login-status"  value="0">
	      		<label id="alert-login" class="noshow" style="color:red;">username or password are wrong.</label>
	      		<br>
	      		<a class="btn btn-primary form-control btn-lg" name="submit-login" id="login-form-submit" value="Log in" style="height:auto;">Log in</a>
						<br>
						<br>
						<a href="#" id="btn-register" class="btn btn-success form-control btn-lg" style="height:auto;">Sign up</a>
	      		<!-- <label>or</label>
	      		<a class="btn btn-success" onclick="location.reload();">Cancel</a> -->
	      	</form>
	      	<br>
	      	<a href="#" id="btn-forget" class="text-center" style="float:right;">Forget Password</a>
	      	<hr>
	      	<br>

	      </div>
	      <div class="modal-body  clearfix ml-4 mr-4 noshow" id="forget-content">
	      	<br>
	      	<form id="forget-form" method="post" action="./forget-password.php">
						<div class="form-group">
							<label>Username</label>
							<input type="text" name="username" class="form-control" required>
						</div>
	      		<div class="form-group">
	      			<label class="float-left" id="forget-text-email">Email</label>
	      			<input type="hidden" id="forget-has-email" name="has-email" value="false">
	      			<input type="text" id="forget-email" class="form-control" name="forget-email" placeholder="Enter email">
	      		</div>
	      		<label id="alert-login" class="noshow" style="color:red;">username or password are wrong.</label>
	      		<br>
						<a class="btn btn-success" name="submit-forget" id="forget-form-submit" value="Enter">Enter</a>
	      		<a class="btn btn-danger" id="forget-form-cancel" style="margin-left:10px;">Cancel</a>
	      	</form>
	      </div>
	      <div class="modal-body ml-3 mr-3 noshow" id="register-content">
	      	<form id="register-form" method="POST" action="./verify.php" enctype="multipart/form-data">
	      		<div class="form-group">
		      		<label id="text-username">Username</label>
		      		<input type="hidden" id="register-has-username" name="has-username" value="false">
		      		<input type="text" class="form-control" id="register-username" name="username" required>
		      		<label id="alert-username" class="noshow" style="color:red;">---Username is already used.---</label>
		      		<span class="help-block">max character is 15.</span>
	      		</div>
	      		<div class="form-group">
		      		<label id="text-password">Password</label>
		      		<input type="password" class="form-control" id="register-password" name="password" required>
		      		<span class="help-block">max character is 15.</span>
	      		</div>
	      		<div class="form-group">
		      		<label id="text-confirmpassword">Confirm Password</label>
		      		<input type="password" class="form-control" id="register-confirmpassword" name="confirm-password" required>
	      		</div>
	      		<div class="form-group">
		      		<label id="text-nickname">Nickname</label>
		      		<input type="text" class="form-control" id="register-nickname" name="nickname" required>
		      		<span class="help-block">max character is 30.</span>
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
		      		<label id="alert-email" class="noshow" style="color:red;">---Email is already used.---</label>
	      		</div>
   					<div class="form-group">
		      		<label id="text-dob">Date of birth</label>
		      		<input type="date" class="form-control" id="register-dob" name="dob" required><br>
   					</div>
	      		<div class="form-group">
	      			<label id="text-gender">Gender</label><br>
		      		<input type="radio" class="register-gender" name="gender" value="m" style="margin-right: 2%;" required><label style="margin-right: 5%;"> Male</label>
		      		<input type="radio" class="register-gender" name="gender" value="w" style="margin-right: 2%;"><label> Female</label>
	      		</div>
	      		<div class="form-group">
	      			<label id="text-avatar">Avatar</label>
		      		<input type="file" id="register-file" class="form-control" name="file" accept="image/*" required data-type='image'>
	      		</div>
	      		<div class="form-group">
	      			<label id="text-position">Position</label><br>
		      		<input type="radio" class="register-position" name="position" value="organizer" style="margin-right: 2%;" required><label style="margin-right: 5%;"> Organizer</label>
		      		<input type="radio" class="register-position" name="position" value="attendant" style="margin-right: 2%;"><label> Attendant</label>
		      		<span class="help-block">Organizer can create activities. And attendant for join activities.</span>
	      		</div>
	      		<br>
	      		<a class="btn btn-primary" id="register-form-submit" name="register-form-submit">Register</a>

	      		<a class="btn btn-danger" id="register-form-cancel" style="margin-left:15px;">Cancel</a>
	      	</form>
	      </div>
	    </div>

	  </div>
	</div>
	<!-- <script src="./js/jquery-3.3.1.min.js"></script> -->
	<!-- <script src="./js/popper.min.js"></script> -->
	<!-- <script src="./js/bootstrap.min.js"></script> -->
	<!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script> -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> -->
	<script>
		$(document).ready(function() {
			console.log('READY');
	    $(document).keyup( function(e) {
        if (e.keyCode == 13 && $('#check-enter-login').val() == "true"){
        	$("#login-form-submit").trigger('click');
        	// console.log('entered');
        }
    	});
			$(".dropdown-toggle").dropdown();
			actionClick();
		});

		function actionClick() {
			$('#btn-login').click(function() {
				$('#login-content').css('display', 'block');
				$('#check-enter-login').val("true");
				$('#register-content').css('display', 'none');
				$('#forget-content').css('display', 'none');
				$('#submitted-content').css('display', 'none');
				$('#login-header').text('Sign in');
				resetForm();
        $('#alert-login').css('display', 'none');
			});

			$('#btn-register').click(function() {
				$('#login-content').css('display', 'none');
				$('#check-enter-login').val("false");
				$('#register-content').css('display', 'block');
				$('#login-header').text('Sign up');
			});

			$('#btn-forget').click(function() {
				$('#login-content').css('display', 'none');
				$('#check-enter-login').val("false");
				$('#forget-content').css('display', 'block');
				$('#login-header').text('Forget Password');
			});

			$('#forget-form-cancel').click(function() {
				$('#login-content').css('display', 'block');
				$('#check-enter-login').val("true");
				$('#alert-login').css('display', 'none');
				$('#forget-content').css('display', 'none');
				$('#login-header').text('Sign in');
				resetForm();
			});

			$('#register-form-cancel').click(function() {
				$('#login-content').css('display', 'block');
				$('#check-enter-login').val("true");
				$('#alert-login').css('display', 'none');
				$('#register-content').css('display', 'none');
				$('#login-header').text('Sign in');
				resetForm();
			});

			$('#login-form-submit').click(function(e) {
				username = $('#login-username').val();
				password = $('#login-password').val();
        $.ajax({
	        url: "./database/check-login.php", //the page containing php script
	        dataType: "json",
	        method: "POST",
	       	data: {username: username, password: password},
	        success: function(response) {
	        	output = response['output'];
	        	if (output == 0) {
	        		$('#alert-login').text("Username or password are wrong, or not verify.");
	        		$('#alert-login').css('display', 'block');
	        	} else if (output == 2) {
	        		$('#alert-login').text("Account was banned.");
	        		$('#alert-login').css('display', 'block');
	        	} else {
	        		$('#login-myModal').hide();
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

			$('#forget-email').keyup(function() {
				email = $('#forget-email').val();
        $.ajax({
	        url: "./database/check-email.php", //the page containing php script
	        dataType: "json",
	        method: "POST",
	       	data: {email: email},
	        success: function(response) {
	        	status = response['status'];
	        	if (status == "YES") { // YES is no have username
	        		$('#forget-has-email').val("false");
	        	} else {
	        		$('#forget-has-email').val("true");
	        	}
		      },
		      error: function (xhr, ajaxOptions, thrownError) {
            console.log(thrownError);
        	}
	     	});
			});

			$('#forget-form-submit').click(function() {
				email = $('#forget-email').val();
				hasEmail = $('#forget-has-email').val();

				isWrong = 0;
				href = "";
				if (email.length == 0)
				{
					$('#forget-text-email').text("*Email");
					if (href == "") {href="#forget-text-email";}
					isWrong = 1;
				} else {
					hasAdd = false;
					for (var i = 0; i < email.length; i++) {
						c = email.charAt(i);
						if (c == '@') {hasAdd = true;}
					}
					if (hasAdd == false) {
						$('#forget-text-email').text("*Email");
						if (href == "") {href="#forget-text-email";}
						isWrong = 1;
					} else {
						$('#forget-text-email').text($('#forget-text-email').text().replace("*",""));
					}
				}
				if (isWrong) {
					location.href = href;
					return false;
				}
        // $.post("./forget-password.php",
				// {
	      //  	email: email
				// }, function(response) {
				// 		console.log('INTO');
				// });
				document.getElementById('forget-form').submit();
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
