<?php
require_once '../models/GuardarArchivoModel.php';

class GuardarArchivoController {

    public function convertirDecimal($valor) {
        $valor = str_replace(".", "", $valor); // Eliminar puntos de los miles
        $valor = str_replace(",", ".", $valor); // Reemplazar comas por puntos
        return floatval($valor); // Convertir a float
    }
    
    public function convertirFecha($fecha) {
        return ($fecha === '-' || empty($fecha)) ? NULL : date('Y-m-d H:i:s', strtotime(str_replace('-', '-', $fecha)));
    }

    public function procesarArchivo1() {
        if (isset($_POST["enviar1"])) {
            require_once "../conexion.php";
            require_once "../funtions.php"; 

            $directorio_destino = 'C:/xampp/htdocs/RemesasT/exel/';
            $archivo1 = $_FILES["archivo1"]["name"];
            $archivo_copiado1 = $_FILES["archivo1"]["tmp_name"];
            $archivo_guardado1 = $directorio_destino . "copia_" . $archivo1;

            if (copy($archivo_copiado1, $archivo_guardado1)) {
                echo "Se copió correctamente el archivo temporal a nuestra carpeta <br/>";
            } else {
                echo "Error en el copiado <br/>";
            }

            if (file_exists($archivo_guardado1)) {
                $fp = fopen($archivo_guardado1, "r");

                while ($datos = fgetcsv($fp, 1000, ";")) {
                    $fecha_convertida_1 = ($datos[1] === '-' || empty($datos[1])) ? NULL : date('Y-m-d H:i:s', strtotime(str_replace('-', '-', $datos[1])));
                    $datos[1] = $fecha_convertida_1;

                    // Transformar valores decimales (12,3)
                    $decimal_10 = $this->convertirDecimal($datos[10]);
                    $decimal_11 = $this->convertirDecimal($datos[11]);
                    $decimal_12 = $this->convertirDecimal($datos[12]);
                    $decimal_13 = $this->convertirDecimal($datos[13]);
                    $decimal_14 = $this->convertirDecimal($datos[14]);
                    $decimal_15 = $this->convertirDecimal($datos[15]);

                    $resultado1 = insertar_datos1($datos[0], $datos[1], $datos[2], $datos[3], $datos[4], $datos[5], $datos[6], $datos[7], $datos[8], $datos[9], $decimal_10, $decimal_11, $decimal_12, $decimal_13, $decimal_14, $decimal_15, $datos[16], $datos[17]);
                }
                if ($resultado1) {
                    echo '<script>alert("¡Los datos se han guardado correctamente!");</script>';
                    echo '<script>window.location.href = "/RemesasT/view/GuardarArchivo.php";</script>';
                } else {
                    echo '<script>alert("Hubo un problema al guardar los datos.");</script>';
                    echo '<script>window.location.href = "/RemesasT/view/GuardarArchivo.php";</script>';
                }
            } else {
                echo "No existe el archivo copiado <br/>";
            }
        }
    }

    public function procesarArchivo2() {
        if (isset($_POST["enviar2"])) {
            require_once "../conexion.php";
            require_once "../funtions.php";  // Corregir la ruta del archivo functions.php

            $directorio_destino = 'C:/xampp/htdocs/RemesasT/exel/';
            $archivo2 = $_FILES["archivo2"]["name"];
            $archivo_copiado2 = $_FILES["archivo2"]["tmp_name"];
            $archivo_guardado2 = $directorio_destino . "copia_" . $archivo2;

            if (copy($archivo_copiado2, $archivo_guardado2)) {
                echo "Se copió correctamente el archivo temporal a nuestra carpeta <br/>";
            } else {
                echo "Error en el copiado <br/>";
            }

            if (file_exists($archivo_guardado2)) {
                $fp = fopen($archivo_guardado2, "r");
                while ($datos = fgetcsv($fp, 1000, ";")) {
                    $fecha_convertida_2 = $this->convertirFecha($datos[2]);
                    $fecha_convertida_5 = $this->convertirFecha($datos[5]);

                    // Transformar valores decimales (12,3)
                    $decimal_7 = $this->convertirDecimal($datos[7]);
                    $decimal_8 = $this->convertirDecimal($datos[8]);

                    $resultado2 = insertar_datos2($datos[0], $datos[1], $fecha_convertida_2, $datos[3], $datos[4], $fecha_convertida_5, $datos[6], $decimal_7, $decimal_8, $datos[9], $datos[10]);
                }
                if ($resultado2) {
                    echo '<script>alert("¡Los datos se han guardado correctamente!");</script>';
                    echo '<script>window.location.href = "/RemesasT/view/GuardarArchivo.php";</script>';
                } else {
                    echo '<script>alert("Hubo un problema al guardar los datos.");</script>';
                    echo '<script>window.location.href = "/RemesasT/view/GuardarArchivo.php";</script>';
                }
            } else {
                echo "No existe el archivo copiado <br/>";
            }
        }
    }

