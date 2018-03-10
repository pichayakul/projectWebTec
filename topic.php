


<html>

<head>
<link href="./css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Libre+Baskerville|Mitr|Nanum+Gothic|Noto+Serif|Ubuntu" rel="stylesheet">    <!-- <script src="./js/popper.min.js"></script>

<!-- <link href="setWebBoard.css" rel="stylesheet" type="text/css" /> -->
    <!-- <script src="jquery-3.3.1.min.js" charset="utf-8"></script> -->
    <!-- <script src="./js/jquery-3.3.1.min.js"></script>
    <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="setWeb.js"></script> -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>

<body style="font-family: 'Ubuntu', sans-serif;
font-family: 'Noto Serif', serif;
font-family: 'Nanum Gothic', sans-serif;
font-family: 'Libre Baskerville', serif;
font-family: 'Mitr', sans-serif;">
<?php

include './database/epmtfafn_satta_db.php';

echo $_GET['v'];
echo $_GET['username'];
echo $_GET['noevent'];

$db = new DataBase();
$db->openDataBase();
$data=$db->get_comment_notopic_all($_GET['v']);
$dataTopic=$db->get_topic($_GET['v']);
$permission=$db->infoUsername($_GET['username']);
$currenceName =$db->get_noevent($_GET['noevent']);

echo "<pre>";
//   print_r($permission);
   print_r($currenceName);
echo "</pre>";
$n=5;
// echo $permission;
if ($permission['position']=="admin" || $currenceName['username'] == $_GET['username']){
    $n=6;
}

$db->closeDataBase();
?>

<div class="row">
    <div class="col-sm-2" style="background-color:white;"> </div>
    <div class="col-sm-8" style="background-color:white;">



    <div  >
<center><font size="100" color="black">Topic</font></center>
</div>



<form method="get" action='nut.php'>
    <button class="btn btn-primary" type="submit">Back To Webboard</button>
    <input type="hidden" name="username" value='<?php echo $_GET['username'];?>' />
    <input type="hidden" name="noevent" value='<?php echo $_GET['noevent'];?>' />
</form>

<table width="840" border="1">
<tr>
<th width="400" height="20px" > <div align="center">Topic: <?php echo $dataTopic['header']?></div></th>
<th width="100" height="20px"><p align="center">Name</p></th>
</tr>
<tr>
<th width="180" height="100px"> <div align="center"><?php echo $dataTopic['description']?></div></th>
<th width="100" height="20px"><div align="center"><?php  echo $dataTopic['username']?><br><?php  echo $dataTopic['date_time']?></div></th>
</tr>
</table>


<!-- <div style="padding-top:20px;">
<a href="#popup1" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Create Comment</a>
</div> -->


<table class="table table-striped" >
<tr>
<th width="500"> <div align="center">Comment</div></th>
<th width="180"> <div align="center">Name</div></th>
</tr>


<?php
if (sizeof($data)==0){
    ?>
<td><div  align="center">No Comment</div></td>
 <?php   
}
$i=0; foreach ($data as $index) { ?>
<tr>
<td height="100px" class="w-75"><div  ><?php echo $index['message']?></div></td>
<td><div  align="center"><?php echo $index["username"]?><br><?php echo $index["date_time"]?> </div></td>

<?php
if ($n==6){ ?>
<td><button align="center" class="btn btn-danger"  onclick="deleteComment(<?php echo $index["notopic"];?>,<?php echo $index["nocomment"];?>)">Delete</button></td>
<?php
}
else{
    if ($index["username"] == $_GET['username'] ){
        ?>
<td><button align="center" class="btn btn-danger"  onclick="deleteComment(<?php echo $index["notopic"];?>,<?php echo $index["nocomment"];?>)">Delete</button></td>
<?php
    }
}?>
</tr>
<?php } ?>
</table>

<div style="padding-top:20px;">
<a href="#popup1" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Create Comment</a>
</div>

</div>
<div class="col-sm-2" style="background-color:white;"> </div>
</div>

<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
    // $db->create_topic(1,"supanut","สวัสดี มาร์ค","อย่าลืมทำงานด้วยนะ",0);
    $db = new DataBase();
    $db->openDataBase();
    $db->create_comment($_GET['v'],$_GET['username'],$_POST['comment'],date('Y/m/d H:i:s'));    
    header('Refresh:0; url="topic.php?username='.$_GET['username'].'&noevent='.$_GET['noevent'].'&v='.$_GET['v']);   
    $db->closeDataBase();
    
 ?>
<?php
    }
?>



        
<div class="modal fade" id="myModal" role="dialog">
<div class="modal-dialog">
<div id="popup1" style="height:600px"  >
<div class="modal-content" >

<div class="modal-header">
<h4 class="modal-title">Comment</h4>
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>

<div class="modal-body">
    <form  method="post" action="">
    <input type="hidden" name="v" value='<?php echo $_GET['v'];?>' />
    <p>Description</p>
    <textarea style="height:300px;width:370px" name="comment"> </textarea> 
    <!-- <input type="text" style="height:300px;width:370px" name="comment"><br> -->
 </div>

 <div class="modal-footer">
    <input id="submit"  onclick="addComment(<?php echo $_GET['v'];?>);"   type="submit" value="Create">
</div>

</div>
</div>
</div>
</div>
</form>
</div>



</div>


<script>

  function deleteComment(notopic,nocomment){
    var ans =confirm("Are you sure you want to remove this item ?");
    if (ans==true){
        var noEvent = "<?php echo $_GET['noevent'];?>";
        var user = "<?php echo $_GET['username'];?>";
        var topic ="<?php echo $dataTopic['header']?>";

         var action="delete comment:  event ";
        //  $db->create_log($_POST['user'],date('Y/m/d H:i:s'),action);
    $.post('sun.php',{deleteComment:"true",action:action,user:user,addLog:"true",notopic:notopic,nocomment:nocomment},
    function(data){
        location.reload();
    });
    }
  }
  

  function addComment(notopic,nocomment,comment){
    
   
        var noEvent = "<?php echo $_GET['noevent'];?>";
        var user = "<?php echo $_GET['username'];?>";
        var topic ="<?php echo $dataTopic['header']?>";

         var action="delete comment:  event ";
        //  $db->create_log($_POST['user'],date('Y/m/d H:i:s'),action);
    $.post('sun.php',{deleteComment:"true",action:action,user:user,addLog:"true",notopic:notopic,nocomment:nocomment},
    function(data){
        location.reload();
    });

  }


  function refresh(){
    location.reload();
  }
</script>

<!-- 
$coment=$_POST['comment'];
    $top=$dataTopic['header'];
    $action = "create coment: ".$_POST['comment']."topic: ".$top; -->
</body>
</html>