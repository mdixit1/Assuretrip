<script>
	$(document).ready(function(){	
		$(document).on('submit', '#login-form', function(){
			var data = $(this).serialize();
			$.ajax({
			type : 'POST',
			url  : "<?php echo $url.'loginprocess.php'; ?>",
			data : data,
			success :  function(data)
					   {		
					   $("#login-form").fadeIn(500).show(function()
							  {	
								$(".resultone").fadeIn(500).show(function()
								{	
									$(".resultone").html(data);
								});   
							 });
						}
			});
			return false;
		});
	});
	
	$(document).ready(function(){	
		$(document).on('submit', '#register-form', function(){
			var data = $(this).serialize();
			$.ajax({
			type : 'POST',
			url  : "<?php echo $url.'registerprocess.php'; ?>",
			data : data,
			success :  function(data)
					   {		
					   $("#register-form").fadeIn(5000).show(function()
							  {	
								$(".result").fadeIn(5000).show(function()
								{	
									$(".result").html(data);
								});   
							 });
						}
			});
			return false;
		});
	});
</script>
<div class="mainnav">
    <div class="home_nav">
        <div class="logo-dv" style="background-color:white;">
            <ul>
                <li class="wow fadeInLeft" ><a href="<?php echo $url; ?>"><img src="<?php echo $url; ?>images/logonew.png"/></a></li>
            </ul>
        </div>
        
        <!--<div class="menu-dv">
            <span class="clo-se-first">&times;</span>
            <span class="clo-se">&equiv;</span>
        </div>-->
      <?php if(isset($_SESSION['usrid']) && isset($_SESSION['usrmail']) && isset($_SESSION['usrpass'])){
				$recid = $_SESSION['usrid'];
				$hdr_usrname = $db->prepare("SELECT user_name FROM users WHERE user_id=:recid");
				$hdr_usrname->bindParam(':recid',$recid);
				$hdr_usrname->execute();
				$hdr = $hdr_usrname->fetch();
	  ?>  
        <ul class="top-link afterlogin"> 
            <li class="wow fadeInRight"><a href="tel:+91-1234567890"><i class="fa fa-phone"></i> <span> Call us - +91-1234567890</span></a></li>
            <li class="wow fadeInRight">
            	<a href="#"><i class="fa fa-user"></i> <span>My Account </span></a>
                <ul class="usersubmenu">
                	<li>
                    	<p><?php echo $hdr['user_name']; ?></p>
                        <a href="<?php echo $url; ?>user/">Profile</a>
                        <a href="<?php echo $url; ?>user/leads.php">Lead</a>
                        <a href="<?php echo $url; ?>user/change-passowrd">Change Password</a>
                        <a href="<?php echo $url; ?>user/logout.php"> LogOut </a>
                    </li>
                </ul>
            </li>
        </ul>
      <?php } elseif(isset($_SESSION['agid']) && isset($_SESSION['agmail']) && isset($_SESSION['agpass'])){
				$agid = $_SESSION['agid'];
				$hdr_agname = $db->prepare("SELECT agent_name FROM agent_registration WHERE agent_id=:agid");
				$hdr_agname->bindParam(':agid',$agid);
				$hdr_agname->execute();
				$hdrag = $hdr_agname->fetch();
	  ?>   
          <ul class="top-link afterlogin"> 
            <li class="wow fadeInRight"><a href="tel:+91-1234567890"><i class="fa fa-phone"></i> <span> Call us - +91-1234567890</span></a></li>
            <li class="wow fadeInRight">
            	<a href="#"><i class="fa fa-user"></i> <span>Agent Account </span></a>
                <ul class="usersubmenu">
                	<li>
                    	<p><?php echo $hdrag['agent_name']; ?></p>
                        <a href="<?php echo $url;?>agent/profile"><i class="fa fa-user"></i> Profile</a>
                        <a href="<?php echo $url;?>agent/changepass"><i class="fa fa-lock"></i> Change Password</a>
                        <a href="<?php echo $url;?>logout.php"><i class="fa fa-power-off"></i> Logout</a>
                    </li>
                </ul>
            
            </li>
        </ul>
     <?php } else{ ?>   
        <ul class="top-link"> 
            <li class="wow fadeInRight"><a href="tel:+91-1234567890"><i class="fa fa-phone"></i> <span> Call us - +91-1234567890</span></a></li>
            <li class="wow fadeInRight"><a href="<?php echo $url;?>travel-agents"><i class="fa fa-user"></i> <span>Travel Agent? Join  Us </span></a></li>
            <li class="wow fadeInRight"><a class="pointer" onClick="login()"><i class="fa fa-sign-in"></i> Log in</a> / <a class="pointer" onClick="sighup()" style="margin-left:0;">Sign Up</a></li>
        </ul>
     <?php } ?>   
    </div>
	
    <div class="menudv">
    	<div class="container">
        	<div class="row">
            	<ul>
                 <?php
				 	$show_hdr_cat = $db->prepare("SELECT * FROM category ORDER BY categoryid DESC");
					$show_hdr_cat->execute();
					$allhdrs = $show_hdr_cat->fetchAll();
					foreach($allhdrs as $alhd){
						$hdcatid = $alhd['categoryid'];
				 ?>
                	<li>
                    	<a href="<?php echo $url; ?>category/<?php echo $alhd['category_url']; ?>"><?php echo $alhd['categoryname']; ?> <span></span></a>
                    	<ul class="megamenu_main">
                        	<li>
                            	<div class="container">
                                	<div class="row">
                                    	<div class="fulldv megamenu">
                                        	<div class="col-md-12 p0">
                                            <?php
												$show_indn_desnt = $db->prepare("SELECT DISTINCT(st.state_name),st.state_id FROM packages pk JOIN state st ON st.state_id=pk.stid WHERE cattid=:hdcatid AND type_destination='0'");
												$show_indn_desnt->bindParam(':hdcatid',$hdcatid);														
												$show_indn_desnt->execute();
												$allindhdrdest = $show_indn_desnt->fetchAll();
												if(count($allindhdrdest)){
											?>
                                            	<div class="col-md-6">
                                                	<h4>Indian Destinations</h4>
                                                    <ul>
                                                    <?php
														foreach($allindhdrdest as $hdr_dsnt){
													?>
                                                    	<li><a href="<?php echo $url; ?>search?state=<?php echo $hdr_dsnt['state_id']; ?>"><?php echo $hdr_dsnt['state_name']; ?></a></li>
                                                    <?php } ?>    
                                                    	<li><a href="">View All</a></li>
                                                    </ul>
                                                </div>
                                             <?php } 
											 	$show_intr_desnt = $db->prepare("SELECT DISTINCT(st.state_name),st.state_id FROM packages pk JOIN state st ON st.state_id=pk.stid WHERE cattid=:hdcatid AND type_destination='1'");
												$show_intr_desnt->bindParam(':hdcatid',$hdcatid);														
												$show_intr_desnt->execute();
												$allinthdrdest = $show_intr_desnt->fetchAll();
												if(count($allinthdrdest)){
											 ?>   
                                                <div class="col-md-6">
                                                	<h4>International Destinations</h4>
                                                    <ul>
                                                    <?php
														foreach($allinthdrdest as $hdr_idsnt){
													?>
                                                    	<li><a href="<?php echo $url; ?>search?state=<?php echo $hdr_idsnt['state_id']; ?>"><?php echo $hdr_idsnt['state_name']; ?></a></li>
                                                    <?php } ?>
                                                        <li><a href="">View All</a></li>
                                                    </ul>
                                                </div>
                                             <?php } ?>   
                                            </div>
                                            <!--<div class="col-md-3"><img src="<?php// echo $url; ?>images/category_image/<?php //echo $alhd['category_image']; ?>" alt=""/></div>-->
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>
                 <?php } ?>   
                   <!-- <li><a href="">Family Packages</a></li>
                    <li><a href="">Holiday Packages</a></li>
                    <li><a href="">Hotels</a></li>
                    <li><a href="">Destination Guides</a></li>
                    <li><a href="">Holiday Themes</a></li>-->
                </ul>
            </div>
        </div>
    </div>