    public function procesarArchivo3() {
        if (isset($_POST["enviar3"])) {
            require_once "../conexion.php";
            require_once "../funtions.php"; // Corregir la ruta del archivo functions.php

            $directorio_destino = 'C:/xampp/htdocs/RemesasT/exel/';
            $archivo3 = $_FILES["archivo3"]["name"];
            $archivo_copiado3 = $_FILES["archivo3"]["tmp_name"];
            $archivo_guardado3 = $directorio_destino . "copia_" . $archivo3;

            if (copy($archivo_copiado3, $archivo_guardado3)) {
                $alert = "Se copió correctamente el archivo temporal a nuestra carpeta";
            } else {
                echo "Error en el copiado <br/>";
            }

            if (file_exists($archivo_guardado3)) {
                $fp = fopen($archivo_guardado3, "r");

                while ($datos = fgetcsv($fp, 1000, ";")) { 
                    $fecha_convertida_1  = $this->convertirFecha($datos[1]);
                    $fecha_convertida_19 = $this->convertirFecha($datos[19]);

                    // Transformar valores decimales (12,3)
                    $decimal_12 = $this -> convertirDecimal($datos[12]);
                    $decimal_13 = $this -> convertirDecimal($datos[13]);
                    $decimal_14 = $this -> convertirDecimal($datos[14]);
                    $decimal_15 = $this -> convertirDecimal($datos[15]);
                    $decimal_16 = $this -> convertirDecimal($datos[16]);
                    $decimal_17 = $this -> convertirDecimal($datos[17]);
                    $decimal_18 = $this -> convertirDecimal($datos[18]);

                    $resultado3 = insertar_datos3($datos[0], $fecha_convertida_1, $datos[2], $datos[3], $datos[4], $datos[5], $datos[6], $datos[7], $datos[8], $datos[9], $datos[10], $datos[11], $decimal_12, $decimal_13, $decimal_14, $decimal_15, $decimal_16, $decimal_17, $decimal_18, $fecha_convertida_19, $datos[20]);
                }
                if ($resultado3) {
                    echo '<script>alert("¡Los datos se han guardado correctamente!");</script>';
                    echo '<script>window.location.href = "/RemesasT/view/GuardarArchivo.php";</script>';
                } else {
                    echo '<script>alert("Hubo un problema al guardar los datos.");</script>';
                    echo '<script>window.location.href = "/RemesasT/view/GuardarArchivo.php";</script>';
                }
            } else {
                echo "No existe el archivo copiado <br/>";
            }
        }
    }

    public function procesarArchivo4() {
        if (isset($_POST["enviar4"])) {
            require_once "../conexion.php";
            require_once "../funtions.php"; require_once "../funtions.php"; // Corregir la ruta del archivo functions.php

            $directorio_destino = 'C:/xampp/htdocs/RemesasT/exel/';
            $archivo4 = $_FILES["archivo4"]["name"];
            $archivo_guardado4 = $directorio_destino . "copia_" . $archivo4;

            // Verificar si el archivo ya existe en el directorio
            if (file_exists($archivo_guardado4)) {
                echo "El archivo ya existe. No se puede subir el mismo archivo nuevamente.";
            } else {
                $archivo_copiado4 = $_FILES["archivo4"]["tmp_name"];

                if (copy($archivo_copiado4, $archivo_guardado4)) {
                    $alert = "Se copió correctamente el archivo temporal a nuestra carpeta";
                } else {
                    echo "Error en el copiado <br/>";
                }

                if (file_exists($archivo_guardado4)) {
                    $fp = fopen($archivo_guardado4, "r");

                    fgetcsv($fp, 1000, ";");

                    while ($datos = fgetcsv($fp, 1000, ";")) {
                        // Transformar valores decimales (12,3)
                        $decimal_2 = $this -> convertirDecimal($datos[2]);
                        $decimal_3 = $this -> convertirDecimal($datos[3]);
                        $decimal_4 = $this -> convertirDecimal($datos[4]);

                        $resultado4 = insertar_datos4($datos[0], $datos[1], $decimal_2, $decimal_3, $decimal_4, $datos[5], $datos[6]);
                    }
                    if ($resultado4) {
                        echo '<script>alert("¡Los datos se han guardado correctamente!");</script>';
                        echo '<script>window.location.href = "/RemesasT/view/GuardarArchivo.php";</script>';
                    } else {
                        echo '<script>alert("Hubo un problema al guardar los datos.");</script>';
                        echo '<script>window.location.href = "/RemesasT/view/GuardarArchivo.php";</script>';
                    }
                } else {
                    echo "No existe el archivo copiado <br/>";
                }
            }
        }
    }
    public function procesarArchivo5() {
        if (isset($_POST["enviar5"])) {
            require_once "../conexion.php";
            require_once "../functions.php"; // Corregir la ruta del archivo functions.php

            $directorio_destino = 'C:/xampp/htdocs/RemesasT/exel/';
            $archivo5 = $_FILES["archivo5"]["name"];
            $archivo_guardado5 = $directorio_destino . "copia_" . $archivo5;

            // Verificar si el archivo ya existe en el directorio
            if (file_exists($archivo_guardado5)) {
                echo "El archivo ya existe. No se puede subir el mismo archivo nuevamente.";
            } else {
                $archivo_copiado5 = $_FILES["archivo5"]["tmp_name"];

                if (copy($archivo_copiado5, $archivo_guardado5)) {
                    $alert = "Se copió correctamente el archivo temporal a nuestra carpeta";
                } else {
                    echo "Error en el copiado <br/>";
                }

                if (file_exists($archivo_guardado5)) {
                    $fp = fopen($archivo_guardado5, "r");

                    fgetcsv($fp, 1000, ";");

                    while ($datos = fgetcsv($fp, 1000, ";")) {
                        $fecha_convertida_2 = $this->convertirFecha($datos[2]);

                        // Transformar valores decimales (12,3)
                        $decimal_3 = $this->convertirDecimal($datos[3]);
                        $decimal_4 = $this->convertirDecimal($datos[4]);
                        $decimal_5 = $this->convertirDecimal($datos[5]);

                        $resultado5 = insertar_datos5($datos[0], $datos[1], $fecha_convertida_2, $decimal_3, $decimal_4, $decimal_5);
                    }
                    if ($resultado5) {
                        echo '<script>alert("¡Los datos se han guardado correctamente!");</script>';
                        echo '<script>window.location.href = "/RemesasT/view/GuardarArchivo.php";</script>';
                    } else {
                        echo '<script>alert("Hubo un problema al guardar los datos.");</script>';
                        echo '<script>window.location.href = "/RemesasT/view/GuardarArchivo.php";</script>';
                    }
                } else {
                    echo "No existe el archivo copiado <br/>";
                }
            }
        }
    }
}
// Ejemplo de uso
$guardarArchivoController = new GuardarArchivoController();
$guardarArchivoController->procesarArchivo1();
$guardarArchivoController->procesarArchivo2();
$guardarArchivoController->procesarArchivo3();
$guardarArchivoController->procesarArchivo4();
$guardarArchivoController->procesarArchivo5();

?>
