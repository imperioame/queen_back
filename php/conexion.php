<?php
$servidor = 'mysql.julianmmame.com.ar';
$db = 'test_queen_back';
$usuario = 'queen_back';
$contrasena = 'queen_back123';
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
