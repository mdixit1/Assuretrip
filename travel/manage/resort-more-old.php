<?php
//error_reporting(0);
session_start();
include('../connection/index.php');
include('../function.php'); 
if(isset($_SESSION['amail']) && isset($_SESSION['aid']) && isset($_SESSION['apass'])){
	$recaid = $_SESSION['aid'];
	$recmail = $_SESSION['amail'];
	$recpass = $_SESSION['apass'];	
	$userdetail = $db->prepare("SELECT * FROM plusadmin WHERE adminid = :recaid AND ademail = :recmail AND adpassword = :recpass");
	$userdetail->bindParam(':recaid',$recaid);
	$userdetail->bindParam(':recmail',$recmail);
	$userdetail->bindParam(':recpass',$recpass);
	$userdetail->execute();
	$userd = $userdetail->fetchAll();
	if(count($userd)){
		foreach($userd as $usr){
			$recname = $usr['adname'];
			
	if(isset($_GET['resrt'])){
		$resuqid = $_GET['resrt'];
		$get_detail = $db->prepare("SELECT package_id,resort_name FROM packages WHERE package_uniq=:resuqid");
		$get_detail->bindParam(':resuqid',$resuqid);
		$get_detail->execute();
		$stmt = $get_detail->fetchAll();
		if(count($stmt)){
			foreach($stmt as $st){
				$resrt_id = $st['package_id'];
				
				if(isset($_POST['addmore'])){
					$cateid = $_POST['catid'];
					$prz = $_POST['pckprz'];
					$bud_from = $_POST['bdgfrom'];
					$bud_to = $_POST['bdgto'];
					$pduratn = $_POST['pckdurtion'];
					$durtin_frm = $_POST['durctnfrom'];
					$durtin_to = $_POST['durctnto'];
					$sean_from = $_POST['sesonfrom'];
					$sean_to = $_POST['sesonto'];
					$rting = $_POST['hotlratin'];
					$fstatus = $_POST['flstatus'];
					$overvw = $_POST['ovrview'];
					//$feature = $_POST['pfeature'];
					$add_packages = $db->prepare("UPDATE packages SET cattid=:cateid, pack_price=:prz, budget_from=:bud_from, budget_to=:bud_to, package_duration=:pduratn, duration_day=:durtin_frm, duration_night=:durtin_to, season_from=:sean_from, season_to=:sean_to, hotel_rating=:rting, flight_status=:fstatus, package_overview=:overvw WHERE package_id=:resrt_id");
					$add_packages->bindParam(':cateid',$cateid);
					$add_packages->bindParam(':prz',$prz);
					$add_packages->bindParam(':bud_from',$bud_from);
					$add_packages->bindParam(':bud_to',$bud_to);
					$add_packages->bindParam(':pduratn',$pduratn);
					$add_packages->bindParam(':durtin_frm',$durtin_frm);
					$add_packages->bindParam(':durtin_to',$durtin_to);
					$add_packages->bindParam(':sean_from',$sean_from);
					$add_packages->bindParam(':sean_to',$sean_to);
					$add_packages->bindParam(':rting',$rting);
					$add_packages->bindParam(':fstatus',$fstatus);
					$add_packages->bindParam(':overvw',$overvw);
					//$add_packages->bindParam(':feature',$feature);
					$add_packages->bindParam(':resrt_id',$resrt_id);
					$add_packages->execute();
					if(isset($add_packages)){
						foreach($_POST['act'] as $val){
							$add_pckactv = $db->prepare("INSERT INTO pack_activity(pack_id,activt_id,pack_actdate)VALUES(:resrt_id, :val, :date)");	
							$add_pckactv->bindParam(':resrt_id',$resrt_id);
							$add_pckactv->bindParam(':val',$val);
							$add_pckactv->bindParam(':date',$date);
							$add_pckactv->execute();
						}
						if(!empty($_FILES['addfles'])){	
						$errors= array();
						foreach($_FILES['addfles']['tmp_name'] as $key => $tmp_name ){
							$file_name = $key.$_FILES['addfles']['name'][$key];
							$file_size =$_FILES['addfles']['size'][$key];
							$file_tmp =$_FILES['addfles']['tmp_name'][$key];
							$file_type=$_FILES['addfles']['type'][$key];	
							$addimages = $db->prepare("INSERT INTO package_images(img_pckid,p_image,pimage_date) VALUES(:resrt_id,:file_name,:date)");
							$addimages->bindParam(':resrt_id',$resrt_id);
							$addimages->bindParam(':file_name',$file_name);
							$addimages->bindParam(':date',$date);
							$addimages->execute();
							if(isset($addimages)){
							  $desired_dir="../images/package_image";
								if(is_dir($desired_dir)==false){
									mkdir("$desired_dir", 0700);		// Create directory if it does not exist
								}
								if(is_dir("$desired_dir/".$file_name)==false){
									move_uploaded_file($file_tmp,"$desired_dir/".$file_name);
								}else{									// rename the file if another one exist
									$new_dir="$desired_dir/".$file_name;
									 rename($file_tmp,$new_dir) ;				
								}
							}
							else{
									print_r($errors);
							}
						}	
					  }
					  
					  $count_itnry = $db->prepare("SELECT COUNT(itinerary_id) FROM package_itinerary WHERE it_pckid=:resrt_id");
					  $count_itnry->bindParam(':resrt_id',$resrt_id);
					  $count_itnry->execute();
					  $cnt_itn = $count_itnry->fetchColumn();
					  
					  
					  if(!empty($_POST['done'])){
						  $done = $_POST['done'];
						 
						  $add_dayone = $db->prepare("INSERT INTO package_itinerary(it_pckid,day_one,itinerary_date)VALUES(:resrt_id, :done, :date)");
						  $add_dayone->bindParam(':resrt_id',$resrt_id);
						  $add_dayone->bindParam(':done',$done);
						  $add_dayone->bindParam(':date',$date);
						  $add_dayone->execute();
						  if(isset($add_dayone)){
						  	if(!empty($_FILES['onefile'])){	
							$errors= array();
							foreach($_FILES['onefile']['tmp_name'] as $key => $tmp_name ){
								$file_name = $key.$_FILES['onefile']['name'][$key];
								$file_size =$_FILES['onefile']['size'][$key];
								$file_tmp =$_FILES['onefile']['tmp_name'][$key];
								$file_type=$_FILES['onefile']['type'][$key];	
								$addimages = $db->prepare("INSERT INTO day_one_image(itry_pckid_one,image_one,image_date_one) VALUES(:resrt_id,:file_name,:date)");
								$addimages->bindParam(':resrt_id',$resrt_id);
								$addimages->bindParam(':file_name',$file_name);
								$addimages->bindParam(':date',$date);
								$addimages->execute();
								if(isset($addimages)){
								  $desired_dir="../images/itinerary_image";
									if(is_dir($desired_dir)==false){
										mkdir("$desired_dir", 0700);		// Create directory if it does not exist
									}
									if(is_dir("$desired_dir/".$file_name)==false){
										move_uploaded_file($file_tmp,"$desired_dir/".$file_name);
									}else{									// rename the file if another one exist
										$new_dir="$desired_dir/".$file_name;
										 rename($file_tmp,$new_dir) ;				
									}
								}
								else{
										print_r($errors);
								}
							}	
						  }
						  
						  	  if(!empty($_POST['ngone'])){
						  $ngone = $_POST['ngone'];
						  if($cnt_itn > 0){ 
							  $add_none = $db->prepare("UPDATE package_itinerary SET night_one:ngone WHERE it_pckid=:resrt_id");
							  $add_none->bindParam(':resrt_id',$resrt_id);
							  $add_none->bindParam(':ngone',$ngone);
							  $add_none->execute();
						  }
						  else{
							  $add_none = $db->prepare("INSERT INTO package_itinerary(it_pckid,night_one,itinerary_date)VALUES(:resrt_id, :ngone, :date)");
							  $add_none->bindParam(':resrt_id',$resrt_id);
							  $add_none->bindParam(':ngone',$ngone);
							  $add_none->bindParam(':date',$date);
							  $add_none->execute();
						  }
						  if(isset($add_none)){
						 	 if(!empty($_FILES['nonefile'])){	
								$errors= array();
								foreach($_FILES['nonefile']['tmp_name'] as $key => $tmp_name ){
									$file_name = $key.$_FILES['nonefile']['name'][$key];
									$file_size =$_FILES['nonefile']['size'][$key];
									$file_tmp =$_FILES['nonefile']['tmp_name'][$key];
									$file_type=$_FILES['nonefile']['type'][$key];	
									$addimages = $db->prepare("INSERT INTO day_onen_image(itry_pckid_none,night_image_one,image_date_onen) VALUES(:resrt_id,:file_name,:date)");
									$addimages->bindParam(':resrt_id',$resrt_id);
									$addimages->bindParam(':file_name',$file_name);
									$addimages->bindParam(':date',$date);
									$addimages->execute();
									if(isset($addimages)){
									  $desired_dir="../images/itinerary_image";
										if(is_dir($desired_dir)==false){
											mkdir("$desired_dir", 0700);		// Create directory if it does not exist
										}
										if(is_dir("$desired_dir/".$file_name)==false){
											move_uploaded_file($file_tmp,"$desired_dir/".$file_name);
										}else{									// rename the file if another one exist
											$new_dir="$desired_dir/".$file_name;
											 rename($file_tmp,$new_dir) ;				
										}
									}
									else{
											print_r($errors);
									}
								}	
							  }
						  }
					  }
					  
							  if(!empty($_POST['dtwo'])){
								  $dtwo = $_POST['dtwo'];
								 if($cnt_itn > 0){ 
									  $add_daytwo = $db->prepare("UPDATE package_itinerary SET day_two:dtwo WHERE it_pckid=:resrt_id");
									  $add_daytwo->bindParam(':resrt_id',$resrt_id);
									  $add_daytwo->bindParam(':dtwo',$dtwo);
									  $add_daytwo->execute();
								 }
								 else{
								  $add_daytwo = $db->prepare("INSERT INTO package_itinerary(it_pckid,day_two,itinerary_date)VALUES(:resrt_id, :dtwo, :date)");
								  $add_daytwo->bindParam(':resrt_id',$resrt_id);
								  $add_daytwo->bindParam(':dtwo',$dtwo);
								  $add_daytwo->bindParam(':date',$date);
								  $add_daytwo->execute();
								 }
								  if(isset($add_daytwo)){
									 if(!empty($_FILES['twofile'])){	
										$errors= array();
										foreach($_FILES['twofile']['tmp_name'] as $key => $tmp_name ){
											$file_name = $key.$_FILES['twofile']['name'][$key];
											$file_size =$_FILES['twofile']['size'][$key];
											$file_tmp =$_FILES['twofile']['tmp_name'][$key];
											$file_type=$_FILES['twofile']['type'][$key];	
											$addimages = $db->prepare("INSERT INTO day_two_image(itry_pckid_two,image_two,image_date_two) VALUES(:resrt_id,:file_name,:date)");
											$addimages->bindParam(':resrt_id',$resrt_id);
											$addimages->bindParam(':file_name',$file_name);
											$addimages->bindParam(':date',$date);
											$addimages->execute();
											if(isset($addimages)){
											  $desired_dir="../images/itinerary_image";
												if(is_dir($desired_dir)==false){
													mkdir("$desired_dir", 0700);		// Create directory if it does not exist
												}
												if(is_dir("$desired_dir/".$file_name)==false){
													move_uploaded_file($file_tmp,"$desired_dir/".$file_name);
												}else{									// rename the file if another one exist
													$new_dir="$desired_dir/".$file_name;
													 rename($file_tmp,$new_dir) ;				
												}
											}
											else{
													print_r($errors);
											}
										}	
									  }
								  }
							  }
							  
							  if(!empty($_POST['ngtwo'])){
								  $ngtwo = $_POST['ngtwo'];
								  if($cnt_itn > 0){ 
									  $add_ntwo = $db->prepare("UPDATE package_itinerary SET night_two:ngtwo WHERE it_pckid=:resrt_id");
									  $add_ntwo->bindParam(':resrt_id',$resrt_id);
									  $add_ntwo->bindParam(':ngtwo',$ngtwo);
									  $add_ntwo->execute();
								 }
								 else{
									  $add_ntwo = $db->prepare("INSERT INTO package_itinerary(it_pckid,night_two,itinerary_date)VALUES(:resrt_id, :ngtwo, :date)");
									  $add_ntwo->bindParam(':resrt_id',$resrt_id);
									  $add_ntwo->bindParam(':ngtwo',$ngtwo);
									  $add_ntwo->bindParam(':date',$date);
									  $add_ntwo->execute();
								 }
								  if(isset($add_ntwo)){
									if(!empty($_FILES['ntwofile'])){	
										$errors= array();
										foreach($_FILES['ntwofile']['tmp_name'] as $key => $tmp_name ){
											$file_name = $key.$_FILES['ntwofile']['name'][$key];
											$file_size =$_FILES['ntwofile']['size'][$key];
											$file_tmp =$_FILES['ntwofile']['tmp_name'][$key];
											$file_type=$_FILES['ntwofile']['type'][$key];	
											$addimages = $db->prepare("INSERT INTO day_twon_image(itry_pckid_twon,night_image_two,image_date_twon) VALUES(:resrt_id,:file_name,:date)");
											$addimages->bindParam(':resrt_id',$resrt_id);
											$addimages->bindParam(':file_name',$file_name);
											$addimages->bindParam(':date',$date);
											$addimages->execute();
											if(isset($addimages)){
											  $desired_dir="../images/itinerary_image";
												if(is_dir($desired_dir)==false){
													mkdir("$desired_dir", 0700);		// Create directory if it does not exist
												}
												if(is_dir("$desired_dir/".$file_name)==false){
													move_uploaded_file($file_tmp,"$desired_dir/".$file_name);
												}else{									// rename the file if another one exist
													$new_dir="$desired_dir/".$file_name;
													 rename($file_tmp,$new_dir) ;				
												}
											}
											else{
													print_r($errors);
											}
										}	
									  }
								  }
							  }
							  
							  if(!empty($_POST['dthree'])){
								  $dthree = $_POST['dthree'];
								  if($cnt_itn > 0){ 
									  $add_daythree = $db->prepare("UPDATE package_itinerary SET day_three:dthree WHERE it_pckid=:resrt_id");
									  $add_daythree->bindParam(':resrt_id',$resrt_id);
									  $add_daythree->bindParam(':dthree',$dthree);
									  $add_daythree->execute();
								 }
								 else{
									  $add_daythree = $db->prepare("INSERT INTO package_itinerary(it_pckid,day_three,itinerary_date)VALUES(:resrt_id, :dthree, :date)");
									  $add_daythree->bindParam(':resrt_id',$resrt_id);
									  $add_daythree->bindParam(':dthree',$dthree);
									  $add_daythree->bindParam(':date',$date);
									  $add_daythree->execute();
								 }
								  if(isset($add_daythree)){
									if(!empty($_FILES['threefile'])){	
										$errors= array();
										foreach($_FILES['threefile']['tmp_name'] as $key => $tmp_name ){
											$file_name = $key.$_FILES['threefile']['name'][$key];
											$file_size =$_FILES['threefile']['size'][$key];
											$file_tmp =$_FILES['threefile']['tmp_name'][$key];
											$file_type=$_FILES['threefile']['type'][$key];	
											$addimages = $db->prepare("INSERT INTO day_three_image(itry_pckid_three,image_three,image_date_three) VALUES(:resrt_id,:file_name,:date)");
											$addimages->bindParam(':resrt_id',$resrt_id);
											$addimages->bindParam(':file_name',$file_name);
											$addimages->bindParam(':date',$date);
											$addimages->execute();
											if(isset($addimages)){
											  $desired_dir="../images/itinerary_image";
												if(is_dir($desired_dir)==false){
													mkdir("$desired_dir", 0700);		// Create directory if it does not exist
												}
												if(is_dir("$desired_dir/".$file_name)==false){
													move_uploaded_file($file_tmp,"$desired_dir/".$file_name);
												}else{									// rename the file if another one exist
													$new_dir="$desired_dir/".$file_name;
													 rename($file_tmp,$new_dir) ;				
												}
											}
											else{
													print_r($errors);
											}
										}	
									  }
								  }
							  }
							  
							  if(!empty($_POST['ngthree'])){
								  $ngthree = $_POST['ngthree'];
								  if($cnt_itn > 0){ 
									  $add_nthree = $db->prepare("UPDATE package_itinerary SET night_three:ngthree WHERE it_pckid=:resrt_id");
									  $add_nthree->bindParam(':resrt_id',$resrt_id);
									  $add_nthree->bindParam(':ngthree',$ngthree);
									  $add_nthree->execute();
								 }
								 else{
									  $add_nthree = $db->prepare("INSERT INTO package_itinerary(it_pckid,night_three,itinerary_date)VALUES(:resrt_id, :ngthree, :date)");
									  $add_nthree->bindParam(':resrt_id',$resrt_id);
									  $add_nthree->bindParam(':ngthree',$ngthree);
									  $add_nthree->bindParam(':date',$date);
									  $add_nthree->execute();
								 }
								  if(isset($add_nthree)){
									if(!empty($_FILES['nthreefile'])){	
										$errors= array();
										foreach($_FILES['nthreefile']['tmp_name'] as $key => $tmp_name ){
											$file_name = $key.$_FILES['nthreefile']['name'][$key];
											$file_size =$_FILES['nthreefile']['size'][$key];
											$file_tmp =$_FILES['nthreefile']['tmp_name'][$key];
											$file_type=$_FILES['nthreefile']['type'][$key];	
											$addimages = $db->prepare("INSERT INTO day_threen_image(itry_pckid_threen,night_image_three,image_date_threen) VALUES(:resrt_id,:file_name,:date)");
											$addimages->bindParam(':resrt_id',$resrt_id);
											$addimages->bindParam(':file_name',$file_name);
											$addimages->bindParam(':date',$date);
											$addimages->execute();
											if(isset($addimages)){
											  $desired_dir="../images/itinerary_image";
												if(is_dir($desired_dir)==false){
													mkdir("$desired_dir", 0700);		// Create directory if it does not exist
												}
												if(is_dir("$desired_dir/".$file_name)==false){
													move_uploaded_file($file_tmp,"$desired_dir/".$file_name);
												}else{									// rename the file if another one exist
													$new_dir="$desired_dir/".$file_name;
													 rename($file_tmp,$new_dir) ;				
												}
											}
											else{
													print_r($errors);
											}
										}	
									  }
								  }
							  }
							  
							  if(!empty($_POST['dfour'])){
								  $dfour = $_POST['dfour'];
								  if($cnt_itn > 0){ 
									  $add_dayfour = $db->prepare("UPDATE package_itinerary SET day_four:dfour WHERE it_pckid=:resrt_id");
									  $add_dayfour->bindParam(':resrt_id',$resrt_id);
									  $add_dayfour->bindParam(':dfour',$dfour);
									  $add_dayfour->execute();
								 }
								 else{
									  $add_dayfour = $db->prepare("INSERT INTO package_itinerary(it_pckid,day_four,itinerary_date)VALUES(:resrt_id, :dfour, :date)");
									  $add_dayfour->bindParam(':resrt_id',$resrt_id);
									  $add_dayfour->bindParam(':dfour',$dfour);
									  $add_dayfour->bindParam(':date',$date);
									  $add_dayfour->execute();
								 }
								  if(isset($add_dayfour)){
									if(!empty($_FILES['fourfile'])){	
										$errors= array();
										foreach($_FILES['fourfile']['tmp_name'] as $key => $tmp_name ){
											$file_name = $key.$_FILES['fourfile']['name'][$key];
											$file_size =$_FILES['fourfile']['size'][$key];
											$file_tmp =$_FILES['fourfile']['tmp_name'][$key];
											$file_type=$_FILES['fourfile']['type'][$key];	
											$addimages = $db->prepare("INSERT INTO day_four_image(itry_pckid_four,image_four,image_date_four) VALUES(:resrt_id,:file_name,:date)");
											$addimages->bindParam(':resrt_id',$resrt_id);
											$addimages->bindParam(':file_name',$file_name);
											$addimages->bindParam(':date',$date);
											$addimages->execute();
											if(isset($addimages)){
											  $desired_dir="../images/itinerary_image";
												if(is_dir($desired_dir)==false){
													mkdir("$desired_dir", 0700);		// Create directory if it does not exist
												}
												if(is_dir("$desired_dir/".$file_name)==false){
													move_uploaded_file($file_tmp,"$desired_dir/".$file_name);
												}else{									// rename the file if another one exist
													$new_dir="$desired_dir/".$file_name;
													 rename($file_tmp,$new_dir) ;				
												}
											}
											else{
													print_r($errors);
											}
										}	
									  }
								  }
							  }
							  
							  if(!empty($_POST['ngfour'])){
								  $ngfour = $_POST['ngfour'];
								  if($cnt_itn > 0){ 
									  $add_nfour = $db->prepare("UPDATE package_itinerary SET night_four:ngfour WHERE it_pckid=:resrt_id");
									  $add_nfour->bindParam(':resrt_id',$resrt_id);
									  $add_nfour->bindParam(':ngfour',$ngfour);
									  $add_nfour->execute();
								 }
								 else{
									  $add_nfour = $db->prepare("INSERT INTO package_itinerary(it_pckid,night_four,itinerary_date)VALUES(:resrt_id, :ngfour, :date)");
									  $add_nfour->bindParam(':resrt_id',$resrt_id);
									  $add_nfour->bindParam(':ngfour',$ngfour);
									  $add_nfour->bindParam(':date',$date);
									  $add_nfour->execute();
								 }
								  if(isset($add_nfour)){
									if(!empty($_FILES['nfourfile'])){	
										$errors= array();
										foreach($_FILES['nfourfile']['tmp_name'] as $key => $tmp_name ){
											$file_name = $key.$_FILES['nfourfile']['name'][$key];
											$file_size =$_FILES['nfourfile']['size'][$key];
											$file_tmp =$_FILES['nfourfile']['tmp_name'][$key];
											$file_type=$_FILES['nfourfile']['type'][$key];	
											$addimages = $db->prepare("INSERT INTO day_fourn_image(itry_pckid_fourn,night_image_four,image_date_fourn) VALUES(:resrt_id,:file_name,:date)");
											$addimages->bindParam(':resrt_id',$resrt_id);
											$addimages->bindParam(':file_name',$file_name);
											$addimages->bindParam(':date',$date);
											$addimages->execute();
											if(isset($addimages)){
											  $desired_dir="../images/itinerary_image";
												if(is_dir($desired_dir)==false){
													mkdir("$desired_dir", 0700);		// Create directory if it does not exist
												}
												if(is_dir("$desired_dir/".$file_name)==false){
													move_uploaded_file($file_tmp,"$desired_dir/".$file_name);
												}else{									// rename the file if another one exist
													$new_dir="$desired_dir/".$file_name;
													 rename($file_tmp,$new_dir) ;				
												}
											}
											else{
													print_r($errors);
											}
										}	
									  }
								  }
							  }
							  
							  if(!empty($_POST['dfive'])){
								  $dfive = $_POST['dfive'];
								  if($cnt_itn > 0){ 
									  $add_dayfive = $db->prepare("UPDATE package_itinerary SET day_five:dfive WHERE it_pckid=:resrt_id");
									  $add_dayfive->bindParam(':resrt_id',$resrt_id);
									  $add_dayfive->bindParam(':dfive',$dfive);
									  $add_dayfive->execute();
								 }
								 else{
									  $add_dayfive = $db->prepare("INSERT INTO package_itinerary(it_pckid,day_five,itinerary_date)VALUES(:resrt_id, :dfive, :date)");
									  $add_dayfive->bindParam(':resrt_id',$resrt_id);
									  $add_dayfive->bindParam(':dfive',$dfive);
									  $add_dayfive->bindParam(':date',$date);
									  $add_dayfive->execute();
								 }
								  if(isset($add_dayfive)){
									if(!empty($_FILES['fivefile'])){	
										$errors= array();
										foreach($_FILES['fivefile']['tmp_name'] as $key => $tmp_name ){
											$file_name = $key.$_FILES['fivefile']['name'][$key];
											$file_size =$_FILES['fivefile']['size'][$key];
											$file_tmp =$_FILES['fivefile']['tmp_name'][$key];
											$file_type=$_FILES['fivefile']['type'][$key];	
											$addimages = $db->prepare("INSERT INTO day_five_image(itry_pckid_five,image_five,image_date_five) VALUES(:resrt_id,:file_name,:date)");
											$addimages->bindParam(':resrt_id',$resrt_id);
											$addimages->bindParam(':file_name',$file_name);
											$addimages->bindParam(':date',$date);
											$addimages->execute();
											if(isset($addimages)){
											  $desired_dir="../images/itinerary_image";
												if(is_dir($desired_dir)==false){
													mkdir("$desired_dir", 0700);		// Create directory if it does not exist
												}
												if(is_dir("$desired_dir/".$file_name)==false){
													move_uploaded_file($file_tmp,"$desired_dir/".$file_name);
												}else{									// rename the file if another one exist
													$new_dir="$desired_dir/".$file_name;
													 rename($file_tmp,$new_dir) ;				
												}
											}
											else{
													print_r($errors);
											}
										}	
									  }
								  }
							  }
							  
							  if(!empty($_POST['ngfive'])){
								  $ngfive = $_POST['ngfive'];
								  if($cnt_itn > 0){ 
									  $add_nfive = $db->prepare("UPDATE package_itinerary SET night_five:ngfive WHERE it_pckid=:resrt_id");
									  $add_nfive->bindParam(':resrt_id',$resrt_id);
									  $add_nfive->bindParam(':ngfive',$ngfive);
									  $add_nfive->execute();
								 }
								 else{
									  $add_nfive = $db->prepare("INSERT INTO package_itinerary(it_pckid,night_five,itinerary_date)VALUES(:resrt_id, :ngfive, :date)");
									  $add_nfive->bindParam(':resrt_id',$resrt_id);
									  $add_nfive->bindParam(':ngfive',$ngfive);
									  $add_nfive->bindParam(':date',$date);
									  $add_nfive->execute();
								 }
								  if(isset($add_nfive)){
									if(!empty($_FILES['nfivefile'])){	
										$errors= array();
										foreach($_FILES['nfivefile']['tmp_name'] as $key => $tmp_name ){
											$file_name = $key.$_FILES['nfivefile']['name'][$key];
											$file_size =$_FILES['nfivefile']['size'][$key];
											$file_tmp =$_FILES['nfivefile']['tmp_name'][$key];
											$file_type=$_FILES['nfivefile']['type'][$key];	
											$addimages = $db->prepare("INSERT INTO day_fiven_image(itry_pckid_fiven,night_image_five,image_date_fiven	) VALUES(:resrt_id,:file_name,:date)");
											$addimages->bindParam(':resrt_id',$resrt_id);
											$addimages->bindParam(':file_name',$file_name);
											$addimages->bindParam(':date',$date);
											$addimages->execute();
											if(isset($addimages)){
											  $desired_dir="../images/itinerary_image";
												if(is_dir($desired_dir)==false){
													mkdir("$desired_dir", 0700);		// Create directory if it does not exist
												}
												if(is_dir("$desired_dir/".$file_name)==false){
													move_uploaded_file($file_tmp,"$desired_dir/".$file_name);
												}else{									// rename the file if another one exist
													$new_dir="$desired_dir/".$file_name;
													 rename($file_tmp,$new_dir) ;				
												}
											}
											else{
													print_r($errors);
											}
										}	
									  }
								  }
							  }
							  
							  if(!empty($_POST['dsix'])){
								  $dsix = $_POST['dsix'];
								  if($cnt_itn > 0){ 
									  $add_daysix = $db->prepare("UPDATE package_itinerary SET day_six:dsix WHERE it_pckid=:resrt_id");
									  $add_daysix->bindParam(':resrt_id',$resrt_id);
									  $add_daysix->bindParam(':dsix',$dsix);
									  $add_daysix->execute();
								 }
								 else{
									  $add_daysix = $db->prepare("INSERT INTO package_itinerary(it_pckid,day_six,itinerary_date)VALUES(:resrt_id, :dsix, :date)");
									  $add_daysix->bindParam(':resrt_id',$resrt_id);
									  $add_daysix->bindParam(':dsix',$dsix);
									  $add_daysix->bindParam(':date',$date);
									  $add_daysix->execute();
								 }
								  if(isset($add_daysix)){
									 if(!empty($_FILES['sixfile'])){	
										$errors= array();
										foreach($_FILES['sixfile']['tmp_name'] as $key => $tmp_name ){
											$file_name = $key.$_FILES['sixfile']['name'][$key];
											$file_size =$_FILES['sixfile']['size'][$key];
											$file_tmp =$_FILES['sixfile']['tmp_name'][$key];
											$file_type=$_FILES['sixfile']['type'][$key];	
											$addimages = $db->prepare("INSERT INTO day_six_image(itry_pckid_six,image_six,image_date_six) VALUES(:resrt_id,:file_name,:date)");
											$addimages->bindParam(':resrt_id',$resrt_id);
											$addimages->bindParam(':file_name',$file_name);
											$addimages->bindParam(':date',$date);
											$addimages->execute();
											if(isset($addimages)){
											  $desired_dir="../images/itinerary_image";
												if(is_dir($desired_dir)==false){
													mkdir("$desired_dir", 0700);		// Create directory if it does not exist
												}
												if(is_dir("$desired_dir/".$file_name)==false){
													move_uploaded_file($file_tmp,"$desired_dir/".$file_name);
												}else{									// rename the file if another one exist
													$new_dir="$desired_dir/".$file_name;
													 rename($file_tmp,$new_dir) ;				
												}
											}
											else{
													print_r($errors);
											}
										}	
									  }
								  }
							  }
							  
							  if(!empty($_POST['ngsix'])){
								  $ngsix = $_POST['ngsix'];
								  if($cnt_itn > 0){ 
									  $add_nsix = $db->prepare("UPDATE package_itinerary SET night_six:ngsix WHERE it_pckid=:resrt_id");
									  $add_nsix->bindParam(':resrt_id',$resrt_id);
									  $add_nsix->bindParam(':ngsix',$ngsix);
									  $add_nsix->execute();
								 }
								 else{
									  $add_nsix = $db->prepare("INSERT INTO package_itinerary(it_pckid,night_six,itinerary_date)VALUES(:resrt_id, :ngsix, :date)");
									  $add_nsix->bindParam(':resrt_id',$resrt_id);
									  $add_nsix->bindParam(':ngsix',$ngsix);
									  $add_nsix->bindParam(':date',$date);
									  $add_nsix->execute();
								 }
								  if(isset($add_nsix)){
									 if(!empty($_FILES['nsixfile'])){	
										$errors= array();
										foreach($_FILES['nsixfile']['tmp_name'] as $key => $tmp_name ){
											$file_name = $key.$_FILES['nsixfile']['name'][$key];
											$file_size =$_FILES['nsixfile']['size'][$key];
											$file_tmp =$_FILES['nsixfile']['tmp_name'][$key];
											$file_type=$_FILES['nsixfile']['type'][$key];	
											$addimages = $db->prepare("INSERT INTO day_sixn_image(itry_pckid_sixn,night_image_six,image_date_sixn) VALUES(:resrt_id,:file_name,:date)");
											$addimages->bindParam(':resrt_id',$resrt_id);
											$addimages->bindParam(':file_name',$file_name);
											$addimages->bindParam(':date',$date);
											$addimages->execute();
											if(isset($addimages)){
											  $desired_dir="../images/itinerary_image";
												if(is_dir($desired_dir)==false){
													mkdir("$desired_dir", 0700);		// Create directory if it does not exist
												}
												if(is_dir("$desired_dir/".$file_name)==false){
													move_uploaded_file($file_tmp,"$desired_dir/".$file_name);
												}else{									// rename the file if another one exist
													$new_dir="$desired_dir/".$file_name;
													 rename($file_tmp,$new_dir) ;				
												}
											}
											else{
													print_r($errors);
											}
										}	
									  }
								  }
							  }
							  
							  if(!empty($_POST['dsvn'])){
								  $dsvn = $_POST['dsvn'];
								  if($cnt_itn > 0){ 
									  $add_daysevn = $db->prepare("UPDATE package_itinerary SET day_seven:dsvn WHERE it_pckid=:resrt_id");
									  $add_daysevn->bindParam(':resrt_id',$resrt_id);
									  $add_daysevn->bindParam(':dsvn',$dsvn);
									  $add_daysevn->execute();
								 }
								 else{
									  $add_daysevn = $db->prepare("INSERT INTO package_itinerary(it_pckid,day_seven,itinerary_date)VALUES(:resrt_id, :dsvn, :date)");
									  $add_daysevn->bindParam(':resrt_id',$resrt_id);
									  $add_daysevn->bindParam(':dsvn',$dsvn);
									  $add_daysevn->bindParam(':date',$date);
									  $add_daysevn->execute();
								 }
								  if(isset($add_daysevn)){
									if(!empty($_FILES['svnfile'])){	
										$errors= array();
										foreach($_FILES['svnfile']['tmp_name'] as $key => $tmp_name ){
											$file_name = $key.$_FILES['svnfile']['name'][$key];
											$file_size =$_FILES['svnfile']['size'][$key];
											$file_tmp =$_FILES['svnfile']['tmp_name'][$key];
											$file_type=$_FILES['svnfile']['type'][$key];	
											$addimages = $db->prepare("INSERT INTO day_sevn_image(itry_pckid_sevn,image_seven,image_date_sevn) VALUES(:resrt_id,:file_name,:date)");
											$addimages->bindParam(':resrt_id',$resrt_id);
											$addimages->bindParam(':file_name',$file_name);
											$addimages->bindParam(':date',$date);
											$addimages->execute();
											if(isset($addimages)){
											  $desired_dir="../images/itinerary_image";
												if(is_dir($desired_dir)==false){
													mkdir("$desired_dir", 0700);		// Create directory if it does not exist
												}
												if(is_dir("$desired_dir/".$file_name)==false){
													move_uploaded_file($file_tmp,"$desired_dir/".$file_name);
												}else{									// rename the file if another one exist
													$new_dir="$desired_dir/".$file_name;
													 rename($file_tmp,$new_dir) ;				
												}
											}
											else{
													print_r($errors);
											}
										}	
									  }
								  }
							  }
							  
							  if(!empty($_POST['ngsvn'])){
								  $ngsvn = $_POST['ngsvn'];
								  if($cnt_itn > 0){ 
									  $add_nsevn = $db->prepare("UPDATE package_itinerary SET night_seven:ngsvn WHERE it_pckid=:resrt_id");
									  $add_nsevn->bindParam(':resrt_id',$resrt_id);
									  $add_nsevn->bindParam(':ngsvn',$ngsvn);
									  $add_nsevn->execute();
								 }
								 else{
									  $add_nsevn = $db->prepare("INSERT INTO package_itinerary(it_pckid,night_seven,itinerary_date)VALUES(:resrt_id, :ngsvn, :date)");
									  $add_nsevn->bindParam(':resrt_id',$resrt_id);
									  $add_nsevn->bindParam(':ngsvn',$ngsvn);
									  $add_nsevn->bindParam(':date',$date);
									  $add_nsevn->execute();
								 }
								  if(isset($add_nsevn)){
									if(!empty($_FILES['nsvnfile'])){	
										$errors= array();
										foreach($_FILES['nsvnfile']['tmp_name'] as $key => $tmp_name ){
											$file_name = $key.$_FILES['nsvnfile']['name'][$key];
											$file_size =$_FILES['nsvnfile']['size'][$key];
											$file_tmp =$_FILES['nsvnfile']['tmp_name'][$key];
											$file_type=$_FILES['nsvnfile']['type'][$key];	
											$addimages = $db->prepare("INSERT INTO day_sevnn_image(itry_pckid_sevnn,night_image_seven,image_date_sevnn) VALUES(:resrt_id,:file_name,:date)");
											$addimages->bindParam(':resrt_id',$resrt_id);
											$addimages->bindParam(':file_name',$file_name);
											$addimages->bindParam(':date',$date);
											$addimages->execute();
											if(isset($addimages)){
											  $desired_dir="../images/itinerary_image";
												if(is_dir($desired_dir)==false){
													mkdir("$desired_dir", 0700);		// Create directory if it does not exist
												}
												if(is_dir("$desired_dir/".$file_name)==false){
													move_uploaded_file($file_tmp,"$desired_dir/".$file_name);
												}else{									// rename the file if another one exist
													$new_dir="$desired_dir/".$file_name;
													 rename($file_tmp,$new_dir) ;				
												}
											}
											else{
													print_r($errors);
											}
										}	
									  }
								  }
							  }
						  }
					  }
					  
					  
					  	echo "<script>location.assign('resort.php')</script>";
					}
				}
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Add Resorts</title>
<?php echo headdata(); ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="<?php echo $url; ?>css/font-awesome.min.css" type="text/css" rel="stylesheet"/>
<link href="<?php echo $url; ?>css/bootstrap.min.css" type="text/css" rel="stylesheet"/>
<link href="css/styleplus.css" type="text/css" rel="stylesheet"/>
<link href="css/responsive-manage.css" type="text/css" rel="stylesheet"/>
<script src="<?php echo $url; ?>js/jquery-3.2.1.min.js" type="text/javascript"> </script>
<script src="<?php echo $url; ?>js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/index.js"></script>
<script src="https://cdn.ckeditor.com/4.7.3/full/ckeditor.js" type="text/javascript"></script>
<script>
$(function(){
		$("a.hidelink").each(function (index, element){
			var href = $(this).attr("href");
			$(this).attr("hiddenhref", href);
			$(this).removeAttr("href");
		});
		$("a.hidelink").click(function(){
			url = $(this).attr("hiddenhref");
			window.open(url, '_top');
		})
	});



function ckdel(){
	
	return confirm('Are you sure');	
	
}
</script>
</head>
<body>
<?php include('aheader.php'); ?>

<div class="slidebody see-trans5s">
    <?php include('topheader.php'); ?>
    <div class="fulldv adminbody">
    <div class="fulldv subcate_sect">
	
      <div class="fulldv category-maindv">
        <!--<div class="see-12 topbox">
            <input type="button" value="Add Resort" class="btn-blue" onClick="addactivity()">
        </div>-->
        
        <div class="col-md-12 addresort_form">
         <form method="post" enctype="multipart/form-data">
        	<div class="col-md-12">
            	<h2><?php echo $st['resort_name']; ?></h2>
            </div>
            
            <div class="col-md-3">
            	<p>Category</p>
                <select name="catid" required/>
                	<option value="" hidden="hidden">Select</option>
                <?php
					$show_cate = $db->prepare("SELECT * FROM category ORDER BY categoryid DESC");
					$show_cate->execute();
					$allcat = $show_cate->fetchAll();
					foreach($allcat as $alct){
				?>
                	<option value="<?php echo $alct['categoryid']; ?>"><?php echo $alct['categoryname']; ?></option>
                <?php } ?>     
                </select>
            </div>
            <div class="col-md-3">
            	<p>Packages Price</p>
                <input type="text" name="pckprz" placeholder="Package Price" required/>
                <!--<select name="pckprz">
                	<option value="" hidden="hidden">Select</option>
                    <option value="Less than 10,000">Less than 10,000</option>
                    <option value="10,000 - 20,000">10,000 - 20,000</option>
                    <option value="20,000 - 40,000">20,000 - 40,000</option>
                    <option value="40,000 - 60,000">40,000 - 60,000</option>
                    <option value="60,000 - 80,000">60,000 - 80,000</option>
                    <option value="Above 80,000">Above 80,000</option>
                </select>-->
            </div>
            <div class="col-md-3">
            	<p>Budget Per Person ( in Rs. )</p>
                <input type="text" name="bdgfrom" style="width:50px;"> <span class="high">To</span><input type="text" name="bdgto" style="width:50px;">
            </div>
            <div class="col-md-3">
            	<p>Packages By Duration</p>
                <select name="pckdurtion" required>
                	<option value="" hidden="hidden">Select</option>
                    <option value="1 to 3 Days">1 to 3 Days</option>
                    <option value="4 to 6 Days">4 to 6 Days</option>
                    <option value="7 to 9 Days">7 to 9 Days</option>
                    <option value="10 to 12 Days">10 to 12 Days</option>
                    <option value="13 Days or More">13 Days or More</option>
                </select>
            </div>
            <div class="col-md-3">
            	<p>Duration ( in Days/Night )</p>
                <input type="text" name="durctnfrom" style="width:50px;" required/> <span class="high">To</span>  
                <input type="text" name="durctnto" style="width:50px;" required/>
            </div>
            <div class="col-md-3">
            	<p>Packages By SEASON</p>
                <select name="sesonfrom" style="width:80px;">
                	<option value="" hidden="hidden">Select</option>
                    <option value="January">January</option>
                    <option value="February">February</option>
                    <option value="March">March</option>
                    <option value="April">April</option>
                    <option value="May">May</option>
                    <option value="June">June</option>
                    <option value="July">July</option>
                    <option value="August">August</option>
                    <option value="September">September</option>
                    <option value="October">October</option>
                    <option value="November">November</option>
                    <option value="December">December</option>
                </select>
                <span class="high">To</span>
                <select name="sesonto" style="width:80px;">
                	<option value="" hidden="hidden">Select</option>
                    <option value="January">January</option>
                    <option value="February">February</option>
                    <option value="March">March</option>
                    <option value="April">April</option>
                    <option value="May">May</option>
                    <option value="June">June</option>
                    <option value="July">July</option>
                    <option value="August">August</option>
                    <option value="September">September</option>
                    <option value="October">October</option>
                    <option value="November">November</option>
                    <option value="December">December</option>
                </select>
            </div>
            <div class="col-md-3">
            	<p>Hotel Star Rating</p>
                <select name="hotlratin" required/>
                	<option value="" hidden="hidden">Select</option>
                    <option value="1">1 star</option>
                    <option value="2">2 star</option>
                    <option value="3">3 star</option>
                    <option value="4">4 star</option>
                    <option value="5">5 star</option>
                </select>
            </div>
            <div class="col-md-2">
            	<p>Flight Status</p>
                <select name="flstatus" required/>
                	<option value="" hidden="hidden">Select</option>
                    <option value="Included">Flight Included</option>
                    <option value="Excluded">Flight Excluded</option>
                </select>
            </div>
            
            <div class="col-md-12">
            	<p>Activities/Facilities</p>
                <ul class="facilities">
                <?php
					$show_activty = $db->prepare("SELECT * FROM add_activity ORDER BY activity_id DESC");
					$show_activty->execute();
					$rowactv = $show_activty->fetchAll();
					foreach($rowactv as $rwactv){
				?>
                    <li><input type="checkbox" name="act[]" value="<?php echo $rwactv['activity_id']; ?>"><?php echo $rwactv['activity_name']; ?></li>
                <?php } ?>    
                </ul>
            </div>
            <div class="col-md-12">
            	<p>Overview</p>
                <textarea rows="10" name="ovrview"></textarea>
            </div>
            <div class="col-md-12">
            	<h2>Package Itinerary</h2>
            </div>
            
            <div class="col-md-8">
            	<p>Day One</p>
                <textarea rows="10" name="done"></textarea>
            </div>
            <div class="col-md-4">
            	<p>Day Image</p>
            	<input type="file" name="onefile[]" multiple>
            </div>
            <div class="col-md-8">
            	<p>Night One</p>
                <textarea rows="10" name="ngone"></textarea>
            </div>
            <div class="col-md-4">
            	<p>Night Image</p>
            	<input type="file" name="nonefile[]" multiple>
            </div>
            
            <div class="col-md-8">
            	<p>Day Two</p>
                <textarea rows="10" name="dtwo"></textarea>
            </div>
            <div class="col-md-4">
            	<p>Day Image</p>
            	<input type="file" name="twofile[]" multiple>
            </div>
            <div class="col-md-8">
            	<p>Night Two</p>
                <textarea rows="10" name="ngtwo"></textarea>
            </div>
            <div class="col-md-4">
            	<p>Night Image</p>
            	<input type="file" name="ntwofile[]" multiple>
            </div>
            
            <div class="col-md-8">
            	<p>Day Three</p>
                <textarea rows="10" name="dthree"></textarea>
            </div>
            <div class="col-md-4">
            	<p>Day Image</p>
            	<input type="file" name="threefile[]" multiple>
            </div>
            <div class="col-md-8">
            	<p>Night Three</p>
                <textarea rows="10" name="ngthree"></textarea>
            </div>
            <div class="col-md-4">
            	<p>Night Image</p>
            	<input type="file" name="nthreefile[]" multiple>
            </div>
            
            <div class="col-md-8">
            	<p>Day Four</p>
                <textarea rows="10" name="dfour"></textarea>
            </div>
            <div class="col-md-4">
            	<p>Day Image</p>
            	<input type="file" name="fourfile[]" multiple>
            </div>
            <div class="col-md-8">
            	<p>Night Four</p>
                <textarea rows="10" name="ngfour"></textarea>
            </div>
            <div class="col-md-4">
            	<p>Night Image</p>
            	<input type="file" name="nfourfile[]" multiple>
            </div>
            
            <div class="col-md-8">
            	<p>Day Five</p>
                <textarea rows="10" name="dfive"></textarea>
            </div>
            <div class="col-md-4">
            	<p>Day Image</p>
            	<input type="file" name="fivefile[]" multiple>
            </div>
            <div class="col-md-8">
            	<p>Night Five</p>
                <textarea rows="10" name="ngfive"></textarea>
            </div>
            <div class="col-md-4">
            	<p>Night Image</p>
            	<input type="file" name="nfivefile[]" multiple>
            </div>
            
            <div class="col-md-8">
            	<p>Day Six</p>
                <textarea rows="10" name="dsix"></textarea>
            </div>
            <div class="col-md-4">
            	<p>Day Image</p>
            	<input type="file" name="sixfile[]" multiple>
            </div>
            <div class="col-md-8">
            	<p>Night Six</p>
                <textarea rows="10" name="ngsix"></textarea>
            </div>
            <div class="col-md-4">
            	<p>Night Image</p>
            	<input type="file" name="nsixfile[]" multiple>
            </div>
            
            <div class="col-md-8">
            	<p>Day Seven</p>
                <textarea rows="10" name="dsvn"></textarea>
            </div>
            <div class="col-md-4">
            	<p>Day Image</p>
            	<input type="file" name="svnfile[]" multiple>
            </div>
            <div class="col-md-8">
            	<p>Night Seven</p>
                <textarea rows="10" name="ngsvn"></textarea>
            </div>
            <div class="col-md-4">
            	<p>Night Image</p>
            	<input type="file" name="nsvnfile[]" multiple>
            </div>
            
            
            
            
            <!--<div class="col-md-12">
            	<p>Package Activity</p>
                <textarea name="pfeature" class="ckeditor" id="" cols="30" rows="10" required/></textarea><br>
            </div>-->
            <div class="col-md-12">
            	<p>Resort Image (You Can Select Multiple Images)</p>
                <input type="file" name="addfles[]" class="" multiple/>
            </div>
            <div class="col-md-12">
            	<input type="submit" value="Save" name="addmore">
            </div>
          </form>  
        </div> 
        <div class="clearfix"></div>
         <br><br>
        
    </div>
 
 </div>
 </div>
 </div>
 </body>
  </html>
  <?php }
	}
	else{ echo "<script>location.assign('logout.php')</script>"; }
  	  }
	}
	else{ echo "<script>location.assign('logout.php')</script>"; }
}
else{ echo "<script>location.assign('logout.php')</script>"; }
?>