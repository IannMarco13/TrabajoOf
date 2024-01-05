<?php
require('fpdf.php');
require_once ('../conexion.php');
//ob_end_clean();
use Carbon\Carbon;
require __DIR__ . '/../vendor/autoload.php';
class PDF extends FPDF
{
    private $dataExists = true;
   // Cabecera de página
   function Header()
   {
      $this->Image('img/img_world_alone.png', 10, 5, 15); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
      //$this->SetFont('Arial', 'B', 19); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(95); // Movernos a la derecha
      $this->SetTextColor(0, 0, 0); //color
      
      $this->SetTextColor(228, 100, 0);//color
      $this->Cell(1); // mover a la derecha
      $this->SetFont('times', 'B', 15);
      $this->Cell(15, 15, utf8_decode("REPORTE"), 0, 1, 'C', 0);
      $this->Ln(5);

      /* CABEZERA DE LA TABLA */
      if ($this->dataExists) {
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
        $this->Cell(50, 5, utf8_decode('REMITENTE'), 1, 0, 'C', 1);
        $this->Cell(93, 5, utf8_decode('DESTINATARIO'), 1, 1, 'C', 1);
    }

   }
   function setDataExists($dataExists)
    {
        $this->dataExists = $dataExists;
    }
   // Pie de página
   function Footer() 
   {
        $this->SetY(-15); // Posición: a 1,5 cm del final
        $this->SetFont('times', 'I', 8); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C'); //pie de pagina(numero de pagina)

        //FECHA FORMATO parte superior de la hoja
        $this->SetTextColor(0, 0, 0);
        $this->SetY(-15); // Posición: a 1,5 cm del final
        $this->SetFont('times', 'BI', 8); // Tipo de fuente: Arial, itálica, tamaño 8
        // Establecer el huso horario a Bolivia (GMT-4)
        Carbon::setLocale('es');
        Carbon::setLocale('America/La_Paz');
        // Obtener la fecha y hora actual en Bolivia con Carbon y formatearla
        $hoy = Carbon::now('America/La_Paz')->isoFormat('D [de] MMMM [de] YYYY [a las] H:mm:ss');
        $pageWidth = $this->GetPageWidth();
        $xPosition = ($pageWidth - 70) ; // Calcula la posición X para centrar
        $this->SetXY($xPosition, -(-20)); //en esta parte modificamos para que este en la parte siperior 
        $this->Cell(10, 5, utf8_decode('Fecha:'), 0, 0, 'c');
        $this->SetFont('times', '', 8);
        $this->Cell(0, 5, utf8_decode('La Paz, '.$hoy), 0, 0, 'R'); // Pie de página (fecha de página)
   }
}

$pdf = new PDF();
$pdf->AddPage('L','Letter'); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas

$i = 0;
$pdf->SetFont('times', '', 12);
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
    $pdf->setDataExists(true); // Indicar que hay datos para mostrar en la tabla
    foreach($query_run as $fila){
        $i = $i + 1;
        /* llenado de la TABLA */
        $pdf->SetFont('times', '', 5.8);
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
        $pdf->Cell(50,  5, utf8_decode($fila['REMITENTE_R']), 1, 'L');
        $pdf->MultiCell(93,  5, utf8_decode($fila['DESTINATARIO_R']), 1, 'L');
   }
} 
$pdf->setDataExists(false);
// Consulta SQL para la segunda tabla
// Agrega una página en orientación horizontal al PDF
$query_cont = "SELECT COUNT(MONEDA) AS Total_Registros FROM remesas_env_chile_bolivia WHERE DATE(FECHA) BETWEEN '$from_date' AND '$to_date' AND remesas_env_chile_bolivia.MONEDA = 'BOB'";

$query_run_cont = mysqli_query($conexion, $query_cont);

if ($query_run_cont) {
    $result = mysqli_fetch_assoc($query_run_cont);
    $Total_Registros = $result['Total_Registros'];

    // Encabezado de la tabla
    $pdf->Ln(); // Salto de línea antes de la tabla
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(50, 5,utf8_decode('Cantidad Envios[BOB]'), 1, 0, 'C', 0);// ver borde,salto de linea, posision del conetenido , nose    Salto de línea después de la fila
    // Contenido de la tabla
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(20, 5, $Total_Registros, 1, 0, 'C',0);
       // Salto de línea después de la fila

} else {
    // Manejar el error si la consulta falla
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(40, 5, 'Error en la consulta de conteo:', 0, 1);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(40, 5, mysqli_error($conexion), 0, 1);
}
$query_cont_usd = "SELECT COUNT(MONEDA) AS Total_Registros
FROM remesas_env_chile_bolivia WHERE DATE(FECHA) BETWEEN '$from_date' AND '$to_date' AND remesas_env_chile_bolivia.MONEDA = 'USD'";
$query_run_cont_usd = mysqli_query($conexion, $query_cont_usd);

if ($query_run_cont) {
    $result = mysqli_fetch_assoc($query_run_cont_usd);
    $Total_Registros = $result['Total_Registros'];
    // Encabezado de la tabla
    $pdf->Ln(); // Salto de línea antes de la tabla
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(50, 5,utf8_decode('Cantidad Envios[USD]'), 1, 0, 'C', 0);// ver borde,salto de linea, posision del conetenido , nose    Salto de línea después de la fila
    // Contenido de la tabla
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(20, 5, $Total_Registros, 1, 0, 'C',0);
       // Salto de línea después de la fila
} else {
    // Manejar el error si la consulta falla
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(40, 5, 'Error en la consulta de conteo:', 0, 1);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(40, 5, mysqli_error($conexion), 0, 1);
}

$query_T = "SELECT SUM(report_chile_bolivia.MONTO_BOB) AS Total_Monto_BOB , SUM(report_chile_bolivia.MONTO_USD) AS TOTAL_MONTO_USD FROM remesas_env_chile_bolivia INNER JOIN report_chile_bolivia ON remesas_env_chile_bolivia.AIR = report_chile_bolivia.AIR_R WHERE DATE(FECHA) BETWEEN '$from_date' AND '$to_date'";

$query_run_T = mysqli_query($conexion, $query_T);

if ($query_run_T) {
    $result = mysqli_fetch_assoc($query_run_T);
    $Total_Monto_BOB = $result['Total_Monto_BOB'];
    $TOTAL_MONTO_USD = $result['TOTAL_MONTO_USD'];

    // Encabezado de la tabla
    $pdf->Ln(); // Salto de línea antes de la tabla
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(30, 5,utf8_decode('N° TOTAL'), 1, 0, 'C', 0);
    $pdf->Cell(30, 5, utf8_decode('Total BOB'), 1,0, 'C', 0);
    $pdf->Cell(30, 5, utf8_decode('Total USD'), 1, 1,'C', 0); // ver borde,salto de linea, posision del conetenido , nose    Salto de línea después de la fila

    // Contenido de la tabla
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(30, 5, $i, 1,0, 'C',);
    $pdf->Cell(30, 5, number_format($Total_Monto_BOB), 1, 0, 'C');
    $pdf->Cell(30, 5, number_format($TOTAL_MONTO_USD), 1, 1, 'C'); // Salto de línea después de la fila

} else {
    // Manejar el error si la consulta falla
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(40, 5, 'Error en la consulta de conteo:', 0, 1);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(40, 5, mysqli_error($conexion), 0, 1);
}
}
else {
    echo '<script>alert("Fecha incorrecta"); window.location.href = "../RepComEStado.php";</script>';
}
$pdf->Output('Remesas Chile Bolivia '.$from_date.'.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)
?>
