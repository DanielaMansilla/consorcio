<?php
require_once '../config/Conexion.php'; 
session_start();
// Permisos
if(!isset($_SESSION['admin'])){
	if(!isset($_SESSION['operador'])){
		header("Location: ../index.php");}} ?>

<!DOCTYPE html>
<html lang="es">
<?php include('template/head.php'); ?>

    <body>
    <?php 
        include('template/nav.php');  
        include('template/header.php'); ?>

		<title>Consorcios del Valle - Lista de Proveedores</title>

        <div class="container">
		<div class="content">
			<h2>Lista de proveedores</h2>
			<hr />

			<?php
			if(isset($_GET['aksi']) == 'delete'){
				// escaping, additionally removing everything that could be (html/javascript-) code
				$nik = mysqli_real_escape_string($conexion,(strip_tags($_GET["nik"],ENT_QUOTES)));
				$cek = mysqli_query($conexion, "SELECT * FROM proveedor WHERE idProveedor='$nik'");
				if(mysqli_num_rows($cek) == 0){
					echo '<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> No se encotraron datos.</div>';
				}else{
					$delete = mysqli_query($conexion, "DELETE FROM proveedor WHERE idProveedor='$nik'");
					if($delete){
						echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Datos eliminado correctamente.</div>';
					}else{
						echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Error, no se pudo eliminar los datos.</div>';
					}
				}
			}
			?>

			<br />
			<div class="table-responsive">
			<table class="table table-striped table-hover">
				<tr>
                    <!--<th>No</th> -->
					<th>Id</th>
                    <th>CUIT</th>
                    <th>Nombre</th>
                    <th style="text-align:center;">Acciones</th>
				</tr>
				<?php
					$sql = mysqli_query($conexion, "SELECT * FROM proveedor ORDER BY idProveedor ASC");
				if(mysqli_num_rows($sql) == 0){
					echo '<tr><td colspan="8">No hay datos.</td></tr>';
				}else{
					//$no = 1;
					while($row = mysqli_fetch_assoc($sql)){
                        /* <td>'.$no.'</td> encima del $row */
                        /* Falta linkear unir las tablas idRol para que muestre nombre del rol */
						echo '
						<tr>
                            <td>'.$row['idProveedor'].'</td>
                            <td>'.$row['cuit'].'</td>
                            <td>'.$row['nombre'].'</td>';
                            
                            if(isset($_SESSION['admin'])){
								echo '
							</td>
							<td>
								<a href="abm/editarProveedor.php?nik='.$row['idProveedor'].'" title="Editar datos" class="btn btn-primary btn-sm"><span class="fas fa-edit" aria-hidden="true"></span></a>
								<a href="listaProveedor.php?aksi=delete&nik='.$row['idProveedor'].'" title="Eliminar" onclick="return confirm(\'Esta seguro de borrar los datos '.$row['nombre'].' con CUIT '.$row['cuit'].'?\')" class="btn btn-danger btn-sm"><span class="fas fa-trash" aria-hidden="true"></span></a>
							</td>
						</tr>
						';
						//$no++;
							}if(isset($_SESSION['operador'])){//verificar si el operador necesita este permiso.
								echo '
							</td>
							<td>
								<a href="abm/editarProveedor.php?nik='.$row['idProveedor'].'" title="Editar datos" class="btn btn-primary btn-sm btn-block"><span class="fas fa-edit" aria-hidden="true"></span></a>
							</td>
						</tr>
						';
						//$no++;
							}
					}
				}
				?>
			</table>
			</div>
		</div>
	</div><center>
	
    <div class="corte">
    </div>
    <?php include('template/footer.php'); ?>
    </body>

</html>