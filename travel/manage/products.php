 <?php
//error_reporting(0);
session_start();
include('../connection/index.php');
$recaid = $_SESSION['aid'];
$recmail = $_SESSION['amail'];
$recpass = $_SESSION['apass'];
if(isset($_SESSION['amail']) && isset($_SESSION['aid']) && isset($_SESSION['apass'])){
	$userdetail = $db->prepare("SELECT * FROM manage WHERE manageid =:recaid AND manage_email=:recmail AND manage_password = :recpass");
	$userdetail->bindParam(':recaid',$recaid);
	$userdetail->bindParam(':recmail',$recmail);
	$userdetail->bindParam(':recpass',$recpass);
	$userdetail->execute();
	$userd = $userdetail->fetchAll();
	if(count($userd)){
		foreach($userd as $usr){
			$recname = $usr['manage_name'];
if(isset($_GET['cate'])){
	$_SESSION['ctname'] = $catename = $_GET['cate'];
	$_SESSION['sctname'] = $scatename = $_GET['scate'];
?>	

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Add Products</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="<?php echo $url; ?>css/font-awesome.min.css" type="text/css" rel="stylesheet"/>
<link href="<?php echo $url; ?>/css/bootstrap.min.css" type="text/css" rel="stylesheet"/>
<link href="css/styleplus.css" type="text/css" rel="stylesheet"/>
<link href="css/responsive-manage.css" type="text/css" rel="stylesheet"/>
<script src="<?php echo $url; ?>js/jquery-2.1.3.min.js" type="text/javascript"> </script>
<script src="<?php echo $url; ?>js/bootstrap.min.js" type="text/javascript"></script>
<script type="text/javascript" src="jquery-3.1.1.min.js"></script> 
<script src="js/index.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="jquery.form.js"></script>
<script type="text/javascript">

function checkDelete(){
    return confirm('Are you sure?');
}

function onlydigit(input){

	var digit = /[^0-9]/g;

	input.value = input.value.replace(digit,"");

}

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

</script>
</head>
<body>
<?php include('aheader.php'); ?>
<div class="slidebody see-trans5s">
    <?php include('topheader.php'); ?>

<div class="fulldv adminbody">

<div class="fulldv subcate">
    <ul>
		<?php if(isset($_GET['scate'])){ ?>
        <li>
            <a href="categories.php"><?php echo $catename; ?> </a>
        </li>
        <li>
            <a href="categories.php?cat=<?php echo $catename; ?>"><?php echo $scatename; ?></a>
        </li>
        <?php } ?>
    </ul>
</div>

<?php 
if(isset($_GET['scate'])){ 

if(isset($_GET['edit'])){
	$pdctid = $_GET['edit'];	
	$prdctdetail = $db->prepare("SELECT * FROM products WHERE productid=:pdctid");
	$prdctdetail->bindParam(':pdctid',$pdctid);
	$prdctdetail->execute();
	$alldetail = $prdctdetail->fetch();
	$pdname = $alldetail['productname'];
	$pddisc = $alldetail['product_description'];
 	if($alldetail['ptype']=='1'){
		$ptval = "On Sale";
	}
	else{
		$ptval = "Fresh Arrival";	
	}

  if(isset($_POST['addproduct'])){
	$newtype = $_POST['nptype'];  
	$newname = addslashes($_POST['newname']);
	$psurl = str_replace(' ', '-', $newname);
	$without_special_char = preg_replace('/[^a-zA-Z0-9_ -]/s', '', $psurl);
	$finalprurl = strtolower($without_special_char);
	$newdiscription = addslashes($_POST['newdisc']);
	$updatedetail = $db->exec("UPDATE products SET ptype='$newtype', productname='$newname', product_url='$finalprurl',  product_description='$newdiscription' WHERE productid='$pdctid' ");
	if(isset($updatedetail)){ ?>
    		 <script>location.assign('products.php?cate=<?php echo $catename;?>&scate=<?php echo $scatename; ?>')</script>;
       
<?php } else{
		echo "Not updated";
	}
  }
}
else{
if(isset($_POST['addproduct'])){
	$ptp = $_POST['ptype'];
	$cid = $_POST['catgyid'];
	$sid = $_POST['scatgyid'];
	$pname = stripslashes($_POST['pname']);
	$caturl = str_replace(' ', '-', $pname);
	$without_special_char = preg_replace('/[^a-zA-Z0-9_ -]/s', '', $caturl);
	$finalprurl = strtolower($without_special_char);
	$pdiscription = stripslashes($_POST['disc']);
	$date = date('d - M - Y');
	$insertcat=$db->prepare("INSERT INTO products(ptype,pcatid,pscatid,productname,product_url,product_description,product_date)VALUES(:ptp, :cid, :sid, :pname,:finalprurl, :pdiscription, :date)");
	$insertcat->bindParam(':ptp', $ptp);
	$insertcat->bindParam(':cid', $cid);
	$insertcat->bindParam(':sid', $sid);
	$insertcat->bindParam(':pname', $pname);
	$insertcat->bindParam(':finalprurl', $finalprurl);
	$insertcat->bindParam(':pdiscription', $pdiscription);
	$insertcat->bindParam(':date', $date);
	$insert = $insertcat->execute();
	if(isset($insert)){ ?>
			 <script>location.assign('products.php?cate=<?php echo urlencode($catename);?>&scate=<?php echo urlencode($scatename);?>')</script>;
 <?php } 
	else{
		echo "Not Added";	
	}
} 
}
?>
<div class="fulldv">
    <div class="fulldv addproduct">
    <div class="col-md-12">
    	<h2>Add Products</h2>
    </div>
    <form method="post">
    <?php
        $getcategoryid = $db->prepare("SELECT categoryid FROM category WHERE category_url=:catename");
		$getcategoryid->bindParam(':catename',$catename);
		$getcategoryid->execute();
        $onlyctid = $getcategoryid->fetch();
        $getctid = $onlyctid['categoryid'];
            $getscategoryid = $db->prepare("SELECT subcategoryid FROM subcategory WHERE subcategory_url=:scatename AND cateid=:getctid");
			$getscategoryid->bindParam(':scatename',$scatename);
			$getscategoryid->bindParam(':getctid',$getctid);
			$getscategoryid->execute();
            $onlysctid = $getscategoryid->fetch();
            $getsctid = $onlysctid['subcategoryid'];
    ?>
    <div class="fulldv">
    	<?php 
		if(isset($_GET['edit'])){ ?>
        <div class="col-md-3">
        	<select name="nptype" id="">
              <?php if($alldetail['ptype']=='0'){ ?>
            	<option value="" hidden="hidden">Select Type</option>
              <?php } else { ?>
              	<option value="<?php echo $alldetail['ptype']; ?>" hidden="hidden"><?php echo $ptval; ?></option>
              <?php } ?>  
                <option value="1">Wholesale</option>
                <option value="2">Retailers</option>
            </select>
        </div>
        <div class="col-md-6">
        <input type="text" name="newname" id="pname" placeholder="Enter Product Name" value="<?php echo $pdname; ?>" required/>
        </div>
        <div class="col-md-9">
    	<textarea name="newdisc" id="discount" placeholder="Enter Discription" required><?php echo $pddisc; ?></textarea>
  		</div>
        <?php } 
		else{ ?>
        <div class="col-md-3">
        	<select name="ptype" id="">
            	<option value="" hidden="hidden">Select Type</option>
                <option value="1">Wholesale</option>
                <option value="2">Retailers</option>
            </select>
        </div>
        <div class="col-md-6">
        <input type="text" name="catgyid" id="catgyid" hidden="hidden" value="<?php echo $getctid; ?>"/>
        </div>
        <div class="col-md-6">
        <input type="text" name="scatgyid" id="scatgyid" hidden="hidden" value="<?php echo $getsctid; ?>"/>
        </div>
        <div class="col-md-6">
        <input type="text" name="pname" id="pname" placeholder="Enter Product Name" required/>
        </div>
        <!--<div class="see-2 see-xm-12">
        <input type="text" name="pprice" id="pname" placeholder="Enter Product Price" onKeyUp="onlydigit(this)" required/>
        </div>
        <div class="see-2 see-xm-12">
        <input type="text" name="dpprice" id="dpname" placeholder="Enter Discount Price" onKeyUp="onlydigit(this)" />
        </div>-->
        </div>
        <div class="col-md-9">
        <textarea name="disc" id="discount" placeholder="Enter Discription"></textarea>
        </div>
    <?php } ?>
    <div class="clear"></div>
    <div class="col-md-3">
    <input type="submit" name="addproduct" value="Add" class="btn-blue"> 
    </div>
    <div class="clear"></div>
    </form>
    </div>
</div>
<?php } 

?>

<div class="pdetail">
<?php 
if(isset($_GET['scate'])){ 

?>

<div class="fulldv">  
	<ul class="nav nav-tabs protab">
      <li class="active"><a data-toggle="tab" href="#onsale">Wholesale Products</a></li>
      <li><a data-toggle="tab" href="#fresh">Retailers Products</a></li>
    </ul>
</div>
<div class="fulldv">
	<div class="tab-content">
      <div id="onsale" class="tab-pane fade in active">
			<?php
               $getproduct = $db->prepare("SELECT * FROM products WHERE pcatid=:getctid AND pscatid=:getsctid AND ptype='1' ORDER BY productid DESC");
               $getproduct->bindParam(':getctid', $getctid);
               $getproduct->bindParam(':getsctid', $getsctid);
               $getproduct->execute();
               $data = $getproduct->fetchAll();
               if(count($data)){
            ?>
             <div class="fulldv p20 cattable" style="padding-top:0 !important;">
                    <table class="see-table see-table-each">
                        <tr class="bluetr">
                            <td>Product Name</td>
                            <td>Date</td>
                            <td>Edit/Delete</td>
                            <td>More</td>
                        </tr>
                        <?php
                           foreach($data as $all){
                               $prid = $all['productid'];
                               $prname = $all['productname'];
                               $prdisc = $all['product_description'];
                               $pdate = $all['product_date'];
                        ?>
                            <tr>
                                <td><?php echo $prname; ?></td>
                                <td><?php echo $pdate; ?></td>
                                
                                <td>
                                    <a href="products.php?cate=<?php echo $catename; ?>&scate=<?php echo $scatename; ?>&edit=<?php echo $prid; ?>">
                                        <span class="catedit"><i class="fa fa-edit"></i></span>
                                    </a>&nbsp;
                                    <a href="products.php?cate=<?php echo $catename; ?>&scate=<?php echo $scatename; ?>&delproduct=<?php echo $prid; ?>" onClick='return checkDelete()'>
                                        <span class="catdelete"><i class="fa fa-trash"></i></span>
                                    </a>
                                </td>
                                <td>
                                    <a href="moredetail.php?cate=<?php echo $catename; ?>&scate=<?php echo $scatename; ?>&pid=<?php echo $prid; ?>&image">
                                        <button type="button" class="btn-more">More</button>
                                    </a>
                                </td>
                            </tr>
                             
                        <?php } ?>
                 </table>
                </div>
            <?php } ?> 
      </div>
      <div id="fresh" class="tab-pane fade">
			<?php
               $getproduct = $db->prepare("SELECT * FROM products WHERE pcatid=:getctid AND pscatid=:getsctid AND ptype='2' ORDER BY productid DESC");
               $getproduct->bindParam(':getctid', $getctid);
               $getproduct->bindParam(':getsctid', $getsctid);
               $getproduct->execute();
               $data = $getproduct->fetchAll();
               if(count($data)){
            ?>				       
             <div class="fulldv p20 cattable" style="padding-top:0 !important;">
                    <table class="see-table see-table-each">
                        <tr class="bluetr">
                            <td>Product Name</td>
                            <td>Date</td>
                            <td>Edit/Delete</td>
                            <td>More</td>
                        </tr>
                        <?php
                           foreach($data as $all){
                               $prid = $all['productid'];
                               $prname = $all['productname'];
                               $prdisc = $all['product_description'];
                               $pdate = $all['product_date'];
                        ?>
                            <tr>
                                <td><?php echo $prname; ?></td>
                                <td><?php echo $pdate; ?></td>
                                
                                <td>
                                    <a href="products.php?cate=<?php echo $catename; ?>&scate=<?php echo $scatename; ?>&edit=<?php echo $prid; ?>">
                                        <span class="catedit"><i class="fa fa-edit"></i></span>
                                    </a>&nbsp;
                                    <a href="products.php?cate=<?php echo $catename; ?>&scate=<?php echo $scatename; ?>&delproduct=<?php echo $prid; ?>" onClick='return checkDelete()'>
                                        <span class="catdelete"><i class="fa fa-trash"></i></span>
                                    </a>
                                </td>
                                <td>
                                    <a href="moredetail.php?cate=<?php echo $catename; ?>&scate=<?php echo $scatename; ?>&pid=<?php echo $prid; ?>&image">
                                        <button type="button" class="btn-more">More</button>
                                    </a>
                                </td>
                            </tr>
                             
                        <?php } ?>
                 </table>
                </div>  
            <?php } ?>
      </div>
    </div>
</div>

   
<?php } 
?>

</div>
 
<?php 
if(isset($_GET['delproduct'])){
		$delprid = $_GET['delproduct'];
		$deleteproduct = $db->prepare("DELETE FROM products WHERE productid=:delprid ");
		$deleteproduct->bindParam(':delprid',$delprid);
		$deleteproduct->execute();
		if($deleteproduct){
				
		$searchimg = $db->prepare("SELECT productimage FROM productimage WHERE prodctid=:delprid ");
		$searchimg->bindParam(':delprid',$delprid);
		$searchimg->execute();
		$allimg = $searchimg->fetchAll();
		foreach($allimg as $getall){
		$images = $getall['productimage'];	
		$deletepimages = $db->prepare("DELETE FROM productimage WHERE prodctid=:delprid ");
		$deletepimages->bindParam(':delprid',$delprid);
		$deletepimages->execute();
		  if($deletepimages){
			 unlink('../images/productimage/'.$images);
			 unlink('../images/productimage/265_320/'.$images);
			 unlink('../images/productimage/60_60/'.$images);
			 
			 if(isset($_GET['scate'])){
				 echo "<script>location.assign('products.php?cate=".urlencode($catename)."&scate=".urlencode($scatename)."')</script>";
			 }
			 else{
				 echo "<script>location.assign('products.php?cate=".urlencode($catename)."')</script>";
			 }
		  }
		  else{
			  if(isset($_GET['scate'])){
				 echo "<script>location.assign('products.php?cate=".urlencode($catename)."&scate=".urlencode($scatename)."')</script>";
			 }
			 else{
				 echo "<script>location.assign('products.php?cate=".urlencode($catename)."')</script>";
			 }
			  
		  }
		  
			}
			
					
		if(isset($_GET['scate'])){
				 echo "<script>location.assign('products.php?cate=".urlencode($catename)."&scate=".urlencode($scatename)."')</script>";
			 }
			 else{
				 echo "<script>location.assign('products.php?cate=".urlencode($catename)."')</script>";
			 }	
		}
	  }
?>	  
</div>
</div>
</body>
</html>
<?php } }
	}
	else{ echo "<script>location.assign('logout.php')</script>"; }
}
else{ echo "<script>location.assign('logout.php')</script>"; }
?> 