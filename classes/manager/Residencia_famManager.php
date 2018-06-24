<?php

class Residencia_famManager {
    
    private $db;
    
    function __construct(DataBase $db) {
        $this->db = $db;
    }
    
    public function addResidencia_fam(Residencia_fam $residencia_fam) {
        $sql = 'insert into residencia_fam(id_familiar, id_residencia)'.
                    'values (:id_familiar, :id_residencia)';
        $params = array(
            'id_familiar' => $residencia_fam->getId_familiar(),
            'id_residencia' => $residencia_fam->getId_residencia()
        );
        $res = $this->db->execute($sql, $params);
        return $res;
    }
    
    
    function getAllFamiliares($id){
        $sql = 'select f.* from familiar as f join residencia_fam as r on f.id = r.id_familiar where id_residencia = :id';
        $params = array(
            'id' => $id
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
    // public function editResidencia_fam(Residencia_fam $residencia_fam) {
    //     $sql = 'update residencia_fam set id_familiar = :id_familiar,'. 
    //               'id_residencia = :id_residencia where id = :id';
    //     $params = array(
    //     'id_familiar' => $residencia_fam->getId_familiar(),
    //     'id_residencia' => $residencia_fam->getId_residencia(),
    //     'id' => $residencia_fam->getId()
    //     );
    //     $res = $this->db->execute($sql, $params);
    //     if($res) {
    //         $affectedRows = $this->db->getRowNumber();
    //     } else {
    //         $affectedRows = -1;
    //     }
    //     return $affectedRows;
    // }
    
    public function getAll() {
        $sql = 'select * from residencia_fam';
        $res = $this->db->execute($sql);
        $residencia_fams = array();
        if($res){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
                $residencia_fam = new Residencia_fam();
                $residencia_fam->set($row);
                $residencia_fams[] = $residencia_fam;
            }
        }
        return $residencia_fams;
    }
    public function getResidencia_fam($id){
        $sql = 'select * from residencia_fam where id = :id';
        $params = array(
            'id' => $id
        );
        $res = $this->db->execute($sql, $params);
        $statement = $this->db->getStatement();
        $residencia_fam = new Residencia_fam();
        if($res && $row = $statement->fetch()) {
            $residencia_fam->set($row);
        } else {
            $residencia_fam = null;
        }
        return $residencia_fam;
    }
    function getAllResidencia_famFromFecha($fecha_alta){
        $sql = 'select * from residencia_fam where fecha_alta like :fecha_alta';
        $params = array(
            'fecha_alta' => '%' . $fecha_alta . '%'
            );
        $res = $this->db->execute($sql, $params);
        $residencia_fams = array();
        if($res){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
                $residencia_fam = new Residencia_fam();
                $residencia_fam->set($row);
                $residencia_fams[] = $residencia_fam;
            }
        }
        return $residencia_fams;
    }
    function getPagedResidencia_fam($offset, $rpp){
        $sql = 'select * from residencia_fam limit '. $offset . ', ' . $rpp;
        $res = $this->db->execute($sql);
        $residencia_fams = array();
        if($res){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
                $residencia_fam = new Residencia_fam();
                $residencia_fam->set($row);
                $residencia_fams[] = $residencia_fam;
            }
        }
        return $residencia_fams;
    }
    public function removeResidencia_fam($id_familiar) {
        $sql = 'delete from residencia_fam where id_familiar = :id_familiar';
        $params = array(
            'id_familiar' => $id_familiar
        );
        $res = $this->db->execute($sql, $params);
        if($res) {
            $affectedRows = $this->db->getRowNumber();
        } else {
            $affectedRows = -1;
        }
        return $affectedRows;
    }
    function countResidencia_fam(){
        $sql = 'select count(*) from residencia_fam';
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