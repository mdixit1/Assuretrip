<?php
date_default_timezone_set('Asia/Kolkata');
$date = date('Y-m-d H:i:s');

$url = 'http://shreerampg.com/travel/';
$server = 'localhost';
$database = 'travelsrtech';
$user = 'travelsrtech';
$password = 'deepakgarg';
try{ 
$db = new PDO('mysql:host='.$server.';dbname='.$database,$user,$password ,
	  array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"));
	  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
echo "Error Found"; die(); 
}

?>