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
    
    
</head>
<body>
<div class="see-section wrapper_mg">

<div class="see-section main_dv main_dv2"> 
    
    <div class="col-md-12 p0 rightsidebar side_header2">
        <?php include('rightheader.php');?>
        
        <div class="col-md-12 rightsidebar_top2 notititle calendar">
        	<h4><i class="fa fa-calendar"></i> Calendar</h4>
            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#report1">Performance</a></li>
              <li><a data-toggle="tab" href="#report2">Revenue</a></li>
              <li><a data-toggle="tab" href="#report3">Converted Trips</a></li>
              <li><a data-toggle="tab" href="#report4">Cancelled Trips</a></li>
              <li><a data-toggle="tab" href="#report5">Reviews</a></li>
            </ul>
        </div>
        
        
        <div class="fulldv view_report_sect">
        	<div class="fulldv destination_select_main">
            	<p>From</p><input type="text" name="#" id="select-from" placeholder="Date" autocomplete="off"><p>To</p><input type="text" name="#" id="select-till" placeholder="Date" autocomplete="off">
                <div class="destination_select">
                	<p>Destination</p>
                    <ul>
                    	<li><input type="checkbox"> Kerela</li>
                        <li><input type="checkbox"> Himachal</li>
                        <li><input type="submit" value="Apply"></li>
                    </ul>
                </div>
            </div>
            
            <div class="tab-content">
                  <div id="report1" class="tab-pane fade in active">
                  	  <div class="">
                      	  <ul class="nav nav-tabs">
                              <li class="active"><a data-toggle="tab" href="#fil1">By Spoc</a></li>
                              <li><a data-toggle="tab" href="#fil2">By Destination</a></li>
                              <li><a data-toggle="tab" href="#fil3">By Day</a></li>
                              <li><a data-toggle="tab" href="#fil4">By Week</a></li>
                              <li><a data-toggle="tab" href="#fil5">By Month</a></li>
                          </ul>
                      </div>
                      <div class="fulldv">
                      	  <div class="tab-content">
                              <div id="fil1" class="tab-pane fade in active">
                                   <div class="col-md-6 p0">
                                   <div class="fulldv table_headtext">
                                      <p>Review Activity </p>
                                      <p>Last updated at: 17 May 09:43 AM</p>
                                   </div>
                                   <div class="table-scroll">
                                      <div class="table-wrap">
                                        <table class="main-table">
                                          <thead>
                                            <tr>
                                              <th class="fixed-side" scope="col">Metric</th>
                                              <th scope="col">Assure Trips</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <tr>
                                              <th class="fixed-side"><strong>Primary Metric</strong></th>
                                              <td></td>
                                            </tr>
                                            <?php
												$show_given = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid");
												$show_given->bindParam(':agid',$agid);
												$show_given->execute();
												$showgvn = $show_given->fetchColumn();
											?>
                                            <tr>
                                              <th class="fixed-side">Leads Given</th>
                                              <td><?php echo $showgvn; ?></td>
                                            </tr>
                                            <?php
												$quoted_trip = $db->prepare("SELECT COUNT(quotation_id) FROM agent_quotation WHERE qag_id=:agid");
												$quoted_trip->bindParam(':agid',$agid);
												$quoted_trip->execute();
												$qtrip = $quoted_trip->fetchColumn();
											?>
                                            <tr>
                                              <th class="fixed-side">Quoted Trips</th>
                                              <td><?php echo $qtrip; ?></td>
                                            </tr>
                                            <?php
												$convrtd_trip = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND confirm_status!='0'");
												$convrtd_trip->bindParam(':agid',$agid);
												$convrtd_trip->execute();
												$cvrttrip = $convrtd_trip->fetchColumn();
											?>
                                            <tr>
                                              <th class="fixed-side">Converted Trips</th>
                                              <td><?php echo $cvrttrip; ?></td>
                                            </tr>
                                            <?php
												$other_bked = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid!=:agid");
												$other_bked->bindParam(':agid',$agid);
												$other_bked->execute();
												$othrbkd = $other_bked->fetchColumn();
											?>
                                            <tr>
                                              <th class="fixed-side">Booked by Others</th>
                                              <td><?php echo $othrbkd; ?></td>
                                            </tr>
                                            <tr>
                                              <th class="fixed-side"><strong>Miscellaneous Metric</strong></th>
                                              <td></td>
                                            </tr>
                                         <?php
											$totl_note = $db->prepare("SELECT COUNT(agnote_id) FROM agent_note WHERE agnt_id=:agid");
											$totl_note->bindParam(':agid',$agid);
											$totl_note->execute();
											$totlnte = $totl_note->fetchColumn();
										?>   
                                            <tr>
                                              <th class="fixed-side">No. of Notes Added</th>
                                              <td><?php echo $totlnte; ?></td>
                                            </tr>
                                            <tr>
                                              <th class="fixed-side">Comments by Traveler</th>
                                              <td>125</td>
                                            </tr>
                                        <?php
											$usr_comt = $db->prepare("SELECT COUNT(ltt.transfer_id) FROM lead_transfer ltt JOIN leads lds ON lds.leads_id=ltt.traf_leadid WHERE ltt.traf_agid=:agid AND lds.user_comment!=''");
											$usr_comt->bindParam(':agid',$agid);
											$usr_comt->execute();
											$contucmt = $usr_comt->fetchColumn();
										?>    
                                            <tr>
                                              <th class="fixed-side">Comments by Agent</th>
                                              <td><?php echo $contucmt; ?></td>
                                            </tr>
                                          </tbody>
                                        </table>
                                      </div>
                                    </div>
                                   </div>
                              </div>
                              <div id="fil2" class="tab-pane fade">
                                   <div class="fulldv table_headtext">
                                      <p>Review Activity </p>
                                      <p>Last updated at: 17 May 09:43 AM</p>
                                   </div>
                                   <div class="table-scroll">
                                      <div class="table-wrap">
                                        <table class="main-table">
                                          <thead>
                                            <tr>
                                              <th class="fixed-side" scope="col">Metric</th>
                                              <th scope="col">Himachal</th>
                                              <th scope="col">Kerala</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <tr>
                                              <th class="fixed-side"><strong>Primary Metric</strong></th>
                                              <td></td>
                                              <td></td>
                                            </tr>
                                            <tr>
                                              <th class="fixed-side">Leads Given</th>
                                              <td>15</td>
                                              <td>55</td>
                                            </tr>
                                            <tr>
                                              <th class="fixed-side">Quoted Trips</th>
                                              <td>54</td>
                                              <td>42</td>
                                            </tr>
                                            <tr>
                                              <th class="fixed-side">Converted Trips</th>
                                              <td>62</td>
                                              <td>14</td>
                                            </tr>
                                            <tr>
                                              <th class="fixed-side">Booked by Others</th>
                                              <td>56</td>
                                              <td>85</td>
                                            </tr>
                                            <tr>
                                              <th class="fixed-side"><strong>Miscellaneous Metric</strong></th>
                                              <td></td>
                                              <td></td>
                                            </tr>
                                            <tr>
                                              <th class="fixed-side">Got Phone Number</th>
                                              <td>152</td>
                                              <td>24</td>
                                            </tr>
                                            <tr>
                                              <th class="fixed-side">No. of Notes Added</th>
                                              <td>654</td>
                                              <td>44</td>
                                            </tr>
                                            <tr>
                                              <th class="fixed-side">Comments by Traveler</th>
                                              <td>125</td>
                                              <td>65</td>
                                            </tr>
                                            <tr>
                                              <th class="fixed-side">Comments by Agent</th>
                                              <td>148</td>
                                              <td>67</td>
                                            </tr>
                                          </tbody>
                                        </table>
                                      </div>
                                    </div>
                              </div>
                              <div id="fil3" class="tab-pane fade">
                                   <div class="fulldv table_headtext">
                                      <p>Review Activity </p>
                                      <p>Last updated at: 17 May 09:43 AM</p>
                                   </div>
                                   <div id="table-scrollno2" class="table-scroll">
                                      <div class="table-wrap">
                                        <table class="main-table2">
                                          <thead>
                                            <tr>
                                              <th class="fixed-side" scope="col">Metric</th>
                                              <th scope="col"><?php echo date('Y'); ?>-<?php echo date('m'); ?>-01</th>
                                              <th scope="col"><?php echo date('Y'); ?>-<?php echo date('m'); ?>-02</th>
                                              <th scope="col"><?php echo date('Y'); ?>-<?php echo date('m'); ?>-03</th>
                                              <th scope="col"><?php echo date('Y'); ?>-<?php echo date('m'); ?>-04</th>
                                              <th scope="col"><?php echo date('Y'); ?>-<?php echo date('m'); ?>-05</th>
                                              <th scope="col"><?php echo date('Y'); ?>-<?php echo date('m'); ?>-06</th>
                                              <th scope="col"><?php echo date('Y'); ?>-<?php echo date('m'); ?>-07</th>
                                              <th scope="col"><?php echo date('Y'); ?>-<?php echo date('m'); ?>-08</th>
                                              <th scope="col"><?php echo date('Y'); ?>-<?php echo date('m'); ?>-09</th>
                                              <th scope="col"><?php echo date('Y'); ?>-<?php echo date('m'); ?>-10</th>
                                              <th scope="col"><?php echo date('Y'); ?>-<?php echo date('m'); ?>-11</th>
                                              <th scope="col"><?php echo date('Y'); ?>-<?php echo date('m'); ?>-12</th>
                                              <th scope="col"><?php echo date('Y'); ?>-<?php echo date('m'); ?>-13</th>
                                              <th scope="col"><?php echo date('Y'); ?>-<?php echo date('m'); ?>-14</th>
                                              <th scope="col"><?php echo date('Y'); ?>-<?php echo date('m'); ?>-15</th>
                                              <th scope="col"><?php echo date('Y'); ?>-<?php echo date('m'); ?>-16</th>
                                              <th scope="col"><?php echo date('Y'); ?>-<?php echo date('m'); ?>-17</th>
                                              <th scope="col"><?php echo date('Y'); ?>-<?php echo date('m'); ?>-18</th>
                                              <th scope="col"><?php echo date('Y'); ?>-<?php echo date('m'); ?>-19</th>
                                              <th scope="col"><?php echo date('Y'); ?>-<?php echo date('m'); ?>-20</th>
                                              <th scope="col"><?php echo date('Y'); ?>-<?php echo date('m'); ?>-21</th>
                                              <th scope="col"><?php echo date('Y'); ?>-<?php echo date('m'); ?>-22</th>
                                              <th scope="col"><?php echo date('Y'); ?>-<?php echo date('m'); ?>-23</th>
                                              <th scope="col"><?php echo date('Y'); ?>-<?php echo date('m'); ?>-24</th>
                                              <th scope="col"><?php echo date('Y'); ?>-<?php echo date('m'); ?>-25</th>
                                              <th scope="col"><?php echo date('Y'); ?>-<?php echo date('m'); ?>-26</th>
                                              <th scope="col"><?php echo date('Y'); ?>-<?php echo date('m'); ?>-27</th>
                                              <th scope="col"><?php echo date('Y'); ?>-<?php echo date('m'); ?>-28</th>
                                              <th scope="col"><?php echo date('Y'); ?>-<?php echo date('m'); ?>-29</th>
                                              <th scope="col"><?php echo date('Y'); ?>-<?php echo date('m'); ?>-30</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <tr>
                                              <th class="fixed-side"><strong>Primary Metric</strong></th>
                                              <td colspan="30"></td>
                                            </tr>
                                            <tr>
                                              <th class="fixed-side">Leads Given</th>
                                           <?php
												$done = date('Y-m-01');
												$query_one = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND lstart_date=:done");
												$query_one->bindParam(':done',$done);
												$query_one->bindParam(':agid',$agid);
												$query_one->execute();
												$count_one = $query_one->fetchColumn();
										   ?>   
                                              <td><?php echo $count_one; ?></td>
                                           <?php
												$dtwo = date('Y-m-02');
												$query_two = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND lstart_date=:dtwo");
												$query_two->bindParam(':dtwo',$dtwo);
												$query_two->bindParam(':agid',$agid);
												$query_two->execute();
												$count_two = $query_two->fetchColumn();
										   ?>   
                                              <td><?php echo $count_two; ?></td>
                                           <?php
												$dthree = date('Y-m-03');
												$query_three = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND lstart_date=:dthree");
												$query_three->bindParam(':dthree',$dthree);
												$query_three->bindParam(':agid',$agid);
												$query_three->execute();
												$count_three = $query_three->fetchColumn();
										   ?>   
                                              <td><?php echo $count_three; ?></td>
                                           <?php
												$dfour = date('Y-m-04');
												$query_four = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND lstart_date=:dfour");
												$query_four->bindParam(':dfour',$dfour);
												$query_four->bindParam(':agid',$agid);
												$query_four->execute();
												$count_four = $query_four->fetchColumn();
										   ?>   
                                              <td><?php echo $count_four; ?></td>
                                           <?php
												$dfive = date('Y-m-05');
												$query_five = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND lstart_date=:dfive");
												$query_five->bindParam(':dfive',$dfive);
												$query_five->bindParam(':agid',$agid);
												$query_five->execute();
												$count_five = $query_five->fetchColumn();
										   ?>   
                                              <td><?php echo $count_five; ?></td>
                                           <?php
												$dsix = date('Y-m-06');
												$query_six = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND lstart_date=:dsix");
												$query_six->bindParam(':dsix',$dsix);
												$query_six->bindParam(':agid',$agid);
												$query_six->execute();
												$count_six = $query_six->fetchColumn();
										   ?>   
                                              <td><?php echo $count_six; ?></td>
                                           <?php
												$dsevn = date('Y-m-07');
												$query_sevn = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND lstart_date=:dsevn");
												$query_sevn->bindParam(':dsevn',$dsevn);
												$query_sevn->bindParam(':agid',$agid);
												$query_sevn->execute();
												$count_sevn = $query_sevn->fetchColumn();
										   ?>   
                                              <td><?php echo $count_sevn; ?></td>
                                           <?php
												$deight = date('Y-m-08');
												$query_eight = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND lstart_date=:deight");
												$query_eight->bindParam(':deight',$deight);
												$query_eight->bindParam(':agid',$agid);
												$query_eight->execute();
												$count_eight = $query_eight->fetchColumn();
										   ?>   
                                              <td><?php echo $count_eight; ?></td>
                                           <?php
												$dnine = date('Y-m-09');
												$query_nine = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND lstart_date=:dnine");
												$query_nine->bindParam(':dnine',$dnine);
												$query_nine->bindParam(':agid',$agid);
												$query_nine->execute();
												$count_nine = $query_nine->fetchColumn();
										   ?>   
                                              <td><?php echo $count_nine; ?></td>
                                           <?php
												$dten = date('Y-m-10');
												$query_ten = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND lstart_date=:dten");
												$query_ten->bindParam(':dten',$dten);
												$query_ten->bindParam(':agid',$agid);
												$query_ten->execute();
												$count_ten = $query_ten->fetchColumn();
										   ?>   
                                              <td><?php echo $count_ten; ?></td>
                                           <?php
												$delvn = date('Y-m-11');
												$query_elvn = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND lstart_date=:delvn");
												$query_elvn->bindParam(':delvn',$delvn);
												$query_elvn->bindParam(':agid',$agid);
												$query_elvn->execute();
												$count_elvn = $query_elvn->fetchColumn();
										   ?>   
                                              <td><?php echo $count_elvn; ?></td>
                                           <?php
												$dtwlve = date('Y-m-12');
												$query_twlve = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND lstart_date=:dtwlve");
												$query_twlve->bindParam(':dtwlve',$dtwlve);
												$query_twlve->bindParam(':agid',$agid);
												$query_twlve->execute();
												$count_twlve = $query_twlve->fetchColumn();
										   ?>   
                                              <td><?php echo $count_twlve; ?></td>
                                           <?php
												$dthrten = date('Y-m-13');
												$query_thrten = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND lstart_date=:dthrten");
												$query_thrten->bindParam(':dthrten',$dthrten);
												$query_thrten->bindParam(':agid',$agid);
												$query_thrten->execute();
												$count_thrten = $query_thrten->fetchColumn();
										   ?>   
                                              <td><?php echo $count_thrten; ?></td>
                                           <?php
												$dforten = date('Y-m-14');
												$query_forten = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND lstart_date=:dforten");
												$query_forten->bindParam(':dforten',$dforten);
												$query_forten->bindParam(':agid',$agid);
												$query_forten->execute();
												$count_forten = $query_forten->fetchColumn();
										   ?>   
                                              <td><?php echo $count_forten; ?></td>
                                           <?php
												$dfiften = date('Y-m-15');
												$query_fiften = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND lstart_date=:dfiften");
												$query_fiften->bindParam(':dfiften',$dfiften);
												$query_fiften->bindParam(':agid',$agid);
												$query_fiften->execute();
												$count_fiften = $query_fiften->fetchColumn();
										   ?>   
                                              <td><?php echo $count_fiften; ?></td>
                                          <?php
												$dsxten = date('Y-m-16');
												$query_sxten = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND lstart_date=:dsxten");
												$query_sxten->bindParam(':dsxten',$dsxten);
												$query_sxten->bindParam(':agid',$agid);
												$query_sxten->execute();
												$count_sxten = $query_sxten->fetchColumn();
										   ?>    
                                              <td><?php echo $count_sxten; ?></td>
                                          <?php
												$dsvnten = date('Y-m-17');
												$query_svnten = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND lstart_date=:dsvnten");
												$query_svnten->bindParam(':dsvnten',$dsvnten);
												$query_svnten->bindParam(':agid',$agid);
												$query_svnten->execute();
												$count_svnten = $query_svnten->fetchColumn();
										   ?>    
                                              <td><?php echo $count_svnten; ?></td>
                                           <?php
												$deghten = date('Y-m-18');
												$query_eghten = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND lstart_date=:deghten");
												$query_eghten->bindParam(':deghten',$deghten);
												$query_eghten->bindParam(':agid',$agid);
												$query_eghten->execute();
												$count_eghten = $query_eghten->fetchColumn();
										   ?>   
                                              <td><?php echo $count_eghten; ?></td>
                                           <?php
												$dninten = date('Y-m-19');
												$query_ninten = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND lstart_date=:dninten");
												$query_ninten->bindParam(':dninten',$dninten);
												$query_ninten->bindParam(':agid',$agid);
												$query_ninten->execute();
												$count_ninten = $query_ninten->fetchColumn();
										   ?>   
                                              <td><?php echo $count_ninten; ?></td>
                                           <?php
												$dtwntn = date('Y-m-20');
												$query_twntn = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND lstart_date=:dtwntn");
												$query_twntn->bindParam(':dtwntn',$dtwntn);
												$query_twntn->bindParam(':agid',$agid);
												$query_twntn->execute();
												$count_twntn = $query_twntn->fetchColumn();
										   ?>    
                                              <td><?php echo $count_twntn; ?></td>
                                           <?php
												$dtwntone = date('Y-m-21');
												$query_twntone = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND lstart_date=:dtwntone");
												$query_twntone->bindParam(':dtwntone',$dtwntone);
												$query_twntone->bindParam(':agid',$agid);
												$query_twntone->execute();
												$count_twntone = $query_twntone->fetchColumn();
										   ?>   
                                              <td><?php echo $count_twntone; ?></td>
                                           <?php
												$dtwnttwo = date('Y-m-22');
												$query_twnttwo = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND lstart_date=:dtwnttwo");
												$query_twnttwo->bindParam(':dtwnttwo',$dtwnttwo);
												$query_twnttwo->bindParam(':agid',$agid);
												$query_twnttwo->execute();
												$count_twnttwo = $query_twnttwo->fetchColumn();
										   ?>   
                                              <td><?php echo $count_twnttwo; ?></td>
                                            <?php
												$dtwntthre = date('Y-m-23');
												$query_twntthre = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND lstart_date=:dtwntthre");
												$query_twntthre->bindParam(':dtwntthre',$dtwntthre);
												$query_twntthre->bindParam(':agid',$agid);
												$query_twntthre->execute();
												$count_twntthre = $query_twntthre->fetchColumn();
										   ?>   
                                              <td><?php echo $count_twntthre; ?></td>
                                           <?php
												$dtwntfour = date('Y-m-24');
												$query_twntfour = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND lstart_date=:dtwntfour");
												$query_twntfour->bindParam(':dtwntfour',$dtwntfour);
												$query_twntfour->bindParam(':agid',$agid);
												$query_twntfour->execute();
												$count_twntfour = $query_twntfour->fetchColumn();
										   ?>   
                                              <td><?php echo $count_twntfour; ?></td>
                                           <?php
												$dtwntfive = date('Y-m-25');
												$query_twntfive = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND lstart_date=:dtwntfive");
												$query_twntfive->bindParam(':dtwntfive',$dtwntfive);
												$query_twntfive->bindParam(':agid',$agid);
												$query_twntfive->execute();
												$count_twntfive = $query_twntfive->fetchColumn();
										   ?>   
                                              <td><?php echo $count_twntfive; ?></td>
                                          <?php
												$dtwntsix = date('Y-m-26');
												$query_twntsix = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND lstart_date=:dtwntsix");
												$query_twntsix->bindParam(':dtwntsix',$dtwntsix);
												$query_twntsix->bindParam(':agid',$agid);
												$query_twntsix->execute();
												$count_twntsix = $query_twntsix->fetchColumn();
										   ?>    
                                              <td><?php echo $count_twntsix; ?></td>
                                           <?php
												$dtwntsevn = date('Y-m-27');
												$query_twntsevn = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND lstart_date=:dtwntsevn");
												$query_twntsevn->bindParam(':dtwntsevn',$dtwntsevn);
												$query_twntsevn->bindParam(':agid',$agid);
												$query_twntsevn->execute();
												$count_twntsevn = $query_twntsevn->fetchColumn();
										   ?>   
                                              <td><?php echo $count_twntsevn; ?></td>
                                           <?php
												$dtwnteght = date('Y-m-28');
												$query_twnteght = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND lstart_date=:dtwnteght");
												$query_twnteght->bindParam(':dtwnteght',$dtwnteght);
												$query_twnteght->bindParam(':agid',$agid);
												$query_twnteght->execute();
												$count_twnteght = $query_twnteght->fetchColumn();
										   ?>   
                                              <td><?php echo $count_twnteght; ?></td>
                                           <?php
												$dtwntnine = date('Y-m-29');
												$query_twntnine = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND lstart_date=:dtwntnine");
												$query_twntnine->bindParam(':dtwntnine',$dtwntnine);
												$query_twntnine->bindParam(':agid',$agid);
												$query_twntnine->execute();
												$count_twntnine = $query_twntnine->fetchColumn();
										   ?>   
                                              <td><?php echo $count_twntnine; ?></td>
                                           <?php
												$dthirty = date('Y-m-30');
												$query_thirty = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND lstart_date=:dthirty");
												$query_thirty->bindParam(':dthirty',$dthirty);
												$query_thirty->bindParam(':agid',$agid);
												$query_thirty->execute();
												$count_thirty = $query_thirty->fetchColumn();
										   ?>   
                                              <td><?php echo $count_thirty; ?></td>   
                                            </tr>
                                            <tr>
                                              <th class="fixed-side">Quoted Trips</th>
                                           <?php
												$done1 = date('Y-m-01');
												$query_one1 = $db->prepare("SELECT COUNT(quotation_id) FROM agent_quotation WHERE qag_id=:agid AND quotation_date=:done1");
												$query_one1->bindParam(':done1',$done1);
												$query_one1->bindParam(':agid',$agid);
												$query_one1->execute();
												$count_one1 = $query_one1->fetchColumn();
										   ?>   
                                              <td><?php echo $count_one1; ?></td>
                                           <?php
												$dtwo1 = date('Y-m-02');
												$query_two1 = $db->prepare("SELECT COUNT(quotation_id) FROM agent_quotation WHERE qag_id=:agid AND quotation_date=:dtwo1");
												$query_two1->bindParam(':dtwo1',$dtwo1);
												$query_two1->bindParam(':agid',$agid);
												$query_two1->execute();
												$count_two1 = $query_two1->fetchColumn();
										   ?>   
                                              <td><?php echo $count_two1; ?></td>
                                           <?php
												$dthree1 = date('Y-m-03');
												$query_three1 = $db->prepare("SELECT COUNT(quotation_id) FROM agent_quotation WHERE qag_id=:agid AND quotation_date=:dthree1");
												$query_three1->bindParam(':dthree1',$dthree1);
												$query_three1->bindParam(':agid',$agid);
												$query_three1->execute();
												$count_three1 = $query_three1->fetchColumn();
										   ?>   
                                              <td><?php echo $count_three1; ?></td>
                                           <?php
												$dfour1 = date('Y-m-04');
												$query_four1 = $db->prepare("SELECT COUNT(quotation_id) FROM agent_quotation WHERE qag_id=:agid AND quotation_date=:dfour1");
												$query_four1->bindParam(':dfour1',$dfour1);
												$query_four1->bindParam(':agid',$agid);
												$query_four1->execute();
												$count_four1 = $query_four1->fetchColumn();
										   ?>   
                                              <td><?php echo $count_four1; ?></td>
                                           <?php
												$dfive1 = date('Y-m-05');
												$query_five1 = $db->prepare("SELECT COUNT(quotation_id) FROM agent_quotation WHERE qag_id=:agid AND quotation_date=:dfive1");
												$query_five1->bindParam(':dfive1',$dfive1);
												$query_five1->bindParam(':agid',$agid);
												$query_five1->execute();
												$count_five1 = $query_five1->fetchColumn();
										   ?>   
                                              <td><?php echo $count_five1; ?></td>
                                           <?php
												$dsix1 = date('Y-m-06');
												$query_six1 = $db->prepare("SELECT COUNT(quotation_id) FROM agent_quotation WHERE qag_id=:agid AND quotation_date=:dsix1");
												$query_six1->bindParam(':dsix1',$dsix1);
												$query_six1->bindParam(':agid',$agid);
												$query_six1->execute();
												$count_six1 = $query_six1->fetchColumn();
										   ?>   
                                              <td><?php echo $count_six1; ?></td>
                                           <?php
												$dsevn1 = date('Y-m-07');
												$query_sevn1 = $db->prepare("SELECT COUNT(quotation_id) FROM agent_quotation WHERE qag_id=:agid AND quotation_date=:dsevn1");
												$query_sevn1->bindParam(':dsevn1',$dsevn1);
												$query_sevn1->bindParam(':agid',$agid);
												$query_sevn1->execute();
												$count_sevn1 = $query_sevn1->fetchColumn();
										   ?>   
                                              <td><?php echo $count_sevn1; ?></td>
                                           <?php
												$deight1 = date('Y-m-08');
												$query_eight1 = $db->prepare("SELECT COUNT(quotation_id) FROM agent_quotation WHERE qag_id=:agid AND quotation_date=:deight1");
												$query_eight1->bindParam(':deight1',$deight1);
												$query_eight1->bindParam(':agid',$agid);
												$query_eight1->execute();
												$count_eight1 = $query_eight1->fetchColumn();
										   ?>   
                                              <td><?php echo $count_eight1; ?></td>
                                           <?php
												$dnine1 = date('Y-m-09');
												$query_nine1 = $db->prepare("SELECT COUNT(quotation_id) FROM agent_quotation WHERE qag_id=:agid AND quotation_date=:dnine1");
												$query_nine1->bindParam(':dnine1',$dnine1);
												$query_nine1->bindParam(':agid',$agid);
												$query_nine1->execute();
												$count_nine1 = $query_nine1->fetchColumn();
										   ?>   
                                              <td><?php echo $count_nine1; ?></td>
                                           <?php
												$dten1 = date('Y-m-10');
												$query_ten1 = $db->prepare("SELECT COUNT(quotation_id) FROM agent_quotation WHERE qag_id=:agid AND quotation_date=:dten1");
												$query_ten1->bindParam(':dten1',$dten1);
												$query_ten1->bindParam(':agid',$agid);
												$query_ten1->execute();
												$count_ten1 = $query_ten1->fetchColumn();
										   ?>   
                                              <td><?php echo $count_ten1; ?></td>
                                           <?php
												$delvn1 = date('Y-m-11');
												$query_elvn1 = $db->prepare("SELECT COUNT(quotation_id) FROM agent_quotation WHERE qag_id=:agid AND quotation_date=:delvn1");
												$query_elvn1->bindParam(':delvn1',$delvn1);
												$query_elvn1->bindParam(':agid',$agid);
												$query_elvn1->execute();
												$count_elvn1 = $query_elvn1->fetchColumn();
										   ?>   
                                              <td><?php echo $count_elvn1; ?></td>
                                           <?php
												$dtwlve1 = date('Y-m-12');
												$query_twlve1 = $db->prepare("SELECT COUNT(quotation_id) FROM agent_quotation WHERE qag_id=:agid AND quotation_date=:dtwlve1");
												$query_twlve1->bindParam(':dtwlve1',$dtwlve1);
												$query_twlve1->bindParam(':agid',$agid);
												$query_twlve1->execute();
												$count_twlve1 = $query_twlve1->fetchColumn();
										   ?>   
                                              <td><?php echo $count_twlve1; ?></td>
                                           <?php
												$dthrten1 = date('Y-m-13');
												$query_thrten1 = $db->prepare("SELECT COUNT(quotation_id) FROM agent_quotation WHERE qag_id=:agid AND quotation_date=:dthrten1");
												$query_thrten1->bindParam(':dthrten1',$dthrten1);
												$query_thrten1->bindParam(':agid',$agid);
												$query_thrten1->execute();
												$count_thrten1 = $query_thrten1->fetchColumn();
										   ?>   
                                              <td><?php echo $count_thrten1; ?></td>
                                           <?php
												$dforten1 = date('Y-m-14');
												$query_forten1 = $db->prepare("SELECT COUNT(quotation_id) FROM agent_quotation WHERE qag_id=:agid AND quotation_date=:dforten1");
												$query_forten1->bindParam(':dforten1',$dforten1);
												$query_forten1->bindParam(':agid',$agid);
												$query_forten1->execute();
												$count_forten1 = $query_forten1->fetchColumn();
										   ?>   
                                              <td><?php echo $count_forten1; ?></td>
                                           <?php
												$dfiften1 = date('Y-m-15');
												$query_fiften1 = $db->prepare("SELECT COUNT(quotation_id) FROM agent_quotation WHERE qag_id=:agid AND quotation_date=:dfiften1");
												$query_fiften1->bindParam(':dfiften1',$dfiften1);
												$query_fiften1->bindParam(':agid',$agid);
												$query_fiften1->execute();
												$count_fiften1 = $query_fiften1->fetchColumn();
										   ?>   
                                              <td><?php echo $count_fiften1; ?></td>
                                          <?php
												$dsxten1 = date('Y-m-16');
												$query_sxten1 = $db->prepare("SELECT COUNT(quotation_id) FROM agent_quotation WHERE qag_id=:agid AND quotation_date=:dsxten1");
												$query_sxten1->bindParam(':dsxten1',$dsxten1);
												$query_sxten1->bindParam(':agid',$agid);
												$query_sxten1->execute();
												$count_sxten1 = $query_sxten1->fetchColumn();
										   ?>    
                                              <td><?php echo $count_sxten1; ?></td>
                                          <?php
												$dsvnten1 = date('Y-m-17');
												$query_svnten1 = $db->prepare("SELECT COUNT(quotation_id) FROM agent_quotation WHERE qag_id=:agid AND quotation_date=:dsvnten1");
												$query_svnten1->bindParam(':dsvnten1',$dsvnten1);
												$query_svnten1->bindParam(':agid',$agid);
												$query_svnten1->execute();
												$count_svnten1 = $query_svnten1->fetchColumn();
										   ?>    
                                              <td><?php echo $count_svnten1; ?></td>
                                           <?php
												$deghten1 = date('Y-m-18');
												$query_eghten1 = $db->prepare("SELECT COUNT(quotation_id) FROM agent_quotation WHERE qag_id=:agid AND quotation_date=:deghten1");
												$query_eghten1->bindParam(':deghten1',$deghten1);
												$query_eghten1->bindParam(':agid',$agid);
												$query_eghten1->execute();
												$count_eghten1 = $query_eghten1->fetchColumn();
										   ?>   
                                              <td><?php echo $count_eghten1; ?></td>
                                           <?php
												$dninten1 = date('Y-m-19');
												$query_ninten1 = $db->prepare("SELECT COUNT(quotation_id) FROM agent_quotation WHERE qag_id=:agid AND quotation_date=:dninten1");
												$query_ninten1->bindParam(':dninten1',$dninten1);
												$query_ninten1->bindParam(':agid',$agid);
												$query_ninten1->execute();
												$count_ninten1 = $query_ninten1->fetchColumn();
										   ?>   
                                              <td><?php echo $count_ninten1; ?></td>
                                           <?php
												$dtwntn1 = date('Y-m-20');
												$query_twntn1 = $db->prepare("SELECT COUNT(quotation_id) FROM agent_quotation WHERE qag_id=:agid AND quotation_date=:dtwntn1");
												$query_twntn1->bindParam(':dtwntn1',$dtwntn1);
												$query_twntn1->bindParam(':agid',$agid);
												$query_twntn1->execute();
												$count_twntn1 = $query_twntn1->fetchColumn();
										   ?>    
                                              <td><?php echo $count_twntn1; ?></td>
                                           <?php
												$dtwntone1 = date('Y-m-21');
												$query_twntone1 = $db->prepare("SELECT COUNT(quotation_id) FROM agent_quotation WHERE qag_id=:agid AND quotation_date=:dtwntone1");
												$query_twntone1->bindParam(':dtwntone1',$dtwntone1);
												$query_twntone1->bindParam(':agid',$agid);
												$query_twntone1->execute();
												$count_twntone1 = $query_twntone1->fetchColumn();
										   ?>   
                                              <td><?php echo $count_twntone1; ?></td>
                                           <?php
												$dtwnttwo1 = date('Y-m-22');
												$query_twnttwo1 = $db->prepare("SELECT COUNT(quotation_id) FROM agent_quotation WHERE qag_id=:agid AND quotation_date=:dtwnttwo1");
												$query_twnttwo1->bindParam(':dtwnttwo1',$dtwnttwo1);
												$query_twnttwo1->bindParam(':agid',$agid);
												$query_twnttwo1->execute();
												$count_twnttwo1 = $query_twnttwo1->fetchColumn();
										   ?>   
                                              <td><?php echo $count_twnttwo1; ?></td>
                                            <?php
												$dtwntthre1 = date('Y-m-23');
												$query_twntthre1 = $db->prepare("SELECT COUNT(quotation_id) FROM agent_quotation WHERE qag_id=:agid AND quotation_date=:dtwntthre1");
												$query_twntthre1->bindParam(':dtwntthre1',$dtwntthre1);
												$query_twntthre1->bindParam(':agid',$agid);
												$query_twntthre1->execute();
												$count_twntthre1 = $query_twntthre1->fetchColumn();
										   ?>   
                                              <td><?php echo $count_twntthre1; ?></td>
                                           <?php
												$dtwntfour1 = date('Y-m-24');
												$query_twntfour1 = $db->prepare("SELECT COUNT(quotation_id) FROM agent_quotation WHERE qag_id=:agid AND quotation_date=:dtwntfour1");
												$query_twntfour1->bindParam(':dtwntfour1',$dtwntfour1);
												$query_twntfour1->bindParam(':agid',$agid);
												$query_twntfour1->execute();
												$count_twntfour1 = $query_twntfour1->fetchColumn();
										   ?>   
                                              <td><?php echo $count_twntfour1; ?></td>
                                           <?php
												$dtwntfive1 = date('Y-m-25');
												$query_twntfive1 = $db->prepare("SELECT COUNT(quotation_id) FROM agent_quotation WHERE qag_id=:agid AND quotation_date=:dtwntfive1");
												$query_twntfive1->bindParam(':dtwntfive1',$dtwntfive1);
												$query_twntfive1->bindParam(':agid',$agid);
												$query_twntfive1->execute();
												$count_twntfive1 = $query_twntfive1->fetchColumn();
										   ?>   
                                              <td><?php echo $count_twntfive1; ?></td>
                                          <?php
												$dtwntsix1 = date('Y-m-26');
												$query_twntsix1 = $db->prepare("SELECT COUNT(quotation_id) FROM agent_quotation WHERE qag_id=:agid AND quotation_date=:dtwntsix1");
												$query_twntsix1->bindParam(':dtwntsix1',$dtwntsix1);
												$query_twntsix1->bindParam(':agid',$agid);
												$query_twntsix1->execute();
												$count_twntsix1 = $query_twntsix1->fetchColumn();
										   ?>    
                                              <td><?php echo $count_twntsix1; ?></td>
                                           <?php
												$dtwntsevn1 = date('Y-m-27');
												$query_twntsevn1 = $db->prepare("SELECT COUNT(quotation_id) FROM agent_quotation WHERE qag_id=:agid AND quotation_date=:dtwntsevn1");
												$query_twntsevn1->bindParam(':dtwntsevn1',$dtwntsevn1);
												$query_twntsevn1->bindParam(':agid',$agid);
												$query_twntsevn1->execute();
												$count_twntsevn1 = $query_twntsevn1->fetchColumn();
										   ?>   
                                              <td><?php echo $count_twntsevn1; ?></td>
                                           <?php
												$dtwnteght1 = date('Y-m-28');
												$query_twnteght1 = $db->prepare("SELECT COUNT(quotation_id) FROM agent_quotation WHERE qag_id=:agid AND quotation_date=:dtwnteght1");
												$query_twnteght1->bindParam(':dtwnteght1',$dtwnteght1);
												$query_twnteght1->bindParam(':agid',$agid);
												$query_twnteght1->execute();
												$count_twnteght1 = $query_twnteght1->fetchColumn();
										   ?>   
                                              <td><?php echo $count_twnteght1; ?></td>
                                           <?php
												$dtwntnine1 = date('Y-m-29');
												$query_twntnine1 = $db->prepare("SELECT COUNT(quotation_id) FROM agent_quotation WHERE qag_id=:agid AND quotation_date=:dtwntnine1");
												$query_twntnine1->bindParam(':dtwntnine1',$dtwntnine1);
												$query_twntnine1->bindParam(':agid',$agid);
												$query_twntnine1->execute();
												$count_twntnine1 = $query_twntnine1->fetchColumn();
										   ?>   
                                              <td><?php echo $count_twntnine1; ?></td>
                                           <?php
												$dthirty1 = date('Y-m-30');
												$query_thirty1 = $db->prepare("SELECT COUNT(quotation_id) FROM agent_quotation WHERE qag_id=:agid AND quotation_date=:dthirty1");
												$query_thirty1->bindParam(':dthirty1',$dthirty1);
												$query_thirty1->bindParam(':agid',$agid);
												$query_thirty1->execute();
												$count_thirty1 = $query_thirty1->fetchColumn();
										   ?>   
                                              <td><?php echo $count_thirty1; ?></td>
                                            </tr>
                                            
                                            <tr>
                                              <th class="fixed-side">Converted Trips</th>
                                              <?php
												$done2 = date('Y-m-01');
												$query_one2 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND confirm_status!='0' AND lstart_date=:done2");
												$query_one2->bindParam(':done2',$done2);
												$query_one2->bindParam(':agid',$agid);
												$query_one2->execute();
												$count_one2 = $query_one2->fetchColumn();
										   ?>   
                                              <td><?php echo $count_one2; ?></td>
                                           <?php
												$dtwo2 = date('Y-m-02');
												$query_two2 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND confirm_status!='0' AND lstart_date=:dtwo2");
												$query_two2->bindParam(':dtwo2',$dtwo2);
												$query_two2->bindParam(':agid',$agid);
												$query_two2->execute();
												$count_two2 = $query_two2->fetchColumn();
										   ?>   
                                              <td><?php echo $count_two2; ?></td>
                                           <?php
												$dthree2 = date('Y-m-03');
												$query_three2 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND confirm_status!='0' AND lstart_date=:dthree2");
												$query_three2->bindParam(':dthree2',$dthree2);
												$query_three2->bindParam(':agid',$agid);
												$query_three2->execute();
												$count_three2 = $query_three2->fetchColumn();
										   ?>   
                                              <td><?php echo $count_three2; ?></td>
                                           <?php
												$dfour2 = date('Y-m-04');
												$query_four2 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND confirm_status!='0' AND lstart_date=:dfour2");
												$query_four2->bindParam(':dfour2',$dfour2);
												$query_four2->bindParam(':agid',$agid);
												$query_four2->execute();
												$count_four2 = $query_four2->fetchColumn();
										   ?>   
                                              <td><?php echo $count_four2; ?></td>
                                           <?php
												$dfive2 = date('Y-m-05');
												$query_five2 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND confirm_status!='0' AND lstart_date=:dfive2");
												$query_five2->bindParam(':dfive2',$dfive2);
												$query_five2->bindParam(':agid',$agid);
												$query_five2->execute();
												$count_five2 = $query_five2->fetchColumn();
										   ?>   
                                              <td><?php echo $count_five2; ?></td>
                                           <?php
												$dsix2 = date('Y-m-06');
												$query_six2 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND confirm_status!='0' AND lstart_date=:dsix2");
												$query_six2->bindParam(':dsix2',$dsix2);
												$query_six2->bindParam(':agid',$agid);
												$query_six2->execute();
												$count_six2 = $query_six2->fetchColumn();
										   ?>   
                                              <td><?php echo $count_six2; ?></td>
                                           <?php
												$dsevn2 = date('Y-m-07');
												$query_sevn2 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND confirm_status!='0' AND lstart_date=:dsevn2");
												$query_sevn2->bindParam(':dsevn2',$dsevn2);
												$query_sevn2->bindParam(':agid',$agid);
												$query_sevn2->execute();
												$count_sevn2 = $query_sevn2->fetchColumn();
										   ?>   
                                              <td><?php echo $count_sevn2; ?></td>
                                           <?php
												$deight2 = date('Y-m-08');
												$query_eight2 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND confirm_status!='0' AND lstart_date=:deight2");
												$query_eight2->bindParam(':deight2',$deight2);
												$query_eight2->bindParam(':agid',$agid);
												$query_eight2->execute();
												$count_eight2 = $query_eight2->fetchColumn();
										   ?>   
                                              <td><?php echo $count_eight2; ?></td>
                                           <?php
												$dnine2 = date('Y-m-09');
												$query_nine2 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND confirm_status!='0' AND lstart_date=:dnine2");
												$query_nine2->bindParam(':dnine2',$dnine2);
												$query_nine2->bindParam(':agid',$agid);
												$query_nine2->execute();
												$count_nine2 = $query_nine2->fetchColumn();
										   ?>   
                                              <td><?php echo $count_nine2; ?></td>
                                           <?php
												$dten2 = date('Y-m-10');
												$query_ten2 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND confirm_status!='0' AND lstart_date=:dten2");
												$query_ten2->bindParam(':dten2',$dten2);
												$query_ten2->bindParam(':agid',$agid);
												$query_ten2->execute();
												$count_ten2 = $query_ten2->fetchColumn();
										   ?>   
                                              <td><?php echo $count_ten2; ?></td>
                                           <?php
												$delvn2 = date('Y-m-11');
												$query_elvn2 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND confirm_status!='0' AND lstart_date=:delvn2");
												$query_elvn2->bindParam(':delvn2',$delvn2);
												$query_elvn2->bindParam(':agid',$agid);
												$query_elvn2->execute();
												$count_elvn2 = $query_elvn2->fetchColumn();
										   ?>   
                                              <td><?php echo $count_elvn2; ?></td>
                                           <?php
												$dtwlve2 = date('Y-m-12');
												$query_twlve2 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND confirm_status!='0' AND lstart_date=:dtwlve2");
												$query_twlve2->bindParam(':dtwlve2',$dtwlve2);
												$query_twlve2->bindParam(':agid',$agid);
												$query_twlve2->execute();
												$count_twlve2 = $query_twlve2->fetchColumn();
										   ?>   
                                              <td><?php echo $count_twlve2; ?></td>
                                           <?php
												$dthrten2 = date('Y-m-13');
												$query_thrten2 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND confirm_status!='0' AND lstart_date=:dthrten2");
												$query_thrten2->bindParam(':dthrten2',$dthrten2);
												$query_thrten2->bindParam(':agid',$agid);
												$query_thrten2->execute();
												$count_thrten2 = $query_thrten2->fetchColumn();
										   ?>   
                                              <td><?php echo $count_thrten2; ?></td>
                                           <?php
												$dforten2 = date('Y-m-14');
												$query_forten2 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND confirm_status!='0' AND lstart_date=:dforten2");
												$query_forten2->bindParam(':dforten2',$dforten2);
												$query_forten2->bindParam(':agid',$agid);
												$query_forten2->execute();
												$count_forten2 = $query_forten2->fetchColumn();
										   ?>   
                                              <td><?php echo $count_forten2; ?></td>
                                           <?php
												$dfiften2 = date('Y-m-15');
												$query_fiften2 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND confirm_status!='0' AND lstart_date=:dfiften2");
												$query_fiften2->bindParam(':dfiften2',$dfiften2);
												$query_fiften2->bindParam(':agid',$agid);
												$query_fiften2->execute();
												$count_fiften2 = $query_fiften2->fetchColumn();
										   ?>   
                                              <td><?php echo $count_fiften2; ?></td>
                                          <?php
												$dsxten2 = date('Y-m-16');
												$query_sxten2 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND confirm_status!='0' AND lstart_date=:dsxten2");
												$query_sxten2->bindParam(':dsxten2',$dsxten2);
												$query_sxten2->bindParam(':agid',$agid);
												$query_sxten2->execute();
												$count_sxten2 = $query_sxten2->fetchColumn();
										   ?>    
                                              <td><?php echo $count_sxten2; ?></td>
                                          <?php
												$dsvnten2 = date('Y-m-17');
												$query_svnten2 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND confirm_status!='0' AND lstart_date=:dsvnten2");
												$query_svnten2->bindParam(':dsvnten2',$dsvnten2);
												$query_svnten2->bindParam(':agid',$agid);
												$query_svnten2->execute();
												$count_svnten2 = $query_svnten2->fetchColumn();
										   ?>    
                                              <td><?php echo $count_svnten2; ?></td>
                                           <?php
												$deghten2 = date('Y-m-18');
												$query_eghten2 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND confirm_status!='0' AND lstart_date=:deghten2");
												$query_eghten2->bindParam(':deghten2',$deghten2);
												$query_eghten2->bindParam(':agid',$agid);
												$query_eghten2->execute();
												$count_eghten2 = $query_eghten2->fetchColumn();
										   ?>   
                                              <td><?php echo $count_eghten2; ?></td>
                                           <?php
												$dninten2 = date('Y-m-19');
												$query_ninten2 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND confirm_status!='0' AND lstart_date=:dninten2");
												$query_ninten2->bindParam(':dninten2',$dninten2);
												$query_ninten2->bindParam(':agid',$agid);
												$query_ninten2->execute();
												$count_ninten2 = $query_ninten2->fetchColumn();
										   ?>   
                                              <td><?php echo $count_ninten2; ?></td>
                                           <?php
												$dtwntn2 = date('Y-m-20');
												$query_twntn2 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND confirm_status!='0' AND lstart_date=:dtwntn2");
												$query_twntn2->bindParam(':dtwntn2',$dtwntn2);
												$query_twntn2->bindParam(':agid',$agid);
												$query_twntn2->execute();
												$count_twntn2 = $query_twntn2->fetchColumn();
										   ?>    
                                              <td><?php echo $count_twntn2; ?></td>
                                           <?php
												$dtwntone2 = date('Y-m-21');
												$query_twntone2 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND confirm_status!='0' AND lstart_date=:dtwntone2");
												$query_twntone2->bindParam(':dtwntone2',$dtwntone2);
												$query_twntone2->bindParam(':agid',$agid);
												$query_twntone2->execute();
												$count_twntone2 = $query_twntone2->fetchColumn();
										   ?>   
                                              <td><?php echo $count_twntone2; ?></td>
                                           <?php
												$dtwnttwo2 = date('Y-m-22');
												$query_twnttwo2 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND confirm_status!='0' AND lstart_date=:dtwnttwo2");
												$query_twnttwo2->bindParam(':dtwnttwo2',$dtwnttwo2);
												$query_twnttwo2->bindParam(':agid',$agid);
												$query_twnttwo2->execute();
												$count_twnttwo2 = $query_twnttwo2->fetchColumn();
										   ?>   
                                              <td><?php echo $count_twnttwo2; ?></td>
                                            <?php
												$dtwntthre2 = date('Y-m-23');
												$query_twntthre2 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND confirm_status!='0' AND lstart_date=:dtwntthre2");
												$query_twntthre2->bindParam(':dtwntthre2',$dtwntthre2);
												$query_twntthre2->bindParam(':agid',$agid);
												$query_twntthre2->execute();
												$count_twntthre2 = $query_twntthre2->fetchColumn();
										   ?>   
                                              <td><?php echo $count_twntthre2; ?></td>
                                           <?php
												$dtwntfour2 = date('Y-m-24');
												$query_twntfour2 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND confirm_status!='0' AND lstart_date=:dtwntfour2");
												$query_twntfour2->bindParam(':dtwntfour2',$dtwntfour2);
												$query_twntfour2->bindParam(':agid',$agid);
												$query_twntfour2->execute();
												$count_twntfour2 = $query_twntfour2->fetchColumn();
										   ?>   
                                              <td><?php echo $count_twntfour2; ?></td>
                                           <?php
												$dtwntfive2 = date('Y-m-25');
												$query_twntfive2 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND confirm_status!='0' AND lstart_date=:dtwntfive2");
												$query_twntfive2->bindParam(':dtwntfive2',$dtwntfive2);
												$query_twntfive2->bindParam(':agid',$agid);
												$query_twntfive2->execute();
												$count_twntfive2 = $query_twntfive2->fetchColumn();
										   ?>   
                                              <td><?php echo $count_twntfive2; ?></td>
                                          <?php
												$dtwntsix2 = date('Y-m-26');
												$query_twntsix2 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND confirm_status!='0' AND lstart_date=:dtwntsix2");
												$query_twntsix2->bindParam(':dtwntsix2',$dtwntsix2);
												$query_twntsix2->bindParam(':agid',$agid);
												$query_twntsix2->execute();
												$count_twntsix2 = $query_twntsix2->fetchColumn();
										   ?>    
                                              <td><?php echo $count_twntsix2; ?></td>
                                           <?php
												$dtwntsevn2 = date('Y-m-27');
												$query_twntsevn2 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND confirm_status!='0' AND lstart_date=:dtwntsevn2");
												$query_twntsevn2->bindParam(':dtwntsevn2',$dtwntsevn2);
												$query_twntsevn2->bindParam(':agid',$agid);
												$query_twntsevn2->execute();
												$count_twntsevn2 = $query_twntsevn2->fetchColumn();
										   ?>   
                                              <td><?php echo $count_twntsevn2; ?></td>
                                           <?php
												$dtwnteght2 = date('Y-m-28');
												$query_twnteght2 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND confirm_status!='0' AND lstart_date=:dtwnteght2");
												$query_twnteght2->bindParam(':dtwnteght2',$dtwnteght2);
												$query_twnteght2->bindParam(':agid',$agid);
												$query_twnteght2->execute();
												$count_twnteght2 = $query_twnteght2->fetchColumn();
										   ?>   
                                              <td><?php echo $count_twnteght2; ?></td>
                                           <?php
												$dtwntnine2 = date('Y-m-29');
												$query_twntnine2 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND confirm_status!='0' AND lstart_date=:dtwntnine2");
												$query_twntnine2->bindParam(':dtwntnine2',$dtwntnine2);
												$query_twntnine2->bindParam(':agid',$agid);
												$query_twntnine2->execute();
												$count_twntnine2 = $query_twntnine2->fetchColumn();
										   ?>   
                                              <td><?php echo $count_twntnine2; ?></td>
                                           <?php
												$dthirty2 = date('Y-m-30');
												$query_thirty2 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND confirm_status!='0' AND lstart_date=:dthirty2");
												$query_thirty2->bindParam(':dthirty2',$dthirty2);
												$query_thirty2->bindParam(':agid',$agid);
												$query_thirty2->execute();
												$count_thirty2 = $query_thirty2->fetchColumn();
										   ?>   
                                              <td><?php echo $count_thirty2; ?></td>
                                            </tr>
                                            <tr>
                                              <th class="fixed-side">Booked by Others</th>
                                              <?php
												$done3 = date('Y-m-01');
												$query_one3 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid!=:agid AND transfer_date=:done3");
												$query_one3->bindParam(':done3',$done3);
												$query_one3->bindParam(':agid',$agid);
												$query_one3->execute();
												$count_one3 = $query_one3->fetchColumn();
										   ?>   
                                              <td><?php echo $count_one3; ?></td>
                                           <?php
												$dtwo3 = date('Y-m-02');
												$query_two3 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid!=:agid AND transfer_date=:dtwo3");
												$query_two3->bindParam(':dtwo3',$dtwo3);
												$query_two3->bindParam(':agid',$agid);
												$query_two3->execute();
												$count_two3 = $query_two3->fetchColumn();
										   ?>   
                                              <td><?php echo $count_two3; ?></td>
                                           <?php
												$dthree3 = date('Y-m-03');
												$query_three3 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid!=:agid AND transfer_date=:dthree3");
												$query_three3->bindParam(':dthree3',$dthree3);
												$query_three3->bindParam(':agid',$agid);
												$query_three3->execute();
												$count_three3 = $query_three3->fetchColumn();
										   ?>   
                                              <td><?php echo $count_three3; ?></td>
                                           <?php
												$dfour3 = date('Y-m-04');
												$query_four3 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid!=:agid AND transfer_date=:dfour3");
												$query_four3->bindParam(':dfour3',$dfour3);
												$query_four3->bindParam(':agid',$agid);
												$query_four3->execute();
												$count_four3 = $query_four3->fetchColumn();
										   ?>   
                                              <td><?php echo $count_four3; ?></td>
                                           <?php
												$dfive3 = date('Y-m-05');
												$query_five3 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid!=:agid AND transfer_date=:dfive3");
												$query_five3->bindParam(':dfive3',$dfive3);
												$query_five3->bindParam(':agid',$agid);
												$query_five3->execute();
												$count_five3 = $query_five3->fetchColumn();
										   ?>   
                                              <td><?php echo $count_five3; ?></td>
                                           <?php
												$dsix3 = date('Y-m-06');
												$query_six3 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid!=:agid AND transfer_date=:dsix3");
												$query_six3->bindParam(':dsix3',$dsix3);
												$query_six3->bindParam(':agid',$agid);
												$query_six3->execute();
												$count_six3 = $query_six3->fetchColumn();
										   ?>   
                                              <td><?php echo $count_six3; ?></td>
                                           <?php
												$dsevn3 = date('Y-m-07');
												$query_sevn3 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid!=:agid AND transfer_date=:dsevn3");
												$query_sevn3->bindParam(':dsevn3',$dsevn3);
												$query_sevn3->bindParam(':agid',$agid);
												$query_sevn3->execute();
												$count_sevn3 = $query_sevn3->fetchColumn();
										   ?>   
                                              <td><?php echo $count_sevn3; ?></td>
                                           <?php
												$deight3 = date('Y-m-08');
												$query_eight3 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid!=:agid AND transfer_date=:deight3");
												$query_eight3->bindParam(':deight3',$deight3);
												$query_eight3->bindParam(':agid',$agid);
												$query_eight3->execute();
												$count_eight3 = $query_eight3->fetchColumn();
										   ?>   
                                              <td><?php echo $count_eight3; ?></td>
                                           <?php
												$dnine3 = date('Y-m-09');
												$query_nine3 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid!=:agid AND transfer_date=:dnine3");
												$query_nine3->bindParam(':dnine3',$dnine3);
												$query_nine3->bindParam(':agid',$agid);
												$query_nine3->execute();
												$count_nine3 = $query_nine3->fetchColumn();
										   ?>   
                                              <td><?php echo $count_nine3; ?></td>
                                           <?php
												$dten3 = date('Y-m-10');
												$query_ten3 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid!=:agid AND transfer_date=:dten3");
												$query_ten3->bindParam(':dten3',$dten3);
												$query_ten3->bindParam(':agid',$agid);
												$query_ten3->execute();
												$count_ten3 = $query_ten3->fetchColumn();
										   ?>   
                                              <td><?php echo $count_ten3; ?></td>
                                           <?php
												$delvn3 = date('Y-m-11');
												$query_elvn3 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid!=:agid AND transfer_date=:delvn3");
												$query_elvn3->bindParam(':delvn3',$delvn3);
												$query_elvn3->bindParam(':agid',$agid);
												$query_elvn3->execute();
												$count_elvn3 = $query_elvn3->fetchColumn();
										   ?>   
                                              <td><?php echo $count_elvn3; ?></td>
                                           <?php
												$dtwlve3 = date('Y-m-12');
												$query_twlve3 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid!=:agid AND transfer_date=:dtwlve3");
												$query_twlve3->bindParam(':dtwlve3',$dtwlve3);
												$query_twlve3->bindParam(':agid',$agid);
												$query_twlve3->execute();
												$count_twlve3 = $query_twlve3->fetchColumn();
										   ?>   
                                              <td><?php echo $count_twlve3; ?></td>
                                           <?php
												$dthrten3 = date('Y-m-13');
												$query_thrten3 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid!=:agid AND transfer_date=:dthrten3");
												$query_thrten3->bindParam(':dthrten3',$dthrten3);
												$query_thrten3->bindParam(':agid',$agid);
												$query_thrten3->execute();
												$count_thrten3 = $query_thrten3->fetchColumn();
										   ?>   
                                              <td><?php echo $count_thrten3; ?></td>
                                           <?php
												$dforten3 = date('Y-m-14');
												$query_forten3 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid!=:agid AND transfer_date=:dforten3");
												$query_forten3->bindParam(':dforten3',$dforten3);
												$query_forten3->bindParam(':agid',$agid);
												$query_forten3->execute();
												$count_forten3 = $query_forten3->fetchColumn();
										   ?>   
                                              <td><?php echo $count_forten3; ?></td>
                                           <?php
												$dfiften3 = date('Y-m-15');
												$query_fiften3 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid!=:agid AND transfer_date=:dfiften3");
												$query_fiften3->bindParam(':dfiften3',$dfiften3);
												$query_fiften3->bindParam(':agid',$agid);
												$query_fiften3->execute();
												$count_fiften3 = $query_fiften3->fetchColumn();
										   ?>   
                                              <td><?php echo $count_fiften3; ?></td>
                                          <?php
												$dsxten3 = date('Y-m-16');
												$query_sxten3 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid!=:agid AND transfer_date=:dsxten3");
												$query_sxten3->bindParam(':dsxten3',$dsxten3);
												$query_sxten3->bindParam(':agid',$agid);
												$query_sxten3->execute();
												$count_sxten3 = $query_sxten3->fetchColumn();
										   ?>    
                                              <td><?php echo $count_sxten3; ?></td>
                                          <?php
												$dsvnten3 = date('Y-m-17');
												$query_svnten3 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid!=:agid AND transfer_date=:dsvnten3");
												$query_svnten3->bindParam(':dsvnten3',$dsvnten3);
												$query_svnten3->bindParam(':agid',$agid);
												$query_svnten3->execute();
												$count_svnten3 = $query_svnten3->fetchColumn();
										   ?>    
                                              <td><?php echo $count_svnten3; ?></td>
                                           <?php
												$deghten3 = date('Y-m-18');
												$query_eghten3 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid!=:agid AND transfer_date=:deghten3");
												$query_eghten3->bindParam(':deghten3',$deghten3);
												$query_eghten3->bindParam(':agid',$agid);
												$query_eghten3->execute();
												$count_eghten3 = $query_eghten3->fetchColumn();
										   ?>   
                                              <td><?php echo $count_eghten3; ?></td>
                                           <?php
												$dninten3 = date('Y-m-19');
												$query_ninten3 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid!=:agid AND transfer_date=:dninten3");
												$query_ninten3->bindParam(':dninten3',$dninten3);
												$query_ninten3->bindParam(':agid',$agid);
												$query_ninten3->execute();
												$count_ninten3 = $query_ninten3->fetchColumn();
										   ?>   
                                              <td><?php echo $count_ninten3; ?></td>
                                           <?php
												$dtwntn3 = date('Y-m-20');
												$query_twntn3 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid!=:agid AND transfer_date=:dtwntn3");
												$query_twntn3->bindParam(':dtwntn3',$dtwntn3);
												$query_twntn3->bindParam(':agid',$agid);
												$query_twntn3->execute();
												$count_twntn3 = $query_twntn3->fetchColumn();
										   ?>    
                                              <td><?php echo $count_twntn3; ?></td>
                                           <?php
												$dtwntone3 = date('Y-m-21');
												$query_twntone3 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid!=:agid AND transfer_date=:dtwntone3");
												$query_twntone3->bindParam(':dtwntone3',$dtwntone3);
												$query_twntone3->bindParam(':agid',$agid);
												$query_twntone3->execute();
												$count_twntone3 = $query_twntone3->fetchColumn();
										   ?>   
                                              <td><?php echo $count_twntone3; ?></td>
                                           <?php
												$dtwnttwo3 = date('Y-m-22');
												$query_twnttwo3 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid!=:agid AND transfer_date=:dtwnttwo3");
												$query_twnttwo3->bindParam(':dtwnttwo3',$dtwnttwo3);
												$query_twnttwo3->bindParam(':agid',$agid);
												$query_twnttwo3->execute();
												$count_twnttwo3 = $query_twnttwo3->fetchColumn();
										   ?>   
                                              <td><?php echo $count_twnttwo3; ?></td>
                                            <?php
												$dtwntthre3 = date('Y-m-23');
												$query_twntthre3 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid!=:agid AND transfer_date=:dtwntthre3");
												$query_twntthre3->bindParam(':dtwntthre3',$dtwntthre3);
												$query_twntthre3->bindParam(':agid',$agid);
												$query_twntthre3->execute();
												$count_twntthre3 = $query_twntthre3->fetchColumn();
										   ?>   
                                              <td><?php echo $count_twntthre3; ?></td>
                                           <?php
												$dtwntfour3 = date('Y-m-24');
												$query_twntfour3 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid!=:agid AND transfer_date=:dtwntfour3");
												$query_twntfour3->bindParam(':dtwntfour3',$dtwntfour3);
												$query_twntfour3->bindParam(':agid',$agid);
												$query_twntfour3->execute();
												$count_twntfour3 = $query_twntfour3->fetchColumn();
										   ?>   
                                              <td><?php echo $count_twntfour3; ?></td>
                                           <?php
												$dtwntfive3 = date('Y-m-25');
												$query_twntfive3 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid!=:agid AND transfer_date=:dtwntfive3");
												$query_twntfive3->bindParam(':dtwntfive3',$dtwntfive3);
												$query_twntfive3->bindParam(':agid',$agid);
												$query_twntfive3->execute();
												$count_twntfive3 = $query_twntfive3->fetchColumn();
										   ?>   
                                              <td><?php echo $count_twntfive3; ?></td>
                                          <?php
												$dtwntsix3 = date('Y-m-26');
												$query_twntsix3 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid!=:agid AND transfer_date=:dtwntsix3");
												$query_twntsix3->bindParam(':dtwntsix3',$dtwntsix3);
												$query_twntsix3->bindParam(':agid',$agid);
												$query_twntsix3->execute();
												$count_twntsix3 = $query_twntsix3->fetchColumn();
										   ?>    
                                              <td><?php echo $count_twntsix3; ?></td>
                                           <?php
												$dtwntsevn3 = date('Y-m-27');
												$query_twntsevn3 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid!=:agid AND transfer_date=:dtwntsevn3");
												$query_twntsevn3->bindParam(':dtwntsevn3',$dtwntsevn3);
												$query_twntsevn3->bindParam(':agid',$agid);
												$query_twntsevn3->execute();
												$count_twntsevn3 = $query_twntsevn3->fetchColumn();
										   ?>   
                                              <td><?php echo $count_twntsevn3; ?></td>
                                           <?php
												$dtwnteght3 = date('Y-m-28');
												$query_twnteght3 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid!=:agid AND transfer_date=:dtwnteght3");
												$query_twnteght3->bindParam(':dtwnteght3',$dtwnteght3);
												$query_twnteght3->bindParam(':agid',$agid);
												$query_twnteght3->execute();
												$count_twnteght3 = $query_twnteght3->fetchColumn();
										   ?>   
                                              <td><?php echo $count_twnteght3; ?></td>
                                           <?php
												$dtwntnine3 = date('Y-m-29');
												$query_twntnine3 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid!=:agid AND transfer_date=:dtwntnine3");
												$query_twntnine3->bindParam(':dtwntnine3',$dtwntnine3);
												$query_twntnine3->bindParam(':agid',$agid);
												$query_twntnine3->execute();
												$count_twntnine3 = $query_twntnine3->fetchColumn();
										   ?>   
                                              <td><?php echo $count_twntnine3; ?></td>
                                           <?php
												$dthirty3 = date('Y-m-30');
												$query_thirty3 = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid!=:agid AND transfer_date=:dthirty3");
												$query_thirty3->bindParam(':dthirty3',$dthirty3);
												$query_thirty3->bindParam(':agid',$agid);
												$query_thirty3->execute();
												$count_thirty3 = $query_thirty3->fetchColumn();
										   ?>   
                                              <td><?php echo $count_thirty3; ?></td>
                                            </tr>
                                            <tr>
                                              <th class="fixed-side"><strong>Miscellaneous Metric</strong></th>
                                              <td colspan="30"></td>
                                            </tr>
                                            <tr>
                                              <th class="fixed-side">No. of Notes Added</th>
                                           <?php
												$done = date('Y-m-01');
												$totl_note1 = $db->prepare("SELECT COUNT(agnote_id) FROM agent_note WHERE agnt_id=:agid AND note_date=:done");
												$totl_note1->bindParam(':agid',$agid);
												$totl_note1->bindParam(':done',$done);
												$totl_note1->execute();
												$totlnte1 = $totl_note1->fetchColumn();
										   ?>   
                                              <td><?php echo $totlnte1; ?></td>
                                           <?php
												$dtwo = date('Y-m-02');
												$totl_note2 = $db->prepare("SELECT COUNT(agnote_id) FROM agent_note WHERE agnt_id=:agid AND note_date=:dtwo");
												$totl_note2->bindParam(':agid',$agid);
												$totl_note2->bindParam(':dtwo',$dtwo);
												$totl_note2->execute();
												$totlnte2 = $totl_note2->fetchColumn();
										   ?>   
                                              <td><?php echo $totlnte2; ?></td>
                                           <?php
												$dthree = date('Y-m-03');
												$totl_note3 = $db->prepare("SELECT COUNT(agnote_id) FROM agent_note WHERE agnt_id=:agid AND note_date=:dthree");
												$totl_note3->bindParam(':agid',$agid);
												$totl_note3->bindParam(':dthree',$dthree);
												$totl_note3->execute();
												$totlnte3 = $totl_note3->fetchColumn();
										   ?>   
                                              <td><?php echo $totlnte3; ?></td>
                                           <?php
												$dfour = date('Y-m-04');
												$totl_note4 = $db->prepare("SELECT COUNT(agnote_id) FROM agent_note WHERE agnt_id=:agid AND note_date=:dfour");
												$totl_note4->bindParam(':agid',$agid);
												$totl_note4->bindParam(':dfour',$dfour);
												$totl_note4->execute();
												$totlnte4 = $totl_note4->fetchColumn();
										   ?>   
                                              <td><?php echo $totlnte4; ?></td>
                                           <?php
												$dfive = date('Y-m-05');
												$totl_note5 = $db->prepare("SELECT COUNT(agnote_id) FROM agent_note WHERE agnt_id=:agid AND note_date=:dfive");
												$totl_note5->bindParam(':agid',$agid);
												$totl_note5->bindParam(':dfive',$dfive);
												$totl_note5->execute();
												$totlnte5 = $totl_note5->fetchColumn();
										   ?>   
                                              <td><?php echo $totlnte5; ?></td>
                                           <?php
												$dsix = date('Y-m-06');
												$totl_note6 = $db->prepare("SELECT COUNT(agnote_id) FROM agent_note WHERE agnt_id=:agid AND note_date=:dsix");
												$totl_note6->bindParam(':agid',$agid);
												$totl_note6->bindParam(':dsix',$dsix);
												$totl_note6->execute();
												$totlnte6 = $totl_note6->fetchColumn();
										   ?>   
                                              <td><?php echo $totlnte6; ?></td>
                                           <?php
												$dsevn = date('Y-m-07');
												$totl_note7 = $db->prepare("SELECT COUNT(agnote_id) FROM agent_note WHERE agnt_id=:agid AND note_date=:dsevn");
												$totl_note7->bindParam(':agid',$agid);
												$totl_note7->bindParam(':dsevn',$dsevn);
												$totl_note7->execute();
												$totlnte7 = $totl_note7->fetchColumn();
										   ?>   
                                              <td><?php echo $totlnte7; ?></td>
                                           <?php
												$deight = date('Y-m-08');
												$totl_note8 = $db->prepare("SELECT COUNT(agnote_id) FROM agent_note WHERE agnt_id=:agid AND note_date=:deight");
												$totl_note8->bindParam(':agid',$agid);
												$totl_note8->bindParam(':deight',$deight);
												$totl_note8->execute();
												$totlnte8 = $totl_note8->fetchColumn();
										   ?>   
                                              <td><?php echo $totlnte8; ?></td>
                                           <?php
												$dnine = date('Y-m-09');
												$totl_note9 = $db->prepare("SELECT COUNT(agnote_id) FROM agent_note WHERE agnt_id=:agid AND note_date=:dnine");
												$totl_note9->bindParam(':agid',$agid);
												$totl_note9->bindParam(':dnine',$dnine);
												$totl_note9->execute();
												$totlnte9 = $totl_note9->fetchColumn();
										   ?>   
                                              <td><?php echo $totlnte9; ?></td>
                                           <?php
												$dten = date('Y-m-10');
												$totl_note10 = $db->prepare("SELECT COUNT(agnote_id) FROM agent_note WHERE agnt_id=:agid AND note_date=:dten");
												$totl_note10->bindParam(':agid',$agid);
												$totl_note10->bindParam(':dten',$dten);
												$totl_note10->execute();
												$totlnte10 = $totl_note10->fetchColumn();
										   ?>   
                                              <td><?php echo $totlnte10; ?></td>
                                           <?php
												$delvn = date('Y-m-11');
												$totl_note11 = $db->prepare("SELECT COUNT(agnote_id) FROM agent_note WHERE agnt_id=:agid AND note_date=:delvn");
												$totl_note11->bindParam(':agid',$agid);
												$totl_note11->bindParam(':delvn',$delvn);
												$totl_note11->execute();
												$totlnte11 = $totl_note11->fetchColumn();
										   ?>   
                                              <td><?php echo $totlnte11; ?></td>
                                           <?php
												$dtwlve = date('Y-m-12');
												$totl_note12 = $db->prepare("SELECT COUNT(agnote_id) FROM agent_note WHERE agnt_id=:agid AND note_date=:dtwlve");
												$totl_note12->bindParam(':agid',$agid);
												$totl_note12->bindParam(':dtwlve',$dtwlve);
												$totl_note12->execute();
												$totlnte12 = $totl_note12->fetchColumn();
										   ?>   
                                              <td><?php echo $totlnte12; ?></td>
                                           <?php
												$dthrten = date('Y-m-13');
												$totl_note13 = $db->prepare("SELECT COUNT(agnote_id) FROM agent_note WHERE agnt_id=:agid AND note_date=:dthrten");
												$totl_note13->bindParam(':agid',$agid);
												$totl_note13->bindParam(':dthrten',$dthrten);
												$totl_note13->execute();
												$totlnte13 = $totl_note13->fetchColumn();
										   ?>   
                                              <td><?php echo $totlnte13; ?></td>
                                           <?php
												$dforten = date('Y-m-14');
												$totl_note14 = $db->prepare("SELECT COUNT(agnote_id) FROM agent_note WHERE agnt_id=:agid AND note_date=:dforten");
												$totl_note14->bindParam(':agid',$agid);
												$totl_note14->bindParam(':dforten',$dforten);
												$totl_note14->execute();
												$totlnte14 = $totl_note14->fetchColumn();
										   ?>   
                                              <td><?php echo $totlnte14; ?></td>
                                           <?php
												$dfiften = date('Y-m-15');
												$totl_note15 = $db->prepare("SELECT COUNT(agnote_id) FROM agent_note WHERE agnt_id=:agid AND note_date=:dfiften");
												$totl_note15->bindParam(':agid',$agid);
												$totl_note15->bindParam(':dfiften',$dfiften);
												$totl_note15->execute();
												$totlnte15 = $totl_note15->fetchColumn();
										   ?>   
                                              <td><?php echo $totlnte15; ?></td>
                                          <?php
												$dsxten = date('Y-m-16');
												$totl_note16 = $db->prepare("SELECT COUNT(agnote_id) FROM agent_note WHERE agnt_id=:agid AND note_date=:dsxten");
												$totl_note16->bindParam(':agid',$agid);
												$totl_note16->bindParam(':dsxten',$dsxten);
												$totl_note16->execute();
												$totlnte16 = $totl_note16->fetchColumn();
										   ?>    
                                              <td><?php echo $totlnte16; ?></td>
                                          <?php
												$dsvnten = date('Y-m-17');
												$totl_note17 = $db->prepare("SELECT COUNT(agnote_id) FROM agent_note WHERE agnt_id=:agid AND note_date=:dsvnten");
												$totl_note17->bindParam(':agid',$agid);
												$totl_note17->bindParam(':dsvnten',$dsvnten);
												$totl_note17->execute();
												$totlnte17 = $totl_note17->fetchColumn();
										   ?>    
                                              <td><?php echo $totlnte17; ?></td>
                                           <?php
												$deghten = date('Y-m-18');
												$totl_note18 = $db->prepare("SELECT COUNT(agnote_id) FROM agent_note WHERE agnt_id=:agid AND note_date=:deghten");
												$totl_note18->bindParam(':agid',$agid);
												$totl_note18->bindParam(':deghten',$deghten);
												$totl_note18->execute();
												$totlnte18 = $totl_note18->fetchColumn();
										   ?>   
                                              <td><?php echo $totlnte18; ?></td>
                                           <?php
												$dninten = date('Y-m-19');
												$totl_note19 = $db->prepare("SELECT COUNT(agnote_id) FROM agent_note WHERE agnt_id=:agid AND note_date=:dninten");
												$totl_note19->bindParam(':agid',$agid);
												$totl_note19->bindParam(':dninten',$dninten);
												$totl_note19->execute();
												$totlnte19 = $totl_note19->fetchColumn();
										   ?>   
                                              <td><?php echo $totlnte19; ?></td>
                                           <?php
												$dtwntn = date('Y-m-20');
												$totl_note20 = $db->prepare("SELECT COUNT(agnote_id) FROM agent_note WHERE agnt_id=:agid AND note_date=:dtwntn");
												$totl_note20->bindParam(':agid',$agid);
												$totl_note20->bindParam(':dtwntn',$dtwntn);
												$totl_note20->execute();
												$totlnte20 = $totl_note20->fetchColumn();
										   ?>    
                                              <td><?php echo $totlnte20; ?></td>
                                           <?php
												$dtwntone = date('Y-m-21');
												$totl_note21 = $db->prepare("SELECT COUNT(agnote_id) FROM agent_note WHERE agnt_id=:agid AND note_date=:dtwntone");
												$totl_note21->bindParam(':agid',$agid);
												$totl_note21->bindParam(':dtwntone',$dtwntone);
												$totl_note21->execute();
												$totlnte21 = $totl_note21->fetchColumn();
										   ?>   
                                              <td><?php echo $totlnte21; ?></td>
                                           <?php
												$dtwnttwo = date('Y-m-22');
												$totl_note22 = $db->prepare("SELECT COUNT(agnote_id) FROM agent_note WHERE agnt_id=:agid AND note_date=:dtwnttwo");
												$totl_note22->bindParam(':agid',$agid);
												$totl_note22->bindParam(':dtwnttwo',$dtwnttwo);
												$totl_note22->execute();
												$totlnte22 = $totl_note22->fetchColumn();
										   ?>   
                                              <td><?php echo $totlnte22; ?></td>
                                            <?php
												$dtwntthre = date('Y-m-23');
												$totl_note23 = $db->prepare("SELECT COUNT(agnote_id) FROM agent_note WHERE agnt_id=:agid AND note_date=:dtwntthre");
												$totl_note23->bindParam(':agid',$agid);
												$totl_note23->bindParam(':dtwntthre',$dtwntthre);
												$totl_note23->execute();
												$totlnte23 = $totl_note23->fetchColumn();
										   ?>   
                                              <td><?php echo $totlnte23; ?></td>
                                           <?php
												$dtwntfour = date('Y-m-24');
												$totl_note24 = $db->prepare("SELECT COUNT(agnote_id) FROM agent_note WHERE agnt_id=:agid AND note_date=:dtwntfour");
												$totl_note24->bindParam(':agid',$agid);
												$totl_note24->bindParam(':dtwntfour',$dtwntfour);
												$totl_note24->execute();
												$totlnte24 = $totl_note24->fetchColumn();
										   ?>   
                                              <td><?php echo $totlnte24; ?></td>
                                           <?php
												$dtwntfive = date('Y-m-25');
												$totl_note25 = $db->prepare("SELECT COUNT(agnote_id) FROM agent_note WHERE agnt_id=:agid AND note_date=:dtwntfive");
												$totl_note25->bindParam(':agid',$agid);
												$totl_note25->bindParam(':dtwntfive',$dtwntfive);
												$totl_note25->execute();
												$totlnte25 = $totl_note25->fetchColumn();
										   ?>   
                                              <td><?php echo $totlnte25; ?></td>
                                          <?php
												$dtwntsix = date('Y-m-26');
												$totl_note26 = $db->prepare("SELECT COUNT(agnote_id) FROM agent_note WHERE agnt_id=:agid AND note_date=:dtwntsix");
												$totl_note26->bindParam(':agid',$agid);
												$totl_note26->bindParam(':dtwntsix',$dtwntsix);
												$totl_note26->execute();
												$totlnte26 = $totl_note26->fetchColumn();
										   ?>    
                                              <td><?php echo $totlnte26; ?></td>
                                           <?php
												$dtwntsevn = date('Y-m-27');
												$totl_note27 = $db->prepare("SELECT COUNT(agnote_id) FROM agent_note WHERE agnt_id=:agid AND note_date=:dtwntsevn");
												$totl_note27->bindParam(':agid',$agid);
												$totl_note27->bindParam(':dtwntsevn',$dtwntsevn);
												$totl_note27->execute();
												$totlnte27 = $totl_note27->fetchColumn();
										   ?>   
                                              <td><?php echo $totlnte27; ?></td>
                                           <?php
												$dtwnteght = date('Y-m-28');
												$totl_note28 = $db->prepare("SELECT COUNT(agnote_id) FROM agent_note WHERE agnt_id=:agid AND note_date=:dtwnteght");
												$totl_note28->bindParam(':agid',$agid);
												$totl_note28->bindParam(':dtwnteght',$dtwnteght);
												$totl_note28->execute();
												$totlnte28 = $totl_note28->fetchColumn();
										   ?>   
                                              <td><?php echo $totlnte28; ?></td>
                                           <?php
												$dtwntnine = date('Y-m-29');
												$totl_note29 = $db->prepare("SELECT COUNT(agnote_id) FROM agent_note WHERE agnt_id=:agid AND note_date=:dtwntnine");
												$totl_note29->bindParam(':agid',$agid);
												$totl_note29->bindParam(':dtwntnine',$dtwntnine);
												$totl_note29->execute();
												$totlnte29 = $totl_note29->fetchColumn();
										   ?>   
                                              <td><?php echo $totlnte29; ?></td>
                                           <?php
												$dthirty = date('Y-m-30');
												$totl_note30 = $db->prepare("SELECT COUNT(agnote_id) FROM agent_note WHERE agnt_id=:agid AND note_date=:dthirty");
												$totl_note30->bindParam(':agid',$agid);
												$totl_note30->bindParam(':dthirty',$dthirty);
												$totl_note30->execute();
												$totlnte30 = $totl_note30->fetchColumn();
										   ?>   
                                              <td><?php echo $totlnte30; ?></td>
                                            </tr>
                                            <tr>
                                              <th class="fixed-side">Comments by Traveler</th>
                                              <td>1</td>
                                              <td>2</td>
                                              <td>25</td>
                                              <td>25</td>
                                              <td>45</td>
                                              <td>5</td>
                                              <td>36</td>
                                              <td>54</td>
                                              <td>5</td>
                                              <td>5</td>
                                              <td>2</td>
                                              <td>85</td>
                                              <td>15</td>
                                              <td>24</td>
                                              <td>51</td>
                                              <td>42</td>
                                              <td>88</td>
                                              <td>86</td>
                                              <td>53</td>
                                              <td>55</td>
                                              <td>66</td>
                                              <td>35</td>
                                              <td>15</td>
                                              <td>85</td>
                                              <td>75</td>
                                              <td>74</td>
                                              <td>73</td>
                                              <td>81</td>
                                              <td>82</td>
                                              <td>83</td>
                                            </tr>
                                            <tr>
                                              <th class="fixed-side">Comments by Agent</th>
                                              <?php
												$done = date('Y-m-01');
												$usr_comt1 = $db->prepare("SELECT COUNT(ltt.transfer_id) FROM lead_transfer ltt JOIN leads lds ON lds.leads_id=ltt.traf_leadid WHERE ltt.traf_agid=:agid AND lds.user_comment!='' AND lead_date=:done");
												$usr_comt1->bindParam(':agid',$agid);
												$usr_comt1->bindParam(':done',$done);
												$usr_comt1->execute();
												$contucmt1 = $usr_comt1->fetchColumn();
										   ?>   
                                              <td><?php echo $contucmt1; ?></td>
                                           <?php
												$dtwo = date('Y-m-02');
												$usr_comt2 = $db->prepare("SELECT COUNT(ltt.transfer_id) FROM lead_transfer ltt JOIN leads lds ON lds.leads_id=ltt.traf_leadid WHERE ltt.traf_agid=:agid AND lds.user_comment!='' AND lead_date=:dtwo");
												$usr_comt2->bindParam(':agid',$agid);
												$usr_comt2->bindParam(':dtwo',$dtwo);
												$usr_comt2->execute();
												$contucmt2 = $usr_comt2->fetchColumn();
										   ?>   
                                              <td><?php echo $contucmt2; ?></td>
                                           <?php
												$dthree = date('Y-m-03');
												$usr_comt3 = $db->prepare("SELECT COUNT(ltt.transfer_id) FROM lead_transfer ltt JOIN leads lds ON lds.leads_id=ltt.traf_leadid WHERE ltt.traf_agid=:agid AND lds.user_comment!='' AND lead_date=:dthree");
												$usr_comt3->bindParam(':agid',$agid);
												$usr_comt3->bindParam(':dthree',$dthree);
												$usr_comt3->execute();
												$contucmt3 = $usr_comt3->fetchColumn();
										   ?>   
                                              <td><?php echo $contucmt3; ?></td>
                                           <?php
												$dfour = date('Y-m-04');
												$usr_comt4 = $db->prepare("SELECT COUNT(ltt.transfer_id) FROM lead_transfer ltt JOIN leads lds ON lds.leads_id=ltt.traf_leadid WHERE ltt.traf_agid=:agid AND lds.user_comment!='' AND lead_date=:dfour");
												$usr_comt4->bindParam(':agid',$agid);
												$usr_comt4->bindParam(':dfour',$dfour);
												$usr_comt4->execute();
												$contucmt4 = $usr_comt4->fetchColumn();
										   ?>   
                                              <td><?php echo $contucmt4; ?></td>
                                           <?php
												$dfive = date('Y-m-05');
												$usr_comt5 = $db->prepare("SELECT COUNT(ltt.transfer_id) FROM lead_transfer ltt JOIN leads lds ON lds.leads_id=ltt.traf_leadid WHERE ltt.traf_agid=:agid AND lds.user_comment!='' AND lead_date=:dfive");
												$usr_comt5->bindParam(':agid',$agid);
												$usr_comt5->bindParam(':dfive',$dfive);
												$usr_comt5->execute();
												$contucmt5 = $usr_comt5->fetchColumn();
										   ?>   
                                              <td><?php echo $contucmt5; ?></td>
                                           <?php
												$dsix = date('Y-m-06');
												$usr_comt6 = $db->prepare("SELECT COUNT(ltt.transfer_id) FROM lead_transfer ltt JOIN leads lds ON lds.leads_id=ltt.traf_leadid WHERE ltt.traf_agid=:agid AND lds.user_comment!='' AND lead_date=:dsix");
												$usr_comt6->bindParam(':agid',$agid);
												$usr_comt6->bindParam(':dsix',$dsix);
												$usr_comt6->execute();
												$contucmt6 = $usr_comt6->fetchColumn();
										   ?>   
                                              <td><?php echo $contucmt6; ?></td>
                                           <?php
												$dsevn = date('Y-m-07');
												$usr_comt7 = $db->prepare("SELECT COUNT(ltt.transfer_id) FROM lead_transfer ltt JOIN leads lds ON lds.leads_id=ltt.traf_leadid WHERE ltt.traf_agid=:agid AND lds.user_comment!='' AND lead_date=:dsevn");
												$usr_comt7->bindParam(':agid',$agid);
												$usr_comt7->bindParam(':dsevn',$dsevn);
												$usr_comt7->execute();
												$contucmt7 = $usr_comt7->fetchColumn();
										   ?>   
                                              <td><?php echo $contucmt7; ?></td>
                                           <?php
												$deight = date('Y-m-08');
												$usr_comt8 = $db->prepare("SELECT COUNT(ltt.transfer_id) FROM lead_transfer ltt JOIN leads lds ON lds.leads_id=ltt.traf_leadid WHERE ltt.traf_agid=:agid AND lds.user_comment!='' AND lead_date=:deight");
												$usr_comt8->bindParam(':agid',$agid);
												$usr_comt8->bindParam(':deight',$deight);
												$usr_comt8->execute();
												$contucmt8 = $usr_comt8->fetchColumn();
										   ?>   
                                              <td><?php echo $contucmt8; ?></td>
                                           <?php
												$dnine = date('Y-m-09');
												$usr_comt9 = $db->prepare("SELECT COUNT(ltt.transfer_id) FROM lead_transfer ltt JOIN leads lds ON lds.leads_id=ltt.traf_leadid WHERE ltt.traf_agid=:agid AND lds.user_comment!='' AND lead_date=:dnine");
												$usr_comt9->bindParam(':agid',$agid);
												$usr_comt9->bindParam(':dnine',$dnine);
												$usr_comt9->execute();
												$contucmt9 = $usr_comt9->fetchColumn();
										   ?>   
                                              <td><?php echo $contucmt9; ?></td>
                                           <?php
												$dten = date('Y-m-10');
												$usr_comt10 = $db->prepare("SELECT COUNT(ltt.transfer_id) FROM lead_transfer ltt JOIN leads lds ON lds.leads_id=ltt.traf_leadid WHERE ltt.traf_agid=:agid AND lds.user_comment!='' AND lead_date=:dten");
												$usr_comt10->bindParam(':agid',$agid);
												$usr_comt10->bindParam(':dten',$dten);
												$usr_comt10->execute();
												$contucmt10 = $usr_comt10->fetchColumn();
										   ?>   
                                              <td><?php echo $contucmt10; ?></td>
                                           <?php
												$delvn = date('Y-m-11');
												$usr_comt11 = $db->prepare("SELECT COUNT(ltt.transfer_id) FROM lead_transfer ltt JOIN leads lds ON lds.leads_id=ltt.traf_leadid WHERE ltt.traf_agid=:agid AND lds.user_comment!='' AND lead_date=:delvn");
												$usr_comt11->bindParam(':agid',$agid);
												$usr_comt11->bindParam(':delvn',$delvn);
												$usr_comt11->execute();
												$contucmt11 = $usr_comt11->fetchColumn();
										   ?>   
                                              <td><?php echo $contucmt11; ?></td>
                                           <?php
												$dtwlve = date('Y-m-12');
												$usr_comt12 = $db->prepare("SELECT COUNT(ltt.transfer_id) FROM lead_transfer ltt JOIN leads lds ON lds.leads_id=ltt.traf_leadid WHERE ltt.traf_agid=:agid AND lds.user_comment!='' AND lead_date=:dtwlve");
												$usr_comt12->bindParam(':agid',$agid);
												$usr_comt12->bindParam(':dtwlve',$dtwlve);
												$usr_comt12->execute();
												$contucmt12 = $usr_comt12->fetchColumn();
										   ?>   
                                              <td><?php echo $contucmt12; ?></td>
                                           <?php
												$dthrten = date('Y-m-13');
												$usr_comt13 = $db->prepare("SELECT COUNT(ltt.transfer_id) FROM lead_transfer ltt JOIN leads lds ON lds.leads_id=ltt.traf_leadid WHERE ltt.traf_agid=:agid AND lds.user_comment!='' AND lead_date=:dthrten");
												$usr_comt13->bindParam(':agid',$agid);
												$usr_comt13->bindParam(':dthrten',$dthrten);
												$usr_comt13->execute();
												$contucmt13 = $usr_comt13->fetchColumn();
										   ?>   
                                              <td><?php echo $contucmt13; ?></td>
                                           <?php
												$dforten = date('Y-m-14');
												$usr_comt14 = $db->prepare("SELECT COUNT(ltt.transfer_id) FROM lead_transfer ltt JOIN leads lds ON lds.leads_id=ltt.traf_leadid WHERE ltt.traf_agid=:agid AND lds.user_comment!='' AND lead_date=:dforten");
												$usr_comt14->bindParam(':agid',$agid);
												$usr_comt14->bindParam(':dforten',$dforten);
												$usr_comt14->execute();
												$contucmt14 = $usr_comt14->fetchColumn();
										   ?>   
                                              <td><?php echo $contucmt14; ?></td>
                                           <?php
												$dfiften = date('Y-m-15');
												$usr_comt15 = $db->prepare("SELECT COUNT(ltt.transfer_id) FROM lead_transfer ltt JOIN leads lds ON lds.leads_id=ltt.traf_leadid WHERE ltt.traf_agid=:agid AND lds.user_comment!='' AND lead_date=:dfiften");
												$usr_comt15->bindParam(':agid',$agid);
												$usr_comt15->bindParam(':dfiften',$dfiften);
												$usr_comt15->execute();
												$contucmt15 = $usr_comt15->fetchColumn();
										   ?>   
                                              <td><?php echo $contucmt15; ?></td>
                                          <?php
												$dsxten = date('Y-m-16');
												$usr_comt16 = $db->prepare("SELECT COUNT(ltt.transfer_id) FROM lead_transfer ltt JOIN leads lds ON lds.leads_id=ltt.traf_leadid WHERE ltt.traf_agid=:agid AND lds.user_comment!='' AND lead_date=:dsxten");
												$usr_comt16->bindParam(':agid',$agid);
												$usr_comt16->bindParam(':dsxten',$dsxten);
												$usr_comt16->execute();
												$contucmt16 = $usr_comt16->fetchColumn();
										   ?>    
                                              <td><?php echo $contucmt16; ?></td>
                                          <?php
												$dsvnten = date('Y-m-17');
												$usr_comt17 = $db->prepare("SELECT COUNT(ltt.transfer_id) FROM lead_transfer ltt JOIN leads lds ON lds.leads_id=ltt.traf_leadid WHERE ltt.traf_agid=:agid AND lds.user_comment!='' AND lead_date=:dsvnten");
												$usr_comt17->bindParam(':agid',$agid);
												$usr_comt17->bindParam(':dsvnten',$dsvnten);
												$usr_comt17->execute();
												$contucmt17 = $usr_comt17->fetchColumn();
										   ?>    
                                              <td><?php echo $contucmt17; ?></td>
                                           <?php
												$deghten = date('Y-m-18');
												$usr_comt18 = $db->prepare("SELECT COUNT(ltt.transfer_id) FROM lead_transfer ltt JOIN leads lds ON lds.leads_id=ltt.traf_leadid WHERE ltt.traf_agid=:agid AND lds.user_comment!='' AND lead_date=:deghten");
												$usr_comt18->bindParam(':agid',$agid);
												$usr_comt18->bindParam(':deghten',$deghten);
												$usr_comt18->execute();
												$contucmt18 = $usr_comt18->fetchColumn();
										   ?>   
                                              <td><?php echo $contucmt18; ?></td>
                                           <?php
												$dninten = date('Y-m-19');
												$usr_comt19 = $db->prepare("SELECT COUNT(ltt.transfer_id) FROM lead_transfer ltt JOIN leads lds ON lds.leads_id=ltt.traf_leadid WHERE ltt.traf_agid=:agid AND lds.user_comment!='' AND lead_date=:dninten");
												$usr_comt19->bindParam(':agid',$agid);
												$usr_comt19->bindParam(':dninten',$dninten);
												$usr_comt19->execute();
												$contucmt19 = $usr_comt19->fetchColumn();
										   ?>   
                                              <td><?php echo $contucmt19; ?></td>
                                           <?php
												$dtwntn = date('Y-m-20');
												$usr_comt20 = $db->prepare("SELECT COUNT(ltt.transfer_id) FROM lead_transfer ltt JOIN leads lds ON lds.leads_id=ltt.traf_leadid WHERE ltt.traf_agid=:agid AND lds.user_comment!='' AND lead_date=:dtwntn");
												$usr_comt20->bindParam(':agid',$agid);
												$usr_comt20->bindParam(':dtwntn',$dtwntn);
												$usr_comt20->execute();
												$contucmt20 = $usr_comt20->fetchColumn();
										   ?>    
                                              <td><?php echo $contucmt20; ?></td>
                                           <?php
												$dtwntone = date('Y-m-21');
												$usr_comt21 = $db->prepare("SELECT COUNT(ltt.transfer_id) FROM lead_transfer ltt JOIN leads lds ON lds.leads_id=ltt.traf_leadid WHERE ltt.traf_agid=:agid AND lds.user_comment!='' AND lead_date=:dtwntone");
												$usr_comt21->bindParam(':agid',$agid);
												$usr_comt21->bindParam(':dtwntone',$dtwntone);
												$usr_comt21->execute();
												$contucmt21 = $usr_comt21->fetchColumn();
										   ?>   
                                              <td><?php echo $contucmt21; ?></td>
                                           <?php
												$dtwnttwo = date('Y-m-22');
												$usr_comt22 = $db->prepare("SELECT COUNT(ltt.transfer_id) FROM lead_transfer ltt JOIN leads lds ON lds.leads_id=ltt.traf_leadid WHERE ltt.traf_agid=:agid AND lds.user_comment!='' AND lead_date=:dtwnttwo");
												$usr_comt22->bindParam(':agid',$agid);
												$usr_comt22->bindParam(':dtwnttwo',$dtwnttwo);
												$usr_comt22->execute();
												$contucmt22 = $usr_comt22->fetchColumn();
										   ?>   
                                              <td><?php echo $contucmt22; ?></td>
                                            <?php
												$dtwntthre = date('Y-m-23');
												$usr_comt23 = $db->prepare("SELECT COUNT(ltt.transfer_id) FROM lead_transfer ltt JOIN leads lds ON lds.leads_id=ltt.traf_leadid WHERE ltt.traf_agid=:agid AND lds.user_comment!='' AND lead_date=:dtwntthre");
												$usr_comt23->bindParam(':agid',$agid);
												$usr_comt23->bindParam(':dtwntthre',$dtwntthre);
												$usr_comt23->execute();
												$contucmt23 = $usr_comt23->fetchColumn();
										   ?>   
                                              <td><?php echo $contucmt23; ?></td>
                                           <?php
												$dtwntfour = date('Y-m-24');
												$usr_comt24 = $db->prepare("SELECT COUNT(ltt.transfer_id) FROM lead_transfer ltt JOIN leads lds ON lds.leads_id=ltt.traf_leadid WHERE ltt.traf_agid=:agid AND lds.user_comment!='' AND lead_date=:dtwntfour");
												$usr_comt24->bindParam(':agid',$agid);
												$usr_comt24->bindParam(':dtwntfour',$dtwntfour);
												$usr_comt24->execute();
												$contucmt24 = $usr_comt24->fetchColumn();
										   ?>   
                                              <td><?php echo $contucmt24; ?></td>
                                           <?php
												$dtwntfive = date('Y-m-25');
												$usr_comt25 = $db->prepare("SELECT COUNT(ltt.transfer_id) FROM lead_transfer ltt JOIN leads lds ON lds.leads_id=ltt.traf_leadid WHERE ltt.traf_agid=:agid AND lds.user_comment!='' AND lead_date=:dtwntfive");
												$usr_comt25->bindParam(':agid',$agid);
												$usr_comt25->bindParam(':dtwntfive',$dtwntfive);
												$usr_comt25->execute();
												$contucmt25 = $usr_comt25->fetchColumn();
										   ?>   
                                              <td><?php echo $contucmt25; ?></td>
                                          <?php
												$dtwntsix = date('Y-m-26');
												$usr_comt26 = $db->prepare("SELECT COUNT(ltt.transfer_id) FROM lead_transfer ltt JOIN leads lds ON lds.leads_id=ltt.traf_leadid WHERE ltt.traf_agid=:agid AND lds.user_comment!='' AND lead_date=:dtwntsix");
												$usr_comt26->bindParam(':agid',$agid);
												$usr_comt26->bindParam(':dtwntsix',$dtwntsix);
												$usr_comt26->execute();
												$contucmt26 = $usr_comt26->fetchColumn();
										   ?>    
                                              <td><?php echo $contucmt26; ?></td>
                                           <?php
												$dtwntsevn = date('Y-m-27');
												$usr_comt27 = $db->prepare("SELECT COUNT(ltt.transfer_id) FROM lead_transfer ltt JOIN leads lds ON lds.leads_id=ltt.traf_leadid WHERE ltt.traf_agid=:agid AND lds.user_comment!='' AND lead_date=:dtwntsevn");
												$usr_comt27->bindParam(':agid',$agid);
												$usr_comt27->bindParam(':dtwntsevn',$dtwntsevn);
												$usr_comt27->execute();
												$contucmt27 = $usr_comt27->fetchColumn();
										   ?>   
                                              <td><?php echo $contucmt27; ?></td>
                                           <?php
												$dtwnteght = date('Y-m-28');
												$usr_comt28 = $db->prepare("SELECT COUNT(ltt.transfer_id) FROM lead_transfer ltt JOIN leads lds ON lds.leads_id=ltt.traf_leadid WHERE ltt.traf_agid=:agid AND lds.user_comment!='' AND lead_date=:dtwnteght");
												$usr_comt28->bindParam(':agid',$agid);
												$usr_comt28->bindParam(':dtwnteght',$dtwnteght);
												$usr_comt28->execute();
												$contucmt28 = $usr_comt28->fetchColumn();
										   ?>   
                                              <td><?php echo $contucmt28; ?></td>
                                           <?php
												$dtwntnine = date('Y-m-29');
												$usr_comt29 = $db->prepare("SELECT COUNT(ltt.transfer_id) FROM lead_transfer ltt JOIN leads lds ON lds.leads_id=ltt.traf_leadid WHERE ltt.traf_agid=:agid AND lds.user_comment!='' AND lead_date=:dtwntnine");
												$usr_comt29->bindParam(':agid',$agid);
												$usr_comt29->bindParam(':dtwntnine',$dtwntnine);
												$usr_comt29->execute();
												$contucmt29 = $usr_comt29->fetchColumn();
										   ?>   
                                              <td><?php echo $contucmt29; ?></td>
                                           <?php
												$dthirty = date('Y-m-30');
												$usr_comt30 = $db->prepare("SELECT COUNT(ltt.transfer_id) FROM lead_transfer ltt JOIN leads lds ON lds.leads_id=ltt.traf_leadid WHERE ltt.traf_agid=:agid AND lds.user_comment!='' AND lead_date=:dthirty");
												$usr_comt30->bindParam(':agid',$agid);
												$usr_comt30->bindParam(':dthirty',$dthirty);
												$usr_comt30->execute();
												$contucmt30 = $usr_comt30->fetchColumn();
										   ?>   
                                              <td><?php echo $contucmt30; ?></td>
                                            </tr>
                                          </tbody>
                                        </table>
                                      </div>
                                    </div>
                              </div>
                              <div id="fil4" class="tab-pane fade">
                                   <div class="fulldv table_headtext">
                                      <p>Review Activity </p>
                                      <p>Last updated at: 17 May 09:43 AM</p>
                                   </div>
                                   <div id="table-scrollno3" class="table-scroll week">
                                      <div class="table-wrap">
                                        <table class="main-table3">
                                          <thead>
                                            <tr>
                                              <th class="fixed-side" scope="col">Metric</th>
                                              <th scope="col">Week 14 <br> <span>01-04 To 07-04 </span></th>
                                              <th scope="col">Week 15 <br> <span>08-04 To 14-04 </span></th>
                                              <th scope="col">Week 16 <br> <span>15-04 To 21-04</span></th>
                                              <th scope="col">Week 17 <br> <span>22-04 To 28-04 </span></th>
                                              <th scope="col">Week 18 <br> <span>29-04 To 05-05 </span></th>
                                              <th scope="col">Week 19 <br> <span>06-05 To 12-05</span></th>
                                              <th scope="col">Week 20 <br> <span>13-05 To 19-05 </span></th>
                                              <th scope="col">Week 21 <br> <span>20-05 To 26-05 </span></th>
                                              <th scope="col">Week 22 <br> <span>27-05 To 31-05 </span></th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <tr>
                                              <th class="fixed-side"><strong>Primary Metric</strong></th>
                                              <td colspan="9"></td>
                                            </tr>
                                            <tr>
                                              <th class="fixed-side">Leads Given</th>
                                              <td>1</td>
                                              <td>2</td>
                                              <td>25</td>
                                              <td>25</td>
                                              <td>45</td>
                                              <td>5</td>
                                              <td>36</td>
                                              <td>54</td>
                                              <td>5</td>
                                            </tr>
                                            <tr>
                                              <th class="fixed-side">Quoted Trips</th>
                                              <td>1</td>
                                              <td>2</td>
                                              <td>25</td>
                                              <td>25</td>
                                              <td>45</td>
                                              <td>5</td>
                                              <td>36</td>
                                              <td>54</td>
                                              <td>5</td>
                                            </tr>
                                            <tr>
                                              <th class="fixed-side">Converted Trips</th>
                                              <td>1</td>
                                              <td>2</td>
                                              <td>25</td>
                                              <td>25</td>
                                              <td>45</td>
                                              <td>5</td>
                                              <td>36</td>
                                              <td>54</td>
                                              <td>5</td>
                                            </tr>
                                            <tr>
                                              <th class="fixed-side">Booked by Others</th>
                                              <td>1</td>
                                              <td>2</td>
                                              <td>25</td>
                                              <td>25</td>
                                              <td>45</td>
                                              <td>5</td>
                                              <td>36</td>
                                              <td>54</td>
                                              <td>5</td>
                                            </tr>
                                            <tr>
                                              <th class="fixed-side"><strong>Miscellaneous Metric</strong></th>
                                              <td colspan="9"></td>
                                            </tr>
                                            <tr>
                                              <th class="fixed-side">Got Phone Number</th>
                                              <td>1</td>
                                              <td>2</td>
                                              <td>25</td>
                                              <td>25</td>
                                              <td>45</td>
                                              <td>5</td>
                                              <td>36</td>
                                              <td>54</td>
                                              <td>5</td>
                                            </tr>
                                            <tr>
                                              <th class="fixed-side">No. of Notes Added</th>
                                              <td>1</td>
                                              <td>2</td>
                                              <td>25</td>
                                              <td>25</td>
                                              <td>45</td>
                                              <td>5</td>
                                              <td>36</td>
                                              <td>54</td>
                                              <td>5</td>
                                            </tr>
                                            <tr>
                                              <th class="fixed-side">Comments by Traveler</th>
                                              <td>1</td>
                                              <td>2</td>
                                              <td>25</td>
                                              <td>25</td>
                                              <td>45</td>
                                              <td>5</td>
                                              <td>36</td>
                                              <td>54</td>
                                              <td>5</td>
                                            </tr>
                                            <tr>
                                              <th class="fixed-side">Comments by Agent</th>
                                              <td>1</td>
                                              <td>2</td>
                                              <td>25</td>
                                              <td>25</td>
                                              <td>45</td>
                                              <td>5</td>
                                              <td>36</td>
                                              <td>54</td>
                                              <td>5</td>
                                            </tr>
                                          </tbody>
                                        </table>
                                      </div>
                                    </div>
                              </div>
                              <div id="fil5" class="tab-pane fade">
                                   <div class="fulldv table_headtext">
                                      <p>Review Activity </p>
                                      <p>Last updated at: 17 May 09:43 AM</p>
                                   </div>
                                   <div class="table-scroll week">
                                      <div class="table-wrap">
                                        <table class="main-table1">
                                          <thead>
                                            <tr>
                                              <th class="fixed-side" scope="col">Metric</th>
                                              <th scope="col">Apr 19 <br> <span>01-04 To 30-04  </span></th>
                                              <th scope="col">May 19<br> <span>001-05 To 31-05 </span></th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <tr>
                                              <th class="fixed-side"><strong>Primary Metric</strong></th>
                                              <td colspan="2"></td>
                                            </tr>
                                            <tr>
                                              <th class="fixed-side">Leads Given</th>
                                              <td>25</td>
                                              <td>45</td>
                                            </tr>
                                            <tr>
                                              <th class="fixed-side">Quoted Trips</th>
                                              <td>45</td>
                                              <td>5</td>
                                            </tr>
                                            <tr>
                                              <th class="fixed-side">Converted Trips</th>
                                              <td>36</td>
                                              <td>54</td>
                                            </tr>
                                            <tr>
                                              <th class="fixed-side">Booked by Others</th>
                                              <td>54</td>
                                              <td>5</td>
                                            </tr>
                                            <tr>
                                              <th class="fixed-side"><strong>Miscellaneous Metric</strong></th>
                                              <td colspan="2"></td>
                                            </tr>
                                            <tr>
                                              <th class="fixed-side">Got Phone Number</th>
                                              <td>5</td>
                                              <td>55</td>
                                            </tr>
                                            <tr>
                                              <th class="fixed-side">No. of Notes Added</th>
                                              <td>14</td>
                                              <td>245</td>
                                            </tr>
                                            <tr>
                                              <th class="fixed-side">Comments by Traveler</th>
                                              <td>360</td>
                                              <td>514</td>
                                            </tr>
                                            <tr>
                                              <th class="fixed-side">Comments by Agent</th>
                                              <td>244</td>
                                              <td>226</td>
                                            </tr>
                                          </tbody>
                                        </table>
                                      </div>
                                    </div>
                              </div>
                          </div>
                      </div>
                      
                  </div>
                  <div id="report2" class="tab-pane fade">
                  	  <div class="fulldv reward_tbla">
                          <h3><i class="fa fa-bell"></i> &nbsp; Reward Section </h3>
                          <div class="col-md-6 p0">
                              <table class="see-table">
                                  <tr>
                                      <th>Sub Account Name</th>
                                      <th>Conversions <br> <span>(Includes 'Dropped After Booking' Trips)</span></th>
                                      <th>Revenue</th>
                                  </tr>
                                  <tr>
                                      <td>Karan Singh</td>
                                      <td>16</td>
                                      <td>INR 601,948.50</td>
                                  </tr>
                              </table>
                          </div>
                      </div>	
                  </div>
                  
                  <div id="report3" class="tab-pane fade">
                      <ul class="nav nav-tabs">
                          <li class="active"><a data-toggle="tab" href="#converted1">Converted by you</a></li>
                          <li><a data-toggle="tab" href="#converted2">Converted by Others</a></li>
                      </ul>
                      
                      <div class="tab-content">
                          <div id="converted1" class="tab-pane fade active in">
                          	  <div class="fulldv">
                          	  	 <div class="fulldv">
                                     <ul class="nav nav-tabs converted_lead">
                                          <li class="active">
                                          	<a data-toggle="tab" href="#leads1">
                                              <p>7</p>
                                              <p>Conversion on <span>activated leads</span> in the selected time peroid</p>
                                              <p>
                                              	 <i class="fa fa-star" style="color:#EFB303;"></i>
                                                 <i class="fa fa-star" style="color:#EFB303;"></i>
                                                 <i class="fa fa-star" style="color:#EFB303;"></i>
                                                 <i class="fa fa-star"></i>
                                                 <i class="fa fa-star"></i>
                                              </p>
                                            </a>
                                          </li>
                                          <li>
                                          	<a data-toggle="tab" href="#leads2">
                                              <p>7</p>
                                              <p><span>Total Conversions</span> in the selected time peroid</p>
                                              <p>
                                              	 <i class="fa fa-star" style="color:#EFB303;"></i>
                                                 <i class="fa fa-star" style="color:#EFB303;"></i>
                                                 <i class="fa fa-star" style="color:#EFB303;"></i>
                                                 <i class="fa fa-star"></i>
                                                 <i class="fa fa-star"></i>
                                              </p>
                                            </a>
                                          </li>
                                     </ul> 
                                 </div>
                                 <div class="fulldv">
                                 <div class="tab-content">
                                     <div id="leads1" class="tab-pane fade active in">
                                          <div class="fulldv converted_trips_tbls">
                                  <table class="see-table">
                                      <tr>
                                          <th>Trip ID</th>
                                          <th>Destination</th>
                                          <th>Start Date</th>
                                          <th>End Date</th>
                                          <th>Travellers Detail</th>
                                          <th>Given Quotation Price</th>
                                          <th>Winning Quote</th>
                                          <th>Compare Quote</th>
                                      </tr>
                                      <tr>
                                          <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                          <td>Himachal</td>
                                          <td>05 Aug 2019</td>
                                          <td>11 Aug 2019</td>
                                          <td>Ujjawal Chaudhary <br> 2 Adults & 0 Children </td>
                                          <td> 30,750 total</td>
                                          <td>Booked Outside </td>
                                          <td>-</td>
                                      </tr>
                                      <tr>
                                          <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                          <td>Himachal</td>
                                          <td>05 Aug 2019</td>
                                          <td>11 Aug 2019</td>
                                          <td>Ujjawal Chaudhary <br> 2 Adults & 0 Children </td>
                                          <td> 30,750 total</td>
                                          <td>Booked Outside </td>
                                          <td>-</td>
                                      </tr>
                                      <tr>
                                          <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                          <td>Himachal</td>
                                          <td>05 Aug 2019</td>
                                          <td>11 Aug 2019</td>
                                          <td>Ujjawal Chaudhary <br> 2 Adults & 0 Children </td>
                                          <td> 30,750 total</td>
                                          <td>Booked Outside </td>
                                          <td>-</td>
                                      </tr>
                                      <tr>
                                          <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                          <td>Himachal</td>
                                          <td>05 Aug 2019</td>
                                          <td>11 Aug 2019</td>
                                          <td>Ujjawal Chaudhary <br> 2 Adults & 0 Children </td>
                                          <td> 30,750 total</td>
                                          <td> <span class="rupee"><i class="fa fa-rupee"></i>44,500 total</span> </td>
                                          <td><a href="#" class="comparebtn">Compare</a></td>
                                      </tr>
                                      <tr>
                                          <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                          <td>Himachal</td>
                                          <td>05 Aug 2019</td>
                                          <td>11 Aug 2019</td>
                                          <td>Ujjawal Chaudhary <br> 2 Adults & 0 Children </td>
                                          <td> 30,750 total</td>
                                          <td> <span class="rupee"><i class="fa fa-rupee"></i>44,500 total</span> </td>
                                          <td><a href="#" class="comparebtn">Compare</a></td>
                                      </tr>
                                      <tr>
                                          <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                          <td>Himachal</td>
                                          <td>05 Aug 2019</td>
                                          <td>11 Aug 2019</td>
                                          <td>Ujjawal Chaudhary <br> 2 Adults & 0 Children </td>
                                          <td>Booked Outside </td>
                                          <td><span class="rupee"><i class="fa fa-rupee"></i>44,500 total</span> </td>
                                          <td>-</td>
                                      </tr>
                                  </table>
                              </div>
                                     </div>
                                     <div id="leads2" class="tab-pane fade">
                                          <div class="fulldv converted_trips_tbls">
                                  <table class="see-table">
                                      <tr>
                                          <th>Trip ID</th>
                                          <th>Destination</th>
                                          <th>Start Date</th>
                                          <th>End Date</th>
                                          <th>Travellers Detail</th>
                                          <th>Given Quotation Price</th>
                                          <th>Winning Quote</th>
                                          <th>Compare Quote</th>
                                      </tr>
                                      <tr>
                                          <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                          <td>Himachal</td>
                                          <td>05 Aug 2019</td>
                                          <td>11 Aug 2019</td>
                                          <td>Ujjawal Chaudhary <br> 2 Adults & 0 Children </td>
                                          <td> 30,750 total</td>
                                          <td>Booked Outside </td>
                                          <td>-</td>
                                      </tr>
                                      <tr>
                                          <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                          <td>Himachal</td>
                                          <td>05 Aug 2019</td>
                                          <td>11 Aug 2019</td>
                                          <td>Ujjawal Chaudhary <br> 2 Adults & 0 Children </td>
                                          <td> 30,750 total</td>
                                          <td>Booked Outside </td>
                                          <td>-</td>
                                      </tr>
                                      <tr>
                                          <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                          <td>Himachal</td>
                                          <td>05 Aug 2019</td>
                                          <td>11 Aug 2019</td>
                                          <td>Ujjawal Chaudhary <br> 2 Adults & 0 Children </td>
                                          <td> 30,750 total</td>
                                          <td>Booked Outside </td>
                                          <td>-</td>
                                      </tr>
                                      <tr>
                                          <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                          <td>Himachal</td>
                                          <td>05 Aug 2019</td>
                                          <td>11 Aug 2019</td>
                                          <td>Ujjawal Chaudhary <br> 2 Adults & 0 Children </td>
                                          <td> 30,750 total</td>
                                          <td> <span class="rupee"><i class="fa fa-rupee"></i>44,500 total</span> </td>
                                          <td><a href="#" class="comparebtn">Compare</a></td>
                                      </tr>
                                      <tr>
                                          <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                          <td>Himachal</td>
                                          <td>05 Aug 2019</td>
                                          <td>11 Aug 2019</td>
                                          <td>Ujjawal Chaudhary <br> 2 Adults & 0 Children </td>
                                          <td> 30,750 total</td>
                                          <td> <span class="rupee"><i class="fa fa-rupee"></i>44,500 total</span> </td>
                                          <td><a href="#" class="comparebtn">Compare</a></td>
                                      </tr>
                                      <tr>
                                          <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                          <td>Himachal</td>
                                          <td>05 Aug 2019</td>
                                          <td>11 Aug 2019</td>
                                          <td>Ujjawal Chaudhary <br> 2 Adults & 0 Children </td>
                                          <td>Booked Outside </td>
                                          <td><span class="rupee"><i class="fa fa-rupee"></i>44,500 total</span> </td>
                                          <td>-</td>
                                      </tr>
                                  </table>
                              </div>
                                     </div>
                                 </div>
                                 </div>
                              </div>
                              
                          </div>
                          <div id="converted2" class="tab-pane fade">
                          	  <div class="fulldv">
                              <div class="col-md-2 converted_trip">
                                  <table class="see-table">
                                       <tr>
                                          <th>Converted Trips</th>
                                       </tr>
                                       <tr>
                                          <td>
                                              <span>32</span><br>Trips
                                          </td>
                                       </tr>
                                  </table>
                              </div>
                              <div class="col-md-2 converted_trip">
                                  <table class="see-table">
                                       <tr>
                                          <th>Converted Trips</th>
                                       </tr>
                                       <tr>
                                          <td>
                                              <span>32</span><br>Trips
                                          </td>
                                       </tr>
                                  </table>
                              </div>
                          </div>
                              <div class="fulldv converted_trips_tbls">
                                  <table class="see-table">
                                      <tr>
                                          <th>Trip ID</th>
                                          <th>Destination</th>
                                          <th>Start Date</th>
                                          <th>End Date</th>
                                          <th>Travellers Detail</th>
                                          <th>Given Quotation Price</th>
                                          <th>Winning Quote</th>
                                          <th>Compare Quote</th>
                                      </tr>
                                      <tr>
                                          <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                          <td>Himachal</td>
                                          <td>05 Aug 2019</td>
                                          <td>11 Aug 2019</td>
                                          <td>Ujjawal Chaudhary <br> 2 Adults & 0 Children </td>
                                          <td> 30,750 total</td>
                                          <td>Booked Outside </td>
                                          <td>-</td>
                                      </tr>
                                      <tr>
                                          <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                          <td>Himachal</td>
                                          <td>05 Aug 2019</td>
                                          <td>11 Aug 2019</td>
                                          <td>Ujjawal Chaudhary <br> 2 Adults & 0 Children </td>
                                          <td> 30,750 total</td>
                                          <td>Booked Outside </td>
                                          <td>-</td>
                                      </tr>
                                      <tr>
                                          <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                          <td>Himachal</td>
                                          <td>05 Aug 2019</td>
                                          <td>11 Aug 2019</td>
                                          <td>Ujjawal Chaudhary <br> 2 Adults & 0 Children </td>
                                          <td> 30,750 total</td>
                                          <td>Booked Outside </td>
                                          <td>-</td>
                                      </tr>
                                      <tr>
                                          <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                          <td>Himachal</td>
                                          <td>05 Aug 2019</td>
                                          <td>11 Aug 2019</td>
                                          <td>Ujjawal Chaudhary <br> 2 Adults & 0 Children </td>
                                          <td> 30,750 total</td>
                                          <td> <span class="rupee"><i class="fa fa-rupee"></i>44,500 total</span> </td>
                                          <td><a href="#" class="comparebtn">Compare</a></td>
                                      </tr>
                                      <tr>
                                          <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                          <td>Himachal</td>
                                          <td>05 Aug 2019</td>
                                          <td>11 Aug 2019</td>
                                          <td>Ujjawal Chaudhary <br> 2 Adults & 0 Children </td>
                                          <td> 30,750 total</td>
                                          <td> <span class="rupee"><i class="fa fa-rupee"></i>44,500 total</span> </td>
                                          <td><a href="#" class="comparebtn">Compare</a></td>
                                      </tr>
                                      <tr>
                                          <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                          <td>Himachal</td>
                                          <td>05 Aug 2019</td>
                                          <td>11 Aug 2019</td>
                                          <td>Ujjawal Chaudhary <br> 2 Adults & 0 Children </td>
                                          <td>Booked Outside </td>
                                          <td><span class="rupee"><i class="fa fa-rupee"></i>44,500 total</span> </td>
                                          <td>-</td>
                                      </tr>
                                  </table>
                              </div>
                              <div class="fulldv">
                                  <ul class="pagination">
                                      <li class="disabled"><a href="#">&laquo;</a></li>
                                      <li class="active"><a href="#">1</a></li>
                                      <li><a href="#">2</a></li>
                                      <li><a href="#">3</a></li>
                                      <li><a href="#">4</a></li>
                                      <li><a href="#">4</a></li>
                                      <li><a href="#">&raquo;</a></li>
                                  </ul>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div id="report4" class="tab-pane fade">
                  		<div class="fulldv">
                             <div class="fulldv">
                             <div class="col-md-6 cartmaindv">
                                  <div class="cartmaindv_in">
                                     <div id="pie2" class="example"></div>
                                     <div class="chart_des">
                                        <ul>
                                            <li> <span style="background:#7cb5ec;"></span> Bad</li>
                                            <li> <span style="background:#434348;"></span> Poor</li>
                                            <li> <span style="background:#90ed7d;"></span> Good</li>
                                            <li> <span style="background:#f7a35c;"></span> Very Good</li>
                                            <li> <span style="background:#8085e9;"></span> Excellent</li>
                                        </ul>
                                     </div>
                                  </div>
                              </div>
                             <div class="col-md-6">
                                 <ul class="nav nav-tabs converted_lead">
                                      <li class="active converted_trip cenel">
                                        <a data-toggle="tab" href="#cancel1">
                                          <table class="see-table">
                                          	  <tr>
                                              	  <th>Canceled due to personal reasons</th>
                                              </tr>
                                              <tr>
                                              	  <td><span>94</span>Trips</td>
                                              </tr>
                                          </table>
                                        </a>
                                      </li>
                                      <li class="converted_trip cenel">
                                        <a data-toggle="tab" href="#cancel2">
                                          <table class="see-table">
                                          	  <tr>
                                              	  <th>Traveler is not going due to misc reasons</th>
                                              </tr>
                                              <tr>
                                              	  <td><span>70</span>Trips</td>
                                              </tr>
                                          </table>
                                        </a>
                                      </li>
                                      <li class="converted_trip cenel">
                                        <a data-toggle="tab" href="#cancel3">
                                          <table class="see-table">
                                          	  <tr>
                                              	  <th>Others</th>
                                              </tr>
                                              <tr>
                                              	  <td><span>41</span>Trips</td>
                                              </tr>
                                          </table>
                                        </a>
                                      </li>
                                      <li class="converted_trip cenel">
                                        <a data-toggle="tab" href="#cancel4">
                                          <table class="see-table">
                                          	  <tr>
                                              	  <th>Postponed</th>
                                              </tr>
                                              <tr>
                                              	  <td><span>18</span>Trips</td>
                                              </tr>
                                          </table>
                                        </a>
                                      </li>
                                      <li class="converted_trip cenel">
                                        <a data-toggle="tab" href="#cancel5">
                                          <table class="see-table">
                                          	  <tr>
                                              	  <th>Changed Destination</th>
                                              </tr>
                                              <tr>
                                              	  <td><span>11</span>Trips</td>
                                              </tr>
                                          </table>
                                        </a>
                                      </li>
                                 </ul> 
                             </div>
                             </div>
                             <div class="fulldv">
                             <div class="tab-content">
                                 <div id="cancel1" class="tab-pane fade active in">
                                      <div class="fulldv converted_trips_tbls">
                                          <h3 class="iconheading"> <i class="fa fa-bell"></i> &nbsp; Canceled due to personal reasons:</h3>
                                          <table class="see-table">
                                              <tr>
                                                  <th>Trip ID</th>
                                                  <th>Destination</th>
                                                  <th>Travellers Detail</th>
                                                  <th>Given Quotation Price</th>
                                              </tr>
                                              <tr>
                                                  <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                                  <td>Himachal</td>
                                                  <td>Jitendra Rokade <br> 2 Adults & 0 Children</td>
                                                  <td></td>
                                              </tr>
                                              <tr>
                                                  <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                                  <td>Himachal</td>
                                                  <td>Jitendra Rokade <br> 2 Adults & 0 Children</td>
                                                  <td></td>
                                              </tr>
                                              <tr>
                                                  <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                                  <td>Himachal, Manali</td>
                                                  <td>Balu Reddy <br> 6 Adults & 1 Children </td>
                                                  <td> <span class="rupee" style="color:#666;"><i class="fa fa-rupee"></i>44,500 total</span> to <span class="rupee" style="color:#666;"><i class="fa fa-rupee"></i>44,500 total</span> per person </td>
                                              </tr>
                                              <tr>
                                                  <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                                  <td>Himachal</td>
                                                  <td>Jitendra Rokade <br> 2 Adults & 0 Children</td>
                                                  <td></td>
                                              </tr>
                                              <tr>
                                                  <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                                  <td>Himachal</td>
                                                  <td>Jitendra Rokade <br> 2 Adults & 0 Children</td>
                                                  <td></td>
                                              </tr>
                                              <tr>
                                                  <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                                  <td>Himachal, Manali</td>
                                                  <td>Balu Reddy <br> 6 Adults & 1 Children </td>
                                                  <td> <span class="rupee" style="color:#666;"><i class="fa fa-rupee"></i>44,500 total</span> to <span class="rupee" style="color:#666;"><i class="fa fa-rupee"></i>44,500 total</span> per person </td>
                                              </tr>
                                          </table>
                                      </div>
                                 </div>
                                 <div id="cancel2" class="tab-pane fade">
                                      <div class="fulldv converted_trips_tbls">
                                          <h3 class="iconheading"> <i class="fa fa-bell"></i> &nbsp; Traveler is not going due to misc reasons:</h3>
                                          <table class="see-table">
                                              <tr>
                                                  <th>Trip ID</th>
                                                  <th>Destination</th>
                                                  <th>Travellers Detail</th>
                                                  <th>Given Quotation Price</th>
                                              </tr>
                                              <tr>
                                                  <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                                  <td>Himachal</td>
                                                  <td>Jitendra Rokade <br> 2 Adults & 0 Children</td>
                                                  <td></td>
                                              </tr>
                                              <tr>
                                                  <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                                  <td>Himachal</td>
                                                  <td>Jitendra Rokade <br> 2 Adults & 0 Children</td>
                                                  <td></td>
                                              </tr>
                                              <tr>
                                                  <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                                  <td>Himachal, Manali</td>
                                                  <td>Balu Reddy <br> 6 Adults & 1 Children </td>
                                                  <td> <span class="rupee" style="color:#666;"><i class="fa fa-rupee"></i>44,500 total</span> to <span class="rupee" style="color:#666;"><i class="fa fa-rupee"></i>44,500 total</span> per person </td>
                                              </tr>
                                              <tr>
                                                  <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                                  <td>Himachal</td>
                                                  <td>Jitendra Rokade <br> 2 Adults & 0 Children</td>
                                                  <td></td>
                                              </tr>
                                              <tr>
                                                  <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                                  <td>Himachal</td>
                                                  <td>Jitendra Rokade <br> 2 Adults & 0 Children</td>
                                                  <td></td>
                                              </tr>
                                              <tr>
                                                  <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                                  <td>Himachal, Manali</td>
                                                  <td>Balu Reddy <br> 6 Adults & 1 Children </td>
                                                  <td> <span class="rupee" style="color:#666;"><i class="fa fa-rupee"></i>44,500 total</span> to <span class="rupee" style="color:#666;"><i class="fa fa-rupee"></i>44,500 total</span> per person </td>
                                              </tr>
                                          </table>
                                      </div>
                                 </div>
                                 <div id="cancel3" class="tab-pane fade">
                                      <div class="fulldv converted_trips_tbls">
                                          <h3 class="iconheading"> <i class="fa fa-bell"></i> &nbsp; Others:</h3>
                                          <table class="see-table">
                                              <tr>
                                                  <th>Trip ID</th>
                                                  <th>Destination</th>
                                                  <th>Travellers Detail</th>
                                                  <th>Given Quotation Price</th>
                                              </tr>
                                              <tr>
                                                  <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                                  <td>Himachal</td>
                                                  <td>Jitendra Rokade <br> 2 Adults & 0 Children</td>
                                                  <td></td>
                                              </tr>
                                              <tr>
                                                  <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                                  <td>Himachal</td>
                                                  <td>Jitendra Rokade <br> 2 Adults & 0 Children</td>
                                                  <td></td>
                                              </tr>
                                              <tr>
                                                  <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                                  <td>Himachal, Manali</td>
                                                  <td>Balu Reddy <br> 6 Adults & 1 Children </td>
                                                  <td> <span class="rupee" style="color:#666;"><i class="fa fa-rupee"></i>44,500 total</span> to <span class="rupee" style="color:#666;"><i class="fa fa-rupee"></i>44,500 total</span> per person </td>
                                              </tr>
                                              <tr>
                                                  <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                                  <td>Himachal</td>
                                                  <td>Jitendra Rokade <br> 2 Adults & 0 Children</td>
                                                  <td></td>
                                              </tr>
                                              <tr>
                                                  <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                                  <td>Himachal</td>
                                                  <td>Jitendra Rokade <br> 2 Adults & 0 Children</td>
                                                  <td></td>
                                              </tr>
                                              <tr>
                                                  <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                                  <td>Himachal, Manali</td>
                                                  <td>Balu Reddy <br> 6 Adults & 1 Children </td>
                                                  <td> <span class="rupee" style="color:#666;"><i class="fa fa-rupee"></i>44,500 total</span> to <span class="rupee" style="color:#666;"><i class="fa fa-rupee"></i>44,500 total</span> per person </td>
                                              </tr>
                                          </table>
                                      </div>
                                 </div>
                                 <div id="cancel4" class="tab-pane fade">
                                      <div class="fulldv converted_trips_tbls">
                                          <h3 class="iconheading"> <i class="fa fa-bell"></i> &nbsp; Postponed:</h3>
                                          <table class="see-table">
                                              <tr>
                                                  <th>Trip ID</th>
                                                  <th>Destination</th>
                                                  <th>Travellers Detail</th>
                                                  <th>Given Quotation Price</th>
                                              </tr>
                                              <tr>
                                                  <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                                  <td>Himachal</td>
                                                  <td>Jitendra Rokade <br> 2 Adults & 0 Children</td>
                                                  <td></td>
                                              </tr>
                                              <tr>
                                                  <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                                  <td>Himachal</td>
                                                  <td>Jitendra Rokade <br> 2 Adults & 0 Children</td>
                                                  <td></td>
                                              </tr>
                                              <tr>
                                                  <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                                  <td>Himachal, Manali</td>
                                                  <td>Balu Reddy <br> 6 Adults & 1 Children </td>
                                                  <td> <span class="rupee" style="color:#666;"><i class="fa fa-rupee"></i>44,500 total</span> to <span class="rupee" style="color:#666;"><i class="fa fa-rupee"></i>44,500 total</span> per person </td>
                                              </tr>
                                              <tr>
                                                  <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                                  <td>Himachal</td>
                                                  <td>Jitendra Rokade <br> 2 Adults & 0 Children</td>
                                                  <td></td>
                                              </tr>
                                              <tr>
                                                  <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                                  <td>Himachal</td>
                                                  <td>Jitendra Rokade <br> 2 Adults & 0 Children</td>
                                                  <td></td>
                                              </tr>
                                              <tr>
                                                  <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                                  <td>Himachal, Manali</td>
                                                  <td>Balu Reddy <br> 6 Adults & 1 Children </td>
                                                  <td> <span class="rupee" style="color:#666;"><i class="fa fa-rupee"></i>44,500 total</span> to <span class="rupee" style="color:#666;"><i class="fa fa-rupee"></i>44,500 total</span> per person </td>
                                              </tr>
                                          </table>
                                      </div>
                                 </div>
                                 <div id="cancel5" class="tab-pane fade">
                                      <div class="fulldv converted_trips_tbls">
                                          <h3 class="iconheading"> <i class="fa fa-bell"></i> &nbsp;  Due to Changed Destinations:</h3>
                                          <table class="see-table">
                                              <tr>
                                                  <th>Trip ID</th>
                                                  <th>Destination</th>
                                                  <th>Travellers Detail</th>
                                                  <th>Given Quotation Price</th>
                                              </tr>
                                              <tr>
                                                  <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                                  <td>Himachal</td>
                                                  <td>Jitendra Rokade <br> 2 Adults & 0 Children</td>
                                                  <td></td>
                                              </tr>
                                              <tr>
                                                  <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                                  <td>Himachal</td>
                                                  <td>Jitendra Rokade <br> 2 Adults & 0 Children</td>
                                                  <td></td>
                                              </tr>
                                              <tr>
                                                  <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                                  <td>Himachal, Manali</td>
                                                  <td>Balu Reddy <br> 6 Adults & 1 Children </td>
                                                  <td> <span class="rupee" style="color:#666;"><i class="fa fa-rupee"></i>44,500 total</span> to <span class="rupee" style="color:#666;"><i class="fa fa-rupee"></i>44,500 total</span> per person </td>
                                              </tr>
                                              <tr>
                                                  <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                                  <td>Himachal</td>
                                                  <td>Jitendra Rokade <br> 2 Adults & 0 Children</td>
                                                  <td></td>
                                              </tr>
                                              <tr>
                                                  <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                                  <td>Himachal</td>
                                                  <td>Jitendra Rokade <br> 2 Adults & 0 Children</td>
                                                  <td></td>
                                              </tr>
                                              <tr>
                                                  <td><a href="http://localhost/travel/agent/requested_trips/5ce53e0b83056" target="_blank">4835113</a></td>
                                                  <td>Himachal, Manali</td>
                                                  <td>Balu Reddy <br> 6 Adults & 1 Children </td>
                                                  <td> <span class="rupee" style="color:#666;"><i class="fa fa-rupee"></i>44,500 total</span> to <span class="rupee" style="color:#666;"><i class="fa fa-rupee"></i>44,500 total</span> per person </td>
                                              </tr>
                                          </table>
                                      </div>
                                 </div>
                             </div>
                             </div>
                         </div>
                  </div>
                  <div id="report5" class="tab-pane fade">
                      <div class="fulldv">
                      	  <div class="col-md-5">
                              <div class="fulldv cartmaindv">
                                  <div class="cartmaindv_in">
                                     <div id="pie" class="example"></div>
                                     <div class="chart_des">
                                        <ul>
                                            <li> <span style="background:#7cb5ec;"></span> Bad</li>
                                            <li> <span style="background:#434348;"></span> Poor</li>
                                            <li> <span style="background:#90ed7d;"></span> Good</li>
                                            <li> <span style="background:#f7a35c;"></span> Very Good</li>
                                            <li> <span style="background:#8085e9;"></span> Excellent</li>
                                        </ul>
                                     </div>
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-7">
                              <div class="col-md-4"> 
                                  <div class="fulldv ratingboxdv">
                                      <h4>Hotel Rating</h4>
                                      <div class="col-md-12">
                                         <h3>1.7</h3>
                                         <p>
                                            <i class="fa fa-star" style="color:#EFB303;"></i>
                                            <i class="fa fa-star" style="color:#EFB303;"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                         </p>
                                         <p>Based on 3 Ratings</p>
                                      </div>
                                      <div class="col-md-12">
                                          <ul>
                                             <li><span><i class="fa fa-star"></i>5</span><div style="width:5%"></div><span>0%</span> </li>
                                             <li><span><i class="fa fa-star"></i>4</span><div style="width:5%"></div><span>0%</span> </li>
                                             <li><span><i class="fa fa-star"></i>3</span><div style="width:33%"></div><span>33%</span> </li>
                                             <li><span><i class="fa fa-star"></i>2</span><div style="width:5%"></div><span>0%</span> </li>
                                             <li><span><i class="fa fa-star"></i>1</span><div style="width:66%"></div><span>66%</span> </li>
                                          </ul>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-4"> 
                                  <div class="fulldv ratingboxdv">
                                      <h4>Cab Rating</h4>
                                      <div class="col-md-12">
                                         <h3>3.7</h3>
                                         <p>
                                            <i class="fa fa-star" style="color:#EFB303;"></i>
                                            <i class="fa fa-star" style="color:#EFB303;"></i>
                                            <i class="fa fa-star" style="color:#EFB303;"></i>
                                            <i class="fa fa-star" style="color:#EFB303;"></i>
                                            <i class="fa fa-star"></i>
                                         </p>
                                         <p>Based on 3 Ratings</p>
                                      </div>
                                      <div class="col-md-12">
                                          <ul>
                                             <li><span><i class="fa fa-star"></i>5</span><div style="width:5%"></div><span>0%</span> </li>
                                             <li><span><i class="fa fa-star"></i>4</span><div style="width:66%"></div><span>66%</span> </li>
                                             <li><span><i class="fa fa-star"></i>3</span><div style="width:33%"></div><span>33%</span> </li>
                                             <li><span><i class="fa fa-star"></i>2</span><div style="width:5%"></div><span>0%</span> </li>
                                             <li><span><i class="fa fa-star"></i>1</span><div style="width:5%"></div><span>0%</span> </li>
                                          </ul>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-4"> 
                                  <div class="fulldv ratingboxdv">
                                      <h4>Service Rating</h4>
                                      <div class="col-md-12">
                                         <h3>1.3</h3>
                                         <p>
                                            <i class="fa fa-star" style="color:#EFB303;"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                         </p>
                                         <p>Based on 3 Ratings</p>
                                      </div>
                                      <div class="col-md-12">
                                          <ul>
                                             <li><span><i class="fa fa-star"></i>5</span><div style="width:5%"></div><span>0%</span> </li>
                                             <li><span><i class="fa fa-star"></i>4</span><div style="width:5%"></div><span>0%</span> </li>
                                             <li><span><i class="fa fa-star"></i>3</span><div style="width:5%"></div><span>0%</span> </li>
                                             <li><span><i class="fa fa-star"></i>2</span><div style="width:33%"></div><span>33%</span> </li>
                                             <li><span><i class="fa fa-star"></i>1</span><div style="width:66%"></div><span>66%</span> </li>
                                          </ul>
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
  
  
  <script>
  	  $(document).ready(function(e) {
		
    });
  </script>


</div>

<script src="<?php echo $url; ?>js/slick.js" type="text/javascript"></script>
<script src="<?php echo $url; ?>js/custom.js" type="text/javascript"></script>
<script src="<?php echo $url; ?>agent/js/radial-progress-bar.js"></script>
<script src="<?php echo $url; ?>agent/js/examples.js"></script>
        

<script>
jQuery(document).ready(function() {
   jQuery(".main-table1").clone(true).appendTo('#table-scrollno1').addClass('clone');   
 });
 jQuery(document).ready(function() {
   jQuery(".main-table3").clone(true).appendTo('#table-scroll3').addClass('clone');   
 });
</script>

</body>
</html>
<?php } } else{ echo "<script>location.assign('".$url."agent/logout.php')</script>"; }
      } else{ echo "<script>location.assign('".$url."agent/logout.php')</script>"; } ?>

