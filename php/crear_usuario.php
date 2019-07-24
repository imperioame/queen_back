<?php
header("Access-Control-Allow-Origin: *");
require "conexion.php";

//Este endpoint recibe datos del formulario de creación de usuario y los carga en la bd
//Es posible que el correo ya exista, si es así, devuelve excepción

//recibo los datos
$correo = mysqli_real_escape_string($conexion, $_POST['correo']);
$contrasena = mysqli_real_escape_string($conexion, $_POST['contrasena']);
$nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
$apellido = mysqli_real_escape_string($conexion, $_POST['apellido']);

//MD5 a la contraseña
$contrasena = md5($contrasena);

//preparo la query para insertar campos
$consulta = "INSERT INTO `queen_usuarios`(`nombre`, `Apellido`, `correo`, `contrasena`) VALUES ('$nombre','$apellido','$correo','$contrasena')";

//hago la consulta - en caso de que el correo exista, me va a tirar error
try {
    mysqli_query($conexion, $consulta);
    $code = 200;
    $response = 'ok';
}
catch (exception $e) {
    $response = $e->getMessage();
    $code = 400;
}

echo json_encode($response);
http_response_code($code);
mysqli_close($conexion);

?>