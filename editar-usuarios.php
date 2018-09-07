<?php

$precisa_sesion = true;
$msg_error = 0;
$permiso = 4294967295;

require('templates/coneccion.php');

$sql = mysqli_query($db, 'SELECT * FROM usuarios;');
$usr_listado="";
if($sql){
    while($usuario = mysqli_fetch_array($sql)){
        $usr_listado .= '
        <tr>
        <td>' . $usuario['id'] . '</td>
        <td>' . $usuario['nombre'] . '</td>
        <td>' . $usuario['apellido'] . '</td>
        <td>' . $usuario['email'] . '</td>
        <td>' . $usuario['permiso'] . '</td>
        <td>
        <a href="editar-usuarios-DB.php?id=' . $usuario['id'] . '&confirma=no" class="btn btn-primary">Editar</a>
        <a href="borrar-usuario.php?id=' . $usuario['id'] . '" class="btn btn-warning">Borrar</a>
        </td>
        </tr>
        ';
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Edicion de Usuarios</title>
        <?php include('templates/inicial/head.php');?>  
    </head>
    <body>
    <?php include('templates/online/header.php');?>  
        <div class="jumbotron jumbotron-sm">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <h3 class="h3">Edición de usuarios</h3>
                        <p>Aqui usted puede administrar usuarios dentro sistema. Recuerde que todo cambio será permanente.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <h1>Usuarios</h1>
                </div>
                <!--<div class="col-6 mt-2">
                    <a href="cargar-campania.php" class="btn btn-primary">Agregar nuevo</a>
                </div>-->
            </div>
            <div class="row">
                <div class="col">
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Email</th>
                                <th>Permiso</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>    
                        <tbody>
                            <?php echo $usr_listado;?>
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