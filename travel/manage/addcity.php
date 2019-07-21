<?php
//error_reporting(0);
session_start();
include('../function.php');
include('../connection/index.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Add Cities and Area</title>
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
		<?php 
        if(isset($_GET['cat'])){ 
                $ctname = $_GET['cat'];
                $getid = $db->prepare("SELECT city_id,city_name FROM cities WHERE city_url=:ctname");
                $getid->bindParam(':ctname',$ctname);
                $getid->execute();
                $onlycid = $getid->fetch();
                $ctid = $onlycid['city_id'];
                $catnamee = $onlycid['city_name'];
        ?>
        <div class="fulldv subcate" style="border-bottom:0; padding:0;">
            <a href="addcity.php?ste=<?php echo $sturl; ?>" class="btn-yellow"><?php echo $catnamee; ?></a>
            <span class="arrow-right"><img src="../images/arrow.png" alt=""/></span>
            <input type="button" id="login-pop1" value="Add Area" class="btn-blue">
            <span class="arrow-right1" style="width:42px; height:42px; margin:0px 10px; position:relative; box-sizing:border-box; padding:10px;">
        </div>
        
        <div class="overlaydv login-popup">
            <div class="pop-off"></div>
            <div class="overlaydv-in">
                <div class="overlaydv-inner">
                    <div class="log-pop-inner">  
                      <form>
                      <?php if(isset($duplicate)){ echo $duplicate; } ?>
                        <span><a href="addcity.php?ste=<?php echo $sturl; ?>&cat=<?php echo $ctname; ?>">&times;</a></span>
                        <h4>Add Area</h4>
                        <div class="fulldv cattag">
                        <input type="text" name="ctid" id="ctid" hidden="hidden" value="<?php echo $ctid; ?>">
                        <input type="text" name="subcate" id="subcate" placeholder="Enter Area Name" required/>
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
            <h2>Area</h2>
            <div class="col-md-6 p0 cattable">
				<table class="see-table see-table-each">
					<tr class="bluetr">
                    	<th>Area</th>
                    	<th>Edit</th>
                    </tr>
				<?php
					$getcategory = $db->prepare("SELECT * FROM area WHERE cty_id=:ctid ORDER BY area_id DESC");
                    $getcategory->bindParam(':ctid',$ctid);
                    $getcategory->execute();
                    $allcat = $getcategory->fetchAll();
                    foreach($allcat as $allct){
                         $scatid = $allct['area_id'];
                         $scatname = $allct['area_name'];	
			    ?>
                	<tr>
                    	<td><?php echo $scatname; ?></td>
                    	<td>
                          <?php // if($chkpr > 0){ } else { ?>
                        	<a href="addcity.php?ste=<?php echo $sturl; ?>&cat=<?php echo $ctname; ?>&scdel=<?php echo $scatid;?>" id="forgote" onClick="return ckdel();">
                            	<span class="catdelete"><i class="fa fa-trash"></i></span>
                            </a> &nbsp;
                          <?php // } ?>  
                			<a href="addcity.php?ste=<?php echo $sturl; ?>&cat=<?php echo $ctname; ?>&sval=<?php echo $scatid;?>" id="forgote">
                            	<span class="catedit">
                                	<i class="fa fa-edit"></i>
                                </span>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                </table>
            </div>
        </div>
    <?php
    if(isset($_GET['scdel'])){
        $sbctid = $_GET['scdel'];
        $delete_sbcat = $db->prepare("DELETE FROM area WHERE area_id=:sbctid");	
        $delete_sbcat->bindParam(':sbctid',$sbctid);
        $delete_sbcat->execute();
        if(isset($delete_sbcat)){ echo "<script>location.assign('addcity.php?ste=$sturl&cat=$ctname')</script>"; }
    }
    
    if(isset($_GET['sval'])){ 
       $getscatid = $_GET['sval']; 
       $getscatname = $db->prepare("SELECT cty_id,area_name FROM area WHERE area_id=:getscatid");
       $getscatname->bindParam(':getscatid',$getscatid);
       $getscatname->execute();
       $getsname = $getscatname->fetch();
       $ctid = $getsname['cty_id'];
       $scname = $getsname['area_name']; ?>
       
    <div class="overlaydv forgote-popup-change">
        <div class="pop-off"></div>
        <div class="overlaydv-in">
            <div class="overlaydv-inner">
                <div class="log-pop-inner">
                <?php if(isset($msg)){ echo $msg; } ?>
                  <form action="" method="post" id="register-form-forgote" novalidate>
                   <span><a href="addcity.php?ste=<?php echo $sturl; ?>&cat=<?php echo $ctname;?>">&times;</a></span>
                    <h4>Edit Area</h4>
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
            $changename = $db->prepare("UPDATE area SET area_name=:newsname, area_url=:finalnew WHERE area_id=:getscatid");
            $changename->bindParam(':newsname',$newsname);
            $changename->bindParam(':finalnew',$finalnew);
            $changename->bindParam(':getscatid',$getscatid);
            $changename->execute();
            if(isset($changename)){
                        echo "<script>location.assign('addcity.php?ste=$sturl&cat=$ctname')</script>";	
            }
            $msg = "Area Not Edit";
    
    }
    ?>
    <?php } 
    
     } 
	 	else { ?>
    
      <div class="fulldv category-maindv">
      	<div class="see-12 topbox">
        	<a href="state.php" class="btn-yellow" style="float:left;">Haryana</a>
            <span class="arrow-right"><img src="../images/arrow.png" alt=""/></span>
            <input type="button" id="login-pop" value="Add City" class="btn-blue">
        </div>
    
        <div class="overlaydv login-popup">
            <div class="pop-off"></div>
            <div class="overlaydv-in">
                <div class="overlaydv-inner">
                    <div class="log-pop-inner">  
                        <form>
                          <span><a href="addcity.php?ste=<?php echo $sturl; ?>">&times;</a></span>
                          <h4>Add City</h4>
                          <div class="fulldv cattag">
                              <input type="text" name="cate" id="cate" placeholder="Enter City Name" required/>
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
                       <tr>
                            <td>
                                <a class="hidelink" href="#">
                                    <button type="button">Faridabad</button>
                                </a>
                            </td>
                            <td>
                                <a href="#" id="forgote" onClick="return ckdel();">
                                    <span class="catdelete"><i class="fa fa-trash"></i></span>
                                </a> &nbsp;
                                <a href="#" id="forgote">
                                    <span class="catedit"><i class="fa fa-edit"></i></span>
                                </a>
                            </td>
                        </tr>
                       <tr>
                            <td>
                                <a class="hidelink" href="#">
                                    <button type="button">Gurugram</button>
                                </a>
                            </td>
                            <td>
                                <a href="#" id="forgote" onClick="return ckdel();">
                                    <span class="catdelete"><i class="fa fa-trash"></i></span>
                                </a> &nbsp;
                                <a href="#" id="forgote">
                                    <span class="catedit"><i class="fa fa-edit"></i></span>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a class="hidelink" href="#">
                                    <button type="button">Panipat</button>
                                </a>
                            </td>
                            <td>
                                <a href="#" id="forgote" onClick="return ckdel();">
                                    <span class="catdelete"><i class="fa fa-trash"></i></span>
                                </a> &nbsp;
                                <a href="#" id="forgote">
                                    <span class="catedit"><i class="fa fa-edit"></i></span>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a class="hidelink" href="#">
                                    <button type="button">Ambala</button>
                                </a>
                            </td>
                            <td>
                                <a href="#" id="forgote" onClick="return ckdel();">
                                    <span class="catdelete"><i class="fa fa-trash"></i></span>
                                </a> &nbsp;
                                <a href="#" id="forgote">
                                    <span class="catedit"><i class="fa fa-edit"></i></span>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a class="hidelink" href="#">
                                    <button type="button">Yamunanagar</button>
                                </a>
                            </td>
                            <td>
                                <a href="#" id="forgote" onClick="return ckdel();">
                                    <span class="catdelete"><i class="fa fa-trash"></i></span>
                                </a> &nbsp;
                                <a href="#" id="forgote">
                                    <span class="catedit"><i class="fa fa-edit"></i></span>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a class="hidelink" href="#">
                                    <button type="button">Rohtak</button>
                                </a>
                            </td>
                            <td>
                                <a href="#" id="forgote" onClick="return ckdel();">
                                    <span class="catdelete"><i class="fa fa-trash"></i></span>
                                </a> &nbsp;
                                <a href="#" id="forgote">
                                    <span class="catedit"><i class="fa fa-edit"></i></span>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a class="hidelink" href="#">
                                    <button type="button">Hisar</button>
                                </a>
                            </td>
                            <td>
                                <a href="#" id="forgote" onClick="return ckdel();">
                                    <span class="catdelete"><i class="fa fa-trash"></i></span>
                                </a> &nbsp;
                                <a href="#" id="forgote">
                                    <span class="catedit"><i class="fa fa-edit"></i></span>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a class="hidelink" href="#">
                                    <button type="button">Karnal</button>
                                </a>
                            </td>
                            <td>
                                <a href="#" id="forgote" onClick="return ckdel();">
                                    <span class="catdelete"><i class="fa fa-trash"></i></span>
                                </a> &nbsp;
                                <a href="#" id="forgote">
                                    <span class="catedit"><i class="fa fa-edit"></i></span>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a class="hidelink" href="#">
                                    <button type="button">Sonipat</button>
                                </a>
                            </td>
                            <td>
                                <a href="#" id="forgote" onClick="return ckdel();">
                                    <span class="catdelete"><i class="fa fa-trash"></i></span>
                                </a> &nbsp;
                                <a href="#" id="forgote">
                                    <span class="catedit"><i class="fa fa-edit"></i></span>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a class="hidelink" href="#">
                                    <button type="button">Panchkula</button>
                                </a>
                            </td>
                            <td>
                                <a href="#" id="forgote" onClick="return ckdel();">
                                    <span class="catdelete"><i class="fa fa-trash"></i></span>
                                </a> &nbsp;
                                <a href="#" id="forgote">
                                    <span class="catedit"><i class="fa fa-edit"></i></span>
                                </a>
                            </td>
                        </tr>
                </table>
                <br><br><br>
           </div>
        </div>
    </div>
    <?php } ?>
    
    <?php
    if(isset($_GET['del'])){
        $delctid = $_GET['del'];
		$deletecate = $db->prepare("DELETE FROM cities WHERE city_id=:delctid");	
        $deletecate->bindParam(':delctid',$delctid);
        $deletecate->execute();
        if(isset($deletecate)){ 
			echo "<script>location.assign('addcity.php?ste=$sturl')</script>"; }
        else{ echo "Not deleted"; }
        
    }
    
    if(isset($_GET['val'])){ 
       $getcatid = $_GET['val']; 
       $getcatname = $db->query("SELECT city_name FROM cities WHERE city_id='$getcatid'");
       $getname = $getcatname->fetch();
       $cname = $getname['city_name']; ?>
       
    <div class="overlaydv forgote-popup-next">
        <div class="overlaydv-in">
            <div class="overlaydv-inner">
                <div class="log-pop-inner">
                <?php if(isset($msg)){ echo $msg; } ?>
                  <form action="" method="post" id="register-form-forgote" novalidate>
                   <span><a href="addcity.php?ste=$sturl">&times;</a></span>
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
            $changename = $db->exec("UPDATE cities SET city_name='$newname', city_url='$finalnewc' WHERE city_id='$getcatid' ");
            if(isset($changename)){
                        echo "<script>location.assign('addcity.php?ste=$sturl')</script>";	
            }
            $msg = "City Not Edit";
    }
     } 
    ?>
    <script>
        showdata();
            $('#submit').click(function(){
                var catname = $('#cate').val();
				$('#cate').val('');
			    $.ajax({
                    url:"addcity.php?ste=<?php echo $sturl; ?>",  
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
                    url:"addcity.php?ste=<?php echo $sturl; ?>", 
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
                    url:"addcity.php?ste=<?php echo $sturl; ?>",  
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
                    url:"addcity.php?ste=<?php echo $sturl; ?>", 
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
