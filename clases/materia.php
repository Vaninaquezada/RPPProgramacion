<?php


class  Materia{

    private $nombre;
    private $cuatrimestre;
    private $id;
    private $ruta = "./archivos/materias.json";

 

    public function __get($name)
    {
        return $this->$name;
    }
    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __construct($nombre,$cuatrimestre)
    {
        $this->cuatrimestre = $cuatrimestre;
        $this->nombre= $nombre;
        $this->id= $random = rand(100, 10000);

    }



public  function AltaMateria()
{
    
  
      $array=array("id"=> $this->id,"Cuatrimestre"=> $this->cuatrimestre ,"Nombre"=>$this->nombre);
      
      
        archivos::GuardarJson($this->ruta, $array);

       return array("code"=>200,"mensaje"=>"Materia dada de alta de forma exitosa");

      
       
       
}


public static  function TraerMateria($patente){
    $ruta = "./archivos/autos.json";

    $array =  Archivos::traerJson($ruta);
     
    $repetido = false;

    if (isset($array)) {
       
        foreach ($array as $item) {
           
               if($item->Usuario == $patente )
                {
                    
                    return $item;
                }  
               
        }
    }
       return  $repetido;

}



}

?>
