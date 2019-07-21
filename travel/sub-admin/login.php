<?php
session_start();
include('../function.php');
require "../connection/index.php"; 
if(isset($_SESSION['said']) && isset($_SESSION['samail']) && isset($_SESSION['sapass'])){ echo "<script>location.assign('index.php')</script>"; }
else { ?>

<?php 
	if(isset($_POST['submit'])){
		$loemail = $_POST['loginmail'];
		$lopassword = md5($_POST['loginpassword']);
			$check_login = $db->prepare("SELECT * FROM sub_admin WHERE subadmin_mail='{$loemail}' AND subadmin_password='{$lopassword}'");
			$check_login->execute();
			if($check_login){
				$data = $check_login->fetchAll();
				if(count($data)){
					foreach($data as $datall){
					$recid = $datall['subadmin_id'];
					$emp_mail = $datall['subadmin_mail'];
					$emp_password = $datall['subadmin_password'];
					$status = $datall['subadmin_status'];
					if($status=='1'){
						if($loemail == $emp_mail && $lopassword == $emp_password){
							$_SESSION['said'] = $recid;
							$_SESSION['samail'] = $emp_mail;
					   		$_SESSION['sapass'] = $emp_password;	
						
							echo "<script>location.assign('index.php')</script>";
						} 
					}
					else{
						$msg = "You are not active right now for the login";	
					}
					}
				}
				else { $msg ="Email and Password is incorrect"; }
			}
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link href="imag/logo.png" rel="icon"/>
<?php echo headdata(); ?>
<link href="css/see.css" type="text/css" rel="stylesheet"/>
<link href="css/responsive-manage.css" type="text/css" rel="stylesheet"/>
<link href="css/index.css" type="text/css" rel="stylesheet"/>
<link href="css/styleplus.css" type="text/css" rel="stylesheet"/>
<style>
.logindv.wid {
    width: 350px;
    overflow: hidden;}
.logindv {
    background: #FFF;
    border: solid #333;
        border-top-width: medium;
        border-right-width: medium;
        border-bottom-width: medium;
        border-left-width: medium;
    border-width: 5px 0;
    padding: 20px 25px;
    box-shadow: 5px 6px 5px 0 rgba(0,0,0,0.2);}
.logindv h4 {
    font-size: 24px;
    color: #0A6698;
    margin-bottom: 30px;}
.logindv p {font-size: 14px;
line-height: 24px;
letter-spacing: 0.5px;
color: #666;}
.logindv input, .logindv textarea {
    width: 100%;
    height: 35px;
    margin-bottom: 15px; padding:0 10px; }
.red_bton {
    background: #0A6698;
    border: 1px solid #0A6698;
    display: inline-block;
    padding: 7px 18px;
    color: #FFF;
    font-size: 15px;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    font-family: 'Roboto', sans-serif;}
</style>

<title>Log In</title>
</head>
<body>


<div class="overlaydv-in" style="background:url(images/backmg.jpg); background-size:cover;">
    <div class="overlaydv-inner">
        <div class="display-center">
            <div class="fulldv logindv wid">
                <h4>Sign-In</h4>
                <div class="confac" style="color:rgba(255,0,4,1.00);"><?php if(isset($msg)) {echo $msg;} ?></div>
                 <form method="post">
                        <p>UserName</p>
                        <input type="text" name="loginmail" placeholder="Enter Username" required/>
                        <p>Password</p>
                        <input type="password" name="loginpassword" placeholder="Enter Password" required/>
                        <input type="submit" name="submit" value="Submit" class="red_bton see-trans5s" />
                 </form>
                 
            </div>
        </div>
    </div>
</div>

   
</body>
</html>
<?php } ?>
