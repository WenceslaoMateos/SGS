<?php
$sql = "SELECT 
mediciones.id,
latitud AS Latitud,
longitud AS Longitud, 
datetime AS Fecha, 
campanias.nombre AS Campania,
campanias.id AS campaniaid,
barcos.nombre AS Barco
FROM mediciones
INNER JOIN campanias ON mediciones.idcampania = campanias.id
INNER JOIN barcos ON campanias.idbarcos = barcos.id ";
//WHERE MBRwithin(point, $geometria);";

$sql2 = "SELECT DISTINCT idcampania
FROM mediciones ";
if ((!empty($campanias) && ($campanias != -1)) || isset($desde)) {
    $sql .= "WHERE (";
    $sql2 .= "WHERE ("; {
        if ((!empty($campanias) && ($campanias != -1))) {
            foreach ($campanias as $clave => $valor) {
                $sql .= "idcampania=$valor OR ";
                $sql2 .= "idcampania=$valor OR ";
            }
            $sql = substr($sql, 0, -3);
            $sql2 = substr($sql2, 0, -3);
            $sql .= ") AND ";
            $sql2 .= ") AND ";
        }
    }
    if (isset($desde)) {
        foreach ($desde as $clave => $valor) {
            $sql .= " (datetime BETWEEN '$valor' AND '" . $hasta[$clave] . "') OR ";
            $sql2 .= "(datetime BETWEEN '$valor' AND '" . $hasta[$clave] . "') OR ";
        }
        $sql = substr($sql, 0, -3);
        $sql2 = substr($sql2, 0, -3);
        $sql .= ")  ";
        $sql2 .= ")  ";
    } else if (isset($campanias)) {
        $sql = substr($sql, 0, -4);
        $sql2 = substr($sql2, 0, -4);
    }
} else {
    $sql .= "  ORDER BY campanias.id, mediciones.id ASC;";
    $sql2 .= " ORDER BY idcampania ASC;";
}

$exec = 'mysql --user=wence --password=wence sgs -e "' . $sql . '"  -B > templates/data.csv';
exec($exec);
