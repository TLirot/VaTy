<?php

class AcompanianteModel extends Model{
    function getAllAcompaniantes($id){
        $manager = new AcompanianteManager($this->getDataBase());
        return $manager->getAllAcompaniantes($id);
    }
    
    function getAcompaniante($id){
        $manager = new AcompanianteManager($this->getDataBase());
        return $manager->getAcompaniante($id);
    }
    function editAcompaniante($id, $direccion, $cp, $telefono){
        $manager = new AcompanianteManager($this->getDataBase());
        return $manager->editAcompaniante($id, $direccion, $cp, $telefono);
    }
    
    function getCitasAvaiableFromResidencia($id_acompaniante){
        $manager = new CitaManager($this->getDataBase());
        return $manager->getCitasAvaiableFromResidencia($id_acompaniante);
    }
    
    function addViaje($id_acompaniante, $id_cita){
        $manager = new ViajeManager($this->getDataBase());
        return $manager->addViaje($id_acompaniante, $id_cita);
    }
    
    function getCitasAceptadas($id_acompaniante){
        $manager = new CitaManager($this->getDataBase());
        return $manager->getCitasAceptadas($id_acompaniante);
    }
    
    function getCitasHistorial($id_acompaniante){
        $manager = new CitaManager($this->getDataBase());
        return $manager->getCitasHistorial($id_acompaniante);
    }
    
    function editViajeIniciar($id_viaje){
        $manager = new ViajeManager($this->getDataBase());
        return $manager->editViajeIniciar($id_viaje);
    }
    
    function editViajeFinalizar($id_viaje){
        $manager = new ViajeManager($this->getDataBase());
        return $manager->editViajeFinalizar($id_viaje);
    }
}