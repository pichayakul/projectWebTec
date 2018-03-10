<?php 

$email = $_POST['email'];
$msg = "Please, click link below for reset password.<br>After reset account, you can sign in and enjoy it.<br><br>";
$msg = wordwrap($msg,70);
$msg .= '<a href="http://localhost/projectWebTec/reset-password.php">Reset Password Here.</a><br><br>';
$msg .= 'Thank you for support to us.<br>We hope you enjoy the activities and seminars.<br><br>';
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
$mail->Subject = "Satta Garden - Reset Password";
$mail->Body = $msg;
$mail->AddAddress($email); // to Address
// $mail->AddAttachment("thaicreate/myfile.zip");
// $mail->AddAttachment("thaicreate/myfile2.zip");
//$mail->AddCC("member@thaicreate.com", "Mr.Member ShotDev"); //CC
//$mail->AddBCC("member@thaicreate.com", "Mr.Member ShotDev"); //CC
$mail->set('X-Priority', '1'); //Priority 1 = High, 3 = Normal, 5 = low
$mail->Send();

echo json_encode("SENDED");
?>