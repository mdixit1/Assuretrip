<?php
error_reporting(0);
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
<title>Lead Detail</title>
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
        
        
       <!-- Find lead by state -->
     <?php if(isset($_GET['transfer'])){ ?>  
        <div class="col-md-12">
        <?php 
			if(isset($_GET['transfer'])){ 
				$luniqid = $_GET['transfer'];
				$getldid = $db->prepare("SELECT leads_id FROM leads WHERE lead_uniq=:luniqid"); 
				$getldid->bindParam(':luniqid',$luniqid);
				$getldid->execute();
				$fldid = $getldid->fetch();
				$foundlid = $fldid['leads_id'];
				
				if(isset($_POST['find'])){
					$_SESSION['stnme'] = $_POST['aste_name'];
					header('Location:leads.php?transfer=$luniqid');
				}
				
			  if(isset($_POST['transfer'])){
					foreach($_POST['agid'] as $val){
							if($val!=''){
								$add_leads = $db->prepare("INSERT INTO lead_transfer(traf_agid,traf_leadid,transfer_status,transfer_date)VALUES(:val, :foundlid, '1', :date)");
								$add_leads->bindParam(':val',$val);
								$add_leads->bindParam(':foundlid',$foundlid);
								$add_leads->bindParam(':date',$date);
								$add_leads->execute();
								if(isset($add_leads)){ echo "<script>location.assign('leads.php?transfer=$luniqid')</script>"; }
							}
							else{ echo "<script>alert('Select Atleast one agent')</script>"; }
						
					}
			  }
			  
			  if(isset($_POST['cancel'])){
				  unset($_SESSION['stnme']);
				  echo "<script>location.assign('leads.php')</script>";
			  }
		?>
        	<div class="col-md-12 leadfindtable">
            	<h2>Find Lead </h2>
            </div>
            <div class="fulldv leadfind">
                <form method="post">
                    <div class="col-md-3">
                        <select name="aste_name" id="" required/>
                            <option value="">Select Option</option>
                        <?php
							$get_state = $db->prepare("SELECT ste.state_id,ste.state_name FROM agent_registration aget JOIN state ste ON ste.state_id=aget.agent_state ORDER BY state_name ASC");	
							$get_state->execute();
							$allstate = $get_state->fetchAll();
							foreach($allstate as $alste){
						?>   
                            <option value="<?php echo $alste['state_id']; ?>"><?php echo $alste['state_name']; ?></option>
                        <?php } ?>    
                        </select>
                    </div>
                    <div class="col-md-3 p0"> <input type="submit" name="find" value="Find"></div>
                </form>
            </div>
       <?php } 
	   		  if(isset($_SESSION['stnme'])){ 
	   				$setename = $_SESSION['stnme'];
					
	   ?>     
            <form method="post">
                <div class="col-md-12 leadfindtable">
                    <h2>Lead Detail</h2>
                    <table class="see-table see-table-each">
                        <tr>
                            <th style="width:80px;">S.No.</th>
                            <th style="width:80px;">Check</th>
                            <th>Agent Name</th>
                            <th>Address</th>
                        </tr>
                      <?php
					  	$sno = 1; 
					  	$show_agents = $db->prepare("SELECT ag.agent_id,ag.agent_name,ag.agent_address,st.state_name FROM agent_registration ag JOIN state st ON st.state_id=ag.agent_state WHERE agent_state=:setename AND agent_id NOT IN(SELECT traf_agid FROM lead_transfer WHERE traf_leadid='$foundlid')");
						$show_agents->bindParam(':setename',$setename);
						$show_agents->execute();
						$algsnts = $show_agents->fetchAll();
						foreach($algsnts as $alf){
					  ?>  
                        <tr>
                            <td><?php echo $sno++; ?></td>
                            <td><input type="checkbox" name="agid[]" value="<?php echo $alf['agent_id']; ?>"/></td>
                            <td><?php echo $alf['agent_name']; ?></td>
                            <td><?php echo $alf['agent_address']; ?></td>
                        </tr>
                     <?php } ?>                          
                    </table>
                </div>
                <div class="col-md-12 tranfersubmit">
                    <input type="submit" name="transfer" value="Tranfer Now">
                    <input type="submit" name="cancel" value="Cancel">
                </div>
            </form>
            <div class="clearfix"></div>
            <br><br><br>
       <?php } ?>     
        </div>
    <?php } 
		elseif(isset($_GET['confirm'])){ ?>    
        <!-- Lead by transfer -->
        <a href="leads.php">Back</a>
        <div class="fullldv p20 leadfindtable">
               <h2>Lead Detail</h2>
               <table class="see-table see-table-each" >
               <th>S.No</th>
               <th>Agent Name</th>
               <th>Lead ID</th>
               <th>Email</th>
               <th>Mobile</th>
               <th>Transfer Date</th>
               <th>Confirm Status</th>
             <?php
			 	$srno = 1;
			 	$show_tranferstatus = $db->prepare("SELECT ag.agent_name,ag.agent_mail,ag.mobile,lds.lead_uniq,lt.confirm_status,lt.transfer_date FROM lead_transfer lt JOIN agent_registration ag ON ag.agent_id=lt.traf_agid JOIN leads lds ON lds.leads_id=lt.traf_leadid ORDER BY lt.transfer_id DESC");
				$show_tranferstatus->execute();
				$stmt = $show_tranferstatus->fetchAll();
				if(count($stmt)){
					foreach($stmt as $st){
			 ?>  
                <tr>
                	<td><?php echo $srno++; ?></td>
                    <td><?php echo $st['agent_name']; ?></td>
                    <td><?php echo $st['lead_uniq']; ?></td>
                    <td><?php echo $st['agent_mail']; ?></td>
                    <td><?php echo $st['mobile']; ?></td>
                    <td><?php echo date('d-M-Y',strtotime($st['transfer_date'])); ?></td>
                    <th> <?php if($st['confirm_status']=='1'){ ?>
                    		<span class="confirm" style="background:#14980A;">Confirm</span> 
                         <?php } else { ?>
                    		<span class="confirm">Not Confirm</span>
                        <?php } ?>
                    </th>
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
            <br><br><br><br>
    <?php } 
	
		
		elseif(isset($_GET['transfered'])){ ?>	
		
        	<div class="see-12">
            	<div class="fullldv p20 leadfindtable">
              <h2>Lead Detail</h2>
              <table class="see-table see-table-each" >
               <th>S.No</th>
               <th>Email</th>
               <th>Mobile</th>
               <th>Date</th>
               <th>Download Lead</th>
               <th>Transfer Lead</th>
               <th>View</th>
             <?php
			 	$sno = 1;
			 	$show_agent = $db->prepare("SELECT ld.* FROM leads ld JOIN lead_transfer lt ON lt.traf_leadid=ld.leads_id ORDER BY leads_id DESC");
				$show_agent->execute();
				$rows = $show_agent->fetchAll();
				if(count($rows)){
					foreach($rows as $row){
						$lid = $row['leads_id'];
						$chektrnfrlead = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_leadid=:lid");
						$chektrnfrlead->bindParam(':lid',$lid);
						$chektrnfrlead->execute();
						$chkld = $chektrnfrlead->fetchColumn();
			 ?>  
                <tr>
                	<td><?php echo $sno++; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['mobile']; ?></td>
                    <td><?php echo date('d-M-Y',strtotime($row['lead_date'])); ?></td>
                    <td><a href="download_pdf.php?compid=<?php echo $row['leads_id']; ?>">Download</a></td>
                    <th>
                  <?php
				  	 if($chkld > 0){
				  ?>  
                    <a class="trf_btn" style="background:#14980A; opacity:1;">Transfered</a>
                  <?php } else { ?>
                  	<a href="leads.php?transfer=<?php echo $row['lead_uniq']; ?>" class="trf_btn">Transfer</a> 
                  <?php } ?>  
                  </th>
                    <td><a href="leads.php?confirm=<?php echo $row['lead_uniq']; ?>" class="leadtrn">(<?php echo $chkld; ?>) view all</a></td>
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
            </div>
        
	<?php } else { ?>  
    	<div class="see-12">
          <?php
		  	  if(isset($_GET['more'])){
				  $getagid = $_GET['more'];
				  $getdetail = $db->prepare("SELECT * FROM leads WHERE leads_id=:getagid");
				  $getdetail->bindParam(':getagid',$getagid);
				  $getdetail->execute();
				  $stmt = $getdetail->fetch();
		  ?>		
          <a href="listingdetail.php" class="btn btn-danger" style="margin-left:10px; margin-top:15px;">Back</a>  
          <center><h4><?php echo $stmt['lead_uniq']; ?></h4></center>
          <div class="fulldv p20">
          <h4>Lead Information</h4>
          <div class="dv100 userdetail">
          	<table class="see-table see-table-each" >
				<tr>
                	<th>Destination Name</th>
                	<td><?php echo $stmt['destination_to']; ?></td>
                </tr>
                <tr>
                	<th>Exploring Holiday</th>
                	<td><?php echo $stmt['exploring']; ?></td>
                </tr>
                <tr>
                	<th>Destination FROM</th>
                    <td><?php echo $stmt['destination_from']; ?></td>
                </tr>
                <tr>
                	<th>Departure Type</th>
                    <td><?php echo $stmt['departure_type']; ?></td>
                </tr>
                <tr>
                	<th>Departure Date</th>
                    <td><?php echo date('d-M-Y', strtotime($stmt['departure_date'])); ?></td>
                </tr>
                 <tr>
                	<th>Departure Day</th>
                    <td><?php echo $stmt['departure_day']; ?></td>
                </tr>
                <tr>
                	<th>Email</th>
                    <td><?php echo $stmt['email']; ?></td>
                </tr>
                <tr>
                	<th>Mobile No.</th>
                    <td><?php echo $stmt['mobile']; ?></td>
                </tr>
                <tr>
                	<th>Hotel Rating</th>
                    <td><?php echo $stmt['hotel_first']."&nbsp;".$stmt['hotel_second']."&nbsp;".$stmt['hotel_third']."&nbsp;".$stmt['hotel_four']."&nbsp;".$stmt['hotel_five']; ?></td>
                </tr>
                <tr>
                	<th>Flight</th>
                    <td><?php echo $stmt['flight']; ?></td>
                </tr>
                <tr>
                	<th>Budget With AirFair</th>
                    <td><?php echo $stmt['budget_withair']; ?></td>
                </tr>
                <tr>
                	<th>Budget Without AirFair</th>
                    <td><?php echo $stmt['budget_withoutair']; ?></td>
                </tr>
                <tr>
                	<th>Adult</th>
                    <td><?php echo $stmt['adult']; ?></td>
                </tr>
                <tr>
                	<th>Infant</th>
                    <td><?php echo $stmt['infant']; ?></td>
                </tr>
                <tr>
                	<th>Childeren</th>
                    <td><?php echo $stmt['children']; ?></td>
                </tr>
                <tr>
                	<th>Booking Type</th>
                    <td><?php echo $stmt['book_type']; ?></td>
                </tr>
                <tr>
                	<th>Cab Facility</th>
                    <td><?php echo $stmt['cab_facility']; ?></td>
                </tr>
                <tr>
                	<th>Language</th>
                    <td><?php echo $stmt['cab_language']; ?></td>
                </tr>
                <tr>
                	<th>Tour Type</th>
                    <td><?php echo $stmt['type_of_tour']; ?></td>
                </tr>
                <tr>
                	<th>Week</th>
                	<td><?php echo $stmt['this_week']; ?></td>
                </tr>
                <tr>
                	<th>Additional Requirements</th>
                    <td><?php echo $stmt['additional_req']; ?></td>
                </tr>
            </table>    
          </div>        
          <br><br><br>
          </div>     
		  <?php } 
			  else{ 
		  ?>	  
        	<div class="fullldv p20 leadfindtable">
              <h2>Lead Detail</h2>
              <table class="see-table see-table-each" >
               <th>S.No</th>
               <th>Email</th>
               <th>Mobile</th>
               <th>Date</th>
               <th>Download Lead</th>
               <th>Transfer Lead</th>
               <th>View</th>
             <?php
			 	$sno = 1;
			 	$show_agent = $db->prepare("SELECT * FROM leads ORDER BY leads_id DESC");
				$show_agent->execute();
				$rows = $show_agent->fetchAll();
				if(count($rows)){
					foreach($rows as $row){
						$lid = $row['leads_id'];
						$chektrnfrlead = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_leadid=:lid");
						$chektrnfrlead->bindParam(':lid',$lid);
						$chektrnfrlead->execute();
						$chkld = $chektrnfrlead->fetchColumn();
			 ?>  
                <tr>
                	<td><?php echo $sno++; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['mobile']; ?></td>
                    <td><?php echo date('d-M-Y',strtotime($row['lead_date'])); ?></td>
                    <td><a href="download_pdf.php?compid=<?php echo $row['leads_id']; ?>">Download</a></td>
                    <th>
                  <?php
				  	 if($chkld > 0){
				  ?>  
                    <a class="trf_btn" style="background:#14980A; opacity:1;">Transfered</a>
                  <?php } else { ?>
                  	<a href="leads.php?transfer=<?php echo $row['lead_uniq']; ?>" class="trf_btn">Transfer</a> 
                  <?php } ?>  
                  </th>
                    <td><a href="leads.php?confirm=<?php echo $row['lead_uniq']; ?>" class="leadtrn">(<?php echo $chkld; ?>) view all</a></td>
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
    <?php } ?>      
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
  
  
function addactivity() {
	$('#activit').addClass('showhide');
	
	}
function closepop() {
	$('.activity_pop').removeClass('showhide');
	
	}

  
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
