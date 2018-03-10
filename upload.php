<?php
$report='';
$allowed = array('gif','png' ,'jpg','jpeg');
$uploadOk = 1;
if ((isset($_POST["btnSetting"]) || isset($_POST["btnCreate"])) && isset($_POST["username"]) ){
    $username=$_POST["username"];
    $title=$_POST["title"];
    $target_dir = "images/events/".$title."/organizerUpload"."/";
    $nameFile=$_FILES["vdoUpload"]["name"];   
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    // if (file_exists($target_dir . $_FILES["vdoUpload"]["name"])) {
    //     $report .= "please rename the file,".$nameFile." VDO.<br>";
    //     $uploadOk = 0;
    //  }
     else if ($_FILES["vdoUpload"]["type"] == "video/mp4") {

        if (move_uploaded_file($_FILES["vdoUpload"]["tmp_name"], $target_dir . $_FILES["vdoUpload"]["name"])){
            $report .= "The file VDO". basename( $_FILES["vdoUpload"]["name"]). " has been uploaded.<br>";
        }
        else{
            $report .= $nameFile." format not supported.";
            $uploadOk = 0;
        }
    }
    //  }
    //  else if ($_FILES["vdoUpload"]["size"] > 26214400) {
    //     $error = "Only files <= 25ΜΒ.";
    //  }
    foreach($_FILES["fileToUpload"]["name"] as $i => $name){
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"][$i]);
        $nameFile=$_FILES["fileToUpload"]["name"][$i];   
        $check = strtolower(pathinfo($_FILES["fileToUpload"]["name"][$i],PATHINFO_EXTENSION));
        if (!in_array($check,$allowed)){
            $report .= $nameFile." is not an image.Please try again.<br>";
            $uploadOk = 0;
        }
        else{
            // if (file_exists($target_file)) {
            // $report .= "please rename the file, ".$nameFile.".<br>";
            // $uploadOk = 0;
            // }
        }
            if ($uploadOk==1){
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {
                    $report .= $nameFile." has been uploaded.<br>";
                } 
                else {
                    $report .= "Sorry, there was an error uploading ".$nameFile.".<br>";
                }
            }
    }
}
else if (isset($_POST["submitM"])){
    $username=$_POST["username"];
    $title=$_POST["title"];
    $target_dirM = "images/events/".$title."/attendantUploads"."/".$username."/preCondition".'/';
    $target_dirPay = "images/events/".$title."/attendantUploads"."/".$username."/payment".'/';
    if (!is_dir($target_dirM)) {
        mkdir($target_dirM, 0777, true);
    }
    if (!is_dir($target_dirPay)) {
        mkdir($target_dirPay, 0777, true);
    }
    
    foreach($_FILES["fileToUploadM"]["name"] as $i => $name){

        $target_file = $target_dirM . basename($_FILES["fileToUploadM"]["name"][$i]);
        // $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        // $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        $nameFile=$_FILES["fileToUploadM"]["name"][$i];   
        $check = strtolower(pathinfo($_FILES["fileToUploadM"]["name"][$i],PATHINFO_EXTENSION));
        // if($check !== false) {
        //     $report .= "File is an image - " . $check["mime"] . ".";
        //     $uploadOk = 1;
        // } 
        if (!in_array($check,$allowed)){
            $report .= $nameFile." is not an image.Please try again.<br>";
            $uploadOk = 0;
        }
        // if ($check==false) {
        //     $report .= "File is not an image.";
        //     $uploadOk = 0;
        // }
        // Check if file already exists
        
        // Check file size
        // if ($_FILES["fileToUpload"]["size"] > 500000) {
        //     $report .= "Sorry, your file is too large.";
        //     $uploadOk = 0;
        // }
        // Allow certain file formats
        // if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        // && $imageFileType != "gif" ) {
        //     $report .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        //     $uploadOk = 0;
        // }
        // Check if $uploadOk is set to 0 by an error
        // if ($uploadOk == 0) {
        //     $report .= "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        // } else {
            if ($uploadOk==1){
            if (move_uploaded_file($_FILES["fileToUploadM"]["tmp_name"][$i], $target_file)) {
                    $report .= $nameFile." has been uploaded.<br>";
                } 
                else {
                    $report .= "Sorry, there was an error uploading ".$nameFile.".<br>";
                }
            }
    }
    /*           */
    foreach($_FILES["fileToUpload"]["name"] as $i => $name){

        $target_file = $target_dirPay . basename($_FILES["fileToUpload"]["name"][$i]);
        // $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        // $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        $nameFile=$_FILES["fileToUpload"]["name"][$i];   
        $check = strtolower(pathinfo($_FILES["fileToUpload"]["name"][$i],PATHINFO_EXTENSION));
        // if($check !== false) {
        //     $report .= "File is an image - " . $check["mime"] . ".";
        //     $uploadOk = 1;
        // } 
        if (!in_array($check,$allowed)){
            $report .= $nameFile." is not an image.Please try again.<br>";
            $uploadOk = 0;
        }
        // if ($check==false) {
        //     $report .= "File is not an image.";
        //     $uploadOk = 0;
        // }
        // Check if file already exists

        // Check file size
        // if ($_FILES["fileToUpload"]["size"] > 500000) {
        //     $report .= "Sorry, your file is too large.";
        //     $uploadOk = 0;
        // }
        // Allow certain file formats
        // if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        // && $imageFileType != "gif" ) {
        //     $report .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        //     $uploadOk = 0;
        // }
        // Check if $uploadOk is set to 0 by an error
        // if ($uploadOk == 0) {
        //     $report .= "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        // } else {
            if ($uploadOk==1){
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {
                    $report .= $nameFile." has been uploaded.<br>";
                } 
                else {
                    $report .= "Sorry, there was an error uploading ".$nameFile.".<br>";
                }
            }
    }

}
else if(isset($_POST["submit"]) && isset($_POST["username"])) { 
    $username=$_POST["username"];
    $title=$_POST["title"];
    // echo $_FILES["fileToUpload"]["name"][0];
    $target_dir = "images/events/".$title."/attendantUploads"."/".$username."/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    foreach($_FILES["fileToUpload"]["name"] as $i => $name){

        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"][$i]);
        // $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        // $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        $nameFile=$_FILES["fileToUpload"]["name"][$i];   
        $check = strtolower(pathinfo($_FILES["fileToUpload"]["name"][$i],PATHINFO_EXTENSION));
        // if($check !== false) {
        //     $report .= "File is an image - " . $check["mime"] . ".";
        //     $uploadOk = 1;
        // } 
        if (!in_array($check,$allowed)){
            $report .= $nameFile." is not an image.Please try again.<br>";
            $uploadOk = 0;
        }
        // if ($check==false) {
        //     $report .= "File is not an image.";
        //     $uploadOk = 0;
        // }
        // Check if file already exists
        else{
            if (file_exists($target_file)) {
            $report .= "please rename the file, ".$nameFile.".<br>";
            $uploadOk = 0;
            }
        }
        // Check file size
        // if ($_FILES["fileToUpload"]["size"] > 500000) {
        //     $report .= "Sorry, your file is too large.";
        //     $uploadOk = 0;
        // }
        // Allow certain file formats
        // if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        // && $imageFileType != "gif" ) {
        //     $report .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        //     $uploadOk = 0;
        // }
        // Check if $uploadOk is set to 0 by an error
        // if ($uploadOk == 0) {
        //     $report .= "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        // } else {
            if ($uploadOk==1){
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {
                    $report .= $nameFile." has been uploaded.<br>";
                } 
                else {
                    $report .= "Sorry, there was an error uploading ".$nameFile.".<br>";
                }
            }
    }

    // }
}
?>