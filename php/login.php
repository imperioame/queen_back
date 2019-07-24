<?php
header("Access-Control-Allow-Origin: *");
require "conexion.php";

//este endpoint permite al usuario loguearse


//recibo datos de usuario y contraseña
$correo_usuario = mysqli_real_escape_string($conexion, $_POST['correo']);
$contrasena = mysqli_real_escape_string($conexion, $_POST['contrasena']);

//Md5 a la contraseña
$contrasena = md5($contrasena);

//Preparo la query
$consulta = "SELECT * FROM queen_usuarios WHERE correo='$correo_usuario' AND contrasena='$contrasena'";

//busco los datos en la bd
$fila = mysqli_query($conexion, $consulta);

$columnas = mysqli_fetch_assoc( $fila );

$datos = array();


//Consulto si tuvo éxito
if($columnas == false){
    //mensaje de error, probablemente no sea este, pero sirve
	$datos['mensaje'] = 'El usuario no existe';
	$code = 401;
	http_response_code($code);
	echo json_encode($datos);
	exit;
};

//Mando mensaje de éxito
$datos['mensaje'] = 'Envío datos';
$code = 200;
//Mando nombre y apellido del usuario
$datos['nombre'] = $columnas['nombre'];
$datos['apellido'] = $columnas['apellido'];

echo json_encode($datos);
http_response_code($code);
mysqli_close($conexion);
?>