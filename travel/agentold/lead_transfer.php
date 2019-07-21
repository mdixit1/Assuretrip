<?php
error_reporting(0);
session_start();
include('../connection/index.php');
include('../function.php'); 
if(isset($_SESSION['agid']) && isset($_SESSION['agmail']) && isset($_SESSION['agpass'])){
	$agid = $_SESSION['agid'];
	$agent_detail = $db->prepare("SELECT * FROM agent_registration WHERE agent_id=:agid");
	$agent_detail->bindParam(':agid',$agid);
	$agent_detail->execute();
	$stmt = $agent_detail->fetchAll();
	if(count($stmt)){
		foreach($stmt as $st){
			$recname = $st['agent_company'];
			
			$update_notification = $db->prepare("UPDATE lead_transfer SET notification='1' WHERE traf_agid=:agid");
			$update_notification->bindParam(':agid',$agid);
			$update_notification->execute();
			
			if(isset($_POST['updatesta'])){
				$tfid = $_POST['tfid'];
				$tfst = $_POST['tfstatus'];	
				$update_status = $db->prepare("UPDATE lead_transfer SET confirm_status=:tfst WHERE transfer_id=:tfid");
				$update_status->bindParam(':tfst',$tfst);
				$update_status->bindParam(':tfid',$tfid);
				$update_status->execute();
				if(isset($update_status)){ echo "<script>location.assign('".$url."agent/lead_transfer')</script>"; } 
			}
?>
<!DOCTYPE html>
<html lang="en-IN">
<head>
    <?php echo headdata(); ?>
    <link rel="canonical" href=""/>
    <link rel='shortlink' href=""/>
	<title>Leads</title>
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
    <link href="style/admin-style.css" rel="stylesheet" type="text/css"/>
    <link href="css/see.css" type="text/css" rel="stylesheet"/>
	<link href="css/styleplus.css" type="text/css" rel="stylesheet"/>
	<link href="css/index.css" type="text/css" rel="stylesheet"/>
    <link href="css/style_manage.css" type="text/css" rel="stylesheet" />
    <link href="css/responsive-manage.css" type="text/css" rel="stylesheet"/>
    
</head>
<body>
<div class="see-section wrapper_mg">

<div class="see-section main_dv"> 
    <?php include('leftmenu.php'); ?>
    
    <div class="col-md-12 p0 rightsidebar">
        <?php include('rightheader.php');?>
        <div class="col-md-12 rightsidebar_top2"></div>
        <!--<div class="col-md-12 rightsidebar_top3">
        	<select name="" id="">
            	<option value="" hidden="">Destinations</option>
            	<option value="">Delhi</option>
            	<option value="">Kerla</option>
            </select>
        </div>-->
        
        <?php if(isset($_GET['more'])){
				  $getagid = $_GET['more'];
				  $getdetail = $db->prepare("SELECT * FROM leads WHERE lead_uniq=:getagid");
				  $getdetail->bindParam(':getagid',$getagid);
				  $getdetail->execute();
				  $stmtt = $getdetail->fetch();
					
		?>
          <div class="fulldv p20 leadfindtable leaddetail">
          	  <h2><a href="lead_transfer.php" class="back">Back</a> <?php echo $getagid; ?></h2>
              <table class="see-table see-table-each" >
                    <tr style="background:#FFF;">
                        <th>Destination Name</th>
                        <td><?php echo $stmtt['destination_to']; ?></td>
                        <th>Exploring Holiday</th>
                        <td><?php echo $stmtt['exploring']; ?></td>
                    </tr>
                    <tr>
                        <th>Destination FROM</th>
                        <td><?php echo $stmtt['destination_from']; ?></td>
                        <th>Departure Type</th>
                        <td><?php echo $stmtt['departure_type']; ?></td>
                    </tr>
                    <tr>
                        <th>Departure Date</th>
                        <td><?php echo date('d-M-Y', strtotime($stmtt['departure_date'])); ?></td>
                        <th>Departure Day</th>
                        <td><?php echo $stmtt['departure_day']; ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?php echo $stmtt['email']; ?></td>
                        <th>Mobile No.</th>
                        <td><?php echo $stmtt['mobile']; ?></td>
                    </tr>
                    <tr>
                        <th>Hotel Rating</th>
                        <td><?php echo $stmtt['hotel_first']."&nbsp;".$stmtt['hotel_second']."&nbsp;".$stmtt['hotel_third']."&nbsp;".$stmtt['hotel_four']."&nbsp;".$stmtt['hotel_five']; ?></td>
                        <th>Flight</th>
                        <td><?php echo $stmtt['flight']; ?></td>
                    </tr>
                    <tr>
                        <th>Budget With AirFair</th>
                        <td><?php echo $stmtt['budget_withair']; ?></td>
                        <th>Budget Without AirFair</th>
                        <td><?php echo $stmtt['budget_withoutair']; ?></td>
                    </tr>
                    <tr>
                        <th>Adult</th>
                        <td><?php echo $stmtt['adult']; ?></td>
                        <th>Infant</th>
                        <td><?php echo $stmtt['infant']; ?></td>
                    </tr>
                    <tr>
                        <th>Childeren</th>
                        <td><?php echo $stmtt['children']; ?></td>
                        <th>Booking Type</th>
                        <td><?php echo $stmtt['book_type']; ?></td>
                    </tr>
                    <tr>
                        <th>Cab Facility</th>
                        <td><?php echo $stmtt['cab_facility']; ?></td>
                        <th>Language</th>
                        <td><?php echo $stmtt['cab_language']; ?></td>
                    </tr>
                    <tr>
                        <th>Tour Type</th>
                        <td><?php echo $stmtt['type_of_tour']; ?></td>
                        <th>Week</th>
                        <td><?php echo $stmtt['this_week']; ?></td>
                    </tr>
                    <tr>
                        <th>Additional Requirements</th>
                        <td><?php echo $stmtt['additional_req']; ?></td>
                        <th></th>
                        <td></td>
                    </tr>
                </table>
          </div>
        <?php } else{ ?>
        	<div class="fulldv p20 leadfindtable">
                <h2>List of Transfer Leads</h2>
               <table class="see-table see-table-each">
                  <tr>
                    <th>S.No</th>
                    <th>Lead ID</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Destination From</th>
                    <th>Destination To</th>
                    <th style="width:110px;">Transfer Date</th>
                    <th style="width:110px;">Confirm Status</th>
                    <th>Update Status</th>
                    <th>More</th>
                  </tr>
                <?php
                    $sno = 1;
                    $lead_list = $db->prepare("SELECT ld.lead_uniq,ld.destination_to,ld.destination_from,ld.email,ld.mobile,lf.transfer_id,lf.confirm_status,lf.transfer_date FROM lead_transfer lf JOIN leads ld ON ld.leads_id=lf.traf_leadid WHERE lf.traf_agid=:agid");
                    $lead_list->bindParam(':agid',$agid);
                    $lead_list->execute();
                    $rows = $lead_list->fetchAll();
                    foreach($rows as $row){
                        $trfid = $row['transfer_id'];
                ?>  	
                  <tr>
                    <td><?php echo $sno++; ?></td>
                    <td><?php echo $row['lead_uniq']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['mobile']; ?></td>
                    <td><?php echo $row['destination_from']; ?></td>
                    <td><?php echo $row['destination_to']; ?></td>
                    <td><?php echo date('d-M-Y',strtotime($row['transfer_date'])); ?></td>
                    <td><?php if($row['confirm_status']=='0'){ echo "Not Confirm"; } else{ echo "Confirm"; }?></td>
                    <td>
                    <?php  
                        $date = date('d - M - Y');
                        $date = strtotime($date);
                        $date = strtotime("+29 day", $date);
                        $finaldate = date('Y-m-d', $date);
                        if($row['transfer_date'] > $finaldate){ }
                        else{
                    ?>	
                        <form method="post">
                            <input type="text" name="tfid" value="<?php echo $trfid; ?>" hidden="hidden">
                            <select name="tfstatus" id="" required/>
                                <option value="" hidden="hidden">Status</option>
                                <option value="1">Confirm</option>
                                <option value="0">Not Confirm</option>
                            </select>
                            <input type="submit" name="updatesta" value="Update">
                        </form>
                    <?php } ?>    
                    </td>
                    <td><a href="lead_transfer.php?more=<?php echo $row['lead_uniq']; ?>" class="leadtrn">More</a></td>
                  </tr>  
               <?php } ?>   
               </table> 
           </div>
        <?php } ?>    
        
        
    </div>
</div>
  


</div>

<script src="<?php echo $url; ?>js/slick.js" type="text/javascript"></script>
<script src="<?php echo $url; ?>js/custom.js" type="text/javascript"></script>




</body>
</html>
<?php } } else{ echo "</script>location.assign('".$url."agent/logout.php')</script>"; }
      } else{ echo "</script>location.assign('".$url."agent/logout.php')</script>"; } ?>
