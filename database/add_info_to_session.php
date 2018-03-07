<?php
function getUsername($loginusername) {
	$servername = "localhost";
	$username = "epmtfafn_satta";
	$password = "satta123";
	$dbname = "epmtfafn_satta";

	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	$conn->exec("set names utf8");
	// $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$statement = $conn->prepare('SELECT * FROM account WHERE username=:username' );
	$statement->execute([':username' => $loginusername]); //  set username
	$result = $statement->fetchAll(PDO::FETCH_ASSOC)[0]; //  fetch all to Array in Array
	$arr = array();
	foreach ($result as $key => $value) {
		switch ($key) {
			case 'password':
				$arr['password'] = $value;
				break;
			case 'nickname':
				$arr['nickname'] = $value;
				break;
			case 'position':
				$arr['position'] = $value;
				break;
			case 'first_name':
				$arr['first_name'] = $value;
				break;
			case 'last_name':
				$arr['last_name'] = $value;
				break;
			case 'gender':
				$arr['gender'] = $value;
				break;
			case 'age':
				$arr['age'] = $value;
				break;
			case 'email':
				$arr['email'] = $value;
				break;
			case 'image':
				$arr['image'] = $value;
				break;
			case 'start_date_time':
				$arr['start_date_time'] = $value;
				break;
			case 'last_login_date_time':
				$arr['last_login_date_time'] = $value;
				break;
			case 'status_email':
				$arr['status_email'] = $value;
				break;
			case 'qrcode':
				$arr['qrcode'] = $value;
				break;
		}
	}
	return $arr;
}

foreach (getUsername($_SESSION['username']) as $key => $value) {
	$_SESSION[$key] = $value;
}

?>