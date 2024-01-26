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
<body>
    <div class="container container-a">
        <div> 
        </div>
    </div>
    <div class="container container-b">
        <div> 
        </div>
    </div>
    <div class="container-c">
        <h1 class="Tutulo">Reporte Chile Bolivia</h1>
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
                                <button type="submit" class="submit-button"><i class="fas fa-search">Buscar</i> </button>
                                <a href="ReportesPDF/ReporteChilePDF.php?from_date=<?php echo isset($_GET['from_date']) ? $_GET['from_date'] : ''; ?>&to_date=<?php echo isset($_GET['to_date']) ? $_GET['to_date'] : ''; ?>" target="_blank" class="btn-custom">
                                <i class="far fa-file-pdf"> Generar Reporte </i></a>
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
                            <th>CODIGO</th>
                            <th>AIR</th>
                            <th>FECHA ORIGEN</th>
                            <th>ORIGEN</th>
                            <Th>DESTINO</Th>
                            <th>FECHA PAGO</th>
                            <th>ESTADO</th>
                            <th>MONTO BOB</th>
                            <th>MONTO USD</th>
                            <th>REMITENTE</th>
                            <th>DESTINATARIO</th>
                        </tr>
                    </thead>
                <tbody>
                    <?php 
                    if(isset($_GET['from_date']) && isset($_GET['to_date'])){
                        
                        $query ="SELECT * FROM report_chile_bolivia WHERE DATE(FECHA_ORI) BETWEEN '$from_date' AND '$to_date' ORDER BY FECHA_ORI ASC";
                        $query_run = mysqli_query($conexion, $query);
                        if(mysqli_num_rows($query_run) > 0){
                            foreach($query_run as $fila){ 
                                $cont++;?>
                            <tr>
                                <td> <?php echo $cont ?> </td>
                                <td> <?php echo $fila['CODIGO_R'] ?> </td>
                                <td> <?php echo $fila['AIR_R'] ?> </td>
                                <!--<td> <?php echo $fila['FECHA_ORI'] ?> </td>-->
                                <td> <?php echo date("d-m-Y h:i", strtotime($fila['FECHA_ORI'])) ?></td>   
                                <td> <?php echo $fila['ORIGEN_R'] ?> </td>
                                <td> <?php echo $fila['DESTINO_R'] ?> </td>
                                <!-- Como en la BD las fechas de exel que estan con campos "-" los guarda como 0000-00-00 00:00:00 usando este comando se Haregla-->
                                <?php if ($fila['FECHA_PAG'] !== null && $fila['FECHA_PAG'] !== '0000-00-00 00:00:00') { ?>
                                <td><?php echo date("d-m-Y H:i", strtotime($fila['FECHA_PAG'])); ?></td>
                                <?php } else { ?>
                                <td>Fecha no disponible</td>
                                <?php } ?>
                                <td> <?php echo $fila['ESTADO_R'] ?> </td>
                                <td> <?php echo $fila['MONTO_BOB'] ?> </td>
                                <td> <?php echo $fila['MONTO_USD'] ?> </td>
                                <td> <?php echo $fila['REMITENTE_R'] ?> </td>  
                                <td> <?php echo $fila['DESTINATARIO_R'] ?> </td>
                                
                            </tr>                        
                            <?php
                            }
                        }else{?>
                        <tr>
                            <td><?php  echo "No se encontraron resultados"; ?></td>
                        <?php }                                
                    } 
                        ?>
                    </tbody>
                    </table>
                    <?php  mysqli_close($conexion); ?>
                </div>
            </div>
        <script src="../assets/js/PieTablas.js"></script>
    </div>
</body>
<?php include '../includes/footer.php'; ?>