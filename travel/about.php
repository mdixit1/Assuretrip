<?php
error_reporting(0);
session_start();
include('function.php'); 
include('connection/index.php');

?>
<!DOCTYPE html>
<html lang="en-IN">
<head>
    <?php echo headdata(); ?>
    <link rel="canonical" href=""/>
    <link rel='shortlink' href=""/>
	<title>About us</title>
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
                	<h1>Building the Holiday Eco-system for Happy Travelers</h1>
                </div>
                <div class="col-md-9 center-block aboutdv">
                	<p>Assure Trips is our brand name, it was incorporated with the aim to provide reliable travel experience. Our motto is to provide quality services and making our clients dream holiday come true. We have been serving domestic and international holidays for decades of years.</p>
                    <p>We urge you to pick and choose every element of your holiday from our wide and varied range of options, so we can customize your trip down to the smallest detail. Our mantra is simple – Whatever makes you happy, makes us happy!</p>
                    <p>We are your one-stop solution for all your travel requirements like Hotels, transportation, Fixed and customized packages etc.</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="section countdown_sect jarallax" style="background:url(images/mountain.jpg)">
    	<div class="container">
        	<div class="row">
            	<h4>interesting facts about us</h4>
                <div class="col-md-3 col-xs-6">
                	<div class="fulldv countdv_main">
                    	<div class="countdv"> 
                        	<div class='numscroller numscroller-big-bottom' data-slno='1' data-min='0' data-max='20' data-delay='10' data-increment="9">0</div>
                            <span>Lakh+</span>
                        </div>
                        <p>Travelers monthly visiting us</p>
                    </div>
                </div>
                <div class="col-md-3 col-xs-6">
                	<div class="fulldv countdv_main">
                    	<div class="countdv">
                        	<div class='numscroller numscroller-big-bottom' data-slno='1' data-min='0' data-max='650' data-delay='10' data-increment="9">0</div>
                            <span>+</span>
                        </div>
                        <p>Network of expert travel agents</p>
                    </div>
                </div>
                <div class="col-md-3 col-xs-6">
                	<div class="fulldv countdv_main">
                        <div class="countdv">
                        	<div class='numscroller numscroller-big-bottom' data-slno='1' data-min='0' data-max='65' data-delay='10' data-increment="5987654">0</div>
                            <span>+</span>
                        </div>
                        <p>Destinations served worldwide</p>
                    </div>
                </div>
                <div class="col-md-3 col-xs-6">
                	<div class="fulldv countdv_main">
                    	<div class="countdv">
                        	<div class='numscroller numscroller-big-bottom' data-slno='1' data-min='0' data-max='97' data-delay='10' data-increment="9876543">0</div>
                            <span>%</span>
                        </div>
                        <p>Positive quotient by travelers</p>
                    </div>
                </div>
            </div>
        </div>
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
$('.headslider').slick({
  dots: true,
  autoplay: true,
  infinite: true,
  //fade: true,
  speed: 1000,
  autoplaySpeed: 3000,
  slidesToShow: 1,
  slidesToScroll: 1,
  cssEase: 'ease'
});

$('.feature_slider').slick({
  dots: true,
  autoplay: true,
  infinite: true,
  //fade: true,
  speed: 1000,
  autoplaySpeed: 3000,
  slidesToShow: 5,
  slidesToScroll: 1,
  cssEase: 'ease'
});

$('.international_slider').slick({
  dots: true,
  autoplay: true,
  infinite: true,
  //fade: true,
  speed: 1000,
  autoplaySpeed: 3000,
  slidesToShow: 4,
  slidesToScroll: 1,
  cssEase: 'ease'
});

$('.budget_slider').slick({
  dots: true,
  autoplay: true,
  infinite: true,
  //fade: true,
  speed: 1000,
  autoplaySpeed: 3000,
  slidesToShow: 3,
  slidesToScroll: 1,
  cssEase: 'ease'
});

$('.testi-slide').slick({
  dots: true,
  autoplay: true,
  infinite: true,
  fade: true,
  speed: 1000,
  autoplaySpeed: 3000,
  slidesToShow: 1,
  slidesToScroll: 1,
  cssEase: 'ease'
});

function popclose() {
	$('.hidepop').fadeToggle();
	}
</script>

<script src="js/numscroller-1.0.js"></script>

</body>
</html>
