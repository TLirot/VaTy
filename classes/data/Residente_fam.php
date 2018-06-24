<?php

class Residente_fam {
    
    use Comun;
    
    private $id;
    private $id_familiar;
    private $id_residente;
    
    function __construct($id = null, $id_familiar = null, $id_residente = null) {
        $this->id = $id;
        $this->id_familiar = $id_familiar;
        $this->id_residente= $id_residente;
    }
    
    /*getter & setter generator http://www.kjetil-hartveit.com/blog/1/setter-and-getter-generator-for-php-javascript-c%2B%2B-and-csharp*/

   

    function setId($id) { $this->id = $id; }
    function getId() { return $this->id; }
    function setId_familiar($id_familiar) { $this->id_familiar = $id_familiar; }
    function getId_familiar() { return $this->id_familiar; }
    function setId_residente($id_residente) { $this->id_residente = $id_residente; }
    function getId_residente() { return $this->id_residente; }

}