<?php

$precisa_sesion = true;
$msg_error = 0;
$permiso = 1000;


require('templates/coneccion.php');

$sql = mysqli_query($db, 'SELECT * FROM barcos ORDER BY nombre ASC;');
$barco_listado="";
if($sql){
    while($barco = mysqli_fetch_array($sql)){
        $barco_listado .= '
            <tr>
                <td>' . $barco['id'] . '</td>
                <td>' . $barco['nombre'] . '</td>
                <td>
                    <a href="editar-barco-DB.php?id=' . $barco['id'] . '&confirma=no" class="btn btn-primary">Editar</a>
                    <a href="borrar-barco.php?id=' . $barco['id'] . '" class="btn btn-warning">Borrar</a>
                </td>
            </tr>
        ';
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Edición de barcos</title>
        <?php include('templates/inicial/head.php');?>  
    </head>
    <body>
    <?php include('templates/online/header.php');?>  
        <div class="jumbotron jumbotron-sm">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <h3 class="h3">Edición de datos</h3>
                        <p>Aqui usted puede administrar barcos dentro sistema. Recuerde que todo cambio será permanente.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <h1>Barcos</h1>
                </div>
                <div class="col-6 mt-2">
                    <a href="cargar-barco.php" class="btn btn-primary">Agregar nuevo</a>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo $barco_listado;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php include('templates/inicial/footer.php');?>      
        <script>
            $('ul li:nth-child(3)').addClass('active');
            $('ul li:nth-child(3) a').addClass('active').append('<span class="sr-only">(current)</span>');
    </script>
    </body>
</html>