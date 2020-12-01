<?php

require_once ("clases/usuario.php");
require_once ("clases/materia.php");
require_once ("clases/responsejson.php");
require_once ("clases/profesor.php");
require_once ("clases/asignacion.php");


$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'] ?? 0;



$array = array();
switch ($path) {
    case '/usuario':
        if ($method == 'POST') {
            $clave= $_POST["clave"];
            $mail=$_POST["email"];
            $foto=  $_FILES["foto"];

            $usuario = new Usuario($mail,$clave,$foto); 



      $array=  $usuario->AltaUsuarioJson();
      echo ResponseJson::GenerarJson($array);

        } else {
            echo "Metodo no permitido";
        }
    break;
    case '/login':
        if ($method == 'POST') {
    
            $password= $_POST["clave"];
            $mail=$_POST["email"];
            $password_encoded = base64_encode($password);

            $array=Usuario::Login($mail,$password_encoded);
            echo ResponseJson::GenerarJson($array);

        } else {
            $array=  array("code"=>400,"mensaje"=>"Metodo no permitido");
            echo ResponseJson::GenerarJson($array);
        }


    break;

    case '/materia':
        if ($method == 'POST') {
    
            $nombre= $_POST["nombre"];
            $cuatrimestre= $_POST["cuatrimestre"];
             $token = $_SERVER['HTTP_TOKEN'];
             
  
            if(Usuario::ValidarToken($token)){

        
            $materia= new Materia( $nombre,$cuatrimestre);
            $array= $materia->AltaMateria();

            echo ResponseJson::GenerarJson($array);
        

            }
            else{
                $array=  array("code"=>400,"mensaje"=>"Token invalido");
                echo ResponseJson::GenerarJson($array);
        
            }
      
          

        }else if($method == "GET")
        {
            $array= Materia::TraerMaterias();
            echo ResponseJson::GenerarJson($array);

        } else {
            $array=   array("code"=>400,"mensaje"=>"Metodo no permitido");
            echo ResponseJson::GenerarJson($array);
        }


    break;
    
    case '/profesor':
        if ($method == 'POST') {
    
            $nombre= $_POST["nombre"];
            $legajo= $_POST["legajo"];
             $token = $_SERVER['HTTP_TOKEN'];
             
  
     if(Usuario::ValidarToken($token)){
        if(Profesor::ValidarLegajo($legajo)){


            $profesor= new Profesor( $nombre,$legajo);
            $array= $profesor->AltaProfesor();

            echo ResponseJson::GenerarJson($array);
        }else{
            $array=  array("code"=>400,"mensaje"=>"Legajo ya existente");
            echo ResponseJson::GenerarJson($array);
        }

       
       

       }else{
        $array=  array("code"=>400,"mensaje"=>"Token invalido");
        echo ResponseJson::GenerarJson($array);
  
       }
      
          

        }else if($method == "GET")
        {
            $array= Profesor::TraerProfesores();
            echo ResponseJson::GenerarJson($array);

        } else {
            $array=   array("code"=>400,"mensaje"=>"Metodo no permitido");
            echo ResponseJson::GenerarJson($array);
        }


    break;
    case '/asignacion':
        if ($method == 'POST') {
    
            $idMateria= $_POST["idMateria"];
            $legajoProfesor= $_POST["legajoProfesor"];
            $turno= $_POST["turno"];
             $token = $_SERVER['HTTP_TOKEN'];
             
  
     if(Usuario::ValidarToken($token)){
         
        $asignacion= new Asinacion($legajoProfesor,$turno,$idMateria);
        
        if(Profesor::TraerProfesor($legajoProfesor)){

            if(Materia::TraerMateria($idMateria)){
                if($asignacion->ValidarAsignacion()){

                    $array= $asignacion->AltaAsignacion();
        
                    echo ResponseJson::GenerarJson($array);
                }else{
                    $array=  array("code"=>400,"mensaje"=>"Asignacion existente, un profesor no puese tener asignado mas de una materia en el mismo turno");
                    echo ResponseJson::GenerarJson($array);
                }
        
            
            }else{
                $array=  array("code"=>400,"mensaje"=>"Id Materia inexistente");
                echo ResponseJson::GenerarJson($array);
            }
        }else{
            $array=  array("code"=>400,"mensaje"=>"Legajo Profesor inexistente");
            echo ResponseJson::GenerarJson($array);
        }

       
       

       }else{
        $array=  array("code"=>400,"mensaje"=>"Token invalido");
        echo ResponseJson::GenerarJson($array);
  
       }
      
          

        }else if($method == "GET")
        {
            $array= Asinacion::TraerAsignaciones();
            echo ResponseJson::GenerarJson($array);

        } else {
            $array=   array("code"=>400,"mensaje"=>"Metodo no permitido");
            echo ResponseJson::GenerarJson($array);
        }


    break;
   
    default:
    $array=   array("code"=>400,"mensaje"=>"Path erroneo");
    echo ResponseJson::GenerarJson($array);
        
}
die();




?>