<?php

class TemplateController extends Controller { 

    function __construct(Model $model) {
        parent::__construct($model);
    }
    
    function index() {
        if($this->isLogged()) {
            $this->getModel()->setData('file', '_dashboard.html');
        } else {
            $this->getModel()->setData('file', '_login.html');
        }
    }
    
    function logout(){
        $this->getSession()->logout();
        $this->index();
    }
}