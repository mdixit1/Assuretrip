<?php
error_reporting(0);
session_start();
include('../function.php');
include('../connection/index.php');
if(isset($_GET['ste'])){
	$steid = $_GET['ste'];
	$state_detal = $db->prepare("SELECT st.*,cn.country_name,cn.country_url FROM state st JOIN country cn ON cn.country_id=st.contryid WHERE state_id=:steid");
	$state_detal->bindParam(':steid',$steid);
	$state_detal->execute();
	$rows = $state_detal->fetchAll();
	if(count($rows)){
		foreach($rows as $row){
			
			
if(isset($_POST['saverecord'])){
	$catname = stripslashes($_POST['cate']);
	$caturl = str_replace(' ', '-', $catname);
	$without_special_char = preg_replace('/[^a-zA-Z0-9_ -]/s', '', $caturl);
	$final = strtolower($without_special_char);
	if($catname){
		$checkname = $db->prepare("SELECT COUNT(city_name) FROM city WHERE city_name=:catname AND ste_id=:steid");
		$checkname->bindParam(':catname' , $catname);
		$checkname->bindParam(':steid' , $steid);
		$checkname->execute();
		if($checkname->fetchColumn() > 0 ){
					echo "City already exists";
			}
			else{
				$insertcat=$db->prepare("INSERT INTO city(ste_id,city_name,city_url,city_date)VALUES(:steid, :catname, :final, :date)");
				$insertcat->bindParam(':steid', $steid);
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
   $getcat = $db->prepare("SELECT * FROM city WHERE ste_id=:steid ORDER BY city_id DESC");
   $getcat->bindParam(':steid',$steid);
   $getcat->execute();
   $data = $getcat->fetchAll();
   foreach($data as $all){
	   $catid = $all['city_id'];
	   $catname = $all['city_name'];
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
<title>Add City</title>
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
        	<a href="country.php"><?php echo $row['country_name']; ?></a>
            <a href="state.php?contry=<?php echo $row['country_url']; ?>"><?php echo $row['state_name']; ?></a>
            <input type="button" id="login-pop" value="Add City" class="btn-blue">
        </div>
        
        <div class="overlaydv login-popup">
            <div class="pop-off"></div>
            <div class="overlaydv-in">
                <div class="overlaydv-inner">
                    <div class="log-pop-inner">  
                        <form>
                          <span><a href="city.php?ste=<?php echo $steid; ?>">&times;</a></span>
                          <h4>Add City</h4>
                          <div class="fulldv cattag">
                              <input type="text" name="cate" id="cate" placeholder="Enter City" required/>
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
                <h2>City</h2>
            </div>
           <div class="col-md-6 cattable p0">
               <table class="see-table see-table-each">
                    <tr class="bluetr">
                        <th>City Name</th>
                        <th>Edit</th>
                    </tr>
                  <?php
				  	 $show_state = $db->prepare("SELECT * FROM city WHERE ste_id=:steid");
					 $show_state->bindParam(':steid',$steid);
					 $show_state->execute();
					 $allstats = $show_state->fetchAll();
					 foreach($allstats as $slst){
						 $ctyid = $slst['city_id'];
						 	/*$checkcat = $db->prepare("SELECT COUNT(state_id) FROM state WHERE contryid=:catid"); 
							$checkcat->bindParam(':catid',$catid);
							$checkcat->execute();
							$chkct = $checkcat->fetchColumn();*/
				  ?>  
                    <tr>
                        <td>
                            <!--<a class="hidelink" href="city.php?ste=<?php echo $ctyid; ?>">-->
                                <?php echo $slst['city_name']; ?>
                            <!--</a>-->
                        </td>
                        <td>
                            <?php /* if($chkct > 0){ } else { ?>
                                <a href="state.php?contry=<?php echo $cntryurl; ?>&del=<?php echo $steid; ?>" id="forgote" onClick="return ckdel();">
                                <span class="catdelete">
                                    <i class="fa fa-trash"></i>
                                </span>
                                </a> &nbsp;
                            <?php } */?>
                            <a href="city.php?ste=<?php echo $steid; ?>&val=<?php echo $ctyid; ?>" id="forgote">
                                <span class="catedit"> <i class="fa fa-edit"></i> </span>
                            </a>
                        </td>
                    </tr>
                  <?php } ?>  
                </table><br><br><br>
          </div>
        </div>
    </div>
 <?php
	if(isset($_GET['del'])){
        $delctid = $_GET['del'];
		$deletecate = $db->prepare("DELETE FROM city WHERE city_id=:delctid");	
        $deletecate->bindParam(':delctid',$delctid);
        $deletecate->execute();
        if(isset($deletecate)){ 
			echo "<script>location.assign('city.php?ste=$steid')</script>"; }
        else{ echo "Not deleted"; }
        
    }
	
	if(isset($_GET['val'])){ 
       $getcatid = $_GET['val']; 
       $getcatname = $db->query("SELECT city_name FROM city WHERE city_id='$getcatid'");
       $getname = $getcatname->fetch();
       $cname = $getname['city_name']; ?>
       
    <div class="overlaydv forgote-popup-next">
        <div class="overlaydv-in">
            <div class="overlaydv-inner">
                <div class="log-pop-inner">
                <?php if(isset($msg)){ echo $msg; } ?>
                  <form action="" method="post" id="register-form-forgote" novalidate>
                   <span><a href="city.php?ste=<?php echo $steid; ?>">&times;</a></span>
                    <h4>Edit City</h4>
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
            $changename = $db->exec("UPDATE city SET city_name='$newname', city_url='$finalnewc' WHERE city_id='$getcatid' ");
            if(isset($changename)){
                        echo "<script>location.assign('city.php?ste=$steid')</script>";	
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
                    url:'city.php?ste=<?php echo $steid; ?>',  
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
                    url:'city.php?ste=<?php echo $steid; ?>', 
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
<?php } } else{ "No Detail Found"; } } else{ "No Detail Found"; } ?>