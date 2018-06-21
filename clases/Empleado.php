<?php 

class Empleado extends model
{

private $_id;
private $_nombre;
private $_apellido;
private $_tipoDocumento;
private $_numeroDocumento;
private $_telefono;
//private $_idUsuario;

public function __construct($nombre ,$apellido, $tipoDocumento,$numeroDocumento,$telefono ,$id=null){
	
	$this->_nombre=$nombre;
	$this->_apellido=$apellido;
	$this->_tipoDocumento=$tipoDocumento;
	$this->_telefono=$telefono;
}


		public function save (){
			
			if( is_null($this->id)
			{
				_insert();		
			}
		else
			{
			  _update();
			}
		}
}

?>