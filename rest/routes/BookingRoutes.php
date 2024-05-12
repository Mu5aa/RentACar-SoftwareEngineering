<?php
//works
//get all bookings from database
Flight::route('GET /bookings', function () {
    Flight::json(Flight::bookingService()->get_all());
}); 

//works
//add a new booking
Flight::route('POST /bookings', function () {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::bookingService()->add($data));
});

//works, and returns all correct solutions and not just the first one
//get all paid bookings based on a location
Flight::route('GET /bookings/paid/@location_id', function ($location_id) {
    Flight::json(Flight::bookingService()->getPaidBookingsPerLocation($location_id));
});

//works,and returns all correct solutions and not just the first one
//get all unpaid bookings based on a location
Flight::route('GET /bookings/unpaid/@location_id', function ($location_id) {
    Flight::json(Flight::bookingService()->getUnpaidBookingsPerLocation($location_id));
});

//works
//delete all information regarding one booking based upon its id
Flight::route('DELETE /bookings/@booking_id', function ($booking_id) {
    Flight::bookingService()->delete($booking_id);
});

//works
//get all regarding one booking based on its id as parameter
Flight::route('GET /bookings/@booking_id', function ($booking_id) {
    Flight::json(Flight::bookingService()->get_by_id($booking_id));
});

//works
//update an existing booking
Flight::route("PUT /bookings/@booking_id", function($booking_id){
    $data = Flight::request()->data->getData();
    Flight::json(['message' => 'Booking edited succesfully', 'data' => Flight::bookingService()->update($data, $booking_id)]); 
    //-> converts the results to the JSON form
    //This array we could have created above, store it in a variable, and then call that variable or do it directly like this
});

?>
