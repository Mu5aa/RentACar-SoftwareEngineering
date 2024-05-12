<?php
require_once __DIR__ . '/BaseDao.class.php';


class LocationDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct("locations");
    }


    // This is custom function, which is not present in BaseDao, and it will return number of bookings per locations
    // query_unique -> returns only 1 result if multiple are present
    //For some reason, it just returns false. I don't know why, but perhaps ALIASES are problem.
     function getNumberOfBookingsPerLocation($location_id)
    {
        return $this->query_unique("SELECT COUNT(b.id) AS number_of_bookings_per_location
        FROM bookings b
        JOIN locations l ON b.location_id = l.id
        WHERE l.id = :l.id", ["id" => $location_id]); 
    }

    //This is a custom function to get contact info from certain location
    function getContactInfo($id)  
    {
        return $this->query_unique("SELECT email, phone
        FROM locations
        WHERE id = :id", ["id" => $id]);
    }



}

?>
