<?php

class ResidenciaModel extends Model{

    function getResidencia($id){
        $manager = new ResidenciaManager($this->getDataBase());
        return $manager->getResidencia($id);
    }

    function editResidencia($residencia){
        $manager = new ResidenciaManager($this->getDataBase());
        return $manager->editResidencia($residencia);
    }
    
    function getAllResidentesFromResidencia($id){
        $manager = new ResidenteManager($this->getDataBase());
        return $manager->getAllResidentesFromResidencia($id);
    }
    
    function addResidente($residente){
        $manager = new ResidenteManager($this->getDataBase());
        return $manager->addResidente($residente);
    }
    
    function removeResidente($id){
        $manager = new ResidenteManager($this->getDataBase());
        return $manager->removeResidente($id);
    }
    
    function editResidente($residente){
        $manager = new ResidenteManager($this->getDataBase());
        return $manager->editResidente($residente);
    }
    
    function getCitasFromResidente($id){
        $manager = new CitaManager($this->getDataBase());
        return $manager->getCitasFromResidente($id);
    }
    
    function getCita($id){
        $manager = new CitaManager($this->getDataBase());
        return $manager->getCita($id);
    }
    function addCita($cita){
        $manager = new CitaManager($this->getDataBase());
        return $manager->addCita($cita);
    }
    
    function removeCita($id){
        $manager = new CitaManager($this->getDataBase());
        return $manager->removeCita($id);
    }
    
    function getViaje($id_cita){
        $manager = new ViajeManager($this->getDataBase());
        return Util::unsetNumericKeys($manager->getViaje($id_cita));
    }
    

    function getCentroMedico($id){
        $manager = new CentroMedicoManager($this->getDataBase());
        return $manager->getCentroMedico($id);
    }
    
}