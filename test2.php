<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/theme.css" rel="stylesheet" >
</head>
<?php

function getUsername($loginusername) {
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "epmtfafn_satta";

	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	$conn->exec("set names utf8");
	// $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$statement = $conn->prepare('SELECT * FROM account WHERE username=:username' );
	$statement->execute([':username' => $loginusername]); //  set username
	$result = $statement->fetchAll(PDO::FETCH_ASSOC)[0]; //  fetch all to Array in Array
	// $conn = null;
	return $result;
}

function encryptPassword($loginusername, $loginpassword) {
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "epmtfafn_satta";

	$encrypt = password_hash($loginpassword, PASSWORD_DEFAULT);

	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	$conn->exec("set names utf8");
	// $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$statement = $conn->prepare('UPDATE account SET password=:password WHERE username=:username' );
	$statement->execute([':username' => $loginusername, ':password' => $encrypt]); //  set username
}

?>
<body>
</body>
</html>