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
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="<?php echo $url; ?>css/font-awesome.min.css" type="text/css" rel="stylesheet"/>
<link href="<?php echo $url; ?>/css/bootstrap.min.css" type="text/css" rel="stylesheet"/>
<link href="css/styleplus.css" type="text/css" rel="stylesheet"/>
<link href="css/responsive-manage.css" type="text/css" rel="stylesheet"/>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="<?php echo $url; ?>js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/index.js"></script>
<script type="text/javascript">
function checkDelete(){
    return confirm('Are you sure?');
}
</script>
</head>

<body>
<?php include('aheader.php'); ?>
	
<div class="slidebody see-trans5s">
    <?php include('topheader.php'); ?>
    <div class="fulldv adminbody">
        <div class="section">
            <div class="fulldv p20">
                <?php if(isset($_POST['status'])){ 
                        $getuqordid = $_POST['unqodrid'];
                        $detail = $_POST['addstatus'];
                        $updatestatus = $db->exec("UPDATE userorderdetail SET status='$detail' WHERE uniqueorderid='$getuqordid' ");
                        if($updatestatus){
                            echo "<script>location.assign('usrorderdetail.php')</script>";
                        }
                      }
                ?>
                <?php
                    if(isset($_GET['cancel'])){
                        $oderid = $_GET['cancel'];
                        $deleteorder = $db->query("DELETE FROM userorderdetail WHERE orderid='$oderid'");
                        if($deleteorder){
                            echo "<script>location.assign('usrorderdetail.php')</script>";
                        }
                    }
                    
                ?>	
                   
                
                <div class="fulldv order_details">
                    <table class="see-table see-table-each">
                        <tr class="bluetr">
                            <td>S.No </td>
                            <td>Order Id </td>
                            <td>Name/Address </td>
                            <td>Status </td>
                            <td>Invoice </td>
                            <td>Payment </td>
                            <td>Date</td>
                            <td>Detail</td>
                        </tr>
                    
                    <?php
                    
                        $no = 1;
                        $example = $db->query("SELECT odr.uniqueorderid , odr.status , odr.orderdate , odr.paymentoption, odr.transtionid, usr.fname , usr.lname, usr.address , usr.postalcode , usr.city, usr.state FROM userorderdetail odr JOIN useraddress usr ON usr.addressid=odr.add_id GROUP BY odr.uniqueorderid");
                        $allexp = $example->fetchAll();
                        foreach($allexp as $exp){
                            $uniqeid = $exp['uniqueorderid']; 
                            $user_name = $exp['fname']." ".$exp['lname'];
                            $user_add = $exp['address'];
                            $city = $exp['city'];
                            $pin = $exp['postalcode'];
                            $near = $exp['state'];
                            $orderdate = $exp['orderdate'];
                            $paymentoption = $exp['paymentoption'];
                            $transactid = $exp['transtionid'];
                            $ostatus = $exp['status'];
                             ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $uniqeid; ?> </td>
                                    <td>
										<p style="margin-bottom:0; color:#333;"><strong><?php echo $user_name;?></strong></p>
										<?php echo $user_add." , Nr ".$near." - ".$pin; ?>
                                    </td>
                                    <td><form method="post">
                                             <input type="text" name="unqodrid" hidden="hidden" value="<?php echo $uniqeid; ?>">
                                                <select name="addstatus" required>
                                                    <option value="" hidden="hidden">Select Status</option>
                                                    <option value="packaging" >Packaging</option>
                                                    <option value="deliver to courier" >Deliver To Courier Co.</option>
                                                    <option value="delivered" >Delivered</option>
                                                </select>     
                                                <input type="submit" name="status" value="Add" class="see-trans5s">
                                            </form>
                                         <span class="status"><?php echo $ostatus; ?></span>
                                    </td>
                                    <td><a href="invoice.php?order=<?php echo $uniqeid;?>">Download</a></td>
                                     <td><?php if($transactid!=''){ echo "Pay Umoney"; }else{ echo "Cash On Delivery"; } ?></td>
                                    <td><?php echo $orderdate; ?></td>
                                    <td><a href="product-history.php?unique=<?php echo $uniqeid; ?>">View More</a></td>
                             </tr>
                    <?php } ?>	
                    </table>
                </div>
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
else{ echo "<script>location.assign('logout.php')</script>"; }
?> 