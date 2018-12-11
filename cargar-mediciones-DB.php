<?php

/******************** FUNCIONES ÚTILES ********************/
/**
 * La función constanSet se encarga de generar un array asociativo con los nombres de cada uno de los 
 * datos sensados y su ubicación en el array "$datos".
 *
 * @param array $datos Array que contiene los tipos de dato de todo un archivo
 * @return array Array asociativo que está compuesto por el primer valor de la tabla de sensores
 */
function constantSet($datos)
{
    $ret = array();
    $n = count($datos["sensor"]);
    for ($i = 0; $i < $n; $i++) {
        if (!isset($ret[$datos["sensor"][$i]]))
            $ret[$datos["sensor"][$i]] = $i + 2;
    }
    return $ret;
}

/**
 * Undocumented function
 *
 * @param [type] $archivos
 * @return void
 */
function parsingTDatos($archivos)
{
    $ret = array();
    $m = count($archivos);
    //voy archivo por archivo
    for ($j = 0; $j < $m; $j++) {
        $archivo = $archivos[$j];
        $array = file($archivo);
        $n = count($array);
        //$ret es un vector de archivos
        $ret[$j] = array(
            "dispositivo" => array(),
            "sensor" => array(),
            "formato" => array(),
            "longitud" => array(),
            "precision" => array(),
            "unidades" => array(),
            "calculo" => array(),
            "valores" => array()
        );
        $i = 0;
        //voy linea por linea de un archivo en especifico
        while ($i < $n) {
            //comparo si estoy hablando de un canal
            if (substr($array[$i], 0, 8) == 'Channel ') {
                //una vez que estoy en un canal, ya se que estoy hablando de un tipo de medición
                $i++;
                $ret[$j]["dispositivo"][] = trim(str_replace("\"", "", substr($array[$i], 16, 50)));
                $i++;
                $ret[$j]["sensor"][] = trim(str_replace("\"", "", substr($array[$i], 16, 50)));
                $i++;
                $ret[$j]["formato"][] = trim(str_replace("\"", "", substr($array[$i], 16, 50)));
                $i++;
                $ret[$j]["longitud"][] = trim(str_replace("\"", "", substr($array[$i], 16, 50)));
                $i++;
                $ret[$j]["precision"][] = trim(str_replace("\"", "", substr($array[$i], 16, 50)));
                $i++;
                $ret[$j]["unidades"][] = trim(str_replace("\"", "", substr($array[$i], 16, 50)));
                $i++;
                $ret[$j]["calculo"][] = trim(str_replace("\"", "", substr($array[$i], 16, 50)));
                $i++;
                $ret[$j]["valores"][] = trim(str_replace("\"", "", substr($array[$i], 22, 50)));
            }
            $i++;
        }
    }
    return $ret;
}

/**
 * La función se encarga de obtener una coordenada en el formato de "G M O" donde:
 * G es grados.
 * M la cantidad de minutos (junto con los segundos).
 * O es la orientación (N, S, E, W) que transforma la coordenada en positiva o negativa.
 * 
 * @param string $coordenada Coordenada indicada en un string con formato G M O.
 * @return float $ret Coordenada en grados con minutos, segundoa y orientación incluidos.
 */
function GPS2degree($coordenada)
{
    $array = preg_split('/\s+/', $coordenada);
    $ret = $array[0];
    if (is_numeric($array[1])) {
        $ret += $array[1] / 60;
    } else {
        if ($array[1] == "S" || $array[1] == "W") {
            $ret = $ret * -1;
        }
    }
    if ($array[2] == "S" || $array[2] == "W") {
        $ret = $ret * -1;
    }
    return $ret;
}

/**
 * Valida que el numero sea valido, considerando que un numero invalido contiene solamente el numero 9.
 * TODO hay que refactorizar esto para que sea mas dinamico
 * @param float/integer $dato Dato a verificar.
 * @param string $formato Tipo de dato a ser verificado, esto existe por posibles puntos por reales
 * @param integer $length Tamaño del numero a verificar (incluyendo decimales y el punto que indica decimal).
 * @param integer $precision Cantidad de decimales que el numero posee.
 * @return boolean $ret En caso de que el dato sea valido devuelve true, false en caso contrario.
 */
function valido($dato, $formato, $length, $precision)
{
    $ret = false;
    switch ($formato) {
        case "Int":
            $dato = preg_replace('/\s+/', '', $dato);
            $inv = '';
            for ($i = 0; $i < $length; $i++) {
                $inv .= '9';
            }
            $ret = strcmp($inv, $dato);
            break;
        case "Real":
            $dato = preg_replace('/\s+/', '', $dato);
            $inv = '';
            for ($i = 0; $i < $length; $i++) {
                $inv .= '9';
            }
            if ($precision > 0)
                $inv[$length - $precision - 1] = '.';
            $ret = strcmp($inv, $dato);
            break;
        case "PosLon":
        case "PosLat":
            $ret = !strcmp($dato, '');
            break;
        case "Text":
            break;
        default:
            break;
    }
    return $ret;
}

/**
 * Valida que los campos que representan la clave principal sean validos. Sin estos campos no hay 
 * entrada en la base de datos.
 *
 * @param array $array Array con la linea con todas las mediciones en formato de string, donde cada uno de los
 * elementos representa una medición.
 * @return void
 */
