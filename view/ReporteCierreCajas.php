<?php
include '../conexion.php';
include '../includes/header.php';
use Carbon\Carbon;
ob_start();
require_once __DIR__ . '../../vendor/autoload.php';
?>
<link rel="stylesheet" href="/RemesasT/assets/css/containerEliCre.css">
<!-- Formulario para enviar la fecha al servidor -->
<form method="POST" action="">
    <div class="container-a1">
        <div>
            <label>Escojer día:
                <input type="date" name="from_date" value="<?php echo isset($_POST['from_date']) ? $_POST['from_date'] : ''; ?>" class="Buscar_fechaAC">
            </label>
            <button type="button" class="submit-button" onclick="AtrasCAE()"><i class="fas fa-arrow-left"> Atras </i></button>
            <button type="submit" class="submit-button"><i class="fas fa-search"> Buscar </i></button>        
            <a href="/RemesasT/ReportesPDF/CierreCajasPDF.php?from_date=<?php echo isset($_POST['from_date']) ? $_POST['from_date'] : $from_date;?>" target="_blank" class="btn-custom">
            <i class="far fa-file-pdf"> Imprimir</i></a> 
        </div>
    </div>
    <br>
    <div class="containerr container-c3">
        <h1>Reporte Cierre de Cajas</h1>
        <br>
        <?php
        // Obtener la fecha actual si no se proporciona ninguna fecha
        $from_date = $_POST['from_date'] ?? Carbon::now('America/La_Paz')->startOfDay()->toDateString();

        if (!$from_date) {
            $query = "SELECT MAX(FECHA_TC) AS Ult_fecha  FROM cierre_cajas;";
            $query_run = mysqli_query($conexion, $query);
        
            if ($row = mysqli_fetch_assoc($query_run)) {
                $from_date= date('Y-m-d', strtotime($row['Ult_fecha']));
                $hora = date('H:i:s', strtotime($row['Ult_fecha']));
            }
        }else{
            // Verificar si se ha enviado el formulario
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Obtener la fecha proporcionada por el usuario desde el formulario
                $from_date = $_POST['from_date'] ?? Carbon::now('America/La_Paz')->startOfDay()->toDateString();
            }
        }      
        
        $query1 = "SELECT CodigoMoneda, Moneda FROM tabla_monedas";
        $query1_run = mysqli_query($conexion, $query1);
    
        if ($query1_run) {
            while ($resultado1 = mysqli_fetch_assoc($query1_run)) {
                $CodigoMoneda = $resultado1['CodigoMoneda'];
                $NombreMoneda = $resultado1['Moneda'];
                // Utilizar la variable $from_date en la consulta
                $query = "SELECT CORTE, FAJO, UNIDAD, TOTAL, (SELECT SUM(TOTAL) FROM cierre_cajas WHERE MONEDA_TC = '$CodigoMoneda' AND DATE(FECHA_TC) = '$from_date') AS SUMATOTAL, FECHA_TC FROM cierre_cajas WHERE MONEDA_TC = '$CodigoMoneda' AND DATE(FECHA_TC) = '$from_date';";
                $query_run = mysqli_query($conexion, $query);   
                // Verificar si la consulta fue exitosa
                if ($query_run) {
                    // Crear un array para almacenar los resultados de la consulta
                    $resultados = array();
                    // Recorrer los resultados y almacenarlos en el array
                    while ($row = mysqli_fetch_assoc($query_run)) {
                        $resultados[] = $row;
                        $SumaTotal = $row['SUMATOTAL'];
                    }
                    // Mostrar la tabla solo si hay resultados
                    if (!empty($resultados)) {
                        // Crear una tabla por cada resultado
                        echo '<div class="container">';
                        echo '<div class="table-container">';
                        echo '<table id="TablaActa" border="3">';
                        echo '<thead>';
                        echo "<tr><th colspan='4'>$NombreMoneda</th></tr>";
                        echo '<tr><th>Corte</th><th>Fajo</th><th>Unidad</th><th>Total</th></tr>';
                        echo '</thead>';
                        echo '<tbody>';
                        // Mostrar los resultados en la tabla
                        foreach ($resultados as $resultado) {
                            echo '<tr>';
                            echo '<td id=th align=right>' . $resultado['CORTE'] . '</td>';
                            echo '<td align=center>' . $resultado['FAJO'] . '</td>';
                            echo '<td align=center>' . $resultado['UNIDAD'] . '</td>';
                            echo '<td align=right>' . $resultado['TOTAL'] . '</td>';
                            echo '</tr>';
                        }
                        echo "<td id=th colspan='3'>Total</td>";
                        echo "<td id=th align=right>$SumaTotal</td>";
                        echo '</tbody>';
                        echo 'Fecha: '. date('d-m-Y', strtotime( $resultado['FECHA_TC']));   
                        echo '</table>';
                        echo '</div>';
                        echo '</div>';
                        echo '<br>';
                    }
                } else {
                    // Imprimir el mensaje de error en caso de problemas con la consulta
                    echo "Error en la consulta: " . mysqli_error($conexion);
                }
            }
        } else {
            // Imprimir el mensaje de error en caso de problemas con la consulta
            echo "Error en la consulta: " . mysqli_error($conexion);
        } ?>
    </div>
</form>
<?php include '../includes/footer.php'; ?>