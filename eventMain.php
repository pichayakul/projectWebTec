<html>
    
<head>
    <?php include "database/epmtfafn_satta_db.php" ;?>
    <?php include "upload.php" ;?>
    <link rel="stylesheet" href="css/bootstrap.min.css"/> 
    <link href="css/eventMain.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"/>
    <meta http-equiv=Content-Type content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
</head>
<body id="body">
    
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
                    $priceStart=$row[$round]["price"];
                    $usernamePage=$row[$round]["username"];
                    $type=$row[$round]["type"];
                    $location=$row[$round]["location"];
                    $current=$row[$round]["current"];
                    $capacity=$row[$round]["capacity"];
                    $start_date_time=$row[$round]["start_date_time"];
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
            
                if (isset($_POST["T_Event"]) ){
                    
                        $c=$_POST["capacity"];
                        $p=$_POST["price"];
                    
                    $fi='';
                    foreach($_FILES["fileToUpload"]["name"] as $i => $name){
                        $fi.='webUpload/'.$title.'/organizerUpload'.'/'.$_FILES['fileToUpload']["name"][$i].',';
                    }
                    // echo $noevent;
                    // echo $username;
                    // echo $title;
                    // echo $type;
                    // echo $current;
                    // echo $c;
                    // echo $p;
                    // echo $fi;
                    // echo 'webUpload/'.$title.'/organizerUpload'.'/'.$_FILES['vdoUpload']["name"];
                    // echo $_POST["description"];
                    // echo date('Y-m-d h:i:s');
                    $start = $_POST['dateStart'].' '.$_POST['timeFrom'];
                    $end = $_POST['dateEnd'].' '.$_POST['timeTo'];
                    // echo "STARTTIME :".$start;
                    // echo "ENDTIME : ".$end;
                    // echo $_POST["location"];
                    // echo $_POST["precondition"];
                    $db->update_event(intval($noevent),$username,$title,$_POST["T_Event"],intval($current),intval($_POST["capacity"]),intval($_POST["price"])
                    ,$fi,'webUpload/'.$title.'/organizerUpload'.'/'.$_FILES['vdoUpload']["name"],$_POST["description"],date('Y-m-d h:i:s'),
                    $start,$end,$_POST["location"],$_POST["precondition"]);
                }
                if (isset($_POST["submitM"])){
                    $fi='';
                    foreach($_FILES["fileToUpload"]["name"] as $i => $name){
                        $fi.='webUpload/'.$title.'/organizerUpload'.'/'.$_FILES['fileToUpload']["name"][$i].',';
                    }
                    $op='';
                    foreach($_FILES["fileToUploadM"]["name"] as $i => $name){
                        $op.='webUpload/'.$title.'/organizerUpload'.'/'.$_FILES['fileToUploadM']["name"][$i].',';
                    }
                    $row = $db->get_eventmember_all($noevent);
                    $finish=0;
                    for ($i=0;$i<count($row);$i++){
                        if ($row[$i]["username"]==$username){
                            $db->update_eventmember(intval($noevent),$username,date('Y-m-d h:i:s'),$fi,$op,intval($_POST["price"]));
                            $finish=1;
                            break;
                        }
                    }
                    if ($finish==0){
                        $db->add_eventmember(intval($noevent),$username,date('Y-m-d h:i:s'),$fi,$op,intval($_POST["price"]));
                    }
                    
                }
            

        $db->closeDatabase();
        
    }
       ?>
        <div class="row">
            <div class="col-lg-1" ></div>
            <div id='background' class="background col-lg-10 img-fluid z-depth-4 " style="border-radius: 20px;padding-bottom:20px">
            <div class="row">
                <div class="col-lg-1"></div>
                <div class="col-lg-10">
                    <div>
                            <h2><?php 
                                echo $type.' : '.$title."(".$isMaxCapacity.") ".$current.'/'.$capacity.'</h2>' ;
                                
                                if ($username==$usernamePage)
                                {
                                    echo '
                                    <div class="container">
                                    <!-- Trigger the modal with a button -->
                                    <button type="button" class="btn btn-info btn-lg" style="text-align:right" data-toggle="modal" data-target="#myModal">Edit</button>
                                
                                    <!-- Modal -->
                                    <div class="modal fade" id="myModal" role="dialog" style="width:auto">
                                    <div class="modal-dialog" >
                                
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title"></h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="container" >
                                            <h2>Edit</h2>
                                            
                                            <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                            <input type="hidden" class="form-control" id="titleF"  name="title" value="'.$title.'" require>
                                            <div class="form-group">
                                                <label class="control-label col-sm-1" >Description:</label>
                                                <div class="col-sm-12">
                                                <textarea class="form-control" name="description" rows="5" id="comment" require>'.$description.'</textarea>
                                                </div>
                                                <label class="control-label col-sm-1" ></label>
                                            </div>
                                            <div class="form-group">
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
                                                <input type="text" class="form-control" id="location"  name="location" require>
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
                                                <input type="time" class="form-control" id="timeFrom"  name="timeFrom" require>
                                                
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
                                                    <div class="col-sm-10">
                                                    <div class="row">
                                                    <div class="col-sm-6"><input type="radio" name="T_Event" value="event">Event</div>
                                                    <div class="col-sm-6"><input type="radio" name="T_Event" value="seminar">Seminar</div>
                                                    </div>
                                                    <label class="control-label col-sm-1" ></label>
                                                    </div >
                                                
                                
                                            </div>
                                            <div class="form-group">
                                                                                                        <!-- <div style="margin-left:100px">\ -->
                                                    <label class="control-label col-sm-1" >Video:</label>
                                                    <div class="col-sm-offset-2 col-sm-10">
                                                    <input type="file" class="btn btn-default" name="vdoUpload"accept="video/*">
                                                </div>
                                                    <label class="control-label col-sm-1" >Image:</label>
                                                    <div class="col-sm-offset-2 col-sm-10">
                                                    <input type="file" class="btn btn-default" name="fileToUpload[]" multiple="multiple" accept="image/*">
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                <?php
                                                    $username=$_GET["username"];
                                                ?>
                                                <input type="hidden" name="username" value="<?php echo $username?>">
                                                <input type="submit" name="btnCreate" class="btn btn-default" value="Submit">
                                                </div>
                                            </div>
                                            </form>
                                            </div>
                                        </div>
                                
                                        </div>
                                
                                    </div>
                                    </div>
                                
                                </div>';
                                }
                                else{
                                    echo '<div class="container">
                                    <!-- Trigger the modal with a button -->
                                    <button type="button" class="btn btn-info btn-lg" style="text-align:right" data-toggle="modal" data-target="#myModal">BuyTicket</button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="myModal" role="dialog" style="width:auto">
                                    <div class="modal-dialog" >
                                
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title"></h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="container" >
                                            <h2>BuyTicket</h2>
                                            
                                            
                                            <div class="form-group">
                                                <div font-size:15px"><label class="control-label col-sm-10" >Total Amount : '.'<button class="btn btn-primary" onclick="plusMoney(-1)">-</button><div id="price" style="display:inline">'.$price.'</div><button class="btn btn-primary" onclick="plusMoney(1)">+</button></label></div>
                                                <div class="col-sm-10">
                                                <form method="post" enctype="multipart/form-data">
                                                PaymentFile : <input type="file" class="form-control" multiple="multiple" accept="image/*" style="margin-top:10" id="titleF"  name="fileToUpload[]">
                                                PreConditionFile : <input type="file" class="form-control" multiple="multiple" accept="image/*" style="margin-top:10" id="titleP"  name="fileToUploadM[]">
                                                <input type="hidden" name="username" value="'.$username.'">
                                                <input type="hidden" name="price" value="'.$price.'">
                                                <input type="hidden" name="title" value="'.$title.'">
                                                </div>
                                                <div class="col-sm-10">
                                                
                                                <input type="submit" class="btn btn-secondary active" style="margin-top:10;width:100px" name="submitM" value="submit">
                                                </div>
                                            </div>
                                            </form>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                    </div>';
                                }?>
                    </div>
                               <script>
                                   var price=0;
                                    function plusMoney(a){
                                        if (price==0){
                                            price = <?php echo $price?>;
                                        }
                                        
                                        
                                        var priceStart = <?php echo $priceStart?>;
                                        if  (a==1){
                                            
                                            price=price+priceStart;
                                        }
                                        else{
                                            price=price-priceStart;
                                            if (price<=0)
                                            {
                                                price=priceStart;
                                            }
                                        }
                                        document.getElementById('price').innerHTML=price;
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
                            รายละเอียด :
                            <div class="detail" style="margin-left:20px"><?php echo $description;?></div>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-10" style="background:black">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
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
                                            $content.='<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>';
                                            $contentSrc.='<div class="carousel-item active">
                                            <img class="d-block w-100" src="'.$path.'" style="width:100%; height: 400px;max-width:800px">
                                        </div>';
                                        }
                                        else{
                                            $content.='<li data-target="#carouselExampleIndicators" data-slide-to="'.$x.'"></li>';
                                            $contentSrc.='<div class="carousel-item">
                                            <img class="d-block w-100" src="'.$path.'" style="width:100%; height: 400px;max-width:800px">
                                        </div>';
                                        }
                                        
                                    }
                                    echo $content;
                                ?>
                            </ol>
                            <div class="carousel-inner">
                                <?php echo $contentSrc?>
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" style="max-width:600px" ></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" ></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-1"></div>
                    </div>
            
                    <div class="contain" style="text-align:center;">
                        
                        <div id='preCondition' class="box"  >
                        เงื่อนไข :
                            <div id='preConditionContent' class="detail" style="margin-left:20px">
                                <?php
                                    if ($max_count>0){
                                        $condition=$precondition;
                                    }
                                    else{
                                        $condition.="none";
                                    }
                                    echo $condition;
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="contain">
                        <div class="row">
                            <div class="col-lg-1"></div>
                            <div class="col-lg-10">
                    <div id="map" style="width:auto;height:400px;"></div>
                    <input id="pac-input" style="width:250px;margin-top:15px;margin-left:20px"class="controls" type="text" placeholder="Search Box" >
                                </div>
                                <div class="col-lg-1"></div>
                                </div>
                                </div>
                    
                </div>
                <div id='boxAlert'></div>
                <div id='boxBuyTicket'></div>
                <div id='boxSetting'></div>
                </div>
                <div class="col-lg-1"></div>
            </div>
            </div>
        </div>
    <script>
      function initAutocomplete() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -33.8688, lng: 151.2195},
          zoom: 13,
          mapTypeId: 'roadmap'
        });

        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
            var icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

            // Create a marker for each place.
            markers.push(new google.maps.Marker({
              map: map,
              icon: icon,
              title: place.name,
              position: place.geometry.location
            }));

            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);
          
        });
      }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCfk7eKoClwjzWQcxpZX6wRznS6_oRhS8U&libraries=places&callback=initAutocomplete"
         async defer>
    </script>
    <br>
    <div class="contain">
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-10" >
                            <center>
                                <div class="row">
                                    
                                            <div id='background' class="background col-lg-4 img-fluid z-depth-4 bottomBox">
                                            <h3><a id='btnWebBoard' class="btnMenu" href='nut.php?username=<?php echo $username?>&noevent=<?php echo $noevent?>'>Webboard</a></h3>If you have a question create the topic on the webborad.
                                            </div>
                                        <div id='background' class="background col-lg-4 img-fluid z-depth-4 bottomBox" >
                                            
                                                <h3>Location and DateTime</h3>
                                                <div id="location" ><i class="fa fa-map-marker" style="font-size:20px;"></i><?php echo " ".$location?></div>
                                                <div id="DateTime"><i class="fa fa-clock-o" style="font-size:15px;"></i><?php echo " ".$day."-".$month."-".$year." at ".$time?></div>
                                            
                                        </div>
                                        <div id='background' class="background col-lg-4 img-fluid z-depth-4 bottomBox" >
                                            <h3>About Organizer</h3>
                                            Username : <?php echo $usernamePage?>
                                        </div>
                                        </div>
                
                                </div>
                                </center>
                        </div>
                        <div class="col-lg-1"></div>
                    </div>
                    
                </div>
    
    
    
    
    </script>
    </script>
    <script src="./js/jquery-3.3.1.min.js"></script>
    <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <?php
            if ($uploadOk==0){
                    if ($username!=$usernamePage){
                        $report="Upload Failed.<br>".$report;
                    }
                    else{
                        $report="Updated Failed.<br>".$report;
                    }
                    
            }
            else{
                if ($username!=$usernamePage){
                    $report="Upload Success.<br>".$report;
                }
                else{
                    $report="Updated Success.<br>".$report;
                }
                
            }

            if ($report!=''){
                    echo '<div class="row">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4"><div class="alert alert-warning alert-dismissible fade show" role="alert" style="position:fixed;top:0px;">
                        '.$report.'<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    <div class="col-lg-4"></div>' ;
                }
    ?> 
    <?php unset($_POST)?>
    </body>
</html>