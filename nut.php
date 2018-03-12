<html>

<head>
<?php include "epmtfafn_satta_db.php" ;?>
    <link rel="stylesheet" type="text/css" href="css/webboard.css">
    <link href="https://fonts.googleapis.com/css?family=Libre+Baskerville|Mitr|Nanum+Gothic|Noto+Serif|Ubuntu" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>


<body style="font-family: 'Ubuntu', sans-serif;
    font-family: 'Noto Serif', serif;
    font-family: 'Nanum Gothic', sans-serif;
    font-family: 'Libre Baskerville', serif;
    font-family: 'Mitr', sans-serif;height:800px; background-color:rgb(245, 245, 245);">




   


    
<?php
$db = new DataBase();
$db->openDataBase();

$nut = $_GET['noevent'];
$sun = $_GET['username'];
// echo "<pre>";
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
// echo "</pre>";
?>

<div id="wallTopic"> 
    
<h1 align="center">
  <a href=""  style="font-size: 4em;"  class="typewrite" data-period="2000" data-type='[ "Webboard." ]'>
    <span class="wrap"></span>
  </a>
</h1>

</div>

<div class="row"  >

<div class="col-sm-2" ></div>
<div class="col-sm-8" >



<div class="sticky-top" >
 <!-- <center style="font-size: 5em;">Webboard</center> -->
<center><font size="100px" ><?php echo $event['name']?></font></center>
</div>




<form method="get" action='eventMain.php'>

    <button class="btn btn-primary" type="submit">Back To Event</button>
    <a href="#popup1" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Create Topic</a>

    <input type="hidden" name="noevent" value='<?php echo $_GET['noevent'];?>' />
    <input type="hidden" name="username" value='<?php echo $_GET['username'];?>' />
</form>

<table border="-1">
<tr id="TopicHeader">
<th width="85" > <div  align="center">No.</div></th>
<th width="480"> <div  align="center">Question </div></th>
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
<tr id="choice">
<?php $i=$i+1;
$db = new DataBase();
$db->openDataBase();
$reply=$db->get_comment_notopic_all($index['notopic']);
// echo count($reply);
$db->closeDataBase();
?>
<td><div id="NoTopic"  align="center"><?php echo $i?></div></td>
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
<td><div align="center" ><button  data-toggle="confirmation" class="btn btn-danger"   onclick="deleteTopic(<?php echo $index["notopic"];?>)">Delete</button></div></td>
<td><div align="center" ><button class="btn btn-warning"  data-toggle="modal"  value='<?php echo $index["notopic"]; ?>'  onclick="edit(<?php echo $index["notopic"];?>)"data-target="#edit">Edit</button></div></td>
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


 
 <script type="text/javascript">
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
        $.post('database/functionWebboard.php',{editTopic:"true",id:id,noevent:noEvent,username:user,topic:topic,description:des},
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
        $.post('database/functionWebboard.php',{createTopic:"true",noevent:noEvent,username:user,topic:topic,description:des},
        function(data){
            //console.log(data);
            location.reload();
        });
        var event="<?php echo $event['name'];?>";
        var action = "create topic: "+topic+" event: "+event+" description: "+des;
        addLog(user,action);
    }

    function deleteTopic(id,topic){
        var ans =confirm("Are you sure you want to remove this item ?");
        var user = "<?php echo $_GET['username'];?>";
        var event="<?php echo $event['name'];?>";
        var action = "delete event: "+event+" topic: ";
        if (ans==true){    
        $.post('database/functionWebboard.php',{deleteTopic:"true",user:user,action:action,addLogDeleteTopic:"true",d:id,},
        function(data){
            //console.log(data);
            location.reload();
        }); 
        }
    }

    function addLog(user,action){
        $.post('database/functionWebboard.php',{addLog:"true",user:user,action:action},
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
        this.el.innerHTML = '<span  class="wrap">'+this.txt+'</span>';
        var that = this;
        var delta = 400 - Math.random() * 100;
        if (this.isDeleting) { delta /= 2; }
        if (!this.isDeleting && this.txt === fullTxt) {
        sleep(10000);
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
        css.innerHTML = ".typewrite > .wrap { border-right: 0.05em solid black}";
        document.body.appendChild(css);
    };



 </script>


<!-- <script src="./js/jquery-3.3.1.min.js"></script>
<script src="./js/popper.min.js"></script>
<script src="./js/bootstrap.min.js"></script> -->



</div>
<div class="col-sm-2" "> </div>
</div>

</body>
</html>

