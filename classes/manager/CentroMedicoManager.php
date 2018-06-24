<?php

class CentroMedicoManager {
    
    private $db;
    
    function __construct(DataBase $db) {
        $this->db = $db;
    }
    
    public function addCentroMedico(CentroMedico $centroMedico) {
        $sql = 'insert into centro_medico(nombre, direccion, telefono)'.
                    'values (:nombre, :direccion, :telefono)';
        $params = array(
            'nombre' => $centroMedico->get_nombre(),
            'direccion' => $centroMedico->get_direccion(),
            'telefono' => $centroMedico->get_telefono()
        );
        $res = $this->db->execute($sql, $params);
        if($res) {
            $id = $this->db->getId();
            $centroMedico->set_id($id);
        } else {
            $id = 0;
        }
        return $id;
    }
    public function editCentroMedico(CentroMedico $centroMedico) {
        $sql = 'update centro_medico set nombre = :nombre,'. 
                   'direccion = :direccion, telefono = :telefono where id = :id';
        $params = array(
        'nombre' => $centroMedico->get_nombre(),
        'direccion' => $centroMedico->get_direccion(),
        'telefono' => $centroMedico->get_telefono(),
        'id' => $centroMedico->get_id()
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
        $sql = 'select * from centro_medico';
        $res = $this->db->execute($sql);
        $centroMedicos = array();
        if($res){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
                $centroMedico = new CentroMedico();
                $centroMedico->set($row);
                $centroMedicos[] = $centroMedico;
            }
        }
        return $centroMedicos;
    }
    public function getCentroMedico($id){
        $sql = 'select * from centro_medico where id = :id';
        $params = array(
            'id' => $id
        );
        $res = $this->db->execute($sql, $params);
        $statement = $this->db->getStatement();
        $centroMedico = new CentroMedico();
        if($res && $row = $statement->fetch()) {
            $centroMedico->set($row);
        } else {
            $centroMedico = null;
        }
        return $centroMedico;
    }
    function getAllCentrosMedicosFromNombre($nombre){
        $sql = 'select * from centro_medico where nombre like :nombre';
        $params = array(
            'nombre' => '%' . $nombre . '%'
            );
        $res = $this->db->execute($sql, $params);
        $centroMedicos = array();
        if($res){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
                $centroMedico = new CentroMedico();
                $centroMedico->set($row);
                $centroMedicos[] = $centroMedico;
            }
        }
        return $centroMedicos;
    }
    function getPagedCentrosMedicos($offset, $rpp){
        $sql = 'select * from centro_medico limit '. $offset . ', ' . $rpp;
        $res = $this->db->execute($sql);
        $centroMedicos = array();
        if($res){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
                $centroMedico = new CentroMedico();
                $centroMedico->set($row);
                $centroMedicos[] = $centroMedico;
            }
        }
        return $centroMedicos;
    }
    public function removeCentroMedico($id) {
        $sql = 'delete from centro_medico where id = :id';
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
    function countCentrosMedicos(){
        $sql = 'select count(*) from centro_medico';
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