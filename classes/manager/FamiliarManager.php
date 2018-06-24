<?php

class FamiliarManager {
    
    private $db;
    
    function __construct(DataBase $db) {
        $this->db = $db;
    }
    
    public function addFamiliar(Familiar $familiar) {
        $sql = 'insert into familiar(id_usuario, nombre, apellidos, dni, direccion, cp, telefono)'.
                    'values (:id_usuario, :nombre, :apellidos, :dni, :direccion, :cp, :telefono)';
        $params = array(
            'id_usuario' => $familiar->get_id_usuario(),
            'nombre' => $familiar->get_nombre(),
            'apellidos' => $familiar->get_apellidos(),
            'dni' => $familiar->get_dni(),
            'direccion' => $familiar->get_direccion(),
            'cp' => $familiar->get_cp(),
            'telefono' => $familiar->get_telefono()
        );
        $res = $this->db->execute($sql, $params);
        if($res) {
            $id = $this->db->getId();
            $familiar->set_id($id);
        } else {
            $id = 0;
        }
        return $id;
    }
    /*public function editFamiliar(Familiar $familiar) {
        $sql = 'update familiar set nombre = :nombre, apellidos = :apellidos, dni = :dni,'. 
                  'direccion = :direccion, cp = :cp, telefono = :telefono where id = :id';
        $params = array(
        'nombre' => $familiar->get_nombre(),
        'apellidos' => $familiar->get_apellidos(),
        'dni' => $familiar->get_dni(),
        'direccion' => $familiar->get_direccion(),
        'cp' => $familiar->get_cp(),
        'telefono' => $familiar->get_telefono(),
        'id' => $familiar->get_id()
        );
        $res = $this->db->execute($sql, $params);
        if($res) {
            $affectedRows = $this->db->getRowNumber();
        } else {
            $affectedRows = -1;
        }
        return $affectedRows;
    }*/
    public function editFamiliar($id, $direccion, $cp, $telefono) {
        $sql = 'update familiar set direccion = :direccion, cp = :cp, telefono = :telefono where id = :id';
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
    public function getAll() {
        $sql = 'select * from familiar';
        $res = $this->db->execute($sql);
        $familiars = array();
        if($res){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
                $familiar = new Familiar();
                $familiar->set($row);
                $familiars[] = $familiar;
            }
        }
        return $familiars;
    }
    public function getFamiliar($id){
        $sql = 'SELECT f . * , u.correo FROM familiar AS f JOIN usuarios AS u ON f.id_usuario = u.id WHERE f.id =:id';
        $params = array(
            'id' => $id
        );
        $res = $this->db->execute($sql, $params);
        $statement = $this->db->getStatement();
        if($res && $row = $statement->fetch()) {
            $familiar = $row;
        } else {
            $familiar = null;
        }
        return $familiar;
    }
    function getAllFamiliaresFromNombre($nombre){
        $sql = 'select * from familiar where nombre like :nombre';
        $params = array(
            'nombre' => '%' . $nombre . '%'
            );
        $res = $this->db->execute($sql, $params);
        $familiars = array();
        if($res){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
                $familiar = new Familiar();
                $familiar->set($row);
                $familiars[] = $familiar;
            }
        }
        return $familiars;
    }
    function getPagedFamiliares($offset, $rpp){
        $sql = 'select * from familiar limit '. $offset . ', ' . $rpp;
        $res = $this->db->execute($sql);
        $familiars = array();
        if($res){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
                $familiar = new Familiar();
                $familiar->set($row);
                $familiars[] = $familiar;
            }
        }
        return $familiars;
    }
    public function removeFamiliar($id) {
        $sql = 'delete from familiar where id = :id';
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
    function countFamiliares(){
        $sql = 'select count(*) from familiar';
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
    
    
    // ---------------------------------------------JOINS-----------------------------------------------
    
    
    public function getAllFamiliaresFromResidencia($id_residencia) {
        $sql = 'select f.* from familiar AS f'.
        'join residencia_fam AS rf'.
        'on f.id = rf.id_familiar'.
        'where id_residencia = :id_residencia';
        
        $params = array(
            'id_residencia' => $id_residencia
            );
        $res = $this->db->execute($sql, $params);
        $familiars = array();
        if($res){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
                $familiar = new Familiar();
                $familiar->set($row);
                $familiars[] = $familiar;
            }
        }
        return $familiars;
    }
    
    
}