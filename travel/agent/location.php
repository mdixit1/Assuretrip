<?php
error_reporting(0);
session_start();
include('../connection/index.php');
include('../function.php'); 
?>
<!DOCTYPE html>
<html lang="en-IN">
<head>
    <?php echo headdata(); ?>
    <link rel="canonical" href=""/>
    <link rel='shortlink' href=""/>
	<title>Welcome to travel.com</title>
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
    <link href="style/admin-style.css" rel="stylesheet" type="text/css"/>
    <link href="css/styleplus.css" type="text/css" rel="stylesheet"/>
    <link href="css/see.css" type="text/css" rel="stylesheet"/>
	<link href="css/responsive-manage.css" type="text/css" rel="stylesheet"/>
	<link href="css/index.css" type="text/css" rel="stylesheet"/>
    <link href="css/style_manage.css" type="text/css" rel="stylesheet" />
    
    
</head>
<body>
<div class="see-section wrapper_mg">

<div class="see-section main_dv"> 
    <?php include('leftmenu.php'); ?>
    
    <div class="col-md-12 p0 rightsidebar">
        <?php include('rightheader.php');?>
        <div class="col-md-12 rightsidebar_top2">
        
        </div>
        <div class="col-md-12 rightsidebar_top3">
        	<select name="" id="">
            	<option value="" hidden="">Destinations</option>
            	<option value="">Delhi</option>
            	<option value="">Kerla</option>
            </select>
        </div>
        
        <div class="col-md-12">
        <br><br>
        	<?php
	if(isset($_GET['state'])){ ?>
<div class="fulldv title_with_button">
	<a href="location.php" class="see-button see-blue">Add Country</a>
    &nbsp;&nbsp;&nbsp; 
    <h3>State</h3>   
    &nbsp;&nbsp;&nbsp; 
    <a href="location.php?city" class="see-button see-blue">Add City</a>
</div>

<div class="country">

<?php
   if(isset($_POST['addstate'])){ 
		$contryid = $_POST['country'];
		$stename = $_POST['stname'];
		$steimg = $_FILES['stimg']['name'];
		$tempimg = $_FILES['stimg']['tmp_name'];
		$target = '../images/stateimage/'.$steimg;
		$stetag = $_POST['sttag'];
		$date = date('d - M - Y');
		$duplicate = $db->prepare("SELECT COUNT(statename) FROM state WHERE statename= :stename ");
		 $duplicate->bindParam(':stename',$stename);
		 $duplicate->execute();
		 $getcat = $duplicate->fetchColumn();
		 if($getcat > 0){ echo "This State Already Exists"; }
		 elseif(file_exists('../images/stateimage/'.$_FILES['stimg']['name'])){echo "This image Already Exists";}
		 else{
			  $insertquery = $db->prepare("INSERT INTO state(contid,statename,stateimage,statetagline,statedate)VALUES(:contryid,:stename,:steimg,:stetag,:date)");
			  $insertquery->bindParam(':contryid',$contryid);
			  $insertquery->bindParam(':stename',$stename);
			  $insertquery->bindParam(':steimg',$steimg);
			  $insertquery->bindParam(':stetag',$stetag);
			  $insertquery->bindParam(':date',$date); 
			  if($insertquery->execute()){
			  	move_uploaded_file($tempimg,$target);
			  }
			else{
				 echo "Not Add";
			 }
		}
	  }
  ?>	
  <div class="clear"></div>
  <div class="dv-form">
  <form method="post" enctype="multipart/form-data">
  	<select name="country" required>
        <option value="" hidden="hidden">Select Country</option>  
            <option value="">india</option>
    </select>
    <p>State Name</p>
    <input type="text" name="stname" required/>
    <p>State Image</p>
    <input type="file" name="stimg">
    <p>Tag Line</p>
    <input type="text" name="sttag" placeholder="Enter Tag Line" >
    <input type="submit" name="addstate" value="Add State"/>
	</form>
</div>



    <div class="fulldv add-imag-dv">     
        <div class="col-md-3 add-imag-dv-in_out">
            <div class="fulldv add-imag-dv-in">
                <p>India</p>
                <img src="../images/themes/theme1.jpg" alt=""/>
                <p>Nice Place To Visit</p> 
                <a href="#" class="see-button see-blue">Edit</a>
            </div>
        </div>
        <div class="col-md-3 add-imag-dv-in_out">
            <div class="fulldv add-imag-dv-in">
                <p>India</p>
                <img src="../images/themes/theme1.jpg" alt=""/>
                <p>Explore The Nature</p> 
                <a href="#" class="see-button see-blue">Edit</a>
            </div>
        </div>
        <div class="col-md-3 add-imag-dv-in_out">
            <div class="fulldv add-imag-dv-in">
                <p>India</p>
                <img src="../images/themes/theme1.jpg" alt=""/>
                <p>Vast Desert In India</p> 
                <a href="#" class="see-button see-blue">Edit</a>
            </div>
        </div>
        <div class="col-md-3 add-imag-dv-in_out">
            <div class="fulldv add-imag-dv-in">
                <p>India</p>
                <img src="../images/themes/theme1.jpg" alt=""/>
                <p>Start Vacation From Here</p> 
                <a href="#" class="see-button see-blue">Edit</a>
            </div>
        </div>
    </div>

</div>

<?php }
	elseif(isset($_GET['changestate'])){
		  $getstateid = $_GET['changestate'];
		  $querygetstate = $db->query("SELECT * from state WHERE stateid = '$getstateid' ");
     	  $row = $querygetstate->fetch();
          $stnamechnage = $row['statename'];
          $stpimgchange = $row['stateimage'];
          $stptagchange = $row['statetagline']; ?>
		  <div class="dv-form">
          <h2> Update State </h2>
              <form method="post" enctype="multipart/form-data">
                <p><input type="text" name="statechangename" placeholder="Enter State Name" value="<?php echo $stnamechnage; ?>"></p>
                <p><img src="../images/stateimage/<?php echo $stpimgchange; ?>" style=" height:100px;"></p>
                <p><input type="file" name="changeimg" value="<?php echo $stpimgchange; ?>"></p>
                <p><input type="text" name="tagchan" value="<?php echo $stptagchange; ?>"></p>
                <p><input type="submit" value="Chnage" name="chastate"></p>
                <a href="location.php?state"> Cancel </a>
              </form>
              
              <?php
			  	if(isset($_POST['chastate'])){
					$chstname = $_POST['statechangename'];
					$chstimg = $_FILES['changeimg']['name'];
					$chstimgtmp = $_FILES['changeimg']['tmp_name'];
					$targetchangesta = '../images/stateimage/'.$chstimg;					
					$tagchan = $_POST['tagchan'];
					$date = date('d M Y');
					$queryupdate = $db->exec("UPDATE state SET statename='$chstname', stateimage='$chstimg', statetagline='$tagchan', statedate='$date' WHERE stateid = '$getstateid' ");
					if(isset($queryupdate)){
						move_uploaded_file($chstimgtmp,$targetchangesta);
						echo "<script>location.assign('location.php?state')</script>";
					}
					else{ echo "Sorry Can not Update"; }
				}
			  ?>
              
          </div>
		  <?php
	  }
    elseif(isset($_GET['city'])){ ?>
<div class="fulldv title_with_button"> 
    <a href="location.php" class="see-button see-blue">Add Country</a>
    &nbsp;&nbsp;&nbsp;
    <a href="location.php?state" class="see-button see-blue">Add State</a> 
    &nbsp;&nbsp;&nbsp;
    <h3>City</h3>
</div>

<div class="country"> 
  
        <?php
	       if(isset($_POST['addcity'])){ 
		        $stateid = $_POST['state'];
		        $ctyname = $_POST['ctname'];
				/*$ctyimg = $_FILES['ctimg']['name'];
				$tempimg = $_FILES['ctimg']['tmp_name'];
				$target = '../images/cityimage/'.$ctyimg;
				$ctytagline = $_POST['cttag'];*/
				$date = date('d - M - Y');
				$duplicate = $db->prepare("SELECT COUNT(cityname) FROM city WHERE cityname= :ctyname ");
					 $duplicate->bindParam(':ctyname',$ctyname);
					 $duplicate->execute();
					 $getcat = $duplicate->fetchColumn();
					 if($getcat > 0){ echo "This City Already Exists"; }
					 /*elseif(file_exists('../images/cityimage/'.$_FILES['ctimg']['name'])){echo "This image Already Exists";}*/
					 else{
						  $insertquery = $db->prepare("INSERT INTO city(stid,cityname,citydate)VALUES(:stateid,:ctyname,:date)");
						  $insertquery->bindParam(':stateid',$stateid);
						  $insertquery->bindParam(':ctyname',$ctyname);
						  $insertquery->bindParam(':date',$date); 
						  if($insertquery->execute()){
										  /*move_uploaded_file($tempimg,$target);*/
					      }
				        else{
					   	     echo "Not Add";
				         }
			        }
		      }
  ?>	
  <div class="clear"></div>
        
        <div class="dv-form">
            <form method="post" enctype="multipart/form-data">
                <select name="state" required>
                    <option value="" hidden="hidden">Select State</option>
                    <option value="">Delhi</option>
                </select>
                <p>City Name</p>
                <input type="text" name="ctname" required/>
                <input type="submit" name="addcity" value="Add City"/>
            </form>
        </div>
        
        
		<div class="add-imag-dv">
            <div class="col-md-3 add-imag-dv-in_out">
                <div class="fulldv add-imag-dv-in">
                    <p>India</p>
                    <img src="../images/themes/theme1.jpg" alt=""/>
                    <p>Start Vacation From Here</p> 
                    <a href="#" class="see-button see-blue">Edit</a>
                </div>
            </div>
            <div class="col-md-3 add-imag-dv-in_out">
                <div class="fulldv add-imag-dv-in">
                    <p>India</p>
                    <img src="../images/themes/theme1.jpg" alt=""/>
                    <p>Start Vacation From Here</p> 
                    <a href="#" class="see-button see-blue">Edit</a>
                </div>
            </div>
            <div class="col-md-3 add-imag-dv-in_out">
                <div class="fulldv add-imag-dv-in">
                    <p>India</p>
                    <img src="../images/themes/theme1.jpg" alt=""/>
                    <p>Start Vacation From Here</p> 
                    <a href="#" class="see-button see-blue">Edit</a>
                </div>
            </div>
            <div class="col-md-3 add-imag-dv-in_out">
                <div class="fulldv add-imag-dv-in">
                    <p>India</p>
                    <img src="../images/themes/theme1.jpg" alt=""/>
                    <p>Start Vacation From Here</p> 
                    <a href="#" class="see-button see-blue">Edit</a>
                </div>
            </div>
        </div>
        
        </div>
		
		
<?php } 
	elseif(isset($_GET['changecity'])){
		$changecityid = $_GET['changecity'];
		$querycitygat = $db->query("SELECT * FROM city WHERE cityid = '$changecityid' LIMIT 1");
		$queryc = $querycitygat->fetch();
		$citynameget = $queryc['cityname']; ?>
		<div class="add-imag-dv">
        <form action="" method="post">
        	<input type="text" name="changecityname" value="<?php echo $citynameget; ?>">
            <input type="submit" name="changecity" value="Change">
        </form>
        <a href="location.php?city"> Cancel </a>
        </div>
        
	<?php
		if(isset($_POST['changecity'])){
			$citygeid = $changecityid;
			$valnamecity = $_POST['changecityname'];
			$upcityqu = $db->query("UPDATE city SET cityname = '$valnamecity' WHERE cityid = '$citygeid' ");
			if(isset($upcityqu)){ echo "<script>location.assign('location.php?city')</script>"; }
			else{ echo "Sorry We can not update"; }
		}
	}
	else{ ?>
 
 <div class="fulldv title_with_button">
 	<h3>Country</h3>
    &nbsp;&nbsp;&nbsp;
    <a href="location.php?state" class="see-button see-blue">Add State</a>
    &nbsp;&nbsp;&nbsp;
    <a href="location.php?city" class="see-button see-blue">Add City</a>
 </div>
 
    								
<div class="country">
 
	<?php
	    if(isset($_POST['addcountry'])){ 
		        $cotryname = $_POST['couname'];
				$cotryimg = $_FILES['couimg']['name'];
				$tempimg = $_FILES['couimg']['tmp_name'];
				$target = '../images/countryimage/'.$cotryimg;
				$date = date('d - M - Y');
				$duplicate = $db->prepare("SELECT COUNT(countryname) FROM country WHERE countryname= :cotryname ");
					 $duplicate->bindParam(':cotryname',$cotryname);
					 $duplicate->execute();
					 $getcat = $duplicate->fetchColumn();
					 if($getcat > 0){ echo "This Country Already Exists"; }
					 elseif(file_exists('../images/countryimage/'.$_FILES['couimg']['name'])){echo "This file Already Exists";}
					 else{
						  $insertquery = $db->prepare("INSERT INTO country(countryname,countryimage,countrydate)VALUES(:cotryname,:cotryimg,:date)");
						  $insertquery->bindParam(':cotryname',$cotryname);
						  $insertquery->bindParam(':cotryimg',$cotryimg);
						  $insertquery->bindParam(':date',$date); 
						  if($insertquery->execute()){
										  move_uploaded_file($tempimg,$target);
					      }
				        else{
					   	     echo "Not Add";
				         }
			        }
		      }
  ?>	
  
<div class="clear"></div>
      <div class="dv-form">
          <form method="post" enctype="multipart/form-data">
            <p>Country Name</p>
            <input type="text" name="couname" required/>
            <p>Country Image</p>
            <input type="file" name="couimg" required>
            <input type="submit" name="addcountry" value="Add Country"/>
          </form>
      </div>

      <div class="fulldv add-imag-dv">
        <div class="col-md-2 add-imag-dv-in_out">
          <div class="fulldv add-imag-dv-in">
              <p>DUBAI</p>
              <img src="../images/themes/theme1.jpg" alt=""/> 
              <a href="#" class="see-button see-blue">Edit</a>
          </div>
        </div>
        <div class="col-md-2 add-imag-dv-in_out">
          <div class="fulldv add-imag-dv-in">
              <p>DUBAI</p>
              <img src="../images/themes/theme1.jpg" alt=""/> 
              <a href="#" class="see-button see-blue">Edit</a>
          </div>
        </div>
        <div class="col-md-2 add-imag-dv-in_out">
          <div class="fulldv add-imag-dv-in">
              <p>DUBAI</p>
              <img src="../images/themes/theme1.jpg" alt=""/> 
              <a href="#" class="see-button see-blue">Edit</a>
          </div>
        </div>
        <div class="col-md-2 add-imag-dv-in_out">
          <div class="fulldv add-imag-dv-in">
              <p>DUBAI</p>
              <img src="../images/themes/theme1.jpg" alt=""/> 
              <a href="#" class="see-button see-blue">Edit</a>
          </div>
        </div>
        <div class="col-md-2 add-imag-dv-in_out">
          <div class="fulldv add-imag-dv-in">
              <p>DUBAI</p>
              <img src="../images/themes/theme1.jpg" alt=""/> 
              <a href="#" class="see-button see-blue">Edit</a>
          </div>
        </div>
        <div class="col-md-2 add-imag-dv-in_out">
          <div class="fulldv add-imag-dv-in">
              <p>DUBAI</p>
              <img src="../images/themes/theme1.jpg" alt=""/> 
              <a href="#" class="see-button see-blue">Edit</a>
          </div>
        </div>    
    </div>	
</div>
<?php } ?>
        </div>
        
    </div>
</div>
  


</div>

<script src="<?php echo $url; ?>js/slick.js" type="text/javascript"></script>
<script src="<?php echo $url; ?>js/custom.js" type="text/javascript"></script>




</body>
</html>
