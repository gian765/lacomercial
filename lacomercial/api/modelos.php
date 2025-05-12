<?php 
require_once 'config.php';  //  Requerimos config.php
/**
 * Clase que nos permite conectarnos a la BD
 */
class Conexion {
   protected $db;   //propiedad para la conexion a la BD
   //   Metodo constructor
   public function __construct() {
    //  Guardamos en la propiedad $db la conexion de la BD
    $this->db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    //  Si se produce un error de conexion, muestra el error
    if($this->db->connect_errno) {
        echo 'Fallo al conectar MySQL:  ' . $this->db->connect_error;
        return;
    }
    //  Establecer el conjunto de caracteres utf8
    $this->db->set_charset(DB_CHARSET);
    $this->db->query("set NAMES 'utf8' ");

   }



}

/**
 *  Clase Modelo basada en la clase Conexion
 */
Class Modelo extends Conexion{
    //Propiedades
    private $tabla ; // Nombre de la trabla
    private $id = 0 ; // id del registro
    private $criterio = '' ; // Criterio para las consultas
    private $campos = '*' ; //  Lista de campos
    private $orden = 'id' ; // Campos en ordenamiento
    private $limite = 0 ; //  cantidad de registros

public function __construct($tabla) {
    parent::__construct();  // Ejecuta el constructor padre
    $this->tabla = $tabla;  // Guardamos en la propiedad tabla el valor de la variable del argumento $tabla
}

// Métodos Getter y Setter 
public function getId(){
    return $this->id;

}
public function setId($id){
    $this->id = $id;
}
public function getCriterio(){
    return $this->criterio;

}
public function setCriterio($criterio){
    $this->criterio = $criterio;
}
public function getCampos(){
    return $this->campos;

}
public function setCampos($campos){
    $this->campos = $campos;
}
public function getOrden(){
    return $this->orden;

}
public function setOrden($orden){
    $this->orden = $orden;
}
public function getLimite(){
    return $this->limite;

}
public function setLimite($limite){
    $this->limite = $limite;
}
/**
 * Métodos de selección 
 * Permite seleccionar resgitros de una tabla de BD
 * @return datos
 */
    public function seleccionar() {
        //SELECT * FROM productos WHERE id = '10' ORDER BY id LIMIT 10
        $sql = "SELECT $this->campos FROM $this->tabla";
        //Si hay un criterio lo agregamos
        if($this->criterio != ''){
            $sql .= " WHERE $this->criterio";
        }
        // Agregamos el Orden
        $sql .= " ORDER BY $this->orden";
        // Si el $limite es > que 0; agregamos el limite 
        if($this->limite > 0){
            $sql .= " LIMIT $this->limite";
        }
    
        //echo $sql; // Mostramos la instruccion SQL

        //Ejecutamos la instruccion SQL
        $resultado = $this->db->query($sql);
        $datos = $resultado->fetch_all(MYSQLI_ASSOC); //Guardamos los datos en un array asociativo
        $datos = json_encode($datos); // COnvertimos los datos a JSON

        //Devolvemos los datos
        return $datos; 
    }
    /**
     * metodo de insercion
     * permite insertar un registro en la BD
     * @param datos
     */
    public function insertar ($datos) {
        // INSERT INTO productos (codigo, nombre, descripcion, precio, stock, imagen)
        // values ('201','motorola G9','Un gran telefono', '45000', '10', 'motorola.jpg')
        unset($datos->id); // Eliminamos el valor del id
        $campos = implode(",", array_keys($datos)); // separamos las claves del array
        $valores = implode ("','", array_values($datos)); // separamos los valores del array

        //  Guardamos en la variable $sql la instruccion INSERT
        $sql = "INSERT INTO $this->tabla($campos) VALUES($valores)";
        echo $sql."<br>"; // mostramos la unstruccion SQL resultante
        $this->db->query($sql); // ejecutamos la instruccion SQL
    }
}


?>