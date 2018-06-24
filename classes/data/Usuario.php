<?php

class Usuario {
    
    use Comun;
    
    private $id;
    private $nick;
    private $password;
    private $rol;
    private $correo;
    private $fecha_alta;
    
    function __construct($id = null, $nick = null, $password = null, $rol = null, $correo = null, $fecha_alta = null) {
        $this->id = $id;
        $this->nick = $nick;
        $this->password = $password;
        $this->rol = $rol;
        $this->correo = $correo;
        $this->fecha_alta = $fecha_alta;
    }
    
    /*getter & setter generator http://www.kjetil-hartveit.com/blog/1/setter-and-getter-generator-for-php-javascript-c%2B%2B-and-csharp*/
    
   

function set_id($id) { $this->id = $id; }
function get_id() { return $this->id; }
function set_nick($nick) { $this->nick = $nick; }
function get_nick() { return $this->nick; }
function set_password($password) { $this->password = $password; }
function get_password() { return $this->password; }
function set_rol($rol) { $this->rol = $rol; }
function get_rol() { return $this->rol; }
function set_correo($correo) { $this->correo = $correo; }
function get_correo() { return $this->correo; }
function set_fecha_alta($fecha_alta) { $this->fecha_alta = $fecha_alta; }
function get_fecha_alta() { return $this->fecha_alta; }

}