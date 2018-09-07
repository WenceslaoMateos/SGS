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
$permiso = 15;

require('templates/coneccion.php');

if (isset($_REQUEST['nombreBarco']) && $_REQUEST['nombreBarco'] != ""){
    
    $nombre = $_REQUEST['nombreBarco'];
    $usuario = mysqli_query($db, "  INSERT INTO barcos (nombre) 
                                    VALUES ('$nombre');");
}
header("location: ./cargar-barco.php");
die();
?>