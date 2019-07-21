<?php
require_once "../connection/index.php";
?>	
<select name="subid">
	<option value="" hidden="hidden">City</option> 
 <?php
    $id = $_POST['value'];
    $getcat = $db->prepare("SELECT city_id,city_name FROM city WHERE ste_id=:id");
	$getcat->bindParam(':id',$id);
	$getcat->execute();
    $row = $getcat->fetchAll();
    foreach($row as $rowall){
        $ctyid = $rowall['city_id'];
        $ctname = $rowall['city_name'];
        echo "<option value='$ctyid'>$ctname</option>";
    } ?>  
</select>      		

