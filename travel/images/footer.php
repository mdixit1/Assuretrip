<script type="text/javascript">
$(document).ready(function()
{	
	$(document).on('submit', '#register-form', function()
	{
		var data = $(this).serialize();
		$.ajax({
		type : 'POST',
		url  : 'login.php',
		data : data,
		success : function(data){				
					$("#register-form").fadeIn(500).show(function(){	
						$(".result").fadeIn(500).show(function(){
							$(".result").html(data);
						});   
					 });
				  }
		});
		return false;
	});
});

(function($,W,D)
	{ var JQUERY4U = {};
    JQUERY4U.UTIL = {
        setupFormValidation: function() { $("#recieve-form").validate({
                rules: {
					name: { required: true },
					mobile: { required: true, minlength: 10 , maxlength: 10 , digits: true},
		        },
                messages: { 
				    name: { required: "Please Enter Name " },
					mobile: {
						required: "Enter Mobile Number",
						minlength: "Enter atleast 10 digits Mobile Number",
						maxlength: "Digits not greater than 10 ",
						digits: "Enter Correct Mobile Number"
						
					},
					msg: { required: "Type message" }
			    },
                submitHandler: function(form) {
				form.submit();
                }
            });
        }
    }
    //when the dom has loaded setup form validation rules
    $(D).ready(function($) { JQUERY4U.UTIL.setupFormValidation();  });
})(jQuery, window, document);
</script>


