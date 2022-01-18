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
//                //Hash the password
//                $hashedPW = password_hash($data['password'], PASSWORD_DEFAULT);


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

    public function changePassword()
    {
        $data = [];
        $this->view('admins/changePassword', $data);
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
}
