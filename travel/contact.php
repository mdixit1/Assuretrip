<?php
error_reporting(0);
session_start();
include('function.php'); 
include('connection/index.php');

	if(isset($_POST['addcontact'])){
		$cname = $_POST['contname'];
		$cmail = $_POST['contmail'];
		$cmob = $_POST['contmob'];
		$cmsg = $_POST['contmsg'];
		$add_contactdetail = $db->prepare("INSERT INTO contact_detail(contact_name,contact_email,contact_mobile,contact_msg,contact_date)VALUES(:cname, :cmail, :cmob, :cmsg, :date)");
		$add_contactdetail->bindParam(':cname',$cname);
		$add_contactdetail->bindParam(':cmail',$cmail);
		$add_contactdetail->bindParam(':cmob',$cmob);
		$add_contactdetail->bindParam(':cmsg',$cmsg);
		$add_contactdetail->bindParam(':date',$date);
		$add_contactdetail->execute();
		if(isset($add_contactdetail)){
			$error = "Detail Submitted Our support team will contact you soon";
		}
		else{
			$error = "Not Submitted";	
		}
	}
?>
<!DOCTYPE html>
<html lang="en-IN">
<head>
    <?php echo headdata(); ?>
    <link rel="canonical" href=""/>
    <link rel='shortlink' href=""/>
	<title>Contact us</title>
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
    <link href="css/animation.css" type="text/css" rel="stylesheet" />
    <link href="<?php echo $url; ?>css/slit-slider.css" type="text/css" rel="stylesheet" />
    <script src="js/modernizr-2.6.2.min.js"></script>
    <link href="http://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
	<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    
</head>
<body>
<div class="see-section wrapper">
	<?php include('header.php'); ?>
    
    <div class="section about_sect">
    	<div class="container">
        	<div class="row">
            	<div class="col-md-12 team_heading">
                	<h1>Get in Touch</h1>
                </div>
                <div class="col-md-9 center-block aboutdv">
                	<p>If you have an enquiry or any questions about our services please contact us</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="section contact_sect">
    	<div class="container">
        	<div class="row">
            	<div class="col-md-6 contact_detail">
                	<ul>
                    	<li><i class="fa fa-phone"></i> CONTACT NUMBER
                        <p>+91 1234567890 </p></li>
                    </ul>
                    <ul>
                    	<li><i class="fa fa-envelope-open"></i> Customer Email ID
                        <p>info@websitename.com </p></li>
                    </ul>
                    <ul>
                    	<li><i class="fa fa-map-marker"></i> Corporate Office <br> 
                        <p><strong>Company Name</strong> <br> D-27, Dummy street, delhi - 123456, India</p></li>
                    </ul>
                </div>
                <div class="col-md-6 contact_detail_form p0">
                <p style="color:rgba(255,0,4,1.00);"><?php if(isset($error)){ echo $error; } ?> </p>
                 <form method="post">
                	<div class="col-md-6">
                    	<p>Full Name</p>
                        <input type="text" name="contname" required/>
                    </div>
                    <div class="col-md-6">
                    	<p>Email ID</p>
                        <input type="email" name="contmail" required/>
                    </div>
                    <div class="col-md-6">
                    	<p>Mobile Mo.</p>
                        <input type="text" name="contmob" onKeyUp="onlydigit(this)" maxlength="10" required/>
                    </div>
                    <div class="col-md-12">
                    	<p>Message</p>
                        <textarea name="contmsg" id="" cols="30" rows="10"></textarea>
                    </div>
                    <div class="col-md-6">
                        <input type="submit" name="addcontact" value="Send">
                    </div>
                  </form>  
                </div>
            </div>
        </div>
    </div>
    
    <div class="section mapdv">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3497.9430892673204!2d77.1950540146474!3d28.751116082371148!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390cfb25895d1daf%3A0xcc67f6c9760dc960!2sAssure+Trips+Private+Limited!5e0!3m2!1sen!2sin!4v1555157240047!5m2!1sen!2sin" frameborder="0" style="border:0" allowfullscreen></iframe>
    </div>
    

    <!-- Footer Section -->
    <?php include('footer.php') ?>

</div>

<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.slitslider.js"></script>
<script src="js/jquery.ba-cond.min.js"></script>
<!-- Custom Functions -->
<script src="js/main.js"></script> 

<script src="<?php echo $url; ?>js/slick.js" type="text/javascript"></script>
<script src="<?php echo $url; ?>js/custom.js" type="text/javascript"></script>
<script src="<?php echo $url; ?>js/jarallax.js" type="text/javascript"></script>
<script>
	  $(document).ready(function(){
    	$(function(){
		$( "#datepicker" ).datepicker({
			minDate: 'dateToday',
			dateFormat: 'yy-m-d', 
			onSelect: function(selected){ 
			$("#datepicker2").datepicker("option","minDate",selected);
         }
		});
	 });
	 
	 $(function() {
		$( "#datepicker2" ).datepicker({
			dateFormat: 'yy-m-d',
			onSelect: function(selected){
				$("#datepicker").datepicker("option","maxDate",selected);
            }
		});
	 });
  });
    </script>
<script type="text/javascript">
	/* init Jarallax */
	$('.jarallax').jarallax({
		speed: 0.5,
		imgWidth: 1366,
		imgHeight: 768
	})
</script>
<script>

function popclose() {
	$('.hidepop').fadeToggle();
	}
</script>


</body>
</html>

