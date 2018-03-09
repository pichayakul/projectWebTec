<!DOCTYPE html>
<html>
<head>
	<title>Verify</title>
	<meta charset="utf-8">
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
