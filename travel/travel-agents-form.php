<?php
//error_reporting(0);
session_start();
include('function.php'); 
include('connection/index.php');
	if(isset($_POST['addstepone'])){
		$uniqid = uniqid();
		$coname = $_POST['coname'];
		$agname = $_POST['agname'];
		$bprmnth = $_POST['bprmnth'];
		$onlnexp = $_POST['onlnexp'];
		$wbsite = $_POST['wbsite'];
		$tmsize = $_POST['tmsize'];
		$hear = $_POST['hear'];
		$mstdesti = $_POST['mstdesti'];
		$dest = $_POST['dest'];
		$mail = $_POST['mail'];
		$mob = $_POST['mob'];
		$pass = md5($mob);
		$skpe = $_POST['skpe'];
		$logo = $_FILES['cmplogo']['name'];
		$logotemp = $_FILES['cmplogo']['tmp_name'];
		$target = "images/company_logo/".$logo;
		$steid = $_POST['steid'];
		$addres = $_POST['add'];
		$check_email = $db->prepare("SELECT COUNT(agent_mail) FROM agent_registration WHERE agent_mail=:mail");	
		$check_email->bindParam(':mail',$mail);
		$check_email->execute();
		$chkmail = $check_email->fetchColumn();
		if($chkmail > 0){ $mesg = "Email already Exists"; }
		else{
			$check_mob = $db->prepare("SELECT COUNT(mobile) FROM agent_registration WHERE mobile=:mob");	
			$check_mob->bindParam(':mob',$mob);
			$check_mob->execute();
			$chkmob = $check_mob->fetchColumn();
			if($chkmob > 0){ $mesg = "Mobile Number already Exists"; }
			else{
				$add_agent = $db->prepare("INSERT INTO agent_registration(agent_uniq,agent_name,agent_company,boking_prmonth,online_exp,agent_website,sale_teamsize,hear_about_us,most_sell_desti,destination_name,agent_mail,agent_pass,mobile,skype_handler,agent_address,agent_state,company_logo,agent_date)VALUES(:uniqid, :agname, :coname, :bprmnth, :onlnexp, :wbsite, :tmsize, :hear, :mstdesti, :dest, :mail, :pass, :mob, :skpe, :addres, :steid, :logo, :date)");
				$add_agent->bindParam(':uniqid',$uniqid);
				$add_agent->bindParam(':agname',$agname);
				$add_agent->bindParam(':coname',$coname);
				$add_agent->bindParam(':bprmnth',$bprmnth);
				$add_agent->bindParam(':onlnexp',$onlnexp);
				$add_agent->bindParam(':wbsite',$wbsite);
				$add_agent->bindParam(':tmsize',$tmsize);
				$add_agent->bindParam(':hear',$hear);
				$add_agent->bindParam(':mstdesti',$mstdesti);
				$add_agent->bindParam(':dest',$dest);
				$add_agent->bindParam(':mail',$mail);
				$add_agent->bindParam(':pass',$pass);
				$add_agent->bindParam(':mob',$mob);
				$add_agent->bindParam(':skpe',$skpe);
				$add_agent->bindParam(':addres',$addres);
				$add_agent->bindParam(':steid',$steid);
				$add_agent->bindParam(':logo',$logo);
				$add_agent->bindParam(':date',$date);
				$add_agent->execute();
				if(isset($add_agent)){
					move_uploaded_file($logotemp,$target);
					$get_agentid = $db->prepare("SELECT agent_id,agent_mail,agent_pass FROM agent_registration WHERE agent_uniq=:uniqid AND agent_mail=:mail AND mobile=:mob ORDER BY agent_id DESC LIMIT 0,1");	
					$get_agentid->bindParam(':uniqid',$uniqid);
					$get_agentid->bindParam(':mail',$mail);
					$get_agentid->bindParam(':mob',$mob);
					$get_agentid->execute();
					$stmt = $get_agentid->fetch();
					$agid = $stmt['agent_id'];
					$_SESSION['agid'] = $agid;
					$_SESSION['agmail'] = $stmt['agent_mail'];
					$_SESSION['agpass'] = $stmt['agent_pass']; 
						header('Location:travel-agents-form/'.$uniqid.'');
				}
			}
		}
	}
	if(isset($_POST['steptwo'])){
		$unqid = $_GET['next'];
		$gid = $_SESSION['agid'];
		$agmail = $_SESSION['agmail'];
		$agpass = $_SESSION['agpass'];
		$oldagncy = $_POST['oldagncy'];
		$noemp = $_POST['noemp'];
		$regon = $_POST['regon'];
		$cprfl = $_POST['coprofile'];
		$hlp = $_POST['hlp'];
		$update_agent = $db->prepare("UPDATE agent_registration SET agent_stablish=:oldagncy, no_of_emp=:noemp, current_travlr_region=:regon, company_profile=:cprfl, help=:hlp WHERE agent_id=:gid AND agent_uniq=:unqid");
		$update_agent->bindParam(':oldagncy',$oldagncy);
		$update_agent->bindParam(':noemp',$noemp);
		$update_agent->bindParam(':regon',$regon);
		$update_agent->bindParam(':cprfl',$cprfl);
		$update_agent->bindParam(':hlp',$hlp);
		$update_agent->bindParam(':gid',$gid);
		$update_agent->bindParam(':unqid',$unqid);
		$update_agent->execute();
		if(isset($update_agent)){
			$to="$agmail";							 
			$from="deepakgarg638@gmail.com";
			$subject='Travel Login Detail';
			$message = 'Name : '.$name.'
					<br/>Email : '. $mail .'
					<br/>Mobile : '. $mob .' 
					<br/>Comapny Name : '. $coname .'  
					<br/> Date : '.$date.' <br/> From Assure trips'; 
			$headers = "From: $from\n";
			$headers .= "MIME-Version: 1.0\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\n";
			if(mail($to, $subject, $message, $headers)){ 
			}
			else{ }
			echo "<script>alert('Your login detail has been sent on your register mail')</script>";
			echo "<script>location.assign('".$url."agent/')</script>";
			
		}
	}

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
		function checkURL (abc) {
			var string = abc.value;
			console.log(abc);
			if (!~string.indexOf("http")){
				console.log("abcd");
				string = "http://" + string;
			}
			abc.value = string;
			return abc
		}
		
		$(document).ready(function(e){
		$('#cntid').change(function(){
			var value =$(this).val();
			if(value==0){
					$('#steid').hide();
				}
				else { $('#steid').show();
					$.post('<?php echo $url; ?>stfunction.php', {value: value}, function(data){
							$('#steid').html(data);
						});
				 }
		});
	});
    </script>
    
