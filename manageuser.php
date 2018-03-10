<!DOCTYPE html>
<html>
<head>
	<title>Manage User</title>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
</head>
<?php require 'header.php'; ?>
<?php
	$is_show_next = "";
	$is_show_previous = "";
	$next_page = 0;
	$previous_page = 0;
	$str_table = "";
	function pageToString($number, $arr) {
		$capacity = 5;
		$begin = 1;
		$max = ($number*$capacity); 
		if ($number > 1) {
			$begin = (($number-1)*$capacity)+1;
		}

		if ((count($arr) - $begin) < $capacity) {
			$GLOBALS['is_show_next'] = "noshow";
		} else {
			$GLOBALS['next_page'] = $number+1;
		}
		if ($number == 1) {
			$GLOBALS['is_show_previous'] = "noshow";
		} else {
			$GLOBALS['previous_page'] = $number-1;
		}

		$str = '<table class="table table-bordered table-striped table-sm"><thead><th>#</th><th>Username</th><th>Update</th><th>Ban</th></thead><tbody>';
		for ($i=$begin; $i <= $max && $i <= count($arr); $i++) {
			$username = $arr[$i-1]['username'];
			$position = $arr[$i-1]['position'];
			$str .= '<tr>';
			$str .= '<td>'.$i.'</td>';
			$str .= '<td>'.$username.'</td>';
			$str .= '<td><form method="POST" action="./updateuser.php">';
			$str .= '<input type="hidden" name="username" value="'.$username.'">';
			$str .= '<input type="hidden" name="status" value="update">';
			$str .= '<button type="submit" name="submit">Update</button>';
			$str .= '</form></td>';
			$str .= '<td><form method="POST" action="" onsubmit="return confirm(\'Do you want ban username: `'.$username.'` from website?\')">';
			$str .= '<input type="hidden" name="username" value="'.$username.'">';
			$str .= '<input type="hidden" name="position" value="'.$position.'">';
			$str .= '<input type="hidden" name="status" value="ban">';
			$str .= '<button type="submit" name="submit">Ban</button>';
			$str .= '</form></td>';
			$str .= '</tr>';
		}
		$str .= "</tbody></table>";
		return $str;
	}

	require './database/epmtfafn_satta_db.php';
	$db = new Database();
	$db->openDatabase();
	$arr = $db->get_account_all();
	if (isset($_POST['status'])) {
		if (!strcmp($_POST['status'], "ban")) {
			if ($_POST['position'] == "admin") {
				$count_admin = $db->check_admin_account();
				if ($count_admin > 1) {
					$db->ban_account($_POST['username']);
				} else {
					echo "<script type='text/javascript'>alert('Can not ban account admin which have 1 account');</script>";
				}
			} else {
				$db->ban_account($_POST['username']);
			}
			// $db->ban_account($_POST['username']);
		} else if (!strcmp($_POST['status'], "update")) {
			$first_name = $_POST['first_name'];
			$last_name = $_POST['last_name'];
			$nickname = $_POST['nickname'];
			$age = $_POST['age'];
			$gender = $_POST['gender'];
			$position = $_POST['position'];
			$email = $_POST['email'];
			$username = $_POST['username'];
			$oldpassword = $_POST['oldpassword'];
			$password = $_POST['password'];
			if ($password == "") {
				$encrypt = $oldpassword;
			} else {
				$encrypt = password_hash($password, PASSWORD_DEFAULT);
			}
			$db->update_account_keyword($username, "first_name", $first_name);
			$db->update_account_keyword($username, "last_name", $last_name);
			$db->update_account_keyword($username, "nickname", $nickname);
			$db->update_account_keyword($username, "age", $age);
			$db->update_account_keyword($username, "gender", $gender);
			$db->update_account_keyword($username, "position", $position);
			$db->update_account_keyword($username, "email", $email);
			$db->update_account_keyword($username, "password", $encrypt);
		}
	}
	if (isset($_POST['next_page'])) {
		$str_table = pageToString($_POST['next_page'], $arr);
	} else {
		$str_table = pageToString(1, $arr);
	}
	$db->closeDatabase();
	$str_search = "";
	if (isset($_POST['search-username'])) {
		for ($i=0; $i < count($arr); $i++) {
			if (!strcmp($_POST['username'], $arr[$i]['username'])) {
				$str = '<h5>Result</h5><table class="table table-bordered table-sm"><thead><th>#</th><th>Username</th><th>Update</th><th>Ban</th></thead><tbody>';

				$username = $arr[$i]['username'];
				$question = 'Do you want ban '.$username.' from website?';
				$str .= '<tr>';
				$str .= '<td>'.($i+1).'</td>';
				$str .= '<td>'.$username.'</td>';
				$str .= '<td><form method="POST" action="./updateuser.php">';
				$str .= '<input type="hidden" name="username" value="'.$username.'">';
				$str .= '<input type="hidden" name="status" value="update">';
				$str .= '<button type="submit" name="submit">Update</button>';
				$str .= '</form></td>';
				$str .= '<td><form method="POST" action="" onsubmit="return confirm(\'Do you want ban username: `'.$username.'` from website?\')">';
				$str .= '<input type="hidden" name="username" value="'.$username.'">';
				$str .= '<input type="hidden" name="status" value="ban">';
				$str .= '<button type="submit" name="submit">Ban</button>';
				$str .= '</form></td>';
				$str .= '</tr>';
				$str .= "</tbody></table>";
				$str_search = $str;
				break;
			} else {
				$str_search = "<label>Result: username not found, please try again.</label>";
			}
		}
	}
