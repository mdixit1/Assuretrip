<?php // error_reporting(0); ?>

<script src="https://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>

<div class="slideadd see-trans5s">
    <span class="navgoin"><img src="../image/pre2.png" alt=""/><strong></strong></span>

    <div class="fulldv main_menu">
        <p><a href="index.php">Dashboard</a></p>
		<p><a href="contactdetail.php">Contact Detail</a></p>
        <p><a href="leads.php">Leads Notification
            <span style="float:right;">
            <?php
                $leadnot = $db->prepare("SELECT COUNT(leads_id) FROM leads WHERE lead_notf='0'");
                $leadnot->execute();
                $notf = $leadnot->fetchColumn();
            ?>
            (<?php echo $notf; ?>)
            </span>
            </a>
        </p>
        <p><a href="userdetail.php">Users</a></p>
    	<p><a href="listingdetail.php">Listing Detail Of Travel Agent</a></p>
        <p><a href="sub-admin.php"> Manage Sub Admin</a></p>
        <p><a href="categories.php">Add Category</a></p>
        <p><a href="country.php">Add Location</a></p>
        <p><a href="activity.php">Add Activity</a></p>
        <p><a href="resort.php">Add Package</a></p>
        <!--<p><a href="keywords.php">Package Highlights</a></p>
        <p><a href="add_skill.php">Add2</a></p>-->
        
        <div class="panel-group" id="accordion">
           <!-- <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse3">Others</a>
                </h4>
              </div>
              <div id="collapse3" class="panel-collapse collapse">
                <div class="panel-body">
                    <a href="addcity.php">Add City</a>
                    <a href="keywords.php">Add Keywords</a>
                </div>
              </div>
            </div> -->
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse4">Setting</a>
                </h4>
              </div>
              <div id="collapse4" class="panel-collapse collapse">
                <div class="panel-body">
                    <a href="admchangepass.php">Change Password</a>
                </div>
              </div>
            </div>
        </div> 
        <p><a href="logout.php"> LogOut </a></p>
    </div>
    

</div>


