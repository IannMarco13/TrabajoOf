<?php
require('fpdf.php');
require_once ('../conexion.php');

//ob_end_clean();
use Carbon\Carbon;
require __DIR__ . '/../vendor/autoload.php';
$i=0;
class PDF extends FPDF
{
   // Cabecera de página
   function Header()
   {
      $this->Image('img/logo.png', 270, 5, 20); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
      $this->SetFont('Arial', 'B', 19); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(95); // Movernos a la derecha
      $this->SetTextColor(0, 0, 0); //color
      
      $this->SetTextColor(228, 100, 0);//color
      $this->Cell(1); // mover a la derecha
      $this->SetFont('Arial', 'B', 15);
      $this->Cell(100, 10, utf8_decode("REPORTE DE REMESAS 123"), 0, 1, 'C', 0);
      $this->Ln(7);

      /* CAMPOS DE LA TABLA */
      //color
      $this->SetFillColor(255, 165, 0); //colorFondo
      $this->SetTextColor(0, 0, 0); //colorTexto
      $this->SetDrawColor(163, 163, 163); //colorBorde
      $this->SetFont('times', 'B', 7); // 'times' es el nombre para Times New Roman
      $this->Cell(67, 5, utf8_decode('SEGUIMIENTO'), 1, 0, 'C', 1);
      $this->Cell(24, 5, utf8_decode('PAGO'), 1, 0, 'C', 1);
      $this->Cell(38, 5, utf8_decode('PROCESO DESTINO'), 1, 0, 'C', 1);
      $this->Cell(55, 5, utf8_decode('REMITENTE'), 1, 0, 'C', 1);
      $this->Cell(93, 5, utf8_decode('DESTINATARIO'), 1, 1, 'C', 1);
      $this->Cell(8,  5, utf8_decode('N°'), 1, 0, 'C', 1);
      $this->Cell(10, 5, utf8_decode('AIR'), 1, 0, 'C', 1);
      $this->Cell(10, 5, utf8_decode('AGR'), 1, 0, 'C', 1);
      $this->Cell(10, 5, utf8_decode('CRD'), 1, 0, 'C', 1);
      $this->Cell(10, 5, utf8_decode('CODIGO'), 1, 0, 'C', 1);
      $this->Cell(19, 5, utf8_decode('FECHA'), 1, 0, 'C', 1);
      $this->Cell(9, 5, utf8_decode('[USD]'), 1, 0, 'C', 1);
      $this->Cell(15, 5, utf8_decode('[CLP]'), 1, 0, 'C', 1);
      $this->Cell(8,  5, utf8_decode('MON'), 1, 0, 'C', 1);
      $this->Cell(15, 5, utf8_decode('MONTO'), 1, 0, 'C', 1);
      $this->Cell(15, 5, utf8_decode('ESTADO'), 1, 0, 'C', 1);
      $this->Cell(55, 5, utf8_decode('NOMBRE'), 1, 0, 'C', 1);
      $this->Cell(93, 5, utf8_decode('NOMBRE'), 1, 1, 'C', 1);

   }

   function AddTableData($data) {
    $this->SetFont('times', '', 6);
    foreach ($data as $fila) {
        $this->Cell(8,  5, utf8_decode($fila[0]), 1, 0, 'C', 0);
        $this->Cell(10,  5, utf8_decode($fila[1]), 1, 0, 'C', 0);
        $this->Cell(10,  5, utf8_decode($fila[2]), 1, 0, 'C', 0);
        $this->Cell(10,  5, utf8_decode($fila[3]), 1, 0, 'C', 0);
        $this->Cell(10,  5, utf8_decode($fila[4]), 1, 0, 'C', 0);
        $this->Cell(19,  5, utf8_decode($fila[5]), 1, 0, 'C', 0);
        $this->Cell(9,  5, utf8_decode($fila[6]), 1, 0, 'R', 0);
        $this->Cell(15,  5, utf8_decode($fila[7]), 1, 0, 'R', 0);
        $this->Cell(8,  5, utf8_decode($fila[8]), 1, 0, 'C', 0);
        $this->Cell(15,  5, utf8_decode($fila[9]), 1, 0, 'R', 0);
        $this->Cell(15,  5, utf8_decode($fila[10]), 1, 0, 'C', 0);
        $this->Cell(55, 5, utf8_decode($fila[11]), 1, 0, 'L', 0);
        $this->MultiCell(93, 5, utf8_decode($fila[12]), 1, 'L');
    }
}

