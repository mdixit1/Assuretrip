<?php
error_reporting(0);
session_start();
include('function.php');
include('connection/index.php');



if($_POST){
	$uniq = uniqid();
	$destintn = $_POST['destintn'];
	$explor = $_POST['explor'];
	$fromdesti = $_POST['fromdesti'];
	$Choose = $_POST['Choose'];
	if($Choose=='fixed'){
		$deptdate = $_POST['fxdate'];
		$deptday = $_POST['fxday'];
	}
	elseif($Choose=='flexible'){
		$deptdate = $_POST['flxdate'];
		$deptday = $_POST['flxday'];
	}
	elseif($Choose=='anytime'){
		$deptdate = $_POST['anydate'];
		$deptday = $_POST['anyday'];
	}
	$email = $_POST['mail'];
	$moble = $_POST['mob'];
	$pass = md5($moble);
	$add_lead_one = $db->prepare("INSERT INTO leads(lead_uniq,destination_to,exploring,destination_from,departure_type,departure_date,departure_day,email,password,mobile,lead_date)VALUES(:uniq, :destintn, :explor, :fromdesti, :Choose, :deptdate, :deptday, :email, :pass, :moble, :date)");
	$add_lead_one->bindParam(':uniq',$uniq);
	$add_lead_one->bindParam(':destintn',$destintn);
	$add_lead_one->bindParam(':explor',$explor);
	$add_lead_one->bindParam(':fromdesti',$fromdesti);
	$add_lead_one->bindParam(':Choose',$Choose);
	$add_lead_one->bindParam(':deptdate',$deptdate);
	$add_lead_one->bindParam(':deptday',$deptday);
	$add_lead_one->bindParam(':email',$email);
	$add_lead_one->bindParam(':pass',$pass);
	$add_lead_one->bindParam(':moble',$moble);
	$add_lead_one->bindParam(':date',$date);
	$add_lead_one->execute();
}

?>
<!DOCTYPE html>
<html lang="en-IN">
<head>
    <?php echo headdata(); ?>
 	
	
</head>
<body>


				
<script>
	$(document).ready(function(){	
			$(document).on('submit', '#second-form2', function(){
				var data = $(this).serialize();
				$.ajax({
				type : 'POST',
				url  : "<?php echo $url.'submittwo.php';?>",
				data : data,
				success :  function(data)
						   {				
							 $("#second-form2").fadeIn(500).show(function()
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

        
                <!--<button type="button" class="closeop" onClick="hidepop()">&times;</button>-->
                <div class="resultone">	 
                <form method="post" id="second-form2">
                	<div class="fulldv planyour" style="margin:0;">
                        	<h4>Great! Tell Us What You Prefer</h4>
                            <p>Preferred Hotel Category <span>(Rating)</span> *</p>
                            <div class="col-md-12 p0 starcheck">
                            <p><input class="coupon_question" type="checkbox" name="hotlfive" value="5" /> 5 Star</p> 
                            <p><input class="coupon_question" type="checkbox" name="hotlfour" value="4" /> 4 Star</p> 
                            <p><input class="coupon_question" type="checkbox" name="hotlthre" value="3" /> 3 Star</p>
                            <p><input class="coupon_question" type="checkbox" name="hotltwo" value="2" /> 2 Star</p>
                            <p><input class="coupon_question" type="checkbox" name="hotlone" value="1" /> 1 Star</p>
                            <script>
                            	$(".answer").hide();
								$(".coupon_question").click(function() {
									if($(this).is(":checked")) {
										$(".answer").show();
										$(".budgetdv").hide();
									} else {
										$(".answer").hide();
										$(".budgetdv").show();
									}
								});
								$(".coupon_question2").click(function() {
									if($(this).is(":checked")) {
										$(".answer").show();
										$(".budgetdv").hide();
									} else {
										$(".answer").hide();
										$(".budgetdv").show();
									}
								});
                            </script>
                            
                            </div>
                            <div class="fulldv radiobutton">
                            	<p><i class="fa fa-plane"></i> &nbsp; Flights To Be Included? <input type="radio" name="flight" value="Yes" checked onClick="show4()"> Yes <input type="radio" name="flight" value="No" onClick="show5()"> No </p>
                            </div>
                            <script>
								function show4(){
								  document.getElementById('div4').style.display ='block';
								  document.getElementById('div5').style.display ='none';
								}
								function show5(){
								  document.getElementById('div4').style.display = 'none';
								  document.getElementById('div5').style.display = 'block';
								}
							</script>
                            
                            
                            <div class="fulldv budgetdv">
                                <div class="col-md-12 p0 chooseany_hide" id="div4" style="display:inline-block;">
                                    <p>Budget With Airfare : <span>(per person)</span></p>
                                    <input type="text" name="bud_with_air">
                                </div>
                                <div class="col-md-12 p0 chooseany_hide" id="div5">
                                    <p>Budget Without Airfare : <span>(per person)</span></p>
                                    <input type="text" name="bud_without_air">
                                </div>
                            </div>    
                            <div class="fulldv answer willbook">
                            	<p>Budget Without Airfare: <span>( per person )</span></p>
                                <input type="radio" name="Airfare" id="price1">
                                <label for="price1">₹ 6,000</label>
                                <input type="radio" name="Airfare" id="price2">
                                <label for="price2">₹ 6,750</label>
                                <input type="radio" name="Airfare" id="price3">
                                <label for="price3">₹ 7,500</label>
                            </div>
                            
                            <div class="fulldv adultdv">
                            	<div class="col-md-4 p0">
                                	<p>Adults <span>(12+ yrs)</span></p>
                                    <select name="adlt" id="">
                                    	<option value="" hidden="hidden">Select</option>
                                    	<option value="">0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                    </select>
                                </div>
                                <div class="col-md-4 p0">
                                	<p>Infant <span>(0-2yrs)</span></p>
                                    <select name="inft" id="">
                                    	<option value="" hidden="hidden">Select</option>
                                    	<option value="">0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                    </select>
                                </div>
                                <div class="col-md-4 p0">
                                	<p>Children <span>(2-12yrs)</span></p>
                                    <select name="chldrn" id="">
                                    	<option value="" hidden="hidden">Select</option>
                                    	<option value="">0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                    </select>
                                </div>
                            </div>
                            <div class="fulldv willbook">
                            	<p>I Will Book</p>
                                <input type="radio" name="my_input" value="In Next 2-3 Days" id="day">
                                <label for="day">In Next 2-3 Days</label>
                                <input type="radio" name="my_input" value="In This Week" id="week">
                                <label for="week">In This Week</label>
                                <input type="radio" name="my_input" value="In This Month" id="month">
                                <label for="month">In This Month</label>
                                <input type="radio" name="my_input" value="Later Sometime" id="sometime">
                                <label for="sometime">Later Sometime</label>
                                <input type="radio" name="my_input" value="Just Checking Price" id="checking">
                                <label for="checking">Just Checking Price</label>
                            </div>
                            <input type="submit" name="#" value="Next">
                        </div>
                  </form>
                </div>
                

</body>
</html>

