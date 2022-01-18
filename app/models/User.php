<?php

class User{
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function register($user){
        $this->db->query('INSERT INTO users (name, email, password) VALUES(:name, :email, :password)');

        //bind values
        $this->db->bind(':name', $user['name']);
        $this->db->bind(':email', $user['email']);
        $this->db->bind(':password', $user['password']);

        //execute
        if($this->db->execute())
            return true;
        else
            return false;
    }

    public function findUserByEmail($email){
      $this->db->query('SELECT * FROM users WHERE email= :email');
      $this->db->bind(':email', $email);
      $this->db->single();

      if($this->db->rowCount() > 0)
        return true;
      else
          return false;
    }

    //login user
    public function login($email, $password){

        $this->db->query('SELECT * FROM users WHERE email= :email');
        $this->db->bind(':email', $email);
        $row = $this->db->single();

        if(password_verify($password, $row->password)){
           return $row;
        }else{
            return false;
        }
    }

    public function getUserByID($id){
        $this->db->query("SELECT * FROM users WHERE id=:id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function updateUser($user){
        $this->db->query("UPDATE users SET name = :nameParameter, email = :emailParameter WHERE id = :idParameter");

        //bind values
        $this->db->bind(':idParameter', $user['id']);
        $this->db->bind(':nameParameter', $user['name']);
        $this->db->bind(':emailParameter', $user['email']);

        //execute
        if($this->db->execute())
            return true;
        else
            return false;

    }

    public function updatePassword($user){
        $this->db->query("UPDATE users SET password = :passwordParameter WHERE id = :idParameter");

        //bind values
        $this->db->bind(':idParameter', $user['id']);
        $this->db->bind(':passwordParameter', $user['new_password']);

        //execute
        if($this->db->execute())
            return true;
        else
            return false;

    }

    public function deleteUser($id){
        $this->db->query('DELETE FROM users WHERE id = :id');

        //bind values
        $this->db->bind(':id', $id);

        //execute
        if($this->db->execute())
            return true;
        else
            return false;
    }

    public function getAllUsers(){
        $this->db->query('SELECT * FROM users');
        return $this->db->resultSet();
    }

}