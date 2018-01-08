<?php
$archName = "datos.dat";

//CONECCION CON LA BASE DE DATOS.
$servername = "localhost";
$username = "wen";
$password = "wen";
$dbname = "sgs";
$conn =new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}
//------------------------------------------------------------

$sql = "SELECT latitud, longitud, profundidad 
        FROM puntos 
        WHERE id < 5000;";

//al ser una sola query no es necesario hacer commit ni comenzar tranzacción.
$result = $conn->query($sql);

$datos = "Lat+N\tLong+E\tDep\n";

$norte = -99999;
$sur = 99999;
$este = 99999;
$oeste = -99999;
 
if ($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $lon = $row["longitud"];
        if ($lon > $oeste)
            $oeste = $lon;
        else
            if ($lon < $este)
                $este = $lon;
        $lat = $row["latitud"];
        if ($lat > $norte)
            $norte = $lat;
        else
            if ($lat < $sur)
                $sur = $lat;
        $depth = $row["profundidad"];
        if (($depth != null) && ($depth != 0)){
            $datos .= $lon . "\t" . $lat . "\t" . $depth . "\n";
        }
    }
}

$conn->close();

echo "Norte: $norte\nSur: $sur\nEste: $este\nOeste: $oeste";

$arch = fopen($archName, "w");
fwrite($arch, $datos);
fclose($arch);


