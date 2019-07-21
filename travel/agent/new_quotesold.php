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
								$qday = $_POST['qday'];
								$qngt = $_POST['qnight'];
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
								$itdate = $_POST['itdate'];
								$dyone = $_POST['dyone'];
								$onedesc = $_POST['onedesc'];
								$dytwo = $_POST['dytwo'];
								$twodesc = $_POST['twodesc'];
								$tcond = $_POST['tcond'];
								$othrinfo = $_POST['othrinfo'];
								$add_quotation = $db->prepare("INSERT INTO agent_quotation(qag_id,qlead_id,day,night,person,currency,flight_cost,visa_cost,land_cost,total_cost,total_night,hotel_name,cityy,categry,room_type,comment,flight_include,flight_detail,cab_include,cab_detail,itinerary_date,first_day,first_desc,second_day,second_desc,terms_condition,other_info,quotation_date)VALUES(:agid, :lid, :qday, :qngt, :per, :curcy, :flcost, :vscost, :lndcost, :totl_cost, :nght, :hname, :cty, :cat, :roomtyp, :commnt, :fltype, :fdetil, :cab, :cbdetail, :itdate, :dyone, :onedesc, :dytwo, :twodesc, :tcond, :othrinfo, :date)");
								$add_quotation->bindParam(':agid',$agid);
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
								$add_quotation->bindParam(':itdate',$itdate);
								$add_quotation->bindParam(':dyone',$dyone);
								$add_quotation->bindParam(':onedesc',$onedesc);
								$add_quotation->bindParam(':dytwo',$dytwo);
								$add_quotation->bindParam(':twodesc',$twodesc);
								$add_quotation->bindParam(':tcond',$tcond);
								$add_quotation->bindParam(':othrinfo',$othrinfo);
								$add_quotation->bindParam(':date',$date);
								$add_quotation->execute();
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
            	<div class="fulldv trav_requirement">
                	<h4>Traveler's Requirement</h4>
                    <table class="see-table">
                    	<tr>
                        	<td>Starting Date</td>
                        	<td><?php echo date('d-M-Y', strtotime($row['departure_date'])); ?></td>
                        </tr>
                        <tr>
                        	<td>Duration</td>
                        	<td>5 Days & 4 Nights</td>
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
                        <tr>
                        	<td>Children Age</td>
                        	<td>NA</td>
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
                        	<td>Transport from home city?</td>
                            <td>Yes</td>
                        </tr>
                        <tr>
                        	<td>Cab services</td>
                            <td>Driver speaks: <?php echo $row['cab_language']; ?></td>
                        </tr>
                        <tr>
                        	<td>Choose Pick - up point</td>
                            <td>Other</td>
                        </tr>
                        <tr>
                        	<td>Type of tour you want?</td>
                            <td><?php echo $row['type_of_tour']; ?></td>
                        </tr>
                        <tr>
                        	<td>Meal preference?</td>
                            <td>Non-Vegetarian</td>
                        </tr>
                        <tr>
                        	<td>Places you want to cover in this tour?</td>
                            <td>Manali (3 nights)</td>
                        </tr>
                        <tr>
                        	<td>Local Experiences</td>
                            <td>
                            	<ul>
                                	<li>Trekking & Safari - Spiti</li>
                                    <li>Shimla</li>
                                    <li>Beas Circuit, Adventure - Manali</li>
                                    <li>Kullu Dusshera Mela</li>
                                    <li>Chail - Highest Cricket Ground</li>
                                </ul>
                            </td>
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
                            <input type="text" name="qday" required>
                        </div>
                        <div class="col-md-2">
                            <p>Nights</p>
                            <input type="text" name="qnight" required>
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
                            <input type="text" name="hname">
                        </div>
                        <div class="col-md-3">
                        	<p>City</p>
                            <input type="text" name="cty">
                        </div>
                        <div class="col-md-2">
                        	<p>Category</p><!-- in star e.g. 3 star -->
                            <input type="text" name="cat">
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
                            <textarea name="commnt" id="" cols="30" rows="10"></textarea>
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
                            <textarea name="fdetil" id="" cols="30" rows="10" placeholder=" Flight Details"></textarea>
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
                            	<p><input type="checkbox" name="cab" value="1" class="car_del"> Cab Details</p>
                            </div>
                            <div class="fulldv answer">
                            <textarea name="cbdetail" id="" cols="30" rows="10" placeholder=" Flight Details"></textarea>
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
                    	<h3><i class="fa fa-puzzle-piece"></i> &nbsp;  Inclusions/Exclusions <span style="font-size:13px;">Click here to add</span></h3>
                        <div class="col-md-12 inclusions_tbl">
                        	<table class="see-table">
                            	<tr>
                                	<td>Inclusions
                                    	<div class="fulldv inclusions">
                                        	<ul>
                                            	<li>Accomodation 
                                                	<ul>
                                                    	<li>Hotel
                                                        	<ul>
                                                            	<li>Taj</li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li>Meal plan  
                                                	<ul>
                                                    	<li>Breakfast</li>
                                                    </ul>
                                                </li>
                                                <li>Others 
                                                	<ul>
                                                    	<li>Other Inclusions
                                                        	<ul>
                                                            	<li>testing</li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                            
                                        </div>
                                    </td>
                                    <td>Exclusions
                                    	<div class="fulldv inclusions exclusions">
                                        	<ul>
                                            	<li>Accomodation 
                                                	<ul>
                                                    	<li>Camp Stay
                                                        	<ul>
                                                            	<li>testing</li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li>Meal plan  
                                                	<ul>
                                                    	<li>Dinner</li>
                                                        <li>Welcome Drink on Arrival</li>
                                                    </ul>
                                                </li>
                                                <li>Transport 
                                                	<ul>
                                                    	<li>Flight Tickets</li>
                                                    	<li>Arrival - Airport Transfer</li>
                                                    	<li>Departure - Airport Transfer</li>
                                                    	<li>Volvo Bus Tickets </li>
                                                    	<li>Rail tickets</li>
                                                        <li>Cab for Transport
                                                        	<ul>
                                                            	<li>testing</li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li>Sightseeing 
                                                	<ul>
                                                    	<li>Local Sightseeing
                                                        	<ul>
                                                            	<li>testing</li>
                                                            </ul>
                                                        </li>
                                                        <li>Cab for sightseeing</li>
                                                        <li>Rohtang Permit </li>
                                                    </ul>
                                                </li>
                                                <li>Honeymoon Inclusions  
                                                	<ul>
                                                    	<li>Honeymoon Inclusions
                                                        	<ul>
                                                            	<li>testing</li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li>Government Taxes/VAT/ Service Charges</li>
                                                <li>Others 
                                                	<ul>
                                                    	<li>Other Exclusions
                                                        	<ul>
                                                            	<li>testing</li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                            
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class="fulldv">
                    	<h3><i class="fa fa-sun-o"></i> &nbsp;  Day wise Itinerary</h3>
                        <div class="col-md-3">
                        	Itinerary Start Date
                            <input type="text" name="itdate" id="datepicker" autocomplete="off">
                        </div>
                        <div class="fulldv">
                            <div class="col-md-6">
                                <p>Day 1 : Title (07 June 2019)</p>
                                <input type="text" name="dyone">
                            </div>
                            <div class="col-md-12">
                            	<p>Description</p>
                                <textarea name="onedesc" id="" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="fulldv">
                            <div class="col-md-6">
                                <p>Day 2 : Title (08 June 2019)</p>
                                <input type="text" name="dytwo">
                            </div>
                            <div class="col-md-12">
                            	<p>Description</p>
                                <textarea name="twodesc" id="" cols="30" rows="10"></textarea>
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
	$('#aftcomsn').val(totlecost + 5000); 
	
});
</script>
</body>
</html>
<?php } } } else{ echo "<script>location.assign('".$url."agent/logout.php')</script>"; }
} } else{ echo "<script>location.assign('".$url."agent/logout.php')</script>"; }
      } else{ echo "<script>location.assign('".$url."agent/logout.php')</script>"; }
?>


