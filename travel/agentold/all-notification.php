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
			
			$update_lead = $db->prepare("UPDATE lead_transfer SET notification='1' WHERE traf_agid=:agid");
			$update_lead->bindParam(':agid',$agid);
			$update_lead->execute();
			
$perpage = 10;
if(isset($_GET["page"])){
$page = intval($_GET["page"]);
} else { $page = 1; }
$calc = $perpage * $page;
$start = $calc - $perpage;			
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
        
        <div class="col-md-12 rightsidebar_top2 notititle">
        	<h4><i class="fa fa-bell"></i> Notification</h4>
        </div>
        
        <div class="fulldv">
        	<div class="fulldv notifi_cat allnoti">
                <table class="see-table">
                <?php
					$show_tlead = $db->prepare("SELECT ld.lead_uniq,tl.confirm_status FROM lead_transfer tl JOIN leads ld ON ld.leads_id=tl.traf_leadid WHERE tl.traf_agid=:agid ORDER BY tl.transfer_id DESC LIMIT $start, $perpage");
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
                            <h4><a href="requested_trips.php">TRIP ID <?php echo $tl['lead_uniq']; ?></a></h4>
                            <h3><strong>Talk in progress with traveler</strong></h3>
                            <p class="mb10"><em>Getting Quote/package customized</em></p>
                            <p>Follow up on this lead as it has been 24 hours last interacted with traveler : call around 4</p>
                        </td>
                        <td><p><a href="#">See comment</a></p></td>
                        <td><p><a href="#">Reply</a></p></td>
                    </tr>
               <?php } ?>  
                </table>
            </div>
            <div class="fulldv pagination_out">
            	<ul class="pagination">
                	<?php 
			 			if(isset($page)){
					$countfiles = $db->prepare("SELECT COUNT(tl.transfer_id) FROM lead_transfer tl JOIN leads ld ON ld.leads_id=tl.traf_leadid WHERE tl.traf_agid=:agid");
					$countfiles->bindParam(':agid',$agid);
					$countfiles->execute();
					$totalfile = $countfiles->fetchColumn();
					if($totalfile > 6){
					$totalPages = ceil($totalfile / $perpage);
						if($page <=1 ){
								echo "<li class='disabled' id='page_links'><a>Prev</a></li>";
						}
						else{
							$j = $page - 1;
							echo "<li><a id='page_a_link' href='".$url."agent/all-notification/".$j."'>Prev</a></li>";
						}
						
						for($i=1; $i <= $totalPages; $i++){
						if($i<>$page){
							echo "<li><a id='page_a_link' href='".$url."agent/all-notification/".$i."'>$i</a></li>";
						}
						else{
							echo "<li class='active' id='page_links'><a>$i</a></li>";
						}
						}
						if($page == $totalPages ){
							echo "<li class='disabled' id='page_links'><a>Next</a></li>";
						}
						else{
							$j = $page + 1;
							echo "<li><a id='page_a_link' href='".$url."agent/all-notification/".$j."'>Next</a></li>";
						}
				}
				}
				    ?>
                </ul>
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

