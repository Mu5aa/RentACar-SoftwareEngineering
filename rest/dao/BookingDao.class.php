<?php
require_once __DIR__ . '/BaseDao.class.php';


class BookingDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct("bookings");  
        //name of the table in DB is written with lower-case letter, so I wrote it like that in every class
    }


    // custom function, which is not present in BaseDao, which will show all paid bookings per a location
    // query_unique will return only 1 result if multiple are present, but query will return all
    function getPaidBookingsPerLocation($location_id)
    {
        return $this->query("SELECT *
        FROM bookings
        WHERE paid = 1 AND location_id = :location_id", [ "location_id" => $location_id]);
    } 

    //custom function, which will show all unpaid bookings per a location
    function getUnpaidBookingsPerLocation($location_id)
    {
        return $this->query("SELECT *
        FROM bookings
        WHERE paid = 0 AND location_id = :location_id", [ "location_id" => $location_id]);
    } 

    
}
    
    

?>
