<?php
require_once __DIR__ . '/BaseDao.class.php';


class CarDao extends BaseDao
{
    

    public function __construct()
    {
        parent::__construct('cars');  
    }

    public function add_car($car) {
        return $this->add('cars', $car);
    }

    public function get_car_by_id($car_id){
        return $this->query_unique("SELECT * FROM cars WHERE id = :id", ['id' => $car_id]);
    }

    public function delete_car_by_id() {
        $this->delete('cars');
    }

    public function update_car($id, $car) {
        $query = "UPDATE cars SET name = :name, manufacturer = :manufacturer, price = :price, description = :description, mileage = :mileage, transmission = :transmission, seats = :seats, luggage = :luggage, fuel = :fuel
                  WHERE id = :id";
        $this->execute($query, [
            'name' => $car['name'],
            'manufacturer' => $car['manufacturer'],
            'price' => $car['price'],
            'description' => $car['description'],
            'mileage' => $car['mileage'],
            'transmission' => $car['transmission'],
            'seats' => $car['seats'],
            'luggage' => $car['luggage'],
            'fuel' => $car['fuel'],
            'id' => $id
        ]);
    }
    
}
