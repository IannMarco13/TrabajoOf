<?php
require_once('includes/header.php');
require_once('conexion.php');
use Carbon\Carbon;
ob_start();
require_once __DIR__ . '/vendor/autoload.php';
// Configurar el huso horario a Bolivia
Carbon::setLocale('es');
Carbon::setLocale('America/La_Paz');
$fecha = Carbon::now('America/La_Paz');
$cont=0;
$from_date = isset($_GET['from_date']) ? $_GET['from_date'] : '';
$to_date = isset($_GET['to_date']) ? $_GET['to_date'] : '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/comp_vent_estilo.css">
    <link rel="stylesheet" href="assets/css/tabla.css">
    <link rel="stylesheet" href="assets/css/tablaTC.css">

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
    
    <title>COMPRA Y VENTA</title>
</head>
<body>
    <table border="9" id="Tabla_CompraVenta">
    <th>
        <form action="">
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
            <div class="form-group btn-group">
                <button type="submit" class="submit-button"><i class="fas fa-search"></i> Buscar</button>
                
            </div> 
        </div>
        </form> 
            <div calss="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                        <table  id="TablaRemesas" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Agencia</th>
                                    <th>CODIGO</th>
                                    <th>FECHA</th>
                                    <th>COMPRA</th>
                                    <th>VENTA</th>
                                </tr>
                            </thead>
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
                                if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
                                    $query = "SELECT agencias.AGENCIA,tp_cambio.CODIGO_MONEDA , tp_cambio.FECHA_TP , tp_cambio.COMPRA, tp_cambio.VENTA FROM tp_cambio INNER JOIN agencias on tp_cambio.Cod_agencia = agencias.ID_A  WHERE DATE(FECHA_TP) BETWEEN '$from_date' AND '$to_date' ORDER BY FECHA_TP ,AGENCIA ASC";
                                } 
                                $query_run = mysqli_query($conexion, $query);
                                if (mysqli_num_rows($query_run) > 0) {
                                    foreach ($query_run as $fila) {
                                        $cont++;
                                ?>
                                        <tr>
                                            <td><?php echo $cont ?></td>
                                            <td><?php echo $fila['AGENCIA'] ?></td>
                                            <td><?php echo $fila['CODIGO_MONEDA'] ?></td>
                                            <td><?php echo date("d-m-Y h:i:s", strtotime($fila['FECHA_TP'])) ?></td>
                                            <td><?php echo $fila['COMPRA'] ?></td>
                                            <td><?php echo $fila['VENTA'] ?></td>
                                        </tr>
                                <?php
                                    }
                                }
                            }
                                ?>
                        </table>
                        <script src="assets/js/PieTablas.js"></script>
                        </div>
                    </div>
                </div>
            </div>
    </th>
        <th>
            <form method="post" action="Compra_venta.php">
            <input type="submit" name="actualizarCV" value="Actualizar Compra Venta">
                <label for="agencia">Selecciona una agencia:</label>
                <select name="agencia" id="agencia">
                    <option value="101">SUCRE CENTRAL</option>
                    <option value="202">COLON</option>
                    <option value="210">6 DE MARZO</option>
                    <option value="301">COCHABAMBA CENTRAL</option>
                    <option value="401">ORURO CENTRAL</option>
                    <option value="501">UYUNI</option>
                    <option value="701">SANTA CRUZ CENTRAL</option>
                    <option value="702">YAPACANI</option>
                </select>
                <br><br>
                <label for="moneda">Selecciona una moneda:</label>
                <select name="moneda" id="moneda">
                    <option value="USD">Dólar Estadounidense</option>
                    <option value="BOB">Boliviano</option>
                    <option value="CLP">Peso Chileno</option>
                    <option value="BRL">Real Brasileño</option>
                    <option value="EUR">Euro</option>
                    <option value="ARS">Peso Argentino</option>
                    <option value="ASD">Bólar Australiano</option>
                    <option value="CAD">Dólar Canadiense</option>
                    <option value="PEN">Sol Peruano</option>
                    <option value="GBP">Libra Esterlina</option>
                    <option value="CHF">Franco Suizo</option>
                    <option value="NZD">Dólar Neozelandés</option>
                    <option value="PYG">Guaraní</option>
                </select>
                <br><br>
                <label for="compra">Compra:</label>
                <input type="text" id="compra" name="compra" maxlength="12" placeholder="Valor de Compra">
                <br><br>
                <label for="venta">Venta:</label>
                <input type="text" id="venta" name="venta" maxlength="12" placeholder="Valor de Venta">
                <br><br>    
               <input type="submit" id="Guardar" name="Guardar">
            </form>
            <script src="assets/js/Compra_Venta.js"></script>
        </th>
        <tr>
            <th>
                <table  id="TablaCV" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>MONEDA</th>
                        <th>PROMEDIO</th>
                        <th>COMPRA MIN</th>
                        <th>COMPRA MAX</th>
                        <th>VENTA MIN</th>
                        <th>VENTA MAX</th>
                    </tr>
                </thead>
                <?php
                $from_date = $_GET['from_date'] ?? null;
                $to_date = $_GET['to_date'] ?? null;

                if ($from_date && $to_date) {
                    $query = "SELECT Moneda, AVG(promedio) AS promedio_general, MAX(max_compra) AS max_compra, MIN(min_compra) AS min_compra, MAX(max_venta) AS max_venta, MIN(min_venta) AS min_venta
                        FROM (
                            SELECT 
                                Moneda,
                                MAX(COMPRA) AS max_compra,
                                MIN(COMPRA) AS min_compra,
                                MAX(VENTA) AS max_venta,
                                MIN(VENTA) AS min_venta,
                                (AVG(COMPRA) + AVG(VENTA)) / 2 AS promedio
                            FROM tp_cambio
                            INNER JOIN tabla_monedas ON tp_cambio.CODIGO_MONEDA = tabla_monedas.CodigoMoneda
                            WHERE CODIGO_MONEDA IN ('USD', 'CLP', 'BRL', 'EUR', 'ARS', 'ASD', 'CAD', 'PEN', 'GBP', 'CHF', 'NZD', 'PYG') 
                            AND DATE(FECHA_TP) BETWEEN '$from_date' AND '$to_date'
                            GROUP BY Moneda
                        ) AS subconsulta
                        GROUP BY Moneda";

                    $query_run = mysqli_query($conexion, $query);
                        
                    if ($query_run) {
                        if (mysqli_num_rows($query_run) > 0) {
                            $cont = 0;
                            while ($fila = mysqli_fetch_assoc($query_run)) {
                                $cont++;
                ?>
                <tr>
                    <td><?php echo $cont ?></td>
                    <td class= "texto-izquierda"><?php echo $fila['Moneda'] ?></td>
                    <td><?php echo number_format($fila['promedio_general'],5) ?></td>
                    <td><?php echo number_format($fila['min_compra'], 4) ?></td>
                    <td><?php echo number_format($fila['max_compra'], 4) ?></td>
                    <td><?php echo number_format($fila['min_venta'] , 4)?></td>
                    <td><?php echo number_format($fila['max_venta'] , 4)?></td>
                </tr>
                <?php
                            }
                        } else {
                            echo "No se encontraron resultados.";
                        }
                    } else {
                        echo "Error al ejecutar la consulta: " . mysqli_error($conexion);
                    }
                } else {
                    echo "Fechas no especificadas.";
                }
                ?>
                </table>
            </th>
        </tr>
    </table>
