<?php
require('fpdf.php');
require_once ('../conexion.php');
use Carbon\Carbon;
require __DIR__ . '/../vendor/autoload.php';
class PDF extends FPDF {
   // Cabecera de página
    function Header()
    {
       
       $this->Image('img/imgPdf.png', 0, 0, $this->GetPageWidth(), $this->GetPageHeight()); 
       $this->SetFont('Arial', 'B', 19); 
       $this->Cell(95); 
       $this->SetTextColor(0, 0, 0); 

       $pageWidth = $this->GetPageWidth();
       $xPosition = ($pageWidth - 25) / 2; 
       $this->SetXY($xPosition, 15); 
       
       $this->Ln(1); 
       
       $this->SetTextColor(103); 
       $this->Cell(100); 
       $this->SetFont('Arial', 'I', 8);
       $pageWidth = $this->GetPageWidth();
       $xPosition = ($pageWidth - 25) / 2; 
       $this->SetXY($xPosition, 20); 
     
       $this->Ln(5);
 
       $this->SetTextColor(228, 100, 0);
       $this->Cell(100); 
       $this->SetFont('Arial', 'B', 25);
       $pageWidth = $this->GetPageWidth();
       $xPosition = ($pageWidth - 25) / 2; 
       $this->SetXY($xPosition, 30); 
       $this->Cell(25, 25, utf8_decode("ACTA DE ENTREGA"), 0, 1, 'C', 0);
       $this->Ln(1);
    }
    private $pageCount = 0;
    
    function Footer()
   {
     $this->SetY(-15); 
     $pageWidth = $this->GetPageWidth();
     $xPosition = ($pageWidth - 190) / 2; 
     $this->SetXY($xPosition, -30);
     $this->SetTextColor(100, 100, 100);
     
     $this->SetFont('Arial', 'BI', 8);
     $this->SetLineWidth(1); 
     $this->SetDrawColor(255, 128, 0); 
     $this->Cell(0, 5, utf8_decode('Casa Matriz'), 'T', 1, 'L',0); 
     $this->SetFont('Arial', 'I', 8);
     $this->Cell(0, 5, utf8_decode('Calle Mercado N° 1335, PB'), 0, 1, 'L');
     $this->Cell(0, 5, utf8_decode('Oficina 102'), 0, 1, 'L');
     $this->SetFont('Arial', 'BI', 8);
     $this->Cell(0, 5, utf8_decode('Teléfono: +591 2200020'), 0, 1, 'L');
     $this->Cell(0, 5, utf8_decode('Celular: +591 683 55517'), 0, 1, 'L');
 
     $this->pageCount++;
     
     if ($this->pageCount > 2) {
       $this->SetTextColor(100, 100, 100);
       $this->SetY(-15); 
       $this->SetFont('Arial', 'I', 8);
 
       $pageWidth = $this->GetPageWidth();
       $xPosition = ($pageWidth - 25); 
       $this->SetXY($xPosition, -40); 
       $this->Cell(25, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'R');
     }
     //FECHA FORMATO 
     $this->SetTextColor(0, 0, 0);
     $this->SetY(-15); 
     $this->SetFont('Arial', 'I', 8); 
     Carbon::setLocale('es');
     Carbon::setLocale('America/La_Paz');
     
     $hoy = Carbon::now('America/La_Paz')->isoFormat('D [de] MMMM [de] YYYY [a las] H:mm:ss');
     $pageWidth = $this->GetPageWidth();
     $xPosition = ($pageWidth - 25) / 2; 
     $this->SetXY($xPosition, -45); 
     $this->Cell(25, 25, utf8_decode('La Paz, '.$hoy), 0, 0, 'C'); 
    }
 }
$pdf = new PDF();
$pdf->AddPage('P','Letter');
$pdf->AliasNbPages(); 
$pdf->SetFont('times', 'B', 12);
$i=0;
$suma=0;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    foreach ($_POST as $key => $value) {
      $posicion = $value;
      $pdf->Cell(195,  5, utf8_decode($posicion), 1, 1, 'R', 0);
      $suma = $suma + $posicion;
      //var_dump($_POST);
      }
      $pdf->Cell(195,  5, utf8_decode("sss".$suma), 1, 1, 'R', 0);
  }
  
$pdf->Output();
?>