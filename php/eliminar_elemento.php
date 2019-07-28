<?php
header("Access-Control-Allow-Origin: *");
require "conexion.php";

//Este endpoint recibe id de tablero para borrar en la bd

//recibo información del usuario e id del tablero
$correo_usuario = mysqli_real_escape_string($conexion, $_POST['correo']);
$id_tablero = mysqli_real_escape_string($conexion, $_POST['id_tablero']);

//$response = array();

//me aseguro de obtener un correo. sinó no prosigo.
if($correo_usuario != null and  $correo_usuario != ''){
    
    //Preparo la consulta:
    $consulta_tablero = "DELETE FROM `queen_elementos` WHERE `tableros_idtableros` = $id_tablero";

    try{
        $exito = mysqli_query($conexion, $consulta_tablero);
        if($exito){
            
            $response['mensaje'] = 'Se ha eliminado el tablero correctamente.';
            $code = 200;

        }else{
            $response['mensaje'] = 'No se ha podido eliminar el tablero por error de SQL';
            $code = 400;
        }
    }catch (exception $e) {
        $response['mensaje'] = 'Hubo un error de SQL.';
        $response['mensaje_extra'] = $e;
        $code = 400;
    }

}else{
    $response['mensaje'] = 'No se recibió usuario, no se pudo ejecutar la acción';
    $code = 401;
}

echo json_encode($response);
http_response_code($code);
mysqli_close($conexion);

?>