<?php

$name = "temperaturas.txt";

$kml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
$kml .= '<kml xmlns="http://www.opengis.net/kml/2.2"'."\n";
$kml .= ' xmlns:gx="http://www.google.com/kml/ext/2.2">'."\n";

$lineas = file($name);
$n = count($lineas);
for($i = 3; $i < $n; $i++){
    $arrayLinea = preg_split('/\s+/', $lineas[$i]);
    echo $arrayLinea[0] . "--" . $arrayLinea[1] . "--" . $arrayLinea[2] . "--" . $arrayLinea[3] . "\n";
    $kml .= '<Document>'."\n";
    $kml .= '<Placemark>'."\n";
    $kml .= '<name>'."\n";
}

