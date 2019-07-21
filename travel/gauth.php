<?php
require_once('settings.php');
require_once('google-login-api.php');

// Google passes a parameter 'code' in the Redirect Url
if(isset($_GET['code'])) {
	try {
		$gapi = new GoogleLoginApi();
		
		// Get the access token 
		$data = $gapi->GetAccessToken(CLIENT_ID, CLIENT_REDIRECT_URL, CLIENT_SECRET, $_GET['code']);
		
		// Get user information
		$user_info = $gapi->GetUserProfileInfo($data['access_token']);
	}
	catch(Exception $e) {
		echo $e->getMessage();
		exit();
	}
}
?>
<head>
<style type="text/css">

#information-container {
	width: 400px;
	margin: 50px auto;
	padding: 20px;
	border: 1px solid #cccccc;
}

.information {
	margin: 0 0 30px 0;
}

.information label {
	display: inline-block;
	vertical-align: middle;
	width: 150px;
	font-weight: 700;
}

.information span {
	display: inline-block;
	vertical-align: middle;
}

.information img {
	display: inline-block;
	vertical-align: middle;
	width: 100px;
}

</style>
</head>

<body>
<?php
session_start();
include_once('connection/index.php');
	$gusrname =  $user_info['name'];
	$pssss = substr($gusrname,0,4);
	$gusrps =  md5($pssss);
	$gusrm = $user_info['email'];
	
    $check_umail = $db->prepare("SELECT COUNT(user_mail) FROM users WHERE user_mail=:gusrm");
	$check_umail->bindParam(':gusrm',$gusrm);
	$check_umail->execute();
	$chkgusr = $check_umail->fetchColumn();
	if($chkgusr > 0){
		$gusr_detail = $db->prepare("SELECT * FROM users WHERE user_mail=:gusrm");
		$gusr_detail->bindParam(':gusrm', $gusrm);
		$gusr_detail->execute();
		$rowg = $gusr_detail->fetch();
		$_SESSION['usrid'] = $rowg['user_id'];
		$_SESSION['usrmail'] = $rowg['user_mail'];
		$_SESSION['usrpass'] = $rowg['user_pass'];
			echo "<script>location.assign('".$url."user/')</script>";
	}
	else{
		$enter_guser = $db->prepare("INSERT INTO users(user_name,user_mail,user_pass,user_date)VALUES(:gusrname, :gusrm, :gusrps, :date)");
		$enter_guser->bindParam(':gusrname',$gusrname);
		$enter_guser->bindParam(':gusrm',$gusrm);
		$enter_guser->bindParam(':gusrps',$gusrps);
		$enter_guser->bindParam(':date',$date);
		$enter_guser->execute();
		if(isset($enter_guser)){
			$newgusr_detail = $db->prepare("SELECT * FROM users WHERE user_mail=:gusrm");
			$newgusr_detail->bindParam(':gusrm', $gusrm);
			$newgusr_detail->execute();
			$nwrowg = $newgusr_detail->fetch();
			$_SESSION['usrid'] = $nwrowg['user_id'];
			$_SESSION['usrmail'] = $nwrowg['user_mail'];
			$_SESSION['usrpass'] = $nwrowg['user_pass'];
				echo "<script>location.assign('".$url."user/')</script>";		
		}
	}
?>
</body>
</html>