<?php
require_once('../../models/AperturaCajasModel.php');
require_once('../../conexion.php');
use Carbon\Carbon;

class AperturaCajasController {
    private $AperturaCajasModel;

    public function __construct($AperturaCajasModel) {
        $this->AperturaCajasModel = $AperturaCajasModel;
    }

    public function procesarFormulario() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            date_default_timezone_set('America/La_Paz');
            $fechaHoraActual = Carbon::now();

            // Recupera los datos del formulario y llama al método del modelo
            $mensaje = $this->AperturaCajasModel->guardarDatos(
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