<?php
//error_reporting(0);
session_start();
include('function.php'); 
include('connection/index.php');
require_once('settings.php');
	
	if(isset($_POST['showresult'])){
		$sname = $_POST['typeahead'];
		$getsteid = $db->prepare("SELECT state_id FROM state WHERE state_name=:sname");
		$getsteid->bindParam(':sname',$sname);
		$getsteid->execute();
		$rwid = $getsteid->fetch();
		$stid = $rwid['state_id'];
		$durtion = $_POST['pckdurtion'];
		$sesonfrom = $_POST['sesonfrom'];
		
		    if($sname!='' && $durtion!='' && $sesonfrom!=''){
				echo "<script>location.assign('".$url."search?state=".$stid."&durtion=".urlencode($durtion)."&mnth=".$sesonfrom."')</script>";
			}
			elseif($stttid!='' && $durtion=='' && $sesonfrom==''){
				echo "<script>location.assign('".$url."search?state=".$stid."')</script>";
			}
			elseif($stttid!='' && $durtion!='' && $sesonfrom==''){
				echo "<script>location.assign('".$url."search?state=".$stid."&durtion=".urlencode($durtion)."')</script>";
			}
			elseif($stttid!='' && $durtion=='' && $sesonfrom!=''){
				echo "<script>location.assign('".$url."search?state=".$stid."&mnth=".$sesonfrom."')</script>";
			}
			elseif($stttid=='' && $durtion!='' && $sesonfrom!=''){
				echo "<script>location.assign('".$url."search?durtion=".urlencode($durtion)."&mnth=".$sesonfrom."')</script>";
			}
			elseif($stttid=='' && $durtion!='' && $sesonfrom==''){
				echo "<script>location.assign('".$url."search?durtion=".urlencode($durtion)."')</script>";
			}
			elseif($stttid=='' && $durtion=='' && $sesonfrom!=''){
				echo "<script>location.assign('".$url."search?mnth=".$sesonfrom."')</script>";
			}
		
	}
?>
<!DOCTYPE html>
<html lang="en-IN">
<head>
    <?php echo headdata(); ?>
    <link rel="canonical" href=""/>
    <link rel='shortlink' href=""/>
	<title>Welcome to travel.com</title>
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
    <script src="typeahead.min.js"></script>
    <script>
	$(document).ready(function(){
	$('input.typeahead').typeahead({
		name: 'typeahead',
		remote:'<?php echo $url; ?>headersearch.php?key=%QUERY',
		limit : 100
	});
	});
</script>
</head>
<body>
<div class="see-section wrapper">

    <div class="overlaydv hidepop" style="background:rgba(0,0,0,0.9); position:fixed; width:100%; height:100%; top:0; left:0; z-index:999999; display:none;">
    <div class="callback" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-body">
             <button type="button" class="close" onClick="popclose()"><a>&times;</a></button>
             <div class="result">
               <form method="post" id="contact-form">
                    <div class="form_maindv_in">
                        <h2>Hey there! Tell us more about your plan for us to serve you better. 1</h2>
                        <label for="one" class="radiolabel">
                            <input type="radio" id="one" name="honeymoon"> i am planning my honeymoon trip
                        </label>
                        <label for="one2" class="radiolabel">
                            <input type="radio" id="one2" name="honeymoon"> i am planning my honeymoon trip
                        </label>
                        <label for="one3" class="radiolabel">
                            <input type="radio" id="one3" name="honeymoon"> i am planning my honeymoon trip
                        </label>
                        <input type="submit" class="see-button" name="submit" value="Get a Call back">
                    </div>
               </form>
              </div> 
             </div>
          </div>
        </div>
      </div>
  </div>                    


<div class="home_nav">
<?php include('header.php'); ?>
</div>

<div class="slider_maindv">
    <!--<section class="regular headslider">
    	<img src="images/sliderimage/slider1.jpg" alt=""/> 
        <img src="images/sliderimage/slider2.jpg" alt=""/> 
    </section> -->
    <section id="home-slider">
            <div id="slider" class="sl-slider-wrapper">

				<div class="sl-slider">
				
					<div class="sl-slide" data-orientation="horizontal" data-slice1-rotation="-25" data-slice2-rotation="-25" data-slice1-scale="2" data-slice2-scale="2">

						<div class="bg-img bg-img-1"></div>
						
					</div>
					
					<div class="sl-slide" data-orientation="vertical" data-slice1-rotation="10" data-slice2-rotation="-15" data-slice1-scale="1.5" data-slice2-scale="1.5">
					
						<div class="bg-img bg-img-2"></div>
						
					</div>
					
					<div class="sl-slide" data-orientation="horizontal" data-slice1-rotation="3" data-slice2-rotation="3" data-slice1-scale="2" data-slice2-scale="1">
						
						<div class="bg-img bg-img-3"></div>

					</div>

				</div><!-- /sl-slider -->

                <!-- 
                <nav id="nav-arrows" class="nav-arrows">
                    <span class="nav-arrow-prev">Previous</span>
                    <span class="nav-arrow-next">Next</span>
                </nav>
                -->
                
                <nav id="nav-arrows" class="nav-arrows hidden-xs hidden-sm visible-md visible-lg">
                    <a href="javascript:;" class="sl-prev">
                        <i class="fa fa-angle-left fa-3x"></i>                    </a>
                    <a href="javascript:;" class="sl-next">
<i class="fa fa-angle-right fa-3x"></i>                    </a>                </nav>
                

				<nav id="nav-dots" class="nav-dots visible-xs visible-sm hidden-md hidden-lg">
					<span class="nav-dot-current"></span>
					<span></span>
					<span></span>				</nav>

			</div><!-- /slider-wrapper -->
		</section>
    
   
    <div class="frentface">
        <div class="background transparent-one">
            <h1 class="wow fadeInDown"> # Discover Journeys of a lifetime </h1>
            
            <div class="searchbar wow fadeInUp">
                <form method="post">
                    <input type="text" name="typeahead" class="typeahead search-inhead" placeholder="Where to Go ?" autocomplete="off"/>
                 <select name="pckdurtion">
                	<option value="" hidden="hidden">Select</option>
                    <option value="1 to 3 Days">1 to 3 Days</option>
                    <option value="4 to 6 Days">4 to 6 Days</option>
                    <option value="7 to 9 Days">7 to 9 Days</option>
                    <option value="10 to 12 Days">10 to 12 Days</option>
                    <option value="13 Days or More">13 Days or More</option>
                </select>
                <select name="sesonfrom">
                	<option value="" hidden="hidden">Select</option>
                    <option value="January">January</option>
                    <option value="February">February</option>
                    <option value="March">March</option>
                    <option value="April">April</option>
                    <option value="May">May</option>
                    <option value="June">June</option>
                    <option value="July">July</option>
                    <option value="August">August</option>
                    <option value="September">September</option>
                    <option value="October">October</option>
                    <option value="November">November</option>
                    <option value="December">December</option>
                </select>
                    <input type="submit" name="showresult" value="Find Now"/>
                    <div id="citylist"></div>
                </form>
            </div>
        </div>
        
        <div class="dark-dv"></div>
    </div>
