<?php
require_once __DIR__ . '/BaseDao.class.php';

class AuthDao extends BaseDao {
    public function __construct() {
        parent::__construct('users');
    }

    public function get_user_by_email($email) {
        $query = "SELECT *
                  FROM users
                  WHERE email = :email";
        return $this->query_unique($query, ['email' => $email]);
    }

    public function insert_user($user) {
        $query = "INSERT INTO users (first_name, last_name, email, pwd)
                  VALUES (:first_name, :last_name, :email, :pwd)";
        return $this->execute($query, [
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'email' => $user['email'],
            'pwd' => $user['pwd']
        ]);
    }
}
