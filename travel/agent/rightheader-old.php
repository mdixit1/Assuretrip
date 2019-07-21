<div class="col-md-12 rightsidebar_top1">
    <div class="menuright2">
        <ul>
            <li>
                <img src="<?php echo $url; ?>/agent/images/user.png" alt=""/> <?php echo $recname; ?>
                <ul>
                    <li><a href="<?php echo $url; ?>agent/profile">Public Profile View</a></li>
                    <li><a href="<?php echo $url; ?>agent/account-edit.php">Edit My Account</a></li>
                    <li><a href="<?php echo $url; ?>agent/changepass">Update Password</a></li>
                    <li><a href="<?php echo $url; ?>agent/profile-setting">Profile Settings</a></li>
                    <li><a href="<?php echo $url; ?>agent/logout.php">Sign Out</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="menuright1">
        <ul>
            <li class="backul">
                <a href="<?php echo $st['agent_website']; ?>"><i class="fa fa-globe"></i></a>
                <ul>
                    <li><span></span><a href="#">Website</a></li>
                </ul>
            </li>
            <li class="whiteul">
                <a href="<?php echo $st['skype_handler']; ?>"><i class="fa fa-facebook"></i></a>
                <ul>
                    <li><span></span><a href="#">Facebook</a></li>
                </ul>
            </li>
            <!--<li class="backul">
            
                <a href="#"><i class="fa fa-bar-chart"></i></a>
                <ul>
                    <li><span></span><a href="#">Statistics & Reports</a></li>
                </ul>
            </li>
            <li class="backul">
                <a href="#"><i class="fa fa-calendar"></i></a>
                <ul>
                    <li><span></span><a href="#">Calendar</a></li>
                </ul>
            </li>-->
            <?php
				$show_notifc = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid AND notification='0'");
				$show_notifc->bindParam(':agid',$agid);
				$show_notifc->execute();
				$cntnotf = $show_notifc->fetchColumn();
			?>
            <li class="backul"><a href="<?php echo $url; ?>agent/lead_transfer"><i class="fa fa-bell">(<?php echo $cntnotf; ?>)</i></a>
            	<div class="notification_maindvv">
                	<h1><i class="fa fa-bell"> </i> Notification</h1>
                    <div class="fulldv notifi_cat">
                    	<table>
                        <?php
							$show_tlead = $db->prepare("SELECT ld.lead_uniq,tl.confirm_status,tl.transfer_desc FROM lead_transfer tl JOIN leads ld ON ld.leads_id=tl.traf_leadid WHERE tl.traf_agid=:agid AND tl.notification='0' ORDER BY tl.transfer_id DESC LIMIT 0,5");
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
                                	<h4><a href="<?php echo $url; ?>agent/requested_trips/<?php echo $tl['lead_uniq']; ?>">TRIP ID <?php echo $tl['lead_uniq']; ?></a></h4>
                                    <h3><strong>Talk in progress with traveler</strong></h4>
                                    <p class="mb10"><em>Getting Quote/package customized</em></p>
                                    <p><?php echo $tl['transfer_desc']; ?></p>
                                    <p><a href="#">See comment</a> <a href="#">Reply</a></p>
                                </td>
                            	<!--<td style="width:124px">
                                	<p style="color:#888;"><em>in a few seconds</em></p>
                                </td>-->
                            </tr>
                         <?php } ?>   
                        </table>
                    </div>
                    <div class="fulldv vall">
                    	<a href="<?php echo $url; ?>agent/all-notification">View all</a>
                    </div>
                </div>
                
                <!--<ul>
                    <li><span></span><a href="#">Notification</a></li>
                </ul>-->
            </li>
        </ul>
    </div>
</div>