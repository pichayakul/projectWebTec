<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <?php include "database/epmtfafn_satta_db.php" ;?>
    <?php include "./upload.php" ;?>

    <!-- <script src="js/jquery-3.3.1.min.js"></script> -->
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
    <!-- <link href="./css/bootstrap.min.css" rel="stylesheet"> -->


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link href="https://fonts.googleapis.com/css?family=Libre+Baskerville|Mitr|Nanum+Gothic|Noto+Serif|Ubuntu" rel="stylesheet">
  </head>
  <body onload="myFunction()" style="margin:0;" id ="event-body">
        <div id="headerID" style="background-color: white; box-shadow:0 0 10px;">
            <?php require './header.php';  ?>

        </div>

    <div id="min-loader">
  <div class="holder">
    <div class="box"></div>
  </div>
  <div class="holder">
    <div class="box"></div>
  </div>
  <div class="holder">
    <div class="box"></div>
  </div>
</div>



<script>
var myVar;

function myFunction() {
    myVar = setTimeout(showPage, 1500);
}

function showPage() {
  document.getElementById("min-loader").style.display = "none";
  document.getElementById("headerID").style.display = "block";
  document.getElementById("satta").style.display = "block";

}
</script>
<?php
$db = new Database();
$db->openDatabase();
        if (isset($_POST["btnCreate"])){

          // echo "aaaaaaaaaaaaaaa";
          date_default_timezone_set('Asia/Bangkok');
          $fi='';
          if (isset($_POST["linkForm"])){
            $linkForm = $_POST["linkForm"];
        }
        else{
            $linkForm = "";
        }

          foreach($_FILES["fileToUpload"]["name"] as $i => $name){
            $fi.='images/events/'.$_POST["title"].'/organizerUpload'.'/'.$_FILES['fileToUpload']["name"][$i].',';
          }
          $start = $_POST['dateStart'].' '.$_POST['timeFrom'];
          $end = $_POST['dateEnd'].' '.$_POST['timeTo'];
          $username=$_SESSION["username"];
          if ($uploadOk==1){

            $db->create_event($username,$_POST["title"],$_POST["T_Event"],0,intval($_POST["capacity"]),intval($_POST["price"]),
            $fi,'images/events/'.$_POST["title"].'/organizerUpload'.'/'.$_FILES['vdoUpload']["name"],$_POST["description"],date('Y-m-d h:i:s'),
            $start,$end,$_POST["location"],$_POST["precondition"],0,0,$_POST["lat"],$_POST["lon"],$linkForm);

          }




        $db->closeDatabase();
        $db->openDatabase();
        $imagePath='';
        $date_time = '';
        $name = '';
        $location = '';

        $_POST["btnCreate"]=array();
        $db->closeDatabase();
}
    ?>



    <?php
    // $title='';
    //     if ($_SERVER["REQUEST_METHOD"] == "GET")
    //     {
    //         $title=$_GET["title"];
    //         $username=$_GET["username"];
    //     }


        $db->openDatabase();

        $imagePath='';
        $date_time = '';
        $name = '';
        $location = '';

        $eventAll = $db->get_event_available_all() ;
        $seminarAll =$db->get_seminar_available_all();
        $eventsSort = $db->get_event_and_seminar_sort_desc_alive();
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

        function showContents($data){
          $round=0;
          $event = '';
          $lenth = count($data);

          if($lenth>6){
            $lenth = 6;

          }
          while ($round<$lenth){
            $name = $data[$round]["name"];
            $imagePath = $data[$round]["imagePath"];
            $imagePath = explode(",",$imagePath);
            $imagePath=$imagePath[0];
            $date_time = $data[$round]["start_date_time"];
            $end_date = $data[$round]["end_date_time"];
            $location = $data[$round]["location"];
            $noevent = $data[$round]["noevent"];
            $username =  $data[$round]["username"];
            $sdate = DateEng($date_time);
            $endae = DateEng($end_date);




            $contents = '<div class="col-sm-6 col-md-4" >
                            <div class="event-container animate-bottom " style = "box-shadow:0 0 3px;" >

                              <a href = "./eventMain.php?noevent='.$noevent.'" >
                                <div class="thumbnail" style="background-color:white;">
                                  <div class="event-image" >
                                    <img src="'.$imagePath.'"  >
                                  </div>
                                  <div class="caption">
                                    <div class="text-ellipsis">
                                      <strong>'.$name.'</strong>
                                    </div>
                                    <div class="text-ellipsis">
                                      <i class="glyphicon glyphicon-calendar" style="font-size:20px;"></i> '.$sdate[0].' - '.$endae[0].'
                                    </div>
                                    <div class="text-ellipsis">
                                      <i class="fa fa-clock-o" style="font-size:20px; "></i>   '.$sdate[1].' - '.$endae[1].'
                                    </div>

                                    <div class="text-ellipsis">
                                      <i class="fa fa-map-marker" style="font-size:20px;margin-left:2px;"></i>            '.$location.'
                                    </div>
                                  </div>
                                </div>
                              </a>
                            </div>
                          </div>';
                  $event = $event.$contents;
              $round++;
          }


          return  $event;
        }


        $events = showContents($eventAll);
        $seminars = showContents($seminarAll);
        $db->closeDatabase();

        // echo $numslide;
        // echo $numRecom;


    ?>
  <div class="animate-bottom" id="satta" style="margin-top:-18px;" >




  <div class="wrapper" >


    <!--  -->
    <div class="satta-event animatebottom" >
      <div class="container ">


        <span style="font-size:40px; font-weight:bold; color:white; margin-left:25px;">Recommend</span>

        <div id="myCarousel" class="carousel slide" data-ride="carousel">

           <?php
           $maxArray = count($eventsSort);
           $maxcount =  ceil(count($eventsSort)/3);
           $arrayCount=0;
           $maxcountFor=0;

           if ($maxcount>3){
             $maxcount=3;
           }

           $contents =  '';
           $contentsSrc = '';

           while ($maxcountFor<$maxcount) {

             if($maxcountFor==0){
               $contents.='<li data-target="#myCarousel" data-slide-to ="'.$maxcountFor.'" class = "active" ></li>';
               $f = '<div class = "item active">';
             }
             else {
               $contents.='<li data-target="#myCarousel" data-slide-to ="'.$maxcountFor.'" ></li>';
               $f = '<div class = "item">';


             }
             // $detail = '<img src="'.$imagePath.'" style="100%">';
             $detail='';
             $cunt=0;
             while ($arrayCount<$maxArray){
               $name = $eventsSort[$arrayCount]["name"];
               $imagePath = $eventsSort[$arrayCount]["imagePath"];
               $imagePath = explode(",",$imagePath);
               $imagePath=$imagePath[0];
               $date_time = $eventsSort[$arrayCount]["start_date_time"];
               $end_date = $eventsSort[$arrayCount]["end_date_time"];
               $location = $eventsSort[$arrayCount]["location"];
               $noevent = $eventsSort[$arrayCount]["noevent"];
               $username =  $eventsSort[$arrayCount]["username"];
               $sdate = DateEng($date_time);
               $endae = DateEng($end_date);

               $detail .= '<div class="col-sm-6 col-md-4 " style = "margin-top:25px;">
                               <div class="event-container">
                                 <a href = "./eventMain.php?noevent='.$eventsSort[$arrayCount]["noevent"].'">
                                   <div class="thumbnail" style="background-color:white;">
                                     <div class="event-image" >
                                       <img src="'.$imagePath.'">
                                     </div>
                                     <div class="caption">
                                       <div class="text-ellipsis">
                                         <strong>'.$name.'</strong>
                                       </div>
                                       <div class="text-ellipsis">
                                         <i class="glyphicon glyphicon-calendar" style="font-size:20px;"></i> '.$sdate[0].' - '.$endae[0].'
                                       </div>
                                       <div class="text-ellipsis">
                                         <i class="fa fa-clock-o" style="font-size:20px;"></i> '.$sdate[1].' - '.$endae[1].'
                                       </div>

                                       <div class="text-ellipsis">
                                         <i class="fa fa-map-marker" style="font-size:20px;margin-left:2px;"></i>            '.$location.'
                                       </div>
                                     </div>
                                   </div>
                                 </a>
                               </div>
                             </div>';
                             $cunt++;
                             $arrayCount++;
                             if ($cunt==3){
                               break;
                             }
             }

             $s='</div>';
             $contentsSrc.=$f.$detail.$s;

             $maxcountFor++;

           }





            ?>
          <!-- Indicators -->
          <!-- <ol class="carousel-indicators" >
            <?php echo $contents?>;
          </ol> -->

          <!-- Wrapper for slides -->
          <div class="carousel-inner">
            <?php echo $contentsSrc?>;
          </div>


          <!-- Left and right controls -->
          <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div>
      </div>

     </div>



