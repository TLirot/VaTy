<?php

class ResidenteManager {
    
    private $db;
    
    function __construct(DataBase $db) {
        $this->db = $db;
    }
    
    public function addResidente(Residente $residente) {
        $sql = 'insert into residente(id_residencia, id_centro_medico, nombre, apellidos, dni)'.
                    'values (:id_residencia, :id_centro_medico, :nombre, :apellidos, :dni)';
        $params = array(
            'id_residencia' => $residente->getId_residencia(),
            'id_centro_medico' => $residente->getId_centro_medico(),
            'nombre' => $residente->getNombre(),
            'apellidos' => $residente->getApellidos(),
            'dni' => $residente->getDni(),
        );
        $res = $this->db->execute($sql, $params);
        if($res) {
            $id = $this->db->getId();
            $residente->setId($id);
        } else {
            $id = 0;
        }
        return $id;
    }
    public function editResidente(Residente $residente) {
        $sql = 'update residente set nombre = :nombre,'. 
                   'apellidos = :apellidos, dni = :dni, id_centro_medico = :id_centro_medico where id = :id';
        $params = array(
        'nombre' => $residente->getNombre(),
        'apellidos' => $residente->getApellidos(),
        'dni' => $residente->getDni(),
        'id_centro_medico' => $residente->getId_centro_medico(),
        'id' => $residente->getId()
        );
        $res = $this->db->execute($sql, $params);
        if($res) {
            $affectedRows = $this->db->getRowNumber();
        } else {
            $affectedRows = -1;
        }
        return $affectedRows;
    }
    public function removeResidente($id) {
        $sql = 'delete from residente where id = :id';
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
    public function getAll() {
        $sql = 'select * from residente';
        $res = $this->db->execute($sql);
        $residentes = array();
        if($res){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
                $residente = new Residente();
                $residente->set($row);
                $residentes[] = $residente;
            }
        }
        return $residentes;
    }
    public function getAllResidentesFromFamiliar($id_familiar) {
        $sql = 'select r.*, c.nombre as centro from residente as r join residente_fam as r_f on r.id = r_f.id_residente join centro_medico as c on r.id_centro_medico = c.id where r_f.id_familiar = :id_familiar';
        $params = array(
            'id_familiar' => $id_familiar
            );
        $res = $this->db->execute($sql, $params);
        $residentes = array();
        if($res){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
               /* $residente = new Residente();
                $residente->set($row);*/
                $residentes[] = $row;
            }
        }
        return $residentes;
    }
    public function getResidente($id){
        $sql = 'select * from residente where id = :id';
        $params = array(
            'id' => $id
        );
        $res = $this->db->execute($sql, $params);
        $statement = $this->db->getStatement();
        $residente = new Residente();
        if($res && $row = $statement->fetch()) {
            $residente->set($row);
        } else {
            $residente = null;
        }
        return $residente;
    }
    public function getAllResidentesFromNombre($nombre){
        $sql = 'select * from residente where nombre like :nombre';
        $params = array(
            'nombre' => '%' . $nombre . '%'
            );
        $res = $this->db->execute($sql, $params);
        $residentes = array();
        if($res){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
                $residente = new Residente();
                $residente->set($row);
                $residentes[] = $residente;
            }
        }
        return $residentes;
    }
    public function getAllResidentesFromResidencia($id){
        $sql = 'SELECT r.* , c.nombre AS centro FROM residente AS r JOIN centro_medico AS c ON r.id_centro_medico = c.id WHERE id_residencia = :id';
        $params = array(
            'id' => $id
            );
        $res = $this->db->execute($sql, $params);
        $residentes = array();
        if($res){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
                /*$residente = new Residente();
                $residente->set($row);*/
                $residentes[] = $row;
            }
        }
        return $residentes;
    }
    public function getPagedResidentes($offset, $rpp){
        $sql = 'select * from residente limit '. $offset . ', ' . $rpp;
        $res = $this->db->execute($sql);
        $residentes = array();
        if($res){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
                $residente = new Residente();
                $residente->set($row);
                $residentes[] = $residente;
            }
        }
        return $residentes;
    }
    public function countResidentes(){
        $sql = 'select count(*) from residente';
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