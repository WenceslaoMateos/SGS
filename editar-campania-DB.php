<?php

$precisa_sesion = true;
$msg_error = 0;
$permiso = 50;

require('templates/coneccion.php');

$id = $_REQUEST['id'];

$campania_query = mysqli_query($db, "SELECT * FROM campanias WHERE id=" . $id . ";");

$campania = mysqli_fetch_assoc($campania_query);


if (isset($_REQUEST['confirma']) && $_REQUEST['confirma'] == "si"){
    $nombre = $_REQUEST['nombreCamp'];
    $barco = $_REQUEST['cargaBarcoCamp'];
    $desc = $_REQUEST['descripcion'];

    $actualiza = mysqli_query($db, "UPDATE campanias SET nombre = '" . $nombre . "', idbarcos = '" . $barco . "', descripcion = '" . $desc . "' WHERE id=" . $id . ";");

    header("location: editar-campanias.php");
    die();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Edición de campaña</title>
        <?php include('templates/inicial/head.php');?>  
    </head>
<body>
    <?php include('templates/online/header.php');?>  
    <main>
        <div class="jumbotron jumbotron-sm">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <h3 class="h3">Edición de campañas</h3>
                        <p>Aqui usted puede editar la campaña seleccionada.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin: 0px;">
            <div class="col-7" id="crearcampania">
                <form action="editar-campania-DB.php" method="post">
                    <select class="form-control" name="cargaBarcoCamp" require id="cargaBarcoCamp">
                        <option value="">Seleccione un barco</option>
                        <?php
                        $barcos = mysqli_query($db, "SELECT * FROM barcos;");
                        if(mysqli_num_rows($barcos) > 0){
                            while($barco = mysqli_fetch_assoc($barcos)){
                                if ($campania['idbarcos'] == $barco['id'])
                                    echo '<option value="' . $barco['id'] . '" selected>' . $barco['nombre'] . '</option>';
                                else
                                    echo '<option value="' . $barco['id'] . '">' . $barco['nombre'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <label for="nombreCamp">Nombre de la campaña</label>
                    <input type="text" name="nombreCamp" id="nombreCamp" class="form-control" placeholder="Nombre de la campaña" value="<?php echo $campania['nombre'] ?>">
                    <label for="descripcion">Descripción de la campaña</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3"><?php echo $campania['descripcion'] ?></textarea>
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