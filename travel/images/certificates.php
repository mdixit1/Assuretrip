<?php
session_start();
require_once "connection/index.php"; 
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Resort Location</title>
<link href="images/company-overview.png" rel="icon">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta content="telephone=no" name="format-detection">
<link href="style/index.css" rel="stylesheet" type="text/css"/>
<link href="style/main-file.css" rel="stylesheet" type="text/css"/>
<link href="style/responsive.css" rel="stylesheet" type="text/css"/>
<link href='https://fonts.googleapis.com/css?family=Roboto:400,500,700' rel='stylesheet' type='text/css'>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
</head>

<body>
 
<div class="certificatedv_bg">
	<div class="background transparent-one">
        <?php include('newheader.php'); ?>
        <div class="slide-up-box">
			<h4>Certificates</h4>
            <div class="clear"></div>
        </div>
    </div>
</div>
 
 
 <div class="section alllocaitonsect">
    <div class="see-width">
    <div class="dv100">
    	<h3 class="title-hadding">Certificates</h3>
    </div>
     <div class="cycle-slideshow">
		<div class="see-4 see-sm-6 see-xm-12">
            <div class="state-dv certificatedv">
                <img src="images/certificate/certificate.jpg" alt="certificate"/>
            </div>
        </div>
     </div> 
    
    </div>
</div>     
     
     
     
     
     
 
<div class="clear"></div>
<?php include 'footer.php';?>					 
</body>
</html>