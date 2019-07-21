<?php
session_start();
require_once "connection/index.php"; 
if(isset($_GET['pay'])){
	$getemail = $_GET['pay']; 
  
$MERCHANT_KEY = "q0BjxxCD";
$SALT = "QDKX1LG92w";
$PAYU_BASE_URL = "https://secure.payu.in";
$action = '';
 
$posted = array();
if(!empty($_POST)){ foreach($_POST as $key => $value){ $posted[$key] = $value; } }
$formError = 0;
if(empty($posted['txnid'])){ $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20); } 
else { $txnid = $posted['txnid']; }
$hash = '';
$hashSequence = "key|txnid|amount|productinfo|firstname|email||||||||||";
if(empty($posted['hash']) && sizeof($posted) > 0){
	if( 
		empty($posted['key']) 
		|| empty($posted['txnid'])
		|| empty($posted['amount'])
		|| empty($posted['firstname'])
		|| empty($posted['email'])
		|| empty($posted['phone'])
		|| empty($posted['productinfo'])
		|| empty($posted['surl'])
		|| empty($posted['furl'])
		|| empty($posted['service_provider'])
	){ $formError = 1; }
	else {
		$hashVarsSeq = explode('|', $hashSequence);
		$hash_string = '';	
		foreach($hashVarsSeq as $hash_var) {
		  $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
		  $hash_string .= '|';
		}
		$hash_string .= $SALT;
		$hash = strtolower(hash('sha512', $hash_string));
		$action = $PAYU_BASE_URL . '/_payment';
	}
} 
elseif(!empty($posted['hash'])){
	$hash = $posted['hash'];
	$action = $PAYU_BASE_URL . '/_payment';
}
?>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta content="telephone=no" name="format-detection">
<title>Welcome to countywidevacations.com</title>
<link href="images/company-overview.png" rel="icon">
<link href="style/index.css" rel="stylesheet" type="text/css"/>
<link href="style/main-file.css" rel="stylesheet" type="text/css"/>
<link href="style/responsive.css" rel="stylesheet" type="text/css"/>

<script src="js/jquery-1.12.4.js" type="text/javascript"></script>
<script src="js/jquery.cycle.all.js" type="text/javascript"></script>
<script src="js/custom.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<link href='https://fonts.googleapis.com/css?family=Roboto:400,500,700' rel='stylesheet' type='text/css'>

<!------- datepicker -------->
<link href="http://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script>
	var hash = '<?php echo $hash ?>';
	function submitPayuForm() {
	  if(hash == '') {
		return;
	  }
	  var payuForm = document.forms.payuForm;
	  payuForm.submit();
	}
</script>
</head>
<body onload="submitPayuForm()">
<?php include 'header.php'; ?>
<div class="section book-now-sect">
<div class="see-width">
    <h2>Booking Detail</h2>
        
        <?php
         if($formError){ ?>
          <span style="color:red">Please fill all mandatory fields.</span>
          <br/>
        <?php } ?>
        <table>
         <?php
              $searchdetail = $db->prepare("SELECT * FROM tourists WHERE touristemail = :getemail LIMIT 1");
              $searchdetail->bindParam(':getemail',$getemail);
              $searchdetail->execute();
              $alldetail = $searchdetail->fetchAll();
              if(count($alldetail)){ 
              foreach($alldetail as $all){
                    $tfname = $all['touristfirstname'];
                    $tlname = $all['touristlastname'];
                    $temail = $all['touristemail'];
                    $tmobile = $all['tmobileno'];
                    $plprice = $all['pyment'];
            ?>
            <form action="<?php echo $action; ?>" method="post" name="payuForm">
                <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
                <input type="hidden" name="abc" value="<?php echo $hash_string ?>" />
                <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
                <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />	
                <tr><td>Name</td><td><?php echo $tfname.' '.$tlname; ?></td></tr>
                <tr><td>Email</td><td><?php echo $temail; ?></td></tr>
                <tr><td>Mobile No</td><td><?php echo $tmobile; ?></td></tr>
                <input type="hidden" name="firstname" id="firstname" value="<?php echo $tfname; ?>" required/>
                <input type="hidden" name="email" id="email" value="<?php echo $temail; ?>" required/>
                <input type="hidden" name="phone" value="<?php echo $tmobile; ?>" required/>
                <input type="hidden" name="productinfo" value="countywidevations" required/>
                <input type="hidden" name="surl" value="http://www.countywidevacations.com/success.php" required/>
                <input type="hidden" name="furl" value="http://www.countywidevacations.com/failure.php" required/>
                <input name="amount" type="hidden" value="<?php echo $plprice; ?>" />
                <input type="hidden" name="service_provider" value="payu_paisa" required/>
                <tr><td><b>Rs : <?php echo $plprice; ?> INR </b></td></tr>
                <tr><td><input type="submit" value="Pay Now"  /></td></tr>
            </form>
         </table>
    <?php } } 
		else { echo "No Booking Detail"; }?>     

</div>
</div>

 <?php include('footer.php'); ?>
 
</body>
</html>
<?php }
else{ echo "Page Not Found"; }
 ?>
 