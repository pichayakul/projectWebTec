<!DOCTYPE html>
<html>
<head>
	<title>Verify</title>
	<meta charset="utf-8">
</head>
<?php require './header.php';?>
<?php
date_default_timezone_set('Asia/Bangkok');
$username = $_POST['username'];
$password = $_POST['password'];
$nickname = $_POST['nickname'];
$position = $_POST['position'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$gender = $_POST['gender'];
$email = $_POST['email'];

$now = new DateTime();
$start_date_time = $now->format('Y-m-d H:i:s');
// print_r($start_date_time);
$dob = new DateTime($_POST['dob']);
$interval = date_diff($dob, $now);
$age = (int) $interval->format("%y");

$file_name = explode(".", $_FILES["file"]["name"])[0];
$type_file = explode(".", $_FILES["file"]["name"])[1];
$image = $now->format('Y-m-d\TH:i:s')."-".$file_name.".".$type_file;
$image_path = "./images/avatar/".$_FILES["file"]["name"];

function create_account($username,$password,$nickname,$position,$first_name,$last_name,$gender,$age,$email,$image,$start_date_time) {
  $servername = "localhost";
  $serverusername = "root";
  $serverpassword = "";
  $dbname = "epmtfafn_satta";

  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $serverusername, $serverpassword);
  $conn->exec("set names utf8");
  $statement = $conn->prepare('INSERT INTO account (username,password,nickname,position,first_name,last_name,gender,age,email,image,start_date_time,status_email,status_ban) VALUES (:username,:password,:nickname,:position,:first_name,:last_name,:gender,:age,:email,:image,:start_date_time,0,0);' );
  $statement->execute([':username' => $username,
                      ':password' => $password,
                      ':nickname' => $nickname,
                      ':position' => $position,
                      ':first_name' => $first_name,
                      ':last_name' => $last_name,
                      ':gender' => $gender,
                      ':age' => $age,
                      ':email' => $email,
                      ':image' => $image,
                      ':start_date_time' => $start_date_time]); //  set username
}


if (move_uploaded_file($_FILES["file"]["tmp_name"], "./images/avatar/".$_FILES["file"]["name"]))
{
  // rename("./images/avatar/".$_FILES["file"]["name"], "./images/avatar/".$image);
  create_account($username,$password,$nickname,$position,$firstname,$lastname,$gender,$age,$email,$image_path,$start_date_time);
  $msg = "Please, click link below for verify your account.<br>After verified account, you can sign in and enjoy it.<br><br>";
  $msg = wordwrap($msg,70);
  $msg .= '<a href="http://localhost/projectWebTec/active-account.php?username='.$username.'&">Click Verify Here.</a><br><br>';
  $msg .= 'Thank you for join to us.<br>We hope you enjoy the activities and seminars.<br><br>';
  $msg .= 'Admin M.Suphawich';
  $strHeader = "From: suphawichtsd@gmail.com";

  require_once('./PHPMailer_v5.0.2/class.phpmailer.php');
  $mail = new PHPMailer();
  $mail->IsHTML(true);
  $mail->IsSMTP();
  $mail->SMTPAuth = true; // enable SMTP authentication
  $mail->SMTPSecure = "ssl"; // sets the prefix to the servier
  $mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server
  $mail->Port = 465; // set the SMTP port for the GMAIL server
  $mail->Username = "suphawichct@gmail.com"; // GMAIL username
  $mail->Password = "Mm123456"; // GMAIL password
  $mail->From = "admin@sattagarden.com"; // "name@yourdomain.com";
  //$mail->AddReplyTo = "support@thaicreate.com"; // Reply
  $mail->FromName = "Mr. Suphawich";  // set from Name
  $mail->Subject = "Satta Garden - Verify you account";
  $mail->Body = $msg;
  $mail->AddAddress($email, $firstname." ".$lastname); // to Address
  // $mail->AddAttachment("thaicreate/myfile.zip");
  // $mail->AddAttachment("thaicreate/myfile2.zip");
  //$mail->AddCC("member@thaicreate.com", "Mr.Member ShotDev"); //CC
  //$mail->AddBCC("member@thaicreate.com", "Mr.Member ShotDev"); //CC
  $mail->set('X-Priority', '1'); //Priority 1 = High, 3 = Normal, 5 = low
  $mail->Send();
}


// if (!$db->hasUsername($username)) {
//   print_r("1. false");
// }
// echo "<br>";
// if (!$db->hasEmail($email)) {
//   print_r("2. false");
// }
// $db->closeDatabase();
// echo "<br> Closed";

?>

<body>
  <div class="row content">
    <div class="col-sm-2" style="background-color:lavender;"></div>
    <div class="col-sm-8">
      <div id="verify-content" class="alert-verify text-center">
        <br>
        <label>
          Registration Successfully.
          <br>
          <br />Please, check your email.
          <br />You have to verify account before sign in.
          <br />If have no email please check in junk mail or re-send mail here.
        </label>
        <br><br>
        <button class="btn btn-info" onclick="location.reload();">Re-send Email</button>
        <br><br>
        <label>Thank you for registration. Have a enjoy with us.</label>
      </div>
    </div>
    <div class="col-sm-2" style="background-color:lavender;"></div>
  </div>
</body>
</html>
