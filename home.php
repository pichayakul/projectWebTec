<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <?php include "database/epmtfafn_satta_db.php" ;?>
    <!-- <script src="js/jquery-3.3.1.min.js"></script> -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
    <!-- <link href="./css/bootstrap.min.css" rel="stylesheet"> -->


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" type="text/css" href="css/main.css">
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




            $contents = '<div class="col-sm-6 col-md-4" >
                            <div class="event-container animate-bottom " style = "box-shadow:0 0 3px;" >

                              <a href = "./eventMain.php?noevent='.$noevent.'&username='.$username.'" >
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
  <div class="animate-bottom" id="satta"  >
    <?php require './header.php';  ?>



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
                                 <a href = "./eventMain.php?noevent='.$eventsSort[$arrayCount]["noevent"].'&username='.$eventsSort[$arrayCount]["username"].'">
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
<!-- wrapper -->
<script src="./js/jquery-3.3.1.min.js"></script>
<script src="./js/popper.min.js"></script>
<script src="./js/bootstrap.min.js"></script>

  </body>
</html>
