<?php
// Requerimos el archivo modelos.php
require_once 'modelos.php';

// Si hay en parámetro tabla
if(isset($_GET['tabla'])) {// Si esta seteado el parametro tabla
  $tabla = new Modelo ($_GET['tabla']); // Creamos el objeto tabla 

  // Si hay parametro id
  if(isset($_GET['id'])){
    $tabla->setCriterio("id=". $_GET ['id']);
  }

  $datos = $tabla->seleccionar(); // Ejecutamos el metodo seleccionar 
  echo $datos; // Mostramos los datos 
}
?>