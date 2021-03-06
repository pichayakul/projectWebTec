<html>

<head>
    <?php include "database/epmtfafn_satta_db.php" ;?>
    <?php include "upload.php" ;?>

    <!-- <link rel="stylesheet" href="css/bootstrap.min.css"/>  -->
    <link href="css/eventMain.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"/>
    <meta http-equiv=Content-Type content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<?php require './header.php'; ?>
<body id="body" style="background-color: #F0F0F0;">

    <?php
    $uploadOk;
    $finish=0;
    $report;
    $updateC = 0;
    $title='';
    $noevent;
    $ticket=1;
    /**uploadOK =0 ;can't upload */
    $db = new Database();
            $db->openDatabase();
        if (isset($_GET["noevent"]))
        {
            $noevent=$_GET["noevent"];
            if (isset($_SESSION["username"]))
            {
                $username=$_SESSION["username"];
            }
            else{
                $username="guest";
            }
            $price=-99;
            $description='';
            $precondition='';
            $imagePath='';
            $noevent;
            $usernamePage='';
            $row = $db->get_event_and_seminar_all();
            $round=0;
            $priceStart;
            $max_count=count($row);
            date_default_timezone_set('Asia/Bangkok');
            while ($round<$max_count){
                if ($row[$round]["noevent"]==$noevent)
                {
                    $title = $row[$round]["name"];
                    $noevent=$row[$round]["noevent"];
                    $description = $row[$round]["description"];
                    $precondition = $row[$round]["pre_condition"];
                    $imagePath = $row[$round]["imagePath"];
                    $vdoPath = $row[$round]["vdoPath"];
                    $price=$row[$round]["price"];
                    $lat=$row[$round]["lat"];
                    $lon=$row[$round]["lon"];
                    $priceStart=$row[$round]["price"];
                    $status=$row[$round]["status"];
                    $usernamePage=$row[$round]["username"];
                    $linkForm=$row[$round]["formPath"];
                    $type=$row[$round]["type"];
                    $location=$row[$round]["location"];
                    $current=$row[$round]["current"];
                    $capacity=$row[$round]["capacity"];
                    $numberTicket=$capacity-$current;
                    $create_date_time=$row[$round]["create_date_time"];
                    $start_date_time=$row[$round]["start_date_time"];
                    $end_date_time=$row[$round]["end_date_time"];
                    $allStart_date_time=explode(" ",$start_date_time);
                    $datestart=$allStart_date_time[0];
                    $timefrom=$allStart_date_time[1];
                    $date=explode("-",$allStart_date_time[0]);
                    $year=$date[0];
                    $month=$date[1];
                    $day=$date[2];
                    $timeD=explode(":",$allStart_date_time[1]);
                    $time=$timeD[0].":".$timeD[1];
                }
                $round++;
            }
            if ($current < $capacity){
                $isMaxCapacity="Avaliable";
            }
            else{
                $isMaxCapacity="Full";
            }
                if (isset($_POST)){
                    if (isset($_POST["btnCreate"]))
                    {
                        $fi="";
                        $vd="";
                        if (isset($_POST["linkForm"])){
                            $linkForm = $_POST["linkForm"];
                        }
                        else{
                            $linkForm = "";
                        }
                        // echo var_dump($_POST);
                        // echo var_dump($_FILES);
                        if ($_FILES["fileToUpload"]["name"][0]!=""){
                            foreach($_FILES["fileToUpload"]["name"] as $i => $name){
                                $fi.='images/events/'.$title.'/organizerUpload'.'/'.$_FILES['fileToUpload']["name"][$i].',';
                            }
                            
                        }
                        if ($_FILES["vdoUpload"]["name"]!="") {
                            $vd = 'images/events/'.$title.'/organizerUpload'.'/'.$_FILES['vdoUpload']["name"];
                        }
                        if ($fi==""){
                            $fi = $imagePath;
                        }
                        if ($vd==""){
                            $vd=$vdoPath;
                        }
                        $start = $_POST['dateStart'].' '.$_POST['timeFrom'];
                        $end = $_POST['dateEnd'].' '.$_POST['timeTo'];
                        $lat=$_POST["lat"];
                        $lon=$_POST["lon"];
                        if ($uploadOk==1){
                        $db->update_event(intval($noevent),$username,$title,$_POST["T_Event"],intval($current),intval($_POST["capacity"]),intval($_POST["price"])
                        ,$fi,$vd,$_POST["description"],date('Y-m-d h:i:s'),
                        $start,$end,$_POST["location"],$_POST["precondition"],$lat,$lon,$linkForm);
                        $updateC = 1;
                        
                        }
                }
                if (isset($_POST["submitM"])){
                    $fi='';
                    $op='';
                    if (!isset($_POST["free"])){
                    foreach($_FILES["fileToUpload"]["name"] as $i => $name){
                        $fi.='images/events/'.$title.'/attendantUploads'.'/'.$username.'/payment'.'/'.$_FILES['fileToUpload']["name"][$i].',';
                    }
                    foreach($_FILES["fileToUploadM"]["name"] as $i => $name){
                        $op.='images/events/'.$title.'/attendantUploads'.'/'.$username.'/preCondition'.'/'.$_FILES['fileToUploadM']["name"][$i].',';
                    }
                    }
                    $row = $db->get_eventmember_all($noevent);
                    $finish=0;
                    $ti = intval($_POST["ticket"]);
                    for ($i=0;$i<count($row);$i++){
                        if ($row[$i]["username"]==$username){
                            $db->update_eventmember(intval($noevent),$username,date('Y-m-d h:i:s'),$fi,$op,intval($_POST["ticket"])+$row[$i]["tickets"]);
                            $finish=1;
                            


                            break;
                        }
                    }
                    if ($finish==0){

                        $db->add_eventmember(intval($noevent),$username,date('Y-m-d h:i:s'),$fi,$op,intval($_POST["ticket"]));
                        
                    }
                    $db->update_event(intval($noevent),$usernamePage,$title,$type,$current+$ti,$capacity,$price,$imagePath,
                        $vdoPath,$description,$create_date_time,$start_date_time,$end_date_time,$location,$precondition,$lat,$lon,$linkForm);
                        $updateC = 1;
                }
            }
        $db->closeDatabase();
        $db->openDatabase();
            $noevent=$_GET["noevent"];
            $price=-99;
            $description='';
            $precondition='';
            $imagePath='';
            $noevent;
            $usernamePage='';
            $row = $db->get_event_and_seminar_all();
            $requestRow = $db->get_eventmember_all($noevent);
            $userInfo = $db->get_eventmember_all($noevent);
            $round=0;
            $priceStart;
            $max_count=count($row);
            $eventPage=$db->get_event_noevent($noevent);
            date_default_timezone_set('Asia/Bangkok');
            while ($round<$max_count){
                if ($row[$round]["noevent"]==$noevent)
                {
                    $title = $row[$round]["name"];
                    $noevent=$row[$round]["noevent"];
                    $description = $row[$round]["description"];
                    $precondition = $row[$round]["pre_condition"];
                    $imagePath = $row[$round]["imagePath"];
                    $vdoPath = $row[$round]["vdoPath"];
                    $price=$row[$round]["price"];
                    $lat=$row[$round]["lat"];
                    $lon=$row[$round]["lon"];
                    // echo $lat,$lon;
                    $priceStart=$row[$round]["price"];
                    // $ticket=1;
                    $usernamePage=$row[$round]["username"];
                    $type=$row[$round]["type"];
                    $location=$row[$round]["location"];
                    $current=$row[$round]["current"];
                    $capacity=$row[$round]["capacity"];
                    $linkForm=$row[$round]["formPath"];
                    $numberTicket=$capacity-$current;
                    $create_date_time=$row[$round]["create_date_time"];
                    $start_date_time=$row[$round]["start_date_time"];
                    $end_date_time=$row[$round]["end_date_time"];
                    $allStart_date_time=explode(" ",$start_date_time);
                    $allEnd_date_time=explode(" ",$end_date_time);
                    $allEnd_date_timeExpl=explode("-",$allEnd_date_time[0]);
                    $datestart=$allStart_date_time[0];
                    $timefrom=$allStart_date_time[1];
                    $date=explode("-",$allStart_date_time[0]);
                    $year=$date[0];
                    $month=$date[1];
                    $lat=$row[$round]["lat"];
                    $lon=$row[$round]["lon"];
                    $status=$row[$round]["status"];
                    $day=$date[2];
                    $yearE=$allEnd_date_timeExpl[0];
                    $monthE=$allEnd_date_timeExpl[1];
                    $dayE=$allEnd_date_timeExpl[2];
                    $timeE=$allEnd_date_time[1];
                    $timeDE=explode(":",$timeE);
                    $timeEnd=$timeDE[0].":".$timeDE[1];
                    $timeD=explode(":",$allStart_date_time[1]);
                    $time=$timeD[0].":".$timeD[1];

                }
                $round++;
            }
            if ($status==1){
                $isMaxCapacity="Finished";
            }
            else if ($current < $capacity){
                $isMaxCapacity="Avaliable";
            }
            else{
                $isMaxCapacity="Full";
            }
        }
        if (isset($_GET["accept"])){
            $db->pass_event_eventmember($noevent, $_GET["accept"],date('Y-m-d h:i:s'));
            // alert($_GET["accept"]. ' is Join the event.');
            echo ("<script> alert('".$_GET["accept"]." is Joined the event now.')</script>");
            
        }
        $db->closeDatabase();
        echo "<input type='hidden' id='updateFinish' value=".$finish.">";
        echo "<input type='hidden' id='noevent' value=".$noevent.">";
        echo "<input type='hidden' id='updateC' value=".$updateC.">";
       ?>

        <script>
            if ($('#updateFinish').val()!="0" || $('#updateC').val()==1){
                window.location="eventMain.php?noevent=".concat($('#noevent').val());
            }
        </script>
       <?php

