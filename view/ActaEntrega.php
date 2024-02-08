<?php 
include '../includes/header.php';
require_once __DIR__ . '../../vendor/autoload.php';
use Carbon\Carbon;
$hoy = $_POST['from_date'] ?? Carbon::now('America/La_Paz')->startOfDay()->toDateString();
require_once ('../models/ActaEntregaModel.php');
$ActaEntregaModel = new ActaEntregaModel();
require_once('../controllers/ActaEntregaController.php'); 
$ActaEntregaController = new ActaEntregaController($ActaEntregaModel);
$mensaje = $ActaEntregaController->prosesarActa();
?>

<link rel="stylesheet" href="/RemesasT/assets/css/containerEliCre.css">
<script src="../assets/js/Acta_Entrega.js"></script>
<br>    
<h1>Acta de Entrega</h1>
<form method="POST" action="" id="FormularioActaEntrega">
    <div class="container container-a">
        <div>
        </div>
    </div>
    <div class="container container-b">
        <div> 
        </div>
    </div>
    <div class="container-c">
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
            <tbody>
            <?php
            $query = "SELECT MAX(DATE(FECHA_TP)) AS Ult_fecha FROM tp_cambio;";
            $query_run = mysqli_query($conexion, $query);

            if ($row = mysqli_fetch_assoc($query_run)) {
                $hoy = $row['Ult_fecha'];
            } else {
                $hoy = Carbon::now('America/La_Paz')->startOfDay()->toDateString();
            }

            $query = "SELECT tabla_monedas.Moneda,tabla_monedas.CodigoMoneda, VENTA, FECHA_TP,
            CASE WHEN CODIGO_MONEDA = 'USD' THEN COMPRA
            ELSE (SELECT COMPRA FROM tp_cambio WHERE CODIGO_MONEDA = 'USD' AND Cod_agencia = '202' AND DATE(FECHA_TP) = '$hoy')END AS COMPRA
            FROM tp_cambio INNER JOIN tabla_monedas ON tp_cambio.CODIGO_MONEDA = tabla_monedas.CodigoMoneda
            WHERE CODIGO_MONEDA IN ('USD', 'CLP', 'BRL', 'EUR', 'ARS', 'ASD', 'CAD', 'PEN', 'GBP', 'CHF', 'NZD', 'PYG') AND Cod_agencia = '202' AND DATE(FECHA_TP) = '$hoy';";

            $result = $conexion->query($query);
            while ($row = $result->fetch_assoc()) {
                echo "<tr data-monedas='true'>"; 
                echo "<td id='th' class='moneda'>" . $row['Moneda'] . "</td>";
                echo "<input type='hidden' class='Cod_MonedaHidden' name='Cod_Moneda[]' value='" . $row['CodigoMoneda'] . "'>";
                echo "<td><input type='text' class='TotalEnviado' id='TotalEnviado' name='TotalEnviado[]' maxlength='12' placeholder='Ingresar total' oninput='calcularDolarizado(this.parentNode.parentNode)'></td>";
                echo "<td class='tipo-cambio-venta'>" . $row['VENTA'] . "</td>";
                echo "<input type='hidden' class='VentaHidden' name='Venta[]' value='". $row['VENTA'] . "'>";
                echo "<td id='resultado' class='resultado-op' >Total (bob)</td>";
                echo "<td class='tipo-cambio-compra'>". $row['COMPRA'] ."</td>";
                echo "<input type='hidden' class='CompraHidden' name='Compra[]' value='". $row['COMPRA'] ."'>";
                echo "<td id='total' class='total'>0</td>";
                echo "<input type='hidden' class='monedaHidden' name='moneda[]' value='".$row['Moneda']."'>";
                echo "<input type='hidden' class='totalEnviado' name='totalEnviado[]'  value=''>";
                echo "<input type='hidden' class='resultadoOp' name='resultadoOp[]' value=''>";
                echo "<input type='hidden' class='total' name='total[]' value=''>";
                echo "</tr>"; 
                $fec=$row['FECHA_TP'];
            } echo 'Fecha: '. date('d-m-Y', strtotime($fec)); ?>
                <tr> 
                    <td id="th" colspan="5" align="center">Total Dolarizado</td>
                    <td id="total-dolarizado" class='total-dolarizado'>0</td>
                    <input type="hidden" class="totalGloval" name="totalGloval[]" value="">
                </tr>
            </tbody>
        </table>
        <center>
            <br>
            <button class="submit-button" type="button" onclick="Reset()"><i class="fas fa-redo-alt"></i> Reset</i></button>
            <button class="submit-button" type="button" onclick="GuardarActa()"><i class="far fa-folder"> Guardar</i></button>
            <?php if (!empty($mensaje) && $_SERVER['REQUEST_METHOD'] == 'POST'): ?>
                    <p><?php echo $mensaje; ?></p>
                    <?php endif; ?>
            <button class="submit-button" type="button" onclick="Imprimir()"><i class="far fa-file-pdf"> Imprimir</i></button>
            <button class="submit-button" type="button" onclick="Consulta()"> Consulta</i></button>
            <br><br>
        </center>
    </div>
</form>
<?php 
 include '../includes/footer.php';
?>