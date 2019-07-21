<?php
error_reporting(0);
session_start();
include('../connection/index.php');
include('../function.php');
if(isset($_SESSION['usrid']) && isset($_SESSION['usrmail']) && isset($_SESSION['usrpass'])){
	$recid = $_SESSION['usrid'];
	$recmail = $_SESSION['usrmail'];
	$recpass = $_SESSION['usrpass'];
	$user_detail = $db->prepare("SELECT * FROM users WHERE user_id=:recid");
	$user_detail->bindParam(':recid',$recid);
	$user_detail->execute();
	$stmt = $user_detail->fetchAll();
	if(count($stmt)){
		foreach($stmt as $st){
			$recname = $st['user_name'];
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Welcome <?php echo $st['user_name']; ?> </title>
<?php echo headdata(); ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="<?php echo $url; ?>css/font-awesome.min.css" type="text/css" rel="stylesheet"/>
<link href="<?php echo $url; ?>css/bootstrap.min.css" type="text/css" rel="stylesheet"/>
<link href="css/styleplus.css" type="text/css" rel="stylesheet"/>
<link href="css/responsive-manage.css" type="text/css" rel="stylesheet"/>
<script src="<?php echo $url; ?>js/jquery-3.2.1.min.js" type="text/javascript"> </script>
<script src="<?php echo $url; ?>js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/index.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
$(document).ready(function(){
 $(document).on('change', '#file', function(){
  var name = document.getElementById("file").files[0].name;
  var form_data = new FormData();
  var ext = name.split('.').pop().toLowerCase();
  if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1) 
  {
   alert("Invalid Image File");
  }
  var oFReader = new FileReader();
  oFReader.readAsDataURL(document.getElementById("file").files[0]);
  var f = document.getElementById("file").files[0];
  var fsize = f.size||f.fileSize;
  if(fsize > 2000000)
  {
   alert("Image File Size is very big");
  }
  else
  {
   form_data.append("file", document.getElementById('file').files[0]);
   $.ajax({
    url:"<?php echo $url.'user/upload.php'; ?>",
    method:"POST",
    data: form_data,
    contentType: false,
    cache: false,
    processData: false,
    beforeSend:function(){
     $('#uploaded_image').html("<label class='text-success'>Image Uploading...</label>");
    },   
    success:function(data)
    {
     $('#uploaded_image').html(data);
    }
   });
  }
 });
});
</script>
</head>
<body>
<?php include('aheader.php'); ?>
<div class="slidebody trans5s">
    <?php include('topheader.php'); ?>
    <div class="fulldv adminbody">
        <div class="section">
			<div class="fulldv p20 profile_main">
            	<table class="see-table">
                	<tr>
                    	<tr>
                        	<td>
                            <?php if($st['profile_image']==''){ ?>
                            	<img src="<?php echo $url; ?>user/images/userphoto.jpg" alt=""/>
                            <?php } else{ ?>    
                            	<div class="profilemg"><span id="uploaded_image"><img src="images/<?php echo $st['profile_image']; ?>" alt=""/></span></div>
               				<?php } ?>   
                				<input type="file" name="file" id="file" />
                            </td>
                            <td>
                            	<h4>Profile</h4>
                                <table class="see-table">
                                	<tr>
                                    	<td>Name</td>
                                    	<td><?php echo $st['user_name']; ?></td>
                                    </tr>
                                    <tr>
                                    	<td>Email ID</td>
                                    	<td><?php echo $st['user_mail']; ?></td>
                                    </tr>
                                    <tr>
                                    	<td>Phone No.</td>
                                    	<td><?php echo $st['user_mobile']; ?></td>
                                    </tr>
                                </table>
                                <a href="#" onClick="editpro()">Edit Profile</a>
                            </td>
                        </tr>
                    </tr>
                </table>
			</div>
            <div class="fulldv">
            	<div class="col-md-5 editprofile">
                <?php
					if(isset($_POST['changeprofile'])){
						$newname = $_POST['nwname'];
						$newmail = $_POST['nwmail'];
						$newmob = $_POST['nwmob'];
						$change_profile = $db->prepare("UPDATE users SET user_name=:newname, user_mail=:newmail, user_mobile=:newmob WHERE user_id=:recid");
						$change_profile->bindParam(':newname',$newname);
						$change_profile->bindParam(':newmail',$newmail);
						$change_profile->bindParam(':newmob',$newmob);
						$change_profile->bindParam(':recid',$recid);
						$change_profile->execute();
						if(isset($change_profile)){
							$_SESSION['usrmail'] = $newmail;
							echo "<script>location.assign('".$url."user/')</script>";
						}
					}
				?>
                 <form method="post">
                	<h4>Edit Profile</h4>
                    <p>Name</p>
                    <input type="text" name="nwname" value="<?php echo $st['user_name']; ?>">
                    <p>Email ID</p>
                    <input type="email" name="nwmail" value="<?php echo $st['user_mail']; ?>">
                    <p>Phone No.</p>
                    <input type="text" name="nwmob" value="<?php echo $st['user_mobile']; ?>">
                    <input type="submit" name="changeprofile" value="Submit">
                    <a href="#" style="background:#C50105" onClick="editclose()">Cancel</a>
                  </form>  
                </div>
            </div>
        </div>
    </div>
</div>


<script>
	function editpro() {
		$('.editprofile').addClass('show')
		
		}
	function editclose() {
		$('.editprofile').removeClass('show')
		
		}
</script>
</body>

</html>
<?php } } else { echo "<script>location.assign('".$url."user/logout.php')</script>"; }
} else { echo "<script>location.assign('".$url."user/logout.php')</script>"; } ?>