</div>


<div class="section citydiv-sect">
    <div class="container">
        <div class="row">
        <div class="col-md-12">
            <h3 class="title-hadding wow fadeInDown">Explore Destinations through Holiday Themes</h3>
            <section class="regular feature_slider wow fadeInUp">
            <?php
				$cat_sldir = $db->prepare("SELECT * FROM category ORDER BY categoryid DESC");
				$cat_sldir->execute();
				$rowscat = $cat_sldir->fetchAll();
				foreach($rowscat as $rwcat){
					$ctid = $rwcat['categoryid'];
						$countcat = $db->prepare("SELECT COUNT(package_id) FROM packages WHERE cattid=:ctid");
						$countcat->bindParam(':ctid',$ctid);
						$countcat->execute();
						$ccat = $countcat->fetchColumn();
			?>
                <div class="col-md-12 p0 feature_sld">
                    <div class="col-md-12 feature_sld_in">
                       <a href="<?php echo $url; ?>category/<?php echo $rwcat['category_url']; ?>">
                        <img src="<?php echo $url; ?>images/category_image/<?php echo $rwcat['category_image']; ?>" alt=""/> 
                        <div class="col-md-12 feature_sld_text">
                            <p><?php echo $rwcat['categoryname']; ?></p>
                            <span><?php echo $ccat; ?>+ destinations</span>
                        </div>
                        </a>
                    </div>
                </div>
          <?php } ?>      
            </section>
        </div>
        </div>
    </div>
</div>

