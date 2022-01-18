<?php

//Load Config
require_once 'config/config.php';

//Load helper functions
require_once 'helpers/helpers.php';

//Autoload Libraries
spl_autoload_register(function($className){
    require_once 'libraries/' . $className . '.php';
});