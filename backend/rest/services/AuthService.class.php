<?php

require_once __DIR__ . '/../dao/AuthDao.class.php';

class AuthService {
    private $auth_dao;

    public function __construct() {
        $this->auth_dao = new AuthDao();
    }

    public function get_user_by_email($email){
        return $this->auth_dao->get_user_by_email($email);
    }

    public function register_user($user) {
        // Ensure email uniqueness
        $existing_user = $this->auth_dao->get_user_by_email($user['email']);
        if ($existing_user) {
            throw new Exception("Email already registered");
        }

        // Insert new user into the database
        return $this->auth_dao->insert_user($user);
    }
}
