<?php

require_once("archivos.php");
require_once("jwt.php");

class  Usuario
{
    private $email;
    private $clave;
    private $foto;

    public function getEmail()
    {

        return $this->email;
    }


    public function getClave()
    {

        return $this->clave;
    }

    public function setClave($clave)
    {
        $this->clave = $clave;
    }

    public function getFoto()
    {

        return $this->foto;
    }

    public function setFoto($foto)
    {
        $this->foto = $foto;
    }





    public function __construct( $email, $clave,$foto ="")
    {
        $this->email = $email;
        $this->clave = $clave;
        $this->imagen = $foto;
    }

    public function ToString()
    {
        return $this->tipo . " - " . $this->email . " - " . $this->clave . "\r\n";
    }


    public function AltaImagen()
    {
        
        $uploadOk = TRUE;

        $origen =   $_FILES['foto']["tmp_name"];
        
        $partes_ruta = pathinfo($_FILES['foto']["name"]);
        $tipoArchivo= $partes_ruta['extension'];
        $random = rand(100, 10000);
        $archivoTmp =  $this->email ."-". $random. ".".$tipoArchivo;
        $destino = "./archivos/img/" . $archivoTmp;
        $this->foto = $archivoTmp;
          

           

        if ($_FILES["foto"]["size"] > 500000) {
            echo "El archivo es demasiado grande. Verifique!!!";
            $uploadOk = FALSE;
        }

        $esImagen = getimagesize($_FILES["foto"]["tmp_name"]);

        // ES UNA IMAGEN
        //SOLO PERMITO CIERTAS EXTENSIONES
        if (
            $tipoArchivo != "jpg" && $tipoArchivo != "jpeg" && $tipoArchivo != "gif"
            && $tipoArchivo != "png"
        ) {
            echo "Solo son permitidas imagenes con extension JPG, JPEG, PNG o GIF.";
            $uploadOk = FALSE;
        }


        //VERIFICO SI HUBO ALGUN ERROR, CHEQUEANDO $uploadOk
        if ($uploadOk === FALSE) {

            echo "<br/>NO SE PUDO SUBIR EL ARCHIVO.";
        } else {
            //MUEVO EL ARCHIVO DEL TEMPORAL AL DESTINO FINAL
            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $destino)) {


               // echo "<br/>El archivo " . basename($_FILES["imagen"]["name"]) . " ha sido subido exitosamente.";

                //rename("/tmp/fichero_tmp.txt", "/home/user/login/docs/mi_fichero.txt");
            } else {
                echo "<br/>Lamentablemente ocurri&oacute; un error y no se pudo subir el archivo.";
            }
        }


     
    }


    public static function Login($mail,$clave){

        $ruta = "./archivos/users.txt";
      
         $usuario=  Usuario::TraerUsuario($mail);
            if(!$usuario){
                return array("code"=>400,"mensaje"=>"No existe usuario con ese email");
            }else{
                
                $password_encoded = base64_encode($usuario->Clave);
               
                if($password_encoded == $clave )
                {

                    $token = JWTMaker::GenerarToken($mail,$clave);
                    return array("code"=>200,"Token"=>$token);
                    
                }else{
                    return array("code"=>400,"mensaje"=>"Error al generar token");
                } 
            }

            
        

    }
    public static function ValidarToken($token){
       
        $obj  = JWTMaker::DecodeToken($token);
  
      if($obj != "Error"){
        return true;
      }else{
          return false;
      }
    
    }


public  function AltaUsuarioJson()
{
    $ruta = "./archivos/users.json";
  
      $array=array("Usuario"=> $this->email ,"Clave"=>$this->clave);
      
      $repetido = $this->ValidarUsuarioJson();
      
      if($repetido){

        return array("code"=>400,"mensaje"=>"Usuario ya existente");

      }else{
        $this->AltaImagen();
        archivos::GuardarJson($ruta, $array);

       return array("code"=>200,"mensaje"=>"Usuario dado de alta de forma exitosa");

      }
       
       
}

private  function ValidarUsuarioJson(){
    $ruta = "./archivos/users.json";

    $array =  Archivos::traerJson($ruta);

    $repetido = false;

    if (isset($array)) {
       
        foreach ($array as $item) {
           
               if($item->Usuario == $this->email )
                {
                    
                    $repetido = true;
                }  
               
        }
    }
       return  $repetido;

}

public static  function TraerUsuario($mail){
    $ruta = "./archivos/users.json";

    $array =  Archivos::traerJson($ruta);
     
    $repetido = false;

    if (isset($array)) {
       
        foreach ($array as $item) {
           
               if($item->Usuario == $mail )
                {
                    
                    return $item;
                }  
               
        }
    }
       return  $repetido;

}




}