if ($username==$usernamePage)
{

    echo '<div class="container">
    <div class="dropdown">
    <button type="button" class="btn btn-primary dropdown-toggle" style="text-align:right" data-toggle="dropdown" data-target="#demo">Menu
    <span class="caret"></span></button>
    <!-- Trigger the modal with a button -->

    <ul class="dropdown-menu">


    ';





    if ($isMaxCapacity=="Finished")
    {echo '<li><a class="btn disabled" data-toggle="modal" data-target="#myModal">EditEvent</a></li>
        <li><a class="btn disabled" data-toggle="modal" data-target="#closeEvent" >CloseEvent</a></li>';}
    else{
    echo '<li><a class="btn" data-toggle="modal" data-target="#myModal">EditEvent</a></li>
    <li><a  class="btn" data-toggle="modal" data-target="#closeEvent" >CloseEvent</a></li>';
    }
    echo '<li><a class="btn" data-toggle="modal" data-target="#manageRequest">ManageRequest</a></li>';
    echo '<li><a class="btn" data-toggle="modal" data-target="#member">Certificant</a></li>';

    echo '

    </div>
    </div>
    <!-- Modal Member -->
    <div class="modal fade" id="member" role="dialog" style="overflow: auto;">
      <div class="modal-dialog " style="width:fit-content;" >



        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Sent the Certificant</h4>
          </div>
          <div> You can create it on this link : <a href="https://www.canva.com" target="_blank">www.canva.com</a></div>
          <table class="table">
          <thead>
            <tr>
              <th>Username</th>
              <th>Ticket</th>

              <th>Status</th>
            </tr>
          </thead>
          <tbody id="tableMember">';

          $count=0;
              for ($round=0;$round < count($requestRow);$round++){
                if ($requestRow[$round]["status"]=='completed'){
                    echo '<tr class="success">';
                }
                else{
                  echo '<tr class="warning">';
                }

                echo '<td>'.$requestRow[$round]["username"].'</td>';
                echo '<td>'.$requestRow[$round]["tickets"].'</td>';

                 $dataRequest="'".$requestRow[$round]["username"]."',";
                $dataRequest.="'".$requestRow[$round]["tickets"]."',";
                $dataRequest.="'".$requestRow[$round]["request_date_time"]."',";
                $dataRequest.="'".$requestRow[$round]["join_date_time"]."',";
                $dataRequest.="'".$requestRow[$round]["payment_path"]."',";
                $dataRequest.="'".$requestRow[$round]["pre_path"]."',";
                $dataRequest.="'".$noevent."'";
                if ($requestRow[$round]["status"]=="completed"){
                  $count=$count+1;
                    echo '<td>Pass</td>';
                }
                else{
                    echo '<td>Not-pass</td>';
                }

                echo '</tr>';
              }
              echo '
          </tbody>
          </table>
          <div class="modal-footer">

          <div>Put your certificate link on this box ,then click the submit to sent.<input type="text" id="imageOnline" class="form-control" name="imageOnline"></div>';
          if ($count>0){
      echo '<button id="btnsentCer" onclick='."'".'sentCetificate('.$noevent.',"'.$username.'"'.')'."'".' class="btn btn-success">sent</button>';}
      else{
        echo '<button id="btnsentCer" onclick='."'".'sentCetificate('.$noevent.',"'.$username.'"'.')'."'".' class="btn btn-success disabled">sent</button>';}

      echo '
          </div>

      </div>
      </div>
      </div>

  </ul>
  </div>

</div>
</div>


    <!-- Modal CloseEvent -->
    <div class="modal fade" id="closeEvent" role="dialog" style="overflow: auto;">
      <div class="modal-dialog " style="width:fit-content;" >



        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Close Event</h4>
          </div>
          <div class="modal-body">
          <div >
          <h4>Please submit to close the event (can'."'".'t undo)</h4>
          </div>
          <div>*Please check the link form that send to attandants*</div>
          <input type="text" value="'.$linkForm.'" class="form-control" readonly>

          <div style="margin-top:10">
          Click here to sent the link to all attantdant';
          if ($linkForm!=""){
              echo '<button type="submit" id="sentMail" class="btn btn-info" style="margin-left:10px" value="sendMail" onclick='."'".'sendMailAssessetment('.$noevent.',"'.$username.'","'.$linkForm.'"'.')'."'".'>Send</button>
          ';
            }
            else{
                echo '<button type="submit" id="sentMail" class="btn btn-info disabled" style="margin-left:10px" value="sendMail" onclick='."'".'sendMailAssessetment('.$noevent.',"'.$username.'","'.$linkForm.'"'.')'."'".'>Send</button>
                ';  
            }
            echo '
          </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" onclick="closeEvent('.$noevent.');reload();" value="submit">Submit</button>
          </div>

          </div>
      </div>
      </div>

  </ul>
  </div>

</div>
</div>

    <!-- Modal ManageRequest -->
    <div class="modal fade" id="manageRequest" role="dialog" style="overflow: auto;">
      <div class="modal-dialog " style="width:fit-content;" >



        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">ManageRequest</h4>
          </div>
          <div class="modal-body">
          <div class="" >

          <form id="manageRequestID" method="" enctype="multipart/form-data">
          <table class="table">
              <thead>
                <tr>
                  <th>Username</th>
                  <th>Ticket</th>
                  <th>Request date</th>
                  <th>Join date</th>
                  <th>Payment</th>
                  <th>pre-condition</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody id="TableBODY">';


                  for ($round=0;$round < count($requestRow);$round++){
                    if ($requestRow[$round]["status"]!='requested'){
                        echo '<tr class="success">';
                    }
                    else{
                      echo '<tr class="warning">';
                    }

                    echo '<td>'.$requestRow[$round]["username"].'</td>';
                    echo '<td>'.$requestRow[$round]["tickets"].'</td>';
                    echo '<td>'.$requestRow[$round]["request_date_time"].'</td>';
                    echo '<td>'.$requestRow[$round]["join_date_time"].'</td>';
                    echo '<td>';

                    $arrayIma = explode(',',$requestRow[$round]["payment_path"]);
                    if (count($arrayIma)>1){


                    for ($co=count($arrayIma);$co>=0;$co--){
                        if ($co<count($arrayIma)-1){
                            echo '<img width="100" height="50" src="'.$arrayIma[$co].'" />';
                        }
                    };
                    }
                    echo '</td>';
                    echo '<td>';

                    $arrayIma = explode(',',$requestRow[$round]["pre_path"]);
                    if (count($arrayIma)>1){


                    for ($co=count($arrayIma);$co>=0;$co--){
                        if ($co<count($arrayIma)-1){

                            echo '<img width="100" height="50" src="'.$arrayIma[$co].'" />';
                        }
                    };
                    }

                    echo '</td>';
                     $dataRequest="'".$requestRow[$round]["username"]."',";
                    $dataRequest.="'".$requestRow[$round]["tickets"]."',";
                    $dataRequest.="'".$requestRow[$round]["request_date_time"]."',";
                    $dataRequest.="'".$requestRow[$round]["join_date_time"]."',";
                    $dataRequest.="'".$requestRow[$round]["payment_path"]."',";
                    $dataRequest.="'".$requestRow[$round]["pre_path"]."',";
                    $dataRequest.="'".$noevent."'";

                    if ($requestRow[$round]["status"]!='requested'){
                        echo '<td><button type="button" class="btn btn-success disabled">accept</button></td>';
                    }
                    else {
                        if ($eventPage[0]["status"]==1){
                          echo '<td><button type="button" class="btn btn-success disabled"  onclick="acceptRequest('.$dataRequest.')" >accept</button>
                          <button type="button" class="btn btn-danger disabled" onclick="declineRequest('.$dataRequest.')" >decline</button>
                          </td>';
                        }
                        else{
                        echo '<td><button type="button" class="btn btn-success"  onclick="acceptRequest('.$dataRequest.')" >accept</button>
                        <button type="button" class="btn btn-danger" onclick="declineRequest('.$dataRequest.')" >decline</button>
                        </td>';
                      }

                    }
                    echo '</tr>';
                  }
                  echo '
              </tbody>
              </table>
          </form>
          </div>
      </div>
      </div>
  </div>
  </div>

</div>
</div>

    <!-- Modal Edit-->
    <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog" >

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit</h4>
          </div>
          <div class="modal-body">
          <div class="" >

          <form id="EDITID" method="post" enctype="multipart/form-data">
          <input type="hidden"  id="titleF"  name="title" value="'.$title.'" >

          <div class="form-group">
              <label class="control-label col-sm-1" >Description:</label>
              <div class="col-sm-12">
              <textarea  name="description" class="form-control" rows="8" id="comment" required="">'.$description.'</textarea>
              </div>
              <label class="control-label" ></label>
          </div>
          <div class="forn-group">
              <label class="control-label col-sm-1" >Precondition:</label>
              <div class="col-sm-12">
              <input type="text" class="form-control" id="precondition"  name="precondition" value="'.$precondition.'" required="">
              </div>
          </div>
          <div class="form-group">
              <label class="control-label col-sm-1" >Capacity:</label>
              <div class="col-sm-12">
              <input type="number" class="form-control" id="capacity"  name="capacity" min=0 value="'.$capacity.'" required="">
              </div>
          </div>
          <div class="form-group">
              <label class="control-label col-sm-1" >Price:</label>
              <div class="col-sm-12">
              <input type="number" class="form-control" id="price"  name="price" min=0 value="'.$price.'" required="">
              </div>
          </div>
          <div class="form-group">
              <label class="control-label col-sm-1" >Location:</label>
              <div class="col-sm-12"  style="margin-bottom:20px">
              <input type="text" class="form-control" id="location"  name="location" value="'.$location.'" required="">
              </div>
          </div>
          <div class="form-group">
                <div class="col-sm-12">
                <div id="map" style="width:auto;height:300px;"></div>
                <input id="pac-input" style="width:250px;margin-top:15px;margin-left:10px"class="controls" type="text" placeholder="Search Box" >
                </div>

          </div>
          <div class="form-group">
              <label class="control-label col-sm-1" >StartDate:</label>
              <div class="col-sm-12">
              <input type="date" class="form-control" id="dateStart"  name="dateStart" value="'.$allStart_date_time[0].'" required="">
              </div>
          </div>
          <div class="form-group">
              <label class="control-label col-sm-1" >StartTime:</label>
              <div class="col-sm-12">
              <input type="time" class="form-control"  id="timeFrom"  name="timeFrom" value="'.$allStart_date_time[1].'" required="">
              </div>
          </div>
          <div class="form-group">
              <label class="control-label col-sm-1" >EndDate:</label>
              <div class="col-sm-12">
                <input type="date" class="form-control" id="dateEnd" name="dateEnd" value="'.$allEnd_date_time[0].'" required="">
              </div>
          </div>
              <div class="form-group">

                <label class="control-label col-sm-1" >EndTime:</label>
                <div class="col-sm-12">
                  <input type="time" class="form-control" id="timeTo"  name="timeTo" value="'.$allEnd_date_time[1].'" required="">
                </div>
              </div>

          <div class="form-group">

                  <label class="control-label col-sm-1" >Type:</label>
                  <div class="col-sm-12" style="margin-left:30px">
                    <div class="row" required="">
                    ';
                    if ($type=="event"){
                        echo '<div class="col-sm-8"><input type="radio" checked="checked" name="T_Event" value="event">Event</div>
                        <div class="col-sm-8"><input type="radio" name="T_Event" value="seminar">Seminar</div>';
                    }
                    else{
                        echo '<div class="col-sm-8"><input type="radio"  name="T_Event" value="event">Event</div>
                        <div class="col-sm-8"><input type="radio" checked="checked" name="T_Event" value="seminar">Seminar</div>';
                    }
                    echo '

                    </div>
                  </div >
          </div>


          <div class="form-group">
                  <label class="control-label col-sm-1" >Video:</label>
                  <input type="file" class="form-control btn btn-default" name="vdoUpload"  accept="video/*">
                  <label class="control-label col-sm-1" >Image:</label>
                  <input type="file" class="form-control btn btn-default" name="fileToUpload[]" multiple="multiple" accept="image/*">
          </div>
                  <div class="form-group">
                    <label class="control-label col-sm-12">Form link (To collect comments from attandants) :</label>
                      <div class="col-sm-12">
                        The link to create a form <a href="https://docs.google.com/forms" target="_blank">Google form</a></div>
                          <input class="form-control" type="text" name="linkForm" value="'.$linkForm.'">
                      </div>
                  </div>
              <input type="hidden" name="username" value="'.$_SESSION["username"].'">
              <input type="hidden" id="lat" name="lat" value="'.$lat.'">
                <input type="hidden" id="lon" name="lon" value="'.$lon.'">

          </div>

          <div class="modal-footer">
          <input type="submit" name="btnCreate" style="text-align:center" class="btn btn-default " value="Submit">
            </div>
          </form>
          </div>
      </div>
      </div>
  </div>
  </div>
</div>
</div>
  </div>';
}
?>
        <div class="row">
            <div class="col-lg-2" ></div>

            <div id='background' class="background col-lg-8 img-fluid z-depth-4 " style="border-radius: 10px;padding-bottom:20px;box-shadow: 0 0 10px;">

            <div class="row">
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators" >
                                    <?php
                                    $max_count = substr_count($imagePath,",");
                                    $content='';
                                    $contentSrc='';
                                    if ($max_count>0){
                                        $imagePath=explode(",",$imagePath);
                                    }
                                    for ($x = 0; $x < $max_count; $x++) {
                                        $path = $imagePath[$x];
                                        if ($x==0){
                                            $content.='<li data-target="#myCarousel" data-slide-to="0" class="active"></li>';
                                            $contentSrc.='<div class="item active">
                                            <img src="'.$path.'" style="width:100%; height: 400px;border-top-left-radius: 10px;border-top-right-radius: 10px;">
                                        </div>';
                                        }
                                        else{
                                            $content.='<li data-target="#myCarousel" data-slide-to="'.$x.'"></li>';
                                            $contentSrc.='<div class="item">
                                            <img src="'.$path.'" style="width:100%; height: 400px;border-top-left-radius: 10px;border-top-right-radius: 10px;">
                                        </div>';
                                        }

                                    }
                                    echo $content;
                                ?>
                            </ol>
                            <div class="carousel-inner">
                                <?php echo $contentSrc?>
                            </div>
                            <a class="left carousel-control" href="#myCarousel" data-slide="prev" style="border-top-left-radius: 10px;">
                                <span class="glyphicon glyphicon-chevron-left" ></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="right carousel-control" href="#myCarousel" data-slide="next" style="border-top-right-radius: 10px;">
                                <span class="glyphicon glyphicon-chevron-right" ></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                <div class="col-lg-1"></div>
                <div class="col-lg-10">
                            <?php
                                echo '<div class="row">';
                                echo '<div class="col-sm-0"></div><div class="col-sm-12"><h2>'.$title.'</h2>';
                                echo '<div style="font-size:20px"><div><i class="glyphicon glyphicon-user" style="margin-right:10px"></i><div id="current" style="display:inline">'.$current.'</div>/'.$capacity;
                                if ($isMaxCapacity=="Finished"){
                                    echo '<span class="label label-default" style="margin-left:10px;margin-top:-5px;background:red">'.$isMaxCapacity."</span>";
                                }
                                else if ($isMaxCapacity!="Full"){
                                    echo '<span class="label label-default" style="margin-left:10px;margin-top:-5px;background:green">'.$isMaxCapacity."</span>";
                                }
                                else{
                                    echo '<span class="label label-default" style="margin-left:10px;margin-top:-5px">'.$isMaxCapacity."</span>";
                                }
                                echo '<br></div>' ;
                                echo '<i class="glyphicon glyphicon-calendar" style="margin-right:5px"></i>'." ".DateEng($datestart)[0]." to ".DateEng($timefrom)[0];
                                echo '<div id="DateTime"><i class="glyphicon glyphicon-time" style="margin-right:10px"></i>'.$time." - ".$timeEnd.'</div>';
                                echo '<i class="glyphicon glyphicon-info-sign" style="margin-right:10px"></i>'.$type.'</div><br>';
                                ?>
                                <?php

                                if ($username!=$usernamePage){
                                    echo '<div class="container">
                                    <!-- Trigger the modal with a button -->
                                    ';
                                    if ($isMaxCapacity=="Full" || $isMaxCapacity=="Finished"){
                                        echo '<button class="btn btn-info btn-lg disabled" id="buttonBuy" onclick="checkLogin()" style="text-align:center;margin-left:20px;width:180px;margin-bottom:20px">BuyTicket</button></div>';
                                    }
                                    else{
                                        $haveTICKET=0;
                                        foreach ($requestRow as $i){
                                            if ($username==$i["username"]){
                                                $haveTICKET=1;
                                            }
                                        }
                                        if ($haveTICKET==0){
                                        echo '
                                    <button type="button" id="buttonBuy" class="btn btn-info btn-lg" onclick="checkLogin()" style="text-align:center;margin-left:20px;width:180px;margin-bottom:20px" data-toggle="modal" data-target="#myModal">BuyTicket</button>'                                    ;
                                        }
                                        else{
                                            echo '
                                                <button type="button"id="buttonBuy" class="btn btn-info btn-lg" onclick="checkLogin()" style="text-align:center;margin-left:20px;width:180px;margin-bottom:20px" data-toggle="modal" data-target="#myModal">Buymore/Cancel</button>'                                   ;
                                        }
                                    echo '
                                    <!-- Modal -->
                                    <div class="modal fade" id="myModal" role="dialog">
                                    <div class="modal-dialog" >

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">BuyTicket/Cancel</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div>';
                                            foreach ($userInfo as $o){
                                                if ($o["username"]==$username){
                                                    if ($o["status"]=="accepted"){
                                                        echo '<tr class="success">';
                                                    }
                                                    else{
                                                        echo '<tr class="default">';
                                                    }
                                                    $a ='<td class="col-sm-4">'.$o["username"].'</td>';
                                                    $a.='<td class="col-sm-4">'.$o["tickets"].'</td>';
                                                    $dataRequest="'".$o["username"]."',";
                                                    $dataRequest.="'".$o["tickets"]."',";
                                                    $dataRequest.="'".$o["request_date_time"]."',";
                                                    $dataRequest.="'".$o["join_date_time"]."',";
                                                    $dataRequest.="'".$o["payment_path"]."',";
                                                    $dataRequest.="'".$o["pre_path"]."',";
                                                    $dataRequest.="'".$noevent."'";
                                                    if ($o["status"]=="accepted"){
                                                        $a.='<td ><button id="accept" class="col-sm-4 btn btn-success"  style="width:100px" onclick="declineRequestAttentand('.$dataRequest.','."'".$o["status"]."'".')">Accept</button></td>';
                                                    }
                                                    else{
                                                    $a.='<td class="col-sm-4"><button id="reques" type="button" class="btn btn-warning btn-primary" style="width:100px" onclick="declineRequestAttentand('.$dataRequest.','."'".$o["status"]."'".')"'.'>requested</button></td>';
                                                    }


                                                }
                                            }
                                                if ($haveTICKET==1){
                                                    echo
                                                    '<table class="table">
                                                    <thread>
                                                        <tr>
                                                            <th>Username</th>
                                                            <th>Tickets</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thread>
                                                    <tbody id="Tablebody">
                                                            ';
                                                            echo $a;
                                                            echo '</tr>

                                                    </tbody>
                                                    </table>
                                                    <hr>';
                                                }
                                                echo '<br>
                                                <h3>Buy more </h3>
                                                <div font-size:15px"><label class="control-label col-sm-10" >Ticket : '.'<button class="btn btn-primary" onclick="plusMoney(-1)" style="margin-left:80px">-</button><div id="ticket" style="display:inline;margin-left:20px">'.$ticket.'</div><button class="btn btn-primary" onclick="plusMoney(1)" style="margin-left:20px">+</button></label></div>
                                                <div font-size:15px"><label class="control-label col-sm-10" >Total Amount : '.'<div id="price" style="display:inline;margin-left:80px">'.$price.'</div></label></div>
                                                    <form id="BUYID"method="post" enctype="multipart/form-data">

                                                ';
                                                if ($priceStart==0){
                                                    echo '<div class="form-group" style="height:50px">  ';
                                                    echo '<input type="hidden" id="" name="free">';
                                                }
                                                else{
                                                    echo '<div class="form-group">';
                                                    echo '

                                                    <label class="control-label col-sm-12" >PaymentFile :</label>
                                                    <input type="file" class="form-control btn btn-default" multiple="multiple" accept="image/*" style="margin-top:10" id="titleF"  name="fileToUpload[]">
                                                    <br>
                                                    <label class="control-label col-sm-12" >PreConditionFile :
                                                    </label><input type="file" class="form-control btn btn-default" multiple="multiple" accept="image/*" style="margin-top:10" id="titleP"  name="fileToUploadM[]">
                                                    ';
                                                }
                                                echo '<input type="hidden" name="username" value="'.$username.'">
                                                <input type="hidden" id="ticketHidden" name="ticket" value=1>
                                                <input type="hidden" name="title" value="'.$title.'">
                                                    </div>
                                                </div>

                                                </div>
                                            <div class="modal-footer">
                                            <input type="submit" style="text-align:center;" class="btn btn-default " name="submitM" value="submit">
                                            </div>
                                            </form>

                                            </div>

                                        </div>

                                    </div>
                                    </div>
                                    </div></div>';



                                }
                            }
                                ?>
                    </div>
                               <script>
                                   var price=0;
                                   var ticket = <?php echo $ticket?>;
                                    function plusMoney(a){
                                        if (price==0){
                                            price = <?php echo $price?>;
                                        }


                                        var priceStart = <?php echo $priceStart?>;
                                        if  (a==1){
                                            ticket+=1;
                                            price=price+priceStart;
                                            if (ticket> <?php echo $numberTicket?>){
                                                ticket-=1;
                                                price=price-priceStart;
                                            }

                                        }
                                        else{
                                            ticket-=1;
                                            price=price-priceStart;
                                            if (price<=0)
                                            {
                                                ticket=1;
                                                price=priceStart;
                                            }
                                        }
                                        document.getElementById('price').innerHTML=price;
                                        document.getElementById('ticket').innerHTML=ticket;
                                        document.getElementById("ticketHidden").value=ticket;

                                    }
                                </script>
                    <div id='teserVDO'>
                        <?php
                            $path = $vdoPath;
                            $firstPart = '<div class="row"><div ><video width="100%" controls><source src="';
                            $secondPart='"type="video/mp4">Your browser does not support the video tag.</video></div></div>';
                            echo $firstPart.$path.$secondPart;
                        ?>
                    </div>

                    <div class="contain" style="text-align:center;">
                        <div id='description' class="box">
                        <center><h3>Description</h3></center>
                            <div class="detail" style="margin-left:20px"><?php echo $description;?></div>
                        </div>
                    </div>
                                    <hr>
                    <div class="contain" style="text-align:center;">

                        <div id='preCondition' class="box"  >
                        <center><h3 style="font-family: Roboto;">Condition</h3></center>
                            <div id='preConditionContent' class="detail" style="margin-left:20px">
                                <?php
                                    if ($max_count>0){
                                        $condition=$precondition;
                                    }
                                    else{
                                        $condition="none";
                                    }
                                    echo $condition;
                                ?>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="contain">
                        <div class="row">
                            <div class="col-lg-1"></div>
                            <div class="col-lg-10">
                            <center><i class="fa fa-map-marker" style="font-size:20px;"></i><h3 style="font-family: Roboto;">Location</h3>
                        </center>

                                <div class="row">
                                    <div class="col-lg-8">
                                        <div id="map2" style="width:auto;height:200;"></div>
                                            <input id="pac-input2" style="width:250px;margin-top:15px;margin-left:10px"class="controls" type="text" placeholder="Search Box" ></div>
                                                <div id='background' class="col-lg-4 img-fluid z-depth-4 bottomBox">
                                                <div id="location" style="font-size:20px;margin-top:30px" ><?php echo " ".$location?></div>
                                                <a class="btn btn-success" href='https://www.google.com/maps/dir/Current+Location/<?php echo $lat ?>,<?php echo $lon ?>' target="_blank">Direction</a>



                                        </div>
                                </div>
                                </div>
                                <div class="col-lg-1"></div>
                                </div>
                                </div>
                </div>
                <div class="col-lg-1"></div>
                <div id='boxAlert'></div>
                <div id='boxBuyTicket'></div>
                <div id='boxSetting'></div>
                </div>
            </div>
            </div>

            </div>
        </div>
    <script>

        var map;
        var username='<?php echo $username?>';
        var usernamePage='<?php echo $usernamePage?>';
      var markers = [];
      function initAutocomplete() {
        var myOptions = {
        zoom: 5,
        center: new google.maps.LatLng(<?php echo $lat?>,<?php echo $lon ?>),
        mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        if (username==usernamePage)
        {
            map = new google.maps.Map(document.getElementById("map"), myOptions);
        map.addListener('click', function(e) {
          placeMarkerAndPanTo(e.latLng, map);
        });
        var l = new google.maps.Marker({
          position: {lat: <?php echo $lat?>, lng: <?php echo $lon?>},
          map: map
        });
        markers.push(l);
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });
        searchBox.addListener('places_changed', function() {
          for (var i = 0; i < markers.length; i++) {
              markers[i].setMap(null);
          }
          markers = [];
          var places = searchBox.getPlaces();
          if (places.length == 0) {
            return;
          }
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
            marker = new google.maps.Marker({
              map: map,
              title: place.name,
              position: place.geometry.location
            });
            markers.push(marker);

            if (place.geometry.viewport) {
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);
          markers.push(marker);
          var location = map.getCenter();

            // document.getElementById("lat").innerHTML=location.lat();
            document.getElementById("lat").value = location.lat();
            // document.getElementById("lon").innerHTML = location.lng();
            document.getElementById("lon").value = location.lng();
        });
      }

        /** box2 */
        map2 = new google.maps.Map(document.getElementById("map2"), myOptions);
        new google.maps.Marker({
          position: {lat: <?php echo $lat?>, lng: <?php echo $lon?>},
          map: map2
        });
        var input2 = document.getElementById('pac-input2');
        var searchBox2 = new google.maps.places.SearchBox(input2);
        map2.controls[google.maps.ControlPosition.TOP_LEFT].push(input2);
        map2.addListener('bounds_changed', function() {
          searchBox2.setBounds(map2.getBounds());
        });

        searchBox2.addListener('places_changed', function() {
          var places2 = searchBox2.getPlaces();
          if (places2.length == 0) {
            return;
          }
          var bounds2 = new google.maps.LatLngBounds();
          places2.forEach(function(place2) {
            if (!place2.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
            var icon2 = {
              url: place2.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };
            if (place2.geometry.viewport) {
              bounds2.union(place2.geometry.viewport);
            } else {
              bounds2.extend(place2.geometry.location);
            }
          });
          map2.fitBounds(bounds2);
          var location = map2.getCenter();
            document.getElementById("lat").value=location.lat();
            document.getElementById("lon").value = location.lng();

        });

    }
      function placeMarkerAndPanTo(latLng, map) {
        var marker = new google.maps.Marker({
          position: latLng,
          map: map
        });
        map.panTo(latLng);
        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(null);
        }
        markers = [];
        markers.push(marker);
        var location = map.getCenter();
            document.getElementById("lat").value = location.lat();
            document.getElementById("lon").value = location.lng();
      }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCfk7eKoClwjzWQcxpZX6wRznS6_oRhS8U&libraries=places&callback=initAutocomplete"
         async defer>
    </script>
    <br>
    <div class="contain" style="">
                    <div class="row">
                        <div class="col-lg-2"></div>
                        <div class="col-lg-8" >
                            <center>
                                <div class="row background" style="box-shadow: 0 0 10px ">

                                            <div id='background' class="col-lg-6 img-fluid z-depth-4 bottomBox">
                                            <h3><a id='btnWebBoard' class="btnMenu" href='nut.php?noevent=<?php echo $noevent?>'>Webboard</a></h3>If you have a question create the topic on the webborad.
                                            </div>

                                        <div id='background' class="col-lg-6 img-fluid z-depth-4 bottomBox" >
                                            <h3>About Organizer</h3>
                                            Username : <?php echo $usernamePage?>
                                        </div>
                                        </div>

                                </div>
                                </center>
                        </div>
                        <div class="col-lg-2"></div>
                    </div>

                </div>

    <!-- <script src="./js/jquery-3.3.1.min.js"></script> -->
    <!-- <script src="./js/popper.min.js"></script> -->
    <!-- <script src="./js/bootstrap.min.js"></script> -->


    <script>
        function closeEvent($noevent){
            $.post( "myfunction.php", { close:"",
              noevent:$noevent},function(data) {
                  console.log(data);
            var noEvent = "<?php echo $_GET['noevent'] ?>";
            window.location="eventMain.php?noevent="+noEvent;
              });


       }

    </script>
    <?php


    function DateEng($strDate){
        $strYear = date("Y",strtotime($strDate));
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
        $strHour= date("H",strtotime($strDate));
        $strMinute= date("i",strtotime($strDate));
        $strSeconds= date("s",strtotime($strDate));
        $strMonthCut = Array("","JAN","FEB","MAR","APR","MAY","JUN","JUL","AUG","SEP","OCT","NOV","DEC");
        $strMonthEng=$strMonthCut[$strMonth];
        return array("$strDay/$strMonthEng/$strYear ","$strHour:$strMinute");
    }

    ?>
    <script>
        function checkLogin(){
            if (<?php if (isset($_SESSION["username"])){echo 1;}else{echo 0;} ?>==0){
                $("#buttonBuy").attr('data-target','#login-myModal');
            }

        }
        $(document).ready(function(){
            if ($('#reques').css("background")!="green"){
                $("#reques").hover(function(){
            $('#reques').css("background-color", "red");
            document.getElementById('reques').innerHTML="Cancel";
            }, function(){
            $("#reques").css("background-color", "orange");
            document.getElementById('reques').innerHTML="Requested";
            });
            }else if ($('#accept').css("background")!="red"){
                $("#accept").hover(function(){
            $('#accept').css("background-color", "red");
            document.getElementById('accept').innerHTML="Cancel";
            }, function(){
            $("#accept").css("background-color", "green");
            document.getElementById('accept').innerHTML="Accepted";
            });
            }
            $('input[type="file"]').change(function(e){
                fileName = URL.createObjectURL(e.target.files[0]);
                console.log(fileName);
            });


        });

        function sentCetificate($noevent,$user){
            $.post("myfunction.php",{
                sendMail:"cetificate",
            link:$('#imageOnline').val(),
            quitity:"many",
            sendCertificate:"",
            noevent:$noevent,
            username:$user
            },function(data) {
                console.log(data);
                $('#btnsentCer').addClass('disabled');
            $('#btnsentCer').removeClass('btn-info');
            $('#btnsentCer').addClass('btn-default');
            });
        }
        function sendMailAssessetment($noevent,$user,$link){
            $.post("myfunction.php",{
                sendMail:"sendAsses",
            link:$link,
            quitity:"many",
            noevent:$noevent,
            username:$user
            },function(data) {
                console.log(data);
                $('#sentMail').addClass('disabled');
            $('#sentMail').removeClass('btn-info');
            $('#sentMail').addClass('btn-default');
            });

        }
      function acceptRequest($user,$tic,$req,$joi,$pay,$pre,$noevent) {
        $.post( "myfunction.php", { username: $user,
                                    tickets: $tic,
                                   request_date_time: $req,
                                    join_date_time: $joi,
                                   payment_path: $pay,
                                   pre_path: $pre ,
                                   update:"",
                                   status:"accepted",
                                   sendMail:"acceptReq",
                                   quitity:"one",
                                   noevent:$noevent}
              ,function(data) {
                  console.log(data);
                var data = data.split('||splitIT||');
                document.getElementById('TableBODY').innerHTML=data[1];
                document.getElementById('current').innerHTML=data[2];
          });
      }
      function declineRequest($user,$tic,$req,$joi,$pay,$pre,$noevent) {
        $.post( "myfunction.php", { username: $user,
                                    tickets: $tic,
                                   request_date_time: $req,
                                    join_date_time: $joi,
                                   payment_path: $pay,
                                   pre_path: $pre ,
                                   update:"",
                                   status:"declined",
                                   sendMail:"declineReq",
                                   quitity:"one",
                                   noevent:$noevent}
              ,function(data) {
                console.log(data);
                var data = data.split('||splitIT||');
                document.getElementById('TableBODY').innerHTML=data[1];
                document.getElementById('current').innerHTML=data[2];
          });
      }
      function declineRequestAttentand($user,$tic,$req,$joi,$pay,$pre,$noevent) {
        $.post( "myfunction.php", { username: $user,
                                    tickets: $tic,
                                   request_date_time: $req,
                                    join_date_time: $joi,
                                   payment_path: $pay,
                                   pre_path: $pre ,
                                   update:"declineByAttendant",
                                   status:"declined",
                                   sendMail:"declineReAt",
                                   quitity:"one",
                                   noevent:$noevent}
              ,function(data) {
                console.log(data);
                var data = data.split('||splitIT||');

                document.getElementById('Tablebody').innerHTML=data[1];
                document.getElementById('current').innerHTML=data[2];
          });
      }
    </script>
    </body>
</html>
