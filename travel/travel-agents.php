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
	<title>Travel Agents</title>
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
    
    <script>
		$(document).ready(function(){	
				$(document).on('submit', '#second-form', function(){
					var data = $(this).serialize();
					$.ajax({
					type : 'POST',
					url  : "<?php echo $url.'travel-agents-step2.php';?>",
					data : data,
					success :  function(data)
							   {				
								 $("#second-form").fadeIn(500).show(function()
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
	</script>
    
</head>
<body>
<div class="see-section wrapper">
	<?php include('header.php'); ?>
    
    
    <div class="section growth_sect">
    	<img src="images/economic-growth.jpg" alt=""/>
        <div class="overlaydv">
        	<div class="container">
            	<div class="row">
            		<h2>Get 100% Genuine Travel Leads</h2>    
                    <a href="<?php echo $url; ?>travel-agents-form"> Join us to get free leads</a>
                </div>
            </div>
        </div> 
    </div>
    
    
  <!--<div class="section lead_sect">
    	<div class="container">
        	<div class="row">
            	<div class="col-md-12 showmelead">
                	<h2>Travel Leads - Verified & Premium</h2>
                    <select name="" id="">
                    	<option value="">select</option>
                    </select>
                    <input type="submit" name="#" value="Show me leads">
              </div>
                
                <div class="col-md-12 lead_main_dv">
                    <div class="col-md-12">
                    	<h4>Internationalbiz <span>Verified <i class="fa fa-check"></i></span></h4>
                    </div>
                    <div class="col-md-4">
                        <ul class="listing">
                            <li><img src="images/icon/group.png" alt=""/> 2 Adults & 0 Children</li>
                            <li><img src="images/icon/calender.png" alt=""/> Arriving on May 22, 2019</li>
                            <li><img src="images/icon/calendar2.png" alt=""/> Duration : 7 Days</li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <ul class="listing">
                            <li><img src="images/icon/viewer.png" alt=""/> 3 Agents are looking at this lead</li>
                            <li><img src="images/icon/envelope.png" alt=""/> Email : intexxxxxx@xxxxx.xxx</li>
                            <li><img src="images/icon/telephone.png" alt=""/> Phone : +917XXXXXX</li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <ul class="listing">
                            <li><img src="images/icon/location.png" alt=""/>  From : Delhi</li>
                            <li><img src="images/icon/bed.png" alt=""/> Wants to Purchase</li>
                        </ul>
                        <a href="travel-agents-form.php">Sell your package now</a>
                    </div>
                    
                </div>
                <div class="col-md-12 lead_main_dv">
                    <div class="col-md-12">
                    	<h4>Internationalbiz <span>Verified <i class="fa fa-check"></i></span></h4>
                    </div>
                    <div class="col-md-4">
                        <ul class="listing">
                            <li><img src="images/icon/group.png" alt=""/> 2 Adults & 0 Children</li>
                            <li><img src="images/icon/calender.png" alt=""/> Arriving on May 22, 2019</li>
                            <li><img src="images/icon/calendar2.png" alt=""/> Duration : 7 Days</li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <ul class="listing">
                            <li><img src="images/icon/viewer.png" alt=""/> 3 Agents are looking at this lead</li>
                            <li><img src="images/icon/envelope.png" alt=""/> Email : intexxxxxx@xxxxx.xxx</li>
                            <li><img src="images/icon/telephone.png" alt=""/> Phone : +917XXXXXX</li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <ul class="listing">
                            <li><img src="images/icon/location.png" alt=""/>  From : Delhi</li>
                            <li><img src="images/icon/bed.png" alt=""/> Wants to Purchase</li>
                        </ul>
                        <a href="travel-agents-form.php">Sell your package now</a>
                    </div>
                    
                </div>
                <div class="col-md-12 lead_main_dv">
                    <div class="col-md-12">
                    	<h4>Internationalbiz <span>Verified <i class="fa fa-check"></i></span></h4>
                    </div>
                    <div class="col-md-4">
                        <ul class="listing">
                            <li><img src="images/icon/group.png" alt=""/> 2 Adults & 0 Children</li>
                            <li><img src="images/icon/calender.png" alt=""/> Arriving on May 22, 2019</li>
                            <li><img src="images/icon/calendar2.png" alt=""/> Duration : 7 Days</li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <ul class="listing">
                            <li><img src="images/icon/viewer.png" alt=""/> 3 Agents are looking at this lead</li>
                            <li><img src="images/icon/envelope.png" alt=""/> Email : intexxxxxx@xxxxx.xxx</li>
                            <li><img src="images/icon/telephone.png" alt=""/> Phone : +917XXXXXX</li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <ul class="listing">
                            <li><img src="images/icon/location.png" alt=""/>  From : Delhi</li>
                            <li><img src="images/icon/bed.png" alt=""/> Wants to Purchase</li>
                        </ul>
                        <a href="travel-agents-form.php">Sell your package now</a>
                    </div>
                    
                </div>
                
              <div class="col-md-12 p0">
                    <ul class="pagination pagination-sm">
                    <li class='disabled'><a>Prev</a></li>
                    <li class='active'><a>1</a></li>
                    <li><a href='#'>2</a></li>
                    <li><a href='#'>3</a></li>
                    <li><a href='#'>4</a></li>
                    <li><a href='#'>5</a></li>
                    <li><a href='#'>Next</a></li>                
                    </ul>
                </div>
          </div>
        </div>
    </div>-->

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
