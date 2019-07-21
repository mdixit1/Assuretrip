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
    <link href="css/see.css" type="text/css" rel="stylesheet"/>
	<link href="css/responsive-manage.css" type="text/css" rel="stylesheet"/>
	<link href="css/index.css" type="text/css" rel="stylesheet"/>
    <link href="css/style_manage.css" type="text/css" rel="stylesheet" />
    <link href="css/styleplus.css" type="text/css" rel="stylesheet"/>
    <link href="css/examples.css" type="text/css" rel="stylesheet"/>
    
    
</head>
<body>
<div class="see-section wrapper_mg">

<div class="see-section main_dv main_dv2"> 
    
    <div class="col-md-12 p0 rightsidebar side_header2">
        <?php include('rightheader.php');?>
        <div class="col-md-12 rightsidebar_top2 notititle">
        	<h4>TRIP ID 4598257</h4>
        </div>
		<div class="fulldv comparemain_sect">
        	<div class="col-md-6">
            	<div class="fulldv comparemain">
                	<table class="see-table">
                    	<tr>
                        	<th colspan="3"> <i class="fa fa-rupee"></i> &nbsp; 32,000 Total (15 May 2019) - Your Quote</th>
                        </tr>
                        <tr>
                        	<td colspan="3">
                            	<h4><i class="fa fa-file-text-o"></i> &nbsp; Basic Details</h4>
                            </td>
                        </tr>
                        <tr>
                        	<td>
                            	<p>Trip Type</p>
                            </td>
                        	<td>
                            	<p>Destination </p>
                                Manali
                            </td>
                        	<td>
                            	<p>Duration</p>
                                4 Days 3 Nights
                            </td>
                        </tr>
                        <tr>
                        	<th colspan="3"><i class="fa fa-hotel"></i> &nbsp; Hotel Details</th>
                        </tr>
                        <tr>
                        	<td colspan="3">
                            	<h5>Night 1, Hotel Aplin Hillden, Shimla, Deluxe ,</h5>
                                <h5>Night 2,3, Snow Heaven Resort, Manali, Luxury , Mounrtain View</h5>
                            </td>
                        </tr>
                        <tr>
                        	<th colspan="3"><i class="fa fa-plane"></i> &nbsp; Flight(s)</th>
                        </tr>
                        <tr>
                        	<td colspan="3"> NA	</td>
                        </tr>
                        <tr>
                        	<th colspan="3"><i class="fa fa-car"></i> &nbsp; Cab Details</th>
                        </tr>
                        <tr>
                        	<td colspan="3">Ac Sedan Pvt cab for Entire Trip(Ac will not work on hill Station)</td>
                        </tr>
                        <tr>
                        	<th colspan="3"><i class="fa fa-puzzle-piece"></i> &nbsp; Inclusions/Exclusions</th>
                        </tr>
                        <tr>
                        	<td colspan="3">
                            	<h6>Inclusions</h6>
                                <h5>Accomodation : Hotel (Very Good Hotels) </h5>
                                <h5>Meal plan : Breakfast</h5>
                                <h5>Meal plan : Dinner</h5>
                                <h5>Meal plan : Welcome Drink on Arrival</h5>
                                <h5>Transport : Arrival - Airport Transfer</h5>
                                <h5>Transport : Departure - Airport Transfer</h5>
                                <h5>Transport : Cab for Transport (Ac Sedan Pvt Cab)</h5>
                                <h5>Sightseeing : Local Sightseeing (As per itinerary with Verified Driver)</h5>
                                <h5>Sightseeing : Cab for sightseeing</h5>
                                <h5>Honeymoon Inclusions : Honeymoon Inclusions ( (Honeymoon Inclusions : Honeymoon Inclusions (Candle light dinner , flower bed decoration , honeymoon cake for one night )) ) Government Taxes/VAT/ Service Charges</h5>
                            </td>
                        </tr>
                        <tr>
                        	<td colspan="3">
                            	<h6>Exclusion</h6>
                                <h5>Accomodation : Hotel (Very Good Hotels) </h5>
                                <h5>Meal plan : Breakfast</h5>
                                <h5>Meal plan : Dinner</h5>
                                <h5>Meal plan : Welcome Drink on Arrival</h5>
                                <h5>Transport : Arrival - Airport Transfer</h5>
                                <h5>Transport : Departure - Airport Transfer</h5>
                                <h5>Transport : Cab for Transport (Ac Sedan Pvt Cab)</h5>
                                <h5>Sightseeing : Local Sightseeing (As per itinerary with Verified Driver)</h5>
                                <h5>Sightseeing : Cab for sightseeing</h5>
                                <h5>Honeymoon Inclusions : Honeymoon Inclusions ( (Honeymoon Inclusions : Honeymoon Inclusions (Candle light dinner , flower bed decoration , honeymoon cake for one night )) ) Government Taxes/VAT/ Service Charges</h5>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-md-6">
            	<div class="fulldv comparemain">
                	<table class="see-table">
                    	<tr>
                        	<th colspan="3"> <i class="fa fa-rupee"></i> &nbsp; 32,000 Total (15 May 2019) - Your Quote</th>
                        </tr>
                        <tr>
                        	<td colspan="3">
                            	<h4><i class="fa fa-file-text-o"></i> &nbsp; Basic Details</h4>
                            </td>
                        </tr>
                        <tr>
                        	<td>
                            	<p>Trip Type</p>
                            </td>
                        	<td>
                            	<p>Destination </p>
                                Manali
                            </td>
                        	<td>
                            	<p>Duration</p>
                                4 Days 3 Nights
                            </td>
                        </tr>
                        <tr>
                        	<th colspan="3"><i class="fa fa-hotel"></i> &nbsp; Hotel Details</th>
                        </tr>
                        <tr>
                        	<td colspan="3">
                            	<h5>Night 1, Hotel Aplin Hillden, Shimla, Deluxe ,</h5>
                                <h5>Night 2,3, Snow Heaven Resort, Manali, Luxury , Mounrtain View</h5>
                            </td>
                        </tr>
                        <tr>
                        	<th colspan="3"><i class="fa fa-plane"></i> &nbsp; Flight(s)</th>
                        </tr>
                        <tr>
                        	<td colspan="3"> NA	</td>
                        </tr>
                        <tr>
                        	<th colspan="3"><i class="fa fa-car"></i> &nbsp; Cab Details</th>
                        </tr>
                        <tr>
                        	<td colspan="3">Ac Sedan Pvt cab for Entire Trip(Ac will not work on hill Station)</td>
                        </tr>
                        <tr>
                        	<th colspan="3"><i class="fa fa-puzzle-piece"></i> &nbsp; Inclusions/Exclusions</th>
                        </tr>
                        <tr>
                        	<td colspan="3">
                            	<h6>Inclusions</h6>
                                <h5>Accomodation : Hotel (Very Good Hotels) </h5>
                                <h5>Meal plan : Breakfast</h5>
                                <h5>Meal plan : Dinner</h5>
                                <h5>Meal plan : Welcome Drink on Arrival</h5>
                                <h5>Transport : Arrival - Airport Transfer</h5>
                                <h5>Transport : Departure - Airport Transfer</h5>
                                <h5>Transport : Cab for Transport (Ac Sedan Pvt Cab)</h5>
                                <h5>Sightseeing : Local Sightseeing (As per itinerary with Verified Driver)</h5>
                                <h5>Sightseeing : Cab for sightseeing</h5>
                                <h5>Honeymoon Inclusions : Honeymoon Inclusions ( (Honeymoon Inclusions : Honeymoon Inclusions (Candle light dinner , flower bed decoration , honeymoon cake for one night )) ) Government Taxes/VAT/ Service Charges</h5>
                            </td>
                        </tr>
                        <tr>
                        	<td colspan="3">
                            	<h6>Exclusion</h6>
                                <h5>Accomodation : Hotel (Very Good Hotels) </h5>
                                <h5>Meal plan : Breakfast</h5>
                                <h5>Meal plan : Dinner</h5>
                                <h5>Meal plan : Welcome Drink on Arrival</h5>
                                <h5>Transport : Arrival - Airport Transfer</h5>
                                <h5>Transport : Departure - Airport Transfer</h5>
                                <h5>Transport : Cab for Transport (Ac Sedan Pvt Cab)</h5>
                                <h5>Sightseeing : Local Sightseeing (As per itinerary with Verified Driver)</h5>
                                <h5>Sightseeing : Cab for sightseeing</h5>
                                <h5>Honeymoon Inclusions : Honeymoon Inclusions ( (Honeymoon Inclusions : Honeymoon Inclusions (Candle light dinner , flower bed decoration , honeymoon cake for one night )) ) Government Taxes/VAT/ Service Charges</h5>
                            </td>
                        </tr>
                    </table>
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
<?php } } else{ echo "<script>location.assign('".$url."agent/logout.php')</script>"; }
      } else{ echo "<script>location.assign('".$url."agent/logout.php')</script>"; } ?>

