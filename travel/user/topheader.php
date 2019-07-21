<!-- Top Header -->
<?php require_once('../connection/index.php'); ?>

<div class="section headersection see-trans5s">
    <div class="col-md-12 p0">
        <div class="navbtn">
            <span class="spnnavbtn1">&times;</span>
            <span class="spnnavbtn2">&equiv;</span>
        </div>

        <div class="usernamedv">
            <h4><?php echo $recname; ?></h4>
         <?php if($st['profile_image']==''){ ?>   
            <img src="<?php echo $url; ?>user/images/user.png" alt=""/> 
         <?php } else{ ?>
         	<img src="images/<?php echo $st['profile_image']; ?>" alt=""/>
         <?php } ?>   
        </div>
    </div>
</div>