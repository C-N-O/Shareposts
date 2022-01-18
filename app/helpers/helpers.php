<?php

//To create a flash, call: flash('register_success', 'You are now registered')
//To display a flash: echo flash('register_success')

session_start();

//Flash Message helper
function flash($name='', $message='', $class='alert alert-success'){
    if(!empty($name)){
        if(!empty($message) && empty($_SESSION[$name])){
            if(!empty($_SESSION[$name])){
                unset($_SESSION[$name]);
             }

             if(!empty($_SESSION[$name.'_class'])){
                 unset($_SESSION[$name.'_class']);
             }

             $_SESSION[$name] = $message;
              $_SESSION[$name.'_class'] = $class;
        }elseif (empty($message) && !empty($_SESSION[$name])){
            $class = !empty($_SESSION[$name.'_class']) ? $_SESSION[$name.'_class'] : '';
            echo '<div class="'.$class.'" id="msg-flash">'.$_SESSION[$name].'</div>';
            unset($_SESSION[$name]);
            unset($_SESSION[$name.'_class']);
        }
    }
}

//redirect helper
function redirect($toURL){
    header('location: ' . URLROOT . '/' . $toURL);
}

//check if user is logged in
function isLoggedIn(){
    if(isset($_SESSION['user_id'])){
        return 'USER';
    }elseif(isset($_SESSION['admin_id'])){
        return 'ADMIN';
    }
    else{
        return false;
    }
}
