<?php
    class User {
        private $db;

        public function __construct() {
            $this->db = new Database;
        }

        // Register
        function register($data) {
            $this->db->query('INSERT INTO users (name, mail, pass) VALUES(:name, :mail, :pass)');

            // Bind values
            $this->db->bind(':mail', $data['email']);
            $this->db->bind(':name', $data['name']);
            $this->db->bind(':pass', $data['password']);
            if($this->db->execute()) {
                return true;
            } else {
                return false;
            }

        }

        // Login
        function login ($data) {
            $this->db->query('SELECT * FROM users WHERE mail = :email');
            $this->db->bind(':email', $data['email']);
            $response = $this->db->single();
            if (!empty($response)) {
                if (password_verify($data['password'], $response->pass)) {
                    return $response;
                } else {
                    return false;
                };
            } else {
                return false;
            }
        }

        // Find user by email
        function findUserByEmail($email) {
            $this->db->query('SELECT * FROM users WHERE mail = :email');
            $this->db->bind(':email', $email);
            $row = $this->db->single();

            // Check row
            if($this->db->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }

        function getUserById($id) {
            $this->db->query('SELECT * FROM users WHERE id = :id');
            $this->db->bind(':id', $id);
            if ($row = $this->db->single()) {
                return $row;
            } else {
                return false;
            };


            // Check row
//            if($this->db->rowCount() > 0) {
//                return true;
//            } else {
//                return false;
//            }
        }
    }
