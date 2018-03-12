<?php
include 'epmtfafn_satta_db.php';
$db = new DataBase();
$db->openDataBase();



if(isset($_POST["addLogDeleteTopic"])){
    $nameTopic=$db->get_topic($_POST['d']);
    $ac=$_POST['action']." | ".$nameTopic['header'];
    $db->create_log($_POST['user'],date('Y/m/d H:i:s'), $ac);
}


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

if(isset($_POST["addComment"])){
    $db->create_comment($_POST['notopic'],$_POST['user'],$_POST['comment'],date('Y/m/d H:i:s'));
}



if(isset($_POST["addLog"])){

    $db->create_log($_POST['user'],date('Y/m/d H:i:s'), $_POST['action']);
}
if(isset($_POST["addDeleteLog"])){ 
     $commentD=$db->get_comment_notopic_notopic($_POST['notopic'],$_POST['nocomment']);
    //  $db->create_log($_POST['user'],date('Y/m/d H:i:s'),$commentD['message']);
     $topicD=$db->get_topic($_POST['notopic']);
     $action="delete comment: ".$commentD['message']." event: ".$topicD['header'];
     $db->create_log($_POST['user'],date('Y/m/d H:i:s'), $action);
}
if(isset($_POST["addCreateLog"])){ 
    // $commentD=$db->get_comment_notopic_notopic($_POST['notopic'],$_POST['nocomment']);
    // $db->create_log($_POST['user'],date('Y/m/d H:i:s'),$commentD['message']);
    // $topicD=$db->get_topic($_POST['notopic']);

    $action="create comment: ".$_POST['comment']." event: ".$_POST['topic'];
    $db->create_log($_POST['user'],date('Y/m/d H:i:s'), $action);
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