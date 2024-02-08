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
 $from_date = isset($_GET['from_date']) ? $_GET['from_date'] : null;
 
 // Obtener la última fecha si no se envió ninguna desde el formulario
 if (!$from_date) {
     $query = "SELECT MAX(DATE(FECHA_AE)) AS Ult_fecha, FECHA_AE FROM acta_entrega;";
     $query_run = mysqli_query($conexion, $query);
 
     if ($row = mysqli_fetch_assoc($query_run)) {
         $from_date = $row['Ult_fecha'];
     }
 }
 
 // Si aún no hay fecha, establecer la fecha actual
 $from_date = $from_date ?? Carbon::now('America/La_Paz')->startOfDay()->toDateString();

 $query = "SELECT Moneda, TOTAL_ENVIADO, TOTAL_USD, (SELECT SUM(TOTAL_USD) FROM acta_entrega WHERE DATE(FECHA_AE)='$from_date') AS TOTAL, FECHA_AE
 FROM acta_entrega 
 INNER JOIN tabla_monedas ON COD_MONEDA = CodigoMoneda  
 WHERE DATE(FECHA_AE) = '$from_date';";

 $query_run = $conexion->query($query);
 $Fecha = $query_run->fetch_assoc();
 $fechaa = $Fecha['FECHA_AE'];

 // Crear un nuevo objeto FPDF
 $pdf = new PDF();
 $pdf->AddPage('P','Letter');
 $pdf->AliasNbPages(); //muestra la pagina / y total de paginas

 $pdf->SetFont('times', 'B', 12);

 $pdf->Ln();
 $pdf->MultiCell(0, 10, utf8_decode('DETALLE DE MONTOS Y MONEDA EXTRANJERA ENTREGADA A LA SRA. EDELMIRA RAMOS MOLLO POR PARTE DE LA AGENCIA COLON EN LA FECHA: '.date('d-m-Y', strtotime($fechaa))), 0, 1);
 $query_run = mysqli_query($conexion, $query);

 $pdf->Ln(); // Salto de línea antes de la tabla
 $pdf->SetFont('Arial', 'B', 12);
 $pdf->Cell(0, 5,utf8_decode('AGENCIA COLON: '), 0, 1, 'L', 0);

 $pdf->SetFont('Arial', 'B', 12);
 $pdf->Cell(85, 5,utf8_decode(''), 0, 0, 'C', 0);
 $pdf->Cell(50, 10, utf8_decode('TOTAL ENVIADO'), 0,0, 'R', 0);
 $pdf->Cell(50, 10, utf8_decode('TOTAL DOLARIZADO'), 0, 1,'R', 0);

if(mysqli_num_rows($query_run) > 0){
   foreach($query_run as $fila){  
    $pdf->Cell(20, 5, utf8_decode(''), 0, 0, 'C', 0);
    $pdf->Cell(65, 5, utf8_decode($fila['Moneda']), 0, 0, 'L', 0);
    $pdf->Cell(50, 5, utf8_decode($fila['TOTAL_ENVIADO']), 0, 0, 'R', 0);
    $pdf->Cell(50, 5, utf8_decode($fila['TOTAL_USD']), 0, 1, 'R', 0);
   }
   $pdf->Cell(135, 10, utf8_decode('TOTAL DOLIRAZADO'), 0, 0, 'C', 0 );
   $pdf->Cell( 50, 10, utf8_decode($fila['TOTAL']), 0, 1, 'R', 0);
}

// Nombre del archivo PDF
$fileName = 'ActaEntrega.pdf';
// Salida del PDF para mostrar en una ventana nueva
$pdf->Output($fileName, 'I');

?>