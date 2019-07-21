<?php
error_reporting(0);
session_start();
include('function.php'); 
include('connection/index.php');
if(isset($_GET['pck'])){
	$puniqid = $_GET['pck'];
	$pck_detail = $db->prepare("SELECT pc.*,cnt.country_name,st.state_name,ct.city_name,cat.categoryname FROM packages pc JOIN country cnt ON cnt.country_id=pc.cntid JOIN state st ON st.state_id=pc.stid JOIN city ct ON ct.city_id=pc.ctyyid JOIN category cat ON cat.categoryid=pc.cattid WHERE package_uniq=:puniqid");
	$pck_detail->bindParam(':puniqid',$puniqid);
	$pck_detail->execute();
	$rows = $pck_detail->fetchAll();
	if(count($rows)){
		foreach($rows as $row){
			$pcid = $row['package_id'];
					$show_dayone = $db->prepare("SELECT * FROM package_itinerary WHERE it_pckid=:pcid");
					$show_dayone->bindParam(':pcid',$pcid);
					$show_dayone->execute();
					$itinry = $show_dayone->fetch();
?>
<!DOCTYPE html>
<html lang="en-IN">
<head>
    <?php echo headdata(); ?>
    <link rel="canonical" href=""/>
    <link rel='shortlink' href=""/>
	<title><?php echo $row['resort_name']; ?></title>
    <meta content="telephone=no" name="format-detection">
    <meta name="keywords" content="travel">
    <meta name="description" content="travel">
    <meta property="og:url" content="">
    <meta property="og:title" content="travel"/>
    <meta property="og:image" content="travel"/>
    <meta property="og:description" content="travel"/>
    <meta name="twitter:url" content="">
    <meta name="twitter:title" content="travel">    
    <meta name="twitter:description" content="travel">
    <meta name="twitter:image:src" content="travel">
    <meta name="twitter:image:alt" content="travel">
    <link href="css/animation.css" type="text/css" rel="stylesheet" />
    <link href="<?php echo $url; ?>css/slit-slider.css" type="text/css" rel="stylesheet" />
    <script src="js/modernizr-2.6.2.min.js"></script>
    <link href="http://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
	<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    
</head>
<body>
<div class="see-section wrapper">
	<?php include('header.php'); ?>
     <div class="section overview_sect citydiv-sect">
    	<div class="container">
        	<div class="row">
            	<div class="col-md-12 p0 overviewdv" style="margin-top:-2px; margin-bottom:-7px;">
                    <p style="font-size:30px; background-color:white;"><?php echo $row['resort_name']; ?>  <span style="margin-top: -4px; margin-bottom: 3px; color:red;"><?php echo $row['duration_day']; ?> Days & <?php echo $row['duration_night']; ?> Nights</span></p>
                   
                </div>
               
            </div>
        </div>
    </div>
    <div class="section detail_slider_main">
    	<div class="container">
        	<div class="row">
            	<section class="regular headslider" style="margin-top:-32px;">
                <?php
					$show_pckslider = $db->prepare("SELECT p_image FROM package_images WHERE img_pckid=:pcid");
					$show_pckslider->bindParam(':pcid',$pcid);
					$show_pckslider->execute();
					$allimg = $show_pckslider->fetchAll();
					foreach($allimg as $alm){
				?>
                      <div class="fulldv detailsliderdv" style="background:url(<?php echo $url; ?>images/package_image/<?php echo $alm['p_image']; ?>) center center; background-size:cover;">
                          <!--<img src="<?php echo $url; ?>images/package_image/<?php echo $alm['p_image']; ?>" alt="">-->
                     </div>
                <?php } ?>       
                 </section> 
            </div>
        </div>
    </div>   
    

	
    
    <div class="section overview_sect citydiv-sect">
    	<div class="container">
        	<div class="row">
            	<div class="col-md-12 p0 overviewdv" style="border:2px solid red; background-color:white; padding:15px;">
                    <h2><strong>Overview</strong></h2>
                    <p><?php echo $row['package_overview']; ?></p><br>
                </div>
                <div class="clearfix"></div>
                <div class="fulldv">
                	
                    <div class="col-md-8" style="border:2px solid skyblue; background-color:white; margin-top: 4px;">
                    	<div class="fulldv overviewdv">
                        	<h2><strong>Itinerary</strong></h2>
                        </div>
                     <?php if($itinry['day_one']!=''){ ?>   
                     	<h2 style="color:red; text-align:center;">Day 1</h2> 
                        <div class="full itinerary_dv">
                        	<?php echo $itinry['day_one']; 
								echo "<br>";
								$image_one = $db->prepare("SELECT * FROM day_one_image WHERE itry_pckid_one=:pcid");
								$image_one->bindParam(':pcid',$pcid);
								$image_one->execute();
								$allone = $image_one->fetchAll();
								foreach($allone as $alone){
									echo "<p><img src='".$url."images/itinerary_image/".$alone['image_one']."' height='100px;'></p>";
								}
							?>
                        </div>
                     <?php } if($itinry['night_one']!=''){ ?> 
                     <br><hr>
                     	<h2 style="color:red; text-align:center;">Night 1</h2> 
                        <div class="full itinerary_dv">
                        	<?php echo $itinry['night_one']; 
								echo "<br>";
								$image_onen = $db->prepare("SELECT * FROM day_onen_image WHERE itry_pckid_none=:pcid");
								$image_onen->bindParam(':pcid',$pcid);
								$image_onen->execute();
								$allonen = $image_onen->fetchAll();
								foreach($allonen as $alonen){
									echo "<p><img src='".$url."images/itinerary_image/".$alonen['night_image_one']."' height='100px;'></p>";
								}
							?>
                        </div>
                     <?php } if($itinry['day_two']!=''){ ?> 
                     <br> <hr> 
                     	<h2 style="color:red; text-align:center;">Day 2</h2> 
                        <div class="full itinerary_dv">
                        	<?php echo $itinry['day_two']; 
								echo "<br>";
								$image_two = $db->prepare("SELECT * FROM day_two_image WHERE itry_pckid_two=:pcid");
								$image_two->bindParam(':pcid',$pcid);
								$image_two->execute();
								$alltwo = $image_two->fetchAll();
								foreach($alltwo as $altwo){
									echo "<p><img src='".$url."images/itinerary_image/".$altwo['image_two']."' height='100px;'></p>";
								}
							?>
                        </div>
                     <?php } if($itinry['night_two']!=''){ ?> 
                     <br> <hr> 
                     	<h2 style="color:red; text-align:center;">Night 2</h2> 
                        <div class="full itinerary_dv">
                        	<?php echo $itinry['night_two']; 
								echo "<br>";
								$image_twon = $db->prepare("SELECT * FROM day_twon_image WHERE itry_pckid_twon=:pcid");
								$image_twon->bindParam(':pcid',$pcid);
								$image_twon->execute();
								$alltwon = $image_twon->fetchAll();
								foreach($alltwon as $altwon){
									echo "<p><img src='".$url."images/itinerary_image/".$altwon['night_image_two']."' height='100px;'></p>";
								}
							?>
                        </div>
                     <?php } if($itinry['day_three']!=''){ ?> 
                     <br> <hr>
                     	<h2 style="color:red; text-align:center;">Day 3</h2> 
                        <div class="full itinerary_dv">
                        	<?php echo $itinry['day_three']; 
								echo "<br>";
								$image_three = $db->prepare("SELECT * FROM day_three_image WHERE itry_pckid_three=:pcid");
								$image_three->bindParam(':pcid',$pcid);
								$image_three->execute();
								$allthree = $image_three->fetchAll();
								foreach($allthree as $althree){
									echo "<p><img src='".$url."images/itinerary_image/".$althree['image_three']."' height='100px;'></p>";
								}
							?>
                        </div>
                     <?php } if($itinry['night_three']!=''){ ?> 
                     <br><hr> 
                     	<h2 style="color:red; text-align:center;">Night 3</h2> 
                        <div class="full itinerary_dv">
                        	<?php echo $itinry['night_three']; 
								echo "<br>";
								$image_threen = $db->prepare("SELECT * FROM day_threen_image WHERE itry_pckid_threen=:pcid");
								$image_threen->bindParam(':pcid',$pcid);
								$image_threen->execute();
								$allthreen = $image_threen->fetchAll();
								foreach($allthreen as $althreen){
									echo "<p><img src='".$url."images/itinerary_image/".$althreen['night_image_three']."' height='100px;'></p>";
								}
							?>
                        </div>
                     <?php } if($itinry['day_four']!=''){ ?> 
                     <br> <hr>
                     	<h2 style="color:red; text-align:center;">Day 4</h2> 
                        <div class="full itinerary_dv">
                        	<?php echo $itinry['day_four']; 
								echo "<br>";
								$image_four = $db->prepare("SELECT * FROM day_four_image WHERE itry_pckid_four=:pcid");
								$image_four->bindParam(':pcid',$pcid);
								$image_four->execute();
								$allfour = $image_four->fetchAll();
								foreach($allfour as $alfour){
									echo "<p><img src='".$url."images/itinerary_image/".$alfour['image_four']."' height='100px;'></p>";
								}
							?>
                        </div>
                      <?php } if($itinry['night_four']!=''){ ?> 
                     <br><hr> 
                     	<h2 style="color:red; text-align:center;">Night 4</h2> 
                        <div class="full itinerary_dv">
                        	<?php echo $itinry['night_four']; 
								echo "<br>";
								$image_fourn = $db->prepare("SELECT * FROM day_fourn_image WHERE itry_pckid_fourn=:pcid");
								$image_fourn->bindParam(':pcid',$pcid);
								$image_fourn->execute();
								$allfourn = $image_fourn->fetchAll();
								foreach($allfourn as $alfourn){
									echo "<p><img src='".$url."images/itinerary_image/".$alfourn['night_image_four']."' height='100px;'></p>";
								}
							?>
                        </div>
                     <?php } if($itinry['day_five']!=''){ ?> 
                     <br><hr>  
                     	<h2 style="color:red; text-align:center;">Day 5</h2> 
                        <div class="full itinerary_dv">
                        	<?php echo $itinry['day_five']; 
								echo "<br>";
								$image_five = $db->prepare("SELECT * FROM day_five_image WHERE itry_pckid_five=:pcid");
								$image_five->bindParam(':pcid',$pcid);
								$image_five->execute();
								$allfive = $image_five->fetchAll();
								foreach($allfive as $alfive){
									echo "<p><img src='".$url."images/itinerary_image/".$alfive['image_five']."' height='100px;'></p>";
								}
							?>
                        </div>
                     <?php } if($itinry['night_five']!=''){ ?> 
                     <br><hr>  
                     	<h2 style="color:red; text-align:center;">Night 5</h2> 
                        <div class="full itinerary_dv">
                        	<?php echo $itinry['night_five']; 
								echo "<br>";
								$image_fiven = $db->prepare("SELECT * FROM day_fiven_image WHERE itry_pckid_fiven=:pcid");
								$image_fiven->bindParam(':pcid',$pcid);
								$image_fiven->execute();
								$allfiven = $image_fiven->fetchAll();
								foreach($allfiven as $alfiven){
									echo "<p><img src='".$url."images/itinerary_image/".$alfiven['night_image_five']."' height='100px;'></p>";
								}
							?>
                        </div>
                     <?php } if($itinry['day_six']!=''){ ?> 
                     <br><hr>
                     	<h2 style="color:red; text-align:center;">Day 6</h2> 
                        <div class="full itinerary_dv">
                        	<?php echo $itinry['day_six']; 
								echo "<br>";
								$image_six = $db->prepare("SELECT * FROM day_six_image WHERE itry_pckid_six=:pcid");
								$image_six->bindParam(':pcid',$pcid);
								$image_six->execute();
								$allsix = $image_six->fetchAll();
								foreach($allsix as $alsix){
									echo "<p><img src='".$url."images/itinerary_image/".$alsix['image_six']."' height='100px;'></p>";
								}
							?>
                        </div>
                      <?php } if($itinry['night_six']!=''){ ?> 
                     <br><hr>  
                     	<h2 style="color:red; text-align:center;">Night 6</h2> 
                        <div class="full itinerary_dv">
                        	<?php echo $itinry['night_six']; 
								echo "<br>";
								$image_sixn = $db->prepare("SELECT * FROM day_six_image WHERE itry_pckid_sixn=:pcid");
								$image_sixn->bindParam(':pcid',$pcid);
								$image_sixn->execute();
								$allsixn = $image_six->fetchAll();
								foreach($allsixn as $alsixn){
									echo "<p><img src='".$url."images/itinerary_image/".$alsixn['night_image_six']."' height='100px;'></p>";
								}
							?>
                        </div>
                     <?php } if($itinry['day_seven']!=''){ ?> 
                     <br><hr>
                      	<h2 style="color:red; text-align:center;">Day 7</h2> 
                        <div class="full itinerary_dv">
                        	<?php echo $itinry['day_seven']; 
								echo "<br>";
								$image_sevn = $db->prepare("SELECT * FROM day_sevn_image WHERE itry_pckid_sevn=:pcid");
								$image_sevn->bindParam(':pcid',$pcid);
								$image_sevn->execute();
								$allsevn = $image_sevn->fetchAll();
								foreach($allsevn as $alsevn){
									echo "<p><img src='".$url."images/itinerary_image/".$alsevn['image_seven']."' height='100px;'></p>";
								}
							?>
                        </div>
                     <?php } if($itinry['night_seven']!=''){ ?> 
                     <br><hr>
                     	<h2 style="color:red; text-align:center;">Night 7</h2> 
                        <div class="full itinerary_dv">
                        	<?php echo $itinry['night_seven']; 
								echo "<br>";
								$image_sevnn = $db->prepare("SELECT * FROM day_sevnn_image WHERE itry_pckid_sevnn=:pcid");
								$image_sevnn->bindParam(':pcid',$pcid);
								$image_sevnn->execute();
								$allsevnn = $image_sevn->fetchAll();
								foreach($allsevnn as $alsevnn){
									echo "<p><img src='".$url."images/itinerary_image/".$alsevnn['night_image_seven']."' height='100px;'></p>";
								}
							?>
                        </div>
                     <?php } ?>
                    </div>
                    
                    <div class="col-md-4"  style="margin-top: 4px;">
                    	<div class="fulldv hol_include">
                        	<h4>Hotel included in package: </h4>
                            <ul class="ratingul">
                            	<li><input type="radio" name="star"><?php echo $row['hotel_rating']; ?> Star</li>
                            </ul>
                            <p>
                              <?php
									$pck_activity = $db->prepare("SELECT act.activity_name FROM pack_activity pac JOIN add_activity act ON act.activity_id=pac.activt_id WHERE pack_id=:pcid");
									$pck_activity->bindParam(':pcid',$pcid);
									$pck_activity->execute();
									$alcp = $pck_activity->fetchAll();
									foreach($alcp as $cp){
								?>
                                    <li><?php echo $cp['activity_name']; ?></li>
                                <?php } ?>
                            </p>
                        
                       
                            <strong style="margin-top: -4px; margin-bottom: 3px;">State: <?php echo $row['state_name']; ?>(<?php echo $row['duration_day']; ?>D)</strong>
                            <ul class="cities_avval">
                            	<li><i class="fa fa-plane"></i><br> Flights</li>
                            	<li><i class="fa fa-star"></i><br>Upto 3 Stars</li>
                            	<li><i class="fa fa-cutlery"></i><br>Breakfast</li>
                            	<li><i class="fa fa-eye"></i><br>Sightseeing</li>
                            	<li><i class="fa fa-car"></i><br>Transfers</li>
                            </ul>
                            <div class="fulldv">
                            	<div class="col-md-6 p0 statingfrom">
                                	<p>Starting from:</p>
                                    <h4><i class="fa fa-rupee"></i><?php echo $row['pack_price']; ?>/-<!--<span> <i class="fa fa-rupee"></i> 12,613</span>--></h4>
                                    <p>Per Person on twin sharing</p>
                                </div>
                                <div class="col-md-6 p0 statingfrom formonth">
                                	<p>Price For The Month</p>
                                    <select name="" id="">
                                    	<option value="">Apr 2019</option>
                                        <option value="">Mar 2019</option>
                                        <option value="">Jun 2019</option>
                                        <option value="">Jul 2019</option>
                                        <option value="">Aug 2019</option>
                                        <option value="">Not Decided</option>
                                    </select>
                                </div>
                            </div>
                              
                        </div>
                        
                        <div class="fulldv planyour">
                        	<p>Plan your travel now!</p>
                            <input type="email" name="#" placeholder="Email ID">
                            <input type="text" name="#" placeholder="Mobile No." onKeyUp="onlydigit(this)">
                            <input type="submit" name="#" value="Customize & Get Quotes">
                        </div>
                        
                        <div class="fulldv planyour">
                        	<h4>Your Preferences</h4>
                            <p>To</p>
                            <input type="text" name="#">
                            <p><input type="checkbox" name="#"> I am exploring destinations</p>
                            <p>From</p>
                            <input type="text" name="#">
                            <p>Departure Date (Choose Any)</p>
                            <div class="fulldv chooseany">
                            	<label for=""><input type="checkbox" name="#">Fixed</label>
                                <label for=""><input type="checkbox" name="#">Flexible</label>
                                <label for=""><input type="checkbox" name="#">Anytime</label>
                            </div>
                            <p>Email ID</p>
                            <input type="email" name="#" placeholder="Email ID">
                            <p>Mobile No.</p>
                            <input type="text" name="#" placeholder="Mobile No." onKeyUp="onlydigit(this)">
                            <input type="submit" name="#" value="Plan My Holydays">
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


 <div class="section honeymoon_sect">
    	<div class="container">
        	<div class="row">
            
                
                <div class="col-md-12 p0 product-data">
               		
		  <?php
			 if($stttid!='' && $durtion!='' && $mnth!=''){
				  $cat_package = $db->prepare("SELECT pk.*,stt.state_name FROM packages pk JOIN state stt ON stt.state_id=pk.stid WHERE pk.package_duration=:durtion AND pk.stid=:stttid AND pk.season_from=:mnth");
				  $cat_package->bindParam(':durtion',$durtion);
				  $cat_package->bindParam(':stttid',$stttid);
				  $cat_package->bindParam(':mnth',$mnth);
				  $cat_package->execute();
				  $rows = $cat_package->fetchAll();
			}
			elseif($stttid!='' && $durtion=='' && $mnth==''){
				  $cat_package = $db->prepare("SELECT pk.*,stt.state_name FROM packages pk JOIN state stt ON stt.state_id=pk.stid WHERE pk.stid=:stttid");
				  $cat_package->bindParam(':stttid',$stttid);
				  $cat_package->execute();
				  $rows = $cat_package->fetchAll();
			}
			elseif($stttid!='' && $durtion!='' && $mnth==''){
				  $cat_package = $db->prepare("SELECT pk.*,stt.state_name FROM packages pk JOIN state stt ON stt.state_id=pk.stid WHERE pk.package_duration=:durtion AND pk.stid=:stttid");
				  $cat_package->bindParam(':durtion',$durtion);
				  $cat_package->bindParam(':stttid',$stttid);
				  $cat_package->execute();
				  $rows = $cat_package->fetchAll();
			}
			elseif($stttid!='' && $durtion=='' && $mnth!=''){
				  $cat_package = $db->prepare("SELECT pk.*,stt.state_name FROM packages pk JOIN state stt ON stt.state_id=pk.stid WHERE pk.stid=:stttid AND pk.season_from=:mnth");
				  $cat_package->bindParam(':stttid',$stttid);
				  $cat_package->bindParam(':mnth',$mnth);
				  $cat_package->execute();
				  $rows = $cat_package->fetchAll();
			}
			elseif($stttid=='' && $durtion!='' && $mnth!=''){
				  $cat_package = $db->prepare("SELECT pk.*,stt.state_name FROM packages pk JOIN state stt ON stt.state_id=pk.stid WHERE pk.package_duration=:durtion AND pk.season_from=:mnth");
				  $cat_package->bindParam(':durtion',$durtion);
				  $cat_package->bindParam(':mnth',$mnth);
				  $cat_package->execute();
				  $rows = $cat_package->fetchAll();
			}
			elseif($stttid=='' && $durtion!='' && $mnth==''){
				  $cat_package = $db->prepare("SELECT pk.*,stt.state_name FROM packages pk JOIN state stt ON stt.state_id=pk.stid WHERE pk.package_duration=:durtion");
				  $cat_package->bindParam(':durtion',$durtion);
				  $cat_package->execute();
				  $rows = $cat_package->fetchAll();
			}
			elseif($stttid=='' && $durtion=='' && $mnth!=''){
				  $cat_package = $db->prepare("SELECT pk.*,stt.state_name FROM packages pk JOIN state stt ON stt.state_id=pk.stid WHERE pk.season_from=:mnth");
				  $cat_package->bindParam(':mnth',$mnth);
				  $cat_package->execute();
				  $rows = $cat_package->fetchAll();
			}
				
				
			   	  
				  if(count($rows)){
					  foreach($rows as $row){
						  $pckid = $row['package_id'];
						   
						  		$show_image = $db->prepare("SELECT p_image FROM package_images WHERE img_pckid=:pckid LIMIT 1");
								$show_image->bindParam(':pckid',$pckid);
								$show_image->execute();
								$alimgs = $show_image->fetchAll();
								foreach($alimgs as $alm){
			   ?> 
               	  <div class="col-md-6 search_result_main_out wow fadeInUp">
                      <div class="fulldv search_result_main">
                        <div class="theme_mg" style="background:url(<?php echo $url; ?>images/package_image/<?php echo $alm['p_image']; ?>) center center; background-size:cover;">
                            <span><i class="fa fa-star"></i> 4.5</span>
                        </div>
                        <div class="fulldv theme_txt">
                             <div class="col-md-12 p0">
                                 <h4 style="margin-top: -4px; margin-bottom: 3px;"><?php echo $row['resort_name']; ?></h4>
                                 </div>
                                 <div class="col-md-12 p0">
                                 <h5 style="margin-top: -4px; margin-bottom: 3px;"><?php echo $row['duration_day']; ?> Days & <?php echo $row['duration_night']; ?> Nights</h5>
                                 </div>
                            <div class="col-md-12 p0">
                                <div class="timedv">
                                    <p>Best Time</p>
                                    <span><?php echo $row['season_from']; ?> - <?php echo $row['season_to']; ?></span>
                                </div>
                                <div class="timedv">
                                    <p>Price</p>
                                    <span><?php echo $row['pack_price']; ?></span>
                                </div>
                                <div class="timedv priper">
                                    <p><span><i class="fa fa-rupee"></i> <?php echo $row['budget_from']; ?> to <?php echo $row['budget_to']; ?></span> / per person</p>
                                    <p>(Flight <?php echo $row['flight_status']; ?>)</p>
                                </div>
                            </div>
                            <div class="col-md-12 p0">
                            Hotel included in package:   <strong><?php echo $row['hotel_rating']; ?> Star</strong>
                            </div>
                            <div class="col-md-12 p0">
                                <h4 style="margin-top: -4px; margin-bottom: 3px;"><?php echo $row['state_name']; ?></h4>
                                <ul>
                                <?php
									$pck_activity = $db->prepare("SELECT act.activity_name FROM pack_activity pac JOIN add_activity act ON act.activity_id=pac.activt_id WHERE pack_id=:pckid");
									$pck_activity->bindParam(':pckid',$pckid);
									$pck_activity->execute();
									$alcp = $pck_activity->fetchAll();
									foreach($alcp as $cp){
								?>
                                    <li><?php echo $cp['activity_name']; ?></li>
                                <?php } ?>    
                                </ul>
                                <div class="clearfix"></div>
                                <a href="#" onClick="moreinfo()">More Info</a>
                                <a href="<?php echo $url; ?>detail/<?php echo $row['package_uniq']; ?>" style="background:none; color:#000;">View detail</a>
                            </div>
                        </div>
                      </div>
                  </div>
               <?php } } } else{ echo "No Package Found"; } ?>   
                  <div class="clearfix"></div>
                  <div class="col-md-12">
                  	  <ul class="pagination pagination-sm wow fadeInUp">
                          <?php 
						if(isset($page)){
							$countfiles = $db->prepare("SELECT COUNT(package_id) FROM packages WHERE cattid=:cteid");
							$countfiles->bindParam(':cteid',$cteid);
							$countfiles->execute();
							$totalfile = $countfiles->fetchColumn();
							if($totalfile > 6){
							$totalPages = ceil($totalfile / $perpage);
								if($page <=1 ){
										echo "<li class='disabled' id='page_links'><a>Prev</a></li>";
								}
								else{
									$j = $page - 1;
									echo "<li><a id='page_a_link' href='".$url."category/".$cturl."/".$j."'>Prev</a></li>";
								}
								
								for($i=1; $i <= $totalPages; $i++){
								if($i<>$page){
									echo "<li><a id='page_a_link' href='".$url."category/".$cturl."/".$i."'>$i</a></li>";
								}
								else{
									echo "<li class='active' id='page_links'><a>$i</a></li>";
								}
								}
								if($page == $totalPages ){
									echo "<li class='disabled' id='page_links'><a>Next</a></li>";
								}
								else{
									$j = $page + 1;
									echo "<li><a id='page_a_link' href='".$url."category/".$cturl."/".$j."'>Next</a></li>";
								}
						}
						}
						  ?>
                      </ul>
                  </div>
                </div>
                
            </div>
        </div>
    </div> 

    <!-- Footer Section -->
    <?php include('footer.php') ?>

</div>

<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.slitslider.js"></script>
<script src="js/jquery.ba-cond.min.js"></script>
<!-- Custom Functions -->
<script src="js/main.js"></script> 

<script src="<?php echo $url; ?>js/slick.js" type="text/javascript"></script>
<script src="<?php echo $url; ?>js/custom.js" type="text/javascript"></script>
<script src="<?php echo $url; ?>js/jarallax.js" type="text/javascript"></script>
<script>
	  $(document).ready(function(){
    	$(function(){
		$( "#datepicker" ).datepicker({
			minDate: 'dateToday',
			dateFormat: 'yy-m-d', 
			onSelect: function(selected){ 
			$("#datepicker2").datepicker("option","minDate",selected);
         }
		});
	 });
	 
	 $(function() {
		$( "#datepicker2" ).datepicker({
			dateFormat: 'yy-m-d',
			onSelect: function(selected){
				$("#datepicker").datepicker("option","maxDate",selected);
            }
		});
	 });
  });
    </script>
<script type="text/javascript">
	/* init Jarallax */
	$('.jarallax').jarallax({
		speed: 0.5,
		imgWidth: 1366,
		imgHeight: 768
	})
</script>
<script>
$('.headslider').slick({
  dots: true,
  autoplay: true,
  infinite: true,
  //fade: true,
  speed: 1000,
  autoplaySpeed: 3000,
  slidesToShow: 1,
  slidesToScroll: 1,
  cssEase: 'ease'
});

$('.feature_slider').slick({
  dots: true,
  autoplay: true,
  infinite: true,
  //fade: true,
  speed: 1000,
  autoplaySpeed: 3000,
  slidesToShow: 5,
  slidesToScroll: 1,
  cssEase: 'ease'
});

$('.international_slider').slick({
  dots: true,
  autoplay: true,
  infinite: true,
  //fade: true,
  speed: 1000,
  autoplaySpeed: 3000,
  slidesToShow: 4,
  slidesToScroll: 1,
  cssEase: 'ease'
});

$('.budget_slider').slick({
  dots: true,
  autoplay: true,
  infinite: true,
  //fade: true,
  speed: 1000,
  autoplaySpeed: 3000,
  slidesToShow: 3,
  slidesToScroll: 1,
  cssEase: 'ease'
});

$('.testi-slide').slick({
  dots: true,
  autoplay: true,
  infinite: true,
  fade: true,
  speed: 1000,
  autoplaySpeed: 3000,
  slidesToShow: 1,
  slidesToScroll: 1,
  cssEase: 'ease'
});

function popclose() {
	$('.hidepop').fadeToggle();
	}
</script>



</body>
</html>
<?php } } else { echo "No Detail Found"; } 
} else { echo "No Detail Found"; }
?>

