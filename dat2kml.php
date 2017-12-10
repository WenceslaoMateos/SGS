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
    return join("-", explode ("/" , $fecha)) . "T" . $hora . "Z";
}

$name = 'DataRLAbvE.kml';

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

$lineas = file($name);
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
    while (($j < $foldersize) && ($i < $n)) 
    {
        $arrayLinea = explode("\t" , $lineas[$i]); 
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
$kml[] = ' </Document>';
$kml[] = '</kml>';
$kmlOutput = join("\n", $kml);

$kmlArch = fopen($name,"w");
fwrite($kmlArch,$kmlOutput);
fclose($kmlArch);
echo $name;
?>


