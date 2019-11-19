<?php
	require('conector.php');
	//crear conexion con la clase conector
	$connectorDB = new connectorDB();
	$response['conn'] = $connectorDB->initConnection($connectorDB->database);
	if ($response['conn'] == 'OK') {
		if ($connectorDB->deleteRecord('eventos', 'id='.$_POST['id'])) {
			$response['msg'] = 'OK';
		}else{
			$response['msg'] = 'No se a podido eliminar el registro';
		}
	}else{
			$response['msg'] = "error en la comunicacion con la base de datos";
		}
	echo json_encode($response)




 ?>
