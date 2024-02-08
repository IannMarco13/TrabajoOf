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
        <br>
        <h1>Listado Reporte Bolivia - Chile</h1>
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
                                <button type="submit" class="submit-button"><i class="fas fa-search"> Buscar </i></button>
                                <a href="/RemesasT/ReportesPDF/RemesasBoliviaPDF.php?from_date=<?php echo isset($_GET['from_date']) ? $_GET['from_date'] : ''; ?>&to_date=<?php echo isset($_GET['to_date']) ? $_GET['to_date'] : ''; ?>" target="_blank" class="btn-custom">
                                <i class="fas fa-print"> Imprimir Tabla</i></a>
                                <a href="/RemesasT/ReportesPDF/RemesaReportChilePDF.php?from_date=<?php echo $from_date; ?>&to_date=<?php echo $to_date; ?>" target="_blank" class="btn-custom">
                                <i  class="far fa-file-pdf"> Generar Consulta </i></a>
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
                            <th>CÓDIGO</th>
                            <th>FECHA DE REGISTRO</th>
                            <th>CORRELATIVO</th>
                            <th>DOCUMENTO</th>
                            <Th>US. FINANCIERO</Th>
                            <th>TELÉFONO</th>
                            <th>DESTINATARIO</th>
                            <th>TELF. DEST</th>
                            <th>ORIGEN</th>
                            <th>DESTINO</th>
                            <th>MONEDA ENVIO</th>
                            <th>MONTO ENV</th>
                            <th>% CAM</th>
                            <th>COMISIÓN</th>
                            <th>TIPO de CAMBIO</th>
                            <th>MONTO EN BOB</th>
                            <th>COMISIÓN EN BOB</th>
                            <th>ITF EN BOB</th>
                            <th>ULTIMA MODIFCACIÓN</th>
                            <th>ESTADO</th>
                        </tr>
                    </thead>
                <tbody>
                    <?php 
                    if(isset($_GET['from_date']) && isset($_GET['to_date'])){    
                        $query ="SELECT * FROM remesas_bolivia_chile WHERE DATE(FECHA_B) BETWEEN '$from_date' AND '$to_date' ORDER BY FECHA_B ASC";
                        $query_run = mysqli_query($conexion, $query);

                        if(mysqli_num_rows($query_run) > 0){

                            foreach($query_run as $fila){ 
                                $cont++;?>
                            <tr>
                                <td> <?php echo $cont ?> </td>
                                <td> <?php echo $fila['CODIGO_B'] ?> </td>
                                <!-- Como en la BD las fechas de exel que estan con campos "-" los guarda como 0000-00-00 00:00:00 usando este comando se Haregla-->
                                <?php if ($fila['FECHA_B'] !== null && $fila['FECHA_B'] !== '0000-00-00 00:00:00') { ?>
                                <td><?php echo date("d-m-Y H:i", strtotime($fila['FECHA_B'])); ?></td>
                                <?php } else { ?>
                                <td>Fecha no disponible</td>
                                <?php } ?>
                                <td> <?php echo $fila['CORRELATIVO_B'] ?> </td>
                                <td> <?php echo $fila['DOCUMENTO_B'] ?> </td>
                                <td> <?php echo $fila['USU_FINCACIERO'] ?> </td>
                                <td> <?php echo $fila['TELEFONO_U'] ?> </td>
                                <td> <?php echo $fila['DESTINATARIO_B'] ?> </td>
                                <td> <?php echo $fila['TELEFONO_D'] ?> </td>  
                                <td> <?php echo $fila['ORIGEN_B'] ?> </td>
                                <td> <?php echo $fila['DESTINO_B'] ?> </td>
                                <td> <?php echo $fila['MONEDA_ENV'] ?> </td>
                                <td> <?php echo $fila['MONTO_ENV'] ?> </td>
                                <td> <?php echo $fila['POR_COM'] ?> </td>  
                                <td> <?php echo $fila['COMISION_B'] ?> </td>
                                <td> <?php echo $fila['TIPO_CAMBIO'] ?> </td>
                                <td> <?php echo $fila['MONTO_BOB_B'] ?> </td>
                                <td> <?php echo $fila['COMISION_BOB'] ?> </td>
                                <td> <?php echo $fila['ITF_BOB'] ?> </td>  
                                <!-- Como en la BD las fechas de exel que estan con campos "-" los guarda como 0000-00-00 00:00:00 usando este comando se Haregla-->
                                <?php if ($fila['ULTIMA_MODIFI'] !== null && $fila['ULTIMA_MODIFI'] !== '0000-00-00 00:00:00') { ?>
                                <td><?php echo date("d-m-Y H:i", strtotime($fila['ULTIMA_MODIFI'])); ?></td>
                                <?php } else { ?>
                                <td>Fecha no disponible</td>
                                <?php } ?>
                                <td> <?php echo $fila['ESTADO_B'] ?> </td>
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
        <script src="/RemesasT/assets/js/PieTablas.js"></script>
    </div>
</body>
<?php include '../includes/footer.php'; ?>