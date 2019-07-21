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
			$recimage = $st['agent_profile'];
			
			if(isset($_POST['changeprof'])){
				$newname = $_POST['nwname'];
				$newmail = $_POST['nwmail'];
				$newmob = $_POST['nwmob'];
				$newadd = $_POST['nwadd'];
				$profilepic = $_FILES['proflpic']['name'];
				$prftemp = $_FILES['proflpic']['tmp_name'];
				$ext = pathinfo($profilepic,PATHINFO_EXTENSION);
				$newname = uniqid().".".$ext;
				$target = "images/profile_image/".$newname;
				$update_profile = $db->prepare("UPDATE agent_registration SET agent_name=:newname, agent_mail=:newmail, mobile=:newmob, agent_address=:newadd, agent_profile=:profilepic WHERE agent_id=:agid");
				$update_profile->bindParam(':newname',$newname);
				$update_profile->bindParam(':newmail',$newmail);
				$update_profile->bindParam(':newmob',$newmob);
				$update_profile->bindParam(':newadd',$newadd);
				$update_profile->bindParam(':profilepic',$profilepic);
				$update_profile->bindParam(':agid',$agid);
				$update_profile->execute();
				if(isset($update_profile)){ 
					unlink('images/profile_image/'.$recimage);
					move_uploaded_file($prftemp,$target);
					echo "<script>location.assign('".$url."agent/profile')</script>";
				}
				
			}
?>
<!DOCTYPE html>
<html lang="en-IN">
<head>
    <?php echo headdata(); ?>
    <link rel="canonical" href=""/>
    <link rel='shortlink' href=""/>
	<title>Profile Edit</title>
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
            	<h4>My Account </h4>
            </div>
            <div class="col-md-5 p0">
            <form method="post" enctype="multipart/form-data">
            	<div class="col-md-6">
                    <p>Full Name</p>
                    <input type="text" name="nwname" value="<?php echo $st['agent_name']; ?>" required/>
                </div>
                <div class="col-md-12">
                    <p>Email</p>
                    <input type="text" name="nwmail" value="<?php echo $st['agent_mail']; ?>" required/>
                </div>
                <div class="col-md-12">
                    <p>Mobile</p>
                    <input type="text" name="nwmob" value="<?php echo $st['mobile']; ?>" required/>
                </div>
                <div class="col-md-12">
                	<p>Address</p>
                    <textarea name="nwadd" id="" cols="30" rows="10"><?php echo $st['agent_address']; ?></textarea>
                </div>
                <div class="col-md-12">
                    <p>Profile Pic</p>
                    <input type="file" name="proflpic">
                </div>
                <div class="col-md-6">
                	<input type="submit" name="changeprof" value="Update">
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
