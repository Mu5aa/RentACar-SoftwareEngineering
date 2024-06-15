<?php
require_once 'BaseService.class.php';
require_once __DIR__ . "/../dao/CarDao.class.php";

class CarService extends BaseService{

    public $car_dao;
    
    public function __construct(){
        parent::__construct(new CarDao);
        $this->car_dao = new CarDao();
    }

    public function get_car_by_id($car_id) {
        return $this->car_dao->get_car_by_id($car_id);
    }

    public function update_car($car, $car_id) {

        $this->car_dao->update_car($car_id, $car);
    }
    
}
