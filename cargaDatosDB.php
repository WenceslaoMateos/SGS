<?php

//CONSTANT
$DATE = 0;
$TIME = 1;
$UTC_TIME = 4;
$NUMBER_USED_SATELLITE = 7;
$LONGITUDE = 8;
$LATITUDE = 9;
$DEPTH = 11;
$SPEED = 16;
$SYSTEM_HEADING = 38;
//END CONSTANT

//FUNCIONES UTILES
/**
 * La función se encarga de obtener una coordenada en el formato de "G M O" donde:
 * G es grados.
 * M la cantidad de minutos (junto con los segundos).
 * O es la orientación (N, S, E, W) que transforma la coordenada en positiva o negativa.
 * 
 * @param string $coordenada Coordenada indicada en un string con formato G M O.
 * @return float $ret Coordenada en grados con minutos, segundoa y orientación incluidos.
 */
function GPS2degree($coordenada){
    $array = preg_split('/\s+/',  $coordenada);
    $ret = $array[0];
    if (is_numeric($array[1])){
        $ret += $array[1] / 60;
    }
    else {
        if ($array[1] == "S" || $array[1] == "W"){
            $ret = $ret * -1;
        }
    }
    if ($array[2] == "S" || $array[2] == "W"){
        $ret = $ret * -1;
    }
    return $ret;
}

/**
 * Valida que el numero sea valido, considerando que un numero invalido contiene solamente el numero 9.
 *
 * @param float/integer $dato Dato a verificar.
 * @param integer $length Tamaño del numero a verificar (incluyendo decimales y el punto que indica decimal).
 * @param integer $precision Cantidad de decimales que el numero posee.
 * @return boolean $ret En caso de que el dato sea valido devuelve true, false en caso contrario.
 */
function numeroValido($dato, $length=5, $precision = 0){
    $format = 0;
    if($precision == 0){
        for ($i = 0; $i < $length; $i++){
            $format = ($format * 10) + 9;
        }
        $ret = ($format == abs($dato));
    }
    else{
        for ($i = 0; $i < ($length-$precision-1); $i++){
            $format = $format * 10 + 9;
        }
        $decim = 0;
        for ($i = 0; $i < $precision; $i++){
            $decim = ($decim + 9) / 10;
        }
        $ret = (($format + $decim) == abs($dato));
    }
    return !$ret;
}

/**
 * Valida que los campos que representan la clave principal sean validos. Sin estos campos no hay 
 * entrada en la base de datos.
 *
 * @param array $array Array con la linea con todas las mediciones en formato de string, donde cada uno de los
 * elementos representa una medición.
 * @return void
 */
function camposValidos($array)
{
    global $DATE, $TIME, $LATITUDE, $LONGITUDE;      
    $ret = !empty(trim($array[$DATE]));
    $ret = $ret && !empty(trim($array[$TIME]));
    $ret = $ret && !empty(trim($array[$LONGITUDE]));
    $ret = $ret && !empty(trim($array[$LATITUDE]));
    return $ret;
}

/**
 * Funcion que recibe la fecha y la hora de la medición y la convierte al formato requerido por la 
 * base de datos para su correcto almacenamiento.
 *
 * @param string $fecha Fecha de la medición. Formato: AAAA/MM/DD.
 * @param string $hora Hora de la medición. Formato: HH:MM:SS.
 * @return string fecha y hora juntas con el formato indicado.
 */
function date2when($fecha,$hora)
{
    return join("-", explode ("/" , $fecha)) . " " . $hora;
}
//END FUNCIONES UTILES.

//CONECCION CON LA BASE DE DATOS.
$servername = "localhost";
$username = "wen";
$password = "wen";
$dbname = "sgs";
$conn =new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

//se eliminan datos anteriores de la base de datos.
$conn->query("TRUNCATE TABLE puntos");

//se le indica a la base de datos que se le va a pasar un conjunto grande de querys.
$conn-> begin_transaction();
//------------------------------------------------------------

//APERTURA DE ARCHIVO A CARGAR.
$name = "https://134.1.2.55/polarstern_data/results/fevans/DataRLAbvE.dat";

//LECTURA DE DATOS A CARGAR Y CARGA DE DATOS EN LA BASE DE DATOS.
$lineas = file($name);
$n = count($lineas);
$j = 0;
for($i = 4; $i < $n; $i++){
    $arrayLinea = explode("\t", $lineas[$i]); 
    if (camposValidos($arrayLinea)){
        $time = date2when(trim($arrayLinea[$DATE]), trim($arrayLinea[$TIME]));
        $latitud = GPS2degree(trim($arrayLinea[$LONGITUDE]));
        $longitud = GPS2degree(trim($arrayLinea[$LATITUDE]));     
        
        //se genera el punto para despues poder indexar espacialmente.
        $geom = "'POINT($longitud $latitud)'";
        $point = "GeomFromText($geom)";

        //Inserta el punto en la base de datos.
        $sql = "INSERT INTO puntos (time, longitud, latitud, point) VALUES ('$time', $longitud, $latitud, $point);";
        $conn->query($sql);
        
        //Al punto insertado le agrega la velocidad en caso de ser valida.
        $speed = $arrayLinea[$SPEED];
        if (numeroValido($speed, 5, 1)){
            $sql = "UPDATE puntos SET velocidad = $speed WHERE id = $j;";
            $conn->query($sql);
        }
    
        //Al punto insertado le agrega la profundidad en caso de ser valida.
        $depth = $arrayLinea[$DEPTH];
        if (numeroValido($depth, 5)){
            $sql = "UPDATE puntos SET profundidad = $depth WHERE id = $j;";
            $conn->query($sql);
        }
    
        //Al punto insertado le agrega el angulo en caso de ser valido.
        $heading = $arrayLinea[$SYSTEM_HEADING];
        if (numeroValido($heading, 5, 1)){
            $sql = "UPDATE puntos SET angulo = $heading WHERE id = $j;";
            $conn->query($sql);
        }
        $j++;
    }
}
    
//avisa a la base de datos que ya se pueden hacer todas las operaciones antes solicitadas.
$conn->commit();

//CIERRE DE LA BASE DE DATOS.
$conn->close();