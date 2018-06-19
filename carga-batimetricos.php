<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html" />
        <title>Carga de datos batimetricos</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    </head>
    <body>
    <?php
	if (!array_key_exists('Enviar',$_POST)) {
        ?>
        <form method="post" name="archivo" enctype="multipart/form-data">
            <table class="table">
                <tr>
                    <td><div class="checkbox">
                        <label><input type="checkbox" name="-Wc" value=" -Wc"> Curvas de nivel</label> </div></td>
                        
                </tr>
                <tr>
                    <td><input type="radio" name="-Q" value=" -Qm" checked> Grilla<br></td>
                    <td><input type="radio" name="-Q" value=" -Qs" checked> Superficie<br></td>
                    <td><input type="radio" name="-Q" value=" -Qi" checked> Imagen<br></td>
                </tr>
                <tr>
                    <td><input type="radio" name=" -T" value=" -Tb" checked> BMP<br></td>
                    <td><input type="radio" name=" -T" value=" -Te" checked> EPS<br></td>
                    <td><input type="radio" name=" -T" value=" -TE" checked> EPS PageSize<br></td>
                    <td><input type="radio" name=" -T" value=" -Tf" checked> PDF<br></td>
                    <td><input type="radio" name=" -T" value=" -TF" checked> PDF multipagina<br></td>
                    <td><input type="radio" name=" -T" value=" -Tj" checked> JPEG<br></td>
                    <td><input type="radio" name=" -T" value=" -Tg" checked> PNG<br></td>
                    <td><input type="radio" name=" -T" value=" -TG" checked> PNG transparente<br></td>
                    <td><input type="radio" name=" -T" value=" -Tm" checked> PPM<br></td>
                    <td><input type="radio" name=" -T" value=" -Ts" checked> SVG<br></td>
                    <td><input type="radio" name=" -T" value=" -Tt" checked> TIFF<br></td>
                </tr>
                <tr>
                    <th>Adjuntar</th>
                    <td><input name="adjunto" type="file" accept=".tmp"></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align:center;"><input type="submit" name="Enviar" value="Enviar"></td>
                </tr>
            </table>
        </form>
        <?php
    }   
    else{
        $filename= "map.pdf";
        $name = $_FILES['adjunto']['tmp_name']; 
        exec("grdview $name " .  $_POST["-Wc"] ." -B1a2 -BWSneZ+b+tBatimetrico -JM-57/-38/7i " . $_POST["-Q"] . " -JZ4i -P -p170/20 -Cseafloor2.cpt > map.ps");
        exec("psconvert -Tf -Z -A4 -E720 map.ps");
        header("Content-type: application/octet-stream");
        header("Content-disposition: attachment;filename=$filename");
        readfile($filename);
    }
        ?>
    </body>
</html>
