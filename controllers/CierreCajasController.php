<?php
require_once('../../models/AperturaCajasModel.php');
require_once('../../conexion.php');
use Carbon\Carbon;

class CierreCajasController {
    private $cierreCajasModel;

    public function __construct($cierreCajasModel) {
        $this->cierreCajasModel = $cierreCajasModel;
    }

    public function procesarFormulario() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            date_default_timezone_set('America/La_Paz');
            $fechaHoraActual = Carbon::now();

            // Recupera los datos del formulario y llama al método del modelo
            $mensaje = $this->cierreCajasModel->guardarDatos(
                $_POST['Moneda'],
                $_POST['Corte'],
                $_POST['Fajo'],
                $_POST['Unidad'],
                $_POST['Total'],
                $fechaHoraActual
            );

            return $mensaje;
        }
    }

    public function verificarCajero($codigoCajero) {
        // Realiza la consulta SQL para verificar si el código del cajero existe
        $cajero = $this->cierreCajasModel->obtenerDatosCajero($codigoCajero);
    
        if ($cajero) {
            // Devuelve los datos del cajero si existe
            return $cajero;
        } else {
            // Devuelve un mensaje de error si el cajero no existe
            return ["error" => "El código del cajero no existe"];
        }
    }
}
