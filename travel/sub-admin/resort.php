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
			
		if(isset($_POST['firststep'])){
			$uniq = uniqid();
			$restnme = $_POST['resrtname'];
			$dtype = $_POST['desttype'];
			$cntid = $_POST['cntid'];
			$stid = $_POST['steid'];
			$ctid = $_POST['ctid'];
			$add_resort = $db->prepare("INSERT INTO packages(package_uniq,resort_name,type_destination,cntid,stid,ctyyid,package_date)VALUES(:uniq, :restnme, :dtype, :cntid, :stid, :ctid, :date)");
			$add_resort->bindParam(':uniq',$uniq);
			$add_resort->bindParam(':restnme',$restnme);
			$add_resort->bindParam(':dtype',$dtype);
			$add_resort->bindParam(':cntid',$cntid);
			$add_resort->bindParam(':stid',$stid);
			$add_resort->bindParam(':ctid',$ctid);
			$add_resort->bindParam(':date',$date);
			$add_resort->execute();
			if(isset($add_resort)){
				echo "<script>location.assign('resort-more.php?resrt=$uniq')</script>";
			}
		}
		
			if(isset($_GET['del'])){
				$delid = $_GET['del'];
				$delete_record = $db->prepare("DELETE FROM packages WHERE package_id=:delid");
				$delete_record->bindParam(':delid',$delid);
				$delete_record->execute();
				if(isset($delete_record)){
					$delete_actv = $db->prepare("DELETE FROM pack_activity WHERE pack_id=:delid");
					$delete_actv->bindParam(':delid',$delid);
					$delete_actv->execute();
						$all_image = $db->prepare("SELECT p_image FROM package_images WHERE img_pckid=:delid");
						$all_image->bindParam(':delid',$delid);
						$all_image->execute();
						$foundimg = $all_image->fetchAll();
						foreach($foundimg as $fmimg){
							$pimg = $fmimg['p_image'];
							unlink('../images/package_image/'.$pimg);
							$delete_imag = $db->prepare("DELETE FROM package_images WHERE img_pckid=:delid");
							$delete_imag->bindParam(':delid',$delid);
							$delete_imag->execute();
							if(isset($delete_imag)){
								
							}
						}
						echo "<script>location.assign('resort.php')</script>";			
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
	  <div class="fulldv category-maindv">
    	<div class="col-md-12 addresort_form">
        	<div class="col-md-12">
            	<h2>Add Package</h2>
            </div>
          <form method="post">  
            <div class="col-md-3">
            	<p>Package Name</p>
            	<input type="text" name="resrtname" required>
            </div>
            <div class="col-md-3">
            	<p>Type Of Destination</p>
                <select name="desttype" id="" required>
                	<option value="" hidden="hidden">Select</option>
                    <option value="0">India</option>
                    <option value="1">International</option>
                </select>
                <!--<Script> 
				   $('#destination').change(function() {
						$('.desti').hide();
						$('#' + $(this).val()).show();
				 });
				</Script>-->
            </div>
            
            
            <div class="col-md-3" id="">
            	<p>Country</p>
                <select name="cntid" id="cntid" required>
                	<option value="" hidden="hidden">Select Country</option>
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
                	<option value="" hidden="hidden">State</option>
                </select>
            </div>
            <div class="col-md-3">
            	<p>City</p>
                <select name="ctid" id="ctid" required/>
                	<option value="" hidden="hidden">City</option>
                </select>
            </div>
            <div class="col-md-12">
            	<input type="submit" value="Add" name="firststep">
            </div>
         </form>   
        </div>
    
        
        <div class="fulldv category">
            <div class="fulldv">
                <h2>Resorts</h2>
            </div>
           <div class="col-md-12 p0 activity_table">
               <table class="see-table">
                    <tr class="bluetr">
                        <th style="width:70px;">S. NO.</th>
                        <th >Resort Name</th>
                        <th>Country</th>
                        <th>State</th>
                        <th>City</th>
                        <th style="width:80px; text-align:center;">Edit</th>
                        <th style="width:80px; text-align:center;">Delete</th>
                        <th style="width:80px; text-align:center;">View</th>
                        <th style="width:80px; text-align:center;">More</th>
                    </tr>
                <?php
					$all_packages = $db->prepare("SELECT pck.*,cn.country_name,st.state_name,ct.city_name FROM packages pck JOIN country cn ON cn.country_id=pck.cntid JOIN state st ON st.state_id=pck.stid JOIN city ct ON ct.city_id=pck.ctyyid ORDER BY package_id DESC");
					$all_packages->execute();
					$rows = $all_packages->fetchAll();
					foreach($rows as $row){
				?>    
                    <tr>
                        <td>1</td>
                        <td> <?php echo $row['resort_name']; ?> </td>
                        <td><?php echo $row['country_name']; ?></td>
                        <td><?php echo $row['state_name']; ?></td>
                        <td><?php echo $row['city_name']; ?></td>
                        <td style="text-align:center;">
                        	<a href="edit-resort.php?resrt=<?php echo $row['package_uniq']; ?>">
                                <span class="catedit"> <i class="fa fa-edit"></i> </span>
                            </a>
                        </td>
                        <td style="text-align:center;">
                            <a href="resort.php?del=<?php echo $row['package_id']; ?>">
                                <span class="catdelete"><i class="fa fa-trash"></i> </span>
                            </a>
                        </td>
                        <td style=" text-align:center;"><a href="view-resort.php?resrt=<?php echo $row['package_uniq']; ?>">View</a></td>
                        <td style=" text-align:center;">
                     <?php if($row['pack_price']==''){ ?>   
                        <a href="resort-more.php?resrt=<?php echo $row['package_uniq']; ?>">More</a>
                     <?php } ?>   
                     </td>
                    </tr>
               <?php } ?>
                </table>
           </div>
           <ul class="pagination">
           	  <li class="disabled"><a href="#">&laquo;</a></li>
              <li class="active"><a href="#">1</a></li>
              <li><a href="#">1</a></li>
              <li><a href="#">1</a></li>
              <li><a href="#">1</a></li>
              <li><a href="#">1</a></li>
              <li><a href="#">1</a></li>
              <li><a href="#">&raquo;</a></li>
           </ul>
        </div>
    </div>
 
 </div>
 </div>
 </div>
 </body>
  </html>
<?php  }
	}
	else{ echo "<script>location.assign('logout.php')</script>"; }
}
else{ echo "<script>location.assign('logout.php')</script>"; }
?>