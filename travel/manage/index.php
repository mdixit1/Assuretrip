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
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title> Welcome to Travel </title>
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
<div class="slidebody trans5s">
    <?php include('topheader.php'); ?>
    <div class="fulldv adminbody  budget_sect">
        <div class="section">
			<div class="fulldv p20 top_box_main">
            	<div class="col-md-4 top_box_out">
                	<a href="<?php echo $url; ?>/manage/listingdetail.php">
                    <div class="fulldv top_box">
                    <?php
						$count_agent = $db->prepare("SELECT COUNT(agent_id) FROM agent_registration");
						$count_agent->execute();
						$cntagt = $count_agent->fetchColumn();
					?>
                    	<h1>Total Agent</h1>
                        <p><?php echo $cntagt; ?></p>
                    </div>
                    </a>
                </div>
                
                
                
                <div class="col-md-4 top_box_out">
                    <a href="<?php echo $url; ?>/manage/leads.php">
                    <div class="fulldv top_box">
                    <?php
						$count_leads = $db->prepare("SELECT COUNT(leads_id) FROM leads");
						$count_leads->execute();
						$counld = $count_leads->fetchColumn();
					?>
                        <h1>Total Leads</h1>
                        <p><?php echo $counld; ?></p>
                    </div>
                    </a>
                </div>
                
                <div class="col-md-4 top_box_out">
                    <a href="<?php echo $url; ?>/manage/destination.php?indian">
                    <div class="fulldv top_box">
                        <h1>Indian Destinations</h1>
                        <?php
					  	$count_indian = $db->prepare("SELECT COUNT(package_id) FROM packages WHERE type_destination='0'");
						$count_indian->execute();
						$count_ind = $count_indian->fetchColumn();
					   ?>  
                        <p><?php echo $count_ind; ?></p>	
                    </div>
                    </a>
                </div>
                
                <div class="col-md-4 top_box_out">
                    <a href="<?php echo $url; ?>/manage/destination.php?international">
                    <div class="fulldv top_box">
                        <h1>International Destinations</h1>
                      <?php
					  	$count_interntion = $db->prepare("SELECT COUNT(package_id) FROM packages WHERE type_destination='1'");
						$count_interntion->execute();
						$count_int = $count_interntion->fetchColumn();
					  ?>  
                        <p><?php echo $count_int; ?></p>	
                    </div>
                    </a>
                </div>
                
                <div class="col-md-4 top_box_out">
                    <a href="<?php echo $url; ?>/manage/leads.php?transfered">
                    <div class="fulldv top_box">
                        <h1>Total Lead Transfered</h1>  
                        <?php
					  	$count_leads = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer");
						$count_leads->execute();
						$count_ld = $count_leads->fetchColumn();
					    ?> 
                        <p><?php echo $count_ld; ?></p>	
                    </div>
                    </a>
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