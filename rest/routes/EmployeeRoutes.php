<?php
//works
//get all employees from database
Flight::route('GET /employees', function () {
    Flight::json(Flight::employeeService()->get_all());
});

//works
//get all information regarding one employee based upon its id as a parameter
Flight::route('GET /employees/@employee_id', function ($employee_id) {
    Flight::json(Flight::employeeService()->get_by_id($employee_id));
});

//works
//add a new employee to the database
Flight::route('POST /employees', function () {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::employeeService()->add($data));
});

// works
//get information regarding one employee based upon its id and location id as parameters
Flight::route('GET /employees/@employee_id/@location_id', function ($employee_id, $location_id) {
    Flight::json(Flight::employeeService()->getEmployeeByIdAndLocationId($employee_id, $location_id));
});

//works
//update current customer based upon its id as a parameter
Flight::route("PUT /employees/@employee_id", function($employee_id){
    $data = Flight::request()->data->getData();
    Flight::json(['message' => 'Employee edited succesfully', 'data' => Flight::employeeService()->update($data, $employee_id)]); 
    //-> converts the results to the JSON form
    //This array we could have created above, store it in a variable, and then call that variable or do it directly like this
});

//works
//delete a current customer based upon its id as a parameter
Flight::route('DELETE /employees/@employee_id', function ($employee_id) {
    Flight::employeeService()->delete($employee_id);
});



?>
