<?php
require_once('../models/ActaEntregaModel.php');
require_once('../conexion.php');
use Carbon\Carbon;

class ActaEntregaController{

    private $ActaEntregaModel;

    public function __construct($ActaEntregaModel){
        $this -> ActaEntregaModel = $ActaEntregaModel;
    }
    public function prosesarActa(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            date_default_timezone_set('America/La_Paz');
            $fechaHoraActual = Carbon::now();

            // Recupera los datos del formulario y llama al método del modelo
            $mensaje = $this->ActaEntregaModel->GuardarDatos(
                $_POST['Cod_Moneda'],
                $_POST['totalEnviado'],
                $_POST['Venta'], //
                $_POST['resultadoOp'],
                $_POST['Compra'], 
                $_POST['total'],
                $fechaHoraActual
            );
            return $mensaje;
        }
    }
}
?>