</div>


<!-- Login -->
 <div class="overlaydv loginfixed loginpopdv">
 	<div class="overlaydv-in">
    	<div class="overlaydv-inner">
        	<div class="loginmid">
            <div id="form" class="resultone">
             <form method="post" id="login-form">
            	<span class="closepop" onClick="closeallpop()">&times;</span>
                <h4>Login</h4>
                <div class="fulldv loginwith">
                    <!--<div class="col-md-6 p0">
                        <a href="#" class="login_face"><i class="fa fa-facebook"></i> Login with Facebook</a>
                    </div>-->
                    <div class="col-md-6 p0">
                        <a id="login-button" href="<?= 'https://accounts.google.com/o/oauth2/auth?scope=' . urlencode('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email') . '&redirect_uri=' . urlencode(CLIENT_REDIRECT_URL) . '&response_type=code&client_id=' . CLIENT_ID . '&access_type=online' ?>" class="login_google"><i class="fa fa-google-plus"></i>Login with Google</a>
                    </div>
                </div>
                <h4>Or</h4>
                <p>Email ID</p>
                <input type="email" name="logmail" required/>
                <p>Password</p>
                <input type="password" name="logpassword" required/>
                <!--<button type="submit" name="submit">Login</button>-->
                <input type="submit" name="submit" value="Login">
                <p style="display:inline-block;">Forgot Password?</p>
                <p style="float:right;">New Here?<a onClick="sighup()" class="pointer"> Sign Up</a></p>
              </form>  
             </div>  
            </div>
        </div>
    </div>
 </div>
 
