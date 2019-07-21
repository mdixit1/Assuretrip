<?php
error_reporting(0);
session_start();
include('function.php');
include('connection/index.php');
$cont="";


$cont = isset($_REQUEST['cont'])?$_REQUEST['cont']:"";

$contid = $_SESSION['cntid'];
?>
<!DOCTYPE html>
<html lang="en-IN">
<body>

                    
                <?php
					   if($cont !=''){
							$skillsdata =implode("','",$cont);  
					     	$query .= "SELECT pk.*,stt.state_name FROM packages pk JOIN state stt ON stt.state_id=pk.stid WHERE pk.cntid IN('$skillsdata')"; 
					   }
					   else{
						  $query .= "SELECT pk.*,stt.state_name FROM packages pk JOIN state stt ON stt.state_id=pk.stid WHERE pk.cntid='$contid'"; 
					    }
					
					  	 $results = $db->query($query); 
						 $product_datas = $results->fetchAll();
						 $val = count($product_datas);
						 if(count($product_datas)){
				?>
               			<div class="col-md-9 p0">
               		<div class="col-md-12 cathead">
                    	<h1><span>(<?php echo $val; ?>) Packages</span> are Found</h1>
                    </div>
			   <?php
			   	    foreach($product_datas as $row){
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
                                <div class="timedv">
                                    <p>Best Time</p>
                                    <span>Oct - Mar</span>
                                </div>
                                <div class="timedv">
                                    <p>travelers</p>
                                    <span>23,353+</span>
                                </div>
                                <div class="timedv priper">
                                    <p><span><i class="fa fa-rupee"></i> <?php echo $row['budget_from']; ?> to <?php echo $row['budget_to']; ?></span> / per person</p>
                                    <p>(Flight <?php echo $row['flight_status']; ?>)</p>
                                </div>
                            </div>
                            <div class="col-md-12 p0">
                                <h4><?php echo $row['state_name']; ?></h4>
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
               <?php } } ?>   
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
               <?php } else{ echo "No Package Found"; } ?> 
            			
       
                       
               

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="js/jquery.validate.min.js" type="text/javascript"></script>
<script src="js/custom.js" type="text/javascript"></script>
<script src="<?php echo $url; ?>js/chosen.jquery.js" type="text/javascript"></script>

</body>
</html>
