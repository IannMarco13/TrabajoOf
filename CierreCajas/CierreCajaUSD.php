<?php
require_once('CierreCajas.php');
require_once('encabezado.php');
require_once('conexion.php');
require_once __DIR__ . '/vendor/autoload.php';
require_once('CierreCajasController.php'); 
$cierreCajasModel = new CierreCajas();
$cierreCajasController = new CierreCajasController($cierreCajasModel);
$mensaje = $cierreCajasController->procesarFormulario();
?>
 <link rel="stylesheet" href="assets/css/container.css">
 <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
 <script src="assets/js/CierreCajasB.js"></script>
 <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<h1>
    <br>
    <center>
        Cierre de Caja
    </center>
</h1>
<form id="cierreCajaForm" action="" method="post">   
    <div class="a">
        <div>
            <br>
            <center>
                <h5> moneda </h5>
                <select name="Moneda" class="form-control form-control-sm" id="Moneda" onchange="redirigir()">
                <option value="0">EXT</option>
                <?php foreach ($cierreCajasModel->ListarMonedas() as $row) { ?>
                    <option value="<?=$row->ID_TABLA_MONEDAS?>"><?=$row->Moneda?></option>
                <?php } ?>
                </select>
            </center>
        </div>
    </div>
    <div class="b">
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
<div>
    <center>
        <br><br>
        <h1>Dolar Estadounidense [USD]</h1>
        <br>
            <br><br>
            <table border="3">
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
                <?php
                ///MODELO
                $query = "SELECT CodigoMoneda AS MONEDA, CORTE FROM corte_monedas WHERE CodigoMoneda = 'USD' ORDER BY CORTE DESC";
                $result = $conexion->query($query);
                while ($row = $result->fetch_assoc()){
                    echo "<tr Data-Monedas='true'>";
                ?>
                    <td><i class="fas fa-money-bill-wave"></i>
                        <i class="fas fa-coins"></i>
                    </td>
                <?php
                    echo "<td class='Corte'>" . $row['CORTE'] . "</td>";
                    echo "<input type='hidden' class='MonedaHidden' name='Moneda[]' value='" . $row['MONEDA'] . "'>";
                    echo "<input type='hidden' class='CorteHidden' name='Corte[]' value='" . $row['CORTE'] . "'>";
                    echo "<td><input type='text' class='Fajo' name='Fajo[]' maxlength='12' placeholder='Ingresar fajo' oninput='calculaCierre(this.parentNode.parentNode)'></td>";
                    echo "<td><input type='text' class='Unidad' name='Unidad[]' maxlength='12' placeholder='Ingresar unidad' oninput='calculaCierre(this.parentNode.parentNode)'></td>";
                    echo "<td class='Total'>0</td>";
                    echo "<input type='hidden' class='TotalHidden' name='Total[]' value=''>";
                    echo "</tr>";
                }
                ?>        
            </table>
            <center>
            <input type="button" value="RECETAR" onclick="Recet2()">
            <button type="button" onclick="guardarCierre()">Guardar</button>
            <?php if (!empty($mensaje) && $_SERVER['REQUEST_METHOD'] == 'POST'): ?>
            <p><?php echo $mensaje; ?></p>
            <?php endif; ?>
            </center>
        </form>
    </center>
</div>

