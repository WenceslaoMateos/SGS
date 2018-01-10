<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Carga de datos batimetricos</title>
    </head>
    <body>
    <?php
	if (!array_key_exists('Enviar',$_POST)) {
    ?>
        <form method="post" name="archivo" enctype="multipart/form-data">
            <table width="500" border="0" cellpadding="5" cellspacing="5">
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
        $name = $_FILES['adjunto']['tmp_name']; 
        //exec("grdview $name -Wc -B1a2 -BWSneZ+b+tmapitachoto -JM-57/-38/7i -Qs -JZ4i -P -p170/20 -Cseafloor2.cpt > map.ps 2>&1", $output);
        exec("grdview $name -Wc -B1a2 -BWSneZ+b+tmapitachoto -JM-57/-38/7i -Qs -JZ4i -P -p170/20 -Cseafloor2.cpt > map.ps");
        exec("psconvert -Tf map.ps");

        $filename="map.pdf";
        header("Content-type: application/octet-stream");
        header("Content-disposition: attachment;filename=$filename");
        readfile($filename);
    }
        ?>
    </body>
</html>
