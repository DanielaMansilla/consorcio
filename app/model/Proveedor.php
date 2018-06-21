<?php
include '../librerias/DataBase.php'; 
class Proveedor {
	private $idProveedor;
    private $cuit;
	private $nombre;
 
	public function __construct() { // asigna valor nulo a la variable $data
		}
    
   /* public function chequearCampo($tabla, $columna, $valor){
    $query = "SELECT * FROM `$tabla` WHERE `$columna` = '$valor'";
    $sql = $this->conexion($query);
    $filas = $sql->num_rows;
    return $filas;
  }*/
    
    public function listarProveedores()
    {
        $mysqli = new DataBase(); 
    	$consulta = "SELECT * FROM proveedor";  
        $resultado = $mysqli->query($consulta);
        $filas = $resultado->num_rows;
     
        
        if(isset($_GET['aksi']) == 'delete'){
        // escaping, additionally removing everything that could be (html/javascript-) code
        $nik =  $mysqli->real_escape_string(strip_tags($_GET["nik"],ENT_QUOTES));
        $cek = $mysqli->query("SELECT * FROM proveedor WHERE idProveedor='$nik'");
        if($cek->num_rows == 0){
            echo '<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> No se encotraron datos.</div>';
        }else{
            $delete = $mysqli->query("DELETE FROM proveedor WHERE idProveedor='$nik'");
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
                    <th>CUIT</th>
                    <th>Nombre</th>
                    <th>Accion</th>
                </tr>
        ';
        while($row = $resultado->fetch_assoc()){
           echo '  
                <tr>
                    <td>'.$row['idProveedor'].'</td>
                    <td>'.$row['cuit'].'</td>
                    <td>'.$row['nombre'].'</td>
                    <td>
                       <a href="../view/abm/editarProveedor.php?nik='.$row['idProveedor'].'" title="Editar datos" class="btn btn-primary btn-sm"><span class="fas fa-edit" aria-hidden="true"></span></a>
                       
                        <a href="../view/listaProveedores.php?aksi=delete&nik='.$row['idProveedor'].'" title="Eliminar" 
                        onclick="return confirm(\'Esta seguro de borrar los datos del Proveedor '.$row['nombre'].' con CUIT '
                            .$row['cuit'].'?\')" class="btn btn-danger btn-sm"><span class="fas fa-trash" aria-hidden="true"></span></a>
                    </td>
                </tr>';         
            }
        echo    '
            </table>   
        </div>';
          
        }
    }
    
    public function editarProveedores()
    {   
            $mysqli2 = new DataBase(); 
        
			// escaping, additionally removing everything that could be (html/javascript-) code
			$nik = $mysqli2->real_escape_string(strip_tags($_GET["nik"],ENT_QUOTES));
			$sql = $mysqli2->query("SELECT * FROM proveedor WHERE idProveedor='$nik'");
			if($sql->num_rows == 0){
				header("Location: ../view/listaProveedores.php");
			}else{
				$row = $sql->fetch_assoc();
			}
			if(isset($_POST['save'])){
                $cuit = $mysqli2->real_escape_string(strip_tags($_POST["cuit"],ENT_QUOTES));//Escanpando caracteres 
                $nombre = $mysqli2->real_escape_string(strip_tags($_POST["nombre"],ENT_QUOTES));//Escanpando caracteres 
				
				$update = $mysqli2->query("UPDATE proveedor SET cuit='$cuit', nombre='$nombre' WHERE idProveedor='$nik'") or die($mysqli2->connect_errno);
				if($update){
					header("Location: ../view/editar.php?nik=".$nik."&pesan=sukses");
				}else{
					echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error, no se pudo guardar los datos.</div>';
				}
			}
			
			if(isset($_GET['pesan']) == 'sukses'){
				echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Los datos han sido guardados con éxito.</div>';
			}
            
        echo '<form class="form-horizontal" action="" method="post">
            <div class="form-group">
                <label class="col-sm-3 control-label">CUIT:</label>
                <div class="col-sm-4">
                    <input type="text" name="cuit" value="'.$row['cuit'].'" class="form-control" placeholder="cuit" required>
                </div>
            </div>
                <div class="form-group">
					<label class="col-sm-3 control-label">Nombre:</label>
					<div class="col-sm-4">
						<input type="text" name="nombre" value="'.$row['nombre'].'" class="form-control" placeholder="Nombre" required>
					</div>
				</div>			
				<div class="form-group">
					<label class="col-sm-3 control-label">&nbsp;</label>
					<div class="col-sm-6">
						<input type="submit" name="save" class="btn btn-sm btn-primary" value="Guardar datos">
						<a href="../view/listaProveedor.php" class="btn btn-sm btn-danger">Cancelar</a>
					</div>
				</div>
			</form>';
        }
}

?>