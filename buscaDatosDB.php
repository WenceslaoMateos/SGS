<?php

$precisa_sesion = true;
$msg_error = 0;
$permiso = 0;

require('templates/coneccion.php');
//HEADER DEL KML A SER GENERADO
header('Content-Disposition: attachment; filename="datos.kml"');

//INGRESO DE DATOS POR URL
$x1 = $_REQUEST["x1"];
$x2 = $_REQUEST["x2"];
$y1 = $_REQUEST["y1"];
$y2 = $_REQUEST["y2"];

if (isset($_REQUEST['campanias'])){
    $campanias = unserialize($_REQUEST['campanias']);
}
if (isset($_REQUEST['desde'])){
    $desde = unserialize($_REQUEST['desde']);
}
if (isset($_REQUEST['hasta'])){
    $hasta = unserialize($_REQUEST['hasta']);
}

/*function diferenciaTime($one, $two){
    $one = explode(' ',$one);
    $one = $one[1];
    $one = str_replace(':','',$one);
    $one = (int)$one;
    $two = explode(' ',$two);
    $two = $two[1];
    $two = str_replace(':','',$two);
    $two = (int)$two;
    return ($one-$two)==100;
}*/

//CABECERA KML
$kml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
$kml .= '<kml xmlns="http://www.opengis.net/kml/2.2"'."\n";
$kml .= ' xmlns:gx="http://www.google.com/kml/ext/2.2">'."\n";
$kml .= '  <Document>'."\n";
//END CABECERA KML

//CUERPO KML

//poligono formado por el rectangulo a ser solicitado y mostrado en el mapa
$poligono = "'Polygon(($x1 $y1,
                    $x1 $y2,
                    $x2 $y2,
                    $x2 $y1,
                    $x1 $y1))'";
$geometria = "ST_GeomFromText($poligono)";
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
if ((!empty($campanias) && ($campanias != -1)) || isset($desde)){
    $sql .= "WHERE (";
    $sql2 .= "WHERE (";
    {if ((!empty($campanias) && ($campanias != -1))){
        foreach($campanias as $clave => $valor){
            $sql .= "idcampania=$valor OR ";
            $sql2 .= "idcampania=$valor OR ";
        }
        $sql = substr($sql, 0, -3);
        $sql2 = substr($sql2, 0, -3);
        $sql .=") AND ";
        $sql2 .=") AND ";
    }}
    if (isset($desde)){
        foreach($desde as $clave => $valor){
            $sql .= " (datetime BETWEEN '$valor' AND '" . $hasta[$clave] . "') OR ";
            $sql2 .= "(datetime BETWEEN '$valor' AND '" . $hasta[$clave] . "') OR ";
        }
        $sql = substr($sql, 0, -3);
        $sql2 = substr($sql2, 0, -3);
        $sql .=")  ";
        $sql2 .=")  ";
    }
    else if (isset($campanias)){
        $sql = substr($sql, 0, -4);
        $sql2 = substr($sql2, 0, -4);
    }
}
else{
    $sql .="  ORDER BY campanias.id, mediciones.id ASC;";
    $sql2 .=" ORDER BY idcampania ASC;";
}

//$kml = $sql . "\n" . $sql2;
//al ser una sola query no es necesario hacer commit ni comenzar transacción.
$result = mysqli_query($db, $sql);
//generado de rutas del barco
$query_camp = mysqli_query($db, $sql2);


if (mysqli_num_rows($query_camp) > 0){
    while($camp = mysqli_fetch_assoc($query_camp)){


        //Cada Placemark es un conjunto de varias mediciones.
        $cantMed = 100;
        $j = 0;
        $i = 0;
        $kml .= '      <Placemark>'."\n";
        $kml .= '          <LineString>'."\n";
        $kml .= '              <coordinates>'."\n";
        while(($row = mysqli_fetch_assoc($result)) && ($row['campaniaid'] == $camp['idcampania'])){
            $i++;
            if($j < $cantMed){
                $kml .= '              ' . $row["Longitud"]. ',' . $row["Latitud"] . "\n";
                $j++;
            }
            else{
                $j = 0;
                $kml .= '              </coordinates>'."\n";
                $kml .= '          </LineString>'."\n";
                $kml .= '          <ExtendedData>'."\n";
                //$newTime = $row["time"];
                //cada elemento fetcheado se pone en el dato correspondiente
                $kml .= '              <Data name="type">'."\n";
                $kml .= '                  <value>line</value>'."\n";
                $kml .= '              </Data>'."\n";
                foreach($row as $clave => $elemento){
                    $kml .= '              <Data name="' . $clave . '">'."\n";
                    $kml .= '                  <value>' . $elemento . '</value>'."\n";
                    $kml .= '              </Data>'."\n";
                }
                $kml .= '          </ExtendedData>'."\n";
                $kml .= '      </Placemark>'."\n";
                $kml .= '      <Placemark>'."\n";
                $kml .= '          <LineString>'."\n";
                $kml .= '              <coordinates>'."\n";
                $kml .= '              ' . $row["Longitud"]. ',' . $row["Latitud"] . "\n";
                /*
                //se guarda el ultimo elemento asi al siguiente se le puede agregar al principio
                $lastTime = $last["time"];
                if (diferenciaTime($newTime,$lastTime))
                    $kml .= '              ' . $last["longitud"]. ',' . $last["latitud"] . "\n";
                */
            }
            $last = $row;
        }
        if ($j != 0 || $row['campaniaid']!=$camp['idcampania']){
            $kml .= '              </coordinates>'."\n";
            $kml .= '          </LineString>'."\n";
            $kml .= '          <ExtendedData>'."\n";
            $kml .= '              <Data name="type">'."\n";
            $kml .= '                  <value>line</value>'."\n";
            $kml .= '              </Data>'."\n";
            foreach($last as $clave => $elemento){
                $kml .= '              <Data name="' . $clave . '">'."\n";
                $kml .= '                  <value>' . $elemento . '</value>'."\n";
                $kml .= '              </Data>'."\n";
            }
            $kml .= '          </ExtendedData>'."\n";
            $kml .= '      </Placemark>'."\n";
        }
    }
}

