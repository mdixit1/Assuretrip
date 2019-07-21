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
                <h2 style="margin-top:0;">Indian Resorts</h2>
            </div>
           <div class="col-md-12 p0 activity_table">
           <?php if(isset($_GET['indian'])){ ?>
           
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
					$sno = 1;
					$all_packages = $db->prepare("SELECT pck.*,cn.country_name,st.state_name,ct.city_name FROM packages pck JOIN country cn ON cn.country_id=pck.cntid JOIN state st ON st.state_id=pck.stid JOIN city ct ON ct.city_id=pck.ctyyid WHERE type_destination='0' ORDER BY package_id DESC");
					$all_packages->execute();
					$rows = $all_packages->fetchAll();
					foreach($rows as $row){
				?>    
                    <tr>
                        <td><?php echo $sno++; ?></td>
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
                
           <?php } elseif(isset($_GET['international'])){ ?>
           
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
					$sno = 1;
					$all_packages = $db->prepare("SELECT pck.*,cn.country_name,st.state_name,ct.city_name FROM packages pck JOIN country cn ON cn.country_id=pck.cntid JOIN state st ON st.state_id=pck.stid JOIN city ct ON ct.city_id=pck.ctyyid WHERE type_destination='1' ORDER BY package_id DESC");
					$all_packages->execute();
					$rows = $all_packages->fetchAll();
					foreach($rows as $row){
				?>    
                    <tr>
                        <td><?php echo $sno++; ?></td>
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
                
           <?php } else{ ?>
           
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
					$sno = 1;
					$all_packages = $db->prepare("SELECT pck.*,cn.country_name,st.state_name,ct.city_name FROM packages pck JOIN country cn ON cn.country_id=pck.cntid JOIN state st ON st.state_id=pck.stid JOIN city ct ON ct.city_id=pck.ctyyid ORDER BY package_id DESC");
					$all_packages->execute();
					$rows = $all_packages->fetchAll();
					foreach($rows as $row){
				?>    
                    <tr>
                        <td><?php echo $sno++; ?></td>
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
                
           <?php } ?>     
           </div>
           
           <!--<ul class="pagination">
           	  <li class="disabled"><a href="#">&laquo;</a></li>
              <li class="active"><a href="#">1</a></li>
              <li><a href="#">1</a></li>
              <li><a href="#">1</a></li>
              <li><a href="#">1</a></li>
              <li><a href="#">1</a></li>
              <li><a href="#">1</a></li>
              <li><a href="#">&raquo;</a></li>
           </ul>-->
           
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