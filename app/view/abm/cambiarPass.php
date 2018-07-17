<?php
require_once '../../config/Conexion.php';
session_start();
if(!isset($_SESSION['primeraVez'])){ 
    header("Location: index.php");} ?>

<!DOCTYPE html>
<html lang="es">
<?php include('../template/head.php'); ?>

    <body>
    <?php 
        include('../template/header.php'); ?>
    
    <title>Consorcios del Valle - Cambiar Contraseña</title>
    <br>
    <h3 class="card-header">Cambio de Contraseña</h3>

<?php
    if(isset($_POST['enviar'])){
    $pass=$_POST["passUsuario"];
    $pass2=$_POST["passUsuario2"];
    $pass_sha1 = sha1($pass);
    $primeraVez=0;

    if(!(strlen($pass) >= 6 && strlen($pass) <= 32 && $pass == $pass2)){
            echo "Password debe tener al menos 6 caracteres y coincidir entre sí.";
          }else{
            $usuario = $_SESSION['primeraVez'];
            $cambiarPassUsuario = "UPDATE usuarios SET primeraVez=$primeraVez WHERE email='$usuario'";
            $cambiarPassUsuario2 = "UPDATE usuarios SET pass='$pass_sha1' WHERE email='$usuario'";
            $resultado=mysqli_query($conexion,$cambiarPassUsuario);
            $resultado=mysqli_query($conexion,$cambiarPassUsuario2);
            mysqli_close($conexion);

            echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Bien hecho! Cambiaste tu password con éxito.</div>';
            echo'<a href="../index.php" class="btn btn-sm btn-success">Volver al Inicio</a>';
            //header("Location: ../index.php");
          }
    }?> 

    <form class="form-control" action='' method='POST' ENCTYPE="application/x-www-form-urlencoded">
        <div class="form-row">
            <div class="form-group col-md-6">
                <p class="card-text">Contraseña: </p><INPUT class="form-control" name="passUsuario" type="password" required>
                <br>
            </div>
            <div class="form-group col-md-6">
                <p class="card-text">Ingrese nuevamente la contraseña: </p><INPUT class="form-control" name="passUsuario2" type="password" required>
                <br>
            </div>
        </div> 

        <div class="form-row">
            <div class="form-group col-md-6">
                <input class="btn btn-outline-dark" type="submit" value="Enviar Solicitud" name="enviar">
            </div>
        </div>  
    </form>

    <div class="corte">
    </div>
    <?php include('../template/footer.php'); ?>
    </body>
</html>