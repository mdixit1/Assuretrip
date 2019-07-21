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
				$count_leads = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid");
				$count_leads->bindParam(':agid',$agid);
				$count_leads->execute();
				$conlds = $count_leads->fetchColumn();
				
				if(isset($_POST['updteterm'])){
					$newterm = $_POST['nwtrm'];	
					if($newterm!=''){
						$change_term = $db->prepare("UPDATE agent_registration SET term_condition=:newterm WHERE agent_id=:agid");
						$change_term->bindParam(':newterm',$newterm);
						$change_term->bindParam(':agid',$agid);
						$change_term->execute();
						if(isset($change_term)){ echo "<script>location.assign('".$url."agent/profile-setting')</script>"; }
						else { echo "Not Updated"; }
					}
					else{
						$error = "Enter Some Date";	
					}
				}
?><!DOCTYPE html>
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
        
        <div class="fulldv editaccount">
        	<div class="col-md-12">
            	<h4>Edit Default T&C </h4>
            </div>
            <div class="col-md-12 p0">
            <p style="color:rgba(255,0,4,1.00);"><?php if(isset($error)){ echo $error; } ?></p>
             <form method="post">
            	<div class="col-md-12">
                    <textarea name="nwtrm" id="" cols="30" rows="10" required/>
                    	<?php echo $st['term_condition']; ?>
                    </textarea>
                </div>
                <div class="col-md-12">
                	<input type="submit" name="updteterm" value="Update">
                </div>
             </form>   
            </div>
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
