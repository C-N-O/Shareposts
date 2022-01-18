<?php
/*
 * App Core Class
 * It creates URL and loads Core Controller
 * URL FORMAT - /controller/method/params
 */

class Core{

    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct(){
        $url = $this->getURL();

        //Look in controllers for first value in the $url array
        if(file_exists('../app/controllers/' . ucwords($url[0]) . '.php')){
            $this->currentController = ucwords($url[0]); //set as controller
            unset($url[0]);
        }

        //Require the controller
        require_once '../app/controllers/' . $this->currentController . '.php';

        //Instantiate the controller class
        $this->currentController = new $this->currentController;

        //Check for second part of url and if the method in that second part exists in the class
        if(isset($url[1])){
            if(method_exists($this->currentController, $url[1])){
                $this->currentMethod = $url[1]; //set as current method
                unset($url[1]);
            }
        }

        //Get Params
        $this->params = $url ? array_values($url) : [];

        //Call a callback with array of params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getURL(){
        if(isset($_GET['url'])){
            $url = rtrim($_GET['url'], '/'); //strip any / after the url
            $url = filter_var($url, FILTER_SANITIZE_URL); //it shouldn't have any non-url chars
            return explode('/', $url); //break up the url into an array using the separator and return
        }
    }
}