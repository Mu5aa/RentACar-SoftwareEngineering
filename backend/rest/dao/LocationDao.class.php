<?php
require_once __DIR__ . '/BaseDao.class.php';


class LocationDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct("locations");
    }


    public function add_location($location) {
        return $this->add('locations', $location);
    }

    public function delete_location_by_id() {
        $this->delete('locations');
    }

    public function get_location_by_id($location_id){
        return $this->query_unique("SELECT * FROM locations WHERE id = :id", ["id" => $location_id]);
    }

    public function update_location($id, $location) {
        try {
            $query = "UPDATE locations SET name_point = :name_point, address = :address, town = :town, email = :email, phone = :phone, date_available = :date_available
                      WHERE id = :id";
            $this->execute($query, [
                'name_point' => $location['name_point'],
                'address' => $location['address'],
                'town' => $location['town'],
                'email' => $location['email'],
                'phone' => $location['phone'],
                'date_available' => $location['date_available'],
                'id' => $id
            ]);
        } catch (Exception $e) {
            // Log error
            error_log('Error updating location: ' . $e->getMessage());
            throw $e; // Rethrow the exception for higher-level handling
        }
    }
    
}

