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
<title>User Detail</title>
<?php echo headdata(); ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="<?php echo $url; ?>css/font-awesome.min.css" type="text/css" rel="stylesheet"/>
<link href="<?php echo $url; ?>/css/bootstrap.min.css" type="text/css" rel="stylesheet"/>
<link href="css/styleplus.css" type="text/css" rel="stylesheet"/>
<link href="css/responsive-manage.css" type="text/css" rel="stylesheet"/>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="<?php echo $url; ?>js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/index.js"></script>
</head>
<body>
<?php include('aheader.php'); ?>
<div class="slidebody see-trans5s">
    <?php 
	if(isset($_GET['more'])){ 
	     $usr_id = $_GET['more'];
		 $allusers = $db->query("SELECT * FROM users WHERE userid='$usr_id'");
		 $alld = $allusers->fetch();
		 	 $ursfname = strtoupper($alld['user_fname']);
			 $urslname = strtoupper($alld['user_lname']);
			 $userblock = $alld['userblock']; ?>
             
   <div class="see-3 display-center">          
   	<table class="see-table see-table-each" style="margin-top:100px;">
     	<th><?php echo $ursfname.'&nbsp;'.$urslname;?></th>
            <?php 
                if($userblock == 0){
                    if($_POST['block']){
                        $statufound = $_POST['status'];
                        $queryuodate = $db->exec("UPDATE users SET userblock = '1' WHERE userid = '$usr_id' ");
                        if(isset($queryuodate)){ echo "<script>location.assign('userdetail.php?more=$usr_id')</script>"; }
                    } ?>
                    <tr><td>
                    <form method="post">
                        <input type="hidden" name="status" value="<?php echo $userblock; ?>" required>
                        <input type="submit" value="Block" name="block" class="see-button see-green">
                    </form> 
                    </td></tr>
            <?php } 
                else{
                    if($_POST['unblock']){
                        $statufound = $_POST['status'];
                        $queryuodate = $db->exec("UPDATE users SET userblock = '0' WHERE userid = '$usr_id' ");
                        if(isset($queryuodate)){ echo "<script>location.assign('userdetail.php?more=$usr_id')</script>"; }
                    } ?> 
                    <tr><td>
                    <form method="post">
                        <input type="hidden" name="status" value="<?php echo $userblock; ?>" required>
                        <input type="submit" value="Unblock" name="unblock" class="see-button see-black-hover">
                    </form> 
                    </td></tr>     
            <?php } ?>
                    
</table>		
</div>		
<?php } 
	else { ?>
		<div class="fulldv adminbody">
    <?php include('topheader.php'); ?>
    <div class="section">
        <div class="see-12">
            <div class="fulldv p20 userdetail">
              <h4>User Details</h4>
              <table class="see-table see-table-each" >
                <tr class="bluetr">
                    <th>S.No</th>
                    <th>User Name </th>
                    <th> Mobile </th>
                    <th> Email </th>
                </tr>
               <?php
			    $sno = 1;
			   	$user_detail = $db->prepare("SELECT * FROM users ORDER BY user_id DESC");
				$user_detail->execute();
				$alluser = $user_detail->fetchAll();
				if(count($alluser)){
					foreach($alluser as $alusr){
			   ?> 
             	   <tr>
                    <td><?php echo $sno++; ?></td>
                    <td><?php echo $alusr['user_name']; ?></td>
                    <td><?php echo $alusr['user_mobile']; ?></td>
                    <td><?php echo $alusr['user_mail']; ?></td>
                </tr>
               <?php } } else { ?>
               		<tr>
                    	<td></td>
                    	<td></td>
                    	<td>No detail found</td>
                    	<td></td>
                    </tr>
               <?php } ?> 
               </table> 
            </div>
            <div class="fulldv p20" style="padding-top:0 !important;">
            	<ul class="pagination pagination-sm">
                    <li class="disabled"><a href="#">&laquo;</a></li>
                    <li class="active"><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li><a href="#">&raquo;</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php } ?>
</div>

</body>
</html>
<?php  }
	}
	else{ echo "<script>location.assign('logout.php')</script>"; }
}
else{ echo "<script>location.assign('logout.php')</script>"; }
?>
