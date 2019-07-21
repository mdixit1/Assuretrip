<?php
error_reporting(0);
session_start();
include('function.php');
include('connection/index.php');


if($_POST){
  $plid = $_POST['pllid'];
  $fxdate = $_POST['fxdate'];	
  $dtenme = $_POST['pdate'];
  $update_trip = $db->prepare("UPDATE leads SET departure_type=:fxdate, departure_date=:dtenme WHERE leads_id=:plid");
  $update_trip->bindParam(':fxdate',$fxdate);
  $update_trip->bindParam(':dtenme',$dtenme);
  $update_trip->bindParam(':plid',$plid);
  $update_trip->execute();
}

?>
<!DOCTYPE html>
<html lang="en-IN">
<head>
    <?php echo headdata(); ?>
 	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script>
	$(document).ready(function(){	
			$(document).on('submit', '#fori-form', function(){
				var data = $(this).serialize();
				$.ajax({
				type : 'POST',
				url  : "<?php echo $url.'submit4.php';?>",
				data : data,
				success :  function(data)
						   {				
							 $("#fori-form").fadeIn(200).show(function()
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
</head>
<body>
  
         
<div class="resultone">	 
    <form method="post" id="fori-form">
        <div class="form_maindv_in success">
            <div class="form_maindv_in">
                <img src="<?php echo $url; ?>images/icon-check.png" alt=""/>
                <h2>Congratulations !</h2>
            </div>
        </div>
    </form>
</div>
                

</body>
</html>