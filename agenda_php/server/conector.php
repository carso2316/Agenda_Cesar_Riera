<?php

    session_start();

    class connectorDB{
        private $host = "localhost";
        private $user = "root";
        private $password = "";
        public $database = "agenda_db";
        
        public $conn;

        //Connection Function

        function testConnection(){

            $initialize = @$this->conn = new mysqli($this->host, $this->user, $this->password);

            if( ! $this->conn ){ //Si existe error de conexión
                $conn['msg'] = "<h4>Error connecting to the database.</h4>";
              }

              echo json_encode($conn); //Devolver respuesta         

        }

        function initConnection($nombre_db){
            $this->conn = new mysqli($this->host, $this->user, $this->password, $nombre_db);
            if ($this->conn->connect_error) {
              return "Error:" . $this->conn->connect_error;
            }else {
              return "OK";
            }
          }

          function userSession(){
            if (isset($_SESSION['email'])) {
                $response['msg'] = $_SESSION['email'];
            }else{
                $response['msg'] = '';
            }
            return json_encode($response);
        }
  
        function verifyUsers(){
            $sql = 'SELECT COUNT(email) FROM usuarios';
            $totalUsers = $this->executeQuery($sql);
            while ($row = $totalUsers->fetch_assoc()) {
  
                return $row['COUNT(email)'];
            }
        }

        function getConnection(){
            return $this->conn;
        }
        function executeQuery($query){
            return $this->conn->query($query);
        }
        function createTable($nombre_tbl, $campos){
            $this->conn = new mysqli($this->host,$this->user,$this->password,$this->database);
            if($this->conn->connect_errno){
                return $this->conn->connect_errno;
            }else{
                //Construcción del script
            $sql = 'CREATE TABLE IF NOT EXISTS '.$nombre_tbl.' (';
            $length_array = count($campos);
            $i = 1;
            foreach ($campos as $key => $value) {
              $sql .= $key.' '.$value;
              if ($i!= $length_array) {
                $sql .= ', ';
              }else {
                $sql .= ');';
              }
              $i++;
            }
            
            $query =  $this->executeQuery($sql); //Ejecutar sentencia SQL
  
            if($query == 1)
            {
              return "OK"; //Devolver respuesta positiva correcta
            }
            else{
              return "Error"; //Devolver error;
              }
          }
        }
        function closeConnection(){
            $this->conn->close();
        }
        function createDB(){
            $this->conn =new mysqli($this->host,$this->user,$this->password);
            $query = $this->conn->query('CREATE DATABASE IF NOT EXISTS '.$this->database);
            if ($query == 1) {
                return "OK";
            }else {
                return "Error";
            }
        }
        function newRestriction($tabla, $restriccion){ 
          $sql = 'ALTER TABLE '.$tabla.' '.$restriccion;
          return $this->executeQuery($sql);
       }
        function newRelation($from_tbl, $to_tbl, $fk_foreign_key_name, $from_field, $to_field){
          $sql = 'ALTER TABLE '.$from_tbl.' ADD CONSTRAINT '.$fk_foreign_key_name.' FOREIGN KEY ('.$from_field.') REFERENCES '.$to_tbl.'('.$to_field.');';
          return $this->executeQuery($sql);
      }
      function insertData($tabla, $data){
      $sql = 'INSERT INTO '.$tabla.' (';
      $i = 1;
      foreach ($data as $key => $value) {
        $sql .= $key;
        if ($i<count($data)) {
          $sql .= ', ';
        }else $sql .= ')';
        $i++;
      }
      $sql .= ' VALUES (';
      $i = 1;
      foreach ($data as $key => $value) {
        $sql .= $value;
        if ($i<count($data)) {
          $sql .= ', ';
        }else $sql .= ');';
        $i++;
      }
      return $this->executeQuery($sql);
    }
  
    //Función para actualizar registro en la base de datos
    function updateRecord($tabla, $data, $condicion){
      $sql = 'UPDATE '.$tabla.' SET ';
      $i=1;
      foreach ($data as $key => $value) {
        $sql .= $key.'='.$value;
        if ($i<sizeof($data)) {
          $sql .= ', ';
        }else $sql .= ' WHERE '.$condicion.';';
        $i++;
      }
      return $this->executeQuery($sql);
    }
  
    //Función para eliminar registro en base de datos
    function deleteRecord($tabla, $condicion){
      $sql = "DELETE FROM ".$tabla." WHERE ".$condicion.";";
      return $this->executeQuery($sql);
    }
  
    //Función para consultar información en base de datos
    function consult($tablas, $campos, $condicion = ""){
      $sql = "SELECT ";
      $result = array_keys($campos);
      $ultima_key = end($result);
      foreach ($campos as $key => $value) {
        $sql .= $value;
        if ($key!=$ultima_key) {
          $sql.=", ";
        }else $sql .=" FROM ";
      }
  
      $result = array_keys($tablas);
      $ultima_key = end($result);
      foreach ($tablas as $key => $value) {
        $sql .= $value;
        if ($key!=$ultima_key) {
          $sql.=", ";
        }else $sql .= " ";
      }
  
      if ($condicion == "") {
        $sql .= ";";
      }else {
        $sql .= $condicion.";";
      }
      return $this->executeQuery($sql);
    }
   
  
  }
  
  class Usuarios //Crear objeto Usuario
  {
    public $tableName = 'usuarios'; //Definir nombre de la tabla
    /*Matriz con las columnas que componen la tabla usuarios*/
    public $data = ['email' => 'varchar(50) NOT NULL PRIMARY KEY',
    'nombre' => 'varchar(50) NOT NULL',
    'password' => 'varchar(255) NOT NULL',
    'fecha_nacimiento' => 'date NOT NULL'];
  
  }
  
  class Eventos
  {
    public $tableName = 'eventos'; //Definir nombre de la tabla
    /*Matriz con las columnas que componen la tabla eventos*/
    public $data = ['id' => 'INT NOT NULL PRIMARY KEY AUTO_INCREMENT',
    'titulo'=> 'VARCHAR(50) NOT NULL',
    'fecha_inicio'=> 'date NOT NULL',
    'hora_inicio' => 'varchar(20)',
    'fecha_finalizacion'=> 'varchar(20)',
    'hora_finalizacion'=> 'varchar(20)',
    'allday'=> 'tinyint(1) NOT NULL',
    'fk_usuarios'=>'varchar(50) NOT NULL'];
  }

//    /////////////////////////

//     $conn = new mysqli('localhost','usuaariooo','contasenaa','nombre_bd'); //crear usuario en phpmyadmin para agenda_db
//     if($mysqli->connect_errno){
//         echo "Error: ".$mysqli->connect_error;
//     }

//     $mysqli->close();



?>