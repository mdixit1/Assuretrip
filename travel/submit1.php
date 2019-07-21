<?php
error_reporting(0);
session_start();
include('function.php');
include('connection/index.php');

if($_POST){
  $unii = uniqid();	
  $lmail = $_POST['lmail'];
  $lmob = $_POST['lmob'];
  $pfor = $_POST['honeymoon'];	
  $add_trip = $db->prepare("INSERT INTO leads(lead_uniq,email,mobile,exploring,lead_date)VALUES(:unii, :lmail, :lmob, :pfor, :date)");
  $add_trip->bindParam(':unii',$unii);
  $add_trip->bindParam(':lmail',$lmail);
  $add_trip->bindParam(':lmob',$lmob);
  $add_trip->bindParam(':pfor',$pfor);
  $add_trip->bindParam(':date',$date);
  $add_trip->execute();
  	$found_pid = $db->prepare("SELECT leads_id FROM leads WHERE lead_uniq=:unii ORDER BY leads_id DESC LIMIT 1");	
	$found_pid->bindParam(':unii',$unii);	
	$found_pid->execute();
	$fid = $found_pid->fetch();
	$plnid = $fid['leads_id'];
	
	
}

?>
<!DOCTYPE html>
<html lang="en-IN">
<head>
    <?php echo headdata(); ?>
 	
	
</head>
<body>
<script>
		$(document).ready(function(){	
				$(document).on('submit', '#second-form', function(){
					var data = $(this).serialize();
					$.ajax({
					type : 'POST',
					url  : "<?php echo $url.'submit2.php';?>",
					data : data,
					success :  function(data)
							   {				
								 $("#second-form").fadeIn(200).show(function()
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
<div class="fulldv resultone">	 
    <form method="post" id="second-form">
        <div class="form_maindv_in">
            <h2>Where do you plan to go?</h2>
            <input type="text" value="<?php echo $plnid; ?>" name="pid" hidden="hidden">
            <input type="text" name="dest" placeholder="Please type the destination">
            <input type="submit" class="see-button" name="submit" value="Submit">
        </div>
    </form>
</div>          


</body>
</html>



                
  