   // Pie de página
   function Footer()
   {
      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C'); //pie de pagina(numero de pagina)

      //FECHA FORMATO 
      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); // Tipo de fuente: Arial, itálica, tamaño 8
      // Obtener la fecha actual con Carbon y formatearla
      $hoy = Carbon::now()->locale('es_ES')->isoFormat('D [de] MMMM [de] YYYY');
      $this->Cell(540, 10, utf8_decode($hoy), 0, 0, 'C'); // Pie de página (fecha de página)

   }

}

$pdf = new PDF();
$pdf->AddPage("landscape"); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas

$i = 0;
$pdf->SetFont('Arial', '', 8);
$pdf->SetDrawColor(163, 163, 163); //colorBorde

//validar aca si no son = votar a usandon redirec
$from_date = $_GET['from_date'];
$to_date = $_GET['to_date'];

$fechaInicio = Carbon::createFromFormat('Y-m-d', $from_date);
$fechaFin = Carbon::createFromFormat('Y-m-d', $to_date);

// Crear una instancia de Carbon con la fecha y hora actual
$fechaActual = Carbon::now();

if ($fechaInicio->isFuture() || $fechaFin->isFuture()) {
    // Si alguna de las fechas está en el futuro
    echo '<script>alert("No puedes ingresar fechas futuras a'.$fechaActual.'"); window.location.href = "../RepComEStado.php";</script>';
}

