<?php

class UsuarioModel extends Model{
    
    function getUsuario($nick){
        $manager = new UsuariosManager($this->getDataBase());
        return $manager->getUsuarioFromNick($nick);
    }
    
    function getAll(){
        $manager = new UsuariosManager($this->getDataBase());
        return $manager->getAll();
    }
    
    // function getResidenciaJoinUsuarios($id){
    //     $manager = new UsuariosManager($this->getDataBase());
    //     return $manager->getResidenciaJoinUsuarios($id);
    // }
    
    function getResidencia($id){
        $manager = new UsuariosManager($this->getDataBase());
        return $manager->getResidencia($id);
    }
    function getFamiliar($id){
        $manager = new UsuariosManager($this->getDataBase());
        return $manager->getFamiliar($id);
    }
    function getAcompaniante($id){
        $manager = new UsuariosManager($this->getDataBase());
        return $manager->getAcompaniante($id);
    }
    function getResidente($id){
        $manager = new ResidenteManager($this->getDataBase());
        return $manager->getResidente($id);
    }
    function getAllCentros(){
        $manager = new CentroMedicoManager($this->getDataBase());
        return $manager->getAll($id);
    }
    
    function addUsuario($usuario){
        $manager = new UsuariosManager($this->getDataBase());
        return $manager->addUsuario($usuario);
    }
    
    function removeUsuario($id){
        $manager = new UsuariosManager($this->getDataBase());
        return $manager->removeUsuario($id);
    }
    
    function addFamiliar($familiar){
        $manager = new FamiliarManager($this->getDataBase());
        return $manager->addFamiliar($familiar);
    }
    function addRes_fam($res_fam){
        $manager = new Residencia_famManager($this->getDataBase());
        return $manager->addResidencia_fam($res_fam);
    }
    function addAcompaniante($acompaniante){
        $manager = new AcompanianteManager($this->getDataBase());
        return $manager->addAcompaniante($acompaniante);
    }
    function addRes_aco($res_aco){
        $manager = new Residencia_acoManager($this->getDataBase());
        return $manager->addResidencia_aco($res_aco);
    }
    
    function editPassword($id, $password){
         $manager = new UsuariosManager($this->getDataBase());
        return $manager->editPassword($id, $password);
    }
}