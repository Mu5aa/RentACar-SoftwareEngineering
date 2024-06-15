<?php

require_once __DIR__ . '/../services/CarService.class.php';

Flight::set('car_service', new CarService());
//get information about all cars

/**
     * @OA\Get(
     *      path="/api/cars",
     *      tags={"cars"},
     *      summary="Get all cars",
     *      security={
     *          {"ApiKey": {}}   
     *      },
     *      @OA\Response(
     *           response=200,
     *           description="Array of all cars in the database"
     *      )
     * )
     */
Flight::route('GET /api/cars', function () {
    Flight::json(Flight::carService()->get_all());
});

/**
     * @OA\Post(
     *      path="/api/cars",
     *      tags={"cars"},
     *      summary="Add car data to the database",
     *      @OA\Response(
     *           response=200,
     *           description="Car data, or exception if car is not added properly"
     *      ),
     *      @OA\RequestBody(
     *          description="Car data payload",
     *          @OA\JsonContent(
     *              required={"name","manufacturer","email"},
     *              @OA\Property(property="name", type="string", example="Some car name", description="Car model name"),
     *              @OA\Property(property="manufacturer", type="string", example="Some manufacturer name", description="Car manufacturer name"),
     *              @OA\Property(property="fuel", type="string", example="Diesel", description="Car fuel type"),
     *              @OA\Property(property="transmission", type="string", example="manual", description="Car transmission type")
     *          )
     *      )
     * )
     */

Flight::route('POST /api/cars', function () {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::carService()->add('cars', $data));
});

 /**
     * @OA\Delete(
     *      path="/api/cars/{car_id}",
     *      tags={"cars"},
     *      summary="Delete car by id",
     *      @OA\Response(
     *           response=200,
     *           description="Deleted car data or 500 status code exception otherwise"
     *      ),
     *      @OA\Parameter(@OA\Schema(type="number"), in="path", name="car_id", example="1", description="Car ID")
     * )
     */

Flight::route('DELETE /api/cars/@car_id', function ($car_id) {
    Flight::carService()->delete($car_id);
});

   /**
     * @OA\Get(
     *      path="/cars/{car_id}",
     *      tags={"cars"},
     *      summary="Get car by id",
     *      @OA\Response(
     *           response=200,
     *           description="Car data, or false if car does not exist"
     *      ),
     *      @OA\Parameter(@OA\Schema(type="number"), in="path", name="car_id", example="1", description="Car ID")
     * )
     */

Flight::route('GET /@car_id', function ($car_id) {
    $car = Flight::get('car_service')->get_car_by_id($car_id);
    Flight::json($car, 200);
});
    

Flight::route("PUT /api/cars/@carId", function($carId){
    $car = Flight::request()->data->getData();
    print_r($car);

    // Flight::json(['message' => "Car edited successfully",
    //               'data' => Flight::carService()->update_car($car, $carId)
    //              ]);


 });
