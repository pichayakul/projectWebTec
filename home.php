<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <?php include "database/epmtfafn_satta_db.php" ;?>
    <!-- <script src="js/jquery-3.3.1.min.js"></script> -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" type="text/css" href="css/main.css">



  </head>
  <body>
    <?php
    // $title='';
    //     if ($_SERVER["REQUEST_METHOD"] == "GET")
    //     {
    //         $title=$_GET["title"];
    //         $username=$_GET["username"];
    //     }

        $db = new Database();
        $db->openDatabase();

        $imagePath='';
        $date_time = '';
        $name = '';
        $location = '';

        $eventAll = $db->get_event_available_all() ;
        $seminarAll =$db->get_seminar_available_all();
        $eventsSort = $db->get_event_and_seminar_sort_desc_alive();

        function showContents($data){
          $round=0;
          $event = '';
          if(count($data)<6){
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
                                        <i class="glyphicon glyphicon-calendar" style="font-size:20px; margin-left:10px;"></i>'.$day.''."/".''.$month.'/'.$year.'
                                      </div>
                                      <div class="text-ellipsis">
                                        <i class="fa fa-clock-o" style="font-size:20px; margin-left:10px;"></i>'.$time.'
                                      </div>

                                      <div class="text-ellipsis">
                                        <i class="fa fa-map-marker" style="font-size:20px; margin-left:10px;"></i>'.$location.'
                                      </div>
                                    </div>
                                  </div>
                                </a>
                              </div>
                            </div>';
                    $event = $event.$contents;
                $round++;
            }

          }
          else {
            while ($round<6){
              $name = $data[count($data)-1-$round]["name"];
              $imagePath = $data[count($data)-1-$round]["imagePath"];
              $imagePath = explode(",",$imagePath);
              $imagePath=$imagePath[0];
              $date_time = $data[count($data)-1-$round]["start_date_time"];
              $location = $data[count($data)-1-$round]["location"];
              $noevent = $data[count($data)-1-$round]["noevent"];
              $username =  $data[count($data)-1-$round]["username"];
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
        }

          return  $event;
        }


        $events = showContents($eventAll);
        $seminars = showContents($seminarAll);
        $db->closeDatabase();

        // echo $numslide;
        // echo $numRecom;


    ?>
  <div id="wrapper">


    <!--  -->
    <div class="satta-event" >
      <div class="container">
        <h1>แนะนำ</h1>
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
           <?php
           $maxArray = count($eventsSort);
           $maxcount =  intval(count($eventsSort)/3);
           $arrayCount=0;
           $maxcountFor=0;
           if ($maxcount>3){
             $maxcount=3;
           }
           $contents =  '';
           $contentsSrc = '';
           while ($maxcountFor<$maxcount) {

             if($maxcountFor==0){
               $contents.='<li data-target="#myCarousel" data-slide-to ="'.$maxcountFor.'" class = "active"></li>';
               $f = '<div class = "item active">';
             }
             else {
               $contents.='<li data-target="#myCarousel" data-slide-to ="'.$maxcountFor.'"></li>';
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
               $location = $eventsSort[$arrayCount]["location"];
               $noevent = $eventsSort[$arrayCount]["noevent"];
               $username =  $eventsSort[$arrayCount]["username"];
               $allStart_date_time=explode(" ",$date_time);
               $date=explode("-",$allStart_date_time[0]);
               $year=$date[0];
               $month=$date[1];
               $day=$date[2];
               $timeD=explode(":",$allStart_date_time[1]);
               $time=$timeD[0].":".$timeD[1];
               $detail .= '<div class="col-sm-6 col-md-4" style = "margin-top:25px;">
                               <div class="event-container">
                                 <a href = "./eventMain.php?noevent='.$eventsSort[$arrayCount]["noevent"].'&username='.$eventsSort[$arrayCount]["username"].'">
                                   <div class="thumbnail" >
                                     <div class="event-image" >
                                       <img src="'.$imagePath.'">
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
          <ol class="carousel-indicators">
            <!-- <?php echo $contents?>; -->
          </ol>

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

      <div class="page-wrapper">
        <div class="container">
          <div class="category-container">
            <div class="page-header">
              <div class="btn-toolbar pull-right">
                  <form class="" action="viewAll.php" method="post">
                        <input type="hidden" value="event" name="type">
                        <input type="submit" class = "btn btn-default" name="typeView" value="ดูทั้งหมด">

                  </form>



              </div>
              <h3>Events</h3>

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
                      <input type="submit" class = "btn btn-default" name="typeView" value="ดูทั้งหมด">

                </form>


              </div>
              <h3>Seminars</h3>

            </div>
            <div class="row" >
              <?php echo $seminars ?>

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
