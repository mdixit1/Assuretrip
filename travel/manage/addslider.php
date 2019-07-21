<?php
session_start();
include('../connection/index.php');

if(isset($_SESSION['amail']) && isset($_SESSION['aid']) && isset($_SESSION['apass'])){
	$recaid = $_SESSION['aid'];
	$recmail = $_SESSION['amail'];
	$recpass = $_SESSION['apass'];	
	$userdetail = $db->prepare("SELECT * FROM manage WHERE manageid =:recaid AND manage_email=:recmail AND manage_password = :recpass");
	$userdetail->bindParam(':recaid',$recaid);
	$userdetail->bindParam(':recmail',$recmail);
	$userdetail->bindParam(':recpass',$recpass);
	$userdetail->execute();
	$userd = $userdetail->fetchAll();
	if(count($userd)){
		foreach($userd as $usr){
			$recname = $usr['manage_name'];
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title> Add Slider Image </title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="<?php echo $url; ?>css/font-awesome.min.css" type="text/css" rel="stylesheet"/>
<link href="<?php echo $url; ?>/css/bootstrap.min.css" type="text/css" rel="stylesheet"/>
<link href="css/styleplus.css" type="text/css" rel="stylesheet"/>
<link href="css/responsive-manage.css" type="text/css" rel="stylesheet"/>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="<?php echo $url; ?>js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/index.js"></script>
<script>
function checkDelete(){
    return confirm('Are you sure?');
}
</script>

</head>
<body>

<?php include('aheader.php'); ?>
	
<div class="slidebody see-trans5s">    
<div class="fulldv adminbody">
	<?php include('topheader.php'); ?>
 <div class="section">
   <div class="fulldv">
     

  <?php
  if(isset($_GET['editimg'])){
		$slid = $_GET['editimg'];
		$getname = $db->prepare("SELECT slider_img FROM sliderimage WHERE slider_id=:slid ");
		$getname->bindParam(':slid',$slid);
		$getname->execute();
		$data = $getname->fetch();
		$imgname = $data['slider_img'];
?>
<div class="overlaydv slider_edit">
<div class="overlaydv-in">
<div class="overlaydv-inner">
	<div class="col-md-4 center-block p20 sliderform">
        <form method="post" enctype="multipart/form-data">
            <div class="fulldv">
                <a href="addslider.php">&times;</a>
                <h4>Change Slider Image</h4>
                <p>Image</p>
                <img src="../images/sliderimg/<?php echo $imgname;?>" height="80px">
                <p>Change Image</p>
                <input type="file" name="newimg" required>
                <input type="submit" name="editimage" value="Edit Image" class="backblue see-trans5s">
            </div>
        </form>
    </div>
</div>
</div>
</div>
    

    <?php
	   	  if(isset($_POST['editimage'])){
				$sldrid = $_GET['editimg'];
				$newimg = $_FILES['newimg']['name'];
				$newimgtype = pathinfo($newimg,PATHINFO_EXTENSION);
				$chname = "slider".uniqid().".".$newimgtype;
				$newtemp = $_FILES['newimg']['tmp_name'];
				$needheight = 300;
				$needwidth = 300;
				$filetarget = '../images/sliderimg/'.$chname;
				list($width,$height) = getimagesize($tempimg);
				  $updateimg = $db->prepare("UPDATE sliderimage SET slider_img=:chname WHERE slider_id=:sldrid");
				  $updateimg->bindParam(':chname',$chname);
				  $updateimg->bindParam(':sldrid',$sldrid);
				  $data = $updateimg->execute();
				  if($data){
							move_uploaded_file($newtemp,$filetarget);
							unlink('../images/sliderimg/'.$imgname);
							echo "<script>location.assign('addslider.php')</script>";
				  }
				  else{
						echo "Not Updated";
				  }
		     }
		 } 	 
  else{		 
	 
 if(isset($_POST['submit'])){
	 	$type = $_POST['sltype'];
	    $slimg = $_FILES['sldrimg']['name'];
		$tempimg = $_FILES['sldrimg']['tmp_name'];
		$imgtype = pathinfo($slimg,PATHINFO_EXTENSION);
		$newname = "slider".uniqid().'.'.$imgtype;
		$filetarget = '../images/sliderimg/'.$newname;
		$date = date('d-M-Y');
		 $insertdata = $db->prepare("INSERT INTO sliderimage(type,slider_img,slider_date)VALUES(:type, :newname,:date)");
		 $insertdata->bindParam(':type',$type);
		 $insertdata->bindParam(':newname',$newname);
		 $insertdata->bindParam(':date',$date);
		 $query = $insertdata->execute();
		 if($query){
					move_uploaded_file($tempimg,$filetarget);
		 }
		 else{
				echo "File Not Uploaded";
		 }
 }
?>		
<div class="fulldv p20 sliderform">
	<form method="post" enctype="multipart/form-data"> 
        <div class="col-md-3">
        <p>Slider Type</p>
        <select name="sltype" id="" required/>
            <option value="" hidden="hidden">Select Type</option>
            <option value="0">Wholesale</option>
            <option value="1">Retailer</option>
        </select>
        </div>
        <div class="col-md-4">
        <p>Upload Image</p>
        <input type="file" name="sldrimg" required>
        </div>
        <div class="col-md-4">
        <input type="submit" name="submit" value="Submit" class="backblue see-trans5s">
        </div>
    </form>
</div>

<div class="fulldv p20">
    <div class="col-md-6 slidertable">
    	<h3>Wholesale Slider</h3>
        <table class="see-table see-table-each">
            <tr class="bluetr">
                <td>S.No</td>
                <td>Image</td>
                <td>Edit/Delete</td>
            </tr>
            <?php
                $sno = "0";
                $tabledata = $db->prepare("SELECT * FROM sliderimage WHERE type='0' ORDER BY slider_id DESC");
                $tabledata->execute();
                $alldata = $tabledata->fetchAll();
                if(count($alldata)){
                  foreach($alldata as $all){
                        $imgid = $all['slider_id'];
                        $img = "<img src='../images/sliderimg/".$all['slider_img']."' height='50px'>";
                        $slurl = $all['slider_url'];
                        $cont = $all['slider_content'];
                        $sno++;  ?>
            <tr>
                <td><?php echo $sno; ?></td>
                <td><?php echo $img; ?></td>
                <td>
                	<a href="addslider.php?editimg=<?php echo $imgid;?>" class="catedit"><i class="fa fa-pencil"></i> </a> &nbsp; &nbsp;
                    <a href="addslider.php?delsl=<?php echo $imgid;?>" onClick='return checkDelete()' class="catdelete"><i class="fa fa-trash"></i></a>
                </td>
            </tr>   
           <?php } } else{ echo "Images Are Not Availabe"; } ?>    
        </table>
    </div>
    
    <div class="col-md-6 slidertable">
    	<h3>Retailer Slider</h3>
        <table class="see-table see-table-each">
            <tr class="bluetr">
                <td>S.No</td>
                <td>Image</td>
                <td>Edit/Delete</td>
            </tr>
            <?php
                $sno = "0";
                $tabledata = $db->prepare("SELECT * FROM sliderimage WHERE type='1' ORDER BY slider_id DESC");
                $tabledata->execute();
                $alldata = $tabledata->fetchAll();
                if(count($alldata)){
                  foreach($alldata as $all){
                        $imgid = $all['slider_id'];
                        $img = "<img src='../images/sliderimg/".$all['slider_img']."' height='50px'>";
                        $slurl = $all['slider_url'];
                        $cont = $all['slider_content'];
                        $sno++;  ?>
            <tr>
                <td><?php echo $sno; ?></td>
                <td><?php echo $img; ?></td>
                <td>
                	<a href="addslider.php?editimg=<?php echo $imgid;?>" class="catedit"><i class="fa fa-pencil"></i> </a> &nbsp; &nbsp;
                    <a href="addslider.php?delsl=<?php echo $imgid;?>" onClick='return checkDelete()' class="catdelete"><i class="fa fa-trash"></i></a>
                </td>
            </tr>   
           <?php } } else{ echo "Images Are Not Availabe"; } ?>    
        </table>
    </div>
</div>



<?php
	 if(isset($_GET['delsl'])){
			$slid = $_GET['delsl'];
			$getimage = $db->query("SELECT slider_img FROM sliderimage WHERE slider_id='$slid'");
			$getimg = $getimage->fetch();
			$image = $getimg['slider_img'];
			$changestatus = $db->prepare("DELETE FROM sliderimage WHERE slider_id=:slid ");
			$changestatus->bindParam(':slid',$slid);
			$result = $changestatus->execute();
			if($result){
				 	    unlink('../images/sliderimg/'.$image);
						echo "<script>location.assign('addslider.php')</script>";
			}
			else{ echo "Not Change"; }
	 }
 } 
 ?>
                    
                
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
else{ echo "<script>location.assign('logout.php')</script>"; }
?> 