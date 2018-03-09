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
  </head>
  <body>
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
    function showContents($data){

      $round=0;
      $event = '';


        while ($round<count($data)){
          $name = $data[$round]["name"];
          $imagePath = $data[$round]["imagePath"];
          $imagePath = explode(",",$imagePath);
          $imagePath=$imagePath[0];
          $date_time = $data[$round]["start_date_time"];
          $location = $data[$round]["location"];
          $noevent = $data[$round]["noevent"];
          $username =  $data[$round]["username"];
          $allStart_date_time=explode(" ",$date_time);
          $date=explode("-",$allStart_date_time[0]);
          $year=$date[0];
          $month=$date[1];
          $day=$date[2];
          $timeD=explode(":",$allStart_date_time[1]);
          $time=$timeD[0].":".$timeD[1];

          $contents = '<div class="col-sm-6 col-md-4">
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
                              <i class="glyphicon glyphicon-calendar" style="font-size:20px;"></i>'.$day.''."/".''.$month.'/'.$year.'
                          </div>
                          <div class="text-ellipsis">
                              <i class="fa fa-clock-o" style="font-size:20px;"></i>'.$time.'
                          </div>

                          <div class="text-ellipsis">
                              <i class="fa fa-map-marker" style="font-size:20px;"></i>'.$location.'
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

      }


      ?>
      <div class="wrapper">

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
