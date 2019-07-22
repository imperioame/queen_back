<?php
require "conexion.php";

//Este endpoint recibe un nuevo elemento de algún tablero, lo carga en la bd y devuelve el id

//recibo información del usuario y datos a guardar
$elemento = mysqli_real_escape_string($conexion, $_POST['elemento']);

//disecto el dato
$elemento = json_decode($elemento);

//averiguo el id de status del status de este elemnto
$consulta_status = "SELECT * FROM queen_status WHERE titulo = '$elemento->status'";
$fila = mysqli_query($conexion, $consulta_status);
$columna = mysqli_fetch_assoc( $fila );


//Preparo la consulta
$consulta_carga_elemento = "INSERT INTO `queen_elementos`(`indice_de_elemento`, ` es_lista`, `contenido`, `fecha_deadline`, `fecha_creacion`, `tableros_idtableros`, `status_idstatus`) VALUES ('$elemento->indice_elemento','$elemento->es_lista','$elemento->contenido','$elemento->fecha_deadline','$elemento->fecha_creacion','$elemento->id_tablero','$columnas['titulo']')";

//Lo intento inyectar
try {
    mysqli_query($conexion, $consulta_carga_elemento);
    $response = mysqli_insert_id($conexion);
}
catch (exception $e) {
    $response = '-1';
};

echo json_encode($response);
mysqli_close($conexion);

?>