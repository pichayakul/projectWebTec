


<html>

<head>
<!-- <link href="./css/bootstrap.min.css" rel="stylesheet"> -->

<link href="https://fonts.googleapis.com/css?family=Libre+Baskerville|Mitr|Nanum+Gothic|Noto+Serif|Ubuntu" rel="stylesheet">    <!-- <script src="./js/popper.min.js"></script>

<!-- <link href="setWebBoard.css" rel="stylesheet" type="text/css" /> -->
    <!-- <script src="jquery-3.3.1.min.js" charset="utf-8"></script> -->
    <!-- <script src="./js/jquery-3.3.1.min.js"></script>
    <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="setWeb.js"></script> -->

    <link rel="stylesheet" type="text/css" href="css/webboard.css">

       <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>

<body style="font-family: 'Ubuntu', sans-serif;
    font-family: 'Noto Serif', serif;
    font-family: 'Nanum Gothic', sans-serif;
    font-family: 'Libre Baskerville', serif;
    font-family: 'Mitr', sans-serif;height:800px; background-color: whitesmoke;">
<?php
require './header.php';
include './database/epmtfafn_satta_db.php';

// echo $_GET['v'];
// echo $_GET['username'];
// echo $_GET['noevent'];

$db = new DataBase();
$db->openDataBase();
$n=5;
$data=$db->get_comment_notopic_all($_GET['v']);
$dataTopic=$db->get_topic($_GET['v']);
$currenceName =$db->get_noevent($_GET['noevent']);
if (isset($_SESSION["username"])){
  $permission=$db->infoUsername($_SESSION['username']);
  if ($permission['position']=="admin" || $currenceName['username'] == $_SESSION['username']){
      $n=6;
  }
}



// echo "<pre>";
// //   print_r($permission);
// //    print_r($currenceName);
// echo "</pre>";

// echo $permission;


$db->closeDataBase();
?>

<!-- <div class="pull-right" >
        <ul class="nav navbar-nav">
            <li><button type="submit" class="btn navbar-btn btn-danger" name="logout" id="logout"  value="Log Out">Log Out</button></li>
        </ul>
</div> -->

<div class="row">
    <div class="col-sm-2" > </div>
    <div class="col-sm-8" >



    <div  >

<center><font size="100" color="black"><a href="">Topic</a></font></center>
</div>

<form method="get" action='nut.php'>
    <button class="btn btn-primary" type="submit">Back To Webboard</button>
    <input type="hidden" name="noevent" value='<?php echo $_GET['noevent'];?>' />
</form>

<div style="margin-top:-50px;margin-left:-600px;">
<?php
// $currenceName =$db->get_noevent($_GET['noevent']);
if ($permission['position']!="attendant" ){
?>
<td><div align="center" ><button class="btn btn-warning"  data-toggle="modal"  value=''  onclick="edit(<?php echo $_GET['v'];?>)" data-target="#editComment">Edit</button></div></td>
<?php
}
?>
</div>

<table width="840" border="2">

<tr id="TopicHeader">
<div class="row">
<div class="col-sm-1" style="background-color:white;">
<th width="370" height="20px" > <div align="center">Topic:<?php echo $dataTopic['header']?></div></th>
</div>
<div class="col-sm-3" style="background-color:white;">
<th width="100" height="20px" ><p align="center" style="padding-bottom:10px;">Name</p></th>
</div>
</div>
</tr>
<tr>
<th width="180" height="100px"> <div align="center"><?php echo $dataTopic['description']?></div></th>
<th width="100" height="20px"><div align="center"><?php  echo $dataTopic['username']?><br><?php  echo $dataTopic['date_time']?></div></th>
</tr>


</table>





<!-- <div style="padding-top:20px;">
<a href="#popup1" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Create Comment</a>
</div> -->

<br>
<br>
<!-- <table class="table table-striped" border="1" >
<tr id="TopicHeader">
<th width="30px" <div  align="center">No</div></th>
<th width="500px"> <div align="center">Comment</div></th>
<th width="100px"> <div align="center">Name</div></th>
<th width="30px"> <div align="center">Delete</div></th>
</tr>
</table> -->


