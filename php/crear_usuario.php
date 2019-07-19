<?php

include coneccion_a_db.php


//recibo los datos
$_post();


//preparo la query para insertar campos

//hago la consulta - en caso de que el correo exista, me va a tirar error

if ($existe){
    echo json_encode('mensaje de error');
}else{
    echo json_encode('mensaje de éxito');
};

?>