<!-- featured-event -->

      <div class="page-wrapper animate-bottom">
        <div class="container">
          <br>
          <br>
          <?php
            $createBtn = '<button type="button" class="btn btn-danger btn-lg"  data-toggle="modal" data-target="#CREATE">Create event</button>';
            if(isset($_SESSION['username'])){
              if ($_SESSION['position']!="attendant") {
                echo $createBtn;
                # code...
              }

            }


           ?>
           <br>
          <div class="category-container">
            <div class="page-header">
              <div class="btn-toolbar pull-right">
                  <form class="" action="viewAll.php" method="post">
                        <input type="hidden" value="event" name="type">
                        <input type="submit" class = "btn btn-default" name="typeView" value="View All" >

                  </form>



              </div>
              <h2>Events</h2>
              <hr style="height:5px;  background-color:#FF6666	;">
            </div>
            <div class="row">
              <?php echo $events ?>

            </div>

          </div>
          <div class="category-container">
            <div class="page-header">
              <div class="btn-toolbar pull-right">
                <form class="" action="viewAll.php" method="post">
                      <input type="hidden" value="seminar" name="type">
                      <input type="submit" class = "btn btn-default" name="typeView" value="View All">

                </form>


              </div>
              <h2>Seminars</h2>
                <hr style="height:5px; background-color:#FF6666;">

            </div>
            <div class="row" >
              <?php echo $seminars ?>

            </div>

          </div>


        </div>

      </div>
    <!-- button search -->
    <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->

      <div class="modal-content">

        <div class="modal-body">
          <form action="./viewAll.php" method="post">
            <div class="input-group">
              <input type="hidden" value="search" name="type">
              <input type="text" class="form-control" placeholder="Search" name="search">
              <div class="input-group-btn">
                <button class="btn btn-default"  type="submit"><i class="glyphicon glyphicon-search"></i></button>
              </div>
            </div>
          </form>
        </div>

      </div>

    </div>
  </div>

