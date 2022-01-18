<?php

class Pages extends Controller
{

   public function __construct(){

    }

    //we need to define this method as it is our default page
    public function index(){

       if(isLoggedIn() == 'USER'){
           redirect('posts');
       }elseif(isLoggedIn() == 'ADMIN'){
           redirect('admins');
       }

        $data = [
            'title' => "Welcome to SharePosts",
            'description' => 'Simple Social Network built on an MVC Framework'
        ];

        $this->view('pages/index', $data);
    }

    public function about(){
        $data = [
            'title' => "About Us",
            'description' => 'App to share posts with other users'
        ];
        $this->view('pages/about', $data);
    }


}