<?php

include coneccion_a_db.php

//recibo datos de usuario y contraseña
$_post();


//Md5 a la contraseña


//Preparo la query
$query = 'SELECT * FROM usuarios WHERE correo = aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
//busco los datos en la bd

$datos = mysqli_query($coneccion,$query);

while (mysqli_fetch_assoc($datos)){
}


//retorno mensaje de éxito o código de error
if($encontre){
    echo json_encode('código de éxito');
}else{
    echo json_encode('código de error');
}





?>