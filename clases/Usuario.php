<?php
include 'DataBase.php'; 
class Usuario {
	private $idUsuarios;
    private $nombre;
	private $apellido;
	private $cuil;
	private $email;
    private $dni;
	private $telefono;
	private $estado;
	private $idRol;
	private $pass;
 
	public function __construct() { // asigna valor nulo a la variable $data
		}
    
   /* public function chequearCampo($tabla, $columna, $valor){
    $query = "SELECT * FROM `$tabla` WHERE `$columna` = '$valor'";
    $sql = $this->conexion($query);
    $filas = $sql->num_rows;
    return $filas;
  }*/
    
    public function listarUsuarios()
    {
        $mysqli = new DataBase(); 
    	$consulta = "SELECT * FROM usuarios";  
        $resultado = $mysqli->query($consulta);
        $filas = $resultado->num_rows;
     
        
        if(isset($_GET['aksi']) == 'delete'){
        // escaping, additionally removing everything that could be (html/javascript-) code
        $nik =  $mysqli->real_escape_string(strip_tags($_GET["nik"],ENT_QUOTES));
        $cek = $mysqli->query("SELECT * FROM usuarios WHERE idUsuarios='$nik'");
        if($cek->num_rows == 0){
            echo '<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> No se encotraron datos.</div>';
        }else{
            $delete = $mysqli->query("DELETE FROM usuarios WHERE idUsuarios='$nik'");
            if($delete){
                echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Datos eliminado correctamente.</div>';
            }else{
                echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Error, no se pudo eliminar los datos.</div>';
            }
        }
    }
    
        if($filas == 0){
        echo '<tr><td colspan="8">No hay datos.</td></tr>';
				        }else{
        echo '
           <div class="table-responsive">
            <table class="table table-striped table-hover">
                <tr>
                    <th>Id</th>
                    <th>CUIL</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    <th>DNI</th>
                    <th>Teléfono</th>
                    <th>Estado</th>
                    <th>Id rol</th>
                </tr>
        ';
        while($row = $resultado->fetch_assoc()){
           echo '  
                <tr>
                    <td>'.$row['idUsuarios'].'</td>
                    <td>'.$row['cuil'].'</td>
                    <td>'.$row['nombre'].'</td>
                    <td>'.$row['apellido'].'</td>
                    <td>'.$row['email'].'</td>
                    <td>'.$row['dni'].'</td>
                    <td>'.$row['telefono'].'</td>
                    <td>'.$row['estado'].'</td>
                    <td>'.$row['idRol'].'</td>
                    <td>
                       <a href="../datalayer/editarUsuarios.php?nik='.$row['idUsuarios'].'" title="Editar datos" class="btn btn-primary btn-sm"><span class="fas fa-edit" aria-hidden="true"></span></a>
                       
                        <a href="../datalayer/listaUsuarios.php?aksi=delete&nik='.$row['idUsuarios'].'" title="Eliminar" onclick="return confirm(\'Esta seguro de borrar los datos del Usuario '.$row['nombre'].' con CUIL '.$row['cuil'].' con Apellido '.$row['apellido']. ' con Email '.$row['email']. ' DNI '. $row['dni']. ' con Teléfono ' .$row['telefono'] . 'con estado ' .$row['estado'] . 'con Id rol ' .$row['idRol'].'?\')" class="btn btn-danger btn-sm"><span class="fas fa-trash" aria-hidden="true"></span></a>
                    </td>
                </tr>';         
            }
        echo    '
            </table>   
        </div>';
          
        }
    }
    
