<?php
require_once 'BaseService.php';
require_once __DIR__ . "/../dao/CustomerDao.class.php";


class CustomerService extends BaseService
{
    public function __construct()
    {
        parent::__construct(new CustomerDao);
    }


    function getCustomerByFirstNameAndLastName($customer_name, $customer_surname)
    {
        return $this->dao->getCustomerByFirstNameAndLastName($customer_name, $customer_surname);
    }
}
?>
