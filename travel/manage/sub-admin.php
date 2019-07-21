<?php
error_reporting(0);
session_start();
include('../connection/index.php');
include('../function.php'); 
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
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Sub Admin</title>
<?php echo headdata(); ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="<?php echo $url; ?>css/font-awesome.min.css" type="text/css" rel="stylesheet"/>
<link href="<?php echo $url; ?>css/bootstrap.min.css" type="text/css" rel="stylesheet"/>
<link href="css/styleplus.css" type="text/css" rel="stylesheet"/>
<link href="css/responsive-manage.css" type="text/css" rel="stylesheet"/>
<script src="<?php echo $url; ?>js/jquery-3.2.1.min.js" type="text/javascript"> </script>
<script src="<?php echo $url; ?>js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/index.js"></script>
<script>
$(function(){
		$("a.hidelink").each(function (index, element){
			var href = $(this).attr("href");
			$(this).attr("hiddenhref", href);
			$(this).removeAttr("href");
		});
		$("a.hidelink").click(function(){
			url = $(this).attr("hiddenhref");
			window.open(url, '_top');
		})
	});



function ckdel(){
	
	return confirm('Are you sure');	
	
}
</script>
</head>
<body>
<?php include('aheader.php'); ?>

<div class="slidebody see-trans5s">
    <?php include('topheader.php'); ?>
    <div class="fulldv adminbody">
    <div class="fulldv subcate_sect">
	
      <div class="fulldv category-maindv">
        <div class="see-12 topbox">
            <input type="button" value="Create Sub-Admin" class="btn-blue" onClick="addactivity()">
        </div>
    	<?php
			if(isset($_POST['addactivity'])){
				$code = uniqid();
				$actname = stripslashes($_POST['sbname']);
				$sbmail = $_POST['usrname'];
				$spass = md5($_POST['sbpss']);
				$sbpass = $_POST['sbpss'];
				$checkname = $db->prepare("SELECT COUNT(subadmin_mail) FROM sub_admin WHERE subadmin_mail=:sbmail");
				$checkname->bindParam(':sbmail' , $sbmail);
				$checkname->execute();
				if($checkname->fetchColumn() > 0 ){
						echo "Username Already exists";
				}
				else{
					$checkpss = $db->prepare("SELECT COUNT(subadmin_password) FROM sub_admin WHERE subadmin_password=:sbpass");
					$checkpss->bindParam(':sbpass' , $sbpass);
					$checkpss->execute();
					if($checkpss->fetchColumn() > 0 ){
							echo "Password Already exists";
					}
					else{
						$add_activity = $db->prepare("INSERT INTO sub_admin(subadm_uniqid,subadmin_name,subadmin_mail,subadmin_password,pass,subadmin_date)VALUES(:code, :actname, :sbmail, :spass, :sbpass, :date)");	
						$add_activity->bindParam(':code',$code);
						$add_activity->bindParam(':actname',$actname);
						$add_activity->bindParam(':sbmail',$sbmail);
						$add_activity->bindParam(':spass',$spass);
						$add_activity->bindParam(':sbpass',$sbpass);
						$add_activity->bindParam(':date',$date);
						$add_activity->execute();
						if(isset($add_activity)){
							
						}
					}
				}
			}
		?>	
        
        <div class="overlaydv activity_pop" id="activit">
        	<div class="overlaydv-in">
            	<div class="overlaydv-inner">
                	<div class="activtiyadd">
                    	<div class="closepopdv" onClick="closepop()"> &times; </div>
                        <h4>Sub-Admin</h4>
                        <form method="post" enctype="multipart/form-data">
                            <p>Name</p>
                            <input type="text" name="sbname" required/>
                            <p>Username</p>
                            <input type="email" name="usrname" required/>
                            <p>Password</p>
                            <input type="password" name="sbpss" required>
                            <input type="submit" value="Submit" name="addactivity">
                        </form>
                        <div class="clearfix"></div>
                    </div>	
                </div>
            </div>
        </div>
        
        
       <?php 
	   	if(isset($_GET['edit'])){ 
	   			$chid = $_GET['edit'];
				$foundimage = $db->prepare("SELECT * FROM sub_admin WHERE subadmin_id=:chid");
				$foundimage->bindParam(':chid',$chid);
				$foundimage->execute();
				$find = $foundimage->fetch();
				//$fimage = $find['activity_image'];
				
			  if(isset($_POST['changactv'])){
					$actname = $_POST['nsbname'];
					$sbmail = $_POST['nusrname'];
					$spass = md5($_POST['nsbpss']);
					$sbpass = $_POST['nsbpss'];
					$checkname = $db->prepare("SELECT COUNT(subadmin_mail) FROM sub_admin WHERE subadmin_mail=:sbmail");
					$checkname->bindParam(':sbmail' , $sbmail);
					$checkname->execute();
					if($checkname->fetchColumn() > 1 ){
							echo "Username Already exists";
					}
					else{
						$checkpss = $db->prepare("SELECT COUNT(subadmin_password) FROM sub_admin WHERE subadmin_password=:sbpass");
						$checkpss->bindParam(':sbpass' , $sbpass);
						$checkpss->execute();
						if($checkpss->fetchColumn() > 1 ){
								echo "Password Already exists";
						}
						else{
							$add_activity = $db->prepare("UPDATE sub_admin SET subadmin_name=:actname,subadmin_mail=:sbmail,subadmin_password=:spass,pass=:sbpass WHERE subadmin_id=:chid");	
							$add_activity->bindParam(':actname',$actname);
							$add_activity->bindParam(':sbmail',$sbmail);
							$add_activity->bindParam(':spass',$spass);
							$add_activity->bindParam(':sbpass',$sbpass);
							$add_activity->bindParam(':chid',$chid);
							$add_activity->execute();
							if(isset($add_activity)){
							  echo "<script>location.assign('sub-admin.php')</script>";
							}
						}
				}
			}
					
						
				
		?>
			
		 <div class="overlaydv activity_pop" id="editactivitpop" style="opacity:1; visibility:visible;">
        	<div class="overlaydv-in">
            	<div class="overlaydv-inner">
                	<div class="activtiyadd">
                    	<div class="closepopdv" onClick="closepop()"><a href="sub-admin.php">&times; </a></div>
                        <h4>Edit SubAdmin</h4>
                        <form method="post" enctype="multipart/form-data">
                            <p>Name</p>
                            <input type="text" value="<?php echo $find['subadmin_name']; ?>" name="nsbname" required/>
                            <p>Username</p>
                            <input type="email" value="<?php echo $find['subadmin_mail']; ?>" name="nusrname" required/>
                            <p>Password</p>
                            <input type="password" value="<?php echo $find['pass']; ?>" name="nsbpss" required>
                            <input type="submit" value="Submit" name="changactv">
                        </form>
                        <div class="clearfix"></div>
                    </div>	
                </div>
            </div>
        </div>
        
		<?php } 
		elseif(isset($_GET['status'])){	
				$get_srvid = $_GET['status'];
				$findstatus = $db->prepare("SELECT subadmin_status FROM sub_admin WHERE subadmin_id=:get_srvid");
				$findstatus->bindParam(':get_srvid',$get_srvid);
				$findstatus->execute();
				$st = $findstatus->fetch();
				$found_status = $st['subadmin_status'];	
				if($found_status=='0'){
						$status_active = $db->prepare("UPDATE sub_admin SET subadmin_status='1' WHERE subadmin_id=:get_srvid");
						$status_active->bindParam(':get_srvid',$get_srvid);
						$status_active->execute();
						if(isset($status_active)){	
							
								echo "<script>location.assign('sub-admin.php')</script>"; 
						}
						else{ echo "Server Error"; }
				}
				if($found_status=='1'){
						
						$status_deactive = $db->prepare("UPDATE sub_admin SET subadmin_status='0' WHERE subadmin_id=:get_srvid");
						$status_deactive->bindParam(':get_srvid',$get_srvid);
						$status_deactive->execute();
						if(isset($status_deactive)){	
						
								echo "<script>location.assign('sub-admin.php')</script>"; 
						}
						else{ echo "Server Error"; }
				}
		}
	?>
        
        
        <script>
        	function addactivity() {
				$('#activit').addClass('showhide');
				
				}
			function editactivit() {
				$('#editactivitpop').addClass('showhide');
				
				}
			function closepop() {
				$('.activity_pop').removeClass('showhide');
				
				}
        	
        </script>
        
        
         
        <div class="fulldv category">
            <div class="fulldv">
                <h2>Sub Admin</h2>
            </div>
           <div class="col-md-12 p0 activity_table">
               <table class="see-table">
                    <tr class="bluetr">
                        <th>Name</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Status</th>
                        <th style="width:80px; text-align:center;">Edit</th>
                        <th style="width:80px; text-align:center;">Delete</th>
                    </tr>
                 <?php
				 	$show_activity = $db->prepare("SELECT * FROM sub_admin ORDER BY subadmin_id DESC");
					$show_activity->execute();
					$allactv = $show_activity->fetchAll();
					foreach($allactv as $allct){
				 ?>   
                    <tr>
                        <td><?php echo $allct['subadmin_name']; ?></td>
                        <td><?php echo $allct['subadmin_mail']; ?></td>
                        <td><?php echo $allct['pass']; ?></td>
                        <td><a href="sub-admin.php?status=<?php echo $allct['subadmin_id']; ?>"><?php if($allct['subadmin_status']=='1'){ ?><img src="images/active.png" style="height:25px; width:25px; margin:0 0 0 30px; float:right;"><?php } else { ?> <img src="images/deactive.png" style="height:25px; width:25px; margin:0 0 0 30px; float:right;"><?php } ?></td>
                        <td style="text-align:center;">
                        	<a href="sub-admin.php?edit=<?php echo $allct['subadmin_id']; ?>" onClick="editactivit()">
                                <span class="catedit"> <i class="fa fa-edit"></i> </span>
                            </a>
                        </td>
                        <td style="text-align:center;">
                            <a href="sub-admin.php?del=<?php echo $allct['subadmin_id']; ?>">
                                <span class="catdelete"><i class="fa fa-trash"></i> </span>
                            </a>
                            
                        </td>
                    </tr>
                <?php } ?>
                </table>
           </div>
        </div>
    </div>
 <?php
 	if(isset($_GET['del'])){
		$delid = $_GET['del'];	
		$deletecate = $db->prepare("DELETE FROM sub_admin WHERE subadmin_id=:delid");	
        $deletecate->bindParam(':delid',$delid);
        $deletecate->execute();
        if(isset($deletecate)){ 
			echo "<script>location.assign('sub-admin.php')</script>"; }
        else{ echo "Not deleted"; }
		
		
	}
 ?>
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