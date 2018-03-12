<?php
include "database/epmtfafn_satta_db.php" ;
include "phpqrcode/qrlib.php";
if (isset($_POST["link"])){
  $link = $_POST["link"];
}
else{
  $link = "";
}
if (isset($_POST["sendMail"])){
  $noevent=$_POST["noevent"];
  $username = $_POST["username"];
  $db = new Database();
    $db->openDatabase();

    $row = $db->get_event_noevent($_POST["noevent"]);
  $des="";
  if ($_POST["sendMail"]=="sendAsses"){
    $des = "Hi i'm event's oraganizer of the event that you join (".$row[0]["name"]."),please fill the assessment on this link <br>Click this link to fill it <a href='".$link."'>".$link."</a> ,thank you<br>";
    $head = "Event - Assessement";

  }
  else if($_POST["sendMail"]=="cetificate"){
    $des="Congratuation ,you pass the event that we created :)<br>This is your certificate from ".$row[0]["type"]."'s ".$row[0]["name"]."<br><br><a href='".$link."'>".$link."</a><br>This link will bring you to your certificate";
    $head = "Event - Certificate";
  }
  else if ($_POST["sendMail"]=="acceptReq")
  {
    $des = "Hi i'm event's oraganizer of the event that you join (".$row[0]["name"].").<br>Your ticket is accepted now :),thank you<br><br><br>please bring the QR code on event's day :)";
    $head = "Event - Aleart";
    $li = 'http://localhost/testlast/eventMain.php?noevent='.$noevent.'&accept='.$username;
                            $target_dir = "images/events/".$row[0]["name"]."/attendantUploads"."/".$username;
                            if (!is_dir($target_dir)) {
                                mkdir($target_dir, 0777, true);
                            }
    QRcode::png($li, $target_dir."/qrcode.png", "L", 4, 4);
    $image = $target_dir."/qrcode.png";

  }
  else if ($_POST["sendMail"]=="declineReq"){
    $des = "Hi i'm event's oraganizer of the event that you join (".$row[0]["name"].").<br>Sorry ,Your ticket is declined by Organizer<br>";
    $head = "Event - Aleart";
  }
  if ($des!=""){
    echo $des;
    $noevent=$_POST["noevent"];
    $username=$_POST["username"];

    // echo count($members);
    $accounts = $db->get_account_all();
    $members = $db->get_eventmember_all($noevent);
    include 'PHPMailer_v5.0.2/class.phpmailer.php';
    $organizerName = "";
    foreach ($accounts as $o){
      if ($o["username"]==$username){
        $organizerName = "Organizer ".$o["nickname"];  // set from Name
        break;
      }
    }
    if ($_POST["quitity"]=="many"){
        foreach ($members as $o){
          $email = $db->infoUsername($o["username"])['email'];
          $strMessage = $des;
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
          $mail->FromName = $organizerName;
          //$mail->AddReplyTo = "support@thaicreate.com"; // Reply
          $mail->Subject = $head;
          $mail->Body = $strMessage;
          $mail->AddAddress($email);
          $mail->set('X-Priority', '1'); //Priority 1 = High, 3 = Normal, 5 = low
          if (isset($_POST["condition"])) {
            // if ($_POST["condition"]=="completed"){
            $mail->AddAttachment($image);
            // }
          }
          $mail->Send();
        }
      }
      else{
        $email = $db->infoUsername($_POST["username"])['email'];
          $strMessage = $des;
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
          $mail->FromName = $organizerName;
          //$mail->AddReplyTo = "support@thaicreate.com"; // Reply
          $mail->Subject = $head;
          $mail->Body = $strMessage;
          $mail->AddAddress($email);
          $mail->AddAttachment($image);
          $mail->set('X-Priority', '1'); //Priority 1 = High, 3 = Normal, 5 = low
          $mail->Send();
      }


  }
  $db->closeDatabase();
}


     // to Address
// $mail->AddAttachment("thaicreate/myfile.zip");
// $mail->AddAttachment("thaicreate/myfile2.zip");
//$mail->AddCC("member@thaicreate.com", "Mr.Member ShotDev"); //CC
//$mail->AddBCC("member@thaicreate.com", "Mr.Member ShotDev"); //CC




