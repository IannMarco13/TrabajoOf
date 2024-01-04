<?php
    include("encabezado.php");
    include("conexion.php");
    $cont = 0;
    use Carbon\Carbon;
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
    <title>REMESAS</title>
</head>
<body>
    <br>
    <div class="formu">
    <h1>Listado Remesas Chile Bolivia</h1>
    <div class="container">
        <form action="" method="GET">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class= "prue"><b>Del Dia</b></label>
                        <input type="date" name="from_date" value="<?php echo isset($_GET['from_date']) ? $_GET['from_date'] : ''; ?>" class="form-control">
                    </div>    
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label><b>Hasta el Dia</b></label>
                        <input type="date" name="to_date" value="<?php echo isset($_GET['to_date']) ? $_GET['to_date'] : ''; ?>" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <br>
                    <div class="form-group btn-group">
                        <button type="submit" class="submit-button"><i class="fas fa-search"></i> Buscar</button>
                        <a href="ReportesPDF/ReporteChilePDF.php?from_date=<?php echo isset($_GET['from_date']) ? $_GET['from_date'] : ''; ?>&to_date=<?php echo isset($_GET['to_date']) ? $_GET['to_date'] : ''; ?>" target="_blank" class="btn-custom">
                            <i class="far fa-file-pdf"></i> Generar Reporte
                        </a>
                    </div>
                    <div class="form-group btn-group">
                        <br>
                        <a href="ReportesPDF/RemesaReportChilePDF.php?from_date=<?php echo $from_date; ?>&to_date=<?php echo $to_date; ?>" target="_blank" class="btn-custom">
                            <i  class="far fa-file-pdf"></i> Generar Consulta
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
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
                        
                        $query ="SELECT * 
                        FROM remesas_env_chile_bolivia 
                        WHERE DATE(FECHA) BETWEEN '$from_date' AND '$to_date';";
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