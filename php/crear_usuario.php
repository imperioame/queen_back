<?php
require "conexion.php";


//recibo los datos
$_post();
$usuario = mysqli_real_escape_string($cnx, $_POST['usuario']);
$contrasena = mysqli_real_escape_string($cnx, $_POST['clave']);


//preparo la query para insertar campos

//hago la consulta - en caso de que el correo exista, me va a tirar error

if ($existe){
    echo json_encode('mensaje de error');
}else{
    echo json_encode('mensaje de éxito');
};

?>