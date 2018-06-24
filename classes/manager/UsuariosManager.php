<?php

class UsuariosManager {
    
    private $db;
    
    function __construct(DataBase $db) {
        $this->db = $db;
    }
    
    public function addUsuario(Usuario $usuario) {
        $sql = 'insert into usuarios(nick, password, rol, correo)'.
                    'values (:nick, :password, :rol, :correo)';
        $params = array(
            'nick' => $usuario->get_nick(),
            'password' => Util::encrypt($usuario->get_password()),
            'rol' => $usuario->get_rol(),
            'correo' => $usuario->get_correo()
        );
        $res = $this->db->execute($sql, $params);
        if($res) {
            $id = $this->db->getId();
            $usuario->set_id($id);
        } else {
            $id = 0;
        }
        return $id;
    }
     public function removeUsuario($id) {
        $sql = 'delete from usuarios where id = :id';
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
     public function removeUsuarioRol($id_usuario) {
        $sql = 'delete from usuarios where id = :id_usuario';
        $params = array(
            'id' => $id_usuario
        );
        $res = $this->db->execute($sql, $params);
        if($res) {
            $affectedRows = $this->db->getRowNumber();
        } else {
            $affectedRows = -1;
        }
        return $affectedRows;
    }
    public function editUsuario(Usuario $usuario) {
        $sql = 'update usuarios set nick = :nick, password = :password, rol = :rol,'. 
                   'correo = :correo where id = :id';
        $params = array(
        'nick' => $usuario->get_nick(),
        'password' => Util::encrypt($usuario->get_password()),
        'rol' => $usuario->get_rol(),
        'correo' => $usuario->get_correo(),
        'id' => $usuario->get_id()
        );
        $res = $this->db->execute($sql, $params);
        if($res) {
            $affectedRows = $this->db->getRowNumber();
        } else {
            $affectedRows = -1;
        }
        return $affectedRows;
    }
    public function editPassword($id, $password) {
        $sql = 'update usuarios set password = :password where id = :id';
        $params = array(
        'password' => Util::encrypt($password),
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
        $sql = 'select * from usuarios';
        $res = $this->db->execute($sql);
        $usuarios = array();
        if($res){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
                $usuario = new Usuario();
                $usuario->set($row);
                $usuarios[] = $usuario;
            }
        }
        return $usuarios;
    }
    public function getUsuario($id){
        $sql = 'select * from usuarios where id = :id';
        $params = array(
            'id' => $id
        );
        $res = $this->db->execute($sql, $params);
        $statement = $this->db->getStatement();
        $usuario = new Usuario();
        if($res && $row = $statement->fetch()) {
            $usuario->set($row);
        } else {
            $usuario = null;
        }
        return $usuario;
    }
    
     public function getUsuarioFromNick($nick){
        $sql = 'select * from usuarios where nick = :nick';
        $params = array(
            'nick' => $nick
        );
        $res = $this->db->execute($sql, $params);
        $statement = $this->db->getStatement();
        $usuario = new Usuario();
        if($res && $row = $statement->fetch()) {
            $usuario->set($row);
        } else {
            $usuario = null;
        }
        return $usuario;
    }
    
    function getAllUsuariosFromNick($nick){
        $sql = 'select * from usuarios where nick like :nick';
        $params = array(
            'nick' => '%' . $nick . '%'
            );
        $res = $this->db->execute($sql, $params);
        $usuarios = array();
        if($res){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
                $usuario = new Usuario();
                $usuario->set($row);
                $usuarios[] = $usuario;
            }
        }
        return $usuarios;
    }
    
    public function getResidencia($id){
        $sql = 'select * from residencia where id_usuario = :id';
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
    
    public function getFamiliar($id){
        $sql = 'select f.*, u.correo as correo from familiar as f join usuarios as u on f.id_usuario = u.id where u.id = :id';
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
    
    public function getAcompaniante($id){
        $sql = 'select a.*, u.correo as correo from acompaniante as a join usuarios as u on a.id_usuario = u.id where u.id = :id';
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
    
    // function getResidenciaJoinUsuarios($id){
    //     $sql = 'SELECT u.id as u_id, u.nick as u_nick, u.password as u_password, u.rol as u_rol, u.correo as u_correo, u.fecha_alta as u_fecha_alta,'
    //     .'r.id as r_id, r.id_usuario as r_id_usuario, r.direccion as r_direccion, r.cp as r_cp, r.telefono as r_telefono'
    //     .'FROM usuarios AS u'
    //     .'JOIN residencia AS r ON u.id = r.id_usuario'
    //     .'WHERE r.id_usuario = :id;';
    //     $params = array(
    //         'id' => $id
    //         );
    //     $res = $this->db->execute($sql, $params);
    //     if($res && $row = $statement->fetch()) {
    //         return $row;
    //     } else{
    //         return null;
    //     }
    // }
    
    
    
    
    function getPagedUsuarios($offset, $rpp){
        $sql = 'select * from usuarios limit '. $offset . ', ' . $rpp;
        $res = $this->db->execute($sql);
        $usuarios = array();
        if($res){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
                $usuario = new Usuario();
                $usuario->set($row);
                $usuarios[] = $usuario;
            }
        }
        return $usuarios;
    }
    function countUsuarios(){
        $sql = 'select count(*) from usuarios';
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