<!DOCTYPE html>
<html>
<head>
	<title>Home Page</title>
	<meta charset="utf-8">
</head>
<?php require 'header.php';?>
 <body id="body">

    <?php
    
    // $title='';
    
        $report;
        if ($_SERVER["REQUEST_METHOD"] == "GET")
        {
    //         $title=$_GET["title"];
            $username=$_GET["username"];
        }
        
        require './database/epmtfafn_satta_db.php';
        $db = new Database();
        $db->openDatabase();

        $imagePath='';
        $date_time = '';
        $name = '';
        $location = '';

        $eventAll = $db->get_event_all();
        $seminarAll =$db->get_seminar_all();
        function randContents($data){
          if(count($data)>6){
            $data = array_rand($data,6);
          }
          else{
            $data = array_rand($data,count($data));
          }
          return $data;
        }
        function showContents($data,$rand){
          $round=0;
          $event = '';
          while ($round<count($rand)){
            $imagePath = $data[$rand[$round]]["imagePath"];
            $imagePath = explode(",",$imagePath);
            $imagePath=$imagePath[0];
            $date_time = $data[$rand[$round]]["start_date_time"];
            $location = $data[$rand[$round]]["location"];
            $noevent = $data[$rand[$round]]["noevent"];
            $name=$data[$rand[$round]]["name"];
            $usernamePage =  $data[$rand[$round]]["username"];
            $contents = '
            <div class="event-container" style="height: auto">

                    <a href = "./eventMain.php?noevent='.$noevent.'&username='.$usernamePage.'">
                    <div class="thumbnail">
                        <div class="event-image">
                            <img src="'.$imagePath.'">
                        </div>
                        <div class="caption" style="margin-top:20px">
                            <div class="text-ellipsis">
                                <strong>'.$name.'</strong>
                            </div>
                            <div class="text-ellipsis">
                                <i class="fa fa-clock-o" style="font-size:20px;"></i>'.$date_time.'
                            </div>
                            <div class="text-ellipsis">
                                <i class="fa fa-map-marker" style="font-size:20px;"></i>'.$location.'
                            </div>
                        </div>
                    </div>
                </a>
            </div>';
                  $event = $event.$contents;
              $round++;
          }
          return  $event;
        }
        if (isset($_POST["btnCreate"])){
          date_default_timezone_set('Asia/Bangkok');
          $fi='';
          foreach($_FILES["fileToUpload"]["name"] as $i => $name){
            $fi.='organizer/'.$_FILES['fileToUpload']["name"][$i].',';
          }
          
          $db->create_event($username,$_POST["title"],$_POST["type"],0,$_POST["capacity"],$_POST["price"],
          $fi,'organizer/'.$_FILES['vdoUpload']["name"],$_POST["description"],date('Y-m-d h:i:s'),
          $_POST['timeFrom'],$_POST['timeTo'],$_POST["location"],$_POST["precondition"]);
          
        }
        // $eventShow = randContents($eventAll);
        // $seminarShow = randContents($seminarAll);
        // $events = showContents($eventAll,$eventShow);
        // $seminars = showContents($seminarAll,$seminarShow);
        $db->closeDatabase();

    ?>
      <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
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
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAzbSkmik7WsO98aQ6Lqg5LrirotjlnjVE&libraries=places&callback=initAutocomplete"
  type="text/javascript"></script>
            <div class="blog" >
              <h1>Event</h1>
              <div class="more" style="margin-top:-70px">
                <a href="allEvent.php">view all</a>
              </div>
              <?php echo '<div class="row">'.$events.'</div>' ?>
            </div>
            <div class="blog">
              <h1>Seminar</h1>
              <div class="more" style="margin-top:-70px">
                <a href="allSeminar.php">view all</a>
              </div>
              <?php  echo $seminars ?>
            </div>
            <?php
              if ($report!=''){
                echo '<div class="row">
                <div class="col-lg-4"></div>
                <div class="col-lg-4"><div class="alert alert-warning alert-dismissible fade show" role="alert" style="position:fixed;top:0px;">
    '.$report.'<button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
                <div class="col-lg-4"></div>' ;
                $report='';echo $report;unset($_POST);
                unset($_REQUEST);;
              } ?>
            
            
    </div>
  
</div>
    

            <div class="container">
    <!-- Trigger the modal with a button -->
    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>

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
              <h2>Create Event</h2>
              <form class="form-horizontal" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label class="control-label col-sm-1" >Title:</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="titleF"  name="title">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-1" >Description:</label>
                <div class="col-sm-12">
                  <textarea class="form-control" name="description" rows="5" id="comment"></textarea>
                </div>
                <label class="control-label col-sm-1" ></label>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-1" >Precondition:</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="precondition"  name="precondition">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-1" >Capacity:</label>
                <div class="col-sm-12">
                  <input type="number" class="form-control" id="capacity"  name="capacity">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-1" >Price:</label>
                <div class="col-sm-12">
                  <input type="number" class="form-control" id="price"  name="price">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-1" >Location:</label>
                <div class="col-sm-12"  style="margin-bottom:20px">
                  <input type="text" class="form-control" id="location"  name="location">
                </div>
                <div id="map" style="width:auto;height:400px;"></div>
                
                  <input id="pac-input" class="controls" type="text" placeholder="Search Box" style="z-index:2000px;width:200px;margin-top:20px;margin-left:10px">
              </div>
              <div class="form-group">
                <label class="control-label col-sm-1" >Date:</label>
                <div class="col-sm-12">
                  <input type="date" class="form-control" id="date"  name="date">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-1" >StartTime:</label>
                <div class="col-sm-12">
                  <input type="time" class="form-control" id="timeFrom"  name="timeFrom">
                  
                </div>
                <div class="form-group">
                <label class="control-label col-sm-1" >EndTime:</label>
                <div class="col-sm-12">
                  <input type="time" class="form-control" id="timeTo"  name="timeTo">
                  
                </div>
              </div>
              <div class="form-group">

                    <label class="control-label col-sm-1" >Type:</label>
                    <div class="col-sm-10">
                      <div class="row">
                    <div class="col-sm-6"><input type="radio" name="type" value="Radio 1">Event</div>
                      <div class="col-sm-6"><input type="radio" name="type" value="Radio 2">Seminar</div>
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
                                                            <!-- <input type="submit" value="Change"  name="btnSetting" style="margin-top:10px;margin-left:-30px;width:100px;">\ -->
                                                            <!-- </form>' -->
              </div>
              
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <?php
                    $username=$_GET["username"];
                  ?>
                  <input type="hidden" name="username" value="<?php echo $username?>">
                  <button type="submitMain" name="btnCreate" class="btn btn-default">Submit</button>
                </div>
              </div>
              </form>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
          </div>
          <div class="col-lg-1"></div>
          
        </div>
        <script src="./js/jquery-3.3.1.min.js"></script>
        <script src="./js/popper.min.js"></script>
        <script src="./js/bootstrap.min.js"></script>
        
  </body>
</html>