</div>
<!-- end search -->

</div>

</div>

      <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
          <?php $lat=15.1241123;
                $lon=103.123987;
          ?>


          <script>
          var map;


        var markers = [];
        function initAutocomplete() {
          var myOptions = {
          zoom: 5,
          center: new google.maps.LatLng(<?php echo $lat?>,<?php echo $lon ?>),
          mapTypeId: google.maps.MapTypeId.ROADMAP
          };

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
              document.getElementById("lat").value = location.lat();
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



    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAzbSkmik7WsO98aQ6Lqg5LrirotjlnjVE&libraries=places&callback=initAutocomplete"
  type="text/javascript">
  </script>

<div class="container">
<!-- Trigger the modal with a button -->


<!-- Modal -->
<div class="modal fade" id="CREATE" role="dialog">
  <div class="modal-dialog" >

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Create Event</h4>
      </div>
      <div class="modal-body">
      <div class="" >

      <form id="createID" method="post" enctype="multipart/form-data">

      <div class="form-group">
          <label class="control-label col-sm-1" >Title:</label>
          <div class="col-sm-12">
          <input type="input" class="form-control" id="titleF"  name="title" required="">
          </div>
          <label class="control-label" ></label>
      </div>
      <div class="form-group">
          <label class="control-label col-sm-1" >Description:</label>
          <div class="col-sm-12">
          <textarea  name="description" class="form-control" rows="8" id="comment" required=""></textarea>
          </div>
          <label class="control-label" ></label>
      </div>
      <div class="forn-group">
          <label class="control-label col-sm-1" >Precondition:</label>
          <div class="col-sm-12">
          <input type="text" class="form-control" id="precondition"  name="precondition" required="">
          </div>
      </div>
      <div class="form-group">
          <label class="control-label col-sm-1" >Capacity:</label>
          <div class="col-sm-12">
          <input type="number" min=0 class="form-control" id="capacity"  name="capacity" required="">
          </div>
      </div>
      <div class="form-group">
          <label class="control-label col-sm-1" >Price:</label>
          <div class="col-sm-12">
          <input type="number" min=0 class="form-control" id="price"  name="price" required="">
          </div>
      </div>
      <div class="form-group">
          <label class="control-label col-sm-1" >Location:</label>
          <div class="col-sm-12"  style="margin-bottom:20px">
          <input type="text" class="form-control" id="location"  name="location" required="">
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
          <input type="date" class="form-control" id="dateS"  name="dateStart" required="">
          </div>
      </div>
      <div class="form-group">
          <label class="control-label col-sm-1" >StartTime:</label>
          <div class="col-sm-12">
          <input type="time" class="form-control"  id="timeFrom"  name="timeFrom" required="">

          </div>
          </div>
          <div class="form-group">
          <label class="control-label col-sm-1" >EndDate:</label>
          <div class="col-sm-12">
          <input type="date" class="form-control" id="date"  name="dateEnd" required="">
          </div>
      </div>
          <div class="form-group">

          <label class="control-label col-sm-1" >EndTime:</label>
          <div class="col-sm-12">
          <input type="time" class="form-control" id="timeTo"  name="timeTo" required="">

          </div>
      </div>
      <div class="form-group">

              <label class="control-label col-sm-1" >Type:</label>
              <div class="col-sm-12" style="margin-left:30px">
                <div class="row" >
                    <div class="col-sm-8"><input type="radio" checked="checked" name="T_Event" value="event">Event</div>
                    <div class="col-sm-8"><input type="radio" name="T_Event" value="seminar">Seminar</div>
                </div>
              </div >


    </div>
      <div class="form-group">
              <label class="control-label col-sm-1" >Video:</label>

              <input type="file" class="form-control btn btn-default" name="vdoUpload"accept="video/*" required="">

              <label class="control-label col-sm-1" >Image:</label>

              <input type="file" class="form-control btn btn-default" name="fileToUpload[]" multiple="multiple" accept="image/*" required="">
</div>
<div class="form-group">
                    <label class="control-label col-sm-12">Form link (To collect comments from attandants) :</label>
                      <div class="col-sm-12">
                        The link to create a form <a href="https://docs.google.com/forms" target="_blank">Google form</a></div>

                          <input class="form-control" type="text" name="linkForm">
                      </div>


                  </div>

          <input type="hidden" name="username" value="">
          <input type="hidden" id="lat" name="lat" value="15.1241123">
            <input type="hidden" id="lon" name="lon" value="103.123987">
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
</div>
          </div>
<!-- wrapper -->
<script src="./js/jquery-3.3.1.min.js"></script>
<script src="./js/popper.min.js"></script>
<script src="./js/bootstrap.min.js"></script>

  </body>
</html>
