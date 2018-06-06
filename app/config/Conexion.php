<?php

    
     $host = '127.0.0.1';
     $user = 'root';
     $pass = '';
    $db = 'consorcio';
$conexion=mysqli_connect($host,$user,$pass,$db);
/*
    if(mysqli_connect_errno){
      die ('Error en la conexion a la base de datos: '. mysqli_connect_errno());
    }*/

 /* public function chequearCampo($tabla, $columna, $valor){
    $query = "SELECT * FROM `$tabla` WHERE `$columna` = '$valor'";
    $sql = $this->query($query);
    $filas = $sql->num_rows;
    return $filas;
  }*/

 /* public function getId($tabla, $columna, $valor){
    $query = "SELECT `id` FROM `$tabla` WHERE `$columna` = '$valor'";
    $sql = $this->query($query);
    $id = $sql->fetch_assoc()["id"];
    return $id;
  }*/
    
/*public function getLogin($tabla, $columnaEmail, $columnaPass, $email, $pass){
    $query = "SELECT `id` FROM `$tabla` WHERE `$columnaEmail` = '$email' 
    and `$columnaPass` = '$pass'";
    $sql = $this->query($query);
    $filas = $sql->num_rows;
    return $filas;
  }*/
       
?>