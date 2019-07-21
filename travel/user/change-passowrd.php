<?php
error_reporting(0);
session_start();
include('../connection/index.php');
include('../function.php');
if(isset($_SESSION['usrid']) && isset($_SESSION['usrmail']) && isset($_SESSION['usrpass'])){
	$recid = $_SESSION['usrid'];
	$recmail = $_SESSION['usrmail'];
	$recpass = $_SESSION['usrpass'];
	$user_detail = $db->prepare("SELECT * FROM users WHERE user_id=:recid");
	$user_detail->bindParam(':recid',$recid);
	$user_detail->execute();
	$stmt = $user_detail->fetchAll();
	if(count($stmt)){
		foreach($stmt as $st){
			$recname = $st['user_name'];
				if(isset($_POST['editpass'])){
				  $oldpass = md5($_POST['opass']);
				  $newpass = md5($_POST['npass']);
				  $repass = md5($_POST['repass']);
				  if($recpass == $oldpass){
					 if($newpass == $repass){
						  $changedata = $db->prepare("UPDATE users SET user_pass=:newpass WHERE user_pass=:oldpass AND user_id=:recid");
						  $changedata->bindParam(':newpass',$newpass);
						  $changedata->bindParam(':oldpass',$oldpass);
						  $changedata->bindParam(':recid',$recid);
						  $changedata->execute();
						  if(isset($changedata)){
							  $_SESSION['usrpass'] = $newpass;
							  $error = "Password Succefully Updated"; 
						  }
						  else { $error = "Server Error"; }	 
					 }
					 else{ $error = "Retype not match with New password"; } 	 
				  }
				  else { $error = "Old Password Not Match"; }
				}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Change Password</title>
<?php echo headdata(); ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="<?php echo $url; ?>css/font-awesome.min.css" type="text/css" rel="stylesheet"/>
<link href="<?php echo $url; ?>/css/bootstrap.min.css" type="text/css" rel="stylesheet"/>
<link href="css/styleplus.css" type="text/css" rel="stylesheet"/>
<link href="css/responsive-manage.css" type="text/css" rel="stylesheet"/>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="<?php echo $url; ?>js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/admin.js"></script>
<script src="js/index.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="http://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
<script src="http://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>
<script>
(function($,W,D)
	{ var JQUERY4U = {};
    JQUERY4U.UTIL = {
        setupFormValidation: function() { $("#register-form").validate({
                rules: {
					opass : { required: true  },
                    npass: { required: true, minlength: 8 },
					repass: {  required: true, equalTo: "#npass" }
                },
                messages: {
					opass : { 
						required: "Please Enter Your Old Password"
					}, 
                    npass: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 8 characters long"
                    },
					repass: {
                        required: "Please provide a Re - password",
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
<?php include('aheader.php'); ?>
<div class="slidebody see-trans5s">
    <?php include('topheader.php'); ?>
    <div class="fulldv adminbody">	  
          <br><br>
          <div class="col-md-5 center-block changepass">
          <p style="color:rgba(255,0,4,1.00);"><?php if(isset($error)){ echo $error; } ?></p>
		  	  <form method="post" id="register-form">
                <h4>Change Password</h4>
                <input type="password" name="opass" placeholder="Old Password" required>
                <input type="password" name="npass" id="npass" placeholder="New Password" required>
                <input type="password" name="repass" placeholder="Retype Password" required>
                <input type="submit" name="editpass" value="Change Password" class="see-trans5s">
              </form>
          </div>
    </div>
</div>
</body>
</html>
<?php } } else { echo "<script>location.assign('".$url."user/logout.php')</script>"; }
} else { echo "<script>location.assign('".$url."user/logout.php')</script>"; } ?>
