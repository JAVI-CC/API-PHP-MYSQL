<?php

$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/incs/videojuegos/api/apivideojuegos.php";
include_once($path);

$api = new apivideojuegos();

if (isset($_POST['nombre']) && isset($_POST['desarrolladora']) && isset($_POST['descripcion']) && isset($_POST['fecha']) && isset($_FILES['portada'])) {
  if ($api->subirImagen($_FILES['portada'])) {
    //Insertar datos
    $item = array(
      'nombre' => $_POST['nombre'],
      'descripcion' => $_POST['descripcion'],
      'desarrolladora' => $_POST['desarrolladora'],
      'fecha' => $_POST['fecha'],
      'portada' => $api->getImagen()
    );
    $api->add($item);
  } else {
    $api->error('Error con el archivo: ' . $api->getError());
  }
} else {
  $api->error('Error al llamar a la API');
}

?>