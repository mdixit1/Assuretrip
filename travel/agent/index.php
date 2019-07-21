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
    <link href="css/styleplus.css" type="text/css" rel="stylesheet"/>
    <link href="css/see.css" type="text/css" rel="stylesheet"/>
	<link href="css/responsive-manage.css" type="text/css" rel="stylesheet"/>
	<link href="css/index.css" type="text/css" rel="stylesheet"/>
    <link href="css/style_manage.css" type="text/css" rel="stylesheet" />
    
    
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
                    <div class="panel-heading traveler" role="tab" id="headingOne">
                         <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                              Traveler Replied <p>You need to reply to comments to convert travelers. Recommended to do in 8 hours.</p>
                            </a>
                         </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body dashbod_out">
                        	<div class="fulldv notifi_cat allnoti dashbod">
                                <table class="see-table">
                                <?php
									$show_tlead = $db->prepare("SELECT ld.lead_uniq,tl.confirm_status,tl.transfer_desc,tl.lstart_date FROM lead_transfer tl JOIN leads ld ON ld.leads_id=tl.traf_leadid WHERE tl.traf_agid=:agid ORDER BY tl.transfer_id DESC LIMIT 0,5");
									$show_tlead->bindParam(':agid',$agid);
									$show_tlead->execute();
									$tlrow = $show_tlead->fetchAll();
									foreach($tlrow as $tl){
									 
								?>
                                    <tr>
										<?php if($tl['confirm_status']=='0'){ ?>
                                                <td><span class="active">Active</span></td>
                                        <?php } elseif($tl['confirm_status']=='1'){ ?>
                                            <td><span class="hot">Hot</span></td>
                                        <?php } elseif($tl['confirm_status']=='2'){ ?>
                                            <td><span class="progresss"> In Progress</span></td>
                                        <?php } ?>
                                        <td>
                                            <h4><a href="requested_trips/<?php echo $tl['lead_uniq']; ?>">TRIP ID <?php echo $tl['lead_uniq']; ?></a></h4>
                                            <h3><strong>Talk in progress with traveler</strong></h3>
                                            <p class="mb10"><em>Getting Quote/package customized</em></p>
                                            <p><?php echo $tl['transfer_desc']; ?></p>
                                        </td>
                                        <td><p><a href="<?php echo $url; ?>agent/requested_trips/<?php echo $tl['lead_uniq']; ?>">See comment</a></p></td>
                                        <td><p><a href="<?php echo $url; ?>agent/requested_trips/<?php echo $tl['lead_uniq']; ?>">Reply</a></p></td>
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
  


</div>

<script src="<?php echo $url; ?>js/slick.js" type="text/javascript"></script>
<script src="<?php echo $url; ?>js/custom.js" type="text/javascript"></script>




</body>
</html>
<?php } } else{ echo "<script>location.assign('".$url."agent/logout.php')</script>"; }
      } else{ echo "<script>location.assign('".$url."agent/logout.php')</script>"; } ?>

