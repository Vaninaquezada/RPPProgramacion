<?php


class  Profesor{

    private $nombre;
    private $legajo;

    private static $ruta = "./archivos/profesor.json";

 

    public function __get($name)
    {
        return $this->$name;
    }
    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __construct($nombre,$legajo)
    {
        
        $this->nombre= $nombre;
        $this->legajo=$legajo;

    }



public  function AltaProfesor()
{
    
  
      $array=array("Legajo"=> $this->legajo,"Nombre"=>$this->nombre);
      
      
        archivos::GuardarJson(Profesor::$ruta, $array);

       return array("code"=>200,"mensaje"=>"Profesor dada de alta de forma exitosa");

      
       
       
}


public static  function TraerProfesor($legajo){


    $array =  Archivos::traerJson(Profesor::$ruta);
     
    if (isset($array)) {
       
        foreach ($array as $item) {

               if($item->Legajo == $legajo )
                {

                    return true;
                }  
               
        }
    }
       return  false;

}

public static  function TraerProfesores(){


    $array =  Archivos::traerJson(Profesor::$ruta);
     
    $repetido = false;

    if (isset($array)) {              
        return $array;
               
        }
    
       return  $repetido;

}

public static  function ValidarLegajo($legajo){
    

    $array =  Archivos::traerJson(Profesor::$ruta);
     


    if (isset($array)) {
       
        foreach ($array as $item) {
           
               if($item->Legajo == $legajo )
                {
                    
                    return false;
                }  
               
        }
    }
       return  true;

}



}

?>
