<?php
//error_reporting(0);
session_start();
include('function.php'); 
include('connection/index.php');

if(isset($_POST['fsubmit'])){
	$uremail = $_POST['femail'];
	
	$count_ursr = $db->prepare("SELECT COUNT(user_mail) FROM users WHERE user_mail=:uremail");
	$count_ursr->bindParam(':uremail',$uremail);
	$count_ursr->execute();
	$cuntus = $count_ursr->fetchColumn();
	
	$count_agent = $db->prepare("SELECT COUNT(agent_mail) FROM agent_registration WHERE agent_mail=:uremail ");
	$count_agent->bindParam(':uremail',$uremail);
	$count_agent->execute();
	$cuntag = $count_agent->fetchColumn();
	
	
	if($cuntag > 0){
		$restermail = $db->prepare("SELECT agent_mail,agent_name FROM agent_registration WHERE agent_mail=:uremail");
		$restermail->bindParam(':uremail',$uremail);
		$restermail->execute();
		$showm = $restermail->fetch();
		$mailid = $showm['agent_mail'];
		$usrname = $showm['agent_name'];
			if($uremail == $mailid){
					$code = uniqid();
					$codeupdate = $db->prepare("UPDATE agent_registration SET agpass_code=:code WHERE agent_mail=:mailid");
					$codeupdate->bindParam(':code',$code);
					$codeupdate->bindParam(':mailid',$mailid);
					$codeupdate->execute();
					$to="$mailid";							 
					    $full_name="Assure Trips";					 
						$email_from="srtechweb@gmail.com";
						$from = $full_name.'<'.$email_from.'>';	
						$subject='Forget Password - Listing';
						$message ='<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><style type="text/css"> @import url("https://fonts.googleapis.com/css?family=Roboto"); @import url("https://fonts.googleapis.com/css?family=Poiret+One|Satisfy");* { margin:0; padding:0; -webkit-box-sizing:border-box; -moz-box-sizing:border-box; box-sizing:border-box;} @media (max-width: 480px) {  .width , .fullwidthdv { width:100% !important; display:inline-block;} .verify { text-align:left !important; color:#000 !important;}	}</style></head><body style="background:#e9e9e9;  margin:0; padding:0; font-family: Roboto, sans-serif;"><div style="width:100%; float:left;"> <div class="width" style="width:600px; margin:auto; border:1px solid #ccc;"><table cellpadding="0" cellspacing="0" style="width:100%; background:#FFF;"> <tr> <td> <div style="width:100%; float:left;"><table cellpadding="0" cellspacing="0" style="width:100%; text-align:left; padding:10px 20px; background:#E1E1E1;"><tr><td class="fullwidthdv"><a href="http://shreerampg.com/travel"><span style="float:left; width:185px; padding:0;"><img src="http://shreerampg.com/travel/images/logo.png" alt="icon" style="width:100%; float:left;"/></span></a></td><td class="fullwidthdv"><p class="verify" style=" line-height:50px; font-size:18px; float:right; font-weight:300; margin-left:10px;">Forget Password</p> </td></tr></table></div><div style="width:100%; float:left;"> <table cellpadding="0" cellspacing="0" style="width:100%; padding:20px;"><tr><td><h4 style="font-size:22px; font-weight:300; letter-spacing:0.5px; margin-bottom:5px;">Dear '.$usrname.'</h4><p style="font-size:16px; line-height:28px; letter-spacing:0.5px; text-transform:capitalize;">Click verify now button to reset password for your Travel account</p></td></tr></table></div><div style="width:100%; float:left;"><table cellpadding="0" cellspacing="0" style="width:100%; padding:20px; background:#fcede0; padding-bottom:0;"><tr><td><p style="font-size:16px; line-height:28px; letter-spacing:0.5px;  font-weight:bold; margin-bottom:15px;">Email: '.$mailid.'</p><a href="http://http://shreerampg.com/travel/recovery-password.php?code='.$code.'&mail='.$mailid.'" style="text-decoration:none; padding:15px 75px; text-transform:uppercase; display:inline-block; background:#299ECC; color:#FFF; border-radius:3px;">verify now</a></td></tr></table></div><div style="width:100%; float:left;"><table cellpadding="0" cellspacing="0" style="width:100%; padding:20px; background:#fcede0;"><tr><td><a href="http://http://shreerampg.com/travel/recovery-password.php?code='.$code.'&mail='.$mailid.'" style="text-decoration:none; font-size:14px; color:#3C76FD; display:inline-block; margin-bottom:5px; word-break:break-all;">http://http://shreerampg.com/travel/recovery-password.php?code='.$code.'&mail='.$mailid.'</a><p style="font-size:12px; color:#666;">(If the above link does not work, just copy and paste the URL below in your browser address bar.)</p></td></tr></table></div><div style="width:100%; float:left;"><table cellpadding="0" cellspacing="0" style="width:100%; padding:20px; padding-bottom:0;"><tr><td><p style="font-size:16px; line-height:28px; letter-spacing:0.5px; text-transform:capitalize;">For any queries or assistance, please contact us at http://shreerampg.com/travel</p><p style="font-size:16px; line-height:28px; letter-spacing:0.5px; text-transform:capitalize;">We look forward to helping you build a great career!</p><p style="font-size:16px; line-height:28px; letter-spacing:0.5px; text-transform:capitalize;">Best Regards,</p><p style="font-size:16px; line-height:28px; letter-spacing:0.5px; text-transform:capitalize;">Listing Team</p><a href="http://http://shreerampg.com/travel/" style="font-size:16px; line-height:28px; letter-spacing:0.5px;">http://www.shreerampg.com/travel</a></td></tr></table></div><div style="width:100%; float:left;"><table cellpadding="0" cellspacing="0" style="width:100%; padding:20px;"><tr><td><p style="font-size:14px; color:#666;">Please add <a href="mailto:srtechweb@gmail.com" style="color:#3C76FD; text-decoration:none;">srtechweb@gmail.com</a> to your Address Book or Safe List to prevent future Travel Updates from being classified as Junk/Bulk Mail </p></td></tr></table></div><div style="width:100%; float:left;"><table cellpadding="0" cellspacing="0" style="width:100%; padding:20px; background:#e1e1e1;"><tr><td><p style="font-size:12px; color:#666; line-height:18px;"><span style="color:#000;">Security Alert </span>- In case you receive a suspicious mail from anyone claiming to be a client of searchkaro24, asking for your personal information or some money by pretending to offer you a job please do not respond to such mails and bring it to the immediate notice of www.shreerampg.com/travel by writing to us at <a href="mailto:srtechweb@gmail.com" style="color:#3C76FD; text-decoration:none;">srtechweb@gmail.com</a>. Please note that such offers / emails are a violation of our Terms and Conditions, and www.shreerampg.com/travel/does not endorse such communication with candidates.</p></td></tr></table></div></td></tr></table></div></div></body></html>';
						$headers='From: ' . $from . "\r\n";
						$headers.="MIME-Version: 1.0\n";
						$headers.="Content-type: text/html; charset=iso-8859-1\n";
						if(mail($to, $subject, $message, $headers)){
					
							$mess="<p style='color:#FC0105;'>New password link has been sent to your email address, check your email</p>";
					}
					else { $mess = "<p style='color:#FC0105;'>Some Server Error Try Again</p>";  }
				 }
			else{ $mess = "<p style='color:#FC0105;'>Mail Id Is Incorrect</p>";  }
		}
	elseif($cuntus > 0){
		$restermaill = $db->prepare("SELECT user_mail,user_name FROM users WHERE user_mail=:uremail");
		$restermaill->bindParam(':uremail',$uremail);
		$restermaill->execute();
		$showmm = $restermaill->fetch();
		$mailid = $showmm['user_mail'];
		$usrname = $showmm['user_name'];
			if($uremail == $mailid){
					$code = uniqid();
					$codeupdatee = $db->prepare("UPDATE users SET upass_code=:code WHERE user_mail=:mailid");
					$codeupdatee->bindParam(':code',$code);
					$codeupdatee->bindParam(':mailid',$mailid);
					$codeupdatee->execute();
					$to="$mailid";							 
					    $full_name="Assure Trips";					 
						$email_from="bwdshankar@gmail.com";
						$from = $full_name.'<'.$email_from.'>';	
						$subject='Forget Password - Travel';
						$message ='<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><style type="text/css"> @import url("https://fonts.googleapis.com/css?family=Roboto"); @import url("https://fonts.googleapis.com/css?family=Poiret+One|Satisfy");* { margin:0; padding:0; -webkit-box-sizing:border-box; -moz-box-sizing:border-box; box-sizing:border-box;} @media (max-width: 480px) {  .width , .fullwidthdv { width:100% !important; display:inline-block;} .verify { text-align:left !important; color:#000 !important;}	}</style></head><body style="background:#e9e9e9;  margin:0; padding:0; font-family: Roboto, sans-serif;"><div style="width:100%; float:left;"> <div class="width" style="width:600px; margin:auto; border:1px solid #ccc;"><table cellpadding="0" cellspacing="0" style="width:100%; background:#FFF;"> <tr> <td> <div style="width:100%; float:left;"><table cellpadding="0" cellspacing="0" style="width:100%; text-align:left; padding:10px 20px; background:#E1E1E1;"><tr><td class="fullwidthdv"><a href="http://localhost/travel"><span style="float:left; width:185px; padding:0;"><img src="http://localhost/travel/images/logo.png" alt="icon" style="width:100%; float:left;"/></span></a></td><td class="fullwidthdv"><p class="verify" style=" line-height:50px; font-size:18px; float:right; font-weight:300; margin-left:10px;">Forget Password</p> </td></tr></table></div><div style="width:100%; float:left;"> <table cellpadding="0" cellspacing="0" style="width:100%; padding:20px;"><tr><td><h4 style="font-size:22px; font-weight:300; letter-spacing:0.5px; margin-bottom:5px;">Dear '.$usrname.'</h4><p style="font-size:16px; line-height:28px; letter-spacing:0.5px; text-transform:capitalize;">Click verify now button to reset password for your Travel account</p></td></tr></table></div><div style="width:100%; float:left;"><table cellpadding="0" cellspacing="0" style="width:100%; padding:20px; background:#fcede0; padding-bottom:0;"><tr><td><p style="font-size:16px; line-height:28px; letter-spacing:0.5px;  font-weight:bold; margin-bottom:15px;">Email: '.$mailid.'</p><a href="http://shreerampg.com/travel/change-password.php?code='.$code.'&mail='.$mailid.'" style="text-decoration:none; padding:15px 75px; text-transform:uppercase; display:inline-block; background:#299ECC; color:#FFF; border-radius:3px;">verify now</a></td></tr></table></div><div style="width:100%; float:left;"><table cellpadding="0" cellspacing="0" style="width:100%; padding:20px; background:#fcede0;"><tr><td><a href="http://shreerampg.com/travel/change-password.php?code='.$code.'&mail='.$mailid.'" style="text-decoration:none; font-size:14px; color:#3C76FD; display:inline-block; margin-bottom:5px; word-break:break-all;">http://shreerampg.com/travel/change-password.php?code='.$code.'&mail='.$mailid.'</a><p style="font-size:12px; color:#666;">(If the above link does not work, just copy and paste the URL below in your browser address bar.)</p></td></tr></table></div><div style="width:100%; float:left;"><table cellpadding="0" cellspacing="0" style="width:100%; padding:20px; padding-bottom:0;"><tr><td><p style="font-size:16px; line-height:28px; letter-spacing:0.5px; text-transform:capitalize;">For any queries or assistance, please contact us at localhost/travel</p><p style="font-size:16px; line-height:28px; letter-spacing:0.5px; text-transform:capitalize;">We look forward to helping you build a great career!</p><p style="font-size:16px; line-height:28px; letter-spacing:0.5px; text-transform:capitalize;">Best Regards,</p><p style="font-size:16px; line-height:28px; letter-spacing:0.5px; text-transform:capitalize;">Travel Team</p><a href="http://www.searchkaro24.com/" style="font-size:16px; line-height:28px; letter-spacing:0.5px;">http://localhost/travel</a></td></tr></table></div><div style="width:100%; float:left;"><table cellpadding="0" cellspacing="0" style="width:100%; padding:20px;"><tr><td><p style="font-size:14px; color:#666;">Please add <a href="mailto:searchkaro24@gmail.com" style="color:#3C76FD; text-decoration:none;">searchkaro24@gmail.com</a> to your Address Book or Safe List to prevent future Travel Updates from being classified as Junk/Bulk Mail </p></td></tr></table></div><div style="width:100%; float:left;"><table cellpadding="0" cellspacing="0" style="width:100%; padding:20px; background:#e1e1e1;"><tr><td><p style="font-size:12px; color:#666; line-height:18px;"><span style="color:#000;">Security Alert </span>- In case you receive a suspicious mail from anyone claiming to be a client of searchkaro24, asking for your personal information or some money by pretending to offer you a job please do not respond to such mails and bring it to the immediate notice of localhost/travel by writing to us at <a href="mailto:searchkaro24@gmail.com" style="color:#3C76FD; text-decoration:none;">searchkaro24@gmail.com</a>. Please note that such offers / emails are a violation of our Terms and Conditions, and www.searchkaro24.com/ does not endorse such communication with candidates.</p></td></tr></table></div></td></tr></table></div></div></body></html>';
						$headers='From: ' . $from . "\r\n";
						$headers.="MIME-Version: 1.0\n";
						$headers.="Content-type: text/html; charset=iso-8859-1\n";
						if(mail($to, $subject, $message, $headers)){
					
							$mess="<p style='color:#FC0105;'>New password link has been sent to your email address, check your email</p>";
					}
					else { $mess = "<p style='color:#FC0105;'>Some Server Error Try Again</p>";  }
				 }
			else{ $mess = "<p style='color:#FC0105;'>Mail Id Is Incorrect</p>";  }
		}
	else{  $mess = "<p style='color:#FC0105;'>We did not find an account registered with this email address</a></p>";  } 
	
}
?>
<!DOCTYPE html>
<html lang="en-IN">
<head>
    <?php echo headdata(); ?>
    <link rel="canonical" href=""/>
    <link rel='shortlink' href=""/>
	<title>Forget Password</title>
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
</head>
<body>
<div class="see-section wrapper">
	<?php include('header.php'); ?>
    
    
    <div class="overlaydv loginfixed loginpopdv">
 	<div class="overlaydv-in">
    	<div class="overlaydv-inner">
        	<div class="loginmid">
            <div id="form" class="">
            <p><?php if(isset($mess)){ echo $mess; } ?></p>
             <form method="post">
                <h4>Forget Password</h4>
                <p>Email ID</p>
                <input type="email" name="femail" required/>
                <input type="submit" name="fsubmit" value="Submit">
                <p style="display:inline-block;">Forgot Password?</p>
                <p style="float:right;">New Here?<a onClick="sighup()"  href="<?php echo $url;?>signup.php"  class="pointer"> Sign Up</a></p>
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

