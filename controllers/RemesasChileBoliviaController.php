<?php
use Carbon\Carbon;
include '../conexion.php';  
require_once '../models/RemesasChileBoliviaModel.php';

class RemesasController {
    private $model;

    // Constructor que recibe el modelo
    public function __construct($model) {
        $this->model = $model;
    }

    public function mostrarRemesas($from_date, $to_date) {
        
        if ($from_date && $to_date) {
            $fechaInicio = Carbon::createFromFormat('Y-m-d', $from_date);
            $fechaFin = Carbon::createFromFormat('Y-m-d', $to_date);

         if ($fechaInicio->gt($fechaFin)) {
                echo '<script>alert("La fecha de inicio no puede ser mayor que la fecha fin"); window.location.href = "Mostrar_remesas.php";</script>';
            }

         //delimitar por fecha
            $fechaActual = Carbon::now();
            if ($fechaInicio->isFuture() || $fechaFin->isFuture()) {
                // Si alguna de las fechas está en el futuro
                echo '<script>alert("No puedes ingresar fechas futuras a: '.$fechaActual.'"); window.location.href = "Mostrar_remesas.php";</script>';
            }

        $remesas = $this->model->getRemesas($from_date, $to_date);

        return $remesas;
        }
    }
}
// Crear una instancia del modelo pasando la conexión
$model = new RemesasModel($conexion);
$controller = new RemesasController($model);
?>
