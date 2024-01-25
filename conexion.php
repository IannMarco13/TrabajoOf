        <?php
        /**conexion a BD */
        $usuario     = "root";
        $password    = "";
        $servidor    = "localhost";
        $basededatos = "remesas";
        $conexion = mysqli_connect($servidor, $usuario, $password) or die("No se ha podido conectar al Servidor");
        mysqli_query($conexion,"SET SESSION collation_connection ='utf8_unicode_ci'");
        $db = mysqli_select_db($conexion, $basededatos) or die("Upps! Error en conectar a la Base de Datos");

        class Conexion {
            public static function Conectar() {
                // Configuración de la base de datos
                $usuario     = "root";
                $password    = "";
                $servidor    = "localhost";
                $basededatos = "remesas";

                try {
                    // Intentar conectar a la base de datos usando PDO
                    $pdo = new PDO("mysql:host=$servidor;dbname=$basededatos;charset=utf8", $usuario, $password);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    return $pdo;
                } catch (PDOException $e) {
                    die("Error al conectar a la base de datos: " . $e->getMessage());
                }
            }
        }


        ?>