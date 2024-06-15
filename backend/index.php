<?php

require 'vendor/autoload.php';

// import and register all business logic files (services) to FlightPHP
require_once __DIR__ . '/rest/services/UserService.class.php';
require_once __DIR__ . '/rest/services/BookingService.class.php';
require_once __DIR__ . '/rest/services/LocationService.class.php';
require_once __DIR__ . '/rest/services/ReviewService.class.php';
require_once __DIR__ . '/rest/services/CarService.class.php';
require_once __DIR__ . '/rest/services/AuthService.class.php';


Flight::register('userService', "UserService");
Flight::register('bookingService', "BookingService");
Flight::register('locationService', "LocationService");
Flight::register('reviewService', "ReviewService");
Flight::register('carService', "CarService");
Flight::register('authService', "AuthService");


// import all routes
require_once __DIR__ . '/rest/routes/UserRoutes.php';
require_once __DIR__ . '/rest/routes/BookingRoutes.php';
require_once __DIR__ . '/rest/routes/LocationRoutes.php';
require_once __DIR__ . '/rest/routes/ReviewRoutes.php';
require_once __DIR__ . '/rest/routes/CarRoutes.php';
require_once __DIR__ . '/rest/routes/AuthRoutes.php';
require_once __DIR__ . '/rest/routes/MiddlewareRoutes.php';


// it is still possible to add custom routes after the imports
Flight::route('GET /api/', function () {
    echo "Hello";
});

Flight::start();
