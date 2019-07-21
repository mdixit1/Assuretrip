<?php
error_reporting(0);
session_start();
include('../connection/index.php');
include('../function.php'); 
if(isset($_SESSION['agid']) && isset($_SESSION['agmail']) && isset($_SESSION['agpass'])){
	$agid = $_SESSION['agid'];
	$agent_detail = $db->prepare("SELECT * FROM agent_registration WHERE agent_id=:agid");
	$agent_detail->bindParam(':agid',$agid);
	$agent_detail->execute();
	$stmt = $agent_detail->fetchAll();
	if(count($stmt)){
		foreach($stmt as $st){
			$recname = $st['agent_company'];
?>
<!DOCTYPE html>
<html lang="en-IN">
<head>
    <?php echo headdata(); ?>
    <link rel="canonical" href=""/>
    <link rel='shortlink' href=""/>
	<title>Welcome <?php echo $recname; ?></title>
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
    <link href="style/admin-style.css" rel="stylesheet" type="text/css"/>
    <link href="css/styleplus.css" type="text/css" rel="stylesheet"/>
    <link href="css/see.css" type="text/css" rel="stylesheet"/>
	<link href="css/responsive-manage.css" type="text/css" rel="stylesheet"/>
	<link href="css/index.css" type="text/css" rel="stylesheet"/>
    <link href="css/style_manage.css" type="text/css" rel="stylesheet" />
    <link href="css/vanillaCalendar.css" type="text/css" rel="stylesheet" />
    
</head>
<body>
<div class="see-section wrapper_mg">
	<?php include('leftmenu.php'); ?>
<div class="see-section main_dv">
    
    <div class="col-md-12 p0 rightsidebar">
        <?php include('rightheader.php');?>
        
        <div class="col-md-12 rightsidebar_top2 notititle">
        	<h4><i class="fa fa-calculator"></i> Payment Details</h4>
        </div>
        
        
        <div class="fulldv pay_detail_sect">
        	<ul>
            	<li>Total Payment has to received: 25,250.00</li>
                <li>Total Convenience fee: 250.0</li>
                <li>TCS Collected: 250.0 View Invoice</li>
                <li>Payment due from Traveller: 0.00</li>
                <li>Payment due from TT: 0.00</li>
            </ul>
            <table class="see-table">
            	<tr>
                	<th>Receiving Date</th>
                	<th>Installment Amount</th>
                	<th>Transferable to TT</th>
                	<th>Transferable to You</th>
                	<th>Amount Transfer/ Status</th>
                	<th>Mark Payment</th>
                </tr>
                <tr>
                	<td>22 Feb 2019</td>
                	<td><i class="fa fa-rupee"></i> 12,250.00</td>
                	<td><i class="fa fa-rupee"></i> 12,250.00</td>
                	<td>-</td>
                	<td>Transferred to you on 26 Feb 2019</td>
                	<td>Payment marked</td>
                </tr>
                <tr>
                	<td>30 Apr 2019</td>
                	<td>-</td>
                    <td>-</td>
                    <td><i class="fa fa-rupee"></i> 4,500.00</td>
                	<td>Transferred to you on 01 May 2019</td>
                	<td>Payment marked</td>
                </tr>
                <tr>
                	<td>22 Feb 2019</td>
                	<td><i class="fa fa-rupee"></i> 12,250.00</td>
                	<td><i class="fa fa-rupee"></i> 12,250.00</td>
                	<td>-</td>
                	<td>Transferred to you on 26 Feb 2019</td>
                	<td>Payment marked</td>
                </tr>
                <tr>
                	<td>30 Apr 2019</td>
                	<td>-</td>
                    <td>-</td>
                    <td><i class="fa fa-rupee"></i> 4,500.00</td>
                	<td>Transferred to you on 01 May 2019</td>
                	<td>Payment marked</td>
                </tr>
                <tr>
                	<td colspan="6" style="text-align:right;">In our next payment, we will transfer 0.00</td>
                </tr>
            </table>
              



        </div>
        
    </div>
</div>
  


</div>

<script src="<?php echo $url; ?>js/slick.js" type="text/javascript"></script>
<script src="<?php echo $url; ?>js/custom.js" type="text/javascript"></script>
<script src="<?php echo $url; ?>/agent/js/vanillaCalendar.js" type="text/javascript"></script>
<script>
	window.addEventListener('load', function () {
		vanillaCalendar.init({
			disablePastDays: true
		});
	})
</script>


</body>
</html>
<?php } } else{ echo "<script>location.assign('".$url."agent/logout.php')</script>"; }
      } else{ echo "<script>location.assign('".$url."agent/logout.php')</script>"; } ?>

