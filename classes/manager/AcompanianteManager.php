<?php

class AcompanianteManager {
    
    private $db;
    
    function __construct(DataBase $db) {
        $this->db = $db;
    }
    
    public function addAcompaniante(Acompaniante $acompaniante) {
        $sql = 'insert into acompaniante(id_usuario, nombre, apellidos, dni, direccion, cp, telefono)'.
                    'values (:id_usuario, :nombre, :apellidos, :dni, :direccion, :cp, :telefono)';
        $params = array(
            'id_usuario' => $acompaniante->get_id_usuario(),
            'nombre' => $acompaniante->get_nombre(),
            'apellidos' => $acompaniante->get_apellidos(),
            'dni' => $acompaniante->get_dni(),
            'direccion' => $acompaniante->get_direccion(),
            'cp' => $acompaniante->get_cp(),
            'telefono' => $acompaniante->get_telefono()
        );
        $res = $this->db->execute($sql, $params);
        if($res) {
            $id = $this->db->getId();
            $acompaniante->set_id($id);
        } else {
            $id = 0;
        }
        return $id;
    }
    /*public function editAcompaniante(Acompaniante $acompaniante) {
        $sql = 'update acompaniante set nombre = :nombre, apellidos = :apellidos, dni = :dni,'. 
                   'direccion = :direccion, cp = :cp, telefono = :telefono where id = :id';
        $params = array(
        'nombre' => $acompaniante->get_nombre(),
        'apellidos' => $acompaniante->get_apellidos(),
        'dni' => $acompaniante->get_dni(),
        'direccion' => $acompaniante->get_direccion(),
        'cp' => $acompaniante->get_cp(),
        'telefono' => $acompaniante->get_telefono(),
        'id' => $acompaniante->get_id()
        );
        $res = $this->db->execute($sql, $params);
        if($res) {
            $affectedRows = $this->db->getRowNumber();
        } else {
            $affectedRows = -1;
        }
        return $affectedRows;
    }*/
     public function editAcompaniante($id, $direccion, $cp, $telefono) {
        $sql = 'update acompaniante set direccion = :direccion, cp = :cp, telefono = :telefono where id = :id';
        $params = array(
        'direccion' => $direccion,
        'cp' => $cp,
        'telefono' => $telefono,
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
    public function getAllAcompaniantes($id) {
        $sql = 'select a.* from acompaniante as a join residencia_aco as r on a.id = r.id_acompaniante where r.id_residencia = :id';
        $params = array(
            'id' => $id
            );
        $res = $this->db->execute($sql, $params);
        $acompaniantes = array();
        if($res){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
                $acompaniante = new Acompaniante();
                $acompaniante->set($row);
                $acompaniantes[] = $acompaniante;
            }
        }
        return $acompaniantes;
    }
    public function getAcompaniante($id){
        $sql = 'select a.*, u.correo as correo from acompaniante as a join usuarios as u on a.id_usuario = u.id where a.id = :id';
        $params = array(
            'id' => $id
        );
        $res = $this->db->execute($sql, $params);
        $statement = $this->db->getStatement();
        if($res && $row = $statement->fetch()) {
            $acompaniante = $row;
        } else {
            $acompaniante = null;
        }
        return $acompaniante;
    }
    function getAllAcompaniantesFromNombre($nombre){
        $sql = 'select * from acompaniante where nombre like :nombre';
        $params = array(
            'nombre' => '%' . $nombre . '%'
            );
        $res = $this->db->execute($sql, $params);
        $acompaniantes = array();
        if($res){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
                $acompaniante = new Acompaniante();
                $acompaniante->set($row);
                $acompaniantes[] = $acompaniante;
            }
        }
        return $acompaniantes;
    }
    function getPagedAcompaniantes($offset, $rpp){
        $sql = 'select * from acompaniante limit '. $offset . ', ' . $rpp;
        $res = $this->db->execute($sql);
        $acompaniantes = array();
        if($res){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
                $acompaniante = new Acompaniante();
                $acompaniante->set($row);
                $acompaniantes[] = $acompaniante;
            }
        }
        return $acompaniantes;
    }
    public function removeAcompaniante($id) {
        $sql = 'delete from acompaniante where id = :id';
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
    function countAcompaniantes(){
        $sql = 'select count(*) from acompaniante';
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