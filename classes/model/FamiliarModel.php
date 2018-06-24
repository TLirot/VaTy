<?php

class FamiliarModel extends Model{
    
    function getAllFamiliares($id){
        $manager = new Residencia_famManager($this->getDataBase());
        return $manager->getAllFamiliares($id);
    }
    
    function getAllFam_res($id){
        $manager = new Residente_famManager($this->getDataBase());
        return $manager->getAllFam_res($id);
    }
    
    function addFam_res($residente_fam){
        $manager = new Residente_famManager($this->getDataBase());
        return $manager->addResidente_fam($residente_fam);
    }
    function removeFam_res($residente_fam){
        $manager = new Residente_famManager($this->getDataBase());
        return $manager->removeResidente_fam($residente_fam);
    }
    function getFamiliar($id){
        $manager = new FamiliarManager($this->getDataBase());
        return $manager->getFamiliar($id);
    }
    function editFamiliar($id, $direccion, $cp, $telefono){
        $manager = new FamiliarManager($this->getDataBase());
        return $manager->editFamiliar($id, $direccion, $cp, $telefono);
    }
    function getAllResidentesFromFamiliar($id_familiar){
        $manager = new ResidenteManager($this->getDataBase());
        $residentes = $manager->getAllResidentesFromFamiliar($id_familiar);
        $residentes = Util::unsetNumericKeysArray($residentes);
        return $residentes;
    }
    
    function editFam_disponible($id_cita, $fam_disponible){
        $manager = new CitaManager($this->getDataBase());
        return $manager->editFam_disponible($id_cita, $fam_disponible);
    }
}