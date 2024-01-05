<?php
require('fpdf.php');
use Carbon\Carbon;
require __DIR__ . '/../vendor/autoload.php';
require_once ('../conexion.php');
class PDF extends FPDF {
  // Cabecera de página
   function Header()
   {
      // con dimensiones que cubren toda la página.
      $this->Image('img/imgPdf.png', 0, 0, $this->GetPageWidth(), $this->GetPageHeight()); // ponermos img como marca de agua ('0,0' posicion X,Y)
      //$this->Image('img/logo.png', 15, 5, 20); logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
      $this->SetFont('Arial', 'B', 19); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(95); // Movernos a la derecha
      $this->SetTextColor(0, 0, 0); //color
      //creamos una celda o fila  
      //CENTREAMOS EL TITULO EN EL MEDIO DE LA HOJA
      $pageWidth = $this->GetPageWidth();
      $xPosition = ($pageWidth - 25) / 2; // Calcula la posición X para centrar
      $this->SetXY($xPosition, 15); // Establece la posición X y Y para centrar
      //$this->Cell(25, 25, utf8_decode('GAMBARTE'), 0, 1, 'C', 0);// AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
      $this->Ln(1); // Salto de línea
      /* letras pequenas */ 
      $this->SetTextColor(103); //PARA PODER CAMBIAR EL COLOR DE LA LETRA TIENE QUE ESTAR ENSIMA DE TODO
      $this->Cell(100); // mover a la derecha
      $this->SetFont('Arial', 'I', 8);
      $pageWidth = $this->GetPageWidth();
      $xPosition = ($pageWidth - 25) / 2; // Calcula la posición X para centrar
      $this->SetXY($xPosition, 20); // Establece la posición X y Y para centrar
      //$this->Cell(25, 25, utf8_decode('Giros-Remesas de Dienro'), 0, 1, 'C', 0);
    
      $this->Ln(5);

      $this->SetTextColor(228, 100, 0);//color
      $this->Cell(100); // mover a la derecha
      $this->SetFont('Arial', 'B', 15);
      $pageWidth = $this->GetPageWidth();
      $xPosition = ($pageWidth - 25) / 2; // Calcula la posición X para centrar
      $this->SetXY($xPosition, 30); // Establece la posición X y Y para centrar
      $this->Cell(25, 25, utf8_decode("REPORTE DE CONCILIACÍN DE REMESAS"), 0, 1, 'C', 0);
      $this->Ln(1);
   }
   private $pageCount = 0;
   // Pie de página
   function Footer()
  {
    $this->SetY(-15); // Colocar 15 unidades desde la parte inferior
    // Establecer la fuente y tamaño del texto para el pie de página
    $pageWidth = $this->GetPageWidth();
    $xPosition = ($pageWidth - 190) / 2; // Calcula la posición X para centrar
    $this->SetXY($xPosition, -30);
    $this->SetTextColor(100, 100, 100);
    // Mensaje en el pie de página
    $this->SetFont('Arial', 'BI', 8);
    $this->SetLineWidth(1); // Grosor de línea 1 mm
    $this->SetDrawColor(255, 128, 0); // Color naranja (RGB) para la linea
    $this->Cell(0, 5, utf8_decode('Casa Matriz'), 'T', 1, 'L',0); // Centro el texto en el cuado tambien existe LTRB para los ordes L=izq, T= arrba, R=der, B = abajo
    $this->SetFont('Arial', 'I', 8);
    $this->Cell(0, 5, utf8_decode('Calle Mercado N° 1335, PB'), 0, 1, 'L');
    $this->Cell(0, 5, utf8_decode('Oficina 102'), 0, 1, 'L');
    $this->SetFont('Arial', 'BI', 8);
    $this->Cell(0, 5, utf8_decode('Teléfono: +591 2200020'), 0, 1, 'L');
    $this->Cell(0, 5, utf8_decode('Celular: +591 683 55517'), 0, 1, 'L');

    $this->pageCount++;
    // Mostrar el número de página solo si el conteo de páginas es mayor que 2
    if ($this->pageCount > 2) {
      $this->SetTextColor(100, 100, 100);
      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8);

      $pageWidth = $this->GetPageWidth();
      $xPosition = ($pageWidth - 25); // Calcula la posición X para centrar
      $this->SetXY($xPosition, -40); 
      $this->Cell(25, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'R');
    }
    //FECHA FORMATO 
    $this->SetTextColor(0, 0, 0);
    $this->SetY(-15); // Posición: a 1,5 cm del final
    $this->SetFont('Arial', 'I', 8); // Tipo de fuente: Arial, itálica, tamaño 8
    // Establecer el huso horario a Bolivia (GMT-4)
    Carbon::setLocale('es');
    Carbon::setLocale('America/La_Paz');
    // Obtener la fecha y hora actual en Bolivia con Carbon y formatearla
    $hoy = Carbon::now('America/La_Paz')->isoFormat('D [de] MMMM [de] YYYY [a las] H:mm:ss');
    $pageWidth = $this->GetPageWidth();
    $xPosition = ($pageWidth - 25) / 2; // Calcula la posición X para centrar
    $this->SetXY($xPosition, -45); 
    $this->Cell(25, 25, utf8_decode('La Paz, '.$hoy), 0, 0, 'C'); // Pie de página (fecha de página)

   }
}
// Obtener las fechas
$from_date = $_GET['from_date'] ?? null;
//var_dump($from_date);
$to_date = $_GET['to_date'] ?? null;
//var_dump($to_date);

