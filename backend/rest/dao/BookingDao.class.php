<?php
require_once __DIR__ . '/BaseDao.class.php';


class BookingDao extends BaseDao{

    public function __construct(){
        parent::__construct("bookings");  
    }

    public function get_all_bookings(){
        try {
            $query = "SELECT * FROM bookings";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            throw new \Exception("Error retrieving bookings: " . $e->getMessage());
        }
    }

    public function add_booking($booking) {
        return $this->add('bookings', $booking);
    }
    
    function getPaidBookingsPerLocation($location_id)
    {
        return $this->query("SELECT *
        FROM bookings
        WHERE paid = 1 AND location_id = :location_id", [ "location_id" => $location_id]);
    } 

    function getUnpaidBookingsPerLocation($location_id)
    {
        return $this->query("SELECT *
        FROM bookings
        WHERE paid = 0 AND location_id = :location_id", [ "location_id" => $location_id]);
    } 

    public function get_booking_by_id($booking_id){
        $query = "SELECT * FROM bookings WHERE id = :id";
        $params = ['id' => $booking_id];
    
        // Check if the booking exists
        $countQuery = "SELECT COUNT(*) AS count FROM bookings WHERE id = :id";
        $count = $this->query_unique($countQuery, $params);
    
        if ($count['count'] > 0) {
            // Booking exists, fetch the details
            return $this->query_unique($query, $params);
        } else {
            // Booking does not exist
            return null;
        }
    }
    
}
