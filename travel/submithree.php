<?php
error_reporting(0);
session_start();
include('function.php');
include('connection/index.php');



if($_POST){
	$ldid = $_POST['ldid'];
	$cab = $_POST['cab'];
	$speaks = $_POST['speaks'];
	$tour = $_POST['tour'];
	$ths_week = $_POST['ths_week'];
	$add_req = $_POST['add_req'];
	$update_lead1 = $db->prepare("UPDATE leads SET cab_facility=:cab, cab_language=:speaks, type_of_tour=:tour, this_week=:ths_week, additional_req=:add_req WHERE leads_id=:ldid"); 	
	$update_lead1->bindParam(':cab',$cab);
	$update_lead1->bindParam(':speaks',$speaks);
	$update_lead1->bindParam(':tour',$tour);
	$update_lead1->bindParam(':ths_week',$ths_week);
	$update_lead1->bindParam(':add_req',$add_req);
	$update_lead1->bindParam(':ldid',$ldid);
	$update_lead1->execute();
	if(isset($update_lead1)){
		$getmail = $db->prepare("SELECT email,mobile FROM leads WHERE leads_id=:ldid");
		$getmail->bindParam(':ldid',$ldid);
		$getmail->execute();
		$rw = $getmail->fetch();
		$lmail = $rw['email'];
		$lmob = $rw['mobile'];
		$pass = md5($lmob);
		$check_mail = $db->prepare("SELECT COUNT(user_id) FROM users WHERE user_mail=:lmail");
		$check_mail->bindParam(':lmail',$lmail);
		$check_mail->execute();
		$ckm = $check_mail->fetchColumn();
		if($ckm > 0){ }
		else{
			$add_user = $db->prepare("INSERT INTO users(user_mail,user_mobile,user_pass,user_date)VALUES(:lmail, :lmob, :pass, :date)");	
			$add_user->bindParam(':lmail',$lmail);
			$add_user->bindParam(':lmob',$lmob);
			$add_user->bindParam(':pass',$pass);
			$add_user->bindParam(':date',$date);
			$add_user->execute();
			if(isset($add_user)){
				$userid = $db->prepare("SELECT user_id FROM users WHERE user_mail=:lmail AND user_mobile=:lmob");
				$userid->bindParam(':lmail',$lmail);	
				$userid->bindParam(':lmob',$lmob);	
				$userid->execute();
				$u = $userid->fetch();
				$_SESSION['usrid'] = $u['user_id'];
				$_SESSION['usrmail'] = $lmail;
				$_SESSION['usrpass'] = $lmob;
			}
			
		}
		
		$to="$lmail";							 
		$from="kmanish1212@gmail.com";
		$subject='Login Detail of travel.com';
		$message = 'Username : '.$lmail.'
				<br/>Password : '. $lmob.' 
				<br/>E-Mail : '. $lmail.' 
				<br/>Mobile : '. $lmob .' 
				<br/> Date : '.$date; 
		$headers = "From: $from\n";
		$headers .= "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\n";
		if(mail($to, $subject, $message, $headers)){ 
		
		}
		else{
			
		}
		
	}
}

?>
<!DOCTYPE html>
<html lang="en-IN">
<head>
    <?php echo headdata(); ?>
 	
	
</head>
<body>   
        <button type="button" class="closeop" onClick="hidepop()"><a href="<?php echo $url; ?>">&times;</a></button>
        <div class="resultone">	 
        <form method="post" id="second-form2">
            <div class="fulldv planyour" style="margin:0;">
                <h4>Congratulations !</h4>
                <p></p>
            </div>
          </form>
        </div>
</body>
</html>

