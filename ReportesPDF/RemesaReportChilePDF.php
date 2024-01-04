<?php
require('fpdf.php');
use Carbon\Carbon;
require __DIR__ . '/../vendor/autoload.php';
require_once ('../conexion.php');
class PDF extends FPDF {
  // Cabecera de página
   function Header()
   {
      $this->Image('img/logo.png', 15, 5, 20); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
      $this->SetFont('Arial', 'B', 19); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(95); // Movernos a la derecha
      $this->SetTextColor(0, 0, 0); //color
      //creamos una celda o fila
      //CENTREAMOS EL TITULO EN EL MEDIO DE LA HOJA
      $pageWidth = $this->GetPageWidth();
      $xPosition = ($pageWidth - 25) / 2; // Calcula la posición X para centrar
      $this->SetXY($xPosition, 15); // Establece la posición X y Y para centrar
      $this->Cell(25, 25, utf8_decode('GAMBARTE'), 0, 1, 'C', 0);// AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
      $this->Ln(1); // Salto de línea
      /* letras pequenas */ 
      $this->SetTextColor(103); //PARA PODER CAMBIAR EL COLOR DE LA LETRA TIENE QUE ESTAR ENSIMA DE TODO
      $this->Cell(100); // mover a la derecha
      $this->SetFont('Arial', 'I', 8);
      $pageWidth = $this->GetPageWidth();
      $xPosition = ($pageWidth - 25) / 2; // Calcula la posición X para centrar
      $this->SetXY($xPosition, 20); // Establece la posición X y Y para centrar
      $this->Cell(25, 25, utf8_decode('Giros-Remesas de Dienro'), 0, 1, 'C', 0);
    
      $this->Ln(5);

      $this->SetTextColor(228, 100, 0);//color
      $this->Cell(100); // mover a la derecha
      $this->SetFont('Arial', 'B', 15);
      $pageWidth = $this->GetPageWidth();
      $xPosition = ($pageWidth - 25) / 2; // Calcula la posición X para centrar
      $this->SetXY($xPosition, 30); // Establece la posición X y Y para centrar
      $this->Cell(25, 25, utf8_decode("REPORTE DE REMESAS"), 0, 1, 'C', 0);
      $this->Ln(7);
   }
   // Pie de página
   function Footer()
   {
      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $pageWidth = $this->GetPageWidth();
      $xPosition = ($pageWidth - 25) / 2; // Calcula la posición X para centrar
      $this->SetXY($xPosition, -25); 
      //$this->Cell(25, 25, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C'); //pie de pagina(numero de pagina)

     //FECHA FORMATO 
     $this->SetY(-15); // Posición: a 1,5 cm del final
     $this->SetFont('Arial', 'I', 8); // Tipo de fuente: Arial, itálica, tamaño 8
     // Obtener la fecha actual con Carbon y formatearla
     $hoy = Carbon::now()->locale('es_ES')->isoFormat('D [de] MMMM [de] YYYY');
     $pageWidth = $this->GetPageWidth();
     $xPosition = ($pageWidth - 25) / 2; // Calcula la posición X para centrar
     $this->SetXY($xPosition, -30); 
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

$totalMontoFinal = round($totalMontoBob / 6.86 , 2) + $totalMontoUsd ;

// Crear un nuevo objeto FPDF
$pdf = new PDF();
$pdf->AddPage("portrait");
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas
$i = 0;
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, utf8_decode('Gambarte Chile SpA :'), 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->SetDrawColor(163, 163, 163);
// Establecer la fuente y el tamaño del texto
$pdf->SetFont('Arial', '', 12);
// Contenido del PDF
$pdf->Cell(0, 10, utf8_decode('Monto Total Enviado en Bolivianos: '), 0, 0);
$pdf->Cell(0, 10, $totalMontoBob.' Bs.', 0, 1, 'R');

$pdf->Cell(0, 10, utf8_decode('Monto Total Enviado en Dolar Estado Unidence: ') , 0, 0);
$pdf->Cell(0,10, $totalMontoUsd .' Usd.',0,1,'R');

$pdf->Cell(0, 10, utf8_decode('Monto Total Enviado por Gambarte SpA en Dolar Estado Unidence:'), 0, 0);
$pdf->Cell(0,10, $totalMontoFinal.' Usd.',0,1,'R') ;
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0,10, utf8_decode('Gambarte Bolivia S.R.L:') ,0,1);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, utf8_decode('Monto Total Enviado en Bolivianos: '), 0, 0);
$pdf->Cell(0, 10, $totalMontoEnviadoBOB.' Bs.', 0, 1, 'R');
$pdf->Cell(0, 10, utf8_decode('Monto Total Enviado en Dolar Estado Unidence: ') , 0, 0);
$pdf->Cell(0, 10,$totalMontoEnviado.' Usd.',0,1,'R');
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0,10, utf8_decode('Diferencia:') ,0,1);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0,10, utf8_decode('Total Diferencia en Dolar Estado Unidence:') ,0, 0);

if ($totalMontoFinal > $totalMontoEnviado){
  $diferencia = abs($totalMontoFinal -$totalMontoEnviado);
  $pdf->Cell(0, 10, $diferencia.' Usd.', 0, 1,'R');

  $pdf->Ln(25);
  $pdf->MultiCell(180, 10,utf8_decode('En fecha ') . date("d-m-Y", strtotime($from_date)) . utf8_decode(' a fecha ') . date("d-m-Y", strtotime($to_date)) . utf8_decode(' Gambarte SpA envió ') . $totalMontoEnviado . utf8_decode(' Dólar Estadounidense a Gambarte S.R.L. con una diferencia de ') . $diferencia, 0, 'J');

//  echo "La diferencia de envio entre Chile - Bolivia es: ".$diferencia."<br>";
}else {
  $diferencia = abs($totalMontoFinal - $totalMontoEnviado);
  $pdf->Cell(0, 10, $diferencia.' Usd.', 0, 1, 'R');

  $pdf->Ln(25);
  $pdf->MultiCell(180, 10,utf8_decode('En fecha ') . date("d-m-Y", strtotime($from_date)) . utf8_decode(' a fecha ') . date("d-m-Y", strtotime($to_date)) . utf8_decode(' Gambarte S.R.L. envió ') . $totalMontoEnviado . utf8_decode(' Usd. a Gambarte SpA con una diferencia de ') . $diferencia.' Usd.', 0, 'J');
}

// Nombre del archivo PDF
$fileName = 'reporte_envios.pdf';

// Salida del PDF para mostrar en una ventana nueva
$pdf->Output($fileName, 'I');
?>

