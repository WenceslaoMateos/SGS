<?php

$precisa_sesion = true;
$msg_error = 0;
$permiso = 50;

require('templates/coneccion.php');

$sql = mysqli_query($db, 'SELECT campanias.id, campanias.nombre, barcos.nombre AS barco, descripcion FROM campanias INNER JOIN barcos ON campanias.idbarcos = barcos.id ORDER BY barco ASC;');
$camp_listado="";
if($sql){
    while($camp = mysqli_fetch_array($sql)){
        $camp_listado .= '
        <tr>
        <td>' . $camp['id'] . '</td>
        <td>' . $camp['nombre'] . '</td>
        <td>' . $camp['barco'] . '</td>
        <td>' . $camp['descripcion'] . '</td>
        <td>
        <a href="editar-campania-DB.php?id=' . $camp['id'] . '" class="btn btn-primary">Editar</a>
        <a href="borrar-campania.php?id=' . $camp['id'] . '" class="btn btn-warning">Borrar</a>
        </td>
        </tr>
        ';
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Edicion de Campañas</title>
        <?php include('templates/inicial/head.php');?>  
    </head>
    <body>
    <?php include('templates/online/header.php');?>  
        <div class="jumbotron jumbotron-sm">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                    <h3 class="h3">Edición de datos</h3>
                        <p>Aqui usted puede administrar campañas dentro sistema. Recuerde que todo cambio será permanente.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <h1>Campañas</h1>
                </div>
                <div class="col-6 mt-2">
                    <a href="cargar-campania.php" class="btn btn-primary">Agregar nueva</a>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Barco</th>
                                <th>Descripción</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo $camp_listado;?>
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