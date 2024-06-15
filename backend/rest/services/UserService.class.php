<?php
require_once __DIR__ . "/BaseService.class.php";
require_once __DIR__ . "/../dao/UserDao.class.php";


class UserService extends BaseService{

    public $user_dao;
    public function __construct(){
        parent::__construct(new UserDao);
        $this->user_dao = $this->dao;
    }

    public function add_user($user){
        $user['pwd'] = password_hash($user['pwd'], PASSWORD_BCRYPT);
        return $this->user_dao->add_user($user);
    }

    public function get_all_users(){
        return $this->user_dao->get_all_users();
    }

    public function get_user_By_id($userId) {
        return $this->dao->get_user_By_id($userId);
    }

    public function update_user($user) {
        $id = $user['id'];
        unset($user['id']);

        $this->user_dao->update_user($id, $user );
    }


    // function getCustomerByFirstNameAndLastName($first_name, $last_name)
    // {
    //     return $this->dao->getCustomerByFirstNameAndLastName($first_name, $last_name);
    // }
}

