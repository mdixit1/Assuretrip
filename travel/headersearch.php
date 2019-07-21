<?php
session_start();
include('function.php');
include('connection/index.php'); 

    $key=$_GET['key'];
    $array = array();
    $wholesearch = $db->prepare("SELECT DISTINCT state_url,state_name FROM state WHERE state_id IN(SELECT stid FROM packages) AND state_name LIKE '%{$key}%' ORDER BY state_name ASC");
	$wholesearch->execute();
	$findsbcats = $wholesearch->fetchAll();
	foreach($findsbcats as $find){
      $array[] = $find['state_name'];
    }
    echo json_encode($array);
    
?>
