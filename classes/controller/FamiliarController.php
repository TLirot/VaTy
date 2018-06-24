<?php

class FamiliarController extends Controller {
    
        // TODOS LOS FAMILIARES DE LA RESIDENCIA
    function getAllFamiliares(){
        $id = $this->getData('id');
        $familiares = $this->getModel()->getAllFamiliares($id);
        if($familiares!= null){
            $familiaresAjax=[];
            foreach($familiares as $familiar){
                $familiaresAjax[] = $familiar->getAttributesValues();
            }
            $this->getModel()->setData('familiares', $familiaresAjax);
        }else{
            $this->getModel()->setData('error', 'Error en la consulta');
        }
    }
    // TODOS LOS FAMILIARES DE UN RESIDENTE
    function getAllFam_res(){
        $id = $this->getData('id');
        $familiares = $this->getModel()->getAllFam_res($id);
        if($familiares!= null){
            $familiaresAjax=[];
            foreach($familiares as $familiar){
                $familiaresAjax[] = $familiar->getAttributesValues();
            }
            $this->getModel()->setData('familiares', $familiaresAjax);
        }else{
            $this->getModel()->setData('error', 'Error en la consulta');
        }
    }
    // RELACION FAMILIAR RESIDENTE
    function addFam_res(){
        $residente_fam = new Residente_fam();
        $residente_fam->readAjax();
        $r = $this->getModel()->addFam_res($residente_fam);
        if($r > 0){
            $mensaje = 'Asignado correctamente';
        }else{
            $mensaje = 'Ya existe esa asignación';
        }
        $this->getModel()->setData('mensaje', $mensaje);
    }
    // ELIMINAR RELACION FAMILIAR RESIDENTE
    function removeFam_res(){
        $residente_fam = new Residente_fam();
        $residente_fam->readAjax();
        $r = $this->getModel()->removeFam_res($residente_fam);
        if($r > 0){
            $mensaje = 'Desasignado correctamente';
        }else{
            $mensaje = 'Ya existe esa asignación';
        }
        $this->getModel()->setData('mensaje', $mensaje);
    }
    
    function getFamiliar(){
        $id = $this->getData('id');
        $familiar = $this->getModel()->getFamiliar($id);
        if($familiar){
            $this->getModel()->setData('familiar', $familiar);            
        }else{
            $this->getModel()->setData('mensaje', 'Error en la consulta.');
        }
    }
    function editFamiliar(){
        $id = $this->getData('id');
        $direccion = $this->getData('direccion');
        $cp = $this->getData('cp');
        $telefono = $this->getData('telefono');
        $r = $this->getModel()->editFamiliar($id, $direccion, $cp, $telefono);
        if($r == 1){
            $mensaje = 'Información editada correctamente.';
        }else{
            $mensaje = 'Error al editar los campos de información.';
        }
        $this->getModel()->setData('mensaje', $mensaje);
    }
    
    function getAllResidentesFromFamiliar(){
        $id_familiar = $this->getData('id');
        $residentes = $this->getModel()->getAllResidentesFromFamiliar($id_familiar);
        if($residentes){
            $this->getModel()->setData('usuarios', $residentes);
        }else{
            $this->getModel()->setData('mensaje', 'Error en la consulta');
        }
    }
    
    function editFam_disponible(){
        $id_cita = $this->getData('id_cita');
        $fam_disponible = $this->getData('fam_disponible');
        $r = $this->getModel()->editFam_disponible($id_cita, $fam_disponible);
        $this->getModel()->setData('respuesta', $r);
    }

}