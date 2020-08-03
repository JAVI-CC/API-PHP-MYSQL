<?php

include_once 'videojuego.php';

  class apivideojuegos {

    private $portada;
    private $error;

    function getAll() {
        $videojuego = new Videojuego();
        $videojuegos = array();
        $videojuegos["items"] = array();

        $res = $videojuego->obtenerVideojuegos();

        if($res->rowCount()){
         
          while($row = $res->fetch(PDO::FETCH_ASSOC)){
            $item = array(
                'id' => $row['id'],
                'nombre' => $row['nombre'],
                'descripcion' => $row['descripcion'],
                'desarrolladora' => $row['desarrolladora'],
                'fecha' => $row['fecha'],
                'portada' => $row['portada']
            );
            array_push($videojuegos["items"], $item);
          }

          $this->printJSON($videojuegos);

        } else {
          $this->error('No hay elementos registrados');
        }
    }//Function getAll

    function getById($id) {
        $videojuego = new Videojuego();
        $videojuegos = array();
        $videojuegos["items"] = array();

        $res = $videojuego->obtenerVideojuego($id);

        if($res->rowCount() >= 1){
          $row = $res->fetch();
          $item = array(
            'id' => $row['id'],
            'nombre' => $row['nombre'],
            'descripcion' => $row['descripcion'],
            'desarrolladora' => $row['desarrolladora'],
            'fecha' => $row['fecha'],
            'portada' => $row['portada']
          );

          array_push($videojuegos["items"], $item);

          $this->printJSON($videojuegos);

        } else {
          $this->error('No hay elementos registrados');
        }
    }//Function getAll

    function add($item){
      $videojuego = new Videojuego();
      $res = $videojuego->nuevoVideojuego($item);
      $this->exito('Nuevo videojuego registrado');

    }//Function add

    function exito($array){
      echo '<code>' . json_encode(array($array), JSON_UNESCAPED_UNICODE)  . '</code>';
    }//Function exito

    function error($mensaje) {
        echo '<code>' . json_encode(array('mensaje' => $mensaje)) . '</code>';
    }//Function error

    function printJSON($array){
      echo '<code>' . json_encode(array($array)) . '</code>';
    }//Function printJSON

    function subirImagen($file){
      $directorio = "../../images/covers/";

      $nombre_archivo_md5 = md5(basename($file["name"]));
      $this->portada = $nombre_archivo_md5;
      $archivo = $directorio . '' . $nombre_archivo_md5 . '.jpg';

      $tipoArchivo = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));
  
      // valida que es imagen
      $checarSiImagen = getimagesize($file["tmp_name"]);

      if($checarSiImagen != false){
        //validar tipo de imagen
        if($tipoArchivo == "jpg") {
          // se validó el archivo correctamente
          if(move_uploaded_file($file["tmp_name"], $archivo)){
            //echo "El archivo se subió correctamente";
            return true;
          }else{
            $this->error = "Hubo un error en la subida del archivo";
            return false;
          }
        }else{
          $this->error = "Solo se admiten archivos jpg";
          return false;
        }
          
      }else{
          $this->error = "El documento no es una imagen";
          return false;
      }
    }//Function SubirImagen

    function getImagen(){
      return $this->portada;
    }//Function getImagen

    function getError(){
      return $this->error;
    }//Function getError



}//Class apivideojuegos

?>