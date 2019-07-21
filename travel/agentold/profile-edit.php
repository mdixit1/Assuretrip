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
			
				if(isset($_POST['change'])){
					$newcname = $_POST['newcname'];	
					$newmail = $_POST['newmail'];
					$newmob = $_POST['newmob'];
					$newadd = $_POST['newadd'];
					$check_email = $db->prepare("SELECT COUNT(agent_mail) FROM agent_registration WHERE agent_mail=:newmail");	
					$check_email->bindParam(':newmail',$newmail);
					$check_email->execute();
					$chkmail = $check_email->fetchColumn();
					if($chkmail > 1){ $mesg = "Email already Exists"; }
					else{
						$check_mob = $db->prepare("SELECT COUNT(mobile) FROM agent_registration WHERE mobile=:newmob");	
						$check_mob->bindParam(':newmob',$newmob);
						$check_mob->execute();
						$chkmob = $check_mob->fetchColumn();
						if($chkmob > 1){ $mesg = "Mobile Number already Exists"; }
						else{
							$update_changes = $db->prepare("UPDATE agent_registration SET agent_company=:newcname, agent_mail=:newmail, mobile=:newmob, agent_address=:newadd WHERE agent_id=:agid");
							$update_changes->bindParam(':newcname',$newcname);
							$update_changes->bindParam(':newmail',$newmail);
							$update_changes->bindParam(':newmob',$newmob);
							$update_changes->bindParam(':newadd',$newadd);
							$update_changes->bindParam(':agid',$agid);
							$update_changes->execute();
							if(isset($update_changes)){
									$_SESSION['agmail'] = $newmail;
									echo "<script>location.assign('".$url."agent/profile-setting')</script>";
							}
							else{
								$mesg = "Server Busy";	
							}
						}
					}
				}
?>
<!DOCTYPE html>
<html lang="en-IN">
<head>
    <?php echo headdata(); ?>
    <link rel="canonical" href=""/>
    <link rel='shortlink' href=""/>
	<title>Edit Profile</title>
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
            	<h4>Edit Contact Information </h4>
            </div>
            <p><?php if(isset($mesg)){ echo $mesg; } ?></p>
            <div class="col-md-5 p0">
             <form method="post">
            	<div class="col-md-12">
                    <p>Name</p>
                    <input type="text" name="newcname" value="<?php echo $st['agent_company']; ?>">
                </div>
            	<div class="col-md-12">
                    <p>Email ID</p>
                    <input type="text" name="newmail" value="<?php echo $st['agent_mail']; ?>">
                </div>
                <div class="col-md-12">
                <p>Mobile No.</p>
                <input type="text" name="newmob" value="<?php echo $st['mobile']; ?>">
                </div>
                <div class="col-md-12">
                <p>Address</p>
                <input type="text" name="newadd" value="<?php echo $st['agent_address']; ?>">
                </div>
                <div class="col-md-12">
                	<input type="submit" name="change" value="Update">
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
