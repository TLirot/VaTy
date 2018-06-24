<?php

class AcompanianteController extends Controller {
    
    function getAllAcompaniantes(){
        $id = $this->getData('id');
        $acompaniantes = $this->getModel()->getAllAcompaniantes($id);
        if($acompaniantes!= null){
            $acompaniantesAjax=[];
            foreach($acompaniantes as $acompaniante){
                $acompaniantesAjax[] = $acompaniante->getAttributesValues();
            }
            $this->getModel()->setData('acompaniantes', $acompaniantesAjax);
        }else{
            $this->getModel()->setData('error', 'Error en la consulta');
        }
    }
     function getAcompaniante(){
        $id = $this->getData('id');
        $acompaniante = $this->getModel()->getAcompaniante($id);
        if($acompaniante){
            $this->getModel()->setData('acompaniante', $acompaniante);            
        }else{
            $this->getModel()->setData('mensaje', 'Error en la consulta.');
        }

    }
    function editAcompaniante(){
        $id = $this->getData('id');
        $direccion = $this->getData('direccion');
        $cp = $this->getData('cp');
        $telefono = $this->getData('telefono');
        $r = $this->getModel()->editAcompaniante($id, $direccion, $cp, $telefono);
        if($r == 1){
            $mensaje = 'Información editada correctamente.';
        }else{
            $mensaje = 'Error al editar los campos de información.';
        }
        $this->getModel()->setData('mensaje', $mensaje);
    }
    
    function getCitasAvaiableFromResidencia(){
        $id_acompaniante = $this->getData('id_acompaniante');
        $citas = $this->getModel()->getCitasAvaiableFromResidencia($id_acompaniante);
        if($citas){
            $citasAjax = [];
            foreach($citas as $cita){
                $citasAjax[] = $cita->getAttributesValues();
            }
            $this->getModel()->setData('citas', $citasAjax);
        }
    }
    
    function addViaje(){
        $id_acompaniante = $this->getData('id_acompaniante');
        $id_cita = $this->getData('id_cita');
        $r = $this->getModel()->addViaje($id_acompaniante, $id_cita);
        if($r > 0){
            $mensaje = 'Viaje aceptado.';
        }else{
            $mensaje = 'Error al asignar';
        }
        $this->getModel()->setData('mensaje', $mensaje);
    }
    
    function getCitasAceptadas(){
        $id_acompaniante = $this->getData('id_acompaniante');
        $citas = $this->getModel()->getCitasAceptadas($id_acompaniante);
        if($citas){
            $citasAjax = [];
            foreach($citas as $cita){
                $citasAjax[] = $cita->getAttributesValues();
            }
            $this->getModel()->setData('citas', $citasAjax);
        }
    }
    
     function getCitasHistorial(){
        $id_acompaniante = $this->getData('id_acompaniante');
        $citas = $this->getModel()->getCitasHistorial($id_acompaniante);
        if($citas){
            $citasAjax = [];
            foreach($citas as $cita){
                $citasAjax[] = $cita->getAttributesValues();
            }
            $this->getModel()->setData('citas', $citasAjax);
        }
     }
    
    function editViajeIniciar(){
        $id_viaje = $this->getData('id_viaje');
        $r = $this->getModel()->editViajeIniciar($id_viaje);
        if($r == 1){
            $mensaje = 'Viaje iniciado';
        }else{
            $mensaje = 'Error al inciar el viaje';
        }
        $this->getModel()->setData('mensaje', $mensaje);
    }
    
    function editViajeFinalizar(){
        $id_viaje = $this->getData('id_viaje');
        $r = $this->getModel()->editViajeFinalizar($id_viaje);
        if($r == 1){
            $mensaje = 'Viaje finalizado';
        }else{
            $mensaje = 'Error al finalizar el viaje';
        }
        $this->getModel()->setData('mensaje', $mensaje);
    }

}