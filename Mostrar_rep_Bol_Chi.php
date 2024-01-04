<?php
    include("encabezado.php");
    include("conexion.php");
    use Carbon\Carbon;
    $cont=0;
    require_once __DIR__ . '/vendor/autoload.php';
    $from_date = isset($_GET['from_date']) ? $_GET['from_date'] : '';
    $to_date = isset($_GET['to_date']) ? $_GET['to_date'] : '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <!-- CSS personalizado -->
    <link rel="stylesheet" href="assets/css/MTabla1.css">
    <link rel="stylesheet" href="assets/css/tabla.css">
    <!-- Datatables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css"/>  
    <!-- Datatables Responsive CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    <!-- Datatables-->
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>  
    <!-- Datatables responsive -->
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <title>REMESAS BOLIVIA - CHILE</title>
</head>
<body> 
    <br>
    <h1 class="text-center">Listado Reporte Bolivia - Chile</h1>
    <div class="container">
        <form action="" method="GET">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label><b>Del Dia</b></label>
                        <input type="date" name="from_date" value="<?php if(date(isset($_GET['from_date']))){ echo $_GET['from_date']; } ?>" class="form-control">
                    </div>    
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label><b>Hasta el Dia</b></label>
                        <input type="date" name="to_date" value="<?php if(isset($_GET['to_date'])){ echo $_GET['to_date']; } ?>" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <br>
                        <button type="submit" class="submit-button"><i class="fas fa-search"></i> Buscar</button>
                        <!--hacemos que los datos de los canlendarios se guaden y puedan ser re usados-->
                        <a href="ReportesPDF/RemesasBoliviaPDF.php?from_date=<?php echo $from_date; ?>&to_date=<?php echo $to_date; ?>" target="_blank" class="submit-button">
                        <i class="far fa-file-pdf"></i> Generar Reporte
                    </a>
                </div>
                <a href="ReportesPDF/RemesaReportChilePDF.php?from_date=<?php echo $from_date; ?>&to_date=<?php echo $to_date; ?>" target="_blank" class="submit-button">
                <i  class="far fa-file-pdf"></i> Generar Consulta
                </a>
            </div>
        </div>
    </form>
</div>
    <div calss="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table id="TablaRemesas" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>CODIGO</th>
                            <th>FECHA DE REGISTRO</th>
                            <th>CORRETATIVO</th>
                            <th>DOCUMENTO</th>
                            <Th>US. FINANCIERO</Th>
                            <th>TELEFONO</th>
                            <th>DESTINATARIO</th>
                            <th>TELF. DEST</th>
                            <th>ORIGEN</th>
                            <th>DESTINO</th>
                            <th>MONEDA ENVIO</th>
                            <th>MONTO ENV</th>
                            <th>% CAM</th>
                            <th>COMISION</th>
                            <th>TOPO CAMBIO</th>
                            <th>MOTNO EN BOB</th>
                            <th>COMISION EN BOB</th>
                            <th>ITF EN BOB</th>
                            <th>ULTIMA MODIFCACION</th>
                            <th>ESTADO</th>
                        </tr>
                    </thead>
                <tbody>
                    <?php 
                    $from_date = $_GET['from_date'] ?? null;
                    $to_date = $_GET['to_date'] ?? null;

                    if ($from_date && $to_date) {
                        $fechaInicio = Carbon::createFromFormat('Y-m-d', $from_date);
                        $fechaFin = Carbon::createFromFormat('Y-m-d', $to_date);

                        if ($fechaInicio->gt($fechaFin)) {
                            // Si la fecha de inicio es mayor que la fecha final
                            echo '<script>alert("La fecha de inicio no puede ser mayor que la fecha fin"); window.location.href = "Mostrar_remesas.php";</script>';
                        }
                        //delimitar por fecha
                        $fechaActual = Carbon::now();
                        if ($fechaInicio->isFuture() || $fechaFin->isFuture()) {
                            // Si alguna de las fechas está en el futuro
                            echo '<script>alert("No puedes ingresar fechas futuras a: '.$fechaActual.'"); window.location.href = "Mostrar_remesas.php";</script>';
                        }
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
                        <?php }                                
                    } 
                    }?>
                    </tbody>
                </table>
                <?php  mysqli_close($conexion); ?>
                </div>
            </div>
        </div>
    </div>
    <!--comandos js-->
    <script>
        $(document).ready(function(){
            $('#TablaRemesas').DataTable({
                responsive: true,
                language: {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_       registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior",
                    "dom": '<"top"l>rt<"bottom"ip><"clear">'
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                },
                "buttons": {
                    "copy": "Copiar",
                    "colvis": "Visibilidad"
                }
            }
        });
    });
    </script>
</body>
</html>