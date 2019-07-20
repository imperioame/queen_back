<?php

    require "conexion.php";

    //recibo el dato del usuario
    $usuario = mysqli_real_escape_string($conexion, $_POST['correo']);

    //Preparo la query
    $consulta = "SELECT * FROM usuarios_has_tableros
    INNER JOIN tableros ON tableros.idtableros = usuarios_has_tableros.tableros_idtableros
    INNER JOIN usuarios ON usuarios.idusuarios = usuarios_has_tableros.usuarios_idusuarios
    INNER JOIN elementos ON elementos.tableros_idtableros = tableros.idtableros
    WHERE correo='$usuario'
    ORDER BY idtableros ASC";


//Ver la posibilidad de hacer la query de elementos por separado - adentro del bucle de fetch assoc de tableros

    //busco los datos en la bd
    $fila = mysqli_query($conexion, $consulta);
    $tableros = array();
    $elementos = array();

    while ($columnas = mysqli_fetch_assoc( $fila )){
        //Preparo el objeto a enviar
        
    };

    //Mando mensaje de éxito
    $datos['mensaje'] = '200';
    //Mando nombre y apellido del usuario
    $datos['nombre'] = $columnas['nombre'];;
    $datos['apellido'] = $columnas['apellido'];;

    echo json_encode($datos);
    mysqli_close($columnas);


?>