<?php

class Residencia_aco {
    
    use Comun;
    
    private $id;
    private $id_acompaniante;
    private $id_residencia;
    private $fecha_alta;

    function __construct($id = null, $id_acompaniante = null, $id_residencia = null, $fecha_alta = null) {
        $this->id = $id;
        $this->id_acompaniante = $id_acompaniante;
        $this->id_residencia = $id_residencia;
        $this->fecha_alta = $fecha_alta;
    }
    
    /*getter & setter generator http://www.kjetil-hartveit.com/blog/1/setter-and-getter-generator-for-php-javascript-c%2B%2B-and-csharp*/

    function setId($id) { $this->id = $id; }
    function getId() { return $this->id; }
    function setId_acompaniante($id_acompaniante) { $this->id_acompaniante = $id_acompaniante; }
    function getId_acompaniante() { return $this->id_acompaniante; }
    function setId_residencia($id_residencia) { $this->id_residencia = $id_residencia; }
    function getId_residencia() { return $this->id_residencia; }
    function setFecha_alta($fecha_alta) { $this->fecha_alta = $fecha_alta; }
    function getFecha_alta() { return $this->fecha_alta; }
}