?>
<body>
	<div class="row content">
		<div class="col-sm-2" style="background-color:lavender;"></div>
		<div class="col-sm-8">
			<div class="row">
				<div class="col-sm-12 clearfix">
					<br>
					<a class="btn btn-primary btn-sm float-left" href="./management.php">< Back</a>
					<br>
					<hr>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 text-center">

					<h2>Management Users</h2>
					<br>
					<hr>
					<br>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-3"></div>
				<div class="col-sm-6 text-center">
					<form id="search-user-form" class="form-inline" method="POST" action="">
				    <div class="form-group">
				      <label for="username">Username: </label>
				      <input type="text" class="form-control" placeholder="Enter Username" name="username" require>
				      <input type="hidden" name="search-username" value="1">
				      <input type="submit" name="submit" value="Search">
				    </div>
					</form>
					<br><br>
				</div>
				<div class="col-sm-3"></div>
			</div>
			<div class="row">
				<div class="col-sm-2"></div>
				<div class="col-sm-8">
					<?php echo $str_search;?>
					<br>
					<hr>
					<br>
				</div>
				<div class="col-sm-2"></div>
			</div>
			<div class="row">
				<div class="col-sm-2 h-25 mt-auto mb-auto">
					<form id="previous-page-form" method="POST" >
						<input type="hidden" name="next_page" value="<?php echo $previous_page;?>">
						<a class="btn btn-primary btn-sm float-right <?php echo $is_show_previous;?>" onclick="document.getElementById('previous-page-form').submit();">Previous</a>
					</form>
				</div>
				<div class="col-sm-8">
					<h5>All username (5 users per page)</h5>
					<?php  echo $str_table;?>
				</div>
				<div class="col-sm-2 h-25 mt-auto mb-auto">
					<form id="next-page-form" method="POST">
						<input type="hidden" name="next_page" value="<?php echo $next_page;?>">
						<a class="btn btn-primary btn-sm <?php echo $is_show_next;?>" onclick="document.getElementById('next-page-form').submit();">Next</a>
					</form>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 clearfix">
					<br>
					<br>
					<hr>
				</div>
			</div>
		</div>
		<div class="col-sm-2" style="background-color:lavender;"></div>
	</div>
</body>
</html>