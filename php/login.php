<?php

require "conexion.php";

//recibo datos de usuario y contraseña
$correo_usuario = mysqli_real_escape_string($conexion, $_POST['correo']);
$contrasena = mysqli_real_escape_string($conexion, $_POST['contrasena']);

//Md5 a la contraseña
$contrasena = md5($contrasena);

//Preparo la query
$consulta = "SELECT * FROM usuarios WHERE correo='$correo_usuario' AND contrasena='$contrasena'";

//busco los datos en la bd
$fila = mysqli_query($conexion, $consulta);

$columnas = mysqli_fetch_assoc( $fila );

$datos = array();


//Consulto si tuvo éxito
if($columnas == false){
    //mensaje de error, probablemente no sea este, pero sirve
	$datos['mensaje'] = '401';
	echo json_encode($datos);
	exit;
}

//Mando mensaje de éxito
$datos['mensaje'] = '200';
//Mando nombre y apellido del usuario
$datos['nombre'] = $columnas['nombre'];;
$datos['apellido'] = $columnas['apellido'];;

echo json_encode($datos);
mysqli_close($columnas);
?>