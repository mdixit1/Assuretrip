<?php
error_reporting(0);
session_start();
include('function.php');
include('connection/index.php');

if($_POST){
	$getleadid = $db->prepare("SELECT leads_id FROM leads ORDER BY leads_id DESC LIMIT 1");
	$getleadid->bindParam(':uniq',$uniq);
	$getleadid->execute();
	$rowl = $getleadid->fetch();
	$ldid = $rowl['leads_id'];
	
	$hone = $_POST['hotlone'];
	$htwo = $_POST['hotltwo'];
	$hthree = $_POST['hotlthre'];
	$hfour = $_POST['hotlfour'];
	$hfive = $_POST['hotlfive'];
	$flgt = $_POST['flight'];
	$wair = $_POST['bud_with_air'];
	$woutair = $_POST['bud_without_air'];
	$adlut = $_POST['adlt'];
	$inft = $_POST['inft'];
	$child = $_POST['chldrn'];
	$book = $_POST['my_input'];
	$update_lead = $db->prepare("UPDATE leads SET hotel_first=:hone, hotel_second=:htwo, hotel_third=:hthree, hotel_four=:hfour, hotel_five=:hfive, flight=:flgt, budget_withair=:wair, budget_withoutair=:woutair, adult=:adlut, infant=:inft, children=:child, book_type=:book WHERE leads_id=:ldid"); 	
	$update_lead->bindParam(':hone',$hone);
	$update_lead->bindParam(':htwo',$htwo);
	$update_lead->bindParam(':hthree',$hthree);
	$update_lead->bindParam(':hfour',$hfour);
	$update_lead->bindParam(':hfive',$hfive);
	$update_lead->bindParam(':flgt',$flgt);
	$update_lead->bindParam(':wair',$wair);
	$update_lead->bindParam(':woutair',$woutair);
	$update_lead->bindParam(':adlut',$adlut);
	$update_lead->bindParam(':inft',$inft);
	$update_lead->bindParam(':child',$child);
	$update_lead->bindParam(':book',$book);
	$update_lead->bindParam(':ldid',$ldid);
	$update_lead->execute();
	
	
}
?>
<!DOCTYPE html>
<html lang="en-IN">
<head>
    <?php echo headdata(); ?>
    <link rel="canonical" href=""/>
    <link rel='shortlink' href=""/>
    <title>Travel </title>
    <meta name="keywords" content="Travel">
    <meta name="description" content="Travel">
    <meta property="og:url" content="">
    <meta property="og:title" content="Travel"/>
    <meta property="og:image" content="Travel"/>
    <meta property="og:description" content="Travel"/>
    <meta name="twitter:url" content="">
    <meta name="twitter:title" content="Travel">    
    <meta name="twitter:description" content="Travel">
    <meta name="twitter:image:src" content="Travel">
    <meta name="twitter:image:alt" content="Travel">
</head>
<body>
<div class="see-section wrapper">

<script>
$(document).ready(function(){	
	$(document).on('submit', '#third-form', function(){
		var data = $(this).serialize();
		$.ajax({
		type : 'POST',
		url  : "<?php echo $url.'submithree.php';?>",
		data : data,
		success :  function(data)
		   {				
			 $("#third-form").fadeIn(500).show(function()
				  {	
					$(".resultre").fadeIn(500).show(function()
					{	
						$(".resultre").html(data);
					});   
				 });
			}
		});
		return false;
	});
});
</script>       
<div class="overlaydv hidepop" style="background:rgba(0,0,0,0); position:fixed; width:100%; height:100%; top:0; left:0; z-index:999999;">
    <div class="overlaydv-in">
        <div class="overlaydv-inner">
            <div class="callback" role="dialog">
                <div class="modal-dialog popupwid">
                  <div class="modal-content">
                    <div class="modal-body">
                    <!--<button type="button" class="closeop" onClick="hidepop()">&times;</button>-->
                  <div class="resultre">	 
                    <form method="post" id="third-form">
                        <div class="fulldv planyour" style="margin:0;">
                        	<h4>Almost Done!</h4>
                            <p>Preferred Hotel Category <span>(Rating)</span> *</p>
                            <div class="fulldv radiobutton">
                            	<p><input type="text" value="<?php echo $ldid; ?>" name="ldid" hidden="hidden"></p>
                            	<p><i class="fa fa-cab"></i> &nbsp; Cab for local sightseeing? <input type="radio" name="cab" value="yes" onClick="show1()"> Yes <input type="radio" name="cab" value="no" onClick="show2()"> No </p>
                            </div>
                            <script>
								function show1(){
								  document.getElementById('div1').style.display ='block';
								  document.getElementById('div2').style.display ='none';
								}
								function show2(){
								  document.getElementById('div1').style.display = 'none';
								  document.getElementById('div2').style.display = 'block';
								}
							</script>
                            <div class="col-md-12 p0 chooseany_hide willbook" id="div1">
                                <p>Driver speaks</p>
                                <input type="radio" name="speaks" value="English" id="english">
                                <label for="english">English</label>
                                <input type="radio" name="speaks" value="Hindi" id="hindi">
                                <label for="hindi">Hindi</label>
                            </div>
                            <!--<div class="col-md-12 p0 local_experiences">
                                <p>Local Experiences</p>
                                <ul>
                                	<li><input type="checkbox" name=""> Kochi</li>
                                    <li><input type="checkbox" name="#"> Tea Gardens - Munnar</li>
                                    <li><input type="checkbox" name="#"> Spice Gardens - Thekkaddy</li>
                                    <li><input type="checkbox" name="#"> Backwaters and Houseboat - Allepy</li>
                                    <li><input type="checkbox" name="#"> Kumarakom</li>
                                    <li><input type="checkbox" name="#"> Boat Race</li>
                                    <li><input type="checkbox" name="#"> Kovalam Beach</li>
                                </ul>
                            </div>-->
                            
                            <div class="fulldv willbook">
                            	<p>Type of tour you want?</p>
                                <input type="radio" name="tour" value="Honeymoon" id="Honeymoon">
                                <label for="Honeymoon">Honeymoon</label>
                                <input type="radio" name="tour" value="Family" id="Family">
                                <label for="Family">Family</label>
                                <input type="radio" name="tour" value="Adventure" id="Adventure">
                                <label for="Adventure">Adventure</label>
                                <input type="radio" name="tour" value="Offbeat" id="Offbeat">
                                <label for="Offbeat">Offbeat</label>
                                <input type="radio" name="tour" value="Wildlife" id="Wildlife">
                                <label for="Wildlife">Wildlife</label>
                                <input type="radio" name="tour" value="Religious" id="Religious">
                                <label for="Religious">Religious</label>
                            </div>
                            <div class="col-md-12 p0 local_experiences">
                                <p>This week i want to</p>
                                <ul>
                                	<li><input type="radio" name="ths_week" value="have idea about destination"> have idea about destination</li>
                                    <li><input type="radio" name="ths_week" value="have idea about rates"> have idea about rates</li>
                                    <li><input type="radio" name="ths_week" value="book the package"> book the package</li>
                                </ul>
                            </div>
                            <div class="fulldv local_experiences">
                            	<p>Additional requirements</p>
                                <textarea name="add_req" id="" cols="30" rows="10"></textarea>
                            </div>
                            <input type="submit" name="#" value="Submit">
                        </div>
                      </form>
                    </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
          

</div>

</body>
</html>

