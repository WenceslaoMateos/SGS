<?php

function GPS2degree($coordenada)
{
    $array = explode(" " , $coordenada);
    $ret = $array[0];
    if (is_numeric($array[1]))
        $ret += $array[1] / 60;
    if ($array[2] == "S" || $array[2] == "W")
        $ret = $ret * -1;
    else if (!$array[2] == "N" && !$array[2] == "E")
        echo "El dato no tiene orientación.";
    return $ret;
}

function date2when($fecha,$hora)
{
    return join("-", explode ("/" , $fecha)) . "T" . $hora . "Z";// setea la fecha en un formato tal que puede ser leida por el tracker
}

$kml = array('<?xml version="1.0" encoding="UTF-8"?>');
$kml[] = '<kml xmlns="http://www.opengis.net/kml/2.2"';
$kml[] = ' xmlns:gx="http://www.google.com/kml/ext/2.2">';
$kml[] = '  <Document>';
$kml[] = '      <Style id="EstiloLinea">';
$kml[] = '          <LineStyle>';
$kml[] = '              <color>80000000</color>';
$kml[] = '              <width>5</width>';
$kml[] = '          </LineStyle>';
$kml[] = '          <PolyStyle>';
$kml[] = '              <color>80000000</color>';
$kml[] = '          </PolyStyle>';
$kml[] = '      </Style>';

// Iterates through the rows, printing a node for each row.

$lineas = file('DataRLAbvE.dat');
$n = count($lineas);
$i = 2;
$foldersize = 20;
while ($i < $n)
{
    $kml[] = '      <Placemark>';
    $kml[] = '          <name>Recorrido loco de un barco.</name>';
    $kml[] = '          <description>Una linea de un barco sobre el mar</description>';
    $kml[] = '          <styleUrl>#EstiloLinea</styleUrl>';
    $kml[] = '          <LineString>';
    $kml[] = '              <coordinates>';
    $j = 0;
    $i--;
    while (($j < $foldersize) && ($i < $n)) //me fijo que ningun dato este vacio
    {
        $arrayLinea = explode("\t" , $lineas[$i]); //genero un array con las mediciones separadas
        if (!empty(trim($arrayLinea[0])) && !empty(trim($arrayLinea[1])) && !empty(trim($arrayLinea[8])) && !empty(trim($arrayLinea[9])))
        {
            $kml[] = '              ' . GPS2degree(trim($arrayLinea[9])) . ',' . GPS2degree(trim($arrayLinea[8]));
            $j++;
        }
        $i++;
    }
    $kml[] = '              </coordinates>';
    $kml[] = '          </LineString>';
    $kml[] = '          <ExtendedData>';
    $kml[] = '              <Data name="when">';
    $kml[] = '                  <value>' . date2when(trim($arrayLinea[0]),trim($arrayLinea[1])) . '</value>';
    $kml[] = '              </Data>';
    $kml[] = '              <Data name="point">';
    $kml[] = '                  <value>' . GPS2degree(trim($arrayLinea[9])) . ',' . GPS2degree(trim($arrayLinea[8])) . '</value>';
    $kml[] = '              </Data>';
    $kml[] = '          </ExtendedData>';
    $kml[] = '      </Placemark>';
}
// End XML file
$kml[] = ' </Document>';
$kml[] = '</kml>';
$kmlOutput = join("\n", $kml);

$kmlArch = fopen("DataRLAbvE.kml","w");
fwrite($kmlArch,$kmlOutput);
fclose($kmlArch);



/*
$kml[] = '          <LineString>';
$kml[] = '              <coordinates>';

for ($i=1; $i < $n; $i++)
{
    $arrayLinea = explode("\t" , $lineas[$i]); //genero un array con las mediciones separadas
    if (!empty(trim($arrayLinea[0])) && !empty(trim($arrayLinea[1])) && !empty(trim($arrayLinea[8])) && !empty(trim($arrayLinea[9]))) //me fijo que ningun dato este vacio
    {
        $kml[] = "                  " . GPS2degree(trim($arrayLinea[9])) . "," . GPS2degree(trim($arrayLinea[8]));     //agendo la latitud y longitud de esa linea
    }
} 
$kml[] = '              </coordinates>';
$kml[] = '          </LineString>';*/

?>


