<?php
session_start();
include('../function.php');
include('../connection/index.php');
if(isset($_SESSION['samail']) && isset($_SESSION['said']) && isset($_SESSION['sapass'])){
	$recaid = $_SESSION['said'];
	$recmail = $_SESSION['samail'];
	$recpass = $_SESSION['sapass'];	
	$userdetail = $db->prepare("SELECT * FROM sub_admin WHERE subadmin_id = :recaid AND subadmin_mail = :recmail AND subadmin_password = :recpass AND subadmin_status='1'");
	$userdetail->bindParam(':recaid',$recaid);
	$userdetail->bindParam(':recmail',$recmail);
	$userdetail->bindParam(':recpass',$recpass);
	$userdetail->execute();
	$userd = $userdetail->fetchAll();
	if(count($userd)){
		foreach($userd as $usr){
			$recname = $usr['subadmin_name'];
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
		  	<h3>
			<?php
            if(isset($_POST['editpass'])){
              $oldpass = md5($_POST['olpass']);
              $pass = ($_POST['nepass']);
			  $newpass = md5($_POST['nepass']);
              $repass = md5($_POST['retpass']);
              $checkpass = $db->query("SELECT manage_password FROM manage");
              $search = $checkpass->fetch();
              $opass = $search['manage_password'];
              if($opass!=$oldpass){
                 echo "Old Password Not Match";  
              }
              elseif($repass != $newpass){ echo "Retype password not match with New password"; }
              else{
                      $changedata = $db->prepare("UPDATE sub_admin SET subadmin_password=:newpass, pass=:pass WHERE subadmin_password=:oldpass AND subadmin_id=:recaid");
                      $changedata->bindParam(':newpass',$newpass);
                      $changedata->bindParam(':oldpass',$oldpass);
                      $changedata->bindParam(':recaid',$recaid);
                      $changedata->bindParam(':pass',$pass);
                      $changedata->execute();
                      if(isset($changedata)){ 
                        $_SESSION['sapass'] = $newpass;
                        echo "Password Succefully Updated"; }
                      else { echo "Not Updated"; }
              }
            }
          ?>
            </h3>
          
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
<?php } } } else{ echo "<script>location.assign('logout.php')</script>"; } ?>
