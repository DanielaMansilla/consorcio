<?php
//session_start();
//require_once '../../librerias/Conexion.php';
/*die("Probando") ;*/

//echo 'host: '. $conexion->host;
//exit();


$host = '127.0.0.1';
     $user = 'root';
     $pass = '';
    $db = 'u';
$conexion=mysqli_connect($host,$user,$pass,$db);
                   
                    
                    $pass=$_POST["passUsuario"];
                    $pass_md5 = md5($pass); //hashe*o de pass para que se guarde hasheada
                    $nombre=$_POST["nombreUsuario"];
                    $apellido=$_POST["apellidoUsuario"];
                    $dni=$_POST["dniUsuario"];
                    $cuilUsuario=$_POST["cuilUsuario"];
                    $telUsuario=$_POST["telUsuario"];
                    $estado=1;
                    $rol=1;
                    $email=$_POST["emailUsuario"];
                    $insertaUsuario = "INSERT INTO usuarios (nombre, apellido, dni, cuil, telefono, email, pass, estado, idRol) VALUES ($nombre, $apellido, $dni, $cuilUsuario, $telUsuario, $email, $pass_md5, $estado, $rol)";
$nuevo="insert into usuarios(nombreUsuario,dni) values ('$nombre','$dni')";
$resultado=mysqli_query($conexion,$nuevo);
exit($nuevo);
mysqli_close($conexion);

$email=$_POST["emailUsuario"];
//$filas = $conexion->chequearCampo('usuarios', 'email', $email);  // si falla sacar comillas
 
            
           // if($filas == 0)
           // {
               /* if($_POST['passUsuario'] == $_POST['passUsuario2'])
                {
                    //exit($email);
                    $pass=$_POST["passUsuario"];
                    $pass_md5 = md5($pass); //hashe*o de pass para que se guarde hasheada
                    $nombre=$_POST["nombreUsuario"];
                    $apellido=$_POST["apellidoUsuario"];
                    $dni=$_POST["dniUsuario"];
                    $cuilUsuario=$_POST["cuilUsuario"];
                    $telUsuario=$_POST["telUsuario"];
                    $estado=1;
                    $rol=1;
                    $email=$_POST["emailUsuario"];
                    $insertaUsuario = "INSERT INTO usuarios (nombre, apellido, dni, cuil, telefono, email, pass, estado, idRol) VALUES ($nombre, $apellido, $dni, $cuilUsuario, $telUsuario, $email, $pass_md5, $estado, $rol)";
                    //echo $conexion->$host;
                    //exit();
                    mysqli_query($conexion,$insertaUsuario);
                    
                echo "Te has registrado con exito."; 
                header('location: ../index.php');
            }else{
                echo "Las contraseñas no coinciden.";
            }
            /*}else{
                echo "El correo electrónico ya fue utilizado por otro usuario, por favor prueba otro.";
            }*/

mysqli_close($conexion);


?>