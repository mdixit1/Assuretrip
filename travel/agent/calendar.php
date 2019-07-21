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
			$dayname = date('l');
			$curdatee = date('Y-m-d');
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
    <link href="css/styleplus.css" type="text/css" rel="stylesheet"/>
    <link href="css/see.css" type="text/css" rel="stylesheet"/>
	<link href="css/responsive-manage.css" type="text/css" rel="stylesheet"/>
	<link href="css/index.css" type="text/css" rel="stylesheet"/>
    <link href="css/style_manage.css" type="text/css" rel="stylesheet" />
    <link href="css/vanillaCalendar.css" type="text/css" rel="stylesheet" />
    
</head>
<body>
<div class="see-section wrapper_mg">

<div class="see-section main_dv main_dv2">
    <div class="col-md-12 p0 rightsidebar side_header2">
        <?php include('rightheader.php');?>
        
        <div class="col-md-12 rightsidebar_top2 notititle calendar">
        	<h4><i class="fa fa-calendar"></i> Calendar</h4>
            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#home">Month View</a></li>
              <li><a data-toggle="tab" href="#menu1">Week View</a></li>
              <li><a data-toggle="tab" href="#menu2">Day View</a></li>
            </ul>
        </div>
        
        
        <div class="fulldv calendar_sect">
        	<div class="col-md-3">
            	<div id="v-cal">
			<div class="vcal-header">
				<button class="vcal-btn" data-calendar-toggle="previous">
					<svg height="24" version="1.1" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
						<path d="M20,11V13H8L13.5,18.5L12.08,19.92L4.16,12L12.08,4.08L13.5,5.5L8,11H20Z"></path>
					</svg>
				</button>

				<div class="vcal-header__label" data-calendar-label="month">
					March 2017
				</div>


				<button class="vcal-btn" data-calendar-toggle="next">
					<svg height="24" version="1.1" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
						<path d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z"></path>
					</svg>
				</button>
			</div>
			<div class="vcal-week">
				<span>Mon</span>
				<span>Tue</span>
				<span>Wed</span>
				<span>Thu</span>
				<span>Fri</span>
				<span>Sat</span>
				<span>Sun</span>
			</div>
			<div class="vcal-body" data-calendar-area="month"></div>
		</div>
            </div>
            <div class="col-md-9">
            	<div class="tab-content">
                  <div id="home" class="tab-pane fade in active">
                  	  <table class="see-table">
                        <tr>
                            <th>Sun</th>
                            <th>Mon</th>
                            <th>Tue</th>
                            <th>Wed</th>
                            <th>Thu</th>
                            <th>Fri</th>
                            <th>Sat</th>
                        </tr>
                    <tr>    
                   <td>
                        <span></span>
                        <a href="#">
                        <div class="calendar_view_box" style="background:#DCFFD3;">
                            <p></p>
                            <p></p>
                        </div>
                        </a>
                    </td>
                    <td>
                        <span></span>
                        <a href="#">
                        <div class="calendar_view_box" style="background:#E5EAF5;">
                            <p></p>
                            <p></p>
                        </div>
                        </a>
                    </td>
                    <td>
                        <span></span>
                        <a href="#">
                        <div class="calendar_view_box" style="background:#E5EAF5;">
                            <p></p>
                            <p></p>
                        </div>
                        </a>
                    </td>
                   <?php
				   		$done = date('Y-m-01');
				   		$query_four = $db->prepare("SELECT lt.*,ld.lead_uniq FROM lead_transfer lt JOIN leads ld ON ld.leads_id=lt.traf_leadid WHERE traf_agid=:agid AND lt.lstart_date=:done");
						$query_four->bindParam(':done',$done);
						$query_four->bindParam(':agid',$agid);
						$query_four->execute();
						$four = $query_four->fetch();
				   ?>         
                            <td>
                                <span>1</span>
                                <a href="<?php echo $url; ?>agent/payment_detail/<?php echo $four['transfer_id']; ?>">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                 <?php if($four['lead_uniq']!=''){ ?>
                                    <p>Lead-ID : <?php echo $four['lead_uniq']; ?></p>
                                    <p>Trip Starts</p>
                                <?php } else{ ?>
                                	<p>Vacant</p>
                                <?php } ?>
                                </div>
                                </a>
                            </td>
                  <?php
				   		$dtwo = date('Y-m-02');
				   		$query_five = $db->prepare("SELECT lt.*,ld.lead_uniq FROM lead_transfer lt JOIN leads ld ON ld.leads_id=lt.traf_leadid WHERE traf_agid=:agid AND lt.lstart_date=:dtwo");
						$query_five->bindParam(':dtwo',$dtwo);
						$query_five->bindParam(':agid',$agid);
						$query_five->execute();
						$five = $query_five->fetch();
				   ?>          
                            <td>
                                <span>2</span>
                                <a href="<?php echo $url; ?>agent/payment_detail/<?php echo $five['transfer_id']; ?>">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                  <?php if($five['lead_uniq']!=''){ ?>
                                    <p>Lead-ID : <?php echo $five['lead_uniq']; ?></p>
                                    <p>Trip Starts</p>
                                <?php } else{ ?>
                                	<p>Vacant</p>
                                <?php } ?>
                                </div>
                                </a>
                            </td>
                  <?php
				   		$dthree = date('Y-m-03');
				   		$query_six = $db->prepare("SELECT lt.*,ld.lead_uniq FROM lead_transfer lt JOIN leads ld ON ld.leads_id=lt.traf_leadid WHERE traf_agid=:agid AND lt.lstart_date=:dthree");
						$query_six->bindParam(':dthree',$dthree);
						$query_six->bindParam(':agid',$agid);
						$query_six->execute();
						$six = $query_six->fetch();
				   ?>          
                            <td>
                                <span>3</span>
                                <a href="<?php echo $url; ?>agent/payment_detail/<?php echo $six['transfer_id']; ?>">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                <?php if($six['lead_uniq']!=''){ ?>
                                    <p>Lead-ID : <?php echo $six['lead_uniq']; ?></p>
                                    <p>Trip Starts</p>
                                <?php } else{ ?>
                                	<p>Vacant</p>
                                <?php } ?>
                                </div>
                                </a>
                            </td>
                  <?php
				   		$dfour = date('Y-m-04');
				   		$query_seven = $db->prepare("SELECT lt.*,ld.lead_uniq FROM lead_transfer lt JOIN leads ld ON ld.leads_id=lt.traf_leadid WHERE traf_agid=:agid AND lt.lstart_date=:dfour");
						$query_seven->bindParam(':dfour',$dfour);
						$query_seven->bindParam(':agid',$agid);
						$query_seven->execute();
						$seven = $query_seven->fetch();
				   ?>           
                            <td>
                                <span>4</span>
                                <a href="<?php echo $url; ?>agent/payment_detail/<?php echo $seven['transfer_id']; ?>">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                <?php if($seven['lead_uniq']!=''){ ?>
                                    <p>Lead-ID : <?php echo $seven['lead_uniq']; ?></p>
                                    <p>Trip Starts</p>
                                <?php } else{ ?>
                                	<p>Vacant</p>
                                <?php } ?>
                                </div>
                                </a>
                            </td>
                        </tr>
                  <?php
				   		$dfive = date('Y-m-05');
				   		$query_eight = $db->prepare("SELECT lt.*,ld.lead_uniq FROM lead_transfer lt JOIN leads ld ON ld.leads_id=lt.traf_leadid WHERE traf_agid=:agid AND lt.lstart_date=:dfive");
						$query_eight->bindParam(':dfive',$dfive);
						$query_eight->bindParam(':agid',$agid);
						$query_eight->execute();
						$eight = $query_eight->fetch();
				   ?>       
                        <tr>
                            <td>
                                <span>5</span>
                                <a href="<?php echo $url; ?>agent/payment_detail/<?php echo $eight['transfer_id']; ?>">
                                <div class="calendar_view_box" style="background:#fed4b2;">
                                    <?php if($eight['lead_uniq']!=''){ ?>
                                    <p>Lead-ID : <?php echo $eight['lead_uniq']; ?></p>
                                    <p>Trip Starts</p>
                                <?php } else{ ?>
                                	<p>Vacant</p>
                                <?php } ?>
                                </div>
                                </a>
                            </td>
                    <?php
				   		$dsix = date('Y-m-06');
				   		$query_nine = $db->prepare("SELECT lt.*,ld.lead_uniq FROM lead_transfer lt JOIN leads ld ON ld.leads_id=lt.traf_leadid WHERE traf_agid=:agid AND lt.lstart_date=:dsix");
						$query_nine->bindParam(':dsix',$dsix);
						$query_nine->bindParam(':agid',$agid);
						$query_nine->execute();
						$nine = $query_nine->fetch();
				   ?>         
                            <td>
                                <span>6</span>
                                <a href="<?php echo $url; ?>agent/payment_detail/<?php echo $nine['transfer_id']; ?>">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                <?php if($nine['lead_uniq']!=''){ ?>
                                    <p>Lead-ID : <?php echo $nine['lead_uniq']; ?></p>
                                    <p>Trip Starts</p>
                                <?php } else{ ?>


                                	<p>Vacant</p>
                                <?php } ?>
                                </div>
                                </a>
                            </td>
                    <?php
				   		$dsevn = date('Y-m-07');
				   		$query_ten = $db->prepare("SELECT lt.*,ld.lead_uniq FROM lead_transfer lt JOIN leads ld ON ld.leads_id=lt.traf_leadid WHERE traf_agid=:agid AND lt.lstart_date=:dsevn");
						$query_ten->bindParam(':dsevn',$dsevn);
						$query_ten->bindParam(':agid',$agid);
						$query_ten->execute();
						$ten = $query_ten->fetch();
				   ?>         
                            <td>
                                <span>7</span>
                                <a href="<?php echo $url; ?>agent/payment_detail/<?php echo $ten['transfer_id']; ?>">
                                <div class="calendar_view_box" style="background:#DCFFD3;">
                                <?php if($ten['lead_uniq']!=''){ ?>
                                    <p>Lead-ID : <?php echo $ten['lead_uniq']; ?></p>
                                    <p>Trip Starts</p>
                                <?php } else{ ?>
                                	<p>Vacant</p>
                                <?php } ?>
                                </div>
                                </a>
                            </td>
                    <?php
				   		$deght = date('Y-m-08');
				   		$query_elvn = $db->prepare("SELECT lt.*,ld.lead_uniq FROM lead_transfer lt JOIN leads ld ON ld.leads_id=lt.traf_leadid WHERE traf_agid=:agid AND lt.lstart_date=:deght");
						$query_elvn->bindParam(':deght',$deght);
						$query_elvn->bindParam(':agid',$agid);
						$query_elvn->execute();
						$elvn = $query_elvn->fetch();
				   ?>        
                            <td>
                                <span>8</span>
                                <a href="<?php echo $url; ?>agent/payment_detail/<?php echo $elvn['transfer_id']; ?>">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                <?php if($elvn['lead_uniq']!=''){ ?>
                                    <p>Lead-ID : <?php echo $elvn['lead_uniq']; ?></p>
                                    <p>Trip Starts</p>
                                <?php } else{ ?>
                                	<p>Vacant</p>
                                <?php } ?>
                                </div>
                                </a>
                            </td>
                  <?php
				   		$dnine = date('Y-m-09');
				   		$query_twlve = $db->prepare("SELECT lt.*,ld.lead_uniq FROM lead_transfer lt JOIN leads ld ON ld.leads_id=lt.traf_leadid WHERE traf_agid=:agid AND lt.lstart_date=:dnine");
						$query_twlve->bindParam(':dnine',$dnine);
						$query_twlve->bindParam(':agid',$agid);
						$query_twlve->execute();
						$twlve = $query_twlve->fetch();
				   ?>          
                            <td>
                                <span>9</span>
                                <a href="<?php echo $url; ?>agent/payment_detail/<?php echo $twlve['transfer_id']; ?>">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                <?php if($twlve['lead_uniq']!=''){ ?>
                                    <p>Lead-ID : <?php echo $twlve['lead_uniq']; ?></p>
                                    <p>Trip Starts</p>
                                <?php } else{ ?>
                                	<p>Vacant</p>
                                <?php } ?>
                                </div>
                                </a>
                            </td>
                   <?php
				   		$dten = date('Y-m-10');
				   		$query_thrtn = $db->prepare("SELECT lt.*,ld.lead_uniq FROM lead_transfer lt JOIN leads ld ON ld.leads_id=lt.traf_leadid WHERE traf_agid=:agid AND lt.lstart_date=:dten");
						$query_thrtn->bindParam(':dten',$dten);
						$query_thrtn->bindParam(':agid',$agid);
						$query_thrtn->execute();
						$thrtn = $query_thrtn->fetch();
				   ?>          
                            <td>
                                <span>10</span>
                                <a href="<?php echo $url; ?>agent/payment_detail/<?php echo $thrtn['transfer_id']; ?>">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                <?php if($thrtn['lead_uniq']!=''){ ?>
                                    <p>Lead-ID : <?php echo $thrtn['lead_uniq']; ?></p>
                                    <p>Trip Starts</p>
                                <?php } else{ ?>
                                	<p>Vacant</p>
                                <?php } ?>
                                </div>
                                </a>
                            </td>
                  <?php
				   		$delvn = date('Y-m-11');
				   		$query_foten = $db->prepare("SELECT lt.*,ld.lead_uniq FROM lead_transfer lt JOIN leads ld ON ld.leads_id=lt.traf_leadid WHERE traf_agid=:agid AND lt.lstart_date=:delvn");
						$query_foten->bindParam(':delvn',$delvn);
						$query_foten->bindParam(':agid',$agid);
						$query_foten->execute();
						$foten = $query_foten->fetch();
				   ?>          
                            <td>
                                <span>11</span>
                                <a href="<?php echo $url; ?>agent/payment_detail/<?php echo $foten['transfer_id']; ?>">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                <?php if($foten['lead_uniq']!=''){ ?>
                                    <p>Lead-ID : <?php echo $foten['lead_uniq']; ?></p>
                                    <p>Trip Starts</p>
                                <?php } else{ ?>
                                	<p>Vacant</p>
                                <?php } ?>
                                </div>
                                </a>
                            </td>
                        </tr>
                 <?php
				   		$dtwlve = date('Y-m-12');
				   		$query_fviteen = $db->prepare("SELECT lt.*,ld.lead_uniq FROM lead_transfer lt JOIN leads ld ON ld.leads_id=lt.traf_leadid WHERE traf_agid=:agid AND lt.lstart_date=:dtwlve");
						$query_fviteen->bindParam(':dtwlve',$dtwlve);
						$query_fviteen->bindParam(':agid',$agid);
						$query_fviteen->execute();
						$fiften = $query_fviteen->fetch();
				   ?>       
                        <tr>
                            <td>
                                <span>12</span>
                                <a href="<?php echo $url; ?>agent/payment_detail/<?php echo $fiften['transfer_id']; ?>">
                                <div class="calendar_view_box" style="background:#fed4b2;">
                                <?php if($fiften['lead_uniq']!=''){ ?>
                                    <p>Lead-ID : <?php echo $fiften['lead_uniq']; ?></p>
                                    <p>Trip Starts</p>
                                <?php } else{ ?>
                                	<p>Vacant</p>
                                <?php } ?>
                                </div>
                                </a>
                            </td>
                   <?php
				   		$dthrtn = date('Y-m-13');
				   		$query_sxitn = $db->prepare("SELECT lt.*,ld.lead_uniq FROM lead_transfer lt JOIN leads ld ON ld.leads_id=lt.traf_leadid WHERE traf_agid=:agid AND lt.lstart_date=:dthrtn");
						$query_sxitn->bindParam(':dthrtn',$dthrtn);
						$query_sxitn->bindParam(':agid',$agid);
						$query_sxitn->execute();
						$sxitn = $query_sxitn->fetch();
				   ?>          
                            <td>
                                <span>13</span>
                                <a href="<?php echo $url; ?>agent/payment_detail/<?php echo $sxitn['transfer_id']; ?>">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                <?php if($sxitn['lead_uniq']!=''){ ?>
                                    <p>Lead-ID : <?php echo $sxitn['lead_uniq']; ?></p>
                                    <p>Trip Starts</p>
                                <?php } else{ ?>
                                	<p>Vacant</p>
                                <?php } ?>
                                </div>
                                </a>
                            </td>
                   <?php
				   		$dfrtn = date('Y-m-14');
				   		$query_sevntn = $db->prepare("SELECT lt.*,ld.lead_uniq FROM lead_transfer lt JOIN leads ld ON ld.leads_id=lt.traf_leadid WHERE traf_agid=:agid AND lt.lstart_date=:dfrtn");
						$query_sevntn->bindParam(':dfrtn',$dfrtn);
						$query_sevntn->bindParam(':agid',$agid);
						$query_sevntn->execute();
						$sevntn = $query_sevntn->fetch();
				   ?>         
                            <td>
                                <span>14</span>
                                <a href="<?php echo $url; ?>agent/payment_detail/<?php echo $sevntn['transfer_id']; ?>">
                                <div class="calendar_view_box" style="background:#DCFFD3;">
                                <?php if($sevntn['lead_uniq']!=''){ ?>
                                    <p>Lead-ID : <?php echo $sevntn['lead_uniq']; ?></p>
                                    <p>Trip Starts</p>
                                <?php } else{ ?>
                                	<p>Vacant</p>
                                <?php } ?>
                                </div>
                                </a>
                            </td>
                 <?php
				   		$dfiftn = date('Y-m-15');
				   		$query_eightn = $db->prepare("SELECT lt.*,ld.lead_uniq FROM lead_transfer lt JOIN leads ld ON ld.leads_id=lt.traf_leadid WHERE traf_agid=:agid AND lt.lstart_date=:dfiftn");
						$query_eightn->bindParam(':dfiftn',$dfiftn);
						$query_eightn->bindParam(':agid',$agid);
						$query_eightn->execute();
						$eightn = $query_eightn->fetch();
				   ?>            
                            <td>
                                <span>15</span>
                                <a href="<?php echo $url; ?>agent/payment_detail/<?php echo $eightn['transfer_id']; ?>">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                <?php if($eightn['lead_uniq']!=''){ ?>
                                    <p>Lead-ID : <?php echo $eightn['lead_uniq']; ?></p>
                                    <p>Trip Starts</p>
                                <?php } else{ ?>
                                	<p>Vacant</p>
                                <?php } ?>
                                </div>
                                </a>
                            </td>
                  <?php
				   		$dsxten = date('Y-m-16');
				   		$query_ninten = $db->prepare("SELECT lt.*,ld.lead_uniq FROM lead_transfer lt JOIN leads ld ON ld.leads_id=lt.traf_leadid WHERE traf_agid=:agid AND lt.lstart_date=:dsxten");
						$query_ninten->bindParam(':dsxten',$dsxten);
						$query_ninten->bindParam(':agid',$agid);
						$query_ninten->execute();
						$ninten = $query_ninten->fetch();
				   ?>          
                            <td>
                                <span>16</span>
                                <a href="<?php echo $url; ?>agent/payment_detail/<?php echo $ninten['transfer_id']; ?>">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                 <?php if($ninten['lead_uniq']!=''){ ?>
                                    <p>Lead-ID : <?php echo $ninten['lead_uniq']; ?></p>
                                    <p>Trip Starts</p>
                                <?php } else{ ?>
                                	<p>Vacant</p>
                                <?php } ?>
                                </div>
                                </a>
                            </td>
                     <?php

				   		$dsventn = date('Y-m-17');
				   		$query_twnty = $db->prepare("SELECT lt.*,ld.lead_uniq FROM lead_transfer lt JOIN leads ld ON ld.leads_id=lt.traf_leadid WHERE traf_agid=:agid AND lt.lstart_date=:dsventn");
						$query_twnty->bindParam(':dsventn',$dsventn);
						$query_twnty->bindParam(':agid',$agid);
						$query_twnty->execute();
						$twnty = $query_twnty->fetch();
				   ?>       
                            <td>
                               <span>17</span>
                                <a href="<?php echo $url; ?>agent/payment_detail/<?php echo $twnty['transfer_id']; ?>">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                <?php if($twnty['lead_uniq']!=''){ ?>
                                    <p>Lead-ID : <?php echo $twnty['lead_uniq']; ?></p>
                                    <p>Trip Starts</p>
                                <?php } else{ ?>
                                	<p>Vacant</p>
                                <?php } ?>
                                </div>
                                </a>
                            </td>
                    <?php
				   		$deghtn = date('Y-m-18');
				   		$query_twntyon = $db->prepare("SELECT lt.*,ld.lead_uniq FROM lead_transfer lt JOIN leads ld ON ld.leads_id=lt.traf_leadid WHERE traf_agid=:agid AND lt.lstart_date=:deghtn");
						$query_twntyon->bindParam(':deghtn',$deghtn);
						$query_twntyon->bindParam(':agid',$agid);
						$query_twntyon->execute();
						$twntyon = $query_twntyon->fetch();
				   ?>        
                            <td>
                                <span>18</span>
                                <a href="<?php echo $url; ?>agent/payment_detail/<?php echo $twntyon['transfer_id']; ?>">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                <?php if($twntyon['lead_uniq']!=''){ ?>
                                    <p>Lead-ID : <?php echo $twntyon['lead_uniq']; ?></p>
                                    <p>Trip Starts</p>
                                <?php } else{ ?>
                                	<p>Vacant</p>
                                <?php } ?>
                                </div>
                                </a>
                            </td>
                        </tr>
                    <?php
				   		$dnnten = date('Y-m-19');
				   		$query_twntytw = $db->prepare("SELECT lt.*,ld.lead_uniq FROM lead_transfer lt JOIN leads ld ON ld.leads_id=lt.traf_leadid WHERE traf_agid=:agid AND lt.lstart_date=:dnnten");
						$query_twntytw->bindParam(':dnnten',$dnnten);
						$query_twntytw->bindParam(':agid',$agid);
						$query_twntytw->execute();
						$twntytw = $query_twntytw->fetch();
				   ?>     
                        <tr>
                            <td>
                                <span>19</span>
                                <a href="<?php echo $url; ?>agent/payment_detail/<?php echo $twntytw['transfer_id']; ?>">
                                <div class="calendar_view_box" style="background:#fed4b2;">
                                <?php if($twntytw['lead_uniq']!=''){ ?>
                                    <p>Lead-ID : <?php echo $twntytw['lead_uniq']; ?></p>
                                    <p>Trip Starts</p>
                                <?php } else{ ?>
                                	<p>Vacant</p>
                                <?php } ?>
                                </div>
                                </a>
                            </td>
                   <?php
				   		$dtwnty = date('Y-m-20');
				   		$query_twntyth = $db->prepare("SELECT lt.*,ld.lead_uniq FROM lead_transfer lt JOIN leads ld ON ld.leads_id=lt.traf_leadid WHERE traf_agid=:agid AND lt.lstart_date=:dtwnty");
						$query_twntyth->bindParam(':dtwnty',$dtwnty);
						$query_twntyth->bindParam(':agid',$agid);
						$query_twntyth->execute();
						$twntyth = $query_twntyth->fetch();
				   ?>         
                            <td>
                                <span>20</span>
                                <a href="<?php echo $url; ?>agent/payment_detail/<?php echo $twntyth['transfer_id']; ?>">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                    <?php if($twntyth['lead_uniq']!=''){ ?>
                                    <p>Lead-ID : <?php echo $twntyth['lead_uniq']; ?></p>
                                    <p>Trip Starts</p>
                                <?php } else{ ?>
                                	<p>Vacant</p>
                                <?php } ?>
                                </div>
                                </a>
                            </td>
                     <?php
				   		$dtwntyon = date('Y-m-21');
				   		$query_twntyfr = $db->prepare("SELECT lt.*,ld.lead_uniq FROM lead_transfer lt JOIN leads ld ON ld.leads_id=lt.traf_leadid WHERE traf_agid=:agid AND lt.lstart_date=:dtwntyon");
						$query_twntyfr->bindParam(':dtwntyon',$dtwntyon);
						$query_twntyfr->bindParam(':agid',$agid);
						$query_twntyfr->execute();
						$twntyfr = $query_twntyfr->fetch();
				   ?>        
                            <td>
                                <span>21</span>
                                <a href="<?php echo $url; ?>agent/payment_detail/<?php echo $twntyfr['transfer_id']; ?>">
                                <div class="calendar_view_box" style="background:#DCFFD3;">
                                    <?php if($twntyfr['lead_uniq']!=''){ ?>
                                    <p>Lead-ID : <?php echo $twntyfr['lead_uniq']; ?></p>
                                    <p>Trip Starts</p>
                                <?php } else{ ?>
                                	<p>Vacant</p>
                                <?php } ?>
                                </div>
                                </a>
                            </td>
                      <?php
				   		$dtwntytw = date('Y-m-22');
				   		$query_twntyfv = $db->prepare("SELECT lt.*,ld.lead_uniq FROM lead_transfer lt JOIN leads ld ON ld.leads_id=lt.traf_leadid WHERE traf_agid=:agid AND lt.lstart_date=:dtwntytw");
						$query_twntyfv->bindParam(':dtwntytw',$dtwntytw);
						$query_twntyfv->bindParam(':agid',$agid);
						$query_twntyfv->execute();
						$twntyfv = $query_twntyfv->fetch();
				   ?>        
                            <td>
                                <span>22</span>
                                <a href="<?php echo $url; ?>agent/payment_detail/<?php echo $twntyfv['transfer_id']; ?>">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                    <?php if($twntyfv['lead_uniq']!=''){ ?>
                                    <p>Lead-ID : <?php echo $twntyfv['lead_uniq']; ?></p>
                                    <p>Trip Starts</p>
                                <?php } else{ ?>
                                	<p>Vacant</p>
                                <?php } ?>
                                </div>
                                </a>
                            </td>
                  <?php
				   		$dtwntyth = date('Y-m-23');
				   		$query_twntysx = $db->prepare("SELECT lt.*,ld.lead_uniq FROM lead_transfer lt JOIN leads ld ON ld.leads_id=lt.traf_leadid WHERE traf_agid=:agid AND lt.lstart_date=:dtwntyth");
						$query_twntysx->bindParam(':dtwntyth',$dtwntyth);
						$query_twntysx->bindParam(':agid',$agid);
						$query_twntysx->execute();
						$twntysx = $query_twntysx->fetch();
				   ?>           
                            <td>
                                <span>23</span>
                                <a href="<?php echo $url; ?>agent/payment_detail/<?php echo $twntysx['transfer_id']; ?>">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                    <?php if($twntysx['lead_uniq']!=''){ ?>
                                    <p>Lead-ID : <?php echo $twntysx['lead_uniq']; ?></p>
                                    <p>Trip Starts</p>
                                <?php } else{ ?>
                                	<p>Vacant</p>
                                <?php } ?>
                                </div>
                                </a>
                            </td>
                   <?php
				   		$dtwntyfr = date('Y-m-24');
				   		$query_twntysv = $db->prepare("SELECT lt.*,ld.lead_uniq FROM lead_transfer lt JOIN leads ld ON ld.leads_id=lt.traf_leadid WHERE traf_agid=:agid AND lt.lstart_date=:dtwntyfr");
						$query_twntysv->bindParam(':dtwntyfr',$dtwntyfr);
						$query_twntysv->bindParam(':agid',$agid);
						$query_twntysv->execute();
						$twntysv = $query_twntysv->fetch();
				   ?>          
                            <td>
                               <span>24</span>
                                <a href="<?php echo $url; ?>agent/payment_detail/<?php echo $twntysv['transfer_id']; ?>">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                    <?php if($twntysv['lead_uniq']!=''){ ?>
                                    <p>Lead-ID : <?php echo $twntysv['lead_uniq']; ?></p>
                                    <p>Trip Starts</p>
                                <?php } else{ ?>
                                	<p>Vacant</p>
                                <?php } ?>
                                </div>
                                </a>
                            </td>
                    <?php
				   		$dtwntyfv = date('Y-m-25');
				   		$query_twntyeg = $db->prepare("SELECT lt.*,ld.lead_uniq FROM lead_transfer lt JOIN leads ld ON ld.leads_id=lt.traf_leadid WHERE traf_agid=:agid AND lt.lstart_date=:dtwntyfv");
						$query_twntyeg->bindParam(':dtwntyfv',$dtwntyfv);
						$query_twntyeg->bindParam(':agid',$agid);
						$query_twntyeg->execute();
						$twntyeg = $query_twntyeg->fetch();
				   ?>         
                            <td>
                                <span>25</span>
                                <a href="<?php echo $url; ?>agent/payment_detail/<?php echo $twntyeg['transfer_id']; ?>">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                    <?php if($twntyeg['lead_uniq']!=''){ ?>
                                    <p>Lead-ID : <?php echo $twntyeg['lead_uniq']; ?></p>
                                    <p>Trip Starts</p>
                                <?php } else{ ?>
                                	<p>Vacant</p>
                                <?php } ?>
                                </div>
                                </a>
                            </td>
                        </tr>
                    <?php
				   		$dtwntysx = date('Y-m-26');
				   		$query_twntynn = $db->prepare("SELECT lt.*,ld.lead_uniq FROM lead_transfer lt JOIN leads ld ON ld.leads_id=lt.traf_leadid WHERE traf_agid=:agid AND lt.lstart_date=:dtwntysx");
						$query_twntynn->bindParam(':dtwntysx',$dtwntysx);
						$query_twntynn->bindParam(':agid',$agid);
						$query_twntynn->execute();
						$twntynn = $query_twntynn->fetch();
				   ?>     
                        <tr>
                            <td>
                                <span>26</span>
                                <a href="<?php echo $url; ?>agent/payment_detail/<?php echo $twntynn['transfer_id']; ?>">
                                <div class="calendar_view_box" style="background:#fed4b2;">
                                    <?php if($twntynn['lead_uniq']!=''){ ?>
                                    <p>Lead-ID : <?php echo $twntynn['lead_uniq']; ?></p>
                                    <p>Trip Starts</p>
                                <?php } else{ ?>
                                	<p>Vacant</p>
                                <?php } ?>
                                </div>
                                </a>
                            </td>
                  <?php
				   		$dtwntysv = date('Y-m-27');
				   		$query_twntytn = $db->prepare("SELECT lt.*,ld.lead_uniq FROM lead_transfer lt JOIN leads ld ON ld.leads_id=lt.traf_leadid WHERE traf_agid=:agid AND lt.lstart_date=:dtwntysv");
						$query_twntytn->bindParam(':dtwntysv',$dtwntysv);
						$query_twntytn->bindParam(':agid',$agid);
						$query_twntytn->execute();
						$twntytn = $query_twntytn->fetch();
				   ?>          
                            <td>
                                <span>27</span>
                                <a href="<?php echo $url; ?>agent/payment_detail/<?php echo $twntytn['transfer_id']; ?>">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                    <?php if($twntytn['lead_uniq']!=''){ ?>
                                    <p>Lead-ID : <?php echo $twntytn['lead_uniq']; ?></p>
                                    <p>Trip Starts</p>
                                <?php } else{ ?>
                                	<p>Vacant</p>
                                <?php } ?>
                                </div>
                                </a>
                            </td>
                            <?php
				   		 
						$twenty_eight = date('Y-m-28');
				   		$query_one = $db->prepare("SELECT lt.*,ld.lead_uniq FROM lead_transfer lt JOIN leads ld ON ld.leads_id=lt.traf_leadid WHERE traf_agid=:agid AND lt.lstart_date=:twenty_eight");
						$query_one->bindParam(':twenty_eight',$twenty_eight);
						$query_one->bindParam(':agid',$agid);
						$query_one->execute();
						$one = $query_one->fetch();
				   ?>     
                        
                            <td>
                                <span>28</span>
                                <a href="<?php echo $url; ?>agent/payment_detail/<?php echo $one['transfer_id']; ?>">
                                <div class="calendar_view_box" style="background:#fed4b2;">
                                <?php if($one['lead_uniq']!=''){ ?>
                                    <p>Lead-ID : <?php echo $one['lead_uniq']; ?></p>
                                    <p>Trip Starts</p>
                                <?php } else{ ?>
                                	<p>Vacant</p>
                                <?php } ?>    
                                </div>
                                </a>
                            </td>
                 <?php
				   		$twenty_nine = date('Y-m-29');
				   		$query_two = $db->prepare("SELECT lt.*,ld.lead_uniq FROM lead_transfer lt JOIN leads ld ON ld.leads_id=lt.traf_leadid WHERE traf_agid=:agid AND lt.lstart_date=:twenty_nine");
						$query_two->bindParam(':twenty_nine',$twenty_nine);
						$query_two->bindParam(':agid',$agid);
						$query_two->execute();
						$two = $query_two->fetch();
				   ?>           
                            <td>
                                <span>29</span>
                                <a href="<?php echo $url; ?>agent/payment_detail/<?php echo $two['transfer_id']; ?>">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                <?php if($two['lead_uniq']!=''){ ?>
                                    <p>Lead-ID : <?php echo $two['lead_uniq']; ?></p>
                                    <p>Trip Starts</p>
                                <?php } else{ ?>
                                	<p>Vacant</p>
                                <?php } ?>
                                </div>
                                </a>
                            </td>
                  <?php
				   		$thirty = date('Y-m-30');
				   		$query_three = $db->prepare("SELECT lt.*,ld.lead_uniq FROM lead_transfer lt JOIN leads ld ON ld.leads_id=lt.traf_leadid WHERE traf_agid=:agid AND lt.lstart_date=:thirty");
						$query_three->bindParam(':thirty',$thirty);
						$query_three->bindParam(':agid',$agid);
						$query_three->execute();
						$three = $query_three->fetch();
				   ?>          
                            <td>
                                <span>30</span>
                                <a href="<?php echo $url; ?>agent/payment_detail/<?php echo $three['transfer_id']; ?>">
                                <div class="calendar_view_box" style="background:#DCFFD3;">
                                <?php if($three['lead_uniq']!=''){ ?>
                                    <p>Lead-ID : <?php echo $three['lead_uniq']; ?></p>
                                    <p>Trip Starts</p>
                                <?php } else{ ?>
                                	<p>Vacant</p>
                                <?php } ?>
                                </div>
                                </a>
                            </td>
                            
                            <td>
                               <span></span>
                                <a href="#">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                    <p></p>
                                    <p></p>
                                </div>
                                </a>
                            </td>
                            <td>
                                <span></span>
                                <a href="#">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                    <p></p>
                                    <p></p>
                                </div>
                                </a>
                            </td>
                        </tr>
                      </table>
                  </div>
                  <div id="menu1" class="tab-pane fade">
                  <?php
				  	// first week
							$date = date('Y-m-01');
							$date = strtotime($date);
							$date = strtotime("+7 day", $date);
							$dateres = date('Y-m-d', $date);
							
						//  second week	
						
							$date1 = date('Y-m-d', $date);
							$date1 = strtotime($date1);
							$date1 = strtotime("+7 day", $date1);
							$date1res = date('Y-m-d', $date1);
							
						// Third Week	
						
							$date2 = date('Y-m-d', $date1);
							$date2 = strtotime($date2);
							$date2 = strtotime("+7 day", $date2);
							$date2res = date('Y-m-d', $date2);
							
						// Fourth Week	
						
							$date3 = date('Y-m-d', $date2);
							$date3 = strtotime($date3);
							$date3 = strtotime("+7 day", $date3);
							$date3res = date('Y-m-d', $date3);
							
						// Fifth Week
						
							$date4 = date('Y-m-d', $date3);
							$date4 = strtotime($date4);
							$date4 = strtotime("+2 day", $date4);
							$date4res = date('Y-m-d', $date4);	
				  ?>
                      <table class="see-table">
                        <tr>
                            <th>Sun <?php echo date('m'); ?>/<?php echo date('y'); ?></th>
                            <th>Mon <?php echo date('m'); ?>/<?php echo date('y'); ?></th>
                            <th>Tue <?php echo date('m'); ?>/<?php echo date('y'); ?></th>
                            <th>Wed <?php echo date('m'); ?>/<?php echo date('y'); ?></th>
                            <th>Thu <?php echo date('m'); ?>/<?php echo date('y'); ?></th>
                            <th>Fri <?php echo date('m'); ?>/<?php echo date('y'); ?></th>
                            <th>Sat <?php echo date('m'); ?>/<?php echo date('y'); ?></th>
                        </tr>
                        
                        <tr>
                        <?php 
							$query_week = $db->prepare("SELECT lt.*,ld.lead_uniq FROM lead_transfer lt JOIN leads ld ON ld.leads_id=lt.traf_leadid WHERE traf_agid=:agid AND (lt.lstart_date BETWEEN '$date' AND '$dateres')");
							$query_week->bindParam(':agid',$agid);
							$query_week->execute();
							$week = $query_week->fetchAll();
							if(count($week)){
							foreach($week as $wek){
								$day = date('D',strtotime($wek['lstart_date']));
				   		?> 
                            <td>
                                <a href="<?php echo $url; ?>agent/payment_detail/<?php echo $wek['lead_uniq']; ?>">
                              
                                <div class="calendar_view_box" <?php if($day=='sun'){ ?> style="background:#fed4b2;" <?php }else { ?> style="background:#E5EAF5;" <?php } ?>>        
                                    <p>Lead ID : <?php echo $wek['lead_uniq']; ?></p>
                                    <p>Trip Starts</p>
                                </div>
                                </a>
                            </td>
                        <?php } } 
							else{ ?>
                        	<td>
                                <a href="#">
                                <div class="calendar_view_box" style="background:#fed4b2;">
                                    <p>NAME : Ssarvesh</p>
                                    <p>Trip Starts</p>
                                </div>
                                </a>
                            </td>
                            <td>
                                <a href="#">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                    <p>NAME : Ssarvesh</p>
                                    <p>Trip Starts</p>
                                </div>
                                </a>
                            </td>
                            <td>
                                <a href="#">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                    <p>NAME : Ssarvesh</p>
                                    <p>Trip Starts</p>
                                </div>
                                </a>
                            </td>
                            <td>
                                <a href="#">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                    <p>NAME : Ssarvesh</p>
                                    <p>Trip Starts</p>
                                </div>
                                </a>
                            </td>
                            <td>
                                <a href="#">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                    <p>NAME : Ssarvesh</p>
                                    <p>Trip Starts</p>
                                </div>
                                </a>
                            </td>
                            <td>
                                <a href="#">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                    <p>NAME : Ssarvesh</p>
                                    <p>Trip Starts</p>
                                </div>
                                </a>
                            </td>
                            <td>
                                <a href="#">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                    <p>NAME : Ssarvesh</p>
                                    <p>Trip Starts</p>
                                </div>
                                </a>
                            </td>
                        <?php }  
						?>   
                        </tr>
                        <tr>
                        <?php 
							$query_week1 = $db->prepare("SELECT lt.*,ld.lead_uniq FROM lead_transfer lt JOIN leads ld ON ld.leads_id=lt.traf_leadid WHERE traf_agid=:agid AND (lt.lstart_date BETWEEN '$date1' AND '$date1res')");
							$query_week1->bindParam(':agid',$agid);
							$query_week1->execute();
							$week1 = $query_week1->fetchAll();
							if(count($week1)){
							foreach($week1 as $wek1){
								$day = date('D',strtotime($wek1['lstart_date']));
				   		?> 
                            <td>
                                <a href="<?php echo $url; ?>agent/payment_detail/<?php echo $wek1['lead_uniq']; ?>">
                              <div class="calendar_view_box" <?php if($day=='sun'){ ?> style="background:#fed4b2;" <?php }else { ?> style="background:#E5EAF5;" <?php } ?>>          
                                    <p>Lead ID : <?php echo $wek1['lead_uniq']; ?></p>
                                    <p>Trip Starts</p>
                                </div>
                                </a>
                            </td>
                        <?php } } 
							else{ ?>
                        	<td>
                                <a href="#">
                                <div class="calendar_view_box" style="background:#fed4b2;">
                                    <p>NAME : Ssarvesh</p>
                                    <p>Trip Starts</p>
                                </div>
                                </a>
                            </td>
                            <td>
                                <a href="#">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                    <p>NAME : Ssarvesh</p>
                                    <p>Trip Starts</p>
                                </div>
                                </a>
                            </td>
                            <td>
                                <a href="#">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                    <p>NAME : Ssarvesh</p>
                                    <p>Trip Starts</p>
                                </div>
                                </a>
                            </td>
                            <td>
                                <a href="#">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                    <p>NAME : Ssarvesh</p>
                                    <p>Trip Starts</p>
                                </div>
                                </a>
                            </td>
                            <td>
                                <a href="#">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                    <p>NAME : Ssarvesh</p>
                                    <p>Trip Starts</p>
                                </div>
                                </a>
                            </td>
                            <td>
                                <a href="#">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                    <p>NAME : Ssarvesh</p>
                                    <p>Trip Starts</p>
                                </div>
                                </a>
                            </td>
                            <td>
                                <a href="#">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                    <p>NAME : Ssarvesh</p>
                                    <p>Trip Starts</p>
                                </div>
                                </a>
                            </td>
                        <?php } 
						?>
                        </tr>
                        <tr>
                        <?php 
							$query_week2 = $db->prepare("SELECT lt.*,ld.lead_uniq FROM lead_transfer lt JOIN leads ld ON ld.leads_id=lt.traf_leadid WHERE traf_agid=:agid AND (lt.lstart_date BETWEEN '$date2' AND '$date2res')");
							$query_week2->bindParam(':agid',$agid);
							$query_week2->execute();
							$week2 = $query_week2->fetchAll();
							if(count($week2)){
							foreach($week2 as $wek2){
								$day = date('D',strtotime($wek2['lstart_date']));
				   		?> 
                            <td>
                                <a href="<?php echo $url; ?>agent/payment_detail/<?php echo $wek2['lead_uniq']; ?>">
                              <div class="calendar_view_box" <?php if($day=='sun'){ ?> style="background:#fed4b2;" <?php }else { ?> style="background:#E5EAF5;" <?php } ?>>          
                                    <p>Lead ID : <?php echo $wek2['lead_uniq']; ?></p>
                                    <p>Trip Starts</p>
                                </div>
                                </a>
                            </td>
                        <?php } } 
							else{ ?>
                        	<td>
                                <a href="#">
                                <div class="calendar_view_box" style="background:#fed4b2;">
                                    <p>NAME : Ssarvesh</p>
                                    <p>Trip Starts</p>
                                </div>
                                </a>
                            </td>
                            <td>
                                <a href="#">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                    <p>NAME : Ssarvesh</p>
                                    <p>Trip Starts</p>
                                </div>
                                </a>
                            </td>
                            <td>
                                <a href="#">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                    <p>NAME : Ssarvesh</p>
                                    <p>Trip Starts</p>
                                </div>
                                </a>
                            </td>
                            <td>
                                <a href="#">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                    <p>NAME : Ssarvesh</p>
                                    <p>Trip Starts</p>
                                </div>
                                </a>
                            </td>
                            <td>
                                <a href="#">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                    <p>NAME : Ssarvesh</p>
                                    <p>Trip Starts</p>
                                </div>
                                </a>
                            </td>
                            <td>
                                <a href="#">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                    <p>NAME : Ssarvesh</p>
                                    <p>Trip Starts</p>
                                </div>
                                </a>
                            </td>
                            <td>
                                <a href="#">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                    <p>NAME : Ssarvesh</p>
                                    <p>Trip Starts</p>
                                </div>
                                </a>
                            </td>

                        <?php } 
						?>
                        </tr>
                        <tr>
                        <?php 
							$query_week3 = $db->prepare("SELECT lt.*,ld.lead_uniq FROM lead_transfer lt JOIN leads ld ON ld.leads_id=lt.traf_leadid WHERE traf_agid=:agid AND (lt.lstart_date BETWEEN '$date3' AND '$date3res')");
							$query_week3->bindParam(':agid',$agid);
							$query_week3->execute();
							$week3 = $query_week3->fetchAll();
							if(count($week3)){
							foreach($week3 as $wek3){
								$day = date('D',strtotime($wek3['lstart_date']));
							 if($wek3['lead_uniq']!=''){	
				   		?> 
                            <td>
                                <a href="<?php echo $url; ?>agent/payment_detail/<?php echo $wek3['lead_uniq']; ?>">
                             <div class="calendar_view_box" <?php if($day=='sun'){ ?> style="background:#fed4b2;" <?php }else { ?> style="background:#E5EAF5;" <?php } ?>>          
                                    <p>Lead ID : <?php echo $wek3['lead_uniq']; ?></p>
                                    <p>Trip Starts</p>
                                </div>
                                </a>
                            </td>
                        <?php } else{ ?> 
                        	<td>
                                <a href="">
                             <div class="calendar_view_box" style="background:#E5EAF5;">          
                                    <p>Vacant</p>
                                    <p></p>
                                </div>
                                </a>
                            </td>    
                        <?php } } }
							else{ ?>
                        	<td>
                                <a href="#">
                                <div class="calendar_view_box" style="background:#fed4b2;">
                                    <p>NAME : Ssarvesh</p>
                                    <p>Trip Starts</p>
                                </div>
                                </a>
                            </td>
                            <td>
                                <a href="#">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                    <p>NAME : Ssarvesh</p>
                                    <p>Trip Starts</p>
                                </div>
                                </a>
                            </td>
                            <td>
                                <a href="#">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                    <p>NAME : Ssarvesh</p>
                                    <p>Trip Starts</p>
                                </div>
                                </a>
                            </td>
                            <td>
                                <a href="#">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                    <p>NAME : Ssarvesh</p>
                                    <p>Trip Starts</p>
                                </div>
                                </a>
                            </td>
                            <td>
                                <a href="#">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                    <p>NAME : Ssarvesh</p>
                                    <p>Trip Starts</p>
                                </div>
                                </a>
                            </td>
                            <td>
                                <a href="#">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                    <p>NAME : Ssarvesh</p>
                                    <p>Trip Starts</p>
                                </div>
                                </a>
                            </td>
                            <td>
                                <a href="#">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                    <p>NAME : Ssarvesh</p>
                                    <p>Trip Starts</p>
                                </div>
                                </a>
                            </td>
                        <?php } 
						?>
                        </tr>
                        <tr>
                        <?php 
							$query_week4 = $db->prepare("SELECT lt.*,ld.lead_uniq FROM lead_transfer lt JOIN leads ld ON ld.leads_id=lt.traf_leadid WHERE traf_agid=:agid AND (lt.lstart_date BETWEEN '$date4' AND '$date4res')");
							$query_week4->bindParam(':agid',$agid);
							$query_week4->execute();
							$week4 = $query_week4->fetchAll();
							if(count($week4)){
							foreach($week4 as $wek4){
								$day = date('D',strtotime($wek4['lstart_date']));
				   		?> 
                            <td>
                                <a href="<?php echo $url; ?>agent/payment_detail/<?php echo $wek4['lead_uniq']; ?>">
                              <div class="calendar_view_box" <?php if($day=='sun'){ ?> style="background:#fed4b2;" <?php }else { ?> style="background:#E5EAF5;" <?php } ?>>          
                                    <p>Lead ID : <?php echo $wek4['lead_uniq']; ?></p>
                                    <p>Trip Starts</p>
                                </div>
                                </a>
                            </td>
                        <?php } } 
							else{ ?>
                        	<td>
                                <a href="#">
                                <div class="calendar_view_box" style="background:#fed4b2;">
                                    <p>NAME : Ssarvesh</p>
                                    <p>Trip Starts</p>
                                </div>
                                </a>
                            </td>
                            <td>
                                <a href="#">
                                <div class="calendar_view_box" style="background:#E5EAF5;">
                                    <p>NAME : Ssarvesh</p>
                                    <p>Trip Starts</p>
                                </div>
                                </a>
                            </td>
                        <?php } 
						?>
                        </tr>
                        
                      </table>
                  </div>
                  
                  <div id="menu2" class="tab-pane fade">
                      <div class="col-md-6 p0">
                      <table class="see-table">
                        <tr>
                            <th><?php echo $dayname; ?></th>
                        </tr>
                        
                   <?php 
				  		$query_current = $db->prepare("SELECT lt.*,ld.lead_uniq FROM lead_transfer lt JOIN leads ld ON ld.leads_id=lt.traf_leadid WHERE traf_agid=:agid AND lt.lstart_date=:curdatee");
						$query_current->bindParam(':curdatee',$curdatee);
						$query_current->bindParam(':agid',$agid);
						$query_current->execute();
						$curr = $query_current->fetchAll();
						if(count($curr)){
						foreach($curr as $cur){
				   ?>      
                        <tr>
                            <td>
                                <a href="#">
                                <div class="calendar_view_box" style="background:#fed4b2;">
                                    <p>NAME : <?php echo $cur['lead_uniq']; ?></p>
                                    <p>Trip Starts</p>
                                </div>
                                </a>
                            </td>
                        </tr>
                    <?php } } 
						else{ ?> 
                    	<tr>
                        	<td>No Record Found</td>
                        </tr>
                    <?php } ?>   
                      </table>
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
<script src="<?php echo $url; ?>/agent/js/vanillaCalendar.js" type="text/javascript"></script>
<script>
	window.addEventListener('load', function () {
		vanillaCalendar.init({
			disablePastDays: true
		});
	})
</script>


</body>
</html>
<?php } } else{ echo "<script>location.assign('".$url."agent/logout.php')</script>"; }
      } else{ echo "<script>location.assign('".$url."agent/logout.php')</script>"; } ?>

