<?php
$count_allleads = $db->prepare("SELECT COUNT(transfer_id) FROM lead_transfer WHERE traf_agid=:agid");
$count_allleads->bindParam(':agid',$agid);
$count_allleads->execute();
$alllds = $count_allleads->fetchColumn();
?>
<div class="leftsidebar">
        <div class="col-md-12 performance_dv">
            <center><a href="<?php echo $url;?>"><img src="<?php echo $url; ?>images/logonew.png" alt=""/></a></center>
            <br>
            <h4>Your performance</h4>
            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#home">Yesterday</a></li>
              <li><a data-toggle="tab" href="#menu1">Last Week</a></li>
              <li><a data-toggle="tab" href="#menu2">Last Month</a></li>
            </ul>
    
            <div class="tab-content">
              <div id="home" class="tab-pane fade in active">
                  <div class="col-md-12 convert_out">
                      <h3>Apr 04, 2019</h3>
                      <div class="convert"><span>0</span><p>Converted</p></div>
                  </div>
              </div>
              <div id="menu1" class="tab-pane fade">
                  <div class="col-md-12 convert_out">
                      <h3>Apr 04, 2019</h3>
                      <div class="convert"><span>10</span><p>Converted</p></div>
                  </div>
              </div>
              <div id="menu2" class="tab-pane fade">
                  <div class="col-md-12 convert_out">
                      <h3>Apr 04, 2019</h3>
                      <div class="convert"><span>50</span><p>Converted</p></div>
                  </div>
              </div>
            </div>
        </div>
        
        <div class="col-md-12 p0 tagmg_menu">
            <ul>
                <li>
                    <h4><?php echo $st['agent_company']; ?> </h4>
                </li>
                <li>
                    <a href="<?php echo $url; ?>agent/">
                        <p>Dashboard</p>
                        <p>Location</p>
                        <div class="tagmgdv">
                            <i class="fa fa-home"></i>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $url; ?>agent/lead_transfer">
                        <p>Leads</p>
                        <p>View Leads</p>
                        <span><?php echo $alllds; ?></span>
                        <div class="tagmgdv">
                            <i class="fa fa-map-marker"></i>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $url; ?>agent/account-edit.php">
                        <p>Edit My Account</p>
                        <p>Account</p>
                        <div class="tagmgdv">
                            <i class="fa fa-user-plus"></i>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $url; ?>agent/logout.php">
                        <p>Logout</p>
                        <p><br></p>
                        <div class="tagmgdv">
                            <i class="fa fa-power-off"></i>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    
    </div>