$queryBob = "SELECT SUM(MONTO_BOB) AS total_monto_bob FROM report_chile_bolivia WHERE DATE(FECHA_ORI) BETWEEN '$from_date' AND '$to_date'";

$resultBob = $conexion->query($queryBob);
$rowBob = $resultBob->fetch_assoc();
$totalMontoBob = $rowBob['total_monto_bob'];

// Consulta para obtener el total de MONTO_USD
$queryUsd = "SELECT SUM(MONTO_USD) AS total_monto_usd FROM report_chile_bolivia WHERE DATE(FECHA_ORI) BETWEEN '$from_date' AND '$to_date'";

$resultUsd = $conexion->query($queryUsd);
$rowUsd = $resultUsd->fetch_assoc();
$totalMontoUsd = $rowUsd['total_monto_usd'];

// Consulta para obtener el total de MONTO_ENV entre las fechas
$queryMontoEnviado = "SELECT SUM(MONTO_ENV) AS total_monto_enviado FROM remesas_bolivia_chile WHERE DATE(FECHA_B) BETWEEN '$from_date' AND '$to_date'";

$resultMontoEnviado = $conexion->query($queryMontoEnviado);
$rowMontoEnviado = $resultMontoEnviado->fetch_assoc();
$totalMontoEnviado = $rowMontoEnviado['total_monto_enviado'];

// Consulta para obtener el total de MONTO_BOB entre las fechas
$queryMontoEnviadoBOB = "SELECT SUM(MONTO_BOB_B) AS total_monto_enviado FROM remesas_bolivia_chile WHERE DATE(FECHA_B) BETWEEN '$from_date' AND '$to_date'";

$resultMontoEnviadoBOB = $conexion->query($queryMontoEnviadoBOB);
$rowMontoEnviadoBOB = $resultMontoEnviadoBOB->fetch_assoc();
$totalMontoEnviadoBOB = $rowMontoEnviadoBOB['total_monto_enviado'];

// Realizar cálculos
$totalBOB_USD = round($totalMontoBob / 6.86 , 2);
$totalUSD_BOB = round($totalMontoUsd * 6.86 , 2);
$totalBOB = round( $totalMontoBob + $totalUSD_BOB,2);
$totalUSD = round( $totalMontoUsd + $totalBOB_USD,2);
$totalBob_SRL =  round($totalMontoEnviadoBOB / 6.86, 2);

$BOBTotal = abs( $totalBOB - $totalMontoEnviadoBOB);
$USDTotal = abs( $totalUSD - $totalMontoEnviado);
$totalMontoFinal = round($totalMontoBob / 6.86 , 2) + $totalMontoUsd ;

