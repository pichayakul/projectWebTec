<!DOCTYPE html>
<html>
<head>
	<title>Verify</title>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
</head>
<?php require './header.php';?>
<?php

function active_account($username) {
  $servername = "localhost";
  $serverusername = "root";
  $serverpassword = "";
  $dbname = "epmtfafn_satta";

  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $serverusername, $serverpassword);
  $conn->exec("set names utf8");
  $statement = $conn->prepare('UPDATE account SET status_email=1 WHERE username=:username' );
  $statement->execute([':username' => $username]); //  set username
}

$username = $_GET['username'];
active_account($username);
?>

<body>
  <div class="row content">
    <div class="col-sm-2" style="background-color:lavender;"></div>
    <div class="col-sm-8">
      <div id="verify-content" class="alert-verify text-center">
        <br>
        <label>
          Verified Account.
          <br>
          <br />Now, you can sign in.
          <br />If you are organizer, you can create and join events and seminars.
          <br />But if you are attendant, you can join one only.
          <br />Thank you for join. Have a enjoy with us.
        </label>
        <br><br>
        <a href="./index.php" class="btn btn-primary">Return to HomePage</a><br><br>
      </div>
    </div>
    <div class="col-sm-2" style="background-color:lavender;"></div>
  </div>
</body>
</html>
