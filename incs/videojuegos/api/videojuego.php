<?php

$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/incs/db.php";
include_once($path);

class Videojuego extends db{
    
    function obtenerVideojuegos(){
      $query = $this->connect()->query('SELECT * FROM juegos');
      return $query;
    }

    function obtenerVideojuego($id){
      $query = $this->connect()->prepare('SELECT * FROM juegos WHERE id= :id');
      $query->execute(['id' => $id]);
      return $query;
    }

    function nuevoVideojuego($videojuego){
      $query = $this->connect()->prepare('INSERT INTO juegos (nombre, descripcion, desarrolladora, fecha, portada) VALUES (:nombre, :descripcion, :desarrolladora, :fecha, :portada)');
      $query->execute(['nombre' => $videojuego['nombre'], 'descripcion' => $videojuego['descripcion'], 'desarrolladora' => $videojuego['desarrolladora'], 'fecha' => $videojuego['fecha'], 'portada' => $videojuego['portada'] ]);
      return $query;
    }

}

?>