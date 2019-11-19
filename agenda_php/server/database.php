<?php
	require('./conector.php');
	$connectorDB = new connectorDB(); //Iniciar el objeto ConectorBD
	$response['msg'] = $connectorDB->testConnection();//Iniciar la función verifyConexion
	return $response['msg']; //Devolver resultado

?>