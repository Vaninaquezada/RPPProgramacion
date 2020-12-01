<?php

//require __DIR__ . '../vendor/autoload.php';

require_once("./vendor/autoload.php");


use \Firebase\JWT\JWT;

class JWTMaker{
    private static  $key = "primerparcial";


    public static function GenerarToken($user,$tipo){
      
        $payload = array(
          
                'user' => $user,
                'clave' => $tipo
            
        );

    $jwt = JWT::encode($payload, JWTMaker::$key);
    
    return $jwt;
    }

    
    public static function DecodeToken($token){

    
        try {
      // $token = $_SERVER['HTTP_TOKEN'];
         
         $decoded = JWT::decode($token,JWTMaker::$key, array('HS256'));
          
        return $decoded;
           
        } catch (Exception $e) {
            return 'Error';
        }
    

    }
 
}
?>