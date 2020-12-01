<?php


class  Asinacion{
    private static $ruta = "./archivos/materias-profesores.json";

    private $turno;
    public $legajoProfesor;
    private $idMateria;

    public function __get($name)
    {
        return $this->$name;
    }
    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __construct($legajoProfesor,$turno,$idMateria)
    {
        
        $this->legajoProfesor= $legajoProfesor;
        $this->turno=$turno;
        $this->idMateria=$idMateria;
    }



public  function AltaAsignacion()
{
      $array=array("LegajoProfesor"=> $this->legajoProfesor,"turno"=>$this->turno,"idMateria"=>$this->idMateria);
    
        archivos::GuardarJson(Asinacion::$ruta, $array);

       return array("code"=>200,"mensaje"=>"Asignacion dada de alta de forma exitosa");

      
       
       
}


public static  function TraerAsignaciones(){

    $array =  Archivos::traerJson(Asinacion::$ruta);
     
    $repetido = false;

    if (isset($array)) {
       
        return $array;
    }
       return  $repetido;

}

public function ValidarAsignacion(){
    

    $array =  Archivos::traerJson(Asinacion::$ruta);
     

    if (isset($array)) {
        
        foreach ($array as $item) {
        
               if($item->LegajoProfesor == $this->legajoProfesor && $item->turno == $this->turno)
                {
                    if($item->idMateria == $this->idMateria )
                    {
                        
                        return false;
                    } 
                    
                }  
               
        }
    }
       return  true;

}





}

?>