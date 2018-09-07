<?php

$precisa_sesion = true;
$msg_error = 0;
$permiso = 4294967295;

require('templates/coneccion.php');

$id = $_REQUEST['id'];

$usuario_query = mysqli_query($db, "SELECT * FROM usuarios WHERE id=" . $id . ";");

$usr = mysqli_fetch_assoc($usuario_query);

$confirma = $_REQUEST['confirma'];

if ($confirma == "si"){
    $nombre = $_REQUEST['nombre'];
    $apellido = $_REQUEST['apellido'];
    $email = $_REQUEST['email'];
    $permiso = $_REQUEST['permiso'];
    $contra = $_REQUEST['contrasenia'];
    $contra = md5($contra);
    //agregar contraseña

    $actualiza = mysqli_query($db, "UPDATE usuarios SET contrasena = '" . $contra . "', nombre = '" . $nombre . "', apellido = '" . $apellido . "', email = '" . $email . "', permiso = '" . $permiso . "' WHERE id=" . $id . ";");

//    echo "UPDATE usuarios SET contrasena = '" . $contra . "' nombre = '" . $nombre . "', apellido = '" . $apellido . "', email = '" . $email . "', permiso = '" . $permiso . "' WHERE id=" . $id . ";";
    header("location: editar-usuarios.php");
    die();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Edición de usuario</title>
        <?php include('templates/inicial/head.php');?>  
    </head>
<body>
    <?php include('templates/online/header.php');?>  
    <main>
        <div class="jumbotron jumbotron-sm">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <h3 class="h3">Edición de usuarios</h3>
                        <p>Aqui usted puede editar el usuario seleccionado.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin: 0px;">
            <div class="col-7" id="crearcampania">
                <form action="editar-usuarios-DB.php" method="post">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre" value="<?php echo $usr['nombre'] ?>">

                    <label for="apellido">Apellido</label>
                    <input type="text" name="apellido" id="apellido" class="form-control" placeholder="Apellido" value="<?php echo $usr['apellido'] ?>">

                    <label for="permiso">Permiso</label>
                    <input type="text" name="permiso" id="permiso" class="form-control" placeholder="0 - 4294967295" value="<?php echo $usr['permiso'] ?>">

                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" class="form-control" placeholder="Email" value="<?php echo $usr['email'] ?>">

                    <label for="contrasenia" class="col-md-3 control-label">Contraseña</label>
                    <input type="password" class="form-control" name="contrasenia" placeholder="Contraseña">

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