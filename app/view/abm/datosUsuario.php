<?php
/*include_once '../../librerias/DataBase.php'*/

$conexion=mysqli_connect("127.0.0.1","root","","consorcio")
or die ("Murio tu base");
    
/*$conexion = new DataBase();*/
$email=$_POST["emailUsuario"];
$filas = $conexion->chequearCampo('usuarios', 'email', '$email');  // si falla sacar comillas

            
            if($filas == 0)
            {
                if($_POST['passUsuario'] == $_POST['passUsuario2'])
                {
                    $pass=$_POST["passUsuario"];
                    $pass_md5 = md5($pass); //hasheo de pass para que se guarde hasheada
                    $nombre=$_POST["nombreUsuario"];
                    $apellido=$_POST["apellidoUsuario"];
                    $dni=$_POST["dniUsuario"];
                    $cuilUsuario=$_POST["cuilUsuario"];
                    $telUsuario=$_POST["telUsuario"];
                    $estado='Pendiente';
                    $rol=1;

                    $insertaUsuario = "INSERT INTO usuarios (nombre, apellido, dni, cuil, telefono, email, password, estado, idRol) VALUES ('$nombre','$apellido', '$dni', '$cuilUsuario', '$telUsuario', '$email', '$pass_md5', '$estado', '$rol')";
                    
                    mysqli_query('$conexion','$insertaUsuario');
                    
                echo "Te has registrado con exito."; 
                header('location: index.php');
            }else{
                echo "Las contraseñas no coinciden.";
            }
            }else{
                echo "El correo electrónico ya fue utilizado por otro usuario, por favor prueba otro.";
            }

mysqli_close($conexion);


?>