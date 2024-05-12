<?php
require_once __DIR__ . '/BaseDao.class.php';


class EmployeeDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct("employees");  
        //name of the table in DB is written with lower-case letter, so I wrote it like that in every class
    }


    // custom function, which is not present in BaseDao to get a name and last name of the employee based on its id and location_id
    // query_unique -> returns only 1 result if multiple are present
    function getEmployeeByIdAndLocationId($employee_id, $location_id)
    {
        return $this->query_unique("SELECT employee_name, employee_surname
        FROM employees
        WHERE employee_id = :employee_id AND location_id = :location_id", ["employee_id" => $employee_id, "location_id" => $location_id]);
    }
    
}
?>
