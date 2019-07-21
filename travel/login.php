<?php
//error_reporting(0);
session_start();
include('function.php'); 
include('connection/index.php');
require_once('settings.php');

if(isset($_POST['submit'])){
	$loemail = $_POST['logmail'];
	$lopass = md5($_POST['logpassword']);
	
	$count_ursr = $db->prepare("SELECT COUNT(user_mail) FROM users WHERE user_mail=:loemail");
	$count_ursr->bindParam(':loemail',$loemail);
	//$count_ursr->bindParam(':lopass',$lopass);
	$count_ursr->execute();
	$cuntus = $count_ursr->fetchColumn();
	
	$count_agent = $db->prepare("SELECT COUNT(agent_mail) FROM agent_registration WHERE agent_mail=:loemail ");
	$count_agent->bindParam(':loemail',$loemail);
	//$count_agent->bindParam(':lopass',$lopass);
	$count_agent->execute();
	$cuntag = $count_agent->fetchColumn();
	
	
if($cuntag > 0){	
	
	$logincheck= $db->prepare("SELECT * FROM agent_registration WHERE agent_mail=:loemail AND agent_pass=:lopass LIMIT 0,1");
	$logincheck->bindParam(':loemail',$loemail);
	$logincheck->bindParam(':lopass',$lopass);
	$logincheck->execute();
	$data=$logincheck->fetchAll();	
	if(count($data)){
		foreach($data as $dataall){
			$user_id= $dataall['agent_id'];
			$user_mail= $dataall['agent_mail'];
			$user_password= $dataall['agent_pass'];
			$_SESSION['agid'] = $user_id;
			$_SESSION['agmail'] = $user_mail;
			$_SESSION['agpass'] = $user_password;
			
					echo "<script>location.assign('".$url."agent/')</script>";
		 }
	}	
	else { 
		$error = "Incorrect Username Or Password";
	 } 
}
elseif($cuntus > 0){
	$logincheck= $db->prepare("SELECT * FROM users WHERE user_mail=:loemail AND user_pass=:lopass LIMIT 0,1");
	$logincheck->bindParam(':loemail',$loemail);
	$logincheck->bindParam(':lopass',$lopass);
	$logincheck->execute();
	$data=$logincheck->fetchAll();	
	if(count($data)){
		foreach($data as $dataall){
			$user_id= $dataall['user_id'];
			$user_mail= $dataall['user_mail'];
			$user_password= $dataall['user_pass'];
			$_SESSION['usrid'] = $user_id;
			$_SESSION['usrmail'] = $user_mail;
			$_SESSION['usrpass'] = $user_password;
			
					echo "<script>location.assign('".$url."user/')</script>";
		 }
	}	
	else {  
			$error = "Incorrect Username Or Password";
            
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
    <link href="http://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
	<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script>
	$(document).ready(function(){	
		$(document).on('submit', '#login-form', function(){
			var data = $(this).serialize();
			$.ajax({
			type : 'POST',
			url  : "<?php echo $url.'loginprocess.php'; ?>",
			data : data,
			success :  function(data)
					   {		
					   $("#login-form").fadeIn(500).show(function()
							  {	
								$(".resultone").fadeIn(500).show(function()
								{	
									$(".resultone").html(data);
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
    
    
    <div class="overlaydv loginfixed loginpopdv">
 	<div class="overlaydv-in">
    	<div class="overlaydv-inner">
        	<div class="loginmid">
            <div id="form" class="resultone">
            <p><?php if(isset($error)){ echo $error; } ?></p>
             <form method="post">
                <h4>Login</h4>
                <div class="fulldv loginwith">
                    <!--<div class="col-md-6 p0">
                        <a href="#" class="login_face"><i class="fa fa-facebook"></i> Login with Facebook</a>
                    </div>-->
                    <div class="col-md-12 p0">
                        <a id="login-button" href="<?= 'https://accounts.google.com/o/oauth2/auth?scope=' . urlencode('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email') . '&redirect_uri=' . urlencode(CLIENT_REDIRECT_URL) . '&response_type=code&client_id=' . CLIENT_ID . '&access_type=online' ?>" class="login_google"><i class="fa fa-google-plus"></i>Login with Google</a>
                    </div>
                </div>
                <h4>Or</h4>
                <p>Email ID</p>
                <input type="email" name="logmail" required/>
                <p>Password</p>
                <input type="password" name="logpassword" required/>
                <!--<button type="submit" name="submit">Login</button>-->
                <input type="submit" name="submit" value="Login">
                <a href="<?php echo $url; ?>forget-password"><p style="display:inline-block;">Forgot Password?</p></a>
                <p style="float:right;">New Here?<a onClick="sighup()" href="<?php echo $url;?>signup.php" class="pointer"> Sign Up</a></p>
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

