<?php
header("Access-Control-Allow-Origin: *");
require "conexion.php";

//Este endpoint recibe el objeto maestro de datos de la app, la despedaza y la guarda en las tablas que corresponde

//recibo información del usuario y datos a guardar
$correo_usuario = mysqli_real_escape_string($conexion, $_POST['correo']);
$tablero = mysqli_real_escape_string($conexion, $_POST['tablero']);

$correo_usuario = json_decode($correo_usuario);
$tablero = json_decode($tablero);

$response = array();

//Preparo la consulta
$consulta_tablero = "INSERT INTO `queen_tableros`(`titulo`, `es_destacado`, `es_oculto`, `fecha_creacion`) 
VALUES ('$tablero->titulo','$tablero->es_destacado','$tablero->es_oculto','$tablero->fecha_creacion')";


//Lo intento inyectar
$exito = mysqli_query($conexion, $consulta_tablero);
if ($exito){
    $response['id_tablero'] = mysqli_insert_id($conexion);
    $code = 200;
    $response['mensaje'] = 'ok';

    //Continuo................

    //Averiguo que id tiene este usuario:
    $consulta_usuario = "SELECT * FROM `queen_usuarios` WHERE `correo`= '$correo_usuario'";
    $exito = mysqli_query($conexion, $consulta_usuario);
    if ($exito){
        $columnas = mysqli_fetch_assoc( $exito );
        $id_usuario = $columnas['idusuarios'];

        //Encontré al usuario, ahora tengo que hacer la relación tablero - usuario:
        $id_tablero = $response['id_tablero'];
        $consulta_usuario_tablero = "INSERT INTO `queen_usuarios_has_tableros`(`usuarios_idusuarios`, `tableros_idtableros`) VALUES ('$id_usuario','$id_tablero')";
        
        //Lo intento inyectar
        $exito = mysqli_query($conexion, $consulta_usuario_tablero);
        if (! $exito){
            $response['mensaje'] = 'No se pudo vincular el usuario con el tablero';
            $code = 400;
        };
    }else{
        $response['mensaje'] = 'No se encontró el usuario dueño de este tablero';
        $code = 400;
    };
}else{
    $response['mensaje'] = 'No se pudo insertar el tablero';
    $code = 400;
};

echo json_encode($response);
http_response_code($code);
mysqli_close($conexion);

?>