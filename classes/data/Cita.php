<?php

class Cita {
    
    use Comun;
    
    private $id;
    private $id_residente;
    private $fecha;
    private $motivo;
    private $tipo;
    private $fam_disponible;
    private $descripcion;
    
    function __construct($id = null, $id_residente = null, $fecha = null, $motivo = null, $tipo = null, $fam_disponible = null, $descripcion = null) {
        $this->id = $id;
        $this->id_residente= $id_residente;
        $this->fecha = $fecha;
        $this->motivo = $motivo;
        $this->tipo = $tipo;
        $this->fam_disponible = $fam_disponible;
        $this->descripcion = $descripcion;
    }
    
    /*getter & setter generator http://www.kjetil-hartveit.com/blog/1/setter-and-getter-generator-for-php-javascript-c%2B%2B-and-csharp*/

    function setId($id) { $this->id = $id; }
    function getId() { return $this->id; }
    function setId_residente($id_residente) { $this->id_residente = $id_residente; }
    function getId_residente() { return $this->id_residente; }
    function setFecha($fecha) { $this->fecha = $fecha; }
    function getFecha() { return $this->fecha; }
    function setMotivo($motivo) { $this->motivo = $motivo; }
    function getMotivo() { return $this->motivo; }
    function setTipo($tipo) { $this->tipo = $tipo; }
    function getTipo() { return $this->tipo; }
    function setFam_disponible($fam_disponible) { $this->fam_disponible = $fam_disponible; }
    function getFam_disponible() { return $this->fam_disponible; }
    function setDescripcion($descripcion) { $this->descripcion = $descripcion; }
    function getDescripcion() { return $this->descripcion; }



}