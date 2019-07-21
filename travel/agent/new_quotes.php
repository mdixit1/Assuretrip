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
			  if(isset($_GET['uniq'])){
				 $luniq = $_GET['uniq'];
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
							
							if(isset($_POST['savebasic'])){
							  if($_POST['chosday']=='3Days2Nights'){
									$qday = '3';
									$qngt = '4';
							  }
							  elseif($_POST['chosday']=='4Days3Nights'){
								  	$qday = '4';
									$qngt = '3';
							  }
							  elseif($_POST['chosday']=='5Days4Nights'){
								  	$qday = '5';
									$qngt = '4';
							  }
							  elseif($_POST['chosday']=='6Days5Nights'){
								  	$qday = '6';
									$qngt = '5';
							  }
							  elseif($_POST['chosday']=='7Days6Nights'){
								  	$qday = '7';
									$qngt = '6';
							  }
								$per = $_POST['per'];
								$curcy = $_POST['curncy'];
								$flcost = $_POST['flcost'];
								$vscost = $_POST['vscost'];
								$lndcost = $_POST['lndcost'];
								$totl_cost = $flcost + $vscost + $lndcost;
								$nght = $_POST['nght'];
								$hname = $_POST['hname'];
								$cty = $_POST['cty'];
								$cat = $_POST['cat'];
								$roomtyp = $_POST['roomtyp'];
								$commnt = $_POST['commnt'];
								$chname = $_POST['chname'];
								if($chname!=''){
									$fltype = 1;	
								}
								else{
									$fltype = 0;
								}
								$fdetil = $_POST['fdetil'];
								$cabb = $_POST['cab'];
								if($cabb!=''){
									$cab = 1;	
								}
								else{
									$cab = 0;
								}
								$cbdetail = $_POST['cbdetail'];
								$hotl = $_POST['hotl'];
								$haccomd = $_POST['hotl_accom'];
								$cmp = $_POST['cmp'];
								$campsty = $_POST['campsty'];
								$brfst = $_POST['brfst'];
								$dinr = $_POST['dinr'];
								$drnk = $_POST['drnk'];
								$fltkt = $_POST['fltkt'];
								$arvprt = $_POST['ar_arport'];
								$depprt = $_POST['dep_arport'];
								$volvo = $_POST['volvo'];
								$train = $_POST['train'];
								$cbtrs = $_POST['cbtrs'];
								$cbtdetail = $_POST['cbtdetail'];
								$lclseen = $_POST['lclseen'];
								$sghtsen = $_POST['sghtsen'];
								$cabseen = $_POST['cabseen'];
								$rohtng = $_POST['rohtng'];
								$hny = $_POST['hny'];
								$hoony = $_POST['hoony'];
								$gtax = $_POST['gtax'];
								$othrincl = $_POST['othrincl'];
								$othrex = $_POST['othrex'];
								$itdate = $_POST['itdate'];
								$one = $_POST['day'];
								$night = $_POST['night'];
								$two = $_POST['day1'];
								$night1 = $_POST['night1'];
								$three = $_POST['day2'];
								$night2 = $_POST['night2'];
								$four = $_POST['day3'];
								$night3 = $_POST['night3'];
								$fifth = $_POST['day4'];
								$night4 = $_POST['night4'];
								$six = $_POST['day5'];
								$night5 = $_POST['night5'];
								$senvn = $_POST['day6'];
								$othrinfo = $_POST['othrinfo'];
								$add_quotation = $db->query("INSERT INTO agent_quotation(qag_id,qlead_id,day,night,person,currency,flight_cost,visa_cost,land_cost,total_cost,total_night,hotel_name,cityy,categry,room_type,comment,flight_include,flight_detail,cab_include,cab_detail,hotel_type, hotel_accomd,camp_type,camp_stay,breakfast,dinner,arrival_drink,flight_transport,arrival_airport,dept_airport,volvo,rail_ticket,cab_transport,cb_transdetail,local_seen,desc_sightseen,cab_sightseen,rohtang_permit,honeymoon_type,honey_desc,govt_tax,other_inclusion,other_exclusion,itinerary_date,first_day,first_night,second_day,second_night,third_day,third_night,four_day,four_night,fifth_day,fifth_night,six_day,six_night,seven_day,other_info,quotation_date)VALUES('$agid', '$lid', '$qday', '$qngt', '$per', '$curcy', '$flcost', '$vscost', '$lndcost', '$totl_cost', '$nght', '$hname', '$cty', '$cat', '$roomtyp', '$commnt', '$fltype', '$fdetil', '$cab', '$cbdetail', '$hotl', '$haccomd', '$cmp', '$campsty', '$brfst', '$dinr', '$drnk', '$fltkt', '$arvprt', '$depprt', '$volvo', '$train', '$cbtrs', '$cbtdetail', '$lclseen', '$sghtsen', '$cabseen', '$rohtng', '$hny', '$hoony', '$gtax', '$othrincl', '$othrex', '$itdate', '$one', '$night', '$two', '$night1', '$three', '$night2', '$four', '$night3', '$fifth', '$night4', '$six', '$night5', '$senvn', '$othrinfo', '$date')");
								/*$add_quotation->bindParam(':agid',$agid);
								$add_quotation->bindParam(':lid',$lid);
								$add_quotation->bindParam(':qday',$qday);
								$add_quotation->bindParam(':qngt',$qngt);
								$add_quotation->bindParam(':per',$per);
								$add_quotation->bindParam(':curcy',$curcy);
								$add_quotation->bindParam(':flcost',$flcost);
								$add_quotation->bindParam(':vscost',$vscost);
								$add_quotation->bindParam(':lndcost',$lndcost);
								$add_quotation->bindParam(':totl_cost',$totl_cost);
								$add_quotation->bindParam(':nght',$nght);
								$add_quotation->bindParam(':hname',$hname);
								$add_quotation->bindParam(':cty',$cty);
								$add_quotation->bindParam(':cat',$cat);
								$add_quotation->bindParam(':roomtyp',$roomtyp);
								$add_quotation->bindParam(':commnt',$commnt);
								$add_quotation->bindParam(':fltype',$fltype);
								$add_quotation->bindParam(':fdetil',$fdetil);
								$add_quotation->bindParam(':cab',$cab);
								$add_quotation->bindParam(':cbdetail',$cbdetail);
								$add_quotation->bindParam(':hotl',$hotl);
								$add_quotation->bindParam(':haccomd',$haccomd);
								$add_quotation->bindParam(':cmp',$cmp);
								$add_quotation->bindParam(':campsty',$campsty);
								$add_quotation->bindParam(':brfst',$brfst);
								$add_quotation->bindParam(':dinr',$dinr);
								$add_quotation->bindParam(':drnk',$drnk);
								$add_quotation->bindParam(':fltkt',$fltkt);
								$add_quotation->bindParam(':arvprt',$arvprt);
								$add_quotation->bindParam(':depprt',$depprt);
								$add_quotation->bindParam(':volvo',$volvo);
								$add_quotation->bindParam(':train',$train);
								$add_quotation->bindParam(':cbtrs',$cbtrs);
								$add_quotation->bindParam(':cbtdetail',$cbtdetail);
								$add_quotation->bindParam(':lclseen',$lclseen);
								$add_quotation->bindParam(':sghtsen',$sghtsen);
								$add_quotation->bindParam(':cabseen',$cabseen);
								$add_quotation->bindParam(':rohtng',$rohtng);
								$add_quotation->bindParam(':hny',$hny);
								$add_quotation->bindParam(':hoony',$hoony);
								$add_quotation->bindParam(':gtax',$gtax);
								$add_quotation->bindParam(':othrincl',$othrincl);
								$add_quotation->bindParam(':othrex',$othrex);
								$add_quotation->bindParam(':itdate',$itdate);
								$add_quotation->bindParam(':one',$one);
								$add_quotation->bindParam(':night',$night);
								$add_quotation->bindParam(':two',$two);
								$add_quotation->bindParam(':night1',$night1);
								$add_quotation->bindParam(':three',$three);
								$add_quotation->bindParam(':night2',$night2);
								$add_quotation->bindParam(':four',$four);
								$add_quotation->bindParam(':night3',$night3);
								$add_quotation->bindParam(':fifth',$fifth);
								$add_quotation->bindParam(':night4',$night4);
								$add_quotation->bindParam(':six',$six);
								$add_quotation->bindParam(':night5',$night5);
								$add_quotation->bindParam(':senvn',$senvn);
								$add_quotation->bindParam(':othrinfo',$othrinfo);
								$add_quotation->bindParam(':date',$date);
								$add_quotation->execute();*/
								if(isset($add_quotation)){
									echo "<script>alert('Quotation Added')</script>";
								}
								else{
									echo "<script>alert('Quotation Not Added')</script>";
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
            	<div class="fulldv trav_requirement">
                	<h4>Traveler's Requirement</h4>
                    <table class="see-table">
                    	<tr>
                        	<td>Starting Date</td>
                        	<td><?php echo date('d-M-Y', strtotime($row['departure_date'])); ?></td>
                        </tr>
                       
                        <tr>
                        	<td>Destination</td>
                        	<td><?php echo $row['destination_to']; ?></td>
                        </tr>
                        <tr>
                        	<td>Budget with Flight</td>
                        	<td><?php echo $row['budget_withair']; ?></td>
                        </tr>
                        <tr>
                        	<td>No. of Adults & children</td>
                        	<td><?php echo $row['adult']; ?> adults & <?php echo $row['children']; ?> children</td>
                        </tr>
                        
                    </table>
                    <br>
                    <h4>Additional Information</h4>
                    <table class="see-table">
                    	<tr>
                        	<td>NA</td>
                            <td></td>
                        </tr>
                    </table>
                    <br>
                    <h4>Looking For</h4>
                    <table class="see-table">
                    	<tr>
                        	<td>Hotel Accommodation</td>
                            <?php if($row['hotel_first']!='' || $row['hotel_second']!='' || $row['hotel_third']!='' || $row['hotel_four']!='' || $row['hotel_five']!=''){ ?>   
                            <td>Yes</td>
                            <?php } else{ ?>
                            <td>No</td>
                            <?php } ?> 
                            
                        </tr>
                        <tr>
                        	<td>Hotel Category</td>
                            <td><?php echo $row['hotel_first'] . $row['hotel_second'] . $row['hotel_third'] . $row['hotel_four'] . $row['hotel_five']; ?> Star</td>
                        </tr>
                        <tr>
                        	<td>Need Flight / Train</td>
                            <td><?php echo $row['flight']; ?></td>
                        </tr>
                        <tr>
                        	<td>Cab for Local Sight Seeing</td>
                            <td><?php echo $row['cab_facility']; ?></td>
                        </tr>
                       
                        <tr>
                        	<td>Cab services</td>
                            <td>Driver speaks: <?php echo $row['cab_language']; ?></td>
                        </tr>
                        
                        <tr>
                        	<td>Type of tour you want?</td>
                            <td><?php echo $row['type_of_tour']; ?></td>
                        </tr>
                       
                        <tr>
                        	<td>Places you want to cover in this tour?</td>
                            <td><?php echo $row['destination_to']; ?></td>
                        </tr>
                        
                    </table>

                </div>
            </div>
            <div class="col-md-9">
                <div class="fulldv basic_detial_dv">
                 <form method="post">
                    <h3><i class="fa fa-file-text-o"></i> &nbsp; Basic Details</h3>
                    <div class="fulldv">
                        <div class="col-md-2">
                            <p>Day</p>
                            <select name="chosday" id="choosedays" required/>
                            	<option value="">Select</option>
                                <option value="3Days2Nights">3 Days 2 Nights</option>
                                <option value="4Days3Nights">4 Days 3 Nights</option>
                                <option value="5Days4Nights">5 Days 4 Nights</option>
                                <option value="6Days5Nights">6 Days 5 Nights</option>
                                <option value="7Days6Nights">7 Days 6 Nights</option>
                            </select>
                            <Script> 
										   $('#choosedays').change(function() {
												$('.colors').hide();
												$('#' + $(this).val()).show();
										 });
										</Script>
                        </div>
                    </div>
                    <div class="fulldv table_quote">
                    	<table class="see-table">
                        	<tr>
                            	<td><p><input type="radio" onclick="show2();" name="per" value="0" checked="checked"> Per Person</p></td>
                            	<td colspan="2">
                                	<p><input type="radio" onclick="show1();" name="per" value="1"> Total</p>
                                </td>
                            	
                                <td colspan="4">
                                	<select name="curncy" id="">
                                    	<option value="" hidden="hidden">Currency</option>
                                    	<option value="Dollar">Dollar</option>
                                        <option value="Rupee">Rupee</option>
                                        <option value="Euro">Euro</option>
                                        <option value="JPY">JPY</option>
                                        <option value="SGD">SGD</option>
                                        <option value="PHP">PHP</option>
                                        <option value="GBP">GBP</option>
                                        <option value="AED">AED</option>
                                        <option value="AUD">AUD</option>
                                        <option value="CAD">CAD</option>
                                        <option value="SAR">SAR</option>
                                        <option value="LBP">LBP</option>
                                        <option value="ZAR">ZAR</option>
                                        <option value="PKR">PKR</option>
                                        <option value="MYR">MYR</option>
                                        <option value="NZD">NZD</option>
                                        <option value="CHF">CHF</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                            	<td style="width:150px;">
                                	<p>Flight Cost</p>
                                    <input type="text" name="flcost" onKeyUp="onlydigit(only)" id="flcost" required/>
                                </td>
                            	<td style="width:50px; text-align:center;">
                                	<span class="cost_icon">+</span>
                                </td>
                            	<td style="width:150px;">
                                	<p>Visa Cost</p>
                                    <input type="text" name="vscost" onKeyUp="onlydigit(only)" id="vscost">
                                </td>
                            	<td style="width:50px; text-align:center;">
                                	<span class="cost_icon">+</span>
                                </td>
                                <td style="width:150px;">
                                	<p>Land Package Cost</p>
                                    <input type="text" name="lndcost" onKeyUp="onlydigit(only)" id="lndcost">
                                </td>
                                <td style="width:50px; text-align:center;">
                                	<span class="cost_icon">=</span>	
                                </td>
                                <td>
                                	<p><span style="float:left;">Quotation Price</span> <span class="costtotle">(Total)</span> <span class="costtotle" id="perperson">(Per Person)</span></p>
                                    <input type="text" onKeyUp="onlydigit(only)" id="totlecostt" readonly/>
                                    <ul>
                                    	<li><div id="totlecost2">(Total)</div> <div id="perperson2">(Per Person)</div></li>
                                        <li><span>TT Commission</span>: &nbsp; &nbsp; <i class="fa fa-rupee"></i> 5000.00</li>
                                        <li><span>You Will Earn</span>: &nbsp; &nbsp; <i class="fa fa-rupee"></i><input type="text" id="aftcomsn" style="width:80px;" readonly/></li>
                                    </ul>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="fulldv">
                        <h3><i class="fa fa-hotel"></i> &nbsp; Hotel Details</h3>
                    	<div class="col-md-2">
                        	<p>Nights</p>
                            <select name="nght" id="">
                            	<option value="" hidden="">Select</option>
                            	<option value="1">1 Night</option>
                                <option value="2">2 Night</option>
                                <option value="3">3 Night</option>
                                <option value="4">4 Night</option>
                                <option value="5">5 Night</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                        	<p>Hotel Name</p>
                            <input type="text" name="hname" placeholder="e.g. Taj">
                        </div>
                        <div class="col-md-3">
                        	<p>City</p>
                            <input type="text" name="cty" placeholder="e.g. Delhi">
                        </div>
                        <div class="col-md-2">
                        	<p>Category</p><!-- in star e.g. 3 star -->
                            <input type="text" name="cat" placeholder="e.g. 3 Star">
                        </div>
                        <div class="col-md-2">
                        	<p>Room Type</p>
                            <select name="roomtyp" id="">
                            	<option value="" hidden="hidden">Select</option>
                            	<option value="Standard">Standard</option>
                                <option value="Super Deluxe">Super Deluxe</option>
                                <option value="Deluxe">Deluxe</option>
                                <option value="Luxury">Luxury</option>
                                <option value="Duplex">Duplex</option>
                                <option value="Executive Suite">Executive Suite</option>
                                <option value="Family Suite">Family Suite</option>
                                <option value="Grande Suite">Grande Suite</option>
                                <option value="Houseboat">Houseboat</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                        	<p>Comments</p>
                            <textarea name="commnt" id="" cols="30" rows="10"placeholder="Any Additional Information..........."></textarea>
                        </div>
                    </div>
                    <div class="fulldv"> 
                    	<br>
                    	<h3><i class="fa fa-plane"></i> &nbsp; Flight Details</h3>
                        <div class="col-md-12">
                            <div class="fulldv">
                            	<p><input type="checkbox" name="chname" value="1" class="coupon_question"> Flights not included</p>
                            </div>
                            <div class="fulldv answer">
                            <textarea name="fdetil" id="" cols="30" rows="10" placeholder=" Flight Details..............."></textarea>
                            </div>
                            <script type="text/javascript">
								$(".answer").show();
								$(".coupon_question").click(function() {
									if($(this).is(":checked")) {
										$(".answer").hide();
									} else {
										$(".answer").show();
									}
								});
							</script>
                        </div>
                    </div>
                    <div class="fulldv"> 
                    	<br>
                    	<h3><i class="fa fa-car"></i> &nbsp; Cab Details</h3>
                        <div class="col-md-12">
                            <div class="fulldv">
                            	<p><input type="checkbox" name="cab" value="1" class="car_del"> Cab not included</p>
                            </div>
                            <div class="fulldv car">
                            <textarea name="cbdetail" id="" cols="30" rows="10" placeholder=" Cab Details........."></textarea>
                            </div>
                            <script type="text/javascript">
								$(".car").show();
								$(".car_del").click(function() {
									if($(this).is(":checked")) {
										$(".car").hide();
									} else {
										$(".car").show();
									}
								});
							</script>
                        </div>
                    </div>
                    <div class="fulldv"> 
                    	<br>
                    	<h3><i class="fa fa-puzzle-piece"></i> &nbsp;  Inclusions/Exclusions</h3>
                        <div class="col-md-12 inclusions_tbl">
                        	<div class="fulldv inclusions_form_dv" style="width:100%; max-height:none; padding:0;">
                                <table class="see-table">
                                    <tr>
                                        <td></td>
                                        <td>Inclusion</td>
                                        <td>Exclusion</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"><h4>Accomodation</h4></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p>Hotel</p>
                                            <textarea name="hotl_accom" id="" cols="30" rows="10"></textarea>
                                        </td>
                                        <td><input type="radio" name="hotl" value="yes"></td>
                                        <td><input type="radio" name="hotl" value="no"></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p>Camp Stay</p>
                                            <textarea name="campsty" id="" cols="30" rows="10"></textarea>
                                        </td>
                                        <td><input type="radio" name="cmp" value="yes"></td>
                                        <td><input type="radio" name="cmp" value="no"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"><h4>Meal plan</h4></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p>Breakfast</p>
                                        </td>
                                        <td><input type="radio" name="brfst" value="yes"></td>
                                        <td><input type="radio" name="brfst" value="no"></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p>Dinner</p>
                                        </td>
                                        <td><input type="radio" name="dinr" value="yes"></td>
                                        <td><input type="radio" name="dinr" value="no"></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p>Welcome Drink on Arrival</p>
                                        </td>
                                        <td><input type="radio" name="drnk" value="yes"></td>
                                        <td><input type="radio" name="drnk" value="no"></td>
                                    </tr>
                                    
                                    <tr>
                                        <td colspan="3"><h4>Transport</h4></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p>Flight Tickets</p>
                                        </td>
                                        <td><input type="radio" name="fltkt" value="yes"></td>
                                        <td><input type="radio" name="fltkt" value="no"></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p>Arrival - Airport Transfer</p>
                                        </td>
                                        <td><input type="radio" name="ar_arport" value="yes"></td>
                                        <td><input type="radio" name="ar_arport" value="no"></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p>Departure - Airport Transfer</p>
                                        </td>
                                        <td><input type="radio" name="dep_arport" value="yes"></td>
                                        <td><input type="radio" name="dep_arport" value="no"></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p>Volvo Bus Tickets </p>
                                        </td>
                                        <td><input type="radio" name="volvo" value="yes"></td>
                                        <td><input type="radio" name="volvo" value="no"></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p>Rail tickets</p>
                                        </td>
                                        <td><input type="radio" name="train" value="yes"></td>
                                        <td><input type="radio" name="train" value="no"></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p>Cab for Transport</p>
                                            <textarea name="cbtdetail" id="" cols="30" rows="10"></textarea>
                                        </td>
                                        <td><input type="radio" name="cbtrs" value="yes"></td>
                                        <td><input type="radio" name="cbtrs" value="no"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"> <h4>Sightseeing</h4> </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p>Local Sightseeing</p>
                                            <textarea name="sghtsen" id="" cols="30" rows="10"></textarea>
                                        </td>
                                        <td><input type="radio" name="lclseen" value="yes"></td>
                                        <td><input type="radio" name="lclseen" value="no"></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p>Cab for sightseeing</p>
                                        </td>
                                        <td><input type="radio" name="cabseen" value="yes"></td>
                                        <td><input type="radio" name="cabseen" value="no"></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p>Rohtang Permit </p>
                                        </td>
                                        <td><input type="radio" name="rohtng" value="yes"></td>
                                        <td><input type="radio" name="rohtng" value="no"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"><h4>Honeymoon Inclusions</h4></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p>Honeymoon Inclusions</p>
                                            <textarea name="hoony" id="" cols="30" rows="10"></textarea>
                                        </td>
                                        <td><input type="radio" name="hny" value="yes"></td>
                                        <td><input type="radio" name="hny" value="no"></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p>Government Taxes/VAT/ Service Charges</p>
                                        </td>
                                        <td><input type="radio" name="gtax" value="yes"></td>
                                        <td><input type="radio" name="gtax" value="no"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"><h4>Others</h4></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p>Other Inclusions</p>
                                        </td>
                                        <td><input type="radio" name="othrincl" value="yes"></td>
                                        <td><input type="radio" name="othrincl" value="no"></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p>Other Exclusions</p>
                                        </td>
                                        <td><input type="radio" name="othrex" value="yes"></td>
                                        <td><input type="radio" name="othrex" value="no"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="fulldv">
                    	<h3><i class="fa fa-sun-o"></i> &nbsp;  Day wise Itinerary</h3>
                        <div class="col-md-3">
                            Itinerary Start Date
                            <input type="text" name="itdate" id="datepicker" autocomplete="off">
                        </div>
                        <div id="3Days2Nights" class="fulldv colors" style="display:none">
                            <div class="fulldv">
                                <div class="col-md-12">
                                    <p>Day 1</p>
                                    <textarea name="day" id="" cols="30" rows="10"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <p>Night 1</p>
                                    <textarea name="night" id="" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="fulldv">
                                <div class="col-md-12">
                                    <p>Day 2</p>
                                    <textarea name="day1" id="" cols="30" rows="10"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <p>Night 2</p>
                                    <textarea name="night1" id="" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="fulldv">
                                <div class="col-md-12">
                                    <p>Day 3</p>
                                    <textarea name="day2" id="" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                        </div>
                        <div id="4Days3Nights" class="fulldv colors" style="display:none">
                            <div class="fulldv">
                                <div class="col-md-12">
                                    <p>Day 1</p>
                                    <textarea name="day" id="" cols="30" rows="10"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <p>Night 1</p>
                                    <textarea name="night" id="" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="fulldv">
                                <div class="col-md-12">
                                    <p>Day 2</p>
                                    <textarea name="day1" id="" cols="30" rows="10"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <p>Night 2</p>
                                    <textarea name="night1" id="" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="fulldv">
                                <div class="col-md-12">
                                    <p>Day 3</p>
                                    <textarea name="day2" id="" cols="30" rows="10"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <p>Night 3</p>
                                    <textarea name="night2" id="" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="fulldv">
                                <div class="col-md-12">
                                    <p>Day 4</p>
                                    <textarea name="day3" id="" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                        </div>
                         <div id="5Days4Nights" class="fulldv colors" style="display:none">
                            <div class="fulldv">
                                <div class="col-md-12">
                                    <p>Day 1</p>
                                    <textarea name="day" id="" cols="30" rows="10"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <p>Night 1</p>
                                    <textarea name="night" id="" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="fulldv">
                                <div class="col-md-12">
                                    <p>Day 2</p>
                                    <textarea name="day1" id="" cols="30" rows="10"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <p>Night 2</p>
                                    <textarea name="night1" id="" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="fulldv">
                                <div class="col-md-12">
                                    <p>Day 3</p>
                                    <textarea name="day2" id="" cols="30" rows="10"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <p>Night 3</p>
                                    <textarea name="night2" id="" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="fulldv">
                                <div class="col-md-12">
                                    <p>Day 4</p>
                                    <textarea name="day3" id="" cols="30" rows="10"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <p>Night 4</p>
                                    <textarea name="night3" id="" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="fulldv">
                                <div class="col-md-12">
                                    <p>Day 5</p>
                                    <textarea name="day4" id="" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                        </div>
                         <div id="6Days5Nights" class="fulldv colors" style="display:none">
                            <div class="fulldv">
                                <div class="col-md-12">
                                    <p>Day 1</p>
                                    <textarea name="day" id="" cols="30" rows="10"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <p>Night 1</p>
                                    <textarea name="night" id="" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="fulldv">
                                <div class="col-md-12">
                                    <p>Day 2</p>
                                    <textarea name="day1" id="" cols="30" rows="10"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <p>Night 2</p>
                                    <textarea name="night1" id="" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="fulldv">
                                <div class="col-md-12">
                                    <p>Day 3</p>
                                    <textarea name="day2" id="" cols="30" rows="10"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <p>Night 3</p>
                                    <textarea name="night2" id="" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="fulldv">
                                <div class="col-md-12">
                                    <p>Day 4</p>
                                    <textarea name="day3" id="" cols="30" rows="10"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <p>Night 4</p>
                                    <textarea name="night3" id="" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="fulldv">
                                <div class="col-md-12">
                                    <p>Day 5</p>
                                    <textarea name="day4" id="" cols="30" rows="10"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <p>Night 5</p>
                                    <textarea name="night4" id="" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="fulldv">
                                <div class="col-md-12">
                                    <p>Day 6</p>
                                    <textarea name="day5" id="" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                        </div>
                         <div id="7Days6Nights" class="fulldv colors" style="display:none">
                            <div class="fulldv">
                                <div class="col-md-12">
                                    <p>Day 1</p>
                                    <textarea name="day" id="" cols="30" rows="10"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <p>Night 1</p>
                                    <textarea name="night" id="" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="fulldv">
                                <div class="col-md-12">
                                    <p>Day 2</p>
                                    <textarea name="day1" id="" cols="30" rows="10"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <p>Night 2</p>
                                    <textarea name="night1" id="" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="fulldv">
                                <div class="col-md-12">
                                    <p>Day 3</p>
                                    <textarea name="day2" id="" cols="30" rows="10"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <p>Night 3</p>
                                    <textarea name="night2" id="" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="fulldv">
                                <div class="col-md-12">
                                    <p>Day 4</p>
                                    <textarea name="day3" id="" cols="30" rows="10"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <p>Night 4</p>
                                    <textarea name="night3" id="" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="fulldv">
                                <div class="col-md-12">
                                    <p>Day 5</p>
                                    <textarea name="day4" id="" cols="30" rows="10"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <p>Night 5</p>
                                    <textarea name="night4" id="" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="fulldv">
                                <div class="col-md-12">
                                    <p>Day 6</p>
                                    <textarea name="day5" id="" cols="30" rows="10"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <p>Night 6</p>
                                    <textarea name="night5" id="" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="fulldv">
                                <div class="col-md-12">
                                    <p>Day 7</p>
                                    <textarea name="day6" id="" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="fulldv">
                    	<h3><i class="fa fa-archive"></i> &nbsp;  Miscellaneous</h3>
                        <div class="col-md-6">
                        	<p>Terms & Condition</p>
                            <textarea name="tcond" id="" cols="30" rows="10"></textarea>
                        </div>
                        <div class="col-md-6">
                        	<p>Other Information</p>
                            <textarea name="othrinfo" id="" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                    	<input type="submit" name="savebasic" value="Save & send">
                    </div>
                  </form>  
                </div>
            </div>
        </div>
    </div>
</div>
  

<!--  Inclusions/Exclusions Popup -->
<div class="overlaydv inclusions_form_dv_pop">	
    <div class="overlaydv-in">
    	<div class="overlaydv-inner">
        	<div class="inclusions_form_dv">
                <h4>Inclusion/Exclusion</h4>
                <table class="see-table">
                    <tr>
                        <td></td>
                        <td>Inclusion</td>
                        <td>Exclusion</td>
                    </tr>
                    <tr>
                        <td colspan="3"><h4>Accomodation</h4></td>
                    </tr>
                    <tr>
                        <td>
                            <p>Hotel</p>
                            <textarea name="" id="" cols="30" rows="10"></textarea>
                        </td>
                        <td><input type="radio" name="#"></td>
                        <td><input type="radio" name="#"></td>
                    </tr>
                    <tr>
                        <td>
                            <p>Camp Stay</p>
                            <textarea name="" id="" cols="30" rows="10"></textarea>
                        </td>
                        <td><input type="radio" name="#"></td>
                        <td><input type="radio" name="#"></td>
                    </tr>
                    <tr>
                        <td colspan="3"><h4>Meal plan</h4></td>
                    </tr>
                    <tr>
                        <td>
                            <p>Breakfast</p>
                        </td>
                        <td><input type="radio" name="#"></td>
                        <td><input type="radio" name="#"></td>
                    </tr>
                    <tr>
                        <td>
                            <p>Dinner</p>
                        </td>
                        <td><input type="radio" name="#"></td>
                        <td><input type="radio" name="#"></td>
                    </tr>
                    <tr>
                        <td>
                            <p>Welcome Drink on Arrival</p>
                        </td>
                        <td><input type="radio" name="#"></td>
                        <td><input type="radio" name="#"></td>
                    </tr>
                    
                    <tr>
                        <td colspan="3"><h4>Transport</h4></td>
                    </tr>
                    <tr>
                        <td>
                            <p>Flight Tickets</p>
                        </td>
                        <td><input type="radio" name="#"></td>
                        <td><input type="radio" name="#"></td>
                    </tr>
                    <tr>
                        <td>
                            <p>Arrival - Airport Transfer</p>
                        </td>
                        <td><input type="radio" name="#"></td>
                        <td><input type="radio" name="#"></td>
                    </tr>
                    <tr>
                        <td>
                            <p>Departure - Airport Transfer</p>
                        </td>
                        <td><input type="radio" name="#"></td>
                        <td><input type="radio" name="#"></td>
                    </tr>
                    <tr>
                        <td>
                            <p>Volvo Bus Tickets </p>
                        </td>
                        <td><input type="radio" name="#"></td>
                        <td><input type="radio" name="#"></td>
                    </tr>
                    <tr>
                        <td>
                            <p>Rail tickets</p>
                        </td>
                        <td><input type="radio" name="#"></td>
                        <td><input type="radio" name="#"></td>
                    </tr>
                    <tr>
                        <td>
                            <p>Cab for Transport</p>
                            <textarea name="" id="" cols="30" rows="10"></textarea>
                        </td>
                        <td><input type="radio" name="#"></td>
                        <td><input type="radio" name="#"></td>
                    </tr>
                    <tr>
                        <td colspan="3"> <h4>Sightseeing</h4> </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Local Sightseeing</p>
                            <textarea name="" id="" cols="30" rows="10"></textarea>
                        </td>
                        <td><input type="radio" name="#"></td>
                        <td><input type="radio" name="#"></td>
                    </tr>
                    <tr>
                        <td>
                            <p>Cab for sightseeing</p>
                        </td>
                        <td><input type="radio" name="#"></td>
                        <td><input type="radio" name="#"></td>
                    </tr>
                    <tr>
                        <td>
                            <p>Rohtang Permit </p>
                        </td>
                        <td><input type="radio" name="#"></td>
                        <td><input type="radio" name="#"></td>
                    </tr>
                    <tr>
                        <td colspan="3"><h4>Honeymoon Inclusions</h4></td>
                    </tr>
                    <tr>
                        <td>
                            <p>Honeymoon Inclusions</p>
                            <textarea name="" id="" cols="30" rows="10"></textarea>
                        </td>
                        <td><input type="radio" name="#"></td>
                        <td><input type="radio" name="#"></td>
                    </tr>
                    <tr>
                        <td>
                            <p>Government Taxes/VAT/ Service Charges</p>
                        </td>
                        <td><input type="radio" name="#"></td>
                        <td><input type="radio" name="#"></td>
                    </tr>
                    <tr>
                        <td colspan="3"><h4>Others</h4></td>
                    </tr>
                    <tr>
                        <td>
                            <p>Other Inclusions</p>
                        </td>
                        <td><input type="radio" name="#"></td>
                        <td><input type="radio" name="#"></td>
                    </tr>
                    <tr>
                        <td>
                            <p>Other Exclusions</p>
                        </td>
                        <td><input type="radio" name="#"></td>
                        <td><input type="radio" name="#"></td>
                    </tr>
                    <tr>
                        <td colspan="3"><input type="submit" name="#" value="Save & Preview"> <a onClick="clickhere_close()">Cancel</a></td>
                    </tr>
                </table>
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

<script>
	function show1(){
	  document.getElementById('perperson').style.display ='none';
	  document.getElementById('totlecost').style.display ='block';
	  document.getElementById('perperson2').style.display ='none';
	  document.getElementById('totlecost2').style.display ='block';
	}
	function show2(){
	  document.getElementById('perperson').style.display = 'block';
	  document.getElementById('totlecost').style.display ='none';
	  document.getElementById('perperson2').style.display = 'block';
	  document.getElementById('totlecost2').style.display ='none';
	}
	
	$('#flcost, #vscost, #lndcost, #totlecost').change(function(){
    var flcost = parseFloat($('#flcost').val()) || 0;
    var vscost = parseFloat($('#vscost').val()) || 0;
	var lndcost = parseFloat($('#lndcost').val()) || 0;
	var totlecost = (flcost + vscost + lndcost);
	$('#totlecostt').val(totlecost); 
	$('#aftcomsn').val(totlecost - 5000); 
	
});
</script>
<script>
	function clickhere() {
		$('.inclusions_form_dv_pop').addClass('shows');
		}
	function clickhere_close() {
		$('.inclusions_form_dv_pop').removeClass('shows');
		}
</script>
</body>
</html>
<?php } } } else{ echo "<script>location.assign('".$url."agent/logout.php')</script>"; }
} } else{ echo "<script>location.assign('".$url."agent/logout.php')</script>"; }
      } else{ echo "<script>location.assign('".$url."agent/logout.php')</script>"; }
?>


