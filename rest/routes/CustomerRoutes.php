<?php
//works
//get all customers from database
Flight::route('GET /customers', function () {
    Flight::json(Flight::customerService()->get_all());
});

//works
//get all information regarding one customer based upon its id as a parameter
Flight::route('GET /customers/@customer_id', function ($customer_id) {
    Flight::json(Flight::customerService()->get_by_id($customer_id));
});

//does not work
//get all information regarding one customer based upon its name and surname as parameters
Flight::route('GET /customers/@customer_name/@customer_surname', function ($customer_name, $customer_surname) {
    Flight::json(Flight::customerService()->getCustomerByFirstNameAndLastName($customer_name, $customer_surname));
});

//works
//add a new customer to the database
Flight::route('POST /customers', function () {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::customerService()->add($data));
});

//works
//update an existing customer based upon its id as a parameter
Flight::route("PUT /customers/@customer_id", function($customer_id){
    $data = Flight::request()->data->getData();
    Flight::json(['message' => 'Customer edited succesfully', 'data' => Flight::customerService()->update($data, $customer_id)]); 
    //-> converts the results to the JSON form
    //This array we could have created above, store it in a variable, and then call that variable or do it directly like this
});


//works
//delete one customer based upon its id as a parameter
Flight::route('DELETE /customers/@customer_id', function ($customer_id) {
    Flight::customerService()->delete($customer_id);
});


?>
