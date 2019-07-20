<?php

require "conexion.php";

//recibo el dato del usuario
$usuario = mysqli_real_escape_string($conexion, $_POST['correo']);

//Preparo la query
$consulta = "SELECT * FROM tableros INNER JOIN elementos ON tableros.idtableros = elementos.tableros_idtableros
WHERE correo='$usuario'";


//busco los datos en la bd
$fila = mysqli_query($conexion, $consulta);

while ($columnas = mysqli_fetch_assoc( $fila )){
    
    $datos = array();


    //Mando mensaje de éxito
    $datos['mensaje'] = '200';
    //Mando nombre y apellido del usuario
    $datos['nombre'] = $columnas['nombre'];;
    $datos['apellido'] = $columnas['apellido'];;

    echo json_encode($datos);
    mysqli_close($columnas);
        
};

?>