<!-- recieve a call section -->
<div class="receive-dv">
  <div class="call-dv">
  	<img src="images/phone.png" alt=""/> 
  </div>
  <h4>recieve a call</h4>
    <form method="post" id="recieve-form">
        <input type="text" name="name" placeholder="Name" required/>
        <input type="text" maxlength="10" onKeyUp="onlydigit(this)" name="mobile" placeholder="Mobile no." required/>
        <input type="submit" name="recdetail" value="Submit"/>
    </form>
    <?php 
		if(isset($_POST['recdetail'])){ 
			$urname = $_POST['name'];
			$urmobile = $_POST['mobile'];
			$email = 'lead';
			$datesend = date('H:i , D , d M Y');
			if($urname == '' && $urmobile == ''){
				echo "Fill All Fields";
			}
			else{
			$addcontactdetail = $db->exec("INSERT INTO contactdetail(contname,contactmobile,contactstatus,contactdate)VALUES('$urname','$urmobile','By Recieve Call','$datesend')");
				if(isset($addcontactdetail)){	
				$to="achlesh@countywidevacations.com";							 
				$from="$email";
				$subject='Please Call Us : Lead From countywidevacations.com recieve a call Function';
				$message = 'Name : '."$urname".'
							<br/>Mobile : <a href="tel:'.$urmobile.'">'.$urmobile.'</a>
							<br/> Date : '.$datesend.' <br/> From countywidevacations.com'; 
				$headers = "From: $from\n";
				$headers .= "MIME-Version: 1.0\n";
				$headers .= "Content-type: text/html; charset=iso-8859-1\n";
				if(mail($to, $subject, $message, $headers)){ 
					echo "<script>alert(' Thanks . We will Contact you Soon.')</script>"; 
				}
				else{ echo "<script>alert(' Not Send . ')</script>"; }			
				}
				else{
					 echo "Server Problem";
				}
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
      	<h2 class="title-hadding"> Vacations Offer </h2>
        <img src="images/offerimage/<?php echo $alldata['offerimage'];?>" alt=""/>
     </div>  
    </div>
</div>

<!-- footer section -->
<div class="footer">
	<div class="footer-bg">
    <div class="footer-bg-color">
    <div class="see-width">
	  
      <div class="foot-four-dv see-3 see-tb-3 see-ip-4 see-sm-6 see-xm-12">
      	<ul>
        	<li>about us</li>
            <li><a href="about.php">company overview</a></li>
            <li><a href="about.php#vision">Vision</a></li>
            <li><a href="about.php#vision">mission</a></li>
            <li><a href="career.php">careers</a></li>
            <li><a href="certificates.php">Certificates</a></li>
            
        </ul>
      </div>
      
      <div class="foot-four-dv see-3 see-tb-3 see-ip-4 see-sm-6 see-xm-12">
      	<ul>
        	<li>contact us</li>
            <li><a href="our-offices.php">our offices</a></li>
            <li><a href="become-a-franchisee.php">become a franchise</a></li>
            <li><a href="booking.php">for bookings</a></li>
        </ul>
      </div>
      
      <div class="foot-four-dv see-3 see-tb-3 see-ip-4 see-sm-6 see-xm-12">
      	<ul>
        	<li>Discover</li>
            <li><a href="vacations-plan.php"> Vacations Ownership </a></li>
            <li><a href="faq.php"> Quick facts guide</a></li>
            <li><a href="resortdetail.php">resorts</a></li>
            <li><a href="resortlocation.php">destinations</a></li>
            <li><a href="how-it-work.php">How It Works</a></li>
        </ul>
      </div>
      
      <div class="foot-logo-dv foot-four-dv see-3 see-tb-3 see-ip-12 see-sm-6 see-xm-12">
        <ul>	
            <li>join us on</li>
            <li><a href="https://www.facebook.com/countywidevacations" target="_blank"><img src="images/facebook.png" alt="facebook"/></a></li>
            <li><a href="https://www.instagram.com/countywidevacations" target="_blank"><img src="images/instagram.png" alt="instagram"/></a></li>
            <li><a href="https://www.facebook.com/countywidevacations" target="_blank"><img src="images/google.png" alt="google"/></a></li>
            <li><a href="https://www.facebook.com/countywidevacations" target="_blank"><img src="images/twitter.png" alt="twitter"/></a></li>
        </ul>   
        <div class="dv100 googleapp">
        	<p>Download App</p>
            <a href="apps/CountyWide_Vacations.apk"><img src="images/google-play-mobile.png" alt="google-play-mobile"/></a>
            <img src="images/app-store-mobile.png" alt="app-store-mobile" class="store"/>
            <p>PAYMENT METHOD</p>
            <img src="images/payment2.png" alt="payment" class="maymentimg"/>
        </div>
        
      </div>
      
      
      <div class="foot-end">
      	<ul>
        	<li>Copyright © Countywidevacations 2016 - 17 , All rights reserved</li>
        </ul>
        
        <ul>
        	<li><a href="privacy-policy.php">Privacy Policy</a></li>
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
            <div id="form" class="result">
                  <form method="post" id="register-form" novalidate>
                    <span id="pop-close">&times;</span>
                    <img src="images/logo2.png" alt=""/>
                    <h4>Log in</h4>
                    <input type="email" name="email" id="email" placeholder="E-mail / Login ID"/>
                    <input type="password" name="password" id="password" placeholder="Password"/>
                    <input type="submit" name="submit" value="Submit"/>
                    					Or<div class="clear"></div>
                    <a href="book-now.php"><p>Sign Up</p></a>                    
                    <a href="forgotpassword.php" id="forgote">Forgot Password</a>
                  </form>
             </div> 
          </div>
        </div>
    </div>
</div>  

<!-- forgote password pop up section--->
<div class="forgote-popup">
	<div class="pop-off"></div>
	<div class="log-pop">
    	<div class="log-pop-in">
        	<div class="log-pop-inner">
              <form action="" method="post" id="register-form-forgote" novalidate>
                <span id="pop-close">&times;</span>
                <img src="images/logo2.png" alt=""/>
                <h4>Recover Password</h4>
                <input type="email" name="email" id="email" placeholder="Enter Your Registered email" required/>
                <input type="submit" name="submit" value="submit"/>
              </form>
          </div>
        </div>
    </div>
</div>

<!-- window scroll top dv--->
<div class="scroll-top" id="button">
<img src="images/up.png" alt=""/> 
</div>





<!-- One time password -->
<div class="popupdv" id="popup">
    <div class="overlay_one_in">
        <div class="overlay_one_inner">
            <div class="popslose"></div>
            <div class="display-center">
            	<div class="popup_box">
                	<span class="closepopup">&times;</span>
                    <img src="http://countywidevacations.com/images/offerimage/offer59aaa7da6bfc9.jpg" alt=""/> 
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Apple App popup div -->
<div class="popupdv applestoredv">
    <div class="overlay_one_in">
        <div class="overlay_one_inner">
            <div class="popslose popslose2"></div>
            <div class="display-center">
            	<div class="popup_box2">
                	<span class="closepopup">&times;</span>
                    <img src="images/apple-apps.jpg" alt=""/> 
                </div>
            </div>
        </div>
    </div>
</div>