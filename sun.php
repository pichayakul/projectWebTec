<?php
include './database/epmtfafn_satta_db.php';
$db = new DataBase();
$db->openDataBase();

if(isset($_POST["createTopic"])){
   $db->create_topic($_POST['noevent'],$_POST['username'],$_POST['topic'],$_POST['description'],date('Y/m/d H:i:s'));
}
if(isset($_POST["deleteTopic"])){
    $db->delete_topiccomment_notopic($_POST['d']);
}
if(isset($_POST["editTopic"])){
    $db->update_topic($_POST['id'],$_POST['noevent'],$_POST['username'],$_POST['topic'],$_POST['description'],date('Y/m/d H:i:s'));
}
if(isset($_POST["deleteComment"])){
    $db->delete_comment_notopic_nocomment($_POST['notopic'],$_POST['nocomment']);
}
if(isset($_POST["addLog"])){
    $db->create_log($_POST['user'],date('Y/m/d H:i:s'), $_POST['action']);
}
$db->closeDataBase();
// if($_SERVER['REQUEST_METHOD'] == "POST"){

//     //  if ($_POST['d']!=null){
//     //       $db->delete_topiccomment_notopic($_POST['d']);
//     //     //   header('Location: Refresh:0; url="nut.php?username='.$_GET['username'].'&noevent='.$_GET['noevent']);
//     //   }
//     //  if(isset($_POST["nut"])){
//     //     $db->create_topic($_GET['noevent'],$_GET['username'],$_POST['topic'],$_POST['description'],date('Y/m/d H:i:s'));
//     //     //   header('Location: Refresh:1; url="nut.php?username='.$_GET['username'].'&noevent='.$_GET['noevent']);
//     //  }
//     //  
//     // //  echo $page;
//     // //  header("Refresh: $sec; url=$page");
     
// }


?> 