<!-- Sign Up -->
 <div class="overlaydv loginfixed singuppopdv">
 	<div class="overlaydv-in">
    	<div class="overlaydv-inner">
        	<div class="loginmid">
            <div id="form" class="result">
             <form method="post" id="register-form">
            	<span class="closepop" onClick="closeallpop()">&times;</span>
                <h4>Sign Up</h4>
                <div class="fulldv loginwith">
                    <!--<div class="col-md-6 p0">
                        <a href="#" class="login_face"><i class="fa fa-facebook"></i> Sign Up with Facebook</a>
                    </div>-->
                    <div class="col-md-6 p0">
                        <a id="login-button" href="<?= 'https://accounts.google.com/o/oauth2/auth?scope=' . urlencode('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email') . '&redirect_uri=' . urlencode(CLIENT_REDIRECT_URL) . '&response_type=code&client_id=' . CLIENT_ID . '&access_type=online' ?>" class="login_google"><i class="fa fa-google-plus"></i>Login with Google</a>
                    </div>
                </div>
                <h4>Or</h4>
                <p>Full Name</p>
                <input type="text" name="name" required>
                <p>Mobile No.</p>
                <input type="text" name="mob" onKeyUp="onlydigit(this)" required>
                <p>Email ID</p>
                <input type="email" name="mail" required>
                <p>Password</p>
                <input type="password" name="pass" required>
                <p class="accept"><input type="checkbox" name="#">I Accept <a href="#">T & C</a> and <a href="#">Privacy Policy</a></p>
                <input type="submit" name="submit" value="Sign Up">
                <!--<button type="submit" name="submit">Sign Up</button>-->
                <p>Already Have An Account? <a onClick="login()" class="pointer">Login</a></p>
                </form> 
              </div>
            </div>
        </div>
    </div>
 </div>



<script>
	function login() {
		$('.loginpopdv').addClass('show');
		$('.singuppopdv').removeClass('show');
		$('.loginpopdv .loginmid').addClass('big');
		$('.singuppopdv .loginmid').removeClass('big');
		}
	function sighup() {
		$('.singuppopdv').addClass('show');
		$('.loginpopdv').removeClass('show');
		$('.loginpopdv .loginmid').removeClass('big');
		$('.singuppopdv .loginmid').addClass('big');
		}
	function closeallpop() {
		$('.loginfixed').removeClass('show');
		$('.loginmid').removeClass('big');
		}
</script>



<script>
	$(document).ready(function(){	
			$(document).on('submit', '#contact-form', function(){
				var data = $(this).serialize();
				$.ajax({
				type : 'POST',
				url  : "<?php echo $url.'submit1.php';?>",
				data : data,
				success :  function(data)
						   {				
							 $("#contact-form").fadeIn(100).show(function()
								  {	
									$(".result").fadeIn(100).show(function()
									{	
										$(".result").html(data);
									});   
								 });
							}
				});
				return false;
			});
		});
</script>
    

  <script>
	$(document).ready(function() {	
		// Hide the div
		$("#leadform_pop").hide();
		
		// Show the div in 15s
		$("#leadform_pop").delay(15000).fadeIn(500);
	});	
</script>
    
<div class="overlaydv hidepop" id="leadform_pop" style="background:rgba(0,0,0,0.9); position:fixed; width:100%; height:100%; top:0; left:0; z-index:999999;">
      <div class="overlaydv-in">
      	<div class="overlaydv-inner">
            <div class="modal-dialog leadpopup">
                 <button type="button" class="close" onClick="popclose()">&times;</button>
                 <div class="fulldv result">
                   <form method="post" id="contact-form">
                        <div class="form_maindv_in">
                            <div class="fulldv continp">
                                <div class="col-md-6" style="padding:0 5px;">
                                    <p>Email ID <span>(Registered ID)</span></p>
                                    <input type="email" name="lmail" placeholder="Mail ID" required/>
                                </div>
                                <div class="col-md-6" style="padding:0 5px;">
                                    <p>Phone No.</p>
                                    <input type="text" name="lmob" placeholder="Mobile No." maxlength="10" required/>
                                </div>
                            </div>
                            <h2>Hey there! Tell us more about your plan for us to serve you better.</h2>
                            <label for="one" class="radiolabel">
                                <input type="radio" id="one" name="honeymoon" value="i am planning my Family trip" required> i am planning my Family trip
                            </label>
                            <label for="one2" class="radiolabel">
                                <input type="radio" id="one2" name="honeymoon" value="i am planning my Honeymoon trip"> i am planning my Honeymoon trip
                            </label>
                            <label for="one3" class="radiolabel">
                                <input type="radio" id="one3" name="honeymoon" value="i am planning my Business trip"> i am planning my Business trip
                            </label>
                            <input type="submit" class="see-button" name="submit" value="Submit">
                        </div>
                   </form>
                  </div> 
            </div>
        </div>
      </div>
  </div>
  
