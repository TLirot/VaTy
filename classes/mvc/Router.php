<?php

class Router {
    
    private $routes = array();

    function __construct() {
        $this->routes['index'] = new Route('Model', 'TemplateView', 'TemplateController');
        $this->routes['usuario'] = new Route('UsuarioModel', 'AjaxView', 'UsuarioController');
        $this->routes['residencia'] = new Route('ResidenciaModel', 'AjaxView', 'ResidenciaController');
        $this->routes['familiar'] = new Route('FamiliarModel', 'AjaxView', 'FamiliarController');
        $this->routes['acompaniante'] = new Route('AcompanianteModel', 'AjaxView', 'AcompanianteController');
        // $this->routes['usuario'] = new Route('UsuarioModel', 'AjaxView', 'UsuarioController');
        //add routes
    }

    function getRoute($route) {
        if (!isset($this->routes[$route])) {
            return $this->routes['index'];
        }
        return $this->routes[$route];
    }
}