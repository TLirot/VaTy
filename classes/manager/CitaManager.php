<?php

class CitaManager {
    
    private $db;
    
    function __construct(DataBase $db) {
        $this->db = $db;
    }
    
    public function addCita(Cita $cita) {
        $sql = 'insert into cita(id_residente, fecha, motivo, tipo, fam_disponible, descripcion)'.
                    'values (:id_residente, :fecha, :motivo, :tipo, :fam_disponible, :descripcion)';
        $params = array(
            'id_residente' => $cita->getId_residente(),
            'fecha' => $cita->getFecha(),
            'motivo' => $cita->getMotivo(),
            'tipo' => $cita->getTipo(),
            'fam_disponible' => $cita->getFam_disponible(),
            'descripcion' => $cita->getDescripcion(),
        );
        $res = $this->db->execute($sql, $params);
        if($res) {
            $id = $this->db->getId();
            $cita->setId($id);
        } else {
            $id = 0;
        }
        return $id;
    }
    public function removeCita($id) {
        $sql = 'delete from cita where id = :id';
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
    public function editCita(Cita $cita) {
        $sql = 'update cita set fecha = :fecha motivo = :motivo,'. 
                   'tipo = :tipo, fam_disponible = :fam_disponible where id = :id';
        $params = array(
        'fecha' => $cita->getFecha(),
        'motivo' => $cita->getMotivo(),
        'tipo' => $cita->getTipo(),
        'fam_disponible' => $cita->getFam_disponible(),
        'descripcion' => $cita->getDescripcion(),
        'id' => $cita->getId()
        );
        $res = $this->db->execute($sql, $params);
        if($res) {
            $affectedRows = $this->db->getRowNumber();
        } else {
            $affectedRows = -1;
        }
        return $affectedRows;
    }
    public function editFam_disponible($id_cita, $fam_disponible){
        $sql = 'update cita set fam_disponible = :fam_disponible where id = :id_cita';
        $params = array(
        'fam_disponible' => $fam_disponible,
        'id_cita' => $id_cita
        );
        $res = $this->db->execute($sql, $params);
        if($res) {
            $affectedRows = $this->db->getRowNumber();
        } else {
            $affectedRows = -1;
        }
        return $affectedRows;
    }
    
    public function getCitasAvaiableFromResidencia($id_acompaniante) {
        $sql = 'SELECT c . *'.
                ' FROM acompaniante as a'.
                ' left JOIN residencia_aco AS r_a ON a.id = r_a.id_acompaniante'.
                ' left JOIN residente AS r ON r.id_residencia = r_a.id_residencia'.
                ' left join cita AS c ON c.id_residente = r.id'.
                ' where c.fam_disponible = 0 and a.id = :id_acompaniante and c.fecha > now()';
        $params = array(
            'id_acompaniante' => $id_acompaniante
            );
        $res = $this->db->execute($sql, $params);
        $citas = array();
        if($res){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
                $cita = new Cita();
                $cita->set($row);
                $citas[] = $cita;
            }
        }
        return $citas;
    }
    
    public function getCitasFromResidente($id) {
        $sql = 'select c.* from cita as c join residente as r on c.id_residente = r.id where id_residente = :id';
        $params = array(
            'id' => $id
            );
        $res = $this->db->execute($sql, $params);
        $citas = array();
        if($res){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
                $cita = new Cita();
                $cita->set($row);
                $citas[] = $cita;
            }
        }
        return $citas;
    }
    public function getCita($id){
        $sql = 'select * from cita where id = :id';
        $params = array(
            'id' => $id
        );
        $res = $this->db->execute($sql, $params);
        $statement = $this->db->getStatement();
        $cita = new Cita();
        if($res && $row = $statement->fetch()) {
            $cita->set($row);
        } else {
            $cita = null;
        }
        return $cita;
    }
    
    public function getCitasAceptadas($id_acompaniante){
        $sql = 'select c.* from cita as c join viaje as v on c.id = v.id_cita join acompaniante as a on v.id_acompaniante = a.id where a.id = :id_acompaniante AND v.estado not in (:estado)';
        $params = array(
            'id_acompaniante' => $id_acompaniante,
            'estado' => 'TERMINADO'
            );
        $res = $this->db->execute($sql, $params);
        $citas = array();
        if($res){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
                $cita = new Cita();
                $cita->set($row);
                $citas[] = $cita;
            }
        }
        return $citas;
    }
    
    public function getCitasHistorial($id_acompaniante){
        $sql = 'select c.* from cita as c join viaje as v on c.id = v.id_cita join acompaniante as a on v.id_acompaniante = a.id where a.id = :id_acompaniante AND v.estado = :estado';
        $params = array(
            'id_acompaniante' => $id_acompaniante,
            'estado' => 'TERMINADO'
            );
        $res = $this->db->execute($sql, $params);
        $citas = array();
        if($res){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
                $cita = new Cita();
                $cita->set($row);
                $citas[] = $cita;
            }
        }
        return $citas;
    }
    
    public function getAllCitasFromFecha($fecha){
        $sql = 'select * from cita where fecha like :fecha';
        $params = array(
            'fecha' => '%' . fecha . '%'
            );
        $res = $this->db->execute($sql, $params);
        $citas = array();
        if($res){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
                $cita = new Cita();
                $cita->set($row);
                $citas[] = $cita;
            }
        }
        return $citas;
    }
    
    public function getAllCitasFromTipo($tipo){
        $sql = 'select * from cita where tipo = :tipo';
        $params = array(
            'tipo' => $tipo
            );
        $res = $this->db->execute($sql, $params);
        $citas = array();
        if($res){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
                $cita = new Cita();
                $cita->set($row);
                $citas[] = $cita;
            }
        }
        return $citas;
    }
    
    public function getAllCitasFromFam_disponible($fam_disponible){
        $sql = 'select * from cita where fam_disponible = :fam_disponible';
        $params = array(
            'fam_disponible' => $fam_disponible
            );
        $res = $this->db->execute($sql, $params);
        $citas = array();
        if($res){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
                $cita = new Cita();
                $cita->set($row);
                $citas[] = $cita;
            }
        }
        return $citas;
    }
    
    
    public function getPagedCitas($offset, $rpp){
        $sql = 'select * from cita limit '. $offset . ', ' . $rpp;
        $res = $this->db->execute($sql);
        $citas = array();
        if($res){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
                $cita = new Cita();
                $cita->set($row);
                $citas[] = $cita;
            }
        }
        return $citas;
    }
    
    public function countCita(){
        $sql = 'select count(*) from cita';
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