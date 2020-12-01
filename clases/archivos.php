<?php

class  Archivos{


    static function serializeObj($ruta,$obj){

        $ar=fopen($ruta,"a");
    
            fwrite($ar,serialize($obj).PHP_EOL);
            fclose($ar);
    }




    static function unserializeObj($ruta){
        
        $lista = array();
        if (file_exists($ruta)) {
        $ar = fopen($ruta,"r");
        while(!feof($ar)){
            $obj = unserialize(fgets($ar));
            if($obj != null)
            array_push($lista,$obj);
        }
        fclose($ar);
    }
        return $lista;
    

    }


    static function GuardarJson($ruta,$objeto){

        $array = Archivos::traerJson($ruta);
     
        if(isset($array)){
            $ar=fopen($ruta,"w");
            array_push($array,$objeto);

            fwrite($ar,json_encode($array));
            fclose($ar);

        }else{
            $array2 = array();
            $ar=fopen($ruta,"w");
            array_push($array2,$objeto);
           
          fwrite($ar,json_encode($array2));
            fclose($ar);
        }


    }

    static function traerJson($ruta){
        if (file_exists($ruta)) {
        
            $ar=fopen($ruta,"r");
            $lista=json_decode(fgets($ar));
            fclose($ar);
            if(isset($lista)){
                return $lista;
            }else{
                echo "archivo inexistente";
            }
            
        }

    }
    static  function getRequestHeaders( $token ) {
        $headers = array();
        $token= "";
        foreach($_SERVER as $key => $value) {
            if (substr($key, 0, 5) <> 'HTTP_') {
                continue;
            }
            $header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
            $headers[$header] = $value;

        }
     return $token;
   }

}


?>