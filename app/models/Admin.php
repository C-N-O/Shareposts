<?php

class Admin{
    private $db;

    public function __construct(){
        $this->db = new Database;
    }


    public function findAdminByEmail($email){
        $this->db->query('SELECT * FROM admins WHERE email= :email');
        $this->db->bind(':email', $email);
        $this->db->single();

        if($this->db->rowCount() > 0)
            return true;
        else
            return false;

    }

    public function login($email, $password){
        $this->db->query('SELECT * FROM admins WHERE email= :email');
        $this->db->bind(':email', $email);
        $row = $this->db->single();

        if($password == $row->password){
            return $row;
        }else{
            return false;
        }
    }

    public function updatePassword($admin){
        $this->db->query("UPDATE admins SET password = :passwordParameter WHERE id = :idParameter");

        //bind values
        $this->db->bind(':idParameter', $admin['id']);
        $this->db->bind(':passwordParameter', $admin['new_password']);

        //execute
        if($this->db->execute())
            return true;
        else
            return false;

    }

    public function getAdminByID($id){
        $this->db->query("SELECT * FROM admins WHERE id=:id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

}