<?php
if (sizeof($data)==0){
    ?>
<td><div  align="center">No Comment</div></td>
 <?php
}
$i=0;
 foreach ($data as $index) { $i=$i+1; ?>



<!-- <img id="cloudBox" src="boxtext.png"> <img>    -->

<div class="row" id="seekComment">
<div class="col-sm-2" style="background-color:whitesmoke;">
<td ><div  ><?php echo $i?> </div></td>
<?php

$db->openDataBase();

$account=$db->infoUsernameCheck($index["username"]);
if (count($account)>0){
  $account=$account[0];
}
else{
  $account=$db->infoUsername($index["username"]);
}
// echo $account["image"];
// echo "<pre>";
// echo print_r($account);
// echo "</pre>";
$db->closeDataBase();


?>

<!-- <img src='./images/user.png'> </img> -->
<img id="im" style="height: 50px;width: 50px;margin-left: 30px;" src='<?php echo $account["image"]?>'> </img>

<td><div  align="center"><?php echo $index["username"]?><br><?php echo $index["date_time"]?> </div></td>

<?php
if (isset($_SESSION["position"])){
if ($_SESSION["position"]=="admin"){ ?>

<button style="margin-left:20px;"   class="btn btn-danger"  onclick="deleteComment(<?php echo $index["notopic"];?>,<?php echo $index["nocomment"];?>)">Delete</button>
<?php
}
else{
    if ($currenceName["username"] == $_SESSION['username'] ){
        ?>
<button  style="margin-left:20px;"  class="btn btn-danger"  onclick="deleteComment(<?php echo $index["notopic"];?>,<?php echo $index["nocomment"];?>)">Delete</button>
<?php
    }else{?>
<td><div  align="center"></div></td>
<?php
}
}}?>




</div>



<div class="col-sm-10" style="height: 200px;background:url(./images/webboard/boxtext.png);background-repeat: no-repeat;">
<td style="margin-left:60%;"  ><div style="padding-top:30px;padding-left:30px;"   ><?php echo $index['message']?></div></td>
 </div>

 </div>




<?php } ?>
<!-- </table> -->

<div style="padding-top:0px;">
<a href="#popup1" id="slideright" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Create Comment</a>
</div>

</div>
<div class="col-sm-2" > </div>
</div>

<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
    // $db->create_topic(1,"supanut","สวัสดี มาร์ค","อย่าลืมทำงานด้วยนะ",0);

    // $db = new DataBase();
    // $db->openDataBase();
    //  $db->create_comment($_GET['v'],$_GET['username'],$_POST['comment'],date('Y/m/d H:i:s'));
    // header('Refresh:0; url="topic.php?username='.$_GET['username'].'&noevent='.$_GET['noevent'].'&v='.$_GET['v']);
    // $db->closeDataBase();

 ?>
<?php
    }
?>

<div class="modal fade" id="myModal" role="dialog">
<div class="modal-dialog">
<div id="popup1" style="height:600px;width:420px;"  >
<div class="modal-content" >

<div class="modal-header">
<h4 class="modal-title">Comment</h4>
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>

<div class="modal-body">
    <!-- <form  method="post" action=""> -->
    <input type="hidden" name="v" value='<?php echo $_GET['v'];?>' />
    <p>Description</p>
    <textarea style="height:300px;width:370px"  id="comment"> </textarea>
    <!-- <input type="text" style="height:300px;width:370px" name="comment"><br> -->
 </div>

 <div class="modal-footer">
    <input id="submit"  class="btn btn-success"  onclick="addComment(<?php echo $_GET['v'];?>)"   type="submit" value="Create">
</div>





</div>
</div>
</div>
</div>
<!-- </form> -->
</div>



</div>

<div class="modal fade" id="editComment" role="dialog">
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

<script>
  var ans=0;

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
    }
    function edit(id){
        ans=id;
        console.log(id);

        var list = <?php
        $db->openDataBase();
        $da=$db->get_topic_noevent_all($_GET['noevent']);
        $db->closeDataBase();
         echo json_encode($da);?> ;
            for (i = 0; i < list.length; i++) {
           if (list[i]['notopic']==id){
            document.getElementById("topicEdit").value = list[i]['header'];
            document.getElementById("desEdit").value = list[i]['description'];
            usernameEdit=list[i]['username'];
           }
        }
    }


  function deleteComment(notopic,nocomment){
    var ans =confirm("Are you sure you want to remove this item ?");
    console.log(notopic);
    console.log(nocomment);
    if (ans){

        var user="<?php if (isset($_SESSION['username'])){ echo $_SESSION["username"];} else{
          echo "guest";
        };?>";
        $.post('functionWebboard.php',{addDeleteLog:"true",user:user,notopic:notopic,nocomment:nocomment},
         function(data){
        location.reload();
        });
        //  var action="delete comment:  event ";
        //  $db->create_log($_POST['user'],date('Y/m/d H:i:s'),action);
    $.post('database/functionWebboard.php',{deleteComment:"true",user:user,addLog:"true",notopic:notopic,nocomment:nocomment},
    function(data){
        location.reload();
    });
    }
  }
  function addComment(notopic){
        var comment = document.getElementById('comment').value;
        console.log(notopic);
    //   console.log(comment);
    var user="<?php if (isset($_SESSION['username'])){ echo $_SESSION["username"];} else{
      echo "guest";
    };?>";
        var topic ="<?php echo $dataTopic['header'];?>";
        //  $db->create_log($_POST['user'],date('Y/m/d H:i:s'),action);
        $.post('database/functionWebboard.php',{addCreateLog:"true",addComment:"true",user:user,topic:topic,notopic:notopic,comment:comment},
         function(data){
        location.reload();
        });
    // $.post('sun.php',{user:user,addLog:"true",notopic:notopic,nocomment:nocomment},
    // function(data){
    //     location.reload();
    // });

  }
</script>

<!--
$coment=$_POST['comment'];
    $top=$dataTopic['header'];
    $action = "create coment: ".$_POST['comment']."topic: ".$top; -->
</body>


</html>