</head>
<body>
<div class="see-section wrapper">
	<?php include('header.php'); ?>
    
<?php if(!isset($_GET['next'])){ ?>    
    <!-- Step 1 -->
    <div class="section about_sect agent_form_sect">
    	<div class="container">
        	<div class="row">
            	
                <div class="col-md-9 see-center">
                    <div class="fulldv resultone agent_formdv">	 
                        <div class="col-md-12">
                            <h1>Step -1 <br> <span>Basic Information</span></h1>
                        </div>
                       <p><?php if(isset($mesg)){ echo $mesg; } ?></p>
                        <form method="post" id="second-form" enctype="multipart/form-data">
                            <div class="col-md-6">
                                <p>Company Name*</p>
                                <input type="text" name="coname" required/>
                            </div>
                            <div class="col-md-6">
                                <p>Company Owner*</p>
                                <input type="text" name="agname" required/>
                            </div>
                            <div class="col-md-6">
                                <p>Bookings Per Month</p>
                                <select name="bprmnth" id="">
                                	<option value="" hidden="hidden">Select</option>
                                	<option value="0-5">0-5</option>
                                    <option value="5-15">5-15</option>
                                    <option value="15-25">15-25</option>
                                    <option value="More than 25">More than 25</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <p>Online Experience*</p>
                                <select name="onlnexp" id="">
                                	<option value="" hidden="hidden">Select</option>
                                	<option value="Yes, I have used Google Adwords">Yes, I have used Google Adwords</option>
                                    <option value="Yes, I have used other online sites">Yes, I have used other online sites</option>
                                    <option value="No, I never worked on online queries / requests">No, I never worked on online queries / requests</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <p>Sales Team Size </p>
                                <select name="tmsize" id="">
                                	<option value="" hidden="hidden">Select</option>
                                	<option value="Sales only">Sales only</option>
                                    <option value="Less than 3">Less than 3</option>
                                    <option value="3-5">3-5</option>
                                    <option value="5-10">5-10</option>
                                    <option value="More than 10">More than 10</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <p>Where did you hear about us?</p>
                                <select name="hear" id="">
                                	<option value="" hidden="hidden">Select</option>
                                	<option value="Emails from us">Emails from us</option>
                                    <option value="We called you">We called you</option>
                                    <option value="Google / Bing search">Google / Bing search</option>
                                    <option value="News/ Magazines">News/ Magazines</option>
                                    <option value="LinkedIn / Facebook">LinkedIn / Facebook </option>
                                    <option value="Other Travel Agents">Other Travel Agents</option>
                                    <option value="Your team member">Your team member</option>
                                    <option value="Other / Misc">Other / Misc</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <p>Website*</p>
                                <input type="url" name="wbsite" onblur="checkURL(this)" required/>
                            </div>
                            <div class="col-md-6">
                                <p>Destinations you sell the most*</p>
                                <input type="text" name="mstdesti" required/>
                            </div>
                            <div class="col-md-6">
                                <p>Your Name/ Designation*</p>
                                <input type="text" name="dest" required/>
                            </div>
                            <div class="col-md-6">
                                <p>Email ID*</p>
                                <input type="email" name="mail" required/>
                            </div>
                            <div class="col-md-6">
                                <p>Phone Number*</p>
                                <input type="text" name="mob" onKeyUp="onlydigit(this)" maxlength="10" required/>
                            </div>
                            <div class="col-md-6">
                                <p>Facebook Link </p>
                                <input type="text" name="skpe" />
                            </div>
                            <div class="col-md-4">
                                <p>Company Logo </p>
                                <input type="file" name="cmplogo"/>
                            </div>
                            <div class="col-md-4">
                            	<p>Country</p>
                                <select name="cntid" id="cntid" required>
                                    <option value="" hidden="hidden">Select Country</option>
									   <?php
                                         $all_country = $db->prepare("SELECT * FROM country ORDER BY country_id DESC");
                                         $all_country->execute();
                                         $allcntry = $all_country->fetchAll();
                                         foreach($allcntry as $alcnty){
                                       ?> 	
                                    	<option value="<?php echo $alcnty['country_id']; ?>"><?php echo $alcnty['country_name']; ?></option>
                               <?php } ?>     
                                </select>
                            </div>
                            <div class="col-md-4">
                                <p>State </p>
                                <select name="steid" id="steid" required>
                                    <option value="" hidden="hidden">State</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <p>Address </p>
                                <textarea name="add" id="" cols="30" rows="10"></textarea>
                            </div>
                            <div class="col-md-12">
                            	<input type="submit" name="addstepone" value="Next">
                            </div>
                            
                        </form>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    
    <!-- Step 2 -->
<?php } if(isset($_GET['next'])){ 
		if(isset($_SESSION['agid'])){
?>    
    <div class="section about_sect">
    	<div class="container">
        	<div class="row">
            	
                <div class="col-md-9 see-center">
                    <div class="fulldv resultone agent_formdv">	 
                        <div class="col-md-12">
                            <h1>Step -2 <br> <span>Additional Information</span></h1>
                        </div>
                        <form method="post" id="second-form">
                            
                            <div class="col-md-4">
                                <p class="minheit">How old is you agency?*</p>
                                <select name="oldagncy" id="" required>
                                	<option value="" hidden="hidden">Select</option>
                                	<option value="Less than 2 years old">Less than 2 years old</option>
                                    <option value="2 - 5 years old">2 - 5 years old</option>
                                    <option value="5 - 10 years old">5 - 10 years old</option>
                                    <option value="More than 10 years old">More than 10 years old</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <p class="minheit">Number of Employees?*</p>
                                <select name="noemp" id="" required>
                                	<option value="" hidden="hidden">Select</option>
                                	<option value="Less than 5 employees">Less than 5 employees</option>
                                    <option value="5 - 10 employees">5 - 10 employees</option>
                                    <option value="10 - 15 employees">10 - 15 employees</option>
                                    <option value="More than 15">More than 15</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <p class="minheit">Your current travelers are from which region? <span>(for international user)</span></p>
                                <select name="regon" id="">
                                	<option value="" hidden="hidden">Select</option>
                                	<option value="US">US</option>
                                    <option value="UK">UK</option>
                                    <option value="Rest of Europe">Rest of Europe</option>
                                    <option value="Middle East">Middle East</option>
                                    <option value="India">India</option>
                                    <option value="Asia">Asia</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <p>Company Profile <span>(Specialization, year of registration, company address, annual revenue)</span></p>
                                <textarea name="coprofile" id="" cols="30" rows="10"></textarea>
                            </div>
                            <div class="col-md-12">
                                <p>How can we help? </p>
                                <textarea name="hlp" id="" cols="30" rows="10"></textarea>
                            </div>
                            <div class="col-md-12">
                            	<input type="submit" name="steptwo" value="Join Us">
                            </div>
                            
                        </form>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
<?php } } ?>    
    

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
