<?php
header("Access-Control-Allow-Origin: *");
require "conexion.php";

//Este endpoint recibe el objeto maestro de datos de la app, la despedaza y la guarda en las tablas que corresponde

//recibo información del usuario y datos a guardar
$correo_usuario = mysqli_real_escape_string($conexion, $_POST['correo']);
$datos = mysqli_real_escape_string($conexion, $_POST['datos']);

//disecto los datos recibidos
$datos = json_decode($datos);

//Empiezo por el array de tableros
$array_tableros = $data->tableros;
//Lo recorro
foreach($array_tableros as $obj_tablero){
    //Preparo la consulta
    $consulta = "INSERT INTO `tableros`(`idtableros`, `titulo`, `es_destacado`, `es_oculto`, `fecha_creacion`) 
    VALUES ('$obj_tablero->id_tablero;','$obj_tablero->titulo','$obj_tablero->es_destacado','$obj_tablero->es_oculto','$obj_tablero->fecha_creacion')";

    //Lo intento inyectar
    try {
        mysqli_query($conexion, $consulta);
        $response = '200';
        $code = 200;
    }
    catch (exception $e) {
        $response = $e->getMessage();
        $code = 500;
        echo json_encode($response);
    };
};


//Sigo por el array de elementos
$array_elementos = $data->elementos;
//Lo recorro
foreach($array_tableros as $obj_elemento){
    //Preparo la consulta
    $consulta = "INSERT INTO `queen_elementos`(`idelementos`, `indice_de_elemento`, ` es_lista`, `contenido`, `fecha_deadline`, `fecha_creacion`, `tableros_idtableros`, `status_idstatus`) 
    VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8])";

    //Lo intento inyectar
    try {
        mysqli_query($conexion, $consulta);
        $response = '200';
        $code = 200;
    }
    catch (exception $e) {
        $response = $e->getMessage();
        echo json_encode($response);
        $code = 500;
    };
};


http_response_code($code);
mysqli_close($conexion);

?>