<?php

session_start();

include('../connection/index.php');



if($_POST['id'])

{

$pimgid=$_POST['id'];

$getimg = $db->query("SELECT productimage FROM productimage WHERE productimgid='$pimgid' ");

$onlyimage = $getimg->fetch();

$pimg = $onlyimage['productimage'];

$deletesquery = $db->query("DELETE FROM productimage WHERE productimgid='$pimgid'");	

if(isset($deletesquery)){

		unlink('../images/productimage/'.$pimg);

		unlink('../images/productimage/550_669/'.$pimg);
		
		unlink('../images/productimage/265_320/'.$pimg);

		unlink('../images/productimage/60_60/'.$pimg);

}

}

?>

