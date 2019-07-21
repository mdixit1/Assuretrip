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
			 if(isset($_GET['luniq'])){
				 $luniq = $_GET['luniq'];
				 $leadedetail = $db->prepare("SELECT * FROM leads WHERE lead_uniq=:luniq");
				 $leadedetail->bindParam(':luniq',$luniq);
				 $leadedetail->execute();
				 $rows = $leadedetail->fetchAll();
				 if(count($rows)){
					 foreach($rows as $row){
						 $lid = $row['leads_id'];
							$getstatus = $db->prepare("SELECT confirm_status FROM lead_transfer WHERE traf_agid=:agid AND traf_leadid=:lid");
							$getstatus->bindParam(':agid',$agid);
						 	$getstatus->bindParam(':lid',$lid);
						 	$getstatus->execute();
							$tl = $getstatus->fetch();
							
						 $update_lead = $db->prepare("UPDATE lead_transfer SET notification='1' WHERE traf_agid=:agid AND traf_leadid=:lid");
						 $update_lead->bindParam(':agid',$agid);
						 $update_lead->bindParam(':lid',$lid);
						 $update_lead->execute();
						 
						 if(isset($_POST['givstat'])){
							 $stats = $_POST['stats'];
							 $sdte = $_POST['stdte'];	 
							 $update_date = $db->prepare("UPDATE lead_transfer SET confirm_status=:stats, lstart_date=:sdte WHERE traf_agid=:agid AND traf_leadid=:lid");
							 $update_date->bindParam(':stats',$stats);
							 $update_date->bindParam(':sdte',$sdte);
							 $update_date->bindParam(':agid',$agid);
							 $update_date->bindParam(':lid',$lid);
							 $update_date->execute();
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
    <link href="<?php echo $url; ?>agent/css/styleplus.css" type="text/css" rel="stylesheet"/>
    <link href="<?php echo $url; ?>agent/css/see.css" type="text/css" rel="stylesheet"/>
	<link href="<?php echo $url; ?>agent/css/responsive-manage.css" type="text/css" rel="stylesheet"/>
	<link href="<?php echo $url; ?>agent/css/index.css" type="text/css" rel="stylesheet"/>
    <link href="<?php echo $url; ?>agent/css/style_manage.css" type="text/css" rel="stylesheet" />
    
    
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
                        <span>TT Advisior : Aakansha</span><br>
                        Last Spoken : 22-05-2019
                    </p>
                </div>
                <div class="fulldv trip_id">
					<?php if($tl['confirm_status']=='0'){ ?>
                    	<p><span class="active">Hot</span> Lead Id <?php echo $luniq; ?></p>
                    <?php } elseif($tl['confirm_status']=='1'){ ?>
                    	<p><span class="hot">Hot</span> Lead Id <?php echo $luniq; ?></p>
                    <?php } elseif($tl['confirm_status']=='2'){ ?>
                    	<p><span class="progresss">In Progress</span> Lead Id <?php echo $luniq; ?></p>
                    <?php } ?>
                
                    
                    <h4>2 agents working on this trip</h4>
                </div>
              <div class="fulldv worth">
               	<p><i class="fa fa-eye"></i>Quate worth Rs. 19,900 seen 2 days ago</p>
                </div>
                <div class="fulldv worth">
                	<p><i class="fa fa-refresh"></i><span style="color:#CB0003;"><em>Follow Up Required</em></span> <br>3 days ago</p>
                </div>
                <div class="fulldv traverler_detail">
                	<h4>Traveler Detail</h4>
                    <img src="<?php echo $url; ?>agent/images/user.png" alt=""/>
                    <p><i class="fa fa-phone"></i> +91 123 456 7890</p>
                    <p><i class="fa fa-envelope"></i> user8617753-quote@reply.traveltriangle</p>
                    <p><i class="fa fa-briefcase"></i> Manager</p>
                    <p><i class="fa fa-map-marker"></i> Delhi, Nct, India</p>
                </div>
                
                <div class="fulldv above">
                	<h4>Is the above information useful?</h4>
                    <input type="radio"> <span>Yes</span>
                    <input type="radio"> <span>No</span>
                </div>
                <div class="fulldv notes_dv">
                	<h3>Notes</h3>
                    <div class="fulldv reminder">
                   	  	<h4>Select icons to Add Note & Set Reminder</h4>
                        <ul>
                        	<li>
                            	<img src="<?php echo $url;?>/agent/images/no-phone.png" alt=""/> <br>
                                <p>Not <br> Reachable</p>
                            </li>
                            <li>
                            	<img src="<?php echo $url;?>/agent/images/dislike.png" alt=""/> <br>
                                <p>Won't book <br> with me</p>
                            </li>
                            <li>
                            	<img src="<?php echo $url;?>/agent/images/speaker.png" alt=""/> <br>
                                <p>Talk in <br> progress</p>
                            </li>
                            <li>
                            	<img src="<?php echo $url;?>/agent/images/like.png" alt=""/> <br>
                                <p>Finalizing <br> soon</p>
                            </li>
                        </ul>
                    </div>
                    <div class="fulldv tt_admin">
                    	<ul>
                        	<li>
                            	<img src="<?php echo $url;?>/agent/images/user.png" alt=""/>
                                <p style="color:#0979D5;">TT Admin</p>
                                <p>#aakansha 4n5d 2n wayanad 2n coorg...pickup and drop kunnur..for 2 adults 1 kid#Manual_Hot</p>
                                <p>14:15 hrs, 20 May 2019</p>
                            </li>
                            <li>
                            	<img src="<?php echo $url;?>/agent/images/user.png" alt=""/>
                                <p>#aakansha 4n5d 2n wayanad 2n coorg...pickup and drop kunnur..for 2 adults 1 kid#Manual_Hot</p>
                                <p>14:15 hrs, 20 May 2019</p>
                            </li>
                            <li>
                            	<img src="<?php echo $url;?>/agent/images/user.png" alt=""/>
                                <p>#aakansha 4n5d 2n wayanad 2n coorg...pickup and drop kunnur..for 2 adults 1 kid#Manual_Hot</p>
                                <p>14:15 hrs, 20 May 2019</p>
                            </li>
                            <li>
                            	<img src="<?php echo $url;?>/agent/images/user.png" alt=""/>
                                <p>#aakansha 4n5d 2n wayanad 2n coorg...pickup and drop kunnur..for 2 adults 1 kid#Manual_Hot</p>
                                <p>14:15 hrs, 20 May 2019</p>
                            </li>
                            <li>
                            	<img src="<?php echo $url;?>/agent/images/user.png" alt=""/>
                                <p>#aakansha 4n5d 2n wayanad 2n coorg...pickup and drop kunnur..for 2 adults 1 kid#Manual_Hot</p>
                                <p>14:15 hrs, 20 May 2019</p>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="fulldv reply_dv">
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
                    </div>
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
                                                            <p><?php echo $row['departure_day']; ?></p>
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
                                                            <p><?php echo $row['adult']; ?> Adults <?php echo $row['children']; ?></p>
                                                        </td>
                                                        <td>
                                                            <p>Destination</p>
                                                            <p><?php echo $row['destination_to']; ?></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3">
                                                            <p>Hotel Details</p>
                                                            <p>Night 1,2,3, Golden Apple ResortManali, Manali, Super Deluxe ,02 Room For 04 Adults</p>
                                                        </td>
                                                    </tr>
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
                          </h4>
                    
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="panel-body">
                                    <ul class="nav nav-tabs quotations_tab">
                                        <li class="active">
                                            <a data-toggle="tab" href="#quotations1"><i class="fa fa-rupee"></i> 36,600 Total 
                                                <p>Updated : 19-05-2019 <span>Active</span></p>
                                            </a>
                                        </li>
                                        <li>
                                            <a data-toggle="tab" href="#quotations2"><i class="fa fa-rupee"></i> 48,500 Total
                                                <p>Updated : 19-05-2019 <span>Active</span></p>
                                            </a>
                                        </li>
                                        <li>
                                            <a data-toggle="tab" href="#quotations3"><i class="fa fa-rupee"></i> 62,500 Total
                                                <p>Updated : 19-05-2019 <span>Active</span></p>
                                            </a>
                                        </li>
                                    </ul>
                               <?php
							   		$first_quotation = $db->prepare("SELECT * FROM agent_quotation WHERE qlead_id=:lid AND qag_id=:agid AND total_cost < 36000");
									$first_quotation->bindParam(':lid',$lid);
									$first_quotation->bindParam(':agid',$agid);
									$first_quotation->execute();
									$allqt = $first_quotation->fetch();
									
									$first_quotation1 = $db->prepare("SELECT * FROM agent_quotation WHERE qlead_id=:lid AND qag_id=:agid AND (total_cost BETWEEN '36000' AND '48500') ");
									$first_quotation1->bindParam(':lid',$lid);
									$first_quotation1->bindParam(':agid',$agid);
									$first_quotation1->execute();
									$allqt1 = $first_quotation1->fetch();
									
									$first_quotation2 = $db->prepare("SELECT * FROM agent_quotation WHERE qlead_id=:lid AND qag_id=:agid AND (total_cost BETWEEN '48500' AND '62500') ");
									$first_quotation2->bindParam(':lid',$lid);
									$first_quotation2->bindParam(':agid',$agid);
									$first_quotation2->execute();
									$allqt2 = $first_quotation2->fetch();
								?>	
							      <div class="tab-content">
                                        <div id="quotations1" class="tab-pane fade in active">
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
                                                            <p>Day 1 : <?php echo $allqt['first_day']; ?></p>
                                                            <p><?php echo $allqt['first_desc']; ?></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3">
                                                            <p>Day 2 : <?php echo $allqt['second_day']; ?></p>
                                                            <p><?php echo $allqt['second_desc']; ?></p>
                                                        </td>
                                                    </tr>
                                               </table>
                                            </div>
                                        </div>
                                        <div id="quotations2" class="tab-pane fade">
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
                                                            <p>Day 1 : <?php echo $allqt1['first_day']; ?></p>
                                                            <p><?php echo $allqt1['first_desc']; ?></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3">
                                                            <p>Day 2 : <?php echo $allqt1['second_day']; ?></p>
                                                            <p><?php echo $allqt1['second_desc']; ?></p>
                                                        </td>
                                                    </tr>
                                               </table>
                                            </div>
                                        </div>
                                        <div id="quotations3" class="tab-pane fade">
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
</div>
  


</div>

<script src="<?php echo $url; ?>js/slick.js" type="text/javascript"></script>
<script src="<?php echo $url; ?>js/custom.js" type="text/javascript"></script>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#datepicker" ).datepicker({ dateFormat: 'yy-m-d' });
  } );
  </script>

</body>
</html>
<?php } } else{ "No Detail Found"; } } else{ "No Detail Found"; }
		
} } else{ echo "<script>location.assign('".$url."agent/logout.php')</script>"; }
      } else{ echo "<script>location.assign('".$url."agent/logout.php')</script>"; } ?>

