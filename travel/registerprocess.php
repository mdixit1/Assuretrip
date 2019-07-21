<?php
session_start();
include('function.php');
include('connection/index.php');
if(isset($_SESSION['agid']) && isset($_SESSION['agmail']) && isset($_SESSION['agpass'])){
	
	echo "<script>location.assign('".$url."')</script>";
}
else{
	
if($_POST){
	$code = rand(000000,999999);
	$name = $_POST['name'];
	$mail = $_POST['mail'];
	$mob = $_POST['mob'];
	$pass = md5($_POST['pass']);
	$check_email = $db->prepare("SELECT COUNT(user_mail) FROM users WHERE user_mail=:mail");	
	$check_email->bindParam(':mail',$mail);
	$check_email->execute();
	$chkmail = $check_email->fetchColumn();
	if($chkmail > 0){ ?>
                <p>Email already Exists</p>
                <div id="form" class="result">
                 <form method="post" id="register-form">
                    <span class="closepop" onClick="closeallpop()">&times;</span>
                    <h4>Sign Up</h4>
                    <div class="fulldv loginwith">
                        <div class="col-md-6 p0">
                            <a href="#" class="login_face"><i class="fa fa-facebook"></i> Sign Up with Facebook</a>
                        </div>
                        <div class="col-md-6 p0">
                            <a href="#" class="login_google"><i class="fa fa-google-plus"></i> Sign Up with Google</a>
                        </div>
                    </div>
                    <h4>Or</h4>
                    <p>Full Name</p>
                    <input type="text" name="name">
                    <p>Mobile No.</p>
                    <input type="text" name="mob" onKeyUp="onlydigit(this)">
                    <p>Email ID</p>
                    <input type="email" name="mail">
                    <p>Password</p>
                    <input type="password" name="pass">
                    <p class="accept"><input type="checkbox" name="#">I Accept <a href="#">T & C</a> and <a href="#">Privacy Policy</a></p>
                    <button type="submit" name="submit">Sign Up</button>
                    <p>Already Have An Account? <a onClick="login()" class="pointer">Login</a></p>
                   </form> 
                  </div> 
    <?php }
	else{
		$check_mob = $db->prepare("SELECT COUNT(user_mobile) FROM users WHERE user_mobile=:mob");	
		$check_mob->bindParam(':mob',$mob);
		$check_mob->execute();
		$chkmob = $check_mob->fetchColumn();
		if($chkmob > 0){ ?>
		    		<p>Mobile Number already Exists</p>
					<div id="form" class="result">
                     <form method="post" id="register-form">
                        <span class="closepop" onClick="closeallpop()">&times;</span>
                        <h4>Sign Up</h4>
                        <div class="fulldv loginwith">
                            <div class="col-md-6 p0">
                                <a href="#" class="login_face"><i class="fa fa-facebook"></i> Sign Up with Facebook</a>
                            </div>
                            <div class="col-md-6 p0">
                                <a href="#" class="login_google"><i class="fa fa-google-plus"></i> Sign Up with Google</a>
                            </div>
                        </div>
                        <h4>Or</h4>
                        <p>Full Name</p>
                        <input type="text" name="name">
                        <p>Mobile No.</p>
                        <input type="text" name="mob" onKeyUp="onlydigit(this)">
                        <p>Email ID</p>
                        <input type="email" name="mail">
                        <p>Password</p>
                        <input type="password" name="pass">
                        <p class="accept"><input type="checkbox" name="#">I Accept <a href="#">T & C</a> and <a href="#">Privacy Policy</a></p>
                        <button type="submit" name="submit">Sign Up</button>
                        <p>Already Have An Account? <a onClick="login()" class="pointer">Login</a></p>
                       </form> 
                      </div>
		
		<?php }
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
}
?>       
