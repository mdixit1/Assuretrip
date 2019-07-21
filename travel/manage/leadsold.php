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
			 ?>  
                <tr>
                	<td><?php echo $sno++; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['mobile']; ?></td>
                    <td><?php echo date('d-M-Y',strtotime($row['lead_date'])); ?></td>
                    <td><a href="download_pdf.php?compid=<?php echo $row['leads_id']; ?>">Download</a></td>
                    <th><a href="leads.php?transfer=<?php echo $row['lead_uniq']; ?>" class="trf_btn">Transfer</a> 
                    <a class="trf_btn" style="background:#14980A; opacity:1;">Transfered</a></th>
                    <td><a href="#" class="leadtrn">(25) view all</a></td>
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
        
       <!-- Find lead by state -->
        <div class="col-md-12">
        <?php if(isset($_GET['transfer'])){ 
					
		?>
        	<div class="col-md-12 leadfindtable">
            	<h2>Find Lead </h2>
            </div>
            <div class="fulldv leadfind">
                <form action="">
                    <div class="col-md-3">
                        <select name="" id="">
                            <option value="">Select Option</option>
                            <option value="">Delhi</option>
                            <option value="">UP</option>
                        </select>
                    </div>
                    <div class="col-md-3 p0"> <input type="submit" value="Find"></div>
                </form>
            </div>
       <?php } ?>     
            <form action="">
                <div class="col-md-12 leadfindtable">
                    <h2>Lead Detail</h2>
                    <table class="see-table see-table-each">
                        <tr>
                            <th style="width:80px;">S.No.</th>
                            <th style="width:80px;">Check</th>
                            <th>Agent Name</th>
                            <th>Address</th>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td><input type="checkbox" name="#"></td>
                            <td>Gauri Shankar</td>
                            <td>Rohini sec - 18</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><input type="checkbox" name="#"></td>
                            <td>Gauri Shankar</td>
                            <td>Rohini sec - 18</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><input type="checkbox" name="#"></td>
                            <td>Gauri Shankar</td>
                            <td>Rohini sec - 18</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-12 tranfersubmit">
                    <input type="submit" value="Tranfer Now">
                </div>
            </form>
            <div class="clearfix"></div>
            <br><br><br>
        </div>
        
        <!-- Lead by transfer -->
        <div class="fullldv p20 leadfindtable">
               <h2>Lead Detail</h2>
               <table class="see-table see-table-each" >
               <th>S.No</th>
               <th>Email</th>
               <th>Mobile</th>
               <th>Date</th>
               <th>View More</th>
               <th>Download Lead</th>
               <th>Transfer Lead</th>
               <th>transfered</th>
             <?php
			 	$sno = 1;
			 	$show_agent = $db->prepare("SELECT * FROM leads ORDER BY leads_id DESC");
				$show_agent->execute();
				$rows = $show_agent->fetchAll();
				if(count($rows)){
					foreach($rows as $row){
			 ?>  
                <tr>
                	<td><?php echo $sno++; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['mobile']; ?></td>
                    <td><?php echo date('d-M-Y',strtotime($row['lead_date'])); ?></td>
                    
                    <td><a href="leads.php?more=<?php echo $row['leads_id']; ?>">More</a></td>
                    <td><a href="download_pdf.php?compid=<?php echo $row['leads_id']; ?>">Download</a></td>
                    <th><a href="#" class="trf_btn" onClick="addactivity()">Transfer</a> 
                    <a class="trf_btn" style="background:#14980A; opacity:1;">Transfered</a></th>
                    <th><span class="confirm" style="background:#14980A;">Confirm</span> <span class="confirm">Not Confirm</span></th>
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
            <br><br><br><br>
        
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
