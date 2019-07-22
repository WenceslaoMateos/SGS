<?php
require('templates/coneccion.php');
$sql = mysqli_query($db, 'SELECT W,S,E,N,nombre FROM batimetrias');
$i = 0;
$resultado = '[';
if ($sql) {
    while ($row = mysqli_fetch_array($sql)) {
        if ($i != 0)
            $resultado .= ',';
        $i++;
        $resultado .= '
        {
            "W":' . $row['W'] . ',
            "S":' . $row['S'] . ',
            "E":' . $row['E'] . ',
            "N":' . $row['N'] . ',
            "nombre":"' . $row['nombre'] . '"
        }';
    }
}
$resultado .= "]";
echo $resultado;
?>