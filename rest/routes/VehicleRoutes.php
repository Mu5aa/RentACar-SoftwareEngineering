<?php
//works
//get information about all vehicles
Flight::route('GET /vehicles', function () {
    Flight::json(Flight::vehicleService()->get_all());
});

/*works, however here when I get a randomly generated primary key, 
this one is way bigger than autoincrementation, and this happens only with this class*/
Flight::route('POST /vehicles', function () {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::vehicleService()->add($data));
});

//works
Flight::route('GET /vehicles/year/@year', function ($year) {
    Flight::json(Flight::vehicleService()->getCarsProducedInCertainYear($year));
});

//works
Flight::route('DELETE /vehicles/@vehicle_id', function ($vehicle_id) {
    Flight::vehicleService()->delete($vehicle_id);
});

//works
Flight::route('GET /vehicles/@vehicle_id', function ($vehicle_id) {
    Flight::json(Flight::vehicleService()->get_by_id($vehicle_id));
});

//works
Flight::route("PUT /vehicles/@vehicle_id", function($vehicle_id){
    $data = Flight::request()->data->getData();
    Flight::json(['message' => 'Vehicle info edited succesfully', 'data' => Flight::vehicleService()->update($data, $vehicle_id)]); 
    //-> converts the results to the JSON form
    //This array we could have created above, store it in a variable, and then call that variable or do it directly like this
});

?>
