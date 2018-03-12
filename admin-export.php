<!DOCTYPE html>
<html>
<head>
	<title>Homepage</title>
	<meta charset="utf-8">
</head>
<?php
require './fpdf17/fpdf.php';
header('Content-type: application/pdf');
define('FPDF_FONTPATH','font/');

class PDF extends FPDF {

	// Simple table
	function BasicTable($header, $data)
	{
	    // Header
	    foreach($header as $col)
	        $this->Cell(40,7,$col,'L',1);
	    $this->Ln();
	    // Data
	    // foreach($data as $row)
	    // {
	    //     foreach($row as $col)
	    //         $this->Cell(40,6,$col,1);
	    //     $this->Ln();
	    // }
	}
	//Colored table
	function FancyTable($header,$data)
	{
		//Colors, line width and bold font
		$this->SetFillColor(255,0,0);
		$this->SetTextColor(255);
		$this->SetDrawColor(128,0,0);
		$this->SetLineWidth(.3);
		// $this->SetFont('','B');
		//Header
		$w=array(10,80,20,65);
		for($i=0;$i<count($header);$i++) {
			$this->Cell($w[$i],7,$header[$i],1,0,'C',true);
		}
		$this->Ln();
		//Color and font restoration
		$this->SetFillColor(224,235,255);
		$this->SetTextColor(0);
		// $this->SetFont('');
		//Data
		$fill=false;
		$c = 1;
		foreach($data as $row)
		{
			$this->Cell($w[0],6,$c,0,0,'L',$fill);
			$this->Cell($w[1],6,iconv( 'UTF-8','TIS-620',$row->name),0,0,'L',$fill);
			$this->Cell($w[2],6,iconv( 'UTF-8','TIS-620',$row->current."/".$row->capacity),0,'L',$fill);
			$this->MultiCell($w[3],6,iconv( 'UTF-8','TIS-620',"Create date: ".$row->create_date_time."\nStart date: ".$row->start_date_time."\nEnd date: ".$row->end_date_time),0,'L',$fill);
			$this->Ln();
			$fill=!$fill;
			$c++;
		}
		$this->Cell(array_sum($w),0,'','T');
	}
}

ob_clean();
$pdf=new PDF();
$header=array('#','Name','Capacity','Date');
$data = json_decode(htmlspecialchars_decode($_POST['event']));
// $data=array('Hello','Column 2','Column 3','Column 4');
// print_r($data[0]->name);
$pdf->AddPage();
$pdf->AddFont('angsa','','angsa.php');
$pdf->SetFont('angsa','',16);
$pdf->FancyTable($header,$data);
$pdf->Output();
?>
<body>

</body>
</html>