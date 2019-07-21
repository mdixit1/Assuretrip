<?php
error_reporting(0);
session_start();
include('../function.php');
include('../connection/index.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Add Plans</title>
<?php echo headdata(); ?>
<link href="style/admin-style.css" rel="stylesheet" type="text/css"/>.
<link href="../images/company-overview.png" rel="icon">
<link href="css/see.css" type="text/css" rel="stylesheet"/>
<link rel="stylesheet" href="http://www.joongroup.in/css/see.css" />
<link href="css/responsive-manage.css" type="text/css" rel="stylesheet"/>
<link href="css/styleplus.css" type="text/css" rel="stylesheet"/>
<link href="css/index.css" type="text/css" rel="stylesheet"/>
<script src="js/jquery-2.1.3.min.js" type="text/javascript"></script>
<script src="js/index.js" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript"> function checkDelete(){ return confirm('Are you sure?'); } </script>
</head>

<body>
<?php include('plusheader.php'); ?>
<div class="slidebody see-trans5s">
    <div class="section headersection see-trans5s">
    	<div class="see-12">
        	<div class="dv100">
            	<div class="navbtn">
                	<span class="spnnavbtn1">&times;</span>
                    <span class="spnnavbtn2">&equiv;</span>
                </div>
                <div class="usernamedv">
               		<h4><?php echo "Welcome  ".$recivename; ?></h4>
                	<img src="../images/admin.png" alt=""/> 
                </div>
            </div>
        </div>
    </div>
    
    <div class="dv100 adminbody">
   <?php
   		if(isset($_GET['editplan'])){
				$plid = $_GET['editplan'];
				$getpdetail = $db->prepare("SELECT planprice,plandiscription FROM plans WHERE planid=:plid");
				$getpdetail->bindParam(':plid',$plid);
				$getpdetail->execute();
				$data = $getpdetail->fetch();
				$plprice = $data['planprice'];
				$pldisc = $data['plandiscription'];
		}
  ?>		
  
	<?php
	     if(isset($_GET['editplan'])){
			  if(isset($_POST['submitplan'])){
		 		$plnid = $_GET['editplan'];
				$newplanprice = $_POST['pprice'];
				$newplandisc = $_POST['plandisc'];
				$updatedetail = $db->prepare("UPDATE plans SET planprice=:newplanprice, plandiscription=:newplandisc WHERE planid=:plnid ");
				$updatedetail->bindParam(':newplanprice',$newplanprice);
				$updatedetail->bindParam(':newplandisc',$newplandisc);
				$updatedetail->bindParam(':plnid',$plnid);
				$updatedetail->execute();
				if(isset($updatedetail)){
									echo "<script>location.assign('plans.php')</script>";
				}
				else{
					 echo "Not Updated";
				}
			  }
		 }
		 else{
					
		   if(isset($_POST['submitplan'])){
				$planprice = $_POST['pprice'];
				$plandisc = $_POST['plandisc'];
				$plandate = date('d - M - Y');
				$insertdetail = $db->prepare("INSERT INTO plans(planprice,plandiscription,plandate)VALUES(:planprice,:plandisc,:plandate)");
				$insertdetail->bindParam(':planprice',$planprice);
				$insertdetail->bindParam(':plandisc',$plandisc);
				$insertdetail->bindParam(':plandate',$plandate);
				$insertdetail->execute();
				if(isset($insertdetail)){
				}
				else{
					  echo "Plan Not Added";
				}
		   }
		 }
	?>	
<div class="fulldv">
    <div class="col-md-6 p0 addplan">
        <form method="post">
            <div class="col-md-4">
                <p>Plan Price</p>
                <input type="text" name="pprice" value="<?php echo $plprice;?>" placeholder="Enter Plan Price" required>
            </div>
            <div class="col-md-12">
                <p>Plan Discription</p>
                <textarea name="plandisc" placeholder="Enter plan discription" rows="8" cols="50" required><?php echo $pldisc;?></textarea>
            </div>
            <div class="col-md-6">
            	<input type="submit" name="submitplan" value="Submit">
            </div>
        </form>
    </div>
 </div>
 
<table class="see-table see-table-each" style="display:none;">
<?php
	$showplans = $db->prepare("SELECT sa.statename , pl.planid , pl.planprice , pl.plandiscription FROM plans pl JOIN state sa ON sa.stateid = pl.plan_state_id ORDER BY planid DESC");
	$showplans->execute();
	$plandetail = $showplans->fetchAll();
	foreach($plandetail as $alldetail){
		$pid = $alldetail['planid'];
		$statename = $alldetail['statename'];
		$pprice = $alldetail['planprice'];
		$pdisc = $alldetail['plandiscription']; ?>
		<tr>
			<td><?php echo $statename; ?></td>
			<td><?php echo $pprice; ?></td>
			<td><?php echo $pdisc; ?></td>
			<td><a href="plans.php?editplan=<?php echo $pid; ?>">Edit Plans</a></td>
			<td><a href="plans.php?delplan=<?php echo $pid;?>" onClick="return checkDelete()">Delete</a></td>
		</tr>
<?php } ?>     
</table>

<?php
if(isset($_GET['delplan'])){
	$delplid = $_GET['delplan'];
	$deleteplan = $db->prepare("DELETE FROM plans WHERE planid=:delplid");
	$deleteplan->bindParam(':delplid',$delplid);
	$deleteplan->execute();
	if(isset($deleteplan)){ echo "<script>location.assign('plans.php')</script>"; }
	else{ echo "Server down";
}
} ?>	
</div>
</div>		
</body>
</html>
