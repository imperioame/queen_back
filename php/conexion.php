<?php
header("Access-Control-Allow-Origin: *");

$servidor = 'localhost';
$usuario = 'distrig_queen';
$contrasena = 'HolaHola1!';
$db = 'distritog_id';

$conexion = mysqli_connect($servidor, $usuario, $contrasena, $db) or die ('Hubo un problema al conectarse a la db');

mysqli_set_charset($conexion, 'utf8');


?>
