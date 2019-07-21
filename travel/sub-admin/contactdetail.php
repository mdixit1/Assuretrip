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
			
				if(isset($_GET['del'])){
					$delid = $_GET['del'];
					$show_cont = $db->prepare("DELETE FROM contact_detail WHERE contact_id=:delid"); 
					$show_cont->bindParam(':delid',$delid);
					$show_cont->execute();
					if(isset($show_cont)){
						echo "<script>location.assign('".$url."contactdetail.php')</script>";	
					}
				 }
?>
<!doctype html>
<html>
<head>
<title>Contact Detail</title>
<?php echo headdata(); ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="<?php echo $url; ?>css/font-awesome.min.css" type="text/css" rel="stylesheet"/>
<link href="<?php echo $url; ?>/css/bootstrap.min.css" type="text/css" rel="stylesheet"/>
<link href="css/styleplus.css" type="text/css" rel="stylesheet"/>
<link href="css/responsive-manage.css" type="text/css" rel="stylesheet"/>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="<?php echo $url; ?>js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/index.js"></script>
<script>
	function ck(){
		return confirm('Are you sure');	
	}
</script>
</head>
<body>
<?php include('aheader.php');?>
<div class="slidebody see-trans5s  budget_sect">
	 <?php include('topheader.php'); ?>
     <div class="fulldv adminbody">
        <div class="section">
            <div class="fulldv p20 userdetail">
                 <!--<div class="see-5 see-margin-bottom">
                	<form method="get">
                    	<div class="see-full searchdv">
                            <input type="search" id="searchh" name="searchh" placeholder="Search user by name" required/>
                            <input type="submit" id="sea" name="getsearchh" value="Search" class="greenbutton">
                        </div>
                    </form>
                 </div>--> 
               
                  <h4>Contact Person Details</h4>
                  <table class="see-table see-table-each  budget_sect">
                        <tr class="bluetr">
                            <th>S.No</th>
                            <th>Full Name</th>
                            <th>Email Id</th>
                            <th>Mobile No.</th>
                            <th>Register Date</th>
                            <th>Msg</th>
                            <th>Delete</th>
                        </tr>
                    <?php
					 	$sno = 1;
						$show_contact = $db->prepare("SELECT * FROM contact_detail ORDER BY contact_id DESC");
						$show_contact->execute();
						$rows = $show_contact->fetchAll();
						foreach($rows as $row){
					?>	    
                        <tr>
                            <td><?php echo $sno++; ?></td>
                            <td><?php echo $row['contact_name']; ?></td>			 	
                            <td><?php echo $row['contact_email']; ?></td>
                            <td><?php echo $row['contact_mobile']; ?></td>
                            <td><?php echo $row['contact_msg']; ?></td>
                            <td><?php echo date('d M, Y',strtotime($row['contact_date'])); ?></td>
                            <td>
                                <a href="<?php echo $row['contact_id']; ?>" class="catdelete"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php } ?>    
                    </table>
            </div>
            <!--<div class="fulldv p20" style="padding-top:0 !important;">
                <ul class="pagination pagination-sm">
                    <li class="disabled"><a href="#">&laquo;</a></li>
                    <li class="active"><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li><a href="#">&raquo;</a></li>
                </ul>
            </div>-->
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
	      