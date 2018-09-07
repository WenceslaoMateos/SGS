<?php

$precisa_sesion = true;
$msg_error = 0;
$permiso = 200;

require('templates/coneccion.php');

$id = $_REQUEST['id'];

$sql = mysqli_query($db, 'DELETE mediciones FROM mediciones INNER JOIN campanias ON campanias.id = mediciones.idcampania WHERE idbarcos=' . $id . ';');
$sql = mysqli_query($db, 'DELETE FROM campanias WHERE idbarcos=' . $id . ';');
$sql = mysqli_query($db, 'DELETE FROM barcos WHERE id=' . $id . ';');

header("location: editar-barcos.php");
die();
?>