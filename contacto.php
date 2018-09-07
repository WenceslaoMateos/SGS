<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Contacto</title>
        <?php include('templates/inicial/head.php');?>  
    </head>
    <body>
        <?php include('templates/inicial/header.php');?> 
        <main>
            <div class="jumbotron jumbotron-sm">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-lg-12">
                            <h3 class="h3">Contacto <small>sientase libre de comunicarse</small></h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="well well-sm">
                            <form name="contactform" method="post" action="email.php">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nombre">Nombre</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Enter name" required="required" />
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Dirección de correo electrónico</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Correo electrónico" required="required" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="motivo">
                                            Motivo</label>
                                        <select id="motivo" name="motivo" class="form-control" required="required">
                                            <option value="" selected="service">Opciones:</option>
                                            <option value="service">Soporte</option>
                                            <option value="suggestions">Sugerencias</option>
                                            <option value="product">Producto</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mensaje">
                                            Mensaje</label>
                                        <textarea name="mensaje" id="mensaje" class="form-control" rows="9" cols="25" required placeholder="Mensaje"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary pull-right" id="btnContactUs">Enviar</button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <form method="post">
                        <legend><span class="glyphicon glyphicon-globe"></span> Nuestra oficina</legend>
                        <address>
                            <strong>GTI, UNMDP</strong><br>
                            Juan B. Justo 2002, Oficina 205<br>
                            Mar del Plata, Buenos Aires<br>
                            Argentina<br>
                            <abbr title="Teléfono"></abbr>
                            (223) 482-0222
                        </address>
                        <address>
                            <strong>Wenceslao Mateos</strong><br>
                            <a href="mailto:#">wenceslaomateos@gmail.com</a>
                        </address>
                        </form>
                    </div>
                </div>
            </div>
        </main> 
        <?php include('templates/inicial/footer.php');?>  
        <script>
            $('ul li:nth-child(4)').addClass('active');
            $('ul li:nth-child(4) a').addClass('active').append('<span class="sr-only">(current)</span>');
        </script>
    </body>
</html>