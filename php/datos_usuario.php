<?php
header("Access-Control-Allow-Origin: *");
require "conexion.php";

//Este endpoint devuelve todos los datos de tableros que se tiene de un usuario


//recibo el dato del usuario
$usuario = mysqli_real_escape_string($conexion, $_POST['correo']);

//$response = array();


//Preparo la query para identificar los tableros del usuario
$consulta_tableros_de_usuario = "SELECT * FROM queen_usuarios_has_tableros
INNER JOIN queen_tableros ON queen_tableros.idtableros = queen_usuarios_has_tableros.tableros_idtableros
INNER JOIN queen_usuarios ON queen_usuarios.idusuarios = queen_usuarios_has_tableros.usuarios_idusuarios
WHERE correo='$usuario'
ORDER BY idtableros ASC";


try{
    //busco los datos en la bd
    $fila_tableros = mysqli_query($conexion, $consulta_tableros_de_usuario);
    $tableros_a_entregar = array();
    $elementos_a_entregar = array();

    //Mensaje en caso de que no encuentre nada

    $indice_tableros = 0;

    $objeto_maestro_de_datos = array();
    //Mando mensaje de éxito
    $objeto_maestro_de_datos['mensaje'] = 'No hay datos del usuario';
    $code = 404;

    while ($columnas_tableros = mysqli_fetch_assoc( $fila_tableros )){
        //Busco todos los elementos del tablero actual
        //1)averiguo en que tablero estoy parado:
        $id_tablero_actual = $columnas_tableros['tableros_idtableros'];
        
        //2)Preparo la consulta:
        $consulta_elementos_del_tablero = "SELECT * FROM queen_elementos
        INNER JOIN queen_status ON queen_status.idstatus = queen_elementos.status_idstatus
        WHERE tableros_idtableros='$id_tablero_actual'
        ORDER BY indice_de_elemento ASC";


        //3)Consulto:
        $fila_elementos = mysqli_query($conexion, $consulta_elementos_del_tablero);

        //4)proceso todos los elementos de este tablero:
        $indice_elementos = 0;
        while($columnas_elementos = mysqli_fetch_assoc($fila_elementos)){
            $elementos_a_entregar[$indice_elementos] = array();
            $elementos_a_entregar[$indice_elementos]['id_elemento'] = $columnas_elementos['idelementos'];
            $elementos_a_entregar[$indice_elementos]['indice_elemento'] = $columnas_elementos['indice_de_elemento'];
            $elementos_a_entregar[$indice_elementos]['es_lista'] = $columnas_elementos['es_lista'];
            $elementos_a_entregar[$indice_elementos]['contenido'] = $columnas_elementos['contenido'];
            $elementos_a_entregar[$indice_elementos]['fecha_deadline'] = $columnas_elementos['fecha_deadline'];
            $elementos_a_entregar[$indice_elementos]['fecha_creacion'] = $columnas_elementos['fecha_creacion'];
            $elementos_a_entregar[$indice_elementos]['id_tablero'] = $id_tablero_actual;
            $elementos_a_entregar[$indice_elementos]['status'] = $columnas_elementos['titulo'];

            $indice_elementos++;
        };

        //Proceso el tablero actual
        $tableros_a_entregar[$indice_tableros] = array();
        $tableros_a_entregar[$indice_tableros]['id_tablero'] = $columnas_tableros['idtableros'];
        $tableros_a_entregar[$indice_tableros]['titulo'] = $columnas_tableros['titulo'];
        $tableros_a_entregar[$indice_tableros]['es_destacado'] = $columnas_tableros['es_destacado'];
        $tableros_a_entregar[$indice_tableros]['es_oculto'] = $columnas_tableros['es_oculto'];
        $tableros_a_entregar[$indice_tableros]['fecha_creacion'] = $columnas_tableros['fecha_creacion'];

        $indice_tableros++;
        //Encontré:
        $code = 200;
        $objeto_maestro_de_datos['mensaje'] = 'Envio datos';
        
    };



    //Mando los arrays
    $objeto_maestro_de_datos['elementos'] = $elementos_a_entregar;
    $objeto_maestro_de_datos['tableros'] = $tableros_a_entregar;
}catch (exception $e) {
    $response['mensaje'] = 'Hubo un error de SQL.';
    $response['mensaje_extra'] = $e;
    $code = 400;
};


http_response_code($code);
echo json_encode($objeto_maestro_de_datos);
mysqli_close($conexion);


?>