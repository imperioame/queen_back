<?php
$servidor = '35.222.73.132';
$usuario = 'root';
$contrasena = 'v33black';
$db = 'distritog_id';

$response = array();
$conexion = false;

try{
    $conexion = mysqli_connect($servidor, $usuario, $contrasena, $db);
    mysqli_set_charset($conexion, 'utf8');

    //var_dump($conexion);

}catch (exception $e) {
    $response['mensaje'] = 'Hubo un problema al conectarse a la db';
    $response['mensaje_extra'] = $e;
    $code = 400;
    
    echo json_encode($response);
    http_response_code($code);
    die;
}

?>
