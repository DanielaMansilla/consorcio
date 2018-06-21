<?php

abstract class Model
{

    CONST DB_HOST = "127.0.0.1";//192.168.10.10
    CONST DB_NAME = "consorcio";//"ViajesPepe"
    CONST DB_USER = "root";//"fakux"
    CONST DB_PASSWORD = "";//"123"

    protected $_db;


    protected function __construct()
    {
        $this->_connect();
    }


    /**
    * Ejecuta una consulta en la base de datos y retorna información
    * Notas:
    * trim sive para limpiar espacios en blanco al principio y al final de la cadena ( String )
    * strtolower sirve para pasar una cadena a minuscula
    **/
    protected function query($query)
    {
        // AGARRO LA PRIMERA PALABRA DE LA LA QUERY: SELECT / UPDATE / DELETE
        $type = explode(" ", trim($query) );//ecplode() convierte un string en array, conta los elementos desde los espacio, de esta manera quita los espacios con strim() sive para limpiar espacios en blanco al principio y al final de la cadena ( String )
        // DEPENDE DE CUAL SEA LA PRIMERA PALABRA HAGO ALGO DISTINTO....
        switch ( strtolower($type[0]) ){  // strtolower sirve para pasar una cadena a minuscula
            case 'select':
                return $this->_select($query);
                break;
            case 'update':
                return $this->_update($query);
                break;
            case 'delete':
                return $this->_delete($query);
                break;
        }
    }
    //@param sirve para indicar tipo y variable que van a pasar por paramtro del método,ej: @param $query String

    /**
    * Si la consulta es un select, ejecuta la query y devuelve un array.
    * @param $query String
    * @return $res  Array | Boolean
    **/
    /*echo, print, print_r y var_dump estas funciones imprimen cadena de texto por pantalla.
    .echo y print utilizar para imprimir texto en general 
    .print_r y var_dump para imprimir información de variables. */
    private function _select($query)
    {
        var_dump($query);
        $res = $this->_execQuery($query);

        if ( !$res )
            return false;


        while( $row = $res->fetch_object() ) {
            $return[] = $row;
        }

        return $return;
    }

    /**
    * Si la consulta es un insert, guardo el campo y devuelvo el id del registro ingresado.
    * @param $query String
    * @return $res  Boolean | int
    **/
    private function _insert($query)
    {
        $res = $this->_execQuery($query);
        if( !$res )
            return false;

        return $res->insert_id;
    }

    /**
    * Si la consulta es un delete, devuelvo verdadero o falso dependiendo la respuesta.
    * @param $query String
    * @return $res  Boolean
    **/
    private function _delete($query)
    {
        $res = $this->_execQuery($query);
        if ( !$res )
            return false;

        return true;
    }

    /**
    * Ejecuto la query
    * @param $query String
    * @return $res  Object
    **/
    private function _execQuery($query)
    {
        // SANITIZAR QUERY
        // https://diego.com.es/ataques-sql-injection-en-php  ----> explicacion de q trata injeccion SQL
        // http://php.net/manual/en/filter.filters.sanitize.php --> posible solucion para limpiar la cadena!
        $this->_connect();
        $res = $this->_db->query($query);
        $this->_close();
        return $res;
    }

    private function _connect()
    {                               //self:: es para acceder a una constante o método estático desde dentro de la clase
        $this->_db = mysqli_connect( self::DB_HOST, self::DB_USER, self::DB_PASSWORD, self::DB_NAME );
    }

    private function _close()
    {
        $this->_db->close();
    }

}
