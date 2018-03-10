<html>

<head>


<!-- <link href="setWebBoard.css" rel="stylesheet" type="text/css" /> -->
    <script src="jquery-3.3.1.min.js" charset="utf-8"></script>
    <!-- <script src="setWeb.js"></script>
    <link href="./css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- <script src="jquery-3.3.1.min.js" charset="utf-8"></script> -->


    <link href="https://fonts.googleapis.com/css?family=Libre+Baskerville|Mitr|Nanum+Gothic|Noto+Serif|Ubuntu" rel="stylesheet">    <!-- <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.min.js"></script> -->

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<?php include './header.php'; ?>
<body style="font-family: 'Ubuntu', sans-serif;
font-family: 'Noto Serif', serif;
font-family: 'Nanum Gothic', sans-serif;
font-family: 'Libre Baskerville', serif;
font-family: 'Mitr', sans-serif;">

<!-- <h1>
  <a href="" class="typewrite" data-period="2000" data-type='[ "Hi, Im VipulM.", "I am Creative.", "I Love Design.", "I Love to Develop." ]'>
    <span class="wrap"></span>
  </a>
</h1> -->
<!-- <div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
           T1
        </div>
    </div> 
<div class="row">
        <div class="col-xs-12">
            <div class="page-host" id="content-host" data-bind="router: { transition: 'entrance' }">
            T2
        </div>
        </div>
</div> -->

<?php
include './database/epmtfafn_satta_db.php';
$db = new DataBase();
$db->openDataBase();

// echo $_GET['noevent'];
// echo $_GET['username'];
$nut = $_GET['noevent'];
$sun = $_GET['username'];
// $db->create_topic(1,"supanut","สวัสดี มาร์ค","อย่าลืมทำงานด้วยนะ",0);
echo "<pre>";
// print_r($db->get_topic_noevent_all(1));
$permission=$db->infoUsername($_GET['username']);
$currenceName =$db->get_noevent($_GET['noevent']);

// print_r($currenceName['username']);

if ($permission['position']=="admin" || $currenceName['username'] == $_GET['username']){
    $n=6;
}
else{
    $n=5;
}

$data=$db->get_topic_noevent_all($_GET['noevent']);
// print_r($data);
  $reply=$db->get_comment_notopic_all($data[0]['notopic']);
  $event=$db->get_noevent($_GET['noevent']);
//   print_r($event);

//  $db->delete_topiccomment_notopic(46);
$db->closeDataBase();
echo "</pre>";
?>

<div class="row">
<div class="col-sm-2" style="background-color:red;"> </div>
<div class="col-sm-8" style="background-color:white;">
<h1>
  <a href="" align="center" style="color:black;font-size: 4em;"  class="typewrite" data-period="2000" data-type='[ "Webboard." ]'>
    <span class="wrap"></span>
  </a>
</h1>


<div class="sticky-top" >
<!-- <center style="font-size: 5em;">Webboard</center> -->


<center><font size="100px" color="black"><?php echo $event['name']?></font></center>
</div>




<form method="get" action='eventMain.php'>
    <button class="btn btn-primary" type="submit">Back To Event</button>
    <input type="hidden" name="noevent" value='<?php echo $_GET['noevent'];?>' />
    <input type="hidden" name="username" value='<?php echo $_GET['username'];?>' />
</form>

<a href="#popup1" class="btn btn-primary" data-toggle="modal" data-target="#myModal">สร้างกระทู้</a>


<table  border="1">
<tr>
<th width="85"> <div align="center">No.</div></th>
<th width="480"> <div align="center">Question </div></th>
<th width="100"> <div align="center">Name</div></th>
<th width="150"> <div align="center">CreateDate</div></th>
<th width="58"> <div align="center">Reply</div></th>

<?php
if ($n==6){ 
echo '<th width="47"> <div align="center">Delete</div></th>';
echo '<th width="47"> <div align="center">Edit</div></th>';
}
?>

</tr>



<?php 

