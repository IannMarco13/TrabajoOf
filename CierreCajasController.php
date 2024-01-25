<?php
require_once('CierreCajas.php');
require_once('conexion.php');
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
}