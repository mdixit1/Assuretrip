<?php
session_start();
if(!isset($_SESSION['plusid'] , $_SESSION['plusname'])){ header('location:logout.php'); }  
else{ require_once "../connection/index.php";
$reciveid = $_SESSION['plusid'];
$recivename = $_SESSION['plusname'];
include('digit.php');
$reciveid = $_SESSION['plusid'];
$recivename = $_SESSION['plusname'];

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Invoice</title>

</head>

<body>
<?php
if(isset($_GET['order'])){
	$uniqodrid = $_GET['order'];
$showdetail = $db->query("SELECT * FROM tourists WHERE touristid='$uniqodrid'");
$all = $showdetail->fetch();

$sum = "";


$torstid = $all['touristid'];
$tfname = $all['touristfirstname'];
$temail = $all['touristemail'];
$tmobile = $all['tmobileno'];
$taddress = $all['tcuraddress'];
$country = $all['tcountry'];
$state = $all['tstate'];
$city = $all['tcity'];
$pincode = $all['tpincode'];
$plprice = $all['pyment'];
$plandetail = $all['purpose'];
$tremark = $all['membership_no'];
$date = $all['tdate'];

  /*$vat = 5;

 $vatprice = $plprice*$vat/100;
 
 $pri = $plprice-$vatprice;
 
 $withoutvat = $plprice-$vatprice;

 $roundone =  number_format($vatprice, 2, '.', '');

 $total+=$withoutvat+=$vatprice;

 $finaltotal =  number_format($total, 2, '.', '');

 $inword = strtoupper(convert_number_to_words($total));*/
 
 
 
$srvtax = $plprice*4/100; 
 
$firsttax = $plprice*4/100;
$one = $plprice*0.5/100;
$two = $plprice*0.5/100;

$pric = $plprice-$firsttax-$one-$two;
$withouttax = $plprice-$firsttax-$one-$two;

 $total+=$withouttax+=$firsttax+=$one+=$two;
 $finaltotal =  number_format($total, 2, '.', '');
 $inword = strtoupper(convert_number_to_words($total));
 
require('pdf/fpdf.php');
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',15);
$pdf->Cell(0,10,"INVOICE",0,1,C);
$pdf->Image('../images/logo2.png',10,25,-420);
$pdf->MultiCell(190,10,"COUNTYWIDE VACATIONS",0,0);
$pdf->SetFont('Arial','',10);
$pdf->MultiCell(190,5,"5, 1st Floor",0,0);
$pdf->MultiCell(190,5,"Raja Garden , New Delhi 110019 ",0,0);
$pdf->MultiCell(190,5,"India ",0,0);
$pdf->MultiCell(190,6,"Website : http://www.countywidevacations.com ",0,0);
$pdf->MultiCell(190,6,"E-mail : achlesh@countywidevacations.com ",0,0);

$pdf->Cell(0,5,"",0,1);
$pdf->Cell(0,5,"",0,1);

$pdf->SetFont('Arial','b',14);
$pdf->Cell(120,2,"Mr./Mrs. {$tfname} ",0,0);
$pdf->Cell(70,2," ",0,0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(120,5," ",0,0);
$pdf->Cell(70,5,"",0,1,R);
$pdf->Cell(120,5,"{$taddress}",0,0);
$pdf->Cell(70,5,"Invoice No #: {$torstid}",0,1,R);

$pdf->Cell(120,5,"{$city} , {$state} , {$country}",0,0);
$pdf->Cell(120,5,"                         E-mail : {$temail}",0,1);
$pdf->Cell(194,5," 	Date : {$date}  ",0,1,R);
$pdf->Cell(120,5," ",0,0);

$pdf->Cell(0,5,"",0,1);
$pdf->SetFillColor(255, 255, 255);
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(150,10,"    Description",1,0);
$pdf->Cell(40,10,"Amount   ",1,1,R);
$pdf->SetFont('Arial','',10);
$pdf->Cell(150,10,"    {$plandetail}  ",1,0);
$pdf->Cell(40,10,"{$pric}/-    ",1,1,R);
$pdf->Cell(150,10,"    Service Tax @ 4%",1,0);
$pdf->Cell(40,10,"{$srvtax}/-    ",1,1,R);
$pdf->Cell(150,10,"    Swachh Bharat Cess @ 0.5%",1,0);
$pdf->Cell(40,10,"{$two}/-    ",1,1,R);
$pdf->Cell(150,10,"    Krishi Kalyan Cess @ 0.5%",1,0);
$pdf->Cell(40,10,"{$two}/-    ",1,1,R);



$pdf->SetFont('Arial','b',9);
$pdf->Cell(150,10,"    TOTAL AMOUNT",1,0);
$pdf->Cell(40,10,"{$total}/-    ",1,1,R);
$pdf->Cell(150,10,"    IN WORDS",0,0);
$pdf->Cell(40,10,"{$inword} ONLY",0,1,R);

$pdf->Cell(0,20,"",0,1);
$pdf->SetFont('Arial','B',10);
$pdf->MultiCell(0,10,"THIS IS A COMPUTER GENERATED INVOICE AND DOES NOT REQUIRE SIGNATURE",0);
ob_end_clean();
$pdf->Output($comnamin.'_invoice.pdf','D');
// $pdf->Output();

}
?>

</body>
</html>
<?php } ?>
