<?php
//error_reporting(0);
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
			 if(isset($_GET['luniq'])){
				 $luniq = $_GET['luniq'];
				 $leadedetail = $db->prepare("SELECT * FROM leads WHERE lead_uniq=:luniq");
				 $leadedetail->bindParam(':luniq',$luniq);
				 $leadedetail->execute();
				 $rows = $leadedetail->fetchAll();
				 if(count($rows)){
					 foreach($rows as $row){
						 $lid = $row['leads_id'];
							$getstatus = $db->prepare("SELECT confirm_status,transfer_date,transfer_desc FROM lead_transfer WHERE traf_agid=:agid AND traf_leadid=:lid");
							$getstatus->bindParam(':agid',$agid);
						 	$getstatus->bindParam(':lid',$lid);
						 	$getstatus->execute();
							$tll = $getstatus->fetch();
							
						 $update_lead = $db->prepare("UPDATE lead_transfer SET notification='1' WHERE traf_agid=:agid AND traf_leadid=:lid");
						 $update_lead->bindParam(':agid',$agid);
						 $update_lead->bindParam(':lid',$lid);
						 $update_lead->execute();
						 
					/*	 if(isset(,$_POST['givstat'])){
							 $stats = $_POST['stats'];
							 $sdte = $_POST['stdte'];	 
							 $update_date = $db->prepare("UPDATE lead_transfer SET confirm_status=:stats, lstart_date=:sdte WHERE traf_agid=:agid AND traf_leadid=:lid");
							 $update_date->bindParam(':stats',$stats);
							 $update_date->bindParam(':sdte',$sdte);
							 $update_date->bindParam(':agid',$agid);
							 $update_date->bindParam(':lid',$lid);
							 $update_date->execute();
						 }*/
						 
						if(isset($_GET['delq'])){
							$delid = $_GET['delq'];
							$delete_quted = $db->prepare("DELETE FROM agent_quotation WHERE quotation_id=:delid");	
							$delete_quted->bindParam(':delid',$delid);
							$delete_quted->execute();
							if(isset($delete_quted)){
								echo "<script>location.assign('".$url."requested_trips/agent/".$luniq."')</script>";	
							}
						}
						 
?>
<!DOCTYPE html>
<html lang="en-IN">
<head>
    <?php echo headdata(); ?>
    <link rel="canonical" href=""/>
    <link rel='shortlink' href=""/>
	<title>Welcome <?php echo $recname; ?></title>
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
    <link href="<?php echo $url; ?>agent/css/see.css" type="text/css" rel="stylesheet"/>
	<link href="<?php echo $url; ?>agent/css/responsive-manage.css" type="text/css" rel="stylesheet"/>
	<link href="<?php echo $url; ?>agent/css/index.css" type="text/css" rel="stylesheet"/>
    <link href="<?php echo $url; ?>agent/css/styleplus.css" type="text/css" rel="stylesheet"/>
    <link href="<?php echo $url; ?>agent/css/style_manage.css" type="text/css" rel="stylesheet" />
    <link href="http://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
	<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script>
		$(document).ready(function() {
			$(function(){
				$( "#select-from" ).datepicker({
					minDate: 'dateToday',
					dateFormat: 'yy-m-d', 
					onSelect: function(selected){ 
					$("#select-till").datepicker("option","minDate",selected);
				 }
					});
			 });
			 
			 $(function() {
				$( "#select-till" ).datepicker({
					dateFormat: 'yy-m-d',
					onSelect: function(selected){
						$("#select-from").datepicker("option","maxDate",selected);
				 }
						 
					});
			 });
		});
    </script>
    <script>
		function ckdelq(){
			return confirm('Are You Sure');	
		}
    </script>
    
    
</head>
<body>
<div class="see-section wrapper_mg">

<div class="see-section main_dv main_dv2">
    
    <div class="col-md-12 p0 rightsidebar side_header2">
        <?php include('rightheader.php');?>
        
        <div class="col-md-12 rightsidebar_top2">
        
        </div>
        <div class="section">
            <div class="col-md-3">
            	<div class="triptt">
                	<p>
                    	<img src="<?php echo $url; ?>agent/images/user.png" alt=""/>
                        <span>TT Advisior : <?php echo $recname; ?></span><br>
                       
                    </p>
                </div>
                <div class="fulldv trip_id">
					<?php if($tll['confirm_status']=='0'){ ?>
                    	<p><span class="active">Active</span> Lead Id <?php echo $luniq; ?></p>
                    <?php } elseif($tll['confirm_status']=='1'){ ?>
                    	<p><span class="hot">Hot</span> Lead Id <?php echo $luniq; ?></p>
                    <?php } elseif($tll['confirm_status']=='2'){ ?>
                    	<p><span class="progresss">In Progress</span> Lead Id <?php echo $luniq; ?></p>
                    <?php } elseif($tll['confirm_status']=='3'){ ?>
                    	<p><span class="progresss">Converted</span> Lead Id <?php echo $luniq; ?></p>
                    <?php } elseif($tll['confirm_status']=='4'){ ?>
                    	<p><span class="progresss">Won't Book With Me</span> Lead Id <?php echo $luniq; ?></p>
                    <?php } elseif($tll['confirm_status']=='5'){ ?>
                    	<p><span class="progresss">Not Reachable</span> Lead Id <?php echo $luniq; ?></p>
                    <?php } ?>
                
                    
                    <!--<h4>2 agents working on this trip</h4>-->
                </div>
              <!--<div class="fulldv worth">
               	<p><i class="fa fa-eye"></i>Quate worth Rs. 19,900 seen 2 days ago</p>
                </div>-->
                <!--<div class="fulldv worth">
                	<p><i class="fa fa-refresh"></i><span style="color:#CB0003;"><em>Follow Up Required</em></span> <br>3 days ago</p>
                </div>-->
                <div class="fulldv traverler_detail">
                	<h4>Traveler Detail</h4>
                    <img src="<?php echo $url; ?>agent/images/user.png" alt=""/>
                    <p><i class="fa fa-phone"></i><?php echo $row['mobile']; ?></p>
                    <p><i class="fa fa-envelope"></i><?php echo $row['email']; ?></p>
                    <p><i class="fa fa-map-marker"></i><?php echo $row['destination_from']; ?></p>
                </div>
                
                <!--<div class="fulldv above">
                	<h4>Is the above information useful?</h4>
                    <input type="radio"> <span>Yes</span>
                    <input type="radio"> <span>No</span>
                </div>-->
                <div class="fulldv notes_dv">
                	<h3>Notes</h3>
                    <div class="fulldv reminder">
                   	  	<h4>Select icons to Add Note & Set Reminder</h4>
                        <ul>
                        	<li onClick="reachable()">
                            	<img src="<?php echo $url;?>/agent/images/no-phone.png" alt=""/> <br>
                                <p>Not <br> Reachable</p>
                            </li>
                            <li onClick="withme()">
                            	<img src="<?php echo $url;?>/agent/images/dislike.png" alt=""/> <br>
                                <p>Won't book <br> with me</p>
                            </li>
                            <li onClick="talkinprogress()">
                            	<img src="<?php echo $url;?>/agent/images/speaker.png" alt=""/> <br>
                                <p>Talk in <br> progress</p>
                            </li>
                            <li onClick="finalizingsoon()">
                            	<img src="<?php echo $url;?>/agent/images/like.png" alt=""/> <br>
                                <p>Finalizing <br> soon</p>
                            </li>
                            <li onClick="convertedlead()">
                            	<img src="<?php echo $url;?>/agent/images/like.png" alt=""/> <br>
                                <p>Converted <br> Lead</p>
                            </li>
                        </ul>
                    </div>
                    <div class="fulldv tt_admin">
                    	<ul>
                        	<li>
                            	<img src="<?php echo $url;?>/agent/images/user.png" alt=""/>
                                <p style="color:#0979D5;">TT Admin</p>
                                <p><?php echo $tll['transfer_desc']; ?></p>
                                <p><?php echo date('d-M-Y', strtotime($tll['transfer_date'])); ?></p>
                            </li>
                          <?php if($row['user_comment']!=''){ ?>  
                            <li>
                            	<img src="<?php echo $url;?>/agent/images/user.png" alt=""/>
                                <p style="color:#0979D5;">TT User</p>
                                <p><?php echo $row['user_comment']; ?></p>
                                <p><?php echo date('d-M-Y', strtotime($row['lead_date'])); ?></p>
                            </li>
                          <?php } ?>  
                       </ul>
                    </div>
                    
                    <!--<div class="fulldv reply_dv">
                    	<h4>Reply</h4>
                        <form action="" method="post">
                             <div class="fulldv">
                                <input type="radio" name="stats" value="0" required><span>Active</span>
                                <input type="radio" name="stats" value="1" required><span>Hot</span>
                                <input type="radio" name="stats" value="2" required><span>Progress</span>
                                <input type="radio" name="stats" value="3" required><span>Other</span>
                             </div>   
                             <div class="fulldv">
                                <input type="text" name="stdte" id="datepicker" autocomplete="off" required/>
                                <input type="submit" name="givstat" value="Submit">
                             </div>
                        </form>
                    </div>-->
                </div>
                
            </div>
            <div class="col-md-9">
                <div class="fulldv">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingOne">
                                 <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                      Traveler requirement
                                    </a>
                                 </h4>
                    
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <div class="fulldv basic_detail">
                                                <table class="see-table">
                                                    <tr>
                                                        <td>
                                                            <p>Duration</p>
                                                            <p><?php echo $row['departure_day']; ?> Days</p>
                                                        </td>
                                                        <td>
                                                            <p>Starting Date</p>
                                                            <p><?php echo date('d-M-Y',strtotime($row['departure_date'])); ?></p>
                                                        </td>
                                                        <td>
                                                            <p>Budget without Flight</p>
                                                            <p> <i class="fa fa-rupee"></i> <?php echo $row['budget_withoutair']; ?></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p>No. of Travelers</p>
                                                            <p><?php echo $row['adult']; ?> Adults <?php echo $row['children']; ?> Children</p>
                                                        </td>
                                                        <td>
                                                            <p>Destination</p>
                                                            <p><?php echo $row['destination_to']; ?></p>
                                                        </td>
                                                    </tr>
                                                    <!--<tr>
                                                        <td colspan="3">
                                                            <p>Hotel Details</p>
                                                            <p>Night 1,2,3, Golden Apple ResortManali, Manali, Super Deluxe ,02 Room For 04 Adults</p>
                                                        </td>
                                                    </tr>-->
                                                    <tr>
                                                        <td colspan="3">
                                                            <p>From</p>
                                                            <p><?php echo $row['destination_from']; ?></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3">
                                                            <p>Trip Stage </p>
                                                            <p>Flight-Train already booked, just need remaining package</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3">
                                                            <p>I will Book </p>
                                                            <p><?php echo $row['book_type']; ?></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3">
                                                            <h4><i class="fa fa-eye"></i> &nbsp; Looking for</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p>Hotel Accommodation</p>
                                                        <?php if($row['hotel_first']!='' || $row['hotel_second']!='' || $row['hotel_third']!='' || $row['hotel_four']!='' || $row['hotel_five']!=''){ ?>   
                                                            <p>Yes</p>
                                                        <?php } else{ ?>
                                                            <p>No</p>
                                                        <?php } ?>    
                                                        </td>
                                                        <td>
                                                            <p>Hotel Category</p>
                                                            <p><?php echo $row['hotel_first'] . $row['hotel_second'] . $row['hotel_third'] . $row['hotel_four'] . $row['hotel_five']; ?> Star </p>
                                                        </td>
                                                        <td>
                                                            <p>Need Flight / Train</p>
                                                            <p><?php echo $row['flight']; ?> </p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p>Cab for Local Sight Seeing </p>
                                                            <p><?php echo $row['cab_facility']; ?></p>
                                                        </td>
                                                        <!--<td>
                                                            <p>Transport from home city?</p>
                                                            <p>No</p>
                                                        </td>
                                                        <td>
                                                            <p>Maximum Budget</p>
                                                            <p>15250</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3">
                                                            <p>Minimum Budget</p>
                                                            <p>15250</p>
                                                        </td>-->
                                                    </tr>
                                                </table>
                                            </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingTwo">
                                 <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                              Quotations
                            </a>
                            <a href="<?php echo $url; ?>agent/new_quotes/<?php echo $luniq; ?>" class="givecot"> Give new quotation</a>
                          </h4>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="panel-body">
                               <ul class="nav nav-tabs quotations_tab">
                                <?php
							   		$heading_quotation = $db->prepare("SELECT * FROM agent_quotation WHERE qlead_id=:lid AND qag_id=:agid ORDER BY quotation_id DESC LIMIT 0,1");
									$heading_quotation->bindParam(':lid',$lid);
									$heading_quotation->bindParam(':agid',$agid);
									$heading_quotation->execute();
									$allheads = $heading_quotation->fetchAll();
									foreach($allheads as $aheds){
										$qid = $aheds['quotation_id'];
								?>
                                    <li class="active">
                                        <a data-toggle="tab" href="#quotations<?php echo $qid; ?>"><i class="fa fa-rupee"></i> <?php echo $aheds['total_cost']; ?> Total 
                                            <p>Updated : <?php echo date('d-M-Y',strtotime($aheds['quotation_date'])); ?> <span>Active</span></p>
                                        </a>
                                    </li>
                                <?php } 
							   		$heading_quotation1 = $db->prepare("SELECT * FROM agent_quotation WHERE qlead_id=:lid AND qag_id=:agid ORDER BY quotation_id DESC LIMIT 1,100");
									$heading_quotation1->bindParam(':lid',$lid);
									$heading_quotation1->bindParam(':agid',$agid);
									$heading_quotation1->execute();
									$allheads1 = $heading_quotation1->fetchAll();
									foreach($allheads1 as $aheds1){
										$qid1 = $aheds1['quotation_id'];
								?>
                                <li>
                                        <a data-toggle="tab" href="#quotations<?php echo $qid1; ?>"><i class="fa fa-rupee"></i> <?php echo $aheds1['total_cost']; ?> Total 
                                            <p>Updated : <?php echo date('d-M-Y',strtotime($aheds1['quotation_date'])); ?> <span>Active</span></p>
                                        </a>
                                    </li>  
                               <?php } ?>       
                                </ul>
                                  <div class="tab-content">
                                  <?php
							   		$first_quotation = $db->prepare("SELECT * FROM agent_quotation WHERE qlead_id=:lid AND qag_id=:agid ORDER BY quotation_id DESC LIMIT 0,1");
									$first_quotation->bindParam(':lid',$lid);
									$first_quotation->bindParam(':agid',$agid);
									$first_quotation->execute();
									$allqtt = $first_quotation->fetchAll();
									foreach($allqtt as $allqt){
										$qtid = $allqt['quotation_id'];
								  ?>
                                        <div id="quotations<?php echo $qtid; ?>" class="tab-pane fade in active">
                                            <div class="fulldv invoice_dv">
                                                <ul>
                                                    <li><a href="#"><i class="fa fa-file-o"></i> <br> Create Invoice</a></li>
                                                    <li><a href="#"><i class="fa fa-download"></i> <br> Download Quote</a></li>
                                                    <li><a href="#"><i class="fa fa-pencil"></i> <br> Edit Quote</a></li>
                                                    <li><a href="<?php echo $url; ?>agent/requested_trips.php?luniq=<?php echo $luniq; ?>&delq=<?php echo $qtid; ?>" onClick="return ckdelq();"><i class="fa fa-trash"></i> <br> Delete Quote</a></li>
                                                </ul>
                                            </div>
                                            <div class="fulldv basic_detail">
                                                <table class="see-table">
                                                    <tr>
                                                        <td>
                                                            <p>Trip Type</p>
                                                            <p>NA</p>
                                                        </td>
                                                        <td>
                                                            <p>Days</p>
                                                            <p><?php echo $allqt['day']; ?> days</p>
                                                        </td>
                                                        <td>
                                                            <p>Nights</p>
                                                            <p><?php echo $allqt['night']; ?> nights</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p>Quotation Price </p>
                                                            <p><i class="fa fa-rupee"></i>  <?php echo $allqt['total_cost']; ?> </p>
                                                        </td>
                                                        <td>
                                                            <p>Destination</p>
                                                            <p><?php echo $row['destination_to']; ?></p>
                                                        </td>
                                                        <td>
                                                            <p>No. of Adults & children </p>
                                                            <p><?php echo $row['adult']; ?> Adults & <?php echo $row['children']; ?> Children</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3">
                                                            <p>Hotel Details</p>
                                                            <p><?php echo $allqt['hotel_name']; ?></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3">
                                                            <p>Flight Details</p>
                                                            <p><?php echo $allqt['flight_detail']; ?></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3">
                                                            <p>Cab Details</p>
                                                            <p><?php echo $allqt['cab_detail']; ?></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3">
                                                            <p>Inclusions</p>
                                                        <?php if($allqt['hotel_accomd']!=''){ ?>    
                                                            <p>Accomodation : Hotel (3 Star with Verified Properties) </p>
                                                        <?php } if($allqt['breakfast']='yes'){ ?>    
                                                            <p>Meal plan : Breakfast </p>
                                                        <?php } if($allqt['dinner']=='yes'){ ?>        
                                                            <p>Meal plan : Dinner </p>
                                                        <?php } if($allqt['arrival_drink']=='yes'){ ?> 
                                                            <p>Meal plan : Welcome Drink on Arrival </p>
                                                        <?php } if($allqt['arrival_airport']=='yes'){ ?>    
                                                            <p>Transport : Arrival - Airport Transfer </p>
                                                        <?php } if($allqt['dept_airport']=='yes'){ ?>    
                                                            <p>Transport : Departure - Airport Transfer </p>
                                                        <?php } if($allqt['cab_transport']=='yes'){ ?>        
                                                            <p>Transport : Cab for Transport (Sedan Pvt Cab) </p>
                                                        <?php } if($allqt['local_seen']=='yes'){ ?>    
                                                            <p>Sightseeing : Local Sightseeing (As per the itinerary with verified Driver) </p>
                                                        <?php } if($allqt['cab_sightseen']=='yes'){ ?>        
                                                            <p>Sightseeing : Cab for sightseeing </p>
                                                        <?php } if($allqt['govt_tax']=='yes'){ ?>           
                                                            <p>Government Taxes/VAT/ Service Charges</p>
                                                        <?php } ?>
                                                        </td>
                                                    </tr>
                                                 <?php if($allqt['first_day']!=''){ ?>
                                                    <tr>
                                                        <td colspan="3">
                                                            <p>Day 1 : <?php // echo $allqt['first_day']; ?></p>
                                                            <p><?php echo $allqt['first_day']; ?></p>
                                                        </td>
                                                    </tr>
                                                <?php } elseif($allqt['first_night']!=''){ ?>    
                                                    <tr>
                                                        <td colspan="3">
                                                            <p>Night 1 : <?php // echo $allqt['second_day']; ?></p>
                                                            <p><?php echo $allqt['first_night']; ?></p>
                                                        </td>
                                                    </tr>
                                                <?php } elseif($allqt['second_day']!=''){ ?>    
                                                	<tr>
                                                        <td colspan="3">
                                                            <p>Night 1 : <?php // echo $allqt['second_day']; ?></p>
                                                            <p><?php echo $allqt['second_day']; ?></p>
                                                        </td>
                                                    </tr>
                                                
                                                <?php } elseif($allqt['second_night']!=''){ ?>    
                                                	<tr>
                                                        <td colspan="3">
                                                            <p>Night 1 : <?php // echo $allqt['second_day']; ?></p>
                                                            <p><?php echo $allqt['second_night']; ?></p>
                                                        </td>
                                                    </tr>
                                                
                                                <?php } elseif($allqt['third_day']!=''){ ?>    
                                                	<tr>
                                                        <td colspan="3">
                                                            <p>Night 1 : <?php // echo $allqt['second_day']; ?></p>
                                                            <p><?php echo $allqt['third_day']; ?></p>
                                                        </td>
                                                    </tr>
                                                <?php } elseif($allqt['third_night']!=''){ ?>    
                                                	<tr>
                                                        <td colspan="3">
                                                            <p>Night 1 : <?php // echo $allqt['second_day']; ?></p>
                                                            <p><?php echo $allqt['third_night']; ?></p>
                                                        </td>
                                                    </tr>
                                                
                                                <?php } elseif($allqt['four_day']!=''){ ?>    
                                                	<tr>
                                                        <td colspan="3">
                                                            <p>Night 1 : <?php // echo $allqt['second_day']; ?></p>
                                                            <p><?php echo $allqt['four_day']; ?></p>
                                                        </td>
                                                    </tr>
                                                
                                                <?php } elseif($allqt['four_night']!=''){ ?>    
                                                	<tr>
                                                        <td colspan="3">
                                                            <p>Night 1 : <?php // echo $allqt['second_day']; ?></p>
                                                            <p><?php echo $allqt['four_night']; ?></p>
                                                        </td>
                                                    </tr>
                                                
                                                <?php } elseif($allqt['fifth_day']!=''){ ?>    
                                                	<tr>
                                                        <td colspan="3">
                                                            <p>Night 1 : <?php // echo $allqt['second_day']; ?></p>
                                                            <p><?php echo $allqt['fifth_day']; ?></p>
                                                        </td>
                                                    </tr>
                                                
                                                <?php } elseif($allqt['fifth_night']!=''){ ?>    
                                                	<tr>
                                                        <td colspan="3">
                                                            <p>Night 1 : <?php // echo $allqt['second_day']; ?></p>
                                                            <p><?php echo $allqt['fifth_night']; ?></p>
                                                        </td>
                                                    </tr>
                                                
                                                <?php } elseif($allqt['six_day']!=''){ ?>    
                                                	<tr>
                                                        <td colspan="3">
                                                            <p>Night 1 : <?php // echo $allqt['second_day']; ?></p>
                                                            <p><?php echo $allqt['six_day']; ?></p>
                                                        </td>
                                                    </tr>
                                                
                                                <?php } elseif($allqt['six_night']!=''){ ?>    
                                                	<tr>
                                                        <td colspan="3">
                                                            <p>Night 1 : <?php // echo $allqt['second_day']; ?></p>
                                                            <p><?php echo $allqt['six_night']; ?></p>
                                                        </td>
                                                    </tr>
                                                
                                                <?php } elseif($allqt['seven_day']!=''){ ?>    
                                                	<tr>
                                                        <td colspan="3">
                                                            <p>Night 1 : <?php // echo $allqt['second_day']; ?></p>
                                                            <p><?php echo $allqt['seven_day']; ?></p>
                                                        </td>
                                                    </tr>
                                                
                                                <?php } ?>
                                               </table>
                                            </div>
                                        </div>
                                        
                                <?php } 
								?>   
                                <?php
							   		$first_quotation1 = $db->prepare("SELECT * FROM agent_quotation WHERE qlead_id=:lid AND qag_id=:agid ORDER BY quotation_id DESC LIMIT 1,100");
									$first_quotation1->bindParam(':lid',$lid);
									$first_quotation1->bindParam(':agid',$agid);
									$first_quotation1->execute();
									$allqtt1 = $first_quotation1->fetchAll();
									foreach($allqtt1 as $allqt1){
										$qtid1 = $allqt1['quotation_id'];
								 ?>     
                                        <div id="quotations<?php echo $qtid1; ?>" class="tab-pane fade">
                                            <div class="fulldv invoice_dv">
                                                <ul>
                                                    <li><a href="#"><i class="fa fa-file-o"></i> <br> Create Invoice</a></li>
                                                    <li><a href="#"><i class="fa fa-download"></i> <br> Download Quote</a></li>
                                                    <li><a href="#"><i class="fa fa-pencil"></i> <br> Edit Quote</a></li>
                                                    <li><a href="<?php echo $url; ?>agent/requested_trips.php?luniq=<?php echo $luniq; ?>&delq=<?php echo $qtid1; ?>"><i class="fa fa-trash"></i> <br> Delete Quote</a></li>
                                                </ul>
                                            </div>
                                            
                                            <div class="fulldv basic_detail">
                                                <table class="see-table">
                                                    <tr>
                                                        <td>
                                                            <p>Trip Type</p>
                                                            <p>NA</p>
                                                        </td>
                                                        <td>
                                                            <p>Days</p>
                                                            <p><?php echo $allqt1['day']; ?> days</p>
                                                        </td>
                                                        <td>
                                                            <p>Nights</p>
                                                            <p><?php echo $allqt1['night']; ?> nights</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p>Quotation Price </p>
                                                            <p><i class="fa fa-rupee"></i>  <?php echo $allqt1['total_cost']; ?> </p>
                                                        </td>
                                                        <td>
                                                            <p>Destination</p>
                                                            <p><?php echo $row['destination_to']; ?></p>
                                                        </td>
                                                        <td>
                                                            <p>No. of Adults & children </p>
                                                            <p><?php echo $row['adult']; ?> Adults & <?php echo $row['children']; ?> Children</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3">
                                                            <p>Hotel Details</p>
                                                            <p><?php echo $allqt1['hotel_name']; ?></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3">
                                                            <p>Flight Details</p>
                                                            <p><?php echo $allqt1['flight_detail']; ?></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3">
                                                            <p>Cab Details</p>
                                                            <p><?php echo $allqt1['cab_detail']; ?></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3">
                                                            <p>Inclusions</p>
                                                        <?php if($allqt1['hotel_accomd']!=''){ ?>    
                                                            <p>Accomodation : Hotel (3 Star with Verified Properties) </p>
                                                        <?php } if($allqt1['breakfast']=='yes'){ ?>    
                                                            <p>Meal plan : Breakfast </p>
                                                        <?php } if($allqt1['dinner']=='yes'){ ?>        
                                                            <p>Meal plan : Dinner </p>
                                                        <?php } if($allqt1['arrival_drink']=='yes'){ ?> 
                                                            <p>Meal plan : Welcome Drink on Arrival </p>
                                                        <?php } if($allqt1['arrival_airport']=='yes'){ ?>    
                                                            <p>Transport : Arrival - Airport Transfer </p>
                                                        <?php } if($allqt1['dept_airport']=='yes'){ ?>    
                                                            <p>Transport : Departure - Airport Transfer </p>
                                                        <?php } if($allqt1['cab_transport']=='yes'){ ?>        
                                                            <p>Transport : Cab for Transport (Sedan Pvt Cab) </p>
                                                        <?php } if($allqt1['local_seen']=='yes'){ ?>    
                                                            <p>Sightseeing : Local Sightseeing (As per the itinerary with verified Driver) </p>
                                                        <?php } if($allqt1['cab_sightseen']=='yes'){ ?>        
                                                            <p>Sightseeing : Cab for sightseeing </p>
                                                        <?php } if($allqt1['govt_tax']=='yes'){ ?>           
                                                            <p>Government Taxes/VAT/ Service Charges</p>
                                                        <?php } ?>    
                                                        </td>
                                                    </tr>
                                                    
                                                    <?php if($allqt1['first_day']!=''){ ?>
                                                    <tr>
                                                        <td colspan="3">
                                                            <p>Day 1 : <?php // echo $allqt['first_day']; ?></p>
                                                            <p><?php echo $allqt1['first_day']; ?></p>
                                                        </td>
                                                    </tr>
                                                <?php } elseif($allqt1['first_night']!=''){ ?>    
                                                    <tr>
                                                        <td colspan="3">
                                                            <p>Night 1 : <?php // echo $allqt['second_day']; ?></p>
                                                            <p><?php echo $allqt1['first_night']; ?></p>
                                                        </td>
                                                    </tr>
                                                <?php } elseif($allqt1['second_day']!=''){ ?>    
                                                	<tr>
                                                        <td colspan="3">
                                                            <p>Day 2 : <?php // echo $allqt['second_day']; ?></p>
                                                            <p><?php echo $allqt1['second_day']; ?></p>
                                                        </td>
                                                    </tr>
                                                
                                                <?php } elseif($allqt1['second_night']!=''){ ?>    
                                                	<tr>
                                                        <td colspan="3">
                                                            <p>Night 2 : <?php // echo $allqt['second_day']; ?></p>
                                                            <p><?php echo $allqt1['second_night']; ?></p>
                                                        </td>
                                                    </tr>
                                                
                                                <?php } elseif($allqt1['third_day']!=''){ ?>    
                                                	<tr>
                                                        <td colspan="3">
                                                            <p>Day 3 : <?php // echo $allqt['second_day']; ?></p>
                                                            <p><?php echo $allqt1['third_day']; ?></p>
                                                        </td>
                                                    </tr>
                                                <?php } elseif($allqt1['third_night']!=''){ ?>    
                                                	<tr>
                                                        <td colspan="3">
                                                            <p>Night 3 : <?php // echo $allqt['second_day']; ?></p>
                                                            <p><?php echo $allqt1['third_night']; ?></p>
                                                        </td>
                                                    </tr>
                                                
                                                <?php } elseif($allqt1['four_day']!=''){ ?>    
                                                	<tr>
                                                        <td colspan="3">
                                                            <p>Day 4 : <?php // echo $allqt['second_day']; ?></p>
                                                            <p><?php echo $allqt1['four_day']; ?></p>
                                                        </td>
                                                    </tr>
                                                
                                                <?php } elseif($allqt1['four_night']!=''){ ?>    
                                                	<tr>
                                                        <td colspan="3">
                                                            <p>Night 4 : <?php // echo $allqt['second_day']; ?></p>
                                                            <p><?php echo $allqt1['four_night']; ?></p>
                                                        </td>
                                                    </tr>
                                                
                                                <?php } elseif($allqt1['fifth_day']!=''){ ?>    
                                                	<tr>
                                                        <td colspan="3">
                                                            <p>Day 5 : <?php // echo $allqt['second_day']; ?></p>
                                                            <p><?php echo $allqt1['fifth_day']; ?></p>
                                                        </td>
                                                    </tr>
                                                
                                                <?php } elseif($allqt1['fifth_night']!=''){ ?>    
                                                	<tr>
                                                        <td colspan="3">
                                                            <p>Night 5 : <?php // echo $allqt['second_day']; ?></p>
                                                            <p><?php echo $allqt1['fifth_night']; ?></p>
                                                        </td>
                                                    </tr>
                                                
                                                <?php } elseif($allqt1['six_day']!=''){ ?>    
                                                	<tr>
                                                        <td colspan="3">
                                                            <p>Day 6 : <?php // echo $allqt['second_day']; ?></p>
                                                            <p><?php echo $allqt1['six_day']; ?></p>
                                                        </td>
                                                    </tr>
                                                
                                                <?php } elseif($allqt1['six_night']!=''){ ?>    
                                                	<tr>
                                                        <td colspan="3">
                                                            <p>Night 6 : <?php // echo $allqt['second_day']; ?></p>
                                                            <p><?php echo $allqt['six_night']; ?></p>
                                                        </td>
                                                    </tr>
                                                
                                                <?php } elseif($allqt1['seven_day']!=''){ ?>    
                                                	<tr>
                                                        <td colspan="3">
                                                            <p>Day 7 : <?php // echo $allqt['second_day']; ?></p>
                                                            <p><?php echo $allqt1['seven_day']; ?></p>
                                                        </td>
                                                    </tr>
                                                
                                                <?php } ?>
                                               </table>
                                            </div>
                                        </div>
                                   <?php } ?>     
                                     <!--   <div id="quotations3" class="tab-pane fade">
                                            <div class="fulldv invoice_dv">
                                                <ul>
                                                    <li><a href="#"><i class="fa fa-file-o"></i> <br> Create Invoice</a></li>
                                                    <li><a href="#"><i class="fa fa-download"></i> <br> Download Quote</a></li>
                                                    <li><a href="#"><i class="fa fa-pencil"></i> <br> Edit Quote</a></li>
                                                    <li><a href="#"><i class="fa fa-trash"></i> <br> Delete Quote</a></li>
                                                </ul>
                                            </div>
                                            <div class="fulldv basic_detail">
                                                <table class="see-table">
                                                    <tr>
                                                        <td>
                                                            <p>Trip Type</p>
                                                            <p>NA</p>
                                                        </td>
                                                        <td>
                                                            <p>Days</p>
                                                            <p><?php echo $allqt2['day']; ?> days</p>
                                                        </td>
                                                        <td>
                                                            <p>Nights</p>
                                                            <p><?php echo $allqt2['night']; ?> nights</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p>Quotation Price </p>
                                                            <p><i class="fa fa-rupee"></i>  <?php echo $allqt2['total_cost']; ?> </p>
                                                        </td>
                                                        <td>
                                                            <p>Destination</p>
                                                            <p><?php echo $row['destination_to']; ?></p>
                                                        </td>
                                                        <td>
                                                            <p>No. of Adults & children </p>
                                                            <p><?php echo $row['adult']; ?> Adults & <?php echo $row['children']; ?> Children</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3">
                                                            <p>Hotel Details</p>
                                                            <p><?php echo $allqt2['hotel_name']; ?></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3">
                                                            <p>Flight Details</p>
                                                            <p><?php echo $allqt2['flight_detail']; ?></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3">
                                                            <p>Cab Details</p>
                                                            <p><?php echo $allqt2['cab_detail']; ?></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3">
                                                            <p>Inclusions</p>
                                                            <p>Accomodation : Hotel (3 Star with Verified Properties) </p>
                                                            <p>Meal plan : Breakfast </p>
                                                            <p>Meal plan : Dinner </p>
                                                            <p>Meal plan : Welcome Drink on Arrival </p>
                                                            <p>Transport : Arrival - Airport Transfer </p>
                                                            <p>Transport : Departure - Airport Transfer </p>
                                                            <p>Transport : Cab for Transport (Sedan Pvt Cab) </p>
                                                            <p>Sightseeing : Local Sightseeing (As per the itinerary with verified Driver) </p>
                                                            <p>Sightseeing : Cab for sightseeing </p>
                                                            <p>Government Taxes/VAT/ Service Charges</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3">
                                                            <p>Day 1 : <?php echo $allqt2['first_day']; ?></p>
                                                            <p><?php echo $allqt2['first_desc']; ?></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3">
                                                            <p>Day 2 : <?php echo $allqt2['second_day']; ?></p>
                                                            <p><?php echo $allqt2['second_desc']; ?></p>
                                                        </td>
                                                    </tr>
                                               </table>
                                            </div>
                                        </div>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
	 if(isset($_POST['notrechble'])){
		 $rmndr = $_POST['remind']; 
		 $aqute = $_POST['yr_note'];
		 $strmdr = $_POST['remndr'];
		 $add_query = $db->prepare("INSERT INTO agent_note(agnt_id,nld_id,not_reachable,agent_quote,reminder,note_date)VALUES(:agid, :lid, :rmndr, :aqute, :strmdr, :date)");
		 $add_query->bindParam(':agid',$agid);
		 $add_query->bindParam(':lid',$lid);
		 $add_query->bindParam(':rmndr',$rmndr);
		 $add_query->bindParam(':aqute',$aqute);
		 $add_query->bindParam(':strmdr',$strmdr);
		 $add_query->bindParam(':date',$date);
		 $add_query->execute();
		 if(isset($add_query)){ 
		 	 $update_date = $db->prepare("UPDATE lead_transfer SET confirm_status='5', lstart_date=:date WHERE traf_agid=:agid AND traf_leadid=:lid");
			 $update_date->bindParam(':date',$date);
			 $update_date->bindParam(':agid',$agid);
			 $update_date->bindParam(':lid',$lid);
			 $update_date->execute();
		 		echo "<script>alert('Submitted')</script>"; 
		} 
	 }
?>	 
<!-- Not Reachable Popup -->
<div class="overlaydv inclusions_form_dv_pop" id="remindpop">	
    <div class="overlaydv-in">
    	<div class="overlaydv-inner">
        	<div class="inclusions_form_dv requested">
                <h4>Add Note - TRIP ID <?php echo $luniq; ?></h4>
             <form method="post">   
                <ul>
                	<li><img src="<?php echo $url; ?>agent/images/no-phone.png" alt=""/> Traveler not reachable</li>
                    <li><p><input type="radio" name="remind" value="Phone number doesn't work" onclick="show2();" required/> Phone number doesn't work </p></li>
                    <li>
                    	<p><input type="radio" name="remind" value="Couldn't talk to traveler this time, try again later" onclick="show2();" required> Couldn't talk to traveler this time, try again later </p>
                    </li>
                    <li>
                    	<p><input type="radio" name="remind" value="Tried enough, leave the lead" onclick="show1();" required/> Tried enough, leave the lead </p>
                    </li>
                </ul>
                <p>Your Note</p>
                <textarea name="yr_note" id="" cols="30" rows="10" required/></textarea>
                <div class="fulldv" id="reminddv">
                <p>Set Reminder</p>
                <input type="text" name="remndr" autocomplete="off" />
                </div>
                <div class="fulldv">
                	<input type="submit" name="notrechble" value="add note" name="">
                    <a onClick="clickhere_close()">Cancel</a>
                </div>
             </form>   
            </div>
        </div>
    </div>  
</div>
<?php 
	 if(isset($_POST['bkme'])){
		 $rmndr = $_POST['remind']; 
		 $aqute = $_POST['yr_note'];
		 $strmdr = $_POST['remndr'];
		 $add_query = $db->prepare("INSERT INTO agent_note(agnt_id,nld_id,wont_book,agent_quote,reminder,note_date)VALUES(:agid, :lid, :rmndr, :aqute, :strmdr, :date)");
		 $add_query->bindParam(':agid',$agid);
		 $add_query->bindParam(':lid',$lid);
		 $add_query->bindParam(':rmndr',$rmndr);
		 $add_query->bindParam(':aqute',$aqute);
		 $add_query->bindParam(':strmdr',$strmdr);
		 $add_query->bindParam(':date',$date);
		 $add_query->execute();
		 if(isset($add_query)){ 
		 	 $update_date = $db->prepare("UPDATE lead_transfer SET confirm_status='4', lstart_date=:date WHERE traf_agid=:agid AND traf_leadid=:lid");
			 $update_date->bindParam(':date',$date);
			 $update_date->bindParam(':agid',$agid);
			 $update_date->bindParam(':lid',$lid);
			 $update_date->execute();
		 		echo "<script>alert('Submitted')</script>"; 
		} 
	 }
?>

<!-- Won't book with me Popup -->
<div class="overlaydv inclusions_form_dv_pop" id="bookmepop">	
    <div class="overlaydv-in">
    	<div class="overlaydv-inner">
        	<div class="inclusions_form_dv requested">
                <h4>Add Note - TRIP ID <?php echo $luniq; ?></h4>
               <form method="post"> 
                <ul>
                	<li><img src="<?php echo $url; ?>agent/images/dislike.png" alt=""/> Won't book with me</li>
                    <li><p><input type="radio" name="remind" value="Traveler is not sure about the plan/cancelled plan" onclick="show4();"> Traveler is not sure about the plan/cancelled plan </p></li>
                    <li>
                    	<p><input type="radio" name="remind" value="Traveler booked with someone else" onclick="show3();"> Traveler booked with someone else  </p>
                    </li>
                </ul>
                <p>Your Note</p>
                <textarea name="yr_note" id="" cols="30" rows="10" required/></textarea>
                <div class="fulldv" id="bookme">
                <p>Set Reminder</p>
                <input type="text" name="remndr" autocomplete="off"/>
                </div>
                <div class="fulldv">
                	<input type="submit" name="bkme" value="add note" name="">
                    <a onClick="clickhere_close()">Cancel</a>
                </div>
              </form>  
            </div>
        </div>
    </div>  
</div>
<?php 
	 if(isset($_POST['prgres'])){
		 $rmndr = $_POST['remind']; 
		 $aqute = $_POST['yr_note'];
		 $strmdr = $_POST['remndr'];
		 $add_query = $db->prepare("INSERT INTO agent_note(agnt_id,nld_id,talk_inprogress,agent_quote,reminder,note_date)VALUES(:agid, :lid, :rmndr, :aqute, :strmdr, :date)");
		 $add_query->bindParam(':agid',$agid);
		 $add_query->bindParam(':lid',$lid);
		 $add_query->bindParam(':rmndr',$rmndr);
		 $add_query->bindParam(':aqute',$aqute);
		 $add_query->bindParam(':strmdr',$strmdr);
		 $add_query->bindParam(':date',$date);
		 $add_query->execute();
		 if(isset($add_query)){ 
		 	 $update_date = $db->prepare("UPDATE lead_transfer SET confirm_status='2', lstart_date=:date WHERE traf_agid=:agid AND traf_leadid=:lid");
			 $update_date->bindParam(':date',$date);
			 $update_date->bindParam(':agid',$agid);
			 $update_date->bindParam(':lid',$lid);
			 $update_date->execute();
		 		echo "<script>alert('Submitted')</script>"; 
		} 
	 }
?>

<!-- Talk in progress Popup -->
<div class="overlaydv inclusions_form_dv_pop" id="progresspop">	
    <div class="overlaydv-in">
    	<div class="overlaydv-inner">
        	<div class="inclusions_form_dv requested">
                <h4>Add Note - TRIP ID <?php echo $luniq; ?></h4>
              <form method="post">
                <ul>
                	<li><img src="<?php echo $url; ?>agent/images/speaker.png" alt=""/> Talk in progress with traveler</li>
                    <li><p><input type="radio" name="remind" value="Initial stage only - Quote not seen" onclick="show6();" required/> Initial stage only - Quote not seen  </p></li>
                    <li><p><input type="radio" name="remind" value="Getting Quote/package customized " onclick="show6();" required> Getting Quote/package customized  </p></li>
                    <li>
                    	<p><input type="radio" name="remind" value="Traveler interested, but will book after few weeks" onclick="show5();" required> Traveler interested, but will book after few weeks  </p>
                    </li>
                </ul>
                <p>Your Note</p>
                <textarea name="yr_note" id="" cols="30" rows="10" required/></textarea>
                <div class="fulldv" id="progressdv">
                <p>Set Reminder</p>
                <input type="text" name="remndr" autocomplete="off"/>
                </div>
                <div class="fulldv">
                	<input type="submit" name="prgres" value="add note" name="">
                    <a onClick="clickhere_close()">Cancel</a>
                </div>
              </form>  
            </div>
        </div>
    </div>  
</div>
<?php 
	 if(isset($_POST['finlze'])){
		 $rmndr = $_POST['remind']; 
		 $aqute = $_POST['yr_note'];
		 $strmdr = $_POST['remndr'];
		 $add_query = $db->prepare("INSERT INTO agent_note(agnt_id,nld_id,traveler_finalize,agent_quote,reminder,note_date)VALUES(:agid, :lid, :rmndr, :aqute, :strmdr, :date)");
		 $add_query->bindParam(':agid',$agid);
		 $add_query->bindParam(':lid',$lid);
		 $add_query->bindParam(':rmndr',$rmndr);
		 $add_query->bindParam(':aqute',$aqute);
		 $add_query->bindParam(':strmdr',$strmdr);
		 $add_query->bindParam(':date',$date);
		 $add_query->execute();
		 if(isset($add_query)){ 
		 	 $update_date = $db->prepare("UPDATE lead_transfer SET confirm_status='1', lstart_date=:date WHERE traf_agid=:agid AND traf_leadid=:lid");
			 $update_date->bindParam(':date',$date);
			 $update_date->bindParam(':agid',$agid);
			 $update_date->bindParam(':lid',$lid);
			 $update_date->execute();
		 		echo "<script>alert('Submitted')</script>"; 
		} 
	 }
?>

<!-- like Popup -->
<div class="overlaydv inclusions_form_dv_pop" id="travelerpop">	
    <div class="overlaydv-in">
    	<div class="overlaydv-inner">
        	<div class="inclusions_form_dv requested">
                <h4>Add Note - TRIP ID <?php echo $luniq; ?></h4>
              <form method="post">  
                <ul>
                	<li><img src="<?php echo $url; ?>agent/images/like.png" alt=""/> Traveler will finalize and is 'My Hot'</li>
                    <li><p><input type="radio" name="remind" value="Negotiating / Will finalize in 2 to 3 days" required> Negotiating / Will finalize in 2 to 3 days  </p></li>
                    <li><p><input type="radio" name="remind" value="Invoice sent to traveler" required> Invoice sent to traveler </p></li>
                </ul>
                <p>Your Note</p>
                <textarea name="yr_note" id="" cols="30" rows="10" required/></textarea>
                <p>Set Reminder</p>
                <input type="text" name="remndr" autocomplete="off" />
                <div class="fulldv">
                	<input type="submit" name="finlze" value="add note" name="">
                    <a onClick="clickhere_close()">Cancel</a>
                </div>
              </form>  
            </div>
        </div>
    </div>  
</div>

<?php 
	 if(isset($_POST['convrted'])){
		 $sdte = $_POST['stdate']; 
		 $endate = $_POST['endate']; 
		 $aqute = $_POST['yr_note'];
		 $strmdr = $_POST['remndr'];
		 $add_query = $db->prepare("INSERT INTO agent_note(agnt_id,nld_id,converted,agent_quote,reminder,note_date)VALUES(:agid, :lid, 'lead converted', :aqute, :strmdr, :date)");
		 $add_query->bindParam(':agid',$agid);
		 $add_query->bindParam(':lid',$lid);
		 $add_query->bindParam(':rmndr',$rmndr);
		 $add_query->bindParam(':aqute',$aqute);
		 $add_query->bindParam(':strmdr',$strmdr);
		 $add_query->bindParam(':date',$date);
		 $add_query->execute();
		 if(isset($add_query)){ 
		 	 $update_date = $db->prepare("UPDATE lead_transfer SET confirm_status='3', lstart_date=:sdte, lend_date=:endate WHERE traf_agid=:agid AND traf_leadid=:lid");
			 $update_date->bindParam(':sdte',$sdte);
			 $update_date->bindParam(':endate',$endate);
			 $update_date->bindParam(':agid',$agid);
			 $update_date->bindParam(':lid',$lid);
			 $update_date->execute();
		 		echo "<script>alert('Submitted')</script>"; 
		} 
	 }
?>
<div class="overlaydv inclusions_form_dv_pop" id="convert">	
    <div class="overlaydv-in">
    	<div class="overlaydv-inner">
        	<div class="inclusions_form_dv requested">
                <h4>Converted Lead <?php echo $luniq; ?></h4>
              <form method="post">  
                <div class="col-md-6">
                	<p>Trip Start Date</p>
                	<input type="text" name="stdate" id="select-from" autocomplete="off" required/>
                </div>
                <div class="col-md-6">
                	<p>Trip End Date</p>
                	<input type="text" name="endate" id="select-till" autocomplete="off" required//>
                </div>
                <p>Your Note</p>
                <textarea name="yr_note" id="" cols="30" rows="10" required/></textarea>
                <p>Set Reminder</p>
                <input type="text" name="remndr" autocomplete="off" />
                <div class="fulldv">
                	<input type="submit" name="convrted" value="Submit" name="">
                    <a onClick="clickhere_close()">Cancel</a>
                </div>
              </form>  
            </div>
        </div>
    </div>  
</div>




</div>


<script src="<?php echo $url; ?>js/slick.js" type="text/javascript"></script>
<script src="<?php echo $url; ?>js/custom.js" type="text/javascript"></script>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
		function show1(){
		  document.getElementById('reminddv').style.display ='none';
		}
		function show2(){
		  document.getElementById('reminddv').style.display = 'block';
		}
		function show3(){
		  document.getElementById('bookme').style.display ='none';
		}
		function show4(){
		  document.getElementById('bookme').style.display = 'none';
		}
		function show5(){
		  document.getElementById('progressdv').style.display ='none';
		}
		function show6(){
		  document.getElementById('progressdv').style.display = 'block';
		}
  </script>
  <script>
  $( function() {
    $( "#datepicker" ).datepicker({ dateFormat: 'yy-m-d' });
  } );
  </script>
  
  <script>
	function reachable() {
		$('#remindpop').addClass('shows');
		}
	function withme() {
		$('#bookmepop').addClass('shows');
		}
	function talkinprogress() {
		$('#progresspop').addClass('shows');
		}
	function finalizingsoon() {
		$('#travelerpop').addClass('shows');
		}
	function convertedlead() {
		$('#convert').addClass('shows');
		}
	function clickhere_close() {
		$('.inclusions_form_dv_pop').removeClass('shows');
		}
</script>

</body>
</html>
<?php } } else{ "No Detail Found"; } } else{ "No Detail Found"; }
		
} } else{ echo "<script>location.assign('".$url."agent/logout.php')</script>"; }
      } else{ echo "<script>location.assign('".$url."agent/logout.php')</script>"; } ?>

