<?php

class Users extends Controller
{

    public function __construct()
    {
        $this->userModel = $this->model('User');
        $this->postModel = $this->model('Post');
    }

    //Check if a POST was made then process the form, else load the form
    public function register()
    {
        //check for POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Sanitize POST Data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
            ];

            //Validate email on register page
            if (empty($data['email']))
                $data["email_err"] = "Please enter email";
            elseif ($this->userModel->findUserByEmail($data['email']))
                $data["email_err"] = "Email is already taken";

            //Validate name on register page
            if (empty($data['name']))
                $data["name_err"] = "Please enter name";

            //Validate password on register page
            if (empty($data['password']))
                $data["password_err"] = "Please choose a password";
            elseif (strlen($data['password']) < 6)
                $data["password_err"] = "Password must be at least 6 characters";

            //Validate confirm password on register page
            if (empty($data['confirm_password']))
                $data["confirm_password_err"] = "Please confirm password";
            elseif ($data['password'] != $data['confirm_password'])
                $data["confirm_password_err"] = "Passwords do not match";

            //Make sure errors are empty
            if (empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
                //Hash the password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                //Register User
                if ($this->userModel->register($data)) {
                    flash('register_success', 'You have successfully registered, you can now login');
                    redirect('users/login');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('users/register', $data);
            }

        } else {
            //Init data
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
            ];
            //load view
            $this->view('users/register', $data);
        }
    } //END REGISTER

    //login
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
                $data["email_err"] = "Please enter email";
            }

            //Validate the password on the login page
            if (empty($data['password'])) {
                $data["password_err"] = "Please enter password";
            }

            //Check that user exists in db
            //Check that password matches
            if ($this->userModel->findUserByEmail($data['email'])) {
                //user found
            } else {
                $data['email_err'] = 'No user found with this email address';
            }

            //Make sure errors are empty
            if (empty($data['email_err']) && empty($data['password_err'])) {
                //check and set logged in user
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                if ($loggedInUser) {
                    //create session
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['password_err'] = "Password Incorrect";
                    $this->view('users/login', $data);
                }
            } else {
                $this->view('users/login', $data);
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
            $this->view('users/login', $data);
        }
    } //END LOGIN

    public function createUserSession($user)
    {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_name'] = $user->name;
        $_SESSION['user_email'] = $user->email;

        redirect('posts');
    } //END CREATE USER SESSION


    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_email']);
        session_destroy();

        redirect('users/login');
    }


    //login
    public function profile()
    {
        $data = [
            'id' => trim($_SESSION['user_id']),
            'name' => trim($_SESSION['user_name']),
            'email' => trim($_SESSION['user_email']),
        ];

        //load view
        $this->view('users/profile', $data);
    } //END PROFILE


    //edit
    public function edit()
    {
        //check for POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Sanitize POST Data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => trim($_SESSION['user_id']), //the current session id
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'name_err' => '',
                'email_err' => '',
            ];

            //Validate email on edit page
            if (empty($data['email'])) {
                $data["email_err"] = "Please enter email";
            }

            //Validate the name on the edit page
            if (empty($data['name'])) {
                $data["name_err"] = "Please enter your name";
            }


            //Make sure errors are empty
            if (empty($data['email_err']) && empty($data['name_err'])) {

                if ($this->userModel->updateUser($data)) {
                    flash('user_message', 'User Updated');

                    //reset session name and email after they are updated
                    $_SESSION['user_name'] = $data['name'];
                    $_SESSION['user_email'] = $data['email'];

                    $this->view('users/profile', $data);
                } else {
                    die('User could not be updated');
                }
            } else {
                //if there are errors, load the edit page with errors
                $this->view('users/edit', $data);
            }
        } else {
            $data = [
                'id' => trim($_SESSION['user_id']),
                'name' => trim($_SESSION['user_name']),
                'email' => trim($_SESSION['user_email']),
            ];

            //load view
            $this->view('users/edit', $data);
        }
    } //END EDIT

///////////////////////


    public function changePassWord()
    {
        //check for POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Sanitize POST Data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => trim($_SESSION['user_id']),
                'name' => trim($_SESSION['user_name']),
                'email' => trim($_SESSION['user_email']),
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
                $user = $this->userModel->getUserByID($_SESSION['user_id']);
                if (!password_verify($data['old_password'], $user->password)) {
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
                if($this->userModel->updatePassword($data)){
                    flash('user_message', 'Your password has been updated');
                    $this->view('users/profile', $data);
                }else{
                    die('User password could not be updated');
                }

            } else{
                $this->view('users/changePassword', $data);
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
            $this->view('users/changePassword', $data);
        }

    }

    public function confirmDelete(){
        $this->view('users/confirmDelete', null);
    }



    public function delete(){
        $this->postModel->deleteAllPostsByUser($_SESSION['user_id']); //first, delete all user's posts

        if($this->userModel->deleteUser($_SESSION['user_id'])){
            unset($_SESSION['user_id']);
            unset($_SESSION['user_name']);
            unset($_SESSION['user_email']);
            session_destroy();

            $this->view('users/delete');

        }else{
            die("User could not be deleted");
        }
    }
}