<!DOCTYPE html>
<html>
<head>
	<title>Template</title>
	<meta charset="utf-8">
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/theme.css" rel="stylesheet" >
</head>
<body>
	<div class="header" style="background-color: yellow;">
		<div class="tool">
			<table>
				<tr>
					<td><h3>The Garden</h3></td>
					<!-- <td><button id="login">sign in/sign up</button></td> -->
					<td><button type="button" id="btn-login" class="btn btn-info btn-lg login" data-toggle="modal" data-target="#myModal">Sign in / Sign up</button></td>
				</tr>
			</table>
		</div>
	</div>

	<div class="content" style="background-color: lightblue;">
		<div>
			<label>Please, check your email.</label>
		</div>
	</div>

	<div class="footer" style="background-color: orange;">
		Footer
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
	      	<form>
	      		<input type="text" name="username" placeholder="Username">
	      		<input type="password" name="password" placeholder="Password">
	      		<br><br>
	      		<input type="submit" name="submit-login" value="Log in">
	      	</form>
	      	<a href="#">Forget Password</a>
	      	<hr>
	      	<p class="text-center">
	      		<a href="#" id="btn-register">Sign up</a>
	      	</p>
	      </div>
	      <div class="modal-body" id="register-content" style="display: none;">
	      	<form id="register-form" method="get" action="/verify">
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
	<script src="../js/jquery-3.3.1.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script>
		$(document).ready(function() {
			console.log('READY');

			// $.ajax({
			// 	url: 'question.json',
			// 	method: 'GET',
			// 	dataType: 'json',
			// 	success: function(response) {
			// 		data = response;
			// 		console.log(response);
			// 	} 
			// });
			// actionFirst();
			actionClick();
		});

		function actionClick() {
			$('#btn-login').click(function() {
				$('#login-content').css('display', 'block');
				$('#register-content').css('display', 'none');
				$('#submitted-content').css('display', 'none');
				$('#login-header').text('Sign in');
		    $('#register-form').find(':input').each(function() {
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
			});
			$('#btn-register').click(function() {
				$('#login-content').css('display', 'none');
				$('#register-content').css('display', 'block');
				$('#login-header').text('Sign up');
			});
			$('#register-form').submit(function() {
				// e.preventDefault();
				// let url = e.currentTarget.action;
				// $.post(url, $('#register-form').serialize());

				// $('#register-content').css('display', 'none');
				// $('#submitted-content').css('display', 'block');
			});
		}
	</script>
</body>
</html>
