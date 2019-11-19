<?php
    require('conector.php');
    $connectorDB = new connectorDB();

    $response['conn'] = $connectorDB->initConnection($connectorDB->database);
    if ($response['conn'] == 'OK'){
        $conexion = $connectorDB->getConnection();
        $insert = $conexion->prepare('INSERT INTO usuarios (email, nombre, password , fecha_nacimiento) VALUES (?,?,?,?)');
        $insert->bind_param("ssss", $email, $nombre, $password, $fecha_nacimiento);

        $d_password = "1234";
        $email = "usuario@gmail.com";
        $nombre = "usuario";
        $password = password_hash($d_password, PASSWORD_DEFAULT);
        $fecha_nacimiento = "1990-06-17";

        $insert->execute();

        $email = 'cesar@gmail.com';
        $nombre = 'cesar';
        $password = password_hash($d_password, PASSWORD_DEFAULT);
        $fecha_nacimiento = '1994-05-23';

        $insert->execute();

        $email = 'felix@gmail.com';
        $nombre = 'felix';
        $password = password_hash($d_password, PASSWORD_DEFAULT);
        $fecha_nacimiento = '1975-01-25';

        $insert->execute();
        $response['resultado'] = "1";
        $response['msg']= 'Informacion de inicio:';
        $getUsers = $connectorDB->consult(['usuarios'],['*'],$condicion = "");
        while ($fila= $getUsers->fetch_assoc()) {
            $response['msg'].=$fila['email'];
        }
        $response['msg'].= 'contrasena: '.$d_password;
        }else{
            $response['resultado'] == "0";
            $response['msg'] = 'No se pudo conectar a la base de datos';
        }

        echo json_encode($response);


 ?>