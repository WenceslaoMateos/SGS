<?php

$precisa_sesion = true;
$msg_error = 0;
$permiso = 100;

require('templates/coneccion.php');

$id = $_REQUEST['id'];

$barco_query = mysqli_query($db, "SELECT * FROM barcos WHERE id=" . $id . ";");

$barco = mysqli_fetch_assoc($barco_query);

$confirma = $_REQUEST['confirma'];

if ($confirma == "si"){
    $nombre = $_REQUEST['nombreBarco'];

    $actualiza = mysqli_query($db, "UPDATE barcos SET nombre = '" . $nombre . "' WHERE id=" . $id . ";");

    header("location: editar-barcos.php");
    die();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Edición de barco</title>
        <?php include('templates/inicial/head.php');?>  
    </head>
<body>
    <?php include('templates/online/header.php');?>  
    <main>
        <div class="jumbotron jumbotron-sm">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <h3 class="h3">Edición de barcos</h3>
                        <p>Aqui usted puede editar el barco seleccionado.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin: 0px;">
            <div class="col-7" id="crearcampania">
                <form action="editar-barco-DB.php" method="post">
                <label for="nombreBarco">Nombre del barco</label>
                    <input type="text" name="nombreBarco" id="nombreBarco" class="form-control" placeholder="Nombre del barco" value="<?php echo $barco['nombre'] ?>">
                    <button class="btn btn-primary ml-5 mt-3" type="submit">Cargar</button>
                    <input type="hidden" name="id" value="<?php echo $id;?>"/>
                    <input type="hidden" name="confirma" value="si"/>
                </form>
            </div>
        </div>
    </main>
    <?php include('templates/inicial/footer.php');?>      
    <script>
        $('ul li:nth-child(3)').addClass('active');
        $('ul li:nth-child(3) a').addClass('active').append('<span class="sr-only">(current)</span>');
    </script>
    </body>
</html>