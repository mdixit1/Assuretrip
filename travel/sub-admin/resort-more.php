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
		$get_detail = $db->prepare("SELECT package_id,resort_name FROM packages WHERE package_uniq=:resuqid");
		$get_detail->bindParam(':resuqid',$resuqid);
		$get_detail->execute();
		$stmt = $get_detail->fetchAll();
		if(count($stmt)){
			foreach($stmt as $st){
				$resrt_id = $st['package_id'];
				
				if(isset($_POST['addmore'])){
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
					$add_packages = $db->prepare("UPDATE packages SET cattid=:cateid, pack_price=:prz, budget_from=:bud_from, budget_to=:bud_to, package_duration=:pduratn, duration_day=:durtin_frm, duration_night=:durtin_to, season_from=:sean_from, season_to=:sean_to, hotel_rating=:rting, flight_status=:fstatus, package_overview=:overvw, package_activity=:feature WHERE package_id=:resrt_id");
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
					$add_packages->bindParam(':resrt_id',$resrt_id);
					$add_packages->execute();
					if(isset($add_packages)){
						foreach($_POST['act'] as $val){
							$add_pckactv = $db->prepare("INSERT INTO pack_activity(pack_id,activt_id,pack_actdate)VALUES(:resrt_id, :val, :date)");	
							$add_pckactv->bindParam(':resrt_id',$resrt_id);
							$add_pckactv->bindParam(':val',$val);
							$add_pckactv->bindParam(':date',$date);
							$add_pckactv->execute();
						}
						if(!empty($_FILES['addfles'])){	
						$errors= array();
						foreach($_FILES['addfles']['tmp_name'] as $key => $tmp_name ){
							$file_name = $key.$_FILES['addfles']['name'][$key];
							$file_size =$_FILES['addfles']['size'][$key];
							$file_tmp =$_FILES['addfles']['tmp_name'][$key];
							$file_type=$_FILES['addfles']['type'][$key];	
							$addimages = $db->prepare("INSERT INTO package_images(img_pckid,p_image,pimage_date) VALUES(:resrt_id,:file_name,:date)");
							$addimages->bindParam(':resrt_id',$resrt_id);
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
					  	echo "<script>location.assign('resort.php')</script>";
					}
				}
	}
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
<script src="https://cdn.ckeditor.com/4.7.3/full/ckeditor.js" type="text/javascript"></script>
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
        <!--<div class="see-12 topbox">
            <input type="button" value="Add Resort" class="btn-blue" onClick="addactivity()">
        </div>-->
        
        <div class="col-md-12 addresort_form">
         <form method="post" enctype="multipart/form-data">
        	<div class="col-md-12">
            	<h2><?php echo $st['resort_name']; ?></h2>
            </div>
            
            <div class="col-md-3">
            	<p>Category</p>
                <select name="catid" required/>
                	<option value="" hidden="hidden">Select</option>
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
                <input type="text" name="pckprz" placeholder="Package Price" required/>
                <!--<select name="pckprz">
                	<option value="" hidden="hidden">Select</option>
                    <option value="Less than 10,000">Less than 10,000</option>
                    <option value="10,000 - 20,000">10,000 - 20,000</option>
                    <option value="20,000 - 40,000">20,000 - 40,000</option>
                    <option value="40,000 - 60,000">40,000 - 60,000</option>
                    <option value="60,000 - 80,000">60,000 - 80,000</option>
                    <option value="Above 80,000">Above 80,000</option>
                </select>-->
            </div>
            <div class="col-md-3">
            	<p>Budget Per Person ( in Rs. )</p>
                <input type="text" name="bdgfrom" style="width:50px;"> <span class="high">To</span><input type="text" name="bdgto" style="width:50px;">
            </div>
            <div class="col-md-3">
            	<p>Packages By Duration</p>
                <select name="pckdurtion" required>
                	<option value="" hidden="hidden">Select</option>
                    <option value="1 to 3 Days">1 to 3 Days</option>
                    <option value="4 to 6 Days">4 to 6 Days</option>
                    <option value="7 to 9 Days">7 to 9 Days</option>
                    <option value="10 to 12 Days">10 to 12 Days</option>
                    <option value="13 Days or More">13 Days or More</option>
                </select>
            </div>
            <div class="col-md-3">
            	<p>Duration ( in Days/Night )</p>
                <input type="text" name="durctnfrom" style="width:50px;" required/> <span class="high">To</span>  
                <input type="text" name="durctnto" style="width:50px;" required/>
            </div>
            <div class="col-md-3">
            	<p>Packages By SEASON</p>
                <select name="sesonfrom" style="width:80px;">
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
                <span class="high">To</span>
                <select name="sesonto" style="width:80px;">
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
            </div>
            <div class="col-md-3">
            	<p>Hotel Star Rating</p>
                <select name="hotlratin" required/>
                	<option value="" hidden="hidden">Select</option>
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
                	<option value="" hidden="hidden">Select</option>
                    <option value="Included">Flight Included</option>
                    <option value="Excluded">Flight Excluded</option>
                </select>
            </div>
            
            <div class="col-md-12">
            	<p>Activities/Facilities</p>
                <ul class="facilities">
                <?php
					$show_activty = $db->prepare("SELECT * FROM add_activity ORDER BY activity_id DESC");
					$show_activty->execute();
					$rowactv = $show_activty->fetchAll();
					foreach($rowactv as $rwactv){
				?>
                    <li><input type="checkbox" name="act[]" value="<?php echo $rwactv['activity_id']; ?>"><?php echo $rwactv['activity_name']; ?></li>
                <?php } ?>    
                </ul>
            </div>
            <div class="col-md-12">
            	<p>Overview</p>
                <textarea rows="10" name="ovrview"></textarea>
            </div>
            <div class="col-md-12">
            	<p>Package Activity</p>
                <textarea name="pfeature" class="ckeditor" id="" cols="30" rows="10" required/></textarea><br>
            </div>
            <div class="col-md-12">
            	<p>Resort Image (You Can Select Multiple Images)</p>
                <input type="file" name="addfles[]" class="" multiple/>
            </div>
            <div class="col-md-12">
            	<input type="submit" value="Save" name="addmore">
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
  <?php }
	}
	else{ echo "<script>location.assign('logout.php')</script>"; }
  	  }
	}
	else{ echo "<script>location.assign('logout.php')</script>"; }
}
else{ echo "<script>location.assign('logout.php')</script>"; }
?>