<?php

class ViajeManager {
    
    private $db;
    
    function __construct(DataBase $db) {
        $this->db = $db;
    }
    
    public function addViaje($id_acompaniante, $id_cita) {
        $sql = 'insert into viaje(id_cita, id_acompaniante, estado)'.
                    'values (:id_cita, :id_acompaniante, :estado)';
        $params = array(
            'id_cita' => $id_cita,
            'id_acompaniante' => $id_acompaniante,
            'estado' => 'PENDIENTE'
        );
        $res = $this->db->execute($sql, $params);
        if($res) {
            $id = $this->db->getId();
        } else {
            $id = 0;
        }
        return $id;
    }
    public function editViaje(Viaje $viaje) {
        $sql = 'update viaje set id_cita = :id_cita, fecha = :fecha, h_salida = :h_salida,'. 
                   'h_llegada = :h_llegada, estado = :estado where id = :id';
        $params = array(
        'id_cita' => $viaje->getId_cita(),
        'fecha' => $viaje->getFecha(),
        'h_salida' => $viaje->getH_salida(),
        'h_llegada' => $viaje->getH_llegada(),
        'estado' => $viaje->getEstado(),
        'id' => $viaje->getId()
        );
        $res = $this->db->execute($sql, $params);
        if($res) {
            $affectedRows = $this->db->getRowNumber();
        } else {
            $affectedRows = -1;
        }
        return $affectedRows;
    }
    
    
    function editViajeIniciar($id_viaje){
        $sql = 'update viaje set estado = :estado, h_salida = :h_salida where id = :id_viaje';
        $params = array(
        'id_viaje' => $id_viaje,
        'h_salida' => date('H:i'),
        'estado' => 'INICIADO'
        );
        $res = $this->db->execute($sql, $params);
        if($res) {
            $affectedRows = $this->db->getRowNumber();
        } else {
            $affectedRows = -1;
        }
        return $affectedRows;
    }
    
    
    function editViajeFinalizar($id_viaje){
        $sql = 'update viaje set estado = :estado, h_llegada = :h_llegada where id = :id_viaje';
        $params = array(
        'id_viaje' => $id_viaje,
        'h_llegada' => date('H:i'),
        'estado' => 'TERMINADO'
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
        $sql = 'select * from viaje';
        $res = $this->db->execute($sql);
        $viajes = array();
        if($res){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
                $viaje = new Viaje();
                $viaje->set($row);
                $viajes[] = $viaje;
            }
        }
        return $viajes;
    }
    public function getViaje($id_cita){
        $sql = 'SELECT v. * , a.nombre AS acompaniante FROM viaje AS v JOIN cita AS c ON v.id_cita = c.id JOIN acompaniante AS a ON v.id_acompaniante = a.id WHERE v.id_cita = :id_cita';
        $params = array(
            'id_cita' => $id_cita
        );
        $res = $this->db->execute($sql, $params);
        $statement = $this->db->getStatement();
        $viaje;
        if($res && $row = $statement->fetch()) {
            $viaje = $row;
        } else {
            $viaje = null;
        }
        return $viaje;
    }
    function getAllViajesFromFecha($fecha){
        $sql = 'select * from viaje where fecha like :fecha';
        $params = array(
            'fecha' => '%' . $fecha . '%'
            );
        $res = $this->db->execute($sql, $params);
        $viajes = array();
        if($res){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
                $viaje = new Viaje();
                $viaje->set($row);
                $viajes[] = $viaje;
            }
        }
        return $viajes;
    }
    
    function getAllViajesFromEstado($estado){
        $sql = 'select * from viaje where estado = :estado';
        $params = array(
            'estado' => $estado
            );
        $res = $this->db->execute($sql, $params);
        $viajes = array();
        if($res){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
                $viaje = new Viaje();
                $viaje->set($row);
                $viajes[] = $viaje;
            }
        }
        return $viajes;
    }
    
    
    function getPagedViajes($offset, $rpp){
        $sql = 'select * from viaje limit '. $offset . ', ' . $rpp;
        $res = $this->db->execute($sql);
        $viajes = array();
        if($res){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
                $viaje = new Viaje();
                $viaje->set($row);
                $viajes[] = $viaje;
            }
        }
        return $viajes;
    }
    public function removeViaje($id) {
        $sql = 'delete from viaje where id = :id';
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
    function countViajes(){
        $sql = 'select count(*) from viaje';
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