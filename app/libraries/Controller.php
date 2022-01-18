<?php

/*
 * Base Controllers
 * Loads the Models and the Views
*/

class Controller{

    //Load Model
    public function model($model){
        require_once '../app/models/' . $model . '.php'; //require the model file
        return new $model(); //Instantiate the model
    }

    //Load view
    public function view($view, $data = []){
        if(file_exists('../app/views/' . $view . '.php')){
            require_once '../app/views/' . $view . '.php';
        }else{
            die('View does not exist');
        }
    }

}