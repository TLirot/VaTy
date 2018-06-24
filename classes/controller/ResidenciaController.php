<?php

class ResidenciaController extends Controller {

    function __construct(Model $model) {
        parent::__construct($model);
    }
    
    function getResidencia(){
        $id = $this->getData('id');
        $residencia = $this->getModel()->getResidencia($id);
        if($residencia != null){
            $this->getModel()->setData('residencia', $residencia->getAttributesValues());   
        } else {
            $this->getModel()->setData('mdg', 'error en la consulta');   
        } 
    }
    
    function editResidencia(){
        $residencia = new Residencia();
        $residencia->readAjax();
        $r = $this->getModel()->editResidencia($residencia);
        if($r == 1){
            $mensaje = 'Editado Correcto';
            
        } else{
            $mensaje = 'Error en la edición';
        }
        $this->getModel()->setData('mensaje', $mensaje);
    }
    
    function getAllResidentesFromResidencia(){
        $id = $this->getUser()->get_id();
        $residentes = $this->getModel()->getAllResidentesFromResidencia($id);
        if($residentes != null){
            /*$residentesAjax=[];
            foreach($residentes as $r){
                $residentesAjax[] = $r->getAttributesValues();
            }*/
            $this->getModel()->setData('usuarios', $residentes);
        }else{
            $this->getModel()->setData('error', 'No hay residentes');
        }
    }
    
    function addResidente(){
     $residente = new Residente();
     $residente->readAjax();
     $residente->setId_residencia($this->getUser()->get_id());
     $r = $this->getModel()->addResidente($residente);
     if($r > 0){
         $mensaje = 'Añadido correctamente';
     }else{
         $mensaje = 'Error al guardar';
     }
     $this->getModel()->setData('mensaje', $mensaje);
    }
    
    function removeResidente(){
        $id=$this->getData('id');
        $r = $this->getModel()->removeResidente($id);
        if($r==1){
            $mensaje = 'Eliminado correctamente';
        }else{
            $mensaje = 'Error al eliminar';
        }
        $this->getModel()->setData('mensaje', $mensaje);
    }
    
    function editResidente(){
        $residente = new Residente();
        $residente->readAjax();
        $r = $this->getModel()->editResidente($residente);
        if($r == 1){
            $mensaje = 'Editado correctamente';
        }else{
            $mensaje = 'Error al editar';
        }
        $this->getModel()->setData('mensaje', $mensaje);
    }
    
    function getCitasFromResidente(){
        $id = $this->getData('id');
        $citas = $this->getModel()->getCitasFromResidente($id);
        if($citas != null){
            $citasAjax = [];
            foreach($citas as $cita){
                $citasAjax[]=$cita->getAttributesValues();
            }
         $this->getModel()->setData('citas', $citasAjax);   
        }
    }
    
    function getCita(){
        $id = $this->getData('id');
        $cita = $this->getModel()->getCita($id);
        if($cita){
            $this->getModel()->setData('cita', $cita->getAttributesValues());            
        }else{
            $this->getModel()->setData('error', 'Error en la consulta');
        }
    }
    
    function addCita(){
        $cita = new Cita();
        $cita->readAjax();
        $r = $this->getModel()->addCita($cita);
        if($r > 0){
            $mensaje = 'Cita guardada';
        }else{
            $mensaje = 'Error al guardar la cita';
        }
        $this->getModel()->setData('mensaje', $mensaje);
    }
    
    function removeCita(){
        $id = $this->getData('id');
        $r = $this->getModel()->removeCita($id);
        if($r == 1){
            $mensaje = 'Cita eliminada';
        }else{
            $mensaje = 'Error al eliminar la cita';
        }
        $this->getModel()->setData('mensaje', $mensaje);
    }
    
    function getViaje(){
        $id_cita = $this->getData('id_cita');
        $viaje = $this->getModel()->getViaje($id_cita);
        if($viaje){
           $this->getModel()->setData('viaje', $viaje);
        }else{
            $this->getModel()->setData('mensaje', 'No existe viaje.');
        }
    }
    
    function getCentroMedico(){
        $id = $this->getData('id');
        $centromedico = $this->getModel()->getCentroMedico($id);
        if($centromedico != null){
            $this->getModel()->setData('centromedico', $centromedico->getAttributesValues());
        }   
    }
}