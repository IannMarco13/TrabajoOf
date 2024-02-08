<?php
require('fpdf.php');
require_once ('../conexion.php');
use Carbon\Carbon;
require __DIR__ . '/../vendor/autoload.php';

class PDF extends FPDF {
    private $pageCount = 0;

    function Header()
    {
       // Encabezado de página
       $this->Image('img/imgPdf.png', 0, 0, $this->GetPageWidth(), $this->GetPageHeight()); 
       $this->SetTextColor(228, 100, 0);
       $this->SetFont('Arial', 'B', 20);
       $this->SetXY(10 , 30);
       $this->Cell(0, 8, utf8_decode("Agencia\nActa de Cierre de Caja\nCajero"), 0, 1, 'C', 0);
       $this->Ln(1);
    }

    function Footer()
    {
        // Pie de página
        $this->SetFont('Arial', 'BI', 8);
        $this->SetTextColor(100, 100, 100);
        $this->SetLineWidth(0.5); 
        $this->SetDrawColor(255, 128, 0);  
        $this->SetXY(10 , 260);
        $this->Cell(0, 3, utf8_decode('Casa Matriz'), 0, 1, 'L',0); 
        $this->Cell(0, 3, utf8_decode('Calle Mercado N° 1335, PB'), 0, 1, 'L');
        $this->Cell(0, 3, utf8_decode('Oficina 102'), 0, 1, 'L');
        $this->Cell(0, 3, utf8_decode('Teléfono: +591 2200020'), 0, 1, 'L');
        $this->Cell(0, 3, utf8_decode('Celular: +591 683 55517'), 0, 1, 'L');
        
        $this->pageCount++;
        if ($this->pageCount >= 2) {
          $this->SetXY(100 , 255);
            $this->Cell(25, 5, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
        }
        
        // Fecha
        $this->SetTextColor(0, 0, 0);
        $this->SetY(15); 
        $this->SetFont('Arial', 'I', 8); 
        Carbon::setLocale('es');
        Carbon::setLocale('America/La_Paz');
        $hoy = Carbon::now('America/La_Paz')->isoFormat('D [de] MMMM [de] YYYY [a las] H:mm:ss');
        $this->SetXY(10 , 255);
        $this->Cell(0, 5, utf8_decode('La Paz, '.$hoy), 'B', 0, 'C'); 
    }
}

class CierreCajaData {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function obtenerUltimaFechaCierre() {
        $query = "SELECT MAX(FECHA_TC) AS Ult_fecha FROM cierre_cajas;";
        $query_run = mysqli_query($this->conexion, $query);
        
        if ($row = mysqli_fetch_assoc($query_run)) {
            return date('Y-m-d', strtotime($row['Ult_fecha']));
            
        }
        
        return null;
    }

    public function obtenerDatosCierreCaja($from_date) {
        if (!$from_date) {
            $from_date = $this->obtenerUltimaFechaCierre();
        }

        $query = "SELECT FECHA_TC FROM cierre_cajas WHERE DATE(FECHA_TC)= ?";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, 's', $from_date);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $fecha_tc);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        return $fecha_tc ? date('Y-m-d', strtotime($fecha_tc)) : null;
    }
}
$pdf = new PDF();
$pdf->SetMargins(10, 10, 10);
$pdf->AddPage('P','Letter');
$pdf->AliasNbPages();

$cierreCajaData = new CierreCajaData($conexion);
$from_date = isset($_GET['from_date']) ? $_GET['from_date'] : null;

$pdf->Ln(5);

$fecha = $cierreCajaData->obtenerDatosCierreCaja($from_date);
if (!$fecha) {
    $pdf->Cell(0, 5, utf8_decode('La fecha deseada no se encuentra en la base de datos'), 0, 1, 'C', 0);
} else {
    $hora = date('H:i:s', strtotime($fecha));
    $pdf->Cell(0, 5, utf8_decode('A hotas: '.$hora.' del dia '.date('d-m-Y', strtotime($fecha)).' , se procedió a realizar el arqueo de CAJA en la AGENCIA COLON. Al efecto, certifico para los fines consiguientes de Ley, que los fondos recontados son todos los fondos en mi poder, de lo cual doy fe en mi calidad de cajero'), 0, 1, 'C', 0);

    // Generación de las tablas
    $resultados = array();
    $query1 = "SELECT CodigoMoneda, Moneda FROM tabla_monedas";
    $query1_run = mysqli_query($conexion, $query1);

    if ($query1_run) {
        while ($resultado1 = mysqli_fetch_assoc($query1_run)) {
            $CodigoMoneda = $resultado1['CodigoMoneda'];
            $NombreMoneda = $resultado1['Moneda'];

            $query = "SELECT CORTE, FAJO, UNIDAD, TOTAL, (SELECT SUM(TOTAL) FROM cierre_cajas WHERE MONEDA_TC = ? AND DATE(FECHA_TC) = ?) AS SUMATOTAL FROM cierre_cajas WHERE MONEDA_TC = ? AND DATE(FECHA_TC) = ?"; 
            $stmt = mysqli_prepare($conexion, $query);
            mysqli_stmt_bind_param($stmt, 'ssss', $CodigoMoneda, $fecha, $CodigoMoneda, $fecha);
            mysqli_stmt_execute($stmt);
            $query_run = mysqli_stmt_get_result($stmt);

            if ($query_run) {
                $pdf->SetFont('Times', 'B', 8);
                $pdf->Cell(55, 5, utf8_decode($NombreMoneda), 1, 1, 'C', 0);
                $pdf->Cell(15, 5, utf8_decode('Cortes'), 1, 0, 'C', 0);
                $pdf->Cell(10, 5, utf8_decode('Fajo'), 1, 0, 'C', 0);
                $pdf->Cell(10, 5, utf8_decode('Unidad'), 1, 0, 'C', 0);
                $pdf->Cell(20, 5, utf8_decode('Total'), 1, 1, 'C', 0);
                
                while ($row = mysqli_fetch_assoc($query_run)) {
                  $pdf->Cell(15, 5, utf8_decode($row['CORTE']), 1, 0, 'R', 0);
                  $pdf->Cell(10, 5, utf8_decode($row['FAJO']), 1, 0, 'C', 0);
                  $pdf->Cell(10, 5, utf8_decode($row['UNIDAD']), 1, 0, 'C', 0);
                  $pdf->Cell(20, 5, utf8_decode($row['TOTAL']), 1, 1, 'R', 0);
              }
              
              // Imprimir el total fuera del bucle
              $pdf->Cell(35, 5, utf8_decode('Total'), 1, 0, 'C', 0);
              $pdf->Cell(20, 5, isset($row['SUMATOTAL']) ? utf8_decode($row['SUMATOTAL']) : 'N/A', 1, 1, 'R', 0);
              
            }
        }
    }
}

$fileName = 'CierreCajas.pdf';
$pdf->Output($fileName, 'I');
