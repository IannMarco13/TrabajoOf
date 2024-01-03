<?php
// Esta funcion insertara datos en la tabla Remesas_Chile_Bolivia
    function insertar_datos1($conexion, $codigo, $fecha, $estado, $air, $agr, $ope, $origen, $crd, $destino, $moneda, $monto, $comision_por, $comision_clp, $recibido_usd, $recibido_clp, $total_clp, $remitente, $destinatario) {
    global $conexion;
    $sentencia = "INSERT INTO remesas_env_chile_bolivia (CODIGO, FECHA, ESTADO, AIR, AGR, OPE, ORIGEN, CRD, DESTINO, MONEDA, MONTO, COMISION_POR, COMISION_CLP, RECIBIDO_USD, RECIBIDO_CLP, TOTAL_CLP, REMITENTE, DESTINATARIO) VALUES ($codigo, '$fecha', '$estado', $air, $agr, '$ope', '$origen', $crd, '$destino', '$moneda', '$monto', '$comision_por', '$comision_clp', '$recibido_usd', '$recibido_clp', '$total_clp', '$remitente', '$destinatario')";
    $ejecutar = mysqli_query($conexion, $sentencia);
    
    return $ejecutar;
 }
 function insertar_datos2($conexion,$codigo, $air, $fechaEnv ,$origen, $destino, $fechaPag, $estado, $monBob, $monUsd, $remitente, $destinatario) {
  
    global $conexion;
    $sentencia = "INSERT INTO report_chile_bolivia (CODIGO_R, AIR_R, FECHA_ORI, ORIGEN_R, DESTINO_R, FECHA_PAG, ESTADO_R, MONTO_BOB, MONTO_USD, REMITENTE_R, DESTINATARIO_R) VALUES ($codigo, $air, '$fechaEnv','$origen', '$destino', '$fechaPag', '$estado', '$monBob', '$monUsd', '$remitente', '$destinatario')";
    $ejecutar = mysqli_query($conexion, $sentencia);
    //var_dump($sentencia);
    return $ejecutar;    
}
function insertar_datos3($conexion, $codigo_b, $fecha_b,$correlativo_b,$documento_b,$usu_financiero, $telefono_U, $destinatario_b, $Telefono_d,$origen_b, $operador_b,$moneda_env,$destino_b,$monto_env,$por_com,$comision_b,$tipo_cambio,$monto_bob_b,$comison_bob,$Itf_bob,$ultima_modifi, $estado_b) {
    global $conexion;
    $sentencia = "INSERT INTO remesas_bolivia_chile (CODIGO_B, FECHA_B, CORRELATIVO_B, DOCUMENTO_B, USU_FINCACIERO, TELEFONO_U, DESTINATARIO_B, TELEFONO_D, ORIGEN_B, OPERADOR_B,DESTINO_B, MONEDA_ENV, MONTO_ENV, POR_COM, COMISION_B, TIPO_CAMBIO, MONTO_BOB_B, COMISION_BOB, ITF_BOB, ULTIMA_MODIFI, ESTADO_B) VALUES ($codigo_b, '$fecha_b','$correlativo_b','$documento_b','$usu_financiero', $telefono_U, '$destinatario_b', $Telefono_d,'$origen_b', '$operador_b','$destino_b','$moneda_env','$monto_env','$por_com','$comision_b','$tipo_cambio','$monto_bob_b','$comison_bob','$Itf_bob','$ultima_modifi', '$estado_b')";
    $ejecutar = mysqli_query($conexion, $sentencia);
    var_dump($sentencia);
    return $ejecutar;
 }

 function insertar_datos4($conexion, $fecha, $moneda_s, $resultado_s ,$tc_of, $saldo_bob, $cod_ag, $agencia_a) {
  
    global $conexion;
    $sentencia = "INSERT INTO saldo_cajas (FECHA ,MONEDA_S ,SALDO_S ,TC_OF ,SALDO_BOB ,COD_AG ,AGENCIA_A ) VALUES ('$fecha', '$moneda_s', '$resultado_s' ,'$tc_of', '$saldo_bob', '$cod_ag', '$agencia_a')";
    $ejecutar = mysqli_query($conexion, $sentencia);
    //var_dump($sentencia);
    return $ejecutar;
    
 }
 function insertar_datos5($conexion,$agencia_b,$moneda_b, $fecha_b, $saldo_b, $tc_oficial, $saldo_bob) {
  
   global $conexion;
   $sentencia = "INSERT INTO disp_boveda (AGENCIA_B, MONEDA_B, FECHA_B, SALDO_B, TC_OFICIAL, SALDO_BOB) VALUES ('$agencia_b','$moneda_b', '$fecha_b', '$saldo_b', '$tc_oficial', '$saldo_bob')";
   $ejecutar = mysqli_query($conexion, $sentencia);
   //var_dump($sentencia);
   return $ejecutar;
   
}
?>