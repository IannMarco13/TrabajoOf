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
       $this->SetTextColor(228, 100, 0);
       $this->SetFont('Arial', 'B', 20);
       $pageWidth = $this->GetPageWidth();
       $xPosition = ($pageWidth ) / 2; 
       $this->BasicTable(10, 30);
       $this->MultiCell(0, 8, utf8_decode("Agencia\nActa de Cierre de Caja\nCajero"), 0, 'C', 0);
       $this->Ln(1);
    }
    private $pageCount = 0;
    function Footer()
    {
     $this->BasicTable(10, 260);
     $this->SetTextColor(100, 100, 100);
     $this->SetFont('Arial', 'BI', 8);
     $this->SetLineWidth(0.5); 
     $this->SetDrawColor(255, 128, 0);  
     $this->Cell(0, 3, utf8_decode('Casa Matriz'), 0, 1, 'L',0); 
     $this->SetFont('Arial', 'I', 8);
     $this->Cell(0, 3, utf8_decode('Calle Mercado N° 1335, PB'), 0, 1, 'L');
     $this->Cell(0, 3, utf8_decode('Oficina 102'), 0, 1, 'L');
     $this->Cell(0, 3, utf8_decode('Teléfono: +591 2200020'), 0, 1, 'L');
     $this->Cell(0, 3, utf8_decode('Celular: +591 683 55517'), 0, 1, 'L');
     
     $this->pageCount++;
     if ($this->pageCount >= 2) {
       $this->SetTextColor(100, 100, 100);
       $this->SetFont('Arial', 'I', 8);
       $this->BasicTable(185, 255); 
       $this->Cell(25, 5, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
     }
     //FECHA FORMATO 
     $this->SetTextColor(0, 0, 0);
     $this->SetY(15); 
     $this->SetFont('Arial', 'I', 8); 
     Carbon::setLocale('es');
     Carbon::setLocale('America/La_Paz');
     $hoy = Carbon::now('America/La_Paz')->isoFormat('D [de] MMMM [de] YYYY [a las] H:mm:ss');
     $this->BasicTable(10, 255); 
     $this->Cell(0, 5, utf8_decode('La Paz, '.$hoy), 'B', 0, 'C'); 
    }
    function BasicTable($x, $y) {
        $this->SetXY($x , $y);
    }
 }
 $x1 =  20;
 $x2 = 120;
 $y1 =  80;
 Carbon::setLocale('es');
 $pdf = new PDF();
 $pdf->SetMargins(10, 10, 10);
 $pdf->AddPage('P','Letter'); //(216 mm × 279 mm) (21.59cm x 27.94cm) Y=265
 $pdf->AliasNbPages();

 $from_date = isset($_GET['from_date']) ? $_GET['from_date'] : null;
 $pdf->Ln(5);

 if (!$from_date) {
     $query = "SELECT MAX(FECHA_TC) AS Ult_fecha FROM cierre_cajas;";
     $query_run = mysqli_query($conexion, $query);
 
     if ($row = mysqli_fetch_assoc($query_run)) {
         $from_date= date('Y-m-d', strtotime($row['Ult_fecha']));
         $hora = date('H:i:s', strtotime($row['Ult_fecha']));
     }
    $pdf->BasicTable( 10 , 60);
    $pdf->SetFont('Times', 'B', 11);
    $fecha= date('d-m-Y', strtotime($from_date));
    $pdf->MultiCell(200,5,utf8_decode('A hotas: '.$hora.' del dia '.$fecha.' , se procedió a relizar el arqueo de CAJA en la AGENCIA COLON. Al efecto, certifico para los fines consiguientes de Ley, que los fondos recontados son todos los fondos en mi poder, de lo cual doy fe en mi canlidad de cajero'),0,'C',0);
 }else{
    $query = "SELECT FECHA_TC FROM cierre_cajas WHERE DATE(FECHA_TC)= '$from_date'";
    $query_run = mysqli_query($conexion, $query);
    if ($row = mysqli_fetch_assoc($query_run)) {
        $from_date= date('Y-m-d', strtotime($row['FECHA_TC']));
        $hora = date('H:i:s', strtotime($row['FECHA_TC']));
        $pdf->BasicTable( 10 , 60);
        $pdf->SetFont('Times', 'B', 11);
        $fecha= date('d-m-Y', strtotime($from_date));
        $pdf->MultiCell(200,5,utf8_decode('A hotas: '.$hora.' del dia '.$fecha.' , se procedió a relizar el arqueo de CAJA en la AGENCIA COLON. Al efecto, certifico para los fines consiguientes de Ley, que los fondos recontados son todos los fondos en mi poder, de lo cual doy fe en mi canlidad de cajero'),0,'C',0);
    }else {
        $pdf->BasicTable( 10 , 60);
        $pdf->SetFont('Times', 'B', 11);
        $fecha= date('d-m-Y', strtotime($from_date));
        $pdf->MultiCell(200,5,utf8_decode('La fecha '.$fecha.' deseada no se encuentra en la base de datos'), 0,'C',0);
    }
 }
 $i=0;
 $query1 = "SELECT CodigoMoneda, Moneda FROM tabla_monedas";
 $query1_run = mysqli_query($conexion, $query1);
 if ($query1_run) {

    while ($resultado1 = mysqli_fetch_assoc($query1_run)) {
        $CodigoMoneda = $resultado1['CodigoMoneda'];
        $NombreMoneda = $resultado1['Moneda'];
        
        $query = "SELECT CORTE, FAJO, UNIDAD, TOTAL, (SELECT SUM(TOTAL) FROM cierre_cajas WHERE MONEDA_TC = '$CodigoMoneda' AND DATE(FECHA_TC) = '$from_date') AS SUMATOTAL FROM cierre_cajas WHERE MONEDA_TC = '$CodigoMoneda' AND DATE(FECHA_TC) = '$from_date';";     
        $query_run = mysqli_query($conexion, $query);
        
        if ($query_run) {
            $resultados = array();
            while ($row = mysqli_fetch_assoc($query_run)) {
                $resultados[] = $row;
                $SumaTotal = $row['SUMATOTAL'];
            }
            if (!empty($resultados)) {
                if ($i % 2 == 0) {
                    $y = $y1; 
                    $pdf->BasicTable( $x1, $y);
                    $pdf->SetFont('Times', 'B', 8);
                    $pdf->Cell(55, 5, utf8_decode($NombreMoneda), 1, 1, 'C', 0);
                    $y = $y + 5;
                    $pdf->BasicTable( $x1, $y);
                    $pdf->Cell(15, 5, utf8_decode('Conrtes'), 1, 0, 'C', 0);
                    $pdf->Cell(10, 5, utf8_decode('Fajo'), 1, 0, 'C', 0);
                    $pdf->Cell(10, 5, utf8_decode('Unidad'), 1, 0,'C', 0);
                    $pdf->Cell(20, 5, utf8_decode('Total'), 1, 1, 'C', 0);
                    $y = $y + 5;
                    foreach ($resultados as $resultado) {  
                        $pdf->BasicTable( $x1, $y);  
                        $y = $y + 5;
                        $pdf->Cell(15, 5, utf8_decode($resultado['CORTE']), 1, 0, 'R', 0);
                        $pdf->Cell(10, 5, utf8_decode($resultado['FAJO']), 1, 0, 'C', 0);
                        $pdf->Cell(10, 5, utf8_decode($resultado['UNIDAD']), 1, 0,'C', 0);
                        $pdf->Cell(20, 5, utf8_decode($resultado['TOTAL']), 1, 1, 'R', 0);
                    }
                    $pdf->BasicTable( $x1, $y);
                    $pdf->Cell(35, 5, utf8_decode('Total'), 1, 0, 'C', 0);
                    $pdf->Cell(20, 5, $resultado['SUMATOTAL'], 1, 1, 'R', 0);    
                    $i++;
                    $y = $y + 9;

                    if ($pdf->GetY() > 255) { 
                        $pdf->AddPage('P','Letter'); 
                        $pdf->BasicTable( 10 , 60);
                        $pdf->SetFont('Times', 'B', 11);
                        $fecha= date('d-m-Y', strtotime($from_date));
                        $pdf->MultiCell(200,5,utf8_decode('A hotas: '.$hora.' del dia '.$fecha.' , se procedió a relizar el arqueo de CAJA en la AGENCIA COLON. Al efecto, certifico para los fines consiguientes de Ley, que los fondos recontados son todos los fondos en mi poder, de lo cual doy fe en mi canlidad de cajero'),0,'C',0);
                        $y1 = 80;
                    } 

                }else{
                    $y2 = $y1;
                    $pdf->BasicTable( $x2, $y2);
                    $pdf->SetFont('Times', 'B', 8);
                    $pdf->Cell( 55, 5, utf8_decode($NombreMoneda), 1, 1, 'C', 0);
                    $y2 = $y2 + 5;
                    $pdf->BasicTable( $x2, $y2);
                    $pdf->Cell( 15, 5, utf8_decode('Conrtes'), 1, 0, 'C', 0);
                    $pdf->Cell( 10, 5, utf8_decode('Fajo'), 1, 0, 'C', 0);
                    $pdf->Cell( 10, 5, utf8_decode('Unidad'), 1, 0,'C', 0);
                    $pdf->Cell( 20, 5, utf8_decode('Total'), 1, 1, 'C', 0);
                    $y2 = $y2 + 5;
                    
                    foreach ($resultados as $resultado) { 
                        $pdf->BasicTable( $x2, $y2);   
                        $pdf->Cell( 15, 5, utf8_decode($resultado['CORTE']), 1, 0, 'R', 0);
                        $pdf->Cell( 10, 5, utf8_decode($resultado['FAJO']), 1, 0, 'C', 0);
                        $pdf->Cell( 10, 5, utf8_decode($resultado['UNIDAD']), 1, 0,'C', 0);
                        $pdf->Cell( 20, 5, utf8_decode($resultado['TOTAL']), 1, 1, 'R', 0);
                        $y2 = $y2 + 5;
                    }                    
                    $pdf->BasicTable( $x2, $y2);
                    $pdf->Cell( 35, 5, utf8_decode('Total'), 1, 0, 'C', 0);
                    $pdf->Cell( 20, 5, $resultado['SUMATOTAL'], 1, 1, 'R', 0);  
                    $pdf->Ln(1);  
                    $i++;
                    $y2 = $y2 + 7;
                    //$pdf->BasicTable( $x2, $y2);
                    //$pdf->Cell(30,5, $y2,1,1,'C',0);
                    if ($pdf->GetY() > 200) { 
                        $pdf->AddPage('P','Letter'); 
                        $pdf->BasicTable( 10 , 60);
                        $pdf->SetFont('Times', 'B', 11);
                        $fecha= date('d-m-Y', strtotime($from_date));
                        $pdf->MultiCell(200,5,utf8_decode('A hotas: '.$hora.' del dia '.$fecha.' , se procedió a relizar el arqueo de CAJA en la AGENCIA COLON. Al efecto, certifico para los fines consiguientes de Ley, que los fondos recontados son todos los fondos en mi poder, de lo cual doy fe en mi canlidad de cajero'),0,'C',0);
                        $y1 = 80; 
                    }  else{
                        if($y2 >= $y){
                            $y1 = $y2;
                        }else{
                            $y1= $y;
                        }
                    }    
                }
            } 
        }
    }
 }

$fileName = 'CierreCajas.pdf';

$pdf->Output($fileName, 'I');
?>
