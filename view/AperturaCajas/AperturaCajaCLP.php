<?php
include '../../includes/header.php';
include '../../models/AperturaCajasModel.php';
require_once __DIR__ . '../../../vendor/autoload.php';
$AperturaCajasModel = new AperturaCajasModel();
require_once('../../controllers/AperturaCajasController.php'); 
$AperturaCajasController = new AperturaCajasController($AperturaCajasModel);
$mensaje = $AperturaCajasController->procesarFormulario();
?>

 <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
 <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
 
 <script src="/REMESAST/assets/js/AperturaCajas.js"></script>
<br>
<h1>Apertura de Caja </h1>
<form id="aperturaCajaForm" action="" method="post">   
    <div class="container container-a">
        <div>
            <br>
            <center>
                <h5> Moneda </h5>
                <select name="Moneda" class="form-controll form-control-sm" id="Moneda" onchange="redirigir()">
                <option value="0">EXT</option>
                <?php foreach ($AperturaCajasModel->ListarMonedas() as $row) { ?>
                    <option value="<?=$row->ID_TABLA_MONEDAS?>"><?=$row->Moneda?></option>
                <?php } ?>
                </select>
            </center>
        </div>
    </div>
    <div class="container container-b">
        <div>
            <br>
            <center>
                <h5>confirmar monto</h5>
                <input type="text" name="monto" id="monto"> 
                <button type="button" onclick="procesarCaja()">procesar</button> 
                <button type="button" onclick="cancelarCaja()">cancelar</button> 
            </center>
        </div>
    </div>
    <div class="container-c">
        <br><br>
        <h1>Peso Chileno [CLP]</h1>
        <br>
        <div class="table-responsive">
            <table id="TablaRemesas" border="3">
                <thead>
                    <tr>
                        <th colspan="5" id='totalOP'>Total: 0</th>
                        <input type="hidden" class="" name="totalOP[]" value="">  
                    </tr>
                    <tr align='right'>
                        <th colspan="2">corte</th> 
                        <th>fajo</th> 
                        <th>unidad</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT CodigoMoneda AS MONEDA, CORTE FROM corte_monedas WHERE CodigoMoneda = 'CLP' ORDER BY CORTE DESC";
                    $result = $conexion->query($query);
                    while ($row = $result->fetch_assoc()){
                        echo "<tr Data-Monedas='true'>";
                    ?>
                    <td>
                        <i class="fas fa-money-bill-wave"></i>
                        <i class="fas fa-coins"></i>
                    </td>
                    <?php
                        echo "<td class='Corte'>" . $row['CORTE'] . "</td>";
                        echo "<input type='hidden' class='MonedaHidden' name='Moneda[]' value='" . $row['MONEDA'] . "'>";
                        echo "<input type='hidden' class='CorteHidden' name='Corte[]' value='" . $row['CORTE'] . "'>";
                        echo "<td><input type='text' class='Fajo' name='Fajo[]' maxlength='12' placeholder='Ingresar fajo' oninput='calculaApertura(this.parentNode.parentNode)'></td>";
                        echo "<td><input type='text' class='Unidad' name='Unidad[]' maxlength='12' placeholder='Ingresar unidad' oninput='calculaApertura(this.parentNode.parentNode)'></td>";
                        echo "<td class='Total'>0</td>";
                        echo "<input type='hidden' class='TotalHidden' name='Total[]' value=''>";
                        echo "</tr>";
                    } ?>        
                </tbody>      
            </table>
            <center>
                <input class="submit-button" type="button" value="Reset" onclick="Recet3()">
                <button class="submit-button"  type="button" onclick="guardarApertura()">Guardar</button>
                <?php if (!empty($mensaje) && $_SERVER['REQUEST_METHOD'] == 'POST'): ?>
                    <p><?php echo $mensaje; ?></p>
                    <?php endif; ?>
            </center>
        </div>
    </div>
</form>
<?php include '../../includes/footer.php'; ?>
