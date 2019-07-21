<?php
error_reporting(0);
session_start();
include('../function.php');
include('../connection/index.php');
$recaid = $_SESSION['aid'];
$recmail = $_SESSION['amail'];
$recpass = $_SESSION['apass'];	
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
if(isset($_GET['cat'])){
$_SESSION['ctname'] = $_GET['cat'];
}			
if(isset($_POST['saverecord'])){
	$catname = stripslashes($_POST['cate']);
	$caturl = str_replace(' ', '-', $catname);
	$without_special_char = preg_replace('/[^a-zA-Z0-9_ -]/s', '', $caturl);
	$final = strtolower($without_special_char);
	if($catname){
		$date = date('d - M - Y');
		$checkname = $db->prepare("SELECT count(categoryname) FROM category WHERE categoryname= :catname");
		$checkname->bindParam(':catname' , $catname);
		$checkname->execute();
		if($checkname->fetchColumn() > 0 ){
					echo "category already exists";
			}
			else{
				$insertcat=$db->prepare("INSERT INTO category(categoryname,category_url,categorydate)VALUES(:catname, :final, :date)");
				$insertcat->bindParam(':catname', $catname);
				$insertcat->bindParam(':final', $final);
				$insertcat->bindParam(':date', $date);
				$insertcat->execute();
		}
	}
	echo 3;
	exit();
}
if(isset($_POST['show'])){ ?>
<?php
   $getcat = $db->prepare("SELECT * FROM category ORDER BY categoryid DESC");
   $getcat->execute();
   $data = $getcat->fetchAll();
   foreach($data as $all){
	   $catid = $all['categoryid'];
	   $catname = $all['categoryname'];
?>
 	  <div class="showta">	
		<div class="show">
			<?php echo $catname; ?> 
		</div>
   </div> 
   <?php }
   exit();
} 


