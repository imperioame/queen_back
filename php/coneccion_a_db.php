<?php

$usuario = 'root';
$contrasena = '';

$coneccion = mysqli_connect('localhost', $usuario, $contrasena, 'queen_db') or die ('Hubo un problema al conectarse a la db');

mysqli_set_charset($coneccion, 'UTF-8');

