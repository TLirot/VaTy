<?php

class UsuarioController extends Controller { 

    function __construct(Model $model) {
        parent::__construct($model);
    }
    
    function login(){
        $usuario = new Usuario();
        $usuario->readAjax();
        $usuarioBD = $this->getModel()->getUsuario($usuario->get_nick());
        if($usuarioBD && Util::verifyPass($usuario->get_password(), $usuarioBD->get_password())){
            $this->getSession()->login($usuarioBD);
        }else{
            $this->getModel()->setData('error', 'Credenciales incorrectas');
        }
    }
    function logintoken(){
        $usuario = new Usuario();
        $usuario->readAjax();
        $usuarioBD = $this->getModel()->getUsuario($usuario->get_nick());
        if($usuarioBD && Util::verifyPass($usuario->get_password(), $usuarioBD->get_password())){
            $this->getModel()->setData('usuario', $usuarioBD->getAttributesValues());
            $this->getSession()->login($usuarioBD);
            $tokenAuthorization = new TokenAuthorization();
            $token = $tokenAuthorization->generateToken($usuarioBD);
            $this->getModel()->setData('token', $token);
        }else{
            $this->getModel()->setData('error', 401);
            $this->getModel()->setData('errormsg', 'Wrong Credentials');
        }
    }
    function getUserData(){
        $rol = $this->getUser()->get_rol();
        $id = $this->getUser()->get_id();
        switch($rol){
                case 'RES':
                    $userData = $this->getModel()->getResidencia($id);
                    $this->getModel()->setData('usuario', $userData->getAttributesValues());
                    break;
                case 'FAM':
                    $userData = $this->getModel()->getFamiliar($id);
                     $this->getModel()->setData('usuario', $userData);
                    break;
                case 'ACO':
                    $userData = $this->getModel()->getAcompaniante($id);
                    $this->getModel()->setData('usuario', Util::unsetNumericKeys($userData));
                    break;
            }
            $this->getModel()->setData('rol', $rol);
    }
    function getAll(){
        $usuariosAll = $this->getModel()->getAll();
        $usuariosJson = [];
        foreach($usuariosAll as $usuario){
            $usuariosJson[] = $usuario->getAttributesValues();
        }
        $this->getModel()->setData('allusuarios', $usuariosJson);
    }
    function getAllCentros(){
        $centros = $this->getModel()->getAllCentros();
        if($centros != null){
            $centrosAjax = [];
            foreach($centros as $centro){
                $centrosAjax[] = $centro->getAttributesValues();
            }
            $this->getModel()->setData('centros', $centrosAjax);
        }else{
            $this->getModel()->setData('mensaje', 'No existen centros médicos');
        }
    }
    function getResidente(){
        $id = $this->getData('id');
        $residente = $this->getModel()->getResidente($id);
        if($residente != null){
            $this->getModel()->setData('residente', $residente->getAttributesValues());
        }else{
            $this->getModel()->setData('mensaje', 'No existe el residente.');
        }
    }
    
    function addUsuario(){
        $usuario = new Usuario();
        $usuario->readAjax();
        $usuario->set_password($usuario->get_nick());
        $usuario->set_fecha_alta(new DateTime());
        $r = $this->getModel()->addUsuario($usuario);
        if($r>0){
            if($usuario->get_rol() == 'FAM'){
                $familiar = new Familiar();
                $familiar->readAjax();
                $familiar->set_id_usuario($r);
                $r_f = $this->getModel()->addFamiliar($familiar);
                if($r_f > 0){
                  $id_residencia = $this->getData('id_residencia');
                  $res_fam = new Residencia_fam(null, $r_f, $id_residencia);
                  $r_res_fam = $this->getModel()->addRes_fam($res_fam);
                  if($r_res_fam){
                    $mensaje = 'Guardado del familiar, correcto.';    
                  }else{
                      $mensaje='Error al añadir a la residencia';
                  }
                }else{
                    $this->getModel()->removeUsuario($r);
                    $mensaje = 'El familiar ya existe.';
                }
            }else{
                $acompaniante = new Acompaniante();
                $acompaniante->readAjax();
                $acompaniante->set_id_usuario($r);
                $r_a = $this->getModel()->addAcompaniante($acompaniante);
                if($r_a > 0){
                 $id_residencia = $this->getData('id_residencia');
                  $res_aco = new Residencia_aco(null, $r_a, $id_residencia);
                  $r_res_aco = $this->getModel()->addRes_aco($res_aco);
                  if($r_res_aco){
                    $mensaje = 'Guardado del acompañante, correcto.';    
                  }else{
                      $mensaje='Error al añadir a la residencia';
                  }
                }else{
                  $mensaje = 'El acompañante ya existe.';
                }
            }      
        }else{
            $mensaje = 'El usuario ya existe.';
        }
        $this->getModel()->setData('mensaje', $mensaje);
        
    }
    
    
    function editPassword(){
        $password = $this->getData('password');
        $old_password = $this->getData('old_password');
        if(Util::verifyPass($old_password, $this->getUser()->get_password())){
            $r = $this->getModel()->editPassword($this->getUser()->get_id(), $password);
            if($r == 1){
                $mensaje = 'Contraseña cambiada correctamente';
                $nick = $this->getUser()->get_nick();
                $this->getSession()->logout();
                $this->getSession()->login($this->getModel()->getUsuario($nick));
            }else{
                $mensaje = 'Error al cambiar la contraseña';
            }
            $this->getModel()->setData('mensaje', $mensaje);
        }else{
            $this->getModel()->setData('mensaje', 'La contraseña antigua no es correcta.');
        }
    }
    
    function removeUsuario(){
        $id = $this->getData('id');
        $r = $this->getModel()->removeUsuario($id);
        if($r == 1){
            $mensaje = 'Usuario eliminado.';
        }else{
            $mensaje = 'Error al eliminar el usuario';
        }
        $this->getModel()->setData('mensaje', $mensaje);
    }
}