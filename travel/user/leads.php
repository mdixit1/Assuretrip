<?php
error_reporting(0);
session_start();
include('../connection/index.php');
include('../function.php');
if(isset($_SESSION['usrid']) && isset($_SESSION['usrmail']) && isset($_SESSION['usrpass'])){
	$recid = $_SESSION['usrid'];
	$recmail = $_SESSION['usrmail'];
	$recpass = $_SESSION['usrpass'];
	$user_detail = $db->prepare("SELECT * FROM users WHERE user_id=:recid");
	$user_detail->bindParam(':recid',$recid);
	$user_detail->execute();
	$stmt = $user_detail->fetchAll();
	if(count($stmt)){
		foreach($stmt as $st){
			$recname = $st['user_name'];
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Leads </title>
<?php echo headdata(); ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="<?php echo $url; ?>css/font-awesome.min.css" type="text/css" rel="stylesheet"/>
<link href="<?php echo $url; ?>css/bootstrap.min.css" type="text/css" rel="stylesheet"/>
<link href="css/styleplus.css" type="text/css" rel="stylesheet"/>
<link href="css/responsive-manage.css" type="text/css" rel="stylesheet"/>
<script src="<?php echo $url; ?>js/jquery-3.2.1.min.js" type="text/javascript"> </script>
<script src="<?php echo $url; ?>js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/index.js"></script>
</head>
<body>
<?php include('aheader.php'); ?>
<div class="slidebody trans5s">
    <?php include('topheader.php'); ?>
    <div class="fulldv adminbody">
        <div class="section">
			<div class="fulldv p20">
            	<div class="col-md-6 p0">
                	<div class="fulldv leadtabl">
                     <?php if(isset($_GET['comment'])){
					 	 		$lid = $_GET['comment'];
					?>
                    	<h2>Add Comment</h2>
                        <a href="leads.php">Back</a>
                    <?php			
								$showcomt = $db->prepare("SELECT user_comment FROM leads WHERE leads_id=:lid");
								$showcomt->bindParam(':lid',$lid);
								$showcomt->execute();
								$rowcm = $showcomt->fetch();
								
								if(isset($_POST['addcomnt'])){
									$ucomnt = $_POST['ucomnt'];
									$update_lcomt = $db->prepare("UPDATE leads SET user_comment=:ucomnt WHERE leads_id=:lid");
									$update_lcomt->bindParam(':ucomnt',$ucomnt);
									$update_lcomt->bindParam(':lid',$lid);
									$update_lcomt->execute();
									if(isset($update_lcomt)){ echo "<script>location.assign('".$url."user/leads.php')</script>"; }
								}
					 ?>			
						 <div class="col-md-12">
                         	<form action="" method="post">
                              <div class="col-md-12">
                            	<textarea name="ucomnt" id="" cols="100" rows="10" required/><?php echo $rowcm['user_comment']; ?></textarea>
                              </div>  
                              <div class="col-md-2">
                                <input type="submit" name="addcomnt">
                              </div>  
                            </form>
                         </div>
					<?php }
					 else{ ?>
                        <h4>User Enquiry Details</h4>
                        <table class="see-table">
                            <tr>
                                <td style="width:65px;">S.No.</td>
                                <td>Enquiry ID</td>
                                <td>Add Comments</td>
                                <td style="width:90px;">Download</td>
                            </tr>
                            <?php
								$sno = 1;
								$lead_list = $db->prepare("SELECT * FROM leads WHERE email=:recmail");
								$lead_list->bindParam(':recmail',$recmail);
								$lead_list->execute(); 
								$allleads = $lead_list->fetchAll();
								foreach($allleads as $lead){
							?>
                            <tr>
                                <td><?php echo $sno++; ?></td>
                                <td><?php echo $lead['lead_uniq']; ?></td>
                                <td><a href="leads.php?comment=<?php echo $lead['leads_id']; ?>"><img src="<?php echo $url; ?>user/images/edit.png" height="12px;"></a></td>
                                <td><a href="<?php echo $url; ?>user/download_pdf.php?compid=<?php echo $lead['leads_id']; ?>"><i class="fa fa-download"></i></a></td>
                            </tr>
                           <?php } ?> 
                        </table>
                    <?php } ?>    
                    </div>
                    
                    <!--<div class="fulldv">
                    	<ul class="pagination">
                        	<li class="disabled"><a href="#">&laquo;</a></li>
                            <li class="active"><a href="">1</a></li>
                            <li><a href="">2</a></li>
                            <li><a href="">3</a></li>
                            <li><a href="">4</a></li>
                            <li><a href="">5</a></li>
                            <li><a href="#">&raquo;</a></li>
                        </ul>
                        <div class="clearfix"></div>
                        <br><br><br>
                    </div>-->
                </div>
			</div>
            
        </div>
    </div>
</div>


<script>
	function editpro() {
		$('.editprofile').addClass('show')
		
		}
	function editclose() {
		$('.editprofile').removeClass('show')
		
		}
</script>
</body>

</html>
<?php } } else { echo "<script>location.assign('".$url."user/logout.php')</script>"; }
} else { echo "<script>location.assign('".$url."user/logout.php')</script>"; } ?>