// Crear un nuevo objeto FPDF
$pdf = new PDF();
$pdf->AddPage('P','Letter');
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas
$i = 0;
$pdf->SetFont('times', 'B', 12);
$pdf->Cell(0, 10, utf8_decode('Gambarte Chile S.p.A. :'), 0, 1);

$pdf->SetDrawColor(163, 163, 163);
// Establecer la fuente y el tamaño del texto
$pdf->SetFont('times', '', 12);
// Contenido del PDF
$pdf->Cell(0, 5, utf8_decode('Monto Total Enviado en Bolivianos: '), 0, 0);
$pdf->Cell(-15, 5, $totalMontoBob.' Bs.', 0  , 1, 'R');

$pdf->Cell(0, 5, utf8_decode('Monto Total Enviado en Dolar Estado Unidence: ') , 0, 0);
$pdf->Cell(-15, 5, $totalMontoUsd .' Usd.',0,1,'R');
$pdf->Ln(5);
$pdf->Cell(60, 6, utf8_decode(''), 0, 0,'C');
$pdf->SetFillColor(242, 129, 87);
$pdf->Cell(50, 6, utf8_decode('BOLIVIANOS'), 1, 0,'C',1); 
$pdf->Cell(50, 6, utf8_decode('DOLARES'), 1, 1,'C',1);
$pdf->Cell(35, 6, utf8_decode(''), 0, 0,'C');
$pdf->Cell(25, 6, utf8_decode('ENVIADO'), 1, 0,'C',1); 
$pdf->Cell(50, 6, utf8_decode($totalMontoBob), 1, 0,'R'); 
$pdf->Cell(50, 6, utf8_decode($totalBOB_USD), 1, 1,'R');
$pdf->Cell(35, 6, utf8_decode(''), 0, 0,'C');
$pdf->Cell(25, 6, utf8_decode('ENVIADO'), 1, 0,'C',1);
$pdf->Cell(50, 6, utf8_decode($totalUSD_BOB), 1, 0,'R');
$pdf->Cell(50, 6, utf8_decode($totalMontoUsd), 1, 1,'R');
$pdf->Cell(35, 6, utf8_decode(''), 0, 0,'C');
$pdf->Cell(25, 6, utf8_decode('TOTAL'), 1, 0,'C',1); 
$pdf->Cell(50, 6, utf8_decode($totalBOB), 1, 0,'R');
$pdf->Cell(50, 6, utf8_decode($totalUSD), 1, 1,'R');
$pdf->Ln(5);
$pdf->Cell(0, 5, utf8_decode('Monto Total Enviado por Gambarte SpA en Dolar Estado Unidence:'), 0, 0);
$pdf->Cell(-15, 5, $totalMontoFinal.' Usd.',0,1,'R') ;
$pdf->Ln(5);
$pdf->SetFont('times', 'B', 12);
$pdf->Cell(0, 5, utf8_decode('Gambarte Bolivia S.R.L:') ,0,1);
$pdf->SetFont('times', '', 12);
$pdf->Cell(0, 5, utf8_decode('Monto Total Enviado en Bolivianos: '), 0, 0);
$pdf->Cell(-15, 5, $totalMontoEnviadoBOB.' Bs.', 0, 1, 'R');
$pdf->Cell(0, 5, utf8_decode('Monto Total Enviado en Dolar Estado Unidence: ') , 0, 0);
$pdf->Cell(-15, 5,$totalMontoEnviado.' Usd.',0,1,'R');

$pdf->Ln(5);
$pdf->Cell(60, 6, utf8_decode(''), 0, 0,'C');
$pdf->Cell(50, 6, utf8_decode('BOLIVIANOS'), 1, 0,'C',1); 
$pdf->Cell(50, 6, utf8_decode('DOLARES'), 1, 1,'C',1);
$pdf->Cell(35, 6, utf8_decode(''), 0, 0,'C');
$pdf->Cell(25, 6, utf8_decode('ENVIADO'), 1, 0,'C',1);
$pdf->Cell(50, 6, utf8_decode($totalMontoEnviadoBOB), 1, 0,'R');
$pdf->Cell(50, 6, utf8_decode($totalBob_SRL), 1, 1,'R');
$pdf->Cell(35, 6, utf8_decode(''), 0, 0,'C');
$pdf->SetFillColor(242, 129, 87);
$pdf->Cell(25, 6, utf8_decode('TOTAL'), 1, 0,'C',1); 
$pdf->Cell(50, 6, utf8_decode($totalMontoEnviadoBOB), 1, 0,'R');
$pdf->Cell(50, 6, utf8_decode($totalMontoEnviado), 1, 1,'R');

