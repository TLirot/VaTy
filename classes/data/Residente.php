<?php

class Residente {
    
    use Comun;
    
    private $id;
    private $id_residencia;
    private $id_centro_medico;
    private $nombre;
    private $apellidos;
    private $dni;
    private $fecha_alta;
    
    function __construct($id = null, $id_residencia = null, $id_centro_medico = null, $nombre = null, $apellidos = null, $dni = null, $fecha_alta = null) {
        $this->id = $id;
        $this->id_residencia = $id_residencia;
        $this->id_centro_medico = $id_centro_medico;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->dni = $dni;
        $this->fecha_alta = $fecha_alta;
    }
    
    /*getter & setter generator http://www.kjetil-hartveit.com/blog/1/setter-and-getter-generator-for-php-javascript-c%2B%2B-and-csharp*/

    

    function setId($id) { $this->id = $id; }
    function getId() { return $this->id; }
    function setId_residencia($id_residencia) { $this->id_residencia = $id_residencia; }
    function getId_residencia() { return $this->id_residencia; }
    function setId_centro_medico($id_centro_medico) { $this->id_centro_medico = $id_centro_medico; }
    function getId_centro_medico() { return $this->id_centro_medico; }
    function setNombre($nombre) { $this->nombre = $nombre; }
    function getNombre() { return $this->nombre; }
    function setApellidos($apellidos) { $this->apellidos = $apellidos; }
    function getApellidos() { return $this->apellidos; }
    function setDni($dni) { $this->dni = $dni; }
    function getDni() { return $this->dni; }
    function setFecha_alta($fecha_alta) { $this->fecha_alta = $fecha_alta; }
    function getFecha_alta() { return $this->fecha_alta; }


}