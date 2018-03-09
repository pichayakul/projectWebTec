<?php
// header('Content-Type: application/json');

function hasEmail($email) {
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "epmtfafn_satta";

	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	$conn->exec("set names utf8");
	// $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$statement = $conn->prepare('SELECT * FROM account WHERE email=:email' );
	$statement->execute([':email' => $email]); //  set username
	$result = $statement->fetchAll(PDO::FETCH_ASSOC); //  fetch all to Array in Array
	// $conn = null;
	// return $result;
	if (count($result)==1) { //  Have username in Account table
		return true;
	} else { //  Don't have username in Account table
		return false;
	}
}


$email = $_POST['email'];

$arr = array();
$x = hasEmail($email);
if (!$x) {
	$arr['status'] = "YES";
} else {
	$arr['status'] = "NO";
}
echo json_encode($arr);
?>