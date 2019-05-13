<?php
require('../fpdf.php');
include ('connect.php');

$id=$_POST['selectsupplier'];
$sql='SELECT name FROM supplier WHERE id=' . $id;
$result = $conn->query($sql);


class PDF extends FPDF
{

function Header()
{
    $this->Image('Logo Agung.jpg',10,5,200);
    $this->Ln(20);
}

function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    $this->SetFont('Arial','I',8);
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
$pdf->MultiCell(400,10,$result);
$pdf->AliasNbPages();
$pdf->Output();
?>