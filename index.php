<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Home</title>
        <link href="./css/carousel.css" rel="stylesheet">
        <?php include('templates/inicial/head.php');?>  
    </head>
    <body>
        <?php include('templates/inicial/header.php');?>  
        <main class="main ">

      <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class=""></li>
          <li data-target="#myCarousel" data-slide-to="1" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="2" class=""></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item">
            <img class="first-slide" src="./images/austral.jpg" alt="First slide">
            <div class="container">
              <div class="carousel-caption text-left">
                <h1 class="carrusel">Mapas de hidrografia naval.</h1>
              </div>
            </div>
          </div>
          <div class="carousel-item active">
            <img class="second-slide" src="./images/base naval.jpg" alt="Second slide">
            <div class="container">
              <div class="carousel-caption">
                <h1 class="carrusel">Generación de batimetrias.</h1>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <img class="third-slide" src="./images/base naval 2.jpg" alt="Third slide">
            <div class="container">
              <div class="carousel-caption text-right">
                <h1 class="carrusel">Administración de datos.</h1>
              </div>
            </div>
          </div>
        </div>
        <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Anterior</span>
        </a>
        <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Siguiente</span>
        </a>
      </div>


      <!-- Marketing messaging and featurettes
      ================================================== -->
      <!-- Wrap the rest of the page in another container to center all the content. -->

      <div class="container marketing">

        <!-- Three columns of text below the carousel -->
        <div class="row">
          <div class="col-lg-4">
            <img class="rounded-circle" src="./images/felipe2.jpg" alt="Generic placeholder image" width="140" height="140">
            <h2>Felipe Evans</h2>
            <p>Es Ingeniero electrónico por la Facultad de Ingeniería de la Universidad Nacional de Mar del Plata (UNMdP). Se encuentra cursando la Maestría en Ingeniería en Software de la Facultad de Informática de la Universidad Nacional de La Plata (UNLP). Es profesor adjunto con dedicación exclusiva en la asignaturas Redes de Datos, Facultad de Ingeniería (UNMdP).</p>
          </div><!-- /.col-lg-4 -->
          <div class="col-lg-4">
            <img class="rounded-circle" src="./images/yo.jpg" alt="Generic placeholder image" width="140" height="140">
            <h2>Wenceslao Mateos</h2>
            <p>Estudiante de Ingeniería en Informática de la UNMDP. Técnico en informatica personal y profesional.</p>
          </div><!-- /.col-lg-4 -->
        </div><!-- /.row -->


        <!-- START THE FEATURETTES -->

        <hr class="featurette-divider">

        <div class="row featurette">
          <div class="col-md-7">
            <h2 class="featurette-heading">Tracking de barcos. <span class="text-muted">Exponen los datos.</span></h2>
            <p class="lead">Creamos una interfaz sencilla y agradable que permite el seguimiento de barcos y campañas junto con el muestreo de los datos recabados.</p>
          </div>
          <div class="col-md-5">
            <img class="featurette-image img-fluid mx-auto" alt="500x500" style="width: 500px; height: 500px;" src="./images/sitiomapa.bmp" data-holder-rendered="true">
          </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette">
          <div class="col-md-7 order-md-2">
            <h2 class="featurette-heading">Generación de batimetrias. <span class="text-muted">Nos permiten ver nuestro lecho marino.</span></h2>
            <p class="lead">Integra un generador de graficos batimetricos, que permiten hacer un vistazo de una forma rapida a las batimetrias generadas durante la campaña.</p>
          </div>
          <div class="col-md-5 order-md-1">
            <img class="featurette-image img-fluid mx-auto" data-src="holder.js/500x500/auto" alt="500x500" src="./images/batimetria.bmp" data-holder-rendered="true" style="width: 500px; height: 500px;">
          </div>
        </div>

        <!-- /END THE FEATURETTES -->

      </div><!-- /.container -->

        </main>
        <?php include('templates/inicial/footer.php');?>  
        <script>
            $('ul li:first').addClass('active');
            $('ul li:first a').addClass('active').append('<span class="sr-only">(current)</span>');
        </script>
    </body>
</html>