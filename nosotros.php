<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Nosotros</title>
        <link href="css/full.css" rel="stylesheet">
        <?php include('templates/inicial/head.php');?>  
    </head>
    <body>
        <?php include('templates/inicial/header.php');?>  
        <main>
            <div class="jumbotron jumbotron-sm">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-lg-12">
                            <h3 class="h3">¿Quienes somos?<small>¡Es un gusto conocerlo!</small></h3>
                            <p>Somos integrantes de la Facultad de Ingeniería de la UNMDP. Residimos en el laboratorio del GTI en el anexo de la misma.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="my-4">Nuestro equipo</h2>
                    </div>
                    <div class="col-lg-4 col-sm-6 text-center mb-4">
                        <img class="rounded-circle img-fluid d-block mx-auto" width="140" height="140" src="./images/felipe.jpg" alt="">
                        <h3>Felipe Evans<br><small>Ingeniero Electrónico</small></h3>
                        <p>Director del proyecto, diseñador y analista principal</p>
                    </div>
                    <div class="col-lg-4 col-sm-6 text-center mb-4">
                        <img class="rounded-circle" src="./images/yo.jpg" alt="" width="140" height="140">
                        <h3>Wenceslao Mateos<br><small>Técnico en Informática</small></h3>
                        <p>Diseñador, desarrollador, tester</p>
                    </div>
                </div>
            </div>
        </main>
        <?php include('templates/inicial/footer.php');?>  
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script>
            $('ul li:nth-child(2)').addClass('active');
            $('ul li:nth-child(2) a').addClass('active').append('<span class="sr-only">(current)</span>');
        </script>
    </body>
</html>