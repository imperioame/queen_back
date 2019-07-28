<?php
$servidor = 'localhost';
$usuario = 'distritog_queen';
$contrasena = 'HolaHola1!';
$db = 'distritog_id';

$response = array();

try{
    $conexion = mysqli_connect($servidor, $usuario, $contrasena, $db);
    mysqli_set_charset($conexion, 'utf8');

}catch (exception $e) {
    $response['mensaje'] = 'Hubo un problema al conectarse a la db';
    $response['mensaje_extra'] = $e;
    $code = 400;
    
    echo json_encode($response);
    http_response_code($code);
    die;
};



?>
