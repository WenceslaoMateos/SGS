<?php

$precisa_sesion = true;
$msg_error = 0;
$permiso = 15;

require('templates/coneccion.php');


?>
<!DOCTYPE html>
<html>
    <head>
        <title>Carga de barcos</title>
        <?php include('templates/inicial/head.php');?>  
    </head>
<body>
    <?php include('templates/online/header.php');?>  
    <main>
        <div class="jumbotron jumbotron-sm">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <h3 class="h3">Carga de nuevos barcos</h3>
                        <p>Aqui usted puede cargar nuevos barcos en el sistema.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
        <div class="row" style="margin: 0px;">
            <div class="col-7" id="crearbarco">
                <form action="cargar-barco-DB.php" method="post">
                    <label for="nombreBarco">Nombre del barco</label>
                    <input type="text" name="nombreBarco" id="nombreBarco" class="form-control" required placeholder="Nombre del barco">
                    <button class="btn btn-primary ml-5 mt-3" type="submit">Cargar</button>
                </form>
            </div>
        </div>
        </div>
    </main>
    <?php include('templates/inicial/footer.php');?>      
    <script>
        $('ul li:nth-child(2)').addClass('active');
        $('ul li:nth-child(2) a').addClass('active').append('<span class="sr-only">(current)</span>');
    </script>
    </body>
</html>