if ($fechaInicio <= $fechaFin ){

$from_date = $_GET['from_date'];
$to_date = $_GET['to_date'];

$query = ("SELECT remesas_env_chile_bolivia.AIR, remesas_env_chile_bolivia.AGR, remesas_env_chile_bolivia.CRD, remesas_env_chile_bolivia.CODIGO, remesas_env_chile_bolivia.FECHA , remesas_env_chile_bolivia.RECIBIDO_USD, remesas_env_chile_bolivia.RECIBIDO_CLP, remesas_env_chile_bolivia.MONEDA,remesas_env_chile_bolivia.MONTO,remesas_env_chile_bolivia.ESTADO, remesas_env_chile_bolivia.REMITENTE, remesas_env_chile_bolivia.DESTINATARIO FROM remesas_env_chile_bolivia WHERE DATE(FECHA) BETWEEN '$from_date' AND '$to_date'");

$query_run = mysqli_query($conexion, $query);
if(mysqli_num_rows($query_run) > 0){
    $data = [];
    foreach($query_run as $fila) {
        $i = $i + 1;
        $rowData = [
            $i,
            $fila['AIR'],
            $fila['AGR'],
            $fila['CRD'],
            $fila['CODIGO'],
            date('d-m-Y h:i', strtotime($fila['FECHA'])),
            number_format($fila['RECIBIDO_USD'], 0),
            number_format($fila['RECIBIDO_CLP'], 0),
            $fila['MONEDA'],
            number_format($fila['MONTO'], 0),
            $fila['ESTADO'],
            $fila['REMITENTE'],
            $fila['DESTINATARIO']
        ];
        array_push($data, $rowData);
    }
    $pdf->AddTableData($data);
} else {
    // Manejo de error si no hay filas encontradas
    $pdf->SetFont('times', 'B', 8);
    $pdf->Cell(40, 10, 'No se encontraron datos para el período seleccionado.', 0, 1);
}

$query_cont = "SELECT COUNT(MONEDA) AS Total_Registros FROM remesas_env_chile_bolivia WHERE DATE(FECHA) BETWEEN '$from_date' AND '$to_date' AND remesas_env_chile_bolivia.MONEDA = 'BOB'";

$query_run_cont = mysqli_query($conexion, $query_cont);

if ($query_run_cont) {
    $result = mysqli_fetch_assoc($query_run_cont);
    $Total_Registros = $result['Total_Registros'];

    // Encabezado de la tabla
    $pdf->Ln(); // Salto de línea antes de la tabla
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(50, 10,utf8_decode('Cantidad Envios[BOB]'), 1, 0, 'C', 0);// ver borde,salto de linea, posision del conetenido , nose    Salto de línea después de la fila
    // Contenido de la tabla
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(20, 10, $Total_Registros, 1, 0, 'C',0);
       // Salto de línea después de la fila

} else {
    // Manejar el error si la consulta falla
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(40, 10, 'Error en la consulta de conteo:', 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(40, 10, mysqli_error($conexion), 0, 1);
}
$query_cont_usd = "SELECT COUNT(MONEDA) AS Total_Registros
FROM remesas_env_chile_bolivia WHERE DATE(FECHA) BETWEEN '$from_date' AND '$to_date' AND remesas_env_chile_bolivia.MONEDA = 'USD'";
$query_run_cont_usd = mysqli_query($conexion, $query_cont_usd);

if ($query_run_cont) {
    $result = mysqli_fetch_assoc($query_run_cont_usd);
    $Total_Registros = $result['Total_Registros'];
    // Encabezado de la tabla
    $pdf->Ln(); // Salto de línea antes de la tabla
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(50, 10,utf8_decode('Cantidad Envios[USD]'), 1, 0, 'C', 0);// ver borde,salto de linea, posision del conetenido , nose    Salto de línea después de la fila
    // Contenido de la tabla
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(20, 10, $Total_Registros, 1, 0, 'C',0);
       // Salto de línea después de la fila
} else {
    // Manejar el error si la consulta falla
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(40, 10, 'Error en la consulta de conteo:', 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(40, 10, mysqli_error($conexion), 0, 1);
}

$query_T = "SELECT SUM(report_chile_bolivia.MONTO_BOB) AS Total_Monto_BOB , SUM(report_chile_bolivia.MONTO_USD) AS TOTAL_MONTO_USD FROM remesas_env_chile_bolivia INNER JOIN report_chile_bolivia ON remesas_env_chile_bolivia.AIR = report_chile_bolivia.AIR_R WHERE DATE(FECHA) BETWEEN '$from_date' AND '$to_date'";

$query_run_T = mysqli_query($conexion, $query_T);

if ($query_run_T) {
    $result = mysqli_fetch_assoc($query_run_T);
    $Total_Monto_BOB = $result['Total_Monto_BOB'];
    $TOTAL_MONTO_USD = $result['TOTAL_MONTO_USD'];

    // Encabezado de la tabla
    $pdf->Ln(); // Salto de línea antes de la tabla
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(30, 10,utf8_decode('N° TOTAL'), 1, 0, 'C', 0);
    $pdf->Cell(30, 10, utf8_decode('Total BOB'), 1,0, 'C', 0);
    $pdf->Cell(30, 10, utf8_decode('Total USD'), 1, 1,'C', 0); // ver borde,salto de linea, posision del conetenido , nose    Salto de línea después de la fila

    // Contenido de la tabla
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(30,10, $i, 1,0, 'C',);
    $pdf->Cell(30, 10, number_format($Total_Monto_BOB), 1, 0, 'C');
    $pdf->Cell(30, 10, number_format($TOTAL_MONTO_USD), 1, 1, 'C'); // Salto de línea después de la fila

} else {
    // Manejar el error si la consulta falla
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(40, 10, 'Error en la consulta de conteo:', 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(40, 10, mysqli_error($conexion), 0, 1);
}
}
else {
    echo '<script>alert("Fecha incorrecta"); window.location.href = "../RepComEStado.php";</script>';
}
$pdf->Output('Remesas Chile Bolivia '.$from_date.'.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)
?>
