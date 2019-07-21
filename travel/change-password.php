<?php
//error_reporting(0);
session_start();
include('function.php'); 
include('connection/index.php');

if((isset($_GET['mail'])) && (isset($_GET['code']))){
	$reccode = $_GET['code'];
	$recmail = $_GET['mail'];
	$checkdetail = $db->prepare("SELECT upass_code FROM users WHERE upass_code=:reccode AND user_mail=:recmail");
	$checkdetail->bindParam(':reccode',$reccode);
	$checkdetail->bindParam(':recmail',$recmail);
	$checkdetail->execute();
	$countdetail = $checkdetail->fetchAll();
	if(count($countdetail)){
		foreach($countdetail as $chckall){
			if(isset($_POST['change'])){
			$getcode = $_GET['code'];
			$getmail = $_GET['mail'];
			$newpassword = md5($_POST['newpass']);
			$repassword = md5($_POST['repass']);
			if(!($newpassword == $repassword)){
				
					$error = "<p style='color:#FC0105;'>Password Not Match</p>";
			}
			else{
				$updatepassword = $db->prepare("UPDATE users SET user_pass=:newpassword, upass_code='0' WHERE upass_code=:reccode AND user_mail=:recmail");
				$updatepassword->bindParam(':newpassword',$newpassword);
				$updatepassword->bindParam(':reccode',$reccode);
				$updatepassword->bindParam(':recmail',$recmail);
				$updatepassword->execute();
				if(isset($updatepassword)){
					$error = "<p style='color:#FC0105;' class='see-center'>Password Successfully Change</p>";	
				}
				else{
					$error = "<p style='color:#FC0105;'>Password Not Change</p>";	
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
	<title>Login</title>
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
    <link href="css/animation.css" type="text/css" rel="stylesheet" />
    <link href="<?php echo $url; ?>css/slit-slider.css" type="text/css" rel="stylesheet" />
    <script src="js/modernizr-2.6.2.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script src="http://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
	<script>
    (function($,W,D)
        { var JQUERY4U = {};
        JQUERY4U.UTIL = {
            setupFormValidation: function() { $("#change-form").validate({
                    rules: {
                        newpass: { required: true, minlength: 8 },
                        repass: {  required: true, equalTo: "#newpass" }
                    },
                    messages: { 
                       newpass: {
                            required: "<p style='color:#FC0105;'>Please provide a password</p>",
                            minlength: "<p style='color:#FC0105;'>Type atleast 8 characters</p>"
                        },
                        repass: {
                            required: "<p style='color:#FC0105;'>Please provide a Re - password</p>",
                            equalTo: "<p style='color:#FC0105;'>Password Not Match</p>"
                        },
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
<div class="see-section wrapper">
	<?php include('header.php'); ?>
    
    
    <div class="overlaydv loginfixed loginpopdv">
 	<div class="overlaydv-in">
    	<div class="overlaydv-inner">
        	<div class="loginmid">
            <div id="form" class="resultone">
            <p><?php if(isset($error)){ echo $error; } ?></p>
            <div class="col-2 registered-users"><strong>Create New Password</strong>
            	 <form method="post" id="change-form">
                  <div class="content">
                    <ul class="form-list">
                      <li>
                        <label for="email">New Password <span class="required">*</span></label>
                        <input type="password" name="newpass" id="newpass" placeholder="Enter New Password" class="input-text required-entry" required/>
                      </li>
                      <li>
                        <label for="pass">Password <span class="required">*</span></label>
                        <input type="password" name="repass" placeholder="Confirm Password" class="input-text required-entry validate-password" required/>
                      </li>
                    </ul>
                    <p class="required">* Required Fields</p>
                    <div class="buttons-set">
                      <input type="submit" name="change" value="Submit">
                      <a class="forgot-word" href="<?php echo $url; ?>login.php">Login?</a> </div>
                  </div>
                 </form>  
             </div>  
            </div>
        </div>
    </div>
 </div>

    <!-- Footer Section -->
    <?php include('footer.php') ?>

</div>

<script src="js/jquery-1.11.1.min.js"></script>
<!-- Custom Functions -->
<script src="js/main.js"></script> 

<script src="<?php echo $url; ?>js/slick.js" type="text/javascript"></script>
<script src="<?php echo $url; ?>js/custom.js" type="text/javascript"></script>


</body>
</html>
<?php } } else { ?>
<p>Page Not Found</p>
<?php } } else { ?>
<p>Page Not Found</p>
<?php } ?>