</body>
</html> 

<?php                                                                                    
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Guardar']) ) {
    if (!empty($_POST['moneda']) && !empty($_POST['compra']) && !empty($_POST['venta'])) {
        // Obtener los valores del formulario
        $agencia = $_POST["agencia"];
        $moneda = $_POST["moneda"];
        $compra = $_POST["compra"];
        $venta = $_POST["venta"];
        $fechaHoraActual = Carbon::now('America/La_Paz')->toDateTimeString(); // Fecha y hora actual

        // Actualizar los registros existentes para la fecha y hora actual
        $sql = "UPDATE tp_cambio SET COMPRA = '$compra', VENTA = '$venta', FECHA_TP = '$fechaHoraActual' WHERE DATE(FECHA_TP) = CURDATE() AND Cod_agencia = '$agencia' AND CODIGO_MONEDA = '$moneda'";
        
        if ($conexion->query($sql) === TRUE) {
            echo '<script>alert("Actualizado correctamente"); window.location.href = "Compra_venta.php";</script>';
        } else {
            echo '<script>alert("Error al actualizar los valores"); window.location.href = "Compra_venta.php";</script>';
        } 
    } else {
        echo '<script>alert("Por favor, complete todos los campos."); window.location.href = "Compra_venta.php";</script>';
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['actualizarCV'])) {
    
    $ultima_actualizacion = obtenerUltimaActualizacion($conexion);
    $ultima_actualizacion_query = $ultima_actualizacion->format('Y-m-d');
    $hoy = Carbon::now('America/La_Paz');
    $fechaYHora = $hoy->format('Y-m-d H:i:s');
    
    if ($ultima_actualizacion && $ultima_actualizacion->isSameDay($hoy)) {
        echo '<script>alert("La actualización ya se realizó hoy. No se puede actualizar más de una vez al día."); window.location.href = "Compra_venta.php";</script>';
    } else {
        // Realizar la actualización
        $query = "INSERT INTO tp_cambio (Cod_agencia, CODIGO_MONEDA, FECHA_TP, COMPRA, VENTA)
        SELECT Cod_agencia, CODIGO_MONEDA, '$fechaYHora', COMPRA, VENTA
        FROM tp_cambio 
        WHERE DATE(FECHA_TP) = '$ultima_actualizacion_query'
        AND Cod_agencia IN (101, 202, 210, 301, 401, 501, 701, 702);";
        if ($conexion->query($query) === TRUE) {
            //echo '<script>alert("Actualización realizada correctamente."); window.location.href = "Compra_venta.php";</script>';
            echo "ultima_actualizacion: " . $ultima_actualizacion . "<br>";
            echo "fechaYHora: " . $fechaYHora . "<br>";
            var_dump($query);
        } 
    }
}
// Función para obtener la fecha de la última actualización
function obtenerUltimaActualizacion($conexion) {
    $query = "SELECT MAX(FECHA_TP) AS ultima_actualizacion FROM tp_cambio";
    $result = $conexion->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return Carbon::createFromFormat('Y-m-d H:i:s', $row['ultima_actualizacion'], 'America/La_Paz');
    }
    return null;
}

require_once('includes/footer.php');
?>