if (isset($_POST["close"])){
  $noevent=$_POST["noevent"];
  $db = new Database();
  $db->openDatabase();
  $db->update_event_finish($noevent);
  $db->closeDatabase();
}
else if (isset($_POST["update"])){
    $user = $_POST["username"];
    $tic = $_POST["tickets"];
    $req = $_POST["request_date_time"];
    $joi = $_POST["join_date_time"];
    $pay = $_POST["payment_path"];
    $pre = $_POST["pre_path"];
    $noevent=$_POST["noevent"];
    $status=$_POST["status"];

  $db = new Database();
  $db->openDatabase();
  if ($status=="accepted"){
  $db->confirm_eventmember($noevent,$user);
  }
  else{
    $db->decline_eventmember($noevent,$user);
  }
    $events= $db->get_event_noevent($noevent);
                          $t = $events[0]["current"] - $tic;
                          $db->update_event($events[0]["noevent"],$events[0]["username"],$events[0]["name"],$events[0]["type"],$t,$events[0]["capacity"],$events[0]["price"]
                        ,$events[0]["imagePath"],$events[0]["vdoPath"],$events[0]["description"],$events[0]["create_date_time"],$events[0]["start_date_time"],$events[0]["end_date_time"],$events[0]["location"],$events[0]["pre_condition"],$events[0]["lat"],$events[0]["lon"],$link);



                  $requestRow = $db->get_eventmember_all($noevent);
                    $cont='';
                    $conten='';
                  for ($round=0;$round < count($requestRow);$round++){
                            if ($requestRow[$round]["status"]=='accepted'){
                                $cont.='<tr class="success">';
                            }
                            else{
                                $cont.='<tr class="warning">';
                            }

                            $cont.='<td>'.$requestRow[$round]["username"].'</td>';
                            $cont.='<td>'.$requestRow[$round]["tickets"].'</td>';
                            $cont.='<td>'.$requestRow[$round]["request_date_time"].'</td>';
                            $cont.='<td>'.$requestRow[$round]["join_date_time"].'</td>';
                            $cont.='<td>';


                            $arrayIma = explode(',',$requestRow[$round]["payment_path"]);

                            for ($co=count($arrayIma);$co>=0;$co--){
                                if ($co<count($arrayIma)-1){
                                  $cont.='<img class="" data-toggle="modal" data-target="#popup_img" width="100" height="50" src="'.$arrayIma[$co].'" />';
                                }
                            };
                            $cont.='</td>';
                            $cont.='<td>';

                            $arrayIma = explode(',',$requestRow[$round]["pre_path"]);

                            for ($co=count($arrayIma);$co>=0;$co--){
                                if ($co<count($arrayIma)-1){
                                  $cont.='<img class="" data-toggle="modal" data-target="#popup_img" width="100" height="50" src="'.$arrayIma[$co].'" />';
                                }
                            };

                            $cont.='</td>';
                             $dataRequest="'".$requestRow[$round]["username"]."',";
                            $dataRequest.="'".$requestRow[$round]["tickets"]."',";
                            $dataRequest.="'".$requestRow[$round]["request_date_time"]."',";
                            $dataRequest.="'".$requestRow[$round]["join_date_time"]."',";
                            $dataRequest.="'".$requestRow[$round]["payment_path"]."',";
                            $dataRequest.="'".$requestRow[$round]["pre_path"]."',";
                            $dataRequest.="'".$noevent."'";

                            if ($requestRow[$round]["status"]=='accepted'){
                              $cont.='<td><button type="button" class="btn btn-success">accept</button></td>';
                          }
                          else {
                              $cont.='<td><button type="button" class="btn btn-success" onclick="acceptRequest('.$dataRequest.')" >accept</button>
                              <button type="button" class="btn btn-danger" onclick="declineRequest('.$dataRequest.')" >decline</button>
                              </td>';


                            }
                            $cont.='</tr>';

                          }
                  if ($_POST["update"]==""){

                    echo '||splitIT||'.$cont.'||splitIT||'.$t.'||splitIT||';
                    }
                    else{
                      echo '||splitIT||'.$conten.'||splitIT||'.$t.'||splitIT||';
                    }
        $db->closeDatabase();

        }
?>
