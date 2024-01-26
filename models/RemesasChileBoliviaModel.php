<?php
// RemesasModel.php
require_once '../conexion.php';

class RemesasModel {
    private $conexion;

    public function __construct() {
        try {
            $this->conexion = Conexion::Conectar();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function getRemesas($from_date, $to_date) {
        $resultados = [];

        if(isset($from_date) && isset($to_date)) {
            $query = "SELECT * FROM remesas_env_chile_bolivia WHERE DATE(FECHA) BETWEEN :from_date AND :to_date ORDER BY FECHA ASC;";
            $stmt = $this->conexion->prepare($query);
            $stmt->bindParam(':from_date', $from_date);
            $stmt->bindParam(':to_date', $to_date);
            $stmt->execute();

            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $resultados;
    }
}
?>
