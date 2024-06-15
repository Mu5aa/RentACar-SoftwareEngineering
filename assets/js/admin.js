var token = localStorage.getItem("user");
if (token){
    $(document).ready(function () {
        function addCar(data) {
            $.ajax({
                url: "http://localhost/RentACar-SoftwareEngineering/backend/api/cars",
                type: "POST",
                contentType: "application/json",
                data: JSON.stringify(data),
                success: function (response) {
                    console.log(response);
                    alert("Car added successfully!");
                },
                error: function (error) {
                    console.error('Failed to add car:', error.statusText);
                    alert("Failed to add car. Please try again later.");
                }
            });
        }
      
        $('#add-car').click(function () {
            var name = $('#name').val();
            var manufacturer = $('#manufacturer').val();
            var price = $('#price').val();
            var description = $('#description').val();
            var mileage = $('#mileage').val();
            var transmission = $('#transmission').val();
            var seats = $('#seats').val();
            var luggage = $('#luggage').val();
            var fuel = $('#fuel').val();
      
            var carData = {
                manufacturer: manufacturer,
                name: name,
                price: price,
                description: description,
                mileage: mileage,
                transmission: transmission,
                seats: seats,
                luggage: luggage,
                fuel: fuel
            };
      
            addCar(carData);
            $('#add-car').modal('hide');
        });
      
        function deleteCar(carId) {
            $.ajax({
                url: "http://localhost/RentACar-SoftwareEngineering/backend/api/cars/" + carId,
                type: "DELETE",
                success: function (response) {
                    console.log(response);
                    alert("Car deleted successfully!");
                },
                error: function (error) {
                    console.error('Failed to delete car:', error.statusText);
                    alert("Failed to delete car. Please try again later.");
                }
            });
        }
      
        $('#deleteCarModal').on('click', '.btn-danger', function () {
            var carId = $('#carIdToDelete').val();
            deleteCar(carId);
            $('#deleteCarModal').modal('hide');
        });
      
        function updateCar(carId, updatedCarData) {
          console.log(updatedCarData);
            $.ajax({
                url: "http://localhost/RentACar-SoftwareEngineering/backend/api/cars/" + carId,
                type: "PUT",
                contentType: "application/json",
                data: JSON.stringify(updatedCarData),
                success: function (response) {
                    console.log(response);
                    alert("Car updated successfully!");
                },
                error: function (error) {
                    console.error('Failed to update car:', error.statusText);
                    alert("Failed to update car. Please try again later.");
                }
            });
        }
      
        $('#updateCarModal').on('click', '.btn-primary', function () {
            var carId = $('#updateCarId').val();
            var data = {
                name: $('#name').val(),
                manufacturer: $('#manufacturer').val(),
                price: $('#price').val(),
                description: $('#description').val(),
                mileage: $('#mileage').val(),
                transmission: $('#transmission').val(),
                seats: $('#seats').val(),
                luggage: $('#luggage').val(),
                fuel: $('#fuel').val()
            };
            console.log(data);
            updateCar(carId, data);
            $('#updateCarModal').modal('hide');
        });
      
        function addLocation(data) {
            $.ajax({
                url: "http://localhost/RentACar-SoftwareEngineering/backend/api/locations",
                type: "POST",
                contentType: "application/json",
                data: JSON.stringify(data),
                success: function (response) {
                    console.log(response);
                    alert("Location added successfully!");
                },
                error: function (error) {
                    console.error('Failed to add location:', error.statusText);
                    alert("Failed to add location. Please try again later.");
                }
            });
        }
      
        $('#addLocationModal').on('click', '#add-location', function () {
            console.log("Add Location button clicked!");
            var name_point = $('#name_point').val();
            var address = $('#address').val();
            var town = $('#town').val();
            var email = $('#email').val();
            var phone = $('#phone').val();
            var date_available = $('#date_available').val();
      
            var locationData = {
                name_point: name_point,
                address: address,
                town: town,
                email: email,
                phone: phone,
                date_available: date_available
            };
      
            addLocation(locationData);
            $('#addLocationModal').modal('hide');
        });
      
        function deleteLocation(locationId) {
          $.ajax({
              url: "http://localhost/RentACar-SoftwareEngineering/backend/api/locations/" + locationId,
              type: "DELETE",
              success: function (response) {
                  console.log(response);
                  alert("Location deleted successfully!");
              },
              error: function (error) {
                  console.error('Failed to delete location:', error.statusText);
                  alert("Failed to delete location. Please try again later.");
              }
          });
      }
      
          $('#deleteLocationModal').on('click', '.btn-danger', function () {
          var locationId = $('#locationIdToDelete').val();
          deleteLocation(locationId);
          $('#deleteLocationModal').modal('hide');
          });
      
          function updateLocation(locationId, updatedLocationData) {
              $.ajax({
                  url: "http://localhost/RentACar-SoftwareEngineering/backend/api/locations/" + locationId,
                  type: "PUT",
                  contentType: "application/json",
                  data: JSON.stringify(updatedLocationData),
                  success: function (response) {
                      console.log(response);
                      alert("Location updated successfully!");
                  },
                  error: function (error) {
                      console.error('Failed to update location:', error.statusText);
                      alert("Failed to update location. Please try again later.");
                  }
              });
          }
      
          $('#updateLocationModal').on('click', '.btn-primary', function () {
              var locationId = $('#updateLocationId').val();
              var data = {
                  name_point: $('#name_point').val(),
                  address: $('#address').val(),
                  town: $('#town').val(),
                  email: $('#email').val(),
                  phone: $('#phone').val(),
                  date_available: $('#date_available').val()
              };
              updateLocation(locationId, data);
              $('#updateLocationModal').modal('hide');
          });
      
      
      $('#getAllUsersModal').click(function () {
          $.ajax({
              url: "http://localhost/RentACar-SoftwareEngineering/backend/api/users",
              type: "GET",
              headers: {
                Authorization: `Bearer ${localStorage.getItem("token")}`,
              },
              success: function (users) {
                  $('#userList').empty();
                  users.forEach(function(user) {
                      var userHtml = '<div class="user">';
                      userHtml += '<p><strong>ID:</strong> ' + user.id + '</p>';
                      userHtml += '<p><strong>Email:</strong> ' + user.email + '</p>';
                      userHtml += '<p><strong>Name:</strong> ' + user.first_name + '</p>';
                      userHtml += '<p><strong>Surname:</strong> ' + user.last_name + '</p>';
                      userHtml += '</div>';
                      userHtml += '<hr>';
                      $('#userList').append(userHtml);
                  });
                  // Show the modal
                  $('#getAllUsersModal').modal('show');
              },
              error: function (error) {
                  console.error('Failed to fetch users:', error.statusText);
                  alert("Failed to fetch users. Please try again later.");
              }
          });
      });
      
      function addUser(data) {
          $.ajax({
              url: "http://localhost/RentACar-SoftwareEngineering/backend/api/users",
              type: "POST",
              contentType: "application/json",
              data: JSON.stringify(data),
              success: function (response) {
                  console.log(response);
                  alert("User added successfully!");
              },
              error: function (error) {
                  console.error('Failed to add user:', error.statusText);
                  alert("Failed to add user. Please try again later.");
              }
          });
      }
      
      $('#add-user').click(function () {
          var first_name = $('#first_name').val();
          var last_name = $('#last_name').val();
          var email = $('#email').val();
          var pwd = $('#pwd').val();
          console.log(email); // Add this line to check if the email value is captured correctly
      
      
          var userData = {
              first_name: first_name,
              last_name: last_name,
              email: email,
              pwd: pwd
          };
      
          console.log(userData); // Add this line to check if the userData object contains the correct values
      
      
          addUser(userData);
          $('#add-user').modal('hide');
      });
      
      
          function deleteUser(userId) {
              $.ajax({
                  url: "http://localhost/RentACar-SoftwareEngineering/backend/api/users/" + userId,
                  type: "DELETE",
                  success: function (response) {
                      console.log(response);
                      alert("User deleted successfully!");
                  },
                  error: function (error) {
                      console.error('Failed to delete user:', error.statusText);
                      alert("Failed to delete user. Please try again later.");
                  }
              });
          }
          
          $('#deleteUserModal').on('click', '.btn-danger', function () {
              var userId = $('#userIdToDelete').val();
              deleteUser(userId);
              $('#deleteUserModal').modal('hide');
          });
      
      
          $('#getAllBookingsModal').click(function () {
            var token = localStorage.getItem("token");
            console.log("Token from localStorage:", token);
            $.ajax({
                url: "http://localhost/RentACar-SoftwareEngineering/backend/api/bookings",
                type: "GET",
                headers: {
                    Authorization: "Bearer " + token,
                },
                success: function (bookings) {
                    $('#bookingList').empty();
                    if (bookings.length === 0) {
                        $('#bookingList').html('<p>No bookings found.</p>');
                    } else {
                        bookings.forEach(function(booking) {
                            var bookingHtml = '<div class="booking">';
                            bookingHtml += '<p><strong>Booking ID:</strong> ' + booking.id + '</p>';
                            bookingHtml += '<p><strong>User ID:</strong> ' + booking.user_id + '</p>';
                            bookingHtml += '<p><strong>Car ID:</strong> ' + booking.car_id + '</p>';
                            bookingHtml += '<p><strong>Pick up Location:</strong> ' + booking.pickup_location + '</p>';
                            bookingHtml += '<p><strong>Drop off Location:</strong> ' + booking.dropoff_location + '</p>';
                            bookingHtml += '<p><strong>Pick up Date:</strong> ' + booking.pickup_date + '</p>';
                            bookingHtml += '<p><strong>Drop off Date:</strong> ' + booking.dropoff_date + '</p>';
                            bookingHtml += '<p><strong>Card holder name:</strong> ' + booking.card_holder_name + '</p>';
                            bookingHtml += '<p><strong>Card number:</strong> ' + booking.card_number + '</p>';
                            bookingHtml += '<p><strong>Exp. date:</strong> ' + booking.exp_date + '</p>';
                            bookingHtml += '<p><strong>CCV:</strong> ' + booking.ccv + '</p>';
                            bookingHtml += '<p><strong>Zip code:</strong> ' + booking.zip_code + '</p>';
                            bookingHtml += '</div>';
                            bookingHtml += '<hr>';
                            $('#bookingList').append(bookingHtml);
                        });
                    }
                    $('#getAllBookingsModal').modal('show');
                },
                error: function (error) {
                    console.error('Failed to fetch bookings:', error.statusText);
                    alert("Failed to fetch bookings. Please try again later.");
                }
            });
        });
        
      
      });
      
}