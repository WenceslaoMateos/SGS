<?php

$precisa_sesion = true;
$msg_error = 0;
$permiso = 10;

require('templates/coneccion.php');


?>
<!DOCTYPE html>
<html>
    <head>
        <title>Carga de campañas</title>
        <?php include('templates/inicial/head.php');?>  
    </head>
<body>
    <?php include('templates/online/header.php');?>  
    <main>
        <div class="jumbotron jumbotron-sm">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <h3 class="h3">Carga de nuevas campañas</h3>
                        <p>Aqui usted puede cargar nuevas campañas en el sistema.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
        <div class="row" style="margin: 0px;">
            <div class="col-7" id="crearcampania">
                <form action="cargar-campania-DB.php" method="post">
                    <select class="form-control" name="cargaBarcoCamp" required id="cargaBarcoCamp">
                        <option value="">Seleccione un barco</option>
                        <?php
                        $barcos = mysqli_query($db, "SELECT * FROM barcos;");
                        if(mysqli_num_rows($barcos) > 0){
                            while($barco = mysqli_fetch_assoc($barcos)){
                                echo '<option value="' . $barco['id'] . '">' . $barco['nombre'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <label for="nombreCamp">Nombre de la campaña</label>
                    <input type="text" required name="nombreCamp" id="nombreCamp" class="form-control" placeholder="Nombre de la campaña">
                    <label for="descripcion">Descripción de la campaña</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
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