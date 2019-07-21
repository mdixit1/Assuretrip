<?php
session_start();
include('function.php');
include('connection/index.php');
if(isset($_SESSION['agid']) && isset($_SESSION['agmail']) && isset($_SESSION['agpass'])){
	
	echo "<script>location.assign('".$url."')</script>";
}
else{
	
if($_POST){
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
	else { ?> 
			<p>Incorrect Username Or Password</p>
           
            <div id="form" class="resultone">
             <form method="post" id="login-form">
            	<span class="closepop" onClick="closeallpop()">&times;</span>
                <h4>Login</h4>
                <div class="fulldv loginwith">
                    <div class="col-md-6 p0">
                        <a href="#" class="login_face"><i class="fa fa-facebook"></i> Login with Facebook</a>
                    </div>
                    <div class="col-md-6 p0">
                        <a href="#" class="login_google"><i class="fa fa-google-plus"></i> Login with Google</a>
                    </div>
                </div>
                <h4>Or</h4>
                <p>Email ID</p>
                <input type="email" name="logmail" required/>
                <p>Password</p>
                <input type="password" name="logpassword" required/>
                <button type="submit" name="submit">Login</button>
                <p style="display:inline-block;">Forgot Password?</p>
                <p style="float:right;">New Here?<a onClick="sighup()" class="pointer"> Sign Up</a></p>
              </form>  
             </div> 
            
    <?php } 
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
	else { ?> 
			<p>Incorrect Username Or Password</p>
           
            <div id="form" class="resultone">
             <form method="post" id="login-form">
            	<span class="closepop" onClick="closeallpop()">&times;</span>
                <h4>Login</h4>
                <div class="fulldv loginwith">
                    <!--<div class="col-md-6 p0">
                        <a href="#" class="login_face"><i class="fa fa-facebook"></i> Sign Up with Facebook</a>
                    </div>-->
                    <div class="col-md-6 p0">
                        <a id="login-button" href="<?= 'https://accounts.google.com/o/oauth2/auth?scope=' . urlencode('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email') . '&redirect_uri=' . urlencode(CLIENT_REDIRECT_URL) . '&response_type=code&client_id=' . CLIENT_ID . '&access_type=online' ?>" class="login_google"><i class="fa fa-google-plus"></i>Login with Google</a>
                    </div>
                </div>
                <h4>Or</h4>
                <p>Email ID</p>
                <input type="email" name="logmail" required/>
                <p>Password</p>
                <input type="password" name="logpassword" required/>
                <button type="submit" name="submit">Login</button>
                <p style="display:inline-block;">Forgot Password?</p>
                <p style="float:right;">New Here?<a onClick="sighup()" class="pointer"> Sign Up</a></p>
              </form>  
             </div> 
            
    <?php } 	
	
}
} 
}
       