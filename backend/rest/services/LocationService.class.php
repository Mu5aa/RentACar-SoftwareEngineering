<?php
require_once __DIR__ . "/BaseService.class.php";
require_once __DIR__ . "/../dao/LocationDao.class.php";


class LocationService extends BaseService{
    public $location_dao;


    public function __construct(){
        parent::__construct(new LocationDao);
        $this->location_dao = new LocationDao();

    }

    public function getById($location_id) {
        return $this->dao->get_location_by_id($location_id);
    }

    public function update_location($location) {
        try {
            $id = $location['id'];
            unset($location['id']);
    
            $this->location_dao->update_location($id, $location);
        } catch (Exception $e) {
            // Log error
            error_log('Error updating location: ' . $e->getMessage());
            throw $e; // Rethrow the exception for higher-level handling
        }
    }
    
}
