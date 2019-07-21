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
						 $update_lead = $db->prepare("UPDATE lead_transfer SET notification='1' WHERE traf_agid=:agid AND traf_leadid=:lid");
						 $update_lead->bindParam(':agid',$agid);
						 $update_lead->bindParam(':lid',$lid);
						 $update_lead->execute();
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

<div class="see-section main_dv"> 
    <?php include('leftmenu.php'); ?>
    
    <div class="col-md-12 p0 rightsidebar">
        <?php include('rightheader.php');?>
        
        <div class="col-md-12 rightsidebar_top2">
        
        </div>
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
                                	<a data-toggle="tab" href="#quotations2"><i class="fa fa-rupee"></i> 28,500 Total
                                    	<p>Updated : 19-05-2019 <span>Active</span></p>
                                    </a>
                                </li>
                                <li>
                                	<a data-toggle="tab" href="#quotations3"><i class="fa fa-rupee"></i> 62,50 Total
                                    	<p>Updated : 19-05-2019 <span>Active</span></p>
                                    </a>
                                </li>
                            </ul>
                            
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
                                            		<p>4 days</p>
                                                </td>
                                            	<td>
                                                	<p>Nights</p>
                                                    <p>3 nights</p>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<td>
                                                	<p>Quotation Price </p>
                                            		<p><i class="fa fa-rupee"></i>  36,600 </p>
                                                </td>
                                            	<td>
                                                	<p>Destination</p>
                                            		<p>Manali</p>
                                                </td>
                                            	<td>
                                                	<p>No. of Adults & children </p>
                                            		<p>4 Adults & 0 Children</p>
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
                                                	<p>Flight Details</p>
                                            		<p>NA</p>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<td colspan="3">
                                                	<p>Cab Details</p>
                                            		<p>Ac Sedan Pvt Cab For Entire trip (Ac will not work at Hill Area)</p>
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
                                                	<p>Day 1 : Arrive in Chandigarh to Manali (350 km Approx 9 hours) 01 June 2019</p>
                                                	<p>In morning, on arrival get picked up in Chandigarh by Assure trips Representative from Airport or Railway station and start your tour to Manali also known as best place for honeymoon and family as well as student to view the scenic beauty of Manali, On arrival in Manali and drive to Hotel Check Into The Hotel. Overnight Stay.</p>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<td colspan="3">
                                                	<p>Day 2 : Manali (Local Sightseeing) 02 June 2019</p>
                                                	<p>After Breakfast in hotel ready for sightseeing of places in and around Manali, You May visit Hadimba Devi temple, Manali Club House and Manu temple Apart from that also you can visit Tibetan Monastery, Van Vihar and Hot Spring water after visit of these places in evening you may also visit famous place called mall road after that evening come back to the hotel overnight stay.</p>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<td colspan="3">
                                                	<p>Day 3 : Manali - Solang Valley (Fullday Excursion) (Marhi And Rohtang Pass On Direct Payment Basis) 03 June 2019</p>
                                                	<p>After breakfast & getting ready in the morning Proceed for a full-day tour of Solang Valley. Visit Nehru Kund, Him valley cultural Show; you may enjoy paragliding at Solang Valley and take a helicopter ride around the beautiful snow-capped mountains. Optional adventure activities at Solang Valley include rappelling, rock climbing, river crossing, paragliding and snow scooter rides. Later, return to the hotel Overnight Stay.</p>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<td colspan="3">
                                                	<p>Day 4 : Kulllu Manikaran Siteseeing - Chandigarh 04 June 2019</p>
                                                    <p>After a hearty breakfast, excursion to Manikaran. Famous for its hot sulphur springs, this place is equally revered by both Hindus & Sikhs alike. One can also visit other temples like those dedicated to Lord Shiva, Rama, and Krishna. Also, hit the Kullu Shawl Factor to learn the art of ancient artisans. Adventure enthusiasts can enjoy white water rafting at Babeli Kullu. Later in the evening Drive towards to Chandigarh to Have overnight Stay At Chandigarh Hotel. Stay By Own </p>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<td colspan="3">
                                                	<p>Uploaded file(s)</p>
                                                    <p>N/A</p>
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
                                            		<p>4 days</p>
                                                </td>
                                            	<td>
                                                	<p>Nights</p>
                                                    <p>3 nights</p>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<td>
                                                	<p>Quotation Price </p>
                                            		<p><i class="fa fa-rupee"></i>  28,500 </p>
                                                </td>
                                            	<td>
                                                	<p>Destination</p>
                                            		<p>Manali</p>
                                                </td>
                                            	<td>
                                                	<p>No. of Adults & children </p>
                                            		<p>4 Adults & 0 Children</p>
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
                                                	<p>Flight Details</p>
                                            		<p>NA</p>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<td colspan="3">
                                                	<p>Cab Details</p>
                                            		<p>Ac Sedan Pvt Cab For Entire trip (Ac will not work at Hill Area)</p>
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
                                                	<p>Day 1 : Arrive in Chandigarh to Manali (350 km Approx 9 hours) 01 June 2019</p>
                                                	<p>In morning, on arrival get picked up in Chandigarh by Assure trips Representative from Airport or Railway station and start your tour to Manali also known as best place for honeymoon and family as well as student to view the scenic beauty of Manali, On arrival in Manali and drive to Hotel Check Into The Hotel. Overnight Stay.</p>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<td colspan="3">
                                                	<p>Day 2 : Manali (Local Sightseeing) 02 June 2019</p>
                                                	<p>After Breakfast in hotel ready for sightseeing of places in and around Manali, You May visit Hadimba Devi temple, Manali Club House and Manu temple Apart from that also you can visit Tibetan Monastery, Van Vihar and Hot Spring water after visit of these places in evening you may also visit famous place called mall road after that evening come back to the hotel overnight stay.</p>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<td colspan="3">
                                                	<p>Day 3 : Manali - Solang Valley (Fullday Excursion) (Marhi And Rohtang Pass On Direct Payment Basis) 03 June 2019</p>
                                                	<p>After breakfast & getting ready in the morning Proceed for a full-day tour of Solang Valley. Visit Nehru Kund, Him valley cultural Show; you may enjoy paragliding at Solang Valley and take a helicopter ride around the beautiful snow-capped mountains. Optional adventure activities at Solang Valley include rappelling, rock climbing, river crossing, paragliding and snow scooter rides. Later, return to the hotel Overnight Stay.</p>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<td colspan="3">
                                                	<p>Day 4 : Kulllu Manikaran Siteseeing - Chandigarh 04 June 2019</p>
                                                    <p>After a hearty breakfast, excursion to Manikaran. Famous for its hot sulphur springs, this place is equally revered by both Hindus & Sikhs alike. One can also visit other temples like those dedicated to Lord Shiva, Rama, and Krishna. Also, hit the Kullu Shawl Factor to learn the art of ancient artisans. Adventure enthusiasts can enjoy white water rafting at Babeli Kullu. Later in the evening Drive towards to Chandigarh to Have overnight Stay At Chandigarh Hotel. Stay By Own </p>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<td colspan="3">
                                                	<p>Uploaded file(s)</p>
                                                    <p>N/A</p>
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
                                            		<p>4 days</p>
                                                </td>
                                            	<td>
                                                	<p>Nights</p>
                                                    <p>3 nights</p>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<td>
                                                	<p>Quotation Price </p>
                                            		<p><i class="fa fa-rupee"></i>  62,50 </p>
                                                </td>
                                            	<td>
                                                	<p>Destination</p>
                                            		<p>Manali</p>
                                                </td>
                                            	<td>
                                                	<p>No. of Adults & children </p>
                                            		<p>4 Adults & 0 Children</p>
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
                                                	<p>Flight Details</p>
                                            		<p>NA</p>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<td colspan="3">
                                                	<p>Cab Details</p>
                                            		<p>Ac Sedan Pvt Cab For Entire trip (Ac will not work at Hill Area)</p>
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
                                                	<p>Day 1 : Arrive in Chandigarh to Manali (350 km Approx 9 hours) 01 June 2019</p>
                                                	<p>In morning, on arrival get picked up in Chandigarh by Assure trips Representative from Airport or Railway station and start your tour to Manali also known as best place for honeymoon and family as well as student to view the scenic beauty of Manali, On arrival in Manali and drive to Hotel Check Into The Hotel. Overnight Stay.</p>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<td colspan="3">
                                                	<p>Day 2 : Manali (Local Sightseeing) 02 June 2019</p>
                                                	<p>After Breakfast in hotel ready for sightseeing of places in and around Manali, You May visit Hadimba Devi temple, Manali Club House and Manu temple Apart from that also you can visit Tibetan Monastery, Van Vihar and Hot Spring water after visit of these places in evening you may also visit famous place called mall road after that evening come back to the hotel overnight stay.</p>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<td colspan="3">
                                                	<p>Day 3 : Manali - Solang Valley (Fullday Excursion) (Marhi And Rohtang Pass On Direct Payment Basis) 03 June 2019</p>
                                                	<p>After breakfast & getting ready in the morning Proceed for a full-day tour of Solang Valley. Visit Nehru Kund, Him valley cultural Show; you may enjoy paragliding at Solang Valley and take a helicopter ride around the beautiful snow-capped mountains. Optional adventure activities at Solang Valley include rappelling, rock climbing, river crossing, paragliding and snow scooter rides. Later, return to the hotel Overnight Stay.</p>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<td colspan="3">
                                                	<p>Day 4 : Kulllu Manikaran Siteseeing - Chandigarh 04 June 2019</p>
                                                    <p>After a hearty breakfast, excursion to Manikaran. Famous for its hot sulphur springs, this place is equally revered by both Hindus & Sikhs alike. One can also visit other temples like those dedicated to Lord Shiva, Rama, and Krishna. Also, hit the Kullu Shawl Factor to learn the art of ancient artisans. Adventure enthusiasts can enjoy white water rafting at Babeli Kullu. Later in the evening Drive towards to Chandigarh to Have overnight Stay At Chandigarh Hotel. Stay By Own </p>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<td colspan="3">
                                                	<p>Uploaded file(s)</p>
                                                    <p>N/A</p>
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

<script src="<?php echo $url; ?>js/slick.js" type="text/javascript"></script>
<script src="<?php echo $url; ?>js/custom.js" type="text/javascript"></script>




</body>
</html>
<?php } } else{ "No Detail Found"; } } else{ "No Detail Found"; }
		
} } else{ echo "<script>location.assign('".$url."agent/logout.php')</script>"; }
      } else{ echo "<script>location.assign('".$url."agent/logout.php')</script>"; } ?>

