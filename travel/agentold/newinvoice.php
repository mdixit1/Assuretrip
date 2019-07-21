<?php
error_reporting(0);
session_start();
include('../function.php');
include('../connection/index.php');
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Invoice</title>
    <?php echo headdata(); ?>
    <link href="css/see.css" type="text/css" rel="stylesheet"/>
    <link href="style/admin-style.css" rel="stylesheet" type="text/css"/>
    <link href="../images/company-overview.png" rel="icon">
    <link href="css/responsive-manage.css" type="text/css" rel="stylesheet"/>
    <link href="css/styleplus.css" type="text/css" rel="stylesheet"/>
    <link href="css/index.css" type="text/css" rel="stylesheet"/>
    <script src="js/jquery-2.1.3.min.js" type="text/javascript"></script>
    <script src="js/index.js" type="text/javascript"></script>
</head>
<body>
<?php include('plusheader.php'); ?>
<div class="slidebody see-trans5s">
    <div class="section headersection see-trans5s">
    	<div class="see-12">
        	<div class="dv100">
            	<div class="navbtn">
                	<span class="spnnavbtn1">&times;</span>
                    <span class="spnnavbtn2">&equiv;</span>
                </div>
                <div class="usernamedv">
               		<h4><?php echo "Welcome  ".$recivename; ?></h4>
                	<img src="../images/admin.png" alt=""/> 
                </div>
            </div>
        </div>
    </div>
	<div class="dv100 adminbody">
	<div class="change-psw">
    	<div class="fulldv title_with_button">
            <h3>Make New Invoice</h3>
            <a href="booknowdetail.php" class="see-button see-blue"> All Invoice </a>
        </div>
        <div class="fulldv change-psw-in">
       		<?php
				if(isset($_POST['registernow'])){
					$tfstname = $_POST['fstname']; 
					$temail = strtolower($_POST['mail']);
					$purpos = $_POST['pupos'];
					$touristpassword = rand(25252525, 99999999);
					$tpassword = md5($touristpassword);
					$tmobile = $_POST['mobile'];
					$taddress = $_POST['add'];
					$tstate = $_POST['st'];
					$tcity = $_POST['ct'];
					$tcount = $_POST['co'];
					$amount = $_POST['amount'];
					$mshipno = $_POST['membrno'];
					$tdate = date('Y-m-d H:i:s'); 
					$insertdata = $db->prepare("INSERT INTO tourists(touristfirstname,touristemail,touristpassword,tmobileno,tcuraddress,tcountry,tstate,tcity,purpose,pyment,membership_no,payment_status,tdate)VALUES(:tfstname, :temail, :tpassword, :tmobile, :taddress, :tcount, :tstate, :tcity, :purpos, :amount, :mshipno,'1',:tdate)");
					$insertdata->bindParam(':tfstname',$tfstname);
					$insertdata->bindParam(':temail',$temail);
					$insertdata->bindParam(':tpassword',$tpassword);
					$insertdata->bindParam(':tmobile',$tmobile);
					$insertdata->bindParam(':taddress',$taddress);
					$insertdata->bindParam(':tcount',$tcount);
					$insertdata->bindParam(':tstate',$tstate);
					$insertdata->bindParam(':tcity',$tcity);
					$insertdata->bindParam(':purpos',$purpos);
					$insertdata->bindParam(':amount',$amount);
					$insertdata->bindParam(':mshipno',$mshipno);
					$insertdata->bindParam(':tdate',$tdate);
					$insertdata->execute();
					if(isset($insertdata)){ echo "<script>alert('Invoice Done')</script>"; }
					else{ echo "<script>alert('Not Done')</script>"; }
				}
			?>		
           <form method="post" id="register-form">
            <?php if(isset($already)){ echo "<h1 style='margin:0;'>".$already."<h1>"; } ?> 
            <div class="col-md-2">
                <p>Mr/Ms</p>
                <select name="pupos">
                    <option value="Mr">Mr</option>
                    <option value="Mrs">Mrs</option>
                </select>
            </div>
            <div class="col-md-6">
                <p>Full Name</p>
                <input type="text" name="fstname" placeholder="Enter Full Name" required/>
            </div>
            
            <div class="col-md-4">
                <p>V.O No. /Form No.</p>
                <input type="tel" name="membrno" placeholder="Enter Number" required/>
            </div>
            
             <div class="col-md-4">
                <p>Mobile No</p>
                <input type="tel" onKeyUp="onlydigit(this)" maxlength="10" name="mobile" placeholder="xxxxxxxx12 - 10 Digit" autocomplete="off" required/>
            </div>
            
            <div class="col-md-4">
                <p>Email id</p>
                <input type="email" name="mail" placeholder="example@email.com" required/>
            </div>
            
            <div class="col-md-4">
                <p>Payment for/Purpose</p>
                <select name="pupos">
                    <option value="" hidden="hidden"> Select Purpose </option>
                    <option value="Vacations Fee"> Vacations Fee </option>
                    <option value="AMC"> AMC </option>
                    <option value="Utility Charges"> Utility Charges </option>
                    <option value="Others"> Others </option>
                </select>
            </div>
            
            <div class="col-md-4">
                <p>Amount</p>
                <input type="tel" name="amount" onKeyUp="onlydigit(this)" placeholder="Rupees" required/>
            </div>
            
            
            <div class="col-md-8">
                <p>Address</p>
                <input type="text" name="add" placeholder="Enter Street No / House No" required/>
            </div>
            
            <div class="col-md-4">
                <p>City</p>
                <input type="text" name="ct" placeholder="Enter City Name" required/>
            </div>
            
            <div class="col-md-4">
                <p>State</p>
                <input type="text" name="st" placeholder="Enter State Name" required/>
            </div>
            
             <div class="col-md-4">
                <p>Country</p>
                <input type="text" name="co" placeholder="Enter Country Name" required/>
            </div>
            
            <div class="col-md-3">    
                <input type="submit" name="registernow" value="Make A Payment"/>
            </div> 
        </form>
        </div> 
    </div> 
</div>
</div>
</body>
</html>
