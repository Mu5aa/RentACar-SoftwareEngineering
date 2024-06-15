<?php
require_once __DIR__ . "/BaseService.class.php";
require_once __DIR__ . "/../dao/BookingDao.class.php";

class BookingService extends BaseService{

    public $booking_dao;

    public function __construct(){
        parent::__construct(new BookingDao);
        $this->booking_dao = $this->dao;
    }

    public function get_all_bookings(){
        return $this->booking_dao->get_all_bookings();
    }

    public function add_booking($booking_data) {
        // Perform necessary validation of the booking data here
        
        return $this->booking_dao->add($booking_data);
    }
    
    function getPaidBookingsPerLocation($location_id)
    {
        return $this->dao->getPaidBookingsPerLocation($location_id);
    }

    function getUnpaidBookingsPerLocation($location_id)
    {
        return $this->dao->getUnpaidBookingsPerLocation($location_id);
    }

    public function get_booking_by_id($booking_id) {
        return $this->dao->get_booking_by_id($booking_id);
    }
    
}
