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
		$puid = $_GET['resrt'];
		$found_detail = $db->prepare("SELECT pk.*,cnt.country_name,cty.city_name,st.state_name,cat.categoryname FROM packages pk JOIN country cnt ON pk.cntid=cnt.country_id JOIN state st ON st.state_id=pk.stid JOIN city cty ON cty.city_id=pk.ctyyid JOIN category cat ON cat.categoryid=pk.cattid WHERE package_uniq=:puid");
		$found_detail->bindParam(':puid',$puid);
		$found_detail->execute();
		$rows = $found_detail->fetchAll();
		if(count($rows)){
			foreach($rows as $row){
				$pid = $row['package_id'];
		
		
		if(isset($_POST['editpack'])){
			$restnme = $_POST['resrtname'];
			$dtype = $_POST['desttype'];
			$cntid = $_POST['cntid'];
			$stid = $_POST['steid'];
			$ctid = $_POST['ctid'];
			$cateid = $_POST['catid'];
			$prz = $_POST['pckprz'];
			$bud_from = $_POST['bdgfrom'];
			$bud_to = $_POST['bdgto'];
			$pduratn = $_POST['pckdurtion'];
			$durtin_frm = $_POST['durctnfrom'];
			$durtin_to = $_POST['durctnto'];
			$sean_from = $_POST['sesonfrom'];
			$sean_to = $_POST['sesonto'];
			$rting = $_POST['hotlratin'];
			$fstatus = $_POST['flstatus'];
			$overvw = $_POST['ovrview'];
			$feature = $_POST['pfeature'];
			$add_packages = $db->prepare("UPDATE packages SET resort_name=:restnme, type_destination=:dtype, cntid=:cntid, stid=:stid, ctyyid=:ctid, cattid=:cateid, pack_price=:prz, budget_from=:bud_from, budget_to=:bud_to, package_duration=:pduratn, duration_day=:durtin_frm, duration_night=:durtin_to, season_from=:sean_from, season_to=:sean_to, hotel_rating=:rting, flight_status=:fstatus, package_overview=:overvw, package_activity=:feature WHERE package_id=:pid");
			$add_packages->bindParam(':restnme',$restnme);
			$add_packages->bindParam(':dtype',$dtype);
			$add_packages->bindParam(':cntid',$cntid);
			$add_packages->bindParam(':stid',$stid);
			$add_packages->bindParam(':ctid',$ctid);
			$add_packages->bindParam(':cateid',$cateid);
			$add_packages->bindParam(':prz',$prz);
			$add_packages->bindParam(':bud_from',$bud_from);
			$add_packages->bindParam(':bud_to',$bud_to);
			$add_packages->bindParam(':pduratn',$pduratn);
			$add_packages->bindParam(':durtin_frm',$durtin_frm);
			$add_packages->bindParam(':durtin_to',$durtin_to);
			$add_packages->bindParam(':sean_from',$sean_from);
			$add_packages->bindParam(':sean_to',$sean_to);
			$add_packages->bindParam(':rting',$rting);
			$add_packages->bindParam(':fstatus',$fstatus);
			$add_packages->bindParam(':overvw',$overvw);
			$add_packages->bindParam(':feature',$feature);
			$add_packages->bindParam(':pid',$pid);
			$add_packages->execute();
			if(isset($add_packages)){
				foreach($_POST['act'] as $val){
				  if($val!=''){	
					$add_pckactv = $db->prepare("INSERT INTO pack_activity(pack_id,activt_id,pack_actdate)VALUES(:pid, :val, :date)");	
					$add_pckactv->bindParam(':pid',$pid);
					$add_pckactv->bindParam(':val',$val);
					$add_pckactv->bindParam(':date',$date);
					$add_pckactv->execute();
				  }
				}
				if($_FILES['addfles']!=''){
					if(!empty($_FILES['addfles'])){	
						$errors= array();
						foreach($_FILES['addfles']['tmp_name'] as $key => $tmp_name ){
							$file_name = $key.$_FILES['addfles']['name'][$key];
							$file_size =$_FILES['addfles']['size'][$key];
							$file_tmp =$_FILES['addfles']['tmp_name'][$key];
							$file_type=$_FILES['addfles']['type'][$key];	
							$addimages = $db->prepare("INSERT INTO package_images(img_pckid,p_image,pimage_date) VALUES(:pid,:file_name,:date)");
							$addimages->bindParam(':pid',$pid);
							$addimages->bindParam(':file_name',$file_name);
							$addimages->bindParam(':date',$date);
							$addimages->execute();
							if(isset($addimages)){
							  $desired_dir="../images/package_image";
								if(is_dir($desired_dir)==false){
									mkdir("$desired_dir", 0700);		// Create directory if it does not exist
								}
								if(is_dir("$desired_dir/".$file_name)==false){
									move_uploaded_file($file_tmp,"$desired_dir/".$file_name);
								}else{									// rename the file if another one exist
									$new_dir="$desired_dir/".$file_name;
									 rename($file_tmp,$new_dir) ;				
								}
							}
							else{
									print_r($errors);
							}
						}	
					  }
				}
				echo "<script>location.assign('resort.php')</script>";
			}
		}
		
			if(isset($_GET['del'])){
				$delid = $_GET['del'];
				$showdelimg = $db->prepare("SELECT p_image FROM package_images WHERE pimage_id=:delid");	
				$showdelimg->bindParam(':delid',$delid);
				$showdelimg->execute();
				$find = $showdelimg->fetch();
				$getfind = $find['p_image'];
				$delete_img = $db->prepare("DELETE FROM package_images WHERE pimage_id=:delid");
				$delete_img->bindParam(':delid',$delid);
				$delete_img->execute();
				if(isset($delete_img)){
					unlink('../images/package_image/',$getfind);	
					echo "<script>location.assign('edit-resort.php?resrt=$puid')</script>";
				}
			}
			
			if(isset($_GET['act'])){
				$acid = $_GET['act'];
				$dele_act = $db->prepare("DELETE FROM add_activity WHERE activity_id=:acid");	
				$dele_act->bindParam(':acid',$acid);
				$dele_act->execute();
				if(isset($dele_act)){
					echo "<script>location.assign('edit-resort.php?resrt=$puid')</script>";
				}
			}
		
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Edit Package</title>
<?php echo headdata(); ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="<?php echo $url; ?>css/font-awesome.min.css" type="text/css" rel="stylesheet"/>
<link href="<?php echo $url; ?>css/bootstrap.min.css" type="text/css" rel="stylesheet"/>
<link href="css/styleplus.css" type="text/css" rel="stylesheet"/>
<link href="css/responsive-manage.css" type="text/css" rel="stylesheet"/>
<script src="<?php echo $url; ?>js/jquery-3.2.1.min.js" type="text/javascript"> </script>
<script src="<?php echo $url; ?>js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/index.js"></script>
<script src="https://cdn.ckeditor.com/4.7.3/full/ckeditor.js" type="text/javascript"></script>
<script>
$(document).ready(function(e){
		$('#cntid').change(function(){
			var value =$(this).val();
			if(value==0){
					$('#steid').hide();
				}
				else { $('#steid').show();
					$.post('stfunction.php', {value: value}, function(data){
							$('#steid').html(data);
						});
				 }
		});
	});
	

$(document).ready(function(e){
		$('#steid').change(function(){
			var value =$(this).val();
			if(value==0){
					$('#ctid').hide();
				}
				else { $('#ctid').show();
					$.post('catfunction.php', {value: value}, function(data){
							$('#ctid').html(data);
						});
				 }
		});
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
	
      <div class="col-md-12 backdv">
        <a href="resort.php" class="backbtn"><i class="fa fa-arrow-left"></i>Back</a>
      </div>
      <div class="fulldv category-maindv">
        <div class="col-md-12 addresort_form">
         <form method="post" enctype="multipart/form-data">
        	<div class="col-md-12">
            	<h2>Edit Resort Name <?php echo $row['resort_name']; ?></h2>
            </div>
            
            <div class="col-md-3">
            	<p>Package Name</p>
            	<input type="text" name="resrtname" value="<?php echo $row['resort_name']; ?>" required>
            </div>
            <div class="col-md-3">
            	<p>Type Of Destination</p>
                <select name="desttype" id="" required>
                	<option value="<?php echo $row['type_destination']; ?>" hidden="hidden"><?php if($row['type_destination']=='1'){ echo "International"; }else{ echo "India"; } ?></option>
                    <option value="0">India</option>
                    <option value="1">International</option>
                </select>
            </div>
            
            
            <div class="col-md-3" id="">
            	<p>Country</p>
                <select name="cntid" id="cntid" required>
                	<option value="<?php echo $row['cntid']; ?>" hidden="hidden"><?php echo $row['country_name']; ?></option>
               <?php
			   	 $all_country = $db->prepare("SELECT * FROM country ORDER BY country_id DESC");
				 $all_country->execute();
				 $allcntry = $all_country->fetchAll();
				 foreach($allcntry as $alcnty){
			   ?> 	
                	<option value="<?php echo $alcnty['country_id']; ?>"><?php echo $alcnty['country_name']; ?></option>
               <?php } ?>     
                </select>
            </div>
            <div class="col-md-3">
            	<p>State</p>
                <select name="steid" id="steid" required>
                	<option value="<?php echo $row['stid']; ?>" hidden="hidden"><?php echo $row['state_name']; ?></option>
                </select>
            </div>
            <div class="col-md-3">
            	<p>City</p>
                <select name="ctid" id="ctid" required/>
                	<option value="<?php echo $row['ctyyid']; ?>" hidden="hidden"><?php echo $row['city_name']; ?></option>
                </select>
            </div>
            <div class="col-md-3">
            	<p>Category</p>
                <select name="catid" required/>
                	<option value="<?php echo $row['cattid']; ?>" hidden="hidden"><?php echo $row['categoryname']; ?></option>
                <?php
					$show_cate = $db->prepare("SELECT * FROM category ORDER BY categoryid DESC");
					$show_cate->execute();
					$allcat = $show_cate->fetchAll();
					foreach($allcat as $alct){
				?>
                	<option value="<?php echo $alct['categoryid']; ?>"><?php echo $alct['categoryname']; ?></option>
                <?php } ?>     
                </select>
            </div>
            <div class="col-md-3">
            	<p>Packages Price</p>
                <input type="text" name="pckprz" placeholder="Package Price" value="<?php echo $row['pack_price']; ?>" required/>
            </div>
            <div class="col-md-3">
            	<p>Budget Per Person ( in Rs. )</p>
                <input type="text" name="bdgfrom" value="<?php echo $row['budget_from']; ?>" style="width:50px;"> <span class="high">To</span><input type="text" name="bdgto" value="<?php echo $row['budget_to']; ?>" style="width:50px;">
            </div>
            <div class="col-md-3">
            	<p>Packages By Duration</p>
                <select name="pckdurtion" required>
                	<option value="<?php echo $row['package_duration']; ?>" hidden="hidden"><?php echo $row['package_duration']; ?></option>
                    <option value="1 to 3 Days">1 to 3 Days</option>
                    <option value="4 to 6 Days">4 to 6 Days</option>
                    <option value="7 to 9 Days">7 to 9 Days</option>
                    <option value="10 to 12 Days">10 to 12 Days</option>
                    <option value="13 Days or More">13 Days or More</option>
                </select>
            </div>
            <div class="col-md-3">
            	<p>Duration ( in Days/Night )</p>
                <input type="text" name="durctnfrom" value="<?php echo $row['duration_day']; ?>" style="width:50px;" required/> <span class="high">To</span>  
                <input type="text" name="durctnto" value="<?php echo $row['duration_night']; ?>" style="width:50px;" required/>
            </div>
            <div class="col-md-3">
            	<p>Packages By SEASON</p>
                <select name="sesonfrom" style="width:80px;">
                	<option value="<?php echo $row['season_from']; ?>" hidden="hidden"><?php echo $row['season_from']; ?></option>
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
                <span class="high">To</span>
                <select name="sesonto" style="width:80px;">
                	<option value="<?php echo $row['season_to']; ?>" hidden="hidden"><?php echo $row['season_to']; ?></option>
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
            </div>
            <div class="col-md-3">
            	<p>Hotel Star Rating</p>
                <select name="hotlratin" required/>
                	<option value="<?php echo $row['hotel_rating']; ?>" hidden="hidden"><?php echo $row['hotel_rating']; ?> Star</option>
                    <option value="1">1 star</option>
                    <option value="2">2 star</option>
                    <option value="3">3 star</option>
                    <option value="4">4 star</option>
                    <option value="5">5 star</option>
                </select>
            </div>
            <div class="col-md-2">
            	<p>Flight Status</p>
                <select name="flstatus" required/>
                	<option value="<?php echo $row['flight_status']; ?>" hidden="hidden"><?php echo $row['flight_status']; ?></option>
                    <option value="Included">Flight Included</option>
                    <option value="Excluded">Flight Excluded</option>
                </select>
            </div>
            
            <div class="col-md-12">
            	<p>Activities/Facilities</p>
                <ul class="facilities">
                <?php
					$show_activty = $db->prepare("SELECT * FROM add_activity WHERE activity_id NOT IN(SELECT activt_id FROM pack_activity WHERE pack_id='$pid') ORDER BY activity_id DESC");
					$show_activty->execute();
					$rowactv = $show_activty->fetchAll();
					foreach($rowactv as $rwactv){
				?>
                    <li><input type="checkbox" name="act[]" value="<?php echo $rwactv['activity_id']; ?>"><?php echo $rwactv['activity_name']; ?></li>
                <?php } ?>
                
                <?php
					$showw_activty = $db->prepare("SELECT ct.* FROM add_activity ct JOIN pack_activity pa ON pa.activt_id=ct.activity_id WHERE pa.pack_id='$pid'");
					$showw_activty->execute();
					$rowactvt = $showw_activty->fetchAll();
					foreach($rowactvt as $rwdactv){
						
				?>
                    <li><a href="edit-resort.php?act=<?php echo $rwdactv['activity_id']; ?>" onClick=" return ckdel();"><?php echo $rwdactv['activity_name']; ?></a></li>
                <?php } ?>    
                </ul>
            </div>
            <div class="col-md-12">
            	<p>Overview</p>
                <textarea rows="10" name="ovrview"><?php echo $row['package_overview']; ?></textarea>
            </div>
            <div class="col-md-12">
            	<p>Package Activity</p>
                <textarea name="pfeature" class="ckeditor" id="" cols="30" rows="10" required/><?php echo $row['package_activity']; ?></textarea><br>
            </div>
            <div class="col-md-12">
            	<p>Resort Image (You Can Select Multiple Images)</p>
                <input type="file" name="addfles[]" class="" multiple style="max-width:310px;"/>
                <ul class="sort_mg">
                <?php
					$showimages = $db->prepare("SELECT * FROM package_images WHERE img_pckid=:pid");
					$showimages->bindParam(':pid',$pid);
					$showimages->execute();
					$stmts = $showimages->fetchAll();
					foreach($stmts as $stt){
				?>	
                    <li>
                    	<img src="../images/package_image/<?php echo $stt['p_image']; ?>"alt="" height="50px;"/>
                        <a href="edit-resort.php?resrt=<?php echo $puid; ?>&del=<?php echo $stt['pimage_id']; ?>"  onClick=" return ckdel();">Delete</a>
                    </li>
                <?php } ?>    
                </ul>
            </div>
            <div class="col-md-12">
            	<input type="submit" value="Update" name="editpack">
            </div>
          </form>  
        </div> 
        <div class="clearfix"></div>
         <br><br>
        
    </div>
 
 </div>
 </div>
 </div>
 </body>
  </html>
 <?php } } else{ echo "page not found"; } 
  } else{ echo "page not found"; } 
  }
	}
	else{ echo "<script>location.assign('logout.php')</script>"; }
}
else{ echo "<script>location.assign('logout.php')</script>"; }
  ?>