$pdf->Ln(5);
$pdf->SetFont('times', 'B', 12);
$pdf->Cell(0, 5, utf8_decode('Diferencia:') ,0,1);
$pdf->SetFont('times', '', 12);
$pdf->Ln(5);
$pdf->Cell(25, 6, utf8_decode(''), 0, 0,'C');
$pdf->Cell(50, 6, utf8_decode('TOTAL ENVIADO'), 1, 0,'C',1);
$pdf->SetFillColor(242, 129, 87);
$pdf->Cell(50, 6, utf8_decode('BOLIVIANOS'), 1, 0,'C',1); 
$pdf->Cell(50, 6, utf8_decode('DOLARES'), 1, 1,'C',1);
$pdf->Cell(25, 6, utf8_decode(''), 0, 0,'C');
$pdf->Cell(50, 6, utf8_decode('GAMBARTE S.p.A.'), 1, 0,'C',1); 
$pdf->Cell(50, 6, utf8_decode($totalBOB), 1, 0,'R'); 
$pdf->Cell(50, 6, utf8_decode($totalUSD), 1, 1,'R');
$pdf->Cell(25, 6, utf8_decode(''), 0, 0,'C');
$pdf->Cell(50, 6, utf8_decode('GAMBARTE S.R.L.'), 1, 0,'C',1);
$pdf->Cell(50, 6, utf8_decode($totalMontoEnviadoBOB), 1, 0,'R');
$pdf->Cell(50, 6, utf8_decode($totalMontoEnviado), 1, 1,'R');
$pdf->Cell(25, 6, utf8_decode(''), 0, 0,'C');
$pdf->Cell(50, 6, utf8_decode('DIFERENCIA'), 1, 0,'C',1); 
$pdf->Cell(50, 6, utf8_decode($BOBTotal), 1, 0,'R');
$pdf->Cell(50, 6, utf8_decode($USDTotal), 1, 1,'R');
$pdf->Ln(5);

$pdf->SetFont('times', '', 12);
$pdf->Cell(0, 5, utf8_decode('Total Diferencia en Dolar Estado Unidence:') ,0, 0);

if ($totalMontoFinal > $totalMontoEnviado){
  $diferencia = abs($totalMontoFinal -$totalMontoEnviado);
  $pdf->Cell(-15, 5, $diferencia.' Usd.', 0, 1,'R');

  $pdf->Ln(10);
  $pdf->MultiCell(180, 10,utf8_decode('En fecha ') . date("d-m-Y", strtotime($from_date)) . utf8_decode(' a fecha ') . date("d-m-Y", strtotime($to_date)) . utf8_decode(' Gambarte SpA envió ') . $totalMontoEnviado . utf8_decode(' Dólar Estadounidense a Gambarte S.R.L. con una diferencia de ') . $diferencia, 0, 'J');

//  echo "La diferencia de envio entre Chile - Bolivia es: ".$diferencia."<br>";
}else {
  $diferencia = abs($totalMontoFinal - $totalMontoEnviado);
  $pdf->Cell(-15, 5, $diferencia.' Usd.', 0, 1, 'R');

  $pdf->Ln(10);
  $pdf->MultiCell(180, 10,utf8_decode('En fecha ') . date("d-m-Y", strtotime($from_date)) . utf8_decode(' a fecha ') . date("d-m-Y", strtotime($to_date)) . utf8_decode(' Gambarte S.R.L. envió ') . $totalMontoEnviado . utf8_decode(' Usd. a Gambarte SpA con una diferencia de ') . $diferencia.' Usd.', 0, 'J');
}

// Nombre del archivo PDF
$fileName = 'reporte_envios.pdf';

// Salida del PDF para mostrar en una ventana nueva
$pdf->Output($fileName, 'I');
?>