<?php
	$intrnationl = $db->prepare("SELECT DISTINCT(country_name),country_id,country_url FROM country WHERE country_id IN (SELECT cntid FROM packages) ORDER BY country_name ASC ");
	$intrnationl->execute();
	$ints = $intrnationl->fetchAll();
	if(count($ints)){
?>
<div class="explore-full">
	<div class="container">
    	<div class="row">
            <div class="std-dv100">
                <h2 class="title-hadding wow fadeInDown">Packages for Best-Selling Destinations in the World</h2>
            </div>
            <section class="regular international_slider wow fadeInLeft">
            <?php
			foreach($ints as $innt){
				$psteid = $innt['country_id'];
				$get_intpckg = $db->prepare("SELECT package_id FROM packages WHERE cntid=:psteid LIMIT 1");
				$get_intpckg->bindParam(':psteid',$psteid);
				$get_intpckg->execute();
				$only_onepck = $get_intpckg->fetchAll();
				foreach($only_onepck as $one){
					$pckid = $one['package_id'];
					$count_packge = $db->prepare("SELECT COUNT(package_id) FROM packages WHERE cntid=:psteid");
					$count_packge->bindParam(':psteid',$psteid);
					$count_packge->execute();
					$cpkg = $count_packge->fetchColumn();
						$pck_img = $db->prepare("SELECT p_image FROM package_images WHERE img_pckid=:pckid ORDER BY pimage_id DESC LIMIT 1");
						$pck_img->bindParam(':pckid',$pckid);
						$pck_img->execute();
						$fnimg = $pck_img->fetchAll();
						foreach($fnimg as $fimg){
			?>
   				 <div class="span2">
                    <div class="state-dv" style="background:url(<?php echo $url; ?>images/package_image/<?php echo $fimg['p_image']; ?>) center no-repeat; background-size:cover;">
                        <a href="<?php echo $url; ?>country/<?php echo $innt['country_url']; ?>">
                        <div class="state-overlay">
                            <div class="state-overlay-in">
                                <h4><?php echo $innt['country_name']; ?></h4>
                                <h3><?php echo $cpkg; ?>+ packages</h3>
                                <!--<h3>Package Price <?php echo $stmt['pack_price']; ?>/-</h3>-->
                                <p>Know More</p>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
            <?php } } } ?>    
            </section>
        </div>
	</div>
</div>
<?php } 
	$indian_pckgs = $db->prepare("SELECT DISTINCT(state_name),state_id,state_url FROM state WHERE state_id IN (SELECT stid FROM packages) ORDER BY state_name ASC");
	$indian_pckgs->execute();
	$stepckg = $indian_pckgs->fetchAll();
	if(count($stepckg)){
?>
<div class="section citydiv-sect">
    <div class="container">
    	<div class="row">
            <div class="col-md-12">
                <h3 class="title-hadding wow fadeInDown">Packages for Best-Selling Destinations in India</h3>
                <section class="regular feature_slider wow fadeInRight">
                <?php
				  foreach($stepckg as $stind){
					$pisteid = $stind['state_id'];  
					$get_indpckg = $db->prepare("SELECT package_id,pack_price FROM packages WHERE stid=:pisteid LIMIT 1");
					$get_indpckg->bindParam(':pisteid',$pisteid);
					$get_indpckg->execute();
					$only_onpck = $get_indpckg->fetchAll();
				   foreach($only_onpck as $onl){
					$pickid = $onl['package_id'];
					$count_indpackge = $db->prepare("SELECT COUNT(package_id) FROM packages WHERE stid=:pisteid");
					$count_indpackge->bindParam(':pisteid',$pisteid);
					$count_indpackge->execute();
					$cipkg = $count_indpackge->fetchColumn();
						$inpck_img = $db->prepare("SELECT p_image FROM package_images WHERE img_pckid=:pickid ORDER BY pimage_id DESC LIMIT 1");
						$inpck_img->bindParam(':pickid',$pickid);
						$inpck_img->execute();
						$fidnimg = $inpck_img->fetchAll();
						foreach($fidnimg as $finmg){
				?>
                    <div class="col-md-12 p0 feature_sld">
                        <div class="col-md-12 feature_sld_in">
                        <a href="<?php echo $url; ?>state/<?php echo $stind['state_url']; ?>">
                            <div class="destination_mg" style="background:url(<?php echo $url; ?>images/package_image/<?php echo $finmg['p_image']; ?>) center center; background-size:cover;"></div>
                            <div class="col-md-12 feature_sld_text">
                                <p><?php echo $stind['state_name']; ?></p>
                                <span><?php echo $cipkg; ?>+ Packages</span>
                                <div class="clearfix"></div>
                                <span>Starting From <strong><i class="fa fa-rupee"></i> <?php echo $onl['pack_price']; ?>/-</strong></span>
                            </div>
                            </a>
                        </div>
                    </div>
                <?php } } }?>     
                </section>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<div class="section budget_sect">
    <div class="container">
    	<div class="row">
            <div class="col-md-12">
                <h3 class="title-hadding wow fadeInDown">Best priced packages within your BUDGET</h3>
                <div class="col-md-12 p0 budget_tab wow fadeInUp">
                    <ul class="nav nav-tabs">
                      <li class="active"><a data-toggle="tab" href="#bt1">Less than Rs. 10,000</a></li>
                      <li><a data-toggle="tab" href="#bt2">Rs. 10,000 to Rs. 20,000</a></li>
                      <li><a data-toggle="tab" href="#bt3">Rs. 20,000 to Rs. 40,000</a></li>
                      <li><a data-toggle="tab" href="#bt4">Rs. 40,000 to Rs. 60,000</a></li>
                      <li><a data-toggle="tab" href="#bt5">Rs. 60,000 to Rs. 80,000</a></li>
                      <li><a data-toggle="tab" href="#bt6">Above Rs. 80,000</a></li>
                    </ul>
                </div>
                
                <div class="col-md-12 budget_tab_content">
                    <div class="tab-content wow fadeInLeft">
                    
                      <div id="bt1" class="tab-pane fade in active">
                      <?php
					    $show_budgetpck = $db->prepare("SELECT DISTINCT(bste.state_name),bpck.*,cte.categoryname FROM packages bpck JOIN state bste ON bste.state_id=bpck.stid JOIN category cte ON cte.categoryid=bpck.cattid WHERE pack_price BETWEEN 0 AND 10000 ORDER BY package_id DESC LIMIT 0,10");	
					    $show_budgetpck->execute();
					    $allbudgpck = $show_budgetpck->fetchAll();
					  	  foreach($allbudgpck as $bdgt){
							$bdpickid = $bdgt['package_id'];
								$inpck_img = $db->prepare("SELECT p_image FROM package_images WHERE img_pckid=:bdpickid ORDER BY pimage_id DESC LIMIT 1");
								$inpck_img->bindParam(':bdpickid',$bdpickid);
								$inpck_img->execute();
								$fidnimg = $inpck_img->fetchAll();
								foreach($fidnimg as $finmg){
					  ?>
                            <div class="col-md-4 feature_sld">
                                <div class="col-md-12 feature_sld_in">
                                <a href="<?php echo $url; ?>detail/<?php echo $bdgt['package_uniq']; ?>">
                                    <div class="packages_mg" style="background:url(<?php echo $url; ?>images/package_image/<?php echo $finmg['p_image']; ?>) center center;" style="background-size:cover;"></div>
                                    <div class="col-md-12 budget_sld_text">
                                        <h4><?php echo $bdgt['state_name']; ?> <?php echo $bdgt['categoryname']; ?></h4>
                                        <p><strong><?php echo $bdgt['state_name']; ?></strong> (<?php echo $bdgt['duration_day']; ?> Days & <?php echo $bdgt['duration_night']; ?> Nights)</p>
                                        <div class="clearfix"></div>
                                        <p><strong><i class="fa fa-rupee"></i> <?php echo $bdgt['budget_from']; ?>/-</strong> Per Person</p>
                                    </div>
                                    </a>
                                </div>
                            </div>
                        <?php } } ?>    
                      </div>
                      
                  	  <div id="bt2" class="tab-pane fade">
                      <?php
					  	  $show_budgetpck1 = $db->prepare("SELECT DISTINCT(bste.state_name),bpck.*,cte.categoryname FROM packages bpck JOIN state bste ON bste.state_id=bpck.stid JOIN category cte ON cte.categoryid=bpck.cattid WHERE pack_price BETWEEN 10000 AND 20000 ORDER BY package_id DESC LIMIT 0,10");	
						  $show_budgetpck1->execute();
						  $allbudgpck1 = $show_budgetpck1->fetchAll();
					  	  foreach($allbudgpck1 as $bdgt1){
							$bdpickid1 = $bdgt1['package_id'];
							  $inpck_img1 = $db->prepare("SELECT p_image FROM package_images WHERE img_pckid=:bdpickid1 ORDER BY pimage_id DESC LIMIT 1");
							  $inpck_img1->bindParam(':bdpickid1',$bdpickid1);
							  $inpck_img1->execute();
							  $fidnimg1 = $inpck_img1->fetchAll();
							  foreach($fidnimg1 as $finmg1){
					  ?>
                            <div class="col-md-4 feature_sld">
                                <div class="col-md-12 feature_sld_in">
                           			<a href="<?php echo $url; ?>detail/<?php echo $bdgt1['package_uniq']; ?>">
                                    <div class="packages_mg" style="background:url(<?php echo $url; ?>images/package_image/<?php echo $finmg1['p_image']; ?>) center center;" style="background-size:cover;"></div>
                                    <div class="col-md-12 budget_sld_text">
                                        <h4><?php echo $bdgt1['state_name']; ?> <?php echo $bdgt1['categoryname']; ?></h4>
                                        <p><strong><?php echo $bdgt1['state_name']; ?></strong> (<?php echo $bdgt1['duration_day']; ?> Days & <?php echo $bdgt1['duration_night']; ?> Nights)</p>
                                        <div class="clearfix"></div>
                                        <p><strong><i class="fa fa-rupee"></i> <?php echo $bdgt1['budget_from']; ?>/-</strong> Per Person</p>
                                    </div>
                                </a>
                                </div>
                            </div>
                         <?php } } ?>   
                      </div>
                      
                      <div id="bt3" class="tab-pane fade">
                      <?php
					  	  $show_budgetpck2 = $db->prepare("SELECT DISTINCT(bste.state_name),bpck.*,cte.categoryname FROM packages bpck JOIN state bste ON bste.state_id=bpck.stid JOIN category cte ON cte.categoryid=bpck.cattid WHERE pack_price BETWEEN 20000 AND 40000 ORDER BY package_id DESC LIMIT 0,10");	
					      $show_budgetpck2->execute();
					      $allbudgpck2 = $show_budgetpck2->fetchAll();
					  	  foreach($allbudgpck2 as $bdgt2){
							$bdpickid2 = $bdgt2['package_id'];
							  $inpck_img2 = $db->prepare("SELECT p_image FROM package_images WHERE img_pckid=:bdpickid2 ORDER BY pimage_id DESC LIMIT 1");
							  $inpck_img2->bindParam(':bdpickid2',$bdpickid2);
							  $inpck_img2->execute();
							  $fidnimg2 = $inpck_img2->fetchAll();
							  foreach($fidnimg2 as $finmg2){
					  ?>
                            <div class="col-md-4 feature_sld">
                                <div class="col-md-12 feature_sld_in">
                           			<a href="<?php echo $url; ?>detail/<?php echo $bdgt2['package_uniq']; ?>">
                                    <div class="packages_mg" style="background:url(<?php echo $url; ?>images/package_image/<?php echo $finmg2['p_image']; ?>) center center;" style="background-size:cover;"></div>
                                    <div class="col-md-12 budget_sld_text">
                                        <h4><?php echo $bdgt2['state_name']; ?> <?php echo $bdgt2['categoryname']; ?></h4>
                                        <p><strong><?php echo $bdgt2['state_name']; ?></strong> (<?php echo $bdgt2['duration_day']; ?> Days & <?php echo $bdgt2['duration_night']; ?> Nights)</p>
                                        <div class="clearfix"></div>
                                        <p><strong><i class="fa fa-rupee"></i> <?php echo $bdgt2['budget_from']; ?>/-</strong> Per Person</p>
                                    </div>
                                </a>
                                </div>
                            </div>
                         <?php } } ?>   
                     </div>
                     
                      <div id="bt4" class="tab-pane fade">
                       <?php
					   	  $show_budgetpck3 = $db->prepare("SELECT DISTINCT(bste.state_name),bpck.*,cte.categoryname FROM packages bpck JOIN state bste ON bste.state_id=bpck.stid JOIN category cte ON cte.categoryid=bpck.cattid WHERE pack_price BETWEEN 40000 AND 60000 ORDER BY package_id DESC LIMIT 0,10");	
						  $show_budgetpck3->execute();
						  $allbudgpck3 = $show_budgetpck3->fetchAll();
					  	  foreach($allbudgpck3 as $bdgt3){
							$bdpickid3 = $bdgt3['package_id'];
							  $inpck_img3 = $db->prepare("SELECT p_image FROM package_images WHERE img_pckid=:bdpickid3 ORDER BY pimage_id DESC LIMIT 1");
							  $inpck_img3->bindParam(':bdpickid3',$bdpickid3);
							  $inpck_img3->execute();
							  $fidnimg3 = $inpck_img3->fetchAll();
							  foreach($fidnimg3 as $finmg3){
					    ?>
                            <div class="col-md-4 feature_sld">
                                <div class="col-md-12 feature_sld_in">
                           			<a href="<?php echo $url; ?>detail/<?php echo $bdgt3['package_uniq']; ?>">
                                    <div class="packages_mg" style="background:url(<?php echo $url; ?>images/package_image/<?php echo $finmg3['p_image']; ?>) center center;" style="background-size:cover;"></div>
                                    <div class="col-md-12 budget_sld_text">
                                        <h4><?php echo $bdgt3['state_name']; ?> <?php echo $bdgt3['categoryname']; ?></h4>
                                        <p><strong><?php echo $bdgt3['state_name']; ?></strong> (<?php echo $bdgt3['duration_day']; ?> Days & <?php echo $bdgt3['duration_night']; ?> Nights)</p>
                                        <div class="clearfix"></div>
                                        <p><strong><i class="fa fa-rupee"></i> <?php echo $bdgt3['budget_from']; ?>/-</strong> Per Person</p>
                                    </div>
                                </a>
                                </div>
                            </div>
                          <?php } } ?>   
                      </div>
                      
                      <div id="bt5" class="tab-pane fade">
                      <?php
					  	 $show_budgetpck4 = $db->prepare("SELECT DISTINCT(bste.state_name),bpck.*,cte.categoryname FROM packages bpck JOIN state bste ON bste.state_id=bpck.stid JOIN category cte ON cte.categoryid=bpck.cattid WHERE pack_price BETWEEN 60000 AND 80000 ORDER BY package_id DESC LIMIT 0,10");	
						  $show_budgetpck4->execute();
						  $allbudgpck4 = $show_budgetpck4->fetchAll();
					  	  foreach($allbudgpck4 as $bdgt4){
							$bdpickid4 = $bdgt4['package_id'];
							  $inpck_img4 = $db->prepare("SELECT p_image FROM package_images WHERE img_pckid=:bdpickid4 ORDER BY pimage_id DESC LIMIT 1");
							  $inpck_img4->bindParam(':bdpickid4',$bdpickid4);
							  $inpck_img4->execute();
							  $fidnimg4 = $inpck_img4->fetchAll();
							  foreach($fidnimg4 as $finmg4){
					    ?>
                            <div class="col-md-4 feature_sld">
                                <div class="col-md-12 feature_sld_in">
                           			<a href="<?php echo $url; ?>detail/<?php echo $bdgt4['package_uniq']; ?>">
                                    <div class="packages_mg" style="background:url(<?php echo $url; ?>images/package_image/<?php echo $finmg4['p_image']; ?>) center center;" style="background-size:cover;"></div>
                                    <div class="col-md-12 budget_sld_text">
                                        <h4><?php echo $bdgt4['state_name']; ?> <?php echo $bdgt4['categoryname']; ?></h4>
                                        <p><strong><?php echo $bdgt4['state_name']; ?></strong> (<?php echo $bdgt4['duration_day']; ?> Days & <?php echo $bdgt4['duration_night']; ?> Nights)</p>
                                        <div class="clearfix"></div>
                                        <p><strong><i class="fa fa-rupee"></i> <?php echo $bdgt4['budget_from']; ?>/-</strong> Per Person</p>
                                    </div>
                                </a>
                                </div>
                            </div>
                          <?php } } ?>
                      </div>
                      
                      <div id="bt6" class="tab-pane fade">
                         <?php
						 $show_budgetpck5 = $db->prepare("SELECT DISTINCT(bste.state_name),bpck.*,cte.categoryname FROM packages bpck JOIN state bste ON bste.state_id=bpck.stid JOIN category cte ON cte.categoryid=bpck.cattid WHERE pack_price > 80000 ORDER BY package_id DESC LIMIT 0,10");	
						$show_budgetpck5->execute();
						$allbudgpck5 = $show_budgetpck5->fetchAll();
					  	  foreach($allbudgpck5 as $bdgt5){
							$bdpickid5 = $bdgt5['package_id'];
							  $inpck_img5 = $db->prepare("SELECT p_image FROM package_images WHERE img_pckid=:bdpickid5 ORDER BY pimage_id DESC LIMIT 1");
							  $inpck_img5->bindParam(':bdpickid5',$bdpickid5);
							  $inpck_img5->execute();
							  $fidnimg5 = $inpck_img5->fetchAll();
							  foreach($fidnimg5 as $finmg5){
					    ?>
                            <div class="col-md-4 feature_sld">
                                <div class="col-md-12 feature_sld_in">
                           			<a href="<?php echo $url; ?>detail/<?php echo $bdgt5['package_uniq']; ?>">
                                    <div class="packages_mg" style="background:url(<?php echo $url; ?>images/package_image/<?php echo $finmg5['p_image']; ?>) center center;" style="background-size:cover;"></div> 
                                    <div class="col-md-12 budget_sld_text">
                                        <h4><?php echo $bdgt5['state_name']; ?> <?php echo $bdgt5['categoryname']; ?></h4>
                                        <p><strong><?php echo $bdgt5['state_name']; ?></strong> (<?php echo $bdgt5['duration_day']; ?> Days & <?php echo $bdgt5['duration_night']; ?> Nights)</p>
                                        <div class="clearfix"></div>
                                        <p><strong><i class="fa fa-rupee"></i> <?php echo $bdgt5['budget_from']; ?>/-</strong> Per Person</p>
                                    </div>
                                </a>
                                </div>
                            </div>
                          <?php } } ?>
                      </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                
            </div>
        </div>
    </div>
</div>

<div class="section budget_sect">
    <div class="container">
    	<div class="row">
            <div class="col-md-12">
                <h3 class="title-hadding wow fadeInDown">Best priced packages for your holiday DURATION</h3>
                <div class="col-md-12 budget_tab">
                    <ul class="nav nav-tabs wow fadeInUp">
                      <li class="active"><a data-toggle="tab" href="#du1">1 to 3 Days</a></li>
                      <li><a data-toggle="tab" href="#du2">4 to 6 Days</a></li>
                      <li><a data-toggle="tab" href="#du3">7 to 9 Days</a></li>
                      <li><a data-toggle="tab" href="#du4">10 to 12 Days</a></li>
                      <li><a data-toggle="tab" href="#du5">13 Days or More</a></li>
                    </ul>
                </div>
                
                <div class="col-md-12 budget_tab_content">
                    <div class="tab-content wow fadeInRight">
                    
                      <div id="du1" class="tab-pane fade in active">
                      <?php
					    $show_durtionpck = $db->prepare("SELECT DISTINCT(bste.state_name),bpck.*,cte.categoryname FROM packages bpck JOIN state bste ON bste.state_id=bpck.stid JOIN category cte ON cte.categoryid=bpck.cattid WHERE package_duration='1 to 3 Days' ORDER BY package_id DESC LIMIT 0,10");	
					    $show_durtionpck->execute();
					    $alldurpck = $show_durtionpck->fetchAll();
					  	  foreach($alldurpck as $dur){
							$dupid = $dur['package_id'];
								$dupck_img = $db->prepare("SELECT p_image FROM package_images WHERE img_pckid=:dupid ORDER BY pimage_id DESC LIMIT 1");
								$dupck_img->bindParam(':dupid',$dupid);
								$dupck_img->execute();
								$fduimg = $dupck_img->fetchAll();
								foreach($fduimg as $duimg){
			       	  ?>
                        <div class="col-md-4 feature_sld">
                                <div class="col-md-12 feature_sld_in">
                                <a href="<?php echo $url; ?>detail/<?php echo $dur['package_uniq']; ?>">
                                    <div class="packages_mg" style="background:url(<?php echo $url; ?>images/package_image/<?php echo $duimg['p_image']; ?>) center center;" style="background-size:cover;"></div>
                                    <div class="col-md-12 budget_sld_text">
                                        <h4><?php echo $dur['state_name']; ?> <?php echo $dur['categoryname']; ?></h4>
                                        <p><strong><?php echo $dur['state_name']; ?></strong> (<?php echo $dur['duration_day']; ?> Days & <?php echo $dur['duration_night']; ?> Nights)</p>
                                        <div class="clearfix"></div>
                                        <p><strong><i class="fa fa-rupee"></i> <?php echo $dur['budget_from']; ?>/-</strong> Per Person</p>
                                    </div>
                                </a></div>
                            </div>
                    <?php } } ?>       
                      </div>
                      
                      <div id="du2" class="tab-pane fade">
                       <?php
					    $show_durtionpck1 = $db->prepare("SELECT DISTINCT(bste.state_name),bpck.*,cte.categoryname FROM packages bpck JOIN state bste ON bste.state_id=bpck.stid JOIN category cte ON cte.categoryid=bpck.cattid WHERE package_duration='4 to 6 Days' ORDER BY package_id DESC LIMIT 0,10");	
					    $show_durtionpck1->execute();
					    $alldurpck1 = $show_durtionpck1->fetchAll();
					  	  foreach($alldurpck1 as $dur1){
							$dupid1 = $dur1['package_id'];
								$dupck_img1 = $db->prepare("SELECT p_image FROM package_images WHERE img_pckid=:dupid1 ORDER BY pimage_id DESC LIMIT 1");
								$dupck_img1->bindParam(':dupid1',$dupid1);
								$dupck_img1->execute();
								$fduimg1 = $dupck_img1->fetchAll();
								foreach($fduimg1 as $duimg1){
			       	  ?>
                        <div class="col-md-4 feature_sld">
                                <div class="col-md-12 feature_sld_in">
                                <a href="<?php echo $url; ?>detail/<?php echo $dur1['package_uniq']; ?>">
                                    <div class="packages_mg" style="background:url(<?php echo $url; ?>images/package_image/<?php echo $duimg1['p_image']; ?>) center center;" style="background-size:cover;"></div>
                                    <div class="col-md-12 budget_sld_text">
                                        <h4><?php echo $dur1['state_name']; ?> <?php echo $dur1['categoryname']; ?></h4>
                                        <p><strong><?php echo $dur1['state_name']; ?></strong> (<?php echo $dur1['duration_day']; ?> Days & <?php echo $dur1['duration_night']; ?> Nights)</p>
                                        <div class="clearfix"></div>
                                        <p><strong><i class="fa fa-rupee"></i> <?php echo $dur1['budget_from']; ?>/-</strong> Per Person</p>
                                    </div>
                                </a></div>
                            </div>
                           <?php } } ?>
                      </div>
                      
                      <div id="du3" class="tab-pane fade">
                      <?php
					    $show_durtionpck2 = $db->prepare("SELECT DISTINCT(bste.state_name),bpck.*,cte.categoryname FROM packages bpck JOIN state bste ON bste.state_id=bpck.stid JOIN category cte ON cte.categoryid=bpck.cattid WHERE package_duration='7 to 9 Days' ORDER BY package_id DESC LIMIT 0,10");	
					    $show_durtionpck2->execute();
					    $alldurpck2 = $show_durtionpck2->fetchAll();
					  	  foreach($alldurpck2 as $dur2){
							$dupid2 = $dur2['package_id'];
								$dupck_img2 = $db->prepare("SELECT p_image FROM package_images WHERE img_pckid=:dupid2 ORDER BY pimage_id DESC LIMIT 1");
								$dupck_img2->bindParam(':dupid2',$dupid2);
								$dupck_img2->execute();
								$fduimg2 = $dupck_img2->fetchAll();
								foreach($fduimg2 as $duimg2){
			       	  ?>
                        <div class="col-md-4 feature_sld">
                                <div class="col-md-12 feature_sld_in">
                                <a href="<?php echo $url; ?>detail/<?php echo $dur2['package_uniq']; ?>">
                                    <div class="packages_mg" style="background:url(<?php echo $url; ?>images/package_image/<?php echo $duimg2['p_image']; ?>) center center;" style="background-size:cover;"></div>
                                    <div class="col-md-12 budget_sld_text">
                                        <h4><?php echo $dur2['state_name']; ?> <?php echo $dur2['categoryname']; ?></h4>
                                        <p><strong><?php echo $dur2['state_name']; ?></strong> (<?php echo $dur2['duration_day']; ?> Days & <?php echo $dur2['duration_night']; ?> Nights)</p>
                                        <div class="clearfix"></div>
                                        <p><strong><i class="fa fa-rupee"></i> <?php echo $dur2['budget_from']; ?>/-</strong> Per Person</p>
                                    </div>
                                </a></div>
                            </div>
                           <?php } } ?>
                            
                      </div>
                      
                      <div id="du4" class="tab-pane fade">
                       <?php
					    $show_durtionpck3 = $db->prepare("SELECT DISTINCT(bste.state_name),bpck.*,cte.categoryname FROM packages bpck JOIN state bste ON bste.state_id=bpck.stid JOIN category cte ON cte.categoryid=bpck.cattid WHERE package_duration='10 to 12 Days' ORDER BY package_id DESC LIMIT 0,10");	
					    $show_durtionpck3->execute();
					    $alldurpck3 = $show_durtionpck3->fetchAll();
					  	  foreach($alldurpck3 as $dur3){
							$dupid3 = $dur3['package_id'];
								$dupck_img3 = $db->prepare("SELECT p_image FROM package_images WHERE img_pckid=:dupid3 ORDER BY pimage_id DESC LIMIT 1");
								$dupck_img3->bindParam(':dupid3',$dupid3);
								$dupck_img3->execute();
								$fduimg3 = $dupck_img3->fetchAll();
								foreach($fduimg3 as $duimg3){
			       	  ?>
                        <div class="col-md-4 feature_sld">
                                <div class="col-md-12 feature_sld_in">
                                <a href="<?php echo $url; ?>detail/<?php echo $dur3['package_uniq']; ?>">
                                    <div class="packages_mg" style="background:url(<?php echo $url; ?>images/package_image/<?php echo $duimg3['p_image']; ?>) center center;" style="background-size:cover;"></div>
                                    <div class="col-md-12 budget_sld_text">
                                        <h4><?php echo $dur3['state_name']; ?> <?php echo $dur3['categoryname']; ?></h4>
                                        <p><strong><?php echo $dur3['state_name']; ?></strong> (<?php echo $dur3['duration_day']; ?> Days & <?php echo $dur3['duration_night']; ?> Nights)</p>
                                        <div class="clearfix"></div>
                                        <p><strong><i class="fa fa-rupee"></i> <?php echo $dur3['budget_from']; ?>/-</strong> Per Person</p>
                                    </div>
                                </a></div>
                            </div>
                           <?php } } ?>
                      </div>

                      <div id="du5" class="tab-pane fade">
                       <?php
					    $show_durtionpck4 = $db->prepare("SELECT DISTINCT(bste.state_name),bpck.*,cte.categoryname FROM packages bpck JOIN state bste ON bste.state_id=bpck.stid JOIN category cte ON cte.categoryid=bpck.cattid WHERE package_duration='13 Days or More' ORDER BY package_id DESC LIMIT 0,10");	
					    $show_durtionpck4->execute();
					    $alldurpck4 = $show_durtionpck4->fetchAll();
					  	  foreach($alldurpck4 as $dur4){
							$dupid4 = $dur4['package_id'];
								$dupck_img4 = $db->prepare("SELECT p_image FROM package_images WHERE img_pckid=:dupid4 ORDER BY pimage_id DESC LIMIT 1");
								$dupck_img4->bindParam(':dupid4',$dupid4);
								$dupck_img4->execute();
								$fduimg4 = $dupck_img4->fetchAll();
								foreach($fduimg4 as $duimg4){
			       	  ?>
                        <div class="col-md-4 feature_sld">
                                <div class="col-md-12 feature_sld_in">
                                <a href="<?php echo $url; ?>detail/<?php echo $dur4['package_uniq']; ?>">
                                    <div class="packages_mg" style="background:url(<?php echo $url; ?>images/package_image/<?php echo $duimg4['p_image']; ?>) center center;" style="background-size:cover;"></div>
                                    <div class="col-md-12 budget_sld_text">
                                        <h4><?php echo $dur4['state_name']; ?> <?php echo $dur4['categoryname']; ?></h4>
                                        <p><strong><?php echo $dur4['state_name']; ?></strong> (<?php echo $dur4['duration_day']; ?> Days & <?php echo $dur4['duration_night']; ?> Nights)</p>
                                        <div class="clearfix"></div>
                                        <p><strong><i class="fa fa-rupee"></i> <?php echo $dur4['budget_from']; ?>/-</strong> Per Person</p>
                                    </div>
                                </a></div>
                            </div>
                           <?php } } ?>
                      </div>
                      
                    </div>
                </div>
                <div class="clearfix"></div>
                
            </div>
        </div>
    </div>
</div>

<div class="section budget_sect">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="title-hadding wow fadeInUp">Staff picks for each SEASON</h3>
                <div class="col-md-12 budget_tab">
                    <ul class="nav nav-tabs wow fadeInDown">
                      <li class="active"><a data-toggle="tab" href="#se1">Jan-Feb-Mar</a></li>
                      <li><a data-toggle="tab" href="#se2">Apr-May-Jun</a></li>
                      <li><a data-toggle="tab" href="#se3">Jul-Aug-Sep</a></li>
                      <li><a data-toggle="tab" href="#se4">Oct-Nov-Dec</a></li>
                    </ul>
                </div>
                
                <div class="col-md-12 budget_tab_content">
                    <div class="tab-content wow fadeInLeft">
                    
                      <div id="se1" class="tab-pane fade in active">
                      
                      <?php
					    $show_sesnpck = $db->prepare("SELECT DISTINCT(bste.state_name),bpck.*,cte.categoryname FROM packages bpck JOIN state bste ON bste.state_id=bpck.stid JOIN category cte ON cte.categoryid=bpck.cattid WHERE (season_from='January' || season_from='February' ) AND (season_to='February' || season_to='March') ORDER BY package_id DESC LIMIT 0,10");	
					    $show_sesnpck->execute();
					    $allspck = $show_sesnpck->fetchAll();
					  	  foreach($allspck as $sesn){
							$spid = $sesn['package_id'];
								$spck_img = $db->prepare("SELECT p_image FROM package_images WHERE img_pckid=:spid ORDER BY pimage_id DESC LIMIT 1");
								$spck_img->bindParam(':spid',$spid);
								$spck_img->execute();
								$fsimg = $spck_img->fetchAll();
								foreach($fsimg as $simg){
			       	  ?>
                        <div class="col-md-4 feature_sld">
                                <div class="col-md-12 feature_sld_in">
                                <a href="<?php echo $url; ?>detail/<?php echo $sesn['package_uniq']; ?>">
                                    <div class="packages_mg" style="background:url(<?php echo $url; ?>images/package_image/<?php echo $simg['p_image']; ?>) center center;" style="background-size:cover;"></div>
                                    <div class="col-md-12 budget_sld_text">
                                        <h4><?php echo $sesn['state_name']; ?> <?php echo $sesn['categoryname']; ?></h4>
                                        <p><strong><?php echo $sesn['state_name']; ?></strong> (<?php echo $sesn['duration_day']; ?> Days & <?php echo $sesn['duration_night']; ?> Nights)</p>
                                        <div class="clearfix"></div>
                                        <p><strong><i class="fa fa-rupee"></i> <?php echo $sesn['budget_from']; ?>/-</strong> Per Person</p>
                                    </div>
                                </a></div>
                            </div>
                           <?php } } ?>
                      </div>
                      
                      <div id="se2" class="tab-pane fade">
                       <?php
					    $show_sesnpck1 = $db->prepare("SELECT DISTINCT(bste.state_name),bpck.*,cte.categoryname FROM packages bpck JOIN state bste ON bste.state_id=bpck.stid JOIN category cte ON cte.categoryid=bpck.cattid WHERE (season_from='April' || season_from='May' ) AND (season_to='May' || season_to='June') ORDER BY package_id DESC LIMIT 0,10");	
					    $show_sesnpck1->execute();
					    $allspck1 = $show_sesnpck1->fetchAll();
					  	  foreach($allspck1 as $sesn1){
							$spid1 = $sesn1['package_id'];
								$spck_img1 = $db->prepare("SELECT p_image FROM package_images WHERE img_pckid=:spid1 ORDER BY pimage_id DESC LIMIT 1");
								$spck_img1->bindParam(':spid1',$spid1);
								$spck_img1->execute();
								$fsimg1 = $spck_img1->fetchAll();
								foreach($fsimg1 as $simg1){
			       	  ?>
                        <div class="col-md-4 feature_sld">
                                <div class="col-md-12 feature_sld_in">
                                <a href="<?php echo $url; ?>detail/<?php echo $sesn1['package_uniq']; ?>">
                                    <div class="packages_mg" style="background:url(<?php echo $url; ?>images/package_image/<?php echo $simg1['p_image']; ?>) center center;" style="background-size:cover;"></div> 
                                    <div class="col-md-12 budget_sld_text">
                                        <h4><?php echo $sesn1['state_name']; ?> <?php echo $sesn1['categoryname']; ?></h4>
                                        <p><strong><?php echo $sesn1['state_name']; ?></strong> (<?php echo $sesn1['duration_day']; ?> Days & <?php echo $sesn1['duration_night']; ?> Nights)</p>
                                        <div class="clearfix"></div>
                                        <p><strong><i class="fa fa-rupee"></i> <?php echo $sesn1['budget_from']; ?>/-</strong> Per Person</p>
                                    </div>
                                </a></div>
                            </div>
                           <?php } } ?>
                            
                      </div>
                      
                      <div id="se3" class="tab-pane fade">
                       <?php
					    $show_sesnpck2 = $db->prepare("SELECT DISTINCT(bste.state_name),bpck.*,cte.categoryname FROM packages bpck JOIN state bste ON bste.state_id=bpck.stid JOIN category cte ON cte.categoryid=bpck.cattid WHERE (season_from='July' || season_from='August' ) AND (season_to='August' || season_to='September') ORDER BY package_id DESC LIMIT 0,10");	
					    $show_sesnpck2->execute();
					    $allspck2 = $show_sesnpck2->fetchAll();
					  	  foreach($allspck2 as $sesn2){
							$spid2 = $sesn2['package_id'];
								$spck_img2 = $db->prepare("SELECT p_image FROM package_images WHERE img_pckid=:spid2 ORDER BY pimage_id DESC LIMIT 1");
								$spck_img2->bindParam(':spid2',$spid2);
								$spck_img2->execute();
								$fsimg2 = $spck_img2->fetchAll();
								foreach($fsimg2 as $simg2){
			       	  ?>
                        <div class="col-md-4 feature_sld">
                                <div class="col-md-12 feature_sld_in">
                                <a href="<?php echo $url; ?>detail/<?php echo $sesn2['package_uniq']; ?>">
                                    <div class="packages_mg" style="background:url(<?php echo $url; ?>images/package_image/<?php echo $simg2['p_image']; ?>) center center;" style="background-size:cover;"></div>
                                    <div class="col-md-12 budget_sld_text">
                                        <h4><?php echo $sesn2['state_name']; ?> <?php echo $sesn2['categoryname']; ?></h4>
                                        <p><strong><?php echo $sesn2['state_name']; ?></strong> (<?php echo $sesn2['duration_day']; ?> Days & <?php echo $sesn2['duration_night']; ?> Nights)</p>
                                        <div class="clearfix"></div>
                                        <p><strong><i class="fa fa-rupee"></i> <?php echo $sesn2['budget_from']; ?>/-</strong> Per Person</p>
                                    </div>
                                </a></div>
                            </div>
                           <?php } } ?>
                      </div>
                      
                      <div id="se4" class="tab-pane fade">
                   	<?php
					    $show_sesnpck3 = $db->prepare("SELECT DISTINCT(bste.state_name),bpck.*,cte.categoryname FROM packages bpck JOIN state bste ON bste.state_id=bpck.stid JOIN category cte ON cte.categoryid=bpck.cattid WHERE (season_from='October' || season_from='November' ) AND (season_to='November' || season_to='December') ORDER BY package_id DESC LIMIT 0,10");	
					    $show_sesnpck3->execute();
					    $allspck3 = $show_sesnpck3->fetchAll();
					  	  foreach($allspck3 as $sesn3){
							$spid3 = $sesn2['package_id'];
								$spck_img3 = $db->prepare("SELECT p_image FROM package_images WHERE img_pckid=:spid3 ORDER BY pimage_id DESC LIMIT 1");
								$spck_img3->bindParam(':spid3',$spid3);
								$spck_img3->execute();
								$fsimg3 = $spck_img3->fetchAll();
								foreach($fsimg3 as $simg3){
			       	  ?>
                        <div class="col-md-4 feature_sld">
                                <div class="col-md-12 feature_sld_in">
                                <a href="<?php echo $url; ?>detail/<?php echo $sesn3['package_uniq']; ?>">
                                    <div class="packages_mg" style="background:url(<?php echo $url; ?>images/package_image/<?php echo $simg3['p_image']; ?>) center center;" style="background-size:cover;"></div>
                                    <div class="col-md-12 budget_sld_text">
                                        <h4><?php echo $sesn3['state_name']; ?> <?php echo $sesn3['categoryname']; ?></h4>
                                        <p><strong><?php echo $sesn3['state_name']; ?></strong> (<?php echo $sesn3['duration_day']; ?> Days & <?php echo $sesn3['duration_night']; ?> Nights)</p>
                                        <div class="clearfix"></div>
                                        <p><strong><i class="fa fa-rupee"></i> <?php echo $sesn3['budget_from']; ?>/-</strong> Per Person</p>
                                    </div>
                                </a></div>
                            </div>
                           <?php } } ?>
                      </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                
            </div>
        </div>
    </div>
</div>

<div class="section what-we-sec">
	<div class="container">
    	<div class="row">
            <div class="col-md-12">
                <div class="col-md-12">
                    <div class="col-md-8 display-center">
                        <h2 class="title-hadding wow fadeInUp">Our Features</h2>	
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="what-we wow fadeInLeft">
                        <i class="fa fa-car"></i>
                        <h4>MAKING BOOKING EASIER</h4>
                        <p>You just need to provide your required details along with your travelling dates and we will plan everything related to your private car or tempo traveller service. </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="what-we wow fadeInDown">
                        <i class="fa fa-life-ring"></i>
                        <h4>YOUR TOUR GUIDE</h4>
                        <p>With a aim to make your journey to Himachal a memorable one, our main focus is to provide tour guidence to our clients during their journey.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="what-we wow fadeInDown">
                        <i class="fa fa-users"></i>
                        <h4>QUICK RESPONSE TEAM</h4>
                        <p>We are one of the few tour companies in Himachal that provide through support to its client from our support team during the tour.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section offer-sect jarallax">
	<div class="offer-sect-over">
    	<div class="container">
        	<div class="row">
                <div class="offer-dv col-md-12">
                    <h4 class="wow fadeInUp">Why Choose Us</h4>
                    <p class="wow fadeInRight"> Our Travel Directors are carefully selected for their knowledge and enthusiasm</p>
                    <ul>
                    	<li>
                        	<span>A</span>
                            <h4>138,00+ Hotels</h4>
                            <p>On our tours you are completely free from the hassle of booking your own accommodation, organising your own transport, finding your own excursions with quality guides.</p>
                        </li>
                        <li>
                        	<span>B</span>
                            <h4>Low Rates & Savings</h4>
                            <p>On our tours you are completely free from the hassle of booking your own accommodation, organising your own transport, finding your own excursions with quality guides. </p>
                        </li>
                        <li>
                        	<span>C</span>
                            <h4>Excellent Support</h4>
                            <p>On our tours you are completely free from the hassle of booking your own accommodation, organising your own transport, finding your own excursions with quality guides. </p>
                        </li>
                        <li>
                        	<span>D</span>
                            <h4>Secure Online Transcation</h4>
                            <p>On our tours you are completely free from the hassle of booking your own accommodation, organising your own transport, finding your own excursions with quality guides. </p>
                        </li>
                    </ul>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section testimonial-sec">
	<div class="container">
    	<div class="row">
            <h2 class="wow fadeInDown">What people say</h2>
            <section class="regular testi-slide wow fadeInUp">
                <div class="testi-dv">
                    <img src="images/testimonial-1.jpg" alt=""/>
                    <h4>Deepak Garg <br><span>New Delhi</span></h4>
                    <p>Travel as much as you can, as far as you can, as long as you can. Life's not meant to be lived in one place.</p>
                    
                </div>
                <div class="testi-dv">
                    <img src="images/testimonial-2.jpg" alt=""/>
                    <h4>Deepak Garg <br><span>New Delhi</span></h4>
                    <p>The best things in Life are the people you Love, the places you've seen, and the Memories you've made along the way.</p>
                </div>
                <div class="testi-dv">
                    <img src="images/testimonial-3.png" alt=""/>
                    <h4>Deepak Garg <br><span>New Delhi</span></h4>
                    <p>Take vacations, go as many places as you can. You can always make money but you can't always make memories.</p>
                </div>
          </section>
        </div>
    </div>
</div>
  

    <!-- Footer Section -->
    <?php include('footer.php') ?>

</div>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
<!--<script src="js/jquery-1.11.1.min.js"></script>-->
<script src="js/jquery.slitslider.js"></script>
<script src="js/jquery.ba-cond.min.js"></script>
<!-- Custom Functions -->
<script src="js/main.js"></script> 

<script src="<?php echo $url; ?>js/slick.js" type="text/javascript"></script>
<script src="<?php echo $url; ?>js/custom.js" type="text/javascript"></script>
<script src="<?php echo $url; ?>js/jarallax.js" type="text/javascript"></script>
<script type="text/javascript">s
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
	$('.hidepop').fadeOut();
	}
</script>



</body>
</html>
