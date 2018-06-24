<?php

class Residencia_fam {
    
    use Comun;
    
    private $id;
    private $id_familiar;
    private $id_residencia;
    private $fecha_alta;
    
    function __construct($id = null, $id_familiar = null, $id_residencia = null, $fecha_alta = null) {
        $this->id = $id;
        $this->id_familiar = $id_familiar;
        $this->id_residencia = $id_residencia;
        $this->fecha_alta = $fecha_alta;
    }
    
    /*getter & setter generator http://www.kjetil-hartveit.com/blog/1/setter-and-getter-generator-for-php-javascript-c%2B%2B-and-csharp*/



    function setId($id) { $this->id = $id; }
    function getId() { return $this->id; }
    function setId_familiar($id_familiar) { $this->id_familiar = $id_familiar; }
    function getId_familiar() { return $this->id_familiar; }
    function setId_residencia($id_residencia) { $this->id_residencia = $id_residencia; }
    function getId_residencia() { return $this->id_residencia; }
    function setFecha_alta($fecha_alta) { $this->fecha_alta = $fecha_alta; }
    function getFecha_alta() { return $this->fecha_alta; }


}