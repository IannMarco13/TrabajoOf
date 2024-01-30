<?php
include '../includes/header.php';
require_once __DIR__ . '../../vendor/autoload.php';
$cont = 0;
require_once '../controllers/RemesasChileBoliviaController.php';
require_once '../models/RemesasChileBoliviaModel.php';
$model = new RemesasModel();
$controller = new RemesasController($model);
$from_date = $_GET['from_date'] ?? null;
$to_date = $_GET['to_date'] ?? null;
$remesas = $controller->mostrarRemesas($from_date, $to_date);
?>
<div class="container container-a">
        <div> 
        </div>
    </div>
    <div class="container container-b">
        <div> 
        </div>
    </div>
    <div class="container-c">
        <br>
        <h1>Pagado Mismo Dia</h1>
        <form action="" method="GET">
                <div class="row">
                    <div class="container-c1">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Del Dia
                                <input type="date" name="from_date" value="<?php echo isset($_GET['from_date']) ? $_GET['from_date'] : ''; ?>" class="form-control"></label>
                                <label>Hasta el Dia</label>
                                <input type="date" name="to_date" value="<?php echo isset($_GET['to_date']) ? $_GET['to_date'] : ''; ?>" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="container-c2">
                        <div class="col-md-4">
                            <br>
                            <div class="form-group btn-group">
                                <button type="submit" class="submit-button"><i class="fas fa-search"></i> Buscar</button>
                                <!--hacemos que los datos de los canlendarios se guaden y puedan ser re usados-->
                                <a href="ReportesPDF/ReporteChilePDF.php?from_date=<?php echo $from_date; ?>&to_date=<?php echo $to_date; ?>" target="_blank" class="submit-button">
                                <i class="far fa-file-pdf"></i> Generar Reporte</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table id="TablaRemesas" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>CODIGO T1</th>
                            <th>REMITENTE</th>
                            <th>FECHA ENVIO T1</th>
                            <th>ESTADO</th>
                            <th>MONTO</th>
                            <th>DESTINATARIO</th>
                            <th>FECHA PAGO</th>
                            <th>ESTADO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(isset($_GET['from_date']) && isset($_GET['to_date'])){
                            $query ="SELECT remesas_env_chile_bolivia.CODIGO,remesas_env_chile_bolivia.REMITENTE, remesas_env_chile_bolivia.FECHA,remesas_env_chile_bolivia.ESTADO,remesas_env_chile_bolivia.MONTO,SUBSTRING_INDEX(DESTINATARIO, ' // ', 1) AS DESTINATARIO, report_chile_bolivia.FECHA_PAG,report_chile_bolivia.ESTADO_R FROM remesas_env_chile_bolivia INNER JOIN report_chile_bolivia ON remesas_env_chile_bolivia.CODIGO = report_chile_bolivia.CODIGO_R WHERE remesas_env_chile_bolivia.ESTADO = report_chile_bolivia.ESTADO_R AND remesas_env_chile_bolivia.ESTADO = 'PAGADO' AND DATE(FECHA)BETWEEN '$from_date' AND '$to_date' ORDER BY FECHA ASC;";
                            $query_run = mysqli_query($conexion, $query);
                            if(mysqli_num_rows($query_run) > 0){
                                foreach($query_run as $fila){
                                    $cont++;
                                    $DESTINATARIO = $fila['DESTINATARIO'];
                                    ?>
                                    <tr>
                                        <td> <?php echo $cont; ?></td>
                                        <td> <?php echo $fila['CODIGO'] ?> </td>
                                        <td> <?php echo $fila['REMITENTE'] ?> </td>
                                        <td> <?php echo date("d-m-Y", strtotime($fila['FECHA'])) ?> </td>
                                        <td> <?php echo $fila['ESTADO'] ?> </td>
                                        <td> <?php echo $fila['MONTO'] ?> </td>
                                        <td> <?php echo $DESTINATARIO ?> </td>
                                        <td> <?php echo date("d-m-Y", strtotime($fila['FECHA_PAG'])) ?> </td>
                                        <td> <?php echo $fila['ESTADO_R'] ?> </td>
                                    </tr>
                                    <?php
                                    }
                                }else{?>
                                 <tr>
                                    <td><?php  echo "No se encontraron resultados"; ?></td>
                                </tr>
                        <?php   }
                        } ?>
                    </tbody>
                    </table> <?php  mysqli_close($conexion); ?>
                </div>
            </div>
        <script src="../assets/js/PieTablas.js"></script>
    </div>
</body>
<?php include '../includes/footer.php'; ?>