$i=0; foreach ($data as $index) { 
    ?>
<tr>
<?php $i=$i+1;
$db = new DataBase();
$db->openDataBase();
$reply=$db->get_comment_notopic_all($index['notopic']);

// echo count($reply);
$db->closeDataBase();
?>
<td><div align="center"><?php echo $i?></div></td>
<td>
<form action="topic.php" method="get">
<input type="hidden" name="v" value='<?php echo "$index[notopic]";?>' />
<input type="hidden" name="username" value='<?php echo $_GET['username'];?>' />
<input type="hidden" name="noevent" value='<?php echo $_GET['noevent'];?>' />

<a href="#" onclick="$(this).closest('form').submit()" value=$index["header"] name='v' ><?php echo $index["header"]?></a>
</form>
    <!-- <a href="topic.php?v="; value="topic.php?v="+$i name='v'><?php echo $index["header"]?></a>  -->

</td>
<td><div align="center" ><?php echo $index["username"]?></div></td>
<td><div align="center" style="font-size: 14px;"><?php echo $index["date_time"]?></div></td>
<td><div align="center"><?php echo count($reply)?></div></td>
<?php
if ($n==6){
?>
<td><div align="center" ><button  data-toggle="confirmation" class="btn btn-danger"  onclick="deleteTopic(<?php echo $index["notopic"];?>)">Delete</button></div></td>
<td><div align="center" ><button class="btn btn-warning"  data-toggle="modal"  value='<?php echo $index["notopic"]; ?>'  onclick="edit(<?php echo $index["notopic"];?>)"    data-target="#edit">Edit</button></div></td>

<?php
}else{
    if ($index["username"] == $_GET['username'] ){
        ?>
        <td><div align="center" ><button  class="btn btn-danger" data-target="#comfirm" onclick="deleteTopic(<?php echo $index["notopic"];?>)">Delete</button></div></td>
        <td><div align="center" ><button class="btn btn-warning"  data-toggle="modal"  value='<?php echo $index["notopic"]; ?>'  onclick="edit(<?php echo $index["notopic"];?>)"    data-target="#edit">Edit</button></div></td>
<?php
    }
}
?>



</tr>
<?php

 }
?>
</table>

<div class="modal fade" id="myModal" role="dialog">
<div class="modal-dialog">
<div class="modal-content" style="width:420px">

<div class="modal-header" >
<h4 class="modal-title">Question</h4>
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
    <form  method="post" >
    <div class="modal-body">
    <!-- <input type="hidden" name="username" value='<?php echo $_GET['username'];?>' />
    <input type="hidden" name="noevent" value='<?php echo $_GET[''];?>' /> -->
    <p>Topic</p><input type="text" name="topic" id="topic">
    <p>Description</p>
    <!-- <input type="text" style="height:300px;width:370px" name="description" id="des"><br> -->
    <textarea style="height:300px;width:370px" name="description" id="des"></textarea>
    </div>
    <div class="modal-footer">
    <input id="button" class="btn btn-success" type="button" value="Create" onclick="createTopic()"> 
    </div>

 </div>
 </div>
 </div>
 </form>

 <!-- <div class="modal fade" id="confirm" role="dialog">
<div class="modal-dialog">
<div class="modal-content" style="width:420px">

<div class="modal-header">
<h4 class="modal-title">Delete?</h4>
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>

<form  method="post" >
    <div class="modal-body">
    <p>Are you sure you want to remove this item ?</p>
    </div>
    <div class="modal-footer">
    <input id="delete"  type="submit" value="Delete">
    <input id="cancel"  type="submit" value="Cancel">
    </div>
</div>
 </div>
 </div> -->



 <div class="modal fade" id="edit" role="dialog">
<div class="modal-dialog">
<div class="modal-content" style="width:420px">


    <div class="modal-body">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h3 id="test5" class="modal-title">Edit</h3>
    <input type="text" name="topic" id="topicEdit" >
<p>Description</p>
<textarea style="height:300px;width:370px" name="descriptionEdit" id="desEdit">  </textarea> 
    </div>
    <div class="modal-footer">
    <input id="okEdit" class="btn btn-success"  type="submit" value="Submit"  onclick="editTopic()">
    </div>

</div>
 </div>
 </div>


 <!-- </div>
