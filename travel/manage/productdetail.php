<?php
session_start();
include('../connection/index.php');
$recaid = $_SESSION['aid'];
$recmail = $_SESSION['amail'];
$recpass = $_SESSION['apass'];	
if(isset($_SESSION['amail']) && isset($_SESSION['aid']) && isset($_SESSION['apass'])){
	$userdetail = $db->prepare("SELECT * FROM manage WHERE manageid =:recaid AND manage_email=:recmail AND manage_password = :recpass");
	$userdetail->bindParam(':recaid',$recaid);
	$userdetail->bindParam(':recmail',$recmail);
	$userdetail->bindParam(':recpass',$recpass);
	$userdetail->execute();
	$userd = $userdetail->fetchAll();
	if(count($userd)){
		foreach($userd as $usr){
			$recname = $usr['manage_name'];
				if(isset($_GET['lst'])){
					$getlstid = $_GET['lst'];
					$lst_name = $db->prepare("SELECT person_name FROM listing_detail WHERE list_id=:getlstid");
					$lst_name->bindParam(':getlstid',$getlstid);
					$lst_name->execute();
					$fnd = $lst_name->fetch();
					
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Product Detail</title>
<link href="<?php echo $url; ?>css/font-awesome.min.css" type="text/css" rel="stylesheet"/>
<link href="<?php echo $url; ?>css/bootstrap.min.css" type="text/css" rel="stylesheet"/>
<link href="css/styleplus.css" type="text/css" rel="stylesheet"/>
<link href="css/responsive-manage.css" type="text/css" rel="stylesheet"/>
<script src="<?php echo $url; ?>js/jquery-3.2.1.min.js" type="text/javascript"> </script>
<script src="<?php echo $url; ?>js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/index.js"></script>
</head>

<body>
<?php include('aheader.php'); ?>
	
<div class="slidebody trans5s">
    <?php include('topheader.php'); ?>
<div class="dv100 adminbody">
    <div class="section">
        <div class="see-12">
        	<h2><a href="listingdetail.php"><?php echo $fnd['person_name']; ?></a></h2>
          <?php
		  	  if(isset($_GET['status'])){	
						$get_srvid = $_GET['status'];
						$findstatus = $db->prepare("SELECT product_active_status FROM add_product WHERE product_id=:get_srvid");
						$findstatus->bindParam(':get_srvid',$get_srvid);
						$findstatus->execute();
						$st = $findstatus->fetch();
						$found_status = $st['product_active_status'];	
						if($found_status=='0'){
								$status_active = $db->prepare("UPDATE add_product SET product_active_status='1' WHERE product_id=:get_srvid");
								$status_active->bindParam(':get_srvid',$get_srvid);
								$status_active->execute();
								if(isset($status_active)){	
									
										echo "<script>location.assign('productdetail.php?lst=$getlstid')</script>"; 
								}
								else{ echo "Server Error"; }
						}
						if($found_status=='1'){
							$status_deactive = $db->prepare("UPDATE add_product SET product_active_status='0' WHERE product_id=:get_srvid");
							$status_deactive->bindParam(':get_srvid',$get_srvid);
							$status_deactive->execute();
							if(isset($status_deactive)){	
							
									echo "<script>location.assign('productdetail.php?lst=$getlstid')</script>"; 
							}
							else{ echo "Server Error"; }
						}
				}
			  else{ 
		  ?>	  
        	<div class="dv100 userdetail">
            	<center><h2>Product Detail</h2></center>
              <table class="see-table see-table-each" >
               <th>S.No</th>
               <th>Product Name</th>
               <th>Product Price</th>
               <th>Image</th>
               <th>Feature</th>
               <th>Description</th>
               <th>Date</th>
               <th>Status</th>
               
               
                <?php
				    $i = 0;
					$allusers = $db->prepare("SELECT * FROM add_product WHERE p_lstid=:getlstid ORDER BY product_id DESC");
					$allusers->bindParam(':getlstid',$getlstid);
					$allusers->execute();
                    $alldetail = $allusers->fetchAll();
                    foreach($alldetail as $row){
						 $pid = $row['product_id'];
						 $i++;
				 ?>
                 <tr>
                	<td><?php echo $i; ?></td>
                    <td><?php echo $row['product_name']; ?></td>
                    <td><?php echo $row['product_price']."/-"; ?></td>
                    <td><img src="../images/product/<?php echo $row['product_image']; ?>" height="50px;" alt=""></td>
                    <td><?php echo $row['product_feature']; ?></td>
                    <td><?php echo $row['product_desc']; ?></td>
                    <td><?php echo date('d-M-Y',strtotime($row['product_date'])); ?></td>
                    <td><a href="productdetail.php?lst=<?php echo $getlstid; ?>&status=<?php echo $pid; ?>"><?php if($row['product_active_status']=='1'){ ?><img src="../images/active.png" height="20px;"><?php } else { ?> <img src="../images/deactive.png" height="20px;"><?php } ?></a></td>
                </tr>     
             <?php } ?>  
             </table> 
            </div>
          <?php } ?>
        </div>
    </div>
</div>
<?php if(isset($_POST['status'])){ 
        $getordid = $_POST['odrid'];
		$detail = $_POST['addstatus'];
		$updatestatus = $db->exec("UPDATE listing_detail SET pay_status='$detail' WHERE list_id='$getordid' ");
		if(isset($updatestatus)){
			echo "<script>location.assign('listingdetail.php')</script>";
		}
	  }
?>
</div>
</body>
</html>
<?php } else { echo "No Detail Found"; } } 
	}
	else{ echo "<script>location.assign('logout.php')</script>"; }
}
else{ echo "<script>location.assign('logout.php')</script>"; }
?> 