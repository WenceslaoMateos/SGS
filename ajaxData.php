<?php
$permiso = 0;
$precisa_sesion = true;
    require('templates/coneccion.php');
    if (!empty($_REQUEST["barco"])){
        $campanias_query = mysqli_query($db, "SELECT * FROM campanias WHERE idbarcos = " . $_REQUEST['barco'] . ";");
        while ($campanias = mysqli_fetch_array($campanias_query))
            echo '<option value="'.$campanias['id'].'">'.$campanias['nombre'].'</option>';
    }
?>