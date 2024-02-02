<?php include '../conexion.php';
include '../includes/header.php';
use Carbon\Carbon;
ob_start();
require_once __DIR__ . '../../vendor/autoload.php'; ?>
<link rel="stylesheet" href="/RemesasT/assets/css/containerEliCre.css">
<!-- Formulario para enviar la fecha al servidor -->
<form method="POST" action="">
    <div class="container container-a">
        <div> 
        <label>Del Dia
        <input type="date" name="from_date" value="<?php echo isset($_POST['from_date']) ? $_POST['from_date'] : ''; ?>" class="form-control">
        </label>
        <button type="submit" class="submit-button"><i class="fas fa-search"> Buscar </i></button>
        </div>
    </div>
    <div class="container container-b">
        <div> 
        </div>
    </div>
    <div class="container-c">
        <br>
        <h1> Acta de Entrega </h1>
        <form action="" method="post" id="FormularioActaEntrega">
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
                    $from_date = $_GET['from_date'] ?? Carbon::now('America/La_Paz')->startOfDay()->toDateString();
                    
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
                            $from_date = $_POST['from_date'] ?? Carbon::now('America/La_Paz')->startOfDay()->toDateString();
                        }

                        $query = "SELECT Moneda, TOTAL_ENVIADO, CAMBIO_VENTA, TOTAL_BOLIVIANOS, CAMBIO_COMPRA_USD, TOTAL_USD, (SELECT SUM(TOTAL_USD) FROM acta_entrega WHERE DATE(FECHA_AE)='$from_date') AS TOTAL
                        FROM acta_entrega 
                        INNER JOIN tabla_monedas ON COD_MONEDA = CodigoMoneda  
                        WHERE DATE(FECHA_AE) = '$from_date';";

                        $query_run = mysqli_query($conexion, $query); 

                        if(mysqli_num_rows($query_run) > 0){
                            foreach($query_run as $fila){ ?>
                                <tr>
                                    <td id= "th"> <?php echo $fila['Moneda'] ?> </td>
                                    <td> <?php echo $fila['TOTAL_ENVIADO'] ?></td>                            
                                    <td> <?php echo $fila['CAMBIO_VENTA'] ?> </td>
                                    <td> <?php echo $fila['TOTAL_BOLIVIANOS'] ?> </td>
                                    <td> <?php echo $fila['CAMBIO_COMPRA_USD'] ?> </td>
                                    <td> <?php echo $fila['TOTAL_USD'] ?> </td>
                                </tr>
                                <?php
                            }?>
                            <tr>
                                <td id="th" colspan="5" align="center">Total Dolarizado</td>
                                <td id="total-dolarizado" class='total-dolarizado'><?php echo $fila['TOTAL'] ?></td>
                            </tr><?php
                        }?>
                </tbody>
            </table>
        </form>
    </div>
<?php include '../includes/footer.php'; ?>
<div><a href=""><p>ska.k</p></a></div>