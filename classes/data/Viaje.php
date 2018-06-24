<?php

class Viaje {
    
    use Comun;
    
    private $id;
    private $id_cita;
    private $id_acompaniante;
    private $h_salida;
    private $h_llegada;
    private $estado;
    
    function __construct($id = null, $id_cita = null, $id_acompaniante = null, $h_salida = null, $h_llegada = null, $estado = null) {
        $this->id = $id;
        $this->id_cita= $id_cita;
        $this->id_acompaniante = $id_acompaniante;
        $this->h_salida = $h_salida;
        $this->h_llegada = $h_llegada;
        $this->estado = $estado;
    }
    
    /*getter & setter generator http://www.kjetil-hartveit.com/blog/1/setter-and-getter-generator-for-php-javascript-c%2B%2B-and-csharp*/

  

    function setId($id) { $this->id = $id; }
    function getId() { return $this->id; }
    function setId_cita($id_cita) { $this->id_cita = $id_cita; }
    function getId_cita() { return $this->id_cita; }
    function setId_acompaniante($id_acompaniante) { $this->id_acompaniante = $id_acompaniante; }
    function getId_acompaniante() { return $this->id_acompaniante; }
    function setH_salida($h_salida) { $this->h_salida = $h_salida; }
    function getH_salida() { return $this->h_salida; }
    function setH_llegada($h_llegada) { $this->h_llegada = $h_llegada; }
    function getH_llegada() { return $this->h_llegada; }
    function setEstado($estado) { $this->estado = $estado; }
    function getEstado() { return $this->estado; }




}