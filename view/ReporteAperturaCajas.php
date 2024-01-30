<?php 
include '../conexion.php';
include '../includes/header.php';

$query = "SELECT MONEDA AS Moneda , CORTE, FAJO, UNIDAD, TOTAL FROM apertura_cajas INNER JOIN tabla_monedas ON CodigoMoneda = MONEDA_TA WHERE MONEDA_TA = BOB AND DATE(FECHA_TA)='2024-01-25';";
$from_date = $_GET['from_date'] ?? null;

$query_run = mysqli_query($conexion, $query);
var_dump($from_date);

?>
<body>
    <label>Del Dia
        <input type="date" name="from_date" value="<?php echo isset($_GET['from_date']) ? $_GET['from_date'] : ''; ?>" class="form-control">
    </label>
    <button> botton</button>
    <div class= 'container' >
        
    </div>
    <div class= 'container'>
        <table border="3">
            <thead>
                <tr>
                    <th colspan="5">Bolivianos</th>
                </tr>
                <tr>
                    <th>Corte</th>
                    <th>Fajo</th>
                    <th>Unidad</th>
                    <th>Total</th>
                </tr>
            </thead>
        </table>
    </div>
</body>

<?php include '../includes/footer.php';?>