<div class="col-sm-2" style="background-color:grey;"> </div>
</div> -->
 
 <script type="text/javascript">
    // var data=null;
    var list=null;
    var ans=0;
    var usernameEdit=0;
    //  

    function editTopic(){
        var id=ans;
         var topic = document.getElementById('topicEdit').value;
         var des = document.getElementById('desEdit').value;
         var noEvent = "<?php echo $_GET['noevent'];?>";
         var user = usernameEdit;
        $.post('sun.php',{editTopic:"true",id:id,noevent:noEvent,username:user,topic:topic,description:des},
        function(data){
         location.reload();
        });
        var user = "<?php echo $_GET['username'];?>";
        var event="<?php echo $event['name'];?>";
        var action = "edit topic: "+topic+" event: "+event+" description: "+des;
        addLog(user,action);
    }

    function createTopic(){
        var topic = document.getElementById('topic').value;
        var des = document.getElementById('des').value;
        var noEvent = "<?php echo $_GET['noevent'];?>";
        var user = "<?php echo $_GET['username'];?>";
        console.log(noEvent);
        console.log(user);
        $.post('sun.php',{createTopic:"true",noevent:noEvent,username:user,topic:topic,description:des},
        function(data){
            //console.log(data);
            location.reload();
        });
        var event="<?php echo $event['name'];?>";
        var action = "create topic: "+topic+" event: "+event+" description: "+des;
        addLog(user,action);
    }

    function deleteTopic(id){
        var ans =confirm("Are you sure you want to remove this item ?");
        if (ans==true){
        $.post('sun.php',{deleteTopic:"true",d:id},
        function(data){
            //console.log(data);
            location.reload();
        });
        var user = "<?php echo $_GET['username'];?>";
        var event="<?php echo $event['name'];?>";
        var action = "delete topic: "+topic+" event: "+event;
        addLog(user,action);
        }
    }

    function addLog(user,action){
        $.post('sun.php',{addLog:"true",user:user,action:action},
        function(data){
            //console.log(data);
            location.reload();
        });
    } 
    

    function edit(id){
        ans=id;
        var list = <?php echo json_encode($data);?> ;
            for (i = 0; i < list.length; i++) {
           if (list[i]['notopic']==id){
            document.getElementById("topicEdit").value = list[i]['header'];
            document.getElementById("desEdit").value = list[i]['description'];
            usernameEdit=list[i]['username'];
           }
        }
    }
    



    var TxtType = function(el, toRotate, period) {
        this.toRotate = toRotate;
        this.el = el;
        this.loopNum = 0;
        this.period = parseInt(period, 10) || 2000;
        this.txt = '';
        this.tick();
        this.isDeleting = false;
    };

    TxtType.prototype.tick = function() {
        var i = this.loopNum % this.toRotate.length;
        var fullTxt = this.toRotate[i];

        if (this.isDeleting) {
        this.txt = fullTxt.substring(0, this.txt.length - 1);
        } else {
        this.txt = fullTxt.substring(0, this.txt.length + 1);
        }
        this.el.innerHTML = '<span class="wrap">'+this.txt+'</span>';
        var that = this;
        var delta = 400 - Math.random() * 100;
        if (this.isDeleting) { delta /= 2; }
        if (!this.isDeleting && this.txt === fullTxt) {
        
        delta = this.period;
        this.isDeleting = true;
        } else if (this.isDeleting && this.txt === '') {
        this.isDeleting = false;
        this.loopNum++;
        delta = 500;
        }

        setTimeout(function() {
        that.tick();
        }, delta);
    };

    window.onload = function() {
        var elements = document.getElementsByClassName('typewrite');
        for (var i=0; i<elements.length; i++) {
            var toRotate = elements[i].getAttribute('data-type');
            var period = elements[i].getAttribute('data-period');
            if (toRotate) {
              new TxtType(elements[i], JSON.parse(toRotate), period);
            }
        }
        // INJECT CSS
        var css = document.createElement("style");
        css.type = "text/css";
        css.innerHTML = ".typewrite > .wrap { border-right: 0.08em solid #fff}";
        document.body.appendChild(css);
    };



 </script>


<!-- <script src="./js/jquery-3.3.1.min.js"></script>
<script src="./js/popper.min.js"></script>
<script src="./js/bootstrap.min.js"></script> -->



</div>
<div class="col-sm-2" style="background-color:grey;"> </div>
</div>

</body>
</html>

