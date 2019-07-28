<?php
header("Access-Control-Allow-Origin: *");
require "conexion.php";

//Este endpoint recibe el objeto maestro de datos de la app, la despedaza y la guarda en las tablas que corresponde

//recibo información del usuario y datos a guardar
$correo_usuario = mysqli_real_escape_string($conexion, $_POST['correo']);
$tablero = $_POST['tablero'];

//Debuggeo:
//$response['mensaje_extra'] = $correo_usuario;
//$tablero = $_POST['tablero'];
//mail('julianmmame@gmail.com', 'asuto', var_dump($tablero));

//$response = array();

//me aseguro de obtener un correo. sinó no prosigo.
if($correo_usuario != null and  $correo_usuario != ''){

    $id_tablero_a_actualizar = $tablero['id_tablero'];
    $titulo_de_tablero = $tablero['titulo'];
    $es_destacado = $tablero['es_destacado'];
    $es_oculto = $tablero['es_oculto'];
    $fecha_creacion_recibida = $tablero['fecha_creacion'];

    //Debuggeo:
    //$response['post_tablero'] = $tablero;
    //$response['post_correo'] = $_POST['correo'];
    //$response['callback'] = 'recibí: titulo: '.$titulo_de_tablero.' destacado: '.$es_destacado.' oculto: '.$es_oculto.' fecha de creación: '.$fecha_creacion;


    /*
    Corregí en front: ahora los datos se almacenan y envían como 0 o 1
    if($es_destacado == 'true' || $es_destacado == true){
        $es_destacado = 1;
    }else{
        $es_destacado = 0;
    };
    
    if($es_oculto == 'true'|| $es_oculto == true){
        $es_oculto = 1;
    }else{
        $es_oculto = 0;
    };
    */

    $fecha_creacion_convertida = strtotime($fecha_creacion_recibida);
    $fecha_creacion = date('Y-m-d', $fecha_creacion_convertida);
    //$fecha_creacion = $fecha_creacion_convertida;

    //Me fijo si debo actualizar o crear un tablero nuevo:
    //Si el id del tablero recibido es '-1' entonces debo crear, sinó, debo actualizar
    if($id_tablero_a_actualizar == -1 || $id_tablero_a_actualizar == '-1' || $id_tablero_a_actualizar == null){
        //El tablero no existe, debo crearlo
        //Preparo la consulta
        $consulta_tablero = "INSERT INTO `queen_tableros`(`titulo`, `es_destacado`, `es_oculto`, `fecha_creacion`) 
        VALUES ('$titulo_de_tablero','$es_destacado','$es_oculto','$fecha_creacion')";

        try{
            //Lo intento inyectar
            $exito = mysqli_query($conexion, $consulta_tablero);
            if ($exito){
                $response['id_tablero'] = mysqli_insert_id($conexion);
                $code = 200;
                $response['mensaje'] = 'Se ha creado un nuevo tablero en la bd correctamente.';

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
        }catch (exception $e) {
            $response['mensaje'] = 'Hubo un error de SQL.';
            $response['mensaje_extra'] = $e;
            $code = 400;
        };

        
    }else{
        //El tablero existe - debo actualizar
        $consulta_tablero = "UPDATE `queen_tableros`
        SET `titulo`= '$titulo_de_tablero',`es_destacado`= '$es_destacado',`es_oculto`= '$es_oculto',`fecha_creacion`= '$fecha_creacion'
        WHERE `idtableros` = '$id_tablero_a_actualizar'";
        
        try{
            $exito = mysqli_query($conexion, $consulta_tablero);

            if($exito){
                $code = 200;
                $response['mensaje'] = 'Se ha actualizado el tablero correctamente';
            }else{
                $response['mensaje'] = 'No se pudo actualizar el tablero';
                $code = 400;
            };

        }catch (exception $e) {
            $response['mensaje'] = 'Hubo un error de SQL.';
            $response['mensaje_extra'] = $e;
            $code = 400;
        };
        
    };

}else{
    $response['mensaje'] = 'No se recibió usuario, no se pudo ejecutar la acción';
    $code = 401;
};


echo json_encode($response);
http_response_code($code);
mysqli_close($conexion);

?>