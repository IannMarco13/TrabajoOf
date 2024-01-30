<!-- header.php -->
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>INICIO</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <!-- Otros estilos CSS -->
    <link rel="stylesheet" href="/REMESAST/assets/css/styles-header.css">
    <link rel="stylesheet" href="/REMESAST/assets/css/styles-footer.css">
    <link rel="stylesheet" href="/REMESAST/assets/css/Buscador-Fechas.css">
    <link rel="stylesheet" href="/REMESAST/assets/css/tabla.css">
    <link rel="stylesheet" href="/REMESAST/assets/css/container.css">
    
    <!-- Datatables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css"/>
    <!-- Datatables Responsive CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
    <!-- jQuery, Popper.js, Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    <!-- Datatables JS -->
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>
    <!-- Datatables Responsive JS -->
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script> 

    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="/REMESAST/assets/js/AperturaCajas.js"></script>
    <script src="/REMESAST/assets/js/CierreCajas.js"></script>
<body>
<header  class="header-home">
        <nav>
            <input type="checkbox" id="check">
            <label for="check" class="checkbtn">
                <i class="fas fa-bars"></i>
            </label>
            <a href="#" class="enlace">
                <img src="/REMESAST/assets/img/logocompleto.png" alt="" class="logo">
            </a>
            <ul class="cont-ul">

            <li><a href="/REMESAST/index.php">INICIO</a></li>
            <li><a href="/REMESAST/view/GuardarArchivo.php">SUBIR ARCHIVO</a></li>
            <li class="develop">
                <a href="#">CONULTAS</a> 
                <ul class="ul-second">
                    <li class="front"><a href="/RemesasT/view/RemesasChileBolivia.php">Chile - Bolivia</a> </li>
                    <li class="back"><a href="/REMESAST/view/ReporteBoliviaChile.php">Bolivia - Chile</a></li>
                    <li class="front">
                        <a href="#">Consultas</a>
                        <ul class="ul-third">
                            <li class="back"><a href="/REMESAST/view/ConsultaPagadoMismoDia.php">Consultas 1</a></li>
                            <li class="back"><a href="/REMESAST/view/ConsultaPagadoDistintoDia.php">Consultas 2</a></li>
                            <li class="back"><a href="/REMESAST/view/ConsultaNoPafago.php">Consultas 3</a></li>
                            <li class="back"><a href="/REMESAST/view/">Compra-Venta</a></li>
                            <li class="back"><a href="/REMESAST/view/">Acta Entrega</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="develop">
                <a href="#">Cajas</a> 
                <ul class="ul-second">
                    <li class="front">
                        <a href="#">Cierre</a> 
                        <ul class="ul-third"">
                            <li class="back"><a href="/REMESAST/view/CierreCajas/CierreCajaBOB.php">Cierre Cajas</a></li>
                            <li class="back"><a href="/REMESAST/Mostrar_rem_reporte.php">Reporte</a></li>
                        </ul>
                    </li>
                    <li class="front">
                        <a href="#">Apertura</a>
                        <ul class="ul-third">
                            <li class="back"><a href="/REMESAST/view/AperturaCajas/AperturaCajaBOB.php">Apertura Cajas</a></li>
                            <li class="back"><a href="/REMESAST/consulta2.php">Reporte</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="back"><a href="/REMESAST/saldo_cajas.php">Saldos de Caja</a></li>
            <li class="back"><a href="/REMESAST/Dis_boveda.php">Disponibilidad en Bóveda</a></li>
        </ul>
        <br>
    </nav>
    </header>
</body>
</html>