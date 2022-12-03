<?php

$var = 5;
$var2 = 15;
$resultado = false;

function sumar($var, $var2){
    $resultado = $var + $var2;

    return $resultado;
}

echo sumar($var, $var2);