<?php
	require('./conector.php');
    $connectorDB = new connectorDB();
    if($connectorDB->initConnection($connectorDB->database) == 1049){ //Verificar si no existe la base de adtos al comparar que la respuesta del servidor sea iguale a 1049
      $conn['msg'] = "Creando base de datos ".$connectorDB->database;
      $database = $connectorDB->createDB(); //Ejecutar función crear base de datos
        
        if ($database != "OK"){ //Si existe un error
       
          $conn['msg'] = "<h6><b>Error de privilegios</b></h6></br>El usuario <b>'$con->user'</b> no existe o no posee la permisología requerida para crear la base de datos <b>$connectorDB->database</b>. Si desea crear automaticamente la base de datos, ingrese los parámetros de un usuario phpmyadmin con permisos para crear bases de datos en las variables usuario <b>\$user </b> y contraseña <b>\$password</b> respectivamente en el archivo <b>conector.php</b> en la carpeta <b>server</b> del proyecto. O bien puede crearla manualmente desde el panel de control phpmyadmin."; //Mostrar mensaje
      
        }else{ //Si se crea exitosamente
        
            $conn['database'] = "OK"; //Estado OK
            $conn['msg'] = "Base de datos creada con éxito"; //Mensaje de descripción de la acción
        
        }
        }else{
        //Si la base de datos ya existe
        $conn['database'] = "OK"; //Estado OK
        $conn['msg'] = "Base de datos <b>".$connectorDB->database."</b> encontrada"; //Mensaje de descripción de acción
        }
        echo json_encode($conn);


?>