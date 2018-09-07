<!DOCTYPE html>
<html>
    <head>
        <title>Carga de barcos</title>
        <?php include('templates/inicial/head.php');?>  
    </head>
    <body>
        <?php include('templates/online/header.php');?>  
        <main>
        <div class="container ml-5">
            <img class="col-3 ml-5" id="loading" style=""src="./images/loading.gif">
            </div>
        </main>
        <?php include('templates/inicial/footer.php');?>      
        <script>
            $('ul li:nth-child(2)').addClass('active');
            $('ul li:nth-child(2) a').addClass('active').append('<span class="sr-only">(current)</span>');
        </script>
    </body>
</html>
<?php

$precisa_sesion = true;
$msg_error = 0;
$permiso = 10;

require('templates/coneccion.php');

if (isset($_REQUEST['nombreCamp']) && $_REQUEST['nombreCamp'] != "" && $_REQUEST['cargaBarcoCamp'] != ""){
    
    $nombre = $_REQUEST['nombreCamp'];
    $idbarco = $_REQUEST['cargaBarcoCamp'];
    $desc = $_REQUEST['descripcion'];
    $sql = mysqli_query($db, "  INSERT INTO campanias (nombre, idbarcos, descripcion) 
                                    VALUES ('$nombre', $idbarco, '$desc');");

    echo $sql;
}
echo $sql;
header("location: cargar-campania.php");
die();
?>