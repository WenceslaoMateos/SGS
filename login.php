<?php

$precisa_sesion = false;
$msg_error = 0;
$permiso = 0;

require('templates/coneccion.php');


if(isset($_REQUEST['email']) && $_REQUEST['email'] != ""){
    $email = $_REQUEST['email'];
    $contra = $_REQUEST['contrasena'];
    $contra = md5($contra);
    
    $usuario = mysqli_query($db, "SELECT * FROM usuarios WHERE email = '$email' and contrasena = '$contra';");
    if(mysqli_num_rows($usuario) > 0){
        $usuario_db = mysqli_fetch_assoc($usuario);
        $_SESSION['id'] = $usuario_db['id'];
        $_SESSION['permiso'] = $usuario_db['permiso'];
        session_write_close();
        header('location: mapa.php');
        die();
    }
    else{
        $msg_error = 1;
    }
}

if (isset($_REQUEST['nuevo_contrasena']) && isset($_REQUEST['nuevo_email'])){
    $email = $_REQUEST['nuevo_email'];
    $nom = $_REQUEST['nombre'];
    $apell = $_REQUEST['apellido'];
    $contra = $_REQUEST['nuevo_contrasena'];
    $contra = md5($contra);
    $usuario = mysqli_query($db, "  INSERT INTO usuarios (nombre, apellido, contrasena, email) 
                                    VALUES ('$nom', '$apell', '$contra', '$email');");
    session_write_close();
    header('login.php');
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Log In</title>
        <?php include('templates/inicial/head.php');?>  
    </head>
    <body>
        <?php include('templates/inicial/header.php');?>  
        <main>
            <div class="jumbotron jumbotron-sm">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-lg-12">
                            <h3 class="h3">Acceso de usuarios <small> </small></h3>
                        </div>
                    </div>
                </div>
            </div>                        
            <div class="container">    
                <div id="loginbox" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
                    <div class="panel panel-info" >
                        <div style="padding-top:30px" class="panel-body" >
                        <?php if($msg_error == 1){?>
                        <div id="acceso_incorrecto" class="alert alert-warning">Nombre de usuario o contraseña incorrecto</div>
                        <?php } ?>
                            <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                            <form id="loginform" class="form-horizontal" role="form" method="post">
                                <div style="margin-bottom: 25px" class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <input id="login-username" type="text" class="form-control" name="email" value="" required placeholder="Correo electrónico">                                        
                                </div>                                
                                <div style="margin-bottom: 25px" class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                    <input id="login-password" type="password" class="form-control" name="contrasena" required placeholder="Contraseña">
                                </div>
                                    <div style="margin-top:10px" class="form-group">
                                        <div class="col-sm-12 controls">
                                            <button type="submit" id="btn-login" class="btn btn-success">Iniciar sesión  </a>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 control">
                                            <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >¿No tiene una cuenta? 
                                                <a href="#" onClick="$('#loginbox').hide(); $('#signupbox').show()">Crear cuenta</a>
                                            </div>
                                        </div>
                                    </div>    
                                </form>     
                            </div>                     
                        </div>  
                </div>
                <div id="signupbox" style="display:none;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                    <div class="jumbotron jumbotron-sm">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-12 col-lg-12 text-right  ">
                                    <h6 class="h6"><a id="signinlink" href="#" onclick="$('#signupbox').hide(); $('#loginbox').show()">Volver</a></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-info">
                        <div class="panel-heading">
                        <div class="panel-body" >
                            <form id="signupform" class="form-horizontal" method="post">
                                <div id="signupalert" style="display:none" class="alert alert-danger">
                                    <p>Error:</p>
                                    <span></span>
                                </div>                          
                                <div class="form-group">
                                    <label for="email" class="col-md-4 control-label">Correo Electrónico</label>
                                    <div class="col-md-9">
                                        <input type="email" class="form-control" name="nuevo_email" placeholder="Correo Electrónico">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="firstname" class="col-md-3 control-label">Nombre</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="nombre" placeholder="Nombre">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="lastname" class="col-md-3 control-label">Apellido</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="apellido" placeholder="Apellido">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="contrasena" class="col-md-3 control-label">Contraseña</label>
                                    <div class="col-md-9">
                                        <input type="password" class="form-control" name="nuevo_contrasena" placeholder="Contraseña">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" id="btn-login" class="btn btn-success">Crear  </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> 
            </div>
        </main>
        <?php include('templates/inicial/footer.php');?>  
        <script>
            $()
            $('ul li:nth-child(3)').addClass('active');
            $('ul li:nth-child(3) a').addClass('active').append('<span class="sr-only">(current)</span>');
        </script>
    </body>
</html>