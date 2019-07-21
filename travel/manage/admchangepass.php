<?php
session_start();
include('../function.php');
include('../connection/index.php');
if(isset($_SESSION['amail']) && isset($_SESSION['aid']) && isset($_SESSION['apass'])){
	$recaid = $_SESSION['aid'];
	$recmail = $_SESSION['amail'];
	$recpass = $_SESSION['apass'];	
	$userdetail = $db->prepare("SELECT * FROM plusadmin WHERE adminid = :recaid AND ademail = :recmail AND adpassword = :recpass");
	$userdetail->bindParam(':recaid',$recaid);
	$userdetail->bindParam(':recmail',$recmail);
	$userdetail->bindParam(':recpass',$recpass);
	$userdetail->execute();
	$userd = $userdetail->fetchAll();
	if(count($userd)){
		foreach($userd as $usr){
			$recname = $usr['adname'];
		if(isset($_POST['editpass'])){
              $oldpass = md5($_POST['olpass']);
              $newpass = md5($_POST['nepass']);
              $repass = md5($_POST['retpass']);
              $ndate = date('Y-m-d');
              $checkpass = $db->prepare("SELECT adpassword FROM plusadmin WHERE adminid=:recaid");
			  $checkpass->bindParam(':recaid',$recaid);
			  $checkpass->execute();
              $search = $checkpass->fetch();
              $opass = $search['adpassword'];
              if($opass!=$oldpass){
                 $error = "Old Password Not Match";  
              }
              elseif($repass != $newpass){ echo "Retype password not match with New password"; }
              else{
                      $changedata = $db->prepare("UPDATE plusadmin SET adpassword=:newpass, resetpassword_date=:ndate WHERE adpassword=:oldpass AND adminid=:recaid");
                      $changedata->bindParam(':newpass',$newpass);
                      $changedata->bindParam(':oldpass',$oldpass);
                      $changedata->bindParam(':recaid',$recaid);
                      $changedata->bindParam(':ndate',$ndate);
                      $changedata->execute();
                      if(isset($changedata)){ 
                        $_SESSION['apass'] = $newpass;
                        $error = "Password Succefully Updated"; 
					  }
                      else { $error = "Not Updated"; }
              }
            }
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Change Password</title>
<?php echo headdata(); ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="<?php echo $url; ?>css/font-awesome.min.css" type="text/css" rel="stylesheet"/>
<link href="<?php echo $url; ?>/css/bootstrap.min.css" type="text/css" rel="stylesheet"/>
<link href="css/styleplus.css" type="text/css" rel="stylesheet"/>
<link href="css/responsive-manage.css" type="text/css" rel="stylesheet"/>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="<?php echo $url; ?>js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/admin.js"></script>
<script src="js/index.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="http://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
<script>
(function($,W,D)
	{ var JQUERY4U = {};
    JQUERY4U.UTIL = {
        setupFormValidation: function() { $("#register-form").validate({
                rules: {
					olpass : { required: true  },
                    nepass: { required: true, minlength: 8 },
					retpass: {  required: true, equalTo: "#nepass" }
                },
                messages: {
					olpass : { 
						required: "Please Enter Your Old Password"
					}, 
                    nepass: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 8 characters long"
                    },
					retpass: {
                        required: "Please provide a Re - password",
                        equalTo: "Password Not Match"
                    }
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
<?php include('aheader.php'); ?>
<div class="slidebody see-trans5s">
    <?php include('topheader.php'); ?>
    <div class="fulldv adminbody">	  
          <br><br>
          <div class="col-md-5 center-block changepass">
          <p><?php if(isset($error)){ echo $error; } ?></p>
		  	  <form method="post" id="register-form">
                <h4>Change Password</h4>
                <p>Old Password</p>
                <input type="password" name="olpass" required>
                <p>New Password</p>
                <input type="password" name="nepass" id="nepass" required>
                <p>Retype Password</p>
                <input type="password" name="retpass" required>
                <input type="submit" name="editpass" value="Change Password" class="see-trans5s">
              </form>
          </div>
    </div>
</div>
</body>
</html>
<?php  }
	}
	else{ echo "<script>location.assign('logout.php')</script>"; }
}
else{ echo "<script>location.assign('logout.php')</script>"; }
?>

