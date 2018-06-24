<?php

date_default_timezone_set('Europe/Madrid');

require 'classes/AutoLoader.php';

// $action = Request::read("action");
// $route = Request::read("route");

$action = '';
$route = '';
$urlParams = Request::read('urlparams');
$parametros = explode('/', $urlParams);
if(isset($parametros[0])) {
    $route = $parametros[0];
} else {
    $route = Request::read("route");
}
if(isset($parametros[1])) {
    $action = $parametros[1];
} else {
    $action = Request::read("action");
}


$frontController = new FrontController($route);
$controller = $frontController->getController();
$session = $controller->getSession();

$tokenAuthorization = new TokenAuthorization();

if($authHeader = $tokenAuthorization->getAuthorizationHeader()){
    
    if($tokenAuthorization->validateToken($authHeader)){
        $frontController->doAction($action);
        $data = $frontController->doOutput($action);
        $data = json_decode($data, true);
        if($action != 'logout'){
            $token = $tokenAuthorization->generateToken();
            // $data['data'] = $data['usuarios'];
            // unset($data['usuarios']);
            // $data['token'] = $token;
            unset($data['base']);
        }
        echo json_encode($data);
    }
    
} else if($session->isLogged() || $action == 'login'){

    $frontController->doAction($action);
    echo $frontController->doOutput($action);

} else if($action == 'logintoken'){
    $frontController->doAction($action);
    $data = $frontController->doOutput($action);
    echo $data;
    
}else{
    $action = 'index';
    $frontController->doAction($action);
    echo $frontController->doOutput($action);
    // echo 'index';
}



// $tkm = new TokenManager();


// } else if (validateToken(getHeader('authorization'))) {
//     $frontController->doAction($action);
//     $data = $frontController->doOutput($action);
//      $tok = generateToken();
//      echo $tok + $data
// } else {
//respuesta "No autenticado"
// }


