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
	<title>Welcome to travel.com</title>
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
    
    
</head>
<body>
<div class="see-section wrapper_mg">

<div class="see-section main_dv"> 
    <?php include('leftmenu.php'); ?>
    
    <div class="col-md-12 p0 rightsidebar">
        <?php include('rightheader.php');?>
        <div class="col-md-12 rightsidebar_top2"></div>
        <!--<div class="col-md-12 rightsidebar_top3">
        	<select name="" id="">
            	<option value="" hidden="">Destinations</option>
            	<option value="">Delhi</option>
            	<option value="">Kerla</option>
            </select>
        </div>-->
        <div class="fulldv prfile_sect">
        	<div class="col-md-12 prodv">
            	<div class="prifile_mg_dv"></div>
                <h3><?php echo $st['agent_company']; ?></h3>
                <h4>707 Trips Sold</h4>
                <p>
                	<i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                </p>
                <ul>
                	<li>
                    	<span><i class="fa fa-map-marker"></i>Address</span> <br> <?php echo $st['agent_address']; ?>
                    </li>
                    <li><span><i class="fa fa-envelope"></i> Email ID</span><br> <?php echo $st['agent_mail']; ?></li>
                    <li><span><i class="fa fa-mobile-phone"></i>Mobile No.</span> <br> <?php echo $st['mobile']; ?> </li>
                </ul>
            </div>
            <div class="col-md-12 prodv2">
            	<h2>80.00% Reviews</h2>
                <h3>Reviews 4 / 5 <br>201 reviews</h3>
                <ul>
                	<li><p>5 &nbsp; <i class="fa fa-star"></i></p><div class="starbar"><div style="width:20%;"></div></div><p>72</p></li>
                    <li><p>4 &nbsp; <i class="fa fa-star"></i></p><div class="starbar"><div style="width:30%;"></div></div><p>88</p></li>
                    <li><p>3 &nbsp; <i class="fa fa-star"></i></p><div class="starbar"><div style="width:13%;"></div></div><p>39</p></li>
                    <li><p>2 &nbsp; <i class="fa fa-star"></i></p><div class="starbar"><div style="width:2%;"></div></div><p>1</p></li>
                    <li><p>1 &nbsp; <i class="fa fa-star"></i></p><div class="starbar"><div style="width:0%;"></div></div><p>0</p></li>
                </ul>
            </div>
        </div>
        <div class="fulldv proabout">
        	<h4>About</h4>
            <p><?php echo $st['company_profile']; ?></p>
        </div>
        
    </div>
</div>
  


</div>

<script src="<?php echo $url; ?>js/slick.js" type="text/javascript"></script>
<script src="<?php echo $url; ?>js/custom.js" type="text/javascript"></script>




</body>
</html>
<?php } } else{ echo "</script>location.assign('".$url."agent/logout.php')</script>"; }
      } else{ echo "</script>location.assign('".$url."agent/logout.php')</script>"; } ?>
