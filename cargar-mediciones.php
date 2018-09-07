<?php

$precisa_sesion = true;
$msg_error = 0;
$permiso = 5;

require('templates/coneccion.php');


?>
<!DOCTYPE html>
<html>
    <head>
        <title>Carga de mediciones</title>
        <?php include('templates/inicial/head.php');?>  
    </head>
<body>
    <?php include('templates/online/header.php');?>  
    <main>
        <div class="jumbotron jumbotron-sm">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <h3 class="h3">Carga de nuevas mediciones</h3>
                        <p>Aqui usted puede cargar nuevos mediciones en el sistema. Recuerde que el archivo de mediciones debe ir acompañado de un archivo de tipos.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">

            <div class="col-7" id="cargarmedicion">
                <form action="cargar-mediciones-DB.php" method="post" name="archivo" enctype="multipart/form-data" class="mt-5">
                    <div class="custom-file mb-3">
                        <input class="custom-file-input" name="camp[]" type="file" accept=".dat" multiple required id="input1">
                        <label class="custom-file-label" for="input1">Adjuntar campañas...</label>
                    </div>
                    <div class="custom-file mb-3">
                        <input class="custom-file-input" name="formato[]" type="file" accept=".txt" multiple required id="input2">
                        <label class="custom-file-label" for="input2">Adjuntar formatos...</label>
                    </div>
                    <div class="mb-3">
                        <select class="form-control" name="barco" required id="barco">
                            <option value="">Seleccione un barco</option>
                            <?php
                            $barcos = mysqli_query($db, "SELECT * FROM barcos;");
                            if(mysqli_num_rows($barcos) > 0){
                                while($barco = mysqli_fetch_assoc($barcos)){
                                    echo '<option value="' . $barco['id'] . '">' . $barco['nombre'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <select class="form-control" name="campania" id="campania" required>
                            <option value="">Seleccione una campaña</option>
                        </select>
                    </div>
                    <input class="btn btn-primary ml-5" type="submit" name="Enviar" value="Enviar">
                </form>
            </div>
        </div>
        </div>
    </main>
    <?php include('templates/inicial/footer.php');?>      
    <script>
        $('ul li:nth-child(2)').addClass('active');
        $('ul li:nth-child(2) a:first').addClass('active').append('<span class="sr-only">(current)</span>');        

        $(document).ready(function(){
            $('#barco').on('change',function(){
                var barco = $(this).val();
                if (barco){
                    $.ajax({
                        type:'POST',
                        url:'/Servidor/CursoPHP/TrabajoFInal/TrabajoFinalPHP/ajaxData.php',
                        data:{
                            barco: barco
                        },
                        success:function(html){
                            $('#campania').html(html); 
                        }
                    }); 
                }
            });
        });
    </script>
    </body>
</html>