<?php
//works
//get all information about all locations
Flight::route('GET /locations', function () {
    Flight::json(Flight::locationService()->get_all());
});

//works
//add a new location
Flight::route('POST /locations', function () {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::locationService()->add($data));
});

//does not work
//get number of bookings per location
Flight::route('GET /locations/bookings/@location_id', function ($location_id) {
    Flight::json(Flight::locationService()->getNumberOfBookingsPerLocation($location_id));
});

//does not work
/*get contact of a rental based on a location_id, however I wrote here id because the name in the DB table is id, and I thought perhaps
that was creating the issue*/
Flight::route('GET /locations/contact/@id', function ($id) {
    Flight::json(Flight::locationService()->getContactInfo($id));
});

//works
Flight::route('DELETE /locations/@location_id', function ($location_id) {
    Flight::locationService()->delete($location_id);
});

//works
Flight::route('GET /locations/@location_id', function ($location_id) {
    Flight::json(Flight::locationService()->get_by_id($location_id));
});

//works
Flight::route("PUT /locations/@location_id", function($location_id){
    $data = Flight::request()->data->getData();
    Flight::json(['message' => 'Location edited succesfully', 'data' => Flight::locationService()->update($data, $location_id)]); 
    //-> converts the results to the JSON form
    //This array we could have created above, store it in a variable, and then call that variable or do it directly like this
});

?>
