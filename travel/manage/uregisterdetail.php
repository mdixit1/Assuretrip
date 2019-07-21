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
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Order Detail</title>
<link href="css/styleplus.css" type="text/css" rel="stylesheet"/>
<link href="css/responsive-manage.css" type="text/css" rel="stylesheet"/>
<link href="../css/main-file.css" type="text/css" rel="stylesheet"/>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="js/index.js"></script>
</head>

<body>
<?php include('aheader.php'); ?>
	
<div class="slidebody trans5s">
    <?php include('topheader.php'); ?>
<div class="dv100 adminbody">
    <div class="section">
        <div class="see-12">
            <div class="dv100 userdetail">
              <table class="see-table see-table-each" >
               <th>S.No</th><th>OrderId</th><th>User Name</th><th>Product Name</th><th>Quantity</th><th>Price</th><th>Total Amount</th><th>Shipping Address</th><th>Status</th><th>Order Date</th>
                <?php
                    $i;
                    $allusers = $db->query("SELECT odr.* , usr.username, ship.address,ship.pincode FROM userorderdetail odr JOIN users usr ON odr.urid=usr.userid JOIN useraddress ship ON odr.urid=ship.usrid ORDER BY odr.orderid DESC");
                    $alldetail = $allusers->fetchAll();
                    foreach($alldetail as $all){
						 $odrid = $all['orderid'];
						 $uniqid = $all['uniqueorderid'];
                         $usrname = $all['username'];
                         $prdname = $all['prname'];
                         $prdqty = $all['prqty'];
                         $prdprice = $all['prprice'];
                         $image = $all['primage'];
						 $address = $all['address'];
						 $pin = $all['pincode'];
						 $status = $all['status'];
                         $oderdate = $all['orderdate'];  
						 $totalamt = $prdprice*$prdqty;
                         $i++;
                ?>
                <tr>
                	<td><?php echo $i; ?></td>
                    <td><?php echo $uniqid; ?></td>
                    <td><?php echo $usrname; ?></td>
                    <td><?php echo $prdname; ?></td>
                    <td><?php echo $prdqty; ?></td>
                    <td><?php echo $prdprice; ?></td>
                    <td><?php echo $totalamt; ?></td>
                    <td><?php echo $address." -&nbsp;".$pin; ?></td>
                    <td><form method="post">
                         <input type="text" name="odrid" hidden="hidden" value="<?php echo $odrid; ?>">
                    		<p><select name="addstatus" required/>
                            	<option value="" hidden="hidden">Select Status</option>
                                <option value="packaging" >Packaging</option>
                                <option value="deliver to courier" >Deliver To Courier Co.</option>
                                <option value="delivered" >Delivered</option>
                            </form></p>
                            <input type="submit" name="status" value="Add">
                     	</form>
                        <?php echo $status; ?>
                        </td>
                    <td><?php echo $oderdate; ?></td>
                </tr>     
             <?php } ?>  
             </table> 
            </div>
        </div>
    </div>
</div>
<?php if(isset($_POST['status'])){ 
        $getordid = $_POST['odrid'];
		$detail = $_POST['addstatus'];
		$updatestatus = $db->exec("UPDATE userorderdetail SET status='$detail' WHERE orderid='$getordid' ");
		if($updatestatus){
			echo "<script>location.assign('usrorderdetail.php')</script>";
		}
	  }
?>
		
</div>

</body>
</html>
<?php } 
	}
	else{ echo "<script>location.assign('logout.php')</script>"; }
}
else{ echo "<script>location.assign('logout.php')</script>"; }
?> 