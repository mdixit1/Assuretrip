<!-- recieve a call section -->
<div class="receive-dv">
  <div class="call-dv">
  	<img src="images/phone.png" alt=""/> 
  </div>
  <h4>recieve a call</h4>
    <form method="post">
        <input type="text" name="username" placeholder="Name" required/>
        <input type="tel" name="usermobile" placeholder="Mobile no." required/>
        <input type="submit" name="senddetail" value="Submit"/>
    </form>
    <?php 
		if(isset($_POST['senddetail'])){ 
			$urname = $_POST['username'];
			$urmobile = $_POST['usermobile'];
			$email = 'lead';
			$datesend = date('H:i , D , d M Y');
			if($urname == '' && $urmobile == ''){
				echo "<script>location.assign('Please Enter Name or Mobile Number')</script>";
			}
			else{
				$to="achlesh@countywidevacations.com";							 
				$from="$email";
				$subject='Please Call Us : Lead From countywidevacations.com recieve a call Function';
				$message = 'Name : '."$urname".'
							<br/>Mobile : <a href="tel:'.$urmobile.'">'."$urmobile".'</a>
							<br/> Date : '."$datesend".' <br/> From countywidevacations.com'; 
				$headers = "From: $from\n";
				$headers .= "MIME-Version: 1.0\n";
				$headers .= "Content-type: text/html; charset=iso-8859-1\n";
				if(mail($to, $subject, $message, $headers)){ echo "<script>alert(' Your Detail Sent . We Contact Soon .')</script>"; }
				else{ echo "<script>alert(' Not Send . ')</script>"; }				
			}
		} 
	?>
</div>

<!-- Membership offers section -->
<div class="section offerdv-sect">
	<div class="see-width">
     <div class="colum-one offers">
     		<?php
				$showofferimg = $db->prepare("SELECT offerimage FROM offerimg ");
				$showofferimg->execute();
				$alldata = $showofferimg->fetch();
			?>	
      	<h2 class="title-hadding"> Vactions offers </h2>
        <img src="images/offerimage/<?php echo $alldata['offerimage'];?>" height="300px" alt=""/>
     </div>  
    </div>
</div>


<!-- footer section -->
<div class="footer">
	<div class="footer-bg">
    <div class="footer-bg-color">
    <div class="see-width">
	  
      <div class="foot-four-dv">
      	<ul>
        	<li>about us</li>
            <li><a href="about.php">company overview</a></li>
            <li><a href="about.php#vision">Vision</a></li>
            <li><a href="about.php#vision">mission</a></li>
            <li><a href="career.php">careers</a></li>
        </ul>
      </div>
      
      <div class="foot-four-dv">
      	<ul>
        	<li>contact us</li>
            <li><a href="our-offices.php">our offices</a></li>
            <li><a href="vacations-plan.php">for new vacation ownership</a></li>
            <li><a href="become-a-franchisee.php">become a franchises</a></li>
            <li><a href="how-it-work.php">for bookings</a></li>
        </ul>
      </div>
      
      <div class="foot-four-dv">
      	<ul>
        	<li>Discover</li>
            <li><a href="vacations-plan.php">vacations ownership types</a></li>
            <li><a href="faq.php"> Quick fact guide</a></li>
            <li><a href="#resorts">resorts</a></li>
            <li><a href="#citysect">destinations</a></li>
        </ul>
      </div>
      
      <div class="foot-logo-dv foot-four-dv">
        <ul>	
            <li>join us on</li>
            <li><a href="#"><img src="images/facebook.png" alt=""/></a></li>
            <li><a href="#"><img src="images/google.png" alt=""/></a></li>
            <li><a href="#"><img src="images/twitter.png" alt=""/></a></li>
            <li><a href="#"><img src="images/linked.png" alt=""/></a></li>
            <li><a href="#"><img src="images/pinterest.png" alt=""/></a></li>
            <li><a href="#"><img src="images/youtube.png" alt=""/></a></li>
            <li><a href="#"><img src="images/instagram.png" alt=""/></a></li>
        </ul>   
      </div>
      
      
      <div class="foot-end">
      	<ul>
        	<li>Design by <a href="http://www.joongroup.in" target="_blank">Joon Group</a></li>
        </ul>
        
        <ul>
        	<li><a href="#">Privacy & Policy</a></li>
            <li>/</li>
            <li><a href="term-condition.php">Terms & Conditions</a></li>
        </ul>
      </div>
      
      
      
  </div>
  <div class="clear"></div>
  </div>
  </div>
</div>





<!-- pop up section--->
<div class="login-popup">
	<div class="pop-off"></div>
	<div class="log-pop">
    	<div class="log-pop-in">
        	<div class="log-pop-inner">
              <form action="" method="post" id="register-form" novalidate>
                <span id="pop-close">&times;</span>
                <img src="images/logo2.png" alt=""/>
                <h4>Log in</h4>
                <input type="email" name="email" id="email" placeholder="E-mail / Login ID"/>
                <input type="password" name="password" id="password" placeholder="Password"/>
                <input type="submit" name="submit" value="Log in"/>
                <a href="#" id="forgote">Forgot Password</a>
              </form>
          </div>
        </div>
    </div>
</div>

<!--  forgote password pop up section--->
<div class="forgote-popup">
	<div class="pop-off"></div>
	<div class="log-pop">
    	<div class="log-pop-in">
        	<div class="log-pop-inner">
              <form action="" method="post" id="register-form-forgote" novalidate>
                <span id="pop-close">&times;</span>
                <img src="images/logo2.png" alt=""/>
                <h4>Recover Password</h4>
                <input type="email" name="email" id="email" placeholder="Enter Your Registered email"/>
                <input type="submit" name="submit" value="submit"/>
              </form>
          </div>
        </div>
    </div>
</div>