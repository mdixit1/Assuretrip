<!-- Top Header -->
<div class="section headersection see-trans5s">
    <div class="col-md-12 p0">
        <div class="navbtn">
            <span class="spnnavbtn1">&times;</span>
            <span class="spnnavbtn2">&equiv;</span>
        </div>
        
        <p class="toplead">
        	<a href="leads.php" title="Notification"><i class="fa fa-bell"></i>
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
        <p class="toplead">
        	<a href="#" title="calendar"><i class="fa fa-calendar"></i></a>
        </p>

        <div class="usernamedv">
            <h4><?php echo $recname; ?></h4>
            <img src="images/user.png" alt=""/> 
        </div>
    </div>
</div>