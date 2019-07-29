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
    
    //Primero borro la relación usuario-tablero
    //Preparo la consulta:
    $consulta_rel_us_tab = "DELETE FROM `queen_usuarios_has_tableros` WHERE `tableros_idtableros` = $id_tablero";
    
    try{
        $exito = mysqli_query($conexion, $consulta_rel_us_tab);
        if($exito){
            //Continuo con la tabla de tableros
            //Preparo la consulta:
            $consulta_tablero = "DELETE FROM `queen_tableros` WHERE `idtableros` = $id_tablero";
        
            $exito = mysqli_query($conexion, $consulta_tablero);
            if($exito){
                $response['mensaje'] = 'Se ha eliminado el tablero correctamente.';
                $code = 200;

            }else{
                $response['mensaje'] = 'No se ha podido eliminar el tablero';
                $code = 400;
            }
        }else{
            $response['mensaje'] = 'No se ha podido desenlazar el tablero del usuario';
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