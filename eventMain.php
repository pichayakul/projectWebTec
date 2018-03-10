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
    $report;
    $title='';
    $noevent;
    /**uploadOK =0 ;can't upload */
        if (isset($_GET["noevent"]))
        {
            $noevent=$_GET["noevent"];
            $username=$_GET["username"];
            $db = new Database();
            $db->openDatabase();
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
                    $ticket=1;
                    $usernamePage=$row[$round]["username"];
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
                        $fi='';
                        foreach($_FILES["fileToUpload"]["name"] as $i => $name){
                            $fi.='images/events/'.$title.'/organizerUpload'.'/'.$_FILES['fileToUpload']["name"][$i].',';
                        }
                        // echo $noevent;
                        // echo $username;
                        // echo $title;
                        // echo $type;
                        // echo $current;
                        // echo $c;
                        // echo $p;
                        // echo $fi;
                        // echo 'image/events/'.$title.'/organizerUpload'.'/'.$_FILES['vdoUpload']["name"];
                        // echo $_POST["description"];
                        // echo date('Y-m-d h:i:s');
                        $start = $_POST['dateStart'].' '.$_POST['timeFrom'];
                        $end = $_POST['dateEnd'].' '.$_POST['timeTo'];
                        $lat=$_POST["lat"];
                        $lon=$_POST["lon"];
                        // echo $lat,$lon;
                        // echo "noeleeeeee";
                        // echo $_POST["ticket"];
                        // echo "STARTTIME :".$start;
                        // echo "ENDTIME : ".$end;
                        // echo $_POST["location"];
                        // echo $_POST["precondition"];
                        if ($uploadOk==1){
                        $db->update_event(intval($noevent),$username,$title,$_POST["T_Event"],intval($current),intval($_POST["capacity"]),intval($_POST["price"])
                        ,$fi,'images/events/'.$title.'/organizerUpload'.'/'.$_FILES['vdoUpload']["name"],$_POST["description"],date('Y-m-d h:i:s'),
                        $start,$end,$_POST["location"],$_POST["precondition"],$lat,$lon);
                        }
                }
                if (isset($_POST["submitM"])){
                    $fi='';
                    foreach($_FILES["fileToUpload"]["name"] as $i => $name){
                        $fi.='images/events/'.$title.'/attendantUploads'.'/'.$username.'/payment'.'/'.$_FILES['fileToUpload']["name"][$i].',';
                    }
                    $op='';
                    foreach($_FILES["fileToUploadM"]["name"] as $i => $name){
                        $op.='images/events/'.$title.'/attendantUploads'.'/'.$username.'/preCondition'.'/'.$_FILES['fileToUploadM']["name"][$i].',';
                    }
                    $row = $db->get_eventmember_all($noevent);
                    $finish=0;
                    $ti = intval($_POST["ticket"]);

                    // echo $ti;
                    for ($i=0;$i<count($row);$i++){
                        if ($row[$i]["username"]==$username){
                            $db->update_eventmember(intval($noevent),$username,date('Y-m-d h:i:s'),$fi,$op,intval($_POST["ticket"]));
                            // echo $noevent;
                            // echo $usernamePage;
                            // echo $title;
                            // echo $type;

                            // echo $current+$ti;

                            // echo $capacity;
                            // echo $price;
                            // echo $imagePath;
                            // echo $vdoPath;
                            // echo $description;
                            // echo $create_date_time;
                            // echo $start_date_time;
                            // echo $end_date_time;
                            // echo $location;
                            // echo $precondition;
                            $db->update_event(intval($noevent),$usernamePage,$title,$type,$current+$ti,$capacity,$price,$imagePath,
                        $vdoPath,$description,$create_date_time,$start_date_time,$end_date_time,$location,$precondition,$lat,$lon);
                            $finish=1;
                            break;
                        }
                    }
                    if ($finish==0){
                        $db->add_eventmember(intval($noevent),$username,date('Y-m-d h:i:s'),$fi,$op,intval($_POST["ticket"]));
                        $db->update_event(intval($noevent),$usernamePage,$title,$type,$current+$ti,$capacity,$price,$imagePath,
                        $vdoPath,$description,$create_date_time,$start_date_time,$end_date_time,$location,$precondition,$lat,$lon);
                    }
                    $_POST=array();
                }
            }
        $db->closeDatabase();
        $db->openDatabase();
            $noevent=$_GET["noevent"];
            $username=$_GET["username"];
            $price=-99;
            $description='';
            $precondition='';
            $imagePath='';
            $noevent;
            $usernamePage='';

            $row = $db->get_event_and_seminar_all();
            $requestRow = $db->get_eventmember_all($noevent);
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
                    // echo $lat,$lon;
                    $priceStart=$row[$round]["price"];
                    $ticket=1;
                    $usernamePage=$row[$round]["username"];
                    $type=$row[$round]["type"];
                    $location=$row[$round]["location"];
                    $current=$row[$round]["current"];
                    $capacity=$row[$round]["capacity"];
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
            if ($current < $capacity){
                $isMaxCapacity="Avaliable";
            }
            else{
                $isMaxCapacity="Full";
            }
        }
        $db->closeDatabase();
       ?>
       <?php

        if ($username==$usernamePage)
        {

            echo '<div class="container">
            <!-- Trigger the modal with a button -->
            <button type="button" class="btn btn-info btn-lg" style="position:fixed;top:0%;left:50%;width:100;z-index:2" data-toggle="modal" data-target="#myModal">Edit</button>
            <button type="button" class="btn btn-info btn-lg" style="position:fixed;top:0%;left:50%;margin-left:100;width:fit-content;z-index:2" data-toggle="modal" data-target="#manageRequest">ManageRequest</button>

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
                            if ($requestRow[$round]["status"]=='accepted'){
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
                            
                            for ($co=count($arrayIma);$co>=0;$co--){
                                if ($co<count($arrayIma)-1){
                                    echo '<img class="" data-toggle="modal" data-target="#popup_img" width="100" height="50" src="'.$arrayIma[$co].'" />';
                                }
                            };
                            echo '</td>';
                            echo '<td>';

                            $arrayIma = explode(',',$requestRow[$round]["pre_path"]);

                            for ($co=count($arrayIma);$co>=0;$co--){
                                if ($co<count($arrayIma)-1){
                                    echo '<img class="" data-toggle="modal" data-target="#popup_img" width="100" height="50" src="'.$arrayIma[$co].'" />';
                                }
                            };
                            
                            echo '</td>';
                            // echo '<td>'.$requestRow[$round]["pre_path"].'</td>';
                             $dataRequest="'".$requestRow[$round]["username"]."',";
                            $dataRequest.="'".$requestRow[$round]["tickets"]."',";
                            $dataRequest.="'".$requestRow[$round]["request_date_time"]."',";
                            $dataRequest.="'".$requestRow[$round]["join_date_time"]."',";
                            $dataRequest.="'".$requestRow[$round]["payment_path"]."',";
                            $dataRequest.="'".$requestRow[$round]["pre_path"]."',";
                            $dataRequest.="'".$noevent."'";
                            
                            if ($requestRow[$round]["status"]=='accepted'){
                                echo '<td>accepted</td>';
                            }
                            else {
                                echo '<td><button type="button" class="btn btn-success" onclick="acceptRequest('.$dataRequest.')" >accept</button>
                                <button type="button" class="btn btn-danger" onclick="declineRequest('.$dataRequest.')" >decline</button>
                                </td>';
                                
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
                  <input type="hidden"  id="titleF"  name="title" value="'.$title.'" require>

                  <div class="form-group">
                      <label class="control-label col-sm-1" >Description:</label>
                      <div class="col-sm-12">
                      <textarea  name="description" class="form-control" rows="8" id="comment" require>'.$description.'</textarea>
                      </div>
                      <label class="control-label" ></label>
                  </div>
                  <div class="forn-group">
                      <label class="control-label col-sm-1" >Precondition:</label>
                      <div class="col-sm-12">
                      <input type="text" class="form-control" id="precondition"  name="precondition" value="'.$precondition.'" require>
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="control-label col-sm-1" >Capacity:</label>
                      <div class="col-sm-12">
                      <input type="number" class="form-control" id="capacity"  name="capacity" value="'.$capacity.'" require>
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="control-label col-sm-1" >Price:</label>
                      <div class="col-sm-12">
                      <input type="number" class="form-control" id="price"  name="price" value="'.$price.'" require>
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="control-label col-sm-1" >Location:</label>
                      <div class="col-sm-12"  style="margin-bottom:20px">
                      <input type="text" class="form-control" id="location"  name="location" value="'.$location.'" require>
                      </div>
                  </div>
                  <div class="form-group">
                        <label class="control-label col-sm-1" ></label>
                        <div class="col-sm-12">
                        <div id="map" style="width:auto;height:300px;"></div>
                        <input id="pac-input" style="width:250px;margin-top:15px;margin-left:10px"class="controls" type="text" placeholder="Search Box" >
                        </div>

                  </div>
                  <div class="form-group">
                      <label class="control-label col-sm-1" >StartDate:</label>
                      <div class="col-sm-12">
                      <input type="date" class="form-control" id="date"  name="dateStart" require>
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="control-label col-sm-1" >StartTime:</label>
                      <div class="col-sm-12">
                      <input type="time" class="form-control"  id="timeFrom"  name="timeFrom" require>

                      </div>
                      </div>
                      <div class="form-group">
                      <label class="control-label col-sm-1" >EndDate:</label>
                      <div class="col-sm-12">
                      <input type="date" class="form-control" id="date"  name="dateEnd" require>
                      </div>
                  </div>
                      <div class="form-group">

                      <label class="control-label col-sm-1" >EndTime:</label>
                      <div class="col-sm-12">
                      <input type="time" class="form-control" id="timeTo"  name="timeTo" require>

                      </div>
                  </div>
                  <div class="form-group">

                          <label class="control-label col-sm-1" >Type:</label>
                          <div class="col-sm-12" style="margin-left:30px">
                            <div class="row">
                                <div class="col-sm-8"><input type="radio"  name="T_Event" value="event">Event</div>
                                <div class="col-sm-8"><input type="radio" name="T_Event" value="seminar">Seminar</div>
                            </div>
                          </div >


                </div>
                  <div class="form-group">
                          <label class="control-label col-sm-1" >Video:</label>

                          <input type="file" class="form-control btn btn-default" name="vdoUpload"accept="video/*">

                          <label class="control-label col-sm-1" >Image:</label>

                          <input type="file" class="form-control btn btn-default" name="fileToUpload[]" multiple="multiple" accept="image/*">

                          <?php
                          $username=$_GET["username"];
                      ?>
                      <input type="hidden" name="username" value="<?php echo $username?>">
                      <input type="hidden" id="lat" name="lat">
                        <input type="hidden" id="lon" name="lon">



                      <div class="col-sm-10"></div>



                      </div>

                  </div>

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
                                echo '<div class="col-sm-0"></div><div class="col-sm-5"><h2>'.$title.'</h2>';
                                echo '<div style="font-size:20px"><div><i class="glyphicon glyphicon-user" style="margin-right:10px"></i>'.$current.'/'.$capacity;
                                echo '<span class="label label-default" style="margin-left:10px;margin-top:-5px">'.$isMaxCapacity."</span><br></div>" ;
                                echo '<i class="glyphicon glyphicon-calendar" style="margin-right:5px"></i>'." ".$day."/".$month."/".$year." to ".$dayE."/".$monthE."/".$yearE;
                                echo '<div id="DateTime"><i class="glyphicon glyphicon-time" style="margin-right:10px"></i>'.$time." - ".$timeEnd.'</div>';
                                echo '<i class="glyphicon glyphicon-info-sign" style="margin-right:10px"></i>'.$type.'</div><br>';
                                ?>
                                <?php

                                if ($username!=$usernamePage){
                                    echo '<div class="container">
                                    <!-- Trigger the modal with a button -->
                                    ';
                                    if ($isMaxCapacity=="Full"){
                                        echo '<button class="btn btn-info btn-lg disabled" style="text-align:center;margin-left:20px;width:180px;margin-bottom:20px">BuyTicket</button></div>';
                                    }
                                    else{


                                    echo '
                                    <button type="button" class="btn btn-info btn-lg" style="text-align:center;margin-left:20px;width:180px;margin-bottom:20px" data-toggle="modal" data-target="#myModal">BuyTicket</button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="myModal" role="dialog">
                                    <div class="modal-dialog" >

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">BuyTicket</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="" >
                                            <div font-size:15px"><label class="control-label col-sm-10" >Ticket : '.'<button class="btn btn-primary" onclick="plusMoney(-1)" style="margin-left:80px">-</button><div id="ticket" style="display:inline;margin-left:20px">'.$ticket.'</div><button class="btn btn-primary" onclick="plusMoney(1)" style="margin-left:20px">+</button></label></div>
                                            <div font-size:15px"><label class="control-label col-sm-10" >Total Amount : '.'<div id="price" style="display:inline;margin-left:80px">'.$price.'</div></label></div>
                                                <form id="BUYID"method="post" enctype="multipart/form-data">
                                                <div class="form-group">



                                                <label class="control-label col-sm-12" >PaymentFile :</label>
                                                <input type="file" class="form-control btn btn-default" multiple="multiple" accept="image/*" style="margin-top:10" id="titleF"  name="fileToUpload[]">
                                                <br>
                                                <label class="control-label col-sm-12" >PreConditionFile :
                                                </label><input type="file" class="form-control btn btn-default" multiple="multiple" accept="image/*" style="margin-top:10" id="titleP"  name="fileToUploadM[]">
                                                <input type="hidden" name="username" value="'.$username.'">
                                                <input type="hidden" id="ticketHidden" name="ticket">

                                                <input type="hidden" name="title" value="'.$title.'">

                                                <div class="col-sm-10"></div>


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
                    <div id="map2" style="width:auto;height:300px;"></div>
                    <div class="col-lg-2"></div><input id="pac-input2" style="width:250px;margin-top:15px;margin-left:10px"class="controls" type="text" placeholder="Search Box" ></div>
                    <div id='background' class="col-lg-4 img-fluid z-depth-4 bottomBox">
                                                <div id="location" style="font-size:20px;margin-top:30px" ><?php echo " ".$location?></div>


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
                                            <h3><a id='btnWebBoard' class="btnMenu" href='nut.php?username=<?php echo $username?>&noevent=<?php echo $noevent?>'>Webboard</a></h3>If you have a question create the topic on the webborad.
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

    <?php
            $report='<a href="#" class="close" data-dismiss="alert" style=";margin-top:-35px;" aria-label="close">&times;</a>'.$report;
            if (isset($_POST)){
                if ($uploadOk==0){
                        if ($username!=$usernamePage){

                            $report='<div class="alert alert-danger">'."Upload Failed.<br>".$report;

                        }
                        else{
                            $report='<div class="alert alert-danger">'."Updated Failed.<br>".$report;
                        }
                }
                else{
                    if ($username!=$usernamePage){
                        $report='<div class="alert alert-success">'."Upload Success.<br>".$report;
                    }
                    else{
                        $report='<div class="alert alert-success">'."Updated Success.<br>".$report;
                    }
                }
                if ($report!=''){

                    echo '<div style="top:0%;position:fixed;">'.$report.'</div>';
                    echo '</div>';



                    }
            }
    ?>
    <script>
        function uploadFile(){
            $.post("upload.php", { },function(data){

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
                                   noevent:$noevent}
              ,function(data) {
                var data = data.split('||splitIT||');
                document.getElementById('TableBODY').innerHTML=data[1];
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
                                   noevent:$noevent}
              ,function(data) {
                var data = data.split('||splitIT||');
                document.getElementById('TableBODY').innerHTML=data[1];
          });
      }
    </script>
    </body>
</html>
