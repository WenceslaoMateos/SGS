<?php
//CONSTANT
$DATE = 0;
$TIME = 1;
$UTC_TIME = 4;
$LATITUDE = 9;
$LONGITUDE = 8;
$SPEED = 16;
$NUMBER_USED_SATELLITE = 7;
$DEPTH = 11;
$SYSTEM_HEADING = 38;
//END CONSTANT

function numeroValido($dato, $length, $precicion = 0)
{
    $format = 0;
    for ($i=0;$i<$length;$i++)
        $format = $format * 10 + 9;
    if($precicion == 0)
        $ret = ($format == abs($dato));
    else
    {
        $decim = 0;
        for ($i=0;$i<$precicion;$i++)
            $decim = ($decim + 9) / 10;
        $ret = (($format + $decim) == abs($dato));
    }
    return $ret;
}

function camposValidos($array)
{
    global $DATE, $TIME, $LATITUDE, $LONGITUDE, $SPEED, $DEPTH, $SYSTEM_HEADING;      
    $ret = !empty(trim($array[$DATE]));
    echo $ret;
    $ret = $ret && !empty(trim($array[$TIME]));
    $ret = $ret && !empty(trim($array[$LONGITUDE]));
    $ret = $ret && !empty(trim($array[$LATITUDE]));
    $ret = $ret && numeroValido($array[$SPEED],5,1);
    $ret = $ret && numeroValido($array[$DEPTH],5,1);
    $ret = $ret && numeroValido($array[$SYSTEM_HEADING],5,1);
    return $ret;
}

$name = "DataRLAbvE.dat";

$lineas = file($name);
$n = count($lineas);
$j=0;
for($i = 4 ; $i < 200 ; $i++)
{
    $arrayLinea = explode("\t" , $lineas[$i]); 
    if (camposValidos($arrayLinea))
    {
        $time = date2when(trim($arrayLinea[$DATE]) , trim($arrayLinea[$TIME]));
        $latitud = GPS2degree(trim($arrayLinea[$LONGITUDE]));
        $longitud = GPS2degree(trim($arrayLinea[$LATITUDE]));     
        $geom = "'POINT($longitud $latitud)'";
        $point = "GeomFromText($geom)";
        $speed = $arrayLinea[$SPEED];
        $sql = "INSERT INTO puntos (id, time, longitud, latitud, point, velocidad) VALUES ($j, '$time', $longitud, $latitud, $point, $speed);";
        $j++;
    }
}