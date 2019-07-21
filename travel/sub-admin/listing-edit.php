<?php
//error_reporting(0);
session_start();
include('../function.php');
include('../connection/index.php');
if(isset($_SESSION['samail']) && isset($_SESSION['said']) && isset($_SESSION['sapass'])){
	$recaid = $_SESSION['said'];
	$recmail = $_SESSION['samail'];
	$recpass = $_SESSION['sapass'];	
	$userdetail = $db->prepare("SELECT * FROM sub_admin WHERE subadmin_id = :recaid AND subadmin_mail = :recmail AND subadmin_password = :recpass AND subadmin_status='1'");
	$userdetail->bindParam(':recaid',$recaid);
	$userdetail->bindParam(':recmail',$recmail);
	$userdetail->bindParam(':recpass',$recpass);
	$userdetail->execute();
	$userd = $userdetail->fetchAll();
	if(count($userd)){
		foreach($userd as $usr){
			$recname = $usr['subadmin_name'];
				if(isset($_GET['lst'])){
					$lstid = $_GET['lst'];
					$lst_name = $db->prepare("SELECT st.state_name,ct.city_name,ar.area_name,lst.* FROM listing_detail lst JOIN states st ON st.state_id=lst.state JOIN cities ct ON ct.city_id=lst.city JOIN area ar ON ar.area_id=lst.area WHERE list_id=:lstid AND mobile_code='0' AND active='1'");
					$lst_name->bindParam(':lstid',$lstid);
					$lst_name->execute();
					$rows = $lst_name->fetch();
					$contact_info = $db->prepare("SELECT * FROM list_contact_detail WHERE cont_lstid=:lstid");
					$contact_info->bindParam(':lstid',$lstid);
					$contact_info->execute();
					$cont = $contact_info->fetch();
					        $show_mon = $db->prepare("SELECT monday,listother_id FROM list_other_detail WHERE othr_lstid=:lstid ORDER BY listother_id DESC LIMIT 1");
							$show_mon->bindParam(':lstid',$lstid);
							$show_mon->execute();
							$mon = $show_mon->fetch();
							$rlinks = substr($mon['monday'],0,8);
							$rlinks1 = substr($mon['monday'],12);
							
						    $show_tue = $db->prepare("SELECT tuesday,listother_id FROM list_other_detail WHERE othr_lstid=:lstid ORDER BY listother_id DESC LIMIT 1");
						    $show_tue->bindParam(':lstid',$lstid);
						    $show_tue->execute();
						    $tue = $show_tue->fetch();
						    $rlinks2 = substr($tue['tuesday'],0,8);
						    $rlinks3 = substr($tue['tuesday'],12);
							  
							$show_wed = $db->prepare("SELECT wednesday,listother_id FROM list_other_detail WHERE othr_lstid=:lstid ORDER BY listother_id DESC LIMIT 1");
	 					    $show_wed->bindParam(':lstid',$lstid);
							$show_wed->execute();
							$wed = $show_wed->fetch();
							$rlinks4 = substr($wed['wednesday'],0,8);
						    $rlinks5 = substr($wed['wednesday'],12);
							
							
							$show_thur = $db->prepare("SELECT thursday,listother_id FROM list_other_detail WHERE othr_lstid=:lstid ORDER BY listother_id DESC LIMIT 1");
							$show_thur->bindParam(':lstid',$lstid);
							$show_thur->execute();
							$thur = $show_thur->fetch();
							$rlinks6 = substr($thur['thursday'],0,8);
						    $rlinks7 = substr($thur['thursday'],12);
							
							$show_fri = $db->prepare("SELECT friday,listother_id FROM list_other_detail WHERE othr_lstid=:lstid ORDER BY listother_id DESC LIMIT 1");
							$show_fri->bindParam(':lstid',$lstid);
							$show_fri->execute();
							$fri = $show_fri->fetch();
							$rlinks8 = substr($fri['friday'],0,8);
						    $rlinks9 = substr($fri['friday'],12);
							
						    $show_sat = $db->prepare("SELECT saturday,listother_id FROM list_other_detail WHERE othr_lstid=:lstid ORDER BY listother_id DESC LIMIT 1");
					        $show_sat->bindParam(':lstid',$lstid);
							$show_sat->execute();
							$sat = $show_sat->fetch();
							$rlinks10 = substr($sat['saturday'],0,8);
						    $rlinks11 = substr($sat['saturday'],12);
							
							
						    $show_sun = $db->prepare("SELECT sunday,listother_id FROM list_other_detail WHERE othr_lstid=:lstid ORDER BY listother_id DESC LIMIT 1");
							$show_sun->bindParam(':lstid',$lstid);
							$show_sun->execute();
							$sun = $show_sun->fetch();
							$rlinks12 = substr($sun['sunday'],0,8);
						    $rlinks13 = substr($sun['sunday'],12);
							 
							 $show_disp = $db->prepare("SELECT display_or_not FROM list_other_detail WHERE othr_lstid=:lstid ORDER BY listother_id DESC LIMIT 1");
							 $show_disp->bindParam(':lstid',$lstid);
							 $show_disp->execute();
							 $dis = $show_disp->fetch();
							
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<?php echo headdata(); ?>
<title>Listing Edit</title>
<link href="css/styleplus.css" type="text/css" rel="stylesheet"/>
<link href="css/responsive-manage.css" type="text/css" rel="stylesheet"/>
<script src="js/index.js"></script>
<script src="../state.js" type="text/javascript"></script>
<script src="../city.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
  $(document).ready(function(e){
    $('#lstcls').change(function(){
		var value =$(this).val();
		if(value==0){
				$('#secid').hide();
			}
			else { $('#secid').show();
				$.post('../statefunction.php', {value: value}, function(data){
						$('#secid').html(data);
					});
			 }
		
		});
});

$(document).ready(function(e){
    $('#secid').change(function(){
		var value =$(this).val();
		if(value==0){
				$('#rotid').hide();
			}
			else { $('#rotid').show();
				$.post('../cityfunction.php', {value: value}, function(data){
						$('#rotid').html(data);
					});
			 }
		
		});
});

$(document).ready(function() {
  $("#checkedAll").change(function(){
    if(this.checked){
      $(".checkSingle").each(function(){
        this.checked=true;
      })              
    }else{
      $(".checkSingle").each(function(){
        this.checked=false;
      })              
    }
  });

  $(".checkSingle").click(function () {
    if ($(this).is(":checked")){
      var isAllChecked = 0;
      $(".checkSingle").each(function(){
        if(!this.checked)
           isAllChecked = 1;
      })              
      if(isAllChecked == 0){ $("#checkedAll").prop("checked", true); }     
    }else {
      $("#checkedAll").prop("checked", false);
    }
  });
});

function ckdel(){
	confirm('Are you sure');	
}
</script>
</head>

<body>

<?php include('aheader.php'); ?>
<div class="slidebody trans5s">
    <?php include('topheader.php'); ?>
    <div class="fulldv adminbody">
        <div class="section profile_sect">
            <div class="col-md-8">
            <h2 class="backbtn"><a href="my-listing.php?lst=<?php echo $lstid; ?>">back</a></h2>
            <?php if(isset($_GET['location'])){ 
                    if(isset($_POST['addlocation'])){
                        $businame = $_POST['busname'];
                        $bldng = $_POST['bldngname'];
                        $street = $_POST['strtname'];
                        $landmrk = $_POST['landmrk'];
                        $stateid = $_POST['steid'];
                        $cityid = $_POST['ctyid'];
                        $areaid = $_POST['areaid'];
                        $pincode = $_POST['pcode'];
                        $country = $_POST['cntry'];
                        $nwdesc = stripslashes($_POST['newdesc']);
                        $add_location = $db->prepare("UPDATE listing_detail SET description=:nwdesc, business_name=:businame, building_name=:bldng, street_name=:street, landmark=:landmrk, country=:country, state=:stateid, city=:cityid, area=:areaid, pincode=:pincode WHERE list_id=:lstid");
                        $add_location->bindParam(':nwdesc',$nwdesc);
                        $add_location->bindParam(':businame',$businame);
                        $add_location->bindParam(':bldng',$bldng);
                        $add_location->bindParam(':street',$street);
                        $add_location->bindParam(':landmrk',$landmrk);
                        $add_location->bindParam(':country',$country);
                        $add_location->bindParam(':stateid',$stateid);
                        $add_location->bindParam(':cityid',$cityid);
                        $add_location->bindParam(':areaid',$areaid);
                        $add_location->bindParam(':pincode',$pincode);
                        $add_location->bindParam(':lstid',$lstid);
                        $add_location->execute();
                        if(isset($add_location)){
                            echo "<script>location.assign('my-listing.php?lst=$lstid')</script>";	
                        }
                        else{
                            $locerror = "Server Error";	
                        }
                    }
             ?> 
                <div class="col-md-12 listing_detail_edit edit_mob">
                    <div class="col-md-12">
                        <h4>Location Information </h4>
                    </div>
                    <div class="col-md-12 p0 form_edit">
                        <form method="post">
                            <div class="col-md-6">
                                <p>Business Name</p>
                                <input type="text" name="busname" value="<?php echo $rows['business_name']; ?>" required/>
                            </div>
                            <div class="col-md-6">
                                <p>Building</p>
                                <input type="text" name="bldngname" value="<?php echo $rows['building_name']; ?>">
                            </div>
                            <div class="col-md-6">
                                <p>Street</p>
                                <input type="text" name="strtname" value="<?php echo $rows['street_name']; ?>" required/>
                            </div>
                            <div class="col-md-6">
                                <p>Landmark</p>
                                <input type="text" name="landmrk" value="Near Shani Bazar Road" value="<?php echo $rows['landmark']; ?>">
                            </div>
                            <div class="col-md-6">
                                <p>State</p>
                                <select name="steid" id="lstcls">
                                    <option value="<?php echo $rows['state']; ?>" hidden="hidden"><?php echo $rows['state_name']; ?></option>
                                    <?php
                                        $showstates = $db->prepare("SELECT * FROM states ORDER BY state_name ASC"); 
                                        $showstates->execute();
                                        $allsts = $showstates->fetchAll();
                                        foreach($allsts as $allst){
                                            $stid = $allst['state_id'];
                                            $stname = $allst['state_name'];
                                            echo "<option value='$stid'>$stname</option>";		
                                        }
                                     ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <p>City</p>
                                <select name="ctyid" id="secid" required/>
                                    <option value="<?php echo $rows['city']; ?>" hidden="hidden"><?php echo $rows['city_name']; ?></option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <p>Area</p>
                                <select name="areaid" id="rotid" required/>
                                    <option value="<?php echo $rows['area']; ?>" hidden="hidden"><?php echo $rows['area_name']; ?></option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <p>Pin Code</p>
                                <input type="text" name="pcode" value="<?php echo $rows['pincode']; ?>" required/>
                            </div>
                            <div class="col-md-6">
                                <p>Country</p>
                                <input type="text" name="cntry" value="<?php echo $rows['country']; ?>">
                            </div>
                            <div class="col-md-12">
                                <p>Description</p>
                                <textarea name="newdesc" id="" cols="30" rows="10"><?php echo $rows['description']; ?></textarea>
                               
                            </div>
                            <div class="col-md-12">
                                <input type="submit" name="addlocation" value="Submit">
                            </div>
                        </form>
                    </div>
                </div>
                
             <?php } elseif(isset($_GET['contact'])){ 
                    if(isset($_POST['addcontact'])){
                        $name = $_POST['cname'];
                        $designtn = $_POST['desgn'];
                        $mob = $_POST['mob'];
                        $landline = $_POST['land'];
                        $tfree = $_POST['tolfree'];
                        $mail = $_POST['mail'];
                        $web = $_POST['website'];
                        $checkmob = $db->prepare("SELECT COUNT(cmobile) FROM list_contact_detail WHERE cmobile=:mob");
                        $checkmob->bindParam(':mob',$mob);
                        $checkmob->execute();
                        $ckmob = $checkmob->bindColumn();
                        if($ckmob > 0){ $error = "Mobile Number Already Exists"; }
                        else{
                            $checkmail = $db->prepare("SELECT COUNT(cmail) FROM list_contact_detail WHERE cmail=:mail");
                            $checkmail->bindParam(':mail',$mail);
                            $checkmail->execute();
                            $ckml = $checkmail->bindColumn();
                            if($ckml > 0){ $error = "Email Number Already Exists"; }
                            else{
                                $add_lists = $db->prepare("UPDATE list_contact_detail SET cname=:name, designation=:designtn,cmobile=:mob,clandline=:landline,tollfree_no=:tfree,cmail=:mail,website=:web WHERE cont_lstid=:lstid");	
                                $add_lists->bindParam(':lstid',$lstid);
                                $add_lists->bindParam(':name',$name);
                                $add_lists->bindParam(':designtn',$designtn);
                                $add_lists->bindParam(':mob',$mob);
                                $add_lists->bindParam(':landline',$landline);
                                $add_lists->bindParam(':tfree',$tfree);
                                $add_lists->bindParam(':mail',$mail);
                                $add_lists->bindParam(':web',$web);
                                $add_lists->execute();
                                if(isset($add_lists)){
                                    echo "<script>location.assign('my-listing.php?lst=$lstid')</script>";
                                }
                                else{
                                }
                            }
                        }
                    }
             ?>    
                
                <div class="col-md-12 listing_detail_edit edit_mob">
                    <div class="col-md-12">
                        <h4>Contact Information </h4>
                    </div>
                    <div class="col-md-12 p0 form_edit">
                        <form method="post">
                            <div class="col-md-6">
                                <p>Full name</p>
                                <input type="text" name="cname" value="<?php echo $cont['cname']; ?>" required/>
                            </div>
                            <div class="col-md-6">
                                <p>Designation</p>
                                <input type="text" name="desgn" value="<?php echo $cont['designation']; ?>" required/>
                            </div>
                            <div class="col-md-6">
                                <p>Mobile No.</p>
                                <input type="text" name="mob" value="<?php echo $cont['cmobile']; ?>" required/>
                            </div>
                            <div class="col-md-6">
                                <p>Landline No.</p>
                                <input type="text" name="land" value="<?php echo $cont['clandline']; ?>">
                            </div>
                            <div class="col-md-6">
                                <p>Toll Free No.</p>
                                <input type="text" name="tolfree" value="<?php echo $cont['tollfree_no']; ?>">
                            </div>
                            <div class="col-md-6">
                                <p>Email ID.</p>
                                <input type="text" name="mail" value="<?php echo $cont['cmail']; ?>" required>
                            </div>
                            <div class="col-md-6">
                                <p>Website</p>
                                <input type="text" name="website" value="<?php echo $cont['website']; ?>" required>
                            </div>
                            <div class="col-md-12">
                                <input type="submit" name="addcontact" value="Submit">
                            </div>
                        </form>
                    </div>
                </div>
             
             <?php } elseif(isset($_GET['other'])){ 
                       if(isset($_POST['addother'])){
                        $disply = $_POST['disply'];
                        $mo = $_POST['mndy'];
                        $mo1 = $_POST['mndy1'];
                        $mondy = $mo." To ".$mo1;
                        $ckmondy = $_POST['ckmndy'];
                        if($ckmondy==''){
                            $moval = $mondy;		
                        }
                        else{
                            $moval = $ckmondy;
                        }
                        
                        $tue = $_POST['tusdy'];
                        $tue1 = $_POST['tusdy1'];
                        $tuedy = $tue." To ".$tue1;
                        $cktuedy = $_POST['cktusdy'];
                        if($cktuedy==''){
                            $tuval = $tuedy;		
                        }
                        else{
                            $tuval = $cktuedy;
                        }
                        
                        $we = $_POST['weddy'];
                        $we1 = $_POST['weddy1'];
                        $wedy = $we." To ".$we1;
                        $ckwedy = $_POST['ckweddy'];
                        if($ckwedy==''){
                            $weval = $wedy;		
                        }
                        else{
                            $weval = $ckwedy;
                        }
                        
                        $thu = $_POST['thurdy'];
                        $thu1 = $_POST['thurdy1'];
                        $thudy = $thu." To ".$thu1;
                        $ckthudy = $_POST['ckthurdy'];
                        if($ckthudy==''){
                            $thuval = $thudy;		
                        }
                        else{
                            $thuval = $ckthudy;
                        }
                        
                        $fr = $_POST['frday'];
                        $fr1 = $_POST['frday1'];
                        $fridy = $fr." To ".$fr1;
                        $ckfridy = $_POST['ckfrday'];
                        if($ckfridy==''){
                            $frval = $fridy;		
                        }
                        else{
                            $frval = $ckfridy;
                        }
                        
                        $st = $_POST['satdy'];
                        $st1 = $_POST['satdy1'];
                        $stdy = $st." To ".$st1;
                        $ckstdy = $_POST['cksatdy'];
                        if($ckstdy==''){
                            $stval = $stdy;		
                        }
                        else{
                            $stval = $ckstdy;
                        }
                        
                        $sun = $_POST['sndy'];
                        $sun1 = $_POST['sndy1'];
                        $sundy = $sun." To ".$sun1;
                        $cksundy = $_POST['cksndy'];
                        if($cksundy==''){
                            $sunval = $sundy;		
                        }
                        else{
                            $sunval = $cksundy;
                        }
                        $check_detail = $db->prepare("SELECT COUNT(listother_id) FROM list_other_detail WHERE othr_lstid=:lstid");
                        $check_detail->bindParam(':lstid',$lstid);
                        $check_detail->execute();
                        $ckd = $check_detail->fetchColumn();
                        if($ckd > 0 ){ 
                            $update_time = $db->prepare("UPDATE list_other_detail SET monday=:moval, tuesday=:tuval, wednesday=:weval, thursday=:thuval, friday=:frval, saturday=:stval, sunday=:sunval, display_or_not=:disply WHERE othr_lstid=:lstid");
                            $update_time->bindParam(':moval',$moval);
                            $update_time->bindParam(':tuval',$tuval);
                            $update_time->bindParam(':weval',$weval);
                            $update_time->bindParam(':thuval',$thuval);
                            $update_time->bindParam(':frval',$frval);
                            $update_time->bindParam(':stval',$stval);
                            $update_time->bindParam(':sunval',$sunval);
                            $update_time->bindParam(':disply',$disply);
                            $update_time->bindParam(':lstid',$lstid);
                            $update_time->execute();
                            
                        }
                        else{
                            $add_odetail = $db->prepare("INSERT INTO list_other_detail(othr_lstid,monday,tuesday,wednesday,thursday,friday,saturday,sunday,display_or_not,other_date)VALUES(:lstid, :moval, :tuval, :weval, :thuval, :frval, :stval, :sunval, :disply, :date)");
                            $add_odetail->bindParam(':lstid',$lstid);
                            $add_odetail->bindParam(':moval',$moval);
                            $add_odetail->bindParam(':tuval',$tuval);
                            $add_odetail->bindParam(':weval',$weval);
                            $add_odetail->bindParam(':thuval',$thuval);
                            $add_odetail->bindParam(':frval',$frval);
                            $add_odetail->bindParam(':stval',$stval);
                            $add_odetail->bindParam(':sunval',$sunval);
                            $add_odetail->bindParam(':disply',$disply);
                            $add_odetail->bindParam(':date',$date);
                            $add_odetail->execute();
                        }
                            foreach($_POST['va'] as $val){
                              if($val!=''){	
                              $check_payment = $db->prepare("INSERT INTO payment_option(pay_lstid,mayment_modes,payment_date)VALUES(:lstid, :val, :date)");
                                $check_payment->bindParam(':lstid',$lstid);
                                $check_payment->bindParam(':val',$val);
                                $check_payment->bindParam(':date',$date);
                                $check_payment->execute();
                              }
                            }
                            $year = $_POST['yrs'];
                            $turn = $_POST['turnovr'];
                            $emp = $_POST['emply'];
                            $prof = $_POST['profasso'];
                            $cert = $_POST['certif'];
                            $add_compinfo = $db->prepare("UPDATE listing_detail SET year=:year, anual_turnover=:turn, no_employees=:emp, professional_associations=:prof, certification=:cert WHERE list_id=:lstid");
                            $add_compinfo->bindParam(':year',$year);
                            $add_compinfo->bindParam(':turn',$turn);
                            $add_compinfo->bindParam(':emp',$emp);
                            $add_compinfo->bindParam(':prof',$prof);
                            $add_compinfo->bindParam(':cert',$cert);
                            $add_compinfo->bindParam(':lstid',$lstid);
                            $add_compinfo->execute();
                                echo "<script>location.assign('listing-edit.php?lst=$lstid&other')</script>";
                    }
                        if(isset($_GET['del'])){
                        $delkid = $_GET['del'];
                        $delete_pay = $db->prepare("DELETE FROM payment_option WHERE payment_id=:delkid");  
                        $delete_pay->bindParam(':delkid',$delkid);
                        $delete_pay->execute();
                        if(isset($delete_pay)){ echo "<script>location.assign('listing-edit.php?lst=$lstid&other')</script>"; } 
                      }
                        if(isset($_GET['all'])){
                        $deltid = $_GET['all'];
                        $delete_time = $db->prepare("DELETE FROM list_other_detail WHERE listother_id=:deltid");  
                        $delete_time->bindParam(':deltid',$deltid);
                        $delete_time->execute();
                        if(isset($delete_time)){ echo "<script>location.assign('listing-edit.php?lst=$lstid&other')</script>"; } 
                      }
                      if(isset($_GET['delmon'])){
                        $delmon = $_GET['delmon'];
                        $delete_mon = $db->prepare("UPDATE list_other_detail SET monday='' WHERE listother_id=:delmon");  
                        $delete_mon->bindParam(':delmon',$delmon);
                        $delete_mon->execute();
                        if(isset($delete_mon)){ echo "<script>location.assign('listing-edit.php?lst=$lstid&other')</script>"; } 
                      }
                      if(isset($_GET['deltue'])){
                        $deltue = $_GET['deltue'];
                        $delete_tue = $db->prepare("UPDATE list_other_detail SET tuesday='' WHERE listother_id=:deltue");  
                        $delete_tue->bindParam(':deltue',$deltue);
                        $delete_tue->execute();
                        if(isset($delete_tue)){ echo "<script>location.assign('listing-edit.php?lst=$lstid&other')</script>"; } 
                      }
                      if(isset($_GET['delwed'])){
                        $delwed = $_GET['delwed'];
                        $delete_wed = $db->prepare("UPDATE list_other_detail SET wednesday='' WHERE listother_id=:delwed");  
                        $delete_wed->bindParam(':delwed',$delwed);
                        $delete_wed->execute();
                        if(isset($delete_wed)){ echo "<script>location.assign('listing-edit.php?lst=$lstid&other')</script>"; } 
                      }
                      if(isset($_GET['delthu'])){
                        $delthu = $_GET['delthu'];
                        $delete_thu = $db->prepare("UPDATE list_other_detail SET thursday='' WHERE listother_id=:delthu");  
                        $delete_thu->bindParam(':delthu',$delthu);
                        $delete_thu->execute();
                        if(isset($delete_thu)){ echo "<script>location.assign('listing-edit.php?lst=$lstid&other')</script>"; } 
                      }
                      if(isset($_GET['delfri'])){
                        $delfri = $_GET['delfri'];
                        $delete_fri = $db->prepare("UPDATE list_other_detail SET friday='' WHERE listother_id=:delfri");  
                        $delete_fri->bindParam(':delfri',$delfri);
                        $delete_fri->execute();
                        if(isset($delete_fri)){ echo "<script>location.assign('listing-edit.php?lst=$lstid&other')</script>"; } 
                      }
                      if(isset($_GET['delsat'])){
                        $delsat = $_GET['delsat'];
                        $delete_sat = $db->prepare("UPDATE list_other_detail SET saturday='' WHERE listother_id=:delsat");  
                        $delete_sat->bindParam(':delsat',$delsat);
                        $delete_sat->execute();
                        if(isset($delete_sat)){ echo "<script>location.assign('listing-edit.php?lst=$lstid&other')</script>"; } 
                      }
                      if(isset($_GET['delsun'])){
                        $delsun = $_GET['delsun'];
                        $delete_sun = $db->prepare("UPDATE list_other_detail SET sunday='' WHERE listother_id=:delsun");  
                        $delete_sun->bindParam(':delsun',$delsun);
                        $delete_sun->execute();
                        if(isset($delete_sun)){ echo "<script>location.assign('listing-edit.php?lst=$lstid&other')</script>"; } 
                      }
             ?>  
               
                <div class="col-md-12 listing_detail_edit edit_mob">
                    <div class="col-md-12">
                        <h4>Other Information </h4>
                    </div>
                    <div class="col-md-12 p0 form_edit">
                     <?php if(isset($oerror)){ echo $oerror; } ?>
                        <form method="post">
                            <div class="col-md-12 p0">
                                <div class="col-md-6">
                                 <?php if($dis['display_or_not']=='yes'){ ?>
                                    <p><input type="radio" value="yes" name="disply" checked> Display hours of operation</p>
                                 <?php } else { ?>
                                    <p><input type="radio" value="yes" name="disply"> Display hours of operation</p>
                                 <?php } ?>   
                                </div>
                                <div class="col-md-6">
                                 <?php if($dis['display_or_not']=='no'){ ?>
                                    <p><input type="radio" value="no" name="disply" checked> Do not display hours of operation </p>
                                 <?php } else { ?>
                                    <p><input type="radio" value="no" name="disply"> Do not display hours of operation </p>
                                 <?php } ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <ul class="time_hour time_edit">
                                <?php if($mon['monday']!=''){ ?><a href="listing-edit.php?lst=<?php echo $lstid; ?>&other&delmon=<?php echo $mon['listother_id']; ?>" onClick="return ckdel();"><li>Mon = <?php echo $mon['monday']; ?>&nbsp;&nbsp;<img src="<?php echo $url ?>images/f-box-close-icon1.png" height="15px;"></li></a><?php } ?>
                                <?php if($tue['tuesday']!=''){ ?><a href="listing-edit.php?lst=<?php echo $lstid; ?>&other&deltue=<?php echo $tue['listother_id']; ?>" onClick="return ckdel();"><li>Tue = <?php echo $tue['tuesday']; ?>&nbsp;&nbsp;<img src="<?php echo $url ?>images/f-box-close-icon1.png" height="15px;"></li></a><?php } ?>
                                <?php if($wed['wednesday']!=''){ ?><a href="listing-edit.php?lst=<?php echo $lstid; ?>&other&delwed=<?php echo $wed['listother_id']; ?>" onClick="return ckdel();"><li>Wed = <?php echo $wed['wednesday']; ?>&nbsp;&nbsp;<img src="<?php echo $url ?>images/f-box-close-icon1.png" height="15px;"></li></a><?php } ?>
                                <?php if($thur['thursday']!=''){ ?><a href="listing-edit.php?lst=<?php echo $lstid; ?>&other&delthu=<?php echo $thur['listother_id']; ?>" onClick="return ckdel();"><li>Thu = <?php echo $thur['thursday']; ?>&nbsp;&nbsp;<img src="<?php echo $url ?>images/f-box-close-icon1.png" height="15px;"></li></a><?php } ?>
                                <?php if($fri['friday']!=''){ ?><a href="listing-edit.php?lst=<?php echo $lstid; ?>&other&delfri=<?php echo $fri['listother_id']; ?>"  onClick="return ckdel();"><li>Fri = <?php echo $fri['friday']; ?>&nbsp;&nbsp;<img src="<?php echo $url ?>images/f-box-close-icon1.png" height="15px;"></li></a><?php } ?>
                                <?php if($sat['saturday']!=''){ ?><a href="listing-edit.php?lst=<?php echo $lstid; ?>&other&delsat=<?php echo $sat['listother_id']; ?>" onClick="return ckdel();"><li>Sat = <?php echo $sat['saturday']; ?>&nbsp;&nbsp;<img src="<?php echo $url ?>images/f-box-close-icon1.png" height="15px;"></li></a><?php } ?>
                                <?php if($sun['sunday']!=''){ ?><a href="listing-edit.php?lst=<?php echo $lstid; ?>&other&delsun=<?php echo $sun['listother_id']; ?>" onClick="return ckdel();"><li>Sun = <?php echo $sun['sunday']; ?>&nbsp;&nbsp;<img src="<?php echo $url ?>images/f-box-close-icon1.png" height="15px;"></li></a><?php } ?>
                                <li><a href="listing-edit.php?lst=<?php echo $lstid; ?>&other&all=<?php echo $mon['listother_id']; ?>" onClick="return ckdel();">Delete All Time</a></li>
                                <br>
                            <li>
                                <p>Monday :</p> 
                                <select name="mndy" id="">
                                    <option value="<?php echo $rlinks; ?>" hidden=""><?php echo $rlinks; ?></option>
                                    <option value="Open 24 Hour">Open 24 Hour</option>
                                    <option value="06:00 AM">06:00 AM</option>
                                    <option value="06:30 AM">06:30 AM</option>
                                    <option value="07:00 AM">07:00 AM</option>
                                    <option value="07:30 AM">07:30 AM</option>
                                    <option value="08:00 AM">08:00 AM</option>
                                    <option value="08:30 AM">08:30 AM</option>
                                    <option value="09:00 AM">09:00 AM</option>
                                    <option value="09:30 AM">09:30 AM</option>
                                    <option value="10:00 AM">10:00 AM</option>
                                    <option value="10:30 AM">10:30 AM</option>
                                    <option value="11:00 AM">11:00 AM</option>
                                    <option value="11:30 AM">11:30 AM</option>
                                    <option value="12:00 PM">12:00 PM</option>
                                    <option value="12:30 PM">12:30 PM</option>
                                    <option value="1:00 PM">1:00 PM</option>
                                    <option value="1:30 PM">1:30 PM</option>
                                    <option value="2:00 PM">2:00 PM</option>
                                    <option value="2:30 PM">2:30 PM</option>
                                    <option value="3:00 PM">3:00 PM</option>
                                    <option value="3:30 PM">3:30 PM</option>
                                    <option value="4:00 PM">4:00 PM</option>
                                    <option value="4:30 PM">4:30 PM</option>
                                    <option value="5:00 PM">5:00 PM</option>
                                    <option value="5:30 PM">5:30 PM</option>
                                    <option value="6:00 PM">6:00 PM</option>
                                    <option value="6:30 PM">6:30 PM</option>
                                    <option value="7:00 PM">7:00 PM</option>
                                    <option value="7:30 PM">7:30 PM</option>
                                    <option value="8:00 PM">8:00 PM</option>
                                    <option value="8:30 PM">8:30 PM</option>
                                    <option value="9:00 PM">9:00 PM</option>
                                    <option value="9:30 PM">9:30 PM</option>
                                    <option value="10:00 PM">10:00 PM</option>
                                    <option value="10:30 PM">10:30 PM</option>
                                    <option value="11:00 PM">11:00 PM</option>
                                    <option value="11:30 PM">11:30 PM</option>
                                    <option value="12:00 AM">12:00 AM</option>
                                </select>
                                <p>To</p>
                                <select name="mndy1" id="">
                                    <option value="<?php echo $rlinks1; ?>" hidden=""><?php echo $rlinks1; ?></option>
                                    <option value="Open 24 Hour">Open 24 Hour</option>
                                    <option value="06:00 AM">06:00 AM</option>
                                    <option value="06:30 AM">06:30 AM</option>
                                    <option value="07:00 AM">07:00 AM</option>
                                    <option value="07:30 AM">07:30 AM</option>
                                    <option value="08:00 AM">08:00 AM</option>
                                    <option value="08:30 AM">08:30 AM</option>
                                    <option value="09:00 AM">09:00 AM</option>
                                    <option value="09:30 AM">09:30 AM</option>
                                    <option value="10:00 AM">10:00 AM</option>
                                    <option value="10:30 AM">10:30 AM</option>
                                    <option value="11:00 AM">11:00 AM</option>
                                    <option value="11:30 AM">11:30 AM</option>
                                    <option value="12:00 PM">12:00 PM</option>
                                    <option value="12:30 PM">12:30 PM</option>
                                    <option value="1:00 PM">1:00 PM</option>
                                    <option value="1:30 PM">1:30 PM</option>
                                    <option value="2:00 PM">2:00 PM</option>
                                    <option value="2:30 PM">2:30 PM</option>
                                    <option value="3:00 PM">3:00 PM</option>
                                    <option value="3:30 PM">3:30 PM</option>
                                    <option value="4:00 PM">4:00 PM</option>
                                    <option value="4:30 PM">4:30 PM</option>
                                    <option value="5:00 PM">5:00 PM</option>
                                    <option value="5:30 PM">5:30 PM</option>
                                    <option value="6:00 PM">6:00 PM</option>
                                    <option value="6:30 PM">6:30 PM</option>
                                    <option value="7:00 PM">7:00 PM</option>
                                    <option value="7:30 PM">7:30 PM</option>
                                    <option value="8:00 PM">8:00 PM</option>
                                    <option value="8:30 PM">8:30 PM</option>
                                    <option value="9:00 PM">9:00 PM</option>
                                    <option value="9:30 PM">9:30 PM</option>
                                    <option value="10:00 PM">10:00 PM</option>
                                    <option value="10:30 PM">10:30 PM</option>
                                    <option value="11:00 PM">11:00 PM</option>
                                    <option value="11:30 PM">11:30 PM</option>
                                    <option value="12:00 AM">12:00 AM</option>
                                </select>
                                <input type="checkbox" name="ckmndy" value="Close">
                                <p>Close</p>
                            </li>
                            <li>
                                <p>Tuesday :</p> 
                                <select name="tusdy" id="">
                                    <option value="<?php echo $rlinks2; ?>" hidden=""><?php echo $rlinks2; ?></option>
                                    <option value="Open 24 Hour">Open 24 Hour</option>
                                    <option value="06:00 AM">06:00 AM</option>
                                    <option value="06:30 AM">06:30 AM</option>
                                    <option value="07:00 AM">07:00 AM</option>
                                    <option value="07:30 AM">07:30 AM</option>
                                    <option value="08:00 AM">08:00 AM</option>
                                    <option value="08:30 AM">08:30 AM</option>
                                    <option value="09:00 AM">09:00 AM</option>
                                    <option value="09:30 AM">09:30 AM</option>
                                    <option value="10:00 AM">10:00 AM</option>
                                    <option value="10:30 AM">10:30 AM</option>
                                    <option value="11:00 AM">11:00 AM</option>
                                    <option value="11:30 AM">11:30 AM</option>
                                    <option value="12:00 PM">12:00 PM</option>
                                    <option value="12:30 PM">12:30 PM</option>
                                    <option value="1:00 PM">1:00 PM</option>
                                    <option value="1:30 PM">1:30 PM</option>
                                    <option value="2:00 PM">2:00 PM</option>
                                    <option value="2:30 PM">2:30 PM</option>
                                    <option value="3:00 PM">3:00 PM</option>
                                    <option value="3:30 PM">3:30 PM</option>
                                    <option value="4:00 PM">4:00 PM</option>
                                    <option value="4:30 PM">4:30 PM</option>
                                    <option value="5:00 PM">5:00 PM</option>
                                    <option value="5:30 PM">5:30 PM</option>
                                    <option value="6:00 PM">6:00 PM</option>
                                    <option value="6:30 PM">6:30 PM</option>
                                    <option value="7:00 PM">7:00 PM</option>
                                    <option value="7:30 PM">7:30 PM</option>
                                    <option value="8:00 PM">8:00 PM</option>
                                    <option value="8:30 PM">8:30 PM</option>
                                    <option value="9:00 PM">9:00 PM</option>
                                    <option value="9:30 PM">9:30 PM</option>
                                    <option value="10:00 PM">10:00 PM</option>
                                    <option value="10:30 PM">10:30 PM</option>
                                    <option value="11:00 PM">11:00 PM</option>
                                    <option value="11:30 PM">11:30 PM</option>
                                    <option value="12:00 AM">12:00 AM</option>
                                </select>
                                <p>To</p>
                                <select name="tusdy1" id="">
                                    <option value="<?php echo $rlinks3; ?>" hidden=""><?php echo $rlinks3; ?></option>
                                    <option value="Open 24 Hour">Open 24 Hour</option>
                                    <option value="06:00 AM">06:00 AM</option>
                                    <option value="06:30 AM">06:30 AM</option>
                                    <option value="07:00 AM">07:00 AM</option>
                                    <option value="07:30 AM">07:30 AM</option>
                                    <option value="08:00 AM">08:00 AM</option>
                                    <option value="08:30 AM">08:30 AM</option>
                                    <option value="09:00 AM">09:00 AM</option>
                                    <option value="09:30 AM">09:30 AM</option>
                                    <option value="10:00 AM">10:00 AM</option>
                                    <option value="10:30 AM">10:30 AM</option>
                                    <option value="11:00 AM">11:00 AM</option>
                                    <option value="11:30 AM">11:30 AM</option>
                                    <option value="12:00 PM">12:00 PM</option>
                                    <option value="12:30 PM">12:30 PM</option>
                                    <option value="1:00 PM">1:00 PM</option>
                                    <option value="1:30 PM">1:30 PM</option>
                                    <option value="2:00 PM">2:00 PM</option>
                                    <option value="2:30 PM">2:30 PM</option>
                                    <option value="3:00 PM">3:00 PM</option>
                                    <option value="3:30 PM">3:30 PM</option>
                                    <option value="4:00 PM">4:00 PM</option>
                                    <option value="4:30 PM">4:30 PM</option>
                                    <option value="5:00 PM">5:00 PM</option>
                                    <option value="5:30 PM">5:30 PM</option>
                                    <option value="6:00 PM">6:00 PM</option>
                                    <option value="6:30 PM">6:30 PM</option>
                                    <option value="7:00 PM">7:00 PM</option>
                                    <option value="7:30 PM">7:30 PM</option>
                                    <option value="8:00 PM">8:00 PM</option>
                                    <option value="8:30 PM">8:30 PM</option>
                                    <option value="9:00 PM">9:00 PM</option>
                                    <option value="9:30 PM">9:30 PM</option>
                                    <option value="10:00 PM">10:00 PM</option>
                                    <option value="10:30 PM">10:30 PM</option>
                                    <option value="11:00 PM">11:00 PM</option>
                                    <option value="11:30 PM">11:30 PM</option>
                                    <option value="12:00 AM">12:00 AM</option>
                                </select>
                                <input type="checkbox" name="cktusdy" value="Close">
                                <p>Close</p>
                            </li>
                            <li>
                                <p>Wednesday :</p> 
                                <select name="weddy" id="">
                                    <option value="<?php echo $rlinks4; ?>" hidden=""><?php echo $rlinks4; ?></option>
                                    <option value="Open 24 Hour">Open 24 Hour</option>
                                    <option value="06:00 AM">06:00 AM</option>
                                    <option value="06:30 AM">06:30 AM</option>
                                    <option value="07:00 AM">07:00 AM</option>
                                    <option value="07:30 AM">07:30 AM</option>
                                    <option value="08:00 AM">08:00 AM</option>
                                    <option value="08:30 AM">08:30 AM</option>
                                    <option value="09:00 AM">09:00 AM</option>
                                    <option value="09:30 AM">09:30 AM</option>
                                    <option value="10:00 AM">10:00 AM</option>
                                    <option value="10:30 AM">10:30 AM</option>
                                    <option value="11:00 AM">11:00 AM</option>
                                    <option value="11:30 AM">11:30 AM</option>
                                    <option value="12:00 PM">12:00 PM</option>
                                    <option value="12:30 PM">12:30 PM</option>
                                    <option value="1:00 PM">1:00 PM</option>
                                    <option value="1:30 PM">1:30 PM</option>
                                    <option value="2:00 PM">2:00 PM</option>
                                    <option value="2:30 PM">2:30 PM</option>
                                    <option value="3:00 PM">3:00 PM</option>
                                    <option value="3:30 PM">3:30 PM</option>
                                    <option value="4:00 PM">4:00 PM</option>
                                    <option value="4:30 PM">4:30 PM</option>
                                    <option value="5:00 PM">5:00 PM</option>
                                    <option value="5:30 PM">5:30 PM</option>
                                    <option value="6:00 PM">6:00 PM</option>
                                    <option value="6:30 PM">6:30 PM</option>
                                    <option value="7:00 PM">7:00 PM</option>
                                    <option value="7:30 PM">7:30 PM</option>
                                    <option value="8:00 PM">8:00 PM</option>
                                    <option value="8:30 PM">8:30 PM</option>
                                    <option value="9:00 PM">9:00 PM</option>
                                    <option value="9:30 PM">9:30 PM</option>
                                    <option value="10:00 PM">10:00 PM</option>
                                    <option value="10:30 PM">10:30 PM</option>
                                    <option value="11:00 PM">11:00 PM</option>
                                    <option value="11:30 PM">11:30 PM</option>
                                    <option value="12:00 AM">12:00 AM</option>
                                </select>
                                <p>To</p>
                                <select name="weddy1" id="">
                                    <option value="<?php echo $rlinks5; ?>" hidden=""><?php echo $rlinks5; ?></option>
                                    <option value="Open 24 Hour">Open 24 Hour</option>
                                    <option value="06:00 AM">06:00 AM</option>
                                    <option value="06:30 AM">06:30 AM</option>
                                    <option value="07:00 AM">07:00 AM</option>
                                    <option value="07:30 AM">07:30 AM</option>
                                    <option value="08:00 AM">08:00 AM</option>
                                    <option value="08:30 AM">08:30 AM</option>
                                    <option value="09:00 AM">09:00 AM</option>
                                    <option value="09:30 AM">09:30 AM</option>
                                    <option value="10:00 AM">10:00 AM</option>
                                    <option value="10:30 AM">10:30 AM</option>
                                    <option value="11:00 AM">11:00 AM</option>
                                    <option value="11:30 AM">11:30 AM</option>
                                    <option value="12:00 PM">12:00 PM</option>
                                    <option value="12:30 PM">12:30 PM</option>
                                    <option value="1:00 PM">1:00 PM</option>
                                    <option value="1:30 PM">1:30 PM</option>
                                    <option value="2:00 PM">2:00 PM</option>
                                    <option value="2:30 PM">2:30 PM</option>
                                    <option value="3:00 PM">3:00 PM</option>
                                    <option value="3:30 PM">3:30 PM</option>
                                    <option value="4:00 PM">4:00 PM</option>
                                    <option value="4:30 PM">4:30 PM</option>
                                    <option value="5:00 PM">5:00 PM</option>
                                    <option value="5:30 PM">5:30 PM</option>
                                    <option value="6:00 PM">6:00 PM</option>
                                    <option value="6:30 PM">6:30 PM</option>
                                    <option value="7:00 PM">7:00 PM</option>
                                    <option value="7:30 PM">7:30 PM</option>
                                    <option value="8:00 PM">8:00 PM</option>
                                    <option value="8:30 PM">8:30 PM</option>
                                    <option value="9:00 PM">9:00 PM</option>
                                    <option value="9:30 PM">9:30 PM</option>
                                    <option value="10:00 PM">10:00 PM</option>
                                    <option value="10:30 PM">10:30 PM</option>
                                    <option value="11:00 PM">11:00 PM</option>
                                    <option value="11:30 PM">11:30 PM</option>
                                    <option value="12:00 AM">12:00 AM</option>
                                </select>
                                <input type="checkbox" name="ckweddy" value="Close">
                                <p>Close</p>
                            </li>
                            <li>
                                <p>Thursday :</p> 
                                <select name="thurdy" id="">
                                    <option value="<?php echo $rlinks6; ?>" hidden=""><?php echo $rlinks6; ?></option>
                                    <option value="Open 24 Hour">Open 24 Hour</option>
                                    <option value="06:00 AM">06:00 AM</option>
                                    <option value="06:30 AM">06:30 AM</option>
                                    <option value="07:00 AM">07:00 AM</option>
                                    <option value="07:30 AM">07:30 AM</option>
                                    <option value="08:00 AM">08:00 AM</option>
                                    <option value="08:30 AM">08:30 AM</option>
                                    <option value="09:00 AM">09:00 AM</option>
                                    <option value="09:30 AM">09:30 AM</option>
                                    <option value="10:00 AM">10:00 AM</option>
                                    <option value="10:30 AM">10:30 AM</option>
                                    <option value="11:00 AM">11:00 AM</option>
                                    <option value="11:30 AM">11:30 AM</option>
                                    <option value="12:00 PM">12:00 PM</option>
                                    <option value="12:30 PM">12:30 PM</option>
                                    <option value="1:00 PM">1:00 PM</option>
                                    <option value="1:30 PM">1:30 PM</option>
                                    <option value="2:00 PM">2:00 PM</option>
                                    <option value="2:30 PM">2:30 PM</option>
                                    <option value="3:00 PM">3:00 PM</option>
                                    <option value="3:30 PM">3:30 PM</option>
                                    <option value="4:00 PM">4:00 PM</option>
                                    <option value="4:30 PM">4:30 PM</option>
                                    <option value="5:00 PM">5:00 PM</option>
                                    <option value="5:30 PM">5:30 PM</option>
                                    <option value="6:00 PM">6:00 PM</option>
                                    <option value="6:30 PM">6:30 PM</option>
                                    <option value="7:00 PM">7:00 PM</option>
                                    <option value="7:30 PM">7:30 PM</option>
                                    <option value="8:00 PM">8:00 PM</option>
                                    <option value="8:30 PM">8:30 PM</option>
                                    <option value="9:00 PM">9:00 PM</option>
                                    <option value="9:30 PM">9:30 PM</option>
                                    <option value="10:00 PM">10:00 PM</option>
                                    <option value="10:30 PM">10:30 PM</option>
                                    <option value="11:00 PM">11:00 PM</option>
                                    <option value="11:30 PM">11:30 PM</option>
                                    <option value="12:00 AM">12:00 AM</option>
                                </select>
                                <p>To</p>
                                <select name="thurdy1" id="">
                                    <option value="<?php echo $rlinks7; ?>" hidden=""><?php echo $rlinks7; ?></option>
                                    <option value="Open 24 Hour">Open 24 Hour</option>
                                    <option value="06:00 AM">06:00 AM</option>
                                    <option value="06:30 AM">06:30 AM</option>
                                    <option value="07:00 AM">07:00 AM</option>
                                    <option value="07:30 AM">07:30 AM</option>
                                    <option value="08:00 AM">08:00 AM</option>
                                    <option value="08:30 AM">08:30 AM</option>
                                    <option value="09:00 AM">09:00 AM</option>
                                    <option value="09:30 AM">09:30 AM</option>
                                    <option value="10:00 AM">10:00 AM</option>
                                    <option value="10:30 AM">10:30 AM</option>
                                    <option value="11:00 AM">11:00 AM</option>
                                    <option value="11:30 AM">11:30 AM</option>
                                    <option value="12:00 PM">12:00 PM</option>
                                    <option value="12:30 PM">12:30 PM</option>
                                    <option value="1:00 PM">1:00 PM</option>
                                    <option value="1:30 PM">1:30 PM</option>
                                    <option value="2:00 PM">2:00 PM</option>
                                    <option value="2:30 PM">2:30 PM</option>
                                    <option value="3:00 PM">3:00 PM</option>
                                    <option value="3:30 PM">3:30 PM</option>
                                    <option value="4:00 PM">4:00 PM</option>
                                    <option value="4:30 PM">4:30 PM</option>
                                    <option value="5:00 PM">5:00 PM</option>
                                    <option value="5:30 PM">5:30 PM</option>
                                    <option value="6:00 PM">6:00 PM</option>
                                    <option value="6:30 PM">6:30 PM</option>
                                    <option value="7:00 PM">7:00 PM</option>
                                    <option value="7:30 PM">7:30 PM</option>
                                    <option value="8:00 PM">8:00 PM</option>
                                    <option value="8:30 PM">8:30 PM</option>
                                    <option value="9:00 PM">9:00 PM</option>
                                    <option value="9:30 PM">9:30 PM</option>
                                    <option value="10:00 PM">10:00 PM</option>
                                    <option value="10:30 PM">10:30 PM</option>
                                    <option value="11:00 PM">11:00 PM</option>
                                    <option value="11:30 PM">11:30 PM</option>
                                    <option value="12:00 AM">12:00 AM</option>
                                </select>
                                <input type="checkbox" name="ckthurdy" value="Close">
                                <p>Close</p>
                            </li>
                            <li>
                                <p>Friday :</p> 
                                <select name="frday" id="">
                                    <option value="<?php echo $rlinks8; ?>" hidden=""><?php echo $rlinks8; ?></option>
                                    <option value="Open 24 Hour">Open 24 Hour</option>
                                    <option value="06:00 AM">06:00 AM</option>
                                    <option value="06:30 AM">06:30 AM</option>
                                    <option value="07:00 AM">07:00 AM</option>
                                    <option value="07:30 AM">07:30 AM</option>
                                    <option value="08:00 AM">08:00 AM</option>
                                    <option value="08:30 AM">08:30 AM</option>
                                    <option value="09:00 AM">09:00 AM</option>
                                    <option value="09:30 AM">09:30 AM</option>
                                    <option value="10:00 AM">10:00 AM</option>
                                    <option value="10:30 AM">10:30 AM</option>
                                    <option value="11:00 AM">11:00 AM</option>
                                    <option value="11:30 AM">11:30 AM</option>
                                    <option value="12:00 PM">12:00 PM</option>
                                    <option value="12:30 PM">12:30 PM</option>
                                    <option value="1:00 PM">1:00 PM</option>
                                    <option value="1:30 PM">1:30 PM</option>
                                    <option value="2:00 PM">2:00 PM</option>
                                    <option value="2:30 PM">2:30 PM</option>
                                    <option value="3:00 PM">3:00 PM</option>
                                    <option value="3:30 PM">3:30 PM</option>
                                    <option value="4:00 PM">4:00 PM</option>
                                    <option value="4:30 PM">4:30 PM</option>
                                    <option value="5:00 PM">5:00 PM</option>
                                    <option value="5:30 PM">5:30 PM</option>
                                    <option value="6:00 PM">6:00 PM</option>
                                    <option value="6:30 PM">6:30 PM</option>
                                    <option value="7:00 PM">7:00 PM</option>
                                    <option value="7:30 PM">7:30 PM</option>
                                    <option value="8:00 PM">8:00 PM</option>
                                    <option value="8:30 PM">8:30 PM</option>
                                    <option value="9:00 PM">9:00 PM</option>
                                    <option value="9:30 PM">9:30 PM</option>
                                    <option value="10:00 PM">10:00 PM</option>
                                    <option value="10:30 PM">10:30 PM</option>
                                    <option value="11:00 PM">11:00 PM</option>
                                    <option value="11:30 PM">11:30 PM</option>
                                    <option value="12:00 AM">12:00 AM</option>
                                </select>
                                <p>To</p>
                                <select name="frday1" id="">
                                    <option value="<?php echo $rlinks9; ?>" hidden=""><?php echo $rlinks9; ?></option>
                                    <option value="Open 24 Hour">Open 24 Hour</option>
                                    <option value="06:00 AM">06:00 AM</option>
                                    <option value="06:30 AM">06:30 AM</option>
                                    <option value="07:00 AM">07:00 AM</option>
                                    <option value="07:30 AM">07:30 AM</option>
                                    <option value="08:00 AM">08:00 AM</option>
                                    <option value="08:30 AM">08:30 AM</option>
                                    <option value="09:00 AM">09:00 AM</option>
                                    <option value="09:30 AM">09:30 AM</option>
                                    <option value="10:00 AM">10:00 AM</option>
                                    <option value="10:30 AM">10:30 AM</option>
                                    <option value="11:00 AM">11:00 AM</option>
                                    <option value="11:30 AM">11:30 AM</option>
                                    <option value="12:00 PM">12:00 PM</option>
                                    <option value="12:30 PM">12:30 PM</option>
                                    <option value="1:00 PM">1:00 PM</option>
                                    <option value="1:30 PM">1:30 PM</option>
                                    <option value="2:00 PM">2:00 PM</option>
                                    <option value="2:30 PM">2:30 PM</option>
                                    <option value="3:00 PM">3:00 PM</option>
                                    <option value="3:30 PM">3:30 PM</option>
                                    <option value="4:00 PM">4:00 PM</option>
                                    <option value="4:30 PM">4:30 PM</option>
                                    <option value="5:00 PM">5:00 PM</option>
                                    <option value="5:30 PM">5:30 PM</option>
                                    <option value="6:00 PM">6:00 PM</option>
                                    <option value="6:30 PM">6:30 PM</option>
                                    <option value="7:00 PM">7:00 PM</option>
                                    <option value="7:30 PM">7:30 PM</option>
                                    <option value="8:00 PM">8:00 PM</option>
                                    <option value="8:30 PM">8:30 PM</option>
                                    <option value="9:00 PM">9:00 PM</option>
                                    <option value="9:30 PM">9:30 PM</option>
                                    <option value="10:00 PM">10:00 PM</option>
                                    <option value="10:30 PM">10:30 PM</option>
                                    <option value="11:00 PM">11:00 PM</option>
                                    <option value="11:30 PM">11:30 PM</option>
                                    <option value="12:00 AM">12:00 AM</option>
                                </select>
                                <input type="checkbox" name="ckfrday" value="Close">
                                <p>Close</p>
                            </li>
                            <li>
                                <p>Saturday :</p> 
                                <select name="satdy" id="">
                                    <option value="<?php echo $rlinks10; ?>" hidden=""><?php echo $rlinks10; ?></option>
                                    <option value="Open 24 Hour">Open 24 Hour</option>
                                    <option value="06:00 AM">06:00 AM</option>
                                    <option value="06:30 AM">06:30 AM</option>
                                    <option value="07:00 AM">07:00 AM</option>
                                    <option value="07:30 AM">07:30 AM</option>
                                    <option value="08:00 AM">08:00 AM</option>
                                    <option value="08:30 AM">08:30 AM</option>
                                    <option value="09:00 AM">09:00 AM</option>
                                    <option value="09:30 AM">09:30 AM</option>
                                    <option value="10:00 AM">10:00 AM</option>
                                    <option value="10:30 AM">10:30 AM</option>
                                    <option value="11:00 AM">11:00 AM</option>
                                    <option value="11:30 AM">11:30 AM</option>
                                    <option value="12:00 PM">12:00 PM</option>
                                    <option value="12:30 PM">12:30 PM</option>
                                    <option value="1:00 PM">1:00 PM</option>
                                    <option value="1:30 PM">1:30 PM</option>
                                    <option value="2:00 PM">2:00 PM</option>
                                    <option value="2:30 PM">2:30 PM</option>
                                    <option value="3:00 PM">3:00 PM</option>
                                    <option value="3:30 PM">3:30 PM</option>
                                    <option value="4:00 PM">4:00 PM</option>
                                    <option value="4:30 PM">4:30 PM</option>
                                    <option value="5:00 PM">5:00 PM</option>
                                    <option value="5:30 PM">5:30 PM</option>
                                    <option value="6:00 PM">6:00 PM</option>
                                    <option value="6:30 PM">6:30 PM</option>
                                    <option value="7:00 PM">7:00 PM</option>
                                    <option value="7:30 PM">7:30 PM</option>
                                    <option value="8:00 PM">8:00 PM</option>
                                    <option value="8:30 PM">8:30 PM</option>
                                    <option value="9:00 PM">9:00 PM</option>
                                    <option value="9:30 PM">9:30 PM</option>
                                    <option value="10:00 PM">10:00 PM</option>
                                    <option value="10:30 PM">10:30 PM</option>
                                    <option value="11:00 PM">11:00 PM</option>
                                    <option value="11:30 PM">11:30 PM</option>
                                    <option value="12:00 AM">12:00 AM</option>
                                </select>
                                <p>To</p>
                                <select name="satdy1" id="">
                                    <option value="<?php echo $rlinks11; ?>" hidden=""><?php echo $rlinks11; ?></option>
                                    <option value="Open 24 Hour">Open 24 Hour</option>
                                    <option value="06:00 AM">06:00 AM</option>
                                    <option value="06:30 AM">06:30 AM</option>
                                    <option value="07:00 AM">07:00 AM</option>
                                    <option value="07:30 AM">07:30 AM</option>
                                    <option value="08:00 AM">08:00 AM</option>
                                    <option value="08:30 AM">08:30 AM</option>
                                    <option value="09:00 AM">09:00 AM</option>
                                    <option value="09:30 AM">09:30 AM</option>
                                    <option value="10:00 AM">10:00 AM</option>
                                    <option value="10:30 AM">10:30 AM</option>
                                    <option value="11:00 AM">11:00 AM</option>
                                    <option value="11:30 AM">11:30 AM</option>
                                    <option value="12:00 PM">12:00 PM</option>
                                    <option value="12:30 PM">12:30 PM</option>
                                    <option value="1:00 PM">1:00 PM</option>
                                    <option value="1:30 PM">1:30 PM</option>
                                    <option value="2:00 PM">2:00 PM</option>
                                    <option value="2:30 PM">2:30 PM</option>
                                    <option value="3:00 PM">3:00 PM</option>
                                    <option value="3:30 PM">3:30 PM</option>
                                    <option value="4:00 PM">4:00 PM</option>
                                    <option value="4:30 PM">4:30 PM</option>
                                    <option value="5:00 PM">5:00 PM</option>
                                    <option value="5:30 PM">5:30 PM</option>
                                    <option value="6:00 PM">6:00 PM</option>
                                    <option value="6:30 PM">6:30 PM</option>
                                    <option value="7:00 PM">7:00 PM</option>
                                    <option value="7:30 PM">7:30 PM</option>
                                    <option value="8:00 PM">8:00 PM</option>
                                    <option value="8:30 PM">8:30 PM</option>
                                    <option value="9:00 PM">9:00 PM</option>
                                    <option value="9:30 PM">9:30 PM</option>
                                    <option value="10:00 PM">10:00 PM</option>
                                    <option value="10:30 PM">10:30 PM</option>
                                    <option value="11:00 PM">11:00 PM</option>
                                    <option value="11:30 PM">11:30 PM</option>
                                    <option value="12:00 AM">12:00 AM</option>
                                </select>
                                <input type="checkbox" name="cksatdy" value="Close">
                                <p>Close</p>
                            </li>
                            <li>
                                <p>Sunday :</p> 
                                <select name="sndy" id="">
                                    <option value="<?php echo $rlinks12; ?>" hidden=""><?php echo $rlinks12; ?></option>
                                    <option value="Open 24 Hour">Open 24 Hour</option>
                                    <option value="06:00 AM">06:00 AM</option>
                                    <option value="06:30 AM">06:30 AM</option>
                                    <option value="07:00 AM">07:00 AM</option>
                                    <option value="07:30 AM">07:30 AM</option>
                                    <option value="08:00 AM">08:00 AM</option>
                                    <option value="08:30 AM">08:30 AM</option>
                                    <option value="09:00 AM">09:00 AM</option>
                                    <option value="09:30 AM">09:30 AM</option>
                                    <option value="10:00 AM">10:00 AM</option>
                                    <option value="10:30 AM">10:30 AM</option>
                                    <option value="11:00 AM">11:00 AM</option>
                                    <option value="11:30 AM">11:30 AM</option>
                                    <option value="12:00 PM">12:00 PM</option>
                                    <option value="12:30 PM">12:30 PM</option>
                                    <option value="1:00 PM">1:00 PM</option>
                                    <option value="1:30 PM">1:30 PM</option>
                                    <option value="2:00 PM">2:00 PM</option>
                                    <option value="2:30 PM">2:30 PM</option>
                                    <option value="3:00 PM">3:00 PM</option>
                                    <option value="3:30 PM">3:30 PM</option>
                                    <option value="4:00 PM">4:00 PM</option>
                                    <option value="4:30 PM">4:30 PM</option>
                                    <option value="5:00 PM">5:00 PM</option>
                                    <option value="5:30 PM">5:30 PM</option>
                                    <option value="6:00 PM">6:00 PM</option>
                                    <option value="6:30 PM">6:30 PM</option>
                                    <option value="7:00 PM">7:00 PM</option>
                                    <option value="7:30 PM">7:30 PM</option>
                                    <option value="8:00 PM">8:00 PM</option>
                                    <option value="8:30 PM">8:30 PM</option>
                                    <option value="9:00 PM">9:00 PM</option>
                                    <option value="9:30 PM">9:30 PM</option>
                                    <option value="10:00 PM">10:00 PM</option>
                                    <option value="10:30 PM">10:30 PM</option>
                                    <option value="11:00 PM">11:00 PM</option>
                                    <option value="11:30 PM">11:30 PM</option>
                                    <option value="12:00 AM">12:00 AM</option>
                                </select>
                                <p>To</p>
                                <select name="sndy1" id="">
                                    <option value="<?php echo $rlinks13; ?>" hidden=""><?php echo $rlinks13; ?></option>
                                    <option value="Open 24 Hour">Open 24 Hour</option>
                                    <option value="06:00 AM">06:00 AM</option>
                                    <option value="06:30 AM">06:30 AM</option>
                                    <option value="07:00 AM">07:00 AM</option>
                                    <option value="07:30 AM">07:30 AM</option>
                                    <option value="08:00 AM">08:00 AM</option>
                                    <option value="08:30 AM">08:30 AM</option>
                                    <option value="09:00 AM">09:00 AM</option>
                                    <option value="09:30 AM">09:30 AM</option>
                                    <option value="10:00 AM">10:00 AM</option>
                                    <option value="10:30 AM">10:30 AM</option>
                                    <option value="11:00 AM">11:00 AM</option>
                                    <option value="11:30 AM">11:30 AM</option>
                                    <option value="12:00 PM">12:00 PM</option>
                                    <option value="12:30 PM">12:30 PM</option>
                                    <option value="1:00 PM">1:00 PM</option>
                                    <option value="1:30 PM">1:30 PM</option>
                                    <option value="2:00 PM">2:00 PM</option>
                                    <option value="2:30 PM">2:30 PM</option>
                                    <option value="3:00 PM">3:00 PM</option>
                                    <option value="3:30 PM">3:30 PM</option>
                                    <option value="4:00 PM">4:00 PM</option>
                                    <option value="4:30 PM">4:30 PM</option>
                                    <option value="5:00 PM">5:00 PM</option>
                                    <option value="5:30 PM">5:30 PM</option>
                                    <option value="6:00 PM">6:00 PM</option>
                                    <option value="6:30 PM">6:30 PM</option>
                                    <option value="7:00 PM">7:00 PM</option>
                                    <option value="7:30 PM">7:30 PM</option>
                                    <option value="8:00 PM">8:00 PM</option>
                                    <option value="8:30 PM">8:30 PM</option>
                                    <option value="9:00 PM">9:00 PM</option>
                                    <option value="9:30 PM">9:30 PM</option>
                                    <option value="10:00 PM">10:00 PM</option>
                                    <option value="10:30 PM">10:30 PM</option>
                                    <option value="11:00 PM">11:00 PM</option>
                                    <option value="11:30 PM">11:30 PM</option>
                                    <option value="12:00 AM">12:00 AM</option>
                                </select>
                                <input type="checkbox" name="cksndy" value="Close">
                                <p>Close</p>
                            </li>
                        </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="col-md-12 payment_mode">
                                <h4>Already Added Payment Modes</h4>
                                <ul>  
                                <?php
                                    $show_pay_modes = $db->prepare("SELECT * FROM payment_option WHERE pay_lstid=:lstid");
                                    $show_pay_modes->bindParam(':lstid',$lstid);
                                    $show_pay_modes->execute();
                                    $rowpays = $show_pay_modes->fetchAll();
                                    foreach($rowpays as $rowpay){
                                        $payid = $rowpay['payment_id'];
                                ?>		
                                    <li><?php echo $rowpay['mayment_modes']; ?>&nbsp;&nbsp;<a href="<?php echo $url; ?>listing-edit.php?lst=<?php echo $lstid; ?>&other&del=<?php echo $payid; ?>"><img src="<?php echo $url ?>images/f-box-close-icon1.png" height="15px;" onClick="return ckdel();"></a></li>
                                <?php } ?>
                                </ul> 
                                <h4>Payment Modes Accepted By You</h4>
                                <ul>
                                    <li><input type="checkbox" id="checkedAll">Select All</li>
                                    <li><input type="checkbox" name="va[]" value="cash" class="checkSingle">Cash</li>
                                    <li><input type="checkbox" name="va[]" value="Master Card" class="checkSingle">Master Card</li>
                                    <li><input type="checkbox" name="va[]" value="Visa Card" class="checkSingle">Visa Card</li>
                                    <li><input type="checkbox" name="va[]" value="Debit Cards" class="checkSingle">Debit Cards</li>
                                    <li><input type="checkbox" name="va[]" value="Money Orders" class="checkSingle">Money Orders</li>
                                    <li><input type="checkbox" name="va[]" value="Cheques" class="checkSingle">Cheques</li>
                                    <li><input type="checkbox" name="va[]" value="Credit Card" class="checkSingle">Credit Card</li>
                                    <li><input type="checkbox" name="va[]" value="Travelers Cheque" class="checkSingle">Travelers Cheque</li>
                                    <li><input type="checkbox" name="va[]" value="Financing Available" class="checkSingle">Financing Available</li>
                                    <li><input type="checkbox" name="va[]" value="American Express Card" class="checkSingle">American Express Card</li>
                                    <li><input type="checkbox" name="va[]" value="Diners Club Card" class="checkSingle">Diners Club Card</li>
                                </ul>
                            </div>
                            
                            <div class="col-md-12">
                                <h4>Company Information</h4>
                            </div>
                            <div class="col-md-12">
                                <p>Year Of Establishment:</p>
                            </div>
                            <div class="col-md-12 p0">
                                <div class="col-md-3">
                                    <input type="text" name="yrs" value="<?php echo $rows['year']; ?>" required/>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="turnovr" value="<?php echo $rows['anual_turnover']; ?>" required/>
                                </div>
                                <div class="col-md-6">
                                   <select name="emply" required/><span>*</span>
                                      <option value="<?php echo $rows['no_employees']; ?>" hidden="hidden"><?php echo $rows['no_employees']; ?></option>
                                      <option value="Less than 10">Less than 10</option>
                                      <option value="10-100">10-100</option>
                                      <option value="100-500">100-500</option>
                                      <option value="500-1000">500-1000</option>
                                      <option value="1000-2000">1000-2000</option>
                                      <option value="2000-5000">2000-5000</option>
                                      <option value="5000-10000">5000-10000</option>
                                      <option value="More than 10000">More than 10000</option>
                                   </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <p>Professional Associations:</p>
                                <input type="text" name="profasso" value="<?php echo $rows['professional_associations']; ?>">
                            </div>
                            <div class="col-md-6">
                                <p>Certifications</p>
                                <input type="text" name="certif" value="<?php echo $rows['certification']; ?>">
                            </div>
                            <div class="col-md-12">
                                <input type="submit" name="addother" value="Submit">
                            </div>
                        </form>
                    </div>
                </div>
                
             <?php } elseif(isset($_GET['key'])){ 
                      if(isset($_POST['addkey'])){
                        foreach($_POST['keyskil'] as $keys){
                            $check_key = $db->prepare("SELECT COUNT(keywrd_id) FROM choose_keywords WHERE keywrd_id=:keys AND key_lstid=:lstid");
                            $check_key->bindParam(':keys',$keys);	
                            $check_key->bindParam(':lstid',$lstid);	
                            $check_key->execute();
                            $ckk = $check_key->fetchColumn();
                            if($ckk > 0){ echo "Already Exists"; }
                            else{	
                            $add_keyword = $db->prepare("INSERT INTO choose_keywords(key_lstid,keywrd_id,key_date)VALUES(:lstid, :keys, :date)");
                            $add_keyword->bindParam(':lstid',$lstid);
                            $add_keyword->bindParam(':keys',$keys);
                            $add_keyword->bindParam(':date',$date);
                            $add_keyword->execute();
                            if(isset($add_keyword)){ echo "<script>location.assign('my-listing.php?lst=$lstid')</script>"; }
                            else{ $kerror = "Server Busy"; }
                            }
                            
                                
                        }
                      }
                      if(isset($_GET['del'])){
                        $delkid = $_GET['del'];
                        $delete_key = $db->prepare("DELETE FROM choose_keywords WHERE ch_keyid=:delkid");  
                        $delete_key->bindParam(':delkid',$delkid);
                        $delete_key->execute();
                        if(isset($delete_key)){ echo "<script>location.assign('listing-edit.php?lst=$lstid&key')</script>"; } 
                      }
                      
             ?> 
               
                <div class="col-md-12 listing_detail_edit edit_mob">
                    <div class="col-md-12">
                        <h4>Business Keywords</h4>
                    </div>
                    <div class="col-md-12 p0 form_edit">
                        <ul>
                            <?php
                                $show_keyword = $db->prepare("SELECT ky.keyword_name,cky.ch_keyid FROM choose_keywords cky JOIN add_keywords ky ON ky.keyword_id=cky.keywrd_id WHERE cky.key_lstid=:lstid");
                                $show_keyword->bindParam(':lstid',$lstid);
                                $show_keyword->execute();
                                $allkeys = $show_keyword->fetchAll();
                                foreach($allkeys as $allk){
                                        $keyid = $allk['ch_keyid'];
                            ?>		
                            <li><?php echo $allk['keyword_name']; ?>&nbsp;&nbsp;<a href="listing-edit.php?lst=<?php echo $lstid; ?>&key&del=<?php echo $keyid; ?>"><img src="<?php echo $url ?>images/f-box-close-icon1.png" height="20px;" onClick="return ckdel();"></a></li>
                            <?php } ?>
                         </ul>
                        <form method="post">
                            <div class="col-md-12 keysearch key_edit">
                                <p>Type your Business Keywords and click Search</p>
                                <select data-placeholder="Select Skills" name="keyskil[]" class="chosen-select" multiple tabindex="4" required/>
                                <?php
                                    $showkeywords = $db->prepare("SELECT * FROM add_keywords ORDER BY keyword_id ASC");
                                    $showkeywords->execute();
                                    $allkeys = $showkeywords->fetchAll();
                                    foreach($allkeys as $allkey){
                                        $kyid = $allkey['keyword_id'];
                                        $kyname = $allkey['keyword_name'];
                                        echo "<option value='$kyid'>$kyname</option>";
                                    }
                                ?>	
                      </select>
                            </div>
                            
                            <div class="col-md-12">
                                <input type="submit" name="addkey" value="Submit">
                            </div>
                        </form>
                    </div>
                </div>
                
              <?php } elseif(isset($_GET['img'])){ 
                     if(isset($_POST['addmedia'])){
                        $imgname = $_FILES['limg']['name'];
                        $imgtemp = $_FILES['limg']['tmp_name'];
                        $target = "../images/listing_gallery/".$imgname; 
                        $needheight = 400;	
                        $needwidth = 400;
                        list($pngwidth, $pngheight) = getimagesize($imgtemp);
                        $rlinkss = $_POST['yurl'];
                        $stpp = strpos($rlinkss,'watch?v');
                        $an = substr($rlinkss,$stpp);
                        $stp = $stpp+8; 
                        $edp = strpos($an,'=');
                        $rlinks = substr($rlinkss,$an+$stp,$edp+5);
                    if($imgname=='' && $rlinkss==''){ $imgerror = "Please Fill any one filed"; }
                    else{
                        /*$checklink = $db->prepare("SELECT COUNT(list_url) FROM list_images_videos WHERE img_lstid=:recid AND list_url=:rlinks");
                        $checklink->bindParam(':recid',$recid);
                        $checklink->bindParam(':rlinks',$rlinks);
                        $checklink->execute();
                        $countlnk = $checklink->fetchColumn();
                        if($countlnk > 0){ $imgerror = "Link Already Exists"; }
                        else{*/
                            $checkimg = $db->prepare("SELECT COUNT(list_images) FROM list_images_videos WHERE img_lstid=:lstid AND list_images=:imgname");
                            $checkimg->bindParam(':lstid',$lstid);
                            $checkimg->bindParam(':imgname',$imgname);
                            $checkimg->execute();
                            $countimg = $checkimg->fetchColumn();
                            if($countimg > 0){ $imgerror = "Image Already Exists"; }
                        else{
                            $insert_link = $db->prepare("INSERT INTO list_images_videos(img_lstid,list_images,list_url,imag_date)VALUES(:lstid, :imgname, :rlinks, :date)");
                            $insert_link->bindParam(':lstid',$lstid);
                            $insert_link->bindParam(':imgname',$imgname);
                            $insert_link->bindParam(':rlinks',$rlinks);
                            $insert_link->bindParam(':date',$date);
                            $insert_link->execute();
                            if(isset($insert_link)){
                                      $src = imagecreatefromjpeg($imgtemp);
                                      $dst = imagecreatetruecolor($needwidth,$needheight);
                                      imagealphablending($dst, false);
                                      imagesavealpha($dst,true);
                                      $transparent = imagecolorallocatealpha($dst, 255, 255, 255, 127);
                                      imagefilledrectangle($dst, 0, 0, $needwidth, $needheight, $transparent);
                                      imagecopyresampled($dst,$src,0,0,0,0,$needwidth,$needheight,$pngwidth,$pngheight);
                                      imagejpeg($dst,$target);
                                    /*echo "<script>location.assign('".$url."congratulation')</script>"; */
                        //	}
                          }
                        }
                      } 
                    }
                     if(isset($_GET['delimg'])){
                        $imid = $_GET['delimg'];
                        $getimg = $db->prepare("SELECT list_images,list_url FROM list_images_videos WHERE limage_id=:imid"); 
                        $getimg->bindParam(':imid',$imid);
                        $getimg->execute();
                        $found = $getimg->fetch();
                        $findimg = $found['list_images'];
						$fur = $found['list_url'];
						if($fur!=''){
                            $delimage = $db->prepare("UPDATE list_images_videos SET list_images='' WHERE limage_id=:imid");
                            $delimage->bindParam(':imid',$imid);
                            $delimage->execute();
                            unlink('../images/listing_gallery/'.$findimg);
                            echo "<script>location.assign('listing-edit.php?lst=$lstid&img')</script>";
						}
						else{
							$delimage = $db->prepare("DELETE FROM list_images_videos WHERE limage_id=:imid");
                            $delimage->bindParam(':imid',$imid);
                            $delimage->execute();
                            unlink('../images/listing_gallery/'.$findimg);
                            echo "<script>location.assign('listing-edit.php?lst=$lstid&img')</script>";
						}
                     }
                     if(isset($_GET['delurl'])){
                         $urid = $_GET['delurl'];
                         $delurl = $db->prepare("UPDATE list_images_videos SET list_url='' WHERE limage_id=:urid");
                         $delurl->bindParam(':urid',$urid);
                         $delurl->execute(); 
                         echo "<script>location.assign('listing-edit.php?lst=$lstid&img')</script>";
                         
                     }
             ?>  
              
                <div class="col-md-12 listing_detail_edit edit_mob">
                    <div class="col-md-12">
                        <h4>Upload Images/Videos</h4>
                    </div>
                    <div class="col-md-12 p0 form_edit">
                        <form method="post" enctype="multipart/form-data">
                          <div class="col-md-6">
                                <p>Images</p>
                                <input type="file" name="limg">
                                  <ul class="uploadimg">
                                  <?php
                                     $show_gallery = $db->prepare("SELECT list_images,limage_id FROM list_images_videos WHERE img_lstid=:lstid");
                                     $show_gallery->bindParam(':lstid',$lstid);
                                     $show_gallery->execute();
                                     $imgrows = $show_gallery->fetchAll();
                                     foreach($imgrows as $imrow){
                                         $imgid = $imrow['limage_id'];
                                          if($imrow['list_images']!=''){
							     ?>
                                      <li>
                                          <a href="listing-edit.php?lst=<?php echo $lstid; ?>&img&delimg=<?php echo $imgid; ?>" onClick="return ckdel();">&times;</a>
                                          <img src="../images/listing_gallery/<?php echo $imrow['list_images']; ?>" alt=""/>
                                      </li>
                                <?php } } ?>      
                                  </ul>
                            </div>
                            <div class="col-md-6">
                                <p>Videos</p>
                                <input type="text" name="yurl">
                                <ul class="uploadimg">
                                 <?php
                                     $show_video = $db->prepare("SELECT list_url,limage_id FROM list_images_videos WHERE img_lstid=:lstid");
                                     $show_video->bindParam(':lstid',$lstid);
                                     $show_video->execute();
                                     $vedrows = $show_video->fetchAll();
                                     foreach($vedrows as $vdrow){
                                         $urlid = $imrow['limage_id'];
                                         if($vdrow['list_url']!=''){
                                 ?>
                                    <li>
                                        <a href="listing-edit.php?lst=<?php echo $lstid; ?>&img&delurl=<?php echo $urlid; ?>" onClick="return ckdel();">&times;</a>
                                        <iframe src="https://www.youtube.com/embed/<?php echo $vdrow['list_url']; ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    </li>
                                <?php } } ?>    
                                </ul>
                            </div>
                            
                            <div class="col-md-12">
                                <input type="submit" name="addmedia" value="Submit">
                            </div>
                        </form>
                    </div>
                </div>
                
              <?php } ?>  
            </div>
        </div>
    </div>
</div>

<div id="page" class="login_wrapper">
	
    
    		
   
</div>
 <script src="<?php echo $url; ?>js/chosen.jquery.js" type="text/javascript"></script>
<script>
var config = {
  '.chosen-select'           : {},
  '.chosen-select-deselect'  : { allow_single_deselect: true },
  '.chosen-select-no-single' : { disable_search_threshold: 10 },
  '.chosen-select-no-results': { no_results_text: 'Oops, nothing found!' },
  '.chosen-select-rtl'       : { rtl: true },
  '.chosen-select-width'     : { width: '95%' }
}
for (var selector in config) {
  $(selector).chosen(config[selector]);
}
</script>
</body>
</html>
<?php } else{ echo "Detail not found"; } } } else { echo "<script>location.assign('logout.php')</script>"; } 
	} else { echo "<script>location.assign('logout.php')</script>"; } ?>