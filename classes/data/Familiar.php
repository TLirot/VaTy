<?php

class Familiar {
    
    use Comun;
    
    private $id;
    private $id_usuario;
    private $nombre;
    private $apellidos;
    private $dni;
    private $direccion;
    private $cp;
    private $telefono;
    
    function __construct($id = null, $id_usuario = null, $nombre = null, $apellidos = null, $dni = null, $direccion = null, $cp = null, $telefono = null) {
        $this->id = $id;
        $this->id_usuario = $id_usuario;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->dni = $dni;
        $this->direccion = $direccion;
        $this->cp = $cp;
        $this->telefono = $telefono;
    }
    
    /*getter & setter generator http://www.kjetil-hartveit.com/blog/1/setter-and-getter-generator-for-php-javascript-c%2B%2B-and-csharp*/

    function set_id($id) { $this->id = $id; }
    function get_id() { return $this->id; }
    function set_id_usuario($id_usuario) { $this->id_usuario = $id_usuario; }
    function get_id_usuario() { return $this->id_usuario; }
    function set_nombre($nombre) { $this->nombre = $nombre; }
    function get_nombre() { return $this->nombre; }
    function set_apellidos($apellidos) { $this->apellidos = $apellidos; }
    function get_apellidos() { return $this->apellidos; }
    function set_dni($dni) { $this->dni = $dni; }
    function get_dni() { return $this->dni; }
    function set_direccion($direccion) { $this->direccion = $direccion; }
    function get_direccion() { return $this->direccion; }
    function set_cp($cp) { $this->cp = $cp; }
    function get_cp() { return $this->cp; }
    function set_telefono($telefono) { $this->telefono = $telefono; }
    function get_telefono() { return $this->telefono; }

}