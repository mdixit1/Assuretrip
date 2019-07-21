<?php
//upload.php
error_reporting(0);
session_start();
require_once "../connection/index.php";
$recid = $_SESSION['usrid'];
$get_oldfile = $db->prepare("SELECT profile_image FROM users WHERE user_id=:recid");
$get_oldfile->bindParam(':recid',$recid);
$get_oldfile->execute();
$found = $get_oldfile->fetch();
$findf = $found['profile_image'];
if($_FILES["file"]["name"] != ''){
	 $test = explode('.', $_FILES["file"]["name"]);
	 $ext = end($test);
	 $name = rand(100, 999) . '.' . $ext;
	 $location = 'images/' . $name;  
	 $update_image = $db->prepare("UPDATE users SET profile_image=:name WHERE user_id=:recid"); 
	 $update_image->bindParam(':name',$name);
	 $update_image->bindParam(':recid',$recid);
	 $update_image->execute();
	 if(isset($update_image)){
		 unlink('images/'.$findf);
	 move_uploaded_file($_FILES["file"]["tmp_name"], $location);
	 echo '<img src="'.$location.'" class="img-thumbnail" />';
	 }
}
?>