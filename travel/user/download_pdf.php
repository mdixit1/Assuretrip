<?php
//error_reporting(0);
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
			
			  if(isset($_GET['compid'])){
				    $cid = $_GET['compid'];
				  	$showresitration = $db->prepare("SELECT * FROM leads WHERE leads_id=:cid ORDER BY leads_id DESC"); 
					$showresitration->bindParam(':cid',$cid);
					$showresitration->execute();
					$row = $showresitration->fetch();
					$luniq = $row['lead_uniq'];
					$deprt_date = date('d-M-Y',strtotime($row['departure_date']));
//include('digit.php');

require('../pdf/fpdf.php');
//$pdf = new FPDF('P','mm',array(750,250));
$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont('Arial','b',13);
$pdf->Cell(130,5,"Lead Detail ($luniq)",0,0,'R');
$pdf->Cell(70,5,"",0,1,'R');
$pdf->SetFont('Arial','b',9);
$pdf->Cell(130,5,"",0,0,'R');
$pdf->Cell(70,5,"",0,1);

$pdf->Line(10, 21, 205-5, 21);

$pdf->SetFont('Arial','b',10);
$pdf->MultiCell(100,8,"",0,0);
$pdf->Cell(30,5,"Unique ID  :",0,0,'L');
$pdf->Cell(100,5,"{$luniq}",0,0,'L');
$pdf->Cell(27,5,"Email  :",0,0,'L');
$pdf->Cell(30,5,"{$row['email']}",0,0,'L');
$pdf->MultiCell(20,5,"",0,0);
$pdf->Cell(30,5,"Mobile : ",0,0,'L');
$pdf->Cell(150,5,"{$row['mobile']}",0,0,'L');
$pdf->MultiCell(20,5,"",0,0);
$pdf->Cell(30,5,"Departure Type  :",0,0,'L');
$pdf->Cell(100,5,"{$row['departure_type']}",0,0,'L');
$pdf->Cell(27,5,"Dept. Date     :",0,0,'L');
$pdf->Cell(30,5,"{$deprt_date}",0,0,'L');
$pdf->MultiCell(20,5,"",0,0);
$pdf->Cell(30,5,"Departure Day :",0,0,'L');
$pdf->Cell(110,5,"{$row['departure_day']}",0,0,'L');
$pdf->MultiCell(20,5,"",0,0);
$pdf->Cell(30,5,"Flight :",0,0,'L');
$pdf->Cell(110,5,"{$row['flight']}",0,0,'L');


$pdf->MultiCell(20,-2,"",0,0);
$pdf->SetFont('Arial','b',12);
$pdf->MultiCell(28,12,"{$adult}",0,0);

$pdf->SetFont('Arial','b',9);
$pdf->Cell(70,5,"",0,1,'R');
$pdf->Line(10, 62, 205-5, 62);


$pdf->setFillColor(210,210,210); 
$pdf->SetFont('Arial','b',9);
$pdf->Cell(30,6,"Destination To  :",0,0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(125,6,"{$row['destination_to']}",0,0,'L');

$pdf->Cell(40,9," ",0,1);
$pdf->SetFont('Arial','b',9);
$pdf->Cell(35,6,"Exploring      :",0,0,'L');
$pdf->Cell(1,6,"",0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(110,6,"{$row['exploring']}",0,0,'L');

$pdf->Cell(40,9," ",0,1);
$pdf->SetFont('Arial','b',9);
$pdf->Cell(35,6,"Destination From  :",0,0,'L');
$pdf->Cell(1,6,"",0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(117,6,"{$row['destination_from']}",0,0,'L');

$pdf->Cell(40,9," ",0,1);
$pdf->SetFont('Arial','b',9);
$pdf->Cell(30,6,"Departure Type       :",0,0,'L');
$pdf->Cell(2,6,"",0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(65,6,"{$row['departure_type']}",0,0,'L');

$pdf->SetFont('Arial','b',9);
$pdf->Cell(32,6,"Departure Date        :",0,0,'L');
$pdf->Cell(4,6,"",0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(30,6,"{$deprt_date}",0,0,'L');

$pdf->Cell(40,9," ",0,1);
$pdf->SetFont('Arial','b',9);
$pdf->Cell(30,6,"Departure Day       :",0,0,'L');
$pdf->Cell(2,6,"",0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(65,6,"{$row['departure_day']}",0,0,'L');

$pdf->SetFont('Arial','b',9);
$pdf->Cell(32,6,"Hotels           :",0,0,'L');
$pdf->Cell(3,6,"",0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(117,6,"{$row['hotel_first']} , {$row['hotel_second']} , {$row['hotel_third']} , {$row['hotel_four']} , {$row['hotel_five']}",0,0,'L');


$pdf->Cell(40,12," ",0,1);
$pdf->SetFont('Arial','b',9);
$pdf->Cell(30,6,"Flight       :",0,0,'L');
$pdf->Cell(2,6,"",0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(65,6,"{$row['flight']}",0,0,'L');

$pdf->SetFont('Arial','b',9);
$pdf->Cell(32,6,"Budget With AirFair  :",0,0,'L');
$pdf->Cell(3,6,"",0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(20,6,"{$row['budget_withair']}",0,0,'L');

$pdf->Cell(40,12," ",0,1);
$pdf->SetFont('Arial','b',9);
$pdf->Cell(40,6,"Budget Without AirFair   :",0,0,'L');
$pdf->Cell(2,6,"",0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(55,6,"{$row['budget_withoutair']}",0,0,'L');

$pdf->SetFont('Arial','b',9);
$pdf->Cell(33,6,"Adult  :",0,0,'L');
$pdf->Cell(2,6,"",0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(30,6,"{$row['adult']}",0,0,'L');

$pdf->Cell(40,12," ",0,1);
$pdf->SetFont('Arial','b',9);
$pdf->Cell(30,6,"Infant         :",0,0,'L');
$pdf->Cell(2,6,"",0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(65,6,"{$row['infant']}",0,0,'L');

$pdf->SetFont('Arial','b',9);
$pdf->Cell(31,6,"Children            :",0,0,'L');
$pdf->Cell(4,6,"",0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(55,6,"{$row['children']}",0,0,'L');

$pdf->Cell(40,12," ",0,1);
$pdf->SetFont('Arial','b',9);
$pdf->Cell(30,6,"Book Type    :",0,0,'L');
$pdf->Cell(2,6,"",0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(65,6,"{$row['book_type']}",0,0,'L');


$pdf->Cell(40,12," ",0,1);
$pdf->SetFont('Arial','b',9);
$pdf->Cell(30,6,"Cab Facility    :",0,0,'L');
$pdf->Cell(2,6,"",0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(65,6,"{$row['cab_facility']}",0,0,'L');

$pdf->Cell(40,12," ",0,1);
$pdf->SetFont('Arial','b',9);
$pdf->Cell(30,6,"Cab Language    :",0,0,'L');
$pdf->Cell(2,6,"",0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(65,6,"{$row['cab_language']}",0,0,'L');

$pdf->Cell(40,12," ",0,1);
$pdf->SetFont('Arial','b',9);
$pdf->Cell(30,6,"Type of Tour    :",0,0,'L');
$pdf->Cell(2,6,"",0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(65,6,"{$row['type_of_tour']}",0,0,'L');

$pdf->Cell(40,12," ",0,1);
$pdf->SetFont('Arial','b',9);
$pdf->Cell(30,6,"Week    :",0,0,'L');
$pdf->Cell(2,6,"",0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(65,6,"{$row['this_week']}",0,0,'L');

$pdf->Cell(40,12," ",0,1);
$pdf->SetFont('Arial','b',9);
$pdf->Cell(30,6,"Additional Required  :",0,0,'L');
$pdf->Cell(2,6,"",0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(65,6,"{$row['additional_req']}",0,0,'L');


ob_end_clean();
$pdf->Output();
	}
	else{ echo "No Detail Found"; }

		 }
	}
	else{ echo "<script>location.assign('".$url."logout.php')</script>"; }
}
else{ echo "<script>location.assign('".$url."logout.php')</script>"; }
?>