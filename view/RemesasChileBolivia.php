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
    <div class="container-a">
        <div> 
        </div>
    </div>
    <div class="container-b">
        <div>    
        </div>
    </div>
    <div class="container-c">
        <br>
        <h1> Remesas Chile Bolivia</h1>
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
                                <center>
                                <button type="submit" class="submit-button"><i class="fas fa-search"> Buscar </i></button>
                                <a href="ReportesPDF/RemesasChilePDF.php?from_date=<?php echo isset($_GET['from_date']) ? $_GET['from_date'] : ''; ?>&to_date=<?php echo isset($_GET['to_date']) ? $_GET['to_date'] : ''; ?>" target="_blank" class="btn-custom">
                                <i class="fas fa-print"> Imprimir Tabla</i> </a>
                                <a href="ReportesPDF/RemesaReportChilePDF.php?from_date=<?php echo $from_date; ?>&to_date=<?php echo $to_date; ?>" target="_blank" class="btn-custom">
                                <i  class="far fa-file-pdf"> Generar Consulta </i></a>
                                <a href="ReporteChileBolivia.php" target="_blank" class="btn-custom"><i class="far fa-file"> Reporte</i></a>
                                </center>
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
                        <th>FECHA</th>
                        <th>ESTADO</th>
                        <th>AIR</th>
                        <th>AGR</th>
                        <th>OPE</th>
                        <th>ORIGEN</th>
                        <th>CRD</th>
                        <th>DESTINO</th>
                        <th>MONEDA</th>
                        <th>MONTO</th>
                        <th>COMISION_POR</th>
                        <th>COMISION_CRL</th>
                        <th>REIBIDO_USD</th>
                        <th>RECIBIDO_CLP</th>
                        <th>TOTAL_CLP</th>
                        <th>REMITENTE</th>
                        <th>DESTINATARIO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(isset($_GET['from_date']) && isset($_GET['to_date'])){
                            $query ="SELECT * FROM remesas_env_chile_bolivia WHERE DATE(FECHA) BETWEEN '$from_date' AND '$to_date'ORDER BY FECHA ASC;";
                            $query_run = mysqli_query($conexion, $query);
                            if(mysqli_num_rows($query_run) > 0){
                                foreach($query_run as $fila){
                                    $cont ++;?>
                                    <tr>
                                        <td> <?php echo $cont ?> </td>
                                        <td> <?php echo $fila['CODIGO'] ?> </td>                            
                                        <td> <?php echo date("d-m-Y h:i", strtotime($fila['FECHA'])) ?> </td>
                                        <td> <?php echo $fila['ESTADO'] ?> </td>
                                        <td> <?php echo $fila['AIR'] ?> </td>
                                        <td> <?php echo $fila['AGR'] ?> </td>
                                        <td> <?php echo $fila['OPE'] ?> </td>
                                        <td> <?php echo $fila['ORIGEN'] ?> </td>
                                        <td> <?php echo $fila['CRD'] ?> </td>
                                        <td> <?php echo $fila['DESTINO'] ?> </td>
                                        <td> <?php echo $fila['MONEDA'] ?> </td>
                                        <td> <?php echo $fila['MONTO'] ?> </td>
                                        <td> <?php echo $fila['COMISION_POR'] ?> </td>
                                        <td> <?php echo $fila['COMISION_CLP'] ?> </td>
                                        <td> <?php echo $fila['RECIBIDO_USD'] ?> </td>
                                        <td> <?php echo $fila['RECIBIDO_CLP'] ?> </td>
                                        <td> <?php echo $fila['TOTAL_CLP'] ?> </td>
                                        <td> <?php echo $fila['REMITENTE'] ?> </td>
                                        <td> <?php echo $fila['DESTINATARIO']  ?> </td>
                                    </tr>
                                    <?php
                                }
                            }else{?>
                        <tr>
                            <td><?php  echo "No se encontraron resultados"; ?></td>
                        </tr>
                        <?php 
                            }                                
                        } ?>
                        </tbody>
                    </table>
                    <?php  mysqli_close($conexion); ?>
                </div>
            </div>
        <script src="/RemesasT/assets/js/PieTablass.js"></script>
    </div>
</body>
<?php include '../includes/footer.php'; ?>