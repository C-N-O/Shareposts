<?php

class Post{
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function getPosts(){
        $this->db->query('SELECT *, 
                                posts.id as postId, 
                                users.id as userId,
                                posts.created_at as postCreated,
                                users.created_at as usersCreated
                                FROM posts 
                                INNER JOIN users 
                                ON posts.user_id = users.id 
                                ORDER BY posts.created_at DESC');
        return $this->db->resultSet();
    }

    public function addPost($post){
        $this->db->query('INSERT INTO posts (user_id, title, body) VALUES(:user_id, :title, :body)');

        //bind values
        $this->db->bind(':user_id', $post['user_id']);
        $this->db->bind(':title', $post['title']);
        $this->db->bind(':body', $post['body']);

        //execute
        if($this->db->execute())
            return true;
        else
            return false;
    }

    public function updatePost($post){
        $this->db->query('UPDATE posts SET title = :title, body = :body WHERE id = :id');

        //bind values
        $this->db->bind(':id', $post['id']);
        $this->db->bind(':title', $post['title']);
        $this->db->bind(':body', $post['body']);

        //execute
        if($this->db->execute())
            return true;
        else
            return false;
    }

    public function getPostByID($id){
        $this->db->query("SELECT * FROM posts WHERE id=:id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function deletePost($id){
        $this->db->query('DELETE FROM posts WHERE id = :id');

        //bind values
        $this->db->bind(':id', $id);

        //execute
        if($this->db->execute())
            return true;
        else
            return false;
    }

    public function deleteAllPostsByUser($userId){
        $this->db->query('DELETE FROM posts WHERE user_id = :id');

        //bind values
        $this->db->bind(':id', $userId);

        //execute
        if($this->db->execute())
            return true;
        else
            return false;
    }

    public function getAllPostsByUser($userId){
        $this->db->query('SELECT * FROM posts WHERE user_id = :id');

        //bind values
        $this->db->bind(':id', $userId);
        return $this->db->resultSet();
    }

}
