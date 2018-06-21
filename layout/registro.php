
<!DOCTYPE html>
<html>
<?php 
   session_start();
    include('../template/head.php');   
    include ('../template/header.php');
    ?>   
  <body>   
    <main> 
        <div class="card">
            <h3 class="card-header">Solicitud de Registro de Usuario</h3>
                    <form class="form-control" action='../datalayer/datosUsuario.php' method='POST' ENCTYPE="application/x-www-form-urlencoded">
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
                                    <p class="card-text">Dirección de Correo Electrónico: </p> <INPUT class="form-control"  name="emailUsuario" type="text"  value="ejemplo@ejemplo.com" required><small id="emailHelp" class="form-text text-muted">Nunca compartiremos su correo electrónico con nadie.</small>
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
                               <input class="btn btn-outline-dark" type="submit" value="Enviar Solicitud">
                                <input class="btn btn-dark" type="button" value="Ya estoy registrado" onClick="window.location = '../index.php';">  
                            </div>
                        </div>  
                </form>
                </div>      
    </main> 

<!--EJEMPLO DE SI ESTA DENTRO DEL APP/WIEV-->
        <div class="corte"></div>
        <?php include('../template/footer.php'); ?>
  </body>
</html>