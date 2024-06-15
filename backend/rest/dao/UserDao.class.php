<?php
require_once __DIR__ . '/BaseDao.class.php';


class UserDao extends BaseDao{

    public function __construct(){
        parent::__construct("users");
    }

    public function add_user($user){
        return $this->add('users', $user);
    }

    public function get_user_by_id($user_id){
        return $this->query_unique("SELECT * FROM cars WHERE id = :id", ['id' => $user_id]);
    }

    public function get_all_users(){
        try {
            $query = "SELECT * FROM users";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            throw new \Exception("Error retrieving users: " . $e->getMessage());
        }
    }

    public function delete_user_by_id() {
        $this->delete('users');
    }

    public function update_user($id, $user) {
        $query = "UPDATE users SET first_name = :first_name, last_name = :last_name, email = :email
                  WHERE id = :id";
        $this->execute($query, [
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'email' => $user['email'],
            'id' => $id
        ]);
    }

    
    function getCustomerByFirstNameAndLastName($first_name, $last_name){
        return $this->query_unique("SELECT * FROM users WHERE  = :first_name AND last_name = :last_name", ["first_name" => $first_name, "last_name" => $last_name]);
    }
}
