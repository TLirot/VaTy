<?php

class CentroMedico {
    
    use Comun;
    
    private $id;
    private $nombre;
    private $direccion;
    private $telefono;

    
    function __construct($id = null, $nombre = null, $direccion = null, $telefono = null) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->direccion = $direccion;
        $this->telefono = $telefono;
    }
    
    /*getter & setter generator http://www.kjetil-hartveit.com/blog/1/setter-and-getter-generator-for-php-javascript-c%2B%2B-and-csharp*/

    function set_id($id) { $this->id = $id; }
    function get_id() { return $this->id; }
    function set_nombre($nombre) { $this->nombre = $nombre; }
    function get_nombre() { return $this->nombre; }
    function set_direccion($direccion) { $this->direccion = $direccion; }
    function get_direccion() { return $this->direccion; }
    function set_telefono($telefono) { $this->telefono = $telefono; }
    function get_telefono() { return $this->telefono; }


}