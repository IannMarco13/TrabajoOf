$pdf->SetFont('times', '', 8);

$widths = [8, 10, 10, 10, 15, 25, 10, 15, 8, 13, 18, 68, 68]; // Anchos de las columnas
$data = [
    utf8_decode($i),
    utf8_decode($fila['AIR']),
    utf8_decode($fila['AGR']),
    utf8_decode($fila['CRD']),
    utf8_decode($fila['CODIGO']),
    utf8_decode(date('d-m-Y h:i', strtotime($fila['FECHA']))),
    utf8_decode(number_format($fila['RECIBIDO_USD'], 0)),
    utf8_decode(number_format($fila['RECIBIDO_CLP'], 0)),
    utf8_decode($fila['MONEDA']),
    utf8_decode(number_format($fila['MONTO'], 0)),
    utf8_decode($fila['ESTADO']),
    utf8_decode($fila['REMITENTE']),
    utf8_decode($fila['DESTINATARIO'])
];

$pdf->SetWidths($widths);
$pdf->Row($data);

$destinatario = utf8_decode($fila['DESTINATARIO']);
$chunks = str_split($destinatario, 50); // Dividir el texto en trozos de 50 caracteres

foreach ($chunks as $chunk) {
    $pdf->Cell(68, 5, $chunk, 1, 0, 'L');
    $pdf->Ln(); // Saltar a la siguiente línea después de cada trozo
}
