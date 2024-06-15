<?php

/**
     * @OA\Get(
     *      path="/api/locations",
     *      tags={"locations"},
     *      summary="Get all locations",
     *      security={
     *          {"ApiKey": {}}   
     *      },
     *      @OA\Response(
     *           response=200,
     *           description="Array of all locations in the database"
     *      )
     * )
     */

Flight::route('GET /api/locations', function () {
    Flight::json(Flight::locationService()->get_all());
});

/**
     * @OA\Post(
     *      path="/api/locations",
     *      tags={"locations"},
     *      summary="Add location data to the database",
     *      @OA\Response(
     *           response=200,
     *           description="Location data, or exception if location is not added properly"
     *      ),
     *      @OA\RequestBody(
     *          description="Location data payload",
     *          @OA\JsonContent(
     *              required={"name_point","address","town", "email", "phone", "date_available"},
     *              @OA\Property(property="name_point", type="string", example="Some location name", description="Location name"),
     *              @OA\Property(property="address", type="string", example="Some address of location", description="Location address"),
     *              @OA\Property(property="town", type="string", example="Some town name", description="Town name"),
     *              @OA\Property(property="email", type="string", example="example@organization.com", description="Email of organization"),
     *              @OA\Property(property="phone", type="string", example="+38761588203", description="Phone of organization"),
     *              @OA\Property(property="date_available", type="string", example="2023-05-10", description="Availability date"),
     *          )
     *      )
     * )
     */


Flight::route('POST /api/locations', function () {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::locationService()->add('locations', $data));
});

  /**
     * @OA\Get(
     *      path="/api/locations/{location_id}",
     *      tags={"locations"},
     *      summary="Get locations by id",
     *      @OA\Response(
     *           response=200,
     *           description="Location data, or false if location does not exist"
     *      ),
     *      @OA\Parameter(@OA\Schema(type="number"), in="query", name="location_id", example="1", description="Location ID")
     * )
     */



     Flight::route('GET /api/locations/@location_id', function ($location_id) {
        Flight::json(Flight::locationService()->getById($location_id));
    });

 /**
     * @OA\Delete(
     *      path="/api/locations/{location_id}",
     *      tags={"locations"},
     *      summary="Delete location by id",
     *      @OA\Response(
     *           response=200,
     *           description="Deleted location data or 500 status code exception otherwise"
     *      ),
     *      @OA\Parameter(@OA\Schema(type="number"), in="path", name="location_id", example="1", description="Location ID")
     * )
     */

Flight::route('DELETE /api/locations/@location_id', function ($location_id) {
    Flight::locationService()->delete($location_id);
});



Flight::route("PUT /api/locations/@location_id", function($location_id){
    $data = Flight::request()->data->getData();
    $data['id'] = $location_id;

    
    try {
        Flight::locationService()->update_location($data); // Only pass data
        $updatedLocation = Flight::locationService()->getById($location_id);
        Flight::json($updatedLocation);
    } catch (Exception $e) {
        // Handle update error
        Flight::halt(500, 'Failed to update location: ' . $e->getMessage());
    }
});


// Flight::route("PUT /api/locations/@location_id", function($location_id){
//     $data = Flight::request()->data->getData();
//     Flight::locationService()->update_($location_id, $data);
//     Flight::json(Flight::locationService()->getById($location_id));
// });
