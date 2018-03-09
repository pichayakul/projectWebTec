
<?php
// require_once("../database/epmtfafn_satta_db.php");
// header('Content-Type: application/json');

function hasUsername($loginusername) {
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "epmtfafn_satta";

	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	$conn->exec("set names utf8");
	// $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$statement = $conn->prepare('SELECT * FROM account WHERE username=:username' );
	$statement->execute([':username' => $loginusername]); //  set username
	$result = $statement->fetchAll(PDO::FETCH_ASSOC); //  fetch all to Array in Array
	// $conn = null;
	// return $result;
	if (count($result)==1) { //  Have username in Account table
		return true;
	} else { //  Don't have username in Account table
		return false;
	}
}

function getPassword($loginusername) {
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "epmtfafn_satta";

	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	$conn->exec("set names utf8");
	// $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$statement = $conn->prepare('SELECT * FROM account WHERE username=:username' );
	$statement->execute([':username' => $loginusername]); //  set username
	$result = $statement->fetchAll(PDO::FETCH_ASSOC); //  fetch all to Array in Array
	$conn = null;
	if (count($result)==1) { //  Have username in Account table
		return $result[0]['password']; //  return password
	} else { //  Don't have username in Account table
		return null;
	}
}

$username = $_POST['username'];
$password = $_POST['password'];
$output = 0;
$arroutput = array();
$arroutput['output'] = $output;
if (hasUsername($username)) {
	$encrypt = getPassword($username);
	if (password_verify($password, $encrypt)) {
		$output = 1;
	}
}

$arroutput['output'] = $output;
// print_r($output);
echo json_encode($arroutput);
?>