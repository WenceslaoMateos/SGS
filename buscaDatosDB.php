<?php

//HEADER DEL KML A SER GENERADO
header('Content-Disposition: attachment; filename="datos.kml"');

//INGRESO DE DATOS POR URL
$x1=$_GET["x1"];
$x2=$_GET["x2"];
$y1=$_GET["y1"];
$y2=$_GET["y2"];

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

//CONECCION CON LA BASE DE DATOS.
$servername = "localhost";
$username = "wence";
$password = "wence";
$dbname = "SGS";
$conn =new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}
//------------------------------------------------------------

//CUERPO KML

$sql = "SHOW tables;";
$tablas = $conn->query($sql);

for ($j = 0; $tabla = $tablas->fetch_assoc(); $j++){

    
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
                */
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
    }
}
//END CUERPO KML

$kml .= ' </Document>'."\n";

$kml .= '</kml>'."\n";

//cierre de la conección a la base de datos
$conn->close();

/*$arch=fopen("kml.kml","w");
fwrite($arch,$kml);
fclose(arch);*/
echo $kml;