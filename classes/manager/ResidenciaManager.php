<?php

class ResidenciaManager {
    
    private $db;
    
    function __construct(DataBase $db) {
        $this->db = $db;
    }
    
    public function addResidencia(Residencia $residencia) {
        $sql = 'insert into residencia(id_usuario, nombre, direccion, cp, telefono)'.
                    'values (id_usuario, :nombre, :direccion, :cp, :telefono)';
        $params = array(
            'id_usuario' => $residencia->get_id_usuario(),
            'nombre' => $residencia->get_nombre(),
            'direccion' => $residencia->get_direccion(),
            'cp' => $residencia->get_cp(),
            'telefono' => $residencia->get_telefono()
        );
        $res = $this->db->execute($sql, $params);
        if($res) {
            $id = $this->db->getId();
            $residencia->set_id($id);
        } else {
            $id = 0;
        }
        return $id;
    }
    public function editResidencia(Residencia $residencia) {
        $sql = 'update residencia set nombre = :nombre, direccion = :direccion, cp = :cp, telefono = :telefono where id = :id';
                   
        $params = array(
        'nombre' => $residencia->get_nombre(),
        'direccion' => $residencia->get_direccion(),
        'cp' => $residencia->get_cp(),
        'telefono' => $residencia->get_telefono(),
        'id' => $residencia->get_id()
        );
        $res = $this->db->execute($sql, $params);
        if($res) {
            $affectedRows = $this->db->getRowNumber();
        } else {
            $affectedRows = -1;
        }
        return $affectedRows;
    }
    public function getAll() {
        $sql = 'select * from residencia';
        $res = $this->db->execute($sql);
        $residencias = array();
        if($res){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
                $residencia = new Residencia();
                $residencia->set($row);
                $residencias[] = $residencia;
            }
        }
        return $residencias;
    }
    public function getResidencia($id){
        $sql = 'select * from residencia where id = :id';
        $params = array(
            'id' => $id
        );
        $res = $this->db->execute($sql, $params);
        $statement = $this->db->getStatement();
        $residencia = new Residencia();
        if($res && $row = $statement->fetch()) {
            $residencia->set($row);
        } else {
            $residencia = null;
        }
        return $residencia;
    }
    function getAllResidenciasFromNombre($nombre){
        $sql = 'select * from residencia where nombre like :nombre';
        $params = array(
            'nombre' => '%' . $nombre . '%'
            );
        $res = $this->db->execute($sql, $params);
        $residencias = array();
        if($res){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
                $residencia = new Residencia();
                $residencia->set($row);
                $residencias[] = $residencia;
            }
        }
        return $residencias;
    }
    function getPagedResidencias($offset, $rpp){
        $sql = 'select * from residencia limit '. $offset . ', ' . $rpp;
        $res = $this->db->execute($sql);
        $residencias = array();
        if($res){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
                $residencia = new Residencia();
                $residencia->set($row);
                $residencias[] = $residencia;
            }
        }
        return $residencias;
    }
    public function removeResidencia($id) {
        $sql = 'delete from residencia where id = :id';
        $params = array(
            'id' => $id
        );
        $res = $this->db->execute($sql, $params);
        if($res) {
            $affectedRows = $this->db->getRowNumber();
        } else {
            $affectedRows = -1;
        }
        return $affectedRows;
    }
    function countResidencias(){
        $sql = 'select count(*) from residencia';
        $params = array(

            );
        $res = $this->db->execute($sql, $params);
        $cuenta = 0;
        if($res){
            $sentencia = $this->db->getStatement();
            while($fila = $sentencia->fetch()){
                $cuenta = $fila[0];
            }
        }
        return $cuenta;
    }
}