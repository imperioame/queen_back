<?php
header("Access-Control-Allow-Origin: *");

$servidor = 'localhost';
$usuario = 'root';
$contrasena = '';

$conexion = mysqli_connect($servidor, $usuario, $contrasena, 'queen_db') or die ('Hubo un problema al conectarse a la db');

mysqli_set_charset($conexion, 'utf8');


?>
