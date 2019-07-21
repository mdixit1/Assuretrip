<?php
session_start();
include('../function.php');
require "../connection/index.php"; 
if(isset($_SESSION['aid'], $_SESSION['amail'])){ echo "<script>location.assign('index.php')</script>"; }
else { ?>

<?php 
	if(isset($_POST['submit'])){
		$loemail = $_POST['loginmail'];
		$lopassword = md5($_POST['loginpassword']);
			$check_login = $db->query("SELECT * from plusadmin where ademail='{$loemail}' and adpassword='{$lopassword}'");
			if($check_login){
				$data = $check_login->fetchAll();
				if(count($data)){
					foreach($data as $datall){
					$recid = $datall['adminid'];
					$emp_mail = $datall['ademail'];
					$emp_password = $datall['adpassword'];
					if($loemail == $emp_mail && $lopassword == $emp_password){
							$_SESSION['aid'] = $recid;
							$_SESSION['amail'] = $emp_mail;
					   		$_SESSION['apass'] = $emp_password;	
						
							echo "<script>location.assign('index.php')</script>";
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
                 <form method="post">
                        <p>Email</p>
                        <input type="email" name="loginmail" placeholder="Enter Email" required/>
                        <p>Password</p>
                        <input type="password" name="loginpassword" placeholder="Enter Password" required/>
                        <input type="submit" name="submit" value="Submit" class="red_bton see-trans5s" />
                 </form>
                 <div class="confac"><?php if(isset($msg)) {echo $msg;} ?></div>
            </div>
        </div>
    </div>
</div>

   
</body>
</html>
<?php } ?>
