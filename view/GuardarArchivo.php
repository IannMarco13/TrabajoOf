<?php
include '../includes/header.php';
require_once __DIR__ . '../../vendor/autoload.php';

require_once '../controllers/GuardarArchivoController.php';
require_once '../models/GuardarArchivoModel.php';

$controller = new GuardarArchivoController();
?>
<body>
    <div class="container-guardar">
        <div class="container-1">
            <div class="guardar_archivo">
                <div class="formulario">
                    <br>
                    <h1> REMESAS CHILE BOLIVIA </h1>
                    <form action="GuardarArchivo.php" class="formulariocompleto" method="post" enctype="multipart/form-data">
                        <input type="file" id="archivo1" name="archivo1" class="form input-file" />
                        <button type="submit" class="submit-button" name="enviar1">
                            <i class="fas fa-folder"></i> Subir Archivo Remesas Chile Bolivia
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="container-2">
            <div class="guardar_archivo">
                <div class="formulario">
                    <h1> REPORTE REMESAS CHILE BOLIVIA </h1>
                    <form action="GuardarArchivo.php" class="formulariocompleto" method="post" enctype="multipart/form-data">
                        <input type="file" id="archivo2" name="archivo2" class="form input-file" />
                        <!--<input type="submit" value="Subir Archvo Reportes" class="submit-button" name="enviar2">-->
                        <button type="submit" class="submit-button" name="enviar2">
                            <i class="fas fa-folder"></i> Subir Archivo Reportes
                        </button>
                    </form>
                    <script src="assets/js/guardar.js"></script>
                </div>
            </div>
        </div>

        <div class="container-3">
            <div class="guardar_archivo">
                <div class="formulario">
                    <h1> REMESAS BOLIVIA CHILE </h1>
                    <form action="GuardarArchivo.php" class="formulariocompleto" method="post" enctype="multipart/form-data">        
                    <input type="file" id="archivo3" name="archivo3" class="form input-file"/>
                    <button type="submit" class="submit-button" name="enviar3">
                            <i class="fas fa-folder"></i> Subir Archivo Remesas Bolivia
                        </button>
                    </form>
                </div>
            </div>
        </div>  

        <div class="container-1">
            <div class="guardar_archivo">
                <div class="formulario">
                    <h1> SALDO DE CAJAS </h1>
                    <form action="GuardarArchivo.php" class="formulariocompleto" method="post" enctype="multipart/form-data">
                        <input type="file" id="archivo4" name="archivo4" class="form input-file"/>
                        <button type="submit" class="submit-button" name="enviar4">
                            <i class="fas fa-folder"></i>Subir Archivo Cierre De Cajas
                        </button>
                    </form>
                    <script src="assets/js/guardar.js"></script>
                </div>
            </div>
        </div>

        <div class="container-3">
            <div class="guardar_archivo">
                <div class="formulario">
                    <h1> DISPONIBILIDAD EN BÓVEDA </h1>
                    <form action="GuardarArchivo.php" class="formulariocompleto" method="post" enctype="multipart/form-data">
                        <input type="file" id="archivo5" name="archivo5" class="form input-file"/>
                        <button type="submit" class="submit-button" name="enviar5">
                            <i class="fas fa-folder"></i>Subir Archivo Cierre De Cajas
                        </button>
                    </form>
                    <script src="assets/js/guardar.js"></script>
                </div>
            </div>
        </div>
    </div>
</body>
<?php 
include '../includes/footer.php'; ?>