function camposValidos($array, $claves)
{
    $ret = !empty(trim($array[$claves["Date"]]));
    $ret = $ret && !empty(trim($array[$claves["Time"]]));
    $ret = $ret && !empty(trim($array[$claves["position longitude"]]));
    $ret = $ret && !empty(trim($array[$claves["position latitude"]]));
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
function date2when($fecha, $hora)
{
    $aux = explode(".", $fecha);
    $fecha = join("-", array($aux[2], $aux[1], $aux[0]));
    return $fecha . " " . $hora;
}
//END FUNCIONES UTILES.

//-------------------------------------------------------------------------------------------------//
//-----------------------------------------Programa Principal--------------------------------------//
//-------------------------------------------------------------------------------------------------//

//CONECCION CON LA BASE DE DATOS.
$servername = "localhost";
$username = "wence";
$password = "wence";
$dbname = "sgs";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
ini_set('max_execution_time', -1);
ini_set('memory_limit', '-1'); //MUCHO CUIDADO AVERIGUAR POR LAS DUDAS!!!!!!!!//

$campania = $_REQUEST['campania'];
$barco = $_REQUEST['barco'];
$names = $_FILES['camp']['tmp_name'];
$dbtables = $_FILES['camp']['name'];
$fileTypes = $_FILES['camp']['type'];
$formatos = $_FILES['formato']['tmp_name'];
//print_r( $names);
$tDatos = parsingTDatos($formatos);

$m = count($names);

//$conn->autocommit(FALSE);
for ($k = 0; $k < $m; $k++) {
    $fileType = $fileTypes[$k]; 
    //echo  "<br>" . $k . "<br>";
    if (strcasecmp($fileType, ".dat") != 0) {
        $name = $names[$k];

        $conn->begin_transaction();
        //se le indica a la base de datos que se le va a pasar un conjunto grande de querys.
        //------------------------------------------------------------

        //LECTURA DE DATOS A CARGAR Y CARGA DE DATOS EN LA BASE DE DATOS.
        $claves = constantSet($tDatos[$k]);
        $lineas = file($name);
        $n = count($lineas);
        $j = 0;
        for ($i = 4; ($i < 100000) && ($i < $n); $i++) {
            $arrayLinea = explode("\t", $lineas[$i]); 
            //echo $i . ' --- ';
            if (camposValidos($arrayLinea, $claves)) {
                $time = date2when(trim($arrayLinea[$claves["Date"]]), trim($arrayLinea[$claves["Time"]]));
                $latitud = GPS2degree(trim($arrayLinea[$claves["position latitude"]]));
                $longitud = GPS2degree(trim($arrayLinea[$claves["position longitude"]]));     
                
                //se genera el punto para despues poder indexar espacialmente por punto.
                $geom = "'POINT($longitud $latitud)'";
                $point = "GeomFromText($geom)";

                $otros = '{';
                for ($l = 0; $l < count($arrayLinea); $l++) {
                    if (valido($arrayLinea[$l + 2], $tDatos[$k]['formato'][$l], $tDatos[$k]['longitud'][$l], $tDatos[$k]['precision'][$l])) {
                        $otros .= '\'nombre\': ';
                        $otros .= '\'' . $tDatos[$k]['sensor'][$l] . '\',';
                        $otros .= '\'valores\': {';
                        $otros .= '\'valor\': ';
                        if (is_numeric($arrayLinea[$l + 2])) {
                            $otros .= $arrayLinea[$l + 2] . ' ,';
                        } else {
                            $otros .= '\'' . $arrayLinea[$l + 2] . '\' ,';
                        }
                        if ($tDatos[$k]['dispositivo'][$l] != '') {
                            $otros .= '\'dispositivo\': ';
                            $otros .= '\'' . $tDatos[$k]['dispositivo'][$l] . '\',';
                        }
                        if ($tDatos[$k]['unidades'][$l] != '') {
                            $otros .= '\'unidades\': ';
                            $otros .= '\'' . $tDatos[$k]['unidades'][$l] . '\',';
                        }
                        if ($tDatos[$k]['calculo'][$l] != 'None') {
                            $otros .= '\'calculo\': ';
                            $otros .= '\'' . $tDatos[$k]['calculo'][$l] . '\',';
                        }
                        if ($tDatos[$k]['valores'][$l] != '') {
                            $otros .= '\'tipo\': ';
                            $otros .= '\'' . $tDatos[$k]['valores'][$l] . '\',';
                        }
                        $otros = substr($otros, 0, strlen($otros) - 1);
                        $otros .= '},';
                    }
                }
                //echo $otros . "<br>";
                $otros = substr($otros, 0, strlen($otros) - 1);
                $otros .= '}';
                
                //Inserta el punto en la base de datos.
                $sql = "INSERT INTO mediciones (datetime, longitud, latitud, punto , idcampania, otros) 
                        VALUES ('$time', $longitud, $latitud, $point , $campania, \"$otros\");";
                $conn->query($sql);
                //echo $sql;
                $j++;
            }
        }
        //avisa a la base de datos que ya se pueden hacer todas las operaciones antes solicitadas.
        $conn->commit();
    }
}

//CIERRE DE LA BASE DE DATOS.
$conn->close();

header("location: cargar-mediciones.php");
die();