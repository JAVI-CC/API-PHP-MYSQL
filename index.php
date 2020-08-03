<?php 

$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/incs/videojuegos/api/apivideojuegos.php";
include_once($path);

$api = new apivideojuegos();

if(isset($_GET['id'])){
  $id = $_GET['id'];

  if(is_numeric($id)) {
    $api->getById($id);
  } else {
    $api->error('Los parametros son incorrectos');
  }

} else {
  $api->getAll();
}

?>