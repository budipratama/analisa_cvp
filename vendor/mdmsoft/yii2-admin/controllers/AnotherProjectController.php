<?php

namespace backend\controllers;
class AnotherProjectController{
    public function getController(){
        $controller = new CosController;
        $methods = get_class_methods($controller);
        print_r($methods);
    }
}