$kml .= ' </Document>'."\n";

$kml .= '</kml>'."\n";
//END CUERPO KML



/*
//CUERPO KML

$sql = "SHOW tables;";
$tablas = $conn->query($sql);

for ($j = 0; $tabla = $tablas->fetch_assoc(); $j++){
    if ($tabla["Tables_in_sgs"] != "usuarios" && $tabla["Tables_in_sgs"] != "campanias" && $tabla["Tables_in_sgs"] != "mediciones" && $tabla["Tables_in_sgs"] != "barcos"){
    //poligono formado por el rectangulo a ser solicitado y mostrado en el mapa
    $poligono = "'Polygon(($x1 $y1,
                        $x1 $y2,
                        $x2 $y2,
                        $x2 $y1,
                        $x1 $y1))'";
    $geometria = "ST_GeomFromText($poligono)";
    $sql = "SELECT latitud, longitud, time, velocidad, angulo, profundidad 
            FROM ".$tabla["Tables_in_sgs"].";"; 
            //WHERE MBRwithin(point, $geometria);";
    //al ser una sola query no es necesario hacer commit ni comenzar transacción.
    $result = $conn->query($sql);

    //generado de rutas del barco
    $cantMed = 20;
    $j = 0;
    if ($result->num_rows > 0){
        //Cada Placemark es un conjunto de varias mediciones.
        $kml .= '      <Placemark>'."\n";
        $kml .= '          <name>Recorrido del barco '.$j.'.</name>'."\n";
        $kml .= '          <LineString>'."\n";
        $kml .= '              <coordinates>'."\n";
        $i = 0;
        while($row = $result->fetch_assoc()){
            $i++;
            $kml .= '              ' . $row["longitud"]. ',' . $row["latitud"] . "\n";
            if($j < $cantMed){
                $j++;
            }
            else{
                $j = 0;
                $kml .= '              </coordinates>'."\n";
                $kml .= '          </LineString>'."\n";
                $kml .= '          <ExtendedData>'."\n";

                //$newTime = $row["time"];

                //cada elemento fetcheado se pone en el dato correspondiente
                $kml .= '              <Data name="type">'."\n";
                $kml .= '                  <value>line</value>'."\n";
                $kml .= '              </Data>'."\n";
                foreach($row as $clave => $elemento){
                    $kml .= '              <Data name="' . $clave . '">'."\n";
                    $kml .= '                  <value>' . $elemento . '</value>'."\n";
                    $kml .= '              </Data>'."\n";
                }
                $kml .= '          </ExtendedData>'."\n";
                $kml .= '      </Placemark>'."\n";
                $kml .= '      <Placemark>'."\n";
                $kml .= '          <name>Orientacion del barco '.$j.'.</name>'."\n";
                $kml .= '           <Point>'."\n";
                $kml .= '               <coordinates>' . $row["longitud"]. ',' . $row["latitud"] . '</coordinates>'."\n";
                $kml .= '           </Point>'."\n";
                $kml .= '          <ExtendedData>'."\n";

                //cada elemento fetcheado se pone en el dato correspondiente
                $kml .= '              <Data name="type">'."\n";
                $kml .= '                  <value>point</value>'."\n";
                $kml .= '              </Data>'."\n";
                foreach($row as $clave => $elemento){
                    $kml .= '              <Data name="' . $clave . '">'."\n";
                    $kml .= '                  <value>' . $elemento . '</value>'."\n";
                    $kml .= '              </Data>'."\n";
                }
                $kml .= '          </ExtendedData>'."\n";
                $kml .= '      </Placemark>'."\n";
                $kml .= '      <Placemark>'."\n";
                $kml .= '          <name>Recorrido del barco '.$j.'.</name>'."\n";
                $kml .= '          <LineString>'."\n";
                $kml .= '              <coordinates>'."\n";
                $kml .= '              ' . $row["longitud"]. ',' . $row["latitud"] . "\n";

                /*
                //se guarda el ultimo elemento asi al siguiente se le puede agregar al principio
                $lastTime = $last["time"];
                if (diferenciaTime($newTime,$lastTime))
                    $kml .= '              ' . $last["longitud"]. ',' . $last["latitud"] . "\n";
                
            }
            $last = $row;
        }
        if ($j != 0){
            $kml .= '              </coordinates>'."\n";
            $kml .= '          </LineString>'."\n";
            $kml .= '          <ExtendedData>'."\n";
            $kml .= '              <Data name="type">'."\n";
            $kml .= '                  <value>line</value>'."\n";
            $kml .= '              </Data>'."\n";
            foreach($last as $clave => $elemento){
                $kml .= '              <Data name="' . $clave . '">'."\n";
                $kml .= '                  <value>' . $elemento . '</value>'."\n";
                $kml .= '              </Data>'."\n";
            }
            $kml .= '          </ExtendedData>'."\n";
            $kml .= '      </Placemark>'."\n";
        }
    }}
}

$kml .= ' </Document>'."\n";

$kml .= '</kml>'."\n";
//END CUERPO KML

*/

//cierre de la conección a la base de datos
//$conn->close();

/*$arch=fopen("kml.kml","w");
fwrite($arch,$kml);
fclose(arch);*/
echo $kml;