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

function GPS2degree($coordenada)
{
    $array = explode(" " , $coordenada);
    $ret = $array[0];
    if (is_numeric($array[1]))
        $ret += $array[1] / 60;
    if ($array[2] == "S" || $array[2] == "W")
        $ret = $ret * -1;
    return $ret;
}

function numeroValido($dato, $length, $precicion = 0){
    $format = 0;
    if($precicion == 0)
        {for ($i=0;$i<$length;$i++)
            $format = $format * 10 + 9;
        $ret = ($format == abs($dato));
    }
    else{
        for ($i=0;$i<$length-$precicion-1;$i++)
            $format = $format * 10 + 9;
        $decim = 0;
        for ($i=0;$i<$precicion;$i++)
            $decim = ($decim + 9) / 10;
        $ret = (($format + $decim) == abs($dato));
    }
    return !$ret;
}

function camposValidos($array)
{
    global $DATE, $TIME, $LATITUDE, $LONGITUDE;      
    $ret = !empty(trim($array[$DATE]));
    $ret = $ret && !empty(trim($array[$TIME]));
    $ret = $ret && !empty(trim($array[$LONGITUDE]));
    $ret = $ret && !empty(trim($array[$LATITUDE]));
    return $ret;
}

function date2when($fecha,$hora)
{
    return join("-", explode ("/" , $fecha)) . " " . $hora;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sgs";
$conn =new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) 
    die("Connection failed: " . $conn->connect_error);
else
    $conn->query('DELETE FROM puntos;');

$name = "DataRLAbvE.dat";
$lineas = file($name);
$n = count($lineas);
$j=0;
for($i = 4 ; $i < $n ; $i++)
{
    $arrayLinea = explode("\t" , $lineas[$i]); 
    if (camposValidos($arrayLinea))
    {
        $time = date2when(trim($arrayLinea[$DATE]) , trim($arrayLinea[$TIME]));
        $latitud = GPS2degree(trim($arrayLinea[$LONGITUDE]));
        $longitud = GPS2degree(trim($arrayLinea[$LATITUDE]));     
        $geom = "'POINT($longitud $latitud)'";
        $point = "GeomFromText($geom)";
        $sql = "INSERT INTO puntos (id, time, longitud, latitud, point) VALUES ($j, '$time', $longitud, $latitud, $point);";
        $conn->query($sql);
        
        $speed = $arrayLinea[$SPEED];
        if (numeroValido($speed,5,1))
            {$sql = "UPDATE puntos SET velocidad = $speed WHERE id = $j;";
                $conn->query($sql);}
    
        $depth = $arrayLinea[$DEPTH];
        if (numeroValido($depth,5))
            {$sql = "UPDATE puntos SET profundidad = $depth WHERE id = $j;";
                $conn->query($sql);}
    
        $heading = $arrayLinea[$SYSTEM_HEADING];
        if (numeroValido($heading,5,1))
            {$sql = "UPDATE puntos SET angulo = $heading WHERE id = $j;";
            $conn->query($sql);}
        $j++;
    }
}
    
$conn->close();