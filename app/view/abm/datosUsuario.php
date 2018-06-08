<?php
require_once '../../config/Conexion.php'; 

    $nombre=$_POST["nombreUsuario"];
    $apellido=$_POST["apellidoUsuario"];
    $cuilUsuario=$_POST["cuilUsuario"];
    $email=$_POST["emailUsuario"];
    $dni=$_POST["dniUsuario"];
    $telUsuario=$_POST["telUsuario"];
    $estado = "Pendiente";
    $rol=1;
    $pass=$_POST["passUsuario"];
    $pass_sha1 = sha1($pass); //Guarda el pass hasheado

    $insertarUsuario = "INSERT INTO usuarios(nombre, apellido, cuil, email, dni, telefono,estado,idRol,pass) VALUES ('$nombre', '$apellido', '$cuilUsuario','$email','$dni', '$telUsuario','$estado', '$rol', '$pass_sha1')";
    
    $resultado=mysqli_query($conexion,$insertarUsuario);
    
    mysqli_close($conexion); 

    //Luego mandar a una vista (te registraste con exito)
    header('location: ../index.php');
    ?>