<?php
error_reporting(0);
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

if(isset($_POST['saverecord'])){
	$catname = stripslashes($_POST['cate']);
	$caturl = str_replace(' ', '-', $catname);
	$without_special_char = preg_replace('/[^a-zA-Z0-9_ -]/s', '', $caturl);
	$final = strtolower($without_special_char);
	if($catname){
		$checkname = $db->prepare("SELECT COUNT(country_name) FROM country WHERE country_name= :catname");
		$checkname->bindParam(':catname' , $catname);
		$checkname->execute();
		if($checkname->fetchColumn() > 0 ){
					echo "Country already exists";
			}
			else{
				$insertcat=$db->prepare("INSERT INTO country(country_name,country_url,country_date)VALUES(:catname, :final, :date)");
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
   $getcat = $db->prepare("SELECT * FROM country ORDER BY country_id DESC");
   $getcat->execute();
   $data = $getcat->fetchAll();
   foreach($data as $all){
	   $catid = $all['country_id'];
	   $catname = $all['country_name'];
?>
 	  <div class="showta">	
		<div class="show">
			<?php echo $catname; ?> 
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
<title>Add Country</title>
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
        <div class="see-12 topbox">
            <input type="button" id="login-pop" value="Add Country" class="btn-blue">
        </div>
    
        <div class="overlaydv login-popup">
            <div class="pop-off"></div>
            <div class="overlaydv-in">
                <div class="overlaydv-inner">
                    <div class="log-pop-inner">  
                        <form>
                          <span><a href="country.php">&times;</a></span>
                          <h4>Add Country</h4>
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
         
        <div class="fulldv category">
            <div class="fulldv">
                <h2>Country</h2>
            </div>
           <div class="col-md-10 cattable p0">
               <table class="see-table see-table-each">
                    <tr class="bluetr">
                        <th>Country Name</th>
                        <th>Edit</th>
                    </tr>
                    <?php
                    $getcategory = $db->prepare("SELECT * FROM country ORDER BY country_id DESC");
                    $getcategory->execute();
                    $allcat = $getcategory->fetchAll();
                    foreach($allcat as $allct){
                         $catid = $allct['country_id'];
                         $catname = $allct['country_name'];	
							$checkcat = $db->prepare("SELECT COUNT(state_id) FROM state WHERE contryid=:catid"); 
							$checkcat->bindParam(':catid',$catid);
							$checkcat->execute();
							$chkct = $checkcat->fetchColumn();
                    ?>
                       <tr>
                            <td>
                                <a class="hidelink" href="state.php?contry=<?php echo $allct['country_url']; ?>">
                                    <button type="button"><?php echo $catname; ?></button>
                                </a>
                            </td>
                            <td>
							<?php if($chkct > 0){ } else { ?>
                                <a href="country.php?del=<?php echo $catid; ?>" id="forgote" onClick="return ckdel();">
                                <span class="catdelete">
                                    <i class="fa fa-trash"></i>
                                </span>
                                </a> &nbsp;
                            <?php } ?>
                               <a href="country.php?val=<?php echo $catid; ?>" id="forgote">
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
    </div>
    </div>
 	<?php
	if(isset($_GET['del'])){
        $delctid = $_GET['del'];
		$deletecate = $db->prepare("DELETE FROM country WHERE country_id=:delctid");	
        $deletecate->bindParam(':delctid',$delctid);
        $deletecate->execute();
        if(isset($deletecate)){ 
			echo "<script>location.assign('country.php')</script>"; }
        else{ echo "Not deleted"; }
        
    }
	
	if(isset($_GET['val'])){ 
       $getcatid = $_GET['val']; 
       $getcatname = $db->query("SELECT country_name FROM country WHERE country_id='$getcatid'");
       $getname = $getcatname->fetch();
       $cname = $getname['country_name']; ?>
       
    <div class="overlaydv forgote-popup-next">
        <div class="overlaydv-in">
            <div class="overlaydv-inner">
                <div class="log-pop-inner">
                <?php if(isset($msg)){ echo $msg; } ?>
                  <form action="" method="post" id="register-form-forgote" novalidate>
                   <span><a href="country.php">&times;</a></span>
                    <h4>Edit Country</h4>
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
            $changename = $db->exec("UPDATE country SET country_name='$newname', country_url='$finalnewc' WHERE country_id='$getcatid' ");
            if(isset($changename)){
                        echo "<script>location.assign('country.php')</script>";	
            }
            $msg = "Category Not Edit";
    }
    ?>
    <?php } 
   	
	?>
    <script>
        showdata();
            $('#submit').click(function(){
                var catname = $('#cate').val();
                $('#cate').val('');
                $.ajax({
                    url:'country.php',  
                    method:'POST',
                    async:false,
                    data:{
                        'saverecord' : 1,
                        'cate' : catname
                    },
                    dataType:"text",
                    success: function(data){
                        if(data == 3){
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
                    url:'country.php', 
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