if(isset($_POST['savesub'])){
	$getctid = $_POST['ctid'];
	$subcatname = stripslashes($_POST['subcate']);
	$scaturl = str_replace(' ', '-', $subcatname);
	$without_special_char = preg_replace('/[^a-zA-Z0-9_ -]/s', '', $scaturl);
	$finals = strtolower($without_special_char);
	if($subcatname){
		$checkname = $db->prepare("SELECT count(subcategoryname) FROM subcategory WHERE subcategoryname= :subcatname AND cateid=:getctid ");
		$checkname->bindParam(':subcatname' , $subcatname);
		$checkname->bindParam(':getctid' , $getctid);
		$checkname->execute();
		if($checkname->fetchColumn() > 0 ){
					$duplicate = "subcategory already exists";
			}
			else{
				$insertsubcat=$db->prepare("INSERT INTO subcategory(cateid,subcategoryname,subcategory_url,subcategorydate)VALUES(:getctid, :subcatname, :finals, :date)");
				$insertsubcat->bindParam(':getctid', $getctid );
				$insertsubcat->bindParam(':subcatname', $subcatname);
				$insertsubcat->bindParam(':finals', $finals);
				$insertsubcat->bindParam(':date', $date);
				$insertsubcat->execute();
		     }
	    }
	echo 3;
	exit();
}
if(isset($_POST['shows'])){ ?>
<?php
   $ctename = $_SESSION['ctname'];
   $searchcid = $db->query("SELECT categoryid FROM category WHERE category_url='$ctename' ");
   $cteid = $searchcid->fetch();
   $ctegid = $cteid['categoryid'];
   
   $getcat = $db->prepare("SELECT * FROM subcategory WHERE cateid='$ctegid' ORDER BY subcategoryid DESC");
   $getcat->execute();
   $data = $getcat->fetchAll();
   foreach($data as $all){
	   $subcatid = $all['subcategoryid'];
	   $subcatname = $all['subcategoryname'];
?>
   <div class="showta">	
	<div class="show">
			<?php echo $subcatname; ?> 
			<div class="deleteclass" id='<?php // echo $subcatname ; ?>'>  
			<!--<span class="action"><a href="#" id="<?php // echo $subcatid;?>" class="remove" title="Delete">Delete</a></span>  -->
			</div>
		</div> 
   </div>
   <?php }
   exit();
} 
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Add Categories</title>
<?php echo headdata(); ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="<?php echo $url; ?>css/font-awesome.min.css" type="text/css" rel="stylesheet"/>
<link href="<?php echo $url; ?>css/bootstrap.min.css" type="text/css" rel="stylesheet"/>
<link href="css/styleplus.css" type="text/css" rel="stylesheet"/>
<link href="css/responsive-manage.css" type="text/css" rel="stylesheet"/>
<script src="<?php echo $url; ?>js/jquery-3.2.1.min.js" type="text/javascript"> </script>
<script src="<?php echo $url; ?>js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/index.js"></script>
<script>
/*
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

$(document).ready(function(e) {
    $("#login-pop , #book-pop").click(function(e) {
        $(".login-popup").fadeIn()
    });
	
	$("#pop-close , .pop-off").click(function(e) {
        $(".login-popup").fadeOut()
    });
});

$(document).ready(function(e) {
    $("#login-pop1 , #book-pop").click(function(e) {
        $(".login-popup").fadeIn()
    });
	
	$("#pop-close , .pop-off").click(function(e) {
        $(".login-popup").fadeOut()
    });
});
*/
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
		<?php 
       if(isset($_GET['cat'])){ 
	   		$ctname = $_GET['cat'];
			$getid = $db->prepare("SELECT categoryid,categoryname,category_url FROM category WHERE category_url=:ctname");
			$getid->bindParam(':ctname',$ctname);
			$getid->execute();
			$onlycid = $getid->fetch();
			$ctid = $onlycid['categoryid'];
			$catnamee = $onlycid['categoryname'];
        ?>
        <div class="fulldv subcate" style="border-bottom:0; padding:0;">
            <a href="categories.php" class="btn-yellow"><?php echo $catnamee; ?></a>
            <span class="arrow-right"><img src="../images/arrow.png" alt=""/></span>
            <input type="button" id="login-pop" value="Add Subcategory" class="btn-blue">
            <span class="arrow-right1" style="width:42px; height:42px; margin:0px 10px; position:relative; box-sizing:border-box; padding:10px;">
        </div>
        
        <div class="overlaydv login-popup">
            <div class="pop-off"></div>
            <div class="overlaydv-in">
                <div class="overlaydv-inner">
                    <div class="log-pop-inner">  
                      <form>
                      <?php if(isset($duplicate)){ echo $duplicate; } ?>
                        <span><a href="categories.php?cat=<?php echo $onlycid['category_url']; ?>">&times;</a></span>
                        <h4>Add Subcategory</h4>
                        <div class="fulldv cattag">
                        <input type="text" name="ctid" id="ctid" hidden="hidden" value="<?php echo $ctid; ?>">
                        <input type="text" name="subcate" id="subcate" placeholder="Enter Subcategory" required/>
                        <button type="button" id="submit1" class="btn-blue">Add</button>
                        </div>
                      </form>
                      <br>
                      <div id="showsub"></div>
                      <div class="clearfix"></div>
                  </div>
                </div>
            </div>
        </div> 
        <div class="see-12 subcategory">
            <h2>Sub Category</h2>
            <div class="col-md-6 p0 cattable">
				<table class="see-table see-table-each">
					<tr class="bluetr">
                    	<th>Sub Category</th>
                    	<th>Edit</th>
                    </tr>
                 <?php
				 	$show_subcat = $db->prepare("SELECT * FROM subcategory WHERE cateid=:ctid");
					$show_subcat->bindParam(':ctid',$ctid);
					$show_subcat->execute();
					$stmt = $show_subcat->fetchAll();
					foreach($stmt as $stm){
				 ?>   
                	<tr>
                    	<td><?php echo $stm['subcategoryname']; ?></td>
                        <td>
                        	<a href="categories.php?cat=<?php echo $ctname; ?>&scdel=<?php echo $stm['subcategoryid']; ?>" id="forgote" onClick="return ckdel();">
                            	<span class="catdelete"><i class="fa fa-trash"></i></span>
                            </a> &nbsp;
                			<a href="categories.php?cat=<?php echo $ctname; ?>&sval=<?php echo $stm['subcategoryid']; ?>" id="forgote">
                            	<span class="catedit">
                                	<i class="fa fa-edit"></i>
                                </span>
                            </a>
                        </td>
                    </tr>
                <?php } ?>    
                </table>
            </div>
            <!--<div class="fulldv">
            	<ul class="pagination pagination-sm">
                    <li class="disabled"><a href="#">&laquo;</a></li>
                    <li class="active"><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li><a href="#">&raquo;</a></li>
                </ul>
                <br><br><br>
            </div>-->
        </div>
    <?php
    if(isset($_GET['scdel'])){
        $sbctid = $_GET['scdel'];
        $delete_sbcat = $db->prepare("DELETE FROM subcategory WHERE subcategoryid=:sbctid");	
        $delete_sbcat->bindParam(':sbctid',$sbctid);
        $delete_sbcat->execute();
        if(isset($delete_sbcat)){ echo "<script>location.assign('categories.php?cat=$ctname')</script>"; }
        
    }
    
    if(isset($_GET['sval'])){ 
       $getscatid = $_GET['sval']; 
       $getscatname = $db->prepare("SELECT cateid,subcategoryname FROM subcategory WHERE subcategoryid=:getscatid");
       $getscatname->bindParam(':getscatid',$getscatid);
       $getscatname->execute();
       $getsname = $getscatname->fetch();
       $ctid = $getsname['cateid'];
       $scname = $getsname['subcategoryname']; ?>
       
    <div class="overlaydv forgote-popup-change">
        <div class="pop-off"></div>
        <div class="overlaydv-in">
            <div class="overlaydv-inner">
                <div class="log-pop-inner">
                <?php if(isset($msg)){ echo $msg; } ?>
                  <form action="" method="post" id="register-form-forgote" novalidate>
                   <span><a href="categories.php?cat=<?php echo $ctname;?>">&times;</a></span>
                    <h4>Edit Sub Category</h4>
                    <div class="fulldv cattag">
                        <input type="text" name="newsctname" value="<?php echo $scname;?>"required/>
                        <input type="submit" name="edits" value="Edit" class="btn-blue"/>
                    </div>
                  </form>
              </div>
            </div>
        </div>
    
    <?php if(isset($_POST['edits'])){
            $newsname = stripslashes($_POST['newsctname']);
            $newscaturl = str_replace(' ', '-', $newsname);
            $without_special_char = preg_replace('/[^a-zA-Z0-9_ -]/s', '', $newscaturl);
            $finalnew = strtolower($without_special_char);
            $changename = $db->prepare("UPDATE subcategory SET subcategoryname=:newsname, subcategory_url=:finalnew WHERE subcategoryid=:getscatid");
            $changename->bindParam(':newsname',$newsname);
            $changename->bindParam(':finalnew',$finalnew);
            $changename->bindParam(':getscatid',$getscatid);
            $changename->execute();
            if(isset($changename)){
                        echo "<script>location.assign('categories.php?cat=$ctname')</script>";	
            }
            $msg = "Category Not Edit";
    
    }
    ?>
    <?php } 
    
     } 
	 	elseif(isset($_GET['img'])){
		?>	
			<form method="post" enctype="multipart/form-data">
            	<input type="file" name="imgcat">
                <input type="submit" name="addimg" name="Submit">
            </form>
		<?php }
        else { ?>
    
      <div class="fulldv category-maindv">
        <div class="see-12 topbox">
            <input type="button" id="login-pop" value="Add Category" class="btn-blue">
        </div>
    
        <div class="overlaydv login-popup">
            <div class="pop-off"></div>
            <div class="overlaydv-in">
                <div class="overlaydv-inner">
                    <div class="log-pop-inner">  
                        <form>
                          <span><a href="categories.php">&times;</a></span>
                          <h4>Add Category</h4>
                          <div class="fulldv cattag">
                              <input type="text" name="cate" id="cate" placeholder="Enter Category" required/>
                              <button type="button" id="submit" class="btn-blue">Add</button>
                          </div>
                        </form>
                        <br>
                        <div id="showdata"></div> 
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
         
  <?php if(!isset($_GET['more'])){ ?>       
         
        <div class="fulldv category">
            <div class="fulldv">
                <h2>Category</h2>
            </div>
           <div class="col-md-10 cattable p0">
               <table class="see-table see-table-each">
                    <tr class="bluetr">
                        <th>Category Name</th>
                        <th>Image</th>
                        <th>Add Image</th>
                        <th>Edit</th>
                    </tr>
                    <?php
                    $getcategory = $db->prepare("SELECT * FROM category ORDER BY categoryid DESC");
                    $getcategory->execute();
                    $allcat = $getcategory->fetchAll();
                    foreach($allcat as $allct){
                         $catid = $allct['categoryid'];
                         $catname = $allct['categoryname'];	
							$checkcat = $db->prepare("SELECT COUNT(subcategoryid) FROM subcategory WHERE cateid=:catid"); 
							$checkcat->bindParam(':catid',$catid);
							$checkcat->execute();
							$chkct = $checkcat->fetchColumn();
                    ?>
                       <tr>
                            <td>
                                <a class="hidelink" href="categories.php?cat=<?php echo $allct['category_url']; ?>">
                                    <button type="button"><?php echo $catname; ?></button>
                                </a>
                            </td>
                            <td>
                            	<img src="../images/category_image/<?php echo $allct['category_image']; ?>" height="50px;" alt="">
                            </td>
                            <td>
                            	<a href="categories.php?more=<?php echo $catid; ?>"><i class="fa fa-edit"></i></a>
                            </td>
                            <td>
							<?php if($chkct > 0){ } else { ?>
                                <a href="categories.php?del=<?php echo $catid; ?>" id="forgote" onClick="return ckdel();">
                                <span class="catdelete">
                                    <i class="fa fa-trash"></i>
                                </span>
                                </a> &nbsp;
                            <?php } ?>
		                       <a href="categories.php?val=<?php echo $catid; ?>" id="forgote">
                                    <span class="catedit">
                                        <i class="fa fa-edit"></i>
                                    </span>
                                </a>
                            </td>
                        </tr>
                   <?php } ?> 
                </table>
           </div>
           <!--<div class="fulldv">
            	<ul class="pagination pagination-sm">
                    <li class="disabled"><a href="#">&laquo;</a></li>
                    <li class="active"><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li><a href="#">&raquo;</a></li>
                </ul>
            </div>-->
            <br><br><br>
        </div>
  <?php } ?>      
    </div>
    <?php } ?>
    
    <?php
    if(isset($_GET['del'])){
        $delctid = $_GET['del'];
		$getdelimg = $db->prepare("SELECT category_image FROM category WHERE categoryid=:delctid");
		$getdelimg->bindParam(':delctid',$delctid);
		$getdelimg->execute();
		$founddel = $getdelimg->fetch();
		$finddel = $founddel['category_image'];
        $deletecate = $db->prepare("DELETE FROM category WHERE categoryid=:delctid");	
        $deletecate->bindParam(':delctid',$delctid);
        $deletecate->execute();
        if(isset($deletecate)){ 
			unlink('../images/category_image/'.$finddel);
			echo "<script>location.assign('categories.php')</script>"; }
        else{ echo "Not deleted"; }
        
    }
	
	if(isset($_GET['delimg'])){
        $delictid = $_GET['delimg'];
		$getdelimg = $db->prepare("SELECT category_image FROM category WHERE categoryid=:delictid");
		$getdelimg->bindParam(':delictid',$delictid);
		$getdelimg->execute();
		$founddel = $getdelimg->fetch();
		$finddel = $founddel['category_image'];
        $deletecate = $db->prepare("UPDATE category SET category_image='' WHERE categoryid=:delictid");	
        $deletecate->bindParam(':delictid',$delictid);
        $deletecate->execute();
        if(isset($deletecate)){ 
			unlink('../images/category/'.$finddel);
			echo "<script>location.assign('categories.php')</script>"; }
        else{ echo "Not deleted"; }
        
    }
    
    if(isset($_GET['val'])){ 
       $getcatid = $_GET['val']; 
       $getcatname = $db->query("SELECT categoryname FROM category WHERE categoryid='$getcatid'");
       $getname = $getcatname->fetch();
       $cname = $getname['categoryname']; ?>
       
    <div class="overlaydv forgote-popup-next">
        <div class="overlaydv-in">
            <div class="overlaydv-inner">
                <div class="log-pop-inner">
                <?php if(isset($msg)){ echo $msg; } ?>
                  <form action="" method="post" id="register-form-forgote" novalidate>
                   <span><a href="categories.php">&times;</a></span>
                    <h4>Edit Category</h4>
                    <div class="fulldv cattag">
                        <input type="text" name="newctname" value="<?php echo $cname;?>"required/>
                        <input type="submit" name="edit" value="Edit" class="btn-blue"/>
                    </div>
                  </form>
              </div>
            </div>
        </div>
    </div>	
    <?php if(isset($_POST['edit'])){
            $newname = stripslashes($_POST['newctname']);
            $newcaturl = str_replace(' ', '-', $newname);
            $without_special_char = preg_replace('/[^a-zA-Z0-9_ -]/s', '', $newcaturl);
            $finalnewc = strtolower($without_special_char);
            $changename = $db->exec("UPDATE category SET categoryname='$newname', category_url='$finalnewc' WHERE categoryid='$getcatid' ");
            if(isset($changename)){
                        echo "<script>location.assign('categories.php')</script>";	
            }
            $msg = "Category Not Edit";
    }
    ?>
    <?php } 
    
    if(isset($_GET['more'])){ 
       $getctid = $_GET['more']; 
       $getimage = $db->query("SELECT category_image FROM category WHERE categoryid='$getctid'");
       $stmt = $getimage->fetch();
       $image = $stmt['category_image'];
    ?>
       
    <div class="forgote-popup-next">
        <div class="pop-off"></div>
        <div class="log-pop">
            <div class="log-pop-in">
                <div class="log-pop-inner">
                <?php if(isset($msg)){ echo $msg; } ?>
                  <form method="post" enctype="multipart/form-data" id="register-form-forgote" novalidate>
                   <span><a href="categories.php" class="see-button see-black see-padding-0">&times;</a></span>
                    <h4>Upload Image</h4>
                    <input type="file" name="img" required/>
                    <input type="submit" name="uploadimg" value="Upload" class="see-button see-green"/>
                  </form>
                  <?php if($image!=''){ ?>
                  <br>
                  <img src="../images/category_image/<?php echo $image; ?>" height="50px;">
                  <?php } ?>
              </div>
            </div>
        </div>
    </div>	
    
    <?php 
    if(isset($_POST['uploadimg'])){
            $cat_file = $_FILES['img']['name'];
            $ext = pathinfo($cat_file,PATHINFO_EXTENSION);
            $new_name = "catimage".uniqid().".".$ext;
            $temp_file = $_FILES['img']['tmp_name'];
            $filetarget = '../images/category_image/'.$new_name;
            if($cat_file==''){ $msg = "Upload Image first"; }
            else{
            $uploadimage = $db->exec("UPDATE category SET category_image='$new_name' WHERE categoryid='$getctid' ");
            if($uploadimage){
                    unlink('../images/category_image/'.$image);
                    move_uploaded_file($temp_file,$filetarget);
                    echo "<script>location.assign('categories.php')</script>";	
            }
            $msg = "image Not Edit";
            }
    }
    } 
    ?>
    <script>
        showdata();
            $('#submit').click(function(){
                var catname = $('#cate').val();
                $('#cate').val('');
                $.ajax({
                    url:'categories.php',  
                    method:'POST',
                    async:false,
                    data:{
                        'saverecord' : 1,
                        'cate' : catname
                    },
                    dataType:"text",
                    success: function(data){
                        if(data == 3){
                        //	alert("category Inserted");
                            showdata();	
                        }
                        else if(data == 4){
                            alert('Sorry please enter category');
                        }
                    }
                });
            });
            
            function showdata(){
                $.ajax({
                    url:'categories.php', 
                    type: 'POST',
                    async:false,
                    data:{
                        'show' : 1	
                    },
                    success: function(r){
                        $('#showdata').html(r);
                    }
                });	
            }
            
            
        showsub();
            $('#submit1').click(function(){
                var catid = $('#ctid').val();
				var subcatname = $('#subcate').val();
                $('#subcate').val('');
			    $.ajax({
                    url:'categories.php',  
                    method:'POST',
                    async:false,
                    data:{
                        'savesub' : 1,
                        'ctid' : catid,
				        'subcate' : subcatname
                    },
                    dataType:"text",
                    success: function(data){
                        if(data == 3){
                        //	alert("category Inserted");
                            showsub();	
                        }
                        else if(data == 4){
                            alert('Sorry please enter category');
                        }
                    }
                });
            });
            
            function showsub(){
                $.ajax({
                    url:'categories.php', 
                    type: 'POST',
                    async:false,
                    data:{
                        'shows' : 1	
                    },
                    success: function(r){
                        $('#showsub').html(r);
                    }
                });	
            }		
    </script> 
    </div>
    </div>
</div>

</body>
</html>
<?php  }
	}
	else{ echo "<script>location.assign('logout.php')</script>"; }
}
else{ echo "<script>location.assign('logout.php')</script>"; }
?>
