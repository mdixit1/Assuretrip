<?php
error_reporting(0);
session_start();
include('../connection/index.php');
include('../function.php');
if(isset($_SESSION['agid']) && isset($_SESSION['agmail']) && isset($_SESSION['agpass'])){
	$agid = $_SESSION['agid'];
	$recpass = $_SESSION['agpass'];
	$agent_detail = $db->prepare("SELECT * FROM agent_registration WHERE agent_id=:agid");
	$agent_detail->bindParam(':agid',$agid);
	$agent_detail->execute();
	$stmt = $agent_detail->fetchAll();
	if(count($stmt)){
		foreach($stmt as $st){
			$recname = $st['agent_company'];
			
		if(isset($_POST['editpass'])){
			$old = md5($_POST['oldpass']);
			$new = md5($_POST['newpass']);
			
			if($old!=$recpass){
				$error = "Old Password Not Matched";
			}
			else{
				$change_password = $db->prepare("UPDATE agent_registration SET agent_pass=:new WHERE agent_id=:agid");
				$change_password->bindParam(':new',$new);
				$change_password->bindParam(':agid',$agid);
				$change_password->execute();
				if(isset($change_password)){
					$_SESSION['agpass'] = $new;
					$error = "Password has been changed";
				}
				else{
					$error = "Server Busy";	
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
	<title>Change Password</title>
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
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script src="http://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
	<script src="http://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>
    <script>
(function($,W,D)
	{ var JQUERY4U = {};
    JQUERY4U.UTIL = {
        setupFormValidation: function() { $("#register-form").validate({
                rules: {
					oldpass: { required: true },
					newpass: { required: true, minlength: 8 },
					retype: {  required: true, equalTo: "#newpass" },
                },
                messages: { 
				    oldpass: { required: "Please Enter Old password ", },
					newpass: {
                        required: "Enter password",
                        minlength: "Your password must be at least 8 characters long"
                    },
					retype: {
                        required: "Enter Re - password",
                        equalTo: "Password Not Match"
                    }
				},
                submitHandler: function(form) {
				form.submit();
                }
            });
        }
    }

    //when the dom has loaded setup form validation rules
    $(D).ready(function($) { JQUERY4U.UTIL.setupFormValidation();  });
})(jQuery, window, document);
</script>
    
</head>
<body>
<div class="see-section wrapper_mg">

<div class="see-section main_dv"> 
    <?php include('leftmenu.php'); ?>
    
    <div class="col-md-12 p0 rightsidebar">
        <?php include('rightheader.php');?>
        <div class="col-md-12 rightsidebar_top2">
        
        </div>
        <!--<div class="col-md-12 rightsidebar_top3">
        	<select name="" id="">
            	<option value="" hidden="">Destinations</option>
            	<option value="">Delhi</option>
            	<option value="">Kerla</option>
            </select>
        </div>-->
        
        <div class="col-md-12">
        	<h4 class="passtitle">User Change Password</h4>
            <div class="col-md-4 see-center change-psw">
                <div class="change-psw-in">
                <p><?php if(isset($error)){ echo $error; } ?></p>
                  <form method="post" id="register-form">
                      <p>Old Password</p>
                      <input type="password" name="oldpass" placeholder="Enter Old Password" required>
                      <p>New Password</p>
                      <input type="password" name="newpass" id="newpass" placeholder="Enter New Password" required>
                      <p>Retype Password</p>
                      <input type="password" name="retype" placeholder="Retype Password" required>
                      <input type="submit" name="editpass" value="Change Password">
                  </form>
                </div>
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
