<?php


require '../vendor/autoload.php';

// Import and register all business logic files (services) to FlightPHP
require_once __DIR__ . '/services/CustomerService.php';
require_once __DIR__ . '/services/BookingService.php';
require_once __DIR__ . '/services/EmployeeService.php';
require_once __DIR__ . '/services/LocationService.php';
require_once __DIR__ . '/services/ReviewService.php';
require_once __DIR__ . '/services/VehicleService.php';

Flight::register('customerService', "CustomerService");
Flight::register('bookingService', "BookingService");
Flight::register('employeeService', "EmployeeService");
Flight::register('locationService', "LocationService");
Flight::register('reviewService', "ReviewService");
Flight::register('vehicleService', "VehicleService");

// Import all routes
require_once __DIR__ . '/routes/CustomerRoutes.php';
require_once __DIR__ . '/routes/BookingRoutes.php';
require_once __DIR__ . '/routes/EmployeeRoutes.php';
require_once __DIR__ . '/routes/LocationRoutes.php';
require_once __DIR__ . '/routes/ReviewRoutes.php';
require_once __DIR__ . '/routes/VehicleRoutes.php';

// It is still possible to add custom routes after the imports
Flight::route('GET /', function () {
    echo "Hello";
});

Flight::start();

?>
