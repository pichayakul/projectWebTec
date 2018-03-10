<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <?php include "epmtfafn_satta_db.php" ;?>
    <script src="js/jquery-3.3.1.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" type="text/css" href="css/showAll.css">
    <link href="https://fonts.googleapis.com/css?family=Libre+Baskerville|Mitr|Nanum+Gothic|Noto+Serif|Ubuntu" rel="stylesheet">
  </head>
  <body onload="myFunction()" style="margin:0;" id ="event-body">
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


        while ($round<count($data)){
          $name = $data[count($data)-1-$round]["name"];
          $imagePath = $data[count($data)-1-$round]["imagePath"];
          $imagePath = explode(",",$imagePath);
          $imagePath=$imagePath[0];
          $date_time = $data[count($data)-1-$round]["start_date_time"];
          $end_date = $data[count($data)-1-$round]["end_date_time"];
          $location = $data[count($data)-1-$round]["location"];
          $noevent = $data[count($data)-1-$round]["noevent"];
          $username =  $data[count($data)-1-$round]["username"];
          $sdate = DateEng($date_time);
          $endae = DateEng($end_date);

          if(strpos($name,$text) !== false || strpos($location,$text) !==false || strpos($username,$text) !==false){

            $contents = '<div class="col-sm-6 col-md-4 animate-bottom">
                    <div class="event-container">

                    <a href = "./eventMain.php?noevent='.$noevent.'&username='.$username.'">
                    <div class="thumbnail" >
                        <div class="event-image" >
                            <img src='.$imagePath.'  >
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



          }



            $round++;
    }
    return $event;
  }
    function showContents($data){

      $round=0;
      $event = '';


        while ($round<count($data)){
          $name = $data[count($data)-1-$round]["name"];
          $imagePath = $data[count($data)-1-$round]["imagePath"];
          $imagePath = explode(",",$imagePath);
          $imagePath=$imagePath[0];
          $date_time = $data[count($data)-1-$round]["start_date_time"];
          $end_date = $data[count($data)-1-$round]["end_date_time"];
          $location = $data[count($data)-1-$round]["location"];
          $noevent = $data[count($data)-1-$round]["noevent"];
          $username =  $data[count($data)-1-$round]["username"];
          $sdate = DateEng($date_time);
          $endae = DateEng($end_date);

          $contents = '<div class="col-sm-6 col-md-4 animate-bottom">
                  <div class="event-container"  style = "box-shadow:0 0 5px;">

                  <a href = "./eventMain.php?noevent='.$noevent.'&username='.$username.'">
                  <div class="thumbnail" >
                      <div class="event-image" >
                          <img src='.$imagePath.'  >
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
                $max = count($eventAll) + count($seminarAll);
                $type = "Result";
                $events_aliv = show_arive($eventAll,$_POST["search"]);
                $seminar_aliv  = show_arive($seminarAll,$_POST["search"]);
                $events = $events_aliv.$seminar_aliv;

            # code...
          }

      }


      ?>
      <div class="wrapper animate-bottom" id="satta">

     <div class="satta-event">
       <div class="container">

              <h1><?php echo $type ?></h1>



       </div>

     </div>
     <div class="page-wrapper" style="margin-top:40px;">
       <div class="container">
         <div class="category-container">
            <div class="row">
              <?php echo $events ?>

            </div>

           </div>

         </div>

       </div>

     </div>


  </body>
</html>
