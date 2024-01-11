<?php 
require_once('encabezado.php');
require_once('conexion.php');
use Carbon\Carbon;
ob_start();
require_once __DIR__ . '/vendor/autoload.php';
// Configurar el huso horario a Bolivia
$hoy = Carbon::now('America/La_Paz')->startOfDay();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/Acta_Entrega.css">
    <script src="assets/js/Acta_Entrega.js"></script>
    <title>Acta de Entrega</title>
</head>
<body>
    <center>
        <br>
    <h1>Acta de Entrega</h1>
    </center>
        <br>
    <form action="Acta_Entrega.php">
    <table id="TablaActa" border="1">
        <thead>
            <tr>
                <th>Divisas</th>
                <th>Total Enviado</th>
                <th>Tipo de Cambio Venta</th>
                <th>Total Bolivianos</th>
                <th>Tipo de Cambio Compra (USD)</th>
                <th>Total USD</th>
            </tr>
        </thead>
            <?php
            $query = "SELECT tablamonedas.Moneda, VENTA,
            CASE 
                WHEN CODIGO_MONEDA = 'USD' THEN COMPRA
                ELSE (SELECT COMPRA FROM tp_cambio WHERE CODIGO_MONEDA = 'USD' AND Cod_agencia = '202' AND DATE(FECHA_TP) = '2024-01-11')
                END AS COMPRA
                FROM
                tp_cambio
                INNER JOIN
                tablamonedas ON tp_cambio.CODIGO_MONEDA = tablamonedas.CodigoMoneda
                WHERE
                CODIGO_MONEDA IN ('USD', 'CLP', 'BRL', 'EUR', 'ARS', 'ASD', 'CAD', 'PEN', 'GBP', 'CHF', 'NZD', 'PYG')
                AND Cod_agencia = '202'
                AND DATE(FECHA_TP) = '$hoy';";
                $result = $conexion->query($query);
                while ($row = $result->fetch_assoc()) {
                    echo "<tr align='left' data-monedas='true'>";
                    echo "<td class='moneda'>" . $row['Moneda'] . "</td>";
                    echo "<td><input type='text' name='TotalEnviado' maxlength='12' placeholder='Ingresar total' oninput='calcularDolarizado(this.parentNode.parentNode)'></td>";
                    echo "<td class='tipo-cambio-venta' >" . $row['VENTA'] . "</td>";
                    echo "<td id='resultado' class='resultado-op'  >Total (bob)</td>";
                    echo "<td class='tipo-cambio-compra'  >" . $row['COMPRA'] . "</td>";
                    echo "<td id='total' class='total-dolarizado'  >Total (usd)</td>";
                    echo "</tr>";
                }
                ?>
            <tr>
                <td colspan="2" align="center"><input type="reset">
                <input type="button" value="Ir a otra página" onclick="redirigirAotraPagina()">
                <script>
                // Función para redirigir
                function redirigirAotraPagina() {
                    window.location.href = 'ReportesPDF/Acta_EntregaPDF.php';
                }
                </script>
                </td>
                <td colspan="3" align="center">Total Dolarizado Global</td>
                <td id="total-dolarizado-global" class='Total'>0</td>
            </tr>
    </table>
    </form>
</body>
</html>