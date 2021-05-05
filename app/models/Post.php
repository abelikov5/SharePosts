<?php


class Post {
    private $db;
    function __construct(){
        $this->db = new Database;
    }

    function getPosts() {
        $this->db->query(
                            "SELECT *, 
                                posts.creat_at as created,
                                posts.id       as postId
                                FROM posts
                                INNER JOIN users
                                ON posts.user_id = users.id
                                ORDER BY created DESC
                        ");

        $res = $this->db->resultSet();
        return $res;

    }

    function addPost($data) {
        $this->db->query('INSERT INTO posts (title, user_id, body) VALUES(:title, :user_id, :body)');

        // Bind values
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':body', $data['body']);
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function updatePost($data) {
        $this->db->query('UPDATE posts SET title = :title, body = :body WHERE id = :id');

        // Bind values
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':body', $data['body']);
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function getPostById ($id) {
        $this->db->query('SELECT * FROM posts WHERE id = :id');
        $this->db->bind(':id', $id[0]);
        $row = $this->db->single();
        return $row;
    }

    function deletePost ($id) {
        $id = $id[0];
        $this->db->query('DELETE FROM posts WHERE id = :id');

        // Bind values
        $this->db->bind(':id', $id);
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

}