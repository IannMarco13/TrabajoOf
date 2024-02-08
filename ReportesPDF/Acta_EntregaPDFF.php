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

// Obtener los datos del formulario
$monedas = $_POST['moneda'];
$TotalEnviado = $_POST['totalEnviado'];
$resultadoOps = $_POST['resultadoOp'];
$totalDolarizados = $_POST['totalDolarizado'];
$totalDolarizadoGlobal = $_POST['totalGloval'];

$pdf = new PDF();
$pdf->AddPage('P','Letter');
$pdf->SetFont('TIMES', 'B', 16);
// Iterar sobre los datos y agregarlos al PDF
$pdf->Cell(0,10, utf8_decode("AGENCIA COLON:"),0,1,"L",0);
$pdf->SetFont('TIMES', 'B', 12);
$pdf->Cell(70,7, utf8_decode(""),0,0,"C",0);
$pdf->Cell(50,7, utf8_decode("TOTAL ENVIADO"),1,0,"C",0);
$pdf->Cell(50,7, utf8_decode("TOTAL DOLARIZADO"),1,1,"C",0);


for ($i = 0; $i < count($resultadoOps); $i++) {
  $pdf->SetFont('TIMES', 'B', 12);
  $pdf->Cell(70, 7, utf8_decode($monedas[$i]), 1, 0, "L", 0);
  $pdf->SetFont('TIMES', '', 12);
  $pdf->Cell(50, 7, utf8_decode($TotalEnviado[$i]), 1, 0, "R", 0);
  $pdf->Cell(50, 7, utf8_decode($totalDolarizados[$i]), 1, 1, "R", 0);
}
// Verificar si $totalDolarizadoGlobal es un array
if (is_array($totalDolarizadoGlobal)) {
    $totalDolarizadoGlobalString = implode(', ', $totalDolarizadoGlobal);
    $pdf->SetFont('TIMES', 'B', 12);
    $pdf->Cell(120, 7, utf8_decode('Total Dolarizado Global: '),  1, 0, "C", 0);
    $pdf->Cell(50, 7, ($totalDolarizadoGlobalString), 1, 1, "R", 0);
} else {
    $pdf->Cell(40, 7, utf8_decode('Total Dolarizado Global: '),1, 0, "L", 0);
    $pdf->Cell(50, 7, ($totalDolarizadoGlobal), 1, 1, "R", 0);
}
$fileName = 'ActaEntrega.pdf';
$pdf->Output($fileName, 'I');

?>