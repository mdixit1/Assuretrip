<?php // error_reporting(0); ?>

<script src="https://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>

<div class="slideadd see-trans5s">
    <span class="navgoin"><img src="../image/pre2.png" alt=""/><strong></strong></span>
    <?php if($st['profile_image']==''){ ?>
		<div class="userprodv"><img src="<?php echo $url; ?>user/images/user.png" alt=""/></div>
    <?php } else{ ?>
    	<div class="userprodv"><img src="images/<?php echo $st['profile_image']; ?>" alt=""/></div>
    <?php } ?>    
    <div class="fulldv main_menu">
        <h4><?php echo $recname;?></h4>
        <p><a href="<?php echo $url; ?>user/"></a></p>
		<p><a href="<?php echo $url; ?>user/">Profile</a></p>
        <p><a href="<?php echo $url; ?>user/leads.php">Enquiry Details</a></p>
        <p><a href="<?php echo $url; ?>user/change-passowrd">Change Password</a></p>
        <p><a href="<?php echo $url; ?>user/logout.php"> LogOut </a></p>
    </div>
    

</div>


