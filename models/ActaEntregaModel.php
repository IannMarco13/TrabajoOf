<?php
require_once '../conexion.php';

class ActaEntregaModel{
    private $conexion;

    public function __construct() {
        try {
            $this->conexion = Conexion::Conectar();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }   
    public function GuardarDatos($Cod_Moneda, $T_Enviado, $C_Venta, $T_Bolivianos, $C_Compra, $T_USD, $Fecha) {
        $datosGuardados = false;

        foreach ($Cod_Moneda as $index => $Cod_MonedaActual) { //
            $T_EnviadoActual    = $T_Enviado[$index];
            $C_VentaActual      = $C_Venta[$index];
            $T_BolivianosActual = $T_Bolivianos[$index];
            $C_CompraActual     = $C_Compra[$index];
            $T_USDActual        = $T_USD[$index];

            if ($T_USDActual != 0) {
                $query = "INSERT INTO acta_entrega(COD_MONEDA, TOTAL_ENVIADO, CAMBIO_VENTA, TOTAL_BOLIVIANOS, CAMBIO_COMPRA_USD, TOTAL_USD, FECHA_AE) VALUES ('$Cod_MonedaActual', $T_EnviadoActual, $C_VentaActual, $T_BolivianosActual, $C_CompraActual, $T_USDActual, '$Fecha')";
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