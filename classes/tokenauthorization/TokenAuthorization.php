<?php

require_once 'tokenconfig.php';
require_once 'vendor/BeforeValidException.php';
require_once 'vendor/ExpiredException.php';
require_once 'vendor/SignatureInvalidException.php';
require_once 'vendor/JWT.php';
use \Firebase\JWT\JWT;
// require __DIR__ . '/../vendor/autoload.php';
// include __DIR__ . '/../vendor/autoload.php';

class TokenAuthorization {
    
    private $user_data;
    
    function __construct($userdata = null){
        $this->user_data = $userdata;
    }

    function generateToken($user = null){

        if(isset($this->user_data)){
            $user = $this->user_data;
        }

        $tokenId    = base64_encode(mcrypt_create_iv(32));
        $issuedAt   = time();
        $notBefore  = $issuedAt + 10;                   // Adding 10 seconds
        $expire     = $notBefore + 86400;               // Adding 24 h
        
        /*
        * Create the token as an array
        */
        $data = [
            'iat'  => $issuedAt,        // Issued at: time when the token was generated
            'jti'  => $tokenId,         // Json Token Id: an unique identifier for the token
            'iss'  => SERVER_NAME,      // Issuer
            'nbf'  => $notBefore,       // Not before
            'exp'  => $expire,          // Expire
            'data' => [                 // Data related to the signer user
                $user                  // User
            ]
        ];

        $secretKey = base64_decode(API_KEY);
        
        $jwt = JWT::encode(
            $data,      
            $secretKey, 
            'HS512'     // Algorithm used to sign the token
            );
            
        $unencodedArray = $jwt;
        return $unencodedArray;

    }

    function validateToken($authHeader){
        // get the jwt from the authorization header
        list($jwt) = sscanf( $authHeader, 'Authorization: Bearer %s');

        if ($jwt) {
            try {                    

                $secretKey = base64_decode(API_KEY);
                
                $token = JWT::decode($jwt, $secretKey, array('HS512'));
                
                $this->setUserData($token->data);
                
                if( $hora->getTimestamp() < $token->exp ){
                    return true;
                } else {
                    $error = ['error' => 401, 'errormsg' => 'Expired token'];
                    return $error;
                }
            } catch (Exception $e) {
                $error = ['error' => 401, 'errormsg' => 'Unauthorized'];
                return $error;
            }
        } else {
            $error = ['error' => 400, 'errormsg' => 'Bad Request'];
            return $error;
        }

    }

    function getAuthorizationHeader(){
        $allHeaders = getallheaders();
        return $allHeaders['authorization'];
    }
    
    function setUserData($userData){
        $this->user_data;
    }

}