<?php
header("Access-Control-Allow-Origin: *");
require "conexion.php";

//Este endpoint recibe un nuevo elemento de algún tablero, lo carga en la bd y devuelve el id

//recibo información del usuario y datos a guardar
$correo_usuario = mysqli_real_escape_string($conexion, $_POST['correo']);
$elemento = $_POST['elemento'];

$response = array();

//Debuggeo:
//$response['mensaje'] = 'test';
//echo json_encode($response);
/*
var_dump($response);
var_dump('test');
*/
//http_response_code($code);
//mysqli_close($conexion);

//me aseguro de obtener un correo. sinó no prosigo.
if($correo_usuario != null and $correo_usuario != ''){

    $id_elemento = $elemento['id_elemento'];
    $indice = $elemento['indice_elemento'];
    $id_tablero = $elemento['id_tablero'];
    $es_lista = $elemento['es_lista'];
    $es_lista = $elemento['realizado'];
    $contenido = $elemento['contenido'];
    $status = $elemento['status'];
    $fecha_deadline_recibida = $elemento['fecha_deadline'];
    $fecha_creacion_recibida = $elemento['fecha_creacion'];
    //$titulo = $columnas['titulo'];

    /*
    //Corregí en el frontend: ahora los datos se almacenan y envían como 0 o 1
    if($es_lista == 'true' || $es_lista == true){
        $es_destacado = 1;
    }else{
        $es_destacado = 0;
    }
    */

    //Formateo datos:
    $fecha_deadline_convertida = strtotime($fecha_deadline_recibida);
    $fecha_deadline = date('Y-m-d', $fecha_deadline_convertida);
    
    $fecha_creacion_convertida = strtotime($fecha_creacion_recibida);
    $fecha_creacion = date('Y-m-d', $fecha_creacion_convertida);

    //averiguo el id de status del status de este elemnto
    $consulta_status = "SELECT * FROM `queen_status` WHERE `valor` = '$status'";

    try{
        $fila = mysqli_query($conexion, $consulta_status);
        if($fila){
            $columna = mysqli_fetch_assoc( $fila );

            $id_status = $columna['idstatus'];
            $response['id_status_detectado'] = $id_status;

            //Averiguo si es actualización de ubn elemento existente o creación de uno nuevo
            if($id_elemento == -1 || $id_elemento == '-1' || $id_elemento == null){
                //es creación.

                //Preparo la consulta
                $consulta_carga_elemento = "INSERT INTO `queen_elementos`(`indice_de_elemento`, ` es_lista`, `contenido`, `fecha_deadline`, `fecha_creacion`, `tableros_idtableros`, `status_idstatus`)
                VALUES ('$indice','$es_lista','$contenido','$fecha_deadline','$fecha_creacion','$id_tablero','$id_status')";

                //Lo intento inyectar
                $exito = mysqli_query($conexion, $consulta_carga_elemento);
                if ($exito){
                    $response['id_elemento'] = mysqli_insert_id($conexion);
                    $code = 200;
                    $response['mensaje'] = 'Se cargó de un nuevo elemento';
                }else{
                    $response['mensaje'] = 'No se pudo realizar la carga del nuevo elemento';
                    $code = 400;
                }
                
                

            }else{
                //es actualización
                //El tablero existe - debo actualizar
                $consulta_tablero = "UPDATE `queen_elementos` 
                SET `indice_de_elemento`='$indice',` es_lista`='$es_lista',`contenido`='$contenido',`fecha_deadline`='$fecha_deadline',`fecha_creacion`='$fecha_creacion',`tableros_idtableros`='$id_tablero'',`status_idstatus`='$id_status'
                WHERE `idelementos`= '$id_elemento'";
                
                try{
                    $exito = mysqli_query($conexion, $consulta_tablero);
                    if($exito){
                        $code = 200;
                        $response['mensaje'] = 'Se ha actualizado el elemento correctamente';
                    }else{
                        $response['mensaje'] = 'No se pudo actualizar el elemento.';
                        $code = 400;
                    }
                }catch (exception $e) {
                    $response['mensaje'] = 'No se pudo realizar la actualizacion del nuevo elemento por error de SQL';
                    $code = 400;
                }
            }
        }else{
            $response['mensaje'] = 'Hubo un error en la búsqueda del Status asociado al elemento';
            $code = 401;
        }
    }
    catch (exception $e) {
        $response['mensaje'] = 'Hubo un error de SQL al intentar seleccionar el status';
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