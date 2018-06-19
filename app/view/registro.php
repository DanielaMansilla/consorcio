<?php
require_once '../config/Conexion.php'; 
session_start();
// poner permiso tambien para operador y propietario
if(isset($_SESSION['admin'])){
    header("Location: home.php");} ?>
<!DOCTYPE html>
<html>
<?php 
    include('template/head.php');   
    include('template/header.php');

    if(isset($_POST['enviar'])){
        $error = array();
        $nombre=$_POST["nombreUsuario"];
        $apellido=$_POST["apellidoUsuario"];
        $cuilUsuario=$_POST["cuilUsuario"];
        $email=$_POST["emailUsuario"];
        $dni=$_POST["dniUsuario"];
        $telUsuario=$_POST["telUsuario"];
        $estado = "Pendiente";
        $rol=1;
        $pass=$_POST["passUsuario"];
        $pass2=$_POST["passUsuario2"];
        $pass_sha1 = sha1($pass); //Guarda el pass hasheado

        // Luego revisar los limites con la base de datos.
        if(!(ctype_alpha($nombre) && strlen($nombre) >= 3 && strlen($nombre) <= 20)){
            $error[] = "Nombre debe tener al menos 3 caracteres, solo alfabeticos";
          }        
        
        if(!(ctype_alpha($apellido) && strlen($apellido) >= 3 && strlen($apellido) <= 20)){
            $error[] = "Apellido debe tener al menos 3 caracteres, solo alfabeticos";
          }
        //Verificar validaciones de dni, cuil, teléfono.
        if(!(strlen($cuilUsuario) == 11)){
            $error[] = "Cuil debe tener 11 digitos sin guiones.";
          }
        if(!(strlen($dni) == 8)){
            $error[] = "Dni debe tener 8 digitos sin guiones.";
          }
        if(!(strlen($telUsuario) >= 8 && strlen($telUsuario) <= 10)){
            $error[] = "Teléfono debe tener entre 8 y 10 digitos sin guiones.";
          }
        //Separador
        if(!(filter_var($email, FILTER_VALIDATE_EMAIL))){
            $error[] = "Email incorrecto";
          }else{
            $sql = "SELECT * from usuarios where email='$email'";
            $result = mysqli_query($conexion,$sql);

            if($row = mysqli_fetch_array($result)){
                if($row['email'] == $email){
              $error[] = "El email de '$email' se encuentra en uso";
            }
          }
        }
          if(!(strlen($pass) >= 6 && strlen($pass) <= 32 && $pass == $pass2)){
            $error[] = "Password debe tener al menos 6 caracteres y coincidir entre sí.";
          }

          if(sizeof($error) == 0){
            $insertarUsuario = "INSERT INTO usuarios(nombre, apellido, cuil, email, dni, telefono,estado,idRol,pass) VALUES ('$nombre', '$apellido', '$cuilUsuario','$email','$dni', '$telUsuario','$estado', '$rol', '$pass_sha1')";
    
            $resultado=mysqli_query($conexion,$insertarUsuario);
            
            mysqli_close($conexion); 
            }else{
                echo "Ocurrio un error en los siguientes campos: ";
                foreach($error as $er){
                    echo "</br><strong>$er</strong>";
                  }
                }
            } ?>   
  <body>   
    <main> 
        <div class="card">
            <h3 class="card-header">Solicitud de Registro de Usuario</h3>
                    <form class="form-control" action='' method='POST' ENCTYPE="application/x-www-form-urlencoded">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                     <p class="card-text">Nombre: </p> <INPUT class="form-control" name="nombreUsuario" type="text" required><br>
                                </div>
                                 <div class="form-group col-md-6">
                                    <p class="card-text">Apellido: </p> <INPUT class="form-control" name="apellidoUsuario" type="text" required><br>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <p class="card-text">DNI: </p> <INPUT class="form-control" name="dniUsuario" type="number" required>
                                    <small id="emailHelp" class="form-text text-muted">Solo ingresar números, sin letras ni caracteres especiales.</small>
                                    <br>
                                </div>
                                <div class="form-group col-md-6">
                                 <p class="card-text">CUIL: </p> <INPUT class="form-control" name="cuilUsuario" type="number" required>
                                <small id="emailHelp" class="form-text text-muted">Solo ingresar números, sin letras ni caracteres especiales.</small>
                                <br>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <p class="card-text">Teléfono: </p> <INPUT class="form-control" name="telUsuario" type="number" required>
                                    <small id="emailHelp" class="form-text text-muted">Solo ingresar números, sin letras ni caracteres especiales. Si es celular, recuerde anteponer el 15.</small>
                                    <br>
                                </div>
                                <div class="form-group col-md-6">
                                    <p class="card-text">Dirección de Correo Electrónico: </p> <INPUT class="form-control"  name="emailUsuario" type="text"  placeholder="ejemplo@ejemplo.com" required><small id="emailHelp" class="form-text text-muted">Nunca compartiremos su correo electrónico con nadie.</small>
                                    <br>
                                </div>
                           </div>
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
                                <input class="btn btn-dark" type="button" value="Ya estoy registrado" onClick="window.location = 'index.php';">  
                            </div>
                        </div>  
                </form>
                </div>      
    </main> 

<!--EJEMPLO DE SI ESTA DENTRO DEL APP/WIEV-->
        <div class="corte"></div>
        <?php include('template/footer.php'); ?>
  </body>
</html>