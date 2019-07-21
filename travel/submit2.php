<?php
error_reporting(0);
session_start();
include('function.php');
include('connection/index.php');

if($_POST){
  $pid = $_POST['pid'];
  $dest = $_POST['dest'];	
  $add_trip = $db->prepare("UPDATE leads SET destination_to=:dest WHERE leads_id=:pid");
  $add_trip->bindParam(':dest',$dest);
  $add_trip->bindParam(':pid',$pid);
  $add_trip->execute();
 	
}

?>
<!DOCTYPE html>
<html lang="en-IN">
<head>
    <?php echo headdata(); ?>
 	<link rel="stylesheet" href="/resources/demos/style.css">

	
</head>
<body>
<script>
	$(document).ready(function(){	
			$(document).on('submit', '#third-form', function(){
				var data = $(this).serialize();
				$.ajax({
				type : 'POST',
				url  : "<?php echo $url.'submit3.php';?>",
				data : data,
				success :  function(data)
						   {				
							 $("#third-form").fadeIn(200).show(function()
								  {	
									$(".resultone").fadeIn(200).show(function()
									{	
										$(".resultone").html(data);
									});   
								 });
							}
				});
				return false;
			}); 
		});
		
</script>  
         
<div class="resultone">	 
    <form method="post" id="third-form">
        <div class="form_maindv_in">
            <h2>Is your travel date fixed?</h2>
            <label for="one" class="radiolabel">
            <?php
				$found_pid = $db->prepare("SELECT leads_id FROM leads ORDER BY leads_id DESC LIMIT 1");	
				$found_pid->execute();
				$fid = $found_pid->fetch();
				$plnid = $fid['leads_id'];
			?>
            	<input type="text" value="<?php echo $plnid; ?>" name="pllid" hidden="hidden">
            	<input type="radio" id="one" name="fxdate" value="Fixed" required>Yes
            </label>
            <label for="one2" class="radiolabel">
            	<input type="radio" id="one2" name="fxdate" value="Flexible" required> Not Yet
            </label>
            <br><br>
            <h2>When are you planning to go?</h2>
            <input type="text" name="pdate" placeholder="Date" id="datepicker">
            <input type="submit" class="see-button" name="submit" value="Submit">
        </div>
    </form>
</div>
                

</body>
</html>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  	$( function() {
			$( "#datepicker" ).datepicker({dateFormat: 'yy-m-d'});
		  } );
  </script>
  