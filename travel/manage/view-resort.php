<?php
error_reporting(0);
session_start();
include('../connection/index.php');
include('../function.php'); 
if(isset($_SESSION['amail']) && isset($_SESSION['aid']) && isset($_SESSION['apass'])){
	$recaid = $_SESSION['aid'];
	$recmail = $_SESSION['amail'];
	$recpass = $_SESSION['apass'];	
	$userdetail = $db->prepare("SELECT * FROM plusadmin WHERE adminid = :recaid AND ademail = :recmail AND adpassword = :recpass");
	$userdetail->bindParam(':recaid',$recaid);
	$userdetail->bindParam(':recmail',$recmail);
	$userdetail->bindParam(':recpass',$recpass);
	$userdetail->execute();
	$userd = $userdetail->fetchAll();
	if(count($userd)){
		foreach($userd as $usr){
			$recname = $usr['adname'];
	if(isset($_GET['resrt'])){
		$resuqid = $_GET['resrt'];
		$get_detail = $db->prepare("SELECT pck.*,cn.country_name,st.state_name,ct.city_name,cat.categoryname FROM packages pck JOIN country cn ON cn.country_id=pck.cntid JOIN state st ON st.state_id=pck.stid JOIN city ct ON ct.city_id=pck.ctyyid JOIN category cat ON cat.categoryid=pck.cattid WHERE package_uniq=:resuqid");
		$get_detail->bindParam(':resuqid',$resuqid);
		$get_detail->execute();
		$stmt = $get_detail->fetchAll();
		if(count($stmt)){
			foreach($stmt as $st){
				$resrt_id = $st['package_id'];		
					$show_dayone = $db->prepare("SELECT * FROM package_itinerary WHERE it_pckid=:resrt_id");
					$show_dayone->bindParam(':resrt_id',$resrt_id);
					$show_dayone->execute();
					$itinry = $show_dayone->fetch();
			
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
                   <?php if($itinry['day_one']!=''){ ?> 
                    <tr>
                    	<td>Day 1 Activity</td>
                    	<td><?php echo $itinry['day_one']; 
								$image_one = $db->prepare("SELECT * FROM day_one_image WHERE itry_pckid_one=:resrt_id");
								$image_one->bindParam(':resrt_id',$resrt_id);
								$image_one->execute();
								$allone = $image_one->fetchAll();
								foreach($allone as $alone){
									echo "<p><img src='../images/itinerary_image/".$alone['image_one']."'></p>";
								}
							?>
                        </td>
                    </tr>
                  <?php } if($itinry['night_one']!=''){ ?>  
                    <tr>
                    	<td>Night 1 Activity</td>
                    	<td><?php echo $itinry['night_one']; 
								$image_onen = $db->prepare("SELECT * FROM day_onen_image WHERE itry_pckid_none=:resrt_id");
								$image_onen->bindParam(':resrt_id',$resrt_id);
								$image_onen->execute();
								$allonen = $image_onen->fetchAll();
								foreach($allonen as $alonen){
									echo "<p><img src='../images/itinerary_image/".$alonen['night_image_one']."'></p>";
								}
							?>
                        </td>
                    </tr>
                  <?php } if($itinry['day_two']!=''){ ?>    
                    <tr>
                    	<td>Day 2 Activity</td>
                    	<td><?php echo $itinry['day_two']; 
								$image_two = $db->prepare("SELECT * FROM day_two_image WHERE itry_pckid_two=:resrt_id");
								$image_two->bindParam(':resrt_id',$resrt_id);
								$image_two->execute();
								$alltwo = $image_two->fetchAll();
								foreach($alltwo as $altw){
									echo "<p><img src='../images/itinerary_image/".$altw['image_two']."'></p>";
								}
							?>
                         </td>
                    </tr>
                 <?php } if($itinry['night_two']!=''){ ?>       
                    <tr>
                    	<td>Night 2 Activity</td>
                    	<td><?php echo $itinry['night_two']; 
								$image_twon = $db->prepare("SELECT * FROM day_twon_image WHERE itry_pckid_twon=:resrt_id");
								$image_twon->bindParam(':resrt_id',$resrt_id);
								$image_twon->execute();
								$alltwon = $image_twon->fetchAll();
								foreach($alltwon as $altwn){
									echo "<p><img src='../images/itinerary_image/".$altwn['night_image_two']."'></p>";
								}
							?>
                        </td>
                    </tr>
                 <?php } if($itinry['day_three']!=''){ ?>           
                    <tr>
                    	<td>Day 3 Activity</td>
                    	<td><?php echo $itinry['day_three']; 
								$image_three = $db->prepare("SELECT * FROM day_three_image WHERE itry_pckid_three=:resrt_id");
								$image_three->bindParam(':resrt_id',$resrt_id);
								$image_three->execute();
								$allthree = $image_three->fetchAll();
								foreach($allthree as $althre){
									echo "<p><img src='../images/itinerary_image/".$althre['image_three']."'></p>";
								}
							?>
                        </td>
                    </tr>
                 <?php } if($itinry['night_three']!=''){ ?>              
                    <tr>
                    	<td>Night 3 Activity</td>
                    	<td><?php echo $itinry['night_three']; 
								$image_threen = $db->prepare("SELECT * FROM day_threen_image WHERE itry_pckid_threen=:resrt_id");
								$image_threen->bindParam(':resrt_id',$resrt_id);
								$image_threen->execute();
								$allthreen = $image_threen->fetchAll();
								foreach($allthreen as $althren){
									echo "<p><img src='../images/itinerary_image/".$althren['night_image_three']."'></p>";
								}
							?>
                        </td>
                    </tr>
                 <?php } if($itinry['day_four']!=''){ ?>                  
                    <tr>
                    	<td>Day 4 Activity</td>
                    	<td><?php echo $itinry['day_four']; 
								$image_four = $db->prepare("SELECT * FROM day_four_image WHERE itry_pckid_four=:resrt_id");
								$image_four->bindParam(':resrt_id',$resrt_id);
								$image_four->execute();
								$allfour = $image_four->fetchAll();
								foreach($allfour as $alfour){
									echo "<p><img src='../images/itinerary_image/".$alfour['image_four']."'></p>";
								}
							?>
                        </td>
                    </tr>
                 <?php } if($itinry['night_four']!=''){ ?>                     
                    <tr>
                    	<td>Night 4 Activity</td>
                    	<td><?php echo $itinry['night_four']; 
								$image_fourn = $db->prepare("SELECT * FROM day_fourn_image WHERE itry_pckid_fourn=:resrt_id");
								$image_fourn->bindParam(':resrt_id',$resrt_id);
								$image_fourn->execute();
								$allfourn = $image_fourn->fetchAll();
								foreach($allfourn as $alfourn){
									echo "<p><img src='../images/itinerary_image/".$alfourn['night_image_four']."'></p>";
								}
							?>
                        </td>
                    </tr>
                 <?php } if($itinry['day_five']!=''){ ?>                        
                    <tr>
                    	<td>Day 5 Activity</td>
                    	<td><?php echo $itinry['day_five']; 
								$image_five = $db->prepare("SELECT * FROM day_five_image WHERE itry_pckid_five=:resrt_id");
								$image_five->bindParam(':resrt_id',$resrt_id);
								$image_five->execute();
								$allfive = $image_five->fetchAll();
								foreach($allfive as $alfive){
									echo "<p><img src='../images/itinerary_image/".$alfive['image_five']."'></p>";
								}
							?>
                        </td>
                    </tr>
                 <?php } if($itinry['night_five']!=''){ ?>                           
                    <tr>
                    	<td>Night 5 Activity</td>
                    	<td><?php echo $itinry['night_five']; 
								$image_fiven = $db->prepare("SELECT * FROM day_fiven_image WHERE itry_pckid_fiven=:resrt_id");
								$image_fiven->bindParam(':resrt_id',$resrt_id);
								$image_fiven->execute();
								$allfiven = $image_fiven->fetchAll();
								foreach($allfiven as $alfiven){
									echo "<p><img src='../images/itinerary_image/".$alfiven['night_image_five']."'></p>";
								}
							?>
                        </td>
                    </tr>
                 <?php } if($itinry['day_six']!=''){ ?>                              
                    <tr>
                    	<td>Day 6 Activity</td>
                    	<td><?php echo $itinry['day_six']; 
								$image_six = $db->prepare("SELECT * FROM day_six_image WHERE itry_pckid_six=:resrt_id");
								$image_six->bindParam(':resrt_id',$resrt_id);
								$image_six->execute();
								$allsix = $image_six->fetchAll();
								foreach($allsix as $alsix){
									echo "<p><img src='../images/itinerary_image/".$alsix['image_six']."'></p>";
								}
							?>
                        </td>
                    </tr>
                 <?php } if($itinry['night_six']!=''){ ?>   
                    <tr>
                    	<td>Night 6 Activity</td>
                    	<td><?php echo $itinry['night_six']; 
								$image_sixn = $db->prepare("SELECT * FROM day_six_image WHERE itry_pckid_sixn=:resrt_id");
								$image_sixn->bindParam(':resrt_id',$resrt_id);
								$image_sixn->execute();
								$allsixn = $image_sixn->fetchAll();
								foreach($allsixn as $alsixn){
									echo "<p><img src='../images/itinerary_image/".$alsixn['night_image_six']."'></p>";
								}
							?>
                        </td>
                    </tr>
                <?php } if($itinry['day_seven']!=''){ ?>       
                    
                    <tr>
                    	<td>Day 7 Activity</td>
                    	<td><?php echo $itinry['day_seven']; 
								$image_sevn = $db->prepare("SELECT * FROM day_sevn_image WHERE itry_pckid_sevn=:resrt_id");
								$image_sevn->bindParam(':resrt_id',$resrt_id);
								$image_sevn->execute();
								$allsevn = $image_sevn->fetchAll();
								foreach($allsevn as $alsev){
									echo "<p><img src='../images/itinerary_image/".$alsev['image_seven']."'></p>";
								}
							?>
                        </td>
                    </tr>
                <?php } if($itinry['night_seven']!=''){ ?>           
                    <tr>
                    	<td>Night 7 Activity</td>
                    	<td><?php echo $itinry['night_seven']; 
								$image_sevnn = $db->prepare("SELECT * FROM day_sevnn_image WHERE itry_pckid_sevnn=:resrt_id");
								$image_sevnn->bindParam(':resrt_id',$resrt_id);
								$image_sevnn->execute();
								$allsevnn = $image_sevnn->fetchAll();
								foreach($allsevnn as $alsevn){
									echo "<p><img src='../images/itinerary_image/".$allsevnn['night_image_seven']."'></p>";
								}
							?>
                        </td>
                    </tr>
                <?php } ?>    
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