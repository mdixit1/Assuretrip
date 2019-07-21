<?php
require_once "connection/index.php";
?>	
<select name="subid">
	<option value="" hidden="hidden">State</option> 
 <?php
    $id = $_POST['value'];
    $getcat = $db->prepare("SELECT state_id,state_name FROM state WHERE contryid=:id");
	$getcat->bindParam(':id',$id);
	$getcat->execute();
    $row = $getcat->fetchAll();
    foreach($row as $rowall){
        $stid = $rowall['state_id'];
        $stname = $rowall['state_name'];
        echo "<option value='$stid'>$stname</option>";
    } ?>  
</select>      		

