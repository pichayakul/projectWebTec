<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <?php include "database/epmtfafn_satta_db.php" ;?>
    <script src="js/jquery-3.3.1.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" type="text/css" href="css/showAll.css">
    <link href="https://fonts.googleapis.com/css?family=Libre+Baskerville|Mitr|Nanum+Gothic|Noto+Serif|Ubuntu" rel="stylesheet">
  </head>
  <body onload="myFunction()" style="margin:0; font-family: 'Libre Baskerville', serif;
font-family: 'Mitr', sans-serif;"" id ="event-body">
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
    myVar = setTimeout(showPage, 3000);
}

function showPage() {
  document.getElementById("min-loader").style.display = "none";
  document.getElementById("satta").style.display = "block";
  document.getElementById("event-body").style.background="whitesmoke";
}
</script>


    <?php
    $db = new Database();
    $db->openDatabase();

    $imagePath='';
    $date_time = '';
    $name = '';
    $location = '';
    $type = '';
    $eventAll = $db->get_event_available_all() ;
    $seminarAll =$db->get_seminar_available_all();


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
    function show_arive($data,$text)
    {
      $round=0;
      $event = '';
      $count = 0;

        while ($round<count($data)){
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
          $type = $data[$round]["type"];

          if(strpos($name,$text) !== false || strpos($location,$text) !==false || strpos($username,$text) !==false || strpos($type,$text)!==false){

            $contents = '<div class="col-sm-6 col-md-4 animate-bottom">
                    <div class="event-container style = "box-shadow:0 0 3px;">

                    <a href = "./eventMain.php?noevent='.$noevent.'&username='.$username.'">
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
                                <i class="fa fa-clock-o" style="font-size:20px;"></i>   '.$sdate[1].' - '.$endae[1].'
                            </div>

                            <div class="text-ellipsis">
                                <i class="fa fa-map-marker" style="font-size:20px; margin-Left:2px;"></i>  '.$location.'
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            </div>';

              $event = $event.$contents;
              $count = $count+1;



          }

            $round++;
    }
    return  array($event,$count);
  }
    function showContents($data){

      $round=0;
      $event = '';


        while ($round<count($data)){
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

          $contents = '<div class="col-sm-6 col-md-4 animate-bottom">
                  <div class="event-container"  style = "box-shadow:0 0 3px;">

                  <a href = "./eventMain.php?noevent='.$noevent.'&username='.$username.'">
                  <div class="thumbnail" style="background-color:white;">
                      <div class="event-image" >
                          <img src="'.$imagePath.'"">
                      </div>
                      <div class="caption">
                          <div class="text-ellipsis">
                              <strong>'.$name.'</strong>
                          </div>
                          <div class="text-ellipsis">
                              <i class="glyphicon glyphicon-calendar" style="font-size:20px;"></i> '.$sdate[0].' - '.$endae[0].'
                          </div>
                          <div class="text-ellipsis">
                              <i class="fa fa-clock-o" style="font-size:20px;"></i>   '.$sdate[1].' - '.$endae[1].'
                          </div>

                          <div class="text-ellipsis">
                              <i class="fa fa-map-marker" style="font-size:20px; margin-Left:2px;"></i>  '.$location.'
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
        $db->closeDatabase();
        if($_SERVER["REQUEST_METHOD"]=="POST"){

          if (isset($_POST["type"])){
            if ($_POST["type"]=="event"){
                 $events = showContents($eventAll);

                 $type = 'Events';


            }
            else if($_POST["type"]=="seminar"){
                $events = showContents($seminarAll);
                $type = 'Seminars';
            # code...
          }
          elseif ($_POST["type"]=="search") {
                  $type = "";
                 if($_POST["search"]!=""){
                   $text = $_POST["search"];
                   $max = count($eventAll) + count($seminarAll);
                   $events_aliv = show_arive($eventAll,$_POST["search"]);
                   $seminar_aliv  = show_arive($seminarAll,$_POST["search"]);
                   $num = $events_aliv[1]+$seminar_aliv[1];
                   $events = $events_aliv[0].$seminar_aliv[0];
                   $type = " $num result for  '$text' ";
                 }
                 else{
                      $num = count($eventAll)+count($seminarAll);
                      $findevent = showContents($eventAll);
                      $findseminars = showContents($seminarAll);
                      $events = $findevent.$findseminars;
                      $type = " $num result for ' ' ";



                 }

            # code...
          }
        }

      }


      ?>
      <div class="wrapper animate-bottom" id="satta">
        <?php require './header.php';  ?>


     <div class="satta-event" style="margin-top:-18px;">
       <div class="container">
              <br>
              <br>
              <h1><?php echo $type ?></h1>



       </div>

     </div>
     <div class="page-wrapper" style="margin-top:40px;">
       <div class="container">
         <div class="category-container">
            <div class="row">
              <?php
                if (isset($events)){
                echo $events;
              }


              ?>

            </div>

           </div>

         </div>

       </div>

     </div>


  </body>
</html>
