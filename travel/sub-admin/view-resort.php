<?php
error_reporting(0);
session_start();
include('../connection/index.php');
include('../function.php'); 
if(isset($_SESSION['samail']) && isset($_SESSION['said']) && isset($_SESSION['sapass'])){
	$recaid = $_SESSION['said'];
	$recmail = $_SESSION['samail'];
	$recpass = $_SESSION['sapass'];	
	$userdetail = $db->prepare("SELECT * FROM sub_admin WHERE subadmin_id = :recaid AND subadmin_mail = :recmail AND subadmin_password = :recpass AND subadmin_status='1'");
	$userdetail->bindParam(':recaid',$recaid);
	$userdetail->bindParam(':recmail',$recmail);
	$userdetail->bindParam(':recpass',$recpass);
	$userdetail->execute();
	$userd = $userdetail->fetchAll();
	if(count($userd)){
		foreach($userd as $usr){
			$recname = $usr['subadmin_name'];
	if(isset($_GET['resrt'])){
		$resuqid = $_GET['resrt'];
		$get_detail = $db->prepare("SELECT pck.*,cn.country_name,st.state_name,ct.city_name,cat.categoryname FROM packages pck JOIN country cn ON cn.country_id=pck.cntid JOIN state st ON st.state_id=pck.stid JOIN city ct ON ct.city_id=pck.ctyyid JOIN category cat ON cat.categoryid=pck.cattid WHERE package_uniq=:resuqid");
		$get_detail->bindParam(':resuqid',$resuqid);
		$get_detail->execute();
		$stmt = $get_detail->fetchAll();
		if(count($stmt)){
			foreach($stmt as $st){
				$resrt_id = $st['package_id'];		
			
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Add Resorts</title>
<?php echo headdata(); ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="<?php echo $url; ?>css/font-awesome.min.css" type="text/css" rel="stylesheet"/>
<link href="<?php echo $url; ?>css/bootstrap.min.css" type="text/css" rel="stylesheet"/>
<link href="css/styleplus.css" type="text/css" rel="stylesheet"/>
<link href="css/responsive-manage.css" type="text/css" rel="stylesheet"/>
<script src="<?php echo $url; ?>js/jquery-3.2.1.min.js" type="text/javascript"> </script>
<script src="<?php echo $url; ?>js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/index.js"></script>
<script>
$(function(){
		$("a.hidelink").each(function (index, element){
			var href = $(this).attr("href");
			$(this).attr("hiddenhref", href);
			$(this).removeAttr("href");
		});
		$("a.hidelink").click(function(){
			url = $(this).attr("hiddenhref");
			window.open(url, '_top');
		})
	});



function ckdel(){
	
	return confirm('Are you sure');	
	
}
</script>
</head>
<body>
<?php include('aheader.php'); ?>

<div class="slidebody see-trans5s">
    <?php include('topheader.php'); ?>
    <div class="fulldv adminbody">
    <div class="fulldv subcate_sect">
	
      <div class="fulldv category-maindv">
        <div class="fulldv category" style="padding-top:0;">
            <div class="fulldv">
            	<h2><a href="resort.php" class="see-button">Back</a>&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $st['resort_name']; ?></h2>
            </div>
           <div class="col-md-12 p0 activity_table">
               <table class="see-table">
                    <tr>
                    	<td>Resort Name</td>
                        <td><?php echo $st['resort_name']; ?></td>
                    </tr>
                    <tr>
                    	<td>Country</td>
                    	<td><?php echo $st['country_name']; ?></td>
                    </tr>
                    <tr>
                    	<td>State</td>
                    	<td><?php echo $st['state_name']; ?></td>
                    </tr>
                    <tr>
                    	<td>City</td>
                    	<td><?php echo $st['city_name']; ?></td>
                    </tr>
                    <tr>
                    	<td>Theme</td>
                    	<td><?php echo $st['categoryname']; ?></td>
                    </tr>
                    <tr>
                    	<td>Packages Price</td>
                    	<td><?php echo $st['pack_price']; ?></td>
                    </tr>
                    <tr>
                    	<td>Budget Per Person ( in Rs. )</td>
                    	<td><?php if($st['budget_from']!='' && $st['budget_to']!=''){ echo $st['budget_from']."To".$st['budget_to']; } ?></td>
                    </tr>
                    <tr>
                    	<td>Packages By Duration</td>
                    	<td><?php echo $st['package_duration']; ?></td>
                    </tr>
                    <tr>
                    	<td>Duration ( in Days/Night )</td>
                    	<td><?php if($st['duration_day']!='' && $st['duration_night']!=''){ echo $st['duration_day']; ?>days - <?php echo $st['duration_night']; ?> nights<?php } ?></td>
                    </tr>
                    <tr>
                    	<td>Packages By SEASON</td>
                    	<td><?php echo $st['season_from']; ?>-<?php echo $st['season_to']; ?></td>
                    </tr>
                    <tr>
                    	<td>Hotel Star Rating</td>
                        <td><?php echo $st['hotel_rating']; ?> Star</td>
                    </tr>
                    <tr>
                    	<td>Activities/Facilities</td>
                    	<td>
                        	<ul>
                          <?php
						  	$resrt_activ = $db->prepare("SELECT ac.activity_name FROM pack_activity pck JOIN add_activity ac ON ac.activity_id=pck.activt_id WHERE pck.pack_id=:resrt_id");
							$resrt_activ->bindParam(':resrt_id',$resrt_id);
							$resrt_activ->execute();
							$roww = $resrt_activ->fetchAll();
							foreach($roww as $rw){
						  ?>  
                            	<li><?php echo $rw['activity_name']; ?></li>
                          <?php } ?>  	
                            </ul>
                        </td>
                    </tr>
                    <tr>
                    	<td>Overview</td>
                    	<td>
                        	<?php echo $st['package_overview']; ?>
                        </td>
                    </tr>
                    <tr>
                    	<td>Day 1 Activity</td>
                    	<td><?php echo $st['package_activity']; ?></td>
                    </tr>
                    <tr>
                    	<td>Images</td>
                    	<td>
                        	<ul class="viewimg">
                           <?php
						  	$resrt_images = $db->prepare("SELECT p_image FROM package_images WHERE img_pckid=:resrt_id");
							$resrt_images->bindParam(':resrt_id',$resrt_id);
							$resrt_images->execute();
							$rowimg = $resrt_images->fetchAll();
							foreach($rowimg as $img){
						  ?> 
                            <li><img src="../images/package_image/<?php echo $img['p_image']; ?>" alt=""/></li>
                          <?php } ?>      
                            </ul>
                        </td>
                    </tr>
                </table>
           </div>
           <div class="clearfix"></div>
           <br><br>
        </div>
    </div>
 
 </div>
 </div>
 </div>
 </body>
  </html>
<?php }
	}
	}
	else{ echo "<script>location.assign('logout.php')</script>"; }
  	  }
	}
	else{ echo "<script>location.assign('logout.php')</script>"; }
}
else{ echo "<script>location.assign('logout.php')</script>"; }
?>