<?php

$precisa_sesion = true;
$msg_error = 0;
$permiso = 150;

require('templates/coneccion.php');

$id = $_REQUEST['id'];

$sql = mysqli_query($db, 'DELETE FROM mediciones WHERE idcampania=' . $id . ';');
$sql = mysqli_query($db, 'DELETE FROM campanias WHERE id=' . $id . ';');

header("location: editar-campanias.php");
die();
?>