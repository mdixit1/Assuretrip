<?php
error_reporting(0);
session_start();
include('../connection/index.php');
include('../function.php'); 
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
<title>Add Activity</title>
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
            <input type="button" value="Add Activity" class="btn-blue" onClick="addactivity()">
        </div>
    	<?php
			if(isset($_POST['addactivity'])){
				$actname = stripslashes($_POST['actname']);
				$newscaturl = str_replace(' ', '-', $actname);
				$without_special_char = preg_replace('/[^a-zA-Z0-9_ -]/s', '', $newscaturl);
				$finalnew = strtolower($without_special_char);
				$fl_name = $_FILES['actfile']['name'];
				$fl_temp = $_FILES['actfile']['tmp_name'];
				$target = "../images/activity_image/".$fl_name;
				$checkname = $db->prepare("SELECT COUNT(activity_name) FROM add_activity WHERE activity_name=:actname");
				$checkname->bindParam(':actname' , $actname);
				$checkname->execute();
				if($checkname->fetchColumn() > 0 ){
						echo "Already exists";
				}
				else{
					$add_activity = $db->prepare("INSERT INTO add_activity(activity_name,activity_url,activity_image,activity_date)VALUES(:actname, :finalnew, :fl_name, :date)");	
					$add_activity->bindParam(':actname',$actname);
					$add_activity->bindParam(':finalnew',$finalnew);
					$add_activity->bindParam(':fl_name',$fl_name);
					$add_activity->bindParam(':date',$date);
					$add_activity->execute();
					if(isset($add_activity)){
						move_uploaded_file($fl_temp,$target);	
					}
				}
			}
		?>	
        
        <div class="overlaydv activity_pop" id="activit">
        	<div class="overlaydv-in">
            	<div class="overlaydv-inner">
                	<div class="activtiyadd">
                    	<div class="closepopdv" onClick="closepop()"> &times; </div>
                        <h4>Add Activity</h4>
                        <form method="post" enctype="multipart/form-data">
                            <p>Activity Name</p>
                            <input type="text" name="actname" required/>
                            <p>Activity Icon</p>
                            <input type="file" name="actfile">
                            <input type="submit" value="Submit" name="addactivity">
                        </form>
                        <div class="clearfix"></div>
                    </div>	
                </div>
            </div>
        </div>
        
        
       <?php if(isset($_GET['edit'])){ 
	   			$chid = $_GET['edit'];
				$foundimage = $db->prepare("SELECT activity_image,activity_name FROM add_activity WHERE activity_id=:chid");
				$foundimage->bindParam(':chid',$chid);
				$foundimage->execute();
				$find = $foundimage->fetch();
				$fimage = $find['activity_image'];
				
			  if(isset($_POST['changactv'])){
				$actname = stripslashes($_POST['nactname']);
				$newscaturl = str_replace(' ', '-', $actname);
				$without_special_char = preg_replace('/[^a-zA-Z0-9_ -]/s', '', $newscaturl);
				$finalnew = strtolower($without_special_char);
				$fll_name = $_FILES['nwfile']['name'];
				$fl_temp = $_FILES['nwfile']['tmp_name'];
				$target = "../images/activity_image/".$fl_name;
				if(!empty($fll_name)){
					$fl_name = $fll_name;
				}
				else{
					$fl_name = $fimage;
				}
				$checkname = $db->prepare("SELECT COUNT(activity_name) FROM add_activity WHERE activity_name=:actname");
				$checkname->bindParam(':actname' , $actname);
				$checkname->execute();
				if($checkname->fetchColumn() > 1 ){
						echo "Already exists";
				}
				else{
					$add_activity = $db->prepare("UPDATE add_activity SET activity_name=:actname,activity_url=:finalnew,activity_image=:fl_name WHERE activity_id=:chid");	
					$add_activity->bindParam(':actname',$actname);
					$add_activity->bindParam(':finalnew',$finalnew);
					$add_activity->bindParam(':fl_name',$fl_name);
					$add_activity->bindParam(':chid',$chid);
					$add_activity->execute();
					if(isset($add_activity)){
					  if(!empty($_FILES['nwfile'])){	
						unlink('../images/activity_image/'.$fimage);
						move_uploaded_file($fl_temp,$target);	
					  }
					  echo "<script>location.assign('activity.php')</script>";
					}
				}
			}
					
						
				
		?>
			
		 <div class="overlaydv activity_pop" id="editactivitpop" style="opacity:1; visibility:visible;">
        	<div class="overlaydv-in">
            	<div class="overlaydv-inner">
                	<div class="activtiyadd">
                    	<div class="closepopdv" onClick="closepop()"><a href="activity.php">&times; </a></div>
                        <h4>Edit Activity</h4>
                        <form method="post" enctype="multipart/form-data">
                            <p>Activity Name</p>
                            <input type="text" name="nactname" value="<?php echo $find['activity_name']; ?>" required/>
                            <p>Activity Icon</p>
                            <input type="file" name="nwfile">
                            <input type="submit" value="Submit" name="changactv">
                        </form>
                        <div class="clearfix"></div>
                    </div>	
                </div>
            </div>
        </div>
        
		<?php } ?>
        
        
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
                <h2>Activity</h2>
            </div>
           <div class="col-md-12 p0 activity_table">
               <table class="see-table">
                    <tr class="bluetr">
                        <th>Activity Name</th>
                        <th style="width:100px; text-align:center;">Activity Icon</th>
                        <th style="width:80px; text-align:center;">Edit</th>
                        <th style="width:80px; text-align:center;">Delete</th>
                    </tr>
                 <?php
				 	$show_activity = $db->prepare("SELECT * FROM add_activity ORDER BY activity_id DESC");
					$show_activity->execute();
					$allactv = $show_activity->fetchAll();
					foreach($allactv as $allct){
				 ?>   
                    <tr>
                        <td><?php echo $allct['activity_name']; ?></td>
                        <td style="text-align:center;"><img src="../images/activity_image/<?php echo $allct['activity_image']; ?>" alt=""/></td>
                        <td style="text-align:center;">
                        	<a href="activity.php?edit=<?php echo $allct['activity_id']; ?>" onClick="editactivit()">
                                <span class="catedit"> <i class="fa fa-edit"></i> </span>
                            </a>
                        </td>
                        <td style="text-align:center;">
                            <a href="activity.php?del=<?php echo $allct['activity_id']; ?>">
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
		$getdelimg = $db->prepare("SELECT activity_image FROM add_activity WHERE activity_id=:delictid");
		$getdelimg->bindParam(':delictid',$delictid);
		$getdelimg->execute();
		$founddel = $getdelimg->fetch();
		$finddel = $founddel['activity_image'];
        $deletecate = $db->prepare("DELETE FROM add_activity WHERE activity_id=:delictid");	
        $deletecate->bindParam(':delictid',$delictid);
        $deletecate->execute();
        if(isset($deletecate)){ 
			unlink('../images/activity_image/'.$finddel);
			echo "<script>location.assign('activity.php')</script>"; }
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