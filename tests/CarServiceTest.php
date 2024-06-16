<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../backend/rest/services/CarService.class.php';
require_once __DIR__ . '/../backend/rest/dao/CarDao.class.php';

class CarServiceTest extends TestCase {
    private $car_service;
    private $car_dao;

    protected function setUp(): void {
        $this->car_dao = $this->createMock(CarDao::class);
        $this->car_service = new CarService();
        $this->car_service->car_dao = $this->car_dao;
    }

    public function testGetCarById() {
        $car_id = 1;
        $expected_car = [
            'id' => $car_id,
            'name' => 'Test Car',
            'manufacturer' => 'Test Manufacturer',
            'price' => '10000',
            'description' => 'Test description',
            'mileage' => '10000',
            'transmission' => 'manual',
            'seats' => '5',
            'luggage' => '5',
            'fuel' => 'Diesel'
        ];

        $this->car_dao->method('get_car_by_id')->with($car_id)->willReturn($expected_car);

        $actual_car = $this->car_service->get_car_by_id($car_id);

        $this->assertEquals($expected_car, $actual_car);
    }

    public function testAddCar() {
        $car_data = [
            'name' => 'New Car',
            'manufacturer' => 'New Manufacturer',
            'price' => '20000',
            'description' => 'New description',
            'mileage' => '2000',
            'transmission' => 'automatic',
            'seats' => '4',
            'luggage' => '4',
            'fuel' => 'Petrol'
        ];

        $expected_result = $car_data;
        $expected_result['id'] = 1; // Adjusted to match the actual ID

        $this->car_dao->method('add')->with('cars', $car_data)->willReturn($expected_result);

        $result = $this->car_service->add('cars', $car_data);

        $this->assertArrayHasKey('id', $result);
        $this->assertNotNull($result['id']);
        $this->assertEquals($car_data, array_intersect_key($result, $car_data));
    }

    public function testUpdateCar() {
        $car_id = 1;
        $car_data = [
            'name' => 'Updated Car',
            'manufacturer' => 'Updated Manufacturer',
            'price' => '15000',
            'description' => 'Updated description',
            'mileage' => '15000',
            'transmission' => 'manual',
            'seats' => '5',
            'luggage' => '5',
            'fuel' => 'Electric'
        ];

        $this->car_dao->expects($this->once())->method('update_car')->with($car_id, $car_data);

        $this->car_service->update_car($car_data, $car_id);
    }
}
