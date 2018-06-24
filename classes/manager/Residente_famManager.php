<?php

class Residente_famManager {
    
    private $db;
    
    function __construct(DataBase $db) {
        $this->db = $db;
    }
    
    public function addResidente_fam(Residente_fam $residente_fam) {
        $sql = 'insert into residente_fam(id_familiar, id_residente)'.
                    'values (:id_familiar, :id_residente)';
        $params = array(
            'id_familiar' => $residente_fam->getId_familiar(),
            'id_residente' => $residente_fam->getId_residente()
        );
        $res = $this->db->execute($sql, $params);
        if($res) {
            $id = $this->db->getId();
            $residente_fam->setId($id);
        } else {
            $id = 0;
        }
        return $res;
    }
    
     public function getAllFam_res($id) {
        $sql = 'select f.* from familiar as f join residente_fam as r on f.id =  r.id_familiar where r.id_residente = :id_residente';
        $params = array(
            'id_residente' => $id
            );
        $res = $this->db->execute($sql, $params);
        $familiares = array();
        if($res){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
                $familiar = new Familiar();
                $familiar->set($row);
                $familiares[] = $familiar;
            }
        }
        return $familiares;
    }
    
    /*public function editResidente_fam(Residente_fam $residente_fam) {
        $sql = 'update parentesco = :parentesco where id = :id';
        $params = array(
        'parentesco' => $residente_fam->getParentesco(),
        'id' => $residente_fam->getId()
        );
        $res = $this->db->execute($sql, $params);
        if($res) {
            $affectedRows = $this->db->getRowNumber();
        } else {
            $affectedRows = -1;
        }
        return $affectedRows;
    }*/
    public function getAll() {
        $sql = 'select * from residente_fam';
        $res = $this->db->execute($sql);
        $residente_fams = array();
        if($res){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
                $residente_fam = new Residente_fam();
                $residente_fam->set($row);
                $residente_fams[] = $residente_fam;
            }
        }
        return $residente_fams;
    }
    public function getResidente_fam($id){
        $sql = 'select * from residente_fam where id = :id';
        $params = array(
            'id' => $id
        );
        $res = $this->db->execute($sql, $params);
        $statement = $this->db->getStatement();
        $residente_fam = new Residente_fam();
        if($res && $row = $statement->fetch()) {
            $residente_fam->set($row);
        } else {
            $residente_fam = null;
        }
        return $residente_fam;
    }
    function getAllResidente_famFromParentesco($parentesco){
        $sql = 'select * from residente_fam where parentesco like :parentesco';
        $params = array(
            'parentesco' => '%' . $parentesco . '%'
            );
        $res = $this->db->execute($sql, $params);
        $residente_fams = array();
        if($res){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
                $residente_fam = new Residente_fam();
                $residente_fam->set($row);
                $residente_fams[] = $residente_fam;
            }
        }
        return $residente_fams;
    }
    function getPagedResidente_fam($offset, $rpp){
        $sql = 'select * from residente_fam limit '. $offset . ', ' . $rpp;
        $res = $this->db->execute($sql);
        $residente_fams = array();
        if($res){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
                $residente_fam = new Residente_fam();
                $residente_fam->set($row);
                $residente_fams[] = $residente_fam;
            }
        }
        return $residente_fams;
    }
    public function removeResidente_fam(Residente_fam $residente_fam) {
        $sql = 'delete from residente_fam where id_familiar = :id_familiar AND id_residente = :id_residente';
        $params = array(
            'id_familiar' => $residente_fam->getId_familiar(),
            'id_residente' => $residente_fam->getId_residente()
        );
        $res = $this->db->execute($sql, $params);
        if($res) {
            $affectedRows = $this->db->getRowNumber();
        } else {
            $affectedRows = -1;
        }
        return $affectedRows;
    }
    function countResidente_fam(){
        $sql = 'select count(*) from residente_fam';
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