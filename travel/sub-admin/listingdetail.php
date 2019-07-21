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
<title>Client Detail</title>
<?php echo headdata(); ?>
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
<div class="dv100 adminbody">
    <div class="section">
        <div class="see-12">
          <?php
		  	  if(isset($_GET['more'])){
				  $getagid = $_GET['more'];
				  $getdetail = $db->prepare("SELECT * FROM agent_registration WHERE agent_id=:getagid");
				  $getdetail->bindParam(':getagid',$getagid);
				  $getdetail->execute();
				  $stmt = $getdetail->fetch();
		  ?>		
          <a href="listingdetail.php" class="btn btn-danger" style="margin-left:10px; margin-top:15px;">Back</a>  
          <center><h4><?php echo $stmt['agent_name']; ?></h4></center>
          <div class="fulldv p20">
          <h4>Company Information</h4>
          <div class="dv100 userdetail">
          	<table class="see-table see-table-each" >
				<tr>
                	<th>Company Name</th>
                	<td><?php echo $stmt['agent_company']; ?></td>
                </tr>
                <tr>
                	<th>Contact Person Name</th>
                	<td><?php echo $stmt['agent_name']; ?></td>
                </tr>
                <tr>
                	<th>Address</th>
                    <td><?php echo $stmt['agent_address']; ?></td>
                </tr>
                <tr>
                	<th>Website</th>
                    <td><?php echo $stmt['agent_website']; ?></td>
                </tr>
                <tr>
                	<th>Email</th>
                    <td><?php echo $stmt['agent_mail']; ?></td>
                </tr>
                <tr>
                	<th>Mobile No.</th>
                    <td><?php echo $stmt['mobile']; ?></td>
                </tr>
                <tr>
                	<th>Booking Per Month</th>
                    <td><?php echo $stmt['boking_prmonth']; ?></td>
                </tr>
                <tr>
                	<th>Online Experience</th>
                    <td><?php echo $stmt['online_exp']; ?></td>
                </tr>
                <tr>
                	<th>Sales Team Size</th>
                    <td><?php echo $stmt['sale_teamsize']; ?></td>
                </tr>
                <tr>
                	<th>Where did you hear about us</th>
                    <td><?php echo $stmt['hear_about_us']; ?></td>
                </tr>
                <tr>
                	<th>Destinations you sell the most</th>
                    <td><?php echo $stmt['most_sell_desti']; ?></td>
                </tr>
                <tr>
                	<th>Your Name/ Designation</th>
                    <td><?php echo $stmt['destination_name']; ?></td>
                </tr>
                <tr>
                	<th>Skype Handler</th>
                    <td><?php echo $stmt['skype_handler']; ?></td>
                </tr>
                <tr>
                	<th>How old is you agency</th>
                    <td><?php echo $stmt['agent_stablish']; ?></td>
                </tr>
                <tr>
                	<th>Number of Employees</th>
                    <td><?php echo $stmt['no_of_emp']; ?></td>
                </tr>
                <tr>
                	<th>Our current travelers are from which region</th>
                    <td><?php echo $stmt['current_travlr_region']; ?></td>
                </tr>
                <tr>
                	<th>Description</th>
                    <td><?php echo $stmt['company_profile']; ?></td>
                </tr>
            </table>    
          </div>        
          
          <h4>Deal in</h4>
          <div class="dv100 userdetail">
          	<table class="see-table see-table-each" >
            <tr>
                <th style="width:200px;">Keyword</th>
                <td>
                	<ul>
               			<li>hotels</li>
               			<li>flights</li>
               			<li>travelocity</li>
               			<li>airline tickets</li>
               			<li>vacation</li>
                        <li>trip</li>
                        <li>plane tickets</li>
                        <li>travel agency</li>
                    </ul>
               </td>
              </tr> 
            </table>    
          </div> 
          <h4>Hours of Operation</h4>
          <div class="dv100 userdetail">
          	<table class="see-table see-table-each" >
            <tr>
                <th>Hours</th>
                <td>
                	<ul>
               			<li>Monday 07:00 AM To 1:30 PM</li>
               			<li>Tuesday 2:30 PM To :00 PM</li>
               			<li>Wednesday 3:30 PM To :00 PM</li>
               			<li>Thursday 10:00 AM To 3:00 PM</li>
               			<li>Friday 08:00 AM To 3:00 PM</li>
               			<li>Saturday Close T To</li>
               			<li>Sunday 08:30 AM To 3:00 PM</li>
                    </ul>
               </td>
              </tr> 
            </table>    
          </div> 
          
          <h4>Payment</h4>
          <div class="dv100 userdetail">
          	<table class="see-table see-table-each" >
            <tr>
                <th style="width:200px;">Modes of Payment</th>
                <td>
                	<ul>   
               			<li>cash</li>
               			<li>Credit Card</li>
                    </ul>
               </td>
              </tr> 
            </table>    
          </div>  
          <br><br><br>
          </div>     
		  <?php } 
			  else{ 
		  ?>	  
        	<div class="fullldv p20 userdetail">
            	<center><h2>Agent Detail</h2></center>
              <table class="see-table see-table-each" >
               <th>S.No</th>
               <th>Agent Name</th>
               <th>Company Name</th>
               <th>Email</th>
               <th>Mobile</th>
               <th>View More</th>
             <?php
			 	$sno = 1;
			 	$show_agent = $db->prepare("SELECT * FROM agent_registration ORDER BY agent_id DESC");
				$show_agent->execute();
				$rows = $show_agent->fetchAll();
				if(count($rows)){
					foreach($rows as $row){
			 ?>  
                <tr>
                	<td><?php echo $sno++; ?></td>
                    <td><?php echo $row['agent_name']; ?></td>
                    <td><?php echo $row['agent_company']; ?></td>
                    <td><?php echo $row['agent_mail']; ?></td>
                    <td><?php echo $row['mobile']; ?></td>
                    <!--<td>
                    <form method="post">
                         <input type="text" name="odrid" hidden="hidden" value="#">
                    		<p class="paystatus"><select name="addstatus" required/>
                            	<option value="" hidden="hidden">Pay Status</option>
                                <option value="0">Pending</option>
                                <option value="1">Recieved</option>
                            </form></p>
                            <input type="submit" name="status" value="Add">
                     	</form>
                        </td>-->
                    <td><a href="listingdetail.php?more=<?php echo $row['agent_id']; ?>">More</a></td>
                    <!--<td><a href="#"><img src="images/active.png" height="20px;"></a></td>-->
                </tr>     
             <?php } } else{ ?>
             <tr>
             	<th></th>
             	<th></th>
             	<th></th>
             	<th>No Agent Found</th>
             	<th></th>
             	<th></th>
             </tr>   
             <?php } ?>
             </table> 
            </div>
          <?php } ?>  
        </div>
    </div>
</div>
<?php 
		

if(isset($_POST['status'])){ 
        $getordid = $_POST['odrid'];
		$detail = $_POST['addstatus'];
		$updatestatus = $db->exec("UPDATE listing_detail SET pay_status='$detail' WHERE list_id='$getordid' ");
		if(isset($updatestatus)){
			echo "<script>location.assign('listingdetail.php')</script>";
		}
	  }
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
  $( function() {
    $( "#datepicker" ).datepicker({dateFormat: 'yy-m-d'});
  } );
  </script>
</div>
</body>
</html>
<?php  }
	}
	else{ echo "<script>location.assign('logout.php')</script>"; }
}
else{ echo "<script>location.assign('logout.php')</script>"; }
?>
