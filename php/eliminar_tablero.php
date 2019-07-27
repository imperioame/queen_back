<?php
header("Access-Control-Allow-Origin: *");
require "conexion.php";

//Este endpoint recibe id de tablero para borrar en la bd

//recibo información del usuario e id del tablero
$correo_usuario = mysqli_real_escape_string($conexion, $_POST['correo']);
$id_tablero = mysqli_real_escape_string($conexion, $_POST['id_tablero']);

$response = array();


//me aseguro de obtener un correo. sinó no prosigo.
if($correo_usuario != null and  $correo_usuario != ''){
    
}else{
    $response['mensaje'] = 'No se recibió usuario, no se pudo ejecutar la acción';
    $code = 400;
};


echo json_encode($response);
http_response_code($code);
mysqli_close($conexion);

?>