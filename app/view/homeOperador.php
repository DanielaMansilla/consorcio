<?php
require_once '../config/Conexion.php'; 
session_start();
if(!isset($_SESSION['operador'])){
    header("Location: index.php");} ?>

<!DOCTYPE html>
<html lang="es">
<?php include('template/head.php'); ?>

    <body>
    <?php 
        include('template/nav.php');  
        include('template/header.php'); ?>
    
    <title>Consorcios del Valle - Operador</title>

    <div class="container">
    <div class="content">
    <h2>Lista de usuarios pendientes</h2>
    <hr />
        
			<br />
			<div class="table-responsive">
			<table class="table table-striped table-hover">
				<tr>
					<th>Apellido</th>
                    <th>Nombre</th>
                    <th>Cuil</th>
                    <th>E-mail</th>
                    <th>Dni</th>
					<th>Teléfono</th>
                    <th>Rol</th>
                    <th>Acciones</th>
				</tr>
				<?php
					$sql = mysqli_query($conexion, "SELECT * FROM usuarios JOIN roles ON usuarios.idRol=roles.idRoles WHERE estado='Pendiente' ORDER BY idUsuarios ASC");
				if(mysqli_num_rows($sql) == 0){
					echo '<tr><td colspan="8">No hay usuarios pendientes de habilitación.</td></tr>';
				}else{
					while($row = mysqli_fetch_assoc($sql)){
						echo '
						<tr>
                            <td><a href="perfil.php?nik='.$row['idUsuarios'].'"><span class="fas fa-user" aria-hidden="true"></span> '.$row['apellido'].'</a></td>
                            <td>'.$row['nombre'].'</td>
                            <td>'.$row['cuil'].'</td>
                            <td>'.$row['email'].'</td>
                            <td>'.$row['dni'].'</td>
							<td>'.$row['telefono'].'</td>  
                            <td>'.$row['descripcion'].'</td> 
							<td>
								<a href="abm/editarRolyEstado.php?nik='.$row['idUsuarios'].'" title="Editar datos" class="btn btn-primary btn-sm"><span class="fas fa-edit" aria-hidden="true"></span></a>
							</td>
						</tr>
						';
					}
				}
				?>
			</table>
			</div>
		</div>
	</div>         
    <div class="corte">
    </div>
    <?php include('template/footer.php'); ?>
    </body>
</html>