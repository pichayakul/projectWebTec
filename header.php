<head>
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
	<link href="./css/bootstrap.min.css" rel="stylesheet">
	<link href="./css/theme.css" rel="stylesheet" >
</head>
<body>
<?php
	$is_show = "noshow";
	$is_show_login = "";
	$is_show_profile = "noshow";

	session_save_path('./session');
	session_start();
	// session_destroy();
	if ($_POST['status'] == "logout") {
		session_destroy();
	} else 	if (isset($_SESSION['username'])) {
		$is_show_login = "noshow";
		$is_show_profile = "";
	} else if (isset($_POST['login-username'])) {
		$_SESSION['username'] = $_POST['login-username'];
		require './database/add_info_to_session.php';
		$is_show_login = "noshow";
		$is_show_profile = "";
	}

	if ($_POST['status'] == "viewprofile") {
		if ($_POST['submit'] == "Save") {
			require './database/epmtfafn_satta_db.php';
			$db = new Database();
			$db->openDatabase();
			$image_path = $_SESSION['image'];
			if ($_POST['image'] != "") {
				$image_path = $_POST['image'];
			}
			$db->update_account($_SESSION['username'],$_SESSION['password'],$_POST['nickname'],$_SESSION['position'],
					$_POST['first_name'],$_POST['last_name'],$_POST['email'],$image_path,$_SESSION['qrcode']);
			$db->closeDatabase();
			require './database/add_info_to_session.php';
		}
	}

	print_r($_SESSION);

	if (isset($_POST['submit-register'])) {
		$is_show = "";
	}
?>
	<div class="row" style="background-color: yellow;">
		<div class="col-sm-3">
			<h3 id="name">The Garden</h3>
		</div>
		<div class="col-sm-6"></div>
		<div class="col-sm-3">
			<button type="button" id="btn-login" class="btn btn-info btn-lg login <? echo $is_show_login;?>" data-toggle="modal" data-target="#myModal">Sign in / Sign up</button>
			
			<div class="dropdown">
				<button type="button" id="btn-profile" class="btn btn-primary dropdown-toggle login <? echo $is_show_profile;?>" data-toggle="dropdown"><? echo $_SESSION['first_name']." ".$_SESSION['last_name']; ?><span class="caret"></span></button>
			  <div class="dropdown-menu">
			    <a class="dropdown-item" href="/viewprofile.php">View profile</a>
			    <a class="dropdown-item" href="/viewevent.php">View event</a>
			    <div class="dropdown-divider"></div>
			    <form id="logout-form" method="POST" action="index.php">
			    	<input type="hidden" name="status" value="logout">
			    	<a class="dropdown-item" onclick="document.getElementById('logout-form').submit();">Log out</a>
			    </form>
			  </div>			
			</div>
		</div>
	</div>

	<div class="row content">
		<div class="col-sm-2" style="background-color:lavender;"></div>
		<div class="col-sm-8">
			<div id="verify-content" class="alert-verify text-center <?echo "$is_show";?>">
				<br>
				<label>
					Please, check your email.
					<br />You have to verify account before sign in.
					<br />If have no email please check in junk mail or re-send mail here.
				</label>
				<br><br>
				<button class="btn btn-info">Re-send Email</button>
				<br><br>
			</div>
		</div>
		<div class="col-sm-2" style="background-color:lavender;"></div>
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
	      <div class="modal-body text-center" id="login-content">
	      	<br>
	      	<form id="login-form" method="post" action="index.php">
	      		<input type="text" id="login-username" name="login-username" placeholder="Username">
	      		<input type="password" id="login-password" name="login-password" placeholder="Password">
	      		<input type="hidden" id="login-status" name="login-status" value="0">
	      		<br>
	      		<label id="alert-login" class="noshow">username or password are wrong.</label>
	      		<br>
	      		<input type="submit" name="submit-login" value="Log in">
	      	</form>
	      	<a href="#">Forget Password</a>
	      	<hr>
	      	<p class="text-center">
	      		<a href="#" id="btn-register">Sign up</a>
	      	</p>
	      </div>
	      <div class="modal-body" id="register-content" style="display: none;">
	      	<form id="register-form" method="post" action="">
	      		<div class="form-group">
		      		<label>Username</label>
		      		<input type="text" class="form-control" name="username" required>      			
	      		</div>
	      		<div class="form-group">
		      		<label>Password</label>
		      		<input type="password" class="form-control" name="password" required>   			
	      		</div>
	      		<div class="form-group">
		      		<label>Confirm Password</label>
		      		<input type="password" class="form-control" name="confirm-password" required>   			
	      		</div>
	      		<div class="form-group">
		      		<label>Nickname</label>
		      		<input type="text" class="form-control" name="nickname" required>      			
	      		</div>
	      		<div class="form-group">
		      		<label>First name</label>
		      		<input type="text" class="form-control" name="firstname" required>      			
	      		</div>
	      		<div class="form-group">
		      		<label>Last name</label>
		      		<input type="text" class="form-control" name="lastname" required>	      			
	      		</div>
	      		<div class="form-group">
		      		<label>Email</label>
		      		<input type="text" class="form-control" name="email" required><br>	   	      			
	      		</div>
   					<div class="form-group">
		      		<label>Date of birth</label>
		      		<input type="date" class="form-control" name="date" required><br>   						
   					</div>
	      		<div class="form-group">
		      		<input type="radio" name="gender" required><label> Male</label>
		      		<input type="radio" name="gender"><label> Female</label>			
	      		</div>
	      		<div class="form-group">
	      			<label>Avatar</label>
		      		<input type="file" class="form-control" name="image" required> 			
	      		</div>
	      		<br><br>
	      		<button type="submit" class="btn btn-primary" name="submit-register">Register</button>
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
	<script src="./js/popper.min.js"></script>
	<script src="./js/bootstrap.min.js"></script>
	<!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script> -->
	<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> -->
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
			$('#login-form').submit(function(e) {
				var username = $('#login-username').val();
				var password = $('#login-password').val();
				
        $.ajax({
	        url: "./database/check-login.php", //the page containing php script
	        dataType: "json",
	        method: "POST",
	        cache: false,
	       	data: {username: username, password: password},
	        success: function(response) {
	        	output = response['output'];
	        	if (output == 0) {
	        		$('#alert-login').css('display', 'block');
	        	}
	        	else if (output == 1){
	        		$('#login-status').val("1");
	        	}
		      }
	     	});
				if ($('#login-status').val() == 0) {
					e.preventDefault();
				}
			});
		}
	</script>
</body>