<!DOCTYPE html>
<html>

<?php 
    include('template/head.php');   
    include ('template/header.php'); ?>  
    <body>
        <main>      
            <div class="card">
                <h3 class="card-header">Iniciar sesión</h3>
                    <div class="fondoindex"> 
                        <div class="card-body">  
                            <div class="indexizq">
                                <form class="form-control"  action='abm/datosLogin.php' method='POST' ENCTYPE="application/x-www-form-urlencoded">
                                    <p class="card-text">Dirección de Correo Electrónico: </p> <INPUT class="input-group-lg"  name="emailUsuario" type="text"  value="ejemplo@ejemplo.com"><small id="emailHelp" class="form-text text-muted">Nunca compartiremos su correo electrónico con nadie.</small>
                                    <br>
                                    <p class="card-text">Contraseña: </p><INPUT class="input-group-lg" name="passUsuario" type="password">
                                    <br><br>
                                    <input class="btn btn-outline-dark" type="submit" value="Iniciar Sesión">
                                    <input class="btn btn-dark" type="button" value="Registrarme" onClick="window.location = 'registro.php';">      
                                </form>
                            </div>
                            <div class="medioindex">
                                <div class="alert alert-primary" role="alert">
                                Para más información acerca de propiedades de Consorcios del Valle, comuníquese al 0800-555-1234.
                                </div>
                            </div>
                            <div class="indexder">
                              <img class="fotoindex" src="../../public/img/logo.jpg">
                            </div>  
                        </div>          
                    </div>
            </div>  
        </main> 
        <div class="corte">
        </div>
        <?php include('template/footer.php'); ?>
    </body>
       
</html>