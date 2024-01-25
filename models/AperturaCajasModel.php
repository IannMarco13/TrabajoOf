<?php
require_once '../../conexion.php';

class AperturaCajasModel {
    private $pdo;

    public function __construct() {
        try {
            $this->pdo = Conexion::Conectar();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }   

    public function ListarMonedas() {
        try {   
            $tco = $this->pdo->prepare("SELECT * FROM tabla_monedas");
            $tco->execute();
            return $tco->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    
    public function guardarDatos($monedas, $cortes, $fajos, $unidades, $totales, $fecha) {
        $datosGuardados = false;

        foreach ($monedas as $index => $monedaActual) {
            $corteActual  = $cortes[$index];
            $fajoActual   = $fajos[$index];
            $unidadActual = $unidades[$index];
            $totalActual  = $totales[$index];
            
            if ($totalActual != 0) {
                $query = "INSERT INTO apertura_cajas (MONEDA_TA, CORTE, FAJO, UNIDAD, TOTAL, FECHA_TA) VALUES ('$monedaActual', $corteActual, $fajoActual, $unidadActual, $totalActual, '$fecha')";
                
                if ($this->pdo->query($query)) {
                    $datosGuardados = true;
                } else {
                    $errorInfo = $this->pdo->errorInfo();
                    return 'Error al guardar los datos: ' . $errorInfo[2]; 
                }
            }
        }
        return $datosGuardados ? '¡Datos guardados correctamente!' : '';
    }
}
?> 