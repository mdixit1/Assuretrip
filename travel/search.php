<?php
error_reporting(0);
session_start();
include('function.php'); 
include('connection/index.php');

$perpage = 10;
if(isset($_GET["page"])){
$page = intval($_GET["page"]);
} else { $page = 1; }
$calc = $perpage * $page;
$start = $calc - $perpage;
?>
<!DOCTYPE html>
<html lang="en-IN">
<head>
    <?php echo headdata(); ?>
    <link rel="canonical" href=""/>
    <link rel='shortlink' href=""/>
	<title>Search</title>
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
    <link href="http://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
	<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script>
	var type,stepone,steptwo,stepthree,stepfour,stepfive,stepsix,dur,actv,mnth,mnthh,mnthhh,mnthhhh;
	$(function(){
		$('.item_filter').click(function(){
			$('.product-data').html('<div id="loaderpro" style="" ></div>');
			 type   = multiple_values('type');
			 stepone  = multiple_values('stepone');
			 steptwo  = multiple_values('steptwo');
			 stepthree  = multiple_values('stepthree');
			 stepfour  = multiple_values('stepfour');
			 stepfive  = multiple_values('stepfive');
			 stepsix  = multiple_values('stepsix');
			 dur  = multiple_values('dur');
			 actv  = multiple_values('actv');
			 mnth  = multiple_values('mnth');
			 mnthh  = multiple_values('mnthh');
			 mnthhh  = multiple_values('mnthhh');
			 mnthhhh  = multiple_values('mnthhhh');
		    $.ajax({
				url:"<?php echo $url; ?>ajax.php",
				type:'post',
				data:{type:type,stepone:stepone,steptwo:steptwo,stepthree:stepthree,stepfour:stepfour,stepfive:stepfive,stepsix:stepsix,dur:dur,actv:actv,mnth:mnth,mnthh:mnthh,mnthhh:mnthhh,mnthhhh:mnthhhh},
				success:function(result){
					$('.product-data').html(result);
				}
			});
		});
		
	});
	
		$(document).ready(function(){	
				$(document).on('submit', '#contact-form2', function(){
					var data = $(this).serialize();
					$.ajax({
					type : 'POST',
					url  : "<?php echo $url.'submitone.php';?>",
					data : data,
					success :  function(data)
							   {				
								 $("#contact-form2").fadeIn(500).show(function()
									  {	
										$(".resultone").fadeIn(500).show(function()
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
<div class="see-section wrapper">
	<?php include('header.php'); ?>
    
  <?php if(isset($_GET['state']) || isset($_GET['durtion']) || isset($_GET['mnth'])){
			$stttid = $_GET['state'];
			$durtion = $_GET['durtion'];
			$mnth = $_GET['mnth'];
			
			if($stttid!='' && $durtion!='' && $mnth!=''){
				$count_searpck = $db->prepare("SELECT COUNT(package_id) FROM packages WHERE stid=:stttid AND package_duration=:durtion AND season_from=:mnth");
				$count_searpck->bindParam(':stttid',$stttid);
				$count_searpck->bindParam(':durtion',$durtion);
				$count_searpck->bindParam(':mnth',$mnth);
				$count_searpck->execute();
				$cpk = $count_searpck->fetchColumn();
			}
			elseif($stttid!='' && $durtion=='' && $mnth==''){
				$count_searpck = $db->prepare("SELECT COUNT(package_id) FROM packages WHERE stid=:stttid");
				$count_searpck->bindParam(':stttid',$stttid);
				$count_searpck->execute();
				$cpk = $count_searpck->fetchColumn();
			}
			elseif($stttid!='' && $durtion!='' && $mnth==''){
				$count_searpck1 = $db->prepare("SELECT COUNT(package_id) FROM packages WHERE stid=:stttid AND package_duration=:durtion");
				$count_searpck1->bindParam(':stttid',$stttid);
				$count_searpck1->bindParam(':durtion',$durtion);
				$count_searpck1->execute();
				$cpk = $count_searpck1->fetchColumn();
			}
			elseif($stttid!='' && $durtion=='' && $mnth!=''){
				$count_searpck2 = $db->prepare("SELECT COUNT(package_id) FROM packages WHERE stid=:stttid AND season_from=:mnth");
				$count_searpck2->bindParam(':stttid',$stttid);
				$count_searpck2->bindParam(':mnth',$mnth);
				$count_searpck2->execute();
				$cpk = $count_searpck2->fetchColumn();
			}
			elseif($stttid=='' && $durtion!='' && $mnth!=''){
				$count_searpck3 = $db->prepare("SELECT COUNT(package_id) FROM packages WHERE package_duration=:durtion AND season_from=:mnth");
				$count_searpck3->bindParam(':durtion',$durtion);
				$count_searpck3->bindParam(':mnth',$mnth);
				$count_searpck3->execute();
				$cpk = $count_searpck3->fetchColumn();
			}
			elseif($stttid=='' && $durtion!='' && $mnth==''){
				$count_searpck4 = $db->prepare("SELECT COUNT(package_id) FROM packages WHERE package_duration=:durtion");
				$count_searpck4->bindParam(':durtion',$durtion);
				$count_searpck4->execute();
				$cpk = $count_searpck4->fetchColumn();
			}
			elseif($stttid=='' && $durtion=='' && $mnth!=''){
				$count_searpck5 = $db->prepare("SELECT COUNT(package_id) FROM packages WHERE season_from=:mnth");
				$count_searpck5->bindParam(':mnth',$mnth);
				$count_searpck5->execute();
				$cpk = $count_searpck5->fetchColumn();
			}
			
  ?>	  
  		  
    <h1 style="text-align:center;"><?php $st['categoryname']; ?></h1>
    <div class="section honeymoon_sect">
    	<div class="container">
        	<div class="row">
            	<div class="col-md-3">
                	<div class="fulldv filter_leftside">
                    	<h3>Filters</h3>
                        <h4></h4>
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingOne">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#filtertab1" aria-controls="filtertab1">
                                          Type Of Destination
                                        </a>
                              		</h4>
                                </div>
                                <div id="filtertab1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                    <div class="panel-body acco_body">
                                    	<ul>
                                         <?php
										 	$show_contry = $db->prepare("SELECT DISTINCT(type_destination) FROM packages");
											$show_contry->execute();
											$allcntry = $show_contry->fetchAll();
											foreach($allcntry as $alcnt){
											if($alcnt['type_destination']=='0'){ 
										  ?>
											<li><input type="checkbox" name="#" class="item_filter type" value="<?php echo $alcnt['type_destination']; ?>"> India</li>  	
                                          <?php } else{ ?>
                                        	<li><input type="checkbox" name="#" class="item_filter type" value="<?php echo $alcnt['type_destination']; ?>"> International</li>
                                         <?php } } ?>   
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingTwo">
                                     <h4 class="panel-title">
                                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#filtertab2" aria-controls="filtertab2">
                                          Budget Per Person ( in Rs. )
                                        </a>
                                     </h4>
                                </div>
                                <div id="filtertab2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                    <div class="panel-body acco_body">
                                    	<ul>
                                        	<li><input type="checkbox" name="#" class="item_filter stepone" value=""> Less than 10,000</li>
                                            <li><input type="checkbox" name="#" class="item_filter steptwo" value=""> 10,000 - 20,000</li>
                                            <li><input type="checkbox" name="#" class="item_filter stepthree" value=""> 20,000 - 40,000</li>
                                            <li><input type="checkbox" name="#" class="item_filter stepfour" value=""> 40,000 - 60,000</li>
                                            <li><input type="checkbox" name="#" class="item_filter stepfive" value=""> 60,000 - 80,000</li>
                                            <li><input type="checkbox" name="#" class="item_filter stepsix" value=""> Above 80,000</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingThree">
                                     <h4 class="panel-title">
                                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#filtertab3" aria-controls="filtertab3">
                                          Duration ( in Days )
                                        </a>
                                     </h4>
                                </div>
                                <div id="filtertab3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                    <div class="panel-body acco_body">
                                    	<ul>
                                         <?php
										 	$show_dur = $db->prepare("SELECT DISTINCT(package_duration) FROM packages");
											$show_dur->execute();
											$alldurs = $show_dur->fetchAll();
											foreach($alldurs as $aldu){
										  ?>
                                        	<li><input type="checkbox" name="#" class="item_filter dur"><?php echo $aldu['package_duration']; ?></li>
                                          <?php } ?>  
                                        </ul>
                                    </div>
                                </div>
                           </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingThree">
                                     <h4 class="panel-title">
                                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#filtertab5" aria-controls="filtertab5">
                                          Month of Travel
                                        </a>
                                     </h4>
                                </div>
                                <div id="filtertab5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                    <div class="panel-body acco_body">
                                    	<ul>
                                        	<li><input type="checkbox" name="#" class="item_filter mnth"> Jan-Mar</li>
                                            <li><input type="checkbox" name="#" class="item_filter mnthh"> Apr-Jun</li>
                                            <li><input type="checkbox" name="#" class="item_filter mnthhh"> Jul-Sep</li>
                                            <li><input type="checkbox" name="#" class="item_filter mnthhhh"> Oct-Dec</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingThree">
                                     <h4 class="panel-title">
                                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#filtertab4" aria-controls="filtertab4">
                                          Activities
                                        </a>
                                     </h4>
                                </div>
                                <div id="filtertab4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                    <div class="panel-body acco_body">
                                    	<ul>
                                        <?php
											$show_activity = $db->prepare("SELECT activity_id,activity_name FROM add_activity ORDER BY activity_id DESC");
											$show_activity->execute();
											$allact = $show_activity->fetchAll();
											foreach($allact as $alctv){
										?>
                                        	<li><input type="checkbox" name="#" class="item_filter actv" value="<?php echo $alctv['activity_name']; ?>"> <?php echo $alctv['activity_name']; ?></li>
                                       <?php } ?>     
                                        </ul>
                                    </div>
                                </div>
                           </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-9 p0 product-data">
               		<div class="col-md-12 cathead">
                    	<h1><span>(<?php echo $cpk; ?>) Packages</span> are Found</h1>
                    </div>
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
               	  <div class="col-md-10 search_result_main_out wow fadeInUp">
                      <div class="fulldv search_result_main">
                      <a href="<?php echo $url; ?>detail/<?php echo $row['package_uniq']; ?>">
                        <div class="theme_mg" style="background:url(<?php echo $url; ?>images/package_image/<?php echo $alm['p_image']; ?>) center center; background-size:cover;">
                            <span><i class="fa fa-star"></i> 4.5</span>
                        </div></a>
                        <div class="fulldv theme_txt">
                             <div class="col-md-12 p0">
                                 <h4> <a href="<?php echo $url; ?>detail/<?php echo $row['package_uniq']; ?>"  style="margin-top: -16px; margin-bottom: 6px; background-color:#00bcd4; font-size:15px; float:left;"><?php echo $row['resort_name']; ?></a></h4>
                                 </div>
                                 <div class="col-md-12 p0">
                                 <h5 style="margin-top: -4px; margin-bottom: 3px;"><?php echo $row['duration_day']; ?> Days & <?php echo $row['duration_night']; ?> Nights | Customizable</h5>
                                 </div>
                            <div class="col-md-12 p0">
                                <div class="timedv">
                                    <p>Best Time Visit</p>
                                    <span><?php echo $row['season_from']; ?> - <?php echo $row['season_to']; ?></span>
                                </div>
                                <div class="timedv">
                                    <p>Staring Price From</p>
                                    <span><?php echo $row['pack_price']; ?></span>
                                </div>
                                <div class="timedv priper">
                                    <p><span><i class="fa fa-rupee"></i> <?php echo $row['budget_from']; ?> to <?php echo $row['budget_to']; ?></span> / per person on twin sharing </p>
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
                                <a href="#" onClick="moreinfo()">Customize & Get Quotes</a>
                                <a href="<?php echo $url; ?>detail/<?php echo $row['package_uniq']; ?>" style="background:none; color:#000;">View details</a>
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
    
  <?php } else { echo "No Detail Found"; } ?>                    

<div class="overlaydv quickinquiry" id="lead_form" style="background:rgba(0,0,0,0.7); position:fixed; width:100%; height:100%; top:0; left:0; z-index:999999;">
    <div class="overlaydv-in">
        <div class="overlaydv-inner">
            <div class="callback" role="dialog">
            <div class="modal-dialog popupwid">
              <div class="modal-content">
                <div class="modal-body">
                 <button type="button" class="closeop" onClick="hidepop()">&times;</button>
                 <div class="resultone">
                   <form method="post" id="contact-form2">
                        <div class="fulldv planyour" style="margin:0;">
                        	<h4>Where do you want to go?</h4>
                            <p>To</p>
                            <input type="text" name="destintn" required/>
                            <p><input type="checkbox" name="explor" value="Yes"> I am exploring destinations</p>
                            <p>From</p>
                            <input type="text" name="fromdesti">
                            <p>Departure Date (Choose Any)</p>
                            <div class="fulldv willbook">
                            	<input type="radio" name="Choose" value="fixed" id="Fixed">
                            	<label for="Fixed" onClick="show1()">Fixed</label>
                                <input type="radio" name="Choose" value="flexible" id="Flexible">
                                <label for="Flexible" onClick="show2()">Flexible</label>
                                <input type="radio" name="Choose" value="anytime" id="Anytime">
                                <label for="Anytime" onClick="show3()">Anytime</label>
                            </div>
                            <script>
								function show1(){
								  document.getElementById('div1').style.display ='block';
								  document.getElementById('div2').style.display ='none';
								  document.getElementById('div3').style.display ='none';
								}
								function show2(){
								  document.getElementById('div1').style.display = 'none';
								  document.getElementById('div2').style.display = 'block';
								  document.getElementById('div3').style.display = 'none';
								}
								function show3(){
								  document.getElementById('div1').style.display = 'none';
								  document.getElementById('div2').style.display = 'none';
								  document.getElementById('div3').style.display = 'block';
								}
							</script>
                            <link rel="stylesheet" href="/resources/demos/style.css">
						    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
                            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
                            <script>
								$( function() {
									$( "#datepicker" ).datepicker({dateFormat: 'yy-m-d'});
								  } );
								  
								$( function() {
									$( "#datepicker1" ).datepicker();
								  } ); 
								  
								  $( function() {
									$( "#datepicker2" ).datepicker();
								  } );  	
                            </script>
                            <div class="col-md-12 p0 chooseany_hide" id="div1">
                            	<div class="col-md-6 p0">
                                    <p>Departure Date(Choose Any)</p>
                                    <input type="text" name="fxdate" id="datepicker" autocomplete="off">
                                </div>
                                <div class="col-md-6 p0" style="text-align:right;">
                                    <p>Number Of Days</p>
                                    <input type="number" name="fxday" style="width:100px;">
                                </div>
                            </div>
                            <div class="col-md-12 p0 chooseany_hide" id="div2">
                            	<div class="col-md-6 p0">
                                    <p>Departure Date(Choose Any)</p>
                                    <input type="text" name="flxdate" id="datepicker1" autocomplete="off">
                                </div>
                                <div class="col-md-6 p0" style="text-align:right;">
                                    <p>Number Of Days</p>
                                    <input type="number" name="flxday" style="width:100px;">
                                </div>
                            </div>
                            <div class="col-md-12 p0 chooseany_hide" id="div3">
                            	<div class="col-md-6 p0">
                                    <p>Departure Date(Choose Any)</p>
                                    <input type="text" name="anydate" id="datepicker2" autocomplete="off">
                                </div>
                                <div class="col-md-6 p0" style="text-align:right;">
                                    <p>Number Of Days</p>
                                    <input type="number" name="anyday" style="width:100px;">
                                </div>
                            </div>
                            <p>Email ID</p>
                            <input type="email" name="mail" placeholder="Email ID" required/>
                            <p>Mobile No.</p>
                            <input type="text" name="mob" placeholder="Mobile No." maxlength="10" onKeyUp="onlydigit(this)" required/>
                            <input type="submit" name="" value="Next">
                        
                        </div>
                   </form>
                  </div> 
                 </div>
              </div>
            </div>
            </div>
        </div>
    </div>
</div>


<script>
	function moreinfo() {
		$('.quickinquiry').addClass('show')
		
		}
	function hidepop() {
		$('.quickinquiry').removeClass('show')
		
		}
	
</script>

    <!-- Footer Section -->
    <?php include('footer.php') ?>

</div>

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
function popclose() {
	$('.hidepop').fadeToggle();
	}
</script>



</body>
</html>