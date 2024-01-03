<?php
require('fpdf.php');
require_once ('../conexion.php');
//ob_end_clean();
use Carbon\Carbon;
require __DIR__ . '/../vendor/autoload.php';
class PDF extends FPDF
{
   // Cabecera de página
   function Header()
   {
      $this->Image('img/logo.png', 270, 5, 20); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
      //$this->SetFont('Arial', 'B', 19); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(95); // Movernos a la derecha
      $this->SetTextColor(0, 0, 0); //color
      
      $this->SetTextColor(228, 100, 0);//color
      $this->Cell(1); // mover a la derecha
      $this->SetFont('Arial', 'B', 15);
      $this->Cell(100, 10, utf8_decode("REPORTE"), 0, 1, 'C', 0);
      $this->Ln(7);

      /* CAMPOS DE LA TABLA */
      //color
      $this->SetFillColor(255, 165, 0); //colorFondo
      $this->SetTextColor(0, 0, 0); //colorTexto
      $this->SetDrawColor(163, 163, 163); //colorBorde
      $this->SetFont('times', 'B', 6); // 'times' es el nombre para Times New Roman
      $this->Cell(8,  5, utf8_decode('N°'), 1, 0, 'C', 1);
      $this->Cell(10, 5, utf8_decode('COD'), 1, 0, 'C', 1);
      $this->Cell(10, 5, utf8_decode('AIR'), 1, 0, 'C', 1);
      $this->Cell(19, 5, utf8_decode('ENVIO'), 1, 0, 'C', 1);
      $this->Cell(8, 5, utf8_decode('ORIG'), 1, 0, 'C', 1);
      $this->Cell(8, 5, utf8_decode('DEST'), 1, 0, 'C', 1);
      $this->Cell(19, 5, utf8_decode('PAGO'), 1, 0, 'C', 1);
      $this->Cell(15, 5, utf8_decode('ESTADO'), 1, 0, 'C', 1);
      $this->Cell(10, 5, utf8_decode('BOB'), 1, 0, 'C', 1);
      $this->Cell(10, 5, utf8_decode('USD'), 1, 0, 'C', 1);
      $this->Cell(60, 5, utf8_decode('REMITENTE'), 1, 0, 'C', 1);
      $this->Cell(100, 5, utf8_decode('DESTINATARIO'), 1, 1, 'C', 1);

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
$pdf->SetFont('Arial', '', 12);
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

$query = ("SELECT * FROM report_chile_bolivia WHERE DATE(FECHA_ORI) BETWEEN '$from_date' AND '$to_date'");

$query_run = mysqli_query($conexion, $query);
if(mysqli_num_rows($query_run) > 0){
    foreach($query_run as $fila){     
    $i = $i + 1;
    /* TABLA */
    $pdf->SetFont('times', '', 6);
    $pdf->Cell(8,  5, utf8_decode($i), 1, 0, 'C', 0);
    $pdf->Cell(10, 5, utf8_decode($fila['CODIGO_R']), 1, 0, 'C', 0);
    $pdf->Cell(10, 5, utf8_decode($fila['AIR_R']), 1, 0, 'C', 0);
    $pdf->Cell(19, 5, utf8_decode(date('d-m-Y h:i', strtotime($fila['FECHA_ORI']))), 1, 0, 'C', 0);
    $pdf->Cell(8, 5, utf8_decode($fila['ORIGEN_R']), 1, 0, 'C', 0);
    $pdf->Cell(8, 5, utf8_decode($fila['DESTINO_R']), 1, 0, 'C', 0);
    // Aquí incluimos la lógica para la celda de la fecha
    if ($fila['FECHA_PAG'] !== null && $fila['FECHA_PAG'] !== '0000-00-00 00:00:00') {
        $pdf->Cell(19, 5, utf8_decode(date("d-m-Y H:i", strtotime($fila['FECHA_PAG']))), 1, 0, 'C', 0);
    } else {
        $pdf->Cell(19, 5, utf8_decode('Fecha no disponible'), 1, 0, 'C', 0);
    }
    $pdf->Cell(15,  5, utf8_decode($fila['ESTADO_R']), 1, 0, 'C', 0);
    $pdf->Cell(10,  5, utf8_decode(number_format($fila['MONTO_BOB'], 0)), 1, 0, 'R', 0);
    $pdf->Cell(10,  5, utf8_decode(number_format($fila['MONTO_USD'], 1)), 1, 0, 'R', 0);
    $pdf->Cell(60,  5, utf8_decode($fila['REMITENTE_R']), 1, 'L');
    $pdf->MultiCell(100,  5, utf8_decode($fila['DESTINATARIO_R']), 1, 'L');

   }
} 
// Consulta SQL para la segunda tabla
// Agrega una página en orientación horizontal al PDF
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
