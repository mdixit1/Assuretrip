<?php
error_reporting(0);
session_start();
include('function.php'); 
include('connection/index.php');
require_once('settings.php');

if(isset($_POST['submit'])){
	$code = rand(000000,999999);
	$name = $_POST['name'];
	$mail = $_POST['mail'];
	$mob = $_POST['mob'];
	$pass = md5($_POST['pass']);
	$check_email = $db->prepare("SELECT COUNT(user_mail) FROM users WHERE user_mail=:mail");	
	$check_email->bindParam(':mail',$mail);
	$check_email->execute();
	$chkmail = $check_email->fetchColumn();
	if($chkmail > 0){
                $error = "Email already Exists";
     }
	else{
		$check_mob = $db->prepare("SELECT COUNT(user_mobile) FROM users WHERE user_mobile=:mob");	
		$check_mob->bindParam(':mob',$mob);
		$check_mob->execute();
		$chkmob = $check_mob->fetchColumn();
		if($chkmob > 0){ 
		    		$error = "Mobile Number already Exists";
		 }
		else{
			$add_user = $db->prepare("INSERT INTO users(user_name,user_mail,user_mobile,user_code,user_pass,user_date)VALUES(:name, :mail, :mob, :code, :pass, :date)");
			$add_user->bindParam(':name',$name);
			$add_user->bindParam(':mail',$mail);
			$add_user->bindParam(':mob',$mob);
			$add_user->bindParam(':code',$code);
			$add_user->bindParam(':pass',$pass);
			$add_user->bindParam(':date',$date);
			$add_user->execute();
			if(isset($add_user)){
				$logincheck= $db->prepare("SELECT * FROM users WHERE user_mail=:mail AND user_mobile=:mob AND user_pass=:pass ORDER BY user_id DESC LIMIT 0,1");
				$logincheck->bindParam(':mail',$mail);
				$logincheck->bindParam(':mob',$mob);
				$logincheck->bindParam(':pass',$pass);
				$logincheck->execute();
				$dataall=$logincheck->fetch();	
					$user_id= $dataall['user_id'];
					$user_mail= $dataall['user_mail'];
					$user_password= $dataall['user_pass'];
					$_SESSION['usrid'] = $user_id;
					$_SESSION['usrmail'] = $user_mail;
					$_SESSION['usrpass'] = $user_password;
					
						echo "<script>location.assign('".$url."user/')</script>";
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
	<title>Contact us</title>
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
    <link href="http://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
	<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script>
	$(document).ready(function(){	
		$(document).on('submit', '#register-form', function(){
			var data = $(this).serialize();
			$.ajax({
			type : 'POST',
			url  : "<?php echo $url.'registerprocess.php'; ?>",
			data : data,
			success :  function(data)
					   {		
					   $("#register-form").fadeIn(500).show(function()
							  {	
								$(".result").fadeIn(500).show(function()
								{	
									$(".result").html(data);
								});   
							 });
						}
			});
			return false;
		});
	});
</script>
    
</head>
<body>
<div class="see-section wrapper">
	<?php include('header.php'); ?>
    
    
    <div class="overlaydv loginfixed singuppopdv">
 	<div class="overlaydv-in">
    	<div class="overlaydv-inner">
        	<div class="loginmid">
            <div id="form" class="result">
            <?php if(isset($error)){ echo $error; } ?>
             <form method="post">
                <h4>Sign Up</h4>
                <div class="fulldv loginwith">
                    <!--<div class="col-md-6 p0">
                        <a href="#" class="login_face"><i class="fa fa-facebook"></i> Sign Up with Facebook</a>
                    </div>-->
                    <div class="col-md-12 p0">
                        <a id="login-button" href="<?= 'https://accounts.google.com/o/oauth2/auth?scope=' . urlencode('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email') . '&redirect_uri=' . urlencode(CLIENT_REDIRECT_URL) . '&response_type=code&client_id=' . CLIENT_ID . '&access_type=online' ?>" class="login_google"><i class="fa fa-google-plus"></i>Login with Google</a>
                    </div>
                </div>
                <h4>Or</h4>
                <p>Full Name</p>
                <input type="text" name="name" required>
                <p>Mobile No.</p>
                <input type="text" name="mob" onKeyUp="onlydigit(this)" maxlength="10" required>
                <p>Email ID</p>
                <input type="email" name="mail" required>
                <p>Password</p>
                <input type="password" name="pass" required>
                <p class="accept"><input type="checkbox" name="#">I Accept <a href="#">T & C</a> and <a href="#">Privacy Policy</a></p>
                <input type="submit" name="submit" value="Sign Up">
                <!--<button type="submit" name="submit">Sign Up</button>-->
                <p>Already Have An Account? <a onClick="login()"href="<?php echo $url;?>login.php"  class="pointer">Login</a></p>
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

