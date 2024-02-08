<?php
require_once '../../conexion.php';

class CierreCajas {
    private $conexion;

    public function __construct() {
        try {
            $this->conexion = Conexion::Conectar();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function ListarMonedas() {
        try {   
            $tco = $this->conexion->prepare("SELECT * FROM tabla_monedas");
            $tco->execute();
            return $tco->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    
    public function ListarCajero() {
        try {
            $tco = $this->conexion->prepare("SELECT ID_CAJERO, ID_AGENCIA, NOMBRE FROM cajeros");
            $tco->execute();
            return $tco->fetchAll(PDO::FETCH_OBJ);
        } catch(Exception $e){
            die ($e->getMessage());
        } 
    }

    public function obtenerDatosCajero($codigoCajero) {
        try {
            $query = "SELECT * FROM cajeros WHERE ID_CAJERO = ?";
            $statement = $this->conexion->prepare($query);
            $statement->bindParam(1, $codigoCajero);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
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
                $query = "INSERT INTO cierre_cajas (MONEDA_TC, CORTE, FAJO, UNIDAD, TOTAL, FECHA_TC) VALUES ('$monedaActual', $corteActual, $fajoActual, $unidadActual, $totalActual, '$fecha')";
                
                if ($this->conexion->query($query)) {
                    $datosGuardados = true;
                } else {
                    $errorInfo = $this->conexion->errorInfo();
                    return 'Error al guardar los datos: ' . $errorInfo[2]; 
                }
            }
        }
        return $datosGuardados ? '¡Datos guardados correctamente!' : '';
    }    
}
?> 