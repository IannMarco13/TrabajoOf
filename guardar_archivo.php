<?php 
include("encabezado.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Guardar Archivo</title>
    
    <!--<link rel="stylesheet" href="assets/css/style.css">-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="assets/css/guardarA.css">
    <!--Boostrap JS-->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    <!-- Datatables-->
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>  
    <!-- Datatables responsive -->
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
</head>
<body>
    <br>
    <div class="guardar_archivo">
        <div class="formulario">
            <h1>
                REMESAS CHILE BOLIVIA
            </h1>
            <form action="guardar_archivo.php" class="formulariocompleto" method="post" enctype="multipart/form-data">
                <input type="file" id="archivo1" name="archivo1" class="form input-file" />
                <button type="submit" class="submit-button" name="enviar1">
                    <i class="fas fa-folder"></i> Subir Archivo
                </button>
            </form>
            <script src="assets/js/guardar.js"></script>
        </div>
    </div>
   
    <div class="guardar_archivo">
        <div class="formulario">
            <h1>
               REPORTE REMESAS CHILE BOLIVIA
            </h1>
            <form action="guardar_archivo.php" class="formulariocompleto" method="post" enctype="multipart/form-data">
                <input type="file" id="archivo2" name="archivo2" class="form input-file" />
                <!--<input type="submit" value="Subir Archvo Reportes" class="submit-button" name="enviar2">-->
                <button type="submit" class="submit-button" name="enviar2">
                    <i class="fas fa-folder"></i> Subir Archivo Reportes
                </button>
            </form>
            
            <script src="assets/js/guardar.js"></script>
        </div>
    </div>
    <div class="guardar_archivo">
        <div class="formulario">
            <h1>
                REMESAS BOLIVIA CHILE
            </h1>
            <form action="guardar_archivo.php" class="formulariocompleto" method="post" enctype="multipart/form-data">        
            <input type="file" id="archivo3" name="archivo3" class="form input-file"/>
            <button type="submit" class="submit-button" name="enviar3">
                    <i class="fas fa-folder"></i> Subir Archivo Remesas Bolivi
                </button>
        </form>
    </div>
</div>

</body>
</html>
<?php
    //require_once("menu.php");
    if (isset($_POST["enviar1"])) {//permite recepcionar una variable que si exista y que no sea null
    
        require_once("conexion.php");
        require_once("funtions.php");

        // Define la ruta de la carpeta donde deseas almacenar los archivos
        $directorio_destino = 'C:/xampp/htdocs/RemesasT/exel/';
        
        //Datos remesas Chile Bolivia
        $archivo1 = $_FILES["archivo1"]["name"];
        $archivo_copiado1 = $_FILES["archivo1"]["tmp_name"];
        $archivo_guardado1 = $directorio_destino . "copia_" . $archivo1;
        //echo $archivo. "esta en la ruta temporal: " .$archivo_copiado;
    
        if (copy($archivo_copiado1, $archivo_guardado1)) {
            $alert = "Se copio correctamente el archivo temmporal a nuestra carpeta";
            //echo "Se copio correctamente el archivo temmporal a nuestra carpeta <br/>";
        }else{
            echo"Error en el copiado <br/>";
        }
    
        if(file_exists($archivo_guardado1)) {
            $fp = fopen($archivo_guardado1,"r");
            
            while ($datos = fgetcsv($fp,1000,";")) {
    
                $fecha_convertida_1 = date('Y-m-d H:i:s', strtotime(str_replace('-', '-', $datos[1])));
                $datos[1] = $fecha_convertida_1;
    
                // Transformar valores decimales (12,3)
                $decimal_10 = str_replace(".", "", $datos[10]); // Eliminar puntos de los miles
                $decimal_10 = str_replace(",", ".", $decimal_10); // Reemplazar comas por puntos
                $decimal_10 = floatval($decimal_10); // Convertir a float
    
                $decimal_11 = str_replace(".", "", $datos[11]); // Eliminar puntos de los miles
                $decimal_11 = str_replace(",", ".", $decimal_11); // Reemplazar comas por puntos
                $decimal_11 = floatval($decimal_11); // Convertir a float
    
                $decimal_12 = str_replace(".", "", $datos[12]); // Eliminar puntos de los miles
                $decimal_12 = str_replace(",", ".", $decimal_12); // Reemplazar comas por puntos
                $decimal_12 = floatval($decimal_12); // Convertir a float
    
                $decimal_13 = str_replace(".", "", $datos[13]); // Eliminar puntos de los miles
                $decimal_13 = str_replace(",", ".", $decimal_13); // Reemplazar comas por puntos
                $decimal_13 = floatval($decimal_13); // Convertir a float
    
                $decimal_14 = str_replace(".", "", $datos[14]); // Eliminar puntos de los miles
                $decimal_14 = str_replace(",", ".", $decimal_14); // Reemplazar comas por puntos
                $decimal_14 = floatval($decimal_14); // Convertir a float
    
                $decimal_15 = str_replace(".", "", $datos[15]); // Eliminar puntos de los miles
                $decimal_15 = str_replace(",", ".", $decimal_15); // Reemplazar comas por puntos
                $decimal_15 = floatval($decimal_15); // Convertir a float
    
                // Redondear a 3 decimales si es necesario
                $decimal_10 = number_format($decimal_10, 3, '.', '');
                $decimal_11 = number_format($decimal_11, 3, '.', '');
                $decimal_12 = number_format($decimal_12, 3, '.', '');
                $decimal_13 = number_format($decimal_13, 3, '.', '');
                $decimal_14 = number_format($decimal_14, 3, '.', '');
                $decimal_15 = number_format($decimal_15, 3, '.', '');
        
                
                $resultado1 = insertar_datos1($conexion,$datos[0], $datos[1], $datos[2], $datos[3], $datos[4], $datos[5], $datos[6], $datos[7], $datos[8], $datos[9], $decimal_10, $decimal_11, $decimal_12, $decimal_13, $decimal_14, $decimal_15, $datos[16], $datos[17]); 
                
                var_dump($resultado1);
            }

            if ($resultado1) {
                // Si se guardaron correctamente los datos
                echo '<script>alert("¡Los datos se han guardado correctamente!");</script>';
                echo '<script>window.location.href = "guardar_archivo.php";</script>'; 
            } else {
                echo '<script>alert("Hubo un problema al guardar los datos.");</script>';
                echo '<script>window.location.href = "guardar_archivo.php";</script>'; 
            }
                
        }else{
            echo "No existe el archivo copiado <br/>";
        }
    }
    
    if (isset($_POST["enviar2"])) {
        require_once("conexion.php");
        require_once("funtions.php");

        $directorio_destino = 'C:/xampp/htdocs/RemesasT/exel/';
        //Datos reporte remesas chile bolivia
        $archivo2 = $_FILES["archivo2"]["name"];
        $archivo_copiado2 = $_FILES["archivo2"]["tmp_name"];
        $archivo_guardado2 = $directorio_destino . "copia_".$archivo2;

        if (copy($archivo_copiado2, $archivo_guardado2)) {
            echo "Se copio correctamente el archivo temmporal a nuestra carpeta <br/>";
        }else{
            echo"Error en el copiado <br/>";
        }
        if(file_exists($archivo_guardado2)) {
            $fp = fopen($archivo_guardado2,"r");
            while ($datos = fgetcsv($fp,1000,";")) {
                $fecha_convertida_2 = ($datos[2] === '-' || empty($datos[2])) ? NULL : DateTime::createFromFormat('d-m-Y H:i:s', $datos[2]);
                $fecha_convertida_5 = ($datos[5] === '-' || empty($datos[5])) ? NULL : DateTime::createFromFormat('d-m-Y H:i:s', $datos[5]);
                if ($fecha_convertida_2) {
                    $fecha_convertida_2 = $fecha_convertida_2->format('Y-m-d H:i:s');
                }
                if ($fecha_convertida_5) {
                    $fecha_convertida_5 = $fecha_convertida_5->format('Y-m-d H:i:s');
                }
                // Transformar valores decimales (12,3)
                $decimal_7 = str_replace(".", "", $datos[7]); // Eliminar puntos de los miles
                $decimal_7 = str_replace(",", ".", $decimal_7); // Reemplazar comas por puntos
                $decimal_7 = floatval($decimal_7); // Convertir a float

                $decimal_8 = str_replace(".", "", $datos[8]); // Eliminar puntos de los miles
                $decimal_8 = str_replace(",", ".", $decimal_8); // Reemplazar comas por puntos
                $decimal_8 = floatval($decimal_8); // Convertir a float

                // Redondear a 3 decimales si es necesario
                $decimal_7 = number_format($decimal_7, 3, '.', '');
                $decimal_8 = number_format($decimal_8, 3, '.', '');
                
                // Llamar a la función de inserción con la fecha convertida
                $resultado2 = insertar_datos2($conexion,$datos[0], $datos[1], $fecha_convertida_2, $datos[3], $datos[4], $fecha_convertida_5, $datos[6], $decimal_7, $decimal_8, $datos[9], $datos[10]);
            }
        }else{
            echo "No existe el archivo copiado <br/>";
        }  
    }

    if (isset($_POST["enviar3"])) {//permite recepcionar una variable que si exista y que no sea null
    
        require_once("conexion.php");
        require_once("funtions.php");

        $directorio_destino = 'C:/xampp/htdocs/RemesasT/exel/';
    
        //Datos remesas Chile Bolivia
        $archivo3 = $_FILES["archivo3"]["name"];
        $archivo_copiado3 = $_FILES["archivo3"]["tmp_name"];
        $archivo_guardado3 = $directorio_destino."copia_".$archivo3;
        
        //echo $archivo. "esta en la ruta temporal: " .$archivo_copiado;
    
        if (copy($archivo_copiado3, $archivo_guardado3)) {
            $alert = "Se copio correctamente el archivo temmporal a nuestra carpeta";
            //echo "Se copio correctamente el archivo temmporal a nuestra carpeta <br/>";
        }else{
            echo"Error en el copiado <br/>";
        }
    
        if(file_exists($archivo_guardado3)) {
            $fp = fopen($archivo_guardado3,"r");
            
            while ($datos = fgetcsv($fp,1000,";")) {
    
                $fecha_convertida_1 = ($datos[1] === '-' || empty($datos[1])) ? NULL : DateTime::createFromFormat('d-m-Y H:i:s', $datos[1]);
                $fecha_convertida_19 = ($datos[19] === '-' || empty($datos[19])) ? NULL : DateTime::createFromFormat('d-m-Y H:i:s', $datos[9]);
    
                if ($fecha_convertida_1) {
                    $fecha_convertida_1 = $fecha_convertida_1->format('Y-m-d H:i:s');
                }
                if ($fecha_convertida_19) {
                    $fecha_convertida_19 = $fecha_convertida_19->format('Y-m-d H:i:s');
                }
    
                // Transformar valores decimales (12,3)
                $decimal_12 = str_replace(".", "", $datos[12]); // Eliminar puntos de los miles
                $decimal_12 = str_replace(",", ".", $decimal_12); // Reemplazar comas por puntos
                $decimal_12 = floatval($decimal_12); // Convertir a float
    
                $decimal_13 = str_replace(".", "", $datos[13]); // Eliminar puntos de los miles
                $decimal_13 = str_replace(",", ".", $decimal_13); // Reemplazar comas por puntos
                $decimal_13 = floatval($decimal_13); // Convertir a float
    
                $decimal_14 = str_replace(".", "", $datos[14]); // Eliminar puntos de los miles
                $decimal_14 = str_replace(",", ".", $decimal_14); // Reemplazar comas por puntos
                $decimal_14 = floatval($decimal_14); // Convertir a float
    
                $decimal_15 = str_replace(".", "", $datos[15]); // Eliminar puntos de los miles
                $decimal_15 = str_replace(",", ".", $decimal_15); // Reemplazar comas por puntos
                $decimal_15 = floatval($decimal_15); // Convertir a float
    
                $decimal_16 = str_replace(".", "", $datos[16]); // Eliminar puntos de los miles
                $decimal_16 = str_replace(",", ".", $decimal_16); // Reemplazar comas por puntos
                $decimal_16 = floatval($decimal_16); // Convertir a float
    
                $decimal_17 = str_replace(".", "", $datos[17]); // Eliminar puntos de los miles
                $decimal_17 = str_replace(",", ".", $decimal_17); // Reemplazar comas por puntos
                $decimal_17 = floatval($decimal_17); // Convertir a float
    
                $decimal_18 = str_replace(".", "", $datos[18]); // Eliminar puntos de los miles
                $decimal_18 = str_replace(",", ".", $decimal_18); // Reemplazar comas por puntos
                $decimal_18 = floatval($decimal_18); // Convertir a float
    
                // Redondear a 3 decimales si es necesario
                $decimal_12 = number_format($decimal_12, 2, '.', '');
                $decimal_13 = number_format($decimal_13, 2, '.', '');
                $decimal_14 = number_format($decimal_14, 2, '.', '');
                $decimal_15 = number_format($decimal_15, 2, '.', '');
                $decimal_16 = number_format($decimal_16, 2, '.', '');
                $decimal_17 = number_format($decimal_17, 2, '.', '');
                $decimal_18 = number_format($decimal_18, 2, '.', '');
                
                $resultado3 = insertar_datos3($conexion,$datos[0], $fecha_convertida_1, $datos[2], $datos[3], $datos[4], $datos[5], $datos[6], $datos[7], $datos[8], $datos[9], $datos[10], $datos[11], $decimal_12, $decimal_13, $decimal_14, $decimal_15,$decimal_16,$decimal_17,$decimal_18, $fecha_convertida_19, $datos[20]);
                    
            }
                
        }else{
            echo "No existe el archivo copiado <br/>";
        }
    }
?>