<?php

$e = $_POST['forget-email'];
$u = $_POST['username'];
$msg = "Please, click link below for reset password.<br>After reset account, you can sign in and enjoy it.<br><br>";
$msg = wordwrap($msg,70);
$msg .= '<a href="http://localhost/testlast/reset-password.php?check-username='.$u.'&">Reset Password Here.</a><br><br>';
$msg .= 'Thank you for support to us.<br>We hope you enjoy the activities and seminars.<br><br>';
$msg .= 'Admin M.Suphawich';
$strHeader = "From: suphawichtsd@gmail.com";

require './PHPMailer_v5.0.2/class.phpmailer.php';
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
$mail->Subject = "Satta Garden - Reset Password";
$mail->Body = $msg;
$mail->AddAddress($e); // to Address
// $mail->AddAttachment("thaicreate/myfile.zip");
// $mail->AddAttachment("thaicreate/myfile2.zip");
//$mail->AddCC("member@thaicreate.com", "Mr.Member ShotDev"); //CC
//$mail->AddBCC("member@thaicreate.com", "Mr.Member ShotDev"); //CC
$mail->set('X-Priority', '1'); //Priority 1 = High, 3 = Normal, 5 = low
$mail->Send();
// echo json_encode("SENDED");
include './header.php';
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <div class="row content">
      <div class="col-sm-2" ></div>
      <div class="col-sm-8">
        <div id="verify-content" class="alert-verify text-center">
          <br>
          <label>
            Sended link to reset password.
            <br>Please, check your email.
          </label>
          <br><br>
          <a href="./index.php" name="button" class="btn btn-primary">Return to Home Page</a>
          <br><br>
        </div>
      </div>
      <div class="col-sm-2" ></div>
    </div>
  </body>
</html>
