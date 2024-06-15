
var carData;
var usersData;

function getCars() {
  $.get("http://localhost/RentACar-SoftwareEngineering/backend/api/cars", function (data) {
    carData = data;
    console.log(carData);
    displayCars(carData);
  });
}

function getUsers() {
  $.get("http://localhost/RentACar-SoftwareEngineering/backend/api/users", function (data) {
    usersData = data;
    displayUsers(usersData);
  });
}
