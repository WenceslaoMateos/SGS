<?php

$precisa_sesion = true;
$msg_error = 0;
$permiso = 0;

require('templates/coneccion.php');

if(isset($_REQUEST['enviado']) && ($_REQUEST['enviado'] == "si")){
    exec("grdview ". $_FILES['adjunto']['tmp_name'] ." " .  $_REQUEST["-Wc"] ." -B1a2 -BWSneZ+b+tBatimetrico -JM-57/-38/7i " . $_REQUEST["tipoImagen"] . " -JZ4i -P -p170/20 -Cmagma.cpt > map.ps");
    exec("psconvert -Tf -Z -A4 -E720 map.ps");
    $filename= "map.pdf";
    header("Content-type: application/octet-stream");
    header("Content-disposition: attachment; filename=$filename");
    readfile($filename);
}
else
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Carga de batimetrías</title>
        <?php include('templates/inicial/head.php');?>  
    </head>
<body>
    <?php include('templates/online/header.php');?>  
    <main>
        <div class="jumbotron jumbotron-sm">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <h3 class="h3">Carga de datos batimétricos</h3>
                        <p>Aqui usted puede cargar datos batimétricos dentro del sistema.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <form method="post" name="archivo" enctype="multipart/form-data">
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" name="-Wc" value=" -Wc" class="form-check-input" checked>Curvas de nivel
                    </label>
                </div>
                <div class="form-group">
                    <label for="tipoImagen">Tipo de imagen</label>
                    <select class="form-control" name="tipoImagen" id="tipoImagen">
                        <option name="-Q" value=" -Qs">Superficie</option>
                        <option name="-Q" value=" -Qm">Grilla</option>
                        <option name="-Q" value=" -Qi">Imagen</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tipoArchivo">Tipo de imagen</label>
                    <select class="form-control" name="tipoArchivo" id="tipoArchivo">
                        <option name="-T" value=" -Tf">pdf</option>
                        <option name="-T" value=" -Tb">bmp</option>
                        <option name="-T" value=" -Te">eps</option>
                        <option name="-T" value=" -TE">eps PageSize</option>
                        <option name="-T" value=" -TF">pdf Multipagina</option>
                        <option name="-T" value=" -Tj">jpeg</option>
                        <option name="-T" value=" -Tg">png</option>
                        <option name="-T" value=" -TG">png Transparente</option>
                        <option name="-T" value=" -Tm">PPM</option>
                        <option name="-T" value=" -Ts">SVG</option>
                        <option name="-T" value=" -Tt">TIF</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputFile">Adjuntar</label>
                    <input name="adjunto" type="file" class="form-control-file" id="adjunto" accept=".tmp" aria-describedby="fileHelp">
                    <small id="fileHelp" class="form-text text-muted">Datos adicionales de informacion para las batimetrias</small>
                </div>
                <button type="submit" class="btn btn-primary" name="enviar" value="enviar">Enviar</button>
                <input type="hidden" name="enviado" value="si"/>
            </form>
        </div>
    </main>
    <?php include('templates/inicial/footer.php');?>      
    <script>
        $('ul li:nth-child(4)').addClass('active');
        $('ul li:nth-child(4) a').addClass('active').append('<span class="sr-only">(current)</span>');
    </script>
    </body>
</html>