    public function editarUsuarios()
    {   
            $mysqli2 = new DataBase(); 
        
			// escaping, additionally removing everything that could be (html/javascript-) code
			$nik = $mysqli2->real_escape_string(strip_tags($_GET["nik"],ENT_QUOTES));
			$sql = $mysqli2->query("SELECT * FROM usuarios WHERE idUsuarios='$nik'");
			if($sql->num_rows == 0){
				header("Location: ../datalayer/listaUsuarios.php");
			}else{
				$row = $sql->fetch_assoc();
			}
			if(isset($_POST['save'])){
                $nombre = $mysqli2->real_escape_string(strip_tags($_POST["nombre"],ENT_QUOTES));//Escanpando caracteres 
                $apellido = $mysqli2->real_escape_string(strip_tags($_POST["apellido"],ENT_QUOTES));//Escanpando caracteres 
				 $cuil = $mysqli2->real_escape_string(strip_tags($_POST["cuil"],ENT_QUOTES));//Escanpando caracteres 
                $email = $mysqli2->real_escape_string(strip_tags($_POST["email"],ENT_QUOTES));//Escanpando caracteres 
                 $dni = $mysqli2->real_escape_string(strip_tags($_POST["dni"],ENT_QUOTES));//Escanpando caracteres 
                $telefono = $mysqli2->real_escape_string(strip_tags($_POST["telefono"],ENT_QUOTES));//Escanpando caracteres 
                 $estado = $mysqli2->real_escape_string(strip_tags($_POST["estado"],ENT_QUOTES));//Escanpando caracteres 
                $idRol = $mysqli2->real_escape_string(strip_tags($_POST["idRol"],ENT_QUOTES));//Escanpando caracteres 


				$update = $mysqli2->query("UPDATE usuarios SET  nombre='$nombre',apellido='$apellido', cuil='$cuil', email='$email' , dni='$dni', telefono='$telefono', estado='$estado', idRol='$idRol' WHERE idUsuarios='$nik'") or die($mysqli2->connect_errno);
				if($update){
					header("Location: ../datalayer/editarUsuarios.php?nik=".$nik."&pesan=sukses");
				}else{
					echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error, no se pudo guardar los datos.</div>';
				}
			}
			
			if(isset($_GET['pesan']) == 'sukses'){
				echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Los datos han sido guardados con éxito.</div>';
			}
            
        echo '<form class="form-horizontal" action="" method="post">
            <div class="form-group">
                <label class="col-sm-3 control-label">Nombre:</label>
                <div class="col-sm-4">
                    <input type="text" name="nombre" value="'.$row['nombre'].'" class="form-control" placeholder="nombre" required>
                </div>
            </div>
                <div class="form-group">
					<label class="col-sm-3 control-label">Apellido:</label>
					<div class="col-sm-4">
						<input type="text" name="apellido" value="'.$row['apellido'].'" class="form-control" placeholder="apellido" required>
					</div>
				</div>
				<div class="form-group">
                <label class="col-sm-3 control-label">CUIL:</label>
                <div class="col-sm-4">
                    <input type="text" name="cuil" value="'.$row['cuil'].'" class="form-control" placeholder="cuil" required>
                </div>
            </div>
                <div class="form-group">
					<label class="col-sm-3 control-label">Email:</label>
					<div class="col-sm-4">
						<input type="text" name="email" value="'.$row['email'].'" class="form-control" placeholder="email" required>
					</div>
				</div>
				<div class="form-group">
                <label class="col-sm-3 control-label">DNI:</label>
                <div class="col-sm-4">
                    <input type="text" name="dni" value="'.$row['dni'].'" class="form-control" placeholder="dni" required>
                </div>
            </div>
                <div class="form-group">
					<label class="col-sm-3 control-label">Teléfono:</label>
					<div class="col-sm-4">
						<input type="text" name="telefono" value="'.$row['telefono'].'" class="form-control" placeholder="telefono" required>
					</div>
				</div>

				<div class="form-group">
                <label class="col-sm-3 control-label">Estado:</label>
                <div class="col-sm-4">
                    <input type="text" name="estado" value="'.$row['estado'].'" class="form-control" placeholder="estado" required>
                </div>
            </div>
                <div class="form-group">
					<label class="col-sm-3 control-label">Id Rol:</label>
					<div class="col-sm-4">
						<input type="text" name="idRol" value="'.$row['idRol'].'" class="form-control" placeholder="idRol" required>
					</div>
				</div>





				<div class="form-group">
					<label class="col-sm-3 control-label">&nbsp;</label>
					<div class="col-sm-6">
						<input type="submit" name="save" class="btn btn-sm btn-primary" value="Guardar datos">
						<a href="../datalayer/listaUsuarios.php" class="btn btn-sm btn-danger">Cancelar</a>
					</div>
				</div>
			</form>';
        }
}
?>