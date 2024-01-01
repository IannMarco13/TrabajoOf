<?php
/**conexion a BD */
$usuario  = "root";
$password = "";
$servidor = "localhost";
$basededatos = "remesas";
$conexion = mysqli_connect($servidor, $usuario, $password) or die("No se ha podido conectar al Servidor");
mysqli_query($conexion,"SET SESSION collation_connection ='utf8_unicode_ci'");
$db = mysqli_select_db($conexion, $basededatos) or die("Upps! Error en conectar a la Base de Datos");

//bd_groomers
//minitienda


?>