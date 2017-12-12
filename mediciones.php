<?php

$name = "DataRLAbvE.dat";

$lineas = file($name);
$arrayLinea1 = explode("\t" , $lineas[0]); 
$arrayLinea2 = explode("\t" , $lineas[1]); 
$arrayLinea3 = explode("\t" , $lineas[2]); 
$arrayLinea4 = explode("\t" , $lineas[3]); 
$n = count($arrayLinea1);
for($i = 0 ; $i < $n ; $i++)
{
    echo "$i -- " . $arrayLinea1[$i] . " -- " . $arrayLinea2[$i] . " -- " . $arrayLinea3[$i] . " -- " . $arrayLinea4[$i] . "\n";
}

$n = count($lineas);
for($i = 0 ; $i < 20 ; $i++)
{
    $arrayLinea5 = explode("\t" , $lineas[$i]); 
    echo $arrayLinea5[16] . "\n";
}