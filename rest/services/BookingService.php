<?php
require_once 'BaseService.php';
require_once __DIR__ . "/../dao/BookingDao.class.php";


class BookingService extends BaseService
{
    public function __construct()
    {
        parent::__construct(new BookingDao);
    }


    function getPaidBookingsPerLocation($location_id)
    {
        return $this->dao->getPaidBookingsPerLocation($location_id);
    }

    function getUnpaidBookingsPerLocation($location_id)
    {
        return $this->dao->getUnpaidBookingsPerLocation($location_id);
    }
    
}
?>
