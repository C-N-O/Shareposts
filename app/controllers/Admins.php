<?php
class Admins extends Controller{

    public function __construct(){
        $this->adminModel = $this->model('Admin');
        $this->userModel = $this->model('User');
        $this->postModel = $this->model('Post');

    }


    public function login()
    {
        //check for POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Sanitize POST Data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => '',
            ];

            //Validate email on login page
            if (empty($data['email'])) {
                $data["email_err"] = "Please enter administrator email";
            }

            //Validate the password on the login page
            if (empty($data['password'])) {
                $data["password_err"] = "Please enter administrator password";
            }

            //Check that user exists in db
            //Check that password matches
            if ($this->adminModel->findAdminByEmail($data['email'])) {
                //user found
            } else {
                $data['email_err'] = 'No admins found with this email address';
            }

            //Make sure errors are empty
            if (empty($data['email_err']) && empty($data['password_err'])) {
               //Hash the password
                $hashedPW = password_hash($data['password'], PASSWORD_DEFAULT);


                //check and set logged in user
                $loggedInAdmin = $this->adminModel->login($data['email'], $data['password']);

                if ($loggedInAdmin) {
                    //create session
                    $this->createAdminSession($loggedInAdmin);
                } else {
                    $data['password_err'] = "Password Incorrect";
                    $this->view('admins/login', $data);
                }
            } else {
                $this->view('admins/login', $data);
            }
        } else {
            //Init data
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => ''
            ];
            //load view
            $this->view('admins/login', $data);
        }
    } //END LOGIN

    public function createAdminSession($admin)
    {
        $data = [
            'id' => $admin->id,
            'name' => $admin->name,
            'email' => $admin->email,
        ];

        session_start();

        $_SESSION['admin_id'] = $admin->id;
        $_SESSION['admin_name'] = $admin->name;
        $_SESSION['admin_email'] = $admin->email;

        redirect('admins');
    } //END CREATE Admin SESSION

    //logout admins
    public function logout()
    {
        unset($_SESSION['admin_id']);
        unset($_SESSION['admin_name']);
        unset($_SESSION['admin_email']);
        session_destroy();
        redirect('admins/login');
    }

    public function profile()
    {
        $data = [
            'id' => trim($_SESSION['admin_id']),
            'name' => trim($_SESSION['admin_name']),
            'email' => trim($_SESSION['admin_email']),
        ];

        //load view
        $this->view('admins/profile', $data);
    } //END PROFILE

    public function edit()
    {
        $data = [];
        $this->view('admins/edit', $data);
    }

    public function index()
    {
        if(isLoggedIn() == 'USER'){
            redirect('posts');
        }

        $users = $this->userModel->getAllUsers();
        $posts = $this->postModel->getPosts();
        $data = [
            'users' => $users,
            'posts' => $posts
        ];
        $this->view('admins/index', $data);
    }


    public function showUser($id){
        //$post = $this->postModel->getPostByID($id);
        $user = $this->userModel->getUserByID($id);

        $data = [
//   //delete all users posts
            'user' => $user
        ];
        $this->view('admins/showUser', $data);
    }


    public function showUserPosts($id){
        $user = $this->userModel->getUserByID($id);
        $post = $this->postModel->getAllPostsByUser($id);
        $data = [
            'user' => $user,
            'posts' => $post
        ];
        $this->view('admins/showAllUserPosts', $data);
    }

    public function changePassWord()
    {
        //check for POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Sanitize POST Data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => trim($_SESSION['admin_id']),
                'name' => trim($_SESSION['admin_name']),
                'email' => trim($_SESSION['admin_email']),
                'old_password' => trim($_POST['old-password']),
                'new_password' => trim($_POST['new-password']),
                'confirm_new_password' => trim($_POST['confirm-new-password']),
                'old_password_err' => '',
                'new_password_err' => '',
                'confirm_new_password_err' => '',
            ];

            //Validate that old password field is not empty on change password page and matches old pw in database
            if (empty($data['old_password'])){
                $data["old_password_err"] = "Please enter your old password";
            } else {
                $admin = $this->adminModel->getAdminByID($_SESSION['admin_id']);
                if (!password_verify($data['old_password'], $admin->password)) {
                    $data["old_password_err"] = "This password does not match your old password";
                }
            }

            //Validate new password field is not empty on change password page and meets 6 char requirement
            if (empty($data['new_password'])){
                $data["new_password_err"] = "Please enter your new password";
            } elseif (strlen($data['new_password']) < 6){
                $data["new_password_err"] = "New password must be at least 6 characters";
            } else{
                $data['new_password_err'] = "";
            }

            //Validate confirm new password field is not empty on change password page
            if (empty($data['confirm_new_password'])){
                $data["confirm_new_password_err"] = "Please confirm your new password";
            }elseif($data['new_password'] != $data['confirm_new_password']){
                $data["confirm_new_password_err"] = "Passwords do not match";
            }


            //Make sure errors are empty
            if (empty($data['old_password_err']) && empty($data['new_password_err']) && empty($data['confirm_new_password_err'])) {

                //Hash the password
                $data['new_password'] = password_hash($data['new_password'], PASSWORD_DEFAULT);

                //Do the actual password update
                if($this->adminModel->updatePassword($data)){
                    flash('admin_message', 'Your Admin password has been updated');
                    $this->view('admins/profile', $data);
                }else{
                    die('Admin password could not be updated');
                }

            } else{
                $this->view('admins/changePassword', $data);
            }

        } else {
            //Init data
            $data = [
                'old_password' => '',
                'new_password' => '',
                'confirm_new_password' => '',
                'old_password_err' => '',
                'new_password_err' => '',
                'confirm_new_password_err' => '',
            ];
            //load view
            $this->view('admins/changePassword', $data);
        }

    }
}
