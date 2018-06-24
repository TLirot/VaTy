<?php

class Residencia_acoManager {
    
    private $db;
    
    function __construct(DataBase $db) {
        $this->db = $db;
    }
    
    public function addResidencia_aco(Residencia_aco $residencia_aco) {
        $sql = 'insert into residencia_aco(id_acompaniante, id_residencia)'.
                    'values (:id_acompaniante, :id_residencia)';
        $params = array(
            'id_acompaniante' => $residencia_aco->getId_acompaniante(),
            'id_residencia' => $residencia_aco->getId_residencia()
        );
        $res = $this->db->execute($sql, $params);
        return $res;
    }
    // public function editresidencia_aco(residencia_aco $residencia_aco) {
    //     $sql = 'update id_viaje = :id_viaje where id = :id';
    //     $params = array(
    //     'id_viaje' => $residencia_aco->getid_viaje(),
    //     'id' => $residencia_aco->getId()
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
        $sql = 'select * from residencia_aco';
        $res = $this->db->execute($sql);
        $residencia_acos = array();
        if($res){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
                $residencia_aco = new Residencia_aco();
                $residencia_aco->set($row);
                $residencia_acos[] = $residencia_aco;
            }
        }
        return $residencia_acos;
    }
    public function getresidencia_aco($id){
        $sql = 'select * from residencia_aco where id = :id';
        $params = array(
            'id' => $id
        );
        $res = $this->db->execute($sql, $params);
        $statement = $this->db->getStatement();
        $residencia_aco = new Residencia_aco();
        if($res && $row = $statement->fetch()) {
            $residencia_aco->set($row);
        } else {
            $residencia_aco = null;
        }
        return $residencia_aco;
    }
    // function getAllresidencia_acoFromid_viaje($id_viaje){
    //     $sql = 'select * from residencia_aco where id_viaje like :id_viaje';
    //     $params = array(
    //         'id_viaje' => '%' . $id_viaje . '%'
    //         );
    //     $res = $this->db->execute($sql, $params);
    //     $residencia_acos = array();
    //     if($res){
    //         $statement = $this->db->getStatement();
    //         while($row = $statement->fetch()) {
    //             $residencia_aco = new residencia_aco();
    //             $residencia_aco->set($row);
    //             $residencia_acos[] = $residencia_aco;
    //         }
    //     }
    //     return $residencia_acos;
    // }
    function getPagedresidencia_aco($offset, $rpp){
        $sql = 'select * from residencia_aco limit '. $offset . ', ' . $rpp;
        $res = $this->db->execute($sql);
        $residencia_acos = array();
        if($res){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
                $residencia_aco = new Residencia_aco();
                $residencia_aco->set($row);
                $residencia_acos[] = $residencia_aco;
            }
        }
        return $residencia_acos;
    }
    public function removeresidencia_aco($id) {
        $sql = 'delete from residencia_aco where id = :id';
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
    function countresidencia_aco(){
        $sql = 